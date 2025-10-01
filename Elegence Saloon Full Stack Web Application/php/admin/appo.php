<?php
include "config.php";

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clientName = trim($_POST['clientName']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $date = trim($_POST['date']);
    $timeSlot = trim($_POST['timeSlot']);

    if (empty($clientName) || strlen($clientName) < 2) {
        $error = "Please enter a valid client name.";
    } elseif (empty($phone) || !preg_match("/^[0-9]{10,15}$/", $phone)) {
        $error = "Please enter a valid phone number.";
    } elseif (empty($date)) {
        $error = "Please select an appointment date.";
    } elseif (empty($timeSlot)) {
        $error = "Please select a time slot.";
    } else {
        $sql = "INSERT INTO appointments (client_name, phone, email, appointment_date, time_slot) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $clientName, $phone, $email, $date, $timeSlot);

        if ($stmt->execute()) {
            $success = "Appointment booked successfully!";
        } else {
            $error = "Error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/appo.css">
</head>
<body>

<?php include "side.php"; ?>

<div class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Book New Appointment</h1>
            <div class="breadcrumb">
                <a href="#">Dashboard</a> / <a href="#">Appointments</a> / Book New
            </div>
        </div>
    </div>

    <div class="form-container">
        <div class="form-header">
            <h2 class="form-title">Appointment Details</h2>
            <p class="form-subtitle">Please fill in all the required details to book an appointment</p>
        </div>

        <?php if ($success): ?>
            <div class="success-message" style="display:block; color:green;">
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
                        <label for="clientName" class="form-label">Client Name *</label>
                        <input type="text" name="clientName" id="clientName" class="form-input" placeholder="Enter client name" required>
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">Phone Number *</label>
                        <input type="tel" name="phone" id="phone" class="form-input" placeholder="Enter phone number" required>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" name="email" id="email" class="form-input" placeholder="Enter email address">
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-group">
                        <label for="date" class="form-label">Appointment Date *</label>
                        <div class="input-with-icon">
                            <input type="date" name="date" id="date" class="form-input" required>
                            <i class="fas fa-calendar-alt calendar-icon"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Time Slot *</label>
                        <select name="timeSlot" id="timeSlot" class="form-input" required>
                            <option value="">-- Select Time Slot --</option>
                            <option value="09:00 AM - 10:00 AM">09:00 AM - 10:00 AM</option>
                            <option value="10:00 AM - 11:00 AM">10:00 AM - 11:00 AM</option>
                            <option value="11:00 AM - 12:00 PM">11:00 AM - 12:00 PM</option>
                            <option value="12:00 PM - 01:00 PM">12:00 PM - 01:00 PM</option>
                            <option value="02:00 PM - 03:00 PM">02:00 PM - 03:00 PM</option>
                            <option value="03:00 PM - 04:00 PM">03:00 PM - 04:00 PM</option>
                            <option value="04:00 PM - 05:00 PM">04:00 PM - 05:00 PM</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-calendar-check"></i> Book Appointment
                </button>
            </div>
        </form>
    </div>
</div>
<script src = "js/appo.js"></script>
</body>
</html>
