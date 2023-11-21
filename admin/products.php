<?php
session_start();
include('../middleware/adminMiddleware.php');
include('includes/header.php');
?>

<style>
    .breadcrumb {
        display: flex;
        justify-content: space-between;
    }
</style>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>View Products</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">View products Forms</li>
                <a href="products-add.php" title="Add new Product">
                    <i class=" ri-menu-add-line"></i> Add Product
                </a>

                <li class="breadcrumb-item active">
                    <a href="index.php">
                        <i class="ri-arrow-go-back-fill"></i>
                        home</a>
                </li>
            </ol>
        </nav>
    </div><!-- End Page Title -->


    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">All Products</h5>

                        <!-- Table with stripped rows -->
                        <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Rating</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Discount</th>
                                        <th scope="col">Product</th>
                                        <th scope="col">Selling..</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Trending</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $products = getAll("products");

                                    if (mysqli_num_rows($products) > 0) {
                                        foreach ($products as $item) {
                                    ?>

                                            <tr>
                                                <th><?= $item['id']; ?></th>
                                                <td><?= (strlen($item['category_name']) > 5) ? substr($item['category_name'], 0, 5) . '..' : $item['category_name']; ?></td>
                                                <td>
                                                    <?php
                                                    $rating = $item['rating'];
                                                    for ($i = 1; $i <= 5; $i++) {
                                                        if ($i <= $rating) {
                                                            echo '<i class="bi bi-star-fill" style="font-size: 0.5rem;color:#1bbd36;"></i>';
                                                        } else {
                                                            echo '<i class="bi bi-star" style="font-size: 0.5rem;color:#1bbd36;"></i>';
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php if ($item['status'] == 1) : ?>
                                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span>
                                                    <?php else : ?>
                                                        <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i> Inactive</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= $item['discount'] . '%'; ?></td>
                                                <td><?= (strlen($item['product_name']) > 5) ? substr($item['product_name'], 0, 5) . '..' : $item['product_name']; ?></td>

                                                <td><?= 'Ksh ' . number_format($item['selling_price']); ?></td>
                                                <td><img src="../uploads/shop/<?= $item['image']; ?>" alt="<?= $item['product_name']; ?>" width="100" height="100" style="border: 1px solid #a5c5fe;"></td>
                                                <td>
                                                    <?php if ($item['trending'] == 1) : ?>
                                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span>
                                                    <?php else : ?>
                                                        <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i> Inactive</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="edit-product.php?id=<?= $item['id']; ?>" class="text-primary me-2">
                                                        <i class="ri-edit-2-fill fs-4"></i>
                                                    </a>
                                                    <form action="code.php" method="POST" style="display: inline;">
                                                        <input type="hidden" name="product_id" value="<?= $item['id']; ?>">
                                                        <button type="submit" name="delete_product_btn" style="border: none; background: none; padding: 0; cursor: pointer;">
                                                            <i class="bi bi-trash text-danger fs-4"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>

                                    <?php
                                        }
                                    } else {
                                        echo "No record found";
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>





</main><!-- End #main -->
<?php
include('includes/footer.php')
?>