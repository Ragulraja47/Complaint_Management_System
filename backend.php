<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "complaints";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed']));
}

// Determine the action based on a parameter
// Determine the action based on a parameter
if (isset($_POST['fetch_details'])) {
    $task_id = isset($_POST['task_id']) ? intval($_POST['task_id']) : null;

    if ($task_id === null) {
        die(json_encode(['error' => 'Task ID not provided']));
    }

    $sql = "SELECT 
                faculty_name, 
                faculty_contact, 
                block_venue, 
                venue_name, 
                problem_description, 
                days_to_complete
            FROM complaints_detail 
            WHERE id = (SELECT problem_id FROM manager WHERE task_id = ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $response = array();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $response = array(
            'faculty_name' => $row['faculty_name'],
            'faculty_contact' => $row['faculty_contact'],
            'block_venue' => $row['block_venue'],
            'venue_name' => $row['venue_name'],
            'problem_description' => $row['problem_description'],
            'days_to_complete' => $row['days_to_complete']
        );
        echo json_encode($response);
    } else {
        $response['error'] = 'No details found for this complaint.';
    }

  

    $stmt->close();


}  

if (isset($_POST['update_status'])) {
    $task_id = isset($_POST['task_id']) ? intval($_POST['task_id']) : null;

    if ($task_id === null) {
        echo json_encode(['error' => 'Task ID not provided']);
        exit;
    }

    $sql = "UPDATE complaints_detail 
            SET status = 10 
            WHERE id = (SELECT problem_id FROM manager WHERE task_id = ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $task_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => 'Status updated successfully']);
    } else {
        echo json_encode(['error' => 'Failed to update status']);
    }

    $stmt->close();

} 

$conn->close();

?>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//work completion backend
if (isset($_POST['update'])) {
    $taskId = $_POST['task_id'];
    $completionStatus = $_POST['completion_status'];
    $reason = isset($_POST['reason']) ? $_POST['reason'] : null;

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "complaints";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update status, task_completion, and reason in the complaints_detail table
    $updateComplaintSql = "UPDATE complaints_detail 
                           SET status = 11, task_completion = ?, reason = ?, date_of_completion = NOW()
                           WHERE id = (SELECT problem_id FROM manager WHERE task_id = ?)";
    
    if ($stmt = $conn->prepare($updateComplaintSql)) {
        $stmt->bind_param("ssi", $completionStatus, $reason, $taskId);
        if (!$stmt->execute()) {
            echo "Update failed: (" . $stmt->errno . ") " . $stmt->error;
        } else {
            echo "Complaint status, task completion, and reason updated successfully.";
        }
        $stmt->close();
    } else {
        echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
    }





    // Handle file upload
    $imgAfterName = null;
    if (isset($_FILES['img_after']) && $_FILES['img_after']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'imgafter/';
        $imgAfterName = basename($_FILES['img_after']['name']); // This stores only the file name
        $uploadFile = $uploadDir . $imgAfterName; // Full path to move the file
    
        if (move_uploaded_file($_FILES['img_after']['tmp_name'], $uploadFile)) {
            echo "File successfully uploaded: " . $imgAfterName;
    
            // Insert only the image name into worker_taskdet table
            $insertTaskDetSql = "INSERT INTO worker_taskdet (task_id, task_completion, after_photo, work_completion_date) 
                                 VALUES (?, ?, ?, NOW())";
            if ($stmt = $conn->prepare($insertTaskDetSql)) {
                // Pass the image name (not the path) to the database
                $stmt->bind_param("sss", $taskId, $completionStatus, $imgAfterName);
                if (!$stmt->execute()) {
                    echo "Insertion into worker_taskdet failed: (" . $stmt->errno . ") " . $stmt->error;
                } else {
                    echo "Record inserted successfully into worker_taskdet.";
                }
                $stmt->close();
            } else {
                echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
            }
        } else {
            echo "File upload failed.";
        }
    } else {
        echo "No file uploaded or file upload error.";
    }
    
    $conn->close();
}
?>  


<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "complaints";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['get_bef'])) {
    $task_id = isset($_POST['task_id']) ? $_POST['task_id'] : ''; 

    // Validate task_id
    if (empty($task_id)) {
        echo json_encode(['status' => 400, 'message' => 'Task ID not provided']);
        exit;
    }

    // Query to fetch the image based on task_id
    $query = "SELECT images FROM complaints_detail WHERE id = (SELECT problem_id FROM manager WHERE task_id = ?)";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        echo json_encode(['status' => 500, 'message' => 'Prepare statement failed: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param('i', $task_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Extract only the filename
        $image_filename = basename($row['images']); 
        // Ensure correct path construction
        $image_path = 'uploads/' . $image_filename; 
        
        echo json_encode(['status' => 200, 'data' => ['after_photo' => $image_path]]);
    } else {
        echo json_encode(['status' => 500, 'message' => 'No image found']);
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "complaints";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['get_image'])) {
    $task_id = isset($_POST['task_id']) ? $_POST['task_id'] : ''; 

    // Validate task_id
    if (empty($task_id)) {
        echo json_encode(['status' => 400, 'message' => 'Task ID not provided']);
        exit;
    }

    // Query to fetch the image based on task_id
    $query = "SELECT after_photo FROM worker_taskdet WHERE task_id = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        echo json_encode(['status' => 500, 'message' => 'Prepare statement failed: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param('i', $task_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Extract only the filename
        $image_filename = basename($row['after_photo']); 
        // Ensure correct path construction
        $image_path = 'imgafter/' . $image_filename; 
        
        echo json_encode(['status' => 200, 'data' => ['after_photo' => $image_path]]);
    } else {
        echo json_encode(['status' => 500, 'message' => 'No image found']);
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>
