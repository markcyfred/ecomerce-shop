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
        <h1>Promo Codes</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Promo Codes</li>
                <a href="promocode-add.php" title="Add new Promo Code">
                    <i class="ri-menu-add-line"></i> Add Promo Code
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
                        <h5 class="card-title">All Promo Codes</h5>

                        <!-- Table with stripped rows -->
                        <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Code</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Value</th>
                                        <th scope="col">Min Purchase</th>
                                        <th scope="col">Max Discount</th>
                                        <th scope="col">Start Date</th>
                                        <th scope="col">End Date</th>
                                        <th scope="col">Usage Limit</th>
                                        <th scope="col">Usage Count</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $promocodes = getAll("promocodes");

                                    if (mysqli_num_rows($promocodes) > 0) {
                                        foreach ($promocodes as $item) {
                                    ?>
                                            <tr>
                                                <td><?= $item['id']; ?></td>
                                                <td><?= $item['code']; ?></td>
                                                <td><?= ucfirst($item['discount_type']); ?></td>
                                                <td><?= $item['discount_value']; ?></td>
                                                <td><?= $item['min_purchase']; ?></td>
                                                <td><?= $item['max_discount'] ?? 'No limit'; ?></td>
                                                <td><?= date('Y-m-d', strtotime($item['start_date'])); ?></td>
                                                <td><?= date('Y-m-d', strtotime($item['end_date'])); ?></td>
                                                <td><?= $item['usage_limit'] ?? 'No limit'; ?></td>
                                                <td><?= $item['usage_count']; ?></td>
                                                <td>
                                                    <?php if ($item['status'] == 1) : ?>
                                                        <span class="badge bg-success">Active</span>
                                                    <?php else : ?>
                                                        <span class="badge bg-danger">Inactive</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="promocode-edit.php?id=<?= $item['id']; ?>" class="text-primary me-2">
                                                        <i class="ri-edit-2-fill fs-4"></i>
                                                    </a>
                                                    <form action="code.php" method="POST" style="display: inline;">
                                                        <input type="hidden" name="id" value="<?= $item['id']; ?>">
                                                        <button type="submit" name="delete_promocode_btn" style="border: none; background: none; padding: 0; cursor: pointer;" class="delete-promocode" data-id="<?= $item['id']; ?>">
                                                            <i class="bi bi-trash text-danger fs-4"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                        echo "No promo codes found";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<script>
$(document).ready(function() {
    // Handle delete button click
    $('.delete-promocode').on('click', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete the promo code!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'code.php',
                    type: 'POST',
                    data: {
                        delete_promocode_btn: true,
                        id: id
                    },
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
                                location.reload();
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
            }
        });
    });
});
</script>

<?php
include('includes/footer.php')
?> 