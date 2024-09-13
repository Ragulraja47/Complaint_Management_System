<?php
include("db.php");
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png" />
  <title>Profile</title>
  <link href="assets/libs/flot/css/float-chart.css" rel="stylesheet" />
  <link href="dist/css/style.min.css" rel="stylesheet" />
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #e4e4e4;
      margin: 0;
      padding: 0;
    }

    .profile-container {
      margin: 100px auto;
      max-width: 800px;
      padding: 20px;
      background-color: #ffffff;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .profile-header img {
      border-radius: 50%;
      width: 150px;
      height: 150px;
      object-fit: cover;
      margin-bottom: 20px;
    }

    .profile-header h4 {
      margin: 0;
      font-size: 24px;
      color: #333;
    }

    .profile-header p {
      margin: 5px 0;
      color: #555;
    }

    .profile-details {
      margin-top: 20px;
      border-top: 1px solid #ddd;
      padding-top: 20px;
      text-align: left;
    }

    .profile-details h6 {
      margin: 0;
      font-size: 16px;
      font-weight: bold;
      color: #333;
    }

    .profile-details .row {
      margin-bottom: 15px;
    }

    .profile-details .col-sm-3 {
      font-weight: bold;
      color: #555;
    }

    .profile-details .col-sm-9 {
      color: #333;
    }

    footer {
      margin-top: 50px;
      padding: 10px 0;
      background-color: #ffffff;
      text-align: center;
      font-size: 14px;
      color: #333;
    }
  </style>
  <script src="assets/libs/jquery/dist/jquery.min.js"></script>
</head>

