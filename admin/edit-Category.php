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
        <h1>Category Add</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Edit Category</li>
                <li class="breadcrumb-item">Forms</li>
                <li class="breadcrumb-item active"><a href="index.php">home</a></li>
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
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="inputStatus" name="status" <?= $data['status'] ? 'checked' : '' ?> value="1">
                                            <label class="form-check-label" for="inputStatus">Active</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="inputPopularity" class="form-label">Popularity</label>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="inputPopularity" name="popularity" <?= $data['popularity'] ? "checked" : "" ?>>
                                            <label class="form-check-label" for="inputPopularity">Popular</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="inputImage" class="form-label">Image</label>
                                        <div class="input-group">
                                            <input type="file" class="form-control" name="image" id="inputImage" aria-describedby="inputImageAddon">
                                            <label class="input-group-text" for="current image" id="inputImageAddon">Upload</label>
                                        </div>
                                        <input type="hidden" name="old_image" value="<?=$data['image']?>">
                                        <img src="../uploads/<?= $data['image'] ?>" alt="<?= $data['name'] ?>" width="100" height="50">
                                        <small class="form-text text-muted">These is your old image.</small>
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