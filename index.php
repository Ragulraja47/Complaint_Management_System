<?php
include("db.php");
$sql = "SELECT * FROM complaints_detail WHERE status = 2";
$sql1 = "SELECT * FROM complaints_detail WHERE status IN (4, 6, 7, 8, 9, 10, 12)";
$sql2 = "SELECT * FROM complaints_detail WHERE status = 11";
$sql3 = "SELECT * FROM complaints_detail WHERE status = 5";
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
    <title>MIC</title>
    <!-- Custom CSS -->
    <link href="assets/libs/flot/css/float-chart.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
    <link href="dboardstyles.css" rel="stylesheet">
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
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="https://www.mkce.ac.in">
                        <!-- Logo icon -->
                        <b class="logo-icon p-l-10" style="padding-left:0px; border-left:0px;">
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="assets/images/logo2.png" width="50px" alt="homepage" class="light-logo" />
                           
                        </b>
                        <!--End Logo icon -->
                         <!-- Logo text -->
                        <span class="logo-text">
                             <!-- dark Logo text -->
                             <img src="assets/images/logo-text.png" alt="homepage" class="light-logo" />
                            
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
                    </ul>  
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-right">
                        <!-- ============================================================== -->
                        <!-- Comment -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-bell font-24"></i>
                            </a>
                             <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">Notifications</a>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End Comment -->
                        <!-- ============================================================== -->

                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="assets/images/users/1.jpg" alt="user" class="rounded-circle" width="31"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="authentication-login.html"><i class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
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
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="index.html" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="profile.html" aria-expanded="false"><i class="mdi mdi-account"></i><span class="hide-menu">Profile</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="edit-profile.html" aria-expanded="false"><i class="mdi mdi-account-edit"></i><span class="hide-menu">Edit Profile</span></a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item"><a href="basic-details.php" class="sidebar-link"><i class="mdi mdi-account-settings-variant"></i><span class="hide-menu"> Basic Details </span></a></li>
                            <li class="sidebar-item"><a href="academic-details.html" class="sidebar-link"><i class="mdi mdi-book-multiple"></i><span class="hide-menu"> Academic Details </span></a></li>
                        </ul>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="password.php" aria-expanded="false"><i class="mdi mdi-account-key"></i><span class="hide-menu">Change password</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="hod.php" aria-expanded="false"><i class="mdi mdi-comment-text"></i><span class="hide-menu">Feedback Corner</span></a>
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
                        <h4 class="page-title">Dashboard (Welcome 115XXXX)</h4>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
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
                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-hover">
                            <div class="box bg-cyan text-center">
                                <h1 class="font-light text-white"><i class="fas fa-user"></i></h1>
                                <h6 class="text-white"><b>Name<br>Dr.M.Murugesan</b></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-hover">
                            <div class="box bg-success text-center">
                                <h1 class="font-light text-white"><i class="mdi mdi-account-multiple"></i></h1>
                                <h6 class="text-white"><b>Role<br>Head of the Department</b></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-hover">
                            <div class="box bg-warning text-center">
                                <h1 class="font-light text-white"><i class="mdi mdi-account-card-details"></i></h1>
                                <h6 class="text-white"><b>Branch<br></b>M.KUMARASAMY COLLEGE OF ENGINEERING</h6>
                            </div>
                        </div>                        
                    </div>
                </div><br>
                <div class="card">
        <div class="card-body">
            <h4 class="card-title m-b-0">Issue Analysis</h4><br>
            <div class="row">
                <!-- Pending -->
                <div class="col-12 col-md-3 mb-3">
                    <div class="cir" >
                        <div class="bo">
                            <div class="content1">
                                <div class="stats-box text-center p-3" style="background-color:orange;">
                                    <i class="fas fa-clock"></i>
                                    <h1 class="font-light text-white">
                                        <?php $query2 = "SELECT COUNT(*) as pending FROM complaints_detail WHERE  status ='2'";
                                        $output2 = mysqli_query($conn, $query2);
                                        $row2 = mysqli_fetch_assoc($output2);
                                        $pendingCount = $row2['pending'];
                                        echo $pendingCount;
                                        ?>
                                    </h1>
                                    <small class="font-light">Pending</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Approved -->
                <div class="col-12 col-md-3 mb-3">
                    <div class="cir">
                        <div class="bo">
                            <div class="content1">
                                <div class="stats-box text-center p-3" style="background-color:rgb(14, 86, 239);">
                                    <i class="fas fa-check"></i>
                                    <h1 class="font-light text-white">
                                        <?php $query2 = "SELECT COUNT(*) as approved FROM complaints_detail WHERE   (status ='4' or status ='6' or status='7' or status='8' or status='9' or status='10' or status='11')";
                                        $output2 = mysqli_query($conn, $query2);
                                        $row2 = mysqli_fetch_assoc($output2);
                                        $pendingCount = $row2['approved'];
                                        echo $pendingCount;
                                        ?>
                                    </h1>
                                    <small class="font-light">Approved</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Completed -->
                <div class="col-12 col-md-3 mb-3">
                    <div class="cir">
                        <div class="bo">
                            <div class="content1">
                                <div class="stats-box text-center p-3" style="background-color:rgb(70, 160, 70);">
                                    <i class="mdi mdi-check-all"></i>
                                    <h1 class="font-light text-white">
                                        <?php $query2 = "SELECT COUNT(*) as completed FROM complaints_detail WHERE  status ='11'";
                                        $output2 = mysqli_query($conn, $query2);
                                        $row2 = mysqli_fetch_assoc($output2);
                                        $pendingCount = $row2['completed'];
                                        echo $pendingCount;
                                        ?>
                                    </h1>
                                    <small class="font-light">Completed</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rejected -->
                <div class="col-12 col-md-3 mb-3">
                    <div class="cir">
                        <div class="bo">
                            <div class="content1">
                                <div class="stats-box text-center p-3" style="background-color: rgb(241, 0, 0);">
                                    <i class="mdi mdi-close-circle"></i>
                                    <h1 class="font-light text-white">
                                        <?php $query2 = "SELECT COUNT(*) as rejected FROM complaints_detail WHERE  status ='5'";
                                        $output2 = mysqli_query($conn, $query2);
                                        $row2 = mysqli_fetch_assoc($output2);
                                        $pendingCount = $row2['rejected'];
                                        echo $pendingCount;
                                        ?>
                                    </h1>
                                    <small class="font-light">Rejected</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

                        <!-- <div class="m-t-20">
                            <div class="d-flex no-block align-items-center">
                                <span>100% &nbsp; Basic Profile</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 100%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div> -->
                        <!-- <div>
                            <div class="d-flex no-block align-items-center m-t-25">
                                <span>100% &nbsp; Academic Profile</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div> -->
                    
    <footer class="footer text-center">
        <b>2024 &copy M.Kumarasamy College of Engineering All Rights Reserved.<br>
        Developed and Maintained by Technology Innovation Hub.</b>
    </footer>

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
    
</body>

</html>