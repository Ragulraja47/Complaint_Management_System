<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("db.php");

if (!$conn) {
    echo json_encode(['status' => 500, 'message' => 'Database connection failed']);
    exit;
}

// Define the counter file path
$counterFilePath = './uploads/counter.txt';

// Function to get the next file number
function getNextFileNumber($counterFilePath)
{
    if (file_exists($counterFilePath)) {
        $file = fopen($counterFilePath, 'r');
        $lastNumber = (int)fgets($file);
        fclose($file);
        $nextNumber = $lastNumber + 1;
    } else {
        $nextNumber = 1;
    }
    $file = fopen($counterFilePath, 'w');
    fwrite($file, $nextNumber);
    fclose($file);
    return $nextNumber;
}

// Handle form submission
if (isset($_POST['faculty_id']) && isset($_POST['faculty_name'])) {
    $faculty_id = mysqli_real_escape_string($conn, $_POST['faculty_id']);
    $faculty_name = mysqli_real_escape_string($conn, $_POST['faculty_name']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $faculty_contact = mysqli_real_escape_string($conn, $_POST['faculty_contact']);
    $faculty_mail = mysqli_real_escape_string($conn, $_POST['faculty_mail']);
    $block_venue = mysqli_real_escape_string($conn, $_POST['block_venue']);
    $venue_name = mysqli_real_escape_string($conn, $_POST['venue_name']);
    $type_of_problem = mysqli_real_escape_string($conn, $_POST['type_of_problem']);
    $problem_description = mysqli_real_escape_string($conn, $_POST['problem_description']);
    $date_of_reg = mysqli_real_escape_string($conn, $_POST['date_of_reg']);
    $status = $_POST['status'];

    // Handle file upload
    $images = "";
    $uploadFileDir = './uploads/';

    if (!is_dir($uploadFileDir) && !mkdir($uploadFileDir, 0755, true)) {
        echo json_encode(['status' => 500, 'message' => 'Failed to create upload directory.']);
        exit;
    }

    if (isset($_FILES['images']) && $_FILES['images']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['images']['tmp_name'];
        $fileNameCmps = explode(".", $_FILES['images']['name']);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($fileExtension, $allowedExtensions)) {
            $nextFileNumber = getNextFileNumber($counterFilePath);
            $newFileName = str_pad($nextFileNumber, 10, '0', STR_PAD_LEFT) . '.' . $fileExtension;
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $images = $newFileName;
            } else {
                echo json_encode(['status' => 500, 'message' => 'Error moving the uploaded file.']);
                exit;
            }
        } else {
            echo json_encode(['status' => 500, 'message' => 'Upload failed. Allowed types: jpg, jpeg, png, gif.']);
            exit;
        }
    }

    // Insert data into the database
    $query = "INSERT INTO complaints_detail (faculty_id, faculty_name, department, faculty_contact, faculty_mail, block_venue, venue_name, type_of_problem, problem_description, images, date_of_reg, status) 
              VALUES ('$faculty_id', '$faculty_name', '$department', '$faculty_contact', '$faculty_mail', '$block_venue', '$venue_name', '$type_of_problem', '$problem_description', '$images', '$date_of_reg', '$status')";

    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 200, 'message' => 'Success']);
    } else {
        echo json_encode(['status' => 500, 'message' => 'Error inserting data: ' . mysqli_error($conn)]);
    }
    exit;
}

// Handle complaint deletion
if (isset($_POST['delete_user'])) {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $query = "DELETE FROM complaints_detail WHERE id='$user_id'";

    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 200, 'message' => 'Deleted successfully']);
    } else {
        echo json_encode(['status' => 500, 'message' => 'Error deleting data: ' . mysqli_error($conn)]);
    }
    exit;
}

// Handle image retrieval
if (isset($_POST['get_image'])) {
    $id = isset($_POST['id']) ? $_POST['id'] : ''; // Ensure id is set

    // Validate id
    if (empty($id)) {
        echo json_encode(['status' => 400, 'message' => 'ID not provided']);
        exit;
    }

    // Query to fetch the image based on id
    $query = "SELECT id, images FROM complaints_detail WHERE id = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        echo json_encode(['status' => 500, 'message' => 'Prepare statement failed: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['status' => 200, 'data' => $row]);
    } else {
        echo json_encode(['status' => 500, 'message' => 'No image found']);
    }

    $stmt->close();
    $conn->close();
    exit; // Ensure we exit after handling the request
}

