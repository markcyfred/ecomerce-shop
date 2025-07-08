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
          <h1>Edit Banner</h1>
          <nav>
               <ol class="breadcrumb">
                    <li class="breadcrumb-item">Edit Banner Form</li>
                    <a href="banners.php" title="Add New Banner">
                         <i class="ri-menu-add-line"></i> Add Banner
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
                    <?php
                    if (isset($_GET['id'])) {
                         $id = $_GET['id'];
                         $banner = getByID("banners", $id);

                         if (mysqli_num_rows($banner) > 0) {
                              $data = mysqli_fetch_assoc($banner);
                    ?>
                              <div class="card">
                                   <div class="card-body">
                                        <h5 class="card-title">Edit Banner</h5>
                                        <form action="code.php" method="POST" enctype="multipart/form-data" class="row g-3">
                                             <input type="hidden" name="banner_id" value="<?= $data['id']; ?>">

                                             <div class="col-md-6">
                                                  <label for="title" class="form-label">Banner Title</label>
                                                  <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($data['title']); ?>" required>
                                             </div>

                                             <div class="col-md-6">
                                                  <label for="subtitle" class="form-label">Banner Subtitle</label>
                                                  <input type="text" class="form-control" id="subtitle" name="subtitle" value="<?= htmlspecialchars($data['subtitle']); ?>" required>
                                             </div>

                                             <div class="col-md-6">
                                                  <label for="link" class="form-label">Link</label>
                                                  <input type="text" class="form-control" id="link" name="link" value="<?= htmlspecialchars($data['link']); ?>" required>
                                             </div>

                                             <div class="col-md-6">
                                                  <label for="price" class="form-label">Price</label>
                                                  <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?= htmlspecialchars($data['price']); ?>" required>
                                             </div>

                                             <!-- New field: size (enum 'normal', 'large') -->
                                             <div class="col-md-6">
                                                  <label for="size" class="form-label">Size</label>
                                                  <select class="form-select" id="size" name="size" required>
                                                       <option value="normal" <?= $data['size'] === 'normal' ? 'selected' : ''; ?>>Normal</option>
                                                       <option value="large" <?= $data['size'] === 'large' ? 'selected' : ''; ?>>Large</option>
                                                  </select>
                                             </div>

                                             <!-- New field: banner_type (varchar) -->
                                             <div class="col-md-6">
                                                  <label for="banner_type" class="form-label">Banner Type</label>
                                                  <select class="form-select" id="banner_type" name="banner_type" required>
                                                       <option value="single" <?= $data['banner_type'] === 'single' ? 'selected' : ''; ?>>Single</option>
                                                       <option value="double" <?= $data['banner_type'] === 'double' ? 'selected' : ''; ?>>Double</option>
                                                  </select>
                                             </div>
                                             <div class="col-md-6">
                                                  <label for="brand_image" class="form-label">banner Image</label>
                                                  <input type="hidden" name="old_image" value="<?= $data['image']; ?>">
                                                  <div class="drop-zone" id="dropZone">Drag & Drop Image Here</div>
                                                  <input type="file" class="form-control d-none" id="brand_image" name="image">
                                                  <br>
                                                  <label for="brand_image" class="form-label">Current Image</label>
                                                  <img src="../uploads/banners/<?= $data['image']; ?>" alt="brand image" style="width: 100px; height: 100px;">
                                             </div>
                                            
                                             <div class="col-md-6">
                                                  <label for="status" class="form-label">Status</label>
                                                  <select class="form-select" id="status" name="status" required>
                                                       <option value="1" <?= $data['status'] == 1 ? 'selected' : ''; ?>>Active</option>
                                                       <option value="0" <?= $data['status'] == 0 ? 'selected' : ''; ?>>Inactive</option>
                                                  </select>
                                             </div>

                                             <div class="col-12 text-center">
                                                  <button type="submit" class="btn btn-primary" name="update_banner_btn">Update</button>
                                                  <button type="reset" class="btn btn-secondary">Reset</button>
                                             </div>
                                        </form>
                                   </div>
                              </div>
                    <?php
                         } else {
                              echo "<div class='alert alert-warning'>No record found.</div>";
                         }
                    } else {
                         echo "<div class='alert alert-danger'>Banner ID not set.</div>";
                    }
                    ?>
               </div>
          </div>
     </section>
</main>

<?php include('includes/footer.php'); ?>