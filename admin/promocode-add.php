<?php
include('../middleware/adminMiddleware.php');
include('includes/header.php');
?>

<style>
    .breadcrumb {
        display: flex;
        justify-content: space-between;
    }
    .code-generation-options {
        margin-top: 10px;
    }
    .code-preview {
        margin-top: 10px;
        padding: 10px;
        background-color: #f8f9fa;
        border-radius: 4px;
        display: none;
    }
</style>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Add Promo Code</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item">Promo Codes</li>
                <li class="breadcrumb-item active">Add Promo Code</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add New Promo Code</h5>

                        <form action="code.php" method="POST" enctype="multipart/form-data" class="row g-3">
                            <div class="row mb-3">
                                <label for="code" class="col-sm-2 col-form-label">Promo Code</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="code" name="code" required>
                                        <button type="button" class="btn btn-outline-secondary" id="generateCode">Generate</button>
                                    </div>
                                    <div class="code-generation-options">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="code_type" id="autoCode" value="auto" checked>
                                            <label class="form-check-label" for="autoCode">Auto Generate</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="code_type" id="manualCode" value="manual">
                                            <label class="form-check-label" for="manualCode">Manual Input</label>
                                        </div>
                                    </div>
                                    <div class="code-preview" id="codePreview">
                                        <small class="text-muted">Generated code preview</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="discount_type" class="col-sm-2 col-form-label">Discount Type</label>
                                <div class="col-sm-10">
                                    <select class="form-select" id="discount_type" name="discount_type" required>
                                        <option value="">Select Discount Type</option>
                                        <option value="percentage">Percentage</option>
                                        <option value="fixed">Fixed Amount</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="discount_value" class="col-sm-2 col-form-label">Discount Value</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="discount_value" name="discount_value" step="0.01" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="min_purchase" class="col-sm-2 col-form-label">Minimum Purchase</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="min_purchase" name="min_purchase" step="0.01" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="max_discount" class="col-sm-2 col-form-label">Maximum Discount</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="max_discount" name="max_discount" step="0.01">
                                    <small class="text-muted">Leave empty for no limit</small>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="start_date" class="col-sm-2 col-form-label">Start Date</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="end_date" class="col-sm-2 col-form-label">End Date</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" id="end_date" name="end_date" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="usage_limit" class="col-sm-2 col-form-label">Usage Limit</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="usage_limit" name="usage_limit">
                                    <small class="text-muted">Leave empty for unlimited usage</small>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="status" class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10">
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" name="add_promocode_btn" class="btn btn-primary">Add Promo Code</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const codeInput = document.getElementById('code');
    const generateBtn = document.getElementById('generateCode');
    const autoCodeRadio = document.getElementById('autoCode');
    const manualCodeRadio = document.getElementById('manualCode');
    const codePreview = document.getElementById('codePreview');

    // Function to generate a random promo code
    function generatePromoCode() {
        const prefix = 'PROMO';
        const timestamp = Date.now().toString().slice(-4);
        const random = Math.random().toString(36).substring(2, 6).toUpperCase();
        return `${prefix}${timestamp}${random}`;
    }

    // Handle code type radio buttons
    autoCodeRadio.addEventListener('change', function() {
        if (this.checked) {
            codeInput.readOnly = true;
            generateBtn.disabled = false;
            const generatedCode = generatePromoCode();
            codeInput.value = generatedCode;
            codePreview.textContent = `Generated code: ${generatedCode}`;
            codePreview.style.display = 'block';
        }
    });

    manualCodeRadio.addEventListener('change', function() {
        if (this.checked) {
            codeInput.readOnly = false;
            generateBtn.disabled = true;
            codeInput.value = '';
            codePreview.style.display = 'none';
        }
    });

    // Handle generate button click
    generateBtn.addEventListener('click', function() {
        if (autoCodeRadio.checked) {
            const generatedCode = generatePromoCode();
            codeInput.value = generatedCode;
            codePreview.textContent = `Generated code: ${generatedCode}`;
            codePreview.style.display = 'block';
        }
    });

    // Initialize with auto-generated code
    const initialCode = generatePromoCode();
    codeInput.value = initialCode;
    codePreview.textContent = `Generated code: ${initialCode}`;
    codePreview.style.display = 'block';

    // Update end_date minimum when start_date changes
    document.getElementById('start_date').addEventListener('change', function() {
        document.getElementById('end_date').min = this.value;
    });

    // Validate discount value based on type
    document.getElementById('discount_type').addEventListener('change', function() {
        const discountValue = document.getElementById('discount_value');
        if (this.value === 'percentage') {
            discountValue.max = '100';
            discountValue.placeholder = 'Enter percentage (0-100)';
        } else {
            discountValue.removeAttribute('max');
            discountValue.placeholder = 'Enter amount';
        }
    });

    // Handle form submission
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        $.ajax({
            url: 'code.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                const res = JSON.parse(response);
                if (res.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: res.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = 'promocodes.php';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: res.message
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'An error occurred while processing your request.'
                });
            }
        });
    });
});
</script>

<?php include('includes/footer.php'); ?>