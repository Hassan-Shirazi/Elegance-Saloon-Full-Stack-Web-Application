<?php
include "config.php";

// Handle delete action
if (isset($_GET['delete_id']) && isset($_GET['type'])) {
    $delete_id = $_GET['delete_id'];
    $type = $_GET['type'];
    
    switch($type) {
        case 'appointment':
            $sql = "DELETE FROM appointments WHERE id = ?";
            break;
        case 'stylist':
            $sql = "DELETE FROM stylists WHERE id = ?";
            break;
        case 'receptionist':
            $sql = "DELETE FROM receptionists WHERE id = ?";
            break;
        case 'payment':
            $sql = "DELETE FROM payments WHERE id = ?";
            break;
        default:
            $sql = "";
    }
    
    if ($sql) {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $delete_id);
        if ($stmt->execute()) {
            echo "<script>alert('Record deleted successfully'); window.location.href = window.location.pathname;</script>";
        } else {
            echo "<script>alert('Error deleting record');</script>";
        }
    }
}

// Summary Counts
$totalAppointments = $conn->query("SELECT COUNT(*) AS total FROM appointments")->fetch_assoc()['total'];
$totalStylists = $conn->query("SELECT COUNT(*) AS total FROM stylists")->fetch_assoc()['total'];
$totalReceptionists = $conn->query("SELECT COUNT(*) AS total FROM receptionists")->fetch_assoc()['total'];
$activeClients = $conn->query("SELECT COUNT(DISTINCT client_name) AS total FROM payments")->fetch_assoc()['total'];

// Detailed Reports Data
$appointments = $conn->query("SELECT id, appointment_date FROM appointments ORDER BY appointment_date DESC");
$stylists = $conn->query("SELECT id, full_name FROM stylists ORDER BY id DESC");
$receptionists = $conn->query("SELECT id, full_name FROM receptionists ORDER BY id DESC");
$payments = $conn->query("SELECT id, payment_date FROM payments ORDER BY payment_date DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports & Analytics - Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="css/report.css">
</head>
<body>
<?php include "side.php"; ?>

<main class="main-content">
    <div class="page-header">
        <h1 class="page-title">Reports & Analytics</h1>
    </div>

    <!-- Summary Cards -->
    <div class="summary-cards">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Total Appointments</div>
                <div class="card-icon" style="background-color: var(--primary);">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
            <div class="card-value"><?= $totalAppointments ?></div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title">Total Stylists</div>
                <div class="card-icon" style="background-color: var(--success);">
                    <i class="fas fa-scissors"></i>
                </div>
            </div>
            <div class="card-value"><?= $totalStylists ?></div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title">Total Receptionists</div>
                <div class="card-icon" style="background-color: var(--info);">
                    <i class="fas fa-user-tie"></i>
                </div>
            </div>
            <div class="card-value"><?= $totalReceptionists ?></div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title">Total Payment</div>
                <div class="card-icon" style="background-color: var(--warning);">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="card-value"><?= $activeClients ?></div>
        </div>
    </div>

    <!-- Detailed Reports -->
    <div class="reports-section">
        <div class="section-header">
            <h2 class="section-title">Detailed Reports</h2>
            <div class="table-controls">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search reports...">
                </div>
            </div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Report ID</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Appointments -->
                    <?php while($row = $appointments->fetch_assoc()): ?>
                        <tr>
                            <td>#APT-<?= $row['id'] ?></td>
                            <td><?= $row['appointment_date'] ?></td>
                            <td>Appointment</td>
                            <td>
                                <button class="delete-btn" onclick="deleteRecord(<?= $row['id'] ?>, 'appointment')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>

                    <!-- Stylists -->
                    <?php while($row = $stylists->fetch_assoc()): ?>
                        <tr>
                            <td>#STY-<?= $row['id'] ?></td>
                            <td>--</td>
                            <td>Stylist (<?= htmlspecialchars($row['full_name']) ?>)</td>
                            <td>
                                <button class="delete-btn" onclick="deleteRecord(<?= $row['id'] ?>, 'stylist')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>

                    <!-- Receptionists -->
                    <?php while($row = $receptionists->fetch_assoc()): ?>
                        <tr>
                            <td>#REC-<?= $row['id'] ?></td>
                            <td>--</td>
                            <td>Receptionist (<?= htmlspecialchars($row['full_name']) ?>)</td>
                            <td>
                                <button class="delete-btn" onclick="deleteRecord(<?= $row['id'] ?>, 'receptionist')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>

                    <!-- Payments -->
                    <?php while($row = $payments->fetch_assoc()): ?>
                        <tr>
                            <td>#PAY-<?= $row['id'] ?></td>
                            <td><?= $row['payment_date'] ?></td>
                            <td>Payment</td>
                            <td>
                                <button class="delete-btn" onclick="deleteRecord(<?= $row['id'] ?>, 'payment')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script src = "js/report.js">

</script>
</body>
</html>