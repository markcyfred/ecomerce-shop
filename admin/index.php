<?php
session_start();
include('../middleware/adminMiddleware.php');

include('includes/header.php');

?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="col-xxl-7 col-xxxl-6">
      <div style="background-color: #6fd3f7!important" class="card mb-25 border-0 rounded-0 welcome-box">
        <div class="card-body pe-15 pe-sm-20 pe-md-0 pb-0 pt-15 pt-sm-20">
          <div class="row align-items-center">
            <div class="col-lg-6 col-md-6">
              <div class="title position-relative">
                <?php
                $userName = isset($fullName) ? $fullName : 'User';

                date_default_timezone_set('Africa/Nairobi');

                $currentHour = date('H');

                if ($currentHour >= 5 && $currentHour < 12) {
                  $greeting = 'Good Morning';
                } elseif ($currentHour >= 12 && $currentHour < 17) {
                  $greeting = 'Good Afternoon';
                } else {
                  $greeting = 'Good Evening';
                }

                echo "<h3 class='fw-semibold mb-8'>$greeting, <span class='fw-bold'>$userName</span></h3>";
                ?>

                <span class="d-block text-black-emphasis fs-md-15 fs-lg-16"> Here’s what's happening with your store today </span>
                <!-- Additional Text -->
                <!-- Additional Information -->
                <div class="mt-4">
                  <div class="d-flex justify-content-between mb-3">
                    <div>
                      <p class="fw-bold mb-1">TODAY’S VISIT</p>
                      <p class="fs-4 text-light">15,209</p>
                    </div>
                    <div>
                      <p class="fw-bold mb-1">TODAY’S TOTAL SALES</p>
                      <p class="fs-4 text-light">Ksh 29,115.50</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 text-center mt-15 mt-md-0">
              <img src="../Admin/assets/img/welcome.png" alt="welcome-image">
            </div>
          </div>
        </div>
      </div>
    </div><!-- End greetings banner -->


    <div class="row">

      <!-- Left side columns -->
      <div class="col-lg-8">
        <div class="row">

          <!-- Sales Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card">
              <div class="card-body">
                <h5 class="card-title">Sales <span>| Total Sold items</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-cart"></i>
                  </div>
                  <div class="ps-3">
                    <h6>145</h6>
                    <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span>

                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Sales Card -->

          <!-- Revenue Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card revenue-card">

              <div class="card-body">
                <h5 class="card-title">Sales <span>| Total Sales </span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    Ksh<i class="Ksh"></i>
                  </div>
                  <div class="ps-3">
                    <h6>Ksh 43,264</h6>
                    <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span>

                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Revenue Card -->
          <!-- New Orders Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card new-orders-card">

              <div class="card-body">
                <h5 class="card-title">New Orders <span>| Today</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-box"></i>
                  </div>
                  <div class="ps-3">
                    <h6>28</h6>
                    <span class="text-primary small pt-1 fw-bold">5%</span> <span class="text-muted small pt-2 ps-1">decrease</span>
                  </div>
                </div>
              </div>

            </div>
          </div><!-- End New Orders Card -->
          <!-- Total Users Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card total-users-card">

              <div class="card-body">
                <h5 class="card-title">Total Users</h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-person"></i>
                  </div>
                  <div class="ps-3">
                    <h6>35</h6>
                    <span class="text-muted small pt-2">Registered users</span>
                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Total Users Card -->


        </div>
      </div><!-- End Left side columns -->

      <!-- Right side columns -->
      <div class="col-lg-4">
        <!-- Sales Card -->
        <div class="card info-card customers-card">
          <!-- Customers Card -->

          <div class="card-body">
            <h5 class="card-title">Suppliers <span>| Total Suppliers</span></h5>

            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-people"></i>
              </div>
              <div class="ps-3">
                <h6>14</h6>
                <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span>

              </div>
            </div>


          </div><!-- End Customers Card -->
        </div><!-- End Sales Card -->

        <!-- Total Orders Card -->
        <div class="card info-card total-orders-card">


          <div class="card-body">
            <h5 class="card-title">Total Orders</h5>

            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-bag"></i>
              </div>
              <div class="ps-3">
                <!-- Replace the following values with your actual data -->
                <h6>500</h6>
                <span class="text-success small pt-1 fw-bold">10%</span>
                <span class="text-muted small pt-2 ps-1">increase</span>
              </div>
            </div>
          </div>
        </div>
        <!-- End Total Orders Card -->

      </div><!-- End Right side columns -->

      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Sales Chart</h5>

            <!-- Column Chart -->
            <div id="columnChart"></div>

            <script>
              document.addEventListener("DOMContentLoaded", () => {
                new ApexCharts(document.querySelector("#columnChart"), {
                  series: [{
                    name: 'Net Profit',
                    data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
                  }, {
                    name: 'Revenue',
                    data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
                  }, {
                    name: 'Free Cash Flow',
                    data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
                  }],
                  chart: {
                    type: 'bar',
                    height: 350
                  },
                  plotOptions: {
                    bar: {
                      horizontal: false,
                      columnWidth: '55%',
                      endingShape: 'rounded'
                    },
                  },
                  dataLabels: {
                    enabled: false
                  },
                  stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                  },
                  xaxis: {
                    categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
                  },
                  yaxis: {
                    title: {
                      text: 'Kes (thousands)'
                    }
                  },
                  fill: {
                    opacity: 1
                  },
                  tooltip: {
                    y: {
                      formatter: function(val) {
                        return "Kes " + val + " thousands";
                      }
                    }
                  }
                }).render();
              });
            </script>
            <!-- End Column Chart -->

          </div>
        </div>
      </div>

      <!--pie chart of Column Chart of net profit, revenue and free cash flow-->

      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Sales Chart</h5>
            <!-- Pie Chart -->
            <div style="margin-top: 100px;" id="pieChart"></div>

            <script>
              document.addEventListener("DOMContentLoaded", () => {
                new ApexCharts(document.querySelector("#pieChart"), {
                  series: [44, 55, 13, 43, 22],
                  chart: {
                    height: 350,
                    type: 'pie',
                    toolbar: {
                      show: true
                    }
                  },
                  labels: ['Net Profit', 'Revenue', 'Free Cash Flow', 'Income', 'Expense'],
                  responsive: [{
                    breakpoint: 480,
                    options: {
                      chart: {
                        width: 200
                      },
                      legend: {
                        position: 'bottom'
                      }
                    }
                  }]
                }).render();
              });
            </script>
            <!-- End Pie Chart -->

          </div>
        </div>
      </div>


    </div>
  </section>

</main><!-- End #main -->



<?php
include('includes/footer.php')
?>