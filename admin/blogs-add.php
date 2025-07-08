<?php
include('../middleware/adminMiddleware.php');
include('includes/header.php');
?>

<main id="main" class="main">
     <div class="pagetitle">
          <h1>Add New Blog</h1>
          <nav>
               <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                         <a href="index.php"><i class="ri-arrow-go-back-fill"></i> Home</a>
                    </li>
                    <li class="breadcrumb-item active">
                         <a href="add-blog.php">
                              Add Blog
                         </a>
                    </li>
                    <li class="breadcrumb-item">
                         <a href="blogs.php"><i class="ri-article-line"></i> Blogs</a>
                    </li>
               </ol>
          </nav>
     </div>

     <section class="section">
          <div class="card">
               <div class="card-body">
                    <h5 class="card-title">Blog Details</h5>

                    <form action="code.php" method="POST" enctype="multipart/form-data">
                         <div class="row">
                              <div class="col-md-4 mb-3">
                                   <label for="category">Category</label>
                                   <select name="category" class="form-control" required>
                                        <option value="">-- Select Category --</option>
                                        <?php
                                        // Assuming $conn is your DB connection
                                        $categories = mysqli_query($conn, "SELECT * FROM blog_categories WHERE status='1'");
                                        foreach ($categories as $cat) {
                                             echo "<option value='{$cat['name']}'>{$cat['name']}</option>";  // use name here
                                        }
                                        ?>
                                   </select>
                              </div>

                              <div class="col-md-4 mb-3">
                                   <label for="name">Blog Title</label>
                                   <input type="text" name="title" class="form-control" required>
                              </div>


                              <div class="col-md-6 mb-3">
                                   <label for="slug">Slug</label>
                                   <input type="hidden" name="meta_keywords" value="">

                                   <input type="text" name="slug" class="form-control" placeholder="enter slug" required>
                              </div>
                              <!--meta keywords and description-->
                              <div class="col-md-6 mb-3">
                                   <label for="meta_keywords">Meta Keywords</label>
                                   <input type="text" name="meta_keywords" class="form-control" placeholder="comma-separated keywords" required>
                              </div>

                              <div class="col-md-12 mb-3">
                                   <label for="description">Description</label>
                                   <textarea name="description" class="form-control" rows="4" required></textarea>
                              </div>

                              <div class="col-md-6">
                                   <label for="image" class="form-label">Blog Image</label>
                                   <div class="drop-zone" id="dropZone">Drag & Drop Image Here</div>
                                   <input type="file" class="form-control d-none" id="brand_image" name="image" accept="image/*">

                              </div>

                              <div class="col-md-6">
                                   <label for="status" class="form-label">Status</label>
                                   <select class="form-select" id="status" name="status">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                   </select>
                              </div>

                              <div style="margin-top:20px" class="col-12 text-center">
                                   <button type="submit" class="btn btn-primary" name="add_blog_btn">Submit</button>
                                   <button type="reset" class="btn btn-secondary">Reset</button>
                              </div>
                         </div>
                    </form>
               </div>
          </div>
     </section>
</main>

<?php include('includes/footer.php'); ?>