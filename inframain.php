<?php
include("db.php");
$sql = "SELECT * FROM complaints_detail where status='1'";
$result = mysqli_query($conn, $sql);
$sql1 = "SELECT * FROM complaints_detail where status in (2,4,6,7,10,11)";
$result1 = mysqli_query($conn, $sql1);
$sql2 = "SELECT * FROM complaints_detail where status in (3,5,18,19)";
$result2 = mysqli_query($conn, $sql2);
$sql3 = "SELECT * FROM complaints_detail where status in (13)";
$result3 = mysqli_query($conn, $sql3);


?>
<!DOCTYPE html>

<html dir="ltr" lang="en">

<head>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>CMS</title>
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</head>
<style>
    #setDeadlineModal {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 300px;
        padding: 20px;
        background: #fff;
        border: 1px solid #ddd;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        z-index: 1000;
    }

    #modalBackdrop {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
    }

    /* Style for the progress bar container */
    .progress-container {
        width: 100%;
        background-color: #f3f3f3;
        border: 1px solid #ddd;
        margin-top: 10px;
        position: relative;
    }

    /* Style for the progress bar itself */
    .progress-bar {
        height: 25px;
        width: 0;
        background-color: #4caf50;
        text-align: center;
        color: white;
        line-height: 25px;
        position: absolute;
    }

    /* Style for the progress text */
    .progress-text {
        position: absolute;
        width: 100%;
        text-align: center;
        color: black;
        line-height: 25px;
    }

    th {
        background-color: #7460ee;
        background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);
        color: white
    }

    /* Remove persistent backdrop */
    .modal-backdrop {
        display: none !important;
    }
