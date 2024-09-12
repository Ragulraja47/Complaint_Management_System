<?php
session_start();

if (isset($_SESSION['department'])) {
    $department = $_SESSION['department'];
   
} else {
    die("Couldn't find department in session.");
}



// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "complaints";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute the query to filter by department
//New task query
$sql = "SELECT 
cd.id,
cd.faculty_id,
cd.faculty_name,
cd.department,
cd.faculty_contact,
cd.faculty_mail,
cd.block_venue,
cd.venue_name,
cd.type_of_problem,
cd.problem_description,
cd.images,
cd.date_of_reg,
cd.days_to_complete,
cd.task_completion,
cd.status,
cd.feedback,
m.task_id,
m.priority
FROM 
complaints_detail AS cd
JOIN 
manager AS m ON cd.id = m.problem_id
WHERE 
m.worker_id = ? 
AND cd.status = '8'";
// Filter by department
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $department);  // Assuming department is a string
$stmt->execute();
$result = $stmt->get_result();
$newcount = mysqli_num_rows($result);




//inprogress query
$sql1 = "SELECT 
cd.id,
cd.faculty_id,
cd.faculty_name,
cd.department,
cd.faculty_contact,
cd.faculty_mail,
cd.block_venue,
cd.venue_name,
cd.type_of_problem,
cd.problem_description,
cd.images,
cd.date_of_reg,
cd.days_to_complete,
cd.task_completion,
cd.status,
cd.feedback,
m.task_id,
m.priority
FROM 
complaints_detail AS cd
JOIN 
manager AS m ON cd.id = m.problem_id
WHERE 
m.worker_id = ? 
AND cd.status = '10'";
// Filter by department
$stmt = $conn->prepare($sql1);
$stmt->bind_param("s", $department);  // Assuming department is a string
$stmt->execute();
$result1 = $stmt->get_result();
$progcount = mysqli_num_rows($result1);


//waiting for approval query
$sql2 = "SELECT 
cd.id,
cd.faculty_id,
cd.faculty_name,
cd.department,
cd.faculty_contact,
cd.faculty_mail,
cd.block_venue,
cd.venue_name,
cd.type_of_problem,
cd.problem_description,
cd.images,
cd.date_of_reg,
cd.days_to_complete,
cd.task_completion,
cd.status,
cd.reason,
cd.feedback,
m.task_id,
m.priority
FROM 
complaints_detail AS cd
JOIN 
manager AS m ON cd.id = m.problem_id
WHERE 
m.worker_id = ? 
AND cd.status = '11'";
// Filter by department
$stmt = $conn->prepare($sql2);
$stmt->bind_param("s", $department);  // Assuming department is a string
$stmt->execute();
$result2 = $stmt->get_result();
$waitcount = mysqli_num_rows($result2);


//completed query
$sql3 = "SELECT 
cd.id,
cd.faculty_id,
cd.faculty_name,
cd.department,
cd.faculty_contact,
cd.faculty_mail,
cd.block_venue,
cd.venue_name,
cd.type_of_problem,
cd.problem_description,
cd.images,
cd.date_of_reg,
cd.days_to_complete,
cd.task_completion,
cd.date_of_completion,
cd.status,
cd.feedback,
m.task_id,
m.priority
FROM 
complaints_detail AS cd
JOIN 
manager AS m ON cd.id = m.problem_id
WHERE 
m.worker_id = ? 
AND cd.status = '12'";
// Filter by department
$stmt = $conn->prepare($sql3);
$stmt->bind_param("s", $department);  // Assuming department is a string
$stmt->execute();
$result3 = $stmt->get_result();
$compcount = mysqli_num_rows($result3);


