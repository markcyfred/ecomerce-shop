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
        <h1>Category Add</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Add Category Forms</li>
                <a href="categories.php" title="View categories">
                    <i class=" ri-eye-line"></i> View categories
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
                        <h5 class="card-title">Fill out</h5>
                        <form action="code.php" method="POST" enctype="multipart/form-data" class="row g-3">
                            <div class="col-md-6">
                                <label for="inputName" class="form-label">Category Name</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                            <div class="col-md-6">
                                <label for="inputSlug" class="form-label">Category Slug</label>
                                <input type="text" class="form-control" name="slug">
                            </div>
                            <div class="col-md-12">
                                <label for="inputDescription" class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="4"></textarea>
                            </div>
                            <!-- Status -->
                            <div class="col-md-6">
                                <label for="inputStatus" class="form-label">Status</label>
                                <select class="form-select" id="inputStatus" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <!-- Popularity -->
                            <div class="col-md-6">
                                <label for="inputPopularity" class="form-label">Popularity</label>
                                <select class="form-select" id="inputPopularity" name="popularity">
                                    <option value="1">Popular</option>
                                    <option value="0">Not Popular</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="inputImage" class="form-label">Image</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" name="image" aria-describedby="inputImageAddon">
                                    <label class="input-group-text" for="inputImage" id="inputImageAddon">Upload</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="inputMetaTitle" class="form-label">Meta Title</label>
                                <input type="text" class="form-control" name="meta_title">
                            </div>
                            <div class="col-md-12">
                                <label for="inputMetaDescription" class="form-label">Meta Description</label>
                                <textarea class="form-control" name="meta_description" rows="4"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="inputMetaKeywords" class="form-label">Meta Keywords</label>
                                <input type="text" class="form-control" name="meta_keywords">
                            </div>
                            <!--size for clothers for shoes -->
                            <div class="col-md-6">
                                <label for="inputSize" class="form-label">Size</label>
                                <input type="text" class="form-control" name="size">
                            </div>
                            
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary" name="add_category_btn">Submit</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form>
                        <!-- End Multi Columns Form -->
                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->
<?php
include('includes/footer.php')
?>