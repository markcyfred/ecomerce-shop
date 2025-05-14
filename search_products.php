<?php
// search_products.php

include('admin/config/dbcon.php');

// Get search parameters
$rawSearch = isset($_GET['search']) ? trim($_GET['search']) : '';
$category  = isset($_GET['category']) ? intval($_GET['category']) : 0;
$page      = isset($_GET['page']) && intval($_GET['page']) > 0 ? intval($_GET['page']) : 1;
$limit     = 2;
$offset    = ($page - 1) * $limit;

// Split search into terms
$terms = array_filter(preg_split('/\s+/', $rawSearch));
if (empty($terms)) {
    echo "<div style='text-align:center; padding:40px; color:#888;'>Please enter a search term.</div>";
    exit;
}

// Build dynamic WHERE parts and parameter sets
$whereParts     = [];
$countParams    = [];
$countTypes     = '';
$scoreParts     = [];
$searchParams   = [];
$searchTypes    = '';

foreach ($terms as $term) {
    $like = "%{$term}%";
    // WHERE condition (used by both count & main query)
    $whereParts[] = "product_name LIKE ?";
    // Count params
    $countParams[] = $like;
    $countTypes   .= 's';
    // Score for ordering (main query)
    $scoreParts[] = "(product_name LIKE ?)";
    // Main query params (term for where + for score)
    $searchParams[] = $like;
    $searchParams[] = $like;
    $searchTypes   .= 'ss';
}

// Category filter
if ($category > 0) {
    $whereParts[]   = "category_id = ?";
    $countParams[]  = $category;
    $searchParams[] = $category;
    $countTypes    .= 'i';
    $searchTypes   .= 'i';
}

$whereSql = implode(' AND ', $whereParts);
$scoreSql = implode(' + ', $scoreParts);

// Count total matching rows
$countSql  = "SELECT COUNT(*) AS total FROM products WHERE $whereSql";
$countStmt = $conn->prepare($countSql);
$countStmt->bind_param($countTypes, ...$countParams);
$countStmt->execute();
$countRes   = $countStmt->get_result();
$total      = $countRes->fetch_assoc()['total'] ?? 0;
$totalPages = ceil($total / $limit);
$countStmt->close();

// Main query with score, limit, offset
$sql = "SELECT *, ($scoreSql) AS score
        FROM products
        WHERE $whereSql
        ORDER BY score DESC
        LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);

// Append limit & offset to search params
$searchParams[] = $limit;
$searchParams[] = $offset;
$searchTypes   .= 'ii';

$stmt->bind_param($searchTypes, ...$searchParams);
$stmt->execute();
$result = $stmt->get_result();

// Highlight function
function highlight($text, $terms) {
    foreach ($terms as $t) {
        $escaped = preg_quote($t, '/');
        $text = preg_replace(
            "/($escaped)/i",
            '<span class="highlight">$1</span>',
            $text
        );
    }
    return $text;
}

// Output results
if ($result && $result->num_rows > 0) {
    echo "<div class='products-container'>";
    while ($product = $result->fetch_assoc()) {
        echo "<div class='product shoe-product'>";
        echo "<a href='shop-product.php?id=" . htmlspecialchars($product['id']) . "' style='text-decoration:none;color:inherit;'>";
        echo "<h3>" . highlight(htmlspecialchars($product['product_name']), $terms) . "</h3>";
        echo "<p>" . highlight(htmlspecialchars($product['description']), $terms) . "</p>";
        if ($product['original_price'] > 0) {
            echo "<p style='text-decoration:line-through;color:#888;'>Kes" . htmlspecialchars($product['original_price']) . "</p>";
        }
        echo "<p>Price: Kes" . htmlspecialchars($product['selling_price']) . "</p>";
        if (!empty($product['image'])) {
            echo "<img src='uploads/shop/" . htmlspecialchars($product['image']) . "' alt='" . htmlspecialchars($product['product_name']) . "' style='max-width:120px;max-height:120px;border-radius:8px;object-fit:cover;margin-top:10px;'>";
        }
        echo "</a>";
        echo "</div>";
    }
    echo "</div>";

    // Pagination
    if ($totalPages > 1) {
        echo "<nav aria-label='Page navigation'>";
        echo "<ul class='pagination justify-content-center'>";
        if ($page > 1) {
            echo "<li class='page-item'><a class='page-link pagination-link' href='#' data-page='" . ($page-1) . "'>Previous</a></li>";
        } else {
            echo "<li class='page-item disabled'><span class='page-link'>Previous</span></li>";
        }
        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $page) {
                echo "<li class='page-item active'><span class='page-link'>$i</span></li>";
            } else {
                echo "<li class='page-item'><a class='page-link pagination-link' href='#' data-page='$i'>$i</a></li>";
            }
        }
        if ($page < $totalPages) {
            echo "<li class='page-item'><a class='page-link pagination-link' href='#' data-page='" . ($page+1) . "'>Next</a></li>";
        } else {
            echo "<li class='page-item disabled'><span class='page-link'>Next</span></li>";
        }
        echo "</ul>";
        echo "</nav>";
    }
} else {
    echo "<div style='text-align:center;padding:40px;'>";
    echo "<script src='https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs' type='module'></script>";
    echo "<dotlottie-player src='https://lottie.host/4d90d9e8-11b2-46c0-8032-61f6db73591b/VZqRxP5O84.lottie' background='transparent' speed='1' style='width:250px;height:250px;margin:0 auto;' loop autoplay></dotlottie-player>";
    echo "<h4 style='margin-top:20px;color:#888;'>No items found matching your search</h4>";
    echo "<p style='color:#aaa;'>Try checking the spelling or choosing a different category.</p>";
    echo "</div>";
}

$stmt->close();
$conn->close();
?>
