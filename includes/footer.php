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
                              <form action="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/#blockEmailSubscription_displayFooterBefore" method="post">
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
                         ©

                         <span id="local-time"></span>
                         <script>
                              const now = new Date();

                              // Shows current device/browser time
                              document.getElementById("local-time").textContent = now.toLocaleString();

                              // Force different timezone regardless of system or VPN
                              document.getElementById("india-time").textContent = now.toLocaleString("en-US", {
                                   timeZone: "Asia/Kolkata"
                              });
                         </script> - Ecommerce software by Goprimehost
                    </a>


               </div>
          </div>
     </div>

     <a class="top_button" href="#" style="">&nbsp;</a>

</footer>

</main>


<script type="text/javascript" src="assets/js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

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

<script>
     function addToCart(formId) {
          var formData = $('#' + formId).serialize();
          $.ajax({
               url: 'ajax/code.php', // path to your PHP file inside the ajax folder
               type: 'POST',
               data: formData,
               dataType: 'json',
               success: function(response) {
                    if (response.status === 'success') {
                         // Show success message with SweetAlert2
                         Swal.fire({
                              position: 'top-end',
                              icon: 'success',
                              title: response.message,
                              showConfirmButton: false,
                              timer: 2000,
                              toast: true,
                              width: 'auto',
                              padding: '0.1em',
                              background: 'white',
                              customClass: {
                                   popup: 'small-swal'
                              }
                         });
                         // Update UI: Replace the "Add To Cart" button with "Already in Cart" message
                         $('#' + formId + ' .action-btn').replaceWith('<span class="in-cart-message">Already in Cart</span>');
                    } else {
                         // Show error message with SweetAlert2
                         Swal.fire({
                              position: 'top-end',
                              icon: 'error',
                              title: response.message,
                              showConfirmButton: false,
                              timer: 2000,
                              toast: true,
                              width: 'auto',
                              padding: '0.1em',
                              background: 'white',
                              customClass: {
                                   popup: 'small-swal'
                              }
                         });
                    }
               },
               error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    // Show generic error message with SweetAlert2
                    Swal.fire({
                         position: 'top-end',
                         icon: 'error',
                         title: 'An error occurred while adding the product to the cart.',
                         showConfirmButton: false,
                         timer: 2000,
                         toast: true,
                         width: 'auto',
                         padding: '0.1em',
                         background: 'white',
                         customClass: {
                              popup: 'small-swal'
                         }
                    });
               }
          });
     }
</script>

<script>
     // Wait until DOM is loaded
     document.addEventListener('DOMContentLoaded', function() {
          var cart = document.getElementById('desktop_cart');
          if (!cart) return; // safety check

          cart.addEventListener('click', function(e) {
               // Find the element with class 'mobile_count' inside the cart
               var countEl = cart.querySelector('.mobile_count');
               var count = 0;
               if (countEl) {
                    // parseInt will ignore non-numeric chars and return NaN if none; fallback to 0
                    count = parseInt(countEl.textContent, 10) || 0;
               }

               if (count === 0) {
                    // Stop any default action (like link navigation)
                    e.preventDefault();
                    Swal.fire({
                         icon: 'info',
                         title: 'Your cart is empty',
                         toast: true,
                         position: 'top-end',
                         showConfirmButton: false,
                         timer: 2000,
                         background: 'white',
                         customClass: {
                              popup: 'small-swal'
                         }
                    });
               }
               // If count > 0, click proceeds normally
          });
     });
</script>

<script>
     // Wait until DOM is ready
     $(function() {
          // Delegate click so it works for dynamically loaded items
          $(document).on('click', '.st-wishlist-button', function(e) {
               e.preventDefault();
               var $btn = $(this);
               var productId = $btn.data('product-id');
               var productName = $btn.data('product-name');
               var sellingPrice = $btn.data('selling-price');
               var image = $btn.data('image');
               var sessionData = {
                    add_to_favorite_btn: true,
                    product_id: productId,
                    product_name: productName,
                    selling_price: sellingPrice,
                    image: image,
                    quantity: 1
               };

               $.ajax({
                         url: 'ajax/code.php',
                         method: 'POST',
                         dataType: 'json',
                         data: sessionData,
                    })
                    .done(function(response) {
                         if (response.status === 'success') {
                              Swal.fire({
                                   position: 'top-end',
                                   icon: 'success',
                                   title: response.message,
                                   showConfirmButton: false,
                                   timer: 2000,
                                   toast: true,
                                   background: 'white',
                                   customClass: {
                                        popup: 'small-swal'
                                   }
                              });
                              // Swap to filled heart
                              $btn.find('i')
                                   .removeClass('fi-rs-heart')
                                   .addClass('fa fa-heart')
                                   .attr('aria-hidden', 'true');
                         } else {
                              Swal.fire({
                                   position: 'top-end',
                                   icon: 'error',
                                   title: response.message,
                                   showConfirmButton: false,
                                   timer: 2000,
                                   toast: true,
                                   background: 'white',
                                   customClass: {
                                        popup: 'small-swal'
                                   }
                              });
                         }
                    })
                    .fail(function(xhr, status, error) {
                         console.error('Favorite AJAX Error:', error);
                         Swal.fire({
                              position: 'top-end',
                              icon: 'error',
                              title: 'Could not add to favorites. Try again.',
                              showConfirmButton: false,
                              timer: 2000,
                              toast: true,
                              background: 'white',
                              customClass: {
                                   popup: 'small-swal'
                              }
                         });
                    });
          });
     });
</script>



</body>

</html>