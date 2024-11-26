<?php
include('../admin/config/dbcon.php');
// Check if user is logged in
if (!isset($_SESSION['auth'])) {
  header('location: ../login.php');
  exit();
}

// Get the user data
$user_id = $_SESSION['auth_user']['id'];
$user_query = "SELECT * FROM `users` WHERE `id`='$user_id'";
$user_query_run = mysqli_query($conn, $user_query);

if (mysqli_num_rows($user_query_run) > 0) {
  $user_data = mysqli_fetch_array($user_query_run);
  $fullName = $user_data['first_name'] . " " . $user_data['last_name'];
}

?>
<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

  <div class="d-flex align-items-center justify-content-between">
    <a href="index.php" class="logo d-flex align-items-center">
      <img src="assets/img/logo.png" alt="">
      <span class="d-none d-lg-block">Shop-Sales</span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div><!-- End Logo -->

  <div class="search-bar">
    <form class="search-form d-flex align-items-center" method="POST" action="#">
      <input type="text" name="query" placeholder="Search" title="Enter search keyword">
      <button type="submit" title="Search"><i class="bi bi-search"></i></button>
    </form>
  </div><!-- End Search Bar -->

  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">

      <!--language-->
      <li class="nav-item dropdown">
        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
          <i class="bi bi-globe"></i>
        </a><!-- End Language Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow language">
          <li class="dropdown-header">
            <h6>Select Language</h6>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="#">
              <img src="../admin/assets/img/flags/us.png" alt="English Flag" class="flag">
              <span>English</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="#">
              <img src="../admin/assets/img/flags/fr.png" alt="French Flag" class="flag">
              <span>French</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>
        </ul><!-- End Language Dropdown Items -->
        <style>
          .flag
          {
            width: 20px;
            height: 20px;
            border-radius: 5px;
            margin-right: 5px;
          }
        </style>
      <li class="nav-item dropdown">
        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
          <i class="bi bi-bell"></i>
          <span class="badge bg-primary badge-number">4</span>
        </a><!-- End Notification Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
          <li class="dropdown-header">
            <h6>Hi, <?php echo $fullName; ?></h6>
            <span>Welcome to Shop-Sales</span>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li class="notification-item">
            <i class="bi bi-exclamation-circle text-warning"></i>
            <div>
              <h4>Lorem Ipsum</h4>
              <p>Quae dolorem earum veritatis oditseno</p>
              <p>30 min. ago</p>
            </div>
          </li>

          <li>
            <hr class="dropdown-divider">
          </li>

          <li class="notification-item">
            <i class="bi bi-check-circle text-success"></i>
            <div>
              <h4>Sit rerum fuga</h4>
              <p>Quae dolorem earum veritatis oditseno</p>
              <p>2 hrs. ago</p>
            </div>
          </li>

          <li>
            <hr class="dropdown-divider">
          </li>
          <li class="dropdown-footer">
            <a href="#">Show all notifications</a>
          </li>

        </ul><!-- End Notification Dropdown Items -->

      <li class="nav-item d-block d-lg-none">
        <a class="nav-link nav-icon search-bar-toggle " href="#">
          <i class="bi bi-search"></i>
        </a>
      </li><!-- End Search Icon-->

   
      <li class="nav-item dropdown">

        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
          <i class="bi bi-chat-left-text"></i>
          <span class="badge bg-success badge-number">3</span>
        </a><!-- End Messages Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
          <li class="dropdown-header">
            You have 3 new messages
            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li class="message-item">
            <a href="#">
              <img src="assets/img/messages-1.jpg" alt="" class="rounded-circle">
              <div>
                <h4>Maria Hudson</h4>
                <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                <p>4 hrs. ago</p>
              </div>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li class="dropdown-footer">
            <a href="#">Show all messages</a>
          </li>

        </ul><!-- End Messages Dropdown Items -->

      </li><!-- End Messages Nav -->

      <li class="nav-item dropdown pe-3">

        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
        <img src="../uploads/profile/<?= $user_data['profile_picture'] ?>" alt="<?= $fullName ?>" class="rounded-circle">

          <?php
          if (isset($fullName)) {
            echo "<span class='d-none d-lg-block ps-2'><span class='fw-bold'>Hi,</span> $fullName</span>";
          } else {
            echo "<span class='d-none d-lg-block ps-2'><span class='fw-bold'>Hi,</span> User</span>";
          }

          ?>
          <!--drop down arrow-->
          <i class="bi bi-chevron-down d-none d-lg-block ps-2"></i>
        </a><!-- End Profile Image Icon -->


        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
            <h6>Hi, <?php echo $fullName; ?></h6>
            <span>Welcome to Shop-Sales</span>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>


          <li>
            <a class="dropdown-item d-flex align-items-center" href="../functions/logout.php">
              <i class="bi bi-box-arrow-right"></i>
              <span>Sign Out</span>
            </a>
          </li>


        </ul><!-- End Profile Dropdown Items -->
      </li><!-- End Profile Nav -->

    </ul>
  </nav><!-- End Icons Navigation -->

</header>
<!-- End Header -->