// View workers details
if (isset($_POST['get_worker_details'])) {
    $id = $_POST['id'];

    // SQL query to get worker details
    $query = "
    SELECT w.worker_first_name, w.worker_last_name, w.worker_mobile, w.worker_mail
    FROM complaints_detail cd
    INNER JOIN manager m ON cd.id = m.problem_id
    INNER JOIN worker_details w ON m.worker_id = w.worker_id
    WHERE cd.id = ?
";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $worker = $result->fetch_assoc();
        echo json_encode(['status' => 200, 'worker_first_name' => $worker['worker_first_name'], 'worker_last_name' => $worker['worker_last_name'], 'worker_mobile' => $worker['worker_mobile'], 'worker_mail' => $worker['worker_mail']]);
    } else {
        echo json_encode(['status' => 500, 'message' => 'No worker details found for this id']);
    }

    $stmt->close();
    $conn->close();
    exit;
}

// Handle status details retrieval
if (isset($_POST['get_status_details'])) {
    $id = $_POST['id'];

    // Query to fetch status based on id
    $query = "SELECT status FROM complaints_detail WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $status = $row['status'];

        // Mapping status codes to messages
        $statusMessage = '';
        if ($status == 1) {
            $statusMessage = 'pending';
        } elseif ($status == 2) {
            $statusMessage = 'Approved by infra';
        } elseif ($status == 3) {
            $statusMessage = 'Rejected by infra';
        } elseif ($status == 4) {
            $statusMessage = 'Approved by HOD';
        } elseif ($status == 5) {
            $statusMessage = 'Rejected by HOD';
        } elseif ($status == 6) {
            $statusMessage = 'sent to principal for approval';
        } elseif ($status == 7) {
            $statusMessage = 'Assigned to worker';
        } elseif ($status == 8) {
            $statusMessage = ' ';
        } elseif ($status == 9) {
            $statusMessage = ' ';
        } elseif ($status == 10) {
            $statusMessage = 'worker inprogress';
        } elseif ($status == 11) {
            $statusMessage = 'waiting for approval';
        } elseif ($status == 12) {
            $statusMessage = ' ';
        } elseif ($status == 13) {
            $statusMessage = 'Work completed';
        } elseif ($status == 14) {
            $statusMessage = 'Sent to manager for rework(Reassign)';
        } elseif ($status == 15) {
            $statusMessage = 'Rework details';
        } elseif ($status == 16) {
            $statusMessage = 'Rejected by manager(Reassign)';
        } elseif ($status == 17) {
            $statusMessage = 'In progress';
        } elseif ($status == 18) {
            $statusMessage = 'Rejected by principle';
        } elseif ($status == 19) {
            $statusMessage = 'Rejected by manager';
        } else {
            $statusMessage = 'Unknown status';
        }

        echo json_encode(['status' => 200, 'message' => $statusMessage]);
    } else {
        echo json_encode(['status' => 500, 'message' => 'No status found']);
    }

    $stmt->close();
    $conn->close();
    exit;
}


// Handle feedback form submission
// submit feedback
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Handle feedback submission
    if (isset($_POST['feedback'])) {
        $feedback = $_POST['feedback'];
        
        // Validate inputs
        if (empty($id) || empty($feedback)) {
            echo json_encode(['status' => 400, 'message' => 'Problem ID or Feedback is missing']);
            exit;
        }

        // SQL query to update feedback and status
        $query = "UPDATE complaints_detail SET feedback = ?, status = 13 WHERE id = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            echo json_encode(['status' => 500, 'message' => 'Prepare statement failed: ' . $conn->error]);
            exit;
        }

        $stmt->bind_param('si', $feedback, $id);

        if ($stmt->execute()) {
            echo json_encode(['status' => 200, 'message' => 'Feedback submitted']);
        } else {
            echo json_encode(['status' => 500, 'message' => 'Query failed: ' . $stmt->error]);
        }

        $stmt->close();
    } elseif ($_POST['action'] === 'reassign') {
        // Handle reassign action
        $query = "UPDATE complaints_detail SET status = 14 WHERE id = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            echo json_encode(['status' => 500, 'message' => 'Prepare statement failed: ' . $conn->error]);
            exit;
        }

        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            echo json_encode(['status' => 200, 'message' => 'Problem reassigned']);
        } else {
            echo json_encode(['status' => 500, 'message' => 'Query failed: ' . $stmt->error]);
        }

        $stmt->close();
    }

    $conn->close();
    exit;
}
