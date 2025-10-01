<?php
session_start();
// Database configuration
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "elegence"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to utf8
$conn->set_charset("utf8");

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email_phone = trim($_POST['email_phone']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (empty($email_phone) || empty($password) || empty($role)) {
        $error = "All fields are required!";
    } else {
        switch($role) {
            case 'admin':
                $table = "admin";
                $redirect = "/php/admin/report.php";
                break;
            case 'stylist':
                $table = "stylists";
                $redirect = "/php/stylist/report.php";
                break;
            case 'receptionist':
                $table = "receptionists";
                $redirect = "/php/recpet/report.php";
                break;
            default:
                $error = "Invalid role selected!";
                break;
        }

        if (!$error) {
            // Check if input is email or phone
            if (filter_var($email_phone, FILTER_VALIDATE_EMAIL)) {
                $query = "SELECT * FROM $table WHERE email = ?";
            } else {
                $query = "SELECT * FROM $table WHERE no = ?";
            }

            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $email_phone);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();
                
                // Verify password based on role and password storage method
                if ($role == 'admin') {
                    // For admin - check both hashed and plain text passwords
                    if (isset($user['password'])) {
                        // If password is hashed
                        if (password_verify($password, $user['password'])) {
                            loginSuccess($user, $role, $redirect);
                        } 
                        // If password is stored in plain text (temporary solution)
                        else if ($password === $user['password']) {
                            loginSuccess($user, $role, $redirect);
                        } else {
                            $error = "Invalid password for admin!";
                        }
                    } else {
                        $error = "Password field not found in admin table!";
                    }
                } else {
                    // For stylist and receptionist - use password_verify
                    if (password_verify($password, $user['password'])) {
                        loginSuccess($user, $role, $redirect);
                    } else {
                        $error = "Invalid password!";
                    }
                }
            } else {
                $error = "User not found!";
            }
            $stmt->close();
        }
    }
}

function loginSuccess($user, $role, $redirect) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $role;
    $_SESSION['email'] = $user['email'];
    
    if ($role == 'admin') {
        $_SESSION['name'] = 'Admin';
    } else {
        $_SESSION['name'] = $user['full_name'];
    }
    
    header("Location: $redirect");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Elegance Salon</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
          font-family:robo;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 420px;
            padding: 40px;
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo h1 {
            color: #2c3e50;
            font-size: 28px;
            font-weight: 600;
        }

        .logo p {
            color: #7f8c8d;
            margin-top: 5px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 500;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ecf0f1;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s;
            background: #f8f9fa;
        }

        .form-control:focus {
            outline: none;
            border-color: #3498db;
            background: white;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .select-wrapper {
            position: relative;
        }

        .select-wrapper::after {
            content: '▼';
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #7f8c8d;
            pointer-events: none;
        }

        select.form-control {
            appearance: none;
            cursor: pointer;
        }

        .btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #34495e, #2c3e50);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .error-message {
            background: #e74c3c;
            color: white;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
        }

        .success-message {
            background: #27ae60;
            color: white;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
        }

        .forgot-password {
            text-align: center;
            margin-top: 20px;
        }

        .forgot-password a {
            color: #3498db;
            text-decoration: none;
            font-size: 14px;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .debug-info {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
            font-size: 12px;
            color: #6c757d;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
                margin: 10px;
            }

            .logo h1 {
                font-size: 24px;
            }

            .btn {
                padding: 12px;
                font-size: 15px;
            }
        }

        @media (max-width: 360px) {
            .login-container {
                padding: 20px 15px;
            }

            .logo h1 {
                font-size: 22px;
            }
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-container {
            animation: fadeIn 0.6s ease-out;
        }

        /* Loading state */
        .btn.loading {
            position: relative;
            color: transparent;
        }

        .btn.loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <h1 style = "font-family:robo;">Elegance Salon</h1>
            <!-- <p>Login in to your account</p> -->
             <br>
            <p>admin email : admin123@gmail.com</p>
            <p>admin password : admin123456</p>
        </div>

        <?php if ($error): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (isset($_GET['logout']) && $_GET['logout'] == 'success'): ?>
            <div class="success-message">You have been logged out successfully!</div>
        <?php endif; ?>

        <form method="POST" action="" id="loginForm">
            <div class="form-group">
                <label for="email_phone" class="form-label">Email or Phone Number</label>
                <input type="text" id="email_phone" name="email_phone" class="form-control" 
                       placeholder="Enter your email or phone number" 
                       value="<?php echo isset($_POST['email_phone']) ? htmlspecialchars($_POST['email_phone']) : ''; ?>" 
                       required>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" 
                       placeholder="Enter your password" required>
            </div>

            <div class="form-group">
                <label for="role" class="form-label">Role</label>
                <div class="select-wrapper">
                    <select id="role" name="role" class="form-control" required>
                        <option value="">Select your role</option>
                        <option value="admin" <?php echo (isset($_POST['role']) && $_POST['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                        <option value="stylist" <?php echo (isset($_POST['role']) && $_POST['role'] == 'stylist') ? 'selected' : ''; ?>>Stylist</option>
                        <option value="receptionist" <?php echo (isset($_POST['role']) && $_POST['role'] == 'receptionist') ? 'selected' : ''; ?>>Receptionist</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" id="loginBtn">
               Login
            </button>
        </form>

      

        <?php if (isset($_GET['debug'])): ?>
        <div class="debug-info">
            <strong>Debug Info:</strong><br>
            Admin Table Columns: 
            <?php
            $result = $conn->query("SHOW COLUMNS FROM admin");
            $columns = [];
            while($row = $result->fetch_assoc()) {
                $columns[] = $row['Field'];
            }
            echo implode(', ', $columns);
            ?>
        </div>
        <?php endif; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('loginForm');
            const loginBtn = document.getElementById('loginBtn');

            loginForm.addEventListener('submit', function(e) {
                // Basic validation
                const emailPhone = document.getElementById('email_phone').value.trim();
                const password = document.getElementById('password').value;
                const role = document.getElementById('role').value;

                if (!emailPhone || !password || !role) {
                    e.preventDefault();
                    alert('Please fill in all fields!');
                    return false;
                }

                // Show loading state
                loginBtn.classList.add('loading');
                loginBtn.disabled = true;
            });

            // Remove loading state if form submission fails
            window.addEventListener('pageshow', function() {
                loginBtn.classList.remove('loading');
                loginBtn.disabled = false;
            });

            // Add input validation
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    if (this.value.trim() !== '') {
                        this.style.borderColor = '#27ae60';
                    } else {
                        this.style.borderColor = '#ecf0f1';
                    }
                });
            });
        });
    </script>
</body>
</html>