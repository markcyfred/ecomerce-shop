<?php include "includes/header.php";
include 'admin/config/dbcon.php';

// Sorting options
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'default';
$order_by = match ($sort) {
     'price_low' => 'selling_price ASC',
     'price_high' => 'selling_price DESC',
     'name_asc' => 'product_name ASC',
     'name_desc' => 'product_name DESC',
     'newest' => 'created_at DESC',
     default => 'id DESC'
};

// Search functionality
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$search_condition = '';
if (!empty($search)) {
     $search_condition = "AND (product_name LIKE '%$search%' OR description LIKE '%$search%' OR brand_name LIKE '%$search%')";
}

// Filter by price range
$min_price = isset($_GET['min_price']) ? (float)$_GET['min_price'] : 0;
$max_price = isset($_GET['max_price']) ? (float)$_GET['max_price'] : PHP_FLOAT_MAX;

// Add price range filter condition
$price_filter = '';
if ($min_price > 0 || $max_price < PHP_FLOAT_MAX) {
     $price_filter = "AND selling_price BETWEEN $min_price AND $max_price";
}

// Get selected brands
$selected_brand = isset($_GET['brand']) ? mysqli_real_escape_string($conn, $_GET['brand']) : '';
$brand_filter = '';
if (!empty($selected_brand)) {
     $brand_filter = "AND brand_name = '$selected_brand'";
}

// Get the selected "Show" value or default to 15
$productsPerPage = isset($_GET['show']) ? (int)$_GET['show'] : 15;

// Count all active products in the database with search condition
$sql = "SELECT COUNT(*) AS total FROM products WHERE status = 1 $search_condition $brand_filter $price_filter";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$totalProducts = $row['total'];

// If "Show" is "All", set productsPerPage to totalProducts
if ($productsPerPage === $totalProducts) {
     $productsPerPage = $totalProducts;
}

// Pagination logic
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$totalPages = $productsPerPage > 0 ? ceil($totalProducts / $productsPerPage) : 1;
$currentPage = max(1, min($currentPage, $totalPages));
$offset = ($currentPage - 1) * $productsPerPage;

// Fetch products with LIMIT, OFFSET, search, and sorting
$sql = "SELECT p.*, 
        p.id,
        p.product_name,
        p.description,
        p.selling_price,
        p.original_price,
        p.quantity,
        p.brand_name as brand,
        p.image,
        p.status,
        (SELECT quantity FROM cart 
         WHERE cart.product_id = p.id 
         AND (cart.session_id = '" . session_id() . "' 
              OR cart.user_id = '" . ($_SESSION['auth_user']['id'] ?? '0') . "')
         AND (cart.cart_status IS NULL OR cart.cart_status != 'processed')
         LIMIT 1
        ) AS in_cart,
        (SELECT COUNT(*) FROM favorite 
         WHERE favorite.product_id = p.id 
         AND (favorite.session_id = '" . session_id() . "' 
              OR favorite.user_id = '" . ($_SESSION['auth_user']['id'] ?? '0') . "')
        ) AS in_favorite
        FROM products p
        WHERE p.status = 1 
        $search_condition 
        $brand_filter
        $price_filter
        ORDER BY $order_by 
        LIMIT $productsPerPage OFFSET $offset";
$result = mysqli_query($conn, $sql);

// Fetch all categories for sidebar
$categories_query = "SELECT * FROM categories WHERE status = 1 ORDER BY name ASC";
$categories_result = mysqli_query($conn, $categories_query);

// Fetch new products for sidebar
$new_products_query = "SELECT p.*, 
                             pi.image_path,
                             pi.alt_text
                      FROM products p
                      LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
                      WHERE p.status = 1 
                      AND p.featured = 'new'
                      ORDER BY p.created_at DESC 
                      LIMIT 3";
$new_products_result = mysqli_query($conn, $new_products_query);

// Fetch brands for filter
$brands_query = "SELECT * FROM brands WHERE status = 1 ORDER BY brand_name ASC";
$brands_result = mysqli_query($conn, $brands_query);

// Get price range for filter
$price_range_query = "SELECT 
                        MIN(selling_price) as min_price,
                        MAX(selling_price) as max_price
                      FROM products 
                      WHERE status = 1";
$price_range_result = mysqli_query($conn, $price_range_query);
$price_range = mysqli_fetch_assoc($price_range_result);