//not approved query
$sql4 = "SELECT 
cd.id,
cd.faculty_id,
cd.faculty_name,
cd.department,
cd.faculty_contact,
cd.faculty_mail,
cd.block_venue,
cd.venue_name,
cd.type_of_problem,
cd.problem_description,
cd.images,
cd.date_of_reg,
cd.days_to_complete,
cd.task_completion,
cd.date_of_completion,
cd.status,
cd.feedback,
m.task_id,
m.priority
FROM 
complaints_detail AS cd
JOIN 
manager AS m ON cd.id = m.problem_id
WHERE 
m.worker_id = ? 
AND cd.status = '9'";
// Filter by department
$stmt = $conn->prepare($sql4);
$stmt->bind_param("s", $department);  // Assuming department is a string
$stmt->execute();
$result4 = $stmt->get_result();
$notcount = mysqli_num_rows($result4);

?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title>MKCE_CMS</title>
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<style>
            .nav-tabs .nav-item.show .nav-link,
            .nav-tabs .nav-link.active {
                color: white;
                background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);
                padding: 11px 15px;
            }
    
            .nav-tabs .nav-item.show .nav-link,
            .nav-tabs .nav-link.active:hover {
                border: none;
            }
    
            a {
                color:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);
                padding: 11px 15px;
            }
    
            .nav-tabs .nav-item.show .nav-link,
            .nav-tabs a:hover {
                color:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);
                border: 4px solid gray;
                /* Include the border within the button size */
                padding: 8px 15px;
                /* Adjust padding to maintain the button's size */
            }
            th {
        /* background-color: #7460ee; */
        background: linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%);
        color: white;
    }
            @media (min-width:1300px) and (max-width:1800px) {
      /* For mobile phones: */
    
    }
        </style>
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
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
            <!-- Sidebar toggle for mobile -->
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
            
            <!-- Logo -->
            <a class="navbar-brand" href="index.html">
                
                <span class="logo-text">
                    <img src="assets/images/mkcenavlogo.png" alt="homepage" class="light-logo" />
                </span>
            </a>
            
            <!-- Toggle for mobile -->
            <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
        </div>
        
        <!-- Navbar items -->
        <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
            <ul class="navbar-nav float-left mr-auto">
                <li class="nav-item d-none d-md-block">
                    <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a>
                </li>
                <!-- Additional items can be added here -->
            </ul>
            <a href="login.php" class="btn btn-danger">
    <i class=" fas fa-sign-out-alt" style="font-size: 15px;"></i>
