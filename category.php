<?php
include 'includes/header.php';
include 'admin/config/dbcon.php';

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $category_id = intval($_GET['id']); // Sanitize the input to prevent SQL injection

    // Fetch category details based on the category ID
    $category_query = "SELECT * FROM categories WHERE id = $category_id AND status = 1";
    $category_query_run = mysqli_query($conn, $category_query);

    // Check if the category exists
    if (mysqli_num_rows($category_query_run) > 0) {
        $category = mysqli_fetch_assoc($category_query_run);
    } else {
        echo "<p>Category not found</p>";
        exit;
    }
} else {
    echo "<p>Invalid category</p>";
    exit;
}

// Pagination settings
$products_per_page = 12;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $products_per_page;

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

// Filter by price range
$min_price = isset($_GET['min_price']) ? (float)$_GET['min_price'] : 0;
$max_price = isset($_GET['max_price']) ? (float)$_GET['max_price'] : PHP_FLOAT_MAX;

// Get selected brands
$selected_brand = isset($_GET['brand']) ? mysqli_real_escape_string($conn, $_GET['brand']) : '';
$brand_filter = '';
if (!empty($selected_brand)) {
    $brand_filter = "AND p.brand_name = '$selected_brand'";
}

// Get total products count for pagination
$count_query = "SELECT COUNT(*) as total FROM products p
                WHERE p.category_name = '{$category['name']}' 
                AND p.status = 1 
                AND p.selling_price BETWEEN $min_price AND $max_price
                $brand_filter";
$count_result = mysqli_query($conn, $count_query);
$total_products = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_products / $products_per_page);

// Fetch products with pagination and sorting
$product_query = "SELECT p.*, 
                        (SELECT COUNT(*) FROM cart 
                         WHERE cart.product_id = p.id 
                         AND (cart.session_id = '" . session_id() . "' 
                              OR cart.user_id = '" . ($_SESSION['auth_user']['id'] ?? '0') . "')
                         AND (cart.cart_status IS NULL OR cart.cart_status != 'processed')
                        ) AS in_cart,
                        (SELECT COUNT(*) FROM favorite 
                         WHERE favorite.product_id = p.id 
                         AND (favorite.session_id = '" . session_id() . "' 
                              OR favorite.user_id = '" . ($_SESSION['auth_user']['id'] ?? '0') . "')
                        ) AS in_favorite
                 FROM products p
                 WHERE p.category_name = '{$category['name']}' 
                 AND p.status = 1 
                 AND p.selling_price BETWEEN $min_price AND $max_price
                 $brand_filter
                 ORDER BY $order_by
                 LIMIT $offset, $products_per_page";

$product_query_run = mysqli_query($conn, $product_query);

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
                      WHERE category_name = '{$category['name']}' 
                      AND status = 1";
$price_range_result = mysqli_query($conn, $price_range_query);
$price_range = mysqli_fetch_assoc($price_range_result);
?>

<nav data-depth="4" class="breadcrumb">
    <div class="container">
        <ol>
            <li>
                <a href="index.php"><span>Home</span></a>
            </li>
            <li>
                <a href="category.php?id=<?= $category_id; ?>"><span><?= htmlspecialchars($category['name']); ?></span></a>
            </li>
        </ol>
    </div>
</nav>



