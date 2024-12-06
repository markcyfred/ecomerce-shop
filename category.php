<?php 
include 'includes/header.php';

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $category_id = intval($_GET['id']); // Sanitize the input to prevent SQL injection

    // Fetch category name based on the category ID
    $category_query = "SELECT * FROM categories WHERE id = $category_id";
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
?>
<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.html" rel="nofollow">Home</a>
                <span></span> Categories
                <span></span> <?= $category['name']; ?>
            </div>
        </div>
    </div>

    <section class="mt-50 mb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="category-detail">
                        <h2 class="title-detail"><?= $category['name']; ?></h2>
                        
                        <div class="row">
                            <?php
                            // Fetch products based on category name (not category_id)
                            $product_query = "SELECT * FROM products WHERE category_name = '{$category['name']}' AND status = 1";
                            $product_query_run = mysqli_query($conn, $product_query);

                            if (mysqli_num_rows($product_query_run) > 0) {
                                while ($product = mysqli_fetch_assoc($product_query_run)) {
                                    ?>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="product-cart-wrap small hover-up">
                                            <div class="product-img-action-wrap">
                                                <div class="product-img product-img-zoom">
                                                    <a href="shop-product.php?id=<?= $product['id']; ?>" tabindex="0">
                                                        <img class="default-img" src="uploads/shop/<?= $product['image']; ?>" alt="<?= $product['product_name']; ?>">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="product-content-wrap">
                                                <h2><a href="shop-product.php?id=<?= $product['id']; ?>" tabindex="0"><?= $product['product_name']; ?></a></h2>
                                                <div class="product-price">
                                                    <span>Kes <?= $product['selling_price']; ?></span>
                                                    <span class="old-price">Kes <?= $product['original_price']; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                echo "<p>No products found in this category.</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 primary-sidebar sticky-sidebar">
                    <!-- Sidebar Category Widget -->
                    <div class="widget-category mb-30">
                        <h5 class="section-title style-1 mb-30">Categories</h5>
                        <ul class="categories">
                            <?php 
                            // Fetch all categories for the sidebar
                            $categories_query = "SELECT * FROM categories";
                            $categories_query_run = mysqli_query($conn, $categories_query);
                            if (mysqli_num_rows($categories_query_run) > 0) {
                                while ($category_item = mysqli_fetch_assoc($categories_query_run)) {
                                    ?>
                                    <li><a href="category.php?id=<?= $category_item['id']; ?>"><?= $category_item['name']; ?></a></li>
                                    <?php
                                }
                            } else {
                                echo "<p>No categories available</p>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