<body>
  <div id="main-wrapper">
    <header class="topbar" data-navbarbg="skin5">
      <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header" data-logobg="skin5">
          <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
            <i class="ti-menu ti-close"></i>
          </a>
          <a class="navbar-brand" href="index.html">
            <b class="logo-icon p-l-10" style="padding-left: 0px; border-left: 0px">
              <img src="assets/images/logo2.png" width="50px" alt="homepage" class="light-logo" />
            </b>
            <span class="logo-text">
              <img src="assets/images/logo-text.png" alt="homepage" class="light-logo" />
            </span>
          </a>
          <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="ti-more"></i>
          </a>
        </div>
        <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
          <ul class="navbar-nav float-left mr-auto">
            <li class="nav-item d-none d-md-block">
              <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar">
                <i class="mdi mdi-menu font-24"></i>
              </a>
            </li>
          </ul>
          <ul class="navbar-nav float-right">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="assets/images/users/1.jpg" alt="user" class="rounded-circle" width="31" />
              </a>
              <div class="dropdown-menu dropdown-menu-right user-dd animated">
                <a class="dropdown-item" href="authentication-login.html">
                  <i class="fa fa-power-off m-r-5 m-l-5"></i> Logout
                </a>
              </div>
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <aside class="left-sidebar" data-sidebarbg="skin5">
      <div class="scroll-sidebar">
        <nav class="sidebar-nav">
          <ul id="sidebarnav" class="p-t-30">
            <li class="sidebar-item">
              <a class="sidebar-link waves-effect waves-dark sidebar-link" href="index.html" aria-expanded="false">
                <i class="mdi mdi-view-dashboard"></i>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link waves-effect waves-dark sidebar-link" href="profile.php" aria-expanded="false">
                <i class="mdi mdi-account"></i>
                <span class="hide-menu">Profile</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link has-arrow waves-effect waves-dark" href="edit-profile.html" aria-expanded="false">
                <i class="mdi mdi-account-edit"></i>
                <span class="hide-menu">Edit Profile</span>
              </a>
              <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item">
                  <a href="basic-details.php" class="sidebar-link">
                    <i class="mdi mdi-account-settings-variant"></i>
                    <span class="hide-menu"> Basic Details </span>
                  </a>
                </li>
                <li class="sidebar-item">
                  <a href="academic-details.html" class="sidebar-link">
                    <i class="mdi mdi-book-multiple"></i>
                    <span class="hide-menu"> Academic Details </span>
                  </a>
                </li>
                <li class="sidebar-item">
                  <a href="examdetails.php" class="sidebar-link">
                    <i class="mdi mdi-book-open"></i>
                    <span class="hide-menu"> Exams Details </span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link waves-effect waves-dark sidebar-link" href="bus.html" aria-expanded="false">
                <i class="mdi mdi-bus"></i>
                <span class="hide-menu">Bus Booking</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link waves-effect waves-dark sidebar-link" href="password.php" aria-expanded="false">
                <i class="mdi mdi-account-key"></i>
                <span class="hide-menu">Change password</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link waves-effect waves-dark sidebar-link" href="https://www.camsmkce.in" aria-expanded="false">
                <i class="mdi mdi-web"></i>
                <span class="hide-menu">CAMSS</span>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </aside>

    <div class="page-wrapper">
      <div class="container-fluid profile-container mt-4">
        <div class="profile-header">
          <img src="assets/images/users/default.jpg" alt="Profile Image" id="profile-img">
          <div>
            <h4 id="profile-name">Head</h4>
            <p class="text-secondary" id="profile-designation">Head of the department</p>
            <p class="text-muted" id="profile-department">Department of Artificial Intelligence and Machine Learning</p>
          </div>
        </div>
        <div class="profile-details">
          <div class="row">
            <div class="col-sm-3">
              <h6>Full Name</h6>
            </div>
            <div class="col-sm-9" id="profile-fullname">Head</div>
          </div>
          <hr>
          <div class="row">
            <div class="col-sm-3">
              <h6>Gender</h6>
            </div>
            <div class="col-sm-9" id="profile-gender">Male/Female</div>
          </div>
          <hr>
          <div class="row">
            <div class="col-sm-3">
              <h6>Email</h6>
            </div>
            <div class="col-sm-9" id="profile-email">head_name.dept@mkce.ac.in</div>
          </div>
          <hr>
          <div class="row">
            <div class="col-sm-3">
              <h6>Date of Birth</h6>
            </div>
            <div class="col-sm-9" id="profile-dob">00 - 00 - 0000</div>
          </div>
          <hr>
          <div class="row">
            <div class="col-sm-3">
              <h6>Mobile</h6>
            </div>
            <div class="col-sm-9" id="profile-mobile">93344XXXXX</div>
          </div>
          <hr>
          <div class="row">
            <div class="col-sm-3">
              <h6>Address</h6>
            </div>
            <div class="col-sm-9" id="profile-address">1, xx street, xxxx nagar, xxx.</div>
          </div>
        </div>
      </div>
      <footer class="footer">
        <b>2024 &copy; M.Kumarasamy College of Engineering. All Rights Reserved.<br>
        Developed and Maintained by Technology Innovation Hub.</b>
      </footer>
    </div>
  </div>

  <!-- script for profile info -->
  <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="assets/extra-libs/sparkline/sparkline.js"></script>
    <script src="dist/js/waves.js"></script>
    <script src="dist/js/sidebarmenu.js"></script>
    <script src="dist/js/custom.min.js"></script>
    <script src="assets/libs/flot/excanvas.js"></script>
    <script src="assets/libs/flot/jquery.flot.js"></script>
    <script src="assets/libs/flot/jquery.flot.pie.js"></script>
    <script src="assets/libs/flot/jquery.flot.time.js"></script>
    <script src="assets/libs/flot/jquery.flot.stack.js"></script>
    <script src="assets/libs/flot/jquery.flot.crosshair.js"></script>
    <script src="assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
    <script src="dist/js/pages/chart/chart-page-init.js"></script>
  <script>
  $(document).ready(function() {
    $.ajax({
      url: 'backend.php',
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        if (data.error) {
          alert(data.error);
        } else {
          $('#profile-img').attr('src', data.hod_photo);
          $('#profile-name').text(data.hod_name);
          $('#profile-designation').text('Head of the department'); // Modify as needed
          $('#profile-department').text('Department of Artificial Intelligence and Machine Learning'); // Modify as needed
          $('#profile-fullname').text(data.hod_name);
          $('#profile-gender').text(data.hod_gender);
          $('#profile-email').text(data.hod_email);
          $('#profile-dob').text(data.hod_date_of_birth);
          $('#profile-mobile').text(data.hod_mobile);
          $('#profile-address').text(data.hod_address);
        }
      },
      error: function(xhr, status, error) {
        console.error("AJAX request failed:", status, error);
      }
    });
  });
  </script>
</body>
</html>
