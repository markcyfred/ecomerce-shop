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
        <h1>Add Products</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Add new Products</li>
                <li class="breadcrumb-item">Forms</li>
                <li class="breadcrumb-item active"><a href="index.php">home</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Fill out</h5>

                        <!-- Form add shop products -->
                        <form action="code.php" method="POST" enctype="multipart/form-data" class="row g-3">
                            <div class="col-md-3">
                                <label for="inputCategory" class="form-label">Select Category</label>
                                <select class="form-select" id="inputCategory" name="category_name">
                                    <option selected>Select Category</option>
                                    <?php
                                    $categories = getAll("categories");

                                    if (mysqli_num_rows($categories) > 0) {
                                        foreach ($categories as $item) {
                                    ?>
                                            <option value="<?= $item['name'] ?>"><?= $item['name'] ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <!--rating-->
                            <div class="col-md-3">
                                <label for="inputRating" class="form-label">Rating</label>
                                <select class="form-select" id="inputRating" name="rating">
                                    <option selected>Select Rating</option>
                                    <option value="1">1 Star</option>
                                    <option value="2">2 Star</option>
                                    <option value="3">3 Star</option>
                                    <option value="4">4 Star</option>
                                    <option value="5">5 Star</option>
                                </select>
                            </div>
                            <!-- Status -->
                            <div class="col-md-3">
                                <label for="inputStatus" class="form-label">Status</label>
                                <select class="form-select" id="inputStatus" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <!-- Select Discount Type in Percentage -->
                            <div class="col-md-3">
                                <label for="inputDiscountType" class="form-label">Select Discount Type</label>
                                <select class="form-select" id="inputDiscountType" name="discount">
                                    <option selected>Select Discount Type</option>
                                    <?php
                                    for ($i = 1; $i <= 100; $i++) {
                                        echo '<option value="' . $i . '">' . $i . '%</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Select Discount Type in Percentage -->
                            <div class="col-md-">
                                <label for="inputName" class="form-label">Product Name</label>
                                <input type="text" class="form-control" name="product_name">
                            </div>
                            <div class="col-md-12">
                                <label for="inputDescription" class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="4"></textarea>
                            </div>
                            <!-- Original Price -->
                            <div class="col-md-3">
                                <label for="original_price" class="form-label">Original Price</label>
                                <input type="number" class="form-control" id="original_price" name="original_price" placeholder="Enter original price">
                            </div>
                            <!--sellin price-->
                            <div class="col-md-3">
                                <label for="original_price" class="form-label">Selling Price</label>
                                <input type="number" class="form-control" id="selling_price" name="selling_price" placeholder="Enter Selling price">
                            </div>


                            <div class="col-md-6">
                                <label for="inputImage" class="form-label">Image</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" name="image" aria-describedby="inputImageAddon">
                                    <label class="input-group-text" for="inputImage" id="inputImageAddon">Upload</label>
                                </div>
                            </div>
                            <!--quantity-->
                            <div class="col-md-6">
                                <label for="inputQuantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="inputQuantity" name="quantity" placeholder="Enter Quantity">
                            </div>
                            <!-- Trending -->
                            <div class="col-md-6">
                                <label for="inputTrending" class="form-label">Status</label>
                                <select class="form-select" id="inputStatus" name="trending">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>


                    </div>

                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary" name="add_product_btn">Submit</button>
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