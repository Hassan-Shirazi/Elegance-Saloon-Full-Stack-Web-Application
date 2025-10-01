<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receptionist Dashboard - Notifications & Reminders</title>
  <link rel="stylesheet" href="css/notify.css">
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
    
    // Initialize variables
    $message = "";
    $message_type = "";
    
    // Handle form submissions
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Add Notification
        if (isset($_POST['add_notification'])) {
            $message_text = mysqli_real_escape_string($conn, $_POST['notification_message']);
            $type = mysqli_real_escape_string($conn, $_POST['notification_type']);
            
            if (!empty($message_text)) {
                $sql = "INSERT INTO notifications (message, type, status, created_at) 
                        VALUES ('$message_text', '$type', 'unread', NOW())";
                
                if (mysqli_query($conn, $sql)) {
                    $message = "Notification added successfully!";
                    $message_type = "success";
                } else {
                    $message = "Error adding notification: " . mysqli_error($conn);
                    $message_type = "error";
                }
            } else {
                $message = "Please enter a notification message";
                $message_type = "error";
            }
        }
        
        // Add Reminder
        if (isset($_POST['add_reminder'])) {
            $client_name = mysqli_real_escape_string($conn, $_POST['client_name']);
            $service = mysqli_real_escape_string($conn, $_POST['service']);
            $reminder_date = mysqli_real_escape_string($conn, $_POST['reminder_date']);
            $reminder_time = mysqli_real_escape_string($conn, $_POST['reminder_time']);
            $stylist = mysqli_real_escape_string($conn, $_POST['stylist']);
            
            if (!empty($client_name) && !empty($service) && !empty($reminder_date) && !empty($reminder_time) && !empty($stylist)) {
                // Use correct column names that match your table structure
                $sql = "INSERT INTO reminders (client_name, service, date, time, stylist, status, created_at) 
                        VALUES ('$client_name', '$service', '$reminder_date', '$reminder_time', '$stylist', 'upcoming', NOW())";
                
                if (mysqli_query($conn, $sql)) {
                    $message = "Reminder added successfully!";
                    $message_type = "success";
                } else {
                    $message = "Error adding reminder: " . mysqli_error($conn);
                    $message_type = "error";
                }
            } else {
                $message = "Please fill in all reminder fields";
                $message_type = "error";
            }
        }
        
        // Mark as Read
        if (isset($_POST['mark_read'])) {
            $notification_id = intval($_POST['notification_id']);
            $sql = "UPDATE notifications SET status = 'read' WHERE id = $notification_id";
            
            if (mysqli_query($conn, $sql)) {
                $message = "Notification marked as read!";
                $message_type = "success";
            } else {
                $message = "Error updating notification: " . mysqli_error($conn);
                $message_type = "error";
            }
        }
        
        // Mark All as Read
        if (isset($_POST['mark_all_read'])) {
            $sql = "UPDATE notifications SET status = 'read' WHERE status = 'unread'";
            
            if (mysqli_query($conn, $sql)) {
                $message = "All notifications marked as read!";
                $message_type = "success";
            } else {
                $message = "Error updating notifications: " . mysqli_error($conn);
                $message_type = "error";
            }
        }
        
        // Delete Notification
        if (isset($_POST['delete_notification'])) {
            $notification_id = intval($_POST['notification_id']);
            $sql = "DELETE FROM notifications WHERE id = $notification_id";
            
            if (mysqli_query($conn, $sql)) {
                $message = "Notification deleted successfully!";
                $message_type = "success";
            } else {
                $message = "Error deleting notification: " . mysqli_error($conn);
                $message_type = "error";
            }
        }
        
        // Delete Reminder
        if (isset($_POST['delete_reminder'])) {
            $reminder_id = intval($_POST['reminder_id']);
            $sql = "DELETE FROM reminders WHERE id = $reminder_id";
            
            if (mysqli_query($conn, $sql)) {
                $message = "Reminder deleted successfully!";
                $message_type = "success";
            } else {
                $message = "Error deleting reminder: " . mysqli_error($conn);
                $message_type = "error";
            }
        }
    }
    
    // Fetch notifications from database
    $notifications_sql = "SELECT * FROM notifications ORDER BY created_at DESC";
    $notifications_result = mysqli_query($conn, $notifications_sql);
    
    // Fetch reminders from database
    $reminders_sql = "SELECT * FROM reminders ORDER BY date, time ASC";
    $reminders_result = mysqli_query($conn, $reminders_sql);
    ?>
    
    <div class="dashboard-container">
        <header>
            <h1>Notification & Reminder</h1>
            <form method="POST" style="display: inline;">
                <button type="submit" name="mark_all_read" class="btn btn-primary">Mark All as Read</button>
            </form>
        </header>
        
        <!-- Display messages -->
        <?php if (!empty($message)): ?>
            <div class="alert <?php echo $message_type == 'success' ? 'alert-success' : 'alert-error'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <!-- Add New Items Form -->
        <div class="form-container">
            <div class="form-grid">
                <div>
                    <h3 class="form-title">Add New Notification</h3>
                    <form method="POST">
                        <div class="form-group">
                            <label for="notificationMessage">Message</label>
                            <input type="text" id="notificationMessage" name="notification_message" class="form-control" placeholder="Enter notification message" required>
                        </div>
                        <div class="form-group">
                            <label for="notificationType">Type</label>
                            <select id="notificationType" name="notification_type" class="form-control">
                                <option value="appointment">Appointment</option>
                                <option value="inventory">Inventory</option>
                                <option value="payment">Payment</option>
                                <option value="system">System</option>
                                <option value="general">General</option>
                            </select>
                        </div>
                        <button type="submit" name="add_notification" class="btn btn-success">Add Notification</button>
                    </form>
                </div>
                
                <div>
                    <h3 class="form-title">Add New Reminder</h3>
                    <form method="POST">
                        <div class="form-group">
                            <label for="clientName">Client Name</label>
                            <input type="text" id="clientName" name="client_name" class="form-control" placeholder="Enter client name" required>
                        </div>
                        <div class="form-group">
                            <label for="service">Service</label>
                            <input type="text" id="service" name="service" class="form-control" placeholder="Enter service" required>
                        </div>
                        <div class="form-group">
                            <label for="reminderDate">Date</label>
                            <input type="date" id="reminderDate" name="reminder_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="reminderTime">Time</label>
                            <input type="time" id="reminderTime" name="reminder_time" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="stylist">Stylist</label>
                            <input type="text" id="stylist" name="stylist" class="form-control" placeholder="Enter stylist name" required>
                        </div>
                        <button type="submit" name="add_reminder" class="btn btn-success">Add Reminder</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="dashboard-grid">
            <!-- Notifications Section -->
            <div class="module">
                <div class="module-header">
                    <h2 class="module-title">Notifications</h2>
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn btn-outline">Refresh</a>
                </div>
                <div class="module-content" id="notificationsList">
                    <?php if (mysqli_num_rows($notifications_result) > 0): ?>
                        <?php while($notification = mysqli_fetch_assoc($notifications_result)): ?>
                            <div class="notification-item">
                                <div class="notification-header">
                                    <span class="notification-id">#<?php echo $notification['id']; ?> (<?php echo $notification['type']; ?>)</span>
                                    <div>
                                        <span class="notification-status <?php echo $notification['status'] == 'unread' ? 'status-unread' : 'status-read'; ?>">
                                            <?php echo $notification['status'] == 'unread' ? 'Unread' : 'Read'; ?>
                                        </span>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="notification_id" value="<?php echo $notification['id']; ?>">
                                            <button type="submit" name="delete_notification" class="delete-btn" onclick="return confirm('Are you sure you want to delete this notification?')">Delete</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="notification-message"><?php echo $notification['message']; ?></div>
                                <div class="notification-datetime"><?php echo date('Y-m-d H:i A', strtotime($notification['created_at'])); ?></div>
                                <div class="action-buttons">
                                    <?php if ($notification['status'] == 'unread'): ?>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="notification_id" value="<?php echo $notification['id']; ?>">
                                            <button type="submit" name="mark_read" class="btn btn-outline" style="font-size: 12px;">Mark as Read</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <p>No notifications at this time</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Reminders Section -->
            <div class="module">
                <div class="module-header">
                    <h2 class="module-title">Client Reminders</h2>
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn btn-outline">Refresh</a>
                </div>
                <div class="module-content" id="remindersList">
                    <?php if (mysqli_num_rows($reminders_result) > 0): ?>
                        <?php while($reminder = mysqli_fetch_assoc($reminders_result)): ?>
                            <div class="reminder-item">
                                <div class="reminder-header">
                                    <span class="reminder-id">#<?php echo $reminder['id']; ?></span>
                                    <div>
                                        <span class="reminder-status status-upcoming">Upcoming</span>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="reminder_id" value="<?php echo $reminder['id']; ?>">
                                            <button type="submit" name="delete_reminder" class="delete-btn" onclick="return confirm('Are you sure you want to delete this reminder?')">Delete</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="reminder-client"><?php echo $reminder['client_name']; ?></div>
                                <div class="reminder-datetime"><?php echo $reminder['date']; ?> at <?php echo date('h:i A', strtotime($reminder['time'])); ?></div>
                                <div class="reminder-details">
                                    <div class="detail-item">
                                        <span class="detail-label">Service</span>
                                        <span class="detail-value"><?php echo $reminder['service']; ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Stylist</span>
                                        <span class="detail-value"><?php echo $reminder['stylist']; ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <p>No upcoming reminders</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Set default date to today
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('reminderDate').value = today;
            
            // Set default time to current time + 1 hour
            const now = new Date();
            now.setHours(now.getHours() + 1);
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            document.getElementById('reminderTime').value = `${hours}:${minutes}`;
        });
    </script>
</body>
</html>
<?php
// Close database connection
mysqli_close($conn);
?>