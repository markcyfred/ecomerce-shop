<?php
include('../middleware/adminMiddleware.php');
include('includes/header.php');
?>

<style>
     .breadcrumb {
          display: flex;
          justify-content: space-between;
     }

     .drop-zone {
          border: 2px dashed #ccc;
          padding: 20px;
          text-align: center;
          cursor: pointer;
          border-radius: 5px;
          background-color: #f9f9f9;
     }
</style>

<main id="main" class="main">
     <div class="pagetitle">
          <h1>Edit Blog Category</h1>
          <nav>
               <ol class="breadcrumb">
                    <li class="breadcrumb-item">Edit Blog Category Forms</li>
                    <a href="add-blog-category.php" title="Add new category">
                         <i class="ri-menu-add-line"></i> Add Blog Category
                    </a>
                    <li class="breadcrumb-item active">
                         <a href="index.php"><i class="ri-arrow-go-back-fill"></i> Home</a>
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
                         $blog_category = getByID("blog_categories", $id); // Ensure correct table

                         if (mysqli_num_rows($blog_category) > 0) {
                              $data = mysqli_fetch_array($blog_category);
                    ?>
                              <div class="card">
                                   <div class="card-body">
                                        <h5 class="card-title">Edit Category</h5>

                                        <form action="code.php" method="POST" enctype="multipart/form-data" class="row g-3">
                                             <input type="hidden" name="category_id" value="<?= $data['id'] ?>">
                                             <input type="hidden" name="old_image" value="<?= $data['image']; ?>">

                                             <div class="col-md-6">
                                                  <label for="name" class="form-label">Category Name</label>
                                                  <input type="text" class="form-control" id="name" name="name" value="<?= $data['name'] ?>" required>
                                             </div>

                                             <div class="col-md-6">
                                                  <label for="slug" class="form-label">Slug</label>
                                                  <input type="text" class="form-control" id="slug" name="slug" value="<?= $data['slug'] ?>" placeholder="Auto-generated if empty">
                                             </div>

                                             <div class="col-md-12">
                                                  <label for="description" class="form-label">Description</label>
                                                  <textarea class="form-control" id="description" name="description" rows="3"><?= $data['description'] ?></textarea>
                                             </div>

                                             <div class="col-md-6">
                                                  <label for="image" class="form-label">Category Image</label>
                                                  <div class="drop-zone" id="dropZone">Drag & Drop Image Here or Click to Select</div>
                                                  <input type="file" class="form-control d-none" id="brand_image" name="image">
                                                  <br>
                                                  <label class="form-label">Current Image</label><br>
                                                  <img src="../uploads/blogs/categories/<?= $data['image']; ?>" alt="Current Image" style="width: 100px; height: 100px; object-fit: cover;">
                                             </div>
                                             <div class="col-md-6">
                                                  <label for="inputStatus" class="form-label">Status</label>
                                                  <div class="input-group">
                                                       <select class="form-control" id="inputStatus" name="status">
                                                            <option value="1" <?= $data['status'] == 1 ? 'selected' : '' ?>>Active</option>
                                                            <option value="0" <?= $data['status'] == 0 ? 'selected' : '' ?>>Inactive</option>
                                                       </select>
                                                       <span class="badge bg-success">
                                                            <?= $data['status'] == 1 ? '<span style="margin-top: 5px; display: inline-block;">Active</span>' : 'Inactive' ?>
                                                       </span>
                                                  </div>
                                             </div>

                                             <div class="col-12 text-center">
                                                  <button type="submit" class="btn btn-primary" name="update_blog_category_btn">Update</button>
                                             </div>
                                        </form>
                                   </div>
                              </div>
                    <?php
                         } else {
                              echo "<h4>Category not found</h4>";
                         }
                    } else {
                         echo "<h4>ID missing from URL</h4>";
                    }
                    ?>
               </div>
          </div>
     </section>
</main><!-- End #main -->



<?php include('includes/footer.php'); ?>