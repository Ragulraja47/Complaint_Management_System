<?php
include("db.php");

//Approve Button
if (isset($_POST['approvebtn'])) {
    try {
        $id = mysqli_real_escape_string($conn, $_POST['approve']);
        
        $query = "UPDATE complaints_detail SET status = '4' WHERE id='$id'";
        
        if (mysqli_query($conn, $query))    {
            $res = [
                'status' => 200,
                'message' => 'Details Updated Successfully'
            ];
            echo json_encode($res);
        } else {
            throw new Exception('Query Failed: ' . mysqli_error($conn));
        }
    } catch (Exception $e) {
        $res = [
            'status' => 500,
            'message' => 'Error: ' . $e->getMessage()
        ];
        echo json_encode($res);
    }
}
//Rejected Feedback
if (isset($_POST['rejfeed'])) {
    try {
        $id = mysqli_real_escape_string($conn, $_POST['reject_id']);
        $feedback = mysqli_real_escape_string($conn, $_POST['rejfeed']);

        $query = "UPDATE complaints_detail SET feedback = '$feedback', status = '5' WHERE id = '$id'";

        if (mysqli_query($conn, $query)) {
            $res = [
                'status' => 200,
                'message' => 'Details Updated Successfully'
            ];
            echo json_encode($res);
        } else {
            throw new Exception('Query Failed: ' . mysqli_error($conn));
            echo "print";
        }
    } catch (Exception $e) {
        $res = [
            'status' => 500,
            'message' => 'Error: ' . $e->getMessage()
        ];
        echo json_encode($res);
    }
}

//Problem Description
if (isset($_POST['seedetails'])) {
    $student_id1 = mysqli_real_escape_string($conn, $_POST['user_id']);
    $query = "SELECT * FROM complaints_detail WHERE id='$student_id1'";
    $query_run = mysqli_query($conn, $query);
    $User_data = mysqli_fetch_array($query_run);
    if ($query_run) {
        $res = [
            'status' => 200,
            'message' => 'details Fetch Successfully by id',
            'data' => $User_data
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Details Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
}

//Faculty Details
if (isset($_POST['facultydetails'])) {
    $student_id1 = mysqli_real_escape_string($conn, $_POST['user_id']);
    $query = "SELECT cd.*, faculty.faculty_name, faculty.department, faculty.faculty_contact, faculty.faculty_mail
FROM complaints_detail cd
JOIN faculty ON cd.faculty_id = faculty.faculty_id WHERE cd.id='$student_id1'";
    $query_run = mysqli_query($conn, $query);
    $User_data = mysqli_fetch_array($query_run);
    if ($query_run) {
        $res = [
            'status' => 200,
            'message' => 'details Fetch Successfully by id',
            'data' => $User_data
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Details Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
}

//Rejected Reason
if (isset($_POST['seefeedback'])) {
    $student_id5 = mysqli_real_escape_string($conn, $_POST['user_idrej']);
    
    $query = "SELECT * FROM complaints_detail WHERE id='$student_id5'";
    $query_run = mysqli_query($conn, $query);
    $User_data = mysqli_fetch_array($query_run);

    if ($query_run) {
        $res = [
            'status' => 200,
            'message' => 'details Fetch Successfully by id',
            'data' => $User_data
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Details Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
}

// Get Image
if (isset($_POST['get_image'])) {
    $task_id = isset($_POST['task_id']) ? intval($_POST['task_id']) : '';

    if ($task_id == 0
    ) {
        echo json_encode(['status' => 400, 'message' => 'Task ID not provided or invalid']);
        exit;
    }

    $query = "SELECT images FROM complaints_detail WHERE id = ?";
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
        $image_path = 'uploads/' . $row['images'];

        if (file_exists($image_path)) {
            echo json_encode(['status' => 200, 'data' => ['images' => $image_path]]);
        } else {
            echo json_encode(['status' => 404, 'message' => 'Image file not found on the server']);
        }
    } else {
        echo json_encode(['status' => 404, 'message' => 'No image found']);
    }

    $stmt->close();
    $conn->close();
    exit;
}

// Get After Image
if (isset($_POST['after_image'])) {
    $task_id = isset($_POST['task_id']) ? intval($_POST['task_id']) : '';

    if ($task_id == 0) {
        echo json_encode(['status' => 400, 'message' => 'Task ID not provided or invalid']);
        exit;
    }

    $query = "SELECT after_photo FROM worker_taskdet WHERE id = ?";
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
        $image_path = 'imgafter/' . $row['after_photo'];

        if (file_exists($image_path)) {
            echo json_encode(['status' => 200, 'data' => ['after_photo' => $image_path]]);
        } else {
            echo json_encode(['status' => 404, 'message' => 'Image file not found on the server']);
        }
    } else {
        echo json_encode(['status' => 404, 'message' => 'No image found']);
    }

    $stmt->close();
    $conn->close();
    exit;
}

// Handle form submission
if (isset($_POST['faculty_id'])) {
    $faculty_id = mysqli_real_escape_string($conn, $_POST['faculty_id']);
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

        $allowedExtensions = ['jpg', 'jpeg', 'png'];
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
            echo json_encode(['status' => 500, 'message' => 'Upload failed. Allowed types: jpg, jpeg, png.']);
            exit;
        }
    }


    // Insert data into the database
    $query = "INSERT INTO complaints_detail (faculty_id, block_venue, venue_name, type_of_problem, problem_description, images, date_of_reg, status) 
              VALUES ('$faculty_id', '$block_venue', '$venue_name', '$type_of_problem', '$problem_description', '$images', '$date_of_reg', '$status')";

    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 200, 'message' => 'Success']);
    } else {
        echo json_encode(['status' => 500, 'message' => 'Error inserting data: ' . mysqli_error($conn)]);
    }
    exit;
}

?>
