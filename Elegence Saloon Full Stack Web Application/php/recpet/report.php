<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Overview - Elegence Salon</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --white: #ffffff;
            --light-gray: #f8f9fa;
            --medium-gray: #e9ecef;
            --dark-gray: #6c757d;
            --black: #212529;
            --blue: #007bff;
            --green: #28a745;
            --orange: #fd7e14;
            --purple: #6f42c1;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--light-gray);
            color: var(--black);
            line-height: 1.6;
        }
        
        .dashboard-container {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--medium-gray);
        }
        
        h1 {
            font-size: 32px;
            font-weight: 600;
            color: var(--black);
        }
        
        .welcome-text {
            color: var(--dark-gray);
            font-size: 16px;
            margin-top: 5px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }
        
        .stat-card {
            background: var(--white);
            padding: 30px 25px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border-left: 5px solid;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
        
        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: var(--white);
        }
        
        .stat-info {
            text-align: right;
        }
        
        .stat-number {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 14px;
            color: var(--dark-gray);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .stat-card.appointments {
            border-left-color: var(--blue);
        }
        
        .stat-card.appointments .stat-icon {
            background: linear-gradient(135deg, var(--blue), #0056b3);
        }
        
        .stat-card.notifications {
            border-left-color: var(--orange);
        }
        
        .stat-card.notifications .stat-icon {
            background: linear-gradient(135deg, var(--orange), #e55a00);
        }
        
        .stat-card.payments {
            border-left-color: var(--green);
        }
        
        .stat-card.payments .stat-icon {
            background: linear-gradient(135deg, var(--green), #1e7e34);
        }
        
        .stat-card.inventory {
            border-left-color: var(--purple);
        }
        
        .stat-card.inventory .stat-icon {
            background: linear-gradient(135deg, var(--purple), #59359c);
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        
        @media (max-width: 1200px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .dashboard-container {
                padding: 15px;
            }
            
            h1 {
                font-size: 28px;
            }
        }
        
        .module {
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        
        .module-header {
            background-color: var(--white);
            padding: 20px 25px;
            border-bottom: 1px solid var(--medium-gray);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .module-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--black);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .module-title i {
            color: var(--dark-gray);
        }
        
        .module-content {
            padding: 0;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .data-table th {
            background-color: var(--light-gray);
            padding: 15px 20px;
            text-align: left;
            font-weight: 600;
            color: var(--black);
            border-bottom: 1px solid var(--medium-gray);
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .data-table td {
            padding: 15px 20px;
            border-bottom: 1px solid var(--medium-gray);
            color: var(--black);
        }
        
        .data-table tr:last-child td {
            border-bottom: none;
        }
        
        .data-table tr:hover {
            background-color: var(--light-gray);
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-confirmed {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        
        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-paid {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-unpaid {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
            font-size: 14px;
        }
        
        .btn-primary {
            background-color: var(--blue);
            color: var(--white);
        }
        
        .btn-primary:hover {
            background-color: #0056b3;
        }
        
        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--medium-gray);
            color: var(--dark-gray);
        }
        
        .btn-outline:hover {
            background-color: var(--light-gray);
        }
        
        .btn-danger {
            background-color: #dc3545;
            color: white;
        }
        
        .btn-danger:hover {
            background-color: #c82333;
        }
        
        .empty-state {
            padding: 50px 20px;
            text-align: center;
            color: var(--dark-gray);
        }
        
        .empty-state i {
            font-size: 48px;
            margin-bottom: 15px;
            color: var(--medium-gray);
        }
        
        .empty-state p {
            margin-top: 10px;
            font-size: 16px;
        }
        
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        
        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-success {
            color: var(--green);
        }
        
        .text-danger {
            color: #dc3545;
        }
        
        .text-warning {
            color: var(--orange);
        }
    </style>
</head>
<body>
    <?php include "side.php"; ?>
    <?php 
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "elegence";
    
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    // Handle delete actions
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['delete_appointment'])) {
            $id = intval($_POST['appointment_id']);
            $sql = "DELETE FROM appointments WHERE id = $id";
            mysqli_query($conn, $sql);
        }
        
        if (isset($_POST['delete_notification'])) {
            $id = intval($_POST['notification_id']);
            $sql = "DELETE FROM notifications WHERE id = $id";
            mysqli_query($conn, $sql);
        }
        
        if (isset($_POST['delete_payment'])) {
            $id = intval($_POST['payment_id']);
            $sql = "DELETE FROM payments WHERE id = $id";
            mysqli_query($conn, $sql);
        }
        
        if (isset($_POST['delete_inventory'])) {
            $id = intval($_POST['inventory_id']);
            $sql = "DELETE FROM inventory WHERE id = $id";
            mysqli_query($conn, $sql);
        }
    }
    
    // Fetch statistics
    $appointments_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM appointments"))['count'];
    $notifications_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM notifications WHERE status = 'unread'"))['count'];
    $payments_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM payments"))['count'];
    $inventory_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM inventory"))['count'];
    
    // Fetch recent data
    $appointments = mysqli_query($conn, "SELECT * FROM appointments ORDER BY appointment_date DESC LIMIT 5");
    $notifications = mysqli_query($conn, "SELECT * FROM notifications ORDER BY created_at DESC LIMIT 5");
    $payments = mysqli_query($conn, "SELECT * FROM payments ORDER BY payment_date DESC LIMIT 5");
    $inventory = mysqli_query($conn, "SELECT * FROM inventory ORDER BY id DESC LIMIT 5");
    ?>
    
    <div class="dashboard-container">
        <header>
            <div>
                <h1>Dashboard Overview</h1>
                <div class="welcome-text">Welcome to Elegence Salon Management System</div>
            </div>
        </header>
        
        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card appointments">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number"><?php echo $appointments_count; ?></div>
                        <div class="stat-label">Total Appointments</div>
                    </div>
                </div>
            </div>
            
            <div class="stat-card notifications">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number"><?php echo $notifications_count; ?></div>
                        <div class="stat-label">Unread Notifications</div>
                    </div>
                </div>
            </div>
            
            <div class="stat-card payments">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number"><?php echo $payments_count; ?></div>
                        <div class="stat-label">Total Payments</div>
                    </div>
                </div>
            </div>
            
            <div class="stat-card inventory">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number"><?php echo $inventory_count; ?></div>
                        <div class="stat-label">Inventory Items</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="dashboard-grid">
            <!-- Appointments Table -->
            <div class="module">
                <div class="module-header">
                    <h2 class="module-title">
                        <i class="fas fa-calendar-alt"></i>
                        Recent Appointments
                    </h2>
                </div>
                <div class="module-content">
                    <?php if (mysqli_num_rows($appointments) > 0): ?>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Client</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Phone</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($appointments)): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['client_name']); ?></td>
                                    <td><?php echo date('M j, Y', strtotime($row['appointment_date'])); ?></td>
                                    <td><?php echo htmlspecialchars($row['time_slot']); ?></td>
                                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                    <td>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="appointment_id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" name="delete_appointment" class="btn btn-danger btn-sm" onclick="return confirm('Delete this appointment?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-calendar-times"></i>
                            <p>No appointments found</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Notifications Table -->
            <div class="module">
                <div class="module-header">
                    <h2 class="module-title">
                        <i class="fas fa-bell"></i>
                        Recent Notifications
                    </h2>
                </div>
                <div class="module-content">
                    <?php if (mysqli_num_rows($notifications) > 0): ?>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Message</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($notifications)): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['message']); ?></td>
                                    <td>
                                        <span class="status-badge <?php echo $row['type'] == 'appointment' ? 'status-confirmed' : 'status-pending'; ?>">
                                            <?php echo ucfirst($row['type']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge <?php echo $row['status'] == 'unread' ? 'status-pending' : 'status-completed'; ?>">
                                            <?php echo ucfirst($row['status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('M j, Y', strtotime($row['created_at'])); ?></td>
                                    <td>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="notification_id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" name="delete_notification" class="btn btn-danger btn-sm" onclick="return confirm('Delete this notification?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-bell-slash"></i>
                            <p>No notifications found</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Payments Table -->
            <div class="module">
                <div class="module-header">
                    <h2 class="module-title">
                        <i class="fas fa-credit-card"></i>
                        Recent Payments
                    </h2>
                </div>
                <div class="module-content">
                    <?php if (mysqli_num_rows($payments) > 0): ?>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Client</th>
                                    <th>Service</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($payments)): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['client_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['service']); ?></td>
                                    <td class="text-success">$<?php echo number_format($row['amount'], 2); ?></td>
                                    <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
                                    <td>
                                        <span class="status-badge <?php echo $row['status'] == 'Paid' ? 'status-paid' : 'status-unpaid'; ?>">
                                            <?php echo $row['status']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="payment_id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" name="delete_payment" class="btn btn-danger btn-sm" onclick="return confirm('Delete this payment record?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-receipt"></i>
                            <p>No payments found</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Inventory Table -->
            <div class="module">
                <div class="module-header">
                    <h2 class="module-title">
                        <i class="fas fa-boxes"></i>
                        Inventory Items
                    </h2>
                </div>
                <div class="module-content">
                    <?php if (mysqli_num_rows($inventory) > 0): ?>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Category</th>
                                    <th>Quantity</th>
                                    <th>Cost</th>
                                    <th>Supplier</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($inventory)): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['category']); ?></td>
                                    <td>
                                        <span class="<?php echo $row['quantity'] < 10 ? 'text-danger' : 'text-success'; ?>">
                                            <?php echo $row['quantity']; ?>
                                        </span>
                                    </td>
                                    <td>$<?php echo number_format($row['cost'], 2); ?></td>
                                    <td><?php echo htmlspecialchars($row['supplier']); ?></td>
                                    <td>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="inventory_id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" name="delete_inventory" class="btn btn-danger btn-sm" onclick="return confirm('Delete this inventory item?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-box-open"></i>
                            <p>No inventory items found</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto refresh every 60 seconds
        setInterval(function() {
            window.location.reload();
        }, 60000);
    </script>
</body>
</html>
<?php
// Close database connection
mysqli_close($conn);
?>