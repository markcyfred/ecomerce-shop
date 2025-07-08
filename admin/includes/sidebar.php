<?php
$current_page = basename($_SERVER['PHP_SELF']);
$products_pages = [
  'add-category.php', 'categories.php', 'products-add.php', 'products.php', 'add-brand.php', 'brands.php', 'banner.php', 'add-banner.php'
];
$tags_pages = [
  'add-featured-tag.php', 'featured-tags-manage.php', 'assign-featured-tag.php', 'sync-tag.php', 'tags-manage.php'
];
$sales_pages = [
  'orders-view.php', 'orders-process.php', 'sales.php', 'invoice.php', 'sales-return.php', 'pos.php'
];
$transport_pages = [
  'picking-list.php', 'packing-list.php', 'vehicle-allocation.php',
  'route-to-vehicle.php', 'create-route.php', 'manage-routes.php', 'vehicle-management.php', 'shipment-confirmation.php'
];
$coupons_pages = [
  'coupons-add.php', 'coupons-manage.php'
];
$promo_pages = [
  'promocode-add.php', 'promocodes.php'
];
$users_pages = [
  'users-add.php', 'users-manage.php', 'edit-user.php'
];
$is_products = in_array($current_page, $products_pages);
$is_tags = in_array($current_page, $tags_pages);
$is_sales = in_array($current_page, $sales_pages);
$is_transport = in_array($current_page, $transport_pages);
$is_coupons = in_array($current_page, $coupons_pages);
$is_promo = in_array($current_page, $promo_pages);
$is_users = in_array($current_page, $users_pages);
?>
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
        <a class="nav-link collapsed<?= $is_products ? ' active' : '' ?>" data-bs-target="#products-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-gem"></i><span>Products</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="products-nav" class="nav-content collapse<?= $is_products ? ' show' : '' ?>" data-bs-parent="#sidebar-nav">
          <li>
            <a href="add-category.php"<?= $current_page == 'add-category.php' ? ' class="active"' : '' ?>>
              <i class="bi bi-circle"></i><span>Add Category</span>
            </a>
          </li>
          <li>
            <a href="categories.php"<?= $current_page == 'categories.php' ? ' class="active"' : '' ?>>
              <i class="bi bi-circle"></i><span>Categories</span>
            </a>
          </li>
          <!--add category-->

          <li>
            <a href="products-add.php"<?= $current_page == 'products-add.php' ? ' class="active"' : '' ?>>
              <i class="bi bi-circle"></i><span>Add Products</span>
            </a>
          </li>

          <li>
            <a href="products.php"<?= $current_page == 'products.php' ? ' class="active"' : '' ?>>
              <i class="bi bi-circle"></i><span>Products</span>
            </a>
          </li>
          <!--ADD BRAND-->
          <li>
            <a href="add-brand.php"<?= $current_page == 'add-brand.php' ? ' class="active"' : '' ?>>
              <i class="bi bi-circle"></i><span>Add Brand</span>
            </a>
          </li>

          <!--BRANDS-->
          <li>
            <a href="brands.php"<?= $current_page == 'brands.php' ? ' class="active"' : '' ?>>
              <i class="bi bi-circle"></i><span>Brands</span>
            </a>
          </li>

          <!--banner-->
          <li>
            <a href="banner.php"<?= $current_page == 'banner.php' ? ' class="active"' : '' ?>>
              <i class="bi bi-circle"></i><span>Banner</span>
            </a>
          </li>
          <!--add banner-->
          <li>
            <a href="add-banner.php"<?= $current_page == 'add-banner.php' ? ' class="active"' : '' ?>>
              <i class="bi bi-circle"></i><span>Add Banner</span>
            </a>
          </li>

        </ul>
      </li><!-- End Products Nav -->
      <!--products tags with dropdown-->
      <li class="nav-item">
        <a class="nav-link collapsed<?= $is_tags ? ' active' : '' ?>" data-bs-target="#tags-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-tags"></i><span>Tags</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tags-nav" class="nav-content collapse<?= $is_tags ? ' show' : '' ?>" data-bs-parent="#sidebar-nav">
          <li>
            <a href="add-featured-tag.php"<?= $current_page == 'add-featured-tag.php' ? ' class="active"' : '' ?>>
              <i class="bi bi-circle"></i><span>Add Tag</span>
            </a>
          </li>
          <li>
            <a href="featured-tags-manage.php"<?= $current_page == 'featured-tags-manage.php' ? ' class="active"' : '' ?>>
              <i class="bi bi-circle"></i><span>Tags</span>
            </a>
          </li>
          <li>
            <a href="assign-featured-tag.php"<?= $current_page == 'assign-featured-tag.php' ? ' class="active"' : '' ?>>
              <i class="bi bi-circle"></i><span>Assign Tag</span>
            </a>
          </li>
          <li>
            <a href="sync-tag.php"<?= $current_page == 'sync-tag.php' ? ' class="active"' : '' ?>>
              <i class="bi bi-circle"></i><span>Sync Tag</span>
            </a>
          </li>
          <!--manage tags-->
          <li>
            <a href="tags-manage.php"<?= $current_page == 'tags-manage.php' ? ' class="active"' : '' ?>>
              <i class="bi bi-circle"></i><span>Sequence Tags</span>
            </a>
          </li>
        </ul>
      </li><!-- End Tags Nav -->
      <!--products tags with dropdown-->


      <li class="nav-heading">Shop Sales</li>

      <li class="nav-item">
        <a class="nav-link collapsed<?= $is_sales ? ' active' : '' ?>" data-bs-target="#orders-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-cart"></i><span>Sales</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="orders-nav" class="nav-content collapse<?= $is_sales ? ' show' : '' ?>" data-bs-parent="#sidebar-nav">
          <li>
            <a href="orders-view.php"<?= $current_page == 'orders-view.php' ? ' class="active"' : '' ?>>
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

      <li class="nav-heading">Transport & Logistics</li>
      <li class="nav-item">
        <a class="nav-link collapsed<?= $is_transport ? ' active' : '' ?>" data-bs-target="#transport-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-truck"></i><span>Transport</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="transport-nav" class="nav-content collapse<?= $is_transport ? ' show' : '' ?>" data-bs-parent="#sidebar-nav">
          <li>
            <a href="picking-list.php"<?= $current_page == 'picking-list.php' ? ' class="active"' : '' ?>>
              <i class="bi bi-circle"></i><span>Picking List</span>
            </a>
          </li>
          <li>
            <a href="packing-list.php"<?= $current_page == 'packing-list.php' ? ' class="active"' : '' ?>>
              <i class="bi bi-circle"></i><span>Packing List</span>
            </a>
          </li>
          <li>
            <a href="vehicle-allocation.php"<?= $current_page == 'vehicle-allocation.php' ? ' class="active"' : '' ?>>
              <i class="bi bi-circle"></i><span>Vehicle Allocation</span>
            </a>
          </li>
          <li>
            <a href="route-to-vehicle.php"<?= $current_page == 'route-to-vehicle.php' ? ' class="active"' : '' ?>>
              <i class="bi bi-circle"></i><span>Route to Vehicle</span>
            </a>
          </li>
          <li>
            <a href="create-route.php"<?= $current_page == 'create-route.php' ? ' class="active"' : '' ?>>
              <i class="bi bi-circle"></i><span>Create Route</span>
            </a>
          </li>
          <li>
            <a href="manage-routes.php"<?= $current_page == 'manage-routes.php' ? ' class="active"' : '' ?>>
              <i class="bi bi-circle"></i><span>Manage Routes</span>
            </a>
          </li>
          <li>
            <a href="vehicle-management.php"<?= $current_page == 'vehicle-management.php' ? ' class="active"' : '' ?>>
              <i class="bi bi-circle"></i><span>Vehicle Management</span>
            </a>
          </li>
          <li>
            <a href="shipment-confirmation.php"<?= $current_page == 'shipment-confirmation.php' ? ' class="active"' : '' ?>>
              <i class="bi bi-circle"></i><span>Shipment Confirmation</span>
            </a>
          </li>
        </ul>
      </li>

      <!-- Marketing Coupons Section with Dropdown -->
      <li class="nav-heading">Shop Marketing</li>
      <li class="nav-item">
        <a class="nav-link collapsed<?= $is_coupons ? ' active' : '' ?>" data-bs-target="#coupons-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-tag"></i><span>Coupons</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="coupons-nav" class="nav-content collapse<?= $is_coupons ? ' show' : '' ?>" data-bs-parent="#sidebar-nav">
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

      <!-- Promo Codes Section -->
      <li class="nav-item">
        <a class="nav-link collapsed<?= $is_promo ? ' active' : '' ?>" data-bs-target="#promo-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-percent"></i><span>Promo Codes</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="promo-nav" class="nav-content collapse<?= $is_promo ? ' show' : '' ?>" data-bs-parent="#sidebar-nav">
          <li>
            <a href="promocode-add.php">
              <i class="bi bi-circle"></i><span>Add Promo Code</span>
            </a>
          </li>
          <li>
            <a href="promocodes.php">
              <i class="bi bi-circle"></i><span>Manage Promo Codes</span>
            </a>
          </li>
        </ul>
      </li><!-- End Promo Codes Nav -->

      <!--User Management-->
      <li class="nav-heading">User Management</li>
      <li class="nav-item">
        <a class="nav-link collapsed<?= $is_users ? ' active' : '' ?>" data-bs-target="#users-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-people"></i><span>Users</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="users-nav" class="nav-content collapse<?= $is_users ? ' show' : '' ?>" data-bs-parent="#sidebar-nav">
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
     <!--blogs-->
      <li class="nav-item"></li>
        <a class="nav-link collapsed" data-bs-target="#blogs-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Blogs</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="blogs-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="blogs-add.php">
              <i class="bi bi-circle"></i><span>Add Blog</span>
            </a>
          </li>
          <li>
            <a href="blogs-manage.php">
              <i class="bi bi-circle"></i><span>Manage Blogs</span>
            </a>
          </li>
          <li>
            <a href="blog-category.php">
              <i class="bi bi-circle"></i><span>Blog Categories</span>
            </a>
          </li>
          <!--add blog category-->
          <li>
            <a href="add-blog-category.php">
              <i class="bi bi-circle"></i><span>Add Blog Category</span>
            </a>
          </li>
          <li>
            <a href="blogs-comments.php">
              <i class="bi bi-circle"></i><span>Blog Comments</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-heading">Website Management</li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#testimonials-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-chat-square-quote"></i><span>Testimonials</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="testimonials-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li>
              <a href="add-testimonial.php">
                <i class="bi bi-circle"></i><span>Add Testimonial</span>
              </a>
            </li>
            <li>
              <a href="manage-testimonials.php">
                <i class="bi bi-circle"></i><span>Manage Testimonials</span>
              </a>
            </li>
          </ul>
        </li><!-- End Testimonials Nav -->



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
        <!-- End System Nav -->


        </li>
        <!-- End Clear Cache Sub-Menu Item -->

      </ul>

  </aside>
  <!-- End Sidebar-->
<style>
.sidebar-nav .nav-content a.active {
  background: #e9ecef !important;
  color: #0d6efd !important;
  font-weight: bold;
  border-radius: 4px;
}
</style>