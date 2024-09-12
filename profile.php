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
    <title>Worker Profile Form</title>
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="assets/libs/select2/dist/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="assets/libs/jquery-minicolors/jquery.minicolors.css">
    <link rel="stylesheet" type="text/css" href="assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" type="text/css" href="assets/libs/quill/dist/quill.snow.css">
    <link href="dist/css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
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
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                    <a class="navbar-brand" href="index.html">
                    <span class="logo-text">
                    <img src="assets/images/mkcenavlogo.png" alt="homepage" class="light-logo" />
                </span>
                    </a>
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
                </div>
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
                    </ul>
                    <ul class="navbar-nav float-right">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="assets/images/users/1.jpg" alt="user" class="rounded-circle" width="31"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated">
                                <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
                                <div class="dropdown-divider"></div>
                            </div>
                        </li>
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
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="index.php" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="profile.php" aria-expanded="false"><i class="mdi mdi-account-circle"></i><span class="hide-menu">Profile</span></a></li>
                        <li class="sidebar-item"> <a id="view-work-task-history" class="sidebar-link waves-effect waves-dark sidebar-link" href="worker_taskhistory.php" aria-expanded="false"><i class="mdi mdi-blur-linear"></i><span class="hide-menu">Task History</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="worker_helpline.html" aria-expanded="false"><i class="mdi mdi-phone"></i><span class="hide-menu">Helpline</span></a></li>
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
                        <h4 class="page-title">Form Basic</h4>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
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
            <?php
            // Start the session


            // Database connection details
            $servername = "localhost";
            $username = "root";  // Replace with your DB username
            $password = "";      // Replace with your DB password
            $dbname = "complaints";  // Your database name

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Initialize variables
            $fname = $lname = $gender = $worker_id = $department = $mobile = $email = "";
            $form_submitted = false;
            $target_file = "";

            // Handle form submission
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                try {
                    if (isset($_POST['submit'])) {
                        $fname = $_POST['fname'];
                        $lname = $_POST['lname'];
                        $gender = $_POST['gender'];
                        $worker_id = $_POST['worker_id'];
                        $department = $_POST['department'];
                        $mobile = $_POST['mobile'];
                        $email = $_POST['email'];

                        // Profile photo file upload handling
                        $target_dir = "uploads/";
                        $file_name = basename($_FILES["pphoto"]["name"]);
                        $target_file = $target_dir . $file_name;
                        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                        // Check if image file is a valid image format
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

                        // Insert data into 'worker' table
                        $sql_insert = "INSERT INTO worker (fname, lname, gender, worker_id, department, mobile, email, photo) 
                    VALUES ('$fname', '$lname', '$gender', '$worker_id', '$department', '$mobile', '$email', '$target_file')";

                        if ($conn->query($sql_insert) === TRUE) {
                            // Mark form as submitted
                            $_SESSION['form_submitted'] = true;

                            // Redirect to avoid form resubmission on refresh
                            header("Location: profile.php");
                            exit();
                        } else {
                            throw new Exception('Query Failed: ' . $conn->error);
                        }
                    }

                    // Check if user data was deleted
                    if (isset($_POST['delete_in_db'])) {
                        // Delete the data from the database
                        $sql_delete = "DELETE FROM worker";
                        if ($conn->query($sql_delete) === TRUE) {
                            // Clear session data and reset form
                            session_unset();
                            session_destroy();
                            $form_submitted = false;
                            $target_file = ""; // Clear the target file path
                            // Redirect to reset form
                            header("Location: profile.php");
                            exit();
                        } else {
                            throw new Exception('Error deleting record: ' . $conn->error);
                        }
                    }
                } catch (Exception $e) {
                    $res = [
                        'status' => 500,
                        'message' => 'Error: ' . $e->getMessage()
                    ];
                    echo json_encode($res);
                }
            }

            // Check if there is existing data in the 'worker' table
            $sql_check = "SELECT * FROM worker LIMIT 1";
            $result = $conn->query($sql_check);

            if ($result->num_rows > 0) {
                // If a record exists, fetch the data and keep the form read-only
                $row = $result->fetch_assoc();
                $fname = $row['fname'];
                $lname = $row['lname'];
                $gender = $row['gender'];
                $worker_id = $row['worker_id'];
                $department = $row['department'];
                $mobile = $row['mobile'];
                $email = $row['email'];
                $target_file = $row['photo']; // Store image path for display
                $form_submitted = true;
            }

            // Close the connection
            $conn->close();
            ?>

            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="container mt-5">
                    <div class="tab-content tabcontent-border">
                        <div class="tab-pane active" id="home" role="tabpanel">
                            <form id="basic" class="needs-validation" novalidate="" action="profile.php" method="POST" enctype="multipart/form-data">
                                <div id="errorbasic" class="alert alert-warning d-none"></div>
                                <div class="card-header">
                                    <h4>Personal Information</h4>
                                </div>
                                <br><br>
                                <!-- Section to display the uploaded image -->
                                <?php if ($form_submitted && !empty($target_file)): ?>
                                    <center>
                                        <div class="form-group col-md-4">
                                            <label for="worker_photo">Worker Photo:</label><br>
                                            <img src="<?php echo $row['photo']; ?>" alt="Worker Photo" width="100">
                                        </div>
                                    </center>
                                    <br><br>
                                <?php endif; ?>
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label for="fname">First Name *</label>
                                        <input type="text" name="fname" class="form-control" id="fname"
                                            placeholder="First Name" value="<?php echo htmlspecialchars($fname); ?>"
                                            <?php if ($form_submitted) echo 'readonly'; ?> required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="lname">Last Name *</label>
                                        <input type="text" class="form-control" name="lname" id="lname"
                                            placeholder="Last Name" value="<?php echo htmlspecialchars($lname); ?>"
                                            <?php if ($form_submitted) echo 'readonly'; ?> required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="gender">Gender *</label>
                                        <select class="select2 form-control custom-select" name="gender" id="gender"
                                            <?php if ($form_submitted) echo 'disabled'; ?> required>
                                            <option value="">Select...</option>
                                            <option value="Male" <?php if ($gender == "Male") echo "selected"; ?>>Male</option>
                                            <option value="Female" <?php if ($gender == "Female") echo "selected"; ?>>Female</option>
                                            <option value="Transgender" <?php if ($gender == "Transgender") echo "selected"; ?>>Transgender</option>
                                        </select>
                                        <div class="invalid-feedback">Please select gender.</div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                        <label for="worker_id">Worker ID *</label>
                                        <input type="text" class="form-control" name="worker_id" id="worker_id"
                                            placeholder="Enter Worker ID" value="<?php echo htmlspecialchars($worker_id); ?>"
                                            <?php if ($form_submitted) echo 'readonly'; ?> required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="department">Department *</label>
                                        <select class="select2 form-control custom-select" name="department" id="dept"
                                            <?php if ($form_submitted) echo 'disabled'; ?> required>
                                            <option value="">Select...</option>
                                            <option value="Electrical Work" <?php if ($department == "Electrical Work") echo "selected"; ?>>Electrical Work</option>
                                            <option value="Carpenter Work" <?php if ($department == "Carpenter Work") echo "selected"; ?>>Carpenter Work</option>
                                            <option value="Civil Work" <?php if ($department == "Civil Work") echo "selected"; ?>>Civil Work</option>
                                            <option value="Partition Work" <?php if ($department == "Partition Work") echo "selected"; ?>>Partition Work</option>
                                            <option value="IT infra work" <?php if ($department == "IT infra work") echo "selected"; ?>>IT infra work</option>
                                            <option value="Plumbing work" <?php if ($department == "Plumbing work") echo "selected"; ?>>Plumbing work</option>
                                        </select>
                                        <div class="invalid-feedback">Please select department.</div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label for="mobile">Mobile Number *</label>
                                        <input type="text" class="form-control" name="mobile" id="mobile"
                                            placeholder="Enter Mobile Number" value="<?php echo htmlspecialchars($mobile); ?>"
                                            <?php if ($form_submitted) echo 'readonly'; ?> required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="email">Email ID *</label>
                                        <input type="email" class="form-control" name="email" id="email"
                                            placeholder="Enter Email ID" value="<?php echo htmlspecialchars($email); ?>"
                                            <?php if ($form_submitted) echo 'readonly'; ?> required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label for="pphoto">Profile Photo *</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="pphoto" id="pphoto"
                                                <?php if ($form_submitted) echo 'disabled'; ?> required>
                                            <label class="custom-file-label" for="pphoto">Choose file</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Add this script to update the file input label -->
                                <script>
                                    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
                                        var fileName = document.getElementById("pphoto").files[0].name;
                                        var nextSibling = e.target.nextElementSibling;
                                        nextSibling.innerText = fileName;
                                    });
                                </script>

                                <br>
                                <button type="submit" name="submit" class="btn btn-primary" id="submitBtn"
                                    <?php if ($form_submitted) echo 'disabled'; ?>>Submit</button>
                            </form>
                            <!-- Button to delete data and reset form -->
                            <?php if ($form_submitted): ?>
                                <form action="profile.php" method="POST" class="mt-3">
                                    <input type="hidden" name="delete_in_db" value="1">
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Page Content -->
                <!-- ============================================================== -->
            </div>

            <!-- ============================================================== -->
            <!-- End Page wrapper  -->
            <!-- ============================================================== -->

            <footer class="footer text-center">
                2024 © M.Kumarasamy College of Engineering All Rights Reserved.
                Developed and Maintained by Technology Innovation Hub.
            </footer>
        </div>
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
        <!-- This Page JS -->
        <script src="assets/libs/inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
        <script src="dist/js/pages/mask/mask.init.js"></script>
        <script src="assets/libs/select2/dist/js/select2.full.min.js"></script>
        <script src="assets/libs/select2/dist/js/select2.min.js"></script>
        <script src="assets/libs/jquery-asColor/dist/jquery-asColor.min.js"></script>
        <script src="assets/libs/jquery-asGradient/dist/jquery-asGradient.js"></script>
        <script src="assets/libs/jquery-asColorPicker/dist/jquery-asColorPicker.min.js"></script>
        <script src="assets/libs/jquery-minicolors/jquery.minicolors.min.js"></script>
        <script src="assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
        <script src="assets/libs/quill/dist/quill.min.js"></script>
    </div>
    <script>
        // Form Validation
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var form = document.getElementById('basic');
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
</body>

</html>