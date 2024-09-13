
<?php
// Database connection
$host = "localhost";  // Your database host
$user = "root";       // Your database username
$password = "";       // Your database password
$dbname = "complaints"; // Your database name

$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['department'])) {
// Fetch data from the worker_details table
$sql = "SELECT worker_first_name, worker_last_name, worker_emp_type, worker_dept FROM worker_details WHERE id = id"; // Adjust WHERE clause as necessary
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    $row = $result->fetch_assoc();
    echo json_encode([
        'name' => $row['worker_first_name'] . ' ' . $row['worker_last_name'],
        'employment_type' => $row['worker_emp_type'],
        'department' => $row['worker_dept'],
    ]);
} else {
    echo json_encode([
        'name' => '',
        'employment_type' => '',
        'department' => '',
    ]);
}
}
$conn->close();

?>
