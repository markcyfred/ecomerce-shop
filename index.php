<?php include 'includes/header.php'; ?>
<section id="wrapper">
     <div class="home-container">
          <div id="columns_inner">

               <div id="content-wrapper" class="js-content-wrapper">
                    <section id="main">
                         <section id="content" class="page-home">
                              <section class="display-top-inner">

                                   <div class="flexslider" data-interval="8000" data-pause="true">
                                        <div class="loadingdiv spinner"></div>
                                        <ul class="slides">
                                             <li class="slide">
                                                  <a href="#" title="sample-1">
                                                       <img class="lazyload"
                                                            data-src="assets/img/hero-1.png"
                                                            alt="sample-1" title="Sample 1" />
                                                  </a>
                                                  <div class="caption-description">
                                                       <div class="container">
                                                            <div class="slide_content">
                                                                 <div class="headdings">
                                                                      <div class="headding_text">Flat 20% Discount</div>
                                                                      <div class="sub_headding">JBL Tune 510 Ear
                                                                           <span>Wireless Headphones</span>
                                                                      </div>
                                                                      <div class="price_text">From <span>kes 149.99</span>
                                                                      </div>
                                                                      <div class="button-shopnow"><a href="#"
                                                                                class="btn btn-primary">Shop Now</a>
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                  </div>

                                             </li>
                                             <li class="slide">
                                                  <a href="#" title="sample-2">
                                                       <img class="lazyload"
                                                            data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/modules/cz_imageslider/views/img/sample-2.jpg"
                                                            alt="sample-2" title="Sample 2" />
                                                  </a>
                                                  <div class="caption-description">
                                                       <div class="container">
                                                            <div class="slide_content">
                                                                 <div class="headdings">
                                                                      <div class="headding_text">Flat 30% Discount</div>
                                                                      <div class="sub_headding">VR Virtual Reality
                                                                           <span>Headset Smartphone</span>
                                                                      </div>
                                                                      <div class="price_text">From <span>$199.99</span>
                                                                      </div>
                                                                      <div class="button-shopnow"><a href="#"
                                                                                class="btn btn-primary">Shop Now</a>
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                  </div>

                                             </li>
                                        </ul>
                                   </div>

                                   <section id="czcategoryimagelist" class="czcategoryimagelist">
                                        <div class="czcategoryimage-container container">
                                             <div class="czcategoryimagelist-inner">
                                                  <h2 class="h1 products-section-title text-uppercase">Shop By Category
                                                  </h2>

                                                  <div class="customNavigation">
                                                       <a class="btn prev cat_prev">&nbsp;</a>
                                                       <a class="btn next cat_next">&nbsp;</a>
                                                  </div>


                                                  <div class="czcategoryimagelist_block">
                                                       <div class="czcategoryimagelist_row">
                                                            <div id="czcategoryimagelist-carousel"
                                                                 class="cz-carousel product_list product_slider_grid">
                                                                 <?php
                                                                 // 1) Use LEFT JOIN on products.category_name = categories.name
                                                                 $category_query = "
                                                                      SELECT
                                                                           c.id,
                                                                           c.name,
                                                                           c.image,
                                                                           COUNT(p.id) AS product_count
                                                                      FROM
                                                                           categories AS c
                                                                      LEFT JOIN
                                                                           products AS p
                                                                           ON p.category_name = c.name
                                                                           AND p.status = 1           -- only count active products
                                                                      WHERE
                                                                           c.status = 1
                                                                      GROUP BY
                                                                           c.id
                                                                      ORDER BY
                                                                           RAND()
                                                                      
                                                                      ";

                                                                 $category_query_run = mysqli_query($conn, $category_query);

                                                                 if (mysqli_num_rows($category_query_run) > 0) {
                                                                      while ($category = mysqli_fetch_assoc($category_query_run)) {
                                                                           $count = (int)$category['product_count'];
                                                                 ?>
                                                                           <article class="slider">
                                                                                <div class="categoryblock item">
                                                                                     <div class="block_content">
                                                                                          <div class="categoryimage">
                                                                                               <a href="category.php?id=<?= $category['id']; ?>">
                                                                                                    <img src="uploads/categories/<?= htmlspecialchars($category['image']); ?>"
                                                                                                         alt="<?= htmlspecialchars($category['name']); ?>">
                                                                                               </a>
                                                                                          </div>
                                                                                          <div class="categorylist">
                                                                                               <div class="cate-heading">
                                                                                                    <a href="category.php?id=<?= $category['id']; ?>">
                                                                                                         <?= htmlspecialchars($category['name']); ?>
                                                                                                    </a>
                                                                                               </div>
                                                                                               <div class="cate-quantity">
                                                                                                    <?= $count; ?> Product<?= $count === 1 ? '' : 's'; ?>
                                                                                                    <div class="more">
                                                                                                         <a href="category.php?id=<?= $category['id']; ?>" class="btn btn-primary">
                                                                                                              Shop Now
                                                                                                         </a>
                                                                                                    </div>
                                                                                               </div>
                                                                                          </div>
                                                                                     </div>
                                                                                </div>
                                                                           </article>
                                                                 <?php
                                                                      }
                                                                 } else {
                                                                      echo "<p>No categories available</p>";
                                                                 }
                                                                 ?>

                                                            </div>

                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </section>
                                   <section id="czsubbannercmsblock" class="block czsubbanners">
                                        <div class="czsubbanner_container container">
                                             <div class="subbanners">
                                                  <div class="one-half subbanner-part1">
                                                       <div class="subbanner-inner">
                                                            <div class="subbanner subbanner1"><a class="banner-anchor"
                                                                      href="#"><img class="banner-image1"
                                                                           alt="sub-banner1"
                                                                           src="assets/img/cta-1.svg"
                                                                           width="516" height="250" /></a>
                                                                 <div class="subbanner-text">
                                                                      <div class="main-title">Latest men
                                                                           <span>clothes</span>
                                                                      </div>
                                                                      <div class="offer-title">From <span>Kes 1500.00</span>
                                                                      </div>
                                                                      <div class="shopnow"><a class="btn btn-primary"
                                                                                href="category.php?id=3">Shop Now</a></div>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="subbanners">
                                                       <div class="one-half subbanner-part2">
                                                            <div class="subbanner-inner">
                                                                 <div class="subbanner subbanner1"><a
                                                                           class="banner-anchor" href="#"><img
                                                                                class="banner-image1" alt="sub-banner1"
                                                                                src="assets/img/cta-2.svg"
                                                                                width="516" height="250" /></a>
                                                                      <div class="subbanner-text">
                                                                           <div class="main-title">Best
                                                                                <span>Shoes</span>
                                                                           </div>
                                                                           <div class="offer-title">From
                                                                                <span>Kes 1200.00</span>
                                                                           </div>
                                                                           <div class="shopnow"><a
                                                                                     class="btn btn-primary"
                                                                                     href="category.php?id=1">Shop Now</a></div>
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                       <div class="subbanners">
                                                            <div class="one-half subbanner-part3">
                                                                 <div class="subbanner-inner">
                                                                      <div class="subbanner subbanner1"><a
                                                                                class="banner-anchor" href="#"><img
                                                                                     class="banner-image1"
                                                                                     alt="sub-banner1"
                                                                                     src="assets/img/cta-3.svg"
                                                                                     width="516" height="250" /></a>
                                                                           <div class="subbanner-text">
                                                                                <div class="main-title">Women's
                                                                                     <span>Clothes</span>
                                                                                </div>
                                                                                <div class="offer-title">From
                                                                                     <span>kes 500.00</span>
                                                                                </div>
                                                                                <div class="shopnow"><a
                                                                                          class="btn btn-primary"
                                                                                          href="category.php?id=7">Shop Now</a></div>
                                                                           </div>
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </section>

                              </section>

                              <section id="czcategorytabs" class="tabs products-section products_block clearfix">
                                   <div class="container">
                                        <h2 style="color: #333;" class="h1 products-section-title text-uppercase">
                                             Best Products Tags
                                        </h2>
                                        <div class="czcategory-tab">
                                             <ul id="czcategory-tabs" class="nav nav-tabs clearfix">
                                                  <?php
                                                  $sql = "SELECT tag_name, description, order_num FROM tags WHERE status = 1 ORDER BY order_num ASC LIMIT 5";
                                                  $result = mysqli_query($conn, $sql);

                                                  $tab_start = 6;
                                                  $first = true;
                                                  $tabs = [];

                                                  while ($row = mysqli_fetch_assoc($result)) {
                                                       $tab_id = $tab_start++;
                                                       $active_class = $first ? 'active' : '';
                                                       $first = false;

                                                       $title = ucfirst(str_replace('_', ' ', $row['tag_name']));

                                                       $tabs[] = [
                                                            'tab_id' => $tab_id,
                                                            'tag_name' => $row['tag_name'],
                                                            'description' => $row['description'],
                                                            'order_num' => $row['order_num'],
                                                            'title' => $title,
                                                       ];
                                                  ?>
                                                       <li class="nav-item">
                                                            <a href="#tab_<?= $tab_id ?>" data-toggle="tab" class="nav-link <?= $active_class ?>">
                                                                 <span class="categorytab-title"><?= htmlspecialchars($title) ?></span>
                                                            </a>
                                                       </li>
                                                  <?php } ?>
                                             </ul>
                                        </div>

                                        <div class="tab-content">
                                             <?php foreach ($tabs as $index => $tab): ?>
                                                  <div id="tab_<?= $tab['tab_id']; ?>" class="tab-pane <?= $index === 0 ? 'active' : ''; ?>">
                                                       <div class="products-wrapper">
                                                            <div class="products">
                                                                 <div id="czcategory<?= $tab['tab_id']; ?>-carousel"
                                                                      class="cz-carousel product_list product_slider_grid"
                                                                      data-catid="<?= $tab['tab_id']; ?>">

                                                                      <?php
                                                                      // Dynamic query for each tag
                                                                      $product_query = "
                                                                           SELECT products.*, 
                                                                                categories.name AS category_name, 
                                                                                categories.id AS category_id, 
                                                                                (SELECT COUNT(*) FROM cart 
                                                                                     WHERE cart.product_id = products.id 
                                                                                     AND (cart.session_id = '" . session_id() . "' 
                                                                                          OR cart.user_id = '" . ($_SESSION['auth_user']['id'] ?? '0') . "')
                                                                                     AND (cart.cart_status IS NULL OR cart.cart_status != 'processed')
                                                                                ) AS in_cart, 
                                                                                (SELECT COUNT(*) FROM favorite 
                                                                                     WHERE favorite.product_id = products.id 
                                                                                     AND (favorite.session_id = '" . session_id() . "' 
                                                                                          OR favorite.user_id = '" . ($_SESSION['auth_user']['id'] ?? '0') . "')
                                                                                ) AS in_favorite
                                                                           FROM products
                                                                           LEFT JOIN categories ON products.category_name = categories.name
                                                                           INNER JOIN tags ON products.featured = tags.tag_name
                                                                           WHERE products.status = 1
                                                                                AND tags.description = '" . mysqli_real_escape_string($conn, $tab['description']) . "'
                                                                                AND tags.order_num = '" . intval($tab['order_num']) . "'
                                                                           ORDER BY RAND()
                                                                           ";

                                                                      $product_query_run = mysqli_query($conn, $product_query);

                                                                      if (mysqli_num_rows($product_query_run) > 0) {
                                                                           while ($product = mysqli_fetch_assoc($product_query_run)) {
                                                                                // Your product card rendering here (same as in your original code)
                                                                                include 'includes/product-card-template.php'; // You can extract the HTML card into this file for cleaner code
                                                                           }
                                                                      } else {
                                                                           echo "<p>No featured products available</p>";
                                                                      }
                                                                      ?>
                                                                 </div>

                                                                 <div class="customNavigation">
                                                                      <a class="btn prev czcategory_prev">&nbsp;</a>
                                                                      <a class="btn next czcategory_next">&nbsp;</a>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                  </div>
                                             <?php endforeach; ?>


                                             <div id="tab_9" class="tab-pane ">
                                                  <div class="products-wrapper">
                                                       <div class="products">
                                                            <div id="czcategory9-carousel" class="cz-carousel product_list product_slider_grid" data-catid="9">
                                                                 <?php
                                                                 $product_query = "
                                                            SELECT products.*, 
                                                                 categories.name AS category_name, 
                                                                 categories.id AS category_id, 
                                                                 (SELECT COUNT(*) FROM cart 
                                                                 WHERE cart.product_id = products.id 
                                                                 AND (cart.session_id = '" . session_id() . "' OR cart.user_id = '" . ($_SESSION['auth_user']['id'] ?? '0') . "')
                                                                 AND (cart.cart_status IS NULL OR cart.cart_status != 'processed')
                                                                 ) AS in_cart, 
                                                                 (SELECT COUNT(*) FROM favorite 
                                                                 WHERE favorite.product_id = products.id 
                                                                 AND (favorite.session_id = '" . session_id() . "' OR favorite.user_id = '" . ($_SESSION['auth_user']['id'] ?? '0') . "')
                                                                 ) AS in_favorite
                                                            FROM products
                                                            LEFT JOIN categories ON products.category_name = categories.name
                                                            INNER JOIN tags ON products.featured = tags.tag_name
                                                            WHERE products.status = 1
                                                                 AND tags.description = '#2 eco'
                                                                 AND tags.order_num = 2                       
                                                            ORDER BY RAND()
                                                       ";

                                                                 $product_query_run = mysqli_query($conn, $product_query);

                                                                 if (mysqli_num_rows($product_query_run) > 0) {
                                                                      while ($product = mysqli_fetch_assoc($product_query_run)) {
                                                                 ?>
                                                                 <?php include"includes/product-card-template.php"?>
                                                                 <?php
                                                                      }
                                                                 } else {
                                                                      echo "<p>No featured products available</p>";
                                                                 }
                                                                 ?>
                                                            </div>

                                                            <div class="customNavigation">
                                                                 <a class="btn prev czcategory_prev">&nbsp;</a>
                                                                 <a class="btn next czcategory_next">&nbsp;</a>
                                                            </div>

                                                            <div class="view_more">
                                                                 <a class="all-product-link btn btn-primary"
                                                                      href="category.php?tag=#2-eco">
                                                                      View All Products
                                                                 </a>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div id="tab_10" class="tab-pane ">

                                                  <div class="products-wrapper">
                                                       <div class="products">
                                                            <div id="czcategory10-carousel"
                                                                 class="cz-carousel product_list product_slider_grid"
                                                                 data-catid="10">

                                                                 <?php

                                                                 $product_query = "
                                                            SELECT products.*, 
                                                                 categories.name AS category_name, 
                                                                 categories.id AS category_id, 
                                                                 (SELECT COUNT(*) FROM cart 
                                                                 WHERE cart.product_id = products.id 
                                                                 AND (cart.session_id = '" . session_id() . "' OR cart.user_id = '" . ($_SESSION['auth_user']['id'] ?? '0') . "')
                                                                 AND (cart.cart_status IS NULL OR cart.cart_status != 'processed')
                                                                 ) AS in_cart, 
                                                                 (SELECT COUNT(*) FROM favorite 
                                                                 WHERE favorite.product_id = products.id 
                                                                 AND (favorite.session_id = '" . session_id() . "' OR favorite.user_id = '" . ($_SESSION['auth_user']['id'] ?? '0') . "')
                                                                 ) AS in_favorite
                                                            FROM products
                                                            LEFT JOIN categories ON products.category_name = categories.name
                                                            INNER JOIN tags ON products.featured = tags.tag_name
                                                            WHERE products.status = 1
                                                                 AND tags.description = '#3 eco'
                                                                 AND tags.order_num = 3                      
                                                            ORDER BY RAND()
                                                       ";

                                                                 $product_query_run = mysqli_query($conn, $product_query);

                                                                 if (mysqli_num_rows($product_query_run) > 0) {
                                                                      while ($product = mysqli_fetch_assoc($product_query_run)) {
                                                                 ?>

                                                                           <?php include"includes/product-card-template.php"?>
                                                                 <?php
                                                                      }
                                                                 } else {
                                                                      echo "<p>No featured products available</p>";
                                                                 }
                                                                 ?>

                                                            </div>

                                                            <div class="customNavigation">
                                                                 <a class="btn prev czcategory_prev">&nbsp;</a>
                                                                 <a class="btn next czcategory_next">&nbsp;</a>
                                                            </div>

                                                            <div class="view_more">
                                                                 <a class="all-product-link btn btn-primary"
                                                                      href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/10-laptop-computers">
                                                                      View All Products
                                                                 </a>
                                                            </div>
                                                       </div>
                                                  </div>

                                             </div>
                                             <div id="tab_11" class="tab-pane ">

                                                  <div class="products-wrapper">
                                                       <div class="products">
                                                            <div id="czcategory11-carousel"
                                                                 class="cz-carousel product_list product_slider_grid"
                                                                 data-catid="11">

                                                                 <?php

                                                                  $product_query = "
                                                            SELECT products.*, 
                                                                 categories.name AS category_name, 
                                                                 categories.id AS category_id, 
                                                                 (SELECT COUNT(*) FROM cart 
                                                                 WHERE cart.product_id = products.id 
                                                                 AND (cart.session_id = '" . session_id() . "' OR cart.user_id = '" . ($_SESSION['auth_user']['id'] ?? '0') . "')
                                                                 AND (cart.cart_status IS NULL OR cart.cart_status != 'processed')
                                                                 ) AS in_cart, 
                                                                 (SELECT COUNT(*) FROM favorite 
                                                                 WHERE favorite.product_id = products.id 
                                                                 AND (favorite.session_id = '" . session_id() . "' OR favorite.user_id = '" . ($_SESSION['auth_user']['id'] ?? '0') . "')
                                                                 ) AS in_favorite
                                                            FROM products
                                                            LEFT JOIN categories ON products.category_name = categories.name
                                                            INNER JOIN tags ON products.featured = tags.tag_name
                                                            WHERE products.status = 1
                                                                 AND tags.description = '#4 eco'
                                                                 AND tags.order_num = 4                       
                                                            ORDER BY RAND()
                                                       ";

                                                                 $product_query_run = mysqli_query($conn, $product_query);

                                                                 if (mysqli_num_rows($product_query_run) > 0) {
                                                                      while ($product = mysqli_fetch_assoc($product_query_run)) {
                                                                 ?>

                                                                           <?php "include/product-card-template.php"?>
                                                                 <?php
                                                                      }
                                                                 } else {
                                                                      echo "<p>No featured products available</p>";
                                                                 }
                                                                 ?>

                                                            </div>

                                                            <div class="customNavigation">
                                                                 <a class="btn prev czcategory_prev">&nbsp;</a>
                                                                 <a class="btn next czcategory_next">&nbsp;</a>
                                                            </div>

                                                            <div class="view_more">
                                                                 <a class="all-product-link btn btn-primary"
                                                                      href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/10-laptop-computers">
                                                                      View All Products
                                                                 </a>
                                                            </div>
                                                       </div>
                                                  </div>

                                             </div>
                                             <div id="tab_12" class="tab-pane ">

                                                  <div class="products-wrapper">
                                                       <div class="products">
                                                            <div id="czcategory12-carousel"
                                                                 class="cz-carousel product_list product_slider_grid"
                                                                 data-catid="12">

                                                                 <?php

                                                                $product_query = "
                                                            SELECT products.*, 
                                                                 categories.name AS category_name, 
                                                                 categories.id AS category_id, 
                                                                 (SELECT COUNT(*) FROM cart 
                                                                 WHERE cart.product_id = products.id 
                                                                 AND (cart.session_id = '" . session_id() . "' OR cart.user_id = '" . ($_SESSION['auth_user']['id'] ?? '0') . "')
                                                                 AND (cart.cart_status IS NULL OR cart.cart_status != 'processed')
                                                                 ) AS in_cart, 
                                                                 (SELECT COUNT(*) FROM favorite 
                                                                 WHERE favorite.product_id = products.id 
                                                                 AND (favorite.session_id = '" . session_id() . "' OR favorite.user_id = '" . ($_SESSION['auth_user']['id'] ?? '0') . "')
                                                                 ) AS in_favorite
                                                            FROM products
                                                            LEFT JOIN categories ON products.category_name = categories.name
                                                            INNER JOIN tags ON products.featured = tags.tag_name
                                                            WHERE products.status = 1
                                                                 AND tags.description = '#5 eco'
                                                                 AND tags.order_num = 5                       
                                                            ORDER BY RAND()
                                                       ";

                                                                 $product_query_run = mysqli_query($conn, $product_query);

                                                                 if (mysqli_num_rows($product_query_run) > 0) {
                                                                      while ($product = mysqli_fetch_assoc($product_query_run)) {
                                                                 ?>

                                                                         <?php "include/product-card-template.php"?>
                                                                 <?php
                                                                      }
                                                                 } else {
                                                                      echo "<p>No featured products available</p>";
                                                                 }
                                                                 ?>

                                                            </div>

                                                            <div class="customNavigation">
                                                                 <a class="btn prev czcategory_prev">&nbsp;</a>
                                                                 <a class="btn next czcategory_next">&nbsp;</a>
                                                            </div>

                                                            <div class="view_more">
                                                                 <a class="all-product-link btn btn-primary"
                                                                      href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/10-laptop-computers">
                                                                      View All Products
                                                                 </a>
                                                            </div>
                                                       </div>
                                                  </div>

                                             </div>
                                        </div>
                                   </div>
                              </section>
                              <section id="czservicecmsblock">
                                   <div class="service_container container">
                                        <div class="service-area stickyscroll">
                                             <div class="service-fourth service1 scroll-item">
                                                  <div class="service-icon icon1"></div>
                                                  <div class="service-content">
                                                       <div class="service-heading">Complimentary Shipping</div>
                                                       <div class="service-description">On All Orders Above Kes 1,000</div>
                                                  </div>
                                             </div>
                                             <div class="service-fourth service2 scroll-item">
                                                  <div class="service-icon icon2"></div>
                                                  <div class="service-content">
                                                       <div class="service-heading">Hassle‑Free Returns</div>
                                                       <div class="service-description">Exchange Within 30 Days</div>
                                                  </div>
                                             </div>

                                             <div class="service-fourth service4 scroll-item">
                                                  <div class="service-icon icon4"></div>
                                                  <div class="service-content">
                                                       <div class="service-heading">Free Gift Wrapping</div>
                                                       <div class="service-description">Reach Out Anytime</div>
                                                  </div>
                                             </div>
                                             <div class="service-fourth service5 scroll-item">
                                                  <div class="service-icon icon5"></div>
                                                  <div class="service-content">
                                                       <div class="service-heading">24/7 Assistance</div>
                                                       <div class="service-description">We’re Here to Help</div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </section>

                              <section class="newproducts products-section clearfix">
                                   <div class="container">
                                        <h2 style="color: #333;" class="h1 products-section-title text-uppercase">
                                             Latest Products
                                        </h2>

                                        <div class="products-banner-wrapper banner-right">
                                             <div class="product-banner">
                                                  <div class="czcustomcmsblock1">
                                                       <div class="one-half custombanner-part1">
                                                            <?php
                                                            $product_query = "SELECT products.*, 
                                                                           categories.name AS category_name, 
                                                                           categories.id AS category_id, 
                                                                           (SELECT COUNT(*) FROM cart 
                                                                           WHERE cart.product_id = products.id 
                                                                           AND (cart.session_id = '" . session_id() . "' OR cart.user_id = '" . ($_SESSION['auth_user']['id'] ?? '0') . "')
                                                                           AND (cart.cart_status IS NULL OR cart.cart_status != 'processed')) AS in_cart, 

                                                                           (SELECT COUNT(*) FROM favorite 
                                                                           WHERE favorite.product_id = products.id 
                                                                           AND (favorite.session_id = '" . session_id() . "' OR favorite.user_id = '" . ($_SESSION['auth_user']['id'] ?? '0') . "')) AS in_favorite 

                                                                           FROM products 
                                                                           LEFT JOIN categories ON products.category_name = categories.name 
                                                                           WHERE products.status = 1  
                                                                           ORDER BY products.selling_price DESC
                                                                           LIMIT 1";

                                                            $product_query_run = mysqli_query($conn, $product_query);

                                                            if (mysqli_num_rows($product_query_run) > 0) {
                                                                 while ($product = mysqli_fetch_assoc($product_query_run)) {
                                                            ?>
                                                                      <div class="custombanner-inner">
                                                                           <div class="custombanner custombanner1"><a href="#"
                                                                                     class="banner-anchor"><img
                                                                                          src="uploads/shop/<?= $product['image'] ?? 'default.jpg'; ?>" width="430"
                                                                                          height="340" /></a>
                                                                                <div class="custombanner-content">
                                                                                     <div class="main-title"> <?= htmlspecialchars($product['product_name']); ?></div>
                                                                                     <div class="price-text">From
                                                                                          <span>Kes <?= number_format($product['selling_price'], 2); ?></span>
                                                                                     </div>
                                                                                     <div class="shopnow"><a
                                                                                               class="btn btn-primary"
                                                                                               href="#">Shop Now</a></div>
                                                                                </div>
                                                                           </div>
                                                                      </div>
                                                            <?php
                                                                 }
                                                            } else {
                                                                 echo "<p>No featured products available</p>";
                                                            }
                                                            ?>

                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="products-wrapper">
                                                  <div class="products">
                                                       <!-- Define Number of product for SLIDER -->
                                                       <div id="newproduct-carousel" class="cz-carousel product_list">
                                                            <?php

                                                            $product_query = "SELECT products.*, 
                                                                           categories.name AS category_name, 
                                                                           categories.id AS category_id, 
                                                                           (SELECT COUNT(*) FROM cart 
                                                                           WHERE cart.product_id = products.id 
                                                                           AND (cart.session_id = '" . session_id() . "' OR cart.user_id = '" . ($_SESSION['auth_user']['id'] ?? '0') . "')
                                                                           AND (cart.cart_status IS NULL OR cart.cart_status != 'processed')

                                                                           
                                                                           ) AS in_cart, 

                                                                           (SELECT COUNT(*) FROM favorite 
                                                                           WHERE favorite.product_id = products.id 
                                                                           AND (favorite.session_id = '" . session_id() . "' OR favorite.user_id = '" . ($_SESSION['auth_user']['id'] ?? '0') . "')) AS in_favorite 
                                                                           
                                                                           FROM products 
                                                                           LEFT JOIN categories ON products.category_name = categories.name 
                                                                           WHERE products.status = 1 AND products.featured = 'new' 
                                                                           ORDER BY RAND() ";



                                                            $product_query_run = mysqli_query($conn, $product_query);

                                                            if (mysqli_num_rows($product_query_run) > 0) {
                                                                 while ($product = mysqli_fetch_assoc($product_query_run)) {
                                                            ?>
                                                                      <article class="product_item  slider_item">

                                                                           <div class="product-miniature js-product-miniature"
                                                                                data-id-product="24"
                                                                                data-id-product-attribute="43">
                                                                                <div class="thumbnail-container">

                                                                                     <a href="shop-product.php?id=<?= $product['id'] ?? ''; ?>" class="thumbnail product-thumbnail">
                                                                                          <img class="lazyload"
                                                                                               src="uploads/shop/<?= $product['image'] ?? 'default.jpg'; ?>"
                                                                                               data-full-size-image-url="uploads/shop/<?= $product['image'] ?? 'default.jpg'; ?>"
                                                                                               alt="<?= htmlspecialchars($product['name'] ?? 'No Name'); ?>"
                                                                                               width="250" height="250">

                                                                                          <img class="lazyload fliper_image img-responsive"
                                                                                               src="uploads/shop/<?= $product['image'] ?? 'default.jpg'; ?>"
                                                                                               data-src="uploads/shop/<?= $product['image'] ?? 'default.jpg'; ?>"
                                                                                               data-full-size-image-url="uploads/shop/<?= $product['image'] ?? 'default.jpg'; ?>"
                                                                                               alt="Flip image of <?= htmlspecialchars($product['name'] ?? 'No Name'); ?>">
                                                                                     </a>



                                                                                     <ul class="product-flags js-product-flags">
                                                                                          <li class="product-flag new">New</li>
                                                                                     </ul>


                                                                                     <div class="outer-functional">
                                                                                          <div class="functional-buttons">
                                                                                               <div class="wishlist">
                                                                                                    <a aria-label="Add To Favorite" class="st-wishlist-button btn-product btn" href="javascript:void(0);"
                                                                                                         data-product-id="<?= $product['id']; ?>"
                                                                                                         data-product-name="<?= $product['product_name']; ?>"
                                                                                                         data-selling-price="<?= $product['selling_price']; ?>"
                                                                                                         data-image="<?= $product['image']; ?>">
                                                                                                         <span class="st-wishlist-bt-content">
                                                                                                              <?php if ($product['in_favorite'] > 0): ?>
                                                                                                                   <i class="fa fa-heart" aria-hidden="true"></i>
                                                                                                              <?php else: ?>
                                                                                                                   <i class="fi-rs-heart"></i>
                                                                                                              <?php endif; ?>
                                                                                                         </span>
                                                                                                    </a>

                                                                                               </div>



                                                                                               <div class="quickview">
                                                                                                    <a href="#" class="quick-view-btn text-blue-600 hover:underline" data-product-id="<?= $product['id']; ?>">Quick View</a>
                                                                                               </div>

                                                                                          </div>
                                                                                     </div>
                                                                                </div>

                                                                                <div class="product-description">


                                                                                     <h3 class="h3 product-title"><a
                                                                                               href="shop-product.php?id=<?= $product['id'] ?? ''; ?>"
                                                                                               content="">
                                                                                               <?= htmlspecialchars($product['product_name'] ?? ''); ?></a></h3>



                                                                                     <div class="comments_note">
                                                                                          <div class="star_content clearfix">
                                                                                               <?php
                                                                                               $rating = $product['rating'] ?? 0;
                                                                                               for ($i = 0; $i < 5; $i++) {
                                                                                                    if ($i < $rating) {
                                                                                                         echo '<div class="star star_on"></div>';
                                                                                                    } else {
                                                                                                         echo '<div class="star"></div>';
                                                                                                    }
                                                                                               }
                                                                                               ?>
                                                                                          </div>

                                                                                     </div>



                                                                                     <div class="product-price-and-shipping">


                                                                                          <span class="regular-price"
                                                                                               aria-label="Regular price">
                                                                                               Kes <?= $product['original_price'] ?? ''; ?>
                                                                                          </span>


                                                                                          <span class="price"
                                                                                               aria-label="Price">
                                                                                               Kes <?= $product['selling_price'] ?? ''; ?>
                                                                                          </span>



                                                                                     </div>



                                                                                     <div class="proaction-button">
                                                                                          <!-- Add to Cart Form -->
                                                                                          <form id="cartForm_<?= $product['id']; ?>" method="POST" action="">
                                                                                               <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                                                                                               <input type="hidden" name="add_to_cart_btn" value="true">
                                                                                               <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['product_name']); ?>">
                                                                                               <input type="hidden" name="selling_price" value="<?= $product['selling_price']; ?>">
                                                                                               <input type="hidden" name="image" value="<?= $product['image']; ?>">
                                                                                               <input type="hidden" name="quantity" value="1">

                                                                                               <?php if (!isset($product['in_cart']) || $product['in_cart'] == 0): ?>
                                                                                                    <a aria-label="Add To Cart"
                                                                                                         class="action-btn hover-up btn-primary add-to-cart"
                                                                                                         href="javascript:void(0);"
                                                                                                         onclick="addToCart('cartForm_<?= $product['id']; ?>');">
                                                                                                         <i class="add-to-cart"></i> Add to Cart
                                                                                                    </a>
                                                                                               <?php else: ?>
                                                                                                    <span class="action-btn hover-up btn-primary add-to-cart" style="pointer-events: none;">In Cart</span>
                                                                                               <?php endif; ?>
                                                                                               <style>
                                                                                                    .action-btn[style="pointer-events: none;"] {
                                                                                                         opacity: 0.5;
                                                                                                         /* Make the button appear disabled */
                                                                                                    }
                                                                                               </style>

                                                                                          </form>

                                                                                     </div>



                                                                                </div>
                                                                           </div>
                                                                      </article>
                                                            <?php
                                                                 }
                                                            } else {
                                                                 echo "<p>No featured products available</p>";
                                                            }
                                                            ?>

                                                       </div>

                                                       <div class="customNavigation">
                                                            <a class="btn prev newproduct_prev">Prev</a>
                                                            <a class="btn next newproduct_next">Next</a>
                                                       </div>


                                                  </div>
                                             </div>
                                             <div class="view_more">
                                                  <a class="all-product-link btn btn-primary"
                                                       href="shop.php">
                                                       All new products
                                                  </a>
                                             </div>
                                        </div>
                                   </div>
                              </section>



                              <section class="special-products products-section">
                                   <div class="container">
                                        <h2 style="color: #000;" class="h1 products-section-title text-uppercase">
                                             Deal of the day
                                        </h2>

                                        <div class="products-wrapper">
                                             <div class="products">
                                                  <div id="special-carousel" class="cz-carousel product_list">

                                                       <?php
                                                       $user_id = $_SESSION['auth_user']['id'] ?? 0;
                                                       $session_id = session_id();

                                                       $query = "SELECT products.*, 
                                                       (SELECT COUNT(*) FROM cart 
                                                       WHERE cart.product_id = products.id 
                                                       AND (cart.session_id = '$session_id' OR cart.user_id = '$user_id') 
                                                       AND (cart.cart_status IS NULL OR cart.cart_status != 'processed')
                                                       ) AS in_cart 
                                                       FROM products 
                                                       WHERE deal_of_day_status = 'open' 
                                                       AND NOW() BETWEEN deal_start AND deal_end 
                                                       AND status = 1
                                                       ORDER BY RAND()";

                                                       $deal_result = mysqli_query($conn, $query);

                                                       if (mysqli_num_rows($deal_result) > 0):
                                                            while ($deal = mysqli_fetch_assoc($deal_result)):

                                                                 // Calculate discount price if applicable
                                                                 $discount = floatval($deal['discount']);
                                                                 $price = floatval($deal['selling_price']);
                                                                 $discounted_price = $discount > 0 ? $price * (1 - $discount / 100) : $price;

                                                                 // Stock percentage for progress bar (assuming max stock 500 for demo)
                                                                 $max_stock = 500;
                                                                 $stock_qty = intval($deal['quantity']);
                                                                 $stock_percentage = min(100, max(0, ($stock_qty / $max_stock) * 100));

                                                                 // Convert deal_end to JS timestamp (ms)
                                                                 $deal_end_timestamp = strtotime($deal['deal_end']) * 1000;

                                                                 // Product safe output helper
                                                                 function h($str)
                                                                 {
                                                                      return htmlspecialchars($str);
                                                                 }
                                                       ?>
                                                                 <article class="product_item slider_item" data-deal-end="<?= $deal_end_timestamp; ?>">
                                                                      <div class="product-miniature js-product-miniature" data-id-product="<?= $deal['id']; ?>" data-id-product-attribute="0">

                                                                           <div class="thumbnail-container col-xs-12 col-md-6">
                                                                                <div class="special-product-images">
                                                                                     <ul class="cz-carousel product_list special-image-carousel">
                                                                                          <li class="item special-image">
                                                                                               <a href="shop-product.php?id=<?= $deal['id']; ?>" class="thumbnail product-thumbnail">
                                                                                                    <img class="lazyload"
                                                                                                         src="uploads/shop/<?= h($deal['image'] ?: 'default.jpg'); ?>"
                                                                                                         data-src="uploads/shop/<?= h($deal['image'] ?: 'default.jpg'); ?>"
                                                                                                         alt="<?= h($deal['product_name']); ?>"
                                                                                                         loading="lazy"
                                                                                                         width="250" height="250">
                                                                                               </a>
                                                                                          </li>
                                                                                     </ul>

                                                                                     <div class="outer-functional">
                                                                                          <div class="functional-buttons">
                                                                                               <div class="wishlist">
                                                                                                    <a class="st-wishlist-button btn-product btn" href="#" data-id-product="<?= $deal['id']; ?>" title="Add to Wishlist">
                                                                                                         <span class="st-wishlist-bt-content">
                                                                                                              <i class="fa fa-heart" aria-hidden="true"></i>
                                                                                                              <span class="ajax_wishlist_text">Add to Wishlist</span>
                                                                                                         </span>
                                                                                                    </a>
                                                                                               </div>
                                                                                               <div class="compare">
                                                                                                    <a class="st-compare-button btn-product btn" href="#" data-id-product="<?= $deal['id']; ?>" title="Add to Compare">
                                                                                                         <span class="st-compare-bt-content">
                                                                                                              <i class="fa fa-area-chart"></i>
                                                                                                              <span class="ajax_compare_text">Add to Compare</span>
                                                                                                         </span>
                                                                                                    </a>
                                                                                               </div>
                                                                                               <div class="quickview">
                                                                                                    <a href="#" class="quick-view js-quick-view" data-link-action="quickview">
                                                                                                         <i class="material-icons search">&#xE417;</i> Quick view
                                                                                                    </a>
                                                                                               </div>
                                                                                          </div>
                                                                                     </div>

                                                                                     <?php if ($discount > 0): ?>
                                                                                          <ul class="product-flags js-product-flags">
                                                                                               <li class="product-flag on-sale">On sale!</li>
                                                                                               <li class="product-flag discount">
                                                                                                    <i class="material-icons left">&#xe3e7;</i>-
                                                                                                    <?= round($discount); ?>%
                                                                                               </li>
                                                                                          </ul>
                                                                                     <?php endif; ?>
                                                                                </div>
                                                                           </div>

                                                                           <div class="product-description">
                                                                                <h3 class="h3 product-title">
                                                                                     <a href="shop-product.php?id=<?= $deal['id']; ?>">
                                                                                          <?= h($deal['product_name']); ?>
                                                                                     </a>
                                                                                </h3>

                                                                                <div class="comments_note">
                                                                                     <div class="star_content clearfix">
                                                                                          <?php
                                                                                          $rating = intval($deal['rating']);
                                                                                          for ($i = 1; $i <= 5; $i++) {
                                                                                               if ($i <= $rating) {
                                                                                                    echo '<div class="star star_on"></div>';
                                                                                               } else {
                                                                                                    echo '<div class="star"></div>';
                                                                                               }
                                                                                          }
                                                                                          ?>

                                                                                     </div>
                                                                                </div>

                                                                                <div class="product-price-and-shipping">
                                                                                     <?php if ($discount > 0): ?>
                                                                                          <span class="regular-price" aria-label="Regular price">$<?= number_format($price, 2); ?></span>
                                                                                          <span class="discount-percentage discount-product">-<?= round($discount); ?>%</span>
                                                                                          <span class="price" aria-label="Price">$<?= number_format($discounted_price, 2); ?></span>
                                                                                     <?php else: ?>
                                                                                          <span class="price" aria-label="Price">$<?= number_format($price, 2); ?></span>
                                                                                     <?php endif; ?>
                                                                                </div>

                                                                                <div class="qtyprogress">
                                                                                     <span class="text">Available: <strong class="quantity"><?= $stock_qty; ?></strong> items</span>
                                                                                     <span>
                                                                                          <div class="progress" style="background-color:#eee; border-radius:4px; height:10px; width:100%;">
                                                                                               <div class="progress-bar" role="progressbar" style="width: <?= $stock_percentage; ?>%; background-color:#28a745; height:10px; border-radius:4px;"></div>
                                                                                          </div>
                                                                                     </span>
                                                                                </div>

                                                                                <div class="product-counter">
                                                                                     <span class="end-deal">Hurry up! Sale ends in:</span>
                                                                                     <div class="countdown-timer" id="countdown-<?= $deal['id']; ?>">
                                                                                          <span class="days">00</span>d :
                                                                                          <span class="hours">00</span>h :
                                                                                          <span class="minutes">00</span>m :
                                                                                          <span class="seconds">00</span>s
                                                                                     </div>
                                                                                </div>

                                                                                <div class="proaction-button">
                                                                                     <form id="cartForm_<?= $deal['id']; ?>" method="POST" action="">
                                                                                          <input type="hidden" name="product_id" value="<?= $deal['id']; ?>">
                                                                                          <input type="hidden" name="add_to_cart_btn" value="true">
                                                                                          <input type="hidden" name="product_name" value="<?= h($deal['product_name']); ?>">
                                                                                          <input type="hidden" name="selling_price" value="<?= $price; ?>">
                                                                                          <input type="hidden" name="image" value="<?= h($deal['image']); ?>">
                                                                                          <input type="hidden" name="quantity" value="1">

                                                                                          <?php if (empty($deal['in_cart'])): ?>
                                                                                               <a aria-label="Add To Cart" class="action-btn hover-up btn-primary add-to-cart" href="javascript:void(0);" onclick="addToCart('cartForm_<?= $deal['id']; ?>');">
                                                                                                    <i class="add-to-cart"></i> Add to Cart
                                                                                               </a>
                                                                                          <?php else: ?>
                                                                                               <span class="action-btn hover-up btn-primary add-to-cart disabled" style="pointer-events: none; opacity: 0.5;">
                                                                                                    In Cart
                                                                                               </span>
                                                                                          <?php endif; ?>
                                                                                     </form>
                                                                                </div>
                                                                           </div>

                                                                      </div>
                                                                 </article>
                                                            <?php
                                                            endwhile;
                                                       else:
                                                            ?>
                                                            <div class="col-12">
                                                                 <p class="text-center">No active Deal of the Day available at the moment.</p>
                                                            </div>
                                                       <?php endif; ?>
                                                  </div>

                                                  <div class="customNavigation">
                                                       <a class="btn prev special_prev">&nbsp;</a>
                                                       <a class="btn next special_next">&nbsp;</a>
                                                  </div>

                                                  <div class="view_more">
                                                       <a class="all-product-link btn btn-primary" href="prices-drop.php">
                                                            All sale products
                                                       </a>
                                                  </div>

                                             </div>
                                        </div>
                                   </div>
                              </section>

                              <script>
                                   // Countdown timer function
                                   function initializeCountdown(id, endTime) {
                                        const countdown = document.getElementById(id);
                                        if (!countdown) return;

                                        function updateCountdown() {
                                             const now = new Date().getTime();
                                             const distance = endTime - now;

                                             if (distance < 0) {
                                                  countdown.innerHTML = "Deal ended";
                                                  clearInterval(interval);
                                                  return;
                                             }

                                             const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                             const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                             const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                             const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                             countdown.querySelector('.days').textContent = days.toString().padStart(2, '0');
                                             countdown.querySelector('.hours').textContent = hours.toString().padStart(2, '0');
                                             countdown.querySelector('.minutes').textContent = minutes.toString().padStart(2, '0');
                                             countdown.querySelector('.seconds').textContent = seconds.toString().padStart(2, '0');
                                        }

                                        updateCountdown();
                                        const interval = setInterval(updateCountdown, 1000);
                                   }

                                   // Initialize countdowns for each deal product on page load
                                   document.addEventListener('DOMContentLoaded', () => {
                                        document.querySelectorAll('article.product_item.slider_item').forEach(article => {
                                             const dealEnd = parseInt(article.getAttribute('data-deal-end'), 10);
                                             const countdownId = 'countdown-' + article.querySelector('.product-miniature').getAttribute('data-id-product');
                                             initializeCountdown(countdownId, dealEnd);
                                        });
                                   });

                                   // Dummy addToCart JS function (replace with your actual cart add logic)
                                   function addToCart(formId) {
                                        const form = document.getElementById(formId);
                                        if (!form) return;

                                        // You can do ajax submit here or normal submit
                                        alert('Added to cart: Product ID ' + form.product_id.value);

                                        // Example: disable button after adding
                                        const btn = form.querySelector('.add-to-cart');
                                        if (btn) {
                                             btn.textContent = 'In Cart';
                                             btn.style.pointerEvents = 'none';
                                             btn.style.opacity = '0.5';
                                        }
                                   }
                              </script>

                              <style>
                                   /* Simple star styles */
                                   .star {
                                        display: inline-block;
                                        width: 12px;
                                        height: 12px;
                                        background: #ccc;
                                        margin-right: 2px;
                                        clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%);
                                   }

                                   .star_on {
                                        background: gold;
                                   }

                                   .countdown-timer {
                                        font-weight: bold;
                                        font-size: 14px;
                                        margin-top: 5px;
                                   }

                                   .action-btn.disabled {
                                        cursor: not-allowed;
                                   }
                              </style>

                              <section class="featured-products products-section clearfix">
                                   <div class="container">
                                        <h2 class="h1 products-section-title text-uppercase">
                                             Featured Products
                                        </h2>
                                        <div class="products-banner-wrapper">
                                             <div class="product-banner">
                                                  <div class="czcustomcmsblock2">
                                                       <div class="one-half custombanner-part2">
                                                            <div class="custombanner-inner">
                                                                 <div class="custombanner custombanner2"><a href="#"
                                                                           class="banner-anchor"><img
                                                                                src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/cms/product-banner2.jpg"
                                                                                alt="product-banner" width="430"
                                                                                height="340" /></a>
                                                                      <div class="custombanner-content">
                                                                           <div class="main-title">Redmi <span>10 Prime
                                                                                </span><span>Phone</span></div>
                                                                           <div class="price-text">From
                                                                                <span>$159.00</span>
                                                                           </div>
                                                                           <div class="shopnow"><a
                                                                                     class="btn btn-primary"
                                                                                     href="#">Shop Now</a></div>
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="products-wrapper">
                                                  <div class="products">
                                                       <!-- Define Number of product for SLIDER -->
                                                       <div id="feature-carousel" class="cz-carousel product_list">

                                                            <article class="product_item  slider_item">

                                                                 <div class="product-miniature js-product-miniature"
                                                                      data-id-product="1"
                                                                      data-id-product-attribute="163">
                                                                      <div class="thumbnail-container">

                                                                           <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/chargers-cables/1-163-hummingbird-printed-t-shirt.html#/32-ram-4gb/38-internal_storage-128gb"
                                                                                class="thumbnail product-thumbnail">
                                                                                <img class="lazyload"
                                                                                     src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/244-home_default/hummingbird-printed-t-shirt.jpg"
                                                                                     alt="New Featured MacBook Pro With Apple M1 Pro Chip"
                                                                                     data-full-size-image-url="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/244-large_default/hummingbird-printed-t-shirt.jpg"
                                                                                     width="250" height="250">
                                                                                <img class="lazyload fliper_image img-responsive"
                                                                                     src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/245-home_default/hummingbird-printed-t-shirt.jpg"
                                                                                     data-full-size-image-url="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/245-large_default/hummingbird-printed-t-shirt.jpg"
                                                                                     alt="" />

                                                                           </a>


                                                                           <div
                                                                                class="highlighted-informations no-variants">


                                                                           </div>


                                                                           <ul class="product-flags js-product-flags">
                                                                                <li class="product-flag on-sale">On
                                                                                     sale!</li>
                                                                                <li class="product-flag discount"><i
                                                                                          class="material-icons left">&#xe3e7;</i>-10%
                                                                                </li>
                                                                                <li class="product-flag new">New</li>
                                                                           </ul>


                                                                           <div class="outer-functional">
                                                                                <div class="functional-buttons">
                                                                                     <div class="wishlist">
                                                                                          <a class="st-wishlist-button btn-product btn"
                                                                                               href="#"
                                                                                               data-id-wishlist=""
                                                                                               data-id-product="1"
                                                                                               data-id-product-attribute="163"
                                                                                               title="Add to Wishlist">
                                                                                               <span
                                                                                                    class="st-wishlist-bt-content">
                                                                                                    <i class="fa fa-heart"
                                                                                                         aria-hidden="true"></i>
                                                                                                    <span
                                                                                                         class="ajax_wishlist_text">Add
                                                                                                         to
                                                                                                         Wishlist</span>
                                                                                               </span>
                                                                                          </a>

                                                                                     </div>
                                                                                     <div class="compare">
                                                                                          <a class="st-compare-button btn-product btn"
                                                                                               href="#"
                                                                                               data-id-product="1"
                                                                                               title="Add to Compare">
                                                                                               <span
                                                                                                    class="st-compare-bt-content">
                                                                                                    <i
                                                                                                         class="fa fa-area-chart"></i>
                                                                                                    <span
                                                                                                         class="ajax_compare_text">Add
                                                                                                         to Compare
                                                                                                    </span>
                                                                                          </a>
                                                                                     </div>


                                                                                     <div class="quickview">
                                                                                          <a href="#"
                                                                                               class="quick-view js-quick-view"
                                                                                               data-link-action="quickview">
                                                                                               <i
                                                                                                    class="material-icons search">&#xE417;</i>
                                                                                               Quick view
                                                                                          </a>
                                                                                     </div>

                                                                                </div>
                                                                           </div>
                                                                      </div>

                                                                      <div class="product-description">


                                                                           <div class="brand-title" itemprop="name">
                                                                                <a
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/brand/8-trendmart">TrendMart</a>
                                                                           </div>



                                                                           <h3 class="h3 product-title"><a
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/chargers-cables/1-163-hummingbird-printed-t-shirt.html#/32-ram-4gb/38-internal_storage-128gb"
                                                                                     content="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/chargers-cables/1-163-hummingbird-printed-t-shirt.html#/32-ram-4gb/38-internal_storage-128gb">New
                                                                                     Featured MacBook Pro With Apple M1
                                                                                     Pro Chip</a></h3>



                                                                           <div class="comments_note">
                                                                                <div class="star_content clearfix">
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star"></div>
                                                                                     <div class="star"></div>
                                                                                </div>
                                                                                <span class="total-rating">1
                                                                                     Review(s)</span>
                                                                           </div>



                                                                           <div class="product-price-and-shipping">


                                                                                <span class="regular-price"
                                                                                     aria-label="Regular price">$900.00</span>
                                                                                <span
                                                                                     class="discount-percentage discount-product">-10%
                                                                                     <span>Off</span></span>



                                                                                <span class="price" aria-label="Price">
                                                                                     $810.00
                                                                                </span>




                                                                           </div>



                                                                           <div class="proaction-button">
                                                                                <form action="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/cart"
                                                                                     method="post"
                                                                                     class="add-to-cart-or-refresh">
                                                                                     <input type="hidden" name="token"
                                                                                          value="be2e4f21e069f2f9e1a4d6f6ab1dfbfa">
                                                                                     <input type="hidden"
                                                                                          name="id_product" value="1"
                                                                                          class="product_page_product_id">
                                                                                     <input type="hidden"
                                                                                          name="id_customization"
                                                                                          value="0"
                                                                                          id="product_customization_id"
                                                                                          class="js-product-customization-id">
                                                                                     <button
                                                                                          class="btn btn-primary add-to-cart"
                                                                                          data-button-action="add-to-cart"
                                                                                          type="submit">
                                                                                          Add to cart
                                                                                     </button>
                                                                                </form>
                                                                           </div>



                                                                      </div>
                                                                 </div>
                                                            </article>
                                                            <article class="product_item  slider_item">

                                                                 <div class="product-miniature js-product-miniature"
                                                                      data-id-product="2" data-id-product-attribute="0">
                                                                      <div class="thumbnail-container">

                                                                           <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/usb-type-cable/2-rumbloo-silicone-controller-grip-cover-for-oculus-quest-2.html"
                                                                                class="thumbnail product-thumbnail">
                                                                                <img class="lazyload"
                                                                                     src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/239-home_default/rumbloo-silicone-controller-grip-cover-for-oculus-quest-2.jpg"
                                                                                     alt="Rumbloo Silicone Controller Grip Cover for Oculus Quest 2"
                                                                                     data-full-size-image-url="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/239-large_default/rumbloo-silicone-controller-grip-cover-for-oculus-quest-2.jpg"
                                                                                     width="250" height="250">
                                                                                <img class="lazyload fliper_image img-responsive"
                                                                                     src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/240-home_default/rumbloo-silicone-controller-grip-cover-for-oculus-quest-2.jpg"
                                                                                     data-full-size-image-url="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/240-large_default/rumbloo-silicone-controller-grip-cover-for-oculus-quest-2.jpg"
                                                                                     alt="" />

                                                                           </a>


                                                                           <div
                                                                                class="highlighted-informations no-variants">


                                                                           </div>


                                                                           <ul class="product-flags js-product-flags">
                                                                                <li class="product-flag on-sale">On
                                                                                     sale!</li>
                                                                                <li class="product-flag discount"><i
                                                                                          class="material-icons left">&#xe3e7;</i>-15%
                                                                                </li>
                                                                                <li class="product-flag new">New</li>
                                                                           </ul>


                                                                           <div class="outer-functional">
                                                                                <div class="functional-buttons">
                                                                                     <div class="wishlist">
                                                                                          <a class="st-wishlist-button btn-product btn"
                                                                                               href="#"
                                                                                               data-id-wishlist=""
                                                                                               data-id-product="2"
                                                                                               data-id-product-attribute="0"
                                                                                               title="Add to Wishlist">
                                                                                               <span
                                                                                                    class="st-wishlist-bt-content">
                                                                                                    <i class="fa fa-heart"
                                                                                                         aria-hidden="true"></i>
                                                                                                    <span
                                                                                                         class="ajax_wishlist_text">Add
                                                                                                         to
                                                                                                         Wishlist</span>
                                                                                               </span>
                                                                                          </a>

                                                                                     </div>
                                                                                     <div class="compare">
                                                                                          <a class="st-compare-button btn-product btn"
                                                                                               href="#"
                                                                                               data-id-product="2"
                                                                                               title="Add to Compare">
                                                                                               <span
                                                                                                    class="st-compare-bt-content">
                                                                                                    <i
                                                                                                         class="fa fa-area-chart"></i>
                                                                                                    <span
                                                                                                         class="ajax_compare_text">Add
                                                                                                         to Compare
                                                                                                    </span>
                                                                                          </a>
                                                                                     </div>


                                                                                     <div class="quickview">
                                                                                          <a href="#"
                                                                                               class="quick-view js-quick-view"
                                                                                               data-link-action="quickview">
                                                                                               <i
                                                                                                    class="material-icons search">&#xE417;</i>
                                                                                               Quick view
                                                                                          </a>
                                                                                     </div>

                                                                                </div>
                                                                           </div>
                                                                      </div>

                                                                      <div class="product-description">


                                                                           <div class="brand-title" itemprop="name">
                                                                                <a
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/brand/7-stylehub">StyleHub</a>
                                                                           </div>



                                                                           <h3 class="h3 product-title"><a
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/usb-type-cable/2-rumbloo-silicone-controller-grip-cover-for-oculus-quest-2.html"
                                                                                     content="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/usb-type-cable/2-rumbloo-silicone-controller-grip-cover-for-oculus-quest-2.html">Rumbloo
                                                                                     Silicone Controller Grip Cover for
                                                                                     Oculus Quest 2</a></h3>



                                                                           <div class="comments_note">
                                                                                <div class="star_content clearfix">
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                </div>
                                                                                <span class="total-rating">1
                                                                                     Review(s)</span>
                                                                           </div>



                                                                           <div class="product-price-and-shipping">


                                                                                <span class="regular-price"
                                                                                     aria-label="Regular price">$120.00</span>
                                                                                <span
                                                                                     class="discount-percentage discount-product">-15%
                                                                                     <span>Off</span></span>



                                                                                <span class="price" aria-label="Price">
                                                                                     $102.00
                                                                                </span>




                                                                           </div>



                                                                           <div class="proaction-button">
                                                                                <form action="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/cart"
                                                                                     method="post"
                                                                                     class="add-to-cart-or-refresh">
                                                                                     <input type="hidden" name="token"
                                                                                          value="be2e4f21e069f2f9e1a4d6f6ab1dfbfa">
                                                                                     <input type="hidden"
                                                                                          name="id_product" value="2"
                                                                                          class="product_page_product_id">
                                                                                     <input type="hidden"
                                                                                          name="id_customization"
                                                                                          value="0"
                                                                                          id="product_customization_id"
                                                                                          class="js-product-customization-id">
                                                                                     <button
                                                                                          class="btn btn-primary add-to-cart"
                                                                                          data-button-action="add-to-cart"
                                                                                          type="submit">
                                                                                          Add to cart
                                                                                     </button>
                                                                                </form>
                                                                           </div>



                                                                      </div>
                                                                 </div>
                                                            </article>
                                                            <article class="product_item  slider_item">

                                                                 <div class="product-miniature js-product-miniature"
                                                                      data-id-product="3"
                                                                      data-id-product-attribute="158">
                                                                      <div class="thumbnail-container">

                                                                           <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/3-158-the-best-is-yet-to-come-framed-poster.html#/29-texture-off_white"
                                                                                class="thumbnail product-thumbnail">
                                                                                <img class="lazyload"
                                                                                     src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/222-home_default/the-best-is-yet-to-come-framed-poster.jpg"
                                                                                     alt="The best is yet to come&#039; Framed poster"
                                                                                     data-full-size-image-url="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/222-large_default/the-best-is-yet-to-come-framed-poster.jpg"
                                                                                     width="250" height="250">
                                                                                <img class="lazyload fliper_image img-responsive"
                                                                                     src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/229-home_default/the-best-is-yet-to-come-framed-poster.jpg"
                                                                                     data-full-size-image-url="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/229-large_default/the-best-is-yet-to-come-framed-poster.jpg"
                                                                                     alt="" />

                                                                           </a>


                                                                           <div class="highlighted-informations">

                                                                                <div class="variant-links">
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/3-158-the-best-is-yet-to-come-framed-poster.html#/29-texture-off_white"
                                                                                          class="color texture"
                                                                                          title="Off White"
                                                                                          style="background-image: url(/prestashop/PRS21/PRS210518/default/img/co/29.jpg)"><span
                                                                                               class="sr-only">Off
                                                                                               White</span></a>
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/3-159-the-best-is-yet-to-come-framed-poster.html#/30-texture-red"
                                                                                          class="color texture"
                                                                                          title="Red"
                                                                                          style="background-image: url(/prestashop/PRS21/PRS210518/default/img/co/30.jpg)"><span
                                                                                               class="sr-only">Red</span></a>
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/3-160-the-best-is-yet-to-come-framed-poster.html#/31-texture-blue"
                                                                                          class="color texture"
                                                                                          title="Blue"
                                                                                          style="background-image: url(/prestashop/PRS21/PRS210518/default/img/co/31.jpg)"><span
                                                                                               class="sr-only">Blue</span></a>
                                                                                     <span
                                                                                          class="js-count count"></span>
                                                                                </div>

                                                                           </div>


                                                                           <ul class="product-flags js-product-flags">
                                                                                <li class="product-flag new">New</li>
                                                                           </ul>


                                                                           <div class="outer-functional">
                                                                                <div class="functional-buttons">
                                                                                     <div class="wishlist">
                                                                                          <a class="st-wishlist-button btn-product btn"
                                                                                               href="#"
                                                                                               data-id-wishlist=""
                                                                                               data-id-product="3"
                                                                                               data-id-product-attribute="158"
                                                                                               title="Add to Wishlist">
                                                                                               <span
                                                                                                    class="st-wishlist-bt-content">
                                                                                                    <i class="fa fa-heart"
                                                                                                         aria-hidden="true"></i>
                                                                                                    <span
                                                                                                         class="ajax_wishlist_text">Add
                                                                                                         to
                                                                                                         Wishlist</span>
                                                                                               </span>
                                                                                          </a>

                                                                                     </div>
                                                                                     <div class="compare">
                                                                                          <a class="st-compare-button btn-product btn"
                                                                                               href="#"
                                                                                               data-id-product="3"
                                                                                               title="Add to Compare">
                                                                                               <span
                                                                                                    class="st-compare-bt-content">
                                                                                                    <i
                                                                                                         class="fa fa-area-chart"></i>
                                                                                                    <span
                                                                                                         class="ajax_compare_text">Add
                                                                                                         to Compare
                                                                                                    </span>
                                                                                          </a>
                                                                                     </div>


                                                                                     <div class="quickview">
                                                                                          <a href="#"
                                                                                               class="quick-view js-quick-view"
                                                                                               data-link-action="quickview">
                                                                                               <i
                                                                                                    class="material-icons search">&#xE417;</i>
                                                                                               Quick view
                                                                                          </a>
                                                                                     </div>

                                                                                </div>
                                                                           </div>
                                                                      </div>

                                                                      <div class="product-description">


                                                                           <div class="brand-title" itemprop="name">
                                                                                <a
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/brand/6-smartshop">SmartShop</a>
                                                                           </div>



                                                                           <h3 class="h3 product-title"><a
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/3-158-the-best-is-yet-to-come-framed-poster.html#/29-texture-off_white"
                                                                                     content="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/3-158-the-best-is-yet-to-come-framed-poster.html#/29-texture-off_white">The
                                                                                     best is yet to come&#039; Framed
                                                                                     poster</a></h3>



                                                                           <div class="comments_note">
                                                                                <div class="star_content clearfix">
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                </div>
                                                                                <span class="total-rating">3
                                                                                     Review(s)</span>
                                                                           </div>



                                                                           <div class="product-price-and-shipping">



                                                                                <span class="price" aria-label="Price">
                                                                                     $99.00
                                                                                </span>




                                                                           </div>



                                                                           <div class="proaction-button">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/3-158-the-best-is-yet-to-come-framed-poster.html#/29-texture-off_white"
                                                                                     class="btn btn-primary add-to-cart">
                                                                                     Options
                                                                                </a>
                                                                           </div>



                                                                      </div>
                                                                 </div>
                                                            </article>
                                                            <article class="product_item  slider_item">

                                                                 <div class="product-miniature js-product-miniature"
                                                                      data-id-product="4"
                                                                      data-id-product-attribute="154">
                                                                      <div class="thumbnail-container">

                                                                           <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/4-154-samsung-qn85aa-series-neo-qled-4k-uhd-smart-tv.html#/9-color-off_white"
                                                                                class="thumbnail product-thumbnail">
                                                                                <img class="lazyload"
                                                                                     src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/216-home_default/samsung-qn85aa-series-neo-qled-4k-uhd-smart-tv.jpg"
                                                                                     alt="Samsung QN85AA Series Neo QLED 4K UHD Smart TV"
                                                                                     data-full-size-image-url="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/216-large_default/samsung-qn85aa-series-neo-qled-4k-uhd-smart-tv.jpg"
                                                                                     width="250" height="250">
                                                                                <img class="lazyload fliper_image img-responsive"
                                                                                     src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/217-home_default/samsung-qn85aa-series-neo-qled-4k-uhd-smart-tv.jpg"
                                                                                     data-full-size-image-url="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/217-large_default/samsung-qn85aa-series-neo-qled-4k-uhd-smart-tv.jpg"
                                                                                     alt="" />

                                                                           </a>


                                                                           <div class="highlighted-informations">

                                                                                <div class="variant-links">
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/4-154-samsung-qn85aa-series-neo-qled-4k-uhd-smart-tv.html#/9-color-off_white"
                                                                                          class="color "
                                                                                          title="Off White"
                                                                                          style="background-color: #faebd7"><span
                                                                                               class="sr-only">Off
                                                                                               White</span></a>
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/4-155-samsung-qn85aa-series-neo-qled-4k-uhd-smart-tv.html#/12-color-camel"
                                                                                          class="color " title="Camel"
                                                                                          style="background-color: #C19A6B"><span
                                                                                               class="sr-only">Camel</span></a>
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/4-156-samsung-qn85aa-series-neo-qled-4k-uhd-smart-tv.html#/14-color-blue"
                                                                                          class="color " title="Blue"
                                                                                          style="background-color: #5D9CEC"><span
                                                                                               class="sr-only">Blue</span></a>
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/4-157-samsung-qn85aa-series-neo-qled-4k-uhd-smart-tv.html#/15-color-green"
                                                                                          class="color " title="Green"
                                                                                          style="background-color: #A0D468"><span
                                                                                               class="sr-only">Green</span></a>
                                                                                     <span
                                                                                          class="js-count count"></span>
                                                                                </div>

                                                                           </div>


                                                                           <ul class="product-flags js-product-flags">
                                                                                <li class="product-flag new">New</li>
                                                                           </ul>


                                                                           <div class="outer-functional">
                                                                                <div class="functional-buttons">
                                                                                     <div class="wishlist">
                                                                                          <a class="st-wishlist-button btn-product btn"
                                                                                               href="#"
                                                                                               data-id-wishlist=""
                                                                                               data-id-product="4"
                                                                                               data-id-product-attribute="154"
                                                                                               title="Add to Wishlist">
                                                                                               <span
                                                                                                    class="st-wishlist-bt-content">
                                                                                                    <i class="fa fa-heart"
                                                                                                         aria-hidden="true"></i>
                                                                                                    <span
                                                                                                         class="ajax_wishlist_text">Add
                                                                                                         to
                                                                                                         Wishlist</span>
                                                                                               </span>
                                                                                          </a>

                                                                                     </div>
                                                                                     <div class="compare">
                                                                                          <a class="st-compare-button btn-product btn"
                                                                                               href="#"
                                                                                               data-id-product="4"
                                                                                               title="Add to Compare">
                                                                                               <span
                                                                                                    class="st-compare-bt-content">
                                                                                                    <i
                                                                                                         class="fa fa-area-chart"></i>
                                                                                                    <span
                                                                                                         class="ajax_compare_text">Add
                                                                                                         to Compare
                                                                                                    </span>
                                                                                          </a>
                                                                                     </div>


                                                                                     <div class="quickview">
                                                                                          <a href="#"
                                                                                               class="quick-view js-quick-view"
                                                                                               data-link-action="quickview">
                                                                                               <i
                                                                                                    class="material-icons search">&#xE417;</i>
                                                                                               Quick view
                                                                                          </a>
                                                                                     </div>

                                                                                </div>
                                                                           </div>
                                                                      </div>

                                                                      <div class="product-description">


                                                                           <div class="brand-title" itemprop="name">
                                                                                <a
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/brand/6-smartshop">SmartShop</a>
                                                                           </div>



                                                                           <h3 class="h3 product-title"><a
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/4-154-samsung-qn85aa-series-neo-qled-4k-uhd-smart-tv.html#/9-color-off_white"
                                                                                     content="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/4-154-samsung-qn85aa-series-neo-qled-4k-uhd-smart-tv.html#/9-color-off_white">Samsung
                                                                                     QN85AA Series Neo QLED 4K UHD Smart
                                                                                     TV</a></h3>



                                                                           <div class="comments_note">
                                                                                <div class="star_content clearfix">
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                </div>
                                                                                <span class="total-rating">1
                                                                                     Review(s)</span>
                                                                           </div>



                                                                           <div class="product-price-and-shipping">



                                                                                <span class="price" aria-label="Price">
                                                                                     $560.00
                                                                                </span>




                                                                           </div>



                                                                           <div class="proaction-button">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/4-154-samsung-qn85aa-series-neo-qled-4k-uhd-smart-tv.html#/9-color-off_white"
                                                                                     class="btn btn-primary add-to-cart">
                                                                                     Options
                                                                                </a>
                                                                           </div>



                                                                      </div>
                                                                 </div>
                                                            </article>
                                                            <article class="product_item  slider_item">

                                                                 <div class="product-miniature js-product-miniature"
                                                                      data-id-product="5"
                                                                      data-id-product-attribute="149">
                                                                      <div class="thumbnail-container">

                                                                           <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/macbook/5-149-12kg-front-load-washing-machine-with-inverter.html#/5-color-gray"
                                                                                class="thumbnail product-thumbnail">
                                                                                <img class="lazyload"
                                                                                     src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/209-home_default/12kg-front-load-washing-machine-with-inverter.jpg"
                                                                                     alt="12kg Front Load Washing Machine With Inverter"
                                                                                     data-full-size-image-url="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/209-large_default/12kg-front-load-washing-machine-with-inverter.jpg"
                                                                                     width="250" height="250">
                                                                                <img class="lazyload fliper_image img-responsive"
                                                                                     src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/210-home_default/12kg-front-load-washing-machine-with-inverter.jpg"
                                                                                     data-full-size-image-url="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/210-large_default/12kg-front-load-washing-machine-with-inverter.jpg"
                                                                                     alt="" />

                                                                           </a>


                                                                           <div class="highlighted-informations">

                                                                                <div class="variant-links">
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/macbook/5-149-12kg-front-load-washing-machine-with-inverter.html#/5-color-gray"
                                                                                          class="color " title="Gray"
                                                                                          style="background-color: #AAB2BD"><span
                                                                                               class="sr-only">Gray</span></a>
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/macbook/5-150-12kg-front-load-washing-machine-with-inverter.html#/13-color-orange"
                                                                                          class="color " title="Orange"
                                                                                          style="background-color: #F39C11"><span
                                                                                               class="sr-only">Orange</span></a>
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/macbook/5-151-12kg-front-load-washing-machine-with-inverter.html#/14-color-blue"
                                                                                          class="color " title="Blue"
                                                                                          style="background-color: #5D9CEC"><span
                                                                                               class="sr-only">Blue</span></a>
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/macbook/5-153-12kg-front-load-washing-machine-with-inverter.html#/16-color-yellow"
                                                                                          class="color " title="Yellow"
                                                                                          style="background-color: #F1C40F"><span
                                                                                               class="sr-only">Yellow</span></a>
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/macbook/5-152-12kg-front-load-washing-machine-with-inverter.html#/18-color-pink"
                                                                                          class="color " title="Pink"
                                                                                          style="background-color: #FCCACD"><span
                                                                                               class="sr-only">Pink</span></a>
                                                                                     <span
                                                                                          class="js-count count"></span>
                                                                                </div>

                                                                           </div>


                                                                           <ul class="product-flags js-product-flags">
                                                                                <li class="product-flag new">New</li>
                                                                           </ul>


                                                                           <div class="outer-functional">
                                                                                <div class="functional-buttons">
                                                                                     <div class="wishlist">
                                                                                          <a class="st-wishlist-button btn-product btn"
                                                                                               href="#"
                                                                                               data-id-wishlist=""
                                                                                               data-id-product="5"
                                                                                               data-id-product-attribute="149"
                                                                                               title="Add to Wishlist">
                                                                                               <span
                                                                                                    class="st-wishlist-bt-content">
                                                                                                    <i class="fa fa-heart"
                                                                                                         aria-hidden="true"></i>
                                                                                                    <span
                                                                                                         class="ajax_wishlist_text">Add
                                                                                                         to
                                                                                                         Wishlist</span>
                                                                                               </span>
                                                                                          </a>

                                                                                     </div>
                                                                                     <div class="compare">
                                                                                          <a class="st-compare-button btn-product btn"
                                                                                               href="#"
                                                                                               data-id-product="5"
                                                                                               title="Add to Compare">
                                                                                               <span
                                                                                                    class="st-compare-bt-content">
                                                                                                    <i
                                                                                                         class="fa fa-area-chart"></i>
                                                                                                    <span
                                                                                                         class="ajax_compare_text">Add
                                                                                                         to Compare
                                                                                                    </span>
                                                                                          </a>
                                                                                     </div>


                                                                                     <div class="quickview">
                                                                                          <a href="#"
                                                                                               class="quick-view js-quick-view"
                                                                                               data-link-action="quickview">
                                                                                               <i
                                                                                                    class="material-icons search">&#xE417;</i>
                                                                                               Quick view
                                                                                          </a>
                                                                                     </div>

                                                                                </div>
                                                                           </div>
                                                                      </div>

                                                                      <div class="product-description">


                                                                           <div class="brand-title" itemprop="name">
                                                                                <a
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/brand/5-quickcart">QuickCart</a>
                                                                           </div>



                                                                           <h3 class="h3 product-title"><a
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/macbook/5-149-12kg-front-load-washing-machine-with-inverter.html#/5-color-gray"
                                                                                     content="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/macbook/5-149-12kg-front-load-washing-machine-with-inverter.html#/5-color-gray">12kg
                                                                                     Front Load Washing Machine With
                                                                                     Inverter</a></h3>



                                                                           <div class="comments_note">
                                                                                <div class="star_content clearfix">
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                </div>
                                                                                <span class="total-rating">2
                                                                                     Review(s)</span>
                                                                           </div>



                                                                           <div class="product-price-and-shipping">



                                                                                <span class="price" aria-label="Price">
                                                                                     $210.00
                                                                                </span>




                                                                           </div>



                                                                           <div class="proaction-button">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/macbook/5-149-12kg-front-load-washing-machine-with-inverter.html#/5-color-gray"
                                                                                     class="btn btn-primary add-to-cart">
                                                                                     Options
                                                                                </a>
                                                                           </div>



                                                                      </div>
                                                                 </div>
                                                            </article>
                                                            <article class="product_item  slider_item">

                                                                 <div class="product-miniature js-product-miniature"
                                                                      data-id-product="6"
                                                                      data-id-product-attribute="144">
                                                                      <div class="thumbnail-container">

                                                                           <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/adapter-plug/6-144-apple-new-airpods-max-bluetooth-headset.html#/14-color-blue"
                                                                                class="thumbnail product-thumbnail">
                                                                                <img class="lazyload"
                                                                                     src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/195-home_default/apple-new-airpods-max-bluetooth-headset.jpg"
                                                                                     alt="APPLE New AirPods Max Bluetooth Headset"
                                                                                     data-full-size-image-url="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/195-large_default/apple-new-airpods-max-bluetooth-headset.jpg"
                                                                                     width="250" height="250">
                                                                                <img class="lazyload fliper_image img-responsive"
                                                                                     src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/204-home_default/apple-new-airpods-max-bluetooth-headset.jpg"
                                                                                     data-full-size-image-url="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/204-large_default/apple-new-airpods-max-bluetooth-headset.jpg"
                                                                                     alt="" />

                                                                           </a>


                                                                           <div class="highlighted-informations">

                                                                                <div class="variant-links">
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/adapter-plug/6-148-apple-new-airpods-max-bluetooth-headset.html#/9-color-off_white"
                                                                                          class="color "
                                                                                          title="Off White"
                                                                                          style="background-color: #faebd7"><span
                                                                                               class="sr-only">Off
                                                                                               White</span></a>
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/adapter-plug/6-144-apple-new-airpods-max-bluetooth-headset.html#/14-color-blue"
                                                                                          class="color " title="Blue"
                                                                                          style="background-color: #5D9CEC"><span
                                                                                               class="sr-only">Blue</span></a>
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/adapter-plug/6-145-apple-new-airpods-max-bluetooth-headset.html#/15-color-green"
                                                                                          class="color " title="Green"
                                                                                          style="background-color: #A0D468"><span
                                                                                               class="sr-only">Green</span></a>
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/adapter-plug/6-147-apple-new-airpods-max-bluetooth-headset.html#/16-color-yellow"
                                                                                          class="color " title="Yellow"
                                                                                          style="background-color: #F1C40F"><span
                                                                                               class="sr-only">Yellow</span></a>
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/adapter-plug/6-146-apple-new-airpods-max-bluetooth-headset.html#/18-color-pink"
                                                                                          class="color " title="Pink"
                                                                                          style="background-color: #FCCACD"><span
                                                                                               class="sr-only">Pink</span></a>
                                                                                     <span
                                                                                          class="js-count count"></span>
                                                                                </div>

                                                                           </div>


                                                                           <ul class="product-flags js-product-flags">
                                                                                <li class="product-flag on-sale">On
                                                                                     sale!</li>
                                                                                <li class="product-flag discount"><i
                                                                                          class="material-icons left">&#xe3e7;</i>-8%
                                                                                </li>
                                                                                <li class="product-flag new">New</li>
                                                                           </ul>


                                                                           <div class="outer-functional">
                                                                                <div class="functional-buttons">
                                                                                     <div class="wishlist">
                                                                                          <a class="st-wishlist-button btn-product btn"
                                                                                               href="#"
                                                                                               data-id-wishlist=""
                                                                                               data-id-product="6"
                                                                                               data-id-product-attribute="144"
                                                                                               title="Add to Wishlist">
                                                                                               <span
                                                                                                    class="st-wishlist-bt-content">
                                                                                                    <i class="fa fa-heart"
                                                                                                         aria-hidden="true"></i>
                                                                                                    <span
                                                                                                         class="ajax_wishlist_text">Add
                                                                                                         to
                                                                                                         Wishlist</span>
                                                                                               </span>
                                                                                          </a>

                                                                                     </div>
                                                                                     <div class="compare">
                                                                                          <a class="st-compare-button btn-product btn"
                                                                                               href="#"
                                                                                               data-id-product="6"
                                                                                               title="Add to Compare">
                                                                                               <span
                                                                                                    class="st-compare-bt-content">
                                                                                                    <i
                                                                                                         class="fa fa-area-chart"></i>
                                                                                                    <span
                                                                                                         class="ajax_compare_text">Add
                                                                                                         to Compare
                                                                                                    </span>
                                                                                          </a>
                                                                                     </div>


                                                                                     <div class="quickview">
                                                                                          <a href="#"
                                                                                               class="quick-view js-quick-view"
                                                                                               data-link-action="quickview">
                                                                                               <i
                                                                                                    class="material-icons search">&#xE417;</i>
                                                                                               Quick view
                                                                                          </a>
                                                                                     </div>

                                                                                </div>
                                                                           </div>
                                                                      </div>

                                                                      <div class="product-description">


                                                                           <div class="brand-title" itemprop="name">
                                                                                <a
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/brand/4-megamart">MegaMart</a>
                                                                           </div>



                                                                           <h3 class="h3 product-title"><a
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/adapter-plug/6-144-apple-new-airpods-max-bluetooth-headset.html#/14-color-blue"
                                                                                     content="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/adapter-plug/6-144-apple-new-airpods-max-bluetooth-headset.html#/14-color-blue">APPLE
                                                                                     New AirPods Max Bluetooth
                                                                                     Headset</a></h3>



                                                                           <div class="comments_note">
                                                                                <div class="star_content clearfix">
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                </div>
                                                                                <span class="total-rating">2
                                                                                     Review(s)</span>
                                                                           </div>



                                                                           <div class="product-price-and-shipping">


                                                                                <span class="regular-price"
                                                                                     aria-label="Regular price">$24.00</span>
                                                                                <span
                                                                                     class="discount-percentage discount-product">-8%
                                                                                     <span>Off</span></span>



                                                                                <span class="price" aria-label="Price">
                                                                                     $22.08
                                                                                </span>




                                                                           </div>



                                                                           <div class="proaction-button">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/adapter-plug/6-144-apple-new-airpods-max-bluetooth-headset.html#/14-color-blue"
                                                                                     class="btn btn-primary add-to-cart">
                                                                                     Options
                                                                                </a>
                                                                           </div>



                                                                      </div>
                                                                 </div>
                                                            </article>
                                                            <article class="product_item  slider_item">

                                                                 <div class="product-miniature js-product-miniature"
                                                                      data-id-product="7"
                                                                      data-id-product-attribute="141">
                                                                      <div class="thumbnail-container">

                                                                           <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/convertible-laptops/7-141-oneplus-nord-2r-wireless-earbuds-with-dual-mic.html#/8-color-white"
                                                                                class="thumbnail product-thumbnail">
                                                                                <img class="lazyload"
                                                                                     src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/187-home_default/oneplus-nord-2r-wireless-earbuds-with-dual-mic.jpg"
                                                                                     alt="OnePlus Nord 2r Wireless Earbuds with Dual Mic"
                                                                                     data-full-size-image-url="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/187-large_default/oneplus-nord-2r-wireless-earbuds-with-dual-mic.jpg"
                                                                                     width="250" height="250">
                                                                                <img class="lazyload fliper_image img-responsive"
                                                                                     src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/192-home_default/oneplus-nord-2r-wireless-earbuds-with-dual-mic.jpg"
                                                                                     data-full-size-image-url="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/192-large_default/oneplus-nord-2r-wireless-earbuds-with-dual-mic.jpg"
                                                                                     alt="" />

                                                                           </a>


                                                                           <div class="highlighted-informations">

                                                                                <div class="variant-links">
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/convertible-laptops/7-141-oneplus-nord-2r-wireless-earbuds-with-dual-mic.html#/8-color-white"
                                                                                          class="color " title="White"
                                                                                          style="background-color: #ffffff"><span
                                                                                               class="sr-only">White</span></a>
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/convertible-laptops/7-143-oneplus-nord-2r-wireless-earbuds-with-dual-mic.html#/11-color-black"
                                                                                          class="color " title="Black"
                                                                                          style="background-color: #434A54"><span
                                                                                               class="sr-only">Black</span></a>
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/convertible-laptops/7-142-oneplus-nord-2r-wireless-earbuds-with-dual-mic.html#/14-color-blue"
                                                                                          class="color " title="Blue"
                                                                                          style="background-color: #5D9CEC"><span
                                                                                               class="sr-only">Blue</span></a>
                                                                                     <span
                                                                                          class="js-count count"></span>
                                                                                </div>

                                                                           </div>


                                                                           <ul class="product-flags js-product-flags">
                                                                                <li class="product-flag on-sale">On
                                                                                     sale!</li>
                                                                                <li class="product-flag discount"><i
                                                                                          class="material-icons left">&#xe3e7;</i>-$5.00
                                                                                </li>
                                                                                <li class="product-flag new">New</li>
                                                                           </ul>


                                                                           <div class="outer-functional">
                                                                                <div class="functional-buttons">
                                                                                     <div class="wishlist">
                                                                                          <a class="st-wishlist-button btn-product btn"
                                                                                               href="#"
                                                                                               data-id-wishlist=""
                                                                                               data-id-product="7"
                                                                                               data-id-product-attribute="141"
                                                                                               title="Add to Wishlist">
                                                                                               <span
                                                                                                    class="st-wishlist-bt-content">
                                                                                                    <i class="fa fa-heart"
                                                                                                         aria-hidden="true"></i>
                                                                                                    <span
                                                                                                         class="ajax_wishlist_text">Add
                                                                                                         to
                                                                                                         Wishlist</span>
                                                                                               </span>
                                                                                          </a>

                                                                                     </div>
                                                                                     <div class="compare">
                                                                                          <a class="st-compare-button btn-product btn"
                                                                                               href="#"
                                                                                               data-id-product="7"
                                                                                               title="Add to Compare">
                                                                                               <span
                                                                                                    class="st-compare-bt-content">
                                                                                                    <i
                                                                                                         class="fa fa-area-chart"></i>
                                                                                                    <span
                                                                                                         class="ajax_compare_text">Add
                                                                                                         to Compare
                                                                                                    </span>
                                                                                          </a>
                                                                                     </div>


                                                                                     <div class="quickview">
                                                                                          <a href="#"
                                                                                               class="quick-view js-quick-view"
                                                                                               data-link-action="quickview">
                                                                                               <i
                                                                                                    class="material-icons search">&#xE417;</i>
                                                                                               Quick view
                                                                                          </a>
                                                                                     </div>

                                                                                </div>
                                                                           </div>
                                                                      </div>

                                                                      <div class="product-description">


                                                                           <div class="brand-title" itemprop="name">
                                                                                <a
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/brand/3-ecoshop">EcoShop</a>
                                                                           </div>



                                                                           <h3 class="h3 product-title"><a
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/convertible-laptops/7-141-oneplus-nord-2r-wireless-earbuds-with-dual-mic.html#/8-color-white"
                                                                                     content="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/convertible-laptops/7-141-oneplus-nord-2r-wireless-earbuds-with-dual-mic.html#/8-color-white">OnePlus
                                                                                     Nord 2r Wireless Earbuds with Dual
                                                                                     Mic</a></h3>



                                                                           <div class="comments_note">
                                                                                <div class="star_content clearfix">
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                </div>
                                                                                <span class="total-rating">3
                                                                                     Review(s)</span>
                                                                           </div>



                                                                           <div class="product-price-and-shipping">


                                                                                <span class="regular-price"
                                                                                     aria-label="Regular price">$37.00</span>
                                                                                <span
                                                                                     class="discount-amount discount-product">-$5.00<span>
                                                                                          Off</span></span>



                                                                                <span class="price" aria-label="Price">
                                                                                     $32.00
                                                                                </span>




                                                                           </div>



                                                                           <div class="proaction-button">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/convertible-laptops/7-141-oneplus-nord-2r-wireless-earbuds-with-dual-mic.html#/8-color-white"
                                                                                     class="btn btn-primary add-to-cart">
                                                                                     Options
                                                                                </a>
                                                                           </div>



                                                                      </div>
                                                                 </div>
                                                            </article>
                                                            <article class="product_item  slider_item">

                                                                 <div class="product-miniature js-product-miniature"
                                                                      data-id-product="8"
                                                                      data-id-product-attribute="137">
                                                                      <div class="thumbnail-container">

                                                                           <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/bettery-chargers/8-137-hp-smart-tank-all-in-one-wifi-colour-printer.html#/10-color-red"
                                                                                class="thumbnail product-thumbnail">
                                                                                <img class="lazyload"
                                                                                     src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/180-home_default/hp-smart-tank-all-in-one-wifi-colour-printer.jpg"
                                                                                     alt="HP Smart Tank All-in-one WiFi Colour Printer"
                                                                                     data-full-size-image-url="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/180-large_default/hp-smart-tank-all-in-one-wifi-colour-printer.jpg"
                                                                                     width="250" height="250">
                                                                                <img class="lazyload fliper_image img-responsive"
                                                                                     src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/181-home_default/hp-smart-tank-all-in-one-wifi-colour-printer.jpg"
                                                                                     data-full-size-image-url="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/181-large_default/hp-smart-tank-all-in-one-wifi-colour-printer.jpg"
                                                                                     alt="" />

                                                                           </a>


                                                                           <div class="highlighted-informations">

                                                                                <div class="variant-links">
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/bettery-chargers/8-140-hp-smart-tank-all-in-one-wifi-colour-printer.html#/5-color-gray"
                                                                                          class="color " title="Gray"
                                                                                          style="background-color: #AAB2BD"><span
                                                                                               class="sr-only">Gray</span></a>
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/bettery-chargers/8-137-hp-smart-tank-all-in-one-wifi-colour-printer.html#/10-color-red"
                                                                                          class="color " title="Red"
                                                                                          style="background-color: #E84C3D"><span
                                                                                               class="sr-only">Red</span></a>
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/bettery-chargers/8-139-hp-smart-tank-all-in-one-wifi-colour-printer.html#/14-color-blue"
                                                                                          class="color " title="Blue"
                                                                                          style="background-color: #5D9CEC"><span
                                                                                               class="sr-only">Blue</span></a>
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/bettery-chargers/8-138-hp-smart-tank-all-in-one-wifi-colour-printer.html#/16-color-yellow"
                                                                                          class="color " title="Yellow"
                                                                                          style="background-color: #F1C40F"><span
                                                                                               class="sr-only">Yellow</span></a>
                                                                                     <span
                                                                                          class="js-count count"></span>
                                                                                </div>

                                                                           </div>


                                                                           <ul class="product-flags js-product-flags">
                                                                                <li class="product-flag new">New</li>
                                                                           </ul>


                                                                           <div class="outer-functional">
                                                                                <div class="functional-buttons">
                                                                                     <div class="wishlist">
                                                                                          <a class="st-wishlist-button btn-product btn"
                                                                                               href="#"
                                                                                               data-id-wishlist=""
                                                                                               data-id-product="8"
                                                                                               data-id-product-attribute="137"
                                                                                               title="Add to Wishlist">
                                                                                               <span
                                                                                                    class="st-wishlist-bt-content">
                                                                                                    <i class="fa fa-heart"
                                                                                                         aria-hidden="true"></i>
                                                                                                    <span
                                                                                                         class="ajax_wishlist_text">Add
                                                                                                         to
                                                                                                         Wishlist</span>
                                                                                               </span>
                                                                                          </a>

                                                                                     </div>
                                                                                     <div class="compare">
                                                                                          <a class="st-compare-button btn-product btn"
                                                                                               href="#"
                                                                                               data-id-product="8"
                                                                                               title="Add to Compare">
                                                                                               <span
                                                                                                    class="st-compare-bt-content">
                                                                                                    <i
                                                                                                         class="fa fa-area-chart"></i>
                                                                                                    <span
                                                                                                         class="ajax_compare_text">Add
                                                                                                         to Compare
                                                                                                    </span>
                                                                                          </a>
                                                                                     </div>


                                                                                     <div class="quickview">
                                                                                          <a href="#"
                                                                                               class="quick-view js-quick-view"
                                                                                               data-link-action="quickview">
                                                                                               <i
                                                                                                    class="material-icons search">&#xE417;</i>
                                                                                               Quick view
                                                                                          </a>
                                                                                     </div>

                                                                                </div>
                                                                           </div>
                                                                      </div>

                                                                      <div class="product-description">


                                                                           <div class="brand-title" itemprop="name">
                                                                                <a
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/brand/6-smartshop">SmartShop</a>
                                                                           </div>



                                                                           <h3 class="h3 product-title"><a
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/bettery-chargers/8-137-hp-smart-tank-all-in-one-wifi-colour-printer.html#/10-color-red"
                                                                                     content="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/bettery-chargers/8-137-hp-smart-tank-all-in-one-wifi-colour-printer.html#/10-color-red">HP
                                                                                     Smart Tank All-in-one WiFi Colour
                                                                                     Printer</a></h3>



                                                                           <div class="comments_note">
                                                                                <div class="star_content clearfix">
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star"></div>
                                                                                </div>
                                                                                <span class="total-rating">1
                                                                                     Review(s)</span>
                                                                           </div>



                                                                           <div class="product-price-and-shipping">



                                                                                <span class="price" aria-label="Price">
                                                                                     $225.00
                                                                                </span>




                                                                           </div>



                                                                           <div class="proaction-button">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/bettery-chargers/8-137-hp-smart-tank-all-in-one-wifi-colour-printer.html#/10-color-red"
                                                                                     class="btn btn-primary add-to-cart">
                                                                                     Options
                                                                                </a>
                                                                           </div>



                                                                      </div>
                                                                 </div>
                                                            </article>

                                                       </div>
                                                       <div class="customNavigation">
                                                            <a class="btn prev feature_prev">&nbsp;</a>
                                                            <a class="btn next feature_next">&nbsp;</a>
                                                       </div>


                                                  </div>
                                             </div>
                                             <div class="view_more">
                                                  <a class="all-product-link btn btn-primary"
                                                       href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/2-home">
                                                       All products
                                                  </a>
                                             </div>
                                        </div>
                                   </div>
                              </section>
                              <section class="bestseller-products products-section">
                                   <div class="container">
                                        <h2 class="h1 products-section-title text-uppercase">
                                             Best Selling Products
                                        </h2>

                                        <div class="products-main-wrapper">
                                             <div class="products-wrapper">
                                                  <div class="products">
                                                       <!-- Define Number of product for SLIDER -->
                                                       <div id="bestseller-carousel" class="cz-carousel product_list">

                                                            <article class="product_item  slider_item">

                                                                 <div class="product-miniature js-product-miniature"
                                                                      data-id-product="16"
                                                                      data-id-product-attribute="100">
                                                                      <div class="thumbnail-container">

                                                                           <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/home-theatre-systems/16-100-apple-macbook-air-133-with-retina-display.html#/5-color-gray/37-internal_storage-64gb"
                                                                                class="thumbnail product-thumbnail">
                                                                                <img class="lazyload"
                                                                                     src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/119-home_default/apple-macbook-air-133-with-retina-display.jpg"
                                                                                     alt="Apple MacBook Air 13.3&quot; With Retina Display"
                                                                                     data-full-size-image-url="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/119-large_default/apple-macbook-air-133-with-retina-display.jpg"
                                                                                     width="250" height="250">
                                                                                <img class="lazyload fliper_image img-responsive"
                                                                                     src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/120-home_default/apple-macbook-air-133-with-retina-display.jpg"
                                                                                     data-full-size-image-url="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/120-large_default/apple-macbook-air-133-with-retina-display.jpg"
                                                                                     alt="" />

                                                                           </a>


                                                                           <div class="highlighted-informations">

                                                                                <div class="variant-links">
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/home-theatre-systems/16-101-apple-macbook-air-133-with-retina-display.html#/5-color-gray/38-internal_storage-128gb"
                                                                                          class="color " title="Gray"
                                                                                          style="background-color: #AAB2BD"><span
                                                                                               class="sr-only">Gray</span></a>
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/home-theatre-systems/16-103-apple-macbook-air-133-with-retina-display.html#/9-color-off_white/37-internal_storage-64gb"
                                                                                          class="color "
                                                                                          title="Off White"
                                                                                          style="background-color: #faebd7"><span
                                                                                               class="sr-only">Off
                                                                                               White</span></a>
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/home-theatre-systems/16-97-apple-macbook-air-133-with-retina-display.html#/13-color-orange/37-internal_storage-64gb"
                                                                                          class="color " title="Orange"
                                                                                          style="background-color: #F39C11"><span
                                                                                               class="sr-only">Orange</span></a>
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/home-theatre-systems/16-106-apple-macbook-air-133-with-retina-display.html#/18-color-pink/37-internal_storage-64gb"
                                                                                          class="color " title="Pink"
                                                                                          style="background-color: #FCCACD"><span
                                                                                               class="sr-only">Pink</span></a>
                                                                                     <span
                                                                                          class="js-count count"></span>
                                                                                </div>

                                                                           </div>


                                                                           <ul class="product-flags js-product-flags">
                                                                                <li class="product-flag on-sale">On
                                                                                     sale!</li>
                                                                                <li class="product-flag discount"><i
                                                                                          class="material-icons left">&#xe3e7;</i>-12%
                                                                                </li>
                                                                                <li class="product-flag new">New</li>
                                                                           </ul>


                                                                           <div class="outer-functional">
                                                                                <div class="functional-buttons">
                                                                                     <div class="wishlist">
                                                                                          <a class="st-wishlist-button btn-product btn"
                                                                                               href="#"
                                                                                               data-id-wishlist=""
                                                                                               data-id-product="16"
                                                                                               data-id-product-attribute="100"
                                                                                               title="Add to Wishlist">
                                                                                               <span
                                                                                                    class="st-wishlist-bt-content">
                                                                                                    <i class="fa fa-heart"
                                                                                                         aria-hidden="true"></i>
                                                                                                    <span
                                                                                                         class="ajax_wishlist_text">Add
                                                                                                         to
                                                                                                         Wishlist</span>
                                                                                               </span>
                                                                                          </a>

                                                                                     </div>
                                                                                     <div class="compare">
                                                                                          <a class="st-compare-button btn-product btn"
                                                                                               href="#"
                                                                                               data-id-product="16"
                                                                                               title="Add to Compare">
                                                                                               <span
                                                                                                    class="st-compare-bt-content">
                                                                                                    <i
                                                                                                         class="fa fa-area-chart"></i>
                                                                                                    <span
                                                                                                         class="ajax_compare_text">Add
                                                                                                         to Compare
                                                                                                    </span>
                                                                                          </a>
                                                                                     </div>


                                                                                     <div class="quickview">
                                                                                          <a href="#"
                                                                                               class="quick-view js-quick-view"
                                                                                               data-link-action="quickview">
                                                                                               <i
                                                                                                    class="material-icons search">&#xE417;</i>
                                                                                               Quick view
                                                                                          </a>
                                                                                     </div>

                                                                                </div>
                                                                           </div>
                                                                      </div>

                                                                      <div class="product-description">


                                                                           <div class="brand-title" itemprop="name">
                                                                                <a
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/brand/5-quickcart">QuickCart</a>
                                                                           </div>



                                                                           <h3 class="h3 product-title"><a
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/home-theatre-systems/16-100-apple-macbook-air-133-with-retina-display.html#/5-color-gray/37-internal_storage-64gb"
                                                                                     content="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/home-theatre-systems/16-100-apple-macbook-air-133-with-retina-display.html#/5-color-gray/37-internal_storage-64gb">Apple
                                                                                     MacBook Air 13.3&quot; With Retina
                                                                                     Display</a></h3>



                                                                           <div class="comments_note">
                                                                                <div class="star_content clearfix">
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                </div>
                                                                                <span class="total-rating">1
                                                                                     Review(s)</span>
                                                                           </div>



                                                                           <div class="product-price-and-shipping">


                                                                                <span class="regular-price"
                                                                                     aria-label="Regular price">$878.00</span>
                                                                                <span
                                                                                     class="discount-percentage discount-product">-12%
                                                                                     <span>Off</span></span>



                                                                                <span class="price" aria-label="Price">
                                                                                     $772.64
                                                                                </span>




                                                                           </div>



                                                                           <div class="proaction-button">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/home-theatre-systems/16-100-apple-macbook-air-133-with-retina-display.html#/5-color-gray/37-internal_storage-64gb"
                                                                                     class="btn btn-primary add-to-cart">
                                                                                     Options
                                                                                </a>
                                                                           </div>



                                                                      </div>
                                                                 </div>
                                                            </article>
                                                            <article class="product_item  slider_item">

                                                                 <div class="product-miniature js-product-miniature"
                                                                      data-id-product="4"
                                                                      data-id-product-attribute="154">
                                                                      <div class="thumbnail-container">

                                                                           <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/4-154-samsung-qn85aa-series-neo-qled-4k-uhd-smart-tv.html#/9-color-off_white"
                                                                                class="thumbnail product-thumbnail">
                                                                                <img class="lazyload"
                                                                                     src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/216-home_default/samsung-qn85aa-series-neo-qled-4k-uhd-smart-tv.jpg"
                                                                                     alt="Samsung QN85AA Series Neo QLED 4K UHD Smart TV"
                                                                                     data-full-size-image-url="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/216-large_default/samsung-qn85aa-series-neo-qled-4k-uhd-smart-tv.jpg"
                                                                                     width="250" height="250">
                                                                                <img class="lazyload fliper_image img-responsive"
                                                                                     src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/217-home_default/samsung-qn85aa-series-neo-qled-4k-uhd-smart-tv.jpg"
                                                                                     data-full-size-image-url="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/217-large_default/samsung-qn85aa-series-neo-qled-4k-uhd-smart-tv.jpg"
                                                                                     alt="" />

                                                                           </a>


                                                                           <div class="highlighted-informations">

                                                                                <div class="variant-links">
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/4-154-samsung-qn85aa-series-neo-qled-4k-uhd-smart-tv.html#/9-color-off_white"
                                                                                          class="color "
                                                                                          title="Off White"
                                                                                          style="background-color: #faebd7"><span
                                                                                               class="sr-only">Off
                                                                                               White</span></a>
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/4-155-samsung-qn85aa-series-neo-qled-4k-uhd-smart-tv.html#/12-color-camel"
                                                                                          class="color " title="Camel"
                                                                                          style="background-color: #C19A6B"><span
                                                                                               class="sr-only">Camel</span></a>
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/4-156-samsung-qn85aa-series-neo-qled-4k-uhd-smart-tv.html#/14-color-blue"
                                                                                          class="color " title="Blue"
                                                                                          style="background-color: #5D9CEC"><span
                                                                                               class="sr-only">Blue</span></a>
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/4-157-samsung-qn85aa-series-neo-qled-4k-uhd-smart-tv.html#/15-color-green"
                                                                                          class="color " title="Green"
                                                                                          style="background-color: #A0D468"><span
                                                                                               class="sr-only">Green</span></a>
                                                                                     <span
                                                                                          class="js-count count"></span>
                                                                                </div>

                                                                           </div>


                                                                           <ul class="product-flags js-product-flags">
                                                                                <li class="product-flag new">New</li>
                                                                           </ul>


                                                                           <div class="outer-functional">
                                                                                <div class="functional-buttons">
                                                                                     <div class="wishlist">
                                                                                          <a class="st-wishlist-button btn-product btn"
                                                                                               href="#"
                                                                                               data-id-wishlist=""
                                                                                               data-id-product="4"
                                                                                               data-id-product-attribute="154"
                                                                                               title="Add to Wishlist">
                                                                                               <span
                                                                                                    class="st-wishlist-bt-content">
                                                                                                    <i class="fa fa-heart"
                                                                                                         aria-hidden="true"></i>
                                                                                                    <span
                                                                                                         class="ajax_wishlist_text">Add
                                                                                                         to
                                                                                                         Wishlist</span>
                                                                                               </span>
                                                                                          </a>

                                                                                     </div>
                                                                                     <div class="compare">
                                                                                          <a class="st-compare-button btn-product btn"
                                                                                               href="#"
                                                                                               data-id-product="4"
                                                                                               title="Add to Compare">
                                                                                               <span
                                                                                                    class="st-compare-bt-content">
                                                                                                    <i
                                                                                                         class="fa fa-area-chart"></i>
                                                                                                    <span
                                                                                                         class="ajax_compare_text">Add
                                                                                                         to Compare
                                                                                                    </span>
                                                                                          </a>
                                                                                     </div>


                                                                                     <div class="quickview">
                                                                                          <a href="#"
                                                                                               class="quick-view js-quick-view"
                                                                                               data-link-action="quickview">
                                                                                               <i
                                                                                                    class="material-icons search">&#xE417;</i>
                                                                                               Quick view
                                                                                          </a>
                                                                                     </div>

                                                                                </div>
                                                                           </div>
                                                                      </div>

                                                                      <div class="product-description">


                                                                           <div class="brand-title" itemprop="name">
                                                                                <a
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/brand/6-smartshop">SmartShop</a>
                                                                           </div>



                                                                           <h3 class="h3 product-title"><a
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/4-154-samsung-qn85aa-series-neo-qled-4k-uhd-smart-tv.html#/9-color-off_white"
                                                                                     content="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/4-154-samsung-qn85aa-series-neo-qled-4k-uhd-smart-tv.html#/9-color-off_white">Samsung
                                                                                     QN85AA Series Neo QLED 4K UHD Smart
                                                                                     TV</a></h3>



                                                                           <div class="comments_note">
                                                                                <div class="star_content clearfix">
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                </div>
                                                                                <span class="total-rating">1
                                                                                     Review(s)</span>
                                                                           </div>



                                                                           <div class="product-price-and-shipping">



                                                                                <span class="price" aria-label="Price">
                                                                                     $560.00
                                                                                </span>




                                                                           </div>



                                                                           <div class="proaction-button">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/4-154-samsung-qn85aa-series-neo-qled-4k-uhd-smart-tv.html#/9-color-off_white"
                                                                                     class="btn btn-primary add-to-cart">
                                                                                     Options
                                                                                </a>
                                                                           </div>



                                                                      </div>
                                                                 </div>
                                                            </article>
                                                            <article class="product_item  slider_item">

                                                                 <div class="product-miniature js-product-miniature"
                                                                      data-id-product="21"
                                                                      data-id-product-attribute="66">
                                                                      <div class="thumbnail-container">

                                                                           <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/macbook/21-66-logitech-wireless-mini-mouse-m187-ultra-portable.html#/14-color-blue"
                                                                                class="thumbnail product-thumbnail">
                                                                                <img class="lazyload"
                                                                                     src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/63-home_default/logitech-wireless-mini-mouse-m187-ultra-portable.jpg"
                                                                                     alt="Logitech Wireless Mini Mouse M187 Ultra Portable"
                                                                                     data-full-size-image-url="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/63-large_default/logitech-wireless-mini-mouse-m187-ultra-portable.jpg"
                                                                                     width="250" height="250">
                                                                                <img class="lazyload fliper_image img-responsive"
                                                                                     src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/69-home_default/logitech-wireless-mini-mouse-m187-ultra-portable.jpg"
                                                                                     data-full-size-image-url="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/69-large_default/logitech-wireless-mini-mouse-m187-ultra-portable.jpg"
                                                                                     alt="" />

                                                                           </a>


                                                                           <div class="highlighted-informations">

                                                                                <div class="variant-links">
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/macbook/21-68-logitech-wireless-mini-mouse-m187-ultra-portable.html#/10-color-red"
                                                                                          class="color " title="Red"
                                                                                          style="background-color: #E84C3D"><span
                                                                                               class="sr-only">Red</span></a>
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/macbook/21-69-logitech-wireless-mini-mouse-m187-ultra-portable.html#/11-color-black"
                                                                                          class="color " title="Black"
                                                                                          style="background-color: #434A54"><span
                                                                                               class="sr-only">Black</span></a>
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/macbook/21-67-logitech-wireless-mini-mouse-m187-ultra-portable.html#/13-color-orange"
                                                                                          class="color " title="Orange"
                                                                                          style="background-color: #F39C11"><span
                                                                                               class="sr-only">Orange</span></a>
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/macbook/21-66-logitech-wireless-mini-mouse-m187-ultra-portable.html#/14-color-blue"
                                                                                          class="color " title="Blue"
                                                                                          style="background-color: #5D9CEC"><span
                                                                                               class="sr-only">Blue</span></a>
                                                                                     <span
                                                                                          class="js-count count"></span>
                                                                                </div>

                                                                           </div>


                                                                           <ul class="product-flags js-product-flags">
                                                                                <li class="product-flag new">New</li>
                                                                           </ul>


                                                                           <div class="outer-functional">
                                                                                <div class="functional-buttons">
                                                                                     <div class="wishlist">
                                                                                          <a class="st-wishlist-button btn-product btn"
                                                                                               href="#"
                                                                                               data-id-wishlist=""
                                                                                               data-id-product="21"
                                                                                               data-id-product-attribute="66"
                                                                                               title="Add to Wishlist">
                                                                                               <span
                                                                                                    class="st-wishlist-bt-content">
                                                                                                    <i class="fa fa-heart"
                                                                                                         aria-hidden="true"></i>
                                                                                                    <span
                                                                                                         class="ajax_wishlist_text">Add
                                                                                                         to
                                                                                                         Wishlist</span>
                                                                                               </span>
                                                                                          </a>

                                                                                     </div>
                                                                                     <div class="compare">
                                                                                          <a class="st-compare-button btn-product btn"
                                                                                               href="#"
                                                                                               data-id-product="21"
                                                                                               title="Add to Compare">
                                                                                               <span
                                                                                                    class="st-compare-bt-content">
                                                                                                    <i
                                                                                                         class="fa fa-area-chart"></i>
                                                                                                    <span
                                                                                                         class="ajax_compare_text">Add
                                                                                                         to Compare
                                                                                                    </span>
                                                                                          </a>
                                                                                     </div>


                                                                                     <div class="quickview">
                                                                                          <a href="#"
                                                                                               class="quick-view js-quick-view"
                                                                                               data-link-action="quickview">
                                                                                               <i
                                                                                                    class="material-icons search">&#xE417;</i>
                                                                                               Quick view
                                                                                          </a>
                                                                                     </div>

                                                                                </div>
                                                                           </div>
                                                                      </div>

                                                                      <div class="product-description">


                                                                           <div class="brand-title" itemprop="name">
                                                                                <a
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/brand/3-ecoshop">EcoShop</a>
                                                                           </div>



                                                                           <h3 class="h3 product-title"><a
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/macbook/21-66-logitech-wireless-mini-mouse-m187-ultra-portable.html#/14-color-blue"
                                                                                     content="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/macbook/21-66-logitech-wireless-mini-mouse-m187-ultra-portable.html#/14-color-blue">Logitech
                                                                                     Wireless Mini Mouse M187 Ultra
                                                                                     Portable</a></h3>



                                                                           <div class="comments_note">
                                                                                <div class="star_content clearfix">
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star"></div>
                                                                                </div>
                                                                                <span class="total-rating">3
                                                                                     Review(s)</span>
                                                                           </div>



                                                                           <div class="product-price-and-shipping">



                                                                                <span class="price" aria-label="Price">
                                                                                     $18.00
                                                                                </span>




                                                                           </div>



                                                                           <div class="proaction-button">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/macbook/21-66-logitech-wireless-mini-mouse-m187-ultra-portable.html#/14-color-blue"
                                                                                     class="btn btn-primary add-to-cart">
                                                                                     Options
                                                                                </a>
                                                                           </div>



                                                                      </div>
                                                                 </div>
                                                            </article>
                                                            <article class="product_item  slider_item">

                                                                 <div class="product-miniature js-product-miniature"
                                                                      data-id-product="12"
                                                                      data-id-product-attribute="117">
                                                                      <div class="thumbnail-container">

                                                                           <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/12-117-momentum-2k-indoor-security-camera-for-home.html#/9-color-off_white"
                                                                                class="thumbnail product-thumbnail">
                                                                                <img class="lazyload"
                                                                                     src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/154-home_default/momentum-2k-indoor-security-camera-for-home.jpg"
                                                                                     alt="MOMENTUM 2K Indoor Security Camera for Home"
                                                                                     data-full-size-image-url="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/154-large_default/momentum-2k-indoor-security-camera-for-home.jpg"
                                                                                     width="250" height="250">
                                                                                <img class="lazyload fliper_image img-responsive"
                                                                                     src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/155-home_default/momentum-2k-indoor-security-camera-for-home.jpg"
                                                                                     data-full-size-image-url="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/155-large_default/momentum-2k-indoor-security-camera-for-home.jpg"
                                                                                     alt="" />

                                                                           </a>


                                                                           <div class="highlighted-informations">

                                                                                <div class="variant-links">
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/12-117-momentum-2k-indoor-security-camera-for-home.html#/9-color-off_white"
                                                                                          class="color "
                                                                                          title="Off White"
                                                                                          style="background-color: #faebd7"><span
                                                                                               class="sr-only">Off
                                                                                               White</span></a>
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/12-119-momentum-2k-indoor-security-camera-for-home.html#/15-color-green"
                                                                                          class="color " title="Green"
                                                                                          style="background-color: #A0D468"><span
                                                                                               class="sr-only">Green</span></a>
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/12-118-momentum-2k-indoor-security-camera-for-home.html#/16-color-yellow"
                                                                                          class="color " title="Yellow"
                                                                                          style="background-color: #F1C40F"><span
                                                                                               class="sr-only">Yellow</span></a>
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/12-120-momentum-2k-indoor-security-camera-for-home.html#/18-color-pink"
                                                                                          class="color " title="Pink"
                                                                                          style="background-color: #FCCACD"><span
                                                                                               class="sr-only">Pink</span></a>
                                                                                     <span
                                                                                          class="js-count count"></span>
                                                                                </div>

                                                                           </div>


                                                                           <ul class="product-flags js-product-flags">
                                                                                <li class="product-flag new">New</li>
                                                                           </ul>


                                                                           <div class="outer-functional">
                                                                                <div class="functional-buttons">
                                                                                     <div class="wishlist">
                                                                                          <a class="st-wishlist-button btn-product btn"
                                                                                               href="#"
                                                                                               data-id-wishlist=""
                                                                                               data-id-product="12"
                                                                                               data-id-product-attribute="117"
                                                                                               title="Add to Wishlist">
                                                                                               <span
                                                                                                    class="st-wishlist-bt-content">
                                                                                                    <i class="fa fa-heart"
                                                                                                         aria-hidden="true"></i>
                                                                                                    <span
                                                                                                         class="ajax_wishlist_text">Add
                                                                                                         to
                                                                                                         Wishlist</span>
                                                                                               </span>
                                                                                          </a>

                                                                                     </div>
                                                                                     <div class="compare">
                                                                                          <a class="st-compare-button btn-product btn"
                                                                                               href="#"
                                                                                               data-id-product="12"
                                                                                               title="Add to Compare">
                                                                                               <span
                                                                                                    class="st-compare-bt-content">
                                                                                                    <i
                                                                                                         class="fa fa-area-chart"></i>
                                                                                                    <span
                                                                                                         class="ajax_compare_text">Add
                                                                                                         to Compare
                                                                                                    </span>
                                                                                          </a>
                                                                                     </div>


                                                                                     <div class="quickview">
                                                                                          <a href="#"
                                                                                               class="quick-view js-quick-view"
                                                                                               data-link-action="quickview">
                                                                                               <i
                                                                                                    class="material-icons search">&#xE417;</i>
                                                                                               Quick view
                                                                                          </a>
                                                                                     </div>

                                                                                </div>
                                                                           </div>
                                                                      </div>

                                                                      <div class="product-description">


                                                                           <div class="brand-title" itemprop="name">
                                                                                <a
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/brand/2-cartify">Cartify</a>
                                                                           </div>



                                                                           <h3 class="h3 product-title"><a
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/12-117-momentum-2k-indoor-security-camera-for-home.html#/9-color-off_white"
                                                                                     content="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/12-117-momentum-2k-indoor-security-camera-for-home.html#/9-color-off_white">MOMENTUM
                                                                                     2K Indoor Security Camera for
                                                                                     Home</a></h3>



                                                                           <div class="comments_note">
                                                                                <div class="star_content clearfix">
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                </div>
                                                                                <span class="total-rating">2
                                                                                     Review(s)</span>
                                                                           </div>



                                                                           <div class="product-price-and-shipping">



                                                                                <span class="price" aria-label="Price">
                                                                                     $190.00
                                                                                </span>




                                                                           </div>



                                                                           <div class="proaction-button">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/12-117-momentum-2k-indoor-security-camera-for-home.html#/9-color-off_white"
                                                                                     class="btn btn-primary add-to-cart">
                                                                                     Options
                                                                                </a>
                                                                           </div>



                                                                      </div>
                                                                 </div>
                                                            </article>
                                                            <article class="product_item  slider_item">

                                                                 <div class="product-miniature js-product-miniature"
                                                                      data-id-product="10"
                                                                      data-id-product-attribute="0">
                                                                      <div class="thumbnail-container">

                                                                           <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/chargers-cables/10-noise-colorfit-ultra-3-bluetooth-calling-smart-watch.html"
                                                                                class="thumbnail product-thumbnail">
                                                                                <img class="lazyload"
                                                                                     src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/170-home_default/noise-colorfit-ultra-3-bluetooth-calling-smart-watch.jpg"
                                                                                     alt="Noise ColorFit Ultra 3 Bluetooth Calling Smart Watch"
                                                                                     data-full-size-image-url="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/170-large_default/noise-colorfit-ultra-3-bluetooth-calling-smart-watch.jpg"
                                                                                     width="250" height="250">
                                                                                <img class="lazyload fliper_image img-responsive"
                                                                                     src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/171-home_default/noise-colorfit-ultra-3-bluetooth-calling-smart-watch.jpg"
                                                                                     data-full-size-image-url="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/171-large_default/noise-colorfit-ultra-3-bluetooth-calling-smart-watch.jpg"
                                                                                     alt="" />

                                                                           </a>


                                                                           <div
                                                                                class="highlighted-informations no-variants">


                                                                           </div>


                                                                           <ul class="product-flags js-product-flags">
                                                                                <li class="product-flag new">New</li>
                                                                           </ul>


                                                                           <div class="outer-functional">
                                                                                <div class="functional-buttons">
                                                                                     <div class="wishlist">
                                                                                          <a class="st-wishlist-button btn-product btn"
                                                                                               href="#"
                                                                                               data-id-wishlist=""
                                                                                               data-id-product="10"
                                                                                               data-id-product-attribute="0"
                                                                                               title="Add to Wishlist">
                                                                                               <span
                                                                                                    class="st-wishlist-bt-content">
                                                                                                    <i class="fa fa-heart"
                                                                                                         aria-hidden="true"></i>
                                                                                                    <span
                                                                                                         class="ajax_wishlist_text">Add
                                                                                                         to
                                                                                                         Wishlist</span>
                                                                                               </span>
                                                                                          </a>

                                                                                     </div>
                                                                                     <div class="compare">
                                                                                          <a class="st-compare-button btn-product btn"
                                                                                               href="#"
                                                                                               data-id-product="10"
                                                                                               title="Add to Compare">
                                                                                               <span
                                                                                                    class="st-compare-bt-content">
                                                                                                    <i
                                                                                                         class="fa fa-area-chart"></i>
                                                                                                    <span
                                                                                                         class="ajax_compare_text">Add
                                                                                                         to Compare
                                                                                                    </span>
                                                                                          </a>
                                                                                     </div>


                                                                                     <div class="quickview">
                                                                                          <a href="#"
                                                                                               class="quick-view js-quick-view"
                                                                                               data-link-action="quickview">
                                                                                               <i
                                                                                                    class="material-icons search">&#xE417;</i>
                                                                                               Quick view
                                                                                          </a>
                                                                                     </div>

                                                                                </div>
                                                                           </div>
                                                                      </div>

                                                                      <div class="product-description">


                                                                           <div class="brand-title" itemprop="name">
                                                                                <a
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/brand/6-smartshop">SmartShop</a>
                                                                           </div>



                                                                           <h3 class="h3 product-title"><a
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/chargers-cables/10-noise-colorfit-ultra-3-bluetooth-calling-smart-watch.html"
                                                                                     content="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/chargers-cables/10-noise-colorfit-ultra-3-bluetooth-calling-smart-watch.html">Noise
                                                                                     ColorFit Ultra 3 Bluetooth Calling
                                                                                     Smart Watch</a></h3>



                                                                           <div class="comments_note">
                                                                                <div class="star_content clearfix">
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                </div>
                                                                                <span class="total-rating">2
                                                                                     Review(s)</span>
                                                                           </div>



                                                                           <div class="product-price-and-shipping">



                                                                                <span class="price" aria-label="Price">
                                                                                     $78.00
                                                                                </span>




                                                                           </div>



                                                                           <div class="proaction-button">
                                                                                <form action="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/cart"
                                                                                     method="post"
                                                                                     class="add-to-cart-or-refresh">
                                                                                     <input type="hidden" name="token"
                                                                                          value="be2e4f21e069f2f9e1a4d6f6ab1dfbfa">
                                                                                     <input type="hidden"
                                                                                          name="id_product" value="10"
                                                                                          class="product_page_product_id">
                                                                                     <input type="hidden"
                                                                                          name="id_customization"
                                                                                          value="0"
                                                                                          id="product_customization_id"
                                                                                          class="js-product-customization-id">
                                                                                     <button
                                                                                          class="btn btn-primary add-to-cart"
                                                                                          data-button-action="add-to-cart"
                                                                                          type="submit">
                                                                                          Add to cart
                                                                                     </button>
                                                                                </form>
                                                                           </div>



                                                                      </div>
                                                                 </div>
                                                            </article>
                                                            <article class="product_item  slider_item">

                                                                 <div class="product-miniature js-product-miniature"
                                                                      data-id-product="8"
                                                                      data-id-product-attribute="137">
                                                                      <div class="thumbnail-container">

                                                                           <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/bettery-chargers/8-137-hp-smart-tank-all-in-one-wifi-colour-printer.html#/10-color-red"
                                                                                class="thumbnail product-thumbnail">
                                                                                <img class="lazyload"
                                                                                     src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/180-home_default/hp-smart-tank-all-in-one-wifi-colour-printer.jpg"
                                                                                     alt="HP Smart Tank All-in-one WiFi Colour Printer"
                                                                                     data-full-size-image-url="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/180-large_default/hp-smart-tank-all-in-one-wifi-colour-printer.jpg"
                                                                                     width="250" height="250">
                                                                                <img class="lazyload fliper_image img-responsive"
                                                                                     src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/181-home_default/hp-smart-tank-all-in-one-wifi-colour-printer.jpg"
                                                                                     data-full-size-image-url="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/181-large_default/hp-smart-tank-all-in-one-wifi-colour-printer.jpg"
                                                                                     alt="" />

                                                                           </a>


                                                                           <div class="highlighted-informations">

                                                                                <div class="variant-links">
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/bettery-chargers/8-140-hp-smart-tank-all-in-one-wifi-colour-printer.html#/5-color-gray"
                                                                                          class="color " title="Gray"
                                                                                          style="background-color: #AAB2BD"><span
                                                                                               class="sr-only">Gray</span></a>
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/bettery-chargers/8-137-hp-smart-tank-all-in-one-wifi-colour-printer.html#/10-color-red"
                                                                                          class="color " title="Red"
                                                                                          style="background-color: #E84C3D"><span
                                                                                               class="sr-only">Red</span></a>
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/bettery-chargers/8-139-hp-smart-tank-all-in-one-wifi-colour-printer.html#/14-color-blue"
                                                                                          class="color " title="Blue"
                                                                                          style="background-color: #5D9CEC"><span
                                                                                               class="sr-only">Blue</span></a>
                                                                                     <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/bettery-chargers/8-138-hp-smart-tank-all-in-one-wifi-colour-printer.html#/16-color-yellow"
                                                                                          class="color " title="Yellow"
                                                                                          style="background-color: #F1C40F"><span
                                                                                               class="sr-only">Yellow</span></a>
                                                                                     <span
                                                                                          class="js-count count"></span>
                                                                                </div>

                                                                           </div>


                                                                           <ul class="product-flags js-product-flags">
                                                                                <li class="product-flag new">New</li>
                                                                           </ul>


                                                                           <div class="outer-functional">
                                                                                <div class="functional-buttons">
                                                                                     <div class="wishlist">
                                                                                          <a class="st-wishlist-button btn-product btn"
                                                                                               href="#"
                                                                                               data-id-wishlist=""
                                                                                               data-id-product="8"
                                                                                               data-id-product-attribute="137"
                                                                                               title="Add to Wishlist">
                                                                                               <span
                                                                                                    class="st-wishlist-bt-content">
                                                                                                    <i class="fa fa-heart"
                                                                                                         aria-hidden="true"></i>
                                                                                                    <span
                                                                                                         class="ajax_wishlist_text">Add
                                                                                                         to
                                                                                                         Wishlist</span>
                                                                                               </span>
                                                                                          </a>

                                                                                     </div>
                                                                                     <div class="compare">
                                                                                          <a class="st-compare-button btn-product btn"
                                                                                               href="#"
                                                                                               data-id-product="8"
                                                                                               title="Add to Compare">
                                                                                               <span
                                                                                                    class="st-compare-bt-content">
                                                                                                    <i
                                                                                                         class="fa fa-area-chart"></i>
                                                                                                    <span
                                                                                                         class="ajax_compare_text">Add
                                                                                                         to Compare
                                                                                                    </span>
                                                                                          </a>
                                                                                     </div>


                                                                                     <div class="quickview">
                                                                                          <a href="#"
                                                                                               class="quick-view js-quick-view"
                                                                                               data-link-action="quickview">
                                                                                               <i
                                                                                                    class="material-icons search">&#xE417;</i>
                                                                                               Quick view
                                                                                          </a>
                                                                                     </div>

                                                                                </div>
                                                                           </div>
                                                                      </div>

                                                                      <div class="product-description">


                                                                           <div class="brand-title" itemprop="name">
                                                                                <a
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/brand/6-smartshop">SmartShop</a>
                                                                           </div>



                                                                           <h3 class="h3 product-title"><a
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/bettery-chargers/8-137-hp-smart-tank-all-in-one-wifi-colour-printer.html#/10-color-red"
                                                                                     content="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/bettery-chargers/8-137-hp-smart-tank-all-in-one-wifi-colour-printer.html#/10-color-red">HP
                                                                                     Smart Tank All-in-one WiFi Colour
                                                                                     Printer</a></h3>



                                                                           <div class="comments_note">
                                                                                <div class="star_content clearfix">
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star"></div>
                                                                                </div>
                                                                                <span class="total-rating">1
                                                                                     Review(s)</span>
                                                                           </div>



                                                                           <div class="product-price-and-shipping">



                                                                                <span class="price" aria-label="Price">
                                                                                     $225.00
                                                                                </span>




                                                                           </div>



                                                                           <div class="proaction-button">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/bettery-chargers/8-137-hp-smart-tank-all-in-one-wifi-colour-printer.html#/10-color-red"
                                                                                     class="btn btn-primary add-to-cart">
                                                                                     Options
                                                                                </a>
                                                                           </div>



                                                                      </div>
                                                                 </div>
                                                            </article>
                                                            <article class="product_item  slider_item">

                                                                 <div class="product-miniature js-product-miniature"
                                                                      data-id-product="2" data-id-product-attribute="0">
                                                                      <div class="thumbnail-container">

                                                                           <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/usb-type-cable/2-rumbloo-silicone-controller-grip-cover-for-oculus-quest-2.html"
                                                                                class="thumbnail product-thumbnail">
                                                                                <img class="lazyload"
                                                                                     src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/239-home_default/rumbloo-silicone-controller-grip-cover-for-oculus-quest-2.jpg"
                                                                                     alt="Rumbloo Silicone Controller Grip Cover for Oculus Quest 2"
                                                                                     data-full-size-image-url="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/239-large_default/rumbloo-silicone-controller-grip-cover-for-oculus-quest-2.jpg"
                                                                                     width="250" height="250">
                                                                                <img class="lazyload fliper_image img-responsive"
                                                                                     src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/240-home_default/rumbloo-silicone-controller-grip-cover-for-oculus-quest-2.jpg"
                                                                                     data-full-size-image-url="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/240-large_default/rumbloo-silicone-controller-grip-cover-for-oculus-quest-2.jpg"
                                                                                     alt="" />

                                                                           </a>


                                                                           <div
                                                                                class="highlighted-informations no-variants">


                                                                           </div>


                                                                           <ul class="product-flags js-product-flags">
                                                                                <li class="product-flag on-sale">On
                                                                                     sale!</li>
                                                                                <li class="product-flag discount"><i
                                                                                          class="material-icons left">&#xe3e7;</i>-15%
                                                                                </li>
                                                                                <li class="product-flag new">New</li>
                                                                           </ul>


                                                                           <div class="outer-functional">
                                                                                <div class="functional-buttons">
                                                                                     <div class="wishlist">
                                                                                          <a class="st-wishlist-button btn-product btn"
                                                                                               href="#"
                                                                                               data-id-wishlist=""
                                                                                               data-id-product="2"
                                                                                               data-id-product-attribute="0"
                                                                                               title="Add to Wishlist">
                                                                                               <span
                                                                                                    class="st-wishlist-bt-content">
                                                                                                    <i class="fa fa-heart"
                                                                                                         aria-hidden="true"></i>
                                                                                                    <span
                                                                                                         class="ajax_wishlist_text">Add
                                                                                                         to
                                                                                                         Wishlist</span>
                                                                                               </span>
                                                                                          </a>

                                                                                     </div>
                                                                                     <div class="compare">
                                                                                          <a class="st-compare-button btn-product btn"
                                                                                               href="#"
                                                                                               data-id-product="2"
                                                                                               title="Add to Compare">
                                                                                               <span
                                                                                                    class="st-compare-bt-content">
                                                                                                    <i
                                                                                                         class="fa fa-area-chart"></i>
                                                                                                    <span
                                                                                                         class="ajax_compare_text">Add
                                                                                                         to Compare
                                                                                                    </span>
                                                                                          </a>
                                                                                     </div>


                                                                                     <div class="quickview">
                                                                                          <a href="#"
                                                                                               class="quick-view js-quick-view"
                                                                                               data-link-action="quickview">
                                                                                               <i
                                                                                                    class="material-icons search">&#xE417;</i>
                                                                                               Quick view
                                                                                          </a>
                                                                                     </div>

                                                                                </div>
                                                                           </div>
                                                                      </div>

                                                                      <div class="product-description">


                                                                           <div class="brand-title" itemprop="name">
                                                                                <a
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/brand/7-stylehub">StyleHub</a>
                                                                           </div>



                                                                           <h3 class="h3 product-title"><a
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/usb-type-cable/2-rumbloo-silicone-controller-grip-cover-for-oculus-quest-2.html"
                                                                                     content="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/usb-type-cable/2-rumbloo-silicone-controller-grip-cover-for-oculus-quest-2.html">Rumbloo
                                                                                     Silicone Controller Grip Cover for
                                                                                     Oculus Quest 2</a></h3>



                                                                           <div class="comments_note">
                                                                                <div class="star_content clearfix">
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                </div>
                                                                                <span class="total-rating">1
                                                                                     Review(s)</span>
                                                                           </div>



                                                                           <div class="product-price-and-shipping">


                                                                                <span class="regular-price"
                                                                                     aria-label="Regular price">$120.00</span>
                                                                                <span
                                                                                     class="discount-percentage discount-product">-15%
                                                                                     <span>Off</span></span>



                                                                                <span class="price" aria-label="Price">
                                                                                     $102.00
                                                                                </span>




                                                                           </div>



                                                                           <div class="proaction-button">
                                                                                <form action="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/cart"
                                                                                     method="post"
                                                                                     class="add-to-cart-or-refresh">
                                                                                     <input type="hidden" name="token"
                                                                                          value="be2e4f21e069f2f9e1a4d6f6ab1dfbfa">
                                                                                     <input type="hidden"
                                                                                          name="id_product" value="2"
                                                                                          class="product_page_product_id">
                                                                                     <input type="hidden"
                                                                                          name="id_customization"
                                                                                          value="0"
                                                                                          id="product_customization_id"
                                                                                          class="js-product-customization-id">
                                                                                     <button
                                                                                          class="btn btn-primary add-to-cart"
                                                                                          data-button-action="add-to-cart"
                                                                                          type="submit">
                                                                                          Add to cart
                                                                                     </button>
                                                                                </form>
                                                                           </div>



                                                                      </div>
                                                                 </div>
                                                            </article>
                                                            <article class="product_item  slider_item">

                                                                 <div class="product-miniature js-product-miniature"
                                                                      data-id-product="1"
                                                                      data-id-product-attribute="163">
                                                                      <div class="thumbnail-container">

                                                                           <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/chargers-cables/1-163-hummingbird-printed-t-shirt.html#/32-ram-4gb/38-internal_storage-128gb"
                                                                                class="thumbnail product-thumbnail">
                                                                                <img class="lazyload"
                                                                                     src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/244-home_default/hummingbird-printed-t-shirt.jpg"
                                                                                     alt="New Featured MacBook Pro With Apple M1 Pro Chip"
                                                                                     data-full-size-image-url="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/244-large_default/hummingbird-printed-t-shirt.jpg"
                                                                                     width="250" height="250">
                                                                                <img class="lazyload fliper_image img-responsive"
                                                                                     src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/245-home_default/hummingbird-printed-t-shirt.jpg"
                                                                                     data-full-size-image-url="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/245-large_default/hummingbird-printed-t-shirt.jpg"
                                                                                     alt="" />

                                                                           </a>


                                                                           <div
                                                                                class="highlighted-informations no-variants">


                                                                           </div>


                                                                           <ul class="product-flags js-product-flags">
                                                                                <li class="product-flag on-sale">On
                                                                                     sale!</li>
                                                                                <li class="product-flag discount"><i
                                                                                          class="material-icons left">&#xe3e7;</i>-10%
                                                                                </li>
                                                                                <li class="product-flag new">New</li>
                                                                           </ul>


                                                                           <div class="outer-functional">
                                                                                <div class="functional-buttons">
                                                                                     <div class="wishlist">
                                                                                          <a class="st-wishlist-button btn-product btn"
                                                                                               href="#"
                                                                                               data-id-wishlist=""
                                                                                               data-id-product="1"
                                                                                               data-id-product-attribute="163"
                                                                                               title="Add to Wishlist">
                                                                                               <span
                                                                                                    class="st-wishlist-bt-content">
                                                                                                    <i class="fa fa-heart"
                                                                                                         aria-hidden="true"></i>
                                                                                                    <span
                                                                                                         class="ajax_wishlist_text">Add
                                                                                                         to
                                                                                                         Wishlist</span>
                                                                                               </span>
                                                                                          </a>

                                                                                     </div>
                                                                                     <div class="compare">
                                                                                          <a class="st-compare-button btn-product btn"
                                                                                               href="#"
                                                                                               data-id-product="1"
                                                                                               title="Add to Compare">
                                                                                               <span
                                                                                                    class="st-compare-bt-content">
                                                                                                    <i
                                                                                                         class="fa fa-area-chart"></i>
                                                                                                    <span
                                                                                                         class="ajax_compare_text">Add
                                                                                                         to Compare
                                                                                                    </span>
                                                                                          </a>
                                                                                     </div>


                                                                                     <div class="quickview">
                                                                                          <a href="#"
                                                                                               class="quick-view js-quick-view"
                                                                                               data-link-action="quickview">
                                                                                               <i
                                                                                                    class="material-icons search">&#xE417;</i>
                                                                                               Quick view
                                                                                          </a>
                                                                                     </div>

                                                                                </div>
                                                                           </div>
                                                                      </div>

                                                                      <div class="product-description">


                                                                           <div class="brand-title" itemprop="name">
                                                                                <a
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/brand/8-trendmart">TrendMart</a>
                                                                           </div>



                                                                           <h3 class="h3 product-title"><a
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/chargers-cables/1-163-hummingbird-printed-t-shirt.html#/32-ram-4gb/38-internal_storage-128gb"
                                                                                     content="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/chargers-cables/1-163-hummingbird-printed-t-shirt.html#/32-ram-4gb/38-internal_storage-128gb">New
                                                                                     Featured MacBook Pro With Apple M1
                                                                                     Pro Chip</a></h3>



                                                                           <div class="comments_note">
                                                                                <div class="star_content clearfix">
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star star_on"></div>
                                                                                     <div class="star"></div>
                                                                                     <div class="star"></div>
                                                                                </div>
                                                                                <span class="total-rating">1
                                                                                     Review(s)</span>
                                                                           </div>



                                                                           <div class="product-price-and-shipping">


                                                                                <span class="regular-price"
                                                                                     aria-label="Regular price">$900.00</span>
                                                                                <span
                                                                                     class="discount-percentage discount-product">-10%
                                                                                     <span>Off</span></span>



                                                                                <span class="price" aria-label="Price">
                                                                                     $810.00
                                                                                </span>




                                                                           </div>



                                                                           <div class="proaction-button">
                                                                                <form action="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/cart"
                                                                                     method="post"
                                                                                     class="add-to-cart-or-refresh">
                                                                                     <input type="hidden" name="token"
                                                                                          value="be2e4f21e069f2f9e1a4d6f6ab1dfbfa">
                                                                                     <input type="hidden"
                                                                                          name="id_product" value="1"
                                                                                          class="product_page_product_id">
                                                                                     <input type="hidden"
                                                                                          name="id_customization"
                                                                                          value="0"
                                                                                          id="product_customization_id"
                                                                                          class="js-product-customization-id">
                                                                                     <button
                                                                                          class="btn btn-primary add-to-cart"
                                                                                          data-button-action="add-to-cart"
                                                                                          type="submit">
                                                                                          Add to cart
                                                                                     </button>
                                                                                </form>
                                                                           </div>



                                                                      </div>
                                                                 </div>
                                                            </article>
                                                       </div>

                                                       <div class="customNavigation">
                                                            <a class="btn prev bestseller_prev">&nbsp;</a>
                                                            <a class="btn next bestseller_next">&nbsp;</a>
                                                       </div>


                                                       <div class="view_more">
                                                            <a class="all-product-link btn btn-primary"
                                                                 href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/best-sellers">
                                                                 All best sellers
                                                            </a>
                                                       </div>

                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </section>
                              <section id="czbannercmsblock" class="block czbanners">
                                   <div class="czbanner_container container">
                                        <div class="cmsbanners">
                                             <div class="one-half cmsbanner-part1">
                                                  <div class="cmsbanner-inner">
                                                       <div class="cmsbanner cmsbanner1"><a href="#"
                                                                 class="banner-anchor"><img
                                                                      src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/cms/cms-banner-1.jpg"
                                                                      alt="cms-banner1" class="banner-image1"
                                                                      width="785" height="280" /></a>
                                                            <div class="cmsbanner-text">
                                                                 <div class="main-title">Zebronics Zeb Max
                                                                      <span>Wireless Controller</span>
                                                                 </div>
                                                                 <div class="offer-title">From <span>$88.00</span></div>
                                                                 <div class="view_more"><a class="btn btn-primary"
                                                                           href="#">Shop Now</a></div>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="one-half cmsbanner-part2">
                                                  <div class="cmsbanner-inner">
                                                       <div class="cmsbanner cmsbanner2"><a href="#"
                                                                 class="banner-anchor"><img
                                                                      src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/cms/cms-banner-2.jpg"
                                                                      alt="cms-banner2" class="banner-image2"
                                                                      width="785" height="280" /></a>
                                                            <div class="cmsbanner-text">
                                                                 <div class="main-title">Apple iPad Pro M4 <span>With
                                                                           Best Glass</span></div>
                                                                 <div class="offer-title">From <span>$549.00</span>
                                                                 </div>
                                                                 <div class="view_more"><a class="btn btn-primary"
                                                                           href="#">Shop Now</a></div>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </section>
                              <section id="cztestimonialcmsblock" class="block testimonial-block">
                                   <div class="testimonial_container container">

                                        <h2 class="title products-section-title">What Our Clients Say</h2>

                                        <div class="testimonial-wrapper products-wrapper">
                                             <div class="testimonial-area">
                                                  <div class="customNavigation">
                                                       <a class="btn prev cztestimonial_prev"></a>
                                                       <a class="btn next cztestimonial_next"></a>
                                                  </div>

                                                  <div id="testimonial-carousel" class="cz-carousel product_list">

                                                       <article class="item">
                                                            <div class="testimonial-description">
                                                                 <div class="feedback-title">“Reliable product,
                                                                      consistently delivers.”</div>
                                                                 <div class="feedback">lorem Ipsum many variations of
                                                                      passages of there are available but the have
                                                                      alteration in some form by injected humour or
                                                                      randomised words blievable lorem Ipsum is the
                                                                      printing and typesetting.</div>
                                                            </div>


                                                            <div class="testimonial-inner">
                                                                 <div class="author-image">
                                                                      <img class="lazyload"
                                                                           data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/modules/cz_testimonial/views/img/testimonial-1.jpg"
                                                                           alt="Patrick Goodman" title="Patrick Goodman"
                                                                           width="60" height="60" />
                                                                 </div>
                                                                 <div class="author-name">
                                                                      <a href="#" title="Patrick Goodman">
                                                                           Patrick Goodman
                                                                      </a>
                                                                 </div>
                                                            </div>
                                                       </article>
                                                       <article class="item">
                                                            <div class="testimonial-description">
                                                                 <div class="feedback-title">“Excellent product, A+
                                                                      customer service.”</div>
                                                                 <div class="feedback">There are many variations of
                                                                      passages of lorem Ipsum available but the have
                                                                      alteration in some form by injected humour
                                                                      randomised words which dont look even believable
                                                                      lorem Ipsum is simply text.</div>
                                                            </div>


                                                            <div class="testimonial-inner">
                                                                 <div class="author-image">
                                                                      <img class="lazyload"
                                                                           data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/modules/cz_testimonial/views/img/testimonial-2.jpg"
                                                                           alt="Luies Charls" title="Luies Charls"
                                                                           width="60" height="60" />
                                                                 </div>
                                                                 <div class="author-name">
                                                                      <a href="#" title="Luies Charls">
                                                                           Luies Charls
                                                                      </a>
                                                                 </div>
                                                            </div>
                                                       </article>
                                                       <article class="item">
                                                            <div class="testimonial-description">
                                                                 <div class="feedback-title">“Impressive quality,
                                                                      durable and reliable.”</div>
                                                                 <div class="feedback">Generation many variations of
                                                                      passages of even blievable lorem Ipsum is simply
                                                                      dummy text of the printing and typesetting
                                                                      industry lorem Ipsum available but the have
                                                                      alteration in some form.</div>
                                                            </div>


                                                            <div class="testimonial-inner">
                                                                 <div class="author-image">
                                                                      <img class="lazyload"
                                                                           data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/modules/cz_testimonial/views/img/testimonial-3.jpg"
                                                                           alt="Jecob Goeckno" title="Jecob Goeckno"
                                                                           width="60" height="60" />
                                                                 </div>
                                                                 <div class="author-name">
                                                                      <a href="#" title="Jecob Goeckno">
                                                                           Jecob Goeckno
                                                                      </a>
                                                                 </div>
                                                            </div>
                                                       </article>
                                                       <article class="item">
                                                            <div class="testimonial-description">
                                                                 <div class="feedback-title">“Excellent product, worth
                                                                      every penny.”</div>
                                                                 <div class="feedback">lorem Ipsum is simply dummy text
                                                                      of the printing and typesetting industry There are
                                                                      many variations of passages of lorem Ipsum
                                                                      available but the have alteration in some form by
                                                                      injected humour.</div>
                                                            </div>


                                                            <div class="testimonial-inner">
                                                                 <div class="author-image">
                                                                      <img class="lazyload"
                                                                           data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/modules/cz_testimonial/views/img/testimonial-4.jpg"
                                                                           alt="Danial Smith" title="Danial Smith"
                                                                           width="60" height="60" />
                                                                 </div>
                                                                 <div class="author-name">
                                                                      <a href="#" title="Danial Smith">
                                                                           Danial Smith
                                                                      </a>
                                                                 </div>
                                                            </div>
                                                       </article>

                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </section>

                              <section class="lastest_block block homeblog-latest">
                                   <div class="container">
                                        <div class="blog-wrapper">
                                             <h2 class="h1 products-section-title text-uppercase">
                                                  Our Latest Blog
                                             </h2>
                                             <div class="homeblog-wrapper">
                                                  <div class="homeblog-inner">
                                                       <!-- Define Number of product for SLIDER -->
                                                       <div id="blog-carousel" class="cz-carousel product_list">

                                                            <article class="blog-post item">
                                                                 <div class="blog-item">

                                                                      <div class="blog-image text-xs-center">
                                                                           <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/blog/how-to-build-a-detailed-business-plan-that-stands-out-b12.html"
                                                                                title="How to Build a Detailed Business Plan That Stands Out"
                                                                                class="link">
                                                                                <img src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/wide-lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/psblog/b/12/1400_920/b-blog-10.jpg"
                                                                                     alt="How to Build a Detailed Business Plan That Stands Out"
                                                                                     class="img-fluid lazyload" />
                                                                                <span class="post-image-hover"></span>
                                                                           </a>
                                                                           <span class="blogicons">
                                                                                <a title="Click to view Full Image"
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/psblog/b/12/1400_920/b-blog-10.jpg"
                                                                                     data-lightbox="example-set"
                                                                                     class="icon zoom">&nbsp;</a>
                                                                                <a title="Click to view Read More"
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/blog/how-to-build-a-detailed-business-plan-that-stands-out-b12.html"
                                                                                     class="icon readmore_link">&nbsp;</a>
                                                                           </span>
                                                                      </div>


                                                                      <div class="blog-content-wrap">
                                                                           <div class="blog-meta">
                                                                                <span class="blog-created">
                                                                                     <i class="fa fa-calendar"></i>
                                                                                     <time class="date" datetime="2024">
                                                                                          <!-- day of week -->
                                                                                          15
                                                                                          <!-- day of month -->
                                                                                          October,
                                                                                          <!-- month-->
                                                                                          2024
                                                                                          <!-- year -->
                                                                                     </time>
                                                                                </span>

                                                                                <span class="blog-cat">
                                                                                     <i class="fa fa-list"></i> <a
                                                                                          href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/blog/sub-category-1-c4.html"
                                                                                          title="Social Media">Social
                                                                                          Media</a>
                                                                                </span>

                                                                           </div>

                                                                           <h4 class="title">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/blog/how-to-build-a-detailed-business-plan-that-stands-out-b12.html"
                                                                                     title="How to Build a Detailed Business Plan That Stands Out">How
                                                                                     to Build a Detailed Business Plan
                                                                                     That Stands Out</a>
                                                                           </h4>

                                                                           <div class="blog-shortinfo">
                                                                                Expedita consequatur aut sed eaque minus
                                                                                Mollitia consequatur ipsum ut eaque
                                                                                illum sint. Sapiente ea explicabo. Lure
                                                                                esse quia Ducimus voluptatem...
                                                                           </div>

                                                                           <div class="readmore">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/blog/how-to-build-a-detailed-business-plan-that-stands-out-b12.html"
                                                                                     title="How to Build a Detailed Business Plan That Stands Out">Read
                                                                                     more</a>
                                                                           </div>
                                                                      </div>
                                                                 </div>
                                                            </article>
                                                            <article class="blog-post item">
                                                                 <div class="blog-item">

                                                                      <div class="blog-image text-xs-center">
                                                                           <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/blog/customer-experience-trends-that-ll-define-the-next-year-b11.html"
                                                                                title="Customer Experience Trends That will Define the Next Year"
                                                                                class="link">
                                                                                <img src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/wide-lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/psblog/b/11/1400_920/b-blog-9.jpg"
                                                                                     alt="Customer Experience Trends That will Define the Next Year"
                                                                                     class="img-fluid lazyload" />
                                                                                <span class="post-image-hover"></span>
                                                                           </a>
                                                                           <span class="blogicons">
                                                                                <a title="Click to view Full Image"
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/psblog/b/11/1400_920/b-blog-9.jpg"
                                                                                     data-lightbox="example-set"
                                                                                     class="icon zoom">&nbsp;</a>
                                                                                <a title="Click to view Read More"
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/blog/customer-experience-trends-that-ll-define-the-next-year-b11.html"
                                                                                     class="icon readmore_link">&nbsp;</a>
                                                                           </span>
                                                                      </div>


                                                                      <div class="blog-content-wrap">
                                                                           <div class="blog-meta">
                                                                                <span class="blog-created">
                                                                                     <i class="fa fa-calendar"></i>
                                                                                     <time class="date" datetime="2024">
                                                                                          <!-- day of week -->
                                                                                          12
                                                                                          <!-- day of month -->
                                                                                          October,
                                                                                          <!-- month-->
                                                                                          2024
                                                                                          <!-- year -->
                                                                                     </time>
                                                                                </span>

                                                                                <span class="blog-cat">
                                                                                     <i class="fa fa-list"></i> <a
                                                                                          href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/blog/category-1-c3.html"
                                                                                          title="Business">Business</a>
                                                                                </span>

                                                                           </div>

                                                                           <h4 class="title">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/blog/customer-experience-trends-that-ll-define-the-next-year-b11.html"
                                                                                     title="Customer Experience Trends That will Define the Next Year">Customer
                                                                                     Experience Trends That will Define
                                                                                     the Next Year</a>
                                                                           </h4>

                                                                           <div class="blog-shortinfo">
                                                                                Debitis saepe fugiat nisi consequatur.
                                                                                Nihil sed eos dignissimos consequatur.
                                                                                Id veritatis Aliquid sed facilis a
                                                                                totam. aut ipsa sint qui. Ratione...
                                                                           </div>

                                                                           <div class="readmore">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/blog/customer-experience-trends-that-ll-define-the-next-year-b11.html"
                                                                                     title="Customer Experience Trends That will Define the Next Year">Read
                                                                                     more</a>
                                                                           </div>
                                                                      </div>
                                                                 </div>
                                                            </article>
                                                            <article class="blog-post item">
                                                                 <div class="blog-item">

                                                                      <div class="blog-image text-xs-center">
                                                                           <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/blog/top-9-content-marketing-trends-and-ideas-to-increase-traffic-b10.html"
                                                                                title="Top 9 Content Marketing Trends and Ideas to Increase Traffic"
                                                                                class="link">
                                                                                <img src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/wide-lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/psblog/b/10/1400_920/b-blog-8.jpg"
                                                                                     alt="Top 9 Content Marketing Trends and Ideas to Increase Traffic"
                                                                                     class="img-fluid lazyload" />
                                                                                <span class="post-image-hover"></span>
                                                                           </a>
                                                                           <span class="blogicons">
                                                                                <a title="Click to view Full Image"
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/psblog/b/10/1400_920/b-blog-8.jpg"
                                                                                     data-lightbox="example-set"
                                                                                     class="icon zoom">&nbsp;</a>
                                                                                <a title="Click to view Read More"
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/blog/top-9-content-marketing-trends-and-ideas-to-increase-traffic-b10.html"
                                                                                     class="icon readmore_link">&nbsp;</a>
                                                                           </span>
                                                                      </div>


                                                                      <div class="blog-content-wrap">
                                                                           <div class="blog-meta">
                                                                                <span class="blog-created">
                                                                                     <i class="fa fa-calendar"></i>
                                                                                     <time class="date" datetime="2024">
                                                                                          <!-- day of week -->
                                                                                          8
                                                                                          <!-- day of month -->
                                                                                          October,
                                                                                          <!-- month-->
                                                                                          2024
                                                                                          <!-- year -->
                                                                                     </time>
                                                                                </span>

                                                                                <span class="blog-cat">
                                                                                     <i class="fa fa-list"></i> <a
                                                                                          href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/blog/category-1-c3.html"
                                                                                          title="Business">Business</a>
                                                                                </span>

                                                                           </div>

                                                                           <h4 class="title">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/blog/top-9-content-marketing-trends-and-ideas-to-increase-traffic-b10.html"
                                                                                     title="Top 9 Content Marketing Trends and Ideas to Increase Traffic">Top
                                                                                     9 Content Marketing Trends and
                                                                                     Ideas to Increase Traffic</a>
                                                                           </h4>

                                                                           <div class="blog-shortinfo">
                                                                                What You Need to Know about the Facebook
                                                                                Product Design Interview and What to do
                                                                                about it. Pug twee fam pour-over seitan
                                                                                single-origin coffee...
                                                                           </div>

                                                                           <div class="readmore">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/blog/top-9-content-marketing-trends-and-ideas-to-increase-traffic-b10.html"
                                                                                     title="Top 9 Content Marketing Trends and Ideas to Increase Traffic">Read
                                                                                     more</a>
                                                                           </div>
                                                                      </div>
                                                                 </div>
                                                            </article>
                                                            <article class="blog-post item">
                                                                 <div class="blog-item">

                                                                      <div class="blog-image text-xs-center">
                                                                           <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/blog/how-to-write-a-blog-post-outline-a-simple-formula-to-follow-b9.html"
                                                                                title="How to Write a Blog Post Outline: A Simple Formula to Follow"
                                                                                class="link">
                                                                                <img src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/wide-lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/psblog/b/9/1400_920/b-blog-7.jpg"
                                                                                     alt="How to Write a Blog Post Outline: A Simple Formula to Follow"
                                                                                     class="img-fluid lazyload" />
                                                                                <span class="post-image-hover"></span>
                                                                           </a>
                                                                           <span class="blogicons">
                                                                                <a title="Click to view Full Image"
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/psblog/b/9/1400_920/b-blog-7.jpg"
                                                                                     data-lightbox="example-set"
                                                                                     class="icon zoom">&nbsp;</a>
                                                                                <a title="Click to view Read More"
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/blog/how-to-write-a-blog-post-outline-a-simple-formula-to-follow-b9.html"
                                                                                     class="icon readmore_link">&nbsp;</a>
                                                                           </span>
                                                                      </div>


                                                                      <div class="blog-content-wrap">
                                                                           <div class="blog-meta">
                                                                                <span class="blog-created">
                                                                                     <i class="fa fa-calendar"></i>
                                                                                     <time class="date" datetime="2024">
                                                                                          <!-- day of week -->
                                                                                          5
                                                                                          <!-- day of month -->
                                                                                          October,
                                                                                          <!-- month-->
                                                                                          2024
                                                                                          <!-- year -->
                                                                                     </time>
                                                                                </span>

                                                                                <span class="blog-cat">
                                                                                     <i class="fa fa-list"></i> <a
                                                                                          href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/blog/sub-category-1-c4.html"
                                                                                          title="Social Media">Social
                                                                                          Media</a>
                                                                                </span>

                                                                           </div>

                                                                           <h4 class="title">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/blog/how-to-write-a-blog-post-outline-a-simple-formula-to-follow-b9.html"
                                                                                     title="How to Write a Blog Post Outline: A Simple Formula to Follow">How
                                                                                     to Write a Blog Post Outline: A
                                                                                     Simple Formula to Follow</a>
                                                                           </h4>

                                                                           <div class="blog-shortinfo">
                                                                                Get To Know The Audience From Different
                                                                                Points Of View Copy should be tailored
                                                                                for each stage of the customer journey.
                                                                                For example, a new-to-market...
                                                                           </div>

                                                                           <div class="readmore">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/blog/how-to-write-a-blog-post-outline-a-simple-formula-to-follow-b9.html"
                                                                                     title="How to Write a Blog Post Outline: A Simple Formula to Follow">Read
                                                                                     more</a>
                                                                           </div>
                                                                      </div>
                                                                 </div>
                                                            </article>
                                                            <article class="blog-post item">
                                                                 <div class="blog-item">

                                                                      <div class="blog-image text-xs-center">
                                                                           <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/blog/the-9-habits-of-highly-successful-content-creators-this-year-b8.html"
                                                                                title="The 9 Habits of Highly Successful Content Creators this Year"
                                                                                class="link">
                                                                                <img src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/wide-lazy-loader.svg"
                                                                                     data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/psblog/b/8/1400_920/b-blog-6.jpg"
                                                                                     alt="The 9 Habits of Highly Successful Content Creators this Year"
                                                                                     class="img-fluid lazyload" />
                                                                                <span class="post-image-hover"></span>
                                                                           </a>
                                                                           <span class="blogicons">
                                                                                <a title="Click to view Full Image"
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/psblog/b/8/1400_920/b-blog-6.jpg"
                                                                                     data-lightbox="example-set"
                                                                                     class="icon zoom">&nbsp;</a>
                                                                                <a title="Click to view Read More"
                                                                                     href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/blog/the-9-habits-of-highly-successful-content-creators-this-year-b8.html"
                                                                                     class="icon readmore_link">&nbsp;</a>
                                                                           </span>
                                                                      </div>


                                                                      <div class="blog-content-wrap">
                                                                           <div class="blog-meta">
                                                                                <span class="blog-created">
                                                                                     <i class="fa fa-calendar"></i>
                                                                                     <time class="date" datetime="2024">
                                                                                          <!-- day of week -->
                                                                                          3
                                                                                          <!-- day of month -->
                                                                                          October,
                                                                                          <!-- month-->
                                                                                          2024
                                                                                          <!-- year -->
                                                                                     </time>
                                                                                </span>

                                                                                <span class="blog-cat">
                                                                                     <i class="fa fa-list"></i> <a
                                                                                          href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/blog/sub-category-2-c5.html"
                                                                                          title="Marketing">Marketing</a>
                                                                                </span>

                                                                           </div>

                                                                           <h4 class="title">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/blog/the-9-habits-of-highly-successful-content-creators-this-year-b8.html"
                                                                                     title="The 9 Habits of Highly Successful Content Creators this Year">The
                                                                                     9 Habits of Highly Successful
                                                                                     Content Creators this Year</a>
                                                                           </h4>

                                                                           <div class="blog-shortinfo">
                                                                                Think About How The Offering Will
                                                                                Support The Customer By bringing a new
                                                                                perspective to the table, you can help
                                                                                an invigorate your marketing...
                                                                           </div>

                                                                           <div class="readmore">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/blog/the-9-habits-of-highly-successful-content-creators-this-year-b8.html"
                                                                                     title="The 9 Habits of Highly Successful Content Creators this Year">Read
                                                                                     more</a>
                                                                           </div>
                                                                      </div>
                                                                 </div>
                                                            </article>
                                                       </div>

                                                       <div class="customNavigation">
                                                            <a class="btn prev blog_prev">&nbsp;</a>
                                                            <a class="btn next blog_next">&nbsp;</a>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </section>
                              <section class="brands">
                                   <div class="container">
                                        <section class="brands-wraper">

                                             <div class="products">

                                                  <!-- Define Number of product for SLIDER -->

                                                  <div class="customNavigation">
                                                       <a class="btn prev brand_prev">&nbsp;</a>
                                                       <a class="btn next brand_next">&nbsp;</a>
                                                  </div>

                                                  <ul id="brand-carousel" class="cz-carousel product_list">

                                                       <li class="item">
                                                            <div class="brand-image">
                                                                 <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/brand/2-cartify"
                                                                      title="Cartify">
                                                                      <img class="lazyload"
                                                                           src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/wide-lazy-loader.svg"
                                                                           data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/m/2.jpg"
                                                                           alt="Cartify" />
                                                                 </a>
                                                            </div>
                                                       </li>
                                                       <li class="item">
                                                            <div class="brand-image">
                                                                 <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/brand/1-ecomzone"
                                                                      title="EcomZone">
                                                                      <img class="lazyload"
                                                                           src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/wide-lazy-loader.svg"
                                                                           data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/m/1.jpg"
                                                                           alt="EcomZone" />
                                                                 </a>
                                                            </div>
                                                       </li>
                                                       <li class="item">
                                                            <div class="brand-image">
                                                                 <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/brand/3-ecoshop"
                                                                      title="EcoShop">
                                                                      <img class="lazyload"
                                                                           src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/wide-lazy-loader.svg"
                                                                           data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/m/3.jpg"
                                                                           alt="EcoShop" />
                                                                 </a>
                                                            </div>
                                                       </li>
                                                       <li class="item">
                                                            <div class="brand-image">
                                                                 <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/brand/4-megamart"
                                                                      title="MegaMart">
                                                                      <img class="lazyload"
                                                                           src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/wide-lazy-loader.svg"
                                                                           data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/m/4.jpg"
                                                                           alt="MegaMart" />
                                                                 </a>
                                                            </div>
                                                       </li>
                                                       <li class="item">
                                                            <div class="brand-image">
                                                                 <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/brand/5-quickcart"
                                                                      title="QuickCart">
                                                                      <img class="lazyload"
                                                                           src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/wide-lazy-loader.svg"
                                                                           data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/m/5.jpg"
                                                                           alt="QuickCart" />
                                                                 </a>
                                                            </div>
                                                       </li>
                                                       <li class="item">
                                                            <div class="brand-image">
                                                                 <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/brand/6-smartshop"
                                                                      title="SmartShop">
                                                                      <img class="lazyload"
                                                                           src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/wide-lazy-loader.svg"
                                                                           data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/m/6.jpg"
                                                                           alt="SmartShop" />
                                                                 </a>
                                                            </div>
                                                       </li>
                                                       <li class="item">
                                                            <div class="brand-image">
                                                                 <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/brand/7-stylehub"
                                                                      title="StyleHub">
                                                                      <img class="lazyload"
                                                                           src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/wide-lazy-loader.svg"
                                                                           data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/m/7.jpg"
                                                                           alt="StyleHub" />
                                                                 </a>
                                                            </div>
                                                       </li>
                                                       <li class="item">
                                                            <div class="brand-image">
                                                                 <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/brand/8-trendmart"
                                                                      title="TrendMart">
                                                                      <img class="lazyload"
                                                                           src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/wide-lazy-loader.svg"
                                                                           data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/m/8.jpg"
                                                                           alt="TrendMart" />
                                                                 </a>
                                                            </div>
                                                       </li>

                                                  </ul>
                                             </div>
                                   </div>
                              </section>
                         </section>
                    </section>
               </div>
          </div>
