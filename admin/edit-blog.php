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
          <h1>Edit Blog</h1>
          <nav>
               <ol class="breadcrumb">
                    <li class="breadcrumb-item">Edit Blog</li>
                    <a href="blogs-add.php" title="Add new blog">
                         <i class="ri-menu-add-line"></i> Add Blog
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
                         $blog = getByID("blogs", $id);

                         if (mysqli_num_rows($blog) > 0) {
                              $data = mysqli_fetch_array($blog);

                    ?>
                              <div class="card">
                                   <div class="card-body">
                                        <h5 class="card-title">Edit Blog Post</h5>

                                        <form action="code.php" method="POST" enctype="multipart/form-data" class="row g-3">
                                             <input type="hidden" name="blog_id" value="<?= $data['id'] ?>">
                                             

                                             <div class="col-md-6">
                                                  <label for="title" class="form-label">Title</label>
                                                  <input type="text" class="form-control" id="title" name="title" value="<?= $data['title'] ?>" required>
                                             </div>

                                             <div class="col-md-6">
                                                  <label for="slug" class="form-label">Slug</label>
                                                  <input type="text" class="form-control" id="slug" name="slug" value="<?= $data['slug'] ?>" placeholder="Auto-generated if empty">
                                             </div>

                                             <div class="col-md-6">
                                                  <label for="published_date" class="form-label">Published Date</label>
                                                  <input type="date" class="form-control" id="published_date" name="published_date" value="<?= $data['published_date'] ?>">
                                             </div>

                                             <div class="col-md-6">
                                                  <label for="category_id" class="form-label">Category</label>
                                                  <select class="form-select" id="category_id" name="category_id" required>
                                                      
                                                       <?php
                                                       $categories = getAll("blog_categories");
                                                       if (mysqli_num_rows($categories) > 0) {
                                                            foreach ($categories as $category) {
                                                                 $selected = ($data['category_id'] == $category['id']) ? 'selected' : '';
                                                       ?>
                                                                 <option value="<?= htmlspecialchars($category['id']) ?>" <?= $selected ?>>
                                                                      <?= htmlspecialchars($category['name']) ?>
                                                                 </option>
                                                       <?php
                                                            }
                                                       }
                                                       ?>
                                                  </select>
                                             </div>


                                             <div class="col-md-6">
                                                  <label for="author_name" class="form-label">Author Name</label>
                                                 <!--update to locked not editable-->
                                                  <input type="text" class="form-control" id="author_name" name="author_name" value="<?= $data['author_name'] ?>" readonly>
                                             </div>

                                             <div class="col-md-6">
                                                  <label for="tags" class="form-label">Tags (comma separated)</label>
                                                  <input type="text" class="form-control" id="tags" name="meta_keywords" value="<?= $data['meta_keywords'] ?>">
                                             </div>

                                             <div class="col-md-12">
                                                  <label for="content" class="form-label">Content</label>
                                                  <textarea class="form-control" id="content" name="description" rows="6"><?= $data['description'] ?></textarea>
                                             </div>

                                             <div class="col-md-6">
                                                  <input type="hidden" name="old_image" value="<?= $data['image']; ?>">
                                                  <label for="image" class="form-label">Image</label>
                                                  <div class="drop-zone" id="dropZone">Drag & Drop Image Here or Click to Select</div>
                                                  <input type="file" class="form-control d-none" id="brand_image" name="image">
                                                  <br>
                                                  <label class="form-label">Current Image</label><br>
                                                  <img src="../uploads/blogs/<?= $data['image']; ?>" alt="Current Image" style="width: 100px; height: 100px; object-fit: cover;">
                                             </div>

                                             <div class="col-md-6">
                                                  <label for="status" class="form-label">Status</label>
                                                  <i class="bi bi-info-circle-fill text-secondary" title="Published: Visible to all, Draft: Only visible to admin"></i>
                                                  <select class="form-control" id="status" name="status">
                                                       <option value="1" <?= $data['status'] == 1 ? 'selected' : '' ?>>Published</option>
                                                       <option value="0" <?= $data['status'] == 0 ? 'selected' : '' ?>>Draft</option>
                                                  </select>
                                             </div>

                                             <div class="col-12 text-center">
                                                  <button type="submit" class="btn btn-primary" name="update_blog_btn">Update Blog</button>
                                             </div>
                                        </form>
                                   </div>
                              </div>
                    <?php
                         } else {
                              echo "<h4>Blog not found</h4>";
                         }
                    } else {
                         echo "<h4>ID missing from URL</h4>";
                    }
                    ?>
               </div>
          </div>
     </section>
</main>


<?php include('includes/footer.php'); ?>