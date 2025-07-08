<footer id="footer" class="js-footer">

     <div class="footer-before">
          <div class="container">

               <div id="blockEmailSubscription_displayFooterBefore" class="block_newsletter">
                    <div class="row">
                         <div class="newsletter-detail">
                              <h3 class="title"><span class="news1">Sign Up & Subscribe To Our Newsletter</span></h3>
                              <span class="desc">Subscribe to our latest newsletter to get news about special discounts & upcoming sales</span>
                         </div>
                         <div class="block_content">
                              <form action="" method="post">
                                   <div class="newsletter-form">
                                        <input
                                             class="btn btn-primary pull-xs-right hidden-xs-down"
                                             name="submitNewsletter"
                                             type="submit"
                                             value="Subscribe">
                                        <input
                                             class="btn btn-primary pull-xs-right hidden-sm-up"
                                             name="submitNewsletter"
                                             type="submit"
                                             value="OK">
                                        <div class="input-wrapper">
                                             <input
                                                  name="email"
                                                  type="text"
                                                  value=""
                                                  placeholder="Your Email Address"
                                                  aria-labelledby="block-newsletter-label"
                                                  required>
                                        </div>
                                        <input type="hidden" name="blockHookName" value="displayFooterBefore" />
                                        <input type="hidden" name="action" value="0">
                                        <div class="clearfix"></div>
                                   </div>

                                   <div class="newsletter-message">
                                        <p>You may unsubscribe at any moment. For that purpose, please find our contact info in the legal notice.</p>
                                   </div>


                                   <div class="gdpr_consent gdpr_module_19">
                                        <span class="custom-checkbox">
                                             <label class="psgdpr_consent_message">
                                                  <input id="psgdpr_consent_checkbox_19" name="psgdpr_consent_checkbox" type="checkbox" value="1" class="psgdpr_consent_checkboxes_19">
                                                  <span><i class="material-icons rtl-no-flip checkbox-checked psgdpr_consent_icon"></i></span>
                                                  <span>I agree to the terms and conditions and the privacy policy</span> </label>
                                        </span>
                                   </div>
                              </form>
                         </div>
                    </div>
               </div>

          </div>
     </div>
     <div class="footer-container">
          <div class="container">

               <div id="czfootercmsblock" class="links block">
                    <div id="footercms-wrap">
                         <h3 class="footercms-title">About Us</h3>
                         <div class="footerdesc">
                              Welcome to our store — your trusted destination for high-quality products and outstanding customer service. We are dedicated to delivering excellence, style, and innovation in every experience.
                         </div>
                    </div>

                    <div class="footercms-inner"><a href="#" class="footercms img1">
                              <img src="assets/img/cms-footer-2.png" alt="cms-footer1" class="footercms-image1" width="118" /></a>
                         <a href="#" class="footercms img2"><img src="assets/img/cms-footer-1.png" alt="cms-footer2" class="footercms-image2" width="118" />
                         </a>
                    </div>
               </div>
               <div class="col-md-4 links block">
                    <h3 class="h3 hidden-md-down">Products</h3>
                    <div class="title h3 block_title hidden-lg-up" data-target="#footer_sub_menu_1" data-toggle="collapse">
                         <span class="">Products</span>
                         <span class="pull-xs-right">
                              <span class="navbar-toggler collapse-icons">
                                   <i class="fa-icon add"></i>
                                   <i class="fa-icon remove"></i>
                              </span>
                         </span>
                    </div>
                    <ul id="footer_sub_menu_1" class="collapse block_content">
                         <?php
                         $category_query = "SELECT * FROM categories WHERE status = 1 ORDER BY rand() LIMIT 8";
                         $category_result = mysqli_query($conn, $category_query);

                         if ($category_result && mysqli_num_rows($category_result) > 0) {
                              while ($category = mysqli_fetch_assoc($category_result)) {
                         ?>
                                   <li>
                                        <a
                                             id="link-product-page-prices-drop-<?php echo $category['id']; ?>"
                                             class="cms-page-link"
                                             href="category.php?id=<?php echo $category['id']; ?>"
                                             title="<?php echo htmlspecialchars($category['name']); ?>">
                                             <?php echo htmlspecialchars($category['name']); ?>
                                        </a>
                                   </li>
                         <?php
                              }
                         } else {
                              echo '<li>No categories found.</li>';
                         }
                         ?>
                    </ul>

               </div>
               <div class="col-md-4 links block">
                    <h3 class="h3 hidden-md-down">Information</h3>
                    <div class="title h3 block_title hidden-lg-up" data-target="#footer_sub_menu_2" data-toggle="collapse">
                         <span class="">Information</span>
                         <span class="pull-xs-right">
                              <span class="navbar-toggler collapse-icons">
                                   <i class="fa-icon add"></i>
                                   <i class="fa-icon remove"></i>
                              </span>
                         </span>
                    </div>

                    <ul id="footer_sub_menu_2" class="collapse block_content">
                         <li>
                              <a
                                   id="link-product-page-prices-drop-1"
                                   class="cms-page-link"
                                   href=""
                                   title="Specials">
                                   Specials
                              </a>
                         </li>
                         <li>
                              <a
                                   id="link-product-page-prices-drop-2"
                                   class="cms-page-link"
                                   href=""
                                   title="New products">
                                   New products
                              </a>
                         </li>
                         <li>
                              <a
                                   id="link-product-page-prices-drop-3"
                                   class="cms-page-link"
                                   href=""
                                   title="Best sales">
                                   Best sales
                              </a>
                         </li>
                         <li>
                              <a
                                   id="link-product-page-prices-drop-4"
                                   class="cms-page-link"
                                   href=""
                                   title="Our stores">
                                   Our stores
                              </a>
                         </li>
                         <li>
                              <a
                                   id="link-product-page-prices-drop-5"
                                   class="cms-page-link"
                                   href=""
                                   title="Contact us">
                                   Contact us
                              </a>
                         </li>
                    </ul>
               </div>

               <div id="block_myaccount_infos" class="col-md-2 links wrapper">
                    <h3 class="myaccount-title hidden-sm-down">
                         <a class="text-uppercase" href="" rel="nofollow">
                              Your account
                         </a>
                    </h3>
                    <div class="title clearfix hidden-md-up" data-target="#footer_account_list" data-toggle="collapse">
                         <span class="h3">Your account</span>
                         <span class="pull-xs-right">
                              <span class="navbar-toggler collapse-icons">
                                   <i class="fa-icon add"></i>
                                   <i class="fa-icon remove"></i>
                              </span>
                         </span>
                    </div>
                    <ul class="account-list collapse" id="footer_account_list">

                         <?php if (!isset($_SESSION['auth_user'])) { ?>

                              <li><a href="login.php" title="Log in to your customer account" rel="nofollow">Sign in</a></li>
                              <li><a href="register.php" title="Create account" rel="nofollow">Create account</a></li>

                         <?php } else { ?>
                              <a class="text-uppercase" href="functions/logout.php" rel="nofollow">Logout</a>
                         <?php } ?>
                         <style>
                              .text-uppercase {
                                   text-transform: uppercase;
                                   font-size: 14px;
                                   font-weight: 600;
                                   color: #f5f5f5;
                              }
                         </style>
                    </ul>
               </div>

               <div class="block-contact col-md-4 links wrapper">

                    <h3 class="text-uppercase block-contact-title hidden-sm-down"><a href="contact.php">Contact us</a></h3>

                    <div class="title clearfix hidden-md-up" data-target="#block-contact_list" data-toggle="collapse">
                         <span class="h3">Contact us</span>
                         <span class="pull-xs-right">
                              <span class="navbar-toggler collapse-icons">
                                   <i class="fa-icon add"></i>
                                   <i class="fa-icon remove"></i>
                              </span>
                         </span>
                    </div>

                    <ul id="block-contact_list" class="collapse">
                         <li class="contact">
                              <i class="fa fa-map-marker"></i>
                              <span>Market place<br /> 1234 Nairobi <br /> Kenya</span>
                         </li>

                         <li>
                              <i class="fa fa-envelope-o"></i>
                              <span>
                                   <a href="mailto:buy@marketplace.goprimehost.com">Buy@marketplace.com</a>
                              </span>
                         </li>

                         <li class="phone">
                              <i class="fa fa-phone"></i>
                              <a href='tel:(+91)9876-543-210'>(+254) 0111 893789</a>
                         </li>


                    </ul>
               </div>
               <style type="text/css">
                    :root {
                         --primary-color: #419e66;
                         --secondary-color: #ffffff;
                         --price-color: #419e66;
                         --link-hover-color: #419e66;
                         --box-bodybkg-color: #f5f5f5;
                         --border-radius: 5px;
                         --body-font-family: Lexend;
                         --title-font-family: Lexend;
                         --banner-font-family: Lexend;
                         --body-font-size: 14px;

                         --global-palette1: var(--primary-color);
                         --global-palette1-bkgtext-color: var(--secondary-color);
                         --global-palette-link-color-hover: var(--link-hover-color);
                         --global-border-radius: var(--border-radius);
                         --global-body-font-family: var(--body-font-family);
                         --global-heading-font-family: var(--title-font-family);
                         --global-banner-font-family: var(--banner-font-family);
                    }

                    body,
                    .product-title a,
                    .product-features h3 {
                         font-size: var(--body-font-size);
                    }



                    @media(min-width: 992px) {
                         #columns_inner::after {
                              content: "";
                              display: table;
                              clear: both;
                         }

                         #left-column,
                         #right-column {
                              position: sticky;
                              top: 4rem;
                         }
                    }



                    @media(min-width: 768px) {
                         #product .pp-left-column {
                              position: sticky;
                              top: 5rem;
                         }
                    }
               </style>

          </div>
     </div>

     <div class="footer-after">
          <div class="container">



               <div class="block-social">
                    <ul>
                         <li class="facebook"><a href="https://www.facebook.com/" rel="noopener noreferrer">Facebook</a></li>
                         <li class="twitter"><a href="https://twitter.com/" rel="noopener noreferrer">Twitter</a></li>
                         <li class="youtube"><a href="https://youtube.com/" rel="noopener noreferrer">YouTube</a></li>
                         <li class="pinterest"><a href="https://pinterest.com/" rel="noopener noreferrer">Pinterest</a></li>
                         <li class="instagram"><a href="https://www.instagram.com/" rel="noopener noreferrer">Instagram</a></li>
                    </ul>
               </div>


               <div class="payement_logo_block">
                    <a href="#"><img src="assets/img/payment-logo.png" alt="Payment Logo" /></a>
               </div>
               <div class="control-paneltool">
                    <div class="panel_content">
                         <div class="panel-close hidepanel"><a href="javascript:void(0)"></a></div>

                         <h2 class="panel_headding">Theme Customizer</h2>

                         <div class="panel-settings">
                              <div class="control-group-wrapper color-group skin-setting">
                                   <div class="control_grouptitle">Default Skins</div>
                                   <div class="control-group">
                                        <div class="control-grouplist">
                                             <div class="color-items">
                                                  <div class="color-item" data-color="#e74c3c" style="background-color:#e74c3c"></div>
                                                  <div class="color-item" data-color="#419e66" style="background-color:#419e66"></div>
                                                  <div class="color-item" data-color="#41889e" style="background-color:#41889e"></div>
                                                  <div class="color-item" data-color="#426fdf" style="background-color:#426fdf"></div>
                                                  <div class="color-item" data-color="#ff6a00" style="background-color:#ff6a00"></div>
                                                  <div class="color-item" data-color="#d6122e" style="background-color:#d6122e"></div>
                                                  <div class="color-item" data-color="#9000ff" style="background-color:#9000ff"></div>
                                                  <div class="color-item" data-color="#232f3e" style="background-color:#232f3e"></div>
                                             </div>
                                        </div>
                                   </div>
                              </div>

                              <div class="control-group-wrapper color-group color-setting">
                                   <div class="control_grouptitle">Color & Font Settings</div>
                                   <div class="control-group">

                                        <div class="control-grouplist">
                                             <div class="control_label">Primary Color</div>
                                             <div class="control-tool">
                                                  <input type="text" id="primaryColor" class="preview_color">
                                             </div>
                                        </div>

                                        <div class="control-grouplist">
                                             <div class="control_label">Secondary Color</div>
                                             <div class="control-tool">
                                                  <input type="text" id="secondaryColor" class="preview_color">
                                             </div>
                                        </div>

                                        <div class="control-grouplist">
                                             <div class="control_label">Price Color</div>
                                             <div class="control-tool">
                                                  <input type="text" id="priceColor" class="preview_color">
                                             </div>
                                        </div>

                                        <div class="control-grouplist">
                                             <div class="control_label">Link Hover Color</div>
                                             <div class="control-tool">
                                                  <input type="text" id="linkHoverColor" class="preview_color">
                                             </div>
                                        </div>

                                        <div class="control-grouplist">
                                             <div class="control_label">Body Font</div>
                                             <div class="control-tool">
                                                  <div class="preview_font">
                                                       <select name="bodyFont" id="bodyFont">
                                                            <option value="Red Hat Display" data-link="//fonts.googleapis.com/css2?family=Red+Hat+Display:wght@300;400;500;600;700;800;900&amp;display=swap">Red Hat Display</option>
                                                            <option value="Lexend" data-link="//fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;600;700;800;900&amp;display=swap">Lexend</option>
                                                            <option value="Open Sans" data-link="//fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&amp;display=swap">Open Sans</option>
                                                            <option value="Poppins" data-link="//fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&amp;display=swap">Poppins</option>
                                                            <option value="Lato" data-link="//fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&amp;display=swap">Lato</option>
                                                            <option value="Inter" data-link="//fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&amp;display=swap">Inter</option>
                                                            <option value="Raleway" data-link="//fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700;800&amp;display=swap">Raleway</option>
                                                            <option value="Roboto" data-link="//fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&amp;display=swap">Roboto</option>
                                                            <option value="Oxygen" data-link="//fonts.googleapis.com/css2?family=Oxygen:wght@300;400;700&amp;display=swap">Oxygen</option>
                                                            <option value="Jost" data-link="//fonts.googleapis.com/css2?family=Jost:wght@100;200;300;400;500;600;700;800;900&amp;display=swap">Jost</option>
                                                            <option value="Lora" data-link="//fonts.googleapis.com/css2?family=Lora:wght@400;500;600;700&amp;display=swap">Lora</option>
                                                            <option value="Hind Siliguri" data-link="//fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&amp;display=swap">Hind Siliguri</option>
                                                            <option value="Montserrat" data-link="//fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&amp;display=swap">Montserrat</option>
                                                            <option value="Oswald" data-link="//fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&amp;display=swap">Oswald</option>
                                                            <option value="Nunito Sans" data-link="//fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;300;400;600;700;800;900&amp;display=swap">Nunito Sans</option>
                                                            <option value="Roboto Condensed" data-link="//fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&amp;display=swap">Roboto Condensed</option>
                                                            <option value="Heebo" data-link="//fonts.googleapis.com/css2?family=Heebo:wght@100;200;300;400;500;600;700;800;900&amp;display=swap">Heebo</option>
                                                            <option value="Roboto Slab" data-link="//fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&amp;display=swap">Roboto Slab</option>
                                                            <option value="Playfair Display" data-link="//fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&amp;display=swap">Playfair Display</option>
                                                            <option value="Rajdhani" data-link="//fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&amp;display=swap">Rajdhani</option>
                                                            <option value="Mulish" data-link="//fonts.googleapis.com/css2?family=Mulish:wght@200;300;400;500;600;700;800;900&amp;display=swap">Mulish</option>
                                                            <option value="Merriweather" data-link="//fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700;900&amp;display=swap">Merriweather</option>
                                                            <option value="Work Sans" data-link="//fonts.googleapis.com/css2?family=Work+Sans:wght@100;200;300;400;500;600;700;800;900&amp;display=swap">Work Sans</option>
                                                            <option value="Oxanium" data-link="//fonts.googleapis.com/css2?family=Oxanium:wght@200;300;400;500;600;700;800&amp;display=swap">Oxanium</option>
                                                            <option value="Karla" data-link="//fonts.googleapis.com/css2?family=Karla:wght@200;300;400;500;600;700;800&amp;display=swap">Karla</option>
                                                            <option value="Barlow" data-link="//fonts.googleapis.com/css2?family=Barlow:wght@100;200;300;400;500;600;700;800;900&amp;display=swap">Barlow</option>
                                                       </select>
                                                  </div>
                                             </div>
                                        </div>

                                        <div class="control-grouplist">
                                             <div class="control_label">Body Font Size</div>
                                             <div class="control-tool">
                                                  <div class="preview_font">
                                                       <select name="bodyFontSize" id="bodyFontSize">
                                                            <option value="13px">13px</option>
                                                            <option value="14px">14px</option>
                                                            <option value="15px">15px</option>
                                                            <option value="16px">16px</option>
                                                            <option value="17px">17px</option>
                                                            <option value="18px">18px</option>
                                                       </select>
                                                  </div>
                                             </div>
                                        </div>

                                        <div class="control-grouplist">
                                             <div class="control_label">Title Font</div>
                                             <div class="control-tool">
                                                  <div class="preview_font">
                                                       <select name="titleFont" id="titleFont">
                                                            <option value="Red Hat Display" data-link="//fonts.googleapis.com/css2?family=Red+Hat+Display:wght@300;400;500;600;700;800;900&amp;display=swap">Red Hat Display</option>
                                                            <option value="Lexend" data-link="//fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;600;700;800;900&amp;display=swap">Lexend</option>
                                                            <option value="Open Sans" data-link="//fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&amp;display=swap">Open Sans</option>
                                                            <option value="Poppins" data-link="//fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&amp;display=swap">Poppins</option>
                                                            <option value="Lato" data-link="//fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&amp;display=swap">Lato</option>
                                                            <option value="Inter" data-link="//fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&amp;display=swap">Inter</option>
                                                            <option value="Raleway" data-link="//fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700;800&amp;display=swap">Raleway</option>
                                                            <option value="Roboto" data-link="//fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&amp;display=swap">Roboto</option>
                                                            <option value="Oxygen" data-link="//fonts.googleapis.com/css2?family=Oxygen:wght@300;400;700&amp;display=swap">Oxygen</option>
                                                            <option value="Jost" data-link="//fonts.googleapis.com/css2?family=Jost:wght@100;200;300;400;500;600;700;800;900&amp;display=swap">Jost</option>
                                                            <option value="Lora" data-link="//fonts.googleapis.com/css2?family=Lora:wght@400;500;600;700&amp;display=swap">Lora</option>
                                                            <option value="Hind Siliguri" data-link="//fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&amp;display=swap">Hind Siliguri</option>
                                                            <option value="Montserrat" data-link="//fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&amp;display=swap">Montserrat</option>
                                                            <option value="Oswald" data-link="//fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&amp;display=swap">Oswald</option>
                                                            <option value="Nunito Sans" data-link="//fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;300;400;600;700;800;900&amp;display=swap">Nunito Sans</option>
                                                            <option value="Roboto Condensed" data-link="//fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&amp;display=swap">Roboto Condensed</option>
                                                            <option value="Heebo" data-link="//fonts.googleapis.com/css2?family=Heebo:wght@100;200;300;400;500;600;700;800;900&amp;display=swap">Heebo</option>
                                                            <option value="Roboto Slab" data-link="//fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&amp;display=swap">Roboto Slab</option>
                                                            <option value="Playfair Display" data-link="//fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&amp;display=swap">Playfair Display</option>
                                                            <option value="Rajdhani" data-link="//fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&amp;display=swap">Rajdhani</option>
                                                            <option value="Mulish" data-link="//fonts.googleapis.com/css2?family=Mulish:wght@200;300;400;500;600;700;800;900&amp;display=swap">Mulish</option>
                                                            <option value="Merriweather" data-link="//fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700;900&amp;display=swap">Merriweather</option>
                                                            <option value="Work Sans" data-link="//fonts.googleapis.com/css2?family=Work+Sans:wght@100;200;300;400;500;600;700;800;900&amp;display=swap">Work Sans</option>
                                                            <option value="Oxanium" data-link="//fonts.googleapis.com/css2?family=Oxanium:wght@200;300;400;500;600;700;800&amp;display=swap">Oxanium</option>
                                                            <option value="Karla" data-link="//fonts.googleapis.com/css2?family=Karla:wght@200;300;400;500;600;700;800&amp;display=swap">Karla</option>
                                                            <option value="Barlow" data-link="//fonts.googleapis.com/css2?family=Barlow:wght@100;200;300;400;500;600;700;800;900&amp;display=swap">Barlow</option>
                                                       </select>
                                                  </div>
                                             </div>
                                        </div>

                                        <div class="control-grouplist">
                                             <div class="control_label">Banner Font</div>
                                             <div class="control-tool">
                                                  <div class="preview_font">
                                                       <select name="bannerFont" id="bannerFont">
                                                            <option value="Red Hat Display" data-link="//fonts.googleapis.com/css2?family=Red+Hat+Display:wght@300;400;500;600;700;800;900&amp;display=swap">Red Hat Display</option>
                                                            <option value="Lexend" data-link="//fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;600;700;800;900&amp;display=swap">Lexend</option>
                                                            <option value="Open Sans" data-link="//fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&amp;display=swap">Open Sans</option>
                                                            <option value="Poppins" data-link="//fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&amp;display=swap">Poppins</option>
                                                            <option value="Lato" data-link="//fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&amp;display=swap">Lato</option>
                                                            <option value="Inter" data-link="//fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&amp;display=swap">Inter</option>
                                                            <option value="Raleway" data-link="//fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700;800&amp;display=swap">Raleway</option>
                                                            <option value="Roboto" data-link="//fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&amp;display=swap">Roboto</option>
                                                            <option value="Oxygen" data-link="//fonts.googleapis.com/css2?family=Oxygen:wght@300;400;700&amp;display=swap">Oxygen</option>
                                                            <option value="Jost" data-link="//fonts.googleapis.com/css2?family=Jost:wght@100;200;300;400;500;600;700;800;900&amp;display=swap">Jost</option>
                                                            <option value="Lora" data-link="//fonts.googleapis.com/css2?family=Lora:wght@400;500;600;700&amp;display=swap">Lora</option>
                                                            <option value="Hind Siliguri" data-link="//fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&amp;display=swap">Hind Siliguri</option>
                                                            <option value="Montserrat" data-link="//fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&amp;display=swap">Montserrat</option>
                                                            <option value="Oswald" data-link="//fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&amp;display=swap">Oswald</option>
                                                            <option value="Nunito Sans" data-link="//fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;300;400;600;700;800;900&amp;display=swap">Nunito Sans</option>
                                                            <option value="Roboto Condensed" data-link="//fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&amp;display=swap">Roboto Condensed</option>
                                                            <option value="Heebo" data-link="//fonts.googleapis.com/css2?family=Heebo:wght@100;200;300;400;500;600;700;800;900&amp;display=swap">Heebo</option>
                                                            <option value="Roboto Slab" data-link="//fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&amp;display=swap">Roboto Slab</option>
                                                            <option value="Playfair Display" data-link="//fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&amp;display=swap">Playfair Display</option>
                                                            <option value="Rajdhani" data-link="//fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&amp;display=swap">Rajdhani</option>
                                                            <option value="Mulish" data-link="//fonts.googleapis.com/css2?family=Mulish:wght@200;300;400;500;600;700;800;900&amp;display=swap">Mulish</option>
                                                            <option value="Merriweather" data-link="//fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700;900&amp;display=swap">Merriweather</option>
                                                            <option value="Work Sans" data-link="//fonts.googleapis.com/css2?family=Work+Sans:wght@100;200;300;400;500;600;700;800;900&amp;display=swap">Work Sans</option>
                                                            <option value="Oxanium" data-link="//fonts.googleapis.com/css2?family=Oxanium:wght@200;300;400;500;600;700;800&amp;display=swap">Oxanium</option>
                                                            <option value="Karla" data-link="//fonts.googleapis.com/css2?family=Karla:wght@200;300;400;500;600;700;800&amp;display=swap">Karla</option>
                                                            <option value="Barlow" data-link="//fonts.googleapis.com/css2?family=Barlow:wght@100;200;300;400;500;600;700;800;900&amp;display=swap">Barlow</option>
                                                       </select>
                                                  </div>
                                             </div>
                                        </div>

                                   </div>
                              </div>

                              <div class="control-group-wrapper layout-setting">
                                   <div class="control_grouptitle">Layout Settings</div>
                                   <div class="control-group">
                                        <div class="control-grouplist">
                                             <div class="control_label">Boxed Layout</div>
                                             <div class="control-tool">
                                                  <div class="switchOption layoutOption">
                                                       <input type="radio" id="layoutWide" name="switch_layout" value="widelayout">
                                                       <label for="layoutWide"><span></span></label>
                                                       <input type="radio" id="layoutBoxed" name="switch_layout" value="boxlayout">
                                                       <label for="layoutBoxed"><span></span></label>
                                                       <span class="slider"></span>
                                                  </div>
                                             </div>
                                        </div>

                                        <div class="control-grouplist" id="pattern_block" style="display:none">
                                             <div class="control-grouplist">
                                                  <div class="control_label">Body Back Color</div>
                                                  <div class="control-tool">
                                                       <input type="text" id="bodyBkgColor" class="preview_color">
                                                  </div>
                                             </div>
                                             <div class="pattern-items">
                                                  <div class="pattern-item" id="pattern1" style="background-image:url(assets/img/body-bg1.png)" data-image-url="assets/img/body-bg1.png"></div>
                                                  <div class="pattern-item" id="pattern2" style="background-image:url(assets/img/body-bg2.png)" data-image-url="assets/img/body-bg2.png"></div>
                                                  <div class="pattern-item" id="pattern3" style="background-image:url(assets/img/body-bg3.png)" data-image-url="assets/img/body-bg3.png"></div>
                                                  <div class="pattern-item" id="pattern4" style="background-image:url(assets/img/body-bg4.png)" data-image-url="assets/img/body-bg4.png"></div>
                                                  <div class="pattern-item" id="pattern5" style="background-image:url(assets/img/body-bg5.png)" data-image-url="assets/img/body-bg5.png"></div>
                                                  <div class="pattern-item" id="pattern6" style="background-image:url(assets/img/body-bg6.png)" data-image-url="assets/img/body-bg6.png"></div>
                                                  <div class="pattern-item" id="pattern7" style="background-image:url(assets/img/body-bg7.png)" data-image-url="assets/img/body-bg7.png"></div>
                                                  <div class="pattern-item" id="pattern8" style="background-image:url(assets/img/body-bg8.png)" data-image-url="assets/img/body-bg8.png"></div>
                                                  <div class="pattern-item" id="pattern9" style="background-image:url(assets/img/body-bg9.png)" data-image-url="assets/img/body-bg9.png"></div>
                                                  <div class="pattern-item" id="pattern10" style="background-image:url(assets/img/body-bg10.png)" data-image-url="assets/img/body-bg10.png"></div>
                                             </div>
                                        </div>

                                        <div class="control-grouplist">
                                             <div class="control_label">Sticky Header</div>
                                             <div class="control-tool">
                                                  <div class="switchOption stickyHeader">
                                                       <input type="radio" id="noSticky" name="sticky_header" value="no">
                                                       <label for="noSticky"><span></span></label>
                                                       <input type="radio" id="yesSticky" name="sticky_header" value="yes">
                                                       <label for="yesSticky"><span></span></label>
                                                       <span class="slider"></span>
                                                  </div>
                                             </div>
                                        </div>

                                        <div class="control-grouplist">
                                             <div class="control_label">Border Radius</div>
                                             <div class="control-tool">
                                                  <div class="switchOption borderRadius">
                                                       <input type="radio" id="noRadius" name="border_radius" value="no">
                                                       <label for="noRadius"><span></span></label>
                                                       <input type="radio" id="yesRadius" name="border_radius" value="yes">
                                                       <label for="yesRadius"><span></span></label>
                                                       <span class="slider"></span>
                                                  </div>
                                             </div>
                                        </div>

                                   </div>
                              </div>

                              <div class="control-group-wrapper control-reset">
                                   <button class="reset_settings btn btn-primary" id="resetSettings">Reset Settings</button>
                              </div>
                         </div>
                    </div>
               </div>




               <div class="copyright">
                    <a href="https://www.goprimehost.com" target="_blank" rel="noopener noreferrer nofollow">
                         © <span id="current-year"></span> <span id="local-time"></span> - Ecommerce software by Goprimehost
                    </a>
               </div>

               <script>
                    function updateLocalTime() {
                         const now = new Date();
                         // Update the time every second
                         document.getElementById("local-time").textContent = now.toLocaleTimeString(); // e.g. 10:45:30 AM
                    }

                    // Set the year once
                    document.getElementById("current-year").textContent = new Date().getFullYear();

                    // Initial call to display time immediately
                    updateLocalTime();

                    // Update time every 1 second
                    setInterval(updateLocalTime, 1000);
               </script>



          </div>
     </div>

     <a class="top_button" href="#" style="">&nbsp;</a>
     
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
                         
                         // Initialize add to cart button in quick view
                         $(".quick-view-add-to-cart").off('click').on('click', function(e) {
                              e.preventDefault();
                              var form = $(this).closest('form');
                              var formId = form.attr('id');
                              addToCart(formId);
                         });
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

          // Function to update cart count and dropdown
          function updateCartCount() {
               $.ajax({
                    url: 'ajax/cart_update.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                         if (response.status === 'success') {
                              // Update all cart count elements
                              $('.mobile_count, #cart-item-count-mobile, #cart-item-count-mobile-title').text(response.total_items);
                              
                              // Update cart total
                              $('.cart-products-count .value, #cart-total-price-mobile').text('Kes ' + response.total_price);
                              
                              // Update cart items list
                              $('#cart-items-list-mobile, .cart-items-list').html(response.cart_html);
                              
                              // Update cart summary
                              $('#cart-subtotal-products-value').text('Kes ' + (response.total_price - response.shipping_cost).toFixed(2));
                              $('#cart-subtotal-shipping-value').text('Kes ' + response.shipping_cost.toFixed(2));
                              
                              // Update cart button state
                              if (response.total_items > 0) {
                                   $('.shopping-cart').removeClass('empty');
                              } else {
                                   $('.shopping-cart').addClass('empty');
                              }

                              // Update all add to cart buttons on the page
                              $('.add-to-cart').each(function() {
                                   var button = $(this);
                                   var form = button.closest('form');
                                   var productId = form.find('input[name="product_id"]').val();
                                   
                                   // Check if this product is in the cart
                                   var inCart = false;
                                   var cartQuantity = 0;
                                   $(response.cart_items).each(function() {
                                        if (this.product_id == productId) {
                                             inCart = true;
                                             cartQuantity = this.quantity;
                                             return false;
                                        }
                                   });

                                   if (inCart) {
                                        button.removeClass('btn-primary').addClass('btn-success');
                                        button.text('In Cart (' + cartQuantity + ')');
                                        button.prop('disabled', true);
                                   } else {
                                        button.removeClass('btn-success').addClass('btn-primary');
                                        button.text('Add to cart');
                                        button.prop('disabled', false);
                                   }
                              });
                         }
                    },
                    error: function(xhr, status, error) {
                         console.error('Error updating cart:', error);
                    }
               });
          }

          // Initialize all add to cart buttons
          $(document).on('click', '.add-to-cart', function(e) {
               e.preventDefault();
               var form = $(this).closest('form');
               var formId = form.attr('id');
               addToCart(formId);
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


<script src="admin/assets/js/sweetalert.js"></script>



<!-- Global override (fallback) -->
<style>
     .swal2-container {
          z-index: 10000 !important;
     }

     .my-swal-container {
          z-index: 2147483647 !important;
     }
</style>

<?php
if (isset($_SESSION['message'])) {
     $icon = ($_SESSION['messageType'] === 'success') ? 'success' : 'error';
?>
     <script>
          Swal.fire({
               position: 'top-end',
               icon: '<?php echo $icon; ?>',
               title: '<?php echo addslashes($_SESSION['message']); ?>',
               toast: true,
               showConfirmButton: false,
               timer: 2000,
               width: 'auto',
               padding: '0.1em',
               background: 'white',
               customClass: {
                    container: 'my-swal-container'
               }
          });
     </script>
<?php
     unset($_SESSION['message'], $_SESSION['messageType']);
}
?>


<script type="text/javascript" src="assets/js/main.js"></script>


<script src="ajax/ajax_function.js"></script>
<!-- include_once 'includes/feedback.php' -->
</body>

</footer>

</main>