<?php
include("db.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['id']) && isset($data['days_to_complete'])) {
        $id = $data['id'];
        $deadline = $data['days_to_complete'];

        if (DateTime::createFromFormat('Y-m-d', $deadline) === false) {
            echo json_encode(['success' => false, 'message' => 'Invalid date format']);
            exit;
        }

        $conn = new mysqli("localhost", "root", "", "cms");

        if ($conn->connect_error) {
            die(json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]));
        }

        $sql = "UPDATE complaints_detail SET days_to_complete = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die(json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]));
        }
        $stmt->bind_param("si", $deadline, $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update deadline: ' . $stmt->error]);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid input data']);
    }
}

?>
