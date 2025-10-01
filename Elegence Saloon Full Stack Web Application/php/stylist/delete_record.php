<?php
// delete_record.php
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

// Get table and ID from POST request
$table = $_POST['table'];
$id = $_POST['id'];

// Validate table name to prevent SQL injection
$allowed_tables = ['appointments', 'reminders'];
if (!in_array($table, $allowed_tables)) {
    die("Invalid table name");
}

// Delete the record
$sql = "DELETE FROM $table WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}

$stmt->close();
$conn->close();
?>