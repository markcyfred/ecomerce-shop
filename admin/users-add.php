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
          <h1>Add User</h1>
          <nav>
               <ol class="breadcrumb">
                    <li class="breadcrumb-item">Add User Forms</li>
                    <a href="edit-user.php" title="Add new User">
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
                    <div class="card">
                         <div class="card-body">
                              <h5 class="card-title">Fill out</h5>

                              <!-- Category Columns Form name slug description user_status popularity image meta_title meta_description meta_keywords -->
                              <form action="code.php" method="POST" enctype="multipart/form-data" class="row g-3">
                              <input type="hidden" name="user_id" value="<?= $data['id'] ?>">
                                   <div class="col-md-6">
                                        <label for="inputName" class="form-label">First Name</label>
                                        <input type="text" class="form-control" name="first_name">
                                   </div>
                                   <div class="col-md-6">
                                        <label for="inputSlug" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" name="last_name">
                                   </div>
                                   <div class="col-md-6">
                                        <label for="inputEmail" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email">
                                   </div>
                                   <div class="col-md-6">
                                        <label for="inputPhone" class="form-label">Phone</label>
                                        <input type="text" class="form-control" name="phone">
                                   </div>
                                   <!--street_address-->
                                   <div class="col-md-6">
                                        <label for="inputStreetAddress" class="form-label">Street Address</label>
                                        <input type="text" class="form-control" name="street_address">
                                   </div>
                                   <!--city-->
                                   <div class="col-md-6">
                                        <label for="inputCity" class="form-label">City</label>
                                        <input type="text" class="form-control" name="city">
                                   </div>
                                   <!--postal_code-->
                                   <div class="col-md-6">
                                        <label for="inputPostalCode" class="form-label ">Postal Code</label>
                                        <input type="text" class="form-control" name="postal_code">
                                   </div>
                                   <!--additional_info-->
                                   <div class="col-md-6">
                                        <label for="inputAdditionalInfo" class="form-label">Additional Info</label>
                                        <input type="text" class="form-control" name="additional_info">
                                   </div>
                                   <div class="col-md-6">
                                        <!--role_as use different badge colors for different roles-->
                                        <label for="inputRoleAs" class="form-label">Role</label>
                                        <div class="input-group">
                                             <select class="form-control" id="inputRoleAs" name="role_as">
                                                  <option value="0">User</option>
                                                  <option value="1">Admin</option>
                                                  <option value="2">Supplier</option>

                                             </select>
                                             <span class="badge bg-primary">
                                                  <span style="margin-top: 5px; display: inline-block;">
                                                       Admin
                                                  </span>
                                             </span>
                                        </div>
                                   </div>
                                   <!--user_status-->
                                   <div class="col-md-6">
                                        <label for="inputUserStatus" class="form-label">User Status</label>
                                        <div class="input-group">
                                             <select class="form-control" id="inputUserStatus" name="user_status">
                                                  <option value="active">Active</option>
                                                  <option value="inactive">Inactive</option>
                                             </select>
                                             <span class="badge bg-success">
                                                  <span style="margin-top: 5px; display: inline-block;">
                                                       Active
                                                  </span>
                                             </span>
                                        </div>
                                   </div>
                                   <div class="col-12">
                                        <label for="inputProfilePicture" class="form-label">Profile Picture</label>
                                        <input type="file" class="form-control" name="profile_picture">
                                   </div>
                                   <!--password-->
                                   <div class="col-md-6">
                                        <label for="inputPassword" class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password">
                                   </div>
                                   <!--confirm_password-->
                                   <div class="col-md-6">
                                        <label for="inputConfirmPassword" class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" name="confirm_password">
                                   </div>

                                   <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary" name="add_user">Add</button>
                                   </div>
                              </form>
                              <!-- End Multi Columns Form -->
                         </div>
                    </div>
               </div>
          </div>
     </section>

</main><!-- End #main -->
<?php
include('includes/footer.php')
?>