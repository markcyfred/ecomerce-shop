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
          <h1>Edit brand</h1>
          <nav>
               <ol class="breadcrumb">
                    <li class="breadcrumb-item">Edit brand Forms</li>
                    <a href="brands.php" title="Add new Product">
                         <i class=" ri-menu-add-line"></i> Add brand
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
                    <?php
                    if (isset($_GET['id'])) {
                         $id = $_GET['id'];
                         $product = getByID("brands", $_GET['id']);

                         if (mysqli_num_rows($product) > 0) {
                              $data = mysqli_fetch_assoc($product);
                    ?>

                              <div class="card">
                                   <div class="card-body">
                                        <h5 class="card-title">Fill out</h5>

                                        <!-- Form add shop products -->
                                        <form action="code.php" method="POST" enctype="multipart/form-data" class="row g-3">
                                        <input type="hidden" name="brand_id" value="<?= $data['id']; ?>">
                                        <!--brand we shall brand name , image , descriptio -->
                                             <div class="col-md-6">
                                                  <label for="brand_name" class="form-label">Brand Name</label>
                                                  <input type="text" class="form-control" id="brand_name" name="brand_name" value="<?= $data['brand_name'] ?>" required>
                                             </div>
                                             <div class="col-md-6">
                                                  <label for="brand_image" class="form-label">Brand Image</label>
                                                  <input type="hidden" name="old_image" value="<?= $data['brand_image']; ?>">
                                                  <br>
                                                  <!--show current image-->
                                                  <input type="file" class="form-control" id="brand_image" name="brand_image">
                                                  <br>
                                                  <label for="brand_image" class="form-label">Current Image</label>
                                                  <img src="../uploads/brands/<?= $data['brand_image']; ?>" alt="brand image" style="width: 100px; height: 100px;">

                                                  </div>
                                             <div class="col-md-6">
                                                  <label for="brand_description" class="form-label">Brand Description</label>
                                                  <textarea class="form-control" id="brand_description" name="brand_description" required><?= $data['brand_description'] ?></textarea>
                                             </div>

                                             <div class="col-md-6">
                                                  <label for="inputTrending" class="form-label">Status</label>
                                                  <select class="form-select" id="inputstatus" name="status">
                                                       <option value="1" <?= $data['status'] == 1 ? 'selected' : '' ?>>Active</option>
                                                       <option value="0" <?= $data['status'] == 0 ? 'selected' : '' ?>>Inactive</option>
                                                  </select>
                                             </div>


                                   </div>

                                   <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary" name="update_brand_btn">Update</button>
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                   </div>
                                   </form>
                                   <!-- End Multi Columns Form -->
                              </div>

                    <?php
                         } else {
                              echo "<h4 class='text-center'>No Record Found</h4>";
                         }
                    } else {
                         echo "id missing from the url";
                    }

                    ?>

               </div>

          </div>
          </div>
     </section>

</main><!-- End #main -->


<?php
include('includes/footer.php')
?>