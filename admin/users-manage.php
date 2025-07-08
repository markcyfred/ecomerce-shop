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
          <h1>View Users</h1>
          <nav>
               <ol class="breadcrumb">
                    <li class="breadcrumb-item">View users Forms</li>
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
                    <div class="card">
                         <div class="card-body">
                              <h5 class="card-title">All Users</h5>

                              <!-- Table with stripped rows -->
                              <div class="table-responsive">
                                   <table class="table datatable">
                                        <thead>
                                             <tr>
                                                  <th scope="col">#</th>
                                                  <th scope="col">First Name</th>
                                                  <th scope="col">Last Name</th>
                                                  <th scope="col">Email</th>
                                                  <th scope="col">Phone</th>
                                                  <th scope="col">Role</th>
                                                  <th scope="col">user_status</th>
                                                  <th scope="col">Profile</th>
                                                  <th scope="col">Action</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <?php
                                             $users = getAll("users");

                                             if (mysqli_num_rows($users) > 0) {
                                                  foreach ($users as $item) {
                                             ?>

                                                       <tr>
                                                            <th><?= $item['id']; ?></th>
                                                            <td><?= $item['first_name']; ?></td>
                                                            <td><?= $item['last_name']; ?></td>
                                                            <td><?= $item['email']; ?></td>
                                                            <td><?= $item['phone']; ?></td>
                                                            <td>
                                                                 <?php if ($item['role_as'] == 1) : ?>
                                                                      <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Admin</span>
                                                                 <?php elseif ($item['role_as'] == 2) : ?>
                                                                      <span class="badge bg-info text-dark"><i class="bi bi-box-seam me-1"></i> Supplier</span>
                                                                 <?php else : ?>
                                                                      <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i> User</span>
                                                                 <?php endif; ?>
                                                            </td>
                                                            <!--user_status if 0 active if 1 inactive-->
                                                            <td>
                                                                 <?php if ($item['user_status'] == 'active') : ?>
                                                                      <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span>
                                                                 <?php else : ?>
                                                                      <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i> Inactive</span>
                                                                 <?php endif; ?>
                                                            </td>


                                                            <td><img src="../uploads/profile/<?= $item['profile_picture']; ?>" alt="<?= $item['first_name']; ?>" width="100" height="100" style="border: 1px solid #a5c5fe;"></td>

                                                            <td>
                                                                 <a href="edit-user.php?id=<?= $item['id']; ?>" class="text-primary me-2">
                                                                      <i class="ri-edit-2-fill fs-4"></i>
                                                                 </a>
                                                                 <form action="code.php" method="POST" style="display: inline;">
                                                                      <input type="hidden" name="id" value="<?= $item['id']; ?>">
                                                                      <button type="submit" name="delete_user_btn" style="border: none; background: none; padding: 0; cursor: pointer;" onclick="return confirm('Are you sure you want to delete this user?')">
                                                                           <i class="bi bi-trash text-danger fs-4"></i>
                                                                      </button>
                                                                 </form>
                                                            </td>
                                                       </tr>

                                             <?php
                                                  }
                                             } else {
                                                  echo "No record found";
                                             }
                                             ?>
                                        </tbody>
                                   </table>
                                   <!-- End Table with stripped rows -->
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </section>
</main><!-- End #main -->
<?php
include('includes/footer.php')
?>