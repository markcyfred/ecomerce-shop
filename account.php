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


// Get the logged-in user's email from the session
$user_email = $_SESSION['auth_user']['email'];

// Fetch the details of the logged-in user
$user_data = getUserDetailsByEmail($user_email);

if ($user_data) {
?>

    <main class="main pages">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href='index.html' rel='nofollow'><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Pages <span></span> My Account
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-dashboard">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table  class="table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>City</th>
                                            <th>Role</th>
                                            <th>Profile Image</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody style="background-color: #ddd;">
                                        <tr>
                                            <th><?php echo $user_data['id']; ?></th>
                                            <td><?php echo $user_data['first_name']; ?></td>
                                            <td><?php echo $user_data['email']; ?></td>
                                            <td><?php echo $user_data['phone']; ?></td>
                                            <td><?php echo $user_data['street_address']; ?></td>
                                            <td><?php echo $user_data['city']; ?></td>
                                            <td>
                                                <?php
                                                echo ($user_data['role_as'] == 0) ? "Customer" : (($user_data['role_as'] == 1) ? "Admin" : "Supplier");
                                                ?>
                                            </td>
                                            <td>
                                                <img style="border-radius: 50px;" src="assets/imgs/profile/<?php echo $user_data['profile_picture']; ?>" alt="Profile Image" width="50" height="50">
                                            <td>
                                                <a href="editaccount.php?id=<?= $user_data['id']; ?>" class="text-primary me-2">
                                                    <i class="bi bi-pencil-fill fs-4"></i>
                                                </a>
                                                <form action="functions/authcode.php" method="POST" style="display: inline;">
                                                    <input type="hidden" name="user_id" value="<?= $user_data['id']; ?>">
                                                    <button type="submit" name="delete_user_btn" style="border: none; background: none!important; padding: 0; cursor: pointer;">
                                                        <i class="bi bi-trash text-danger fs-4"></i>
                                                    </button>
                                                </form>
                                            </td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php
} else {
    // Handle if user data is not found
    ?>

    <div class="container">
        <div class="alert alert-warning" role="alert">
            <strong>User data not found!</strong> Please check your account details.
        </div>
    </div>

    <?php
}

include 'includes/footer.php';
?>