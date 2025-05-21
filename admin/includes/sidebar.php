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
            <a href="add-category.php">
              <i class="bi bi-circle"></i><span>Add Category</span>
            </a>
          </li>
          <li>
            <a href="categories.php">
              <i class="bi bi-circle"></i><span>Categories</span>
            </a>
          </li>
          <!--add category-->

          <li>
            <a href="products-add.php">
              <i class="bi bi-circle"></i><span>Add Products</span>
            </a>
          </li>

          <li>
            <a href="products.php">
              <i class="bi bi-circle"></i><span>Products</span>
            </a>
          </li>
          <!--ADD BRAND-->
          <li>
            <a href="add-brand.php">
              <i class="bi bi-circle"></i><span>Add Brand</span>
            </a>
          </li>

          <!--BRANDS-->
          <li>
            <a href="brands.php">
              <i class="bi bi-circle"></i><span>Brands</span>
            </a>
          </li>
         
        </ul>
      </li><!-- End Products Nav -->
      <!--products tags with dropdown-->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tags-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-tags"></i><span>Tags</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tags-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="add-featured-tag.php">
              <i class="bi bi-circle"></i><span>Add Tag</span>
            </a>
          </li>
          <li>
            <a href="featured-tags-manage.php">
              <i class="bi bi-circle"></i><span>Tags</span>
            </a>
          </li>
          <li>
            <a href="assign-featured-tag.php">
              <i class="bi bi-circle"></i><span>Assign Tag</span>
            </a>
          </li>
          <li>
            <a href="sync-tag.php">
              <i class="bi bi-circle"></i><span>Sync Tag</span>
            </a>
          </li>
          <!--manage tags-->
          <li>
            <a href="tags-manage.php">
              <i class="bi bi-circle"></i><span>Sequence Tags</span>
            </a>
          </li>
        </ul>
      </li><!-- End Tags Nav -->
      <!--products tags with dropdown-->


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

      <li class="nav-heading">System Shop Management</li>
      <!--user management-->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#system-dropdown" data-bs-toggle="collapse" href="#">
          <i class="bi bi-gear"></i>
          <span>System</span>
          <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="system-dropdown" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <!-- management of Select Featured , add featured tags-->
          <li class="nav-item">
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#featured-tags-dropdown">
              <i class="bi bi-circle"></i><span>Featured Tags</span>
              <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="featured-tags-dropdown" class="nav-content collapse">

            </ul>
          </li>


        </ul>
      </li>

      </li>
      <!-- End Clear Cache Sub-Menu Item -->
    </ul>

  </aside>
  <!-- End Sidebar-->