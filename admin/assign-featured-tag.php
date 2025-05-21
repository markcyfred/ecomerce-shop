<?php
include('../middleware/adminMiddleware.php');
include('includes/header.php');

// Fetch only untagged products
$untagged_products = [];
$products_query = mysqli_query($conn, "SELECT id, product_name FROM products WHERE (featured IS NULL OR featured = '') AND status = '1'");
while ($row = mysqli_fetch_assoc($products_query)) {
    $untagged_products[] = $row;
}

// Fetch existing tags
$existing_tags = [];
$tags_query = mysqli_query($conn, "SELECT DISTINCT featured FROM products WHERE featured IS NOT NULL AND featured != ''");
while ($row = mysqli_fetch_assoc($tags_query)) {
    $existing_tags[] = $row['featured'];
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Assign Tag to Untagged Products</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="featured-tags-manage.php">Featured Tags</a></li>
                <li class="breadcrumb-item active">Assign Tag</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <form action="code.php" method="POST">
            <div class="card">
                <div class="card-body">
                    <div class="row py-3">
                        <div class="col-md-6">
                            <label for="existing_tag" class="form-label">Select Existing Tag (Optional)</label>
                            <select name="existing_tag" class="form-select">
                                <option value="">-- Select a tag --</option>
                                <?php foreach ($existing_tags as $tag): ?>
                                    <option value="<?= htmlspecialchars($tag); ?>"><?= htmlspecialchars($tag); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="new_tag_name" class="form-label">Or Enter New Tag Name</label>
                            <input type="text" name="new_tag_name" class="form-control" placeholder="Enter a new tag name">
                        </div>

                        <div class="col-12 mt-4">
                            <label class="form-label">Select Untagged Products to Assign</label>
                            <div class="row">
                                <?php
                                if (count($untagged_products) > 0) {
                                    foreach ($untagged_products as $product) {
                                ?>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="product_ids[]" value="<?= $product['id']; ?>" id="product<?= $product['id']; ?>">
                                                <label class="form-check-label" for="product<?= $product['id']; ?>">
                                                    <?= htmlspecialchars($product['product_name']); ?>
                                                </label>
                                            </div>
                                        </div>
                                <?php
                                    }
                                } else {
                                    echo "<p class='text-muted'>No untagged products found.</p>";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" name="assign_featured_tag_btn" class="btn btn-success">Assign Tag</button>
                            <a href="featured-tags-manage.php" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</main>

<?php include('includes/footer.php'); ?>
