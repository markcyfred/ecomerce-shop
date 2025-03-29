<?php
include('../middleware/adminMiddleware.php');
include('includes/header.php');
?>

<style>
    .breadcrumb {
        display: flex;
        justify-content: space-between;
    }

    /* Hide the Zip For Me upload form initially */
    #zipUploadForm {
        display: none;
        margin-top: 20px;
    }

    /* Place the Zip For Me button in the top right */
    .zip-for-me-btn {
        float: right;
        margin: 10px 0;
    }

    /* Style for processing message */
    #processingMsg {
        display: none;
        margin-top: 20px;
        font-weight: bold;
        color: #007bff;
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
        <h1>View Products</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">View Products Forms</li>
                <li class="breadcrumb-item">
                    <a href="products-add.php" title="Add new Product">
                        <i class="ri-menu-add-line"></i> Add Product
                    </a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="index.php">
                        <i class="ri-arrow-go-back-fill"></i> Home
                    </a>
                </li>
            </ol>
        </nav>

    </div><!-- End Page Title -->


    <!-- Bulk Upload Edit Section (visible by default) -->
    <div id="bulkUploadSection">
        <form action="bulk.php" method="POST" enctype="multipart/form-data">
            <?php if (isset($_SESSION['message'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?= $_SESSION['message'] ?>
                </div>
            <?php unset($_SESSION['message']);
            } ?>
            <div class="row">
                <div class="col-md-6">
                    <label for="excel_file" class="form-label">Bulk Upload Edit (CSV/Excel File)</label>
                    <input type="file" class="form-control" id="excel_file" name="excel_file" accept=".csv, .xlsx">
                </div>
                <div class="col-md-6">
                    <label for="imageUpload" class="form-label">Upload Product Images (ZIP File)</label>
                    <input type="file" class="form-control" id="imageUpload" name="images_zip_edited" accept=".zip">
                    <small class="text-danger">Images should be named as per the product name in the Excel.</small>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary" name="bulk_edit_btn">Bulk Upload Edit</button>
            </div>
        </form>
    </div>
    <!-- Bulk Export Form -->
    <form id="bulkEditForm" method="post" action="export_bulk_edit.php">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">All Products</h5>
                <button type="submit" name="bulk_edit_export_btn" class="btn btn-primary">
                    Export Selected for Bulk Edit
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="selectAll">
                                </th>
                                <th>#</th>
                                <th>Category</th>
                                <th>Rating</th>
                                <th>Status</th>
                                <th>Discount</th>
                                <th>Product</th>
                                <th>Selling</th>
                                <th>Image</th>
                                <th>Trending</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $products = mysqli_query($conn, "SELECT * FROM products ORDER BY created_at DESC");
                            if (mysqli_num_rows($products) > 0) {
                                foreach ($products as $item) {
                            ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="bulk-checkbox" name="selected_products[]" value="<?= $item['id']; ?>">
                                        </td>
                                        <th><?= $item['id']; ?></th>
                                        <td><?= (strlen($item['category_name']) > 5) ? substr($item['category_name'], 0, 5) . '..' : $item['category_name']; ?></td>
                                        <td>
                                            <?php
                                            $rating = $item['rating'];
                                            for ($i = 1; $i <= 5; $i++) {
                                                echo ($i <= $rating) ? '<i class="bi bi-star-fill" style="font-size: 0.5rem;color:#1bbd36;"></i>' : '<i class="bi bi-star" style="font-size: 0.5rem;color:#1bbd36;"></i>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php if ($item['status'] == 1) : ?>
                                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span>
                                            <?php else : ?>
                                                <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i> Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $item['discount'] . '%'; ?></td>
                                        <td><?= (strlen($item['product_name']) > 5) ? substr($item['product_name'], 0, 5) . '..' : $item['product_name']; ?></td>
                                        <td><?= 'Ksh ' . number_format($item['selling_price']); ?></td>
                                        <td>
                                            <img src="../uploads/shop/<?= $item['image']; ?>" alt="<?= $item['product_name']; ?>" width="100" height="100" style="border: 1px solid #a5c5fe;">
                                        </td>
                                        <td>
                                            <?php if ($item['trending'] == 1) : ?>
                                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span>
                                            <?php else : ?>
                                                <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i> Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <!-- Separate delete button (outside the bulk export form) -->
                                            <a href="edit-product.php?id=<?= $item['id']; ?>" class="text-primary me-2"><i class="ri-edit-2-fill fs-4"></i></a>
                                            <a href="delete-product.php?id=<?= $item['id']; ?>" class="text-danger delete-btn">
                                                <i class="bi bi-trash fs-4"></i>
                                            </a>
                                            <script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    // Attach event listener to all delete buttons
                                                    document.querySelectorAll('.delete-btn').forEach(function(button) {
                                                        button.addEventListener('click', function(e) {
                                                            e.preventDefault(); // Prevent the default link action
                                                            const deleteUrl = this.getAttribute('href');

                                                            Swal.fire({
                                                                title: 'Are you sure?',
                                                                text: "This action cannot be undone!",
                                                                icon: 'warning',
                                                                showCancelButton: true,
                                                                confirmButtonColor: '#3085d6',
                                                                cancelButtonColor: '#d33',
                                                                confirmButtonText: 'Yes, delete it!'
                                                            }).then((result) => {
                                                                if (result.isConfirmed) {
                                                                    // Redirect to the delete URL if confirmed
                                                                    window.location.href = deleteUrl;
                                                                }
                                                            });
                                                        });
                                                    });
                                                });
                                            </script>


                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='11'>No record found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>



    <script>
        // Toggle the visibility of the two forms when the "Zip For Me" button is clicked
        document.getElementById('toggleZipUpload').addEventListener('click', function() {
            var bulkSection = document.getElementById('bulkUploadSection');
            var zipForm = document.getElementById('zipUploadForm');
            if (zipForm.style.display === "block") {
                zipForm.style.display = "none";
                bulkSection.style.display = "block";
            } else {
                bulkSection.style.display = "none";
                zipForm.style.display = "block";
            }
        });

        // "Select All" checkbox script
        document.getElementById('selectAll').addEventListener('change', function() {
            let checkboxes = document.querySelectorAll('.bulk-checkbox');
            for (let checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });

        // Show processing message on form submit for Zip For Me
        function showProcessingMsg() {
            document.getElementById('processingMsg').style.display = "block";
        }
    </script>
</main><!-- End #main -->

<?php
include('includes/footer.php');
?>