// Add JavaScript for price range slider
?>
<script>
     $(document).ready(function() {
          // Initialize price range slider
          $("#slider-range").slider({
               range: true,
               min: <?php echo $price_range['min_price']; ?>,
               max: <?php echo $price_range['max_price']; ?>,
               values: [<?php echo $min_price; ?>, <?php echo $max_price; ?>],
               slide: function(event, ui) {
                    $("#amount").val("Kes" + ui.values[0] + " - Kes" + ui.values[1]);
               },
               change: function(event, ui) {
                    // Update URL with new price range
                    let currentUrl = new URL(window.location.href);
                    currentUrl.searchParams.set('min_price', ui.values[0]);
                    currentUrl.searchParams.set('max_price', ui.values[1]);
                    currentUrl.searchParams.set('page', '1'); // Reset to first page
                    window.location.href = currentUrl.toString();
               }
          });

          // Set initial price range display
          $("#amount").val("Kes" + $("#slider-range").slider("values", 0) +
               " - Kes" + $("#slider-range").slider("values", 1));
     });
</script>

<div style="margin-top: 40px;" class="container">
     <div class="row">
          <!-- Left Sidebar -->
          <div id="left-column" class="col-lg-3">
               <div id="search_filters_wrapper" class="block">
                    <div id="search_filters">
                         
                              <!-- Price Range Section -->
                              <section class="facet clearfix">
                                   <p class="h6 facet-title">Price Range</p>
                                   <div class="price-filter">
                                        <div class="price-filter-inner">
                                             <div id="slider-range"></div>
                                             <div class="price_slider_amount">
                                                  <div class="label-input">
                                                       <span>Range:</span>
                                                       <input type="text" id="amount" name="price" placeholder="Add Your Price" />
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </section>
                         <h4 class="block_title">Filter By
                              <div class="filter-close hidden-lg-up">
                                   <i class="material-icons menu-close">×</i>
                              </div>
                         </h4>

                         <div class="block_content">
                              <!-- Categories Section -->
                              <section class="facet clearfix">
                                   <p class="h6 facet-title">Categories</p>
                                   <ul class="categories">
                                        <?php
                                        mysqli_data_seek($categories_result, 0);
                                        while ($cat = mysqli_fetch_assoc($categories_result)):
                                        ?>
                                             <li><a href="category.php?id=<?= $cat['id']; ?>"><?= $cat['name']; ?></a></li>
                                        <?php endwhile; ?>
                                   </ul>
                              </section>

                              <!-- Brands Section -->
                              <section class="facet clearfix">
                                   <p class="h6 facet-title">Brands</p>
                                   <ul id="facet_brands" class="collapse">
                                        <li>
                                             <div class="col-sm-12 col-xs-12 col-md-12 facet-dropdown dropdown">
                                                  <a class="select-title" rel="nofollow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                       <span>
                                                            <?= !empty($selected_brand) ? htmlspecialchars($selected_brand) : '(no filter)'; ?>
                                                       </span>
                                                       <i class="material-icons float-xs-right">▼</i>
                                                  </a>
                                                  <div class="dropdown-menu">
                                                       <a href="shop.php" class="select-list <?= empty($selected_brand) ? 'current' : ''; ?>">
                                                            All Brands
                                                       </a>
                                                       <?php
                                                       mysqli_data_seek($brands_result, 0);
                                                       while ($brand = mysqli_fetch_assoc($brands_result)):
                                                       ?>
                                                            <a href="?brand=<?= urlencode($brand['brand_name']); ?>"
                                                                 class="select-list <?= $selected_brand === $brand['brand_name'] ? 'current' : ''; ?>">
                                                                 <?= htmlspecialchars($brand['brand_name']); ?>
                                                            </a>
                                                       <?php endwhile; ?>
                                                  </div>
                                             </div>
                                        </li>
                                   </ul>
                              </section>

                             
                         </div>
                    </div>
               </div>

               <!-- New Products Widget -->
               <div id="newproduct_block" class="block products-block">
                    <h4 class="block_title hidden-md-down">
                        New Products
                    </h4>
                    <h4 class="block_title hidden-lg-up" data-target="#newproduct_block_toggle" data-toggle="collapse">
                        New products
                        <span class="pull-xs-right">
                            <span class="navbar-toggler collapse-icons">
                                <i class="fa-icon add"></i>
                                <i class="fa-icon remove"></i>
                            </span>
                        </span>
                    </h4>
                    <div id="newproduct_block_toggle" class="block_content  collapse">
                        <div class="products">
                            <?php 
                            mysqli_data_seek($new_products_result, 0);
                            while($new_product = mysqli_fetch_assoc($new_products_result)): 
                            ?>
                            <article class="product_item">
                                <div class="product-miniature js-product-miniature" data-id-product="<?= $new_product['id']; ?>">
                                    <div class="product_thumbnail">
                                        <a href="shop-product.php?id=<?= $new_product['id']; ?>" class="thumbnail product-image">
                                            <img class="lazyload" 
                                                 src="<?= !empty($new_product['image_path']) ? $new_product['image_path'] : 'uploads/shop/' . $new_product['image']; ?>" 
                                                 alt="<?= htmlspecialchars($new_product['alt_text'] ?? $new_product['product_name']); ?>"
                                                 loading="lazy">
                                        </a>
                                    </div>
                                    <div class="product-info">
                                        <h3 class="h3 product-title">
                                            <a href="shop-product.php?id=<?= $new_product['id']; ?>">
                                                <?= htmlspecialchars($new_product['product_name']); ?>
                                            </a>
                                        </h3>
                                        <div class="product-price-and-shipping">
                                            <span class="price">Kes<?= number_format($new_product['selling_price'], 2); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
          </div>

          <!-- Main Content -->
          <div id="content-wrapper" class="js-content-wrapper left-column col-xs-12 col-sm-8 col-md-9">
               <section id="main">

                    <div id="product-list-header">
                         <div class="block-content">
                              <div class="row">
                                   <div class="col-md-6">
                                        <form id="search_form" method="get" action="shop.php" class="form-inline">
                                             <div class="input-group" style="width:100%;">
                                                  <input type="text" name="search" placeholder="Search products..." value="<?= htmlspecialchars($search); ?>" class="form-control" style="width:70%;">
                                                  <div class="input-group-append">
                                                       <button type="submit" class="btn btn-primary" style="margin-left:5px;">Search</button>
                                                  </div>
                                             </div>
                                        </form>
                                   </div>
                              </div>
                         </div>
                    </div>

                    <section id="products">
                         <div id="js-product-list-top" class="products-selection">
                              <div class="col-md-6 total-products">
                                   <ul class="display hidden-xs grid_list">
                                        <li id="grid" class="current"><a href="#" rel="nofollow" title="Grid" class="selected">Grid</a></li>
                                        <li id="list"><a href="#" rel="nofollow" title="List">List</a></li>
                                   </ul>
                                   <p>There are <?= $totalProducts; ?> products.</p>
                              </div>

                              <div class="col-md-6 sort-order">
                                   <div class="row sort-by-row">
                                        <span class="col-sm-3 col-md-6 hidden-sm-down sort-by">Sort by:</span>
                                        <div class="col-sm-7 col-xs-8 col-md-6 products-sort-order dropdown">
                                             <a class="btn-unstyle select-title" rel="nofollow" data-toggle="dropdown" aria-label="Sort by selection" aria-haspopup="true" aria-expanded="false">
                                                  <?= ucfirst($sort); ?> <i class="material-icons pull-xs-right">▼</i>
                                             </a>
                                             <div class="dropdown-menu">
                                                  <a href="?show=<?= $productsPerPage; ?>&sort=default<?= !empty($search) ? '&search=' . urlencode($search) : ''; ?><?= !empty($selected_brand) ? '&brand=' . urlencode($selected_brand) : ''; ?><?= $min_price > 0 ? '&min_price=' . $min_price : ''; ?><?= $max_price < PHP_FLOAT_MAX ? '&max_price=' . $max_price : ''; ?>" 
                                                     class="select-list <?= $sort === 'default' ? 'current' : ''; ?>">
                                                       Default
                                                  </a>
                                                  <a href="?show=<?= $productsPerPage; ?>&sort=price_low<?= !empty($search) ? '&search=' . urlencode($search) : ''; ?><?= !empty($selected_brand) ? '&brand=' . urlencode($selected_brand) : ''; ?><?= $min_price > 0 ? '&min_price=' . $min_price : ''; ?><?= $max_price < PHP_FLOAT_MAX ? '&max_price=' . $max_price : ''; ?>" 
                                                     class="select-list <?= $sort === 'price_low' ? 'current' : ''; ?>">
                                                       Price, low to high
                                                  </a>
                                                  <a href="?show=<?= $productsPerPage; ?>&sort=price_high<?= !empty($search) ? '&search=' . urlencode($search) : ''; ?><?= !empty($selected_brand) ? '&brand=' . urlencode($selected_brand) : ''; ?><?= $min_price > 0 ? '&min_price=' . $min_price : ''; ?><?= $max_price < PHP_FLOAT_MAX ? '&max_price=' . $max_price : ''; ?>" 
                                                     class="select-list <?= $sort === 'price_high' ? 'current' : ''; ?>">
                                                       Price, high to low
                                                  </a>
                                                  <a href="?show=<?= $productsPerPage; ?>&sort=name_asc<?= !empty($search) ? '&search=' . urlencode($search) : ''; ?><?= !empty($selected_brand) ? '&brand=' . urlencode($selected_brand) : ''; ?><?= $min_price > 0 ? '&min_price=' . $min_price : ''; ?><?= $max_price < PHP_FLOAT_MAX ? '&max_price=' . $max_price : ''; ?>" 
                                                     class="select-list <?= $sort === 'name_asc' ? 'current' : ''; ?>">
                                                       Name, A to Z
                                                  </a>
                                                  <a href="?show=<?= $productsPerPage; ?>&sort=name_desc<?= !empty($search) ? '&search=' . urlencode($search) : ''; ?><?= !empty($selected_brand) ? '&brand=' . urlencode($selected_brand) : ''; ?><?= $min_price > 0 ? '&min_price=' . $min_price : ''; ?><?= $max_price < PHP_FLOAT_MAX ? '&max_price=' . $max_price : ''; ?>" 
                                                     class="select-list <?= $sort === 'name_desc' ? 'current' : ''; ?>">
                                                       Name, Z to A
                                                  </a>
                                                  <a href="?show=<?= $productsPerPage; ?>&sort=newest<?= !empty($search) ? '&search=' . urlencode($search) : ''; ?><?= !empty($selected_brand) ? '&brand=' . urlencode($selected_brand) : ''; ?><?= $min_price > 0 ? '&min_price=' . $min_price : ''; ?><?= $max_price < PHP_FLOAT_MAX ? '&max_price=' . $max_price : ''; ?>" 
                                                     class="select-list <?= $sort === 'newest' ? 'current' : ''; ?>">
                                                       Newest first
                                                  </a>
                                             </div>
                                        </div>

                                        <div class="col-sm-3 col-xs-4 hidden-lg-up filter-button">
                                             <button id="search_filter_toggler" class="btn btn-secondary js-search-toggler">
                                                  Filter
                                             </button>
                                        </div>
                                   </div>
                              </div>
                              <div class="col-sm-12 hidden-lg-up hidden-md-down showing">
                                   Showing 1-<?= $productsPerPage; ?> of <?= $totalProducts; ?> item(s)
                              </div>
                         </div>

                         <section id="js-active-search-filters" class="hide">
                              <p class="h6 hidden-xs-up">Active filters</p>
                         </section>

                         <div id="js-product-list">
                              <div class="products row">
                                   <div class="product_list grid">
                                        <?php
                                        while ($product = mysqli_fetch_assoc($result)):
                                             // Ensure all required fields have default values if not set
                                             $product['id'] = $product['id'] ?? 0;
                                             $product['product_name'] = $product['product_name'] ?? 'Unnamed Product';
                                             $product['description'] = $product['description'] ?? '';
                                             $product['selling_price'] = $product['selling_price'] ?? 0;
                                             $product['original_price'] = $product['original_price'] ?? 0;
                                             $product['quantity'] = $product['quantity'] ?? 0;
                                             $product['brand'] = $product['brand'] ?? 'Generic';
                                             $product['image'] = $product['image'] ?? 'default.png';
                                             $product['in_cart'] = $product['in_cart'] ?? 0;
                                             $product['in_favorite'] = $product['in_favorite'] ?? 0;

                                             include "includes/product-card-template.php";
                                        endwhile;
                                        ?>
                                   </div>
                              </div>

                              <!-- Pagination -->
                              <?php if ($totalPages > 1): ?>
                                   <nav class="pagination">
                                        <div class="col-md-4">
                                             Showing <?= $offset + 1; ?>-<?= min($offset + $productsPerPage, $totalProducts); ?> of <?= $totalProducts; ?> item(s)
                                        </div>
                                        <div class="col-md-8">
                                             <ul class="page-list clearfix text-xs-right">
                                                  <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                                       <li class="<?= $i == $currentPage ? 'current' : ''; ?>">
                                                            <a href="?page=<?= $i; ?>&show=<?= $productsPerPage; ?><?= !empty($search) ? '&search=' . urlencode($search) : ''; ?><?= !empty($sort) ? '&sort=' . urlencode($sort) : ''; ?>"
                                                                 class="<?= $i == $currentPage ? 'disabled' : ''; ?>">
                                                                  <?= $i; ?>
                                                            </a>
                                                       </li>
                                                  <?php endfor; ?>
                                             </ul>
                                        </div>
                                   </nav>
                              <?php endif; ?>
                         </div>

                         <div id="js-product-list-bottom"></div>
                    </section>
               </section>
          </div>
     </div>
</div>

<?php include "includes/footer.php"; ?>