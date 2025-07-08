<?php
include('../middleware/adminMiddleware.php');
include('includes/header.php');
?>

<style>
     .breadcrumb {
          display: flex;
          justify-content: space-between;
     }

     #zipUploadForm {
          display: none;
          margin-top: 20px;
     }

     .zip-for-me-btn {
          float: right;
          margin: 10px 0;
     }

     #processingMsg {
          display: none;
          margin-top: 20px;
          font-weight: bold;
          color: #007bff;
     }
</style>

<main id="main" class="main">
     <div class="pagetitle">
          <h1>View Blog Posts</h1>
          <nav>
               <ol class="breadcrumb">
                    <li class="breadcrumb-item">View Blog Posts</li>
                    <li class="breadcrumb-item">
                         <a href="blogs-add.php" title="Add new Blog Post">
                              <i class="ri-menu-add-line"></i> Add Blog
                         </a>
                    </li>
                    <li class="breadcrumb-item active">
                         <a href="index.php">
                              <i class="ri-arrow-right-s-line"></i> Blogs

                         </a>
                    </li>
               </ol>
          </nav>
     </div><!-- End Page Title -->

     <div class="card">
          <div class="card-body">
               <div class="table-responsive">
                    <table class="table datatable">
                         <thead>
                              <tr>
                                   <th>#</th>
                                   <th>Title</th>
                                   <th>Slug</th>
                                   <th>Author</th>
                                   <th>Image</th>
                                   <th>Status</th>
                                   <th>Action</th>
                              </tr>
                         </thead>
                         <tbody>
                              <?php
                              $blogs = mysqli_query($conn, "SELECT * FROM blogs ORDER BY created_at DESC");

                              if (mysqli_num_rows($blogs) > 0) {
                                   foreach ($blogs as $blog) {
                              ?>
                                        <tr>
                                             <td><?= $blog['id']; ?></td>
                                             <td><?= $blog['title']; ?></td>
                                             <td><?= $blog['slug']; ?></td>
                                             <td><?= $blog['author_name']; ?></td>
                                             <td>
                                                  <img src="../uploads/blogs/<?= $blog['image']; ?>" alt="<?= $blog['title']; ?>" width="100" height="100" style="border: 1px solid #a5c5fe;">
                                             </td>
                                             <td>
                                                  <?php if ($blog['status'] == 1) : ?>
                                                       <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span>
                                                  <?php else : ?>
                                                       <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i> Inactive</span>
                                                  <?php endif; ?>
                                             </td>
                                             <td>
                                                  <a href="edit-blog.php?id=<?= $blog['id']; ?>" class="text-primary me-2">
                                                       <i class="ri-edit-2-fill fs-4"></i>
                                                  </a>
                                                  <form action="code.php" method="POST" style="display: inline;">
                                                       <input type="hidden" name="delete_blog_id" value="<?= $blog['id']; ?>">
                                                       <button type="submit" name="delete_blog_btn" style="border: none; background: none; padding: 0; cursor: pointer;">
                                                            <i class="bi bi-trash text-danger fs-4"></i>
                                                       </button>
                                                  </form>
                                             </td>
                                        </tr>
                              <?php
                                   }
                              } else {
                                   echo "<tr><td colspan='7'>No blog posts found</td></tr>";
                              }
                              ?>
                         </tbody>
                    </table>
               </div>
          </div>
     </div>
</main>

<?php
include('includes/footer.php');
?>