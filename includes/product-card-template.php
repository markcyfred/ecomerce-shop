 <article class="product_item slider_item">
      <div class="product-miniature js-product-miniature"
           data-id-product="<?= $product['id']; ?>">

           <div class="thumbnail-container">
                <a href="shop-product.php?id=<?= $product['id']; ?>" class="thumbnail product-thumbnail">
                     <img class="lazyload"
                          src="uploads/shop/<?= $product['image'] ?? 'default.jpg'; ?>"
                          alt="<?= htmlspecialchars($product['name'] ?? 'No Name'); ?>"
                          width="250" height="250">

                     <img class="lazyload fliper_image img-responsive"
                          src="uploads/shop/<?= $product['image'] ?? 'default.jpg'; ?>"
                          alt="Flip image of <?= htmlspecialchars($product['name'] ?? 'No Name'); ?>">
                </a>

                <ul class="product-flags js-product-flags">
                     <li class="product-flag on-sale">On sale!</li>
                     <li><i class="material-icons left">&#xe3e7;</i><?= $product['discount'] ?? ''; ?></li>
                     <li class="product-flag new"><?= $product['featured']; ?></li>
                </ul>

                <div class="outer-functional">
                     <div class="functional-buttons">
                          <div class="wishlist">
                               <a class="st-wishlist-button btn-product btn"
                                    href="javascript:void(0);"
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
                               <a href="#" class="quick-view-btn text-blue-600 hover:underline"
                                    data-product-id="<?= $product['id']; ?>">Quick View</a>
                          </div>
                     </div>
                </div>
           </div>

           <div class="product-description">
                <div class="brand-title" itemprop="name">
                     <a href="category.php?id=<?= $product['category_id']; ?>">
                          <?= htmlspecialchars($product['category_name']); ?>
                     </a>
                </div>

                <h3 class="h3 product-title">
                     <a href="shop-product.php?id=<?= $product['id']; ?>">
                          <?= htmlspecialchars($product['product_name']); ?>
                     </a>
                </h3>

                <div class="comments_note">
                     <div class="star_content clearfix">
                          <?php
                              $rating = $product['rating'] ?? 0;
                              for ($i = 0; $i < 5; $i++) {
                                   echo '<div class="star' . ($i < $rating ? ' star_on' : '') . '"></div>';
                              }
                              ?>
                     </div>
                </div>

                <div class="product-price-and-shipping">
                     <span class="regular-price">Kes <?= $product['original_price']; ?></span>
                     <span class="price">Kes <?= $product['selling_price']; ?></span>
                </div>

                <div class="proaction-button">
                     <form id="cartForm_<?= $product['id']; ?>" method="POST" action="">
                          <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                          <input type="hidden" name="add_to_cart_btn" value="true">
                          <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['product_name']); ?>">
                          <input type="hidden" name="selling_price" value="<?= $product['selling_price']; ?>">
                          <input type="hidden" name="image" value="<?= $product['image']; ?>">
                          <input type="hidden" name="quantity" value="1">

                          <?php if (!isset($product['in_cart']) || $product['in_cart'] == 0): ?>
                               <a class="action-btn hover-up btn-primary add-to-cart"
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
                               }
                          </style>
                     </form>
                </div>
           </div>
      </div>
 </article>