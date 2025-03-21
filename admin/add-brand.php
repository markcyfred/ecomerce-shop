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
          <h1>Brand Add</h1>
          <nav>
               <ol class="breadcrumb">
                    <li class="breadcrumb-item">Add Brand Forms</li>
                    <a href="brands.php" title="View Brand">
                         <i class="ri-eye-line"></i> View Brands
                    </a>
                    <li class="breadcrumb-item active">
                         <a href="index.php">
                              <i class="ri-arrow-go-back-fill"></i> home</a>
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
                              <!-- Form add shop products -->
                              <form action="code.php" method="POST" enctype="multipart/form-data" class="row g-3">
                                   <!--brand we shall brand name , image , descriptio -->
                                   <div class="col-md-6">
                                        <label for="brand_name" class="form-label">Brand Name</label>
                                        <input type="text" class="form-control" id="brand_name" name="brand_name" required>
                                   </div>
                                   <div class="col-md-6">
                                        <label for="brand_image" class="form-label">Brand Image</label>
                                        <input type="file" class="form-control" id="brand_image" name="brand_image" required>
                                   </div>
                                   <div class="col-md-6">
                                        <label for="brand_description" class="form-label">Brand Description</label>
                                        <textarea class="form-control" id="brand_description" name="brand_description" required></textarea>
                                   </div>

                                   <div class="col-md-6">
                                        <label for="inputTrending" class="form-label">Status</label>
                                        <select class="form-select" id="inputstatus" name="status">
                                             <option value="1">Active</option>
                                             <option value="0">Inactive</option>
                                        </select>
                                   </div>
                                   <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary" name="add_brand_btn">Submit</button>
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