</style>

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
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="index.html">
                        <!-- Logo icon -->
                        <b class="logo-icon p-l-10">
                            
                            <img src="https://tse3.mm.bing.net/th?id=OIP.feWYBO2zWaCgh0tpHH2zbgHaCg&pid=Api&P=0&h=180" alt="homepage" class="light-logo" height="100px" width="220px"/>
                            

                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        
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
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
                        <!-- ============================================================== -->
                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-right">
                        <!-- ============================================================== -->
                        <!-- Logout-->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="assets/images/users/1.jpg" alt="user" class="rounded-circle" width="31"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated">
                                <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>

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
<br><br>
                        <li class="sidebar-item"><a href="inframain.php" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Faculty Coordinator</span></a></li>
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
                        <h4 class="page-title">Task History</h4>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Task History</li>
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
                <div class="row">
                    <div class="col-md-12">

                        <!-- Tabs -->
                        <div class="card">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#pending" role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">Pending works</span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#progress" role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">Works in progress</span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#reassign" role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">Rejected works</span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#completed" role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">Completed works</span></a> </li>

                            </ul>
                            <!-- Pending table-->
                            <div class="tab-content tabcontent-border">
                                <div class="tab-pane active" id="pending" role="tabpanel">
                                    <div class="p-20">
                                        <div class="card">
                                            <div class="card-header">
                                               <center> <h4>Pending works
                                                    
                                                </h4></center>
                                            </div>
                                            <br>
                                            <br>




                                          
                                            <div class="table-responsive">
                                            <table class="table table-bordered" id="pending1">
                                                <thead>
                                                    <tr>

                                                        <th class="text-center"><b>
                                                                <h5>S.No</h5>
                                                            </b></th>
                                                        <th class="col-md-2 text-center"><b>
                                                                <h5>Faculty ID</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Faculty Name</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Faculty number</h5>
                                                            </b></th>
                                                        <th class="col-md-2 text-center"><b>
                                                                <h5>Block name</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Venue</h5>
                                                            </b></th>
                                                        <th class="col-md-2 text-center"><b>
                                                                <h5>Type of problem</h5>
                                                            </b></th>
                                                        <th class="col-md-2 text-center"><b>
                                                                <h5>Set deadline</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Problem description</h5>
                                                            </b></th>
                                                        <th class="text-center">
                                                            <b>
                                                                <h5>Photos</h5>
                                                            </b>
                                                        </th>
                                                        <th class="text-center"><b>
                                                                <h5>Action</h5>
                                                            </b></th>

                                                        <th class="text-center"><b>
                                                                <h5>Remarks</h5>
                                                            </b></th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $s = 1;
                                                    while ($row = mysqli_fetch_array($result)) {

                                                    ?>
                                                        <tr>
                                                            <td scope="row"><?php echo $s; ?> </td>
                                                            <td class="text-center"><?php echo $row["faculty_id"]; ?></td>
                                                            <td class="text-center"><?php echo $row["faculty_name"]; ?></td>
                                                            <td class="text-center"><?php echo $row["faculty_contact"]; ?></td>
                                                            <td class="text-center"><?php echo $row["block_venue"]; ?></td>
                                                            <td class="text-center"><?php echo $row["venue_name"]; ?></td>
                                                            <td class="text-center"><?php echo $row["type_of_problem"]; ?></td>
                                                            <td class="text-center">
                                                                <div class="deadline-container">
                                                                    <button type="button" class="btn btn-primary btn-sm set-date-btn" data-bs-target="#deadlineModal" data-bs-toggle="modal" data-id="<?php echo $row['id']; ?>">Set date</button>
                                                                    <span class="selected-date" style="display:none;"></span>
                                                                </div>
                                                            </td>

                                                            <div class="modal fade" id="deadlineModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="modalLabel">Set deadline</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <input type="text" class="form-control deadline-picker" id="modalDeadlinePicker" placeholder="Select deadline">
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                            <button type="button" class="btn btn-primary" id="saveDeadlineBtn">Save</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <td class="text-center"> <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#Modal1" data-description="<?php echo $row['problem_description']; ?>">
                                                                    View Details
                                                                </button></span></td>
                                                            <td>
                                                                <button type="button" class="btn btn-info showImage" data-id="<?php echo $row['id']; ?>">View</button>
                                                            </td>
                                                            <td>
                                                                <div style="display: flex; gap: 10px; align-items: center;">
                                                                    <button type="button" value="<?php echo ($row['id']); ?>" class="btn btn-success approve-btn" id="approve" style="display: flex; align-items: center; justify-content: center;">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                                                            <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z" />
                                                                        </svg>
                                                                    </button>

                                                                    <button type="button" value="<?php echo $row['id']; ?>" class="btn btn-danger btnreject" data-toggle="modal" data-target="#rejectreason" style="display: flex; align-items: center; justify-content: center;">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                                                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                            </td>


                                                            <td class="text-center">Pending</td>

                                                        </tr>
                                                    <?php
                                                        $s++;
                                                    } ?>
                                                </tbody>
                                            </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- work on progress table-->
                                <div class="tab-pane  p-10" id="progress" role="tabpanel">
                                    <div class="p-10">
                                        <div class="card">
                                            <div class="card-header">
                                                <center>
                                                    <h4>Works in progress</h4>
                                                </center>
                                            </div><br>
                                            <div class="table-responsive">
                                            <table class="table table-bordered" id="progress1">
                                                <thead>
                                                    <tr>

                                                        <th class="text-center"><b>
                                                                <h5>S.No</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Name</h5>
                                                            </b></th>

                                                        <th class="text-center"><b>
                                                                <h5>Block</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Venue</h5>
                                                            </b></th>
                                                        <th class="col-md-2 text-center"><b>
                                                                <h5>Type</h5>
                                                            </b></th>

                                                        <th class="text-center"><b>
                                                                <h5>Deadline</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Problem description</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Image</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Status</h5>
                                                            </b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $s = 1;
                                                    while ($row = mysqli_fetch_array($result1)) {
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

                                                            case 10:
                                                                $statusMessage = 'Worker In Progress';
                                                                break;
                                                            case 11:
                                                                $statusMessage = 'Waiting for Approval';
                                                                break;

                                                            case 13:
                                                                $statusMessage = 'Work Completed';
                                                                break;
                                                            case 14:
                                                                $statusMessage = 'Sent to Manager for Rework';
                                                                break;
                                                            case 15:
                                                                $statusMessage = 'Rework Details';
                                                                break;
                                                            case 16:
                                                                $statusMessage = 'Rejected by Manager';
                                                                break;
                                                            case 17:
                                                                $statusMessage = 'Rejected by Principal';
                                                                break;
                                                            default:
                                                                $statusMessage = 'Unknown Status';
                                                        }

                                                    ?>
                                                        <tr>
                                                            <td scope="row"><?php echo $s; ?> </td>

                                                            <td class="text-center"><?php echo $row["faculty_name"]; ?></td>

                                                            <td class="text-center"><?php echo $row["block_venue"]; ?></td>
                                                            <td class="text-center"><?php echo $row["venue_name"]; ?></td>
                                                            <td class="text-center"><?php echo $row["type_of_problem"]; ?></td>
                                                            <td class="text-center"><?php echo $row["days_to_complete"]; ?></td>



                                                            <td class="text-center"> <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#Modal1" data-description="<?php echo $row['problem_description']; ?>">
                                                                    View Details
                                                                </button></span></td>
                                                            <td>
                                                                <button type="button" class="btn btn-info showImage" data-id="<?php echo $row['id']; ?>">View</button>
                                                            </td>
                                                            <td><?php echo $statusMessage; ?></td>

                                                        </tr>
                                                    <?php
                                                        $s++;
                                                    } ?>
                                                </tbody>
                                            </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane p-20" id="reassign" role="tabpanel">
                                    <div class="p-20">
                                        <div class="card">
                                            <div class="card-header">
                                                <center>
                                                    <h4>Rejected works</h4>
                                                </center>
                                            </div><br>
                                            <div class="table-responsive">
                                            <table id="reassign1"  class="table table-bordered ">
                                                <thead>
                                                    <tr>

                                                        <th class="text-center"><b>
                                                                <h5>S.No</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Name</h5>
                                                            </b></th>

                                                        <th class="text-center"><b>
                                                                <h5>Block</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Venue</h5>
                                                            </b></th>
                                                        <th class="col-md-2 text-center"><b>
                                                                <h5>Type</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Problem description</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Image</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Feedback</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Status</h5>
                                                            </b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $s = 1;
                                                    while ($row = mysqli_fetch_array($result2)) {
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
                                                            case 10:
                                                                $statusMessage = 'Worker In Progress';
                                                                break;
                                                            case 11:
                                                                $statusMessage = 'Waiting for Approval';
                                                                break;

                                                            case 13:
                                                                $statusMessage = 'Work Completed';
                                                                break;
                                                            case 14:
                                                                $statusMessage = 'Sent to Manager for Rework';
                                                                break;
                                                            case 15:
                                                                $statusMessage = 'Rework Details';
                                                                break;
                                                            case 16:
                                                                $statusMessage = 'Rejected by Manager';
                                                                break;
                                                            case 17:
                                                                $statusMessage = 'Rejected by Principal';
                                                                break;
                                                            default:
                                                                $statusMessage = 'Unknown Status';
                                                        }


                                                    ?>
                                                        <tr>
                                                            <td scope="row"><?php echo $s; ?> </td>

                                                            <td class="text-center"><?php echo $row["faculty_name"]; ?></td>

                                                            <td class="text-center"><?php echo $row["block_venue"]; ?></td>
                                                            <td class="text-center"><?php echo $row["venue_name"]; ?></td>
                                                            <td class="text-center"><?php echo $row["type_of_problem"]; ?></td>





                                                            <td class="text-center"> <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#Modal1" data-description="<?php echo $row['problem_description']; ?>">
                                                                    View Details
                                                                </button></span></td>
                                                            <td>
                                                                <button type="button" class="btn btn-info showImage" data-id="<?php echo $row['id']; ?>">View</button>
                                                            </td>

                                                            <td class="text-center"><?php echo $row["feedback"]; ?></td>

                                                            <td><?php echo $statusMessage; ?></td>

                                                        </tr>
                                                    <?php
                                                        $s++;
                                                    } ?>
                                                </tbody>

                                            </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane p-20" id="completed" role="tabpanel">
                                    <div class="p-20">
                                        <div class="card">
                                            <div class="card-body" style="padding: 10px;">
                                                <div class="card-header">
                                                    <center>
                                                        <h4>Completed works</h4>
                                                    </center>
                                                </div><br>
                                                <div class="table-responsive">
                                                    <!-- Reassigned work -->
                                                    <table id="completed1" class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>

                                                                <th class="text-center"><b>
                                                                        <h5>S.No</h5>
                                                                    </b></th>
                                                                <th class="text-center"><b>
                                                                        <h5>Name</h5>
                                                                    </b></th>

                                                                <th class="text-center"><b>
                                                                        <h5>Block</h5>
                                                                    </b></th>
                                                                <th class="text-center"><b>
                                                                        <h5>Venue</h5>
                                                                    </b></th>
                                                                <th class="col-md-2 text-center"><b>
                                                                        <h5>Type</h5>
                                                                    </b></th>
                                                                <th class="text-center"><b>
                                                                        <h5>Problem description</h5>
                                                                    </b></th>
                                                                <th class="text-center"><b>
                                                                        <h5>Image</h5>
                                                                    </b></th>
                                                                <th class="text-center"><b>
                                                                        <h5>Feedback</h5>
                                                                    </b></th>
                                                                <th class="text-center"><b>
                                                                        <h5>Status</h5>
                                                                    </b></th>



                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $s = 1;
                                                            while ($row = mysqli_fetch_array($result3)) {
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


                                                                    case 10:
                                                                        $statusMessage = 'Worker In Progress';
                                                                        break;
                                                                    case 11:
                                                                        $statusMessage = 'Waiting for Approval';
                                                                        break;

                                                                    case 13:
                                                                        $statusMessage = 'Work Completed';
                                                                        break;
                                                                    case 14:
                                                                        $statusMessage = 'Sent to Manager for Rework';
                                                                        break;
                                                                    case 15:
                                                                        $statusMessage = 'Rework Details';
                                                                        break;
                                                                    case 16:
                                                                        $statusMessage = 'Rejected by Manager';
                                                                        break;
                                                                    case 17:
                                                                        $statusMessage = 'Rejected by Principal';
                                                                        break;
                                                                    default:
                                                                        $statusMessage = 'Unknown Status';
                                                                }


                                                            ?>
                                                                <tr>
                                                                    <td scope="row"><?php echo $s; ?> </td>

                                                                    <td class="text-center"><?php echo $row["faculty_name"]; ?></td>

                                                                    <td class="text-center"><?php echo $row["block_venue"]; ?></td>
                                                                    <td class="text-center"><?php echo $row["venue_name"]; ?></td>
                                                                    <td class="text-center"><?php echo $row["type_of_problem"]; ?></td>
                                                                    <td class="text-center"> <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#Modal1" data-description="<?php echo $row['problem_description']; ?>">
                                                                            View Details
                                                                        </button></span></td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-info showImage" data-id="<?php echo $row['id']; ?>">View</button>
                                                                    </td>

                                                                    <td class="text-center"><?php echo $row["feedback"]; ?></td>

                                                                    <td><?php echo $statusMessage; ?></td>

                                                                </tr>
                                                            <?php
                                                                $s++;
                                                            } ?>
                                                        </tbody>

                                                    </table>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>


                            </div>
                            <!-- ============================================================== -->
                            <!-- End Container fluid  -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- footer -->
                            <!-- ============================================================== -->

                            <!-- ============================================================== -->
                            <!-- End footer -->
                            <!-- ============================================================== -->
                        </div>
                        <!-- ============================================================== -->
                        <!-- End Page wrapper  -->
                        <!-- ============================================================== -->
                    </div>


                    <!--Task Completion--><!--Id:comment-->
                    <!-- Rejection Reason Modal -->
                    <div class="modal fade" id="rejectreason" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Reason for Rejection</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                                </div>
                                <form id="rejectdetails">
                                    <div class="modal-body" style="font-size: larger;">
                                        <textarea class="form-control" placeholder="Enter reason" name="textaria" style="width: 100%; height: 180px;" required></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>



                    <!-- ============================================================== -->
                    <!-- End Container fluid  -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- footer -->
                    <!-- ============================================================== -->
                    <footer class="footer text-center" style="padding-left: 400px;">
                        <b>
                            2024 © M.Kumarasamy College of Engineering All Rights Reserved.<br>
                            Developed and Maintained by Technology Innovation Hub.
                        </b>
                    </footer>
                    <!-- ============================================================== -->
                    <!-- End footer -->
                    <!-- ============================================================== -->
                </div>
                <!-- ============================================================== -->
                <!-- End Page wrapper  -->
                <!-- ============================================================== -->
            </div>
            <!--modal for image(before) viewing in model -->
            <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="imageModalLabel">Image</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                        </div>
                        <div class="modal-body">
                            <img id="modalImage" src="" alt="Image" class="img-fluid" style="width:1500px;height:250px;"> <!-- src will be set dynamically -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!--modal for see more details-->
            <!-- Modal for Problem Description -->
            <div class="modal fade" id="Modal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Complaint</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                        </div>
                        <div class="modal-body">
                            <p id="problem-description"></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

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

        <script src="assets/extra-libs/sparkline/sparkline.js"></script>
        <!--Wave Effects -->
        <script src="dist/js/waves.js"></script>
        <!--Menu sidebar -->
        <script src="dist/js/sidebarmenu.js"></script>
        <!--Custom JavaScript -->
        <script src="dist/js/custom.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="assets/extra-libs/DataTables/datatables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#pending1').DataTable({
                    ordering: false
                });

            });
            $(document).ready(function() {
                $('#progress1').DataTable({
                    ordering: false
                });

            });

            $(document).ready(function() {
                $('#reassign1').DataTable({
                    ordering: false
                });

            });

            $(document).ready(function() {
                $('#completed1').DataTable({
                    ordering: false
                });

            });
        </script>
        <script>
            $(document).ready(function() {
                // Make sure Bootstrap’s modal functions are properly initialized
                $('#rejectreason').on('hidden.bs.modal', function() {
                    // Custom code if needed after modal closes
                });
            });

            //image
            // Show image
            $(document).on('click', '.showImage', function() {
                var user_id = $(this).data('id'); // Get the user ID from data attribute
                console.log(user_id);

                $.ajax({
                    type: "POST",
                    url: "infraback.php",
                    data: {
                        'get_image': true,
                        'user_id': user_id
                    },
                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        console.log(res);

                        if (res.status == 500) {
                            alert(res.message);
                        } else {
                            $('#modalImage').attr('src', 'uploads/' + res.data.images); // Dynamically set the image source
                            $('#imageModal').modal('show'); // Show the modal
                        }
                    }
                });
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

        
           
        <script>
            //for problem description

            document.addEventListener('DOMContentLoaded', function() {
                var modal = document.getElementById('Modal1');
                modal.addEventListener('show.bs.modal', function(event) {
                    var button = event.relatedTarget; // Button that triggered the modal
                    var description = button.getAttribute('data-description'); // Extract info from data-* attributes

                    // Update the modal's content
                    var modalBody = modal.querySelector('#problem-description');
                    modalBody.textContent = description;
                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                let selectedRowId = null;

                // Initialize flatpickr for the modal date picker
                flatpickr('#modalDeadlinePicker', {
                    dateFormat: 'Y-m-d',
                    minDate: "today" // Restrict to future dates
                });

                // When "Set date" button is clicked, store the row ID
                document.querySelectorAll('.set-date-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        selectedRowId = this.getAttribute('data-id');
                    });
                });

                // When "Save" button in modal is clicked
                document.getElementById('saveDeadlineBtn').addEventListener('click', function() {
                    const selectedDate = document.getElementById('modalDeadlinePicker').value;

                    if (selectedDate && selectedRowId) {
                        // Send AJAX request to save the date in the database
                        fetch('infrabackdead.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    id: selectedRowId,
                                    days_to_complete: selectedDate
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Update the UI
                                    const container = document.querySelector(`button.set-date-btn[data-id='${selectedRowId}']`).closest('.deadline-container');
                                    container.querySelector('.set-date-btn').style.display = 'none';
                                    const dateElement = container.querySelector('.selected-date');
                                    dateElement.textContent = selectedDate;
                                    dateElement.style.display = 'inline';
                                    alertify.success('Deadline saved successfully.');
                                    // Close the modal
                                    const modal = bootstrap.Modal.getInstance(document.getElementById('deadlineModal'));
                                    modal.hide();
                                } else {
                                    alertify.error('Failed to save deadline: ' + data.message);
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('An error occurred while saving the deadline.');
                            });
                    } else {
                        alert('Please select a date.');
                    }
                });
            });
        </script>

        </script>
        </script>
        <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>
        <script>
            //approve
            $(document).on('click', '#approve', function(e) {
                e.preventDefault();

                var user_id = $(this).val();

                // Show confirmation dialog
                alertify.confirm('Confirm Approval', 'Are you sure you want to approve this complaint?',
                    function() {
                        // User clicked OK
                        $.ajax({
                            type: "POST",
                            url: "infraback.php",
                            data: {
                                'seedetails': true,
                                'user_id': user_id
                            },
                            success: function(res) {
                                var response = jQuery.parseJSON(res);
                                

                                if (response.status == 200) {
                                    alertify.success('Complaint approved successfully');
                                    $('#pending1').load(location.href + " #pending1");
                                    $('#progress1').load(location.href + " #progress1");
                                   
                                    window.location.reload();
                                  
                                } else {
                                    alertify.error('Error occurred: ' + response.message);
                                }
                            }
                        });
                    },
                    function() {
                        // User clicked Cancel
                        alertify.error('Approval canceled');
                    }
                ).set('labels', {
                    ok: 'Yes',
                    cancel: 'No'
                }); // Custom labels for the buttons
            });
        </script>
        <script>
            // Trigger the modal on Reject button click
            $(document).on('click', '.btnreject', function() {
                var reject_id = $(this).val();
                $('#rejectdetails').data('reject-id', reject_id);
                $('#rejectreason').modal('show');
            });

            // Handle the form submission for rejection
            $('#rejectdetails').on('submit', function(e) {
                e.preventDefault();

                // Use HTML for a custom heading in the Alertify confirmation dialog
                alertify.confirm(
                    '<strong>Confirmation Required</strong>',
                    'Are you sure you want to reject this complaint?',
                    function() { // Confirm callback
                        var formdata1 = new FormData($('#rejectdetails')[0]); // Use the form element directly
                        var reject_id = $('#rejectdetails').data('reject-id'); // Get the ID from the form's data

                        formdata1.append("reject_status", true);
                        formdata1.append("reject_id", reject_id);

                        $.ajax({
                            type: "POST",
                            url: "infraback.php",
                            data: formdata1,
                            processData: false,
                            contentType: false,

                            success: function(response) {
                                var res = jQuery.parseJSON(response);

                                if (res.status == 200) {
                                    $('#rejectreason').modal('hide');
                                    $('#rejectdetails')[0].reset();
                                    $('#pending1').load(location.href + " #pending1");
                                    $('#reassign1').load(location.href + " #reassign1");
                                    alertify.success('Complaint rejected and feedback saved successfully.');
                                    table.ajax.reload();

                                } else if (res.status == 500) {
                                    $('#rejectreason').modal('hide');
                                    $('#rejectdetails')[0].reset();
                                    console.error("Error:", res.message);
                                    alertify.error("Something went wrong. Please try again.");
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error("AJAX error:", error);
                                alertify.error("An error occurred: " + error);
                            }
                        });
                    },
                    function() { // Cancel callback
                        alertify.error('Rejection canceled.');
                    }
                ).set('title', 'Reject Complaint'); // Set the dialog title
            });
        </script>
</body>

</html>