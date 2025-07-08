<?php
include('../middleware/adminMiddleware.php');
include('includes/header.php');

// Get promo code details
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "SELECT * FROM promocodes WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $promocode = mysqli_fetch_assoc($result);
    } else {
        $_SESSION['message'] = "Promo code not found!";
        $_SESSION['message_type'] = "danger";
        header('Location: promocodes.php');
        exit();
    }
} else {
    header('Location: promocodes.php');
    exit();
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Edit Promo Code</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item">Promo Codes</li>
                <li class="breadcrumb-item active">Edit Promo Code</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Promo Code</h5>

                        <form action="code.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="promocode_id" value="<?= $promocode['id']; ?>">
                            <div class="row mb-3">
                                <label for="code" class="col-sm-2 col-form-label">Promo Code</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="code" name="code" value="<?= $promocode['code']; ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="discount_type" class="col-sm-2 col-form-label">Discount Type</label>
                                <div class="col-sm-10">
                                    <select class="form-select" id="discount_type" name="discount_type" required>
                                        <option value="">Select Discount Type</option>
                                        <option value="percentage" <?= $promocode['discount_type'] == 'percentage' ? 'selected' : ''; ?>>Percentage</option>
                                        <option value="fixed" <?= $promocode['discount_type'] == 'fixed' ? 'selected' : ''; ?>>Fixed Amount</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="discount_value" class="col-sm-2 col-form-label">Discount Value</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="discount_value" name="discount_value" step="0.01" value="<?= $promocode['discount_value']; ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="min_purchase" class="col-sm-2 col-form-label">Minimum Purchase</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="min_purchase" name="min_purchase" step="0.01" value="<?= $promocode['min_purchase']; ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="max_discount" class="col-sm-2 col-form-label">Maximum Discount</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="max_discount" name="max_discount" step="0.01" value="<?= $promocode['max_discount']; ?>">
                                    <small class="text-muted">Leave empty for no limit</small>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="start_date" class="col-sm-2 col-form-label">Start Date</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" id="start_date" name="start_date" value="<?= date('Y-m-d', strtotime($promocode['start_date'])); ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="end_date" class="col-sm-2 col-form-label">End Date</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" id="end_date" name="end_date" value="<?= date('Y-m-d', strtotime($promocode['end_date'])); ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="usage_limit" class="col-sm-2 col-form-label">Usage Limit</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="usage_limit" name="usage_limit" value="<?= $promocode['usage_limit']; ?>">
                                    <small class="text-muted">Leave empty for unlimited usage</small>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="status" class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10">
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="1" <?= $promocode['status'] == 1 ? 'selected' : ''; ?>>Active</option>
                                        <option value="0" <?= $promocode['status'] == 0 ? 'selected' : ''; ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" name="update_promocode_btn" class="btn btn-primary">Update Promo Code</button>
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