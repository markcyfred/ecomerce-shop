<?php
include 'init.php';

// Redirect unlogged-in users to the login page
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
     header('location: login.php');
     exit();
}

include 'includes/header.php';
?>

<main class="main">
     <div class="page-header breadcrumb-wrap">
          <div class="container">
               <div class="breadcrumb">
                    <a href="index.html" rel="nofollow">Home</a>
                    <span></span> Pages
                    <span></span> Account
               </div>
          </div>
     </div>
     <section class="pt-150 pb-150">
          <div class="container">
               <div class="row">
                    <div class="col-lg-10 m-auto">
                         <div class="row">
                              <div class="col-md-4">
                                   <div class="dashboard-menu">
                                        <ul class="nav flex-column" role="tablist">
                                             <li class="nav-item">
                                                  <a class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="false"><i class="fi-rs-settings-sliders mr-10"></i>Dashboard</a>
                                             </li>
                                             <li class="nav-item">
                                                  <a class="nav-link" id="orders-tab" data-bs-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="false"><i class="fi-rs-shopping-bag mr-10"></i>Orders</a>
                                             </li>
                                             <li class="nav-item">
                                                  <a class="nav-link" id="track-orders-tab" data-bs-toggle="tab" href="#track-orders" role="tab" aria-controls="track-orders" aria-selected="false"><i class="fi-rs-shopping-cart-check mr-10"></i>Track Your Order</a>
                                             </li>
                                             <li class="nav-item">
                                                  <a class="nav-link" id="address-tab" data-bs-toggle="tab" href="#address" role="tab" aria-controls="address" aria-selected="true"><i class="fi-rs-marker mr-10"></i>My Address</a>
                                             </li>
                                             <li class="nav-item">
                                                  <a class="nav-link" id="account-detail-tab" data-bs-toggle="tab" href="#account-detail" role="tab" aria-controls="account-detail" aria-selected="true"><i class="fi-rs-user mr-10"></i>Account details</a>
                                             </li>
                                             <li class="nav-item">
                                                  <a class="nav-link" href="functions/logout.php"><i class="fi-rs-sign-out mr-10"></i>Logout</a>
                                             </li>
                                        </ul>
                                   </div>
                              </div>
                              <div class="col-md-8">
                                   <div class="tab-content dashboard-content">
                                        <div class="tab-pane fade active show" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                                             <div class="card">
                                                  <div class="card-header">
                                                       <h5 class="mb-0">Hello
                                                            <!-- Define the user's first name -->
                                                            <?php
                                                            if (isset($_SESSION['auth_user'])) {
                                                                 $user_id = $_SESSION['auth_user']['id'];
                                                                 $user_query = "SELECT * FROM `users` WHERE `id`='$user_id'";
                                                                 $user_query_run = mysqli_query($conn, $user_query);

                                                                 if ($user_query_run && mysqli_num_rows($user_query_run) > 0) {
                                                                      $user_data = mysqli_fetch_array($user_query_run);
                                                                      $fullName = $user_data['first_name'] . " " . $user_data['last_name'];
                                                                 } else {
                                                                      $fullName = "User"; // Default fallback if the query fails or no user is found
                                                                 }
                                                            } else {
                                                                 $fullName = "Guest"; // Default fallback for unauthenticated users
                                                            }
                                                            ?>
                                                            <?php echo htmlspecialchars($fullName, ENT_QUOTES, 'UTF-8'); ?>
                                                       </h5>

                                                  </div>
                                                  <div class="card-body">
                                                       <p>From your account dashboard. you can easily check &amp; view your <a href="#">recent orders</a>, manage your <a href="#">shipping and billing addresses</a> and <a href="#">edit your password and account details.</a></p>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                                             <div class="card">
                                                  <div class="card-header">
                                                       <h5 class="mb-0">Your Orders</h5>
                                                  </div>
                                                  <div class="card-body">
                                                       <div class="table-responsive">
                                                            <table class="table">
                                                                 <thead>
                                                                      <tr>
                                                                           <th>Order</th>
                                                                           <th>Date</th>
                                                                           <th>Status</th>
                                                                           <th>Total</th>
                                                                           <th>Actions</th>
                                                                      </tr>
                                                                 </thead>
                                                                 <tbody>
                                                                      <tr>
                                                                           <td>#1357</td>
                                                                           <td>March 45, 2020</td>
                                                                           <td>Processing</td>
                                                                           <td>$125.00 for 2 item</td>
                                                                           <td><a href="#" class="btn-small d-block">View</a></td>
                                                                      </tr>
                                                                      <tr>
                                                                           <td>#2468</td>
                                                                           <td>June 29, 2020</td>
                                                                           <td>Completed</td>
                                                                           <td>$364.00 for 5 item</td>
                                                                           <td><a href="#" class="btn-small d-block">View</a></td>
                                                                      </tr>
                                                                      <tr>
                                                                           <td>#2366</td>
                                                                           <td>August 02, 2020</td>
                                                                           <td>Completed</td>
                                                                           <td>$280.00 for 3 item</td>
                                                                           <td><a href="#" class="btn-small d-block">View</a></td>
                                                                      </tr>
                                                                 </tbody>
                                                            </table>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="tab-pane fade" id="track-orders" role="tabpanel" aria-labelledby="track-orders-tab">
                                             <div class="card">
                                                  <div class="card-header">
                                                       <h5 class="mb-0">Orders tracking</h5>
                                                  </div>
                                                  <div class="card-body contact-from-area">
                                                       <p>To track your order please enter your OrderID in the box below and press "Track" button. This was given to you on your receipt and in the confirmation email you should have received.</p>
                                                       <div class="row">
                                                            <div class="col-lg-8">
                                                                 <form class="contact-form-style mt-30 mb-50" action="#" method="post">
                                                                      <div class="input-style mb-20">
                                                                           <label>Order ID</label>
                                                                           <input name="order-id" placeholder="Found in your order confirmation email" type="text" class="square">
                                                                      </div>
                                                                      <div class="input-style mb-20">
                                                                           <label>Billing email</label>
                                                                           <input name="billing-email" placeholder="Email you used during checkout" type="email" class="square">
                                                                      </div>
                                                                      <button class="submit submit-auto-width" type="submit">Track</button>
                                                                 </form>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                                             <div class="row">
                                                  <div class="col-lg-6">
                                                       <div class="card mb-3 mb-lg-0">
                                                            <div class="card-header">
                                                                 <h5 class="mb-0">Billing Address</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                 <address>3522 Interstate<br> 75 Business Spur,<br> Sault Ste. <br>Marie, MI 49783</address>
                                                                 <p>New York</p>
                                                                 <a href="#" class="btn-small">Edit</a>
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="col-lg-6">
                                                       <div class="card">
                                                            <div class="card-header">
                                                                 <h5 class="mb-0">Shipping Address</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                 <address>4299 Express Lane<br>
                                                                      Sarasota, <br>FL 34249 USA <br>Phone: 1.941.227.4444</address>
                                                                 <p>Sarasota</p>
                                                                 <a href="#" class="btn-small">Edit</a>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="tab-pane fade" id="account-detail" role="tabpanel" aria-labelledby="account-detail-tab">
                                             <div class="card">
                                                  <div class="card-header">
                                                       <h5>Account Details</h5>
                                                  </div>
                                                  <div class="card-body">
                                                       <?php if (isset($_SESSION['auth_user'])): ?>
                                                            <p>Already have an account? <a href="page-login-register.html">Log in instead!</a></p>
                                                            <form method="post" enctype="multipart/form-data" action="functions/authcode.php">
                                                                 <input type="hidden" name="user_id" value="<?php echo $_SESSION['auth_user']['id']; ?>">
                                                                 <div class="row">
                                                                      <div class="form-group col-md-6">
                                                                           <label>First Name <span class="required">*</span></label>
                                                                           <input required class="form-control square" name="first_name" type="text" value="<?php echo $_SESSION['auth_user']['first_name']; ?>">
                                                                      </div>
                                                                      <div class="form-group col-md-6">
                                                                           <label>Last Name <span class="required">*</span></label>
                                                                           <input required class="form-control square" name="last_name" type="text" value="<?php echo $_SESSION['auth_user']['last_name']; ?>">
                                                                      </div>
                                                                      <div class="form-group col-md-6">
                                                                           <label>Display Name <span class="required">*</span></label>
                                                                           <input required class="form-control square" name="display_name" type="text" value="<?php echo $_SESSION['auth_user']['first_name'] . " " . $_SESSION['auth_user']['last_name']; ?>">
                                                                      </div>
                                                                      <div class="form-group col-md-6">
                                                                           <label>Profile Picture</label>
                                                                           <input class="form-control square" name="profile_picture" type="file">
                                                                           <input type="hidden" name="old_image" value="<?php echo $_SESSION['auth_user']['profile_picture']; ?>">

                                                                           <?php if (!empty($_SESSION['auth_user']['profile_picture'])): ?>
                                                                                <img src="uploads/profile/<?php echo $_SESSION['auth_user']['profile_picture']; ?>" alt="profile picture" style="width: 100px; height: 100px;">
                                                                           <?php endif; ?>
                                                                      </div>
                                                                      <div class="form-group col-md-12">
                                                                           <label>Email Address <span class="required">*</span></label>
                                                                           <input required class="form-control square" name="email" type="email" value="<?php echo $_SESSION['auth_user']['email']; ?>">
                                                                      </div>
                                                                      <div class="form-group col-md-6">
                                                                           <label>Phone Number <span class="required">*</span></label>
                                                                           <input required class="form-control square" name="phone" type="text" value="<?php echo $_SESSION['auth_user']['phone']; ?>">
                                                                      </div>
                                                                      <div class="form-group col-md-6">
                                                                           <label>City <span class="required">*</span></label>
                                                                           <input required class="form-control square" name="city" type="text" value="<?php echo $_SESSION['auth_user']['city']; ?>">
                                                                      </div>
                                                                      <div class="form-group col-md-6">
                                                                           <label>Street Address <span class="required">*</span></label>
                                                                           <input required class="form-control square" name="street_address" type="text" value="<?php echo $_SESSION['auth_user']['street_address']; ?>">
                                                                      </div>
                                                                      <div class="form-group col-md-6">
                                                                           <label>Postal Code <span class="required">*</span></label>
                                                                           <input required class="form-control square" name="postal_code" type="text" value="<?php echo $_SESSION['auth_user']['postal_code']; ?>">
                                                                      </div>
                                                                      <div class="form-group col-md-12">
                                                                           <label>Additional Information</label>
                                                                           <textarea class="form-control square" name="additional_info"><?php echo $_SESSION['auth_user']['additional_info']; ?></textarea>
                                                                      </div>
                                                                      <div class="col-md-12">
                                                                           <button type="submit" class="btn btn-fill-out submit" name="update_account_btn" value="Submit">Save</button>
                                                                      </div>

                                                                 </div>
                                                            </form>
                                                       <?php else: ?>
                                                            <p class="text-danger">Cannot fetch information now. Please <a href="page-login-register.html">log in</a> to access your account.</p>
                                                       <?php endif; ?>
                                                  </div>

                                             </div>
                                        </div>

                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </section>
</main>
<?php include 'includes/footer.php'; ?>