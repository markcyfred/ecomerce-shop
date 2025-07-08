<?php
include('../middleware/adminMiddleware.php');
include('includes/header.php');

if (!isset($_GET['tag'])) {
    $_SESSION['message'] = "No tag specified!";
    $_SESSION['messageType'] = "error";
    header("Location: featured-tags-manage.php");
    exit();
}

$current_tag = mysqli_real_escape_string($conn, $_GET['tag']);

// Fetch products currently using this tag
$tagged_products = [];
$tagged_query = mysqli_query($conn, "SELECT id FROM products WHERE featured = '$current_tag'");
while ($row = mysqli_fetch_assoc($tagged_query)) {
    $tagged_products[] = $row['id'];
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Edit Featured Tag</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="featured-tags-manage.php">Featured Tags</a></li>
                <li class="breadcrumb-item active">Edit Tag</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <form action="code.php" method="POST">
            <div class="card">
                <div class="card-body">
                    <div class="row py-3">
                        <input type="hidden" name="old_tag_name" value="<?= htmlspecialchars($current_tag); ?>">

                        <div class="col-md-6">
                            <label for="tag_name" class="form-label">Tag Name</label>
                            <input type="text" name="new_tag_name" class="form-control" value="<?= htmlspecialchars($current_tag); ?>" required>
                        </div>

                        <!-- Real Products Section -->
                        <div class="col-12 mt-4">
                            <label class="form-label">Select Real Products to Assign This Tag</label>
                            <div class="row">
                                <?php
                                $products = mysqli_query($conn, "SELECT id, product_name FROM products WHERE status = '1'");
                                if (mysqli_num_rows($products) > 0) {
                                    foreach ($products as $product) {
                                        $checked = in_array($product['id'], $tagged_products) ? 'checked' : '';
                                ?>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="product_ids[]" value="<?= $product['id']; ?>" id="product<?= $product['id']; ?>" <?= $checked; ?>>
                                                <label class="form-check-label" for="product<?= $product['id']; ?>">
                                                    <?= htmlspecialchars($product['product_name']); ?>
                                                </label>
                                            </div>
                                        </div>
                                <?php
                                    }
                                } else {
                                    echo "<p class='text-muted'>No products found</p>";
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Dummy Products Section -->
                        <div class="col-12 mt-5">
                            <label class="form-label">Dummy Products (Used or Available)</label>

                            <p><strong>Available Dummy Products (selectable):</strong></p>
                            <div class="row">
                                <?php
                                // Dummy products that are available (status=0) and not used (featured empty or NULL)
                                $availableDummies = mysqli_query($conn, "SELECT id, product_name FROM products WHERE status=0 AND (featured IS NULL OR featured = '')");
                                if (mysqli_num_rows($availableDummies) > 0) {
                                    foreach ($availableDummies as $dummy) {
                                        $checked = in_array($dummy['id'], $tagged_products) ? 'checked' : '';
                                ?>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="product_ids[]" value="<?= $dummy['id']; ?>" id="dummyAvailable<?= $dummy['id']; ?>" <?= $checked; ?>>
                                                <label class="form-check-label" for="dummyAvailable<?= $dummy['id']; ?>">
                                                    <?= htmlspecialchars($dummy['product_name']); ?>
                                                </label>
                                            </div>
                                        </div>
                                <?php
                                    }
                                } else {
                                    echo "<p class='text-muted'>No available dummy products</p>";
                                }
                                ?>
                            </div>

                            <p class="mt-3"><strong>Used Dummy Products (disabled):</strong></p>
                            <div class="row">
                                <?php
                                // Dummy products that are used (status=0) and have a featured tag (not empty)
                                $usedDummies = mysqli_query($conn, "SELECT id, product_name, featured FROM products WHERE status=0 AND featured IS NOT NULL AND featured != ''");
                                if (mysqli_num_rows($usedDummies) > 0) {
                                    foreach ($usedDummies as $dummy) {
                                        // Mark checked if this dummy belongs to current tag (allow uncheck)
                                        $checked = in_array($dummy['id'], $tagged_products) ? 'checked' : '';
                                ?>
                                        <div class="col-md-4">
                                            <div class="form-check disabled">
                                                <input class="form-check-input" type="checkbox" name="product_ids[]" value="<?= $dummy['id']; ?>" id="dummyUsed<?= $dummy['id']; ?>" <?= $checked ? 'checked' : ''; ?> <?= $checked ? '' : 'disabled'; ?>>
                                                <label class="form-check-label" for="dummyUsed<?= $dummy['id']; ?>">
                                                    <?= htmlspecialchars($dummy['product_name']) . " (Tag: " . htmlspecialchars($dummy['featured']) . ")"; ?>
                                                </label>
                                            </div>
                                        </div>
                                <?php
                                    }
                                } else {
                                    echo "<p class='text-muted'>No used dummy products</p>";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" name="update_featured_tag_btn" class="btn btn-success">Update Tag</button>
                            <a href="featured-tags-manage.php" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</main>

<?php include('includes/footer.php'); ?>
