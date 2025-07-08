<?php
session_start();
include 'includes/header.php';
include 'admin/config/dbcon.php';

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

// Get selected category
$selected_category = isset($_GET['category']) ? intval($_GET['category']) : 0;
$category_filter = '';
if ($selected_category > 0) {
    $category_filter = "AND p.category_id = $selected_category";
}

// Get selected brand
$selected_brand = isset($_GET['brand']) ? mysqli_real_escape_string($conn, $_GET['brand']) : '';
$brand_filter = '';
if (!empty($selected_brand)) {
    $brand_filter = "AND p.brand = '$selected_brand'";
}

// Get total products count for pagination
$count_query = "SELECT COUNT(*) as total FROM products p
                WHERE p.status = 1 
                AND p.selling_price BETWEEN $min_price AND $max_price
                $category_filter
                $brand_filter";
$count_result = mysqli_query($conn, $count_query);
$total_products = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_products / $products_per_page);

// Fetch products with pagination and sorting
$product_query = "SELECT p.*, 
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
                 AND p.selling_price BETWEEN $min_price AND $max_price
                 $category_filter
                 $brand_filter
                 ORDER BY $order_by
                 LIMIT $offset, $products_per_page";

$product_query_run = mysqli_query($conn, $product_query);

// Fetch all categories for sidebar
$categories_query = "SELECT * FROM categories WHERE status = 1 ORDER BY name ASC";
$categories_result = mysqli_query($conn, $categories_query);

// Fetch brands for filter
$brands_query = "SELECT DISTINCT brand FROM products WHERE status = 1 AND brand IS NOT NULL ORDER BY brand ASC";
$brands_result = mysqli_query($conn, $brands_query);

// Get price range for filter
$price_range_query = "SELECT 
                        MIN(selling_price) as min_price,
                        MAX(selling_price) as max_price
                      FROM products 
                      WHERE status = 1";
$price_range_result = mysqli_query($conn, $price_range_query);
$price_range = mysqli_fetch_assoc($price_range_result);
?>

<nav data-depth="3" class="breadcrumb">
    <div class="container">
        <ol>
            <li>
                <a href="index.php"><span>Home</span></a>
            </li>
            <li>
                <span>Shop</span>
            </li>
        </ol>
    </div>
</nav>