</section>
<div id="czinstagramblock" class="cz_instagramblock clearfix">
     <div class="instagramblock">
          <div class="customNavigation">
               <a class="btn prev instagram_prev">&nbsp;</a>
               <a class="btn next instagram_next">&nbsp;</a>
          </div>
          <div class="instagram_wrap">
               <ul id="instagram-carousel" class="cz-carousel instagram_list">
                    <li class="picture item">
                         <a href="">
                              <img class="img-responsive lazyload"
                                   src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                   data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/modules/cz_instagramfeeds/views/img/instapic/1.jpg" />
                         </a>
                    </li>
                    <li class="picture item">
                         <a href="">
                              <img class="img-responsive lazyload"
                                   src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                   data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/modules/cz_instagramfeeds/views/img/instapic/2.jpg" />
                         </a>
                    </li>
                    <li class="picture item">
                         <a href="">
                              <img class="img-responsive lazyload"
                                   src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                   data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/modules/cz_instagramfeeds/views/img/instapic/3.jpg" />
                         </a>
                    </li>
                    <li class="picture item">
                         <a href="">
                              <img class="img-responsive lazyload"
                                   src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                   data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/modules/cz_instagramfeeds/views/img/instapic/4.jpg" />
                         </a>
                    </li>
                    <li class="picture item">
                         <a href="">
                              <img class="img-responsive lazyload"
                                   src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                   data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/modules/cz_instagramfeeds/views/img/instapic/5.jpg" />
                         </a>
                    </li>
                    <li class="picture item">
                         <a href="">
                              <img class="img-responsive lazyload"
                                   src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                   data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/modules/cz_instagramfeeds/views/img/instapic/6.jpg" />
                         </a>
                    </li>
                    <li class="picture item">
                         <a href="">
                              <img class="img-responsive lazyload"
                                   src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                   data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/modules/cz_instagramfeeds/views/img/instapic/7.jpg" />
                         </a>
                    </li>
                    <li class="picture item">
                         <a href="">
                              <img class="img-responsive lazyload"
                                   src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/themes/Electech/assets/img/codezeel/lazy-loader.svg"
                                   data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/modules/cz_instagramfeeds/views/img/instapic/8.jpg" />
                         </a>
                    </li>
               </ul>
          </div>
          <div class="insta_username"><span>#Instagram</span></div>
     </div>
</div>



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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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