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

$sql5 = "SELECT * FROM complaints_detail WHERE status IN (1,2,4,6,8,9) AND faculty_id = '$faculty_id'";
$sql1 = "SELECT * FROM complaints_detail WHERE status IN (7,10,11,15,17,18) AND faculty_id = '$faculty_id'";
$sql2 = "SELECT * FROM complaints_detail WHERE status = 16 AND faculty_id = '$faculty_id'";
$sql3 = "SELECT * FROM complaints_detail WHERE status IN (3,5,19,20) AND faculty_id = '$faculty_id'";
$sql4 = "SELECT * FROM complaints_detail WHERE status = 15 AND faculty_id = '$faculty_id'";

$result5 = mysqli_query($conn, $sql5);
$result1 = mysqli_query($conn, $sql1);
$result2 = mysqli_query($conn, $sql2);
$result3 = mysqli_query($conn, $sql3);
$result4 = mysqli_query($conn, $sql4);

$row_count5 = mysqli_num_rows($result5);
$row_count1 = mysqli_num_rows($result1);
$row_count2 = mysqli_num_rows($result2);
$row_count3 = mysqli_num_rows($result3);
$row_count4 = mysqli_num_rows($result4);

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

    <link rel="icon" href="assets/images/favicon.png">
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
    .nav-tabs .nav-link {
    color: #0033cc;
}

.nav-tabs .nav-link.active {
    background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);
    color: white;
}

th {
    background-color: #7460ee;
    background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);
    color: white;
}

.text-right {
    text-align: right;
}

.text-left {
    text-align: left;
}

/* Button styling */
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


/* Close button (X) styling */
.modal-header .modal-title {
  color: white;
}
.spbutton {
    position: relative;
    width: 2em;
    height: 2em;
    border: none;
    background: rgba(180, 83, 107, 0.11);
    border-radius: 5px;
    transition: background 0.5s;
}

.spbutton::before,
.spbutton::after {
    content: "";
    position: absolute;
    top: 50%;
    left: 50%;
    width: 1em;
    height: 1.5px;
    background-color: white;
    transform: translateX(-50%) rotate(45deg);
}

.spbutton::after {
    transform: translateX(-50%) rotate(-45deg);
}

.spbutton:hover {
    background-color: rgb(211, 21, 21);
}

.spbutton:active {
    background-color: rgb(130, 0, 0);
}
/* delete button */
/* From Uiverse.io by boryanakrasteva */ 
.fbtn {
  background-color: transparent;
  position: relative;
  border: none;
}

.fbtn::after {
  content: 'delete';
  position: absolute;
  top: -130%;
  left: 50%;
  transform: translateX(-50%);
  width: fit-content;
  height: fit-content;
  background-color: rgb(168, 7, 7);
  padding: 4px 8px;
  border-radius: 5px;
  transition: .2s linear;
  transition-delay: .2s;
  color: white;
  text-transform: uppercase;
  font-size: 12px;
  opacity: 0;
  visibility: hidden;
}

.icon {
  transform: scale(1.2);
  transition: .2s linear;
}

.fbtn:hover > .icon {
  transform: scale(1.5);
}

.fbtn:hover > .icon path {
  fill: rgb(168, 7, 7);
}

