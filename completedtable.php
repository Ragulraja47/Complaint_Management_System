<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['faculty_id'])) {
    // Redirect to login page if not logged in
    header("Location: flogin.php");
    exit();
}

include('db.php'); // Include the configuration file

// Fetch complaints only for this faculty (if necessary)
$faculty_id = $_SESSION['faculty_id']; // Assuming 'faculty_id' is stored in session

$query = "SELECT * FROM complaints_detail WHERE faculty_id = '$faculty_id'";
$result = mysqli_query($conn, $query);

$sql5 = "SELECT * FROM complaints_detail WHERE status IN (1,2,4,6) AND faculty_id = '$faculty_id'";
$sql1 = "SELECT * FROM complaints_detail WHERE status IN (7,10,11,15,17,18) AND faculty_id = '$faculty_id'";
$sql2 = "SELECT * FROM complaints_detail WHERE status = 16 AND faculty_id = '$faculty_id'";
$sql3 = "SELECT * FROM complaints_detail WHERE status IN (3,5,16,19,20) AND faculty_id = '$faculty_id'";
$sql4 = "SELECT * FROM complaints_detail WHERE status = 15 AND faculty_id = '$faculty_id'";

$result5 = mysqli_query($conn, $sql5);
$result1 = mysqli_query($conn, $sql1);
$result2 = mysqli_query($conn, $sql2);
$result3 = mysqli_query($conn, $sql3);
$result4 = mysqli_query($conn, $sql4);
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
    <title>Faculty Login</title>
    <!-- Custom CSS -->
    <link href="assets/libs/flot/css/float-chart.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9] >
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <style>
        th {
            background-color: #7460ee;
            background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);
            color: white
        }

        .circle-container {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 30px 0;
        }

        .circle {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            display: block;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .circle h1 {
            text-align: center;
            justify-content: center;
            display: block;
            align-items: center;

        }


        .circle1 {
            background-color: #3498db;
            /* Blue */
        }

        .circle2 {
            background-color: #e74c3c;
            /* Orange */
        }

        .circle3 {
            background-color: #2ecc71;
            /* Green */
        }

        .circle4 {
            background-color: #f1c40f;
            /* Purple */
        }

        .circle>h5 {
            color: white;
            margin: 0;
            text-align: center;
        }

        .border-animation {
            position: absolute;
            top: -25px;
            left: -25px;
            width: 200px;
            height: 200px;
            border: 5px dotted transparent;
            border-top-color: #ff5733;
            border-right-color: #33ff57;
            border-bottom-color: #3357ff;
            border-left-color: #f1c40f;
            border-radius: 50%;
            animation: rotateBorder 4s linear infinite;
        }

        .circle-container:hover .border-animation {
            border-style: solid;
        }

        @keyframes rotateBorder {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }



        .btn span {
            height: 100%;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            transition: all .4s ease;
        }

        button svg {
            width: 1.25rem;
            height: 1.25rem;
        }

        .btn span:nth-child(2),
        .btn span:nth-child(3) {
            position: absolute;
            top: 40px;
            color: #fff;
        }

        .btn span:nth-child(2) {
            background-color: #488aec;
        }

        .btn span:nth-child(3) {
            background-color: #488aec;
        }

        .btn:hover {
            box-shadow: 0 10px 15px -3px #488aec4f, 0 4px 6px -2px #488aec17;
        }

        .btn:hover span:nth-child(2),
        .btn:focus span:nth-child(3) {
            top: 0;
        }

        .btn:focus {
            box-shadow: none;
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
                        <b class="logo-icon p-l-8">
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="assets/images/mkce.png" alt="homepage" class="light-logo" />
                        </b>
                        <!--End Logo icon -->
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

                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-right">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href=""
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                    src="assets/images/users/1.jpg" alt="user" class="rounded-circle" width="31"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated">
                                <a href="logout.php" class="btn btn-danger">Logout</a>

                                <div class="dropdown-divider"></div>
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
                    <ul id="sidebarnav" class="p-t-30 in">
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link active"
                                href="index.html" aria-expanded="false"><img src="assets/images/dashboard.png"
                                    class="custom-svg-icon" alt="Dashboard Icon"><span
                                    class="hide-menu">&nbsp;Dashboard</span></a></li>
                        
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Edit Profile</h4>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Profile Information</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body wizard-content">
                        <h4 class="card-title">Work Information</h4>
                        <h6 class="card-subtitle"></h6>
                        <div class="card">
                            <ul class="nav nav-tabs mb-3" role="tablist">
                                <li class="nav-item"> <a class="nav-link active show" data-toggle="tab"
                                        href="#dashboard" role="tab" aria-selected="true"><span
                                            class="hidden-sm-up"></span> <span class="hidden-xs-down"><i
                                                class="bi-person"></i><b>Dashboard</b></span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#home" role="tab"
                                        aria-selected="false"><span class="hidden-sm-up"></span> <span
                                            class="hidden-xs-down"><i class="bi bi-people-fill"></i><b>Pending
                                                work</b></span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#inprogress"
                                        role="tab" aria-selected="false"><span class="hidden-sm-up"></span> <span
                                            class="hidden-xs-down"><i class="bi bi-people-fill"></i><b>Work-In
                                                Progress</b></span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#completed"
                                        role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down"><i
                                                class="bi bi-house-door-fill"></i><b>Completed Work</b></span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#parents"
                                        role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down"><i
                                                class="bi bi-house-door-fill"></i><b>Rejected Work</b></span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#reassign"
                                        role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down"><i
                                                class="bi bi-house-door-fill"></i><b>Reassigned Work</b></span></a> </li>
                            </ul>

                            <div class="tab-content tabcontent-border">
                                <!-----------------------------------DashBoard---------------------------------------->
                                <div class="tab-pane p-20 active show" id="dashboard" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12">
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="circle-container">
                                                    <div class="border-animation"></div>
                                                    <div class="circle circle1">
                                                        <div style="padding-top: 20px;">
                                                            <h1 class="font-light text-white">
                                                                <?php $query1 = "SELECT COUNT(*) as total FROM complaints_detail WHERE status IN (1,2,3,4,5,6,7,10,11,13,14,15,16,17,18,19) AND faculty_id = '$faculty_id'";
                                                                $output1 = mysqli_query($conn, $query1);
                                                                $row1 = mysqli_fetch_assoc($output1);
                                                                $totalCount = $row1['total'];
                                                                echo $totalCount;
                                                                ?>
                                                            </h1>
                                                        </div>
                                                        <h5>Total Complaints</h5>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="d-flex flex-column align-items-center">
                                                <div class="circle-container">
                                                    <div class="border-animation"></div>
                                                    <div class="circle circle3">
                                                        <div style="padding-top: 20px;">
                                                            <h1 class="font-light text-white">
                                                                <?php $query3 = "SELECT COUNT(*) as progress FROM complaints_detail WHERE status IN (7,10,11,15,17) AND faculty_id = '$faculty_id'";
                                                                $output3 = mysqli_query($conn, $query3);
                                                                $row3 = mysqli_fetch_assoc($output3);
                                                                $progressCount = $row3['progress'];
                                                                echo $progressCount;
                                                                ?>
                                                            </h1>
                                                        </div>
                                                        <h5>Progress</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="circle-container">
                                                    <div class="border-animation"></div>
                                                    <div class="circle circle2">
                                                        <div style="padding-top: 20px;">
                                                            <h1 class="font-light text-white">
                                                                <?php $query2 = "SELECT COUNT(*) as pending FROM complaints_detail WHERE status IN (1,2,4,6) AND faculty_id = '$faculty_id'";
                                                                $output2 = mysqli_query($conn, $query2);
                                                                $row2 = mysqli_fetch_assoc($output2);
                                                                $pendingCount = $row2['pending'];
                                                                echo $pendingCount;
                                                                ?>
                                                            </h1>
                                                        </div>
                                                        <h5>Pending</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="circle-container">
                                                    <div class="border-animation"></div>
                                                    <div class="circle circle4">
                                                        <div style="padding-top: 20px;">
                                                            <h1 class="font-light text-white">
                                                                <?php $query4 = "SELECT COUNT(*) as completed FROM complaints_detail WHERE status ='16' AND faculty_id = '$faculty_id'";
                                                                $output4 = mysqli_query($conn, $query4);
                                                                $row4 = mysqli_fetch_assoc($output4);
                                                                $completedCount = $row4['completed'];
                                                                echo $completedCount;
                                                                ?>

                                                            </h1>
                                                        </div>
                                                        <h5>Completed</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!---------------------------DashBoard Ends-------------------------->
<!------------------pending work----------------->
<div class="tab-pane p-20" id="home" role="tabpanel">
                                    <div class="modal fade" id="cmodal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Raise Complaint</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"><i class="mdi mdi-close"></i></button>
                                                </div>
                                                <div>
                                                    <form id="addnewuser" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="id" class="form-label">Faculty ID</label>
                                                                <input type="hidden" id="hidden_faculty_id" value="<?php echo $_SESSION['faculty_id']; ?>">
                                                                <input type="text" class="form-control" name="faculty_id" id="faculty_id" placeholder="Faculty ID" readonly>


                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="faculty_name" class="form-label">Faculty
                                                                    Name</label>
                                                                    <input type="text" class="form-control" name="faculty_name" placeholder="Enter Faculty Name" required readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="department"
                                                                    class="form-label">department</label>
                                                                    <input type="text" class="form-control" name="department" placeholder="Enter Department" required readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="contact" class="form-label">Mobile
                                                                    No</label>
                                                                    <input type="text" class="form-control" name="faculty_contact" placeholder="Enter Mobile No" required readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="mail" class="form-label">Mail id</label>
                                                                <input type="text" class="form-control" name="faculty_mail" placeholder="Enter Mail ID" required readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="block" class="form-label">Block</label>
                                                                <input type="text" class="form-control"
                                                                    name="block_venue" placeholder="Eg:RK-206" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="venue" class="form-label">Venue</label>
                                                                <select class="form-control" name="venue_name"
                                                                    style="width: 100%; height:36px;">
                                                                    <option>Select</option>
                                                                    <option value="class">Class Room</option>
                                                                    <option value="department">Department</option>
                                                                    <option value="lab">Lab</option>
                                                                    <option value="staff_room">Staff Room</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="type_of_problem" class="form-label">Type of
                                                                    Problem</label>
                                                                <select class="form-control" name="type_of_problem"
                                                                    style="width: 100%; height:36px;">
                                                                    <option>Select</option>
                                                                    <option value="Electrical Work">ELECTRICAL
                                                                    </option>
                                                                    <option value="Carpenter Work">CARPENTER
                                                                    </option>
                                                                    <option value="Civil Work">CIVIL</option>
                                                                    <option value="Partition Work">PARTITION
                                                                    </option>
                                                                    <option value="IT Infra Work">IT INFRA </option>
                                                                    <option value="Plumbing Work">PLUMBING </option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="description" class="form-label">Problem
                                                                    Description</label>
                                                                <input type="text" class="form-control"
                                                                    name="problem_description"
                                                                    placeholder="Enter Description" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="images" class="form-label">Image</label>
                                                                <input type="file" class="form-control" name="images" id="images" onchange="validateSize(this)">
                                                            </div>
                                                            <div class="mb-3">
                                                                <input type="hidden" class="form-control" name="date_of_reg" id="date_of_reg" required>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="status" value="1">
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit"
                                                                class="btn btn-primary">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <!--pending work end -->
                                    <!-- Status Modal -->
                                    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="statusModalLabel">Status</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="statusDetails"></p> <!-- Status message will be displayed here -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- end status modal -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div>
                                                        <button type="button" class="btn btn-info float-right"
                                                            data-bs-toggle="modal" data-bs-target="#cmodal">Raise
                                                            Compliant</button>
                                                        <br><br>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <!-- pending -->
                                                        <table id="user" class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th><b>S.No</b></th>
                                                                    <th><b>Venue</b></th>
                                                                    <th><b>Problem</b></th>
                                                                    <th><b>Problem description</b></th>
                                                                    <th><b>Date Of submission</b></th>
                                                                    <th><b>Photo</b></th>
                                                                    <th><b>Status</b></th>
                                                                    <th><b>Action</b></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $s = 1;
                                                                while ($row = mysqli_fetch_assoc($result5)) {
                                                                    // Map the numeric status to a message
                                                                    $statusMessage = '';
                                                                    switch ($row['status']) {
                                                                        case 1:
                                                                            $statusMessage = 'Pending';
                                                                            break;
                                                                        case 2:
                                                                            $statusMessage = 'Approved by Infra';
                                                                            break;
                                                                        case 3:
                                                                            $statusMessage = 'Rejected by Infra';
                                                                            break;
                                                                        case 4:
                                                                            $statusMessage = 'Approved by HOD';
                                                                            break;
                                                                        case 5:
                                                                            $statusMessage = 'Rejected by HOD';
                                                                            break;
                                                                        case 6:
                                                                            $statusMessage = 'Sent to Principal for Approval';
                                                                            break;
                                                                        case 7:
                                                                            $statusMessage = 'Assigned to Worker';
                                                                            break;
                                                                        case 8:
                                                                            $statusMessage = ' ';
                                                                            break;
                                                                        case 9:
                                                                            $statusMessage = ' ';
                                                                            break;
                                                                        case 10:
                                                                            $statusMessage = 'Worker In Progress';
                                                                            break;
                                                                        case 11:
                                                                            $statusMessage = 'Waiting for Approval';
                                                                            break;
                                                                        case 12:
                                                                            $statusMessage = ' ';
                                                                            break;
                                                                        case 13:
                                                                            $statusMessage = 'Work Response';
                                                                            break;
                                                                        case 14:
                                                                            $statusMessage = 'Feedback Sent to Manager';
                                                                            break;
                                                                        case 15:
                                                                            $statusMessage = 'Reassigned';
                                                                            break;
                                                                        case 16:
                                                                            $statusMessage = 'Work Completed';
                                                                            break;
                                                                        case 17:
                                                                            $statusMessage = 'Inprogress';
                                                                            break;
                                                                        case 18:
                                                                            $statusMessage = 'Rejected by Principal';
                                                                            break;
                                                                        case 19:
                                                                            $statusMessage = 'Rejected by manager';
                                                                            break;
                                                                        default:
                                                                            $statusMessage = 'Unknown Status';
                                                                    }
                                                                ?>
                                                                    <tr>
                                                                        <td><?php echo $s; ?></td>
                                                                        <td><?php echo $row['block_venue']; ?></td>
                                                                        <td><?php echo $row['type_of_problem']; ?></td>
                                                                        <td><?php echo $row['problem_description']; ?></td>
                                                                        <td><?php echo $row['date_of_reg']; ?></td>
                                                                        <td>
                                                                            <button type="button" class="btn btn-info showImage" value="<?php echo $row['id']; ?>">View</button>
                                                                        </td>
                                                                        <!-- Display the status message instead of numeric status -->
                                                                        <td><?php echo $statusMessage; ?></td>
                                                                        <td>
                                                                            <?php if ($row['status'] == 1) { ?>
                                                                                <button type="button" value="<?php echo $row['id']; ?>" class="btn btn-danger btndelete">Delete</button>
                                                                            <?php } else { ?>
                                                                                <button type="button" disabled>Delete</button>
                                                                            <?php } ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php
                                                                    $s++;
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!------------------Complain form Page Ends----------------->
                                <!-- Modal image view-->
                                <!-- Modal image view-->
                                <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="imageModalLabel">Image</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="mdi mdi-close"></i></button>
                                            </div>
                                            <div class="modal-body">
                                                <img id="modalImage" src="" alt="Image" class="img-fluid" style="width: 100%; height: auto;">
                                                <!-- src will be set dynamically -->
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <!------------------Work in Progress Starts----------------->
                                <div class="tab-pane p-20" id="inprogress" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Add table-responsive class here -->
                                            <div class="table-responsive">
                                                <table id="ProgressTable" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th><b>S.No</b></th>
                                                            <th><b>Venue</b></th>
                                                            <th><b>Problem</b></th>
                                                            <th><b>Problem description</b></th>
                                                            <th><b>Date Of submission</b></th>
                                                            <th><b>Worker Details</b></th>
                                                            <th><b>Feedback</b></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $s = 1;
                                                        while ($row = mysqli_fetch_assoc($result1)) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $s; ?></td>
                                                                <td><?php echo $row['block_venue']; ?></td>
                                                                <td><?php echo $row['type_of_problem']; ?></td>
                                                                <td><?php echo $row['problem_description']; ?></td>
                                                                <td><?php echo $row['date_of_reg']; ?></td>
                                                                <td>
                                                                    <button type="button" class="btn btn-info showWorkerDetails" value="<?php echo $row['id']; ?>">View</button>
                                                                </td>
                                                                <td>
                                                                    <?php if ($row['status'] == 11) { ?>
                                                                        <!-- Button to open the feedback modal -->
                                                                        <button type="button" class="btn btn-info feedbackBtn" data-problem-id="<?php echo $row['id']; ?>" data-bs-toggle="modal" data-bs-target="#feedback_modal">Feedback</button>
                                                                    <?php } else { ?>
                                                                        <button type="button" disabled>Feedback</button>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                            $s++;
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div> <!-- End of table-responsive div -->
                                        </div>
                                    </div>
                                </div>
                                <!------------------Work in Progress Ends----------------->

                                <!-- Worker Details Modal -->
                                <div class="modal fade" id="workerModal" tabindex="-1" aria-labelledby="workerModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="workerModalLabel">Worker Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="mdi mdi-close"></i></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Name:</strong> <span id="workerName"></span></p>
                                                <p><strong>Contact:</strong> <span id="workerContact"></span></p>
                                                <p><strong>Email:</strong> <span id="workerEmail"></span></p>
                                                <!-- Call button -->
                                                <div class="d-flex justify-content-end">
                                                    <a href="#" id="callWorkerBtn" class="btn btn-success">Call Worker</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Feedback Modal -->
                                <div class="modal fade" id="feedback_modal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="feedbackModalLabel">Feedback Form</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="mdi mdi-close"></i></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="add_feedback">
                                                    <input type="hidden" name="id" id="feedback_id"> <!-- Hidden input for id -->

                                                    <div class="mb-3">
                                                        <label for="satisfaction" class="form-label">Satisfaction</label>
                                                        <select name="satisfaction" id="satisfaction" class="form-control" required>
                                                            <option value="" disabled selected>Select an option</option>
                                                            <option value="14">Satisfied</option>
                                                            <option value="14">Reassign</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="feedback" class="form-label">Feedback</label>
                                                        <textarea name="feedback" id="feedback" class="form-control" placeholder="Enter Feedback" style="width: 100%; height: 150px;"></textarea>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <!-- Submit Button -->
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!----------------Completed Work Table starts--------------------->
                                <div class="tab-pane p-20" id="completed" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Add table-responsive class here -->
                                            <div class="table-responsive">
                                                <table id="completedTable" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th><b>S.No</b></th>
                                                            <th><b>Venue</b></th>
                                                            <th><b>Problem</b></th>
                                                            <th><b>Date Of submission</b></th>
                                                            <th><b>Date of Completion</b></th>
                                                            <th><b>Feedback</b></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $s = 1;
                                                        while ($row = mysqli_fetch_assoc($result2)) {
                                                        ?>
                                                            <tr>
                                                                <td>
                                                                    <?php echo $s; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $row['block_venue']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $row['problem_description']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $row['date_of_reg']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $row['date_of_completion']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $row['feedback']; ?>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                            $s++;
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div> <!-- End of table-responsive div -->
                                        </div>
                                    </div>
                                </div><!---------------------Completed Work Ends------------------------------>




                                <!-----------------------Rejected Work Starts-------------------------->
                                <div class="tab-pane p-20" id="parents" role="tabpanel">
                                    <!-- Add table-responsive class here -->
                                    <div class="table-responsive">
                                        <table id="RejectionTable" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th><b>S no</b></th>
                                                    <th><b>Block</b></th>
                                                    <th><b>Venue</b></th>
                                                    <th><b>problem description</b></th>
                                                    <th><b>Status </b></th>
                                                    <th><b>Reason </b></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                                $s = 1;
                                                                while ($row = mysqli_fetch_assoc($result3)) {
                                                                    // Map the numeric status to a message
                                                                    $statusMessage = '';
                                                                    switch ($row['status']) {
                                                                        case 1:
                                                                            $statusMessage = 'Pending';
                                                                            break;
                                                                        case 2:
                                                                            $statusMessage = 'Approved by Infra';
                                                                            break;
                                                                        case 3:
                                                                            $statusMessage = 'Rejected by Infra';
                                                                            break;
                                                                        case 4:
                                                                            $statusMessage = 'Approved by HOD';
                                                                            break;
                                                                        case 5:
                                                                            $statusMessage = 'Rejected by HOD';
                                                                            break;
                                                                        case 6:
                                                                            $statusMessage = 'Sent to Principal for Approval';
                                                                            break;
                                                                        case 7:
                                                                            $statusMessage = 'Assigned to Worker';
                                                                            break;
                                                                        case 8:
                                                                            $statusMessage = ' ';
                                                                            break;
                                                                        case 9:
                                                                            $statusMessage = ' ';
                                                                            break;
                                                                        case 10:
                                                                            $statusMessage = 'Worker In Progress';
                                                                            break;
                                                                        case 11:
                                                                            $statusMessage = 'Waiting for Approval';
                                                                            break;
                                                                        case 12:
                                                                            $statusMessage = ' ';
                                                                            break;
                                                                        case 13:
                                                                            $statusMessage = 'Work Response';
                                                                            break;
                                                                        case 14:
                                                                            $statusMessage = 'Feedback Sent to Manager';
                                                                            break;
                                                                        case 15:
                                                                            $statusMessage = 'Reassigned';
                                                                            break;
                                                                        case 16:
                                                                            $statusMessage = 'Work Completed';
                                                                            break;
                                                                        case 17:
                                                                            $statusMessage = 'Inprogress';
                                                                            break;
                                                                        case 18:
                                                                            $statusMessage = 'Rejected by Principal';
                                                                            break;
                                                                        case 19:
                                                                            $statusMessage = 'Rejected by manager';
                                                                            break;
                                                                        default:
                                                                            $statusMessage = 'Unknown Status';
                                                                    }
                                                                ?>
                                                
                                                    <tr>
                                                        <td>
                                                            <?php echo $s; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row['block_venue']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row['venue_name']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row['problem_description']; ?>
                                                        </td>
                                                        <td>
                                                        <?php echo $statusMessage; ?>
                                                </td>
                                                        <td>
                                                            <?php echo $row['feedback']; ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    $s++;
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div> <!-- End of table-responsive div -->
                                </div>
                                <!------------------Reassigned work Starts----------------->
                                <div class="tab-pane p-20" id="reassign" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Add table-responsive class here -->
                                            <div class="table-responsive">
                                                <table id="reassignTable" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th><b>S.No</b></th>
                                                            <th><b>Venue</b></th>
                                                            <th><b>Problem</b></th>
                                                            <th><b>Problem description</b></th>
                                                            <th><b>Date Of submission</b></th>
                                                            <th><b>Worker Details</b></th>
                                                            <th><b>Feedback</b></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $s = 1;
                                                        while ($row = mysqli_fetch_assoc($result4)) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $s; ?></td>
                                                                <td><?php echo $row['block_venue']; ?></td>
                                                                <td><?php echo $row['type_of_problem']; ?></td>
                                                                <td><?php echo $row['problem_description']; ?></td>
                                                                <td><?php echo $row['date_of_reg']; ?></td>
                                                                <td>
                                                                    <button type="button" class="btn btn-info showWorkerDetails" value="<?php echo $row['id']; ?>">View</button>
                                                                </td>
                                                                <td><?php echo $row['feedback']; ?></td>
                                                            </tr>
                                                        <?php
                                                            $s++;
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div> <!-- End of table-responsive div -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer text-center">
            <b> 2024 © M.Kumarasamy College of Engineering All Rights Reserved. <br> Developed and Maintained by
                Technology Innovation Hub</b>.
        </footer>
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
    <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="dist/js/custom.min.js"></script>
    <!--This page JavaScript -->
    <!-- <script src="dist/js/pages/dashboards/dashboard1.js"></script> -->
    <!-- Charts js Files -->
    <script src="assets/libs/flot/excanvas.js"></script>
    <script src="assets/libs/flot/jquery.flot.js"></script>
    <script src="assets/libs/flot/jquery.flot.pie.js"></script>
    <script src="assets/libs/flot/jquery.flot.time.js"></script>
    <script src="assets/libs/flot/jquery.flot.stack.js"></script>
    <script src="assets/libs/flot/jquery.flot.crosshair.js"></script>
    <script src="assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
    <script src="dist/js/pages/chart/chart-page-init.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script>
        // Get today's date in the format 'YYYY-MM-DD'
        var today = new Date().toISOString().split('T')[0];

        // Get the date input element
        var dateInput = document.getElementById('date_of_reg');

        // Set the minimum and maximum date for the input field to today's date
        dateInput.setAttribute('min', today);
        dateInput.setAttribute('max', today);
         // Set the value of the input field to today's date
         dateInput.value = today;
    </script>


    <!--file size and type -->
    <script>
        function validateSize(input) {
            const filesize = input.files[0].size / 1024; // Size in KB

            var ext = input.value.split(".");
            ext = ext[ext.length - 1].toLowerCase();
            var arrayExtensions = ["jpg", "jpeg" , "png"];

            // Check file extension
            if (arrayExtensions.lastIndexOf(ext) == -1) {
                swal("Invalid Image Format, Only .jpeg, .jpg, .png format allowed", "", "error");
                $(input).val(''); // clear the input field
            }
            // Check file size limit of 2 MB (2048 KB)
            else if (filesize > 2048) {
                swal("File is too large, Maximum 2 MB is allowed", "", "error");
                $(input).val(''); // clear the input field
            }
        }
    </script>


    <script>
        $(document).ready(function() {
            $('#user').DataTable();
            $('#ProgressTable').DataTable();
            $('#completedTable').DataTable();
            $('#RejectionTable').DataTable();
            $('#reassignTable').DataTable();
        });
        $(document).ready(function() {
            // Add complaints
            $(document).on('submit', '#addnewuser', function(e) {
                e.preventDefault(); // Prevent form from submitting normally
                var formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "fbackend.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {

                        var res = typeof response === 'string' ? JSON.parse(response) : response;
                        if (res.status === 200) {
                            swal("Complaint Submitted!", "", "success");
                            $('#cmodal').modal('hide');
                            $('#addnewuser')[0].reset(); // Reset the form
                            $('#user').load(location.href + " #user");
                             // Optional: refresh the page to reflect changes
                        } else {
                            console.error("Error:", res.message);
                            alert("Something went wrong! Try again.");
                        }

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("AJAX Error:", textStatus, errorThrown);
                        alert("Failed to process response. Please try again.");
                    }
                });
            });
            // Delete complaints
            $(document).on('click', '.btndelete', function(e) {
                e.preventDefault();

                if (confirm('Are you sure you want to delete this data?')) {
                    var user_id = $(this).val();

                    $.ajax({
                        type: "POST",
                        url: "fbackend.php",
                        data: {
                            'delete_user': true,
                            'user_id': user_id
                        },
                        success: function(response) {
                            console.log(response);
                            var res = typeof response === 'string' ? JSON.parse(response) : response;
                            if (res.status === 500) {
                                alert(res.message);
                            } else {
                                swal("User deleted successfully", "", "success");
                                $('#user').load(location.href + " #user>*", ""); // Reload the table content
                            }

                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error("AJAX Error:", textStatus, errorThrown);
                            alert("Failed to delete data.");
                        }
                    });
                }
            });

            // Show image in modal
            // Handle View Image Button Click
            $(document).on('click', '#viewImageButton', function() {
                var imageSrc = $('#preview_image').attr('src');
                if (imageSrc) {
                    $('#preview_images').show(); // Show image if available
                } else {
                    alert('No image found');
                }
            });
        });


        // Show image
        $(document).on('click', '.showImage', function() {
            var id = $(this).val(); // Get the id from button value
            console.log(id); // Ensure this logs correctly

            $.ajax({
                type: "POST",
                url: "fbackend.php",
                data: {
                    'get_image': true,
                    'id': id // Correct POST key
                },
                dataType: "json", // Automatically parses JSON responses
                success: function(response) {
                    console.log(response);

                    if (response.status == 200) {
                        // Dynamically set the image source
                        $('#modalImage').attr('src', 'uploads/' + response.data.images);
                        // Show the modal
                        $('#imageModal').modal('show');
                    } else {
                        // Handle case where no image is found
                        alert(response.message || 'An error occurred while retrieving the image.');
                    }
                },
                error: function(xhr, status, error) {
                    // Log the full error details for debugging
                    console.error("AJAX Error: ", xhr.responseText);
                    alert('An error occurred: ' + error + "\nStatus: " + status + "\nDetails: " + xhr.responseText);
                }
            });
        });

        // Display worker details
        $(document).on('click', '.showWorkerDetails', function() {
            var id = $(this).val(); // Get the id from the button value
            console.log("Fetching worker details for id: " + id); // Debug log

            $.ajax({
                type: "POST",
                url: "fbackend.php", // Adjust if necessary
                data: {
                    'get_worker_details': true,
                    'id': id
                },
                dataType: "json",
                success: function(response) {
                    if (response.status == 200) {
                        // Show worker details in the modal
                        $('#workerName').text(response.worker_first_name + ' ' + response.worker_last_name);
                        $('#workerContact').text(response.worker_mobile);
                        $('#workerEmail').text(response.worker_mail);

                        // Set the href attribute for the call button to dial the worker's mobile number
                        $('#callWorkerBtn').attr('href', 'tel:' + response.worker_mobile);

                        // Show the modal
                        $('#workerModal').modal('show');
                    } else {
                        alert(response.message || 'No worker details found.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: ", xhr.responseText);
                    alert('An error occurred while fetching the worker details: ' + error);
                }
            });
        });



        // status button
        $(document).on('click', '.statusBtn', function() {
            var id = $(this).data('problem-id'); // Ensure the data is being passed
            console.log('Problem ID:', id); // Log the id for debugging

            $('#feedback_id').val(id);

            $.ajax({
                type: "POST",
                url: "fbackend.php", // Make sure this is the correct backend URL
                data: {
                    'get_status_details': true,
                    'id': id
                },
                dataType: "json",
                success: function(response) {
                    console.log(response); // Log the response for debugging

                    if (response.status == 200) {
                        // Show status in the modal
                        $('#statusDetails').text(response.message);
                        $('#statusModal').modal('show'); // Open the modal
                    } else {
                        alert(response.message || 'An error occurred while retrieving the status.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: ", xhr.responseText);
                    alert('An error occurred while fetching the status: ' + error);
                }
            });
        });

        // Open feedback modal and set id
        $(document).on('click', '.feedbackBtn', function() {
            var id = $(this).data('problem-id');

            // Clear the feedback field and dropdown before opening the modal
            $('#feedback').val(''); // Clear textarea
            $('#satisfaction').val(''); // Reset dropdown to blank

            // Set id in the hidden input
            $('#feedback_id').val(id);

            // Show the modal
            $('#feedback_modal').modal('show');
        });

        // Handle feedback form submission
        $('#add_feedback').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            var formData = $(this).serialize(); // Serialize form data

            $.ajax({
                type: "POST",
                url: "fbackend.php", // Adjust if necessary
                data: formData,
                dataType: "json",
                success: function(response) {
                    if (response.status == 200) {
                        swal("Done!", "Feedback Submitted!", "success");
                        $('#feedback_modal').modal('hide'); // Close modal on success
                        // Reload the tables to reflect updated data
                        $('#ProgressTable').load(location.href + " #ProgressTable");
                        $('#completedTable').load(location.href + " #completedTable");
                        $('#reassignTable').load(location.href + " #reassignTable");
                    } else {
                        alert(response.message || 'An error occurred while submitting feedback.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: ", xhr.responseText);
                    alert('An error occurred while submitting feedback: ' + error);
                }
            });
        });

        // display user
        
        $(document).ready(function() {
        $('#cmodal').on('show.bs.modal', function() {
        var faculty_id = $('#hidden_faculty_id').val();
        $('#faculty_id').val(faculty_id);

        if (faculty_id) {
            $.ajax({
                type: 'POST',
                url: 'fbackend.php',
                data: { action: 'fetch_faculty_details', faculty_id: faculty_id },
                success: function(response) {
                    var res = typeof response === 'string' ? JSON.parse(response) : response;
                    if (res.status === 200) {
                        var faculty = res.data;
                        $('input[name="faculty_name"]').val(faculty.faculty_name);
                        $('input[name="department"]').val(faculty.department);
                        $('input[name="faculty_contact"]').val(faculty.faculty_contact);
                        $('input[name="faculty_mail"]').val(faculty.faculty_mail);
                    } else {
                        console.error("Error:", res.message);
                        alert("Faculty details could not be retrieved. Please check the Faculty ID.");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("AJAX Error:", textStatus, errorThrown);
                    alert("Failed to retrieve faculty details. Please try again.");
                }
            });
        }
    });
});


    </script>



</body>
<div scrible-ignore="" id="skribel__annotation_ignore_browserExtensionFlag" class="skribel__chromeExtension"
    style="display: none"></div>

</html>