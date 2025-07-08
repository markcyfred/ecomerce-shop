<?php include 'includes/header.php';
//errors show
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>
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
                                                  <h2 style="color: #000;" class="h1 products-section-title text-uppercase">Shop By Category
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
                                                                                (SELECT quantity FROM cart 
                                                                                     WHERE cart.product_id = products.id 
                                                                                     AND (cart.session_id = '" . session_id() . "' 
                                                                                          OR cart.user_id = '" . ($_SESSION['auth_user']['id'] ?? '0') . "')
                                                                                     AND (cart.cart_status IS NULL OR cart.cart_status != 'processed')
                                                                                     LIMIT 1
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
                                                                 (SELECT quantity FROM cart 
                                                                 WHERE cart.product_id = products.id 
                                                                 AND (cart.session_id = '" . session_id() . "' OR cart.user_id = '" . ($_SESSION['auth_user']['id'] ?? '0') . "')
                                                                 AND (cart.cart_status IS NULL OR cart.cart_status != 'processed')
                                                                 LIMIT 1
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
                                                                           <?php include "includes/product-card-template.php" ?>
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
                                                                 (SELECT quantity FROM cart 
                                                                 WHERE cart.product_id = products.id 
                                                                 AND (cart.session_id = '" . session_id() . "' OR cart.user_id = '" . ($_SESSION['auth_user']['id'] ?? '0') . "')
                                                                 AND (cart.cart_status IS NULL OR cart.cart_status != 'processed')
                                                                 LIMIT 1
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

                                                                           <?php include "includes/product-card-template.php" ?>
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
                                                                 (SELECT quantity FROM cart 
                                                                 WHERE cart.product_id = products.id 
                                                                 AND (cart.session_id = '" . session_id() . "' OR cart.user_id = '" . ($_SESSION['auth_user']['id'] ?? '0') . "')
                                                                 AND (cart.cart_status IS NULL OR cart.cart_status != 'processed')
                                                                 LIMIT 1
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

                                                                           <?php include "includes/product-card-template.php" ?>
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
                                                                 (SELECT quantity FROM cart 
                                                                 WHERE cart.product_id = products.id 
                                                                 AND (cart.session_id = '" . session_id() . "' OR cart.user_id = '" . ($_SESSION['auth_user']['id'] ?? '0') . "')
                                                                 AND (cart.cart_status IS NULL OR cart.cart_status != 'processed')
                                                                 LIMIT 1
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

                                                                           <?php include "includes/product-card-template.php" ?>
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
                                                       <div class="service-description">We're Here to Help</div>
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
                                             <?php
                                             // Fetch all random active banners where size = 'normal' and banner_type = 'normal'
                                             $banner_query = "SELECT * FROM banners WHERE status = '1' AND size = 'normal' AND banner_type = 'single' ORDER BY RAND()";
                                             $banner_result = mysqli_query($conn, $banner_query);

                                             $banners = [];
                                             if ($banner_result && mysqli_num_rows($banner_result) > 0) {
                                                  while ($row = mysqli_fetch_assoc($banner_result)) {
                                                       $banners[] = $row;
                                                  }
                                             }
                                             ?>


                                             <!-- Section 1 -->
                                             <div class="product-banner">
                                                  <div class="czcustomcmsblock2">
                                                       <?php if (isset($banners[0])): ?>
                                                            <?php $banner = $banners[0]; ?>
                                                            <div class="one-half custombanner-part2">
                                                                 <div class="custombanner-inner">
                                                                      <div class="custombanner custombanner2">
                                                                           <a href="shop.php" class="banner-anchor">
                                                                                <img src="uploads/banners/<?= htmlspecialchars($banner['image']) ?>"
                                                                                     alt="<?= htmlspecialchars($banner['title']) ?>"
                                                                                     width="430" height="340" />
                                                                           </a>
                                                                           <div class="custombanner-content">
                                                                               
                                                                                <div class="shopnow">
                                                                                     <a class="btn btn-primary" href="shop.php">Shop Now</a>
                                                                                </div>
                                                                           </div>
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                       <?php else: ?>
                                                            <p>No active banners available.</p>
                                                       <?php endif; ?>
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
                                                                           (SELECT quantity FROM cart 
                                                                           WHERE cart.product_id = products.id 
                                                                           AND (cart.session_id = '" . session_id() . "' OR cart.user_id = '" . ($_SESSION['auth_user']['id'] ?? '0') . "')
                                                                           AND (cart.cart_status IS NULL OR cart.cart_status != 'processed')
                                                                           LIMIT 1
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
                                                                      <?php include "includes/product-card-template.php" ?>
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
                                                  <div id="special-carousel" class="cz-carousel product_list owl-carousel owl-theme">

                                                       <?php
                                                       $user_id = $_SESSION['auth_user']['id'] ?? 0;
                                                       $session_id = session_id();

                                                       $query = "SELECT products.*, 
                                                               pi.image_path AS primary_image,
                                                               (SELECT quantity FROM cart 
                                                               WHERE cart.product_id = products.id 
                                                               AND (cart.session_id = '$session_id' OR cart.user_id = '$user_id') 
                                                               AND (cart.cart_status IS NULL OR cart.cart_status != 'processed')
                                                               LIMIT 1
                                                               ) AS in_cart 
                                                               FROM products 
                                                               LEFT JOIN product_images pi ON pi.product_id = products.id AND pi.is_primary = 1
                                                               WHERE deal_of_day_status = 'open' 
                                                               AND NOW() BETWEEN deal_start AND deal_end 
                                                               AND status = 1
                                                               ORDER BY deal_end ASC";

                                                       $deal_result = mysqli_query($conn, $query);

                                                       if (mysqli_num_rows($deal_result) > 0):
                                                            while ($deal = mysqli_fetch_assoc($deal_result)):
                                                                 // Calculate discount price if applicable
                                                                 $discount = floatval($deal['discount']);
                                                                 $price = floatval($deal['selling_price']);
                                                                 $discounted_price = $discount > 0 ? $price * (1 - $discount / 100) : $price;

                                                                 // Stock percentage
                                                                 $max_stock = 500;
                                                                 $stock_qty = intval($deal['quantity']);
                                                                 $stock_percentage = min(100, max(0, ($stock_qty / $max_stock) * 100));

                                                                 // Convert deal_end to JS timestamp (ms)
                                                                 $deal_end_timestamp = strtotime($deal['deal_end']) * 1000;
                                                       ?>
                                                                 <article class="product_item slider_item" data-deal-end="<?= $deal_end_timestamp; ?>">
                                                                      <div class="product-miniature js-product-miniature" data-id-product="<?= $deal['id']; ?>" data-id-product-attribute="0">

                                                                           <div class="thumbnail-container col-xs-12 col-md-6">
                                                                                <div class="special-product-images">
                                                                                     <ul>
                                                                                          <li class="item special-image">
                                                                                               <a href="shop-product.php?id=<?= $deal['id']; ?>" class="thumbnail product-thumbnail">
                                                                                                    <?php
                                                                                                    // Use primary_image if available, else fallback to products.image, else default
                                                                                                    if (!empty($deal['primary_image'])) {
                                                                                                         $image_path = htmlspecialchars($deal['primary_image']);
                                                                                                    } elseif (!empty($deal['image'])) {
                                                                                                         $image_path = 'uploads/shop/' . htmlspecialchars($deal['image']);
                                                                                                    } else {
                                                                                                         $image_path = 'uploads/shop/default.png';
                                                                                                    }
                                                                                                    ?>
                                                                                                    <img style="height: 250px!important;width: 250px!important;"
                                                                                                         src="<?= $image_path ?>"
                                                                                                         data-src="<?= $image_path ?>"
                                                                                                         alt="<?= htmlspecialchars($deal['product_name']) ?>"
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
                                                                                          <?= htmlspecialchars($deal['product_name']) ?>
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
                                                                                          <span class="regular-price" aria-label="Regular price">Kes<?= number_format($price, 2); ?></span>
                                                                                          <span class="discount-percentage discount-product">-<?= round($discount); ?>%</span>
                                                                                          <span class="price" aria-label="Price">Kes<?= number_format($discounted_price, 2); ?></span>
                                                                                     <?php else: ?>
                                                                                          <span class="price" aria-label="Price">Kes<?= number_format($price, 2); ?></span>
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
                                                                                     <div
                                                                                          class="countdown-timer"
                                                                                          id="countdown-<?= $deal['id']; ?>"
                                                                                          data-deal-end="<?= $deal_end_timestamp; ?>">
                                                                                          00d 00h 00m 00s
                                                                                     </div>
                                                                                </div>


                                                                                <div class="proaction-button">
                                                                                     <form id="cartForm_<?= $deal['id'] ?>" method="POST" action="">
                                                                                          <input type="hidden" name="product_id" value="<?= $deal['id'] ?>">
                                                                                          <input type="hidden" name="add_to_cart_btn" value="true">
                                                                                          <input type="hidden" name="product_name" value="<?= htmlspecialchars($deal['product_name']) ?>">
                                                                                          <input type="hidden" name="selling_price" value="<?= $price ?>">
                                                                                          <input type="hidden" name="image" value="<?= htmlspecialchars($deal['image']) ?>">
                                                                                          <input type="hidden" name="quantity" value="1">

                                                                                          <?php if (empty($deal['in_cart'])): ?>
                                                                                               <a class="action-btn hover-up btn-primary add-to-cart" href="#" onclick="addToCart('cartForm_<?= $deal['id'] ?>'); return false;">
                                                                                                    <i class="add-to-cart"></i> Add to Cart
                                                                                               </a>
                                                                                          <?php else: ?>
                                                                                               <span class="action-btn hover-up btn-primary add-to-cart disabled">
                                                                                                    In Cart
                                                                                               </span>
                                                                                          <?php endif; ?>
                                                                                     </form>
                                                                                </div>
                                                                           </div>

                                                                      </div>
                                                                 </article>
                                                            <?php endwhile; ?>
                                                       <?php else: ?>
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
                                   document.addEventListener('DOMContentLoaded', function() {
                                        // For every element with class "countdown-timer"…
                                        document.querySelectorAll('.countdown-timer').forEach(function(el) {
                                             // 1) Read the end‐time once, from its data attribute
                                             var endTime = parseInt(el.getAttribute('data-deal-end'), 10);
                                             if (isNaN(endTime)) {
                                                  // If somehow data-deal-end is missing/invalid, show "Deal ended"
                                                  el.textContent = 'Deal ended';
                                                  return;
                                             }

                                             // 2) Create a function that recalculates days/hours/mins/secs
                                             function updateOnce() {
                                                  var now = Date.now();
                                                  var diff = endTime - now;

                                                  if (diff <= 0) {
                                                       // Time's up
                                                       el.textContent = 'Deal ended';
                                                       clearInterval(intervalId);
                                                       return;
                                                  }

                                                  // Compute each unit
                                                  var days = Math.floor(diff / (1000 * 60 * 60 * 24));
                                                  var hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                  var minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                                                  var seconds = Math.floor((diff % (1000 * 60)) / 1000);

                                                  // Pad single digits with a leading zero
                                                  function pad(n) {
                                                       return (n < 10 ? '0' : '') + n;
                                                  }

                                                  // Write back into the element
                                                  el.textContent =
                                                       pad(days) + 'd ' +
                                                       pad(hours) + 'h ' +
                                                       pad(minutes) + 'm ' +
                                                       pad(seconds) + 's';
                                             }

                                             // 3) Run once immediately, then every second
                                             updateOnce();
                                             var intervalId = setInterval(updateOnce, 1000);
                                        });
                                   });
                              </script>



                              <section class="featured-products products-section clearfix">
                                   <div class="container">
                                        <h2 style="color:black;" class="h1 products-section-title text-uppercase">
                                             Exclusive Products
                                        </h2>
                                        <div class="products-banner-wrapper">

                                             <!-- Section 2 -->
                                             <div class="product-banner">
                                                  <div class="czcustomcmsblock2">
                                                       <?php if (isset($banners[1])): ?>
                                                            <?php $banner = $banners[1]; ?>
                                                            <div class="one-half custombanner-part2">
                                                                 <div class="custombanner-inner">
                                                                      <div class="custombanner custombanner2">
                                                                           <a href="shop.php" class="banner-anchor">
                                                                                <img src="uploads/banners/<?= htmlspecialchars($banner['image']) ?>"
                                                                                     alt="<?= htmlspecialchars($banner['title']) ?>"
                                                                                     width="430" height="340" />
                                                                           </a>
                                                                           <div class="custombanner-content">
                                                                               
                                                                                <div class="shopnow">
                                                                                     <a class="btn btn-primary" href="shop.php">Shop Now</a>
                                                                                </div>
                                                                           </div>
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                       <?php else: ?>
                                                            <p>No second banner available.</p>
                                                       <?php endif; ?>
                                                  </div>
                                             </div>



                                             <div class="products-wrapper">
                                                  <div class="products">
                                                       <!-- Define Number of product for SLIDER -->
                                                       <div id="feature-carousel" class="cz-carousel product_list">
                                                            <?php
                                                            $product_query = "
                                                            SELECT products.*, 
                                                                 categories.name AS category_name, 
                                                                 categories.id AS category_id, 
                                                                 (SELECT quantity FROM cart 
                                                                 WHERE cart.product_id = products.id 
                                                                 AND (cart.session_id = '" . session_id() . "' OR cart.user_id = '" . ($_SESSION['auth_user']['id'] ?? '0') . "')
                                                                 AND (cart.cart_status IS NULL OR cart.cart_status != 'processed')
                                                                 LIMIT 1
                                                                 ) AS in_cart, 
                                                                 (SELECT COUNT(*) FROM favorite 
                                                                 WHERE favorite.product_id = products.id 
                                                                 AND (favorite.session_id = '" . session_id() . "' OR favorite.user_id = '" . ($_SESSION['auth_user']['id'] ?? '0') . "')
                                                                 ) AS in_favorite
                                                            FROM products
                                                            LEFT JOIN categories ON products.category_name = categories.name
                                                            INNER JOIN tags ON products.featured = tags.tag_name
                                                            WHERE products.status = 1
                                                                 AND tags.description = '#6 eco'
                                                                  AND tags.order_num = 6
                                                                                   
                                                            ORDER BY RAND()
                                                       ";

                                                            $product_query_run = mysqli_query($conn, $product_query);

                                                            if (mysqli_num_rows($product_query_run) > 0) {
                                                                 while ($product = mysqli_fetch_assoc($product_query_run)) {
                                                            ?>
                                                                      <?php include "includes/product-card-template.php" ?>

                                                            <?php
                                                                 }
                                                            } else {
                                                                 echo "<p>No featured products available</p>";
                                                            }
                                                            ?>
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
                                        <h2 style="color: #000;" class="h1 products-section-title text-uppercase">
                                             flash sale Products
                                        </h2>

                                        <div class="products-main-wrapper">
                                             <div class="products-wrapper">
                                                  <div class="products">
                                                       <!-- Define Number of product for SLIDER -->
                                                       <div id="bestseller-carousel" class="cz-carousel product_list">
                                                            <?php
                                                            $product_query = "
                                                            SELECT products.*, 
                                                                 categories.name AS category_name, 
                                                                 categories.id AS category_id, 
                                                                 (SELECT quantity FROM cart 
                                                                 WHERE cart.product_id = products.id 
                                                                 AND (cart.session_id = '" . session_id() . "' OR cart.user_id = '" . ($_SESSION['auth_user']['id'] ?? '0') . "')
                                                                 AND (cart.cart_status IS NULL OR cart.cart_status != 'processed')
                                                                 LIMIT 1
                                                                 ) AS in_cart, 
                                                                 (SELECT COUNT(*) FROM favorite 
                                                                 WHERE favorite.product_id = products.id 
                                                                 AND (favorite.session_id = '" . session_id() . "' OR favorite.user_id = '" . ($_SESSION['auth_user']['id'] ?? '0') . "')
                                                                 ) AS in_favorite
                                                            FROM products
                                                            LEFT JOIN categories ON products.category_name = categories.name
                                                            INNER JOIN tags ON products.featured = tags.tag_name
                                                            WHERE products.status = 1
                                                                 AND tags.description = '#7 eco'
                                                                  AND tags.order_num = 7
                                                                                   
                                                            ORDER BY RAND()
                                                       ";

                                                            $product_query_run = mysqli_query($conn, $product_query);

                                                            if (mysqli_num_rows($product_query_run) > 0) {
                                                                 while ($product = mysqli_fetch_assoc($product_query_run)) {
                                                            ?>
                                                                      <?php include "includes/product-card-template.php" ?>

                                                            <?php
                                                                 }
                                                            } else {
                                                                 echo "<p>No featured products available</p>";
                                                            }
                                                            ?>
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
                                             <?php
                                             // Fetch banners from database
                                             $banner_query = "SELECT * FROM banners WHERE status = '1' AND size = 'large' AND banner_type = 'double' ORDER BY RAND() LIMIT 2";
                                             $banner_result = mysqli_query($conn, $banner_query);

                                             $banners = [];
                                             if ($banner_result && mysqli_num_rows($banner_result) > 0) {
                                                  while ($row = mysqli_fetch_assoc($banner_result)) {
                                                       $banners[] = $row;
                                                  }
                                             }

                                             // Display banners
                                             foreach ($banners as $index => $banner):
                                                  $partClass = $index === 0 ? 'cmsbanner-part1' : 'cmsbanner-part2';
                                                  $imgClass = $index === 0 ? 'banner-image1' : 'banner-image2';
                                                  $cmsClass = $index === 0 ? 'cmsbanner1' : 'cmsbanner2';
                                             ?>
                                                  <div class="one-half <?= $partClass ?>">
                                                       <div class="cmsbanner-inner">
                                                            <div class="cmsbanner <?= $cmsClass ?>">
                                                                 <a href="shop.php" class="banner-anchor">
                                                                      <img src="uploads/banners/<?= htmlspecialchars($banner['image']) ?>"
                                                                           alt="<?= htmlspecialchars($banner['title']) ?>"
                                                                           class="<?= $imgClass ?>" width="785" height="280" />
                                                                 </a>
                                                                 <div class="cmsbanner-text">
                                                                      <div class="main-title">
                                                                           <?= htmlspecialchars($banner['title']) ?>
                                                                           <?php if (!empty($banner['subtitle'])): ?>
                                                                                <span><?= htmlspecialchars($banner['subtitle']) ?></span>
                                                                           <?php endif; ?>
                                                                      </div>
                                                                      <?php if (!empty($banner['price'])): ?>
                                                                           <div class="offer-title">From <span>Kes<?= number_format($banner['price'], 2) ?></span></div>
                                                                      <?php endif; ?>
                                                                      <div class="view_more">
                                                                           <a class="btn btn-primary" href="shop.php">Shop Now</a>
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                  </div>
                                             <?php endforeach; ?>
                                        </div>
                                   </div>
                              </section>
                              <!-- Trigger Button -->


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
                                                       <?php
                                                       // Make sure $conn is already connected via mysqli_connect(...)

                                                       $query = "
                                                       SELECT
                                                            f.*,
                                                            p.product_name           AS product_name,
                                                            pi.image_path            AS product_image_path,
                                                            pi.alt_text              AS product_image_alt
                                                       FROM feedback AS f
                                                       LEFT JOIN products AS p
                                                            ON f.product_id = p.id
                                                       LEFT JOIN product_images AS pi
                                                            ON p.id = pi.product_id
                                                            AND pi.is_primary = 1
                                                       WHERE f.status = 1
                                                       ORDER BY f.created_at DESC
                                                       ";

                                                       $result = mysqli_query($conn, $query);

                                                       if ($result && mysqli_num_rows($result) > 0):
                                                            while ($row = mysqli_fetch_assoc($result)):
                                                                 // ─── Feedbacker's Image Logic ───────────────────────────────────
                                                                 $uploadsFeedbackDir = __DIR__ . '/uploads/feedback/';
                                                                 $rawFeedbackImg     = trim($row['image']);
                                                                 $feedbackImgPath    = $uploadsFeedbackDir . $rawFeedbackImg;

                                                                 if (empty($rawFeedbackImg) || !file_exists($feedbackImgPath)) {
                                                                      // default avatar if user didn't upload or file is missing
                                                                      $displayFeedbackImg = 'uploads/feedback/default.jpg';
                                                                 } else {
                                                                      $displayFeedbackImg = 'uploads/feedback/' . $rawFeedbackImg;
                                                                 }

                                                                 // ─── Product Image Logic ───────────────────────────────────────
                                                                 // product_image_path comes from product_images.image_path (e.g. "uploads/shop/prod_abc123.webp")
                                                                 $rawProductImg        = trim($row['product_image_path']);
                                                                 $productImgPathOnDisk  = __DIR__ . '/' . $rawProductImg;

                                                                 if (empty($rawProductImg) || !file_exists($productImgPathOnDisk)) {
                                                                      // fallback to a default product image
                                                                      $displayProductImg     = 'uploads/shop/default.png';
                                                                      $displayProductImgAlt  = htmlspecialchars($row['product_name'], ENT_QUOTES, 'UTF-8');
                                                                 } else {
                                                                      $displayProductImg     = $rawProductImg;
                                                                      // use alt_text from DB if provided, otherwise product_name
                                                                      $displayProductImgAlt  = !empty($row['product_image_alt'])
                                                                           ? htmlspecialchars($row['product_image_alt'], ENT_QUOTES, 'UTF-8')
                                                                           : htmlspecialchars($row['product_name'], ENT_QUOTES, 'UTF-8');
                                                                 }

                                                                 // Prepare product-details URL
                                                                 $productId   = intval($row['product_id']);
                                                                 $productLink = "shop-product.php?id={$productId}";
                                                       ?>
                                                                 <article class="item">
                                                                      <div class="testimonial-description">
                                                                           <div class="feedback-title">
                                                                                "<?= htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8') ?>"
                                                                           </div>
                                                                           <div class="feedback">
                                                                                <?= nl2br(htmlspecialchars($row['feedback'], ENT_QUOTES, 'UTF-8')) ?>
                                                                           </div>
                                                                      </div>

                                                                      <div class="testimonial-inner">
                                                                           <div class="author-image">
                                                                                <img
                                                                                     class="lazyload"
                                                                                     data-src="<?= htmlspecialchars($displayFeedbackImg, ENT_QUOTES, 'UTF-8') ?>"
                                                                                     alt="<?= htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') ?>"
                                                                                     width="60"
                                                                                     height="60" />
                                                                           </div>

                                                                           <div class="author-name">
                                                                                <a href="#" title="<?= htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') ?>">
                                                                                     <?= htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') ?>
                                                                                </a>

                                                                                <?php if (!empty($row['product_name'])): ?>
                                                                                     <div class="product-info" style="margin-top: 8px;">
                                                                                          <div class="product-image" style="margin-bottom: 4px;">
                                                                                               <a href="<?= htmlspecialchars($productLink, ENT_QUOTES, 'UTF-8') ?>" target="_blank">
                                                                                                    <img
                                                                                                         class="lazyload"
                                                                                                         data-src="<?= htmlspecialchars($displayProductImg, ENT_QUOTES, 'UTF-8') ?>"
                                                                                                         alt="<?= $displayProductImgAlt ?>"
                                                                                                         width="80"
                                                                                                         height="80" />
                                                                                               </a>
                                                                                          </div>
                                                                                          <div class="product-name">
                                                                                               <small>Product: <?= htmlspecialchars($row['product_name'], ENT_QUOTES, 'UTF-8') ?></small>
                                                                                          </div>
                                                                                     </div>
                                                                                <?php endif; ?>
                                                                           </div>
                                                                      </div>
                                                                 </article>
                                                       <?php
                                                            endwhile;
                                                       else:
                                                            echo '<p>No testimonials found.</p>';
                                                       endif;
                                                       ?>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </section>







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
                              ?>

                              <section class="lastest_block block homeblog-latest">
                                   <div class="container">
                                        <div class="blog-wrapper">
                                             <h2 style="color: #333;" class="h1 products-section-title text-uppercase">
                                                  Our Latest Blog
                                             </h2>
                                             <div class="homeblog-wrapper">
                                                  <div class="homeblog-inner">
                                                       <div id="blog-carousel" class="cz-carousel product_list">
                                                            <?php while ($blog = mysqli_fetch_assoc($result)) :
                                                                 $createdAt = strtotime($blog['created_at']);
                                                                 $day = date('d', $createdAt);
                                                                 $month = date('F', $createdAt);
                                                                 $year = date('Y', $createdAt);
                                                            ?>
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

                                                                                     <!-- Category name -->
                                                                                     <?php
                                                                                     $cat = htmlspecialchars($blog['category']);
                                                                                     if (mb_strlen($cat) > 10) {
                                                                                          $displayCat = mb_substr($cat, 0, 6) . '..';
                                                                                     } else {
                                                                                          $displayCat = $cat;
                                                                                     }
                                                                                     ?>
                                                                                     <span class="blog-cat">
                                                                                          <i class="fa fa-list"></i>
                                                                                          <a href="#"
                                                                                               title="<?= $cat ?>">
                                                                                               <?= $displayCat ?>
                                                                                          </a>
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
                                                                                          <i class="fa fa-comments-o"></i>
                                                                                          (<?= $commentCount ?>)
                                                                                     </span>

                                                                                     👍 Like (<?= $likeCount ?>)


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
                                                            <?php endwhile; ?>
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
                                                       <?php
                                                       include('admin/config/dbcon.php');

                                                       // Fetch the latest brands from the database
                                                       $brand_query = "SELECT * FROM brands ORDER BY created_at";
                                                       $brand_result = mysqli_query($conn, $brand_query);

                                                       if (!$brand_result) {
                                                            die("Query Failed: " . mysqli_error($conn));
                                                       }
                                                       ?>
                                                       <?php while ($brand = mysqli_fetch_assoc($brand_result)) : ?>
                                                            <li class="item">
                                                                 <div class="brand-image">

                                                                      <img style="width: 50px;height:50px;" class="lazyload"
                                                                           src="uploads/brands/<?php echo htmlspecialchars($brand['brand_image']); ?>" alt="Cartify" />

                                                                 </div>
                                                            </li>
                                                       <?php endwhile; ?>

                                                  </ul>
                                             </div>
                                   </div>
                              </section>
                         </section>
                    </section>
               </div>
          </div>
</section>




<?php include 'includes/footer.php'; ?>

<script>
$(document).ready(function() {
    // Use event delegation for add to cart buttons
    $(document).on('click', '.add-to-cart', function(e) {
        e.preventDefault();
        var formId = $(this).closest('form').attr('id');
        addToCart(formId);
    });

    // Initialize carousel and handle cart updates
    $('#newproduct-carousel').on('initialized.owl.carousel', function() {
        updateCartCount(); // Update cart state when carousel is initialized
    });

    // Update cart state when carousel changes
    $('#newproduct-carousel').on('changed.owl.carousel', function() {
        updateCartCount(); // Update cart state when carousel slides change
    });
});
</script>