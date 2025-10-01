<?php
include "config.php";

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        
        if ($action === 'add') {
            // Add new payment
            $client_name = mysqli_real_escape_string($conn, $_POST['client_name']);
            $service = mysqli_real_escape_string($conn, $_POST['service']);
            $amount = floatval($_POST['amount']);
            $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
            $status = mysqli_real_escape_string($conn, $_POST['status']);
            $payment_date = mysqli_real_escape_string($conn, $_POST['payment_date']);
            
            $sql = "INSERT INTO payments (client_name, service, amount, payment_method, status, payment_date) 
                    VALUES ('$client_name', '$service', $amount, '$payment_method', '$status', '$payment_date')";
            
            if (mysqli_query($conn, $sql)) {
                $message = "Payment added successfully!";
            } else {
                $error = "Error adding payment: " . mysqli_error($conn);
            }
        }
        elseif ($action === 'edit') {
            // Update payment
            $id = intval($_POST['id']);
            $client_name = mysqli_real_escape_string($conn, $_POST['client_name']);
            $service = mysqli_real_escape_string($conn, $_POST['service']);
            $amount = floatval($_POST['amount']);
            $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
            $status = mysqli_real_escape_string($conn, $_POST['status']);
            $payment_date = mysqli_real_escape_string($conn, $_POST['payment_date']);
            
            $sql = "UPDATE payments SET 
                    client_name = '$client_name', 
                    service = '$service', 
                    amount = $amount, 
                    payment_method = '$payment_method', 
                    status = '$status', 
                    payment_date = '$payment_date' 
                    WHERE id = $id";
            
            if (mysqli_query($conn, $sql)) {
                $message = "Payment updated successfully!";
            } else {
                $error = "Error updating payment: " . mysqli_error($conn);
            }
        }
        elseif ($action === 'delete') {
            // Delete payment
            $id = intval($_POST['id']);
            
            $sql = "DELETE FROM payments WHERE id = $id";
            
            if (mysqli_query($conn, $sql)) {
                $message = "Payment deleted successfully!";
            } else {
                $error = "Error deleting payment: " . mysqli_error($conn);
            }
        }
    }
}

// Fetch all payments
$sql = "SELECT * FROM payments ORDER BY payment_date DESC";
$result = mysqli_query($conn, $sql);
$payments = [];
if ($result) {
    $payments = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <link rel="stylesheet" href="css/pay.css">
</head>
<body>
    <?php include "side.php"; ?>
    <div class="container">
        <header>
            <h1>Payments Management</h1>
            <button class="btn-primary" onclick="openModal()">
                <i class="fas fa-plus"></i> Record New Payment
            </button>
        </header>

        <?php if (isset($message)): ?>
            <div class="message success"><?php echo $message; ?></div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th>Client Name</th>
                        <th>Service</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($payments)): ?>
                        <tr>
                            <td colspan="8" style="text-align: center;">No payments found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($payments as $payment): ?>
                            <tr>
                                <td>#<?php echo $payment['id']; ?></td>
                                <td><?php echo htmlspecialchars($payment['client_name']); ?></td>
                                <td><?php echo htmlspecialchars($payment['service']); ?></td>
                                <td>$<?php echo number_format($payment['amount'], 2); ?></td>
                                <td><?php echo $payment['payment_date']; ?></td>
                                <td><?php echo $payment['payment_method']; ?></td>
                                <td>
                                    <span class="status <?php echo $payment['status'] === 'Paid' ? 'status-paid' : 'status-pending'; ?>">
                                        <?php echo $payment['status']; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="actions">
                                     
                                        <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this payment?')">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?php echo $payment['id']; ?>">
                                            <button type="submit" class="action-btn delete-btn">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for adding/editing payments -->
    <div class="modal" id="paymentModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Record New Payment</h2>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST" id="paymentForm">
                    <input type="hidden" name="action" id="formAction" value="add">
                    <input type="hidden" name="id" id="paymentId">
                    
                    <div class="form-group">
                        <label for="client_name">Client Name</label>
                        <input type="text" id="client_name" name="client_name" required>
                    </div>
                    <div class="form-group">
                        <label for="service">Service</label>
                        <input type="text" id="service" name="service" required>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount ($)</label>
                        <input type="number" id="amount" name="amount" step="0.01" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="payment_method">Payment Method</label>
                        <select id="payment_method" name="payment_method" required>
                            <option value="">Select Method</option>
                            <option value="Cash">Cash</option>
                            <option value="Card">Card</option>
                            <option value="Online">Online</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" required>
                            <option value="">Select Status</option>
                            <option value="Paid">Paid</option>
                            <option value="Pending">Pending</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="payment_date">Payment Date</label>
                        <input type="date" id="payment_date" name="payment_date" required>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn-secondary" onclick="closeModal()">Cancel</button>
                        <button type="submit" class="btn-dark">Save Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src = "js/pay.js">
       
    </script>
</body>
</html>