<?php
session_start();
include('db.php'); // Include the database connection file

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $faculty_id = mysqli_real_escape_string($conn, $_POST['faculty_id']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $faculty_dept = mysqli_real_escape_string($conn, $_POST['department']); // Get faculty department from form data

    // Query to check if faculty ID and password match
    $query = "SELECT * FROM faculty_details WHERE faculty_id = '$faculty_id' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    $user = mysqli_fetch_array($result);

    if($user['role']=='infra'){
        $_SESSION['faculty_dept'] = $faculty_dept;
        $_SESSION['faculty_id'] = $faculty_id;
        header("Location: facinfra.php"); // Redirect to the infrastructure completedtable page
        exit();
    }

    elseif($user['role']=='hod'){
        $_SESSION['faculty_dept'] = $faculty_dept;
        $_SESSION['faculty_id'] = $faculty_id;
        header("Location: hod.php"); // Redirect to the infrastructure completedtable page
        exit();
    }


elseif($user['role']=='staff'){
    // If user exists
    if (mysqli_num_rows($result) == 1) {
        $_SESSION['faculty_id'] = $faculty_id; // Store faculty ID in session
        
        header("Location: completedtable.php"); // Redirect to the completedtable page
        exit();
    } else {
        // Invalid credentials
        echo "<script>alert('Invalid Faculty ID or Password. Please try again.'); window.location.href='flogin.php';</script>";
    }
}
} else {
    header("Location: flogin.php"); // Redirect back to login page if accessed without form submission
    exit();
}

$fac_id = $_SESSION['faculty_id'];

if(isset($_POST['fac'])) {
    $sql8 =  "SELECT * FROM faculty WHERE dept=(SELECT department FROM faculty_details WHERE faculty_id='$fac_id')";
    $result8 = mysqli_query($conn, $sql8);

    $options = '';
    $options .= '<option value="">Select a Faculty</option>';



    while ($row = mysqli_fetch_assoc($result8)) {
        $options .= '<option value="' . $row['id'] . '">' . $row['id'] . ' - ' . $row['name'] . '</option>';

    }


    echo $options;
    exit();  
}
