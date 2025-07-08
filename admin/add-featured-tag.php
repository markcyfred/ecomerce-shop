<?php
include('../middleware/adminMiddleware.php');
include('includes/header.php');
?>

<main id="main" class="main">
     <div class="pagetitle">
          <h1>Add Featured Tag</h1>
          <nav>
               <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="featured-tags-manage.php">Featured Tags</a></li>
                    <li class="breadcrumb-item active">Add Tag</li>
               </ol>
          </nav>
     </div>

     <section class="section">
          <form action="code.php" method="POST">
               <div class="card">
                    <div class="card-body">
                         <div class="row py-3">

                              <div class="col-md-6">
                                   <label for="tag_name" class="form-label">Tag Name</label>
                                   <input type="text" name="tag_name" class="form-control" placeholder="e.g. Trending, Deals" required>
                              </div>

                              <div class="col-12 mt-4">
                                   <label class="form-label">Choose Product Type to Assign Tag</label>
                                   <div>
                                        <input type="radio" name="product_type" id="realProducts" value="real">
                                        <label for="realProducts">Use Real Products</label>

                                        <input type="radio" name="product_type" id="dummyProducts" value="dummy" style="margin-left: 20px;">
                                        <label for="dummyProducts">Use Dummy Products</label>
                                   </div>
                              </div>

                              <!-- Initially hidden -->
                              <div class="col-12 mt-3" id="realProductsList" style="display:none;">
                                   <label class="form-label">Select Real Products</label>
                                   <div class="row">
                                        <?php
                                        $products = mysqli_query($conn, "SELECT id, product_name FROM products WHERE status='1'");
                                        if (mysqli_num_rows($products) > 0) {
                                             foreach ($products as $product) {
                                        ?>
                                                  <div class="col-md-4">
                                                       <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="product_ids[]" value="<?= $product['id']; ?>" id="product<?= $product['id']; ?>">
                                                            <label class="form-check-label" for="product<?= $product['id']; ?>">
                                                                 <?= htmlspecialchars($product['product_name']); ?>
                                                            </label>
                                                       </div>
                                                  </div>
                                        <?php
                                             }
                                        } else {
                                             echo "<p class='text-muted'>No active products found</p>";
                                        }
                                        ?>
                                   </div>
                              </div>

                              <!-- Initially hidden -->
                              <div class="col-12 mt-3" id="dummyProductsList" style="display:none;">
                                   <label class="form-label">Select Dummy Products</label>

                                   <p><strong>Available Dummy Products (selectable):</strong></p>
                                   <div class="row">
                                        <?php
                                        $availableDummies = mysqli_query($conn, "SELECT id, product_name FROM products WHERE status=0 AND (featured IS NULL OR featured = '')");
                                        if (mysqli_num_rows($availableDummies) > 0) {
                                             foreach ($availableDummies as $dummy) {
                                        ?>
                                                  <div class="col-md-4">
                                                       <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="product_ids[]" value="<?= $dummy['id']; ?>" id="dummyAvailable<?= $dummy['id']; ?>">
                                                            <label class="form-check-label" for="dummyAvailable<?= $dummy['id']; ?>">
                                                                 <?= htmlspecialchars($dummy['product_name']); ?>
                                                            </label>
                                                       </div>
                                                  </div>
                                        <?php
                                             }
                                        } else {
                                             echo "<p class='text-muted'>No available dummy products</p>";
                                        }
                                        ?>
                                   </div>

                                   <p class="mt-3"><strong>Used Dummy Products (disabled):</strong></p>
                                   <div class="row">
                                        <?php
                                        $usedDummies = mysqli_query($conn, "SELECT id, product_name, featured FROM products WHERE status=0 AND featured IS NOT NULL AND featured != ''");
                                        if (mysqli_num_rows($usedDummies) > 0) {
                                             foreach ($usedDummies as $dummy) {
                                        ?>
                                                  <div class="col-md-4">
                                                       <div class="form-check disabled">
                                                            <input class="form-check-input" type="checkbox" disabled>
                                                            <label class="form-check-label" for="dummyUsed<?= $dummy['id']; ?>">
                                                                 <?= htmlspecialchars($dummy['product_name']) . " (Tag: " . htmlspecialchars($dummy['featured']) . ")"; ?>
                                                            </label>
                                                       </div>
                                                  </div>
                                        <?php
                                             }
                                        } else {
                                             echo "<p class='text-muted'>No used dummy products</p>";
                                        }
                                        ?>
                                   </div>
                              </div>

                              <div class="col-12 mt-4">
                                   <button type="submit" name="add_featured_tag_btn" class="btn btn-primary">Assign Tag</button>
                                   <a href="featured-tags-manage.php" class="btn btn-secondary">Cancel</a>
                              </div>

                         </div>
                    </div>
               </div>
          </form>
     </section>
</main>

<script>
     // Hide both lists initially
     document.getElementById('realProductsList').style.display = 'none';
     document.getElementById('dummyProductsList').style.display = 'none';

     document.querySelectorAll('input[name="product_type"]').forEach((elem) => {
          elem.addEventListener('change', function() {
               if (this.value === 'real') {
                    document.getElementById('realProductsList').style.display = 'block';
                    document.getElementById('dummyProductsList').style.display = 'none';

                    // Clear dummy checkboxes on switch
                    document.querySelectorAll('#dummyProductsList input[type="checkbox"]').forEach(cb => cb.checked = false);
               } else if (this.value === 'dummy') {
                    document.getElementById('realProductsList').style.display = 'none';
                    document.getElementById('dummyProductsList').style.display = 'block';

                    // Clear real product checkboxes on switch
                    document.querySelectorAll('#realProductsList input[type="checkbox"]').forEach(cb => cb.checked = false);
               }
          });
     });
</script>

<?php include('includes/footer.php'); ?>
