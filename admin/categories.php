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
        <h1>View categories</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">View categories Forms</li>
                <a href="add-category.php" title="Add new Category">
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
                                <th scope="col">Category name</th>
                                <th scope="col">Popularity</th>
                                <th scope="col">Image</th>
                                <th scope="col">Status</th>
                                <th scope="col">Description</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $category = getAll("categories");

                            if (mysqli_num_rows($category) > 0) {
                                foreach ($category as $item) {
                            ?>

                                    <tr>
                                        <th>
                                            <?= $item['id']; ?>
                                        </th>
                                        <td>
                                            <?= $item['name']; ?>
                                        </td>
                                        <td>
                                            <?php if ($item['popularity'] == 1) : ?>
                                                <span style="font-size: 15px;" class="badge border-primary border-1 p-2 text-primary">Populer</span>
                                            <?php else : ?>
                                                <span style="font-size: 15px;" class="badge border-warning border-1 text-warning">Not Populer</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <img src="../uploads/<?= $item['image']; ?>" alt="<?= $item['name']; ?>" width="100" height="100">
                                        </td>
                                        <td>
                                            <?php if ($item['status'] == 1) : ?>
                                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span>
                                            <?php else : ?>
                                                <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i> Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?= $item['description']; ?>
                                        </td>
                                        <td>
                                            <a href="edit-Category.php?id=<?= $item['id']; ?>" class="text-primary me-2">
                                                <i class="ri-edit-2-fill fs-4"></i>
                                            </a>
                                            <form action="code.php" method="POST" style="display: inline;">
                                                <input type="hidden" name="category_id" value="<?= $item['id']; ?>">
                                                <button type="submit" name="delete_category_btn" style="border: none; background: none; padding: 0; cursor: pointer;">
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
    </section>

</main><!-- End #main -->
<?php
include('includes/footer.php')
?>