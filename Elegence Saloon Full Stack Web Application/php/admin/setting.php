<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "elegence");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$message = "";
$error = "";

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update account information
    if (isset($_POST['update_account'])) {
        $adminName = $_POST['adminName'];
        $adminEmail = $_POST['adminEmail'];
        $adminPhone = $_POST['adminPhone'];
        
        // Check if admin exists, if not insert, else update
        $checkAdmin = $conn->query("SELECT * FROM admin LIMIT 1");
        
        if ($checkAdmin->num_rows > 0) {
            // Update existing admin
            $stmt = $conn->prepare("UPDATE admin SET email = ?, no = ? WHERE id = 1");
            $stmt->bind_param("ss", $adminEmail, $adminPhone);
        } else {
            // Insert new admin (you might want to handle password differently)
            $defaultPassword = password_hash("admin123", PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO admin (id, email, no, password) VALUES (1, ?, ?, ?)");
            $stmt->bind_param("sss", $adminEmail, $adminPhone, $defaultPassword);
        }
        
        if ($stmt->execute()) {
            $message = "Account information updated successfully!";
        } else {
            $error = "Error updating account information: " . $conn->error;
        }
        $stmt->close();
    }
    
    // Change password
    if (isset($_POST['change_password'])) {
        $currentPassword = $_POST['currentPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];
        
        // Validate passwords
        if ($newPassword !== $confirmPassword) {
            $error = "New passwords do not match!";
        } elseif (strlen($newPassword) < 6) {
            $error = "Password must be at least 6 characters long!";
        } else {
            // Get current admin password
            $result = $conn->query("SELECT password FROM admin WHERE id = 1");
            if ($result->num_rows > 0) {
                $admin = $result->fetch_assoc();
                
                // Verify current password (you might need to adjust this based on your password storage)
                if (password_verify($currentPassword, $admin['password'])) {
                    // Update password
                    $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("UPDATE admin SET password = ? WHERE id = 1");
                    $stmt->bind_param("s", $newPasswordHash);
                    
                    if ($stmt->execute()) {
                        $message = "Password updated successfully!";
                    } else {
                        $error = "Error updating password: " . $conn->error;
                    }
                    $stmt->close();
                } else {
                    $error = "Current password is incorrect!";
                }
            } else {
                $error = "Admin account not found!";
            }
        }
    }
    
    // Update preferences
    if (isset($_POST['update_preferences'])) {
        $notifications = isset($_POST['notifications']) ? 1 : 0;
        // You can add more preference fields here
        
        $message = "Preferences updated successfully!";
    }
}

// Get current admin data
$adminData = array(
    'email' => '',
    'no' => ''
);

$result = $conn->query("SELECT * FROM admin WHERE id = 1");
if ($result->num_rows > 0) {
    $adminData = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - AdminPanel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/setting.css">
    
</head>
<body>
    
   <?php include "side.php"; ?> 

    <main class="main-content" id="mainContent">
        <div class="page-header">
            <h1 class="page-title">Settings</h1>
        </div>
        
        <!-- Display messages -->
        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <!-- Account Settings Section -->
        <section class="settings-section">
            <div class="section-header">
                <h2 class="section-title">Account Settings</h2>
            </div>
            <div class="section-content">
                <form method="POST" action="">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="adminName" class="form-label">Admin Name</label>
                            <input type="text" id="adminName" name="adminName" class="form-control" value="Administrator" readonly>
                        </div>
                        <div class="form-group">
                            <label for="adminEmail" class="form-label">Email</label>
                            <input type="email" id="adminEmail" name="adminEmail" class="form-control" value="<?php echo htmlspecialchars($adminData['email']); ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="adminPhone" class="form-label">Phone</label>
                        <input type="tel" id="adminPhone" name="adminPhone" class="form-control" value="<?php echo htmlspecialchars($adminData['no']); ?>" required>
                    </div>
                    <button type="submit" name="update_account" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </section>
        
        <!-- Change Password Section -->
        <section class="settings-section">
            <div class="section-header">
                <h2 class="section-title">Change Password</h2>
            </div>
            <div class="section-content">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="currentPassword" class="form-label">Current Password</label>
                        <input type="password" id="currentPassword" name="currentPassword" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" id="newPassword" name="newPassword" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword" class="form-label">Confirm New Password</label>
                        <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" required>
                    </div>
                    <button type="submit" name="change_password" class="btn btn-primary">Update Password</button>
                </form>
            </div>
        </section>
        
        <!-- Preferences Section -->
        <section class="settings-section">
            <div class="section-header">
                <h2 class="section-title">Preferences</h2>
            </div>
            <div class="section-content">
                <form method="POST" action="">
                    <div class="toggle-group">
                        <div>
                            <div class="toggle-label">Enable Notifications</div>
                            <div class="toggle-description">Receive notifications for important updates</div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" id="notificationsToggle" name="notifications" value="1" checked>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                    <button type="submit" name="update_preferences" class="btn btn-primary">Save Preferences</button>
                </form>
            </div>
        </section>
    </main>

    <script src = "js/setting.js">
    
    </script>
</body>
</html>