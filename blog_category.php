<?php include 'includes/header.php'; ?>




<section id="wrapper">
     <!-- Inside your main content column, before the blog content: -->
     <nav aria-label="breadcrumb" class="breadcrumb-nav">
          <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="index.php">Home</a></li>

               <?php if (isset($blog['category'])): ?>
                    <li class="breadcrumb-item">
                         <a href="blog_category.php?slug=<?= urlencode($blog['category']) ?>">
                              <?= htmlspecialchars($blog['category']) ?>
                         </a>
                    </li>
               <?php endif; ?>
               <li style="color: #000;" class="breadcrumb-item active" aria-current="page">
                    <?= isset($blog['title']) ? htmlspecialchars($blog['title']) : 'Blog Details' ?>
               </li>
          </ol>
     </nav>
     <style>
          .breadcrumb {
               background-color: #e6edf5;

               margin-bottom: 20px;
          }
     </style>

     <div class="container">
          <div id="columns_inner">


               <div id="left-column" class="col-xs-12">

                    <div id="newproduct_block" class="block products-block">
                         <h4 class="block_title hidden-md-down">
                              New Products
                         </h4>
                         <h4
                              class="block_title hidden-lg-up"
                              data-target="#newproduct_block_toggle"
                              data-toggle="collapse">
                              New products
                              <span class="pull-xs-right">
                                   <span class="navbar-toggler collapse-icons">
                                        <i class="fa-icon add"></i>
                                        <i class="fa-icon remove"></i>
                                   </span>
                              </span>
                         </h4>

                         <div id="newproduct_block_toggle" class="block_content collapse">
                              <div class="products">
                                   <?php
                                   // Fetch 5 random active products and their primary image
                                   $query = "
                SELECT
                    p.id,
                    p.product_name,
                    p.selling_price,
                    p.rating,
                    pi.image_path       AS product_image,
                    pi.alt_text         AS product_image_alt
                FROM products AS p
                LEFT JOIN product_images AS pi
                    ON p.id = pi.product_id
                    AND pi.is_primary = 1
                WHERE p.status = '1'
                ORDER BY RAND()
                LIMIT 5
            ";
                                   $result = mysqli_query($conn, $query);

                                   if ($result && mysqli_num_rows($result) > 0):
                                        while ($row = mysqli_fetch_assoc($result)):
                                             $product_id    = (int)$row['id'];
                                             $product_name  = $row['product_name'];
                                             $selling_price = (float)$row['selling_price'];
                                             $rating        = (int)$row['rating'];

                                             // Determine correct image path
                                             $rawImg     = trim($row['product_image'] ?? '');
                                             $altText    = trim($row['product_image_alt'] ?? '');
                                             $defaultImg = 'uploads/shop/default.png'; // fallback

                                             if (
                                                  $rawImg !== '' &&
                                                  file_exists(__DIR__ . '/' . $rawImg)
                                             ) {
                                                  $imgSrc = $rawImg;
                                                  $imgAlt = $altText !== '' ? $altText : $product_name;
                                             } else {
                                                  $imgSrc = $defaultImg;
                                                  $imgAlt = $product_name;
                                             }
                                   ?>
                                             <article class="product_item">
                                                  <div class="product-miniature js-product-miniature" data-id-product="<?= $product_id ?>">
                                                       <div class="product_thumbnail">
                                                            <a href="shop-product.php?id=<?= $product_id ?>" class="thumbnail product-image">
                                                                 <img
                                                                      class="lazyload"
                                                                      src="loader.svg"
                                                                      data-src="<?= htmlspecialchars($imgSrc, ENT_QUOTES, 'UTF-8') ?>"
                                                                      alt="<?= htmlspecialchars($imgAlt, ENT_QUOTES, 'UTF-8') ?>"
                                                                      loading="lazy"
                                                                      width="140"
                                                                      height="140">
                                                            </a>
                                                       </div>

                                                       <div class="product-info">
                                                            <h3 class="h3 product-title">
                                                                 <a href="shop-product.php?id=<?= $product_id ?>">
                                                                      <?= htmlspecialchars($product_name, ENT_QUOTES, 'UTF-8') ?>
                                                                 </a>
                                                            </h3>

                                                            <div class="comments_note">
                                                                 <div class="star_content clearfix">
                                                                      <?php for ($i = 0; $i < 5; $i++): ?>
                                                                           <div class="star <?= $i < $rating ? 'star_on' : '' ?>"></div>
                                                                      <?php endfor; ?>
                                                                 </div>
                                                                 <span class="total-rating">1 Review(s)</span>
                                                            </div>

                                                            <div class="product-price-and-shipping">
                                                                 <span class="price" aria-label="Price">
                                                                      Kes<?= number_format($selling_price, 2) ?>
                                                                 </span>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </article>
                                        <?php
                                        endwhile;
                                   else:
                                        ?>
                                        <p>No products found.</p>
                                   <?php endif; ?>
                              </div>

                              <div class="view_more">
                                   <a class="all-product-link btn btn-primary" href="shop.php" title="All new products">
                                        All new products
                                   </a>
                              </div>
                         </div>
                    </div>


                    <!-- Block categories module -->
                    <div id="blockcategories" class="block blockcategories">
                         <h4 class="block_title hidden-md-down">
                              Categories
                         </h4>
                         <h4 class="block_title hidden-lg-up" data-target="#blockcategories_toggle" data-toggle="collapse">
                              Categories
                              <span class="pull-xs-right">
                                   <span class="navbar-toggler collapse-icons">
                                        <i class="fa-icon add"></i>
                                        <i class="fa-icon remove"></i>
                                   </span>
                              </span>
                         </h4>
                         <div id="blockcategories_toggle" class="block_content  collapse">
                              <?php
                              // Fetch blog categories where status is active (1)
                              $stmt = $conn->prepare("SELECT id, name, slug FROM blog_categories WHERE status = 1 ORDER BY name ASC");
                              $stmt->execute();
                              $result = $stmt->get_result();

                              if ($result->num_rows > 0): ?>
                                   <ul class="block_content_list list-unstyled">
                                        <?php while ($row = $result->fetch_assoc()):
                                             $categoryId = htmlspecialchars($row['id']);
                                             $categoryName = htmlspecialchars($row['name']);
                                             $categorySlug = htmlspecialchars($row['slug']);
                                        ?>
                                             <li>
                                                  <a href="blog_category.php?slug=<?= $categorySlug ?>" title="<?= $categoryName ?>">
                                                       <?= $categoryName ?>
                                                  </a>
                                             </li>
                                        <?php endwhile; ?>
                                   </ul>
                              <?php else: ?>
                                   <p>No categories found.</p>
                              <?php endif;

                              // Close the statement
                              $stmt->close();
                              ?>


                         </div>
                    </div>
                    <!-- /Block categories module -->

               </div>


               <div id="content-wrapper" class="js-content-wrapper left-column col-xs-12 col-sm-8 col-md-9">



                    <div id="blog-category" class="blogs-container">
                         <?php

                         if (isset($_GET['slug'])) {
                              $slug = $_GET['slug'];

                              // Fetch category details by slug
                              $stmt = $conn->prepare("SELECT id, name, slug, description, image FROM blog_categories WHERE slug = ? AND status = 1 LIMIT 1");
                              $stmt->bind_param("s", $slug);
                              $stmt->execute();
                              $result = $stmt->get_result();

                              if ($result->num_rows === 1) {
                                   $category = $result->fetch_assoc();
                                   $categoryName = htmlspecialchars($category['name']);
                                   $categoryDescription = htmlspecialchars($category['description']);
                                   $categoryImage = !empty($category['image']) ? $category['image'] : 'default-category.jpg'; // use default if empty
                              } else {
                                   echo "<p>Category not found.</p>";
                                   exit;
                              }

                              $stmt->close();
                         } else {
                              echo "<p>Invalid request.</p>";
                              exit;
                         }
                         ?>

                         <!-- Now the category section -->
                         <div class="inner">
                              <div class="row">
                                   <div class="category-image col-xs-12 col-sm-6 col-lg-4 text-center">
                                        <img src="uploads/blogs/categories/<?= htmlspecialchars($categoryImage) ?>" class="img-fluid" alt="<?= $categoryName ?>">
                                   </div>
                                   <div class="col-xs-12 col-sm-12 col-lg-8 category-info caption">
                                        <h1><?= $categoryName ?></h1>
                                        <p><?= nl2br($categoryDescription) ?></p>
                                   </div>
                              </div>
                         </div>


                         <div class="recnet-blog">
                              <h3 class="recent-title h3">Recent blog posts</h3>

                              <?php
                              $query = "
        SELECT 
            b.*, 
            c.name AS category_name, 
            c.slug AS category_slug
        FROM blogs b
        LEFT JOIN blog_categories c ON b.category = c.id
        WHERE b.status = 1
        ORDER BY RAND()
    ";

                              $result = mysqli_query($conn, $query);
                              if (!$result) {
                                   die('Database error: ' . mysqli_error($conn));
                              }

                              $count = 0; // counter to group posts by 3
                              ?>

                              <div class="secondary-blog">

                                   <?php while ($blog = mysqli_fetch_assoc($result)) :
                                        // Start a new row every 3 posts
                                        if ($count % 3 === 0) echo '<div class="row mb-4">';

                                        $createdAt = strtotime($blog['created_at']);
                                        $day = date('d', $createdAt);
                                        $month = date('F', $createdAt);
                                        $year = date('Y', $createdAt);
                                   ?>
                                        <div class="col-lg-4 mb-4">
                                             <article class="blog-post item">
                                                  <div class="blog-item">
                                                       <div class="blog-image text-xs-center">
                                                            <a href="blog-details.php?slug=<?= htmlspecialchars($blog['slug']) ?>"
                                                                 title="<?= htmlspecialchars($blog['title']) ?>" class="link">
                                                                 <img src="uploads/blogs/<?= htmlspecialchars($blog['image']) ?>"
                                                                      alt="<?= htmlspecialchars($blog['title']) ?>"
                                                                      class="img-fluid"
                                                                      width="500"
                                                                      height="500" />
                                                                 <span class="post-image-hover"></span>
                                                            </a>

                                                            <span class="blogicons">
                                                                 <a title="Click to view Full Image"
                                                                      href="uploads/blogs/<?= htmlspecialchars($blog['image']) ?>"
                                                                      data-lightbox="example-set" class="icon zoom">&nbsp;</a>
                                                                 <a title="Click to view Read More"
                                                                      href="blog-details.php?slug=<?= htmlspecialchars($blog['slug']) ?>"
                                                                      class="icon readmore_link">&nbsp;</a>
                                                            </span>
                                                       </div>

                                                       <div class="blog-content-wrap">
                                                            <div class="blog-meta">
                                                                 <span class="blog-created">
                                                                      <i class="fa fa-calendar"></i>
                                                                      <time class="date" datetime="<?= date('Y-m-d', $createdAt) ?>">
                                                                           <?= $day ?> <?= $month ?>, <?= $year ?>
                                                                      </time>
                                                                 </span>

                                                                 <span class="blog-cat">
                                                                      <i class="fa fa-list"></i>
                                                                      <a href="blog-category.php?slug=<?= htmlspecialchars($blog['category_slug']) ?>"
                                                                           title="<?= htmlspecialchars($blog['category_name']) ?>">
                                                                           <?= htmlspecialchars($blog['category_name']) ?>
                                                                      </a>
                                                                 </span>
                                                            </div>

                                                            <h4 class="title">
                                                                 <a href="blog-details.php?slug=<?= htmlspecialchars($blog['slug']) ?>"
                                                                      title="<?= htmlspecialchars($blog['title']) ?>">
                                                                      <?= htmlspecialchars($blog['title']) ?>
                                                                 </a>
                                                            </h4>

                                                            <div class="blog-shortinfo">
                                                                 <?= htmlspecialchars(substr($blog['description'], 0, 150)) ?>...
                                                            </div>

                                                            <div class="readmore">
                                                                 <a href="blog-details.php?slug=<?= htmlspecialchars($blog['slug']) ?>"
                                                                      title="<?= htmlspecialchars($blog['title']) ?>">
                                                                      Read more
                                                                 </a>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </article>
                                        </div>

                                   <?php
                                        $count++;
                                        // Close the row every 3 posts
                                        if ($count % 3 === 0) echo '</div>';
                                   endwhile;

                                   // If not closed and total blogs not multiple of 3, close the last row
                                   if ($count % 3 !== 0) echo '</div>';
                                   ?>
                              </div>

                              <div class="ps_sortPagiBar clearfix bottom-line">
                                   <div class="pagination">
                                        <div class="product-count col-md-4">
                                             Showing 1 - <?= $count ?> of <?= $count ?> items
                                        </div>

                                        <div id="pagination" class="col-md-8 clearfix">
                                             <!-- Pagination logic here if needed -->
                                        </div>
                                   </div>
                              </div>
                         </div>


                    </div>


               </div>




          </div>
     </div>

