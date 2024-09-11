<?php
include('db.php'); // Include the configuration file

if (isset($_POST['login'])) {
    $faculty_id = mysqli_real_escape_string($conn, $_POST['faculty_id']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Validate login (assuming you have a faculty table with passwords)
    $query = "SELECT * FROM faculty_login WHERE faculty_id='$faculty_id' AND password='$password'";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $_SESSION['faculty_id'] = $faculty_id; // Store faculty ID in session
        header("Location: completedtable.php"); // Redirect to the table page
        exit();
    } else {
        $error = "Invalid faculty ID or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Faculty Login</title>
</head>
<body>
    <h2>Faculty Login</h2>

    <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>

    <form method="POST" action="">
        <label for="faculty_id">Faculty ID:</label>
        <input type="text" name="faculty_id" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br><br>

        <button type="submit" name="login">Login</button>
    </form>
</body>
</html>
