<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "elegence";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if there are any stylists in the database
$stylist_check = $conn->query("SELECT id FROM stylists LIMIT 1");
if ($stylist_check->num_rows == 0) {
    // Insert a default stylist if none exists
    $conn->query("INSERT INTO stylists (full_name, email, phone, password, specialty, experience) 
                  VALUES ('Default Stylist', 'stylist@example.com', '000-000-0000', 'password', 'Hair Styling', 5)");
}

// Get all stylists for dropdown
$stylists_result = $conn->query("SELECT id, full_name FROM stylists");
$stylists = [];
while ($row = $stylists_result->fetch_assoc()) {
    $stylists[$row['id']] = $row['full_name'];
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_shift'])) {
        // Add new shift
        $stylist_id = $_POST['stylist_id'];
        $date = $_POST['date'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $status = $_POST['status'];
        
        $sql = "INSERT INTO shifts (stylist_id, date, start_time, end_time, status) 
                VALUES ($stylist_id, '$date', '$start_time', '$end_time', '$status')";
        
        if ($conn->query($sql) === TRUE) {
            $message = "Shift added successfully!";
            // Refresh the page to show the new shift
            echo "<script>window.location.href = 'shedule.php?success=1';</script>";
            exit();
        } else {
            $error = "Error adding shift: " . $conn->error;
        }
    } elseif (isset($_POST['edit_shift'])) {
        // Edit shift
        $shift_id = $_POST['shift_id'];
        $stylist_id = $_POST['stylist_id'];
        $date = $_POST['date'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $status = $_POST['status'];
        
        $sql = "UPDATE shifts SET 
                stylist_id = $stylist_id, 
                date = '$date', 
                start_time = '$start_time', 
                end_time = '$end_time', 
                status = '$status' 
                WHERE id = $shift_id";
        
        if ($conn->query($sql) === TRUE) {
            $message = "Shift updated successfully!";
            // Refresh the page after edit
            echo "<script>window.location.href = 'shedule.php?success=1';</script>";
            exit();
        } else {
            $error = "Error updating shift: " . $conn->error;
        }
    } elseif (isset($_POST['delete_shift'])) {
        // Delete shift
        $shift_id = $_POST['shift_id'];
        $sql = "DELETE FROM shifts WHERE id = $shift_id";
        
        if ($conn->query($sql) === TRUE) {
            $message = "Shift deleted successfully!";
            // Refresh the page after delete
            echo "<script>window.location.href = 'shedule.php?success=1';</script>";
            exit();
        } else {
            $error = "Error deleting shift: " . $conn->error;
        }
    } elseif (isset($_POST['mark_completed'])) {
        // Mark shift as completed
        $shift_id = $_POST['shift_id'];
        $sql = "UPDATE shifts SET status = 'Completed' WHERE id = $shift_id";
        
        if ($conn->query($sql) === TRUE) {
            $message = "Shift marked as completed!";
            // Refresh the page after status change
            echo "<script>window.location.href = 'shedule.php?success=1';</script>";
            exit();
        } else {
            $error = "Error updating shift: " . $conn->error;
        }
    } elseif (isset($_POST['mark_scheduled'])) {
        // Mark shift as scheduled
        $shift_id = $_POST['shift_id'];
        $sql = "UPDATE shifts SET status = 'Scheduled' WHERE id = $shift_id";
        
        if ($conn->query($sql) === TRUE) {
            $message = "Shift marked as scheduled!";
            // Refresh the page after status change
            echo "<script>window.location.href = 'shedule.php?success=1';</script>";
            exit();
        } else {
            $error = "Error updating shift: " . $conn->error;
        }
    }
}

// Check for success message from redirect
if (isset($_GET['success'])) {
    $message = "Operation completed successfully!";
}

// Check if we're in edit mode
$edit_mode = false;
$edit_shift_data = null;
if (isset($_GET['edit'])) {
    $edit_shift_id = $_GET['edit'];
    $edit_result = $conn->query("SELECT * FROM shifts WHERE id = $edit_shift_id");
    if ($edit_result->num_rows > 0) {
        $edit_mode = true;
        $edit_shift_data = $edit_result->fetch_assoc();
    }
}

// Fetch upcoming shifts (next 7 shifts) - FIXED QUERY
$sql = "SELECT s.*, st.full_name as stylist_name 
        FROM shifts s 
        LEFT JOIN stylists st ON s.stylist_id = st.id 
        WHERE s.date >= CURDATE() 
        ORDER BY s.date, s.start_time 
        LIMIT 7";
$result = $conn->query($sql);

// Fetch all shifts for "View All" option
$sql_all = "SELECT s.*, st.full_name as stylist_name 
            FROM shifts s 
            LEFT JOIN stylists st ON s.stylist_id = st.id 
            ORDER BY s.date, s.start_time";
$result_all = $conn->query($sql_all);
$show_all = isset($_GET['view']) && $_GET['view'] == 'all';

// Debug: Check if shifts exist
$debug_sql = "SELECT COUNT(*) as total FROM shifts";
$debug_result = $conn->query($debug_sql);
$debug_row = $debug_result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stylist Schedule Management</title>
    <style>
        :root {
            --primary: #3498db;
            --light-bg: #f8f9fa;
            --dark-text: #2c3e50;
            --gray-border: #e0e0e0;
            --white: #ffffff;
            --success: #27ae60;
            --warning: #f39c12;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--light-bg);
            color: var(--dark-text);
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--gray-border);
        }
        
        h1 {
            color: var(--dark-text);
            margin-bottom: 10px;
        }
        
        .section {
            background-color: var(--white);
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin-bottom: 30px;
        }
        
        h2 {
            color: var(--dark-text);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--gray-border);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }
        
        input, select {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid var(--gray-border);
            border-radius: 4px;
            font-size: 16px;
        }
        
        button {
            background-color: var(--primary);
            color: black;
            border: none;
            padding: 12px 20px;
            border-radius: 25px;
            border: 1px solid #2980b9 ;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s;
        }
        
        button:hover {
            background-color: #2980b9;
        }
        
        .btn-secondary {
            background-color: #95a5a6;
        }
        
        .btn-secondary:hover {
            background-color: #7f8c8d;
        }
        
        .btn-danger {
            background-color: #e74c3c;
        }
        
        .btn-danger:hover {
            background-color: #c0392b;
        }
        
        .btn-success {
            background-color: var(--success);
        }
        
        .btn-success:hover {
            background-color: #219653;
        }
        
        .btn-warning {
            background-color: var(--warning);
        }
        
        .btn-warning:hover {
            background-color: #e67e22;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--gray-border);
        }
        
        th {
            background-color: var(--light-bg);
            font-weight: 600;
        }
        
        .status-scheduled {
            color: var(--warning);
            font-weight: 600;
            background-color: #fef9e7;
            padding: 4px 8px;
            border-radius: 4px;
            display: inline-block;
        }
        
        .status-completed {
            color: var(--success);
            font-weight: 600;
            background-color: #e8f8f1;
            padding: 4px 8px;
            border-radius: 4px;
            display: inline-block;
        }
        
        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .view-all {
            text-align: center;
            margin-top: 20px;
        }
        
        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
        .cancel-btn {
            background-color: #95a5a6;
        }
        
        .cancel-btn:hover {
            background-color: #7f8c8d;
        }
        
        .add-new-btn {
            background-color: var(--success);
            margin-bottom: 20px;
        }
        
        .add-new-btn:hover {
            background-color: #219653;
        }
        
        .debug-info {
            background-color: #e8f4fd;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 10px;
            font-size: 14px;
            color: #2c3e50;
        }
        
        /* Responsive styles */
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }
            
            .section {
                padding: 15px;
            }
            
            table {
                display: block;
                overflow-x: auto;
            }
            
            .actions {
                flex-direction: column;
            }
            
            button {
                width: 100%;
            }
            
            .form-actions {
                flex-direction: column;
            }
        }
        
        @media (max-width: 480px) {
            th, td {
                padding: 8px 10px;
                font-size: 14px;
            }
            
            h1 {
                font-size: 24px;
            }
            
            h2 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <?php include "side.php"; ?>
    <div class="container">
        <header>
            <h1>Stylist Schedule Management</h1>
            <p>Manage your shifts and appointments</p>
        </header>
        
        <!-- Debug information -->
        <div class="debug-info">
            Total shifts in database: <?php echo $debug_row['total']; ?>
        </div>
        
        <?php if (isset($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <!-- Quick Add New Shift Button -->
        <?php if (!$edit_mode): ?>
        <div style="text-align: center; margin-bottom: 20px;">
            <a href="#add-shift-section">
                <button class="add-new-btn">➕ Add New Shift</button>
            </a>
        </div>
        <?php endif; ?>
        
        <div class="section" id="add-shift-section">
            <h2><?php echo $edit_mode ? 'Edit Shift' : 'Add New Shift'; ?></h2>
            <form method="POST" id="shift-form">
                <?php if ($edit_mode): ?>
                    <input type="hidden" name="shift_id" value="<?php echo $edit_shift_data['id']; ?>">
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="stylist_id">Stylist</label>
                    <select id="stylist_id" name="stylist_id" required>
                        <option value="">Select Stylist</option>
                        <?php foreach ($stylists as $id => $name): ?>
                            <option value="<?php echo $id; ?>" 
                                <?php if ($edit_mode && $edit_shift_data['stylist_id'] == $id) echo 'selected'; ?>>
                                <?php echo $name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" id="date" name="date" 
                           value="<?php echo $edit_mode ? $edit_shift_data['date'] : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="start_time">Start Time</label>
                    <input type="time" id="start_time" name="start_time" 
                           value="<?php echo $edit_mode ? $edit_shift_data['start_time'] : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="end_time">End Time</label>
                    <input type="time" id="end_time" name="end_time" 
                           value="<?php echo $edit_mode ? $edit_shift_data['end_time'] : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" required>
                        <option value="Scheduled" <?php if ($edit_mode && $edit_shift_data['status'] == 'Scheduled') echo 'selected'; ?>>Scheduled</option>
                        <option value="Completed" <?php if ($edit_mode && $edit_shift_data['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                    </select>
                </div>
                
                <div class="form-actions">
                    <button type="submit" name="<?php echo $edit_mode ? 'edit_shift' : 'add_shift'; ?>">
                        <?php echo $edit_mode ? 'Update Shift' : 'Add New Shift'; ?>
                    </button>
                    
                    <?php if ($edit_mode): ?>
                        <a href="?" class="cancel-btn" style="text-decoration: none;">
                            <button type="button" class="cancel-btn">Cancel Edit</button>
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        
        <div class="section">
            <h2><?php echo $show_all ? 'All Shifts' : 'Upcoming Shifts'; ?></h2>
            <table>
                <thead>
                    <tr>
                        <th>Shift ID</th>
                        <th>Stylist</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $shifts_result = $show_all ? $result_all : $result;
                    
                    if ($shifts_result->num_rows > 0) {
                        while($row = $shifts_result->fetch_assoc()) {
                            $status_class = strtolower($row["status"]) == "scheduled" ? "status-scheduled" : "status-completed";
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . ($row["stylist_name"] ?? 'N/A') . "</td>";
                            echo "<td>" . $row["date"] . "</td>";
                            echo "<td>" . $row["start_time"] . "</td>";
                            echo "<td>" . $row["end_time"] . "</td>";
                            echo "<td><span class='" . $status_class . "'>" . $row["status"] . "</span></td>";
                            echo "<td class='actions'>";
                            
                            // Edit button
                            echo "<a href='?edit=" . $row["id"] . "'><button class='btn-secondary'>Edit</button></a>";
                            
                            // Status toggle buttons
                            if ($row["status"] == "Scheduled") {
                                echo "<form method='POST' style='display:inline;'>";
                                echo "<input type='hidden' name='shift_id' value='" . $row["id"] . "'>";
                                echo "<button type='submit' name='mark_completed' class='btn-success'>Complete</button>";
                                echo "</form>";
                            } else {
                                echo "<form method='POST' style='display:inline;'>";
                                echo "<input type='hidden' name='shift_id' value='" . $row["id"] . "'>";
                                echo "<button type='submit' name='mark_scheduled' class='btn-warning'>Reschedule</button>";
                                echo "</form>";
                            }
                            
                            // Delete button
                            echo "<form method='POST' style='display:inline;' onsubmit='return confirm(\"Are you sure you want to delete this shift?\");'>";
                            echo "<input type='hidden' name='shift_id' value='" . $row["id"] . "'>";
                            echo "<button type='submit' name='delete_shift' class='btn-danger'>Delete</button>";
                            echo "</form>";
                            
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No shifts found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            
            <?php if (!$show_all): ?>
                <div class="view-all">
                    <a href="?view=all"><button class="btn-secondary">View All Shifts</button></a>
                </div>
            <?php else: ?>
                <div class="view-all">
                    <a href="?view=upcoming"><button class="btn-secondary">Show Only Upcoming Shifts</button></a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Form validation
        document.getElementById('shift-form').addEventListener('submit', function(e) {
            const date = document.getElementById('date').value;
            const startTime = document.getElementById('start_time').value;
            const endTime = document.getElementById('end_time').value;
            const stylist = document.getElementById('stylist_id').value;
            
            if (!date || !startTime || !endTime || !stylist) {
                e.preventDefault();
                alert('Please fill in all fields');
                return false;
            }
            
            if (startTime >= endTime) {
                e.preventDefault();
                alert('End time must be after start time');
                return false;
            }
            
            // Check if date is not in the past
            const selectedDate = new Date(date);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            if (selectedDate < today) {
                e.preventDefault();
                alert('Please select today\'s date or a future date');
                return false;
            }
            
            return true;
        });
        
        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('date').min = today;
        
        // Auto-scroll to form when "Add New Shift" button is clicked
        document.querySelector('.add-new-btn')?.addEventListener('click', function() {
            document.getElementById('add-shift-section').scrollIntoView({ 
                behavior: 'smooth' 
            });
        });
        
        // Auto-hide messages after 5 seconds
        setTimeout(function() {
            const messages = document.querySelectorAll('.message');
            messages.forEach(function(message) {
                message.style.display = 'none';
            });
        }, 5000);
    </script>
</body>
</html>

<?php
$conn->close();
?>