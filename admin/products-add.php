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
<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<?php
if (isset($_SESSION['message'])) {
  $icon = ($_SESSION['messageType'] == 'success') ? 'success' : 'error';
?>
  <script>
    Swal.fire({
      position: 'top-end',
      icon: '<?php echo $icon; ?>',
      title: '<?php echo $_SESSION['message']; ?>',
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
  </script>
<?php
  unset($_SESSION['message']); // unset the session message after displaying
  unset($_SESSION['messageType']); // unset the session message type after displaying
}
?>
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
                        <!-- Bulk Upload Form -->
                        <div class="bulk-upload-container" style="text-align: center; margin-bottom: 20px;">
                            <!-- Download Template Button -->
                            <a href="download_template.php" class="btn btn-success">Download Excel Template</a>

                            <br><br>
                            <!-- Bulk Upload Form -->
                            <form action="bulk.php" method="POST" enctype="multipart/form-data">
                                <label for="bulkUpload" class="form-label">Bulk Upload (CSV/Excel File)</label>
                                <input type="file" class="form-control" id="bulkUpload" name="bulk_file" accept=".csv, .xlsx" >

                                <br>

                                <label for="imageUpload" class="form-label">Upload Product Images (ZIP File)</label>
                                <!--USER NOTE THAT IMAGES SHOULD BE NAMED AS SAME TO PRODUCT NAME-->
                                <small class="text-danger">Note: Images should be named as same to product name in the excell</small>
                                <input type="file" class="form-control" id="imageUpload" name="image_zip" accept=".zip" >

                                <br>

                                <button type="submit" class="btn btn-primary" name="bulk_upload_btn">Bulk Upload</button>
                            </form>

                        </div>


                        <!-- Form add shop products -->
                        <form action="code.php" method="POST" enctype="multipart/form-data" class="row g-3">
                            <!-- Category, Rating, Status fields ... -->

                            <?php
                            if (isset($_SESSION['message'])) {
                            ?>
                                <div class="alert alert-success" role="alert">
                                    <?= $_SESSION['message'] ?>
                                </div>
                            <?php
                                unset($_SESSION['message']);
                            }
                            ?>

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
                            <div class="col-md-4">
                                <label for="inputName" class="form-label">Product Name</label>
                                <input type="text" class="form-control" name="product_name">
                            </div>
                            <!--product brand -->
                            <div class="col-md-4">
                                <label for="inputBrand" class="form-label">Select Brand</label>
                                <select class="form-select" id="inputBrand" name="brand_name">
                                    <option selected>Select Brand</option>
                                    <?php
                                    $brands = getAll("brands");
                                    if (mysqli_num_rows($brands) > 0) {
                                        foreach ($brands as $item) {
                                    ?>
                                            <option value="<?= $item['brand_name'] ?>"><?= $item['brand_name'] ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Select Size -->
                            <div class="col-md-4">
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
                            <div class="col-md-6">
                                <label for="brand_image" class="form-label">product Image</label>
                                <div class="drop-zone" id="dropZone">Drag & Drop Image Here</div>
                                <input type="file" class="form-control d-none" id="brand_image" name="image">
                                <br>

                            </div>

                            <!-- Select Brand -->

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
                            <!-- Deal of the Day Card -->
                            <div class="card my-4 shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">Deal of the Day Settings</h5>
                                </div>
                                <div class="card-body">
                                    <!-- Toggle Switch -->
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="dealOfTheDay" name="deal_of_day">
                                        <label class="form-check-label" for="dealOfTheDay">Enable Deal of the Day</label>
                                    </div>
                                    <!-- Deal Time Inputs (hidden by default) -->
                                    <div id="dealTimeInputs" style="display: none;">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="deal_start" class="form-label">Deal Start</label>
                                                <input type="datetime-local" class="form-control" id="deal_start" name="deal_start">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="deal_end" class="form-label">Deal End</label>
                                                <input type="datetime-local" class="form-control" id="deal_end" name="deal_end">
                                            </div>
                                        </div>
                                        <small class="text-muted">Note: You cannot select a date/time before the current moment.</small>
                                    </div>
                                </div>
                            </div>
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    const dealCheckbox = document.getElementById('dealOfTheDay');
                                    const dealInputs = document.getElementById('dealTimeInputs');
                                    const dealStartInput = document.getElementById('deal_start');
                                    const dealEndInput = document.getElementById('deal_end');

                                    // Function to get current date-time in format yyyy-MM-ddThh:mm
                                    function getCurrentDateTimeLocal() {
                                        const now = new Date();
                                        const localISO = new Date(now.getTime() - now.getTimezoneOffset() * 60000)
                                            .toISOString().slice(0, 16);
                                        return localISO;
                                    }

                                    // Toggle the visibility of deal time inputs and set min values
                                    dealCheckbox.addEventListener('change', function() {
                                        if (this.checked) {
                                            dealInputs.style.display = 'block';
                                            const nowLocal = getCurrentDateTimeLocal();
                                            dealStartInput.min = nowLocal;
                                            dealEndInput.min = nowLocal;
                                        } else {
                                            dealInputs.style.display = 'none';
                                            dealStartInput.value = '';
                                            dealEndInput.value = '';
                                        }
                                    });

                                    // Ensure the deal end is not earlier than the deal start
                                    dealStartInput.addEventListener('change', function() {
                                        if (this.value) {
                                            dealEndInput.min = this.value;
                                        }
                                    });
                                });
                            </script>


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