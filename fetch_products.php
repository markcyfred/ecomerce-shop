<?php
include 'admin/config/dbcon.php'; // Include database connection

// Fetch a maximum of 8 randomly selected products where `featured` is 'featured'
$product_query = "SELECT * FROM products WHERE status = 1 AND featured = 'featured' ORDER BY RAND() LIMIT 8";
$product_query_run = mysqli_query($conn, $product_query);

if (mysqli_num_rows($product_query_run) > 0) {
    while ($product = mysqli_fetch_assoc($product_query_run)) {
        ?>
        <div class="col-lg-3 col-md-4 col-12 col-sm-6">
            <div class="product-cart-wrap mb-30">
                <div class="product-img-action-wrap">
                    <div class="product-img product-img-zoom">
                        <a href="shop-product-right.php?id=<?= $product['id']; ?>">
                            <img class="default-img" src="uploads/shop/<?= $product['image']; ?>" alt="<?= $product['product_name']; ?>">
                        </a>
                    </div>
                    <div class="product-action-1">
                        <a aria-label="Quick view" class="action-btn hover-up" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                        <a aria-label="Add To Wishlist" class="action-btn hover-up" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                        <a aria-label="Compare" class="action-btn hover-up" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                    </div>
                    <div class="product-badges product-badges-position product-badges-mrg">
                        <span class="new">
                            <a href="shop-grid-right.php"><?= $product['featured']; ?></a>
                        </span>
                    </div>
                </div>
                <div class="product-content-wrap">
                    <div class="product-category">
                        <a href="shop-grid-right.php"><?= $product['category_name']; ?></a>
                    </div>
                    <h2>
                        <a href="shop-product-right.php?id=<?= $product['id']; ?>"><?= $product['product_name']; ?></a>
                    </h2>
                    <div class="rating-result" title="90%">
                        <span>
                            <span><?= $product['rating']; ?>%</span>
                        </span>
                    </div>
                    <div class="product-price">
                        <span>Kes<?= $product['selling_price']; ?></span>
                        <span class="old-price">Kes<?= $product['original_price']; ?></span>
                    </div>
                    <div class="product-action-1 show">
                        <a aria-label="Add To Cart" class="action-btn hover-up" href="shop-cart.html"><i class="fi-rs-shopping-bag-add"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
} else {
    echo "<p class='col-12 text-center'>No featured products available</p>";
}
?>
