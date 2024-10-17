<?php
// Database connection
$host = 'localhost';
$dbname = 'workers_db';
$username = 'root'; // use your DB username
$password = ''; // use your DB password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Initialize variables
$name = $worker_id = $department = $mail = $phone = $gender = $worktype = "";
$worker_exists = false;
$target_file = "";

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $worker_id = $_POST['worker_id'];

    // Check if the worker_id already exists in the database
    $check_sql = "SELECT * FROM workers WHERE worker_id = ?";
    $stmt = $pdo->prepare($check_sql);
    $stmt->execute([$worker_id]);
    $worker = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($worker) {
        // Worker exists, fetch the details
        $name = $worker['name'];
        $gender = $worker['gender'];
        $department = $worker['department'];
        $worktype = $worker['worktype'];
        $mail = $worker['mail'];
        $phone = $worker['phone'];
        $target_file = $worker['photo']; // Store image path for display
        $worker_exists = true;
    } else {
        // If worker doesn't exist, insert new details
        $name = $_POST['name'];
        $gender = $_POST['gender'];
        $department = $_POST['department'];
        $worktype = $_POST['worktype'];
        $mail = $_POST['mail'];
        $phone = $_POST['phone'];

        // Check if a file is uploaded
        if (isset($_FILES['pphoto']) && $_FILES['pphoto']['error'] == UPLOAD_ERR_OK) {
            $target_dir = "uploads/";
            $file_name = basename($_FILES["pphoto"]["name"]);
            $target_file = $target_dir . $file_name;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if the file is a valid image
            $check = getimagesize($_FILES["pphoto"]["tmp_name"]);
            if ($check === false) {
                throw new Exception('File is not an image.');
            }

            // Allow certain file formats
            $allowed_formats = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($imageFileType, $allowed_formats)) {
                throw new Exception('Only JPG, JPEG, PNG & GIF files are allowed.');
            }

            // Upload image to the server
            if (!move_uploaded_file($_FILES["pphoto"]["tmp_name"], $target_file)) {
                throw new Exception('Failed to upload image.');
            }
        } else {
            // Handle the case where no file is uploaded or there was an error during file upload
            throw new Exception('No file uploaded or file upload error.');
        }

        // Insert the worker details into the database, including the image path
        $sql = "INSERT INTO workers (name, gender, worker_id, department, worktype, mail, phone, photo) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $gender, $worker_id, $department, $worktype, $mail, $phone, $target_file]);

        // Redirect to avoid form re-submission on page refresh
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>



<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title>CMS</title>
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="assets/extra-libs/multicheck/multicheck.css">
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="dist/css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <style>
        label {
            font-size: 18px;
        }

        input,
        select {
            width: 300px;
            height: 29px;
        }
    </style>

