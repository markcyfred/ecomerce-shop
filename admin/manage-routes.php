<?php
include('../middleware/adminMiddleware.php');
include('includes/header.php');
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Manage Routes</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Routes</li>
                <a href="create-route.php" title="Add Route">
                    <i class="ri-menu-add-line"></i> Add Route
                </a>
                <li class="breadcrumb-item active">
                    <a href="index.php">
                        <i class="ri-arrow-go-back-fill"></i> Home
                    </a>
                </li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">All Routes</h5>
                        <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Route Name</th>
                                        <th>Route Code</th>
                                        <th>Start Name</th>
                                        <th>End Name</th>
                                        <th>Distance (km)</th>
                                        <th>Estimated Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $routes = getAll('routes');
                                    if (mysqli_num_rows($routes) > 0) {
                                        $sn = 1;
                                        foreach ($routes as $route) {
                                    ?>
                                            <tr>
                                                <td><?= $sn++; ?></td>
                                                <td><?= htmlspecialchars($route['route_name']); ?></td>
                                                <td><?= htmlspecialchars($route['route_code']); ?></td>
                                                <td><?= htmlspecialchars($route['start_name']); ?></td>
                                                <td><?= htmlspecialchars($route['end_name']); ?></td>
                                                <td><?= htmlspecialchars($route['distance_km']); ?></td>
                                                <td><?= htmlspecialchars($route['estimated_time']); ?></td>
                                                <td>
                                                    <a href="edit-route.php?id=<?= $route['id']; ?>" class="text-primary me-2" title="Edit">
                                                        <i class="ri-edit-2-fill fs-5"></i>
                                                    </a>
                                                    <form action="code.php" method="POST" style="display:inline;">
                                                        <input type="hidden" name="route_id" value="<?= $route['id']; ?>">
                                                        <button type="submit" name="delete_route_btn" style="border:none; background:none; padding:0; cursor:pointer;">
                                                            <i class="bi bi-trash text-danger fs-5"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                        echo '<tr><td colspan="8">No routes found</td></tr>';
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
</main>
<?php include('includes/footer.php'); ?> 