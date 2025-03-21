<?php
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
        <h1>View brands</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">View brands Forms</li>
                <a href="add-brand.php" title="Add new Category">
                    <i class=" ri-menu-add-line"></i> Add Category
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

                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Brand name</th>
                                <th scope="col">Image</th>
                                <th scope="col">Description</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $brands = getAll("brands");

                            if (mysqli_num_rows($brands) > 0) {
                                foreach ($brands as $item) {
                            ?>

                                    <tr>
                                        <th>
                                            <?= $item['id']; ?>
                                        </th>
                                        <td>
                                            <?= $item['brand_name']; ?>
                                        </td>
                                        <td>
                                            <img src="<?= $item['brand_image']; ?>" alt="<?= $item['brand_name']; ?>" style="width: 50px; height: 50px;">
                                        </td>
                                        <td>
                                            <?= $item['brand_description']; ?>
                                        </td>
                                        <td>
                                            <?= $item['status'] == 1 ? 'Active' : 'Inactive'; ?>
                                        </td>
                                        <td>
                                            <a href="edit-brand.php.php?id=<?= $item['id']; ?>" class="text-primary me-2">
                                                <i class="ri-edit-2-fill fs-4"></i>
                                            </a>
                                            <form action="code.php" method="POST" style="display: inline;">
                                                  <input type="hidden" name="id" value="<?= $item['id']; ?>">
                                                <button type="submit" name="delete_brand_btn" style="border: none; background: none; padding: 0; cursor: pointer;">
                                                    <i class="bi bi-trash text-danger fs-4"></i>
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->
<?php
include('includes/footer.php')
?>