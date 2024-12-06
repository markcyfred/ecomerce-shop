<?php include "includes/header.php"; ?>
<main class="main">
     <div class="page-header breadcrumb-wrap">
          <div class="container">
               <div class="breadcrumb">
                    <a href="index.html" rel="nofollow">Home</a>
                    <span></span> Shop
               </div>
          </div>
     </div>
     <section class="mt-50 mb-50">
          <div class="container">
               <div class="row flex-row-reverse">
                    <div class="col-lg-9">
                         <div class="shop-product-fillter">
                              <div class="totall-product">
                                   <p>We found <strong class="text-brand">
                                             <?php
                                             // Count all active products in the database
                                             $sql = "SELECT COUNT(*) AS total FROM products WHERE status = 1";
                                             $result = mysqli_query($conn, $sql);
                                             $row = mysqli_fetch_assoc($result);
                                             $totalProducts = $row['total'];
                                             echo $totalProducts;
                                             ?>
                                        </strong> items for you!</p>
                              </div>
                              <div class="sort-by-product-area">
                                   <div class="sort-by-cover mr-10">
                                        <div class="sort-by-product-wrap">
                                             <div class="sort-by">
                                                  <span><i class="fi-rs-apps"></i>Show:</span>
                                             </div>
                                             <div class="sort-by-dropdown-wrap">
                                                  <span><?php echo isset($_GET['show']) ? ($_GET['show'] == $totalProducts ? 'All' : $_GET['show']) : 15; ?> <i class="fi-rs-angle-small-down"></i></span>
                                             </div>
                                        </div>
                                        <div class="sort-by-dropdown">
                                             <ul>
                                                  <?php
                                                  // Define available options for "Show"
                                                  $options = [15, 30, 50, $totalProducts];
                                                  foreach ($options as $option) {
                                                       $isActive = (isset($_GET['show']) && $_GET['show'] == $option) ? 'active' : '';
                                                       $showValue = $option == $totalProducts ? 'All' : $option;
                                                       echo "<li><a class=\"$isActive\" href=\"?show=$option&page=1\">$showValue</a></li>";
                                                  }
                                                  ?>
                                             </ul>
                                        </div>
                                   </div>


                              </div>
                         </div>
                         <div class="row product-grid-3">
                              <?php
                              // Get the selected "Show" value or default to 15
                              $productsPerPage = isset($_GET['show']) ? (int)$_GET['show'] : 15;

                              // If "Show" is "All", set productsPerPage to totalProducts
                              if ($productsPerPage === $totalProducts) {
                                   $productsPerPage = $totalProducts; // Display all products
                              }

                              // Pagination logic
                              $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                              $totalPages = $productsPerPage > 0 ? ceil($totalProducts / $productsPerPage) : 1;

                              // Ensure the current page is within valid range
                              $currentPage = max(1, min($currentPage, $totalPages));

                              // Calculate the OFFSET for SQL
                              $offset = ($currentPage - 1) * $productsPerPage;

                              // Fetch products with LIMIT and OFFSET
                              $sql = "SELECT * FROM products WHERE status = 1 LIMIT $productsPerPage OFFSET $offset";
                              $result = mysqli_query($conn, $sql);

                              // Display each product
                              while ($row = mysqli_fetch_assoc($result)) {
                              ?>
                                   <div class="col-lg-4 col-md-4 col-12 col-sm-6">
                                        <div class="product-cart-wrap mb-30">
                                             <div class="product-img-action-wrap">
                                                  <div class="product-img product-img-zoom">
                                                       <a href="shop-product.php?id=<?= $row['id']; ?>">
                                                            <img src="uploads/shop/<?php echo $row['image']; ?>" alt="<?php echo $row['product_name']; ?>">
                                                       </a>
                                                  </div>
                                                  <div class="product-action-1">
                                                       <a aria-label="Quick view" class="action-btn hover-up" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                                            <i class="fi-rs-search"></i></a>
                                                       <a aria-label="Add To Wishlist" class="action-btn hover-up" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                                       <a aria-label="Compare" class="action-btn hover-up" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                                  </div>
                                                  <div class="product-badges product-badges-position product-badges-mrg">
                                                       <span class="hot">
                                                            <?php echo $row['featured']; ?>
                                                       </span>
                                                  </div>
                                             </div>
                                             <div class="product-content-wrap">
                                                  <div class="product-category">
                                                       
                                                            <?= $row['category_name']; ?>
                                                      
                                                  </div>
                                                  <h2><a href="shop-product-right.html"><?php echo $row['product_name']; ?></a></h2>
                                                  <div>
                                                       <span>
                                                            <?php
                                                            $rating = $row['rating'];
                                                            for ($i = 0; $i < 5; $i++) {
                                                                 echo $rating > 0
                                                                      ? '<i class="fi-rs-star text-warning"></i>'
                                                                      : '<i class="fi-rs-star text-secondary"></i>';
                                                                 $rating--;
                                                            }
                                                            ?>
                                                       </span>
                                                  </div>
                                                  <div class="product-price">
                                                       <span>Kes<?= $row['selling_price']; ?></span>
                                                       <span class="old-price">Kes<?= $row['original_price']; ?></span>
                                                  </div>
                                                  <div class="product-action-1 show">
                                                       <a aria-label="Add To Cart" class="action-btn hover-up" href="shop-cart.html"><i class="fi-rs-shopping-bag-add"></i></a>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              <?php
                              }
                              ?>
                         </div>
                         <!-- Pagination -->
                         <div class="pagination-area mt-15 mb-sm-5 mb-lg-0">
                              <nav aria-label="Page navigation example">
                                   <ul class="pagination justify-content-start">
                                        <!-- Previous Button -->
                                        <li class="page-item <?php if ($currentPage <= 1) echo 'disabled'; ?>">
                                             <a class="page-link" href="?show=<?php echo $productsPerPage; ?>&page=<?php echo $currentPage - 1; ?>">
                                                  <i class="fi-rs-angle-double-small-left"></i>
                                             </a>
                                        </li>

                                        <!-- Page Numbers -->
                                        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                             <li class="page-item <?php if ($i == $currentPage) echo 'active'; ?>">
                                                  <a class="page-link" href="?show=<?php echo $productsPerPage; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                             </li>
                                        <?php endfor; ?>

                                        <!-- Next Button -->
                                        <li class="page-item <?php if ($currentPage >= $totalPages) echo 'disabled'; ?>">
                                             <a class="page-link" href="?show=<?php echo $productsPerPage; ?>&page=<?php echo $currentPage + 1; ?>">
                                                  <i class="fi-rs-angle-double-small-right"></i>
                                             </a>
                                        </li>
                                   </ul>
                              </nav>
                         </div>
                    </div>
                    <div class="col-lg-3 primary-sidebar sticky-sidebar">
                         <div class="widget-category mb-30">
                              <h5 class="section-title style-1 mb-30 wow fadeIn animated">Category</h5>
                              <ul class="categories">
                                   <?php
                                   // Fetch all categories
                                   $sql = "SELECT * FROM categories";
                                   $result = mysqli_query($conn, $sql);

                                   // Display each category
                                   while ($row = mysqli_fetch_assoc($result)) {
                                   ?>
                                        <li><a href="category.php?id=<?= $row['id']; ?>"><?= $row['name']; ?></a></li>
                                   <?php
                                   }
                                   ?>
                              </ul>
                         </div>
                         <!-- Fillter By Price -->
                         <div class="sidebar-widget price_range range mb-30">
                              <div class="widget-header position-relative mb-20 pb-10">
                                   <h5 class="widget-title mb-10">Fill by price</h5>
                                   <div class="bt-1 border-color-1"></div>
                              </div>
                              <div class="price-filter">
                                   <div class="price-filter-inner">
                                        <div id="slider-range"></div>
                                        <div class="price_slider_amount">
                                             <div class="label-input">
                                                  <span>Range:</span><input type="text" id="amount" name="price" placeholder="Add Your Price" />
                                             </div>
                                        </div>
                                   </div>
                              </div>
                              <div class="list-group">
                                   <div class="list-group-item mb-10 mt-10">
                                        <label class="fw-900">Color</label>
                                        <div class="custome-checkbox">
                                             <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox1" value="">
                                             <label class="form-check-label" for="exampleCheckbox1"><span>Red (56)</span></label>
                                             <br>
                                             <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox2" value="">
                                             <label class="form-check-label" for="exampleCheckbox2"><span>Green (78)</span></label>
                                             <br>
                                             <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox3" value="">
                                             <label class="form-check-label" for="exampleCheckbox3"><span>Blue (54)</span></label>
                                        </div>
                                        <label class="fw-900 mt-15">Item Condition</label>
                                        <div class="custome-checkbox">
                                             <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox11" value="">
                                             <label class="form-check-label" for="exampleCheckbox11"><span>New (1506)</span></label>
                                             <br>
                                             <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox21" value="">
                                             <label class="form-check-label" for="exampleCheckbox21"><span>Refurbished (27)</span></label>
                                             <br>
                                             <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox31" value="">
                                             <label class="form-check-label" for="exampleCheckbox31"><span>Used (45)</span></label>
                                        </div>
                                   </div>
                              </div>
                              <a href="" class="btn btn-sm btn-default"><i class="fi-rs-filter mr-5"></i> Fillter</a>
                         </div>
                         <!-- Product sidebar Widget -->
                         <div class="sidebar-widget product-sidebar  mb-30 p-30 bg-grey border-radius-10">
                              <div class="widget-header position-relative mb-20 pb-10">
                                   <h5 class="widget-title mb-10">New products</h5>
                                   <div class="bt-1 border-color-1"></div>
                              </div>
                              <?php
                              // Fetch 3 latest products featured = new
                              $sql = "SELECT * FROM products WHERE status = 1 AND featured = 'new' ORDER BY created_at DESC LIMIT 3";
                              $result = mysqli_query($conn, $sql);

                              // Display each product
                              while ($row = mysqli_fetch_assoc($result)) {
                              ?>
                                   <div class="single-post clearfix">
                                        <div class="image">
                                             <img src="uploads/shop/<?php echo $row['image']; ?>" alt="<?php echo $row['product_name']; ?>">
                                        </div>
                                        <div class="content pt-10">
                                             <h5><a href="shop-product.php?id=<?= $row['id']; ?>"><?php echo $row['product_name']; ?></a></h5>
                                             <p class="price mb-0 mt-5">Kes<?= $row['selling_price']; ?></p>
                                             <div class="product-rate">
                                                  <div class="product-rating" style="width:90%"></div>
                                             </div>
                                        </div>
                                   </div>
                              <?php
                              }
                              ?>

                         </div>
                         <div class="banner-img wow fadeIn mb-45 animated d-lg-block d-none">
                              <img src="assets/images/banner-10.jpg" alt="">
                              <div class="banner-text">
                                   <span>Women Zone</span>
                                   <h4>Save 17% on <br>Office Dress</h4>
                                   <a href="shop-grid-right.html">Shop Now <i class="fi-rs-arrow-right"></i></a>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </section>
</main>
<?php include "includes/footer.php"; ?>