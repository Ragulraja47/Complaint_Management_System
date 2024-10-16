<?php
include("db.php");

//image

if (isset($_POST['get_image'])) {
    $user_id = $_POST['user_id'];

    // Query to fetch the image based on user ID
    $query = "SELECT id, images FROM complaints_detail WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['status' => 200, 'data' => $row]);
    } else {
        echo json_encode(['status' => 500, 'message' => 'Image not found']);
    }

    $stmt->close();
    $conn->close();
}
//AFTER IMAGE

if (isset($_POST['after_image'])) {
    $user_id = $_POST['user_id'];

    // Query to fetch the image based on user ID
    $query = "SELECT id, after_photo FROM worker_taskdet WHERE task_id= ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['status' => 200, 'data' => $row]);
    } else {
        echo json_encode(['status' => 500, 'message' => 'Image not found']);
    }

    $stmt->close();
    $conn->close();
}
//approve
if (isset($_POST['seedetails'])) {
    $student_id = mysqli_real_escape_string($conn, $_POST['user_id']);

    $query = "UPDATE complaints_detail SET status='2' WHERE id='$student_id'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        // Successful update
        $res = [
            'status' => 200,
            'message' => 'Details updated successfully'
        ];
    } else {
        // Failed update
        $res = [
            'status' => 500,
            'message' => 'Failed to update status'
        ];
    }

    echo json_encode($res);
}
   
//reject
if (isset($_POST['reject_status'])) {
    $reject_id = mysqli_real_escape_string($conn, $_POST['reject_id']);
    $feedback = mysqli_real_escape_string($conn, $_POST['textaria']);  // Get feedback from textarea

    // Update the complaints_detail table with the feedback and change status
    $query = "UPDATE complaints_detail SET status='3', feedback='$feedback' WHERE id='$reject_id'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $res = [
            'status' => 200,
            'message' => 'Complaint rejected and feedback updated successfully'
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Failed to reject complaint'
        ];
        echo json_encode($res);
        return;
    }
}



if (isset($_POST['seedetails1'])) {
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
?>
<?php

    

   

