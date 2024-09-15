<?php
include("db.php");
$sql1 = "SELECT complaints_detail.*,comments.* FROM complaints_detail LEFT JOIN comments on complaints_detail.id=comments.problem_id WHERE complaints_detail.status = 6";
$result1 = mysqli_query($conn, $sql1);

?>


<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css" integrity="sha512-IXuoq1aFd2wXs4NqGskwX2Vb+I8UJ+tGJEu/Dc0zwLNKeQ7CW3Sr6v0yU3z5OQWe3eScVIkER4J9L7byrgR/fA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap CSS (Optional but recommended) -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <title>Mkce Complain Management Systems</title>
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <!--For data table-->
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<style>
    .left-sidebar {
        position: absolute;
        width: 250px;
        height: 100%;
        top: 0px;
        z-index: 10;
        padding-top: 64px;
        background: #fff;
        -webkit-box-shadow: 1px 0px 20px rgba(0, 0, 0, 0.08);
        box-shadow: 1px 0px 20px rgba(0, 0, 0, 0.08);
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
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                            class="ti-menu ti-close"></i></a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="p_index.php">
                        <!-- Logo icon -->
                        <b class="logo-icon p-l-8">
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="assets\images\srms.png" alt="homepage" class="light-logo" />

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
                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-right">
                        <!-- ============================================================== -->
                        <!-- Logout-->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href=""
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                    src="assets/images/users/1.jpg" alt="user" class="rounded-circle" width="31"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated">
                                <a class="dropdown-item" href="javascript:void(0)"><i
                                        class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>

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
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="p_index.php" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="requirements1.php" aria-expanded="false"><i class="mdi mdi-chart-bar"></i><span class="hide-menu">Requirements</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="complaint.php" aria-expanded="false"><i class="mdi mdi-chart-bubble"></i><span class="hide-menu">Complaint Status</span></a></li>

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
                        <h4 class="page-title">Requirements Status</h4>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="p_index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Requirements</li>
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


                <!-- Tabs -->
                <div class="card">
                    <!-- Tab panes -->
                    <div class="tab-content tabcontent-border">


                        <div class="card">
                            <div class="card-body" style="padding: 10px;">
                                <div class="table-responsive">
                                    <!--id:addnewtask-->
                                    <table id="addnewtask" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>

                                                <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color:white;"><b>
                                                        <h5>S.No</h5>
                                                    </b></th>
                                                <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color:white;"><b>
                                                        <h5>Dept</h5>
                                                    </b></th>
                                                <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color:white;"><b>
                                                        <h5>Block</h5>
                                                    </b></th>
                                                <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color:white;"><b>
                                                        <h5>Venue</h5>
                                                    </b></th>
                                                <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color:white;"><b>
                                                        <h5>Problem Description</h5>
                                                    </b></th>
                                                <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color:white;"><b>
                                                        <h5>Image</h5>
                                                    </b></th>
                                                <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color:white;"><b>
                                                        <h5>Date_raised</h5>
                                                    </b></th>
                                                <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color:white;"><b>
                                                        <h5>Deadline</h5>
                                                    </b></th>
                                                <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color:white;"><b>
                                                        <h5>Requirements</h5>
                                                    </b></th>
                                                <th class="text-center" style="background:linear-gradient(to bottom right, #cc66ff 1%, #0033cc 100%); color:white;"><b>
                                                        <h5>Action</h5>
                                                    </b></th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $s = 1;
                                            while ($row = mysqli_fetch_array($result1)) {
                                            ?>
                                                <tr>
                                                    <th scope="row"><?php echo $s ?></td>
                                                    <td><?php echo $row['department'] ?></td>
                                                    <td><?php echo $row['block_venue'] ?></td>
                                                    <td><?php echo $row['venue_name'] ?></td>
                                                    <td class="text-center"><button type="button" class="btn btn-info margin-5" data-toggle="modal" data-target="#<?php echo $row['problem_id']; ?>" height="30px" width="30px">View description</button></td>
                                                    <!--Description id=problem-->
                                                    <div class="modal fade" id="<?php echo $row['problem_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Problem Description</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="id" id="id">
                                                                    <textarea id="problem_description" name="problem_description" class="form-control" readonly><?php echo $row['problem_description'] ?></textarea>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <td>

                                                        <button type="button" class="btn btn-info showImage1" data-toggle="modal" data-target="imageModal1" data-id="<?php echo $row['problem_id']; ?>">View</button>
                                                    </td>

                                                    <td><?php echo $row['date_of_reg'] ?></td>
                                                    <td><?php echo $row['days_to_complete'] ?></td>
                                                    <td><?php echo $row['reason'] ?></td>
                                                    <td>
                                                        <button type="button" value="<?php echo $row['problem_id'] ?>" class="btn btn-success userapprove">Approve</button>

                                                        <button type="button" value="<?php echo $row['problem_id']; ?>" class="btn btn-danger" data-toggle="modal" data-target="#rejectModal">Reject</button>

                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            $s++
                                            ?>

                                        </tbody>

                                    </table>
                                </div>

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

    <footer class="footer text-center" style="padding-left: 250px;">
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
    </div>


    <!--Task Completion--><!--Id:comment-->
    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Reject Problem</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="rejectreason">
                    <div class="modal-body">
                        <p>Are you sure you want to reject this problem?</p>
                        <textarea name="reason" class="form-control" placeholder="Reason for rejection" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Reject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- problem description -->


    <!-- image-->
    <!-- ============================================================== -->
    <div class="modal fade" id="imageModal1" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Problem Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="rejectreason">
                    <div class="modal-body">
                        <img id="modalImage1" src="" alt="Image" class="img-fluid" style="width:1500px;height:250px;">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


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
    <!--for data table-->
    <script src="assets/extra-libs/DataTables/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>

    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js" integrity="sha512-JnjG+Wt53GspUQXQhc+c4j8SBERsgJAoHeehagKHlxQN+MtCCmFDghX9/AcbkkNRZptyZU4zC8utK59M5L45Iw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            $('#addnewtask').DataTable();
        });

        //requirement approve
        $(document).on('click', '.userapprove', function(e) {
            e.preventDefault();
            var user_id = $(this).val();
            console.log(user_id);
            if (confirm('Are you sure you want to approve?')) {

                $.ajax({
                    type: "POST",
                    url: "backend1.php",
                    data: {
                        'approve_user': true,
                        'user_id': user_id
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 500) {
                            alert(res.message);
                        } else {
                            Swal.fire({
                                title: "Approved!",
                                text: "Requirements are verified!",
                                icon: "success"
                            });
                            $('#addnewtask').load(location.href + " #addnewtask");
                        }
                    }
                });
            }
        });

        //reject 
        $(document).on('submit', '#rejectreason', function(e) {
            e.preventDefault(); // Prevent default form submission

            // Create a FormData object from the form
            var formData = new FormData(this);

            // Get the problem_id from the button that triggered the modal
            var problem_id = $('#rejectModal').data('problem_id');
            console.log(problem_id);

            // Append the problem_id to the FormData
            formData.append("problem_id", problem_id);
            formData.append("save_reason", true); // Add an identifier for the backend

            // Perform the AJAX request
            $.ajax({
                type: "POST",
                url: "backend1.php", // Replace with your backend PHP script
                data: formData,
                processData: false, // Important: Prevent jQuery from processing the data
                contentType: false, // Important: Prevent jQuery from setting the content type
                success: function(response) {
                    console.log(response);
                    var res = jQuery.parseJSON(response);

                    if (res.status == 200) {
                        // Hide the modal on success

                        $('#rejectModal').modal('hide');

                        // Reset the form after submission
                        $('#rejectreason')[0].reset();
                        // Reload the task or the section after update
                        $('#addnewtask').load(location.href + " #addnewtask");
                        // Show a success message
                        alertify.error('Rejected Success');
                    } else {
                        // Handle errors
                        alertify.error('Error Occured');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle any errors that occurred during the request
                    console.error('AJAX Error:', error);
                    alert('An error occurred. Please try again.');
                }
            });
        });

        // Pass the problem_id to the modal when it is shown
        $('#rejectModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var problem_id = button.val(); // Extract problem_id from button value
            var modal = $(this);
            modal.data('problem_id', problem_id); // Store problem_id in the modal's data attribute
        });

        //image
        // Show image
        $(document).on('click', '.showImage1', function() {
            var user_id = $(this).data('id'); // Get the user ID from data attribute
            console.log(user_id);

            $.ajax({
                type: "POST",
                url: "backend1.php",
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
                        $('#modalImage1').attr('src', 'uploads/' + res.data.images); // Dynamically set the image source
                        $('#imageModal1').modal('show'); // Show the modal
                    }
                }
            });
        });
    </script>



</body>

</html>