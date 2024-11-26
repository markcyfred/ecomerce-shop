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
        <h1>Edit User</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Edit User Forms</li>
                <a href="users-add.php" title="Add new User">
                    <i class=" ri-menu-add-line"></i> Add User
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
                    $user = getByID("users", $id);

                    if (mysqli_num_rows($user) > 0) {
                        $data = mysqli_fetch_array($user);


                ?>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Fill out</h5>

                                <!-- Category Columns Form name slug description user_status popularity image meta_title meta_description meta_keywords -->
                                <form action="code.php" method="POST" enctype="multipart/form-data" class="row g-3">
                                    <input type="hidden" name="user_id" value="<?= $data['id'] ?>">
                                    <div class="col-md-6">
                                        <label for="inputName" class="form-label">First Name</label>
                                        <input type="text" class="form-control" name="first_name" value="<?= $data['first_name'] ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputSlug" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" name="last_name" value="<?= $data['last_name'] ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputEmail" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" value="<?= $data['email'] ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputPhone" class="form-label">Phone</label>
                                        <input type="text" class="form-control" name="phone" value="<?= $data['phone'] ?>">
                                    </div>
                                    <!--street_address-->
                                    <div class="col-md-6">
                                        <label for="inputStreetAddress" class="form-label">Street Address</label>
                                        <input type="text" class="form-control" name="street_address" value="<?= $data['street_address'] ?>">
                                    </div>
                                    <!--city-->
                                    <div class="col-md-6">
                                        <label for="inputCity" class="form-label">City</label>
                                        <input type="text" class="form-control" name="city" value="<?= $data['city'] ?>">
                                    </div>
                                    <!--postal_code-->
                                    <div class="col-md-6">
                                        <label for="inputPostalCode" class="form-label ">Postal Code</label>
                                        <input type="text" class="form-control" name="postal_code" value="<?= $data['postal_code'] ?>">
                                    </div>
                                    <!--additional_info-->
                                    <div class="col-md-6">
                                        <label for="inputAdditionalInfo" class="form-label">Additional Info</label>
                                        <input type="text" class="form-control" name="additional_info" value="<?= $data['additional_info'] ?>">
                                    </div>
                                    <!--role_as use different badge colors for different roles-->
                                    <div class="col-md-6">
                                        <label for="inputRoleAs" class="form-label">Role</label>
                                        <div class="input-group">
                                            <select class="form-control" id="inputRoleAs" name="role_as">
                                                <option value="1" <?= $data['role_as'] == 1 ? 'selected' : '' ?>>Admin</option>
                                                <option value="2" <?= $data['role_as'] == 2 ? 'selected' : '' ?>>Supplier</option>
                                                <option value="3" <?= $data['role_as'] == 3 ? 'selected' : '' ?>>User</option>
                                            </select>
                                            <span class="badge <?= $data['role_as'] == 1 ? 'bg-success' : ($data['role_as'] == 2 ? 'bg-info text-dark' : 'bg-warning text-dark') ?>">
                                                <span style="margin-top: 5px; display: inline-block;">
                                                    <?= $data['role_as'] == 1 ? 'Admin' : ($data['role_as'] == 2 ? 'Supplier' : 'User') ?>
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputuser_status" class="form-label">User Status</label>
                                        <div class="input-group">
                                            <select class="form-control" id="inputuser_status" name="user_status">
                                                <option value="active" <?= $data['user_status'] == 'active' ? 'selected' : '' ?>>Active</option>
                                                <option value="inactive" <?= $data['user_status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                            </select>
                                            <span class="badge <?= $data['user_status'] == 'inactive' ? 'bg-danger' : 'bg-success' ?>">
                                                <span style="margin-top: 5px; display: inline-block;">
                                                    <?= $data['user_status'] == 'active' ? 'Active' : 'Inactive' ?>
                                                </span>
                                            </span>
                                        </div>
                                    </div>


                                    <!--profile_picture-->
                                    <div class="col-md-6">
                                        <label for="inputProfilePicture" class="form-label">Profile Picture</label>
                                        <div class="input-group">
                                            <input type="file" class="form-control" name="profile_picture" id="inputProfilePicture" aria-describedby="inputProfilePictureAddon">
                                            <label class="input-group-text" for="current image" id="inputProfilePictureAddon">Upload</label>
                                        </div>
                                        <input type="hidden" name="old_profile_picture" value="<?= $data['profile_picture'] ?>">
                                        <img src="../uploads/profile/<?= $data['profile_picture'] ?>" alt="<?= $data['first_name'] ?>" width="100" height="100" style="border: 1px solid #a5c5fe;">
                                        <small class="form-text text-muted">These is your current image.</small>
                                    </div>
                                    <!--password-->
                                    <div class="col-md-6">
                                        <label for="inputPassword" class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" value="<?= $data['password'] ?>">
                                    </div>

                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary" name="update_user_btn">Update</button>
                                    </div>
                                </form>
                                <!-- End Multi Columns Form -->
                            </div>
                        </div>
                <?php
                    } else {
                        echo "category not found";
                    }
                } else {
                    echo "id not found";
                }
                ?>
            </div>
        </div>
    </section>

</main><!-- End #main -->
<?php
include('includes/footer.php')
?>