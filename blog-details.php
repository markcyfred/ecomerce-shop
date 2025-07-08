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
                         <h4 class="block_title hidden-lg-up" data-target="#newproduct_block_toggle" data-toggle="collapse">
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
                                             $rawImg      = trim($row['product_image'] ?? '');
                                             $altText     = trim($row['product_image_alt'] ?? '');
                                             $defaultImg  = 'uploads/shop/default.png'; // fallback

                                             if ($rawImg !== '' && file_exists(__DIR__ . '/' . $rawImg)) {
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




                    <div id="blogpage">
                         <?php
                         // Get slug from URL
                         $slug = isset($_GET['slug']) ? $_GET['slug'] : '';

                         // Prepare and execute query safely
                         $stmt = $conn->prepare("SELECT id,category, title, published_date, author_name, image, description, meta_keywords FROM blogs WHERE slug = ?");
                         $stmt->bind_param("s", $slug);
                         $stmt->execute();
                         $result = $stmt->get_result();

                         if ($result->num_rows == 0) {
                              echo "Blog post not found.";
                              exit;
                         }

                         $blog = $result->fetch_assoc();

                         // Close the statement
                         $stmt->close();
                         ?>
                         <article class="blog-detail">

                              <div class="blog-image">
                                   <img
                                        src="uploads/blogs/<?php echo htmlspecialchars($blog['image']); ?>"
                                        alt="<?php echo htmlspecialchars($blog['title']); ?>"
                                        title="<?php echo htmlspecialchars($blog['title']); ?>"
                                        class="img-fluid" />
                              </div>

                              <h2 class="blog-title"><?php echo htmlspecialchars($blog['title']); ?></h2>

                              <div class="blog-meta">
                                   <span class="blog-created">
                                        <i class="fa fa-calendar"></i> <?php echo date("F j, Y", strtotime($blog['published_date'])); ?>
                                   </span>

                                   <span class="blog-cat">
                                        <i class="fa fa-list"></i> <a href="" title="Business">
                                             <?php echo htmlspecialchars($blog['category']); ?>
                                        </a>
                                   </span>

                                   <span class="blog-author">
                                        <i class="fa fa-user-o"></i> Posted By:
                                        <?php echo htmlspecialchars($blog['author_name']); ?>
                                   </span>
                                   <?php

                                   $likeCount = 0;
                                   $like_stmt = $conn->prepare("SELECT COUNT(*) FROM likes WHERE blog_id = ?");
                                   $like_stmt->bind_param("i", $blog['id']);
                                   $like_stmt->execute();
                                   $like_stmt->bind_result($likeCount);
                                   $like_stmt->fetch();
                                   $like_stmt->close();

                                   $commentCount = 0;
                                   $comment_stmt = $conn->prepare("SELECT COUNT(*) FROM comments WHERE blog_id = ?");
                                   $comment_stmt->bind_param("i", $blog['id']);
                                   $comment_stmt->execute();
                                   $comment_stmt->bind_result($commentCount);
                                   $comment_stmt->fetch();
                                   $comment_stmt->close();
                                   ?>
                                   <span class="blog-ctncomment">
                                        <i class="fa fa-comments-o"></i> Comment:
                                        (<?= $commentCount ?>)
                                   </span>
                                   <form id="like-form" method="post" action="ajax/blog_ajax.php">
                                        <input type="hidden" name="blog_id" value="<?= htmlspecialchars($blog['id']) ?>">
                                        <input type="hidden" name="submitlike" value="1">
                                        <button type="submit" class="btn btn-outline-primary">
                                             👍 Like (<span id="like-count"><?= $likeCount; ?></span>)
                                        </button>
                                   </form>

                              </div>

                              <div class="blog-description">
                                   <p>
                                        <?php echo htmlspecialchars($blog['description']); ?>
                                   </p>
                              </div>







                    </div>

                    <div class="blog-tags">
                         <span>Tags:</span>
                         <?php
                         $tags = explode(',', $blog['meta_keywords']);
                         foreach ($tags as $tag) {
                              echo '<' . urlencode(trim($tag)) . '" title="' . htmlspecialchars(trim($tag)) . '"><span>' . htmlspecialchars(trim($tag)) . '</span></a>';
                         }
                         ?>
                    </div>

                    <div class="extra-blogs row">
                         <div class="col-lg-6 col-md-6 col-xs-12">
                              <h4>In Same Category</h4>
                              <?php
                              // fetch related blogs from the same category
                              $category = $blog['category'];  // No need to htmlspecialchars here when binding to SQL
                              $stmt = $conn->prepare("SELECT id, title, slug FROM blogs WHERE category = ? AND id != ? LIMIT 5");
                              $stmt->bind_param("si", $category, $blog['id']);
                              $stmt->execute();
                              $relatedBlogs = $stmt->get_result();

                              if ($relatedBlogs->num_rows > 0) {

                                   echo '<ul>';
                                   while ($relatedBlog = $relatedBlogs->fetch_assoc()) {
                                        $slug = htmlspecialchars(urlencode($relatedBlog['slug']));
                                        $title = htmlspecialchars($relatedBlog['title']);
                                        echo '<li><a href="blog-details.php?slug=' . $slug . '">' . $title . '</a></li>';
                                   }
                                   echo '</ul>';
                              } else {
                                   echo '<p>No related blogs found in this category.</p>';
                              }

                              // Close the statement
                              $stmt->close();
                              ?>


                         </div>
                         <div class="col-lg-6 col-md-6 col-xs-12">
                              <h4>Related by Tags</h4>
                              <?php
                              // fetch related blogs by tags
                              $tags = explode(',', $blog['meta_keywords']);
                              $relatedBlogsByTags = [];
                              foreach ($tags as $tag) {
                                   $tag = trim($tag);
                                   $stmt = $conn->prepare("SELECT id, title, slug FROM blogs WHERE meta_keywords LIKE ? AND id != ? LIMIT 5");
                                   $likeTag = '%' . $tag . '%';
                                   $stmt->bind_param("si", $likeTag, $blog['id']);
                                   $stmt->execute();
                                   $result = $stmt->get_result();

                                   while ($relatedBlog = $result->fetch_assoc()) {
                                        if (!in_array($relatedBlog, $relatedBlogsByTags)) {
                                             $relatedBlogsByTags[] = $relatedBlog;
                                        }
                                   }
                                   // Close the statement
                                   $stmt->close();
                              }
                              if (count($relatedBlogsByTags) > 0) {
                                   echo '<ul>';
                                   foreach ($relatedBlogsByTags as $relatedBlog) {
                                        $slug = htmlspecialchars(urlencode($relatedBlog['slug']));
                                        $title = htmlspecialchars($relatedBlog['title']);
                                        echo '<li><a href="blog-details.php?slug=' . $slug . '">' . $title . '</a></li>';
                                   }
                                   echo '</ul>';
                              } else {
                                   echo '<p>No related blogs found by tags.</p>';
                              }
                              ?>
                         </div>
                    </div>
                    <!-- Like Button Form -->
                    <form id="like-form" method="post" action="ajax/blog_ajax.php">
                         <input type="hidden" name="blog_id" value="<?= htmlspecialchars($blog['id']) ?>">
                         <input type="hidden" name="submitlike" value="1">
                         <button type="submit" class="btn btn-outline-primary">
                              👍 Like (<span id="like-count"><?= $likeCount; ?></span>)
                         </button>
                    </form>

                    <!-- Comment Form -->
                    <form class="form-horizontal" method="post" id="comment-form" action="ajax/blog_ajax.php">
                         <input type="hidden" name="blog_id" value="<?= htmlspecialchars($blog['id']) ?>">
                         <input type="hidden" name="submitcomment" value="1">

                         <div class="form-group row">
                              <label class="col-lg-3 col-form-label" for="inputFullName">Full Name</label>
                              <div class="col-lg-9">
                                   <input
                                        type="text"
                                        name="user_name"
                                        id="inputFullName"
                                        class="form-control"
                                        placeholder="Enter your full name"
                                        required>
                              </div>
                         </div>

                         <div class="form-group row">
                              <label class="col-lg-3 col-form-label" for="inputEmail">Email</label>
                              <div class="col-lg-9">
                                   <input
                                        type="email"
                                        name="user_email"
                                        id="inputEmail"
                                        class="form-control"
                                        placeholder="Enter your email"
                                        required>
                              </div>
                         </div>

                         <div class="form-group row">
                              <label class="col-lg-3 col-form-label" for="inputComment">Comment</label>
                              <div class="col-lg-9">
                                   <textarea
                                        name="comment"
                                        id="inputComment"
                                        class="form-control"
                                        rows="6"
                                        placeholder="Enter your comment"
                                        required></textarea>
                              </div>
                         </div>

                         <div class="form-group row">
                              <div class="col-lg-9 offset-md-3">
                                   <button class="btn btn-primary" type="submit">
                                        Submit
                                   </button>
                              </div>
                         </div>
                    </form>

                    <script>
                         document.addEventListener('DOMContentLoaded', function() {
                              // 1) Like form AJAX
                              const likeForm = document.getElementById('like-form');
                              const likeCount = document.getElementById('like-count');

                              likeForm.addEventListener('submit', function(e) {
                                   e.preventDefault();
                                   const formData = new FormData(likeForm);

                                   fetch(likeForm.action, {
                                             method: 'POST',
                                             headers: {
                                                  'X-Requested-With': 'XMLHttpRequest'
                                             },
                                             body: formData
                                        })
                                        .then(res => res.json())
                                        .then(data => {
                                             if (data.success) {
                                                  Swal.fire({
                                                       toast: true,
                                                       position: 'top-end',
                                                       icon: 'success',
                                                       title: data.message,
                                                       showConfirmButton: false,
                                                       timer: 2000,
                                                       background: 'white',
                                                       customClass: {
                                                            container: 'my-swal-container'
                                                       }
                                                  });
                                                  if (typeof data.likeCount !== 'undefined') {
                                                       likeCount.textContent = data.likeCount;
                                                  }
                                             } else {
                                                  Swal.fire({
                                                       toast: true,
                                                       position: 'top-end',
                                                       icon: 'error',
                                                       title: data.message,
                                                       showConfirmButton: false,
                                                       timer: 2000,
                                                       background: 'white',
                                                       customClass: {
                                                            container: 'my-swal-container'
                                                       }
                                                  });
                                             }
                                        })
                                        .catch(err => {
                                             Swal.fire({
                                                  toast: true,
                                                  position: 'top-end',
                                                  icon: 'error',
                                                  title: 'An error occurred. Please try again.',
                                                  showConfirmButton: false,
                                                  timer: 2000,
                                                  background: 'white',
                                                  customClass: {
                                                       container: 'my-swal-container'
                                                  }
                                             });
                                             console.error('Like AJAX error:', err);
                                        });
                              });

                              // 2) Comment form AJAX
                              const commentForm = document.getElementById('comment-form');

                              commentForm.addEventListener('submit', function(e) {
                                   e.preventDefault();
                                   const formData = new FormData(commentForm);

                                   fetch(commentForm.action, {
                                             method: 'POST',
                                             headers: {
                                                  'X-Requested-With': 'XMLHttpRequest'
                                             },
                                             body: formData
                                        })
                                        .then(res => res.json())
                                        .then(data => {
                                             if (data.success) {
                                                  Swal.fire({
                                                       toast: true,
                                                       position: 'top-end',
                                                       icon: 'success',
                                                       title: data.message,
                                                       showConfirmButton: false,
                                                       timer: 2000,
                                                       background: 'white',
                                                       customClass: {
                                                            container: 'my-swal-container'
                                                       }
                                                  });
                                                  // Clear only the comment field
                                                  commentForm.querySelector('textarea[name="comment"]').value = '';
                                             } else {
                                                  Swal.fire({
                                                       toast: true,
                                                       position: 'top-end',
                                                       icon: 'error',
                                                       title: data.message,
                                                       showConfirmButton: false,
                                                       timer: 2000,
                                                       background: 'white',
                                                       customClass: {
                                                            container: 'my-swal-container'
                                                       }
                                                  });
                                             }
                                        })
                                        .catch(err => {
                                             Swal.fire({
                                                  toast: true,
                                                  position: 'top-end',
                                                  icon: 'error',
                                                  title: 'An error occurred. Please try again.',
                                                  showConfirmButton: false,
                                                  timer: 2000,
                                                  background: 'white',
                                                  customClass: {
                                                       container: 'my-swal-container'
                                                  }
                                             });
                                             console.error('Comment AJAX error:', err);
                                        });
                              });
                         });
                    </script>



                    </article>
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