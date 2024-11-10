<?php
session_start(); // Ensure the session is started
if (!isset($_SESSION['faculty_id'])) {
    // Redirect to login page if not logged in
    header("Location: flogin.php");
    exit();
}

include('db.php'); // Include the configuration file

$query="SELECT * FROM products";
$result = mysqli_query($conn, $query);






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
                        <b class="logo-icon p-l-10" style="padding-left:0px; border-left:0px;">
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
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="newprod.php" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span
                                    class="hide-menu">New Product</span></a>
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
                <h3>New Product Request</h3>
                
                <div class="tab-pane p-20" id="inprogress" role="tabpanel">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newprodmodal">
  Add
</button>
<br><br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table id="producttable" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center"><b>S.No</b></th>
                                                            <th class="text-center"><b>Product Name</b></th>
                                                            <th class="text-center"><b>Quantity</b></th>
                                                            <th class="text-center"><b>Block</b></th>
                                                            <th class="text-center"><b>Venue</b></th>
                                                            <th class="text-center"><b>Expected Date for Receiving</b></th>
                                                            <th class="text-center"><b>Letter Pad</b></th>
                                                            <th class="text-center"><b>Status</b></th>
                                                            <th class="text-center"><b>Action</b></th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        
                                                            $count = 1;
                                                            while($row=mysqli_fetch_array($result)){
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $count++;?></td>
                                                            <td><?php echo $row['name'];?></td>
                                                            <td><?php echo $row['quantity'];?></td>
                                                            <td><?php echo $row['block'];?></td>
                                                            <td><?php echo $row['venue'];?></td>
                                                            <td><?php echo $row['date'];?></td>
                                                            <td>
                                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#letter">Letter Pad</button></td>
                                                            <td><button type="button" class="btn btn-success">Waiting for approval</button></td>
                                                            <td><button type="button" class="btn btn-info">Edit</button>
                                                            <button type="button" class="btn btn-danger">Delete</button></td>


                                                            
                                                            </tr>
                                                            <?php
                                                            }?>
                                                       
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             


    </div>
                
                                                           
                                        </div>
                                    </div>
                            
                                    <!--pending work modal end -->

                                    </div>
                                    <div class="modal fade" id="letter" tabindex="-1" role="dialog" aria-labelledby="letter" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="letter">Letter Pad</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="font-family: Arial, sans-serif; line-height: 1.6;">
                    <div style="text-align: center; margin-bottom: 20px;">
                        <p>Date:(date)</strong></p>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <p><strong>(faculty name)</strong><br>
                        Infra Coordinator - (department)<br>
                        M.Kumarasamy College of Engineering,<br>
                        Karur.
                        </p>

                        <p>Through<br>
                        The Head of Department,<br>
                        Department of (dept),<br>
                        M.Kumarasamy College of Engineering,<br>
                        Karur.
                        </p>

                        <p>To<br>
                        The Principal,<br>
                        M.Kumarasamy College of Engineering,<br>
                        Karur.
                        </p>

                        <p>Respected Sir,</p>
                        <p><strong>Sub: Requisition for (product name) - reg.</strong></p>
                        <p>We request you to kindly approve the purchase of a (product name)for our (department)) department as we are in need of it.</p>

                        <p>Thanking you.</p>
                    </div>

                    <div style=" margin-top: 30px;">
                        <p style="text-align: left;">Manager</strong><br></p>
                        <p style="text-align: right;"><strong>Principal</strong>
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
                                    <div class="modal fade" id="newprodmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Product Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="newprod">
        <div class="d-flex flex-column">
          <div class="input-group input-group-lg mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-lg">Product Name</span>
            </div>
            <input type="text" name="prod_name" class="form-control" aria-label="Large" aria-describedby="inputGroup-sizing-sm">
          </div>
          <div class="input-group input-group-lg mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-lg">Product Quantity</span>
            </div>
            <input type="text" name="quantity" class="form-control" aria-label="Large" aria-describedby="inputGroup-sizing-sm">
          </div>
          <div class="input-group input-group-lg mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-lg">Block</span>
            </div>
            <input type="text" name="block" class="form-control" aria-label="Large" aria-describedby="inputGroup-sizing-sm">
          </div>
          <div class="input-group input-group-lg mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-lg">Venue</span>
            </div>
            <input type="text" name="venue" class="form-control" aria-label="Large" aria-describedby="inputGroup-sizing-sm">
          </div>
          <div class="input-group input-group-lg mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-lg">Expected Date</span>
            </div>
            <input type="date" name="date" class="form-control" aria-label="Large" aria-describedby="inputGroup-sizing-sm">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add</button>
      </div>
    </div>
  </div>
    </div>  

</div>
        <footer class="footer text-center">
            <b> 2024 © M.Kumarasamy College of Engineering All Rights Reserved.
                <br> Developed and Maintained by Technology Innovation Hub</b>.
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

    <!-- Set Today date in Raise Complaint-->
    <script>
        var today = new Date().toISOString().split('T')[0];
        var dateInput = document.getElementById('date_of_reg');
        dateInput.setAttribute('min', today);
        dateInput.setAttribute('max', today);
        dateInput.value = today;



        $('input[id="yes"]').on('change', function() {
        if ($(this).is(':checked')) {
            $('#formbtn').show();
        } 
        else{
            $('#formbtn').hide();


        }
    });
    </script>


    <!--file size and type -->
    <script>
        function validateSize(input) {
            const filesize = input.files[0].size / 1024; // Size in KB
            var ext = input.value.split(".");
            ext = ext[ext.length - 1].toLowerCase();
            var arrayExtensions = ["jpg", "jpeg", "png"];
            if (arrayExtensions.lastIndexOf(ext) == -1) {
                swal("Invalid Image Format, Only .jpeg, .jpg, .png format allowed", "", "error");
                $(input).val('');
            } else if (filesize > 2048) {
                swal("File is too large, Maximum 2 MB is allowed", "", "error");
                $(input).val('');
            }
        }
    </script>


    <script>
        // DataTables
        $(document).ready(function() {
            $('#producttable').DataTable();
        
        });
    </script>


    <script>
       $(document).on("submit","#newprod",function(e){
        e.preventDefault();
        var form = new FormData(this);
        console.log(form);
        form.append("add",true);
            $.ajax({
                type:"POST",
                url:"backend1.php",
                data:form,
                processData:false,
                contentType:false,
                success:function(response){
                    var res = jQuery.parseJSON(response);

                    if(res.status==200){
                        alert("product request success");
                        $("#newprod")[0].reset();
                        $("#newprodmodal").modal("hide");

                        $("#producttable").load(location.href + " #producttable");
                        




                    }
                }
            
        })
       })
    </script>
</body>
<div scrible-ignore="" id="skribel_annotation_ignore_browserExtensionFlag" class="skribel_chromeExtension"
    style="display: none"></div>

</html>