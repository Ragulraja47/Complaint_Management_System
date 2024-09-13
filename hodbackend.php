<?php
include("db.php");

if (isset($_POST['update_status'])) {
    try {
        $id = mysqli_real_escape_string($conn, $_POST['update_id']);
        
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

if (isset($_POST['updated_status'])) {
    try {
        $id = mysqli_real_escape_string($conn, $_POST['updated_id']);
        
        $query = "UPDATE complaints_detail SET status = '4' WHERE status='2' ";

        if (mysqli_query($conn, $query)) {
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

if (isset($_POST['textaria'])) {
    try {
        $id = mysqli_real_escape_string($conn, $_POST['reject_id']);
        $feedback = mysqli_real_escape_string($conn, $_POST['textaria']);

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

if (isset($_POST['seedetails'])) {
    $student_id1 = mysqli_real_escape_string($conn, $_POST['user_id']);

    $query = "SELECT * FROM complaints_detail WHERE id='$student_id1'";
    $query_run = mysqli_query($conn, $query);
    //data only for editing
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

if (isset($_POST['seedetailsapr'])) {
    $student_id2 = mysqli_real_escape_string($conn, $_POST['user_idapr']);

    $query = "SELECT * FROM complaints_detail WHERE id='$student_id2' ";
    $query_run = mysqli_query($conn, $query);
    //data only for editing
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

if (isset($_POST['seedetailscomp'])) {
    $student_id3 = mysqli_real_escape_string($conn, $_POST['user_idcomp']);
    
    $query = "SELECT * FROM complaints_detail WHERE id='$student_id3' and status='11'";
    $query_run = mysqli_query($conn, $query);
    //data only for editing
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

if (isset($_POST['seedetailsrej'])) {
    $student_id4 = mysqli_real_escape_string($conn, $_POST['user_idrej1']);
    
    $query = "SELECT * FROM complaints_detail WHERE id='$student_id4'";
    $query_run = mysqli_query($conn, $query);
    //data only for editing
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

if (isset($_POST['seefeedback'])) {
    $student_id5 = mysqli_real_escape_string($conn, $_POST['user_idrej']);
    
    $query = "SELECT * FROM complaints_detail WHERE id='$student_id5'";
    $query_run = mysqli_query($conn, $query);
    //data only for editing
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

        // Validate task_id
        if ($task_id == 0) {
            echo json_encode(['status' => 400, 'message' => 'Task ID not provided or invalid']);
            exit;
        }
    
        // Query to fetch the image based on task_id
        $query = "SELECT image FROM complaints_detail WHERE id = ?";
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
            $image_path = 'uploads/' . $row['image']; // Assuming 'image' column stores the correct filename

            // Check if the image file exists on the server
            if (file_exists($image_path)) {
                echo json_encode(['status' => 200, 'data' => ['image' => $image_path]]);
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

// Get after Image
if (isset($_POST['after_image'])) {
    $task_id = isset($_POST['task_id']) ? intval($_POST['task_id']) : '';

    // Validate task_id
    if ($task_id == 0) {
        echo json_encode(['status' => 400, 'message' => 'Task ID not provided or invalid']);
        exit;
    }

    // Query to fetch the image based on task_id
    $query = "SELECT after_photo FROM workertaskdet WHERE id = ?";
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
        $image_path = 'imgafter/' . $row['image']; // Assuming 'image' column stores the correct filename

        // Check if the image file exists on the server
        if (file_exists($image_path)) {
            echo json_encode(['status' => 200, 'data' => ['image' => $image_path]]);
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

?>