<section id="wrapper">
    <div class="container">
        <div class="row">
            <!-- Left Sidebar -->
            <div class="col-md-3">
                <div class="sidebar">
                    <!-- Categories Filter -->
                    <div class="filter-block">
                        <h4 class="filter-title">Categories</h4>
                        <div class="filter-content">
                            <ul class="category-list">
                                <li class="<?= $selected_category === 0 ? 'active' : '' ?>">
                                    <a href="?<?= http_build_query(array_merge($_GET, ['category' => 0])) ?>">
                                        All Categories
                                    </a>
                                </li>
                                <?php while($category = mysqli_fetch_assoc($categories_result)): ?>
                                    <li class="<?= $selected_category === $category['id'] ? 'active' : '' ?>">
                                        <a href="?<?= http_build_query(array_merge($_GET, ['category' => $category['id']])) ?>">
                                            <?= htmlspecialchars($category['name']) ?>
                                        </a>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Price Range Filter -->
                    <div class="filter-block">
                        <h4 class="filter-title">Price Range</h4>
                        <div class="filter-content">
                            <form id="price-filter-form" method="GET">
                                <input type="hidden" name="category" value="<?= $selected_category ?>">
                                <input type="hidden" name="brand" value="<?= $selected_brand ?>">
                                <input type="hidden" name="sort" value="<?= $sort ?>">
                                
                                <div class="price-range">
                                    <input type="range" 
                                           class="form-range" 
                                           min="<?= floor($price_range['min_price']) ?>" 
                                           max="<?= ceil($price_range['max_price']) ?>" 
                                           step="100"
                                           value="<?= $min_price ?>"
                                           id="min-price"
                                           name="min_price">
                                    <input type="range" 
                                           class="form-range" 
                                           min="<?= floor($price_range['min_price']) ?>" 
                                           max="<?= ceil($price_range['max_price']) ?>" 
                                           step="100"
                                           value="<?= $max_price ?>"
                                           id="max-price"
                                           name="max_price">
                                </div>
                                
                                <div class="price-inputs">
                                    <div class="input-group">
                                        <span class="input-group-text">KES</span>
                                        <input type="number" 
                                               class="form-control" 
                                               id="min-price-display" 
                                               value="<?= $min_price ?>"
                                               readonly>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text">KES</span>
                                        <input type="number" 
                                               class="form-control" 
                                               id="max-price-display" 
                                               value="<?= $max_price ?>"
                                               readonly>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary btn-block mt-3">Apply Filter</button>
                            </form>
                        </div>
                    </div>

                    <!-- Brand Filter -->
                    <div class="filter-block">
                        <h4 class="filter-title">Brands</h4>
                        <div class="filter-content">
                            <ul class="brand-list">
                                <li class="<?= empty($selected_brand) ? 'active' : '' ?>">
                                    <a href="?<?= http_build_query(array_merge($_GET, ['brand' => ''])) ?>">
                                        All Brands
                                    </a>
                                </li>
                                <?php while($brand = mysqli_fetch_assoc($brands_result)): ?>
                                    <li class="<?= $selected_brand === $brand['brand'] ? 'active' : '' ?>">
                                        <a href="?<?= http_build_query(array_merge($_GET, ['brand' => $brand['brand']])) ?>">
                                            <?= htmlspecialchars($brand['brand']) ?>
                                        </a>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <!-- Sorting and View Options -->
                <div class="products-sort-options">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <p class="mb-0">
                                Showing <?= $offset + 1 ?>-<?= min($offset + $products_per_page, $total_products) ?> 
                                of <?= $total_products ?> products
                            </p>
                        </div>
                        <div class="col-md-6 text-end">
                            <select class="form-select" id="sort-select" onchange="updateSort(this.value)">
                                <option value="default" <?= $sort === 'default' ? 'selected' : '' ?>>Default Sorting</option>
                                <option value="price_low" <?= $sort === 'price_low' ? 'selected' : '' ?>>Price: Low to High</option>
                                <option value="price_high" <?= $sort === 'price_high' ? 'selected' : '' ?>>Price: High to Low</option>
                                <option value="name_asc" <?= $sort === 'name_asc' ? 'selected' : '' ?>>Name: A to Z</option>
                                <option value="name_desc" <?= $sort === 'name_desc' ? 'selected' : '' ?>>Name: Z to A</option>
                                <option value="newest" <?= $sort === 'newest' ? 'selected' : '' ?>>Newest First</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="products-grid">
                    <div class="row">
                        <?php
                        if (mysqli_num_rows($product_query_run) > 0):
                            while ($product = mysqli_fetch_assoc($product_query_run)):
                                include 'includes/product-card-template.php';
                            endwhile;
                        else:
                        ?>
                            <div class="col-12">
                                <div class="alert alert-info">
                                    No products found matching your criteria.
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                    <nav aria-label="Page navigation" class="mt-4">
                        <ul class="pagination justify-content-center">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>">
                                        Previous
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($page < $total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page + 1])) ?>">
                                        Next
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<style>
/* Sidebar Styles */
.sidebar {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.filter-block {
    margin-bottom: 30px;
}

.filter-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}

.category-list, .brand-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.category-list li, .brand-list li {
    margin-bottom: 8px;
}

.category-list li a, .brand-list li a {
    color: #333;
    text-decoration: none;
    display: block;
    padding: 5px 0;
    transition: color 0.3s;
}

.category-list li.active a, .brand-list li.active a {
    color: #007bff;
    font-weight: 600;
}

.category-list li a:hover, .brand-list li a:hover {
    color: #007bff;
}

/* Price Range Styles */
.price-range {
    margin: 20px 0;
}

.price-inputs {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}

.price-inputs .input-group {
    flex: 1;
}

/* Products Grid Styles */
.products-sort-options {
    background: #fff;
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.products-grid {
    margin-bottom: 30px;
}

/* Pagination Styles */
.pagination {
    margin-top: 30px;
}

.page-link {
    color: #007bff;
    border: 1px solid #dee2e6;
    padding: 8px 16px;
}

.page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .sidebar {
        margin-bottom: 30px;
    }
    
    .products-sort-options {
        text-align: center;
    }
    
    .products-sort-options .col-md-6 {
        margin-bottom: 15px;
    }
}
</style>

<script>
// Price Range Slider
document.addEventListener('DOMContentLoaded', function() {
    const minPriceInput = document.getElementById('min-price');
    const maxPriceInput = document.getElementById('max-price');
    const minPriceDisplay = document.getElementById('min-price-display');
    const maxPriceDisplay = document.getElementById('max-price-display');

    function updatePriceDisplay() {
        minPriceDisplay.value = minPriceInput.value;
        maxPriceDisplay.value = maxPriceInput.value;
    }

    minPriceInput.addEventListener('input', function() {
        if (parseInt(this.value) > parseInt(maxPriceInput.value)) {
            this.value = maxPriceInput.value;
        }
        updatePriceDisplay();
    });

    maxPriceInput.addEventListener('input', function() {
        if (parseInt(this.value) < parseInt(minPriceInput.value)) {
            this.value = minPriceInput.value;
        }
        updatePriceDisplay();
    });

    updatePriceDisplay();
});

// Sorting
function updateSort(value) {
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.set('sort', value);
    window.location.search = urlParams.toString();
}
</script>

<?php include 'includes/footer.php'; ?> 