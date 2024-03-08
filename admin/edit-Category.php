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
        <h1>Edit Category</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Edit Category Forms</li>
                <a href="add-category.php" title="Add new category">
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
                <?php
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $category = getByID("categories", $id);

                    if (mysqli_num_rows($category) > 0) {
                        $data = mysqli_fetch_array($category);


                ?>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Fill out</h5>

                                <!-- Category Columns Form name slug description status popularity image meta_title meta_description meta_keywords -->
                                <form action="code.php" method="POST" enctype="multipart/form-data" class="row g-3">
                                    <input type="hidden" name="category_id" value="<?= $data['id'] ?>">
                                    <div class="col-md-6">
                                        <label for="inputName" class="form-label">Category Name</label>
                                        <input type="text" class="form-control" name="name" value="<?= $data['name'] ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputSlug" class="form-label">Category Slug</label>
                                        <input type="text" class="form-control" name="slug" value="<?= $data['slug'] ?>">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="inputDescription" class="form-label">Description</label>
                                        <textarea class="form-control" name="description" rows="4"><?= $data['description'] ?></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputStatus" class="form-label">Status</label>
                                        <div class="input-group">
                                            <select class="form-control" id="inputStatus" name="status">
                                                <option value="1" <?= $data['status'] == 1 ? 'selected' : '' ?>>Active</option>
                                                <option value="0" <?= $data['status'] == 0 ? 'selected' : '' ?>>Inactive</option>
                                            </select>
                                            <span class="badge bg-success">
                                                <?= $data['status'] == 1 ? '<span style="margin-top: 5px; display: inline-block;">Active</span>' : 'Inactive' ?>
                                            </span>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <label for="inputPopularity" class="form-label">Popularity</label>
                                        <div class="input-group">
                                            <select class="form-control" id="inputPopularity" name="popularity">
                                                <option value="1" <?= $data['popularity'] == 1 ? 'selected' : '' ?>>Popular</option>
                                                <option value="0" <?= $data['popularity'] == 0 ? 'selected' : '' ?>>Not Popular</option>
                                            </select>
                                            <span class="badge bg-warning text-dark">
                                                <?= $data['popularity'] == 1 ? '<span style="margin-top: 5px; display: inline-block;">Popular</span>' : 'Not Popular' ?>
                                            </span>
                                        </div>
                                    </div>



                                    <div class="col-md-6">
                                        <label for="inputImage" class="form-label">Image</label>
                                        <div class="input-group">
                                            <input type="file" class="form-control" name="image" id="inputImage" aria-describedby="inputImageAddon">
                                            <label class="input-group-text" for="current image" id="inputImageAddon">Upload</label>
                                        </div>
                                        <input type="hidden" name="old_image" value="<?= $data['image'] ?>">
                                        <img src="../uploads/<?= $data['image'] ?>" alt="<?= $data['name'] ?>" width="100" height="50">
                                        <small class="form-text text-muted">These is your current image.</small>
                                    </div>


                                    <div class="col-md-6">
                                        <label for="inputMetaTitle" class="form-label">Meta Title</label>
                                        <input type="text" class="form-control" name="meta_title" value="<?= $data['meta_title'] ?>">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="inputMetaDescription" class="form-label">Meta Description</label>
                                        <textarea class="form-control" name="meta_description" rows="4"> <?= $data['meta_description'] ?></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputMetaKeywords" class="form-label">Meta Keywords</label>
                                        <input type="text" class="form-control" name="meta_keywords" value="<?= $data['meta_keywords'] ?>">
                                    </div>
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary" name="update_category_btn">Update</button>
                                    </div>
                                </form>
                                <!-- End Multi Columns Form -->
                            </div>
                        </div>
                <?php
                    } else {
                        echo "category not found";
                    }
                } else {
                    echo "id not found";
                }
                ?>
            </div>
        </div>
    </section>

</main><!-- End #main -->
<?php
include('includes/footer.php')
?>