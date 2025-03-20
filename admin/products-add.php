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
        <h1>Products Add</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Add Products Forms</li>
                <a href="products.php" title="View products">
                    <i class="ri-eye-line"></i> View products
                </a>
                <li class="breadcrumb-item active">
                    <a href="index.php">
                        <i class="ri-arrow-go-back-fill"></i> home</a>
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

                        <!-- Form add shop products -->
                        <form action="code.php" method="POST" enctype="multipart/form-data" class="row g-3">
                            <!-- Category, Rating, Status fields ... -->
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

                            <!-- Rating -->
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



                            <!-- Product Name -->
                            <div class="col-md-6">
                                <label for="inputName" class="form-label">Product Name</label>
                                <input type="text" class="form-control" name="product_name">
                            </div>

                            <!-- Select Size -->
                            <div class="col-md-6">
                                <label for="inputSize" class="form-label">Select Size</label>
                                <select class="form-select" id="inputSize" name="size">
                                    <option selected>Select Size</option>
                                    <option value="small">Small</option>
                                    <option value="medium">Medium</option>
                                    <option value="large">Large</option>
                                    <option value="x-large">X-Large</option>
                                </select>
                            </div>

                            <!-- Select Featured -->
                            <div class="col-md-6">
                                <label for="inputFeautered" class="form-label">Select Featured</label>
                                <select class="form-select" id="inputFeautered" name="featured">
                                    <option selected>Select Featured</option>
                                    <option value="new">New</option>
                                    <option value="best_selling">Best Selling</option>
                                    <option value="trending">Trending</option>
                                    <option value="popular">Popular</option>
                                    <option value="featured">Featured</option>
                                </select>
                            </div>

                            <!-- Description -->
                            <div class="col-md-12">
                                <label for="inputDescription" class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="4"></textarea>
                            </div>

                            <!-- Original Price -->
                            <div class="col-md-3">
                                <label for="original_price" class="form-label">Original Price</label>
                                <input type="number" class="form-control" id="original_price" name="original_price" placeholder="Enter original price">
                            </div>

                            <!-- Selling Price -->
                            <div class="col-md-3">
                                <label for="selling_price" class="form-label">Selling Price</label>
                                <input type="number" class="form-control" id="selling_price" name="selling_price" placeholder="Enter selling price">
                            </div>
                            <!-- Apply Discount Button -->
                            <div class="col-md-3">
                                <button type="button" id="applyDiscountBtn" class="btn btn-info mt-4">
                                    Apply Discount
                                </button>
                            </div>
                            <!-- Image, Quantity, Trending fields ... -->
                            <div class="col-md-6">
                                <label for="inputImage" class="form-label">Image</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" name="image" aria-describedby="inputImageAddon">
                                    <label class="input-group-text" for="inputImage" id="inputImageAddon">Upload</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="inputQuantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="inputQuantity" name="quantity" placeholder="Enter Quantity">
                            </div>
                            <div class="col-md-6">
                                <label for="inputTrending" class="form-label">Status</label>
                                <select class="form-select" id="inputTrending" name="trending">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary" name="add_product_btn">Submit</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<?php
include('includes/footer.php');
?>
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
            applyDiscountBtn.textContent = 'Apply new discount';
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