</a>

    
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
                        <div class="card" id="navref">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist" id="navli">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#completed"
                                        role="tab"><span class="hidden-sm-up"></span> <span
                                            class="hidden-xs-down"><b>Completed(<?php echo $compcount ?>)</b></span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#newtask"
                                        role="tab"><span class="hidden-sm-up"></span> <span
                                            class="hidden-xs-down"><b>NewTask(<?php echo $newcount ?>)</b></span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#notapproved"
                                        role="tab"><span class="hidden-sm-up"></span> <span
                                            class="hidden-xs-down"><b>NotApproved(<?php echo $notcount ?>)</b></span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#inprogressdiv"
                                        role="tab"><span class="hidden-sm-up"></span> <span
                                            class="hidden-xs-down"><b>InProgress(<?php echo $progcount ?>)</b></span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#waitingforapproval"
                                        role="tab"><span class="hidden-sm-up"></span> <span
                                            class="hidden-xs-down"><b>WaitingForApproval(<?php echo $waitcount ?>)</b></span></a> </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content tabcontent-border">
                                <!--completed start-->
                                <div class="tab-pane active p-20" id="completed" role="tabpanel">
                                    <div class="p-20">
                                        <div class="table-responsive">
                                            <h5 class="card-title">Completed Tasks</h5>
                                            <table id="addnewtaskcompleted" class="table table-striped table-bordered">
                                                <thead style="background-color: rgb(220, 20, 70); color: white; ">
                                                    <tr>

                                                        <th class="text-center"><b>
                                                                <h5>S.No</h5>
                                                            </b></th>
                                                        <th class="col-md-2 text-center"><b>
                                                                <h5>Complaint Date</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Task ID</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Dept</h5>
                                                            </b></th>
                                                        <th class="col-md-2 text-center"><b>
                                                                <h5>Complaint</h5>
                                                            </b></th>
                                                        <th class="text-center">
                                                            <b>
                                                                <h5>Photos</h5>
                                                            </b>
                                                        </th>
                                                        <th class=" col-md-2 text-center"><b>
                                                                <h5>Deadline</h5>
                                                            </b></th>
                                                        <th class=" col-md-2 text-center"><b>
                                                                <h5>Date of completion</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Status</h5>
                                                            </b></th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
        $count = 1;
        while ($row = $result3->fetch_assoc()) {
            echo "<tr>";
            echo "<td class='text-center'>" . $count++ . "</td>";
            echo "<td class='text-center'>" . htmlspecialchars($row['date_of_reg']) . "</td>";
            echo "<td class='text-center'>" . htmlspecialchars($row['task_id']) . "</td>";
            echo "<td class='text-center'>" . htmlspecialchars($row['department']) . "</td>";
            ?>
            <td class='text-center'>
            <button type='button' class='btn btn-primary margin-5 view-complaint-btn' 
        data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
    View Complaint
</button>
            </td>
            
             <td>
                                                            <div class="d-flex justify-content-between">
                                                                <!-- Align the first button to the left -->
                                                                
                <button type='button' class='btn btn-primary margin-5 showbeforeimg' 
                        data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
                    Before
                </button>
           
                                                                <!-- Align the second button to the right -->
                                                                <button type="button" class="btn btn-info"
                                                                    style="margin-left:8px;" data-toggle="modal"
                                                                    data-target="#Modal4">
                                                                    After
                                                                </button>
                                                            </div>
                                             </td>
            <?php
            echo "<td class='text-center'>" . htmlspecialchars($row['days_to_complete']) . "</td>";
            echo "<td class='text-center'>" . htmlspecialchars($row['date_of_completion']) . "</td>";

            ?>
            <td><button type="button" class="btn btn-info"
                                                                     data-toggle="modal"
                                                                     >
                                                                    Completed
                                                                </button></td>
            <?php

            echo "</tr>";
        }
        ?> 
                                                </tbody>

                                            </table>
                                        </div>

                                    </div>
                                </div>
                                <!--completed end-->
                                <!--new task start-->
                                <div class="tab-pane  p-10" id="newtask" role="tabpanel">
                                    <div class="p-10">
                                        <div class="card">
                                            <div class="card-body" style="padding: 10px;">
                                                <h5 class="card-title">New Tasks</h5>
                                                <div class="table-responsive">
                                                <table id="addnewtask" class="table table-striped table-bordered">
    <thead style="background-color: rgb(220, 20, 70); color: white;">
        <tr>
            <th class="text-center"><b>S.No</b></th>
            <th class="col-md-2 text-center"><b>Complaint Date</b></th>
            <th class="text-center"><b>Task ID</b></th>
            <th class="text-center col-md-1"><b>Dept</b></th>
            <th class="col-md-2 text-center"><b>Complaint</b></th>
            <th class="text-center"><b>Priority</b></th>
            <th class="text-center"><b>Photos</b></th>
            <th class="text-center"><b>Deadline</b></th>
            <th class="text-center"><b>Status</b></th>
            <th class="text-center"><b>Action</b></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td class='text-center'>" . $count++ . "</td>";
            echo "<td class='text-center'>" . htmlspecialchars($row['date_of_reg']) . "</td>";
            echo "<td class='text-center'>" . htmlspecialchars($row['task_id']) . "</td>";
            echo "<td class='text-center'>" . htmlspecialchars($row['department']) . "</td>";
            ?>
            <td class='text-center'>
            <button type='button' class='btn btn-primary margin-5 view-complaint-btn' 
        data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
    View Complaint
</button>
            </td>
            <?php
            echo "<td class='text-center'>" . htmlspecialchars($row['priority']) . "</td>";
            ?>
            <td class='text-center'>
                <button type='button' class='btn btn-primary margin-5 showbeforeimg' 
                        data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
                    Before
                </button>
            </td>
            <?php
            echo "<td class='text-center'>" . htmlspecialchars($row['days_to_complete']) . "</td>";
            echo "<td class='text-center'>Pending</td>";
            ?>
            <td class='text-center'>
            <button id = 'reload-table-btn' type='button' class='btn btn-primary margin-5 start-work-btn ' 
        data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
    Start to work