</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin5">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                            class="ti-menu ti-close"></i></a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="index.html">
                        <!-- Logo icon -->

                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span class="logo-text">
                            <!-- dark Logo text -->
                            <img src="assets/images/mkcenavlogo.png" alt="homepage" class="light-logo" />

                        </span>
                        <!-- Logo icon -->
                        <!-- <b class="logo-icon"> -->
                        <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                        <!-- Dark Logo icon -->
                        <!-- <img src="assets/images/logo-text.png" alt="homepage" class="light-logo" /> -->

                        <!-- </b> -->
                        <!--End Logo icon -->
                    </a>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                        data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                            class="ti-more"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block"><a
                                class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"
                                data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
                        <!-- ============================================================== -->
                        <!-- create new -->
                        <!-- ============================================================== -->

                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->

                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-right">
                        <!-- ============================================================== -->
                        <!-- Comment -->
                        <!-- ============================================================== -->

                        <!-- ============================================================== -->
                        <!-- End Comment -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Messages -->
                        <!-- ============================================================== -->

                        <!-- ============================================================== -->
                        <!-- End Messages -->
                        <!-- ============================================================== -->

                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href=""
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                    src="assets/images/users/1.jpg" alt="user" class="rounded-circle" width="31"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated">

                                <a class="dropdown-item" href="javascript:void(0)"><i
                                        class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
                                <!--  <div class="dropdown-divider"></div>-->

                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin5">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav" class="p-t-30">
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="index.php" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span
                                    class="hide-menu">Dashboard</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="profile.php" aria-expanded="false"><i class="mdi mdi-account-circle"></i><span
                                    class="hide-menu">Profile</span></a></li>
                        <li class="sidebar-item"> <a id="view-work-task-history"
                                class="sidebar-link waves-effect waves-dark sidebar-link" href="worker_taskhistory.php"
                                aria-expanded="false"><i class="mdi mdi-blur-linear"></i><span class="hide-menu">Task
                                    History</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="worker_helpline.html" aria-expanded="false"><i class="mdi mdi-phone"></i><span
                                    class="hide-menu">Helpline</span></a></li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h2 class="page-title">Worker Details</h2>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Library</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->

                <form method="POST" action="" enctype="multipart/form-data">
                    <center>
                        <?php if ($target_file) { ?>
                            <img src="<?php echo $target_file; ?>" alt="Profile Photo"
                                style="max-width: 100px; max-height: 100px; border-radius: 50%;">
                        <?php } ?>
                    </center>
                    <br><br>
                    <div class="form-row">

                        <div class="col-4 ">

                            <label for="name">Name:</label><br>
                            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>"
                                <?php if ($name)
                                    echo 'disabled'; ?> required>
                        </div>
                        <div class="col-4">
                            <label for="gender">Gender:</label><br>
                            <select id="gender" name="gender" required>
                                <option value="Select" <?php if ($gender == '')
                                    echo 'selected'; ?>>Select</option>
                                <option value="Male" <?php if ($gender == 'Male')
                                    echo 'selected'; ?>>Male</option>
                                <option value="Female" <?php if ($gender == 'Female')
                                    echo 'selected'; ?>>Female</option>
                                <option value="Other" <?php if ($gender == 'Other')
                                    echo 'selected'; ?>>Other</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="worker_id">Worker ID:</label><br>
                            <input type="text" id="worker_id" name="worker_id"
                                value="<?php echo htmlspecialchars($worker_id); ?>" <?php if ($worker_id)
                                       echo 'disabled'; ?> required>
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-4">
                            <label for="department">Department:</label>
                            <select id="department" name="department" required>
                                <option value="Select" <?php if ($department == '')
                                    echo 'selected'; ?>>Select</option>
                                <option value="Electrical Work" <?php if ($department == 'Electrical Work')
                                    echo 'selected'; ?>>Electrical Work</option>
                                <option value="Carpenter Work" <?php if ($department == 'Carpenter Work')
                                    echo 'selected'; ?>>Carpenter Work</option>
                                <option value="Civil Work" <?php if ($department == 'Civil Work')
                                    echo 'selected'; ?>>
                                    Civil Work</option>
                                <option value="Partition Work" <?php if ($department == 'Partition Work')
                                    echo 'selected'; ?>>Partition Work</option>
                                <option value="IT Infra Work" <?php if ($department == 'IT Infra Work')
                                    echo 'selected'; ?>>IT Infra Work</option>
                                <option value="Plumbing Work" <?php if ($department == 'Plumbing Work')
                                    echo 'selected'; ?>>Plumbing Work</option>
                                <option value="Other" <?php if ($department == 'Other')
                                    echo 'selected'; ?>>Other</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="worktype">Work Type:</label>
                            <select id="worktype" name="worktype" required>
                                <option value="Select" <?php if ($worktype == '')
                                    echo 'selected'; ?>>Select</option>
                                <option value="Full Time" <?php if ($worktype == 'Full Time')
                                    echo 'selected'; ?>>Full
                                    Time</option>
                                <option value="Part Time" <?php if ($worktype == 'Part Time')
                                    echo 'selected'; ?>>Part
                                    Time</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="mail">Mail:</label><br>
                            <input type="email" id="mail" name="mail" value="<?php echo htmlspecialchars($mail); ?>"
                                <?php if ($mail)
                                    echo 'disabled'; ?> required>
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-6">

                            <label for="phone">Phone Number:</label><br>
                            <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>"
                                <?php if ($phone)
                                    echo 'disabled'; ?> required>

                        </div>
                        <div class="col-6">

                            <label for="pphoto">Profile Photo:</label><br>
                            <input type="file" id="pphoto" name="pphoto" accept="image/*" required><br>

                        </div>
                    </div><br><br>

                    <?php if (!$name) { // Show the submit button only if no data exists ?>
                        <button type="submit" class="btn btn-success" value="Submit">Submit</button>
                    <?php } ?>
                </form>

                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                All Rights Reserved by Matrix-admin. Designed and Developed by <a
                    href="https://wrappixel.com">WrapPixel</a>.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="dist/js/custom.min.js"></script>
    <!-- this page js -->
    <script src="assets/extra-libs/multicheck/datatable-checkbox-init.js"></script>
    <script src="assets/extra-libs/multicheck/jquery.multicheck.js"></script>
    <script src="assets/extra-libs/DataTables/datatables.min.js"></script>
    <script>
        /****************************************
         *       Basic Table                   *
         ****************************************/
        $('#zero_config').DataTable();
    </script>

</body>

</html>