<?php include 'includes/header.php';
// Check if the `id` parameter is present in the URL
if (isset($_GET['id'])) {
     $product_id = intval($_GET['id']); // Sanitize the input

     // Fetch product details from the database
     $product_query = "SELECT * FROM products WHERE id = $product_id AND status = 1";
     $product_query_run = mysqli_query($conn, $product_query);

     // Check if the product exists
     if (mysqli_num_rows($product_query_run) > 0) {
          $product = mysqli_fetch_assoc($product_query_run);
     } else {
          echo "<p>Product not found</p>";
          exit;
     }
} else {
     echo "<p>Invalid product</p>";
     exit;
}

?>
<main class="main">
     <div class="page-header breadcrumb-wrap">
          <div class="container">
               <div class="breadcrumb">
                    <a href="index.html" rel="nofollow">Home</a>
                    <span></span> Fashion
                    <span></span> Abstract Print Patchwork Dress
               </div>
          </div>
     </div>
     <section class="mt-50 mb-50">
          <div class="container">
               <div class="row">
                    <div class="col-lg-9">
                         <div class="product-detail accordion-detail">
                              <div class="row mb-50">
                                   <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="detail-gallery">
                                             <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                                             <!-- MAIN SLIDES -->
                                             <div class="product-image-slider">
                                                  <figure class="border-radius-10">
                                                       <img src="uploads/shop/<?= $product['image']; ?>" alt="<?= $product['product_name']; ?>">
                                                  </figure>

                                             </div>
                                             <!-- THUMBNAILS -->
                                             <div class="slider-nav-thumbnails pl-15 pr-15">
                                                  <div>
                                                       <img src="uploads/shop/<?= $product['image']; ?>" alt="<?= $product['product_name']; ?>">
                                                  </div>
                                             </div>
                                        </div>

                                   </div>
                                   <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="detail-info">
                                             <h2 class="title-detail">
                                                  <?= $product['product_name']; ?>
                                             </h2>
                                             <div class="product-detail-rating">
                                                  <div class="pro-details-brand">
                                                       <span> <a href="shop-grid-right.html">
                                                                 <?= $product['category_name']; ?>
                                                            </a></span>
                                                  </div>
                                                  <div class="product-rate-cover text-end">
                                                       <div class="product-rate d-inline-block">
                                                            <div class="product-rating" style="width:<?= ($product['rating'] * 20); ?>%"></div>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="clearfix product-price-cover">
                                                  <div class="product-price primary-color float-left">
                                                       <ins><span class="text-brand">Kes <?= $product['selling_price']; ?></span></ins>
                                                       <ins><span class="old-price font-md ml-15">Kes <?= $product['original_price']; ?></span></ins>
                                                       <span class="save-price font-md color3 ml-15"><?= round(100 - (($product['selling_price'] / $product['original_price']) * 100)); ?>% Off</span>

                                                  </div>
                                             </div>
                                             <div class="bt-1 border-color-1 mt-15 mb-15"></div>
                                             <div class="short-desc mb-30">
                                                  <p><?= $product['description']; ?></p>
                                             </div>
                                             <div class="product_sort_info font-xs mb-30">
                                                  <ul>
                                                       <li class="mb-10"><i class="fi-rs-crown mr-5"></i> 1 Year Warranty</li>
                                                       <li class="mb-10"><i class="fi-rs-refresh mr-5"></i> 30 Day Return Policy</li>
                                                       <li><i class="fi-rs-credit-card mr-5"></i> Cash on Delivery available</li>
                                                  </ul>
                                             </div>

                                             <div class="attr-detail attr-size">
                                                  <strong class="mr-10">Size</strong>
                                                  <ul class="list-filter size-filter font-small">
                                                       <?php
                                                       $sizes = explode(',', $product['size']);
                                                       foreach ($sizes as $size) {
                                                            echo '<li><a href="#">' . $size . '</a></li>';
                                                       }
                                                       ?>
                                                  </ul>
                                             </div>
                                             <div class="bt-1 border-color-1 mt-30 mb-30"></div>
                                             <div class="detail-extralink">
                                                  <div class="detail-qty border radius">
                                                       <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                                       <span class="qty-val">1</span>
                                                       <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                                  </div>
                                                  <div class="product-extra-link2">
                                                       <button type="submit" class="button button-add-to-cart">Add to cart</button>
                                                       <a aria-label="Add To Wishlist" class="action-btn hover-up" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                                       <a aria-label="Compare" class="action-btn hover-up" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                                  </div>
                                             </div>
                                             <ul class="product-meta font-xs color-grey mt-50">

                                                  <li>Availability:<span class="in-stock text-success ml-5">8 Items In Stock</span></li>
                                             </ul>
                                        </div>
                                        <!-- Detail Info -->
                                   </div>
                              </div>

                              <div class="row mt-60">
                                   <div class="col-12">
                                        <h3 class="section-title style-1 mb-30">Related products</h3>
                                   </div>
                                   <div class="col-12">
                                        <div class="row related-products">
                                             <?php
                                             // Assuming you've already fetched the current product details
                                             $product_id = $_GET['id'];  // Get the clicked product's ID

                                             // Fetch product details
                                             $product_query = "SELECT * FROM products WHERE id = '$product_id'";
                                             $product_result = mysqli_query($conn, $product_query);

                                             if ($product_result && mysqli_num_rows($product_result) > 0) {
                                                  $product = mysqli_fetch_assoc($product_result);

                                                  // Get the category of the clicked product (Ensure 'category_name' exists in the products table)
                                                  $category_name = isset($product['category_name']) ? $product['category_name'] : null;

                                                  if ($category_name) {
                                                       // Fetch related products based on the same category (excluding the current product)
                                                       $related_query = "SELECT * FROM products WHERE status = 1 AND category_name = '$category_name' AND id != '$product_id' ORDER BY RAND() LIMIT 4";
                                                       $related_query_run = mysqli_query($conn, $related_query);

                                                       if (mysqli_num_rows($related_query_run) > 0) {
                                                            while ($related_product = mysqli_fetch_assoc($related_query_run)) {
                                             ?>
                                                                 <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                                                      <div class="product-cart-wrap small hover-up">
                                                                           <div class="product-img-action-wrap">
                                                                                <div class="product-img product-img-zoom">
                                                                                     <a href="shop-product.php?id=<?= $related_product['id']; ?>" tabindex="0">
                                                                                          <img class="default-img" src="uploads/shop/<?= $related_product['image']; ?>" alt="<?= $related_product['product_name']; ?>">
                                                                                     </a>
                                                                                </div>
                                                                           </div>
                                                                           <div class="product-content-wrap">
                                                                                <h2><a href="shop-product.php?id=<?= $related_product['id']; ?>" tabindex="0"><?= $related_product['product_name']; ?></a></h2>
                                                                                <div class="product-price">
                                                                                     <span>Kes<?= $related_product['selling_price']; ?></span>
                                                                                     <span class="old-price">Kes<?= $related_product['original_price']; ?></span>
                                                                                </div>
                                                                           </div>
                                                                      </div>
                                                                 </div>
                                             <?php
                                                            }
                                                       } else {
                                                            echo "<p>No related products available</p>";
                                                       }
                                                  } else {
                                                       echo "Category not found.";
                                                  }
                                             } else {
                                                  echo "Product not found.";
                                             }
                                             ?>

                                        </div>
                                   </div>
                              </div>

                         </div>
                    </div>
                    <div class="col-lg-3 primary-sidebar sticky-sidebar">
                         <div class="widget-category mb-30">
                              <h5 class="section-title style-1 mb-30 wow fadeIn animated">Category</h5>
                              <ul class="categories">
                                   <?php
                                   $category_query = "SELECT * FROM categories";
                                   $category_query_run = mysqli_query($conn, $category_query);
                                   if (mysqli_num_rows($category_query_run) > 0) {
                                        while ($category = mysqli_fetch_assoc($category_query_run)) {
                                   ?>
                                             <li><a href="category.php?id=<?= $category['id']; ?>"><?= $category['name']; ?></a></li>
                                   <?php
                                        }
                                   } else {
                                        echo "<p>No categories available</p>";
                                   }
                                   ?>

                              </ul>
                         </div>

                         <!-- Product sidebar Widget -->
                         <div class="sidebar-widget product-sidebar  mb-30 p-30 bg-grey border-radius-10">
                              <div class="widget-header position-relative mb-20 pb-10">
                                   <h5 class="widget-title mb-10">New products</h5>
                                   <div class="bt-1 border-color-1"></div>
                              </div>
                              <?php
                              $new_products_query = "SELECT * FROM products WHERE status = 1 ORDER BY created_at DESC LIMIT 3";
                              $new_products_query_run = mysqli_query($conn, $new_products_query);
                              if (mysqli_num_rows($new_products_query_run) > 0) {
                                   while ($new_product = mysqli_fetch_assoc($new_products_query_run)) {
                              ?>
                                        <div class="single-post clearfix">
                                             <div class="image">
                                                  <img src="uploads/shop/<?= $new_product['image']; ?>" alt="<?= $new_product['product_name']; ?>">
                                             </div>
                                             <div class="content pt-10">
                                                  <h5><a href="shop-product.php?id=<?= $new_product['id']; ?>"><?= $new_product['product_name']; ?></a></h5>
                                                  <p class="price mb-0 mt-5">Kes<?= $new_product['selling_price']; ?></p>
                                                  <div class="product-rate">
                                                       <div class="product-rating" style="width:<?= ($new_product['rating'] * 20); ?>%"></div>
                                                  </div>
                                             </div>
                                        </div>
                              <?php
                                   }
                              } else {
                                   echo "<p>No new products available</p>";
                              }
                              ?>

                         </div>
                    </div>
               </div>
          </div>
     </section>
</main>
<?php include 'includes/footer.php'; ?>