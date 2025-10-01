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

// Handle search and filter
$search = isset($_GET['search']) ? $_GET['search'] : '';
$date_filter = isset($_GET['date_filter']) ? $_GET['date_filter'] : '';

// Build query
$sql = "SELECT * FROM contact_form WHERE 1=1";
$params = [];

if (!empty($search)) {
    $sql .= " AND (name LIKE ? OR email LIKE ? OR subject LIKE ?)";
    $search_term = "%$search%";
    $params = array_merge($params, [$search_term, $search_term, $search_term]);
}

if (!empty($date_filter)) {
    $sql .= " AND DATE(created_at) = ?";
    $params[] = $date_filter;
}

$sql .= " ORDER BY created_at DESC";

// Prepare and execute statement
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $types = str_repeat('s', count($params));
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Submissions - Elegance Salon</title>
    <link rel="icon" type="image/png" href="/images/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/contactM.css">
</head>
<body>

<?php include "side.php"; ?>

    <div class="container">
        <div class="section-title">
            <h2>Customer Messages</h2>
            <div class="underline"></div>
        </div>

        <!-- Stats Section -->
        <div class="stats">
            <div class="stat-card">
                <div class="stat-number"><?php echo $result->num_rows; ?></div>
                <div class="stat-label">Total Submissions</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">
                    <?php
                    $today = date('Y-m-d');
                    $today_sql = "SELECT COUNT(*) as count FROM contact_form WHERE DATE(created_at) = '$today'";
                    $today_result = $conn->query($today_sql);
                    $today_count = $today_result->fetch_assoc()['count'];
                    echo $today_count;
                    ?>
                </div>
                <div class="stat-label">Today's Submissions</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">
                    <?php
                    $week_sql = "SELECT COUNT(*) as count FROM contact_form WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
                    $week_result = $conn->query($week_sql);
                    $week_count = $week_result->fetch_assoc()['count'];
                    echo $week_count;
                    ?>
                </div>
                <div class="stat-label">Last 7 Days</div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="table-container">
            <?php if ($result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['subject']); ?></td>
                                <td class="message-cell">
                                    <span class="message-text"><?php echo htmlspecialchars($row['message']); ?></span>
                                </td>
                                <td><?php echo date('M j, Y g:i A', strtotime($row['created_at'])); ?></td>
                                <td class="actions">
                                    <button class="action-btn" title="View Details" onclick="viewDetails(<?php echo $row['id']; ?>)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="action-btn" title="Reply" onclick="replyToMessage('<?php echo htmlspecialchars($row['email']); ?>', '<?php echo htmlspecialchars($row['subject']); ?>')">
                                        <i class="fas fa-reply"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-results">
                    <i class="fas fa-inbox"></i>
                    <h3>No submissions found</h3>
                    <p>No contact form submissions match your current filters.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // View details function
        function viewDetails(id) {
            alert('Viewing details for submission ID: ' + id);
        }

        // Reply to message function
        function replyToMessage(email, subject) {
            const subjectLine = subject.startsWith('Re:') ? subject : 'Re: ' + subject;
            window.location.href = 'mailto:' + email + '?subject=' + encodeURIComponent(subjectLine);
        }
    </script>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>