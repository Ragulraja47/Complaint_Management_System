<?php
include("db.php");
//query for 1st table input 
//Faculty complaint table
$sql1 = "
SELECT cd.*, faculty.faculty_name, faculty.department, faculty.faculty_contact, faculty.faculty_mail
FROM complaints_detail cd
JOIN faculty ON cd.faculty_id = faculty.faculty_id
WHERE cd.status IN ('4','9')
";
$result1 = mysqli_query($conn, $sql1);
$row_count1 = mysqli_num_rows($result1);
//manager table
$sql2 = "SELECT * FROM worker_details";
$result2 = mysqli_query($conn, $sql2);
//worker details fetch panna
$sql3 = "SELECT * FROM complaints_detail WHERE status IN ('7','10','11','13')";
$result3 = mysqli_query($conn, $sql3);
$row_count3 = mysqli_num_rows($result3);

//worker details fetch panna
$sql4 = "SELECT * FROM complaints_detail WHERE status IN ('8','19')";
$result4 = mysqli_query($conn, $sql4);

$sql9 = "SELECT * FROM complaints_detail WHERE status IN ('8')";
$result9 = mysqli_query($conn, $sql9);
$row_count4 = mysqli_num_rows($result9);

//work finished table
$sql5 = "SELECT * FROM complaints_detail WHERE status = '14'";
$result5 = mysqli_query($conn, $sql5);
$row_count5 = mysqli_num_rows($result5);
//work completed table
$sql6 = "SELECT * FROM complaints_detail WHERE status='16'";
$result6 = mysqli_query($conn, $sql6);
//work reassigned table
$sql7 = "SELECT * FROM complaints_detail WHERE status IN ('15','17','18')";
$result7 = mysqli_query($conn, $sql7);
$row_count7 = mysqli_num_rows($result7);
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title>MIC - MKCE</title>
    <link href="dist/css/style.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="assets/extra-libs/multicheck/multicheck.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link href="dist/css/style.min.css" rel="stylesheet">

    <!-- CSS Alertify-->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css" />
    <!-- Bootstrap theme alertify-->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/bootstrap.min.css" />
    <style>
        .nav-tabs .nav-link {
            color: #0033cc;
        }

        .nav-tabs .nav-link.active {
            background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);
            color: white;
        }

        /* Dropdown animation */
        .dropdown-menu {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .dropdown-menu.show {
            opacity: 1;
        }

        .selected-priority {
            background-color: blue;
            color: white;
        }
    </style>

    <!-- Additional CSS for Modal -->
    <style>
        .close span {
            display: inline-block;
            transition: transform 0.3s ease-in-out;
        }

        .close:hover span {
            transform: rotate(45deg);
            color: white;
        }

        /* Close Button */
        .modal-header .close {
            font-size: 1.5rem;
            color: white;
            opacity: 1;
            transition: transform 0.3s ease;
            outline: none;
            /* Removes the focus outline */
            border: none;
            /* Ensures no border around the button */
        }

        .modal-header .close:focus {
            outline: none;
            /* Removes focus outline when the button is clicked */
            box-shadow: none;
            /* Ensures no shadow or box effect appears */
        }

        .modal-header .close:hover {
            transform: rotate(90deg);
            color: #ff8080;
        }


        /* priority modal */
        /* Modal Background */
        .modal-content {
            border-radius: 12px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
            background-color: #f5f5f5;

            border: none;
        }

        /* Header Styling with Gradient */
        .modal-header {
            background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);
            color: white;
            border-bottom: none;
            padding: 10px 20px;
            border-radius: 12px 12px 0 0;
        }

        .modal-title {
            font-weight: bold;
            font-size: 1.5rem;
        }

        /* Close Button */
        .modal-header .close {
            font-size: 1.5rem;
            color: white;
            opacity: 1;
            transition: transform 0.3s ease;
        }

        .modal-header .close:hover {


            transform: rotate(90deg);
            color: #ff8080;
        }

        /* Modal Body */
        .modal-body {
            font-family: 'Arial', sans-serif;
            color: #333;
            font-size: 1rem;
            line-height: 1.6;
        }

        /* Form Inputs and Labels */
        label {
            font-weight: bold;
            color: #555;
        }

        input[type="date"],
        input[type="text"] {
            border: none;
            /* Removed border */
            border-radius: 8px;
            padding: 5px;
            width: 100%;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        input[type="date"]:focus,
        input[type="text"]:focus {
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
        }

        /* Radio Buttons */
        .form-check-input[type="radio"] {
            transform: scale(1.2);
            margin-right: 10px;
            outline: none;
            /* Removes the focus outline */
            box-shadow: none !important;
            /* Removes the box-like effect when clicked */
        }

        .form-check-input[type="radio"]:focus {
            box-shadow: none;
            /* Ensures no shadow appears when focused */
        }

        /* Checkbox (No toggle effect) */
        #flexSwitchCheckDefault {
            width: auto;
            height: auto;
            background-color: transparent;
            cursor: pointer;
            transition: none;
            position: relative;
        }

        #flexSwitchCheckDefault:checked {
            background-color: transparent;
        }

        #flexSwitchCheckDefault::after {
            content: none;
        }

        /* Reason Input */
        #reasonInput {
            margin-top: 10px;
        }

        /* Modal Footer Buttons */
        .modal-footer .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background-color 0.3s;
        }

        .modal-footer .btn-primary:hover {
            background-color: #0056b3;
        }

        .modal-footer .btn-secondary {
            background-color: #6c757d;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background-color 0.3s;
        }

        .modal-footer .btn-secondary:hover {
            background-color: #5a6268;
        }




        /* Dropdown styling */
        ul.dropdown-menu {
            background-color: #f8f9fa;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            padding: 7px 0;
            text-align: center;
            opacity: 0;
            /* Start hidden */
            transform: translateY(-20px);
            /* Slightly above */
            /* Smooth transition */
            visibility: hidden;
            /* Initially hidden */
        }

        ul.dropdown-menu.show {
            opacity: 1;
            /* Fully visible */
            transform: translateY(0);
            /* Return to original position */
            visibility: visible;
            /* Visible */
        }

        ul.dropdown-menu li {
            display: block;
        }

        ul.dropdown-menu li a {
            display: block;
            padding: 5px 12px;
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease, color 0.3s ease, transform 0.3s ease;
            /* Smooth hover effect */
        }

        ul.dropdown-menu li a:hover {
            background-color: #e9ecef;
            color: #0056b3;
            border-radius: 10px;
            transform: scale(1.05);
            /* Slight zoom effect on hover */
        }

        /* Center the dropdown items */
        ul.dropdown-menu center {
            display: block;
        }

        /* Animation for dropdown items (staggered effect) */
        ul.dropdown-menu li {
            animation: fadeIn 0.4s ease forwards;
            opacity: 0;
            /* Initially invisible */
        }

        /* Staggering delay for each item */
        ul.dropdown-menu li:nth-child(1) {
            animation-delay: 0.05s;
        }

        ul.dropdown-menu li:nth-child(2) {
            animation-delay: 0.1s;
        }

        ul.dropdown-menu li:nth-child(3) {
            animation-delay: 0.15s;
        }

        ul.dropdown-menu li:nth-child(4) {
            animation-delay: 0.2s;
        }

        ul.dropdown-menu li:nth-child(5) {
            animation-delay: 0.25s;
        }

        ul.dropdown-menu li:nth-child(6) {
            animation-delay: 0.30s;
        }

        /* Keyframes for dropdown items */
        @keyframes fadeIn {
            0% {
                transform: translateY(-20px);
                /* Move vertically */
                opacity: 0;
            }

            100% {
                transform: translateY(0);
                /* Move to original position */
                opacity: 1;
            }
        }

        .modal-header {
            border-bottom: 1px solid #dee2e6;
        }

        .modal-body p {
            margin: 10px 0;
            /* Adds spacing between paragraphs */
        }

        .modal-footer .btn {
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .modal-footer .btn:hover {
            background-color: #e9ecef;
            /* Light background on hover */
            color: black;
        }
    </style>
</head>

<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>


    <div id="main-wrapper">
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

        <aside class="left-sidebar" data-sidebarbg="skin5">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav" class="p-t-30">
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="manager_dash.php" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span
                                    class="hide-menu">Dashboard</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="manager.php" aria-expanded="false"><i class="mdi mdi-border-inside"></i><span
                                    class="hide-menu">Complaints</span></a></li>


                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
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
                        <h4 class="page-title">Complaints</h4>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">

                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary" style="margin-left:1080px;" data-toggle="modal" data-target="#addworker">
                Add worker</button>


            <div class="modal fade" id="addworker" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content" style="border-radius: 8px; border: 1px solid #ccc;">
                        <div class="modal-header" style="background-color: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                            <h5 class="modal-title" id="exampleModalLabel">Add Worker</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="workers">
                            <div class="modal-body" style="padding: 20px; background-color: #f5f5f5;">
                                <input type="text" name="w_name" placeholder="Enter Worker Name" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc; margin-bottom: 15px;">
                                <select id="department" name="w_dept" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc; margin-bottom: 15px;">
                                    <option value="all">Select department</option>
                                    <option value="civil">Civil</option>
                                    <option value="electrical">Electrical</option>
                                    <option value="itkm">itkm</option>

                                </select>


                                <select id="gender" name="w_gender" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc; margin-bottom: 15px;">
                                    <option value="all">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>



                                <input type="text" name="w_phone" placeholder="Enter Phone Number" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc; margin-bottom: 15px;">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" style="background-color: #6c757d; border: none; padding: 10px 20px;">Close</button>
                                <button type="submit" class="btn btn-primary" style="background-color: #007bff; border: none; padding: 10px 20px;">Add</button>
                            </div>
                        </form>
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">


                            <div id="navref">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist" id="navli">
                                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#complain"
                                            role="tab"><span class="hidden-sm-up"></span>
                                            <div id="navref1"> <span
                                                    class="hidden-xs-down"><b>Complaint Raised (<?php echo $row_count1; ?>)</b></span></div>
                                        </a> </li>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#principal"
                                            role="tab"><span class="hidden-sm-up"></span>
                                            <div id="navref2"> <span
                                                    class="hidden-xs-down"><b>Principal Approval (<?php echo $row_count4; ?>)</b></span></div>
                                        </a> </li>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#worker"
                                            role="tab"><span class="hidden-sm-up"></span>
                                            <div id="navref3"> <span
                                                    class="hidden-xs-down"><b>Work Assigned (<?php echo $row_count3; ?>)</b></span> </div>
                                        </a> </li>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#finished"
                                            role="tab"><span class="hidden-sm-up"></span>
                                            <div id="navref4"> <span
                                                    class="hidden-xs-down"><b>Worker Response (<?php echo $row_count5; ?>)</b></span></div>
                                        </a> </li>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#reassigned"
                                            role="tab"><span class="hidden-sm-up"></span>
                                            <div id="navref5"> <span
                                                    class="hidden-xs-down"><b>Work Re-assigned (<?php echo $row_count7; ?>)</b></span></div>
                                        </a> </li>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#completed"
                                            role="tab"><span class="hidden-sm-up"></span><span
                                                class="hidden-xs-down"><b>Work Completed</b></span></a> </li>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#record"
                                            role="tab"><span class="hidden-sm-up"></span> <span
                                                class="hidden-xs-down"><b>Work Record</b></span></a> </li>
                                </ul>
                            </div>

                            <!-- Tab panes -->
                            <div class="tab-content tabcontent-border">

                                <!--Complaint start-->
                                <div class="tab-pane active p-20" id="complain" role="tabpanel">
                                    <div class="p-20">
                                        <div class="table-responsive">
                                            <h5 class="card-title">Complaint Raised</h5>
                                            <table id="complain_table" class="table table-striped table-bordered">
                                                <thead style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                                    <tr>

                                                        <th class="text-center"><b>
                                                                <h5>S.No</h5>
                                                            </b></th>
                                                        <th class="col-md-2 text-center"><b>
                                                                <h5>Raised Date</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Dept / Venue</h5>
                                                            </b></th>

                                                        <th class="col-md-2 text-center"><b>
                                                                <h5>Complaint</h5>
                                                            </b></th>
                                                        <th class="text-center">
                                                            <b>
                                                                <h5>Picture</h5>
                                                            </b>
                                                        </th>
                                                        <th class=" col-md-2 text-center"><b>
                                                                <h5>Action</h5>
                                                            </b></th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $s = 1;
                                                    while ($row = mysqli_fetch_assoc($result1)) {
                                                    ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $s ?></td>
                                                            <td class="text-center"><?php echo $row['date_of_reg'] ?></td>
                                                            <td class="text-center"><?php echo $row['department'] ?> / <?php echo $row['block_venue'] ?></td>

                                                            <td class="text-center"><button type="button" value="<?php echo $row['id']; ?>"
                                                                    class="btn viewcomplaint"
                                                                    data-toggle="modal"
                                                                    data-target="#complaintDetailsModal"><i class="fas fa-eye" style="font-size: 25px;"></i></button>
                                                            </td>

                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-light btn-sm showImage"
                                                                    value="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#imageModal">
                                                                    <i class="fas fa-image" style="font-size: 25px;"></i>
                                                                </button>
                                                            </td>
                                                            <td class="text-center">


                                                            <?php if ($row['status'] == 9) { ?>
                                                                        <button type="button" class="btn btn-warning reassign"
                                                                            id="reassignbutton" value="<?php echo $row['id']; ?>"
                                                                            data-toggle="dropdown">
                                                                            Reassign
                                                                        </button>
                                                                        <ul class="dropdown-menu">

                                                                        <center>
                                                                        <li><a href="#" class="reass1"                                                    
                                                                                data-value="electrical">ELECTRICAL</a></li>
                                                                        <li><a href="#" class="reass1"                                                                                
                                                                                data-value="civil">CIVIL</a></li>
                                                                        <li><a href="#" class="reass1"                                                                                
                                                                                data-value="itkm">ITKM</a></li>
                                                                        <li><a href="#" class="reass1"                                                                                
                                                                                data-value="transport">TRANSPORT</a></li>
                                                                        <li><a href="#" class="reass1"                                                                                
                                                                                data-value="house">HOUSE KEEPING</a></li>
                                                                    </center>
                                                                    
                                                                </ul>


                                                                
              
                                                                    <?php } else { ?>
                                                                        <button type="button"
                                                                    class="btn btn-success  managerapprove"
                                                                    value="<?php echo $row['id']; ?>" data-toggle="dropdown"><i class="fas fa-check"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">

                                                                <center>
                                                                        <li><a href="#" class="worker"
                                                                                data-toggle="modal"
                                                                                data-target="#managerapproveModal"
                                                                                data-value="electrical">ELECTRICAL</a></li>
                                                                        <li><a href="#" class="worker"
                                                                                data-toggle="modal"
                                                                                data-target="#managerapproveModal"
                                                                                data-value="civil">CIVIL</a></li>
                                                                        <li><a href="#" class="worker"
                                                                                data-toggle="modal"
                                                                                data-target="#managerapproveModal"
                                                                                data-value="itkm">ITKM</a></li>
                                                                        <li><a href="#" class="worker"
                                                                                data-toggle="modal"
                                                                                data-target="#managerapproveModal"
                                                                                data-value="transport">TRANSPORT</a></li>
                                                                        <li><a href="#" class="worker"
                                                                                data-toggle="modal"
                                                                                data-target="#managerapproveModal"
                                                                                data-value="house">HOUSE KEEPING</a></li>
                                                                    </center>
                                                                    
                                                                </ul>
                                                                    <?php } ?>



                                                                

                                                                <button type="button" class="btn btn-danger rejectcomplaint"
                                                                    id="rejectbutton" value="<?php echo $row['id']; ?>"
                                                                    data-toggle="modal"
                                                                    data-target="#rejectModal"><i class="fas fa-times"></i></button>

                                                                <button type="button" class="btn btn-primary principalcomplaint"
                                                                    id="principalbutton" value="<?php echo $row['id']; ?>"
                                                                    data-toggle="modal"
                                                                    data-target="#principalModal"><i class="fas fa-paper-plane"></i>
                                                                </button>
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

                                <!-- Principal Table -->
                                <div class="tab-pane p-20" id="principal" role="tabpanel">
                                    <div class="p-20">
                                        <div class="table-responsive">
                                            <h5 class="card-title">Principal Approval</h5>
                                            <table id="principal_table" class="table table-striped table-bordered">
                                                <thead style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                                    <tr>

                                                        <th class="text-center"><b>
                                                                <h5>S.No</h5>
                                                            </b></th>
                                                        <th class="col-md-2 text-center"><b>
                                                                <h5>Raised Date</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Venue</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Complaint</h5>
                                                            </b></th>
                                                        <th class="text-center">
                                                            <b>
                                                                <h5>Picture</h5>
                                                            </b>
                                                        </th>
                                                        <th class=" col-md-2 text-center"><b>
                                                                <h5>Action</h5>
                                                            </b></th>
                                                        <th class=" col-md-2 text-center"><b>
                                                                <h5>Status</h5>
                                                            </b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $s = 1;
                                                    while ($row4 = mysqli_fetch_assoc($result4)) {
                                                    ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $s ?></td>
                                                            <td class="text-center"><?php echo $row4['date_of_reg'] ?></td>
                                                            <td class="text-center"><?php echo $row4['block_venue'] ?></td>
                                                            <td class="text-center">
                                                                <button type="button" value="<?php echo $row4['id']; ?>"
                                                                    class="btn viewcomplaint"
                                                                    data-toggle="modal"
                                                                    data-target="#complaintDetailsModal">
                                                                    <i class="fas fa-eye" style="font-size: 25px;"></i>
                                                                </button>
                                                            </td>

                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-light btn-sm showImage"
                                                                    value="<?php echo $row4['id']; ?>" data-toggle="modal" data-target="#imageModal">
                                                                    <i class="fas fa-image" style="font-size: 25px;"></i>
                                                                </button>
                                                            </td>
                                                            <td class="text-center">
                                                                <?php if ($row4['status'] == '8') { ?>
                                                                    <button type="button"
                                                                        class="btn btn-success managerapprove"
                                                                        value="<?php echo $row4['id']; ?>" data-toggle="modal"
                                                                        data-target="#managerapproveModal">
                                                                        <i class="fas fa-check"></i></button>

                                                                <?php }
                                                                if ($row4['status'] == '19') { ?>
                                                                    <button type="button"
                                                                        class="btn btn-primary"
                                                                        value="<?php echo $row4['id']; ?>">
                                                                        Okay</button>
                                                                <?php } ?>

                                                            </td>
                                                            <td class="text-center">
                                                                <?php if ($row4['status'] == '8') { ?>
                                                                    <span class="btn btn-success">Approved</span>

                                                                <?php }
                                                                if ($row4['status'] == '19') { ?>
                                                                    <button type="button" class="btn btn-danger rejectreasonbtn" value="<?php echo $row4['id']; ?>" data-toggle="modal"
                                                                        data-target="#princerejectres">Rejected</button>
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

                                <!-- Worker Table -->
                                <div class="tab-pane p-20" id="worker" role="tabpanel">
                                    <div class="p-20">
                                        <div class="table-responsive">
                                            <h5 class="card-title">Ongoing Work's</h5>
                                            <table id="worker_table" class="table table-striped table-bordered">
                                                <thead style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                                    <tr>

                                                        <th class="text-center"><b>
                                                                <h5>S.No</h5>
                                                            </b></th>
                                                        <th class="col-md-2 text-center"><b>
                                                                <h5>Complaint</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Worker</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Deadline</h5>
                                                            </b></th>
                                                        <th class="col-md-2 text-center"><b>
                                                                <h5>Picture</h5>
                                                            </b></th>
                                                        <th class="text-center">
                                                            <b>
                                                                <h5>Status</h5>
                                                            </b>
                                                        </th>
                                                        <th class=" col-md-2 text-center"><b>
                                                                <h5>Principal Query</h5>
                                                            </b></th>
                                                        <th class=" col-md-2 text-center"><b>
                                                                <h5>Your Reply</h5>
                                                            </b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $s = 1;
                                                    $current_date = date('Y-m-d'); // Get current date in 'YYYY-MM-DD' format

                                                    while ($row3 = mysqli_fetch_assoc($result3)) {
                                                        $deadline = $row3['days_to_complete'];
                                                        $h = $row3['id']; // complaint id

                                                        // Fetch query from manager table
                                                        $querydisplay = "SELECT * FROM manager WHERE problem_id=$h";
                                                        $resultdisplay = mysqli_query($conn, $querydisplay);
                                                        $rowdis = mysqli_fetch_assoc($resultdisplay);
                                                        $comment_query = $rowdis['comment_query'];
                                                        $comment_reply = $rowdis['comment_reply']; // Fetch the reply
                                                        $reply_date = $rowdis['reply_date']; // Fetch the reply date
                                                        $task_id = $rowdis['task_id']; // Unique ID from manager table

                                                        // Check if comment_reply has a value to assign the green color class
                                                        $buttonClass = empty($comment_reply) ? 'btn-primary' : 'btn-success';

                                                        // Check if current date is equal to or greater than the deadline
                                                        $rowBackground = ($current_date >= $deadline) ? 'background-color: #ffcccc;' : '';
                                                    ?>
                                                        <tr style="<?php echo $rowBackground; ?>">
                                                            <td class="text-center"><?php echo $s ?></td>
                                                            <td class="text-center">
                                                                <button type="button" value="<?php echo $row3['id']; ?>"
                                                                    class="btn viewcomplaint"
                                                                    data-toggle="modal"
                                                                    data-target="#complaintDetailsModal"><i class="fas fa-eye" style="font-size: 25px;"></i></button>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-light worker_det" value="<?php echo $row3["id"]; ?>" data-toggle="modal"
                                                                    data-target="#workerdetailmodal">
                                                                    <?php
                                                                    $prblm_id = $row3['id'];
                                                                    $querry = "SELECT worker_first_name FROM worker_details WHERE worker_id = ( SELECT worker_dept FROM manager WHERE problem_id = '$prblm_id')";
                                                                    $querry_run = mysqli_query($conn, $querry);
                                                                    $worker_name = mysqli_fetch_array($querry_run);
                                                                    echo $worker_name['worker_first_name']; ?>
                                                                </button>
                                                            </td>
                                                            <td class="text-center"> <button class="btn btn-light deadline_extend"
                                                                    value="<?php echo $row3["id"]; ?>" data-toggle="modal"
                                                                    data-target="#extend_date">

                                                                    <?php echo $row3['days_to_complete'] ?></button></td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-light btn-sm showImage"
                                                                    value="<?php echo $row3['id']; ?>" data-toggle="modal" data-target="#imageModal">
                                                                    <i class="fas fa-image" style="font-size: 25px;"></i>
                                                                </button>
                                                            </td>
                                                            <td class="text-center"><span class="btn btn-warning">In Progress</span></td>

                                                            <td class="text-center">
                                                                <button type="button"
                                                                    class="btn <?php echo $buttonClass; ?> openQueryModal"
                                                                    data-task-id="<?php echo $task_id; ?>"
                                                                    data-comment-query="<?php echo $comment_query; ?>"
                                                                    data-toggle="modal"
                                                                    data-target="#principalQueryModal"
                                                                    <?php echo empty($comment_query) ? 'disabled' : ''; ?>>
                                                                    <?php echo empty($comment_query) ? 'No Query' : 'View Query'; ?>
                                                                </button>
                                                            </td>
                                                            <!-- Display Comment Reply and Date if available -->
                                                            <td>
                                                                <?php if (!empty($comment_reply)): ?>
                                                                    <span> <?php echo $comment_reply; ?></span>
                                                                    <br>
                                                                    <span class="">Reply Date: <?php echo $reply_date; ?></span>
                                                                <?php else: ?>
                                                                    <span class="badge badge-secondary">No Reply Yet</span>
                                                                <?php endif; ?>
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

                                <!-- Work Finished Table -->
                                <div class="tab-pane p-20" id="finished" role="tabpanel">
                                    <div class="p-20">
                                        <div class="table-responsive">
                                            <h5 class="card-title">Work's for Response</h5>
                                            <table id="finished_table" class="table table-striped table-bordered">
                                                <thead style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                                    <tr>

                                                        <th class="text-center"><b>
                                                                <h5>S.No</h5>
                                                            </b></th>
                                                        <th class="col-md-2 text-center"><b>
                                                                <h5>Complaint</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Worker</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Completion Date</h5>
                                                            </b></th>
                                                        <th class="col-md-2 text-center"><b>
                                                                <h5>Picture</h5>
                                                            </b></th>
                                                        <th class="text-center">
                                                            <b>
                                                                <h5>Faculty Feedback</h5>
                                                            </b>
                                                        </th>
                                                        <th class=" col-md-2 text-center"><b>
                                                                <h5>Status</h5>
                                                            </b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $s = 1;
                                                    while ($row5 = mysqli_fetch_assoc($result5)) {
                                                    ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $s ?></td>
                                                            <td class="text-center">
                                                                <button type="button" value="<?php echo $row5['id']; ?>"
                                                                    class="btn viewcomplaint"
                                                                    data-toggle="modal"
                                                                    data-target="#complaintDetailsModal">
                                                                    <i class="fas fa-eye" style="font-size: 25px;"></i>
                                                                </button>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-light worker_det" value="<?php echo $row5["id"]; ?>" data-toggle="modal"
                                                                    data-target="#workerdetailmodal">
                                                                    <?php
                                                                        $prblm_id = $row5['id'];
                                                                        $querry = "SELECT worker_first_name FROM worker_details WHERE worker_id = ( SELECT worker_dept FROM manager WHERE problem_id = '$prblm_id')";
                                                                        $querry_run = mysqli_query($conn, $querry);
                                                                        $worker_name = mysqli_fetch_array($querry_run);
                                                                        if($worker_name['worker_first_name']!= null){
                                                                            echo $worker_name['worker_first_name']; 
                                                                        }
                                                                        else {
                                                                            echo "NA";
                                                                        }
                                                                       ?>
                                                                </button>
                                                            </td>
                                                            <td class="text-center"><?php echo $row5['date_of_completion'] ?></td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-light btn-sm showImage"
                                                                    value="<?php echo $row5['id']; ?>" data-toggle="modal" data-target="#imageModal">
                                                                    <i class="fas fa-image" style="font-size: 25px;"></i>
                                                                </button>
                                                                <button value="<?php echo $row5['id']; ?>" type="button"
                                                                    class="btn btn-light btn-sm imgafter"
                                                                    data-toggle="modal">
                                                                    <i class="fas fa-images" style="font-size: 25px;"></i>
                                                                </button>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-primary facfeed"
                                                                    value="<?php echo $row5['id']; ?>" data-toggle="modal"
                                                                    data-target="#exampleModal">
                                                                    Feedback
                                                                </button>
                                                            </td>
                                                            <td class="text-center">
                                                                <span
                                                                    class="btn btn-success"><?php echo $row5['task_completion'] ?></span>
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

                                <!-- Resigned Table -->
                                <div class="tab-pane p-20" id="reassigned" role="tabpanel">
                                    <div class="p-20">
                                        <div class="table-responsive">
                                            <h5 class="card-title">Reassigned Work's</h5>
                                            <table id="reassigned_table" class="table table-striped table-bordered">
                                                <thead style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                                    <tr>

                                                        <th class="text-center"><b>
                                                                <h5>S.No</h5>
                                                            </b></th>
                                                        <th class="col-md-2 text-center"><b>
                                                                <h5>Complaint</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Worker</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Date of Reassigned</h5>
                                                            </b></th>
                                                        <th class="col-md-2 text-center"><b>
                                                                <h5>Deadline</h5>
                                                            </b></th>
                                                        <th class="text-center">
                                                            <b>
                                                                <h5>Picture</h5>
                                                            </b>
                                                        </th>
                                                        <th class=" col-md-2 text-center"><b>
                                                                <h5>Faculty Feedback</h5>
                                                            </b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $s = 1;
                                                    while ($row7 = mysqli_fetch_assoc($result7)) {
                                                    ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $s ?></td>
                                                            <td class="text-center">
                                                                <button type="button" value="<?php echo $row7['id']; ?>"
                                                                    class="btn viewcomplaint"
                                                                    data-toggle="modal"
                                                                    data-target="#complaintDetailsModal">
                                                                    <i class="fas fa-eye" style="font-size: 25px;"></i>
                                                                </button>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-light worker_det" value="<?php echo $row7["id"]; ?>" data-toggle="modal"
                                                                    data-target="#workerdetailmodal">
                                                                    <?php
                                                                    $prblm_id = $row7['id'];
                                                                    $querry = "SELECT worker_first_name FROM worker_details WHERE worker_id = ( SELECT worker_id FROM manager WHERE problem_id = '$prblm_id')";
                                                                    $querry_run = mysqli_query($conn, $querry);
                                                                    $worker_name = mysqli_fetch_array($querry_run);
                                                                    echo $worker_name['worker_first_name']; ?>
                                                                </button>
                                                            </td>
                                                            <td class="text-center"><?php echo $row7['reassign_date'] ?></td>
                                                            <td class="text-center"><?php echo $row7['days_to_complete'] ?></td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-light btn-sm showImage"
                                                                    value="<?php echo $row7['id']; ?>" data-toggle="modal" data-target="#imageModal">
                                                                    <i class="fas fa-image" style="font-size: 25px;"></i>
                                                                </button>
                                                                <button value="<?php echo $row7['id']; ?>" type="button"
                                                                    class="btn btn-light btn-sm imgafter"
                                                                    data-toggle="modal">
                                                                    <i class="fas fa-images" style="font-size: 25px;"></i>
                                                                </button>
                                                            </td>
                                                            <td class="text-center">
                                                                <?php echo $row7['feedback']; ?>
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

                                <!-- Completed Table -->
                                <div class="tab-pane p-20" id="completed" role="tabpanel">
                                    <div class="p-20">
                                        <div class="table-responsive">
                                            <h5 class="card-title">Work's Completed</h5>
                                            <table id="completed_table" class="table table-striped table-bordered">
                                                <thead style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                                    <tr>

                                                        <th class="text-center"><b>
                                                                <h5>S.No</h5>
                                                            </b></th>
                                                        <th class="col-md-2 text-center"><b>
                                                                <h5>Complaint</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Worker</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Date of Completion</h5>
                                                            </b></th>
                                                        <th class="col-md-2 text-center"><b>
                                                                <h5>Picture</h5>
                                                            </b></th>
                                                        <th class=" col-md-2 text-center"><b>
                                                                <h5>Faculty Feedback</h5>
                                                            </b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $s = 1;
                                                    while ($row6 = mysqli_fetch_assoc($result6)) {
                                                    ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $s ?></td>
                                                            <td class="text-center">
                                                                <button type="button" value="<?php echo $row6['id']; ?>"
                                                                    class="btn viewcomplaint"
                                                                    data-toggle="modal"
                                                                    data-target="#complaintDetailsModal">
                                                                    <i class="fas fa-eye" style="font-size: 25px;"></i>
                                                                </button>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-light worker_det" value="<?php echo $row6["id"]; ?>" data-toggle="modal"
                                                                    data-target="#workerdetailmodal">
                                                                    <?php
                                                                    $prblm_id = $row6['id'];
                                                                    $querry = "SELECT worker_first_name FROM worker_details WHERE worker_id = ( SELECT worker_dept FROM manager WHERE problem_id = '$prblm_id')";
                                                                    $querry_run = mysqli_query($conn, $querry);
                                                                    $worker_name = mysqli_fetch_array($querry_run);
                                                                    echo $worker_name['worker_first_name']; ?>
                                                                </button>
                                                            </td>
                                                            <td class="text-center"><?php echo $row6['date_of_completion'] ?></td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-light btn-sm showImage"
                                                                    value="<?php echo $row6['id']; ?>" data-toggle="modal" data-target="#imageModal">
                                                                    <i class="fas fa-image" style="font-size: 25px;"></i>
                                                                </button>
                                                                <button value="<?php echo $row6['id']; ?>" type="button"
                                                                    class="btn btn-light btn-sm imgafter"
                                                                    data-toggle="modal">
                                                                    <i class="fas fa-images" style="font-size: 25px;"></i>
                                                                </button>
                                                            </td>
                                                            <td class="text-center">
                                                                <?php echo $row6['feedback']; ?>
                                                            </td>
                                                            <!-- <td>
                                                                <span class="btn btn-success">Completed</span>
                                                            </td> -->
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


                                <!-- Record Table -->

                                <?php
                                // Set default month as the current month if no input is provided
                                $selectedMonth = isset($_POST['selectmonth']) ? $_POST['selectmonth'] : date('m');

                                // Fetch data based on the selected month
                                $sql8 = "SELECT * FROM complaints_detail WHERE status='16' AND MONTH(date_of_completion) = $selectedMonth AND YEAR(date_of_completion) = YEAR(CURDATE())";
                                $result8 = mysqli_query($conn, $sql8);
                                ?>

                                <div class="tab-pane p-20" id="record" role="tabpanel">
                                    <div class="p-20">
                                        <div class="table-responsive">
                                            <h5 class="card-title">Work Completed Records</h5>

                                            <form method="POST" action="">
                                                <label for="selectmonth">Select Month (1-12): </label>
                                                <input type="number" name="selectmonth" min="1" max="12" value="<?php echo $selectedMonth; ?>" required>
                                                <button type="submit" class="btn btn-primary">Enter</button>
                                            </form><span style="float:right">
                                                <button id="download" class="btn btn-success">Download as Excel</button></span><br><br>

                                            <table id="record_table" class="table table-striped table-bordered">
                                                <thead style="background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color: white;">
                                                    <tr>
                                                        <th class="text-center"><b>
                                                                <h5>S.No</h5>
                                                            </b></th>
                                                        <th class="col-md-2 text-center"><b>
                                                                <h5>Work ID</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Venue Details</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Completed Details</h5>
                                                            </b></th>
                                                        <th class="text-center">
                                                            <b>
                                                                <h5>Completed On</h5>
                                                            </b>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $s = 1;
                                                    while ($row = mysqli_fetch_assoc($result8)) {
                                                        $pid = $row['id'];
                                                    ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $s ?></td>
                                                            <td class="text-center"><?php echo $row['id'] ?></td>
                                                            <td class="text-center">Venue: <?php echo $row['block_venue'] ?> | <br>Problem: <?php echo $row['problem_description'] ?></td>
                                                            <td class="text-center">
                                                                <?php
                                                                $id = "SELECT * FROM manager WHERE problem_id=$pid";
                                                                $query_run1 = mysqli_query($conn, $id);
                                                                $roww = mysqli_fetch_array($query_run1);
                                                                $worker_id = $roww['worker_id'];

                                                                // Fetch worker details
                                                                $query = "SELECT * FROM worker_details WHERE worker_id='$worker_id'";
                                                                $query_run = mysqli_query($conn, $query);
                                                                $User_data = mysqli_fetch_array($query_run); ?>
                                                                Completed by: <?php echo $User_data['worker_first_name'] ?> | <br>
                                                                Department: <?php echo $User_data['worker_dept'] ?>
                                                            </td>
                                                            <td class="text-center"><?php echo $row['date_of_completion'] ?></td>
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

                            <!--Modals-->


                            <!-- Reject Modal -->
                            <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog"
                                aria-labelledby="rejectModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="rejectModalLabel">Reject Complaint</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="rejectForm">
                                                <input type="hidden" name="id" id="complaint_id99">
                                                <div class="form-group">
                                                    <label for="rejectReason" class="form-label">Reason for
                                                        rejection</label>
                                                    <textarea class="form-control" name="feedback"
                                                        id="rejectReason" rows="3"
                                                        placeholder="Type the reason here..."></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- manager approve -->
                            <div class="modal fade" id="managerapproveModal" tabindex="-1" role="dialog"
                                aria-labelledby="managerapproveModalLabel1" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="managerapproveModalLabel1">Approval Modal</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="managerapproveForm">
                                                <input type="hidden" name="problem_id" id="complaint_id56">

                                                <input type="hidden" name="worker_id" id="worker_id" value="">
                                                <p id="assignedWorker">Assigned Worker: </p>

                                                <!--deadline code-->
                                                <label for="deadline"><span class="font-weight-bold" style="display: block; margin-bottom: 10px;">Set Deadline:</span></label> <br>
                                                <input type="date" id="deadline01" name="deadline"> <br> <br>
                                                <span class="font-weight-bold" style="display: block; margin-bottom: 10px;">Set Priority:</span>
                                                <ul class="list-group" style="list-style: none; padding: 0;">
                                                    <li class="list-group-item" style="padding: 10px; background-color: #ffffff; border: 1px solid #ddd; border-radius: 4px; margin-bottom: 5px;">
                                                        <input type="radio" class="form-check-input" name="priority" value="High" required>
                                                        <label class="form-check-label">High</label>
                                                    </li>
                                                    <li class="list-group-item" style="padding: 10px; background-color: #ffffff; border: 1px solid #ddd; border-radius: 4px; margin-bottom: 5px;">
                                                        <input type="radio" class="form-check-input" name="priority" value="Medium">
                                                        <label class="form-check-label">Medium</label>
                                                    </li>
                                                    <li class="list-group-item" style="padding: 10px; background-color: #ffffff; border: 1px solid #ddd; border-radius: 4px;">
                                                        <input type="radio" class="form-check-input" name="priority" value="Low">
                                                        <label class="form-check-label">Low</label>
                                                    </li>
                                                </ul>
                                                <br>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary" form="managerapproveForm"
                                                id="submitButton">Submit</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!--Principal Approve Modal -->
                            <div class="modal fade" id="principalModal" tabindex="-1" role="dialog"
                                aria-labelledby="principalModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="principalModalLabel">Need Approval</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="principal_Form">
                                                <input type="hidden" name="id" id="complaint_id89">
                                                <div class="form-group">
                                                    <label for="approvalReason" class="form-label">Reason for
                                                        Approval</label>
                                                    <textarea class="form-control" name="reason"
                                                        id="approvalReason" rows="3"
                                                        placeholder="Type the reason here..."></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Complaint Details Modal -->
                            <div class="modal fade" id="complaintDetailsModal" tabindex="-1" role="dialog" aria-labelledby="complaintDetailsModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content" style="border-radius: 8px; box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15); background-color: #f9f9f9;">

                                        <!-- Modal Header -->
                                        <div class="modal-header" style="background-color: #007bff; color: white; border-radius: 8px 8px 0 0; padding: 15px;">
                                            <h5 class="modal-title" id="complaintDetailsModalLabel" style="font-weight: 700; font-size: 1.4em; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                                                📋 Complaint Details
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; font-size: 1.2em;">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <!-- Modal Body -->
                                        <div class="modal-body" style="padding: 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

                                            <!-- Complaint Info Section arranged in two-column layout -->
                                            <div class="row">
                                                <!-- Left Column -->
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label class="fw-bold" style="color: #007bff;">Complaint ID</label>
                                                        <div class="text-muted"><b id="id"></b></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label class="fw-bold" style="color: #007bff;">Faculty Name</label>
                                                        <div class="text-muted"><b id="faculty_name"></b></div>
                                                    </div>
                                                </div>

                                                <!-- Right Column -->
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label class="fw-bold" style="color: #007bff;">Mobile Number</label>
                                                        <div class="text-muted"><b id="faculty_contact"></b></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label class="fw-bold" style="color: #007bff;">E-mail</label>
                                                        <div class="text-muted"><b id="faculty_mail"></b></div>
                                                    </div>
                                                </div>

                                                <!-- New row for Venue and Type of Problem -->
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label class="fw-bold" style="color: #007bff;">Venue Name</label>
                                                        <div class="text-muted"><b id="venue_name"></b></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label class="fw-bold" style="color: #007bff;">Type of Problem</label>
                                                        <div class="text-muted"><b id="type_of_problem"></b></div>
                                                    </div>
                                                </div>

                                                <!-- Full width for Problem Description -->
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="fw-bold" style="color: #007bff;">Problem Description</label>
                                                        <div class="alert alert-light" role="alert" style="border-radius: 6px; background-color: #f1f1f1; padding: 15px; color: #333;">
                                                            <span id="problem_description"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <!-- Modal Footer with Save Button -->
                                        <div class="modal-footer" style="background-color: #f1f1f1; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px; padding: 10px;">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Before Image Modal -->
                            <div class="modal fade" id="imageModal" tabindex="-1" role="dialog"
                                aria-labelledby="imageModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="imageModalLabel">Image</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <img id="modalImage" src="" alt="Image" class="img-fluid"
                                                style="width: 100%; height: auto;">
                                            <!-- src will be set dynamically -->
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Principal Question Modal -->
                            <div class="modal fade" id="principalQueryModal" tabindex="-1" role="dialog"
                                aria-labelledby="principalQueryLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="principalQueryLabel">Principal's Query
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Question from comment_query -->
                                            <p id="commentQueryText"></p>
                                            <!-- Input for reply -->
                                            <div class="form-group">
                                                <label for="commentReply">Your Reply</label>
                                                <input type="text" class="form-control" id="commentReply"
                                                    placeholder="Enter your reply">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary"
                                                id="submitReply">Submit Reply</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- After Image Modal -->
                            <div class="modal fade" id="afterImageModal" tabindex="-1" role="dialog"
                                aria-labelledby="afterImageModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="afterImageModalLabel">After Picture</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img id="modalImage2" src="" alt="After" class="img-fluid">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--Faculty Feedback Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Faculty Feedback</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <textarea name="ffeed" id="ffeed" readonly></textarea>
                                            <!-- Change to complaintfeed_id -->
                                            <input type="hidden" id="complaintfeed_id" value="">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-success done"
                                                data-dismiss="modal">Done</button>
                                            <button type="button" class="btn btn-danger reass">Reassign</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Reassign deadline Modal -->
                            <div class="modal fade" id="datePickerModal" tabindex="-1" role="dialog" aria-labelledby="datePickerModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="datePickerModalLabel">Set Reassign Deadline</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <label for="reassign_deadline">Reassign Deadline Date:</label>
                                            <input type="date" id="reassign_deadline" name="reassign_deadline" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-primary" id="saveDeadline">Set Deadline</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--Principal Reject Reason Modal -->
                            <div class="modal fade" id="princerejectres" tabindex="-1" role="dialog"
                                aria-labelledby="princerejectresLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="princerejectresLabel">Rejected reason</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <textarea name="feedback" id="feedback" readonly></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--Worker detail Modal -->
                            <div class="modal fade" id="workerdetailmodal" tabindex="-1" role="dialog" aria-labelledby="workerdetailmodalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="workerdetailmodalLabel">Worker Mobile Number</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="d-flex justify-content-between align-items-center p-3" style="background-color: #f9f9f9; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
                                                <div>
                                                    <span id="worker_mobile" class="font-weight-bold" style="font-size: 1.25rem; color: #555;">9629613708</span>
                                                </div>
                                                <div>
                                                    <a href="#" id="callWorkerBtn" class="btn btn-success" style="padding: 8px 16px; font-size: 0.9rem; border-radius: 25px;">Call Worker</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--extend_deadline date Modal -->
                            <div class="modal fade" id="extend_date" tabindex="-1" role="dialog" aria-labelledby="extend_dateLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="extend_dateLabel">Dead-line extend</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="extenddead">
                                                <input type="hidden" name="id" id="deadline_id">
                                                <label for="extend_deadline">Extend Deadline Date:</label>
                                                <input type="date" id="extend_deadline" name="extend_deadline" required> <br> <br>
                                                <label for="extendReason" class="form-label">Reason for
                                                        Extend:</label>
                                                    <textarea class="form-control" name="reason"
                                                        id="extendReason" rows="3"
                                                        placeholder="Type the reason here..."></textarea>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Set Deadline</button>
                                                </div>
                                            </form>
                                        </div>
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
                <footer class="footer text-center">
                    <b>2024 © M.Kumarasamy College of Engineering All Rights Reserved.<br>
                        Developed and Maintained by Technology Innovation Hub.
                    </b>
                </footer>
                <!-- ============================================================== -->
                <!-- End footer -->
                <!-- ============================================================== -->

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
            <!-- jQuery -->
            <script src="assets/libs/jquery/dist/jquery.min.js"></script>

            <!-- Datatables -->
            <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>

            <!-- Perfect Scrollbar -->
            <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>

            <!-- Bootstrap tether Core JavaScript -->
            <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
            <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>

            <!-- Other Scripts -->
            <script src="assets/extra-libs/sparkline/sparkline.js"></script>
            <script src="dist/js/waves.js"></script>
            <script src="dist/js/sidebarmenu.js"></script>
            <script src="dist/js/custom.min.js"></script>

            <!-- Popper.js for Bootstrap 4 -->
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
                integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
                crossorigin="anonymous"></script>

            <!-- JavaScript Sweetalert-->
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

            <!-- JavaScript Alertify-->
            <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>

            <!--Download as XL-Sheet-->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>



            <script>
                //Tool Tip
                $(function() {
                    // Initialize the tooltip
                    $('[data-toggle="tooltip"]').tooltip();

                    // You can also set options manually if needed
                    $('.rejectcomplaint').tooltip({
                        placement: 'top',
                        title: 'Reject'
                    });
                });

                $(function() {
                    // Initialize the tooltip
                    $('[data-toggle="tooltip"]').tooltip();

                    // You can also set options manually if needed
                    $('.managerapprove').tooltip({
                        placement: 'top',
                        title: 'Accept'
                    });
                });

                $(function() {
                    // Initialize the tooltip
                    $('[data-toggle="tooltip"]').tooltip();

                    // You can also set options manually if needed
                    $('.principalcomplaint').tooltip({
                        placement: 'top',
                        title: 'Principal Approval'
                    });
                });

                $(function() {
                    // Initialize the tooltip
                    $('[data-toggle="tooltip"]').tooltip();

                    // You can also set options manually if needed
                    $('.showImage').tooltip({
                        placement: 'top',
                        title: 'Before'
                    });
                });

                $(function() {
                    // Initialize the tooltip
                    $('[data-toggle="tooltip"]').tooltip();

                    // You can also set options manually if needed
                    $('.imgafter').tooltip({
                        placement: 'top',
                        title: 'After'
                    });
                });

                $(function() {
                    // Initialize the tooltip
                    $('[data-toggle="tooltip"]').tooltip();

                    // You can also set options manually if needed
                    $('.viewcomplaint').tooltip({
                        placement: 'top',
                        title: 'View Complaint'
                    });
                });


                $(document).ready(function() {
                    $("#principal_table").DataTable();
                });
                $(document).ready(function() {
                    $("#complain_table").DataTable();
                });
                $(document).ready(function() {
                    $("#worker_table").DataTable();
                });
                $(document).ready(function() {
                    $("#finished_table").DataTable();
                });
                $(document).ready(function() {
                    $("#reassigned_table").DataTable();
                });
                $(document).ready(function() {
                    $("#completed_table").DataTable();
                });
                $(document).ready(function() {
                    $("#record_table").DataTable();
                });
            </script>
            <script>
                //reject complaint
                $(document).on("click", "#rejectbutton", function(e) {
                    e.preventDefault();
                    var user_id = $(this).val(); // Get the ID from the button's value
                    console.log("User ID:", user_id);
                    // Set the user_id in the hidden input field within the form
                    $("#complaint_id99").val(user_id);
                });
                $(document).on("submit", "#rejectForm", function(e) {
                    e.preventDefault();
                    var formData = new FormData(this);
                    formData.append("reject_complaint", true);

                    $.ajax({
                        type: "POST",
                        url: "testbackend.php",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            var res = jQuery.parseJSON(response);

                            if (res.status == 200) {

                                alert("Are you sure? you want to reject it!!");
                                alertify.set('notifier', 'position', 'top-right');
                                alertify.error('Rejected');
                                // Close modal
                                $("#navref1").load(location.href + " #navref1");
                                $("#navref2").load(location.href + " #navref2");



                                $("#rejectModal").modal("hide");

                                // Reset the form
                                $("#rejectForm")[0].reset();
                                // Force refresh the table body with cache bypass

                                // Before loading new content, destroy the existing DataTable instance
                                $('#complain_table').DataTable().destroy();

                                $("#complain_table").load(location.href + " #complain_table > *", function() {
                                    // Reinitialize the DataTable after the content is loaded
                                    $('#complain_table').DataTable();
                                });

                                // Display success message
                            } else if (res.status == 500) {
                                $("#rejectModal").modal("hide");
                                $("#rejectForm")[0].reset();
                                alert("Something went wrong. Please try again.");
                            }
                        },
                        error: function(xhr, status, error) {
                            alert("An error occurred while processing your request.");
                        },
                    });
                });


                //pass worker department tp approve model
                //approve by manager
                $(document).on("click", ".managerapprove", function(e) {
                    e.preventDefault();
                    var user_id = $(this).val(); // Get the ID from the button's value
                    console.log("User ID:", user_id);
                    // pass id to model - form
                    $("#complaint_id56").val(user_id);

                    // Reset the worker selection in modal for next selection
                    $("#worker_id").val('');
                    $("#assignedWorker").text('Assigned Worker: ');
                });

                $(document).on('click', ".worker", function(e) {
                    e.preventDefault();
                    var worker = $(this).data('value');

                    console.log(worker);

                    //pass values to model
                    $("#worker_id").val(worker);
                    $("#assignedWorker").text("Assigned Worker: " + worker);
                })
                
                //reassign for manager
                $(document).on("click", ".reassign", function(e) {
                    e.preventDefault();
                    var user_id = $(this).val(); // Get the ID from the button's value
                    console.log("User ID:", user_id);

                    $(document).data("user_id2", user_id);
                                  
                });

                $(document).on('click', ".reass1", function(e) {
                    e.preventDefault();
                    var worker = $(this).data('value');
                    var user_id = $(document).data("user_id2");

                    console.log(worker);
                    console.log("User ID:", user_id);

                    $.ajax({
                        url: "testbackend.php",
                        type: "POST",
                        data: {
                user_id: user_id,
                worker: worker,
                reassign_complaint: true,
            },
                        success: function(response) {
                            var res = jQuery.parseJSON(response);
                            console.log(res);
                            if (res.status == 200) {
                                swal({
                                    title: "success!",
                                    text: "Complaint accepted sucessfully!",
                                    icon: "success",
                                    button: "Ok",
                                    timer: null
                                });

                                $("#managerapproveModal").modal("hide");

                                // Reset the form
                                $("#managerapproveForm")[0].reset();


                                $('#complain_table').DataTable().destroy();
                                $('#principal_table').DataTable().destroy();

                                $("#complain_table").load(location.href + " #complain_table > *", function() {
                                    // Reinitialize the DataTable after the content is loaded
                                    $('#complain_table').DataTable();
                                });
                                $("#principal_table").load(location.href + " #principal_table > *", function() {
                                    // Reinitialize the DataTable after the content is loaded
                                    $('#principal_table').DataTable();
                                });
                                $("#navref1").load(location.href + " #navref1");
                                $("#navref2").load(location.href + " #navref2");



                            } else {
                                alert("Failed to accept complaint");
                            }
                        },
                    });

                    
                });

                $(document).on("submit", "#managerapproveForm", function(e) {
                    e.preventDefault();
                    var data = new FormData(this);
                    console.log(data);
                    data.append("manager_approve", true);

                    $.ajax({
                        url: "testbackend.php",
                        type: "POST",
                        data: data,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            var res = jQuery.parseJSON(response);
                            console.log(res);
                            if (res.status == 200) {
                                swal({
                                    title: "success!",
                                    text: "Complaint accepted sucessfully!",
                                    icon: "success",
                                    button: "Ok",
                                    timer: null
                                });

                                $("#managerapproveModal").modal("hide");

                                // Reset the form
                                $("#managerapproveForm")[0].reset();


                                $('#complain_table').DataTable().destroy();
                                $('#principal_table').DataTable().destroy();

                                $("#complain_table").load(location.href + " #complain_table > *", function() {
                                    // Reinitialize the DataTable after the content is loaded
                                    $('#complain_table').DataTable();
                                });
                                $("#principal_table").load(location.href + " #principal_table > *", function() {
                                    // Reinitialize the DataTable after the content is loaded
                                    $('#principal_table').DataTable();
                                });
                                $("#navref1").load(location.href + " #navref1");
                                $("#navref2").load(location.href + " #navref2");



                            } else {
                                alert("Failed to accept complaint");
                            }
                        },
                    });
                });


                //Principal approval
                $(document).on("click", "#principalbutton", function(e) {
                    e.preventDefault();
                    var user_id = $(this).val(); // Get the ID from the button's value
                    console.log("User ID:", user_id);
                    // Set the user_id in the hidden input field within the form
                    $("#complaint_id89").val(user_id);
                });
                $(document).on("submit", "#principal_Form", function(e) {
                    e.preventDefault();
                    var formData = new FormData(this);
                    formData.append("principal_complaint", true);

                    $.ajax({
                        type: "POST",
                        url: "testbackend.php",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            var res = jQuery.parseJSON(response);

                            if (res.status == 200) {

                                swal({
                                    title: "success!",
                                    text: "Complaint sent to Principal sucessfully!",
                                    icon: "success",
                                    button: "Ok",
                                    timer: null
                                });
                                // Close modal
                                $("#principalModal").modal("hide");

                                // Reset the form
                                $("#principal_Form")[0].reset();
                                // Force refresh the table body with cache bypass
                                $('#complain_table').DataTable().destroy();
                                $("#complain_table").load(location.href + " #complain_table > *", function() {
                                    // Reinitialize the DataTable after the content is loaded
                                    $('#complain_table').DataTable();
                                });
                                $("#navref1").load(location.href + " #navref1");
                                $("#navref2").load(location.href + " #navref2");



                                // Display success message
                            } else if (res.status == 500) {
                                $("#principalModal").modal("hide");
                                $("#principal_Form")[0].reset();
                                alert("Something went wrong. Please try again.");
                            }
                        },
                        error: function(xhr, status, error) {
                            alert("An error occurred while processing your request.");
                        },
                    });
                });


                //jquerry for view complaint
                $(document).on("click", ".viewcomplaint", function(e) {
                    e.preventDefault();
                    var user_id = $(this).val();
                    console.log(user_id);
                    $.ajax({
                        type: "POST",
                        url: "testbackend.php",
                        data: {
                            view_complaint: true,
                            user_id: user_id,
                        },
                        success: function(response) {
                            var res = jQuery.parseJSON(response);
                            console.log(res);
                            if (res.status == 500) {
                                alert(res.message);
                            } else {
                                //$('#student_id2').val(res.data.uid);
                                $("#id").text(res.data.id);
                                $("#type_of_problem").text(res.data.type_of_problem);
                                $("#problem_description").text(res.data.problem_description);
                                $("#faculty_name").text(res.data.faculty_name);
                                $("#faculty_mail").text(res.data.faculty_mail);
                                $("#faculty_contact").text(res.data.faculty_contact);
                                $("#block_venue").text(res.data.block_venue);
                                $("#venue_name").text(res.data.venue_name);
                                $("#complaintDetailsModal").modal("show");
                            }
                        },
                    });
                });

                //Before image
                $(document).on("click", ".showImage", function() {
                    var problem_id = $(this).val(); // Get the problem_id from button value
                    console.log(problem_id); // Ensure this logs correctly
                    $.ajax({
                        type: "POST",
                        url: "testbackend.php",
                        data: {
                            get_image: true,
                            problem_id: problem_id, // Correct POST key
                        },
                        dataType: "json", // Automatically parses JSON responses
                        success: function(response) {
                            console.log(response); // Log the parsed JSON response
                            if (response.status == 200) {
                                // Dynamically set the image source
                                $("#modalImage").attr("src", "uploads/" + response.data.images);
                                // Show the modal
                                $("#imageModal").modal("show");
                            } else {
                                // Handle case where no image is found
                                alert(
                                    response.message || "An error occurred while retrieving the image."
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            // Log the full error details for debugging
                            console.error("AJAX Error: ", xhr.responseText);
                            alert(
                                "An error occurred: " +
                                error +
                                "\nStatus: " +
                                status +
                                "\nDetails: " +
                                xhr.responseText
                            );
                        },
                    });
                });

                //principal question 
                $(document).ready(function() {
                    // When the button is clicked, populate the modal with the query
                    $(".openQueryModal").on("click", function() {
                        // Check if the button is disabled
                        if ($(this).is(':disabled')) {
                            return; // Do nothing if the button is disabled
                        }

                        var commentQuery = $(this).data("comment-query");
                        var taskId = $(this).data("task-id");
                        // Set the comment query text in the modal
                        $("#commentQueryText").text(commentQuery);
                        // Store the task_id for later use when submitting the answer
                        $("#submitReply").data("task-id", taskId);
                    });

                    // Handle form submission when 'Submit Reply' is clicked
                    $("#submitReply").on("click", function() {
                        var taskId = $(this).data("task-id");
                        var commentReply = $("#commentReply").val();

                        // AJAX request to send the reply to the backend
                        $.ajax({
                            url: "testbackend.php", // Your backend file
                            type: "POST",
                            data: {
                                task_id: taskId,
                                comment_reply: commentReply,
                                submit_comment_reply: true,
                            },
                            success: function(response) {
                                var res = jQuery.parseJSON(response);
                                if (res.status == 200) {
                                    alert(res.message);
                                    $("#principalQueryModal").modal("hide");
                                    // Reload the table to reflect changes
                                    $("#worker_table").load(location.href + " #worker_table");
                                } else {
                                    alert("Something went wrong. Please try again.");
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error("Error:", error);
                                alert("Something went wrong. Please try again.");
                            },
                        });
                    });
                });

                //verify once again


                $(document).on("click", ".facfeed", function(e) {
                    e.preventDefault();
                    var user_id = $(this).val();
                    console.log(user_id);
                    $.ajax({
                        type: "POST",
                        url: "testbackend.php",
                        data: {
                            facfeedview: true,
                            user_id: user_id,
                        },
                        success: function(response) {
                            var res = jQuery.parseJSON(response);
                            console.log(res);
                            if (res.status == 500) {
                                alert(res.message);
                            } else {
                                //$('#student_id2').val(res.data.uid);
                                $("#ffeed").val(res.data.feedback);
                                $("#exampleModal").modal("show");
                            }
                        },
                    });
                });

                $(document).ready(function() {
                    var complaintfeedId = null; // Store complaintfeed_id globally

                    // Open the feedback modal and set the complaintfeed ID (Event Delegation)
                    $(document).on("click", ".facfeed", function() {
                        complaintfeedId = $(this).val();
                        $("#complaintfeed_id").val(complaintfeedId); // Store complaintfeed ID in the hidden input
                    });

                    // When 'Done' is clicked (Event Delegation)
                    $(document).on("click", ".done", function() {
                        var complaintfeedId = $("#complaintfeed_id").val();
                        updateComplaintStatus(complaintfeedId, 16); // Status '16' for Done
                        swal({
                            title: "success!",
                            text: "Completed sucessfully!",
                            icon: "success",
                            button: "Ok",
                            timer: null
                        });

                        $('#finished_table').DataTable().destroy();
                        $('#completed_table').DataTable().destroy();

                        $("#finished_table").load(location.href + " #finished_table > *", function() {
                            // Reinitialize the DataTable after the content is loaded
                            $('#finished_table').DataTable();
                        });
                        $("#completed_table").load(location.href + " #completed_table > *", function() {
                            // Reinitialize the DataTable after the content is loaded
                            $('#completed_table').DataTable();
                        });
                        $("#navref3").load(location.href + " #navref3");
                        $("#navref4").load(location.href + " #navref4");
                        $("#navref5").load(location.href + " #navref5");
                    });

                    // When 'Reassign' is clicked (Event Delegation)
                    $(document).on("click", ".reass", function() {
                        $("#datePickerModal").modal("show"); // Show the modal to select deadline
                    });

                    // When 'Set Deadline' is clicked in the date picker modal
                    $(document).on("click", "#saveDeadline", function() {
                        var reassign_deadline = $("#reassign_deadline").val(); // Get the selected deadline

                        if (!reassign_deadline) {
                            alert("Please select a deadline date.");
                            return;
                        }

                        var complaintfeedId = $("#complaintfeed_id").val();
                        updateComplaintStatus(complaintfeedId, 15, reassign_deadline); // Status '15' for Reassign with deadline
                        swal({
                            title: "success!",
                            text: "Reassigned sucessfully!",
                            icon: "success",
                            button: "Ok",
                            timer: null
                        });
                        $("#datePickerModal").modal("hide"); // Close the date picker modal
                        $("#exampleModal").modal("hide"); // Close the feedback modal

                        $('#finished_table').DataTable().destroy();
                        $('#reassigned_table').DataTable().destroy();

                        $("#finished_table").load(location.href + " #finished_table > *", function() {
                            // Reinitialize the DataTable after the content is loaded
                            $('#finished_table').DataTable();
                        });
                        $("#reassigned_table").load(location.href + " #reassigned_table > *", function() {
                            // Reinitialize the DataTable after the content is loaded
                            $('#reassigned_table').DataTable();
                        });
                        $("#navref3").load(location.href + " #navref3");
                        $("#navref4").load(location.href + " #navref4");
                        $("#navref5").load(location.href + " #navref5");
                    });

                    // Function to update the complaint status
                    function updateComplaintStatus(complaintfeedId, status, reassign_deadline = null) {
                        $.ajax({
                            type: "POST",
                            url: "testbackend.php",
                            data: {
                                complaintfeed_id: complaintfeedId,
                                status: status,
                                reassign_deadline: reassign_deadline, // Only pass this if status is 'reassign'
                            },
                            success: function(response) {
                                var res = jQuery.parseJSON(response);
                                if (res.status == 500) {
                                    alert(res.message);
                                }
                            },
                            error: function() {
                                alert("An error occurred while updating the status.");
                            }
                        });
                    }
                });



                // Function to update the complaint status
                function updateComplaintStatus(complaintfeedId, status, reassign_deadline = null) {
                    $.ajax({
                        type: "POST",
                        url: "testbackend.php",
                        data: {
                            complaintfeed_id: complaintfeedId,
                            status: status,
                            reassign_deadline: reassign_deadline, // Only pass this if status is 'reassign'
                        },
                        success: function(response) {
                            var res = jQuery.parseJSON(response);
                            alert(res.message);
                            if (res.status == 500) {
                                alert(res.message);
                            }
                        }
                    });
                }

                //Reject Reason from principal
                $(document).on("click", ".rejectreasonbtn", function(e) {
                    e.preventDefault();
                    var id12 = $(this).val();
                    console.log(id12);
                    $.ajax({
                        type: "POST",
                        url: "testbackend.php",
                        data: {
                            get_reject_reason: true,
                            problem_id: id12,
                        },
                        success: function(response) {
                            var res = jQuery.parseJSON(response);
                            console.log(res);
                            if (res.status == 500) {
                                alert(res.message);
                            } else {
                                $("#feedback").text(res.data.feedback);
                            }
                        },
                    });
                });


                //after image
                $(document).on("click", ".imgafter", function() {
                    var problem_id = $(this).val(); // Get the problem_id from button value
                    console.log(problem_id); // Ensure this logs correctly
                    $.ajax({
                        type: "POST",
                        url: "testbackend.php",
                        data: {
                            get_aimage: true,
                            problem2_id: problem_id, // Correct POST key
                        },
                        dataType: "json", // Automatically parses JSON responses
                        success: function(response) {
                            console.log(response); // Log the parsed JSON response
                            if (response.status == 200) { // Use 'response' instead of 'res'
                                // Dynamically set the image source
                                $("#modalImage2").attr("src", response.data.after_photo);
                                // Show the modal
                                $("#afterImageModal").modal("show");
                            } else {
                                // Handle case where no image is found
                                alert(response.message || "An error occurred while retrieving the image.");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error: ", status, error);
                        }
                    });
                });
                $('#afterImageModal').on('hidden.bs.modal', function() {
                    // Reset the image source to a default or blank placeholder
                    $("#modalImage2").attr("src", "path/to/placeholder_image.jpg");
                });
                document.getElementById('download').addEventListener('click', function() {
                    var wb = XLSX.utils.book_new();
                    var ws = XLSX.utils.table_to_sheet(document.getElementById('record_table'));
                    XLSX.utils.book_append_sheet(wb, ws, "Complaints Data");

                    // Create and trigger the download
                    XLSX.writeFile(wb, 'complaints_data.xlsx');
                });

                //worker phone number fertch
                $(document).on('click', ".worker_det", function(e) {
                    e.preventDefault();
                    var prblm_id = $(this).val();
                    console.log(prblm_id);
                    $.ajax({
                        type: "POST",
                        url: "testbackend.php",
                        data: {
                            get_worker_phone: true,
                            prblm_id: prblm_id,
                        },
                        success: function(response) {
                            var res = jQuery.parseJSON(response);
                            console.log(res);
                            if (res.status == 500) {
                                alert(res.message);
                            } else {
                                $("#worker_mobile").text(res.data.worker_mobile);
                                // Set the href attribute for the call button to dial the worker's mobile number
                                $('#callWorkerBtn').attr('href', 'tel:' + response.worker_mobile);
                                $("#workerdetailmodal").modal("show");
                            }
                        },
                    });
                });

                //exctend deadline
                $(document).on("click", ".deadline_extend", function(e) {
                    e.preventDefault();
                    var user = $(this).val();
                    console.log(user);
                    $("#deadline_id").val(user);
                });
                $(document).on("submit", "#extenddead", function(e) {
                    e.preventDefault();
                    console.log("Haii!!");
                    var data = new FormData(this);
                    console.log(data);
                    data.append("extend_deadlinedate", true);
                    $.ajax({
                        url: "testbackend.php",
                        type: "POST",
                        data: data,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            var res = jQuery.parseJSON(response);
                            console.log(res);
                            if (res.status == 200) {
                                swal({
                                    title: "success!",
                                    text: "Complaint accepted sucessfully!",
                                    icon: "success",
                                    button: "Ok",
                                    timer: null
                                });
                                $("#extend_date").modal("hide");
                                $("#extenddead")[0].reset();
                                $('#worker_table').DataTable().destroy();
                                $("#worker_table").load(location.href + " #worker_table > *", function() {
                                    // Reinitialize the DataTable after the content is loaded
                                    $('#worker_table').DataTable();
                                });
                            }
                        }
                    })
                })

                //Add worker
                $(document).on("submit", "#workers", function(e) {
                    e.preventDefault();
                    var dt = new FormData(this);
                    console.log(dt);
                    dt.append("form1", true);
                    $.ajax({
                        url: "testbackend.php",
                        type: "POST",
                        data: dt,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.includes("Success")) {
                                $("#addworker").modal("hide");
                                $('#workers')[0].reset();



                            } else {
                                alert("Error");
                            }
                        },
                        error: function(xhr, status, error) {
                            alert("An error occurred: " + error);
                        }
                    });
                })
            </script>

            <script>
                // Get today's date in the format 'YYYY-MM-DD'
                var today = new Date().toISOString().split('T')[0];

                // Get the date input element
                var dateInput = document.getElementById('deadline01');

                // Set the minimum and maximum date for the input field to today's date
                dateInput.setAttribute('min', today);
            </script>

            <script>
                // Get today's date in the format 'YYYY-MM-DD'
                var today = new Date().toISOString().split('T')[0];

                // Get the date input element
                var dateInput = document.getElementById('reassign_deadline');

                // Set the minimum and maximum date for the input field to today's date
                dateInput.setAttribute('min', today);
            </script>

            <script>
                // Get today's date in the format 'YYYY-MM-DD'
                var today = new Date().toISOString().split('T')[0];

                // Get the date input element
                var dateInput = document.getElementById('extend_deadline');

                // Set the minimum and maximum date for the input field to today's date
                dateInput.setAttribute('min', today);
            </script>

</body>

</html>