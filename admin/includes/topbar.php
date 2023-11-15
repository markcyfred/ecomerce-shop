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

      <li class="nav-item d-block d-lg-none">
        <a class="nav-link nav-icon search-bar-toggle " href="#">
          <i class="bi bi-search"></i>
        </a>
      </li><!-- End Search Icon-->

      <li class="nav-item dropdown">

        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
          <i class="bi bi-bell"></i>
          <span class="badge bg-primary badge-number">4</span>
        </a><!-- End Notification Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
          <li class="dropdown-header">
            You have 4 new notifications
            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
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

      </li><!-- End Notification Nav -->

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
          <img src="assets/img/profile.jpg" alt="Profile" class="rounded-circle">
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
<div class="col-xxl-7 col-xxxl-6"><div class="card mb-25 border-0 rounded-0 welcome-box"><div class="card-body pe-15 pe-sm-20 pe-md-0 pb-0 pt-15 pt-sm-20"><div class="row align-items-center"><div class="col-lg-6 col-md-6"><div class="title position-relative"><h3 class="fw-semibold mb-8"> Good Morning, <span class="fw-bold">Victor!</span></h3><span class="d-block text-black-emphasis fs-md-15 fs-lg-16"> Here’s what happening with your store today </span></div><ul class="ps-0 mb-0 list-unstyled"><li class="d-inline-block text-uppercase fw-medium fs-13 text-black-emphasis position-relative"> TODAY’S VISIT <span class="d-block fw-black lh-1 text-black mt-5 mt-md-10"> 15,209 </span></li><li class="d-inline-block text-uppercase fw-medium fs-13 text-black-emphasis position-relative"> TODAY’S TOTAL SALES <span class="d-block fw-black lh-1 text-black mt-5 mt-md-10"> $29,115.50 </span></li></ul></div><div class="col-lg-6 col-md-6 text-center mt-15 mt-md-0"><img src="/adlash/img/welcome1.1814fce0.png" alt="welcome-image"></div></div></div></div><div class="row"><div class="col-lg-6 col-xxxl-6 col-md-6"><div class="card mb-25 border-0 rounded-0 bg-white expected-earnings-box"><div class="card-body p-15 p-sm-20 p-md-25 p-lg-30 letter-spacing"><span class="d-block mb-6 fs-13 text-uppercase fw-medium text-dark-emphasis"> EXPECTED EARNINGS </span><h4 class="fw-black mb-12 lh-1">$32,000</h4><span class="fw-bold text-success text-badge d-inline-block"> 5.5% <i class="flaticon-up-arrow fs-11 lh-1 position-relative top-1"></i></span><ul class="list ps-0 mb-0 list-unstyled mt-15"><li class="text-muted position-relative fw-medium"> Groceries - <span class="text-black fw-bold">$9,500</span></li><li class="text-muted position-relative fw-medium"> Electronics - <span class="text-black fw-bold">$11,500</span></li><li class="text-muted position-relative fw-medium"> Others - <span class="text-black fw-bold">$11,000</span></li></ul><div id="earningChart" class="chart"><div class="vue-apexcharts" style="min-height: 132.8px;"><div id="apexchartsdenhqa6u" class="apexcharts-canvas apexchartsdenhqa6u apexcharts-theme-light" style="width: 300px; height: 132.8px;"><svg id="SvgjsSvg1767" width="300" height="132.8" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><foreignObject x="0" y="0" width="300" height="132.8"><div class="apexcharts-legend" xmlns="http://www.w3.org/1999/xhtml"></div></foreignObject><g id="SvgjsG1769" class="apexcharts-inner apexcharts-graphical" transform="translate(88, 0)"><defs id="SvgjsDefs1768"><clipPath id="gridRectMaskdenhqa6u"><rect id="SvgjsRect1770" width="130" height="148" x="-2" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMaskdenhqa6u"></clipPath><clipPath id="nonForecastMaskdenhqa6u"></clipPath><clipPath id="gridRectMarkerMaskdenhqa6u"><rect id="SvgjsRect1771" width="130" height="152" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><g id="SvgjsG1772" class="apexcharts-pie"><g id="SvgjsG1773" transform="translate(0, 0) scale(1)"><circle id="SvgjsCircle1774" r="37.35121951219512" cx="63" cy="63" fill="transparent"></circle><g id="SvgjsG1775" class="apexcharts-slices"><g id="SvgjsG1776" class="apexcharts-series apexcharts-pie-series" seriesName="series-1" rel="1" data:realIndex="0"><path id="SvgjsPath1777" d="M 63 5.536585365853654 A 57.463414634146346 57.463414634146346 0 0 1 101.10529226378814 106.01198348027108 L 87.7684399714623 90.95778926217619 A 37.35121951219512 37.35121951219512 0 0 0 63 25.648780487804878 L 63 5.536585365853654 z" fill="rgba(6,180,138,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-pie-area apexcharts-donut-slice-0" index="0" j="0" data:angle="138.46153846153845" data:startAngle="0" data:strokeWidth="0" data:value="50" data:pathOrig="M 63 5.536585365853654 A 57.463414634146346 57.463414634146346 0 0 1 101.10529226378814 106.01198348027108 L 87.7684399714623 90.95778926217619 A 37.35121951219512 37.35121951219512 0 0 0 63 25.648780487804878 L 63 5.536585365853654 z"></path></g><g id="SvgjsG1778" class="apexcharts-series apexcharts-pie-series" seriesName="series-2" rel="2" data:realIndex="1"><path id="SvgjsPath1779" d="M 101.10529226378814 106.01198348027108 A 57.463414634146346 57.463414634146346 0 0 1 15.708536876940144 95.64294008045376 L 32.2605489700111 84.21791105229494 A 37.35121951219512 37.35121951219512 0 0 0 87.7684399714623 90.95778926217619 L 101.10529226378814 106.01198348027108 z" fill="rgba(101,96,240,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-pie-area apexcharts-donut-slice-1" index="0" j="1" data:angle="96.9230769230769" data:startAngle="138.46153846153845" data:strokeWidth="0" data:value="35" data:pathOrig="M 101.10529226378814 106.01198348027108 A 57.463414634146346 57.463414634146346 0 0 1 15.708536876940144 95.64294008045376 L 32.2605489700111 84.21791105229494 A 37.35121951219512 37.35121951219512 0 0 0 87.7684399714623 90.95778926217619 L 101.10529226378814 106.01198348027108 z"></path></g><g id="SvgjsG1780" class="apexcharts-series apexcharts-pie-series" seriesName="series-3" rel="3" data:realIndex="2"><path id="SvgjsPath1781" d="M 15.708536876940144 95.64294008045376 A 57.463414634146346 57.463414634146346 0 0 1 62.989970742202864 5.536586241071504 L 62.99348098243186 25.64878105669648 A 37.35121951219512 37.35121951219512 0 0 0 32.2605489700111 84.21791105229494 L 15.708536876940144 95.64294008045376 z" fill="rgba(111,211,247,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-pie-area apexcharts-donut-slice-2" index="0" j="2" data:angle="124.61538461538464" data:startAngle="235.38461538461536" data:strokeWidth="0" data:value="45" data:pathOrig="M 15.708536876940144 95.64294008045376 A 57.463414634146346 57.463414634146346 0 0 1 62.989970742202864 5.536586241071504 L 62.99348098243186 25.64878105669648 A 37.35121951219512 37.35121951219512 0 0 0 32.2605489700111 84.21791105229494 L 15.708536876940144 95.64294008045376 z"></path></g></g></g></g><line id="SvgjsLine1782" x1="0" y1="0" x2="126" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1783" x1="0" y1="0" x2="126" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line></g></svg></div></div></div></div></div></div><div class="col-lg-6 col-xxxl-6 col-md-6"><div class="card mb-25 border-0 rounded-0 bg-white daily-sales-box"><div class="card-body p-15 p-sm-20 p-md-25 p-lg-30 letter-spacing"><span class="d-block mb-6 fs-13 text-uppercase fw-medium text-dark-emphasis"> AVERAGE DAILY SALES </span><h4 class="fw-black mb-12 lh-1">$5,302</h4><span class="fw-bold text-success text-badge d-inline-block"> 3.9% <i class="flaticon-up-arrow fs-11 lh-1 position-relative top-1"></i></span><div class="chart"><div class="vue-apexcharts" id="averageDailySalesChart" style="min-height: 165px;"><div id="apexchartsughjyiwj" class="apexcharts-canvas apexchartsughjyiwj apexcharts-theme-light" style="width: 220px; height: 150px;"><svg id="SvgjsSvg1419" width="220" height="150" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><foreignObject x="0" y="0" width="220" height="150"><div class="apexcharts-legend" xmlns="http://www.w3.org/1999/xhtml" style="max-height: 75px;"></div></foreignObject><g id="SvgjsG1478" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG1421" class="apexcharts-inner apexcharts-graphical" transform="translate(12, 30)"><defs id="SvgjsDefs1420"><linearGradient id="SvgjsLinearGradient1423" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop1424" stop-opacity="0.4" stop-color="rgba(216,227,240,0.4)" offset="0"></stop><stop id="SvgjsStop1425" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop><stop id="SvgjsStop1426" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop></linearGradient><clipPath id="gridRectMaskughjyiwj"><rect id="SvgjsRect1428" width="202" height="105" x="-2" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMaskughjyiwj"></clipPath><clipPath id="nonForecastMaskughjyiwj"></clipPath><clipPath id="gridRectMarkerMaskughjyiwj"><rect id="SvgjsRect1429" width="202" height="109" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><rect id="SvgjsRect1427" width="9.9" height="105" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke-dasharray="3" fill="url(#SvgjsLinearGradient1423)" class="apexcharts-xcrosshairs" y2="105" filter="none" fill-opacity="0.9"></rect><g id="SvgjsG1449" class="apexcharts-grid"><g id="SvgjsG1450" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine1453" x1="0" y1="0" x2="198" y2="0" stroke="#f0f0f0" stroke-dasharray="5" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1454" x1="0" y1="10.5" x2="198" y2="10.5" stroke="#f0f0f0" stroke-dasharray="5" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1455" x1="0" y1="21" x2="198" y2="21" stroke="#f0f0f0" stroke-dasharray="5" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1456" x1="0" y1="31.5" x2="198" y2="31.5" stroke="#f0f0f0" stroke-dasharray="5" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1457" x1="0" y1="42" x2="198" y2="42" stroke="#f0f0f0" stroke-dasharray="5" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1458" x1="0" y1="52.5" x2="198" y2="52.5" stroke="#f0f0f0" stroke-dasharray="5" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1459" x1="0" y1="63" x2="198" y2="63" stroke="#f0f0f0" stroke-dasharray="5" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1460" x1="0" y1="73.5" x2="198" y2="73.5" stroke="#f0f0f0" stroke-dasharray="5" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1461" x1="0" y1="84" x2="198" y2="84" stroke="#f0f0f0" stroke-dasharray="5" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1462" x1="0" y1="94.5" x2="198" y2="94.5" stroke="#f0f0f0" stroke-dasharray="5" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1463" x1="0" y1="105" x2="198" y2="105" stroke="#f0f0f0" stroke-dasharray="5" stroke-linecap="butt" class="apexcharts-gridline"></line></g><g id="SvgjsG1451" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine1465" x1="0" y1="105" x2="198" y2="105" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine1464" x1="0" y1="1" x2="0" y2="105" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line></g><g id="SvgjsG1430" class="apexcharts-bar-series apexcharts-plot-series"><g id="SvgjsG1431" class="apexcharts-series" rel="1" seriesName="Sales" data:realIndex="0"><path id="SvgjsPath1436" d="M 9.192857142857143 105.001 L 9.192857142857143 4.001 C 9.192857142857143 2.0010000000000003 11.192857142857143 0.001 13.192857142857143 0.001 L 15.092857142857142 0.001 C 17.09285714285714 0.001 19.09285714285714 2.001 19.09285714285714 4.001 L 19.09285714285714 105.001 z " fill="rgba(111,211,247,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskughjyiwj)" pathTo="M 9.192857142857143 105.001 L 9.192857142857143 4.001 C 9.192857142857143 2.0010000000000003 11.192857142857143 0.001 13.192857142857143 0.001 L 15.092857142857142 0.001 C 17.09285714285714 0.001 19.09285714285714 2.001 19.09285714285714 4.001 L 19.09285714285714 105.001 z " pathFrom="M 9.192857142857143 105.001 L 9.192857142857143 105.001 L 19.09285714285714 105.001 L 19.09285714285714 105.001 L 19.09285714285714 105.001 L 19.09285714285714 105.001 L 19.09285714285714 105.001 L 9.192857142857143 105.001 z" cy="0" cx="37.47857142857143" j="0" val="100" barHeight="105" barWidth="9.9"></path><path id="SvgjsPath1438" d="M 37.47857142857143 105.001 L 37.47857142857143 77.501 C 37.47857142857143 75.501 39.47857142857143 73.501 41.47857142857143 73.501 L 43.378571428571426 73.501 C 45.378571428571426 73.501 47.378571428571426 75.501 47.378571428571426 77.501 L 47.378571428571426 105.001 z " fill="rgba(111,211,247,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskughjyiwj)" pathTo="M 37.47857142857143 105.001 L 37.47857142857143 77.501 C 37.47857142857143 75.501 39.47857142857143 73.501 41.47857142857143 73.501 L 43.378571428571426 73.501 C 45.378571428571426 73.501 47.378571428571426 75.501 47.378571428571426 77.501 L 47.378571428571426 105.001 z " pathFrom="M 37.47857142857143 105.001 L 37.47857142857143 105.001 L 47.378571428571426 105.001 L 47.378571428571426 105.001 L 47.378571428571426 105.001 L 47.378571428571426 105.001 L 47.378571428571426 105.001 L 37.47857142857143 105.001 z" cy="73.5" cx="65.7642857142857" j="1" val="30" barHeight="31.5" barWidth="9.9"></path><path id="SvgjsPath1440" d="M 65.7642857142857 105.001 L 65.7642857142857 40.751 C 65.7642857142857 38.751 67.7642857142857 36.751 69.7642857142857 36.751 L 71.66428571428571 36.751 C 73.66428571428571 36.751 75.66428571428571 38.751 75.66428571428571 40.751 L 75.66428571428571 105.001 z " fill="rgba(111,211,247,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskughjyiwj)" pathTo="M 65.7642857142857 105.001 L 65.7642857142857 40.751 C 65.7642857142857 38.751 67.7642857142857 36.751 69.7642857142857 36.751 L 71.66428571428571 36.751 C 73.66428571428571 36.751 75.66428571428571 38.751 75.66428571428571 40.751 L 75.66428571428571 105.001 z " pathFrom="M 65.7642857142857 105.001 L 65.7642857142857 105.001 L 75.66428571428571 105.001 L 75.66428571428571 105.001 L 75.66428571428571 105.001 L 75.66428571428571 105.001 L 75.66428571428571 105.001 L 65.7642857142857 105.001 z" cy="36.75" cx="94.04999999999998" j="2" val="65" barHeight="68.25" barWidth="9.9"></path><path id="SvgjsPath1442" d="M 94.04999999999998 105.001 L 94.04999999999998 14.501 C 94.04999999999998 12.501 96.04999999999998 10.501 98.04999999999998 10.501 L 99.94999999999999 10.501 C 101.94999999999999 10.501 103.94999999999999 12.501 103.94999999999999 14.501 L 103.94999999999999 105.001 z " fill="rgba(111,211,247,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskughjyiwj)" pathTo="M 94.04999999999998 105.001 L 94.04999999999998 14.501 C 94.04999999999998 12.501 96.04999999999998 10.501 98.04999999999998 10.501 L 99.94999999999999 10.501 C 101.94999999999999 10.501 103.94999999999999 12.501 103.94999999999999 14.501 L 103.94999999999999 105.001 z " pathFrom="M 94.04999999999998 105.001 L 94.04999999999998 105.001 L 103.94999999999999 105.001 L 103.94999999999999 105.001 L 103.94999999999999 105.001 L 103.94999999999999 105.001 L 103.94999999999999 105.001 L 94.04999999999998 105.001 z" cy="10.5" cx="122.33571428571426" j="3" val="90" barHeight="94.5" barWidth="9.9"></path><path id="SvgjsPath1444" d="M 122.33571428571426 105.001 L 122.33571428571426 67.001 C 122.33571428571426 65.001 124.33571428571426 63.001 126.33571428571426 63.001 L 128.23571428571427 63.001 C 130.23571428571427 63.001 132.23571428571427 65.001 132.23571428571427 67.001 L 132.23571428571427 105.001 z " fill="rgba(111,211,247,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskughjyiwj)" pathTo="M 122.33571428571426 105.001 L 122.33571428571426 67.001 C 122.33571428571426 65.001 124.33571428571426 63.001 126.33571428571426 63.001 L 128.23571428571427 63.001 C 130.23571428571427 63.001 132.23571428571427 65.001 132.23571428571427 67.001 L 132.23571428571427 105.001 z " pathFrom="M 122.33571428571426 105.001 L 122.33571428571426 105.001 L 132.23571428571427 105.001 L 132.23571428571427 105.001 L 132.23571428571427 105.001 L 132.23571428571427 105.001 L 132.23571428571427 105.001 L 122.33571428571426 105.001 z" cy="63" cx="150.62142857142854" j="4" val="40" barHeight="42" barWidth="9.9"></path><path id="SvgjsPath1446" d="M 150.62142857142854 105.001 L 150.62142857142854 4.001 C 150.62142857142854 2.0010000000000003 152.62142857142854 0.001 154.62142857142854 0.001 L 156.52142857142854 0.001 C 158.52142857142854 0.001 160.52142857142854 2.001 160.52142857142854 4.001 L 160.52142857142854 105.001 z " fill="rgba(111,211,247,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskughjyiwj)" pathTo="M 150.62142857142854 105.001 L 150.62142857142854 4.001 C 150.62142857142854 2.0010000000000003 152.62142857142854 0.001 154.62142857142854 0.001 L 156.52142857142854 0.001 C 158.52142857142854 0.001 160.52142857142854 2.001 160.52142857142854 4.001 L 160.52142857142854 105.001 z " pathFrom="M 150.62142857142854 105.001 L 150.62142857142854 105.001 L 160.52142857142854 105.001 L 160.52142857142854 105.001 L 160.52142857142854 105.001 L 160.52142857142854 105.001 L 160.52142857142854 105.001 L 150.62142857142854 105.001 z" cy="0" cx="178.90714285714282" j="5" val="100" barHeight="105" barWidth="9.9"></path><path id="SvgjsPath1448" d="M 178.90714285714282 105.001 L 178.90714285714282 72.251 C 178.90714285714282 70.251 180.90714285714282 68.251 182.90714285714282 68.251 L 184.80714285714282 68.251 C 186.80714285714282 68.251 188.80714285714282 70.251 188.80714285714282 72.251 L 188.80714285714282 105.001 z " fill="rgba(111,211,247,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskughjyiwj)" pathTo="M 178.90714285714282 105.001 L 178.90714285714282 72.251 C 178.90714285714282 70.251 180.90714285714282 68.251 182.90714285714282 68.251 L 184.80714285714282 68.251 C 186.80714285714282 68.251 188.80714285714282 70.251 188.80714285714282 72.251 L 188.80714285714282 105.001 z " pathFrom="M 178.90714285714282 105.001 L 178.90714285714282 105.001 L 188.80714285714282 105.001 L 188.80714285714282 105.001 L 188.80714285714282 105.001 L 188.80714285714282 105.001 L 188.80714285714282 105.001 L 178.90714285714282 105.001 z" cy="68.25" cx="207.1928571428571" j="6" val="35" barHeight="36.75" barWidth="9.9"></path><g id="SvgjsG1433" class="apexcharts-bar-goals-markers" style="pointer-events: none"><g id="SvgjsG1435" className="apexcharts-bar-goals-groups" class="apexcharts-hidden-element-shown" clip-path="url(#gridRectMarkerMaskughjyiwj)"></g><g id="SvgjsG1437" className="apexcharts-bar-goals-groups" class="apexcharts-hidden-element-shown" clip-path="url(#gridRectMarkerMaskughjyiwj)"></g><g id="SvgjsG1439" className="apexcharts-bar-goals-groups" class="apexcharts-hidden-element-shown" clip-path="url(#gridRectMarkerMaskughjyiwj)"></g><g id="SvgjsG1441" className="apexcharts-bar-goals-groups" class="apexcharts-hidden-element-shown" clip-path="url(#gridRectMarkerMaskughjyiwj)"></g><g id="SvgjsG1443" className="apexcharts-bar-goals-groups" class="apexcharts-hidden-element-shown" clip-path="url(#gridRectMarkerMaskughjyiwj)"></g><g id="SvgjsG1445" className="apexcharts-bar-goals-groups" class="apexcharts-hidden-element-shown" clip-path="url(#gridRectMarkerMaskughjyiwj)"></g><g id="SvgjsG1447" className="apexcharts-bar-goals-groups" class="apexcharts-hidden-element-shown" clip-path="url(#gridRectMarkerMaskughjyiwj)"></g></g><g id="SvgjsG1434" class="apexcharts-bar-shadows apexcharts-hidden-element-shown" style="pointer-events: none"></g></g><g id="SvgjsG1432" class="apexcharts-datalabels apexcharts-hidden-element-shown" data:realIndex="0"></g></g><g id="SvgjsG1452" class="apexcharts-grid-borders" style="display: none;"></g><line id="SvgjsLine1466" x1="0" y1="0" x2="198" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1467" x1="0" y1="0" x2="198" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG1468" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG1469" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g><line id="SvgjsLine1477" x1="0" y1="106" x2="198" y2="106" stroke="#e0e0e0" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt"></line></g><g id="SvgjsG1479" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG1480" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG1481" class="apexcharts-point-annotations"></g></g></svg><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-title" style="font-family: &quot;Red Hat Display&quot;, sans-serif; font-size: 14px;"></div><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(111, 211, 247);"></span><div class="apexcharts-tooltip-text" style="font-family: &quot;Red Hat Display&quot;, sans-serif; font-size: 14px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div></div></div></div></div><div class="col-xl-12 col-lg-6 col-xxxl-6 col-md-12"><div class="card mb-25 border-0 rounded-0 bg-white monthly-revenue-box"><div class="card-body p-15 p-sm-20 p-md-25 p-lg-30 letter-spacing"><span class="d-block mb-6 fs-13 text-uppercase fw-medium text-dark-emphasis"> REVENUE THIS MONTH </span><h4 class="fw-black mb-12 lh-1">$16,520</h4><span class="fw-bold text-danger text-badge d-inline-block"> 1.5% <i class="flaticon-down-arrow fs-11 lh-1 position-relative top-1"></i></span><div class="mt-15 mt-md-25 mb-8 mb-md-12 d-flex justify-content-between align-items-center"><span class="fw-medium text-secondary"><span class="fw-bold text-black">$9,500</span> more to reach goal </span><span class="text-primary fw-semibold">68%</span></div><div class="progress" role="progressbar" aria-valuenow="68" aria-valuemin="0" aria-valuemax="100"><div class="progress-bar" style="width: 68%;"></div></div></div></div></div><div class="col-xl-12 col-lg-6 col-xxxl-6 col-md-12"><div class="card mb-25 border-0 rounded-0 bg-white monthly-new-customers-box"><div class="card-body p-15 p-sm-20 p-md-25 p-lg-30 letter-spacing"><div class="title"><span class="d-block mb-6 fs-13 text-uppercase fw-medium text-dark-emphasis"> NEW CUSTOMERS THIS MONTH </span><h4 class="fw-black mb-12 lh-1">4.5 K</h4><span class="fw-bold text-success text-badge d-inline-block"> 4.3% <i class="flaticon-up-arrow fs-11 lh-1 position-relative top-1"></i></span></div><div class="users-list d-flex align-items-center"><div class="rounded-circle text-center"><img src="/adlash/img/user1.82037da5.jpg" class="rounded-circle" alt="user"></div><div class="rounded-circle text-center"><img src="/adlash/img/user2.32106929.jpg" class="rounded-circle" alt="user"></div><div class="rounded-circle bg-primary-emphasis text-center d-flex align-items-center justify-content-center text-white fs-16 fw-bold"> P </div><div class="rounded-circle text-center"><img src="/adlash/img/user4.89c11888.jpg" class="rounded-circle" alt="user"></div><div class="rounded-circle bg-primary text-center d-flex align-items-center justify-content-center text-white fs-16 fw-bold"> S </div><div class="rounded-circle text-center"><img src="/adlash/img/user3.cd403a78.jpg" class="rounded-circle" alt="user"></div><div class="rounded-circle bg-secondary text-center d-flex align-items-center justify-content-center text-white fs-14 fw-bold"> +24 </div><span class="text-black fw-bold ms-25 ms-md-30">Joined Today</span></div></div></div></div></div></div>

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
            <h6>Kevin Anderson</h6>
            <span>Web Designer</span>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
              <i class="bi bi-person"></i>
              <span>My Profile</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
              <i class="bi bi-gear"></i>
              <span>Account Settings</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
              <i class="bi bi-question-circle"></i>
              <span>Need Help?</span>
            </a>
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