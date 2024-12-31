<?php
 
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('db.php');

if (isset($_POST['work'])) {
    $work = $_POST['worker_dept'];  // The department value
    // Modify the query to select both worker_id and worker_first_name
    $sql8 = "SELECT worker_id, worker_first_name FROM worker_details WHERE worker_dept = '$work' AND usertype = 'worker'";
    $result8 = mysqli_query($conn, $sql8);

    // Prepare to output options directly
    $options = '';


    while ($row = mysqli_fetch_assoc($result8)) {
        // Echo each worker's ID and name as an option element (worker_id - worker_first_name)
        $options .= '<option value="' . $row['worker_id'] . '">' . $row['worker_id'] . ' - ' . $row['worker_first_name'] . '</option>';

    }
    // Return the options to the AJAX request
    echo $options;
    exit();  // Stop script execution after output
}
if (isset($_POST['fetch_details'])) {
    $task_id = isset($_POST['task_id']) ? intval($_POST['task_id']) : null;

    if ($task_id === null) {
        die(json_encode(['error' => 'Task ID not provided']));
    }

    $sql = "SELECT 
        f.faculty_name, 
        f.faculty_contact, 
        cd.block_venue, 
        cd.venue_name, 
        cd.problem_description, 
        cd.days_to_complete
    FROM 
        complaints_detail AS cd
    JOIN 
        faculty AS f ON cd.faculty_id = f.faculty_id
    WHERE 
        cd.id = (SELECT problem_id FROM manager WHERE task_id = ?)
";


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

if (isset($_POST['start_work'])) {
    $id = $_POST['task_id'];

   

    $sql = "UPDATE complaints_detail 
            SET status = 10 
            WHERE id = (SELECT problem_id FROM manager WHERE task_id = '$id')";

$query_run = mysqli_query($conn, $sql);
if($query_run){
    $res =[
        "status" => 200,
        "message" => "Work started successfully"
    ];
    echo json_encode($res);
}
else{
    $res =[
        "status" => 500,
        "message" => "Work could not be started"
    ];
    echo json_encode($res);
}
}

//work completion backend
if (isset($_POST['update'])) {
    $taskId = $_POST['task_id'];
    $completionStatus = $_POST['completion_status'];
    $reason = $_POST['reason'];
    $p_id = $_POST['p_id'];
    $oname = $_POST['o_name'];
    $wname = $_POST['w_name'];
    $name = current(array_filter([$oname, $wname]));

    $insertQuery = "UPDATE manager SET worker_id='$name' WHERE task_id='$taskId'";
    if (mysqli_query($conn, $insertQuery)) {
        $updateQuery = "UPDATE complaints_detail SET status='7' WHERE id='$problem_id'";
        if (mysqli_query($conn, $updateQuery)) {
          
        
            // Update status and task_completion in the complaints_detail table
            $updateComplaintSql = "UPDATE complaints_detail 
                                   SET status = 11, task_completion = ?,reason = ?,date_of_completion = NOW()
                                   WHERE id = (SELECT problem_id FROM manager WHERE task_id = ?)";
            if ($stmt = $conn->prepare($updateComplaintSql)) {
                $stmt->bind_param("ssi", $completionStatus,$reason,$taskId);
                if (!$stmt->execute()) {
                    echo "Update failed: (" . $stmt->errno . ") " . $stmt->error;
                } else {
                    echo "Complaint status and task completion updated successfully.";
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

        }
    }
    // Database connection
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
    exit;
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
    exit;
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

// HOD BACKEND

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
    $fac_id = $_POST['fac_id'];
    $query1 = "SELECT * FROM facultys WHERE id='$fac_id'";
    $query = "SELECT cd.*, faculty.faculty_name, faculty.department, faculty.faculty_contact, faculty.faculty_mail
FROM complaints_detail cd
JOIN faculty ON cd.faculty_id = faculty.faculty_id WHERE cd.id='$student_id1'";
    $query_run = mysqli_query($conn, $query);
    $query_run1 = mysqli_query($conn,$query1);
    $User_data = mysqli_fetch_array($query_run);
    $fac_data = mysqli_fetch_array($query_run1);
    if ($query_run) {
        $res = [
            'status' => 200,
            'message' => 'details Fetch Successfully by id',
            'data' => $User_data,
            'data1'=>$fac_data
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
if (isset($_POST['getimage'])) {
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

//FACULTY BACKEND


session_start();


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
if (isset($_POST['faculty_id'])) {
    $faculty_id = mysqli_real_escape_string($conn, $_POST['faculty_id']);
    $fac_id = mysqli_real_escape_string($conn,$_POST['cfaculty']);
    $fac_id = preg_replace('/\D/', '', $fac_id); 
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
    $query = "INSERT INTO complaints_detail (faculty_id,fac_id,block_venue, venue_name, type_of_problem, problem_description, images, date_of_reg, status) 
              VALUES ('$faculty_id','$fac_id', '$block_venue', '$venue_name', '$type_of_problem', '$problem_description', '$images', '$date_of_reg', '$status')";

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
if (isset($_POST['getimagefac'])) {
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

//  View workers details
if (isset($_POST['get_worker_details'])) {
    $id = $_POST['id'];

    // SQL query to get worker details
    $query = "
    SELECT w.worker_first_name,
     w.worker_mobile
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
        echo json_encode(['status' => 200, 'worker_first_name' => $worker['worker_first_name'], 'worker_mobile' => $worker['worker_mobile']]);
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
            $statusMessage = 'Approved by Principal ';
        } elseif ($status == 9) {
            $statusMessage = 'Approved by Manager ';
        } elseif ($status == 10) {
            $statusMessage = 'worker inprogress';
        } elseif ($status == 11) {
            $statusMessage = 'waiting for approval';
        } elseif ($status == 12) {
            $statusMessage = 'Satisfied by Faculty';
        } elseif ($status == 13) {
            $statusMessage = '';
        } elseif ($status == 14) {
            $statusMessage = 'Sent to manager for rework(Reassign)';
        } elseif ($status == 15) {
            $statusMessage = 'Rework details';
        } elseif ($status == 16) {
            $statusMessage = 'Rejected by manager(Reassign)';
        } elseif ($status == 17) {
            $statusMessage = 'In progress';
        } elseif ($status == 18) {
            $statusMessage = 'Waiting for Approval';
        } elseif ($status == 19) {
            $statusMessage = 'Rejected by Principal';
        } elseif ($status == 20) {
            $statusMessage = 'Rejected principal';
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
if (isset($_POST['get_feedback'])) {

    $id = $_POST['id'];
    $feedback = $_POST['satisfaction_feedback']; // Combined feedback and satisfaction value
    $rating = $_POST['ratings']; // Get rating

    // Validate inputs
    if (empty($id) || empty($feedback)) {
        echo json_encode(['status' => 400, 'message' => 'Problem ID or Feedback is missing']);
        exit;
    }

    // Check if feedback already exists for the given id
    $checkQuery = "SELECT feedback FROM complaints_detail WHERE id = ?";
    $stmt = $conn->prepare($checkQuery);

    if (!$stmt) {
        echo json_encode(['status' => 500, 'message' => 'Prepare statement failed: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->store_result();
    $feedbackExists = $stmt->num_rows > 0; // Check if a row exists for the given id

    $stmt->close();

    // Update feedback if it exists, and set status to 14
    if ($feedbackExists) {
        // Update existing feedback, rating, and set status to 14
        $query = "UPDATE complaints_detail SET feedback = ?, rating = ?, status = 14 WHERE id = ?";
    } else {
        // Insert new feedback (same query logic as update), with status set to 14
        $query = "UPDATE complaints_detail SET feedback = ?, rating = ?, status = 14 WHERE id = ?";
    }

    $stmt = $conn->prepare($query);

    if (!$stmt) {
        echo json_encode(['status' => 500, 'message' => 'Prepare statement failed: ' . $conn->error]);
        exit;
    }

    // Bind parameters including the combined feedback value, rating, and ID
    $stmt->bind_param('sii', $feedback, $rating, $id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 200, 'message' => 'Feedback updated successfully']);
    } else {
        echo json_encode(['status' => 500, 'message' => 'Query failed: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit;
}

$fac_id = $_SESSION['faculty_id'];

if (isset($_POST['fac'])) {
    $sql8 =  "SELECT * FROM facultys WHERE dept=(SELECT department FROM faculty WHERE faculty_id='$fac_id')";
    $result8 = mysqli_query($conn, $sql8);

    $options = '';
    $options .= '<option value="">Select a Faculty</option>';



    while ($row = mysqli_fetch_assoc($result8)) {
        $options .= '<option value="' . $row['id'] . '">' . $row['id'] . ' - ' . $row['name'] . '</option>';

    }
    echo $options;
    exit();  
}

//MANAGER BACKEND 

if (isset($_POST['view_comp'])) {
    $complain_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $fac_id = mysqli_real_escape_string($conn,$_POST['fac_id']);
    $query = "
    SELECT cd.*, faculty.faculty_name, faculty.faculty_contact, faculty.faculty_mail, faculty.department, cd.block_venue
    FROM complaints_detail cd
    JOIN faculty ON cd.faculty_id = faculty.faculty_id
    WHERE cd.id = '$complain_id'
";

    $query_run = mysqli_query($conn, $query);
    $User_data = mysqli_fetch_array($query_run);
    $query1 = "SELECT * FROM facultys WHERE id='$fac_id'";
    $query1_run = mysqli_query($conn,$query1);
    $fac_data = mysqli_fetch_array($query1_run);
    if ($query_run) {
        $res = [
            'status' => 200,
            'message' => 'details Fetch Successfully by id',
            'data' => $User_data,
            'data1'=>$fac_data,
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

//backend for worker details
if (isset($_POST['see_worker_detail'])) {
    $complain_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $id = "SELECT * FROM manager WHERE problem_id='$complain_id'";
    $query_run1 = mysqli_query($conn, $id);
    $row = mysqli_fetch_array($query_run1);
    $worker_id = $row['worker_id'];
    //data only for editing
    $query = "SELECT * FROM worker_details WHERE worker_dept='$worker_id'";
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


//reject reason
if (isset($_POST["reject_complaint"])) {
    try {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $reason = mysqli_real_escape_string($conn, $_POST['feedback']);
        $query = "UPDATE complaints_detail SET feedback = '$reason', status = '20' WHERE id = $id";
        if (mysqli_query($conn, $query)) {
            $res = [
                'status' => 200,

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


//Accept reason
if (isset($_POST['manager_approve'])) {
    $problem_id = $_POST['problem_id'];
    $worker = $_POST['worker_id'];
    $priority = $_POST['priority'];
    $deadline = $_POST["deadline"];

    // Insert into manager table
    $insertQuery = "INSERT INTO manager (problem_id, worker_dept, priority) VALUES ('$problem_id', '$worker', '$priority')";
    if (mysqli_query($conn, $insertQuery)) {
        // Update status in complaints_detail table
        $updateQuery = "UPDATE complaints_detail SET days_to_complete='$deadline' , status='9' WHERE id='$problem_id'";
        if (mysqli_query($conn, $updateQuery)) {
            $response = ['status' => 200, 'message' => 'Complaint accepted and status updated successfully!'];
        } else {
            $response = ['status' => 500, 'message' => 'Failed to update complaint status.'];
        }
    } else {
        $response = ['status' => 500, 'message' => 'Failed to insert data into manager table.'];
    }
    echo json_encode($response);
}


// Check if ID is provided
if (isset($_POST['id'])) {
    $complaint_id = intval($_POST['id']);
    // Prepare SQL query
    $query = "SELECT feedback FROM complaints_detail WHERE id = ? AND status IN ('13', '14')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $complaint_id);
    $stmt->execute();
    $stmt->bind_result($feedback);
    $stmt->fetch();
    $stmt->close();
    // Return the feedback
    echo $feedback;
}

// Handle reply submission for principal's query
if (isset($_POST['submit_comment_reply'])) {
    $task_id = $_POST['task_id'];
    $comment_reply = $_POST['comment_reply'];
    $reply_date = date('Y-m-d'); // Get current date

    // Update the comment_reply and reply_date fields for the corresponding task_id
    $query = "UPDATE manager SET comment_reply=?, reply_date=? WHERE task_id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssi', $comment_reply, $reply_date, $task_id);
    if ($stmt->execute()) {
        $response = ['status' => 200, 'message' => 'Reply submitted successfully!'];
    } else {
        $response = ['status' => 500, 'message' => 'Failed to submit reply.'];
    }
    echo json_encode($response);
}

if (isset($_POST['complaintfeed_id']) && isset($_POST['status'])) {
    $id = $_POST['complaintfeed_id']; // Get the complaint ID from the POST request
    $status = $_POST['status'];
    $current_date = date('Y-m-d'); // Get the current date in the format YYYY-MM-DD

    // Check if a reassign deadline is provided (only when status is 'reassign')
    $reassign_deadline = isset($_POST['reassign_deadline']) ? $_POST['reassign_deadline'] : null;

    // Prepare the SQL query based on the provided status and deadline
    if ($status == 15 && $reassign_deadline) {
        // Status '15' for Reassign, update reassign_date and reassign_deadline
        $sql = "UPDATE complaints_detail SET status='$status', reassign_date='$current_date', days_to_complete='$reassign_deadline' WHERE id='$id'";
    } else {
        // For other statuses, only update status and reassign_date (no reassign_deadline)
        $sql = "UPDATE complaints_detail SET status='$status', reassign_date='$current_date' WHERE id='$id'";
    }

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        echo json_encode([
            'status' => 200,
            'message' => "Status and updates saved successfully."
        ]);
    } else {
        echo json_encode([
            'status' => 500,
            'message' => "Error updating status: " . mysqli_error($conn)
        ]);
    }
}

if (isset($_POST['get_aimage'])) {
    // Get the problem_id from POST request
    $problem_id = isset($_POST['problem2_id']) ? $_POST['problem2_id'] : '';

    // Validate problem_id
    if (empty($problem_id)) {
        echo json_encode(['status' => 400, 'message' => 'Problem ID not provided']);
        exit;
    }

    // Log the received problem_id for debugging
    error_log("Problem ID received: " . $problem_id);

    // First, fetch the task_id from the manager table using the problem_id
    $query = "SELECT task_id FROM manager WHERE problem_id = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        echo json_encode(['status' => 500, 'message' => 'Prepare statement failed: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param('i', $problem_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $task_id = $row['task_id'];

        // Log the fetched task_id for debugging
        error_log("Task ID fetched: " . $task_id);

        $stmt->close();

        // Now, fetch the after_photo using the retrieved task_id
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
            $image_filename = basename($row['after_photo']); // Get the filename
            $image_path = 'imgafter/' . $image_filename; // Path to the image

            echo json_encode(['status' => 200, 'data' => ['after_photo' => $image_path]]);
        } else {
            echo json_encode(['status' => 404, 'message' => 'No image found for the provided task ID']);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 404, 'message' => 'No task found for the provided problem ID']);
    }
}

if (isset($_POST['get_image_manager'])) {
    $problem_id = isset($_POST['problem_id']) ? $_POST['problem_id'] : ''; // Ensure problem_id is set
    // Validate problem_id
    if (empty($problem_id)) {
        echo json_encode(['status' => 400, 'message' => 'Problem ID not provided']);
        exit;
    }
    // Query to fetch the image based on problem_id
    $query = "SELECT images FROM complaints_detail WHERE id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo json_encode(['status' => 500, 'message' => 'Prepare statement failed: ' . $conn->error]);
        exit;
    }
    $stmt->bind_param('i', $problem_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $response = json_encode(['status' => 200, 'data' => ['images' => $row['images']]]);
        // Log response to debug if the JSON is correctly formed
        error_log("Response: " . $response);
        echo $response;
    } else {
        // Return 404 if no image is found for the given problem_id
        echo json_encode(['status' => 404, 'message' => 'Image not found']);
    }
    $stmt->close();
    $conn->close();
    exit;
}


if (isset($_POST['facfeedview'])) {
    $student_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $query = "SELECT * FROM complaints_detail WHERE id=$student_id and status IN ('13', '14')";
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


//Accept reason
if (isset($_POST['principal_complaint'])) {
    $problem_id = $_POST['id'];
    $reason = $_POST['reason'];
    /*     $principal_approval = isset($_POST['principal_approval']) ? 6 : 7;
    $reason = isset($_POST['reason11']) ? $_POST['reason11'] : ''; */
    // Insert into manager table
    $insertQuery = "INSERT INTO comments (problem_id, reason) VALUES ('$problem_id','$reason')";
    if (mysqli_query($conn, $insertQuery)) {
        // Update status in complaints_detail table
        $updateQuery = "UPDATE complaints_detail SET status='6' WHERE id='$problem_id'";
        if (mysqli_query($conn, $updateQuery)) {
            $response = ['status' => 200, 'message' => 'Complaint accepted and status updated successfully!'];
            /*   $updateQuery7 = "INSERT INTO comments (problem_id, reason) VALUES ('$problem_id','$reason') ";
            if (mysqli_query($conn, $updateQuery7)) {
                $response = ['status' => 200, 'message' => 'Complaint accepted and status updated successfully!'];
            } else {
                $response = ['status' => 500, 'message' => 'Failed to update comments table.'];
            } */
        } else {
            $response = ['status' => 500, 'message' => 'Failed to update complaint status.'];
        }
    } else {
        $response = ['status' => 500, 'message' => 'Failed to insert data into manager table.'];
    }
    echo json_encode($response);
}


//reject reason from principal
if (isset($_POST['get_reject_reason'])) {
    $complain_id = mysqli_real_escape_string($conn, $_POST['problem_id']);
    $query = "SELECT feedback FROM complaints_detail WHERE id='$complain_id'";
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

//worker phone number

if (isset($_POST['get_worker_phone'])) {
    $complain_id = mysqli_real_escape_string($conn, $_POST['prblm_id']);
    $query = "
    SELECT w.* 
    FROM complaints_detail cd
    INNER JOIN manager m ON cd.id = m.problem_id
    INNER JOIN worker_details w ON m.worker_id = w.worker_id
    WHERE cd.id = '$complain_id'
";
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

//REquirement Reject

if (isset($_POST["hod_reject"])) {
    $id = $_POST["id"];
    $reason = $_POST["feedback"];

    $query = "UPDATE products SET status = 7 , reason = '$reason' WHERE id = '$id'";
    $run = mysqli_query($conn, $query);
    if ($run) {
        $res = [
            "status" => 200,
            "msg" => "Product rejected successfully"
        ];
        echo json_encode($res);
    }
}

if (isset($_POST["infra_reject"])) {
    $id = $_POST["id"];
    $reason = $_POST["feedback"];

    $query = "UPDATE products SET status = 6 , reason = '$reason' WHERE id = '$id'";
    $run = mysqli_query($conn, $query);
    if ($run) {
        $res = [
            "status" => 200,
            "msg" => "Product rejected successfully"
        ];
        echo json_encode($res);
    }
}

if (isset($_POST['form1'])) {
    $name = $_POST['w_name'];
    $contact = $_POST['w_phone'];
    $gender = $_POST['w_gender'];
    $dept = $_POST['w_dept'];
    $role = $_POST['w_role'];

    $dept_prefix = strtoupper(substr($dept, 0, 3)); 

    $checkQuery = "SELECT SUBSTRING(worker_id, 4) AS id_number FROM worker_details 
                   WHERE worker_id LIKE '$dept_prefix%' 
                   ORDER BY CAST(SUBSTRING(worker_id, 4) AS UNSIGNED) DESC LIMIT 1";

    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $number = intval($row['id_number']) + 1; 
    } else {
        $number = 1;
    }

    $worker_id = $dept_prefix . str_pad($number, 2, '0', STR_PAD_LEFT);

    $insertQuery = "INSERT INTO worker_details (worker_id, worker_first_name, worker_dept, worker_mobile, worker_gender,usertype) 
                    VALUES ('$worker_id', '$name', '$dept', '$contact', '$gender','$role')";

    if (mysqli_query($conn, $insertQuery)) {
        echo "Success: Worker added with ID $worker_id!";
        exit;
    } else {
        echo "Error: Could not insert worker details.";
        exit;
    }
}

//dead line extend
if (isset($_POST["extend_deadlinedate"])) {
    try {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $dead_date = mysqli_real_escape_string($conn, $_POST['extend_deadline']);
        $reason = mysqli_real_escape_string($conn, $_POST['reason']);
        $query = "UPDATE complaints_detail SET days_to_complete = '$dead_date',extend_date = '1' ,extend_reason = '$reason'  WHERE id = $id";
        if (mysqli_query($conn, $query)) {
            $res = [
                'status' => 200,
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

//reassign_complaint
if (isset($_POST["reassign_complaint"])) {
    try {
        $id = mysqli_real_escape_string($conn, $_POST['user_id']);
        $worker_dept = mysqli_real_escape_string($conn, $_POST['worker']);
        $query = "UPDATE manager SET worker_dept = '$worker_dept'  WHERE problem_id = $id";
        if (mysqli_query($conn, $query)) {
            $res = [
                'status' => 200,
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

//Done_complaint
if (isset($_POST["manager_feedbacks"])) {
    try {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $feedback = mysqli_real_escape_string($conn, $_POST['feedback12']);
        $rating = mysqli_real_escape_string($conn, $_POST['ratings']);
        $query = "UPDATE complaints_detail SET mfeedback = '$feedback', mrating = '$rating'  WHERE id = $id";
        if (mysqli_query($conn, $query)) {
            $res = [
                'status' => 200,
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

?>
