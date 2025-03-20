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
        <h1>Edit product</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Edit product Forms</li>
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
                <?php
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $product = getByID("products", $_GET['id']);

                    if (mysqli_num_rows($product) > 0) {
                        $data = mysqli_fetch_assoc($product);

                ?>

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
                                                    <option value="<?= $item['name'] ?>" <?= ($data['category_name'] == $item['name']) ? 'selected' : '' ?>>
                                                        <?= $item['name'] ?>
                                                    </option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <input type="hidden" name="product_id" value="<?= $data['id']; ?>">

                                    <!--rating-->
                                    <div class="col-md-3">
                                        <label for="inputRating" class="form-label">Rating</label>
                                        <select class="form-select" id="inputRating" name="rating">
                                            <option selected>Select Rating</option>
                                            <?php
                                            $ratings = [1, 2, 3, 4, 5]; // Assuming ratings are numeric values

                                            foreach ($ratings as $value) {
                                            ?>
                                                <option value="<?= $value ?>" <?= ($data['rating'] == $value) ? 'selected' : '' ?>>
                                                    <?= $value ?> Star
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <!-- Status -->
                                    <div class="col-md-3">
                                        <label for="inputStatus" class="form-label">Status</label>
                                        <select class="form-select" id="inputStatus" name="status">
                                            <option value="1" <?= ($data['status'] == 1) ? 'selected' : '' ?>>Active</option>
                                            <option value="0" <?= ($data['status'] == 0) ? 'selected' : '' ?>>Inactive</option>
                                        </select>
                                    </div>


                                    <!-- Select Discount Type in Percentage -->
                                    <div class="col-md-3">
                                        <label for="inputDiscountType" class="form-label">Select Discount Type</label>
                                        <select class="form-select" id="inputDiscountType" name="discount">
                                            <option selected>Select Discount Type</option>
                                            <?php
                                            for ($i = 1; $i <= 100; $i++) {
                                            ?>
                                                <option value="<?= $i ?>" <?= ($data['discount'] == $i) ? 'selected' : '' ?>>
                                                    <?= $i ?>%
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>


                                    <!-- Select Discount Type in Percentage -->
                                    <div class="col-md-6">
                                        <label for="inputName" class="form-label">Product Name</label>
                                        <input type="text" class="form-control" name="product_name" value="<?= $data['product_name']; ?>">
                                    </div>
                                    <!--featured to show selected ,best_selling, new_arrival, trending, populer and featured -->
                                    <div class="col-md-6">
                                        <label for="inputFeautered" class="form-label">Select Featured</label>
                                        <select class="form-select" id="inputFeautered" name="featured">
                                            <option selected>Select Featured</option>
                                            <?php
                                            $features = ['new', 'best_selling', 'trending', 'populer', 'featured']; // Assuming features are string values

                                            foreach ($features as $value) {
                                            ?>
                                                <option value="<?= $value ?>" <?= ($data['featured'] == $value) ? 'selected' : '' ?>>
                                                    <?= ucfirst($value) ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="inputDescription" class="form-label">Description</label>
                                        <textarea class="form-control" name="description" rows="4"><?= $data['description']; ?></textarea>
                                    </div>
                                    <!-- Original Price -->
                                    <div class="col-md-3">
                                        <label for="original_price" class="form-label">Original Price</label>
                                        <input type="number" class="form-control" id="original_price" name="original_price" placeholder="Enter original price" value="<?= $data['original_price']; ?>">
                                    </div>
                                    <!--sellin price-->
                                    <div class="col-md-3">
                                        <label for="original_price" class="form-label">Selling Price</label>
                                        <input type="number" class="form-control" id="selling_price" name="selling_price" placeholder="Enter Selling price" value="<?= $data['selling_price']; ?>">
                                    </div>
                                    <!-- Apply Discount Button -->
                                    <div class="col-md-3">
                                        <button type="button" id="applyDiscountBtn" class="btn btn-info mt-4">
                                            Apply Discount
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputImage" class="form-label">Image</label>
                                        <div class="input-group">
                                            <input type="file" class="form-control" name="image" id="inputImage" aria-describedby="inputImageAddon">
                                            <label class="input-group-text" for="currentImage" id="inputImageAddon">Upload</label>
                                        </div>
                                        <input type="hidden" name="old_image" value="<?= $data['image'] ?>">
                                        <input type="hidden" name="old_image" value="<?= $data['image'] ?>">
                                        <img src="../uploads/shop/<?= $data['image'] ?>" alt="<?= $data['product_name'] ?>" width="100" height="50">
                                        <small class="form-text text-muted">This is your current image.</small>
                                    </div>


                                    <!--quantity-->
                                    <div class="col-md-6">
                                        <label for="inputQuantity" class="form-label">Quantity</label>
                                        <input type="number" class="form-control" id="inputQuantity" name="quantity" placeholder="Enter Quantity" value="<?= $data['quantity'] ?>">
                                    </div>

                                    <!-- Trending -->
                                    <div class="col-md-6">
                                        <label for="inputTrending" class="form-label">Trending</label>
                                        <select class="form-select" id="inputTrending" name="trending">
                                            <option value="1" <?= ($data['trending'] == 1) ? 'selected' : '' ?>>Active</option>
                                            <option value="0" <?= ($data['trending'] == 0) ? 'selected' : '' ?>>Inactive</option>
                                        </select>
                                    </div>


                            </div>

                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary" name="update_product_btn">Update</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                            </form>
                            <!-- End Multi Columns Form -->
                        </div>

                <?php
                    } else {
                        echo "<h4 class='text-center'>No Record Found</h4>";
                    }
                } else {
                    echo "id missing from the url";
                }

                ?>

            </div>

        </div>
        </div>
    </section>

</main><!-- End #main -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    var discountSelect = document.getElementById('inputDiscountType');
    var originalPriceInput = document.getElementById('original_price');
    var sellingPriceInput = document.getElementById('selling_price');
    var applyDiscountBtn = document.getElementById('applyDiscountBtn');
    var discountApplied = false;

    function updateSellingPrice() {
        var discount = parseFloat(discountSelect.value) || 0;
        var originalPrice = parseFloat(originalPriceInput.value) || 0;
        if (originalPrice > 0) {
            var discountAmount = originalPrice * (discount / 100);
            var newSellingPrice = originalPrice - discountAmount;
            // Round to nearest whole number
            sellingPriceInput.value = Math.round(newSellingPrice);
        }
    }

    // When discount selection changes, if discount was already applied,
    // update the button text to indicate that a new discount is selected.
    discountSelect.addEventListener("change", function() {
        if (discountApplied) {
            applyDiscountBtn.textContent = 'Apply new selected discount';
            // Remove applied discount by resetting the selling price to original
            sellingPriceInput.value = Math.round(parseFloat(originalPriceInput.value) || 0);
            discountApplied = false;
        }
    });

    applyDiscountBtn.addEventListener("click", function() {
        if (!discountApplied) {
            // Validate original price and discount selection
            var originalPrice = parseFloat(originalPriceInput.value) || 0;
            var discount = parseFloat(discountSelect.value) || 0;
            if (originalPrice <= 0 || discount <= 0) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Please enter a valid original price and select a discount.',
                    showConfirmButton: false,
                    timer: 2000,
                    toast: true,
                    width: 'auto',
                    padding: '0.1em',
                    background: 'white',
                    customClass: {
                        popup: 'small-swal'
                    }
                });
                return;
            }

            // Simulate a loading state when applying discount
            applyDiscountBtn.disabled = true;
            applyDiscountBtn.textContent = 'Applying Discount...';
            setTimeout(function() {
                updateSellingPrice();
                discountApplied = true;
                applyDiscountBtn.textContent = 'Remove Discount';
                applyDiscountBtn.disabled = false;
            }, 1000);
        } else {
            // Simulate a loading state when removing discount
            applyDiscountBtn.disabled = true;
            applyDiscountBtn.textContent = 'Removing Discount...';
            setTimeout(function() {
                // Reset selling price to the original price (no discount)
                sellingPriceInput.value = Math.round(parseFloat(originalPriceInput.value) || 0);
                discountApplied = false;
                applyDiscountBtn.textContent = 'Apply Discount';
                applyDiscountBtn.disabled = false;
            }, 1000);
        }
    });
});
</script>

<?php
include('includes/footer.php')
?>