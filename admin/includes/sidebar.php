  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
      <!-- Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link" href="index.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-heading">Shop Products</li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#products-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-gem"></i><span>Products</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="products-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="products-add.php">
              <i class="bi bi-circle"></i><span>Add Product</span>
            </a>
          </li>
          <li>
            <a href="products-manage.php">
              <i class="bi bi-circle"></i><span>Manage Products</span>
            </a>
          </li>

          <li>
            <a href="products-categories.php">
              <i class="bi bi-circle"></i><span>Categories</span>
            </a>
          </li>
        </ul>
      </li><!-- End Products Nav -->

      
      <li class="nav-heading">Shop Sales</li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#orders-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-cart"></i><span>Sales</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="orders-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="orders-view.php">
              <i class="bi bi-circle"></i><span>View Orders</span>
            </a>
          </li>
          <li>
            <a href="orders-process.php">
              <i class="bi bi-circle"></i><span>Process Orders</span>
            </a>
          </li>
          <!--sales-->
          <li>
            <a href="sales.php">
              <i class="bi bi-circle"></i><span>Sales</span>
            </a>  
          </li>
          <!--invoice-->
          <li>
            <a href="invoice.php">
              <i class="bi bi-circle"></i><span>Invoice</span>
            </a>
          </li>
          <!--sales return-->
          <li>
            <a href="sales-return.php">
              <i class="bi bi-circle"></i><span>Sales Return</span>
            </a>
          </li>
          <!--pos-->
          <li>
            <a href="pos.php">
              <i class="bi bi-circle"></i><span>POS</span>
            </a>
          </li>
        </ul>
      </li><!-- End Orders Nav -->

      <!-- Marketing Coupons Section with Dropdown -->
      <li class="nav-heading">Shop Marketing</li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#coupons-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-tag"></i><span>Coupons</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul class="nav-content collapse" id="coupons-nav" data-bs-parent="#sidebar-nav">
          <li>
            <a href="coupons-add.php">
              <i class="bi bi-circle"></i><span>Add Coupon</span>
            </a>
          </li>
          <li>
            <a href="coupons-manage.php">
              <i class="bi bi-circle"></i><span>Manage Coupons</span>
            </a>
          </li>
        </ul>
      </li><!-- End Coupons Nav -->

      <!-- Marketing Newsletter Section with Dropdown -->

      <li class="nav-heading">Shop Peoples</li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#customers-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-person"></i><span>Customers</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="customers-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="customers-list.php">
              <i class="bi bi-circle"></i><span>Customer List</span>
            </a>
          </li>
          <!--suppliers-->
          <li>
            <a href="suppliers.php">
              <i class="bi bi-circle"></i><span>Suppliers</span>
            </a>
          </li>
          <!--stores-->
          <li>
            <a href="stores.php">
              <i class="bi bi-circle"></i><span>Stores</span>
            </a>
          </li>
        </ul>
      </li><!-- End Customers Nav -->

      <li class="nav-heading">Shop Reports</li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#sales-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-graph-up"></i><span>Sales Analytics</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="sales-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="sales-reports.php">
              <i class="bi bi-circle"></i><span>Sales Reports</span>
            </a>
          </li>
          <!--purchase reports-->
          <li>
            <a href="purchase-reports.php">
              <i class="bi bi-circle"></i><span>Purchase Reports</span>
            </a>
          </li>
          <!--inventory reports-->
          <li>
            <a href="inventory-reports.php">
              <i class="bi bi-circle"></i><span>Inventory Reports</span>
            </a>
          </li>
        </ul>
      </li><!-- End Sales Analytics Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#inventory-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-archive"></i><span>Inventory</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="inventory-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="inventory-view.php">
              <i class="bi bi-circle"></i><span>View Inventory</span>
            </a>
          </li>
          <li>
            <a href="inventory-alerts.php">
              <i class="bi bi-circle"></i><span>Inventory Alerts</span>
            </a>
          </li>
        </ul>
      </li><!-- End Inventory Nav -->
      <!--User Management-->
      <li class="nav-heading">User Management</li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#users-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-people"></i><span>Users</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="users-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="users-add.php">
              <i class="bi bi-circle"></i><span>Add User</span>
            </a>
          </li>
          <li>
            <a href="users-manage.php">
              <i class="bi bi-circle"></i><span>Manage Users</span>
            </a>
          </li>
        </ul>
      <!-- System Dropdown with Nested Options -->
      <li class="nav-heading">System Shop Management</li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#system-dropdown" data-bs-toggle="collapse" href="#">
          <i class="bi bi-gear"></i>
          <span>System</span>
          <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="system-dropdown" class="nav-content collapse" data-bs-parent="#sidebar-nav">

          <!-- Languages Dropdown -->
          <li class="nav-item">
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#languages-dropdown">
              <i class="bi bi-circle"></i><span>Languages</span>
              <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="languages-dropdown" class="nav-content collapse">
              <!-- Languages Sub-Menu English -->
              <li class="nav-item">
                <a href="languages-sub-menu-english.php">
                  <i class="bi bi-circle"></i><span>English</span>
                </a>
              </li>
              <!-- Languages Sub-Menu Spanish -->
              <li class="nav-item">
                <a href="languages-sub-menu-spanish.php">
                  <i class="bi bi-circle"></i><span>Spanish</span>
                </a>
              </li>
              <!--swahili-->
              <li class="nav-item">
                <a href="languages-sub-menu-swahili.php">
                  <i class="bi bi-circle"></i><span>Swahili</span>
                </a>
              </li>
            </ul>
          </li>

          <!-- Backup Dropdown -->
          <li class="nav-item">
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#backup-dropdown">
              <i class="bi bi-circle"></i><span>Backup</span>
              <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="backup-dropdown" class="nav-content collapse">
              <!-- Create Backup Sub-Menu Item -->
              <li class="nav-item">
                <a href="create-backup-sub-menu-item.php">
                  <i class="bi bi-circle"></i><span>Create Backup</span>
                </a>
              </li>
              <!-- Restore Backup Sub-Menu Item -->
              <li class="nav-item">
                <a href="restore-backup-sub-menu-item.php">
                  <i class="bi bi-circle"></i><span>Restore Backup</span>
                </a>
              </li>
            </ul>
          </li>

          <!-- Update Dropdown -->
          <li class="nav-item">
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#update-dropdown">
              <i class="bi bi-circle"></i><span>Update</span>
              <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="update-dropdown" class="nav-content collapse">
              <!-- Get Update Sub-Menu Item -->
              <li class="nav-item">
                <a href="get-update-sub-menu-item.php">
                  <i class="bi bi-circle"></i><span>Get Update</span>
                </a>
              </li>
          </li>
        </ul>
      </li>

      <!-- Clear Cache Dropdown -->

      <!-- Clear Cache Sub-Menu Item -->
      <li class="nav-item">
        <a href="clear-cache.php">
          <i class="bi bi-circle"></i><span>Clear Cache</span>
        </a>
      </li>
      <!-- End Clear Cache Sub-Menu Item -->
    </ul>

  </aside>
  <!-- End Sidebar-->