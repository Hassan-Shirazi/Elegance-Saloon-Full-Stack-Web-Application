<?php
include "config.php"; // database connection file

$success = "";
$error = "";

// Form submit handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = mysqli_real_escape_string($conn, $_POST['fullName']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $shift = mysqli_real_escape_string($conn, $_POST['shift']);

    // Validation
    if (strlen($fullName) < 2) {
        $error = "Full name must be at least 2 characters.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    } elseif (!preg_match('/^[0-9]{10,15}$/', $phone)) {
        $error = "Invalid phone number.";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters.";
    } elseif (empty($shift)) {
        $error = "Please select a preferred shift.";
    } else {
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert into DB
        $sql = "INSERT INTO receptionists (full_name, email, phone, address, password, shift) 
                VALUES ('$fullName', '$email', '$phone', '$address', '$hashedPassword', '$shift')";

        if (mysqli_query($conn, $sql)) {
            $success = "Receptionist added successfully!";
            echo "<script>alert('Receptionist added successfully!');</script>";
        } else {
            $error = "Error: " . mysqli_error($conn);
            echo "<script>alert('Error while adding receptionist!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Receptionist</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/rec.css">
</head>
<body>

<?php include "side.php"; ?> 

<div class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Add New Receptionist</h1>
            <div class="breadcrumb">
                <a href="#">Dashboard</a> / <a href="#">Receptionists</a> / Add New
            </div>
        </div>
    </div>

    <div class="form-container">
        <div class="form-header">
            <h2 class="form-title">Receptionist Information</h2>
            <p class="form-subtitle">Please fill in all the required details for the new receptionist</p>
        </div>

        <?php if ($success): ?>
            <div class="success-message">
                <i class="fas fa-check-circle"></i> <?= $success ?>
            </div>
        <?php elseif ($error): ?>
            <div class="error-message" style="display:block; color:red;">
                <i class="fas fa-times-circle"></i> <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-content">
                <div class="form-section">
                    <div class="form-group">
                        <label for="fullName" class="form-label">Full Name *</label>
                        <input type="text" name="fullName" id="fullName" class="form-input" placeholder="Enter full name" required>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email Address *</label>
                        <input type="email" name="email" id="email" class="form-input" placeholder="Enter email address" required>
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">Phone Number *</label>
                        <input type="tel" name="phone" id="phone" class="form-input" placeholder="Enter phone number" required>
                    </div>

                    <div class="form-group">
                        <label for="address" class="form-label">Address</label>
                        <textarea name="address" id="address" class="form-input" placeholder="Enter full address" rows="3"></textarea>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-group">
                        <label for="password" class="form-label">Password *</label>
                        <input type="password" name="password" id="password" class="form-input" placeholder="Create a password" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Preferred Shift *</label>
                        <div class="shift-options">
                            <label class="shift-option">
                                <input type="radio" name="shift" value="morning"> Morning (8AM-4PM)
                            </label>
                            <label class="shift-option">
                                <input type="radio" name="shift" value="afternoon"> Afternoon (12PM-8PM)
                            </label>
                            <label class="shift-option">
                                <input type="radio" name="shift" value="evening"> Evening (4PM-12AM)
                            </label>
                            <label class="shift-option">
                                <input type="radio" name="shift" value="full"> Full Day (9AM-6PM)
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-footer">
              
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Add Receptionist
                </button>
            </div>
        </form>
    </div>
</div>
<script src = "js.rec.js"></script>
</body>
</html>
