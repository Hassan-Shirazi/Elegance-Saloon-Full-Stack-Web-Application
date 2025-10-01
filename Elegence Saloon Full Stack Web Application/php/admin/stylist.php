<?php
 include "config.php";


$success = "";
$error = "";

// Form submit handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = mysqli_real_escape_string($conn, $_POST['fullName']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $specialty = mysqli_real_escape_string($conn, $_POST['specialty']);
    $experience = (int) $_POST['experience'];

    // Validation
    if (strlen($fullName) < 2) {
        $error = "Full name must be at least 2 characters.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    } elseif (!preg_match('/^[0-9]{10,15}$/', $phone)) {
        $error = "Invalid phone number.";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters.";
    } else {
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert into DB
        $sql = "INSERT INTO stylists (full_name, email, phone, password, specialty, experience) 
                VALUES ('$fullName', '$email', '$phone', '$hashedPassword', '$specialty', '$experience')";

        if (mysqli_query($conn, $sql)) {
                $success = "Stylist added successfully!";
    echo "<script>alert('Stylist added successfully!');</script>";
        } else {
              $error = "Error: " . mysqli_error($conn);
    echo "<script>alert('Error while adding stylist!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Stylist</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <link rel="stylesheet" href="css/stylist.css">
</head>
<body>

<?php include "side.php"; ?>

<div class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Add New Stylist</h1>
            <div class="breadcrumb">
                <a href="#">Dashboard</a> / <a href="#">Stylists</a> / Add New
            </div>
        </div>
    </div>

    <div class="form-container">
        <div class="form-header">
            <h2 class="form-title">Stylist Information</h2>
            <p class="form-subtitle">Please fill in all the required details for the new stylist</p>
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
                </div>

                <div class="form-section">
                    <div class="form-group">
                        <label for="password" class="form-label">Password *</label>
                        <input type="password" name="password" id="password" class="form-input" placeholder="Create a password" required>
                    </div>

                    <div class="form-group">
                        <label for="specialty" class="form-label">Specialty</label>
                        <select name="specialty" id="specialty" class="form-input">
                            <option value="">Select a specialty</option>
                            <option value="hair">Hair Styling</option>
                            <option value="makeup">Makeup Artistry</option>
                            <option value="nails">Nail Technician</option>
                            <option value="skincare">Skincare Specialist</option>
                            <option value="barber">Barber</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="experience" class="form-label">Years of Experience</label>
                        <input type="number" name="experience" id="experience" class="form-input" placeholder="Enter years of experience" min="0" max="50">
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Add Stylist
                </button>
            </div>
        </form>
    </div>
</div>
<script src = "js/stylist.js"></script>
</body>
</html>