</button>
        </td>  
        <?php          echo "</tr>";
        }
        ?>
    </tbody>
</table>

</div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--new task end-->
                                <div class="tab-pane p-10" id="notapproved" role="tabpanel">
                                    <div class="p-10">
                                        <div class="p-10">
                                            <div class="card">
                                                <div class="card-body" style="padding: 10px;">
                                                    <h5 class="card-title">Work not Approved</h5>
                                                    <div class="table-responsive">
                                                        <table id="statusnotapproved"
                                                            class="table table-striped table-bordered">
                                                            <thead
                                                                style="background-color: rgb(220, 20, 70); color: white; ">
                                                                <tr>

                                                                    <th class="text-center"><b>
                                                                            <h5>S.No</h5>
                                                                        </b></th>
                                                                    <th class="col-md-2 text-center"><b>
                                                                            <h5>Complaint Date</h5>
                                                                        </b></th>
                                                                    <th class="text-center"><b>
                                                                            <h5>Task ID</h5>
                                                                        </b></th>
                                                                    <th class="text-center col-md-2"><b>
                                                                            <h5>Dept</h5>
                                                                        </b></th>
                                                                    <th class="col-md-2 text-center"><b>
                                                                            <h5>Complaint</h5>
                                                                        </b></th>
                                                                    <th class="text-center"><b>
                                                                            <h5>Priority</h5>
                                                                        </b></th>
                                                                    <th class="text-center">
                                                                        <b>
                                                                            <h5>Photos</h5>
                                                                        </b>
                                                                    </th>
                                                                    <th class="text-center"><b>
                                                                            <h5>Deadline</h5>
                                                                        </b></th>
                                                                    <th class="text-center"><b>
                                                                            <h5>Comments</h5>
                                                                        </b></th>
                                                                    <th class="text-center"><b>
                                                                            <h5>Status</h5>
                                                                        </b></th>
                                                                    <th class="text-center"><b>
                                                                            <h5>Action</h5>
                                                                        </b></th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
        $count = 1;
        while ($row = $result4->fetch_assoc()) {
            echo "<tr>";
            echo "<td class='text-center'>" . $count++ . "</td>";
            echo "<td class='text-center'>" . htmlspecialchars($row['date_of_reg']) . "</td>";
            echo "<td class='text-center'>" . htmlspecialchars($row['task_id']) . "</td>";
            echo "<td class='text-center'>" . htmlspecialchars($row['department']) . "</td>";
            ?>
            <td class='text-center'>
            <button type='button' class='btn btn-primary margin-5 view-complaint-btn' 
        data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
    View Complaint
</button>
            </td>
            <?php
            echo "<td class='text-center'>" . htmlspecialchars($row['priority']) . "</td>";
            ?>
            <td class='text-center'>
            <button type='button' class='btn btn-primary margin-5 showbeforeimg' 
                        data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
                    Before
                </button>
            </td>
            <?php
            echo "<td class='text-center'>" . htmlspecialchars($row['days_to_complete']) . "</td>";
            echo "<td class='text-center'>" . htmlspecialchars($row['feedback']) . "</td>";
            echo "<td class='text-center'>Pending</td>";
            ?>
            <td class='text-center'>
            <button type='button' class='btn btn-primary margin-5 start-work-btn ' 
        data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
    Start to work
</button>
        </td>  
        <?php          echo "</tr>";
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
                                <!--Inprogress-->
                                <div class="tab-pane p-10" id="inprogressdiv" role="tabpanel">
                                    <div class="p-10">
                                        <div class="p-10">
                                            <div class="card">
                                                <div class="card-body" style="padding: 10px;">
                                                    <h5 class="card-title">InProgress</h5>
                                                    <div class="table-responsive">
                                                        <table id="statusinprogress"
                                                            class="table table-striped table-bordered">
                                                            <thead
                                                                style="background-color: rgb(220, 20, 70); color: white; ">
                                                                <tr>

                                                                    <th class="text-center"><b>
                                                                            <h5>S.No</h5>
                                                                        </b></th>
                                                                    <th class="col-md-2 text-center"><b>
                                                                            <h5>Complaint Date</h5>
                                                                        </b></th>
                                                                    <th class="text-center"><b>
                                                                            <h5>Task ID</h5>
                                                                        </b></th>
                                                                    <th class="text-center col-md-2"><b>
                                                                            <h5>Dept</h5>
                                                                        </b></th>
                                                                    <th class="col-md-2 text-center"><b>
                                                                            <h5>Complaint</h5>
                                                                        </b></th>
                                                                    <th class="text-center"><b>
                                                                            <h5>Priority</h5>
                                                                        </b></th>
                                                                    <th class="text-center">
                                                                        <b>
                                                                            <h5>Photos</h5>
                                                                        </b>
                                                                    </th>
                                                                    <th class="text-center"><b>
                                                                            <h5>Deadline</h5>
                                                                        </b></th>
                                                                    <th class="text-center"><b>
                                                                            <h5>Status</h5>
                                                                        </b></th>
                                                                    <th class="text-center"><b>
                                                                            <h5>Action</h5>
                                                                        </b></th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
        $count = 1;
        while ($row = $result1->fetch_assoc()) {
            echo "<tr>";
            echo "<td class='text-center'>" . $count++ . "</td>";
            echo "<td class='text-center'>" . htmlspecialchars($row['date_of_reg']) . "</td>";
            echo "<td class='text-center'>" . htmlspecialchars($row['task_id']) . "</td>";
            echo "<td class='text-center'>" . htmlspecialchars($row['department']) . "</td>";
            ?>
            <td class='text-center'>
                <button type='button' class='btn btn-primary margin-5 view-complaint-btn' 
                        data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
                     View Complaint
                </button>
            </td>
            <?php
            echo "<td class='text-center'>" . htmlspecialchars($row['priority']) . "</td>";
            ?>
            <td class='text-center'>
                <button type='button' class='btn btn-primary margin-5 showbeforeimg' 
                        data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
                    Before
                </button>
            </td>
            <?php
            echo "<td class='text-center'>" . htmlspecialchars($row['days_to_complete']) . "</td>";
            echo "<td class='text-center'>In Progress</td>";
            ?>
            <td class='text-center'>
            <button type='button' class='btn btn-primary margin-5 work-comp ' 
        data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
    Work Completion
</button>
        </td>  
        <?php          echo "</tr>";
        }
        ?>   </tbody>

                                                        </table>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end of inprogress-->
                                <!--inprogress task submission modal-->
                               <!--Task Completion--><!--Id:Modal2-->
 <!-- Modal -->
<div class="modal fade" id="Modal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Task Completion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!--form-->
                <div class="mb-3">
                    <label class="form-label">Task ID</label>
                    <input type="text" class="form-control" id="taskid" disabled readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Add Image-Proof</label>
                    <input onchange = "validateSize(this)"  class="form-control" type="file" id="imgafter">
                </div>
                <label class="form-label">Task Completion</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="completionStatus" id="inlineRadio1" value="Fully Completed">
                    <label class="form-check-label" for="inlineRadio1">Fully Completed</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="completionStatus" id="inlineRadio2" value="Partially Completed">
                    <label class="form-check-label" for="inlineRadio2">Partially Completed</label>
                </div>
                <!-- Hidden input field for reason -->
                <div class="mb-3 mt-3" id="reason-container" style="display: none;">
                    <label class="form-label">Reason</label>
                    <input type="text" class="form-control" id="reason" name="reason" placeholder="Enter reason for partial completion">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="save-btn" type="button" class="btn btn-primary" data-dismiss="modal">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->


                                <!--inprogress task submission modal end-->
                                <!--start of waiting approval-->
                                <div class="tab-pane p-20" id="waitingforapproval" role="tabpanel">
                                    <div class="p-20">
                                        <div class="table-responsive"><!--id:addnewtask-->
                                            <table id="approval" class="table table-striped table-bordered">
                                                <h5 class="card-title">Waiting for Approval</h5>
                                                <thead style="background-color: rgb(220, 20, 70); color: white; ">
                                                    <tr>

                                                        <th class="text-center"><b>
                                                                <h5>S.No</h5>
                                                            </b></th>
                                                        <th class="col-md-2 text-center"><b>
                                                                <h5>Complaint Date</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Task ID</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Dept</h5>
                                                            </b></th>
                                                        <th class="col-md-2 text-center"><b>
                                                                <h5>Complaint</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Priority</h5>
                                                            </b></th>
                                                        <th class="text-center col-md-2">
                                                            <b>
                                                                <h5>Photos</h5>
                                                            </b>
                                                        </th>
                                                        <th class=" col-md-2 text-center"><b>
                                                                <h5>Deadline</h5>
                                                            </b></th>
                                                        <th class=" col-md-2 text-center"><b>
                                                                <h5>Reason</h5>
                                                            </b></th>
                                                        <th class="text-center"><b>
                                                                <h5>Task Completion</h5>
                                                            </b></th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
        $count = 1;
        while ($row = $result2->fetch_assoc()) {
            echo "<tr>";
            echo "<td class='text-center'>" . $count++ . "</td>";
            echo "<td class='text-center'>" . htmlspecialchars($row['date_of_reg']) . "</td>";
            echo "<td class='text-center'>" . htmlspecialchars($row['task_id']) . "</td>";
            echo "<td class='text-center'>" . htmlspecialchars($row['department']) . "</td>";
            ?>
            <td class='text-center'>
            <button type='button' class='btn btn-primary margin-5 view-complaint-btn' 
        data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
    View Complaint
</button>
            </td>
            <?php
            echo "<td class='text-center'>" . htmlspecialchars($row['priority']) . "</td>";
            ?>
             <td>
                                                            <div class="d-flex justify-content-between">
                                                                <!-- Align the first button to the left -->
                                                                
                <button type='button' class='btn btn-primary margin-5 showbeforeimg' 
                        data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
                    Before
                </button>
          
                                                                <!-- Align the second button to the right -->
                                                                <button type="button" class="btn btn-info showImage"
                                                                    style="margin-left:-12px;" data-toggle="modal"
                                                                    data-target="#Modal4" data-task-id='<?php echo htmlspecialchars($row['task_id']); ?>'>
                                                                    After
                                                                </button>
                                                            </div>
                                                        </td>
            <?php
            echo "<td class='text-center'>" . htmlspecialchars($row['days_to_complete']) . "</td>";
            echo "<td class='text-center'>" . htmlspecialchars($row['reason']) . "</td>";
            echo "<td class='text-center'>" . htmlspecialchars($row['task_completion']) . "</td>";
            echo "</tr>";
        }
        ?> 
                                                </tbody>

                                            </table>
                                        </div>

                                    </div>
                                </div>



                                <!--image before and complaint start-->
                                <div class="modal fade" id="Modal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Image-Before</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <img id="modalImage1" src="" width="100%">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


                                <!--modal for image(After) viewing in model -->
                              <!-- Modal image view-->
                              <div class="modal fade" id="Modal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Image-After</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="modalImage" src="" width="100%" >
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
                           
                               <!-- Modal Structure -->
<div class="modal fade" id="Modal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Complaint</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true ">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Complaint Data -->
                <ol class="list-group list-group-numbered">
                <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold"><h4 style="Color:#7460ee">Faculty Name</h4></div>
                            <b><span id="faculty_name"></span></b>
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold"><h4 style="Color:#7460ee">Faculty Contact</h4></div>
                            <b><span id="contact"></span></b>
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold"><h4 style="Color:#7460ee">Block</h4></div>
                            <b><span id="block-content"></span></b>
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold"><h4 style="Color:#7460ee">Venue</h4></div>
                           <b> <span id="venue-content"></span></b>
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold"><h4 style="Color:#7460ee">Problem Description</h4></div>
                            <b><span id="problem-description-content"></span></b>
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold"><h4 style="Color:#7460ee">Deadline</h4></div>
                           <b> <span id="days-remaining-content"></span></b>
                        </div>
                    </li>
                </ol>
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

                                <!--image before and complaint end-->
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
                                <b>2024 © M.Kumarasamy College of Engineering All Rights Reserved.<br>
                                    Developed and Maintained by Technology Innovation Hub.</b>
                            </footer>
                            <!-- ============================================================== -->
                            <!-- End footer -->
                            <!-- ============================================================== -->
                        </div>
                        <!-- ============================================================== -->
                        <!-- End Page wrapper  -->
                        <!-- ============================================================== -->
                   
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
                    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
                    <script>
    $(document).ready(function () {
        // Initialize DataTables
        var addTable = $('#addnewtask').DataTable({ ordering: false });
        var inProgTable = $('#statusinprogress').DataTable({ ordering: false });
        var apprTable = $('#approval').DataTable({ ordering: false });
        var compTable = $('#addnewtaskcompleted').DataTable({ ordering: false });
        var notApprTable = $('#statusnotapproved').DataTable({ ordering: false });

        
    });
</script>
<script>
        //viewing complaint common button
        $(document).ready(function() {
    $('.view-complaint-btn').click(function(e) {
        e.preventDefault(); 
        var taskId = $(this).data('task-id');

        $.ajax({
            url: 'backend.php',
            type: 'POST',// Ensure jQuery parses the response as JSON
            data: {
                fetch_details: true, // Proper action parameter
                task_id: taskId
            },
            success: function(response) {
                console.log("Raw response:", response);
                var response = jQuery.parseJSON(response);

                if (response.error) {
                    alert(response.error);
                } else {
                   
                    $('#faculty_name').text(response.faculty_name);
                    $('#contact').text(response.faculty_contact);
                    $('#block-content').text(response.block_venue);
                    $('#venue-content').text(response.venue_name);
                    $('#problem-description-content').text(response.problem_description);
                    $('#days-remaining-content').text(response.days_to_complete);
                    $('#Modal1').modal('show');
                }
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("AJAX error:", textStatus, errorThrown);
                alert('Failed to fetch details');
            }
        });
    });
});

        //viweing complaint ends
    </script>
<script>
    //content for fetching before image(common)
$(document).ready(function() {
    $('.view-bimg-btn').click(function(e) {
        e.preventDefault();
        var taskId2 = $(this).data('task-id');
        
        // Send an AJAX request to fetch the image details
        $.ajax({
            url: 'backend.php',
            type: 'POST',
            data: { action: 'fetch_images',task_id2: taskId2 },
            success: function(response) {
                console.log("Raw response:", response); // Log raw response
                
                // Assume response is an object or text format
                var data = response; // No parsing needed
                
                // Check for an error or handle the response directly
                if (data.error) {
                    alert(data.error);
                } else {
                    // Set the src of the image to display it in the modal
                    $('#Modal3 img').attr('src', data.bimg);
                    
                    $('#Modal3').modal('show');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("AJAX error:", textStatus, errorThrown);
                alert('Failed to fetch details');
            }
        });
    });
});

//start work in new task table
$(document).ready(function() {
    $('.start-work-btn').click(function(e) {
        e.preventDefault(); 
        var taskId = $(this).data('task-id');
        console.log(taskId);
        
        $.ajax({
            url: 'backend.php',
            type: 'POST',
            data: { update_status: true, task_id: taskId },
            success: function(response) {
                
                try {
                    var data = JSON.parse(response); // Parse JSON response
                    
                    if (data.error) {
                        alert(data.error);
                    } else {
                        $('#statusinprogress').load(location.href + "#statusinprogress");
                        $('#reload-table-btn').click(function() {
        reloadTable();
    });
                        $('#addnewtask').load(location.href + ' #addnewtask');
                        $('#navref').load(location.href + ' #navref');
                        


                    }
                } catch (e) {
                    alert('Error parsing JSON response.');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('AJAX request failed: ' + textStatus);
            }
        });
    });
});

//work completed status in inprogress table
$(document).ready(function() {
    $('.work-comp').on('click', function(e) {
        e.preventDefault();  // Prevent form submission
        var taskId = $(this).data('task-id');
        $('#taskid').val(taskId);
        $('#Modal2').modal('show');
    });

    $('#save-btn').on('click', function() {
        var taskId = $('#taskid').val();
        var completionStatus = $('input[name="completionStatus"]:checked').val();
        var imgAfter = $('#imgafter')[0].files[0];
        var reason = $('#reason').val(); // Capture reason from the input field

        if (!taskId || !completionStatus) {
            alert('Please provide all required information.');
            return;
        }

        var formData = new FormData();
        formData.append("update", true);

        formData.append('task_id', taskId);
        formData.append('completion_status', completionStatus);
        formData.append('reason', reason); // Append reason to form data

        if (imgAfter) {
            formData.append('img_after', imgAfter);
        }

        $.ajax({
            url: 'backend.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert('Updated');
                $('#Modal2').modal('hide');
                $('#statusinprogress').load(location.href + ' #statusinprogress > *');
                $('#approval').load(location.href + ' #approval > *');
                $('#navref').load(location.href + ' #navref > *');
            },
            error: function() {
                alert('An error occurred. Please try again.');
            }
        });
    });

    // Show the reason input field only when 'Partially Completed' is selected
    $('input[name="completionStatus"]').on('change', function() {
        if ($(this).val() === 'Partially Completed') {
            $('#reason-container').show();
        } else {
            $('#reason-container').hide();
        }
    });
});



</script>
<script>
    //after image showing
    // Show image
 // Show image
$(document).on('click', '.showImage', function(e) {
    e.preventDefault();  // Prevent form submission
    var task_id = $(this).data('task-id'); 
    console.log(task_id); 

    $.ajax({
        type: "POST",
        url: "backend.php",
        data: {
            'get_image': true,
            'task_id': task_id
        },
        dataType: "json",
        success: function(response) {
            console.log(response);

            if (response.status == 200) {
                console.log('Image Path:', response.data.after_photo);

                if (response.data.after_photo) {
                    $('#modalImage').attr('src', response.data.after_photo);
                } else {
                    alert('No image found.');
                }

                $('#Modal4').modal('show');
            } else {
                alert(response.message || 'An error occurred while retrieving the image.');
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error: ", xhr.responseText);
            alert('An error occurred: ' + error + "\nStatus: " + status + "\nDetails: " + xhr.responseText);
        }
    });
});


</script>
<script>


//before image showing
    // Show image
 // Show image
$(document).on('click', '.showbeforeimg', function(e) {
    e.preventDefault(); 
    var task_id = $(this).data('task-id'); 
    console.log(task_id); 

    $.ajax({
        type: "POST",
        url: "backend.php",
        data: {
            'get_bef': true,
            'task_id': task_id
        },
        dataType: "json",
        success: function(response) {
            console.log(response);

            if (response.status == 200) {
                console.log('Image Path:', response.data.after_photo);

                if (response.data.after_photo) {
                    $('#modalImage1').attr('src', response.data.after_photo);
                } else {
                    alert('No image found.');
                }

                $('#Modal3').modal('show');
            } else {
                alert(response.message || 'An error occurred while retrieving the image.');
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error: ", xhr.responseText);
            alert('An error occurred: ' + error + "\nStatus: " + status + "\nDetails: " + xhr.responseText);
        }
    });
});
</script>
<script>
    function validateSize(input){
        const fileSize = input.files[0].size/1024;
         var ext = input.value.split(".");
         ext = ext[ext.length-1].toLowerCase();
         var arrayExtensions = ["jpg", "jpeg"];
         if(arrayExtensions.lastIndexOf(ext)==-1){
            alert("Invalid file type");
            $(input).val('');

         }
         else if(fileSize > 2048057nm){
            alert("file is too large");
            $(input).val('');
         }

    }
</script>




</body>

</html>