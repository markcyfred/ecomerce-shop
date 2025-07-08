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
          <h1>Add Banner</h1>
          <nav>
               <ol class="breadcrumb">
                    <li class="breadcrumb-item">Add Banner Form</li>
                    <a href="banner.php" title="View Banners">
                         <i class="ri-eye-line"></i> View Banners
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
                              <h5 class="card-title">Fill out</h5>

                              <!-- Form to add banner -->
                              <form action="code.php" method="POST" enctype="multipart/form-data" class="row g-3">

                                   <div class="col-md-6">
                                        <label for="title" class="form-label">Banner Title</label>
                                        <input type="text" class="form-control" id="title" name="title" required>
                                   </div>

                                   <div class="col-md-6">
                                        <label for="subtitle" class="form-label">Banner Subtitle</label>
                                        <input type="text" class="form-control" id="subtitle" name="subtitle" required>
                                   </div>

                                   <div class="col-md-6">
                                        <label for="link" class="form-label">Link</label>
                                        <input type="text" class="form-control" id="link" name="link" required>
                                   </div>

                                   <div class="col-md-6">
                                        <label for="price" class="form-label">Price</label>
                                        <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                                   </div>

                                   <div class="col-md-6">
                                        <label for="brand_image" class="form-label">Banner Image</label>
                                        <div class="drop-zone" id="dropZone">Drag & Drop Image Here</div>
                                        <input type="file" class="form-control d-none" id="brand_image" name="image">
                                   </div>

                                   <div class="col-md-6">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select" id="status" name="status">
                                             <option value="1">Active</option>
                                             <option value="0">Inactive</option>
                                        </select>
                                   </div>

                                   <!-- New size field -->
                                   <div class="col-md-6">
                                        <label for="size" class="form-label">Banner Size</label>
                                        <select class="form-select" id="size" name="size" required>
                                             <option value="normal">Normal</option>
                                             <option value="large">Large</option>
                                        </select>
                                   </div>

                                   <!-- New banner_type field -->
                                   <div class="col-md-6">
                                        <label for="banner_type" class="form-label">Banner Type</label>
                                        <select class="form-select" id="banner_type" name="banner_type" required>
                                             <option value="single">single</option>
                                             <option value="double">double</option>
                                        </select>
                                   </div>

                                   <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary" name="add_banner_btn">Submit</button>
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
