<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stylist Dashboard Overview</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --white: #ffffff;
            --gray-light: #f8f9fa;
            --gray-medium: #e9ecef;
            --gray-dark: #6c757d;
            --black: #212529;
            --blue: #007bff;
            --blue-light: #e3f2fd;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--gray-light);
            color: var(--black);
            line-height: 1.6;
        }
        
        .dashboard-container {
        width: 100%;
            margin: 0 auto;
            padding: 20px;
        }
        
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--gray-medium);
        }
        
        .dashboard-header h1 {
            color: var(--black);
            font-weight: 600;
        }
        
     
    
        
        .stats-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }
        
        .stat-card {
            background-color: var(--white);
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            font-size: 1.5rem;
            color: var(--white);
        }
        
        .appointments .stat-icon {
            background-color: #28a745;
        }
        
        .shifts .stat-icon {
            background-color: #ffc107;
        }
        
        .messages .stat-icon {
            background-color: #17a2b8;
        }
        
        .notifications .stat-icon {
            background-color: #dc3545;
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: var(--gray-dark);
            font-size: 0.9rem;
            margin-bottom: 15px;
        }
        
        .table-container {
            background-color: var(--white);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }
        
        .table-header {
            background-color: var(--blue);
            color: white;
            padding: 15px 20px;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 15px 20px;
            text-align: left;
            border-bottom: 1px solid var(--gray-medium);
        }
        
        th {
            background-color: var(--blue-light);
            font-weight: 600;
        }
        
        tr:last-child td {
            border-bottom: none;
        }
        
        tr:hover {
            background-color: var(--gray-light);
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-upcoming {
            background-color: #e3f2fd;
            color: #1976d2;
        }
        
        .status-completed {
            background-color: #e8f5e9;
            color: #388e3c;
        }
        
        .status-pending {
            background-color: #fff3e0;
            color: #f57c00;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        
        .delete-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.8rem;
            transition: background-color 0.3s ease;
        }
        
        .delete-btn:hover {
            background-color: #c82333;
        }
        
        .message-preview {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        /* Responsive Design */
        @media (max-width: 992px) {
            .stats-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 576px) {
            .stats-container {
                grid-template-columns: 1fr;
            }
            
            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            th, td {
                padding: 10px 15px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .message-preview {
                max-width: 100px;
            }
        }
    </style>
</head>
<body>
    <?php  include "side.php"; ?>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Stylist Dashboard Overview</h1>
            <div class="user-info">
              
                    <?php
                    // Database connection
                    $servername = "localhost";
                    $username = "root"; // Replace with your DB username
                    $password = ""; // Replace with your DB password
                    $dbname = "elegence";
                    
                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    
                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    
                    // Get stylist data
                    $sql = "SELECT full_name, specialty FROM stylists WHERE id = 13";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $stylist = $result->fetch_assoc();
                        $stylistName = $stylist['full_name'];
                        $stylistSpecialty = $stylist['specialty'];
                        
                        // Get initials for avatar
                        $nameParts = explode(' ', $stylistName);
                        $stylistInitials = '';
                        foreach ($nameParts as $part) {
                            $stylistInitials .= strtoupper(substr($part, 0, 1));
                        }
                        echo $stylistInitials;
                    } else {
                       
                    }
                    ?>
              
               
            </div>
        </div>
        
        <div class="stats-container">
            <div class="stat-card appointments">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-value">
                    <?php
                    // Get total appointments count
                    $sql = "SELECT COUNT(*) as total FROM appointments";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $totalAppointments = $row['total'];
                    echo $totalAppointments;
                    ?>
                </div>
                <div class="stat-label">Total Appointments</div>
            </div>
            
            <div class="stat-card shifts">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-value">
                    <?php
                    // Get upcoming shifts count
                    $sql = "SELECT COUNT(*) as total FROM shifts WHERE status = 'Scheduled'";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $upcomingShifts = $row['total'];
                    echo $upcomingShifts;
                    ?>
                </div>
                <div class="stat-label">Upcoming Shifts</div>
            </div>
            
            <div class="stat-card messages">
                <div class="stat-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="stat-value">
                    <?php
                    // Get new messages count
                    $sql = "SELECT COUNT(*) as total FROM contact_form";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $newMessages = $row['total'];
                    echo $newMessages;
                    ?>
                </div>
                <div class="stat-label">New Client Messages</div>
            </div>
            
            <div class="stat-card notifications">
                <div class="stat-icon">
                    <i class="fas fa-bell"></i>
                </div>
                <div class="stat-value">
                    <?php
                    // Get notifications count
                    $sql = "SELECT COUNT(*) as total FROM notifications WHERE status = 'unread'";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $notifications = $row['total'];
                    echo $notifications;
                    ?>
                </div>
                <div class="stat-label">Notifications & Reminders</div>
            </div>
        </div>
        
        <div class="table-container">
            <div class="table-header">
                <span>Recent Appointments & Reminders</span>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Client Name</th>
                        <th>Service/Type</th>
                        <th>Date & Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Handle delete request for appointments and reminders
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id']) && isset($_POST['delete_table'])) {
                        $delete_id = $_POST['delete_id'];
                        $delete_table = $_POST['delete_table'];
                        
                        // Validate table name to prevent SQL injection
                        $allowed_tables = ['appointments', 'reminders', 'contact_form'];
                        if (in_array($delete_table, $allowed_tables)) {
                            $delete_sql = "DELETE FROM $delete_table WHERE id = ?";
                            $stmt = $conn->prepare($delete_sql);
                            $stmt->bind_param("i", $delete_id);
                            $stmt->execute();
                            $stmt->close();
                            
                            // Refresh the page to show updated data
                            echo "<script>window.location.href = window.location.href.split('?')[0];</script>";
                        }
                    }
                    
                    // Get appointments and reminders data from database
                    $sql = "
                    SELECT 
                        client_name, 
                        'Appointment' as type,
                        CONCAT(appointment_date, ' ', time_slot) as datetime,
                        'upcoming' as status,
                        'appointments' as source_table,
                        id
                    FROM appointments
                    UNION ALL
                    SELECT 
                        client_name, 
                        service as type,
                        CONCAT(date, ' ', time) as datetime,
                        status,
                        'reminders' as source_table,
                        id
                    FROM reminders
                    ORDER BY datetime DESC
                    LIMIT 10
                    ";
                    
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['client_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['type']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['datetime']) . "</td>";
                            echo "<td><span class='status-badge status-" . $row['status'] . "'>" . ucfirst($row['status']) . "</span></td>";
                            echo "<td class='action-buttons'>";
                            echo "<form method='POST' style='display: inline;' onsubmit='return confirmDelete()'>";
                            echo "<input type='hidden' name='delete_id' value='" . $row['id'] . "'>";
                            echo "<input type='hidden' name='delete_table' value='" . $row['source_table'] . "'>";
                            echo "<button type='submit' class='delete-btn'>Delete</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No appointments or reminders found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        
        <div class="table-container">
            <div class="table-header">
                <span>Client Messages</span>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message Preview</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Get contact form messages
                    $sql = "SELECT id, name, email, subject, message, created_at FROM contact_form ORDER BY created_at DESC LIMIT 10";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['subject']) . "</td>";
                            echo "<td class='message-preview' title='" . htmlspecialchars($row['message']) . "'>" . htmlspecialchars($row['message']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                            echo "<td class='action-buttons'>";
                            echo "<form method='POST' style='display: inline;' onsubmit='return confirmDelete()'>";
                            echo "<input type='hidden' name='delete_id' value='" . $row['id'] . "'>";
                            echo "<input type='hidden' name='delete_table' value='contact_form'>";
                            echo "<button type='submit' class='delete-btn'>Delete</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No client messages found</td></tr>";
                    }
                    
                    // Close connection
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this record?");
        }
    </script>
</body>
</html>