.btn:hover::after {
  visibility: visible;
  opacity: 1;
  top: -160%;
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
                    <a class="navbar-brand" href="index.html">
                        <!-- Logo icon -->
                        <b class="logo-icon p-l-8">
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="assets/images/logo-icon.png" alt="homepage" class="light-logo" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span class="logo-text">
                            <!-- dark Logo text -->
                            <img src="assets/images/logo-text.png" alt="homepage" class="light-logo" />
                        </span>
                    </a>
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                        data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                            class="ti-more"></i></a>
                </div>

                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block"><a
                                class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"
                                data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
                    </ul>
                    <ul class="navbar-nav float-right">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href=""
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                    src="assets/images/users/1.jpg" alt="user" class="rounded-circle" width="31"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated">
                                <a class="dropdown-item" href="javascript:void(0)"><i class="ti-user m-r-5 m-l-5"></i>
                                    My Profile</a>
                                <a class="dropdown-item" href="javascript:void(0)"><i
                                        class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
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
                    <ul id="sidebarnav" class="p-t-30 in">

                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="completedtable.php" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span
                                    class="hide-menu">Complaints</span></a>
                        </li>

                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body wizard-content">
                        <h4 class="card-title">Work Information</h4>
                        <h6 class="card-subtitle"></h6>
                        <div class="card">
                            <div id="navref">
                                <ul class="nav nav-tabs mb-3" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active show" data-toggle="tab" href="#dashboard" role="tab" aria-selected="false">
                                            <span class="hidden-sm-up"></span>
                                            <span class="hidden-xs-down">
                                                <i class="bi bi-people-fill"></i><b>Dashboard</b>
                                            </span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#home" role="tab" aria-selected="false">
                                            <span class="hidden-sm-up"></span>
                                            <span class="hidden-xs-down">
                                                <i class="bi bi-people-fill"></i>
                                                <i class="fas fa-exclamation"></i>
                                                <b>&nbsp Pending Work (<?php echo $row_count5; ?>)</b>
                                            </span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#inprogress" role="tab" aria-selected="false">
                                            <span class="hidden-sm-up"></span>
                                            <span class="hidden-xs-down">
                                                <i class="bi bi-people-fill"></i>
                                                <i class="fas fa-clock"></i>
                                                <b>&nbsp Work-In Progress (<?php echo $row_count1; ?>)</b>
                                            </span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#completed" role="tab">
                                            <span class="hidden-sm-up"></span>
                                            <span class="hidden-xs-down">
                                                <i class="bi bi-house-door-fill"></i>
                                                <i class="mdi mdi-check-all"></i>
                                                <b>&nbsp Completed Work (<?php echo $row_count2; ?>)</b>
                                            </span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#parents" role="tab">
                                            <span class="hidden-sm-up"></span>
                                            <span class="hidden-xs-down">
                                                <i class="bi bi-house-door-fill"></i>
                                                <i class="mdi mdi-close-circle"></i>
                                                <b>&nbsp Rejected Work (<?php echo $row_count3; ?>)</b>
                                            </span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#reassign" role="tab">
                                            <span class="hidden-sm-up"></span>
                                            <span class="hidden-xs-down">
                                                <i class="bi bi-house-door-fill"></i>
                                                <i class="fas fa-redo"></i>
                                                <b>&nbsp Reassigned Work (<?php echo $row_count4; ?>)</b>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content tabcontent-border">
                                <!-----------------------------------DashBoard---------------------------------------->
                                <div class="tab-pane p-20 active show" id="dashboard" role="tabpanel">
                                    <div class="row">

                                    </div><br>
                                    <div class="card">
                                        <div class="card-body">
                                            <div id="dashref">
                                                <div class="row">
                                                    <div class="col-12 col-md-3 mb-3">
                                                        <div class="cir">
                                                            <div class="bo">
                                                                <div class="content1">
                                                                    <div class="stats-box text-center p-3"
                                                                        style="background-color:rgb(252, 119, 71);">
                                                                        <i class="fas fa-bell m-b-5 font-20"></i>
                                                                        <h1 class="m-b-0 m-t-5"><?php echo $row_count5; ?></h1>
                                                                        <small class="font-light">Pending</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-3 mb-3">
                                                        <div class="cir">
                                                            <div class="bo">
                                                                <div class="content1">
                                                                    <div class="stats-box text-center p-3"
                                                                        style="background-color:rgb(241, 74, 74);">
                                                                        <i class="fas fa-exclamation m-b-5 font-16"></i>
                                                                        <h1 class="m-b-0 m-t-5"><?php echo $row_count1; ?></h1>
                                                                        <small class="font-light">work in progress</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-3 mb-3">
                                                        <div class="cir">
                                                            <div class="bo">
                                                                <div class="content1">
                                                                    <div class="stats-box text-center p-3"
                                                                        style="background-color:rgb(70, 160, 70);">
                                                                        <i class="fas fa-check m-b-5 font-20"></i>
                                                                        <h1 class="m-b-0 m-t-5"><?php echo $row_count2; ?></h1>
                                                                        <small class="font-light">Completed</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-3 mb-3">
                                                        <div class="cir">
                                                            <div class="bo">
                                                                <div class="content1">
                                                                    <div class="stats-box text-center p-3"
                                                                        style="background-color: rgb(187, 187, 35);">
                                                                        <i class="fas fa-redo m-b-5 font-20"></i>
                                                                        <h1 class="m-b-0 m-t-5"><?php echo $row_count4; ?></h1>
                                                                        <small class="font-light">Re-assigned</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
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
                                                <div class="modal-header" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);background-color:#7460ee;">
                                                    <h5 class="modal-title" id="exampleModalLabel">Raise Complaint</h5>
                                                    <button class="spbutton" type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                </div>
                                                <div>
                                                    <form id="addnewuser" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <input type="hidden" id="hidden_faculty_id" value="<?php echo $_SESSION['faculty_id']; ?>">
                                                                <input type="hidden" class="form-control" name="faculty_id" id="faculty_id" placeholder="Faculty ID" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <input type="hidden" class="form-control" name="faculty_name" placeholder="Enter Faculty Name" required readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <input type="hidden" class="form-control" name="department" placeholder="Enter Department" required readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <input type="hidden" class="form-control" name="faculty_contact" placeholder="Enter Mobile No" required readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <input type="hidden" class="form-control" name="faculty_mail" placeholder="Enter Mail ID" required readonly>
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
                                                <div class="modal-header" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);background-color:#7460ee;">
                                                    <h5 class="modal-title" id="statusModalLabel">Status</h5>
                                                    <button class="spbutton" type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close">
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
                                                                        case 4:
                                                                            $statusMessage = 'Approved by HOD';
                                                                            break;
                                                                        case 6:
                                                                            $statusMessage = 'Sent to Principal for Approval';
                                                                            break;
                                                                        case 8:
                                                                            $statusMessage = 'Approved by Principal ';
                                                                            break;
                                                                        case 9:
                                                                            $statusMessage = ' Approved by Manager';
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
                                                                        <td>
                                                                            <?php if ($row['status'] == 1) { ?>
                                                                                <center>
<button class="fbtn btndelete" type="button" value="<?php echo $row['id']; ?>">
  <svg viewBox="0 0 15 17.5" height="17.5" width="15" xmlns="http://www.w3.org/2000/svg" class="icon">
  <path transform="translate(-2.5 -1.25)" d="M15,18.75H5A1.251,1.251,0,0,1,3.75,17.5V5H2.5V3.75h15V5H16.25V17.5A1.251,1.251,0,0,1,15,18.75ZM5,5V17.5H15V5Zm7.5,10H11.25V7.5H12.5V15ZM8.75,15H7.5V7.5H8.75V15ZM12.5,2.5h-5V1.25h5V2.5Z" id="Fill"></path>
</svg>
</button>
                                                                                    
                                                                                </center>

                                                                            <?php } else { ?>
                                                                                <?php echo $statusMessage; ?>
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
                                            <div class="modal-header" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);background-color:#7460ee;">
                                                <h5 class="modal-title" id="imageModalLabel">Image</h5>
                                                <button class="spbutton" type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close">
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
                                                                    <?php if ($row['status'] == 11 || $row['status'] == 18) { ?>
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
            <div class="modal-header" style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); background-color: #7460ee; color: white;">
                <h5 class="modal-title" id="workerModalLabel">Worker Details</h5>
                <button class="spbutton" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Name Box -->
                <div class="box" style="background-color: #f7f7f7; border: 1px solid #ccc; padding: 15px; margin-bottom: 10px; border-radius: 5px;">
                    <p><strong>Name:</strong> <span id="workerName"></span></p>
                </div>
                
                <!-- Contact Box -->
                <div class="box" style="background-color: #f7f7f7; border: 1px solid #ccc; padding: 15px; margin-bottom: 10px; border-radius: 5px;">
                    <p><strong>Contact:</strong> <span id="workerContact"></span></p>
                </div>

                <!-- Email Box -->
                <div class="box" style="background-color: #f7f7f7; border: 1px solid #ccc; padding: 15px; margin-bottom: 10px; border-radius: 5px;">
                    <p><strong>Email:</strong> <span id="workerEmail"></span></p>
                </div>

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
                                            <div class="modal-header" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);background-color:#7460ee;">
                                                <h5 class="modal-title" id="feedbackModalLabel">Feedback Form</h5>
                                                <button class="spbutton" type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close">
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
                                                        case 3:
                                                            $statusMessage = 'Rejected by Infra';
                                                            break;
                                                        case 5:
                                                            $statusMessage = 'Rejected by HOD';
                                                            break;
                                                        case 19:
                                                            $statusMessage = 'Rejected by Principal';
                                                            break;
                                                        case 20:
                                                            $statusMessage = 'Rejected by Manager';
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
            var arrayExtensions = ["jpg", "jpeg", "png"];

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
                            $('#navref').load(location.href + " #navref");
                            $('#dashref').load(location.href + " #dashref");
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
                                swal("Complaint deleted successfully", "", "success");
                                $('#user').load(location.href + " #user>*", ""); // Reload the table content
                                $('#navref').load(location.href + " #navref");

                                $('#dashref').load(location.href + " #dashref");
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
                        $('#navref').load(location.href + " #navref");

                        $('#dashref').load(location.href + " #dashref");
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
                        data: {
                            action: 'fetch_faculty_details',
                            faculty_id: faculty_id
                        },
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
<div scrible-ignore="" id="skribel_annotation_ignore_browserExtensionFlag" class="skribel_chromeExtension"
    style="display: none"></div>

</html>