</section>





</body>

</html>


<!-- Quick View Modal -->
<div id="quickViewModal" class="custom-modal">
     <div class="custom-modal-dialog">
          <div class="custom-modal-content">
               <span class="close-modal">&times;</span>
               <div id="quick-view-content">
                    <!-- Product details will be loaded here -->
               </div>
          </div>
     </div>
</div>

<!-- jQuery -->

<script>
     $(document).ready(function() {
          // Open the Quick View Modal when clicking on the quick-view button
          $(".quick-view-btn").click(function(e) {
               e.preventDefault();
               var productId = $(this).data("product-id");

               $("#quick-view-content").html('<p class="text-center">Loading product details...</p>');
               $("#quickViewModal").fadeIn();

               // Fetch product details using AJAX
               $.ajax({
                    url: "ajax/fetch_product.php",
                    type: "POST",
                    data: {
                         product_id: productId
                    },
                    success: function(response) {
                         $("#quick-view-content").html(response);
                    },
                    error: function() {
                         $("#quick-view-content").html('<p class="text-danger text-center">Failed to load product details.</p>');
                    }
               });
          });

          // Close the modal when clicking on the close button
          $(".close-modal").click(function() {
               $("#quickViewModal").fadeOut();
          });

          // Close the modal if clicking outside the modal content
          $(window).click(function(e) {
               if ($(e.target).is("#quickViewModal")) {
                    $("#quickViewModal").fadeOut();
               }
          });

          // Quantity increase handler
          $(".quantity-increase").click(function() {
               var input = $(this).siblings(".quantity-input"); // Get the quantity input next to the button
               var currentValue = parseInt(input.val()); // Get the current quantity value
               var maxStock = parseInt(input.attr('max')); // Get the available stock from the 'max' attribute
               if (currentValue < maxStock) {
                    input.val(currentValue + 1); // Increase quantity if it's less than max stock
               }
          });

          // Quantity decrease handler
          $(".quantity-decrease").click(function() {
               var input = $(this).siblings(".quantity-input"); // Get the quantity input next to the button
               var currentValue = parseInt(input.val()); // Get the current quantity value
               if (currentValue > 1) {
                    input.val(currentValue - 1); // Decrease quantity if it's greater than 1
               }
          });

          // Handle form submission for adding to cart
          $("form.quick-cart-form").on("submit", function(e) {
               e.preventDefault();
               var form = $(this);
               var formData = form.serialize();

               $.ajax({
                    url: 'ajax/code.php', // Adjust the path to your AJAX handler if needed
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                         if (response.status === 'success') {
                              Swal.fire({
                                   position: 'top-end',
                                   icon: 'success',
                                   title: response.message,
                                   showConfirmButton: false,
                                   timer: 2000,
                                   toast: true
                              });
                              form.find("button[type='submit']")
                                   .text("Update Cart")
                                   .removeClass("btn-primary")
                                   .addClass("btn-success");
                         } else {
                              Swal.fire({
                                   position: 'top-end',
                                   icon: 'error',
                                   title: response.message,
                                   showConfirmButton: false,
                                   timer: 2000,
                                   toast: true
                              });
                         }
                    },
                    error: function(xhr, status, error) {
                         Swal.fire({
                              position: 'top-end',
                              icon: 'error',
                              title: 'An error occurred while processing your request.',
                              showConfirmButton: false,
                              timer: 2000,
                              toast: true
                         });
                    }
               });
          });
     });
