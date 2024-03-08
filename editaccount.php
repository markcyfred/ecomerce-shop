<?php
// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is not logged in, redirect them to the login page
if (!isset($_SESSION['auth'])) {
    $_SESSION['message'] = "You are not logged in";
    header('location: login.php');
    exit();
}

// Include the header
include 'header.php';
include 'admin/config/dbcon.php';

include 'functions/myfunctions.php';

?>

<main class="main pages">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href='index.html' rel='nofollow'><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> Pages <span></span> Edit My Account
            </div>
        </div>
    </div>
    <!--edit account details-->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $user_data = getUserByID('users', $id);

                    if (mysqli_num_rows($user_data) > 0) {
                        $user = mysqli_fetch_assoc($user_data);


                ?>
                        <div class="card card-dashboard">
                            <div class="card-body">
                                <h4 class="card-title">Edit My Account</h4>
                                <form class="contact-form-style mt-30" action="functions/authcode.php" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input class="form-control" type="text" placeholder="First Name" name="first_name" value="<?= $user['first_name'] ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input class="form-control" type="text" placeholder="Last Name" name="last_name" value="<?= $user['last_name'] ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <select class="form-select" aria-label="Default select example" name="role_as" required disabled>
                                                        <option value="" disabled selected>Select User Type</option>
                                                        <option value="0" <?= ($user['role_as'] == 0) ? 'selected' : '' ?>>Customer</option>
                                                        <option value="2" <?= ($user['role_as'] == 2) ? 'selected' : '' ?>>Supplier</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="inputImage" class="form-label">Image</label>
                                                <div class="input-group">
                                                    <input type="file" class="form-control" name="profile_picture" id="inputImage" aria-describedby="inputImageAddon">
                                                    <label class="input-group-text" for="currentImage" id="inputImageAddon">Upload</label>
                                                </div>
                                                <input type="hidden" name="old_image" value="<?= $user['profile_picture'] ?>">
                                                <input type="hidden" name="old_image" value="<?= $user['profile_picture'] ?>">
                                                <img src="assets/imgs/profile/<?= $user['profile_picture'] ?>" alt="<?= $user['first_name'] ?>" width="100" height="50">
                                                <small class="form-text text-muted">This is your current image.</small>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input class="form-control" type="email" placeholder="Email" name="email" value="<?= $user['email'] ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input class="form-control" type="number" placeholder="Phone" name="phone" maxlength="10" value="<?= $user['phone'] ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <input class="form-control col-md-6" type="text" placeholder="Street Address --eg--90100----" name="street_address" value="<?= $user['street_address'] ?>" required>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input class="form-control" type="text" placeholder="City" name="city" value="<?= $user['city'] ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input class="form-control" type="text" placeholder="Postal Code" name="postal_code" value="<?= $user['postal_code'] ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <textarea class="form-control" placeholder="Additional Information" name="additional_info" required><?= $user['additional_info'] ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group mt-30">
                                        <button type="submit" class="btn btn-sm" name="update_account_btn">Update Account</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                <?php
                    } else {
                        echo "No user found with the given id. Please try again.";
                    }
                } else {
                    echo "id missing in the url. Please try again.";
                }
                ?>

            </div>
        </div>
    </div>

</main>

<?php
include 'includes/footer.php';

?>