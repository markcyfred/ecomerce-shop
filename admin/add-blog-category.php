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
          <h1>Add Blog Category</h1>
          <nav>
               <ol class="breadcrumb">
                    <li class="breadcrumb-item">Blog Category Form</li>
                    <a href="blog-category.php" title="View Blog Categories">
                         <i class="ri-eye-line"></i> View Blog Categories
                    </a>
                    <li class="breadcrumb-item active">
                         <a href="index.php">
                              <i class="ri-arrow-go-back-fill"></i> Home</a>
                    </li>
               </ol>
          </nav>
     </div><!-- End Page Title -->

     <section class="section">
          <div class="row">
               <div class="col-lg-12">
                    <div class="card">
                         <div class="card-body">
                              <h5 class="card-title">Fill out Blog Category Details</h5>
                              <form action="code.php" method="POST" enctype="multipart/form-data" class="row g-3">
                                   <div class="col-md-6">
                                        <label for="name" class="form-label">Category Name</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                   </div>

                                   <div class="col-md-6">
                                        <label for="slug" class="form-label">Slug</label>
                                        <input type="text" class="form-control" id="slug" name="slug" placeholder="auto-generated if left empty">
                                   </div>

                                   <div class="col-md-12">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                   </div>

                                   <div class="col-md-6">
                                        <label for="image" class="form-label">Category Image</label>
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

                                   <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary" name="add_blog_category_btn">Submit</button>
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                   </div>
                              </form>

                         </div>
                    </div>
               </div>
          </div>
     </section>
</main><!-- End #main -->

<?php
include('includes/footer.php');
?>