</script>
<style>
     /* Modal Styling */
     .custom-modal {
          display: none;
          position: fixed;
          z-index: 1050;
          left: 0;
          top: 0;
          width: 100%;
          height: 100%;
          overflow-y: auto;
          background-color: rgba(0, 0, 0, 0.6);
     }

     .custom-modal-dialog {
          position: relative;
          margin: 5% auto;
          max-width: 800px;
          width: 90%;
     }

     .custom-modal-content {
          background-color: #fff;
          padding: 25px;
          border-radius: 10px;
          position: relative;
          box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
     }

     .close-modal {
          position: absolute;
          top: 10px;
          right: 15px;
          font-size: 28px;
          font-weight: bold;
          color: #aaa;
          cursor: pointer;
     }

     .close-modal:hover {
          color: #000;
     }

     /* Quantity Button and Input Styling */
     .input-group {
          display: flex;
          justify-content: center;
          align-items: center;
     }

     .quantity-input {
          text-align: center;
          width: 60px;
          height: 40px;
          font-size: 18px;
          margin: 0 5px;
     }

     .quantity-decrease,
     .quantity-increase {
          font-size: 20px;
          width: 40px;
          height: 40px;
          background-color: #f0f0f0;
          border: 1px solid #ccc;
          cursor: pointer;
          display: flex;
          justify-content: center;
          align-items: center;
     }

     .quantity-decrease:hover,
     .quantity-increase:hover {
          background-color: #ddd;
     }

     /* Adjust the button when the quantity is already in the cart */
     .in-cart-message {
          margin-top: 10px;
          font-size: 14px;
          color: green;
     }

     .btn-success {
          background-color: #28a745;
          color: white;
     }

     .btn-primary {
          background-color: #007bff;
          color: white;
     }
</style>

<?php include 'includes/footer.php'; ?>