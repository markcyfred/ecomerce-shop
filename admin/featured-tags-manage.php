<?php
include('../middleware/adminMiddleware.php');
include('includes/header.php');
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<?php
if (isset($_SESSION['message'])) {
    $icon = ($_SESSION['messageType'] == 'success') ? 'success' : 'error';
?>
    <script>
        Swal.fire({
            icon: '<?php echo $icon; ?>',
            title: '<?php echo $_SESSION['message']; ?>',
            toast: true,
            position: 'top-end',
            timer: 2000,
            showConfirmButton: false
        });
    </script>
<?php
    unset($_SESSION['message']);
    unset($_SESSION['messageType']);
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Manage Featured Tags</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Featured Tags</li>
                <a style="color: #fff;" href="add-featured-tag.php" class="btn btn-primary btn-sm">Add New Tag</a>
                <!-- asign tag to product -->
                <a style="color: #fff;" href="assign-featured-tag.php" class="btn btn-primary btn-sm">Assign Tag to Product</a>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tag Name</th>
                                <th scope="col">Products Using</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT DISTINCT featured FROM products WHERE featured IS NOT NULL AND featured != ''";
                            $result = mysqli_query($conn, $query);

                            if (mysqli_num_rows($result) > 0) {
                                $id = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $tag = $row['featured'];
                                    $count_query = mysqli_query($conn, "SELECT COUNT(*) AS count FROM products WHERE featured = '$tag'");
                                    $count_data = mysqli_fetch_assoc($count_query);
                                    $product_count = $count_data['count'];
                            ?>

                                    <tr>
                                        
                                        <td><?= $id++; ?></td>
                                        </th>
                                        <td>
                                            <?= htmlspecialchars($tag); ?>
                                        </td>


                                        <td>
                                            <?= $product_count; ?>
                                        </td>

                                        <td>
                                            <a href="edit-featured-tag.php?tag=<?= urlencode($tag); ?>" class="text-primary me-2">
                                                <i class="ri-edit-2-fill fs-4"></i>
                                            </a>
                                            <form action="code.php" method="POST" style="display: inline;">
                                                <input type="hidden" name="tag_delete" value="<?= htmlspecialchars($tag); ?>">
                                                <button type="submit" name="delete_tag_btn" onclick="return confirm('Delete this tag from all products?')" style="border: none; background: none; padding: 0; cursor: pointer;">
                                                    <i class="bi bi-trash text-danger fs-4"></i>
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='4' class='text-center'>No Featured Tags Found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>
</main>

<?php include('includes/footer.php'); ?>