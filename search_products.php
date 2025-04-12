<?php
// search_products.php

include('admin/config/dbcon.php');

$search   = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';

$search_safe = mysqli_real_escape_string($conn, $search);
$whereClause = "product_name LIKE '%$search_safe%'";

if (!empty($category)) {
    $category_safe = mysqli_real_escape_string($conn, $category);
    $whereClause .= " AND category_name = '$category_safe'";
}

// Set limit to 2 products per page
$limit = 2;
$page   = isset($_GET['page']) && intval($_GET['page']) > 0 ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

$count_query  = "SELECT COUNT(*) AS total FROM products WHERE $whereClause";
$count_result = mysqli_query($conn, $count_query);
$total = 0;
if ($count_result) {
    $row = mysqli_fetch_assoc($count_result);
    $total = $row['total'];
}
$total_pages = ceil($total / $limit);

$query  = "SELECT * FROM products WHERE $whereClause LIMIT $offset, $limit";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    echo "<div class='products-container'>";
    while ($product = mysqli_fetch_assoc($result)) {
        // Wrap the entire product block within an anchor tag
        echo "<div class='product shoe-product'>";
        echo "<a href='shop-product.php?id=" . htmlspecialchars($product['id']) . "' style='text-decoration: none; color: inherit;'>";
        echo    "<h3>" . htmlspecialchars($product['product_name']) . "</h3>";
        echo    "<p>" . htmlspecialchars($product['description']) . "</p>";
        //ORIGINAL_PRICE
        if ($product['original_price'] > 0) {
            echo    "<p style='text-decoration: line-through; color: #888;'>Kes" . htmlspecialchars($product['original_price']) . "</p>";
        }
        //SELLING_PRICE
        echo    "<p>Price: Kes" . htmlspecialchars($product['selling_price']) . "</p>";
        if (!empty($product['image'])) {
            echo "<img src='uploads/shop/" . htmlspecialchars($product['image']) . "' alt='" . htmlspecialchars($product['product_name']) . "' style='max-width: 120px; max-height: 120px; border-radius: 8px; object-fit: cover; margin-top: 10px;'>";
        }
        echo "</a>";
        echo "</div>";
    }
    echo "</div>";

    // Pagination
    if ($total_pages > 1) {
        echo "<nav aria-label='Page navigation'>";
        echo   "<ul class='pagination justify-content-center'>";
        if ($page > 1) {
            echo "<li class='page-item'><a class='page-link pagination-link' href='#' data-page='" . ($page - 1) . "'>Previous</a></li>";
        } else {
            echo "<li class='page-item disabled'><span class='page-link'>Previous</span></li>";
        }
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                echo "<li class='page-item active'><span class='page-link'>" . $i . "</span></li>";
            } else {
                echo "<li class='page-item'><a class='page-link pagination-link' href='#' data-page='" . $i . "'>" . $i . "</a></li>";
            }
        }
        if ($page < $total_pages) {
            echo "<li class='page-item'><a class='page-link pagination-link' href='#' data-page='" . ($page + 1) . "'>Next</a></li>";
        } else {
            echo "<li class='page-item disabled'><span class='page-link'>Next</span></li>";
        }
        echo   "</ul>";
        echo "</nav>";
    }
} else {
    echo "
    <div style='text-align: center; padding: 40px;'>
        <script src='https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs' type='module'></script>
        <dotlottie-player
            src='https://lottie.host/4d90d9e8-11b2-46c0-8032-61f6db73591b/VZqRxP5O84.lottie'
            background='transparent'
            speed='1'
            style='width: 250px; height: 250px; margin: 0 auto;'
            loop
            autoplay>
        </dotlottie-player>
        <h4 style='margin-top: 20px; color: #888;'>No items found matching your search</h4>
        <p style='color: #aaa;'>Try checking the spelling or choosing a different category.</p>
    </div>
    ";
}
?>
