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
                    <i class="ri-menu-add-line"></i> <span>Add Product</span>
                </a>
                <li class="breadcrumb-item active">
                    <a href="index.php">
                        <i class="ri-arrow-go-back-fill"></i> home</a>
                </li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <?php
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $product = getByID("products", $id);
                    if (mysqli_num_rows($product) > 0) {
                        $data = mysqli_fetch_assoc($product);
                        // A deal exists if both deal_start and deal_end are not empty.
                        $isDeal = (!empty($data['deal_start']) && !empty($data['deal_end']));
                        // Use existing deal_of_day_status if set.
                        $existingStatus = isset($data['deal_of_day_status']) ? $data['deal_of_day_status'] : "";
                        // Set limit_type for Sale Out Limit
                        $limit_type = (isset($data['sale_out_limit']) && $data['sale_out_limit'] !== null && $data['sale_out_limit'] !== '') ? 'number' : 'none';
                ?>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Fill out</h5>
                                <form action="code.php" method="POST" enctype="multipart/form-data" class="row g-3">
                                    <input type="hidden" name="product_id" value="<?= $data['id']; ?>">
                                    <!-- Category -->
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
                                    <!-- Rating -->
                                    <div class="col-md-3">
                                        <label for="inputRating" class="form-label">Rating</label>
                                        <select class="form-select" id="inputRating" name="rating">
                                            <option selected>Select Rating</option>
                                            <?php
                                            $ratings = [1, 2, 3, 4, 5];
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
                                    <!-- Discount -->
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
                                    <!-- Product Name -->
                                    <div class="col-md-4">
                                        <label for="inputName" class="form-label">Product Name</label>
                                        <input type="text" class="form-control" name="product_name" value="<?= $data['product_name']; ?>">
                                    </div>
                                    <!--PRODUCT BRAND-->
                                    <div class="col-md-4">
                                        <label for="inputBrand" class="form-label">Select Brand</label>
                                        <select class="form-select" id="inputBrand" name="brand_name">
                                            <option selected>Select Brand</option>
                                            <?php
                                            $brands = getAll("brands");
                                            if (mysqli_num_rows($brands) > 0) {
                                                foreach ($brands as $item) {
                                            ?>
                                                    <option value="<?= $item['brand_name'] ?>" <?= ($data['brand_name'] == $item['brand_name']) ? 'selected' : '' ?>>
                                                        <?= $item['brand_name'] ?>
                                                    </option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <!-- Featured -->
                                    <div class="col-md-4">
                                        <label for="inputFeautered" class="form-label">Select Featured</label>
                                        <select class="form-select" id="inputFeautered" name="featured">
                                            <option value="">Select Featured</option>
                                            <?php
                                            $query = "SELECT DISTINCT featured FROM products WHERE featured IS NOT NULL AND featured != ''";
                                            $result = mysqli_query($conn, $query);

                                            if (mysqli_num_rows($result) > 0) {
                                                while ($tag = mysqli_fetch_assoc($result)) {
                                                    $tag_value = htmlspecialchars($tag['featured']);
                                                    $selected = ($data['featured'] == $tag_value) ? 'selected' : '';
                                                    echo "<option value=\"$tag_value\" $selected>" . ucfirst($tag_value) . "</option>";
                                                }
                                            } else {
                                                echo '<option disabled>No featured tags found</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <!-- Description -->
                                    <div class="col-md-12">
                                        <label for="inputDescription" class="form-label">Description</label>
                                        <textarea class="form-control" name="description" rows="4"><?= $data['description']; ?></textarea>
                                    </div>
                                    <!-- Original Price -->
                                    <div class="col-md-3">
                                        <label for="original_price" class="form-label">Original Price</label>
                                        <input type="number" class="form-control" id="original_price" name="original_price" placeholder="Enter original price" value="<?= $data['original_price']; ?>">
                                    </div>
                                    <!-- Selling Price -->
                                    <div class="col-md-3">
                                        <label for="selling_price" class="form-label">Selling Price</label>
                                        <input type="number" class="form-control" id="selling_price" name="selling_price" placeholder="Enter Selling price" value="<?= $data['selling_price']; ?>">
                                    </div>

                                    <!-- Apply Discount Button -->
                                    <div class="col-md-3">
                                        <button type="button" id="applyDiscountBtn" class="btn btn-info mt-4">Apply Discount</button>
                                    </div>
                                    <!-- Sale Out Limit -->
                                    <div class="mb-3 col-md-3">
                                        <label class="form-label">Sale Out Limit</label>
                                        <div class="input-group">
                                            <select class="form-select" id="limitType" name="limit_type" onchange="toggleSaleOutInput(this.value)">
                                                <option value="number" <?= $limit_type === 'number' ? 'selected' : ''; ?>>Set Limit</option>
                                                <option value="none" <?= $limit_type === 'none' ? 'selected' : ''; ?>>No Limit</option>
                                            </select>
                                            <input id="inputSaleOutLimit" type="number" name="sale_out_limit" class="form-control" placeholder="Enter Limit"
                                                value="<?= $limit_type === 'number' ? htmlspecialchars($data['sale_out_limit']) : ''; ?>"
                                                <?= $limit_type === 'none' ? 'disabled' : ''; ?>>
                                        </div>
                                        <small id="limitMessage" class="text-danger" style="display:none;"></small>
                                    </div>
                                    <script>
                                        function toggleSaleOutInput(value) {
                                            const limitInput = document.getElementById('inputSaleOutLimit');
                                            const message = document.getElementById('limitMessage');

                                            if (value === 'none') {
                                                limitInput.value = '';
                                                limitInput.disabled = true;
                                                message.style.display = 'none';
                                            } else {
                                                limitInput.disabled = false;
                                            }
                                        }

                                        function showLimitMessage(msg) {
                                            const message = document.getElementById('limitMessage');
                                            message.textContent = msg;
                                            message.style.display = 'block';
                                        }

                                        function clearLimitMessage() {
                                            const message = document.getElementById('limitMessage');
                                            message.textContent = '';
                                            message.style.display = 'none';
                                        }

                                        // Validate sale limit ≤ quantity
                                        document.getElementById('inputSaleOutLimit').addEventListener('input', function() {
                                            const limit = parseInt(this.value);
                                            const quantity = parseInt(document.getElementById('inputQuantity').value);

                                            if (!isNaN(limit) && !isNaN(quantity)) {
                                                if (limit > quantity) {
                                                    this.value = quantity;
                                                    showLimitMessage("Sale Out Limit cannot exceed the Quantity. Adjusted to match.");
                                                } else {
                                                    clearLimitMessage();
                                                }
                                            }
                                        });

                                        // Also update if quantity is changed
                                        document.getElementById('inputQuantity').addEventListener('input', function() {
                                            const quantity = parseInt(this.value);
                                            const limitInput = document.getElementById('inputSaleOutLimit');
                                            const limit = parseInt(limitInput.value);

                                            if (!isNaN(limit) && !isNaN(quantity)) {
                                                if (limit > quantity) {
                                                    limitInput.value = quantity;
                                                    showLimitMessage("Sale Out Limit adjusted to match new Quantity.");
                                                } else {
                                                    clearLimitMessage();
                                                }
                                            }
                                        });
                                    </script>



                                    <div class="row">
                                        <!-- Quantity -->
                                        <div class="col-md-4">
                                            <label for="inputQuantity" class="form-label">Quantity</label>
                                            <input type="number" class="form-control" id="inputQuantity" name="quantity" placeholder="Enter Quantity" value="<?= $data['quantity'] ?>">
                                        </div>

                                        <!-- Trending -->
                                        <div class="col-md-4">
                                            <label for="inputTrending" class="form-label">Trending</label>
                                            <select class="form-select" id="inputTrending" name="trending">
                                                <option value="1" <?= ($data['trending'] == 1) ? 'selected' : '' ?>>Active</option>
                                                <option value="0" <?= ($data['trending'] == 0) ? 'selected' : '' ?>>Inactive</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="inputSize" class="form-label">Shoe Size</label>
                                            <select class="form-select" id="inputSize" name="size">
                                                <option value="">Select Size</option>

                                                <!-- General Sizes -->
                                                <option value="small" <?= ($data['size'] == 'small') ? 'selected' : '' ?>>Small</option>
                                                <option value="medium" <?= ($data['size'] == 'medium') ? 'selected' : '' ?>>Medium</option>
                                                <option value="large" <?= ($data['size'] == 'large') ? 'selected' : '' ?>>Large</option>
                                                <option value="x-large" <?= ($data['size'] == 'x-large') ? 'selected' : '' ?>>X-Large</option>

                                                <optgroup label="Kids Sizes (EU)">
                                                    <?php
                                                    $kidsSizes = range(24, 35); // EU Kids sizes
                                                    foreach ($kidsSizes as $size) {
                                                        $selected = ($data['size'] == "EU $size") ? 'selected' : '';
                                                        echo "<option value=\"EU $size\" $selected>EU $size</option>";
                                                    }
                                                    ?>
                                                </optgroup>

                                                <optgroup label="Adult Sizes (EU)">
                                                    <?php
                                                    $adultSizes = range(36, 47); // EU Adult sizes
                                                    foreach ($adultSizes as $size) {
                                                        $selected = ($data['size'] == "EU $size") ? 'selected' : '';
                                                        echo "<option value=\"EU $size\" $selected>EU $size</option>";
                                                    }
                                                    ?>
                                                </optgroup>


                                            </select>
                                        </div>

                                        <!-- Existing Images Section -->
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Current Images</label>
                                            <div class="d-flex flex-wrap gap-3">
                                                <?php
                                                //select the images from the product_images table
                                                $productImages = mysqli_query($conn, "SELECT * FROM product_images WHERE product_id = '$id'");
                                                if (mysqli_num_rows($productImages) > 0) {
                                                    while ($image = mysqli_fetch_assoc($productImages)) {
                                                ?>
                                                        <div class="position-relative">
                                                            <img src="../<?= $image['image_path'] ?>" alt="Product Image" class="img-thumbnail" style="width: 150px; height: 150px;">
                                                            <a href="delete_img.php?id=<?= $image['id'] ?>&product_id=<?= $id ?>" class="btn btn-danger btn-sm position-absolute top-0 end-0" onclick="return confirm('Are you sure you want to delete this image?');">X</a>
                                                        </div>
                                                <?php
                                                    }
                                                } else {
                                                    echo "<p>No images found for this product.</p>";
                                                }
                                                ?>

                                            </div>

                                            <!-- Multiple Image Upload -->


                                            <div class="col-md-6">
                                                <label for="brand_image" class="form-label">Upload Additional Images</label>
                                                <div class="drop-zone" id="dropZone">Drag & Drop Images Here or Click to Upload</div>
                                                <input type="file" class="form-control d-none" id="brand_image" name="images[]" multiple>
                                                <div id="fileList" class="mt-2 text-muted" style="font-size: 0.9rem;"></div>
                                            </div>
                                        </div>

                                        <!-- Deal of the Day Section -->
                                        <div class="col-12">
                                            <div class="card my-4 shadow-sm">
                                                <div class="card-header bg-primary text-white">
                                                    <h5 class="mb-0">Deal of the Day Settings</h5>
                                                </div>
                                                <div class="card-body">
                                                    <!-- Toggle Switch -->
                                                    <div class="form-check form-switch mb-3">
                                                        <input class="form-check-input" type="checkbox" id="dealOfTheDay" name="deal_of_day" <?= ($isDeal) ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="dealOfTheDay">Enable Deal of the Day</label>
                                                    </div>
                                                    <!-- Deal Time Inputs -->
                                                    <div id="dealTimeInputs" style="display: <?= ($isDeal) ? 'block' : 'none'; ?>;">
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <label for="deal_start" class="form-label">Deal Start</label>
                                                                <input type="datetime-local" class="form-control" id="deal_start" name="deal_start" value="<?= ($isDeal) ? date('Y-m-d\TH:i', strtotime($data['deal_start'])) : ''; ?>">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="deal_end" class="form-label">Deal End</label>
                                                                <input type="datetime-local" class="form-control" id="deal_end" name="deal_end" value="<?= ($isDeal) ? date('Y-m-d\TH:i', strtotime($data['deal_end'])) : ''; ?>">
                                                            </div>
                                                        </div>
                                                        <small class="text-muted">Note: You cannot select a past date/time.</small>
                                                        <!-- Deal Status Dropdown -->
                                                        <div class="mt-3">
                                                            <label for="deal_status_select" class="form-label">Deal Status</label>
                                                            <select class="form-select" id="deal_status_select" name="deal_of_day_status">
                                                                <option value="" <?= ($existingStatus == "") ? 'selected' : '' ?>>Not Set</option>
                                                                <option value="open" <?= ($existingStatus == 'open') ? 'selected' : '' ?>>Open</option>
                                                                <option value="closed" <?= ($existingStatus == 'closed') ? 'selected' : '' ?>>Closed</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Submit / Reset -->
                                        <div class="col-12 text-center">
                                            <button type="submit" class="btn btn-primary" name="update_product_btn">Update</button>
                                            <button type="reset" class="btn btn-secondary">Reset</button>
                                        </div>
                                </form>
                                <!-- End Multi Columns Form -->
                            </div>
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
    </section>
</main>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Discount functionality (existing code)
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
                sellingPriceInput.value = Math.round(newSellingPrice);
            }
        }

        discountSelect.addEventListener("change", function() {
            if (discountApplied) {
                applyDiscountBtn.textContent = 'Apply new selected discount';
                sellingPriceInput.value = Math.round(parseFloat(originalPriceInput.value) || 0);
                discountApplied = false;
            }
        });

        applyDiscountBtn.addEventListener("click", function() {
            if (!discountApplied) {
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
                applyDiscountBtn.disabled = true;
                applyDiscountBtn.textContent = 'Applying Discount...';
                setTimeout(function() {
                    updateSellingPrice();
                    discountApplied = true;
                    applyDiscountBtn.textContent = 'Remove Discount';
                    applyDiscountBtn.disabled = false;
                }, 1000);
            } else {
                applyDiscountBtn.disabled = true;
                applyDiscountBtn.textContent = 'Removing Discount...';
                setTimeout(function() {
                    sellingPriceInput.value = Math.round(parseFloat(originalPriceInput.value) || 0);
                    discountApplied = false;
                    applyDiscountBtn.textContent = 'Apply Discount';
                    applyDiscountBtn.disabled = false;
                }, 1000);
            }
        });

        // Deal of the Day toggle functionality
        const dealCheckbox = document.getElementById('dealOfTheDay');
        const dealInputs = document.getElementById('dealTimeInputs');
        const dealStartInput = document.getElementById('deal_start');
        const dealEndInput = document.getElementById('deal_end');
        const dealStatusSelect = document.getElementById('deal_status_select');

        function getCurrentDateTimeLocal() {
            const now = new Date();
            return new Date(now.getTime() - now.getTimezoneOffset() * 60000).toISOString().slice(0, 16);
        }

        dealCheckbox.addEventListener('change', function() {
            if (this.checked) {
                dealInputs.style.display = 'block';
                const nowLocal = getCurrentDateTimeLocal();
                dealStartInput.min = nowLocal;
                dealEndInput.min = nowLocal;
                // If no status is set or if currently closed, default to open.
                if (dealStatusSelect.value === "" || dealStatusSelect.value === "closed") {
                    dealStatusSelect.value = "open";
                }
            } else {
                dealInputs.style.display = 'none';
                dealStartInput.value = '';
                dealEndInput.value = '';
                // When unchecked, automatically set status to closed.
                dealStatusSelect.value = "closed";
            }
        });

        dealStartInput.addEventListener('change', function() {
            if (this.value) {
                dealEndInput.min = this.value;
            }
        });
    });
</script>

<?php
include('includes/footer.php');
?>