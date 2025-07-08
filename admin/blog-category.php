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

<main id="main" class="main">
     <div class="pagetitle">
          <h1>View blogs categories</h1>
          <nav>
               <ol class="breadcrumb">
                    <li class="breadcrumb-item">View Blog Categories Forms</li>
                    <li class="breadcrumb-item">
                         <a href="add-blog-category.php" title="Add new Blog Category">
                              <i class="ri-menu-add-line"></i> Add Blog Category
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

     <!-- Bulk Export Form -->
          <div class="card">

               <div class="card-body">
                    <div class="table-responsive">
                         <table class="table datatable">
                              <thead>
                                   <tr>
                                       

                                        <th>#</th>
                                        <th>name</th>
                                        <th>slug</th>
                                        <th>description</th>
                                        <th>Image</th>
                                        <th>status</th>
                                        <th>Action</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                   $blog = mysqli_query($conn, "SELECT * FROM blog_categories ORDER BY created_at DESC");

                                   if (mysqli_num_rows($blog) > 0) {
                                        foreach ($blog as $item) {
                                   ?>
                                             <tr>
                                                  
                                                  <td><?= $item['id']; ?></td>
                                                  <td><?= $item['name']; ?></td>
                                                  <td><?= $item['slug']; ?></td>
                                                  <td><?= substr($item['description'], 0, 50) . '...'; ?></td>
                                                  <td>
                                                       <img src="../uploads/blogs/categories/<?= $item['image']; ?>" alt="<?= $item['name']; ?>" width="100" height="100" style="border: 1px solid #a5c5fe;">
                                                  </td>
                                                  <td>
                                                       <?php if ($item['status'] == 1) : ?>
                                                            <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span>
                                                       <?php else : ?>
                                                            <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i> Inactive</span>
                                                       <?php endif; ?>
                                                  </td>
                                           
                                                  <td>
                                                       <a href="edit-blog-category.php?id=<?= $item['id']; ?>" class="text-primary me-2">
                                                            <i class="ri-edit-2-fill fs-4"></i>
                                                       </a>
                                                       <form action="code.php" method="POST" style="display: inline;">
                                                            <input type="hidden" name="delete_blog_category_id" value="<?= $item['id']; ?>">
                                                            <button type="submit" name="delete_blog_category" style="border: none; background: none; padding: 0; cursor: pointer;">
                                                                 <i class="bi bi-trash text-danger fs-4"></i>
                                                            </button>
                                                       </form>

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


</main><!-- End #main -->

<?php
include('includes/footer.php');
?>