<section id="wrapper">

    <div class="container">
        <div id="columns_inner">

            <div id="left-column" class="col-xs-12">

                <div id="search_filters_wrapper" class="block">
                    <div id="search_filters">
                        <h4 class="block_title">Filter By
                            <div class="filter-close hidden-lg-up">
                                <i class="material-icons menu-close">×</i>
                            </div>
                        </h4>

                        <div class="block_content">
                            <!-- Availability Filter -->
                            <section class="facet clearfix">
                                <p class="h6 facet-title">Availability</p>
                                <ul id="facet_availability">
                                    <li>
                                        <label class="facet-label">
                                            <span class="custom-checkbox">
                                                <input type="checkbox" name="in_stock" value="1" <?= isset($_GET['in_stock']) ? 'checked' : ''; ?>>
                                                <span class="ps-shown-by-js"><i class="material-icons rtl-no-flip checkbox-checked">✓</i></span>
                                            </span>
                                            <a href="#" class="_gray-darker search-link js-search-link">
                                                In stock
                                                <span class="magnitude">(<?= $total_products; ?>)</span>
                                            </a>
                                        </label>
                                    </li>
                                </ul>
                            </section>

                            <!-- Brand Filter -->
                            <section class="facet clearfix">
                                <p class="h6 facet-title">Brand</p>
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
                                                <a href="?id=<?= $category_id; ?>" class="select-list <?= empty($selected_brand) ? 'current' : ''; ?>">
                                                    All Brands
                                                </a>
                                                <?php 
                                                mysqli_data_seek($brands_result, 0);
                                                while($brand = mysqli_fetch_assoc($brands_result)): 
                                                    // Count products for this brand in current category
                                                    $brand_count_query = "SELECT COUNT(*) as count FROM products 
                                                                WHERE category_name = '{$category['name']}' 
                                                                AND brand_name = '{$brand['brand_name']}' 
                                                                AND status = 1";
                                                    $brand_count_result = mysqli_query($conn, $brand_count_query);
                                                    $brand_count = mysqli_fetch_assoc($brand_count_result)['count'];
                                                ?>
                                                    <a href="?id=<?= $category_id; ?>&brand=<?= urlencode($brand['brand_name']); ?>" 
                                                       class="select-list <?= $selected_brand === $brand['brand_name'] ? 'current' : ''; ?>">
                                                        <?= htmlspecialchars($brand['brand_name']); ?>
                                                        (<?= $brand_count; ?>)
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

                <div id="czleftbanner" class="czleftbanner block">
                    <?php
                    // Fetch left banner from database
                    $left_banner_query = "SELECT * FROM banners WHERE status = '1' AND size = 'normal' AND banner_type = 'single' ORDER BY RAND() LIMIT 1";
                    $left_banner_result = mysqli_query($conn, $left_banner_query);
                    
                    if ($left_banner_result && mysqli_num_rows($left_banner_result) > 0):
                        $banner = mysqli_fetch_assoc($left_banner_result);
                    ?>
                    <ul>
                        <li class="slide czleftbanner-container">
                            <a href="<?= htmlspecialchars($banner['link']); ?>" title="<?= htmlspecialchars($banner['title']); ?>">
                                <img class="lazyload" 
                                     src="themes/Electech/assets/img/codezeel/sidebanner-lazy-loader.svg" 
                                     data-src="uploads/banners/<?= htmlspecialchars($banner['image']); ?>" 
                                     alt="<?= htmlspecialchars($banner['title']); ?>" 
                                     title="<?= htmlspecialchars($banner['title']); ?>" />
                                <div class="banner-content">
                                    <h3><?= htmlspecialchars($banner['title']); ?></h3>
                                    <p><?= htmlspecialchars($banner['subtitle']); ?></p>
                                    <span class="price">From Kes <?= number_format($banner['price'], 2); ?></span>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <?php else: ?>
                    <ul>
                        <li class="slide czleftbanner-container">
                            <a href="#" title="Default Banner">
                                <img class="lazyload" 
                                     src="themes/Electech/assets/img/codezeel/sidebanner-lazy-loader.svg" 
                                     data-src="themes/Electech/assets/img/codezeel/default-banner.jpg" 
                                     alt="Default Banner" 
                                     title="Default Banner" />
                            </a>
                        </li>
                    </ul>
                    <?php endif; ?>
                </div>
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



            <div id="content-wrapper" class="js-content-wrapper left-column col-xs-12 col-sm-8 col-md-9">


                <section id="main">


                    <input id="getCartLink" name="getCartLink" value="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/cart" type="hidden">
                    <input id="getTokenId" name="getTokenId" value="be2e4f21e069f2f9e1a4d6f6ab1dfbfa" type="hidden">

                    <div id="product-list-header">
                        <div class="block-category">

                            <h1 class="h1"><?= htmlspecialchars($category['name']); ?></h1>

                            <?php if(!empty($category['description'])): ?>
                            <div id="category-description">
                                <p><?= htmlspecialchars($category['description']); ?></p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>







                    <section id="products">


                        <div id="js-product-list-top" class="products-selection">

                            <div class="col-md-6 total-products">
                                <ul class="display hidden-xs grid_list">
                                    <li id="grid" class="current"><a href="#" rel="nofollow" title="Grid" class="selected">Grid</a></li>
                                    <li id="list"><a href="#" rel="nofollow" title="List">List</a></li>
                                </ul>
                                <p>There are <?= $total_products; ?> products.</p>
                            </div>
                            
                            

                            <div class="col-md-6 sort-order">
                                <div class="row sort-by-row">

                                    <span class="col-sm-3 col-md-6 hidden-sm-down sort-by">Sort by:</span>
                                    <div class="col-sm-7 col-xs-8 col-md-6 products-sort-order dropdown">
                                        <a class="btn-unstyle select-title" rel="nofollow" data-toggle="dropdown" aria-label="Sort by selection" aria-haspopup="true" aria-expanded="false">
                                            <?= ucfirst($sort); ?> <i class="material-icons pull-xs-right">▼</i>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a href="?id=<?= $category_id; ?>&sort=price_low" class="select-list <?= $sort === 'price_low' ? 'current' : ''; ?>">
                                                Price, low to high
                                            </a>
                                            <a href="?id=<?= $category_id; ?>&sort=price_high" class="select-list <?= $sort === 'price_high' ? 'current' : ''; ?>">
                                                Price, high to low
                                            </a>
                                            <a href="?id=<?= $category_id; ?>&sort=name_asc" class="select-list <?= $sort === 'name_asc' ? 'current' : ''; ?>">
                                                Name, A to Z
                                            </a>
                                            <a href="?id=<?= $category_id; ?>&sort=name_desc" class="select-list <?= $sort === 'name_desc' ? 'current' : ''; ?>">
                                                Name, Z to A
                                            </a>
                                            <a href="?id=<?= $category_id; ?>&sort=newest" class="select-list <?= $sort === 'newest' ? 'current' : ''; ?>">
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
                                Showing 1-14 of 14 item(s)
                            </div>
                        </div>



                        <section id="js-active-search-filters" class="hide">

                            <p class="h6 hidden-xs-up">Active filters</p>


                        </section>




                        <div id="js-product-list">
                            <div class="products row">
                                <div class="product_list grid">
                                    <?php 
                                    if(mysqli_num_rows($product_query_run) > 0):
                                        while($product = mysqli_fetch_assoc($product_query_run)):
                                            include 'includes/product-card-template.php';
                                        endwhile;
                                    else:
                                        echo "<p>No products found in this category.</p>";
                                    endif;
                                    ?>
                                </div>
                            </div>

                            <!-- Pagination -->
                            <?php if($total_pages > 1): ?>
                            <nav class="pagination">
                                <div class="col-md-4">
                                    Showing <?= $offset + 1; ?>-<?= min($offset + $products_per_page, $total_products); ?> of <?= $total_products; ?> item(s)
                                </div>
                                <div class="col-md-8">
                                    <ul class="page-list clearfix text-xs-right">
                                        <?php for($i = 1; $i <= $total_pages; $i++): ?>
                                            <li class="<?= $i == $page ? 'current' : ''; ?>">
                                                <a href="?id=<?= $category_id; ?>&page=<?= $i; ?><?= !empty($selected_brand) ? '&brand=' . urlencode($selected_brand) : ''; ?><?= !empty($sort) ? '&sort=' . $sort : ''; ?>" 
                                                   class="<?= $i == $page ? 'disabled' : ''; ?>">
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

</section><span class="sr-only">Green</span></a>
<span class="js-count count"></span>
</div>



<?php include 'includes/footer.php'; ?>