<?php
include 'init.php';

if (session_status() == PHP_SESSION_NONE) {
     session_start();
}

include 'functions/userfunctions.php';
?>
<!doctype html>
<html lang="en-US">

<head>

     <meta charset="utf-8">

     <meta http-equiv="x-ua-compatible" content="ie=edge">

     <title>Market place</title>


     <meta name="viewport" content="width=device-width, initial-scale=1">



     <link rel="icon" type="image/vnd.microsoft.icon" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/favicon.ico?1733981001">
     <link rel="shortcut icon" type="image/x-icon" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/favicon.ico?1733981001">



     <!-- Codezeel added -->
     <link href="//fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

     <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOFQNHSoRxMt0aBcB/+Yw5yYtN0bBI7f0Q5V0hMdIP+"
          crossorigin="anonymous">
     <link rel="stylesheet"
          href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
          integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm"
          crossorigin="anonymous">
     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
     <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.5.10-0/css/ionicons.min.css">
     <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/themify-icons@0.1.2/css/themify-icons.css">
     <link rel="stylesheet"
          href="{$shop_url}/modules/ps_fontawesome/views/dist/css/all.css">

     <link rel="stylesheet" href="assets/css/main.css" type="text/css" media="all">



     <link href="//fonts.googleapis.com/css?family=Lexend:300,400,500,600,700,800,900&display=swap" rel="stylesheet" id="body_font">

     <link href="//fonts.googleapis.com/css?family=Lexend:300,400,500,600,700,800,900&display=swap" rel="stylesheet" id="title_font">

     <link href="//fonts.googleapis.com/css?family=Lexend:300,400,500,600,700,800,900&display=swap" rel="stylesheet" id="banner_font">




     <script type="text/javascript">
          var CZBORDER_RADIUS = "1";
          var CZBOX_LAYOUT = "0";
          var CZSTICKY_HEADER = "1";
          var buttoncompare_title_add = "Add to Compare";
          var buttoncompare_title_remove = "Remove from Compare";
          var buttonwishlist_title_add = "Add to Wishlist";
          var buttonwishlist_title_remove = "Remove from WishList";
          var comparator_max_item = 3;
          var compared_products = [];
          var isLogged = false;
          var prestashop = {

          };
     </script>



     <!-- module psproductcountdown start -->
     <script type="text/javascript">
          var pspc_labels = ['days', 'hours', 'minutes', 'seconds'];
          var pspc_labels_lang = {
               'days': 'days',
               'hours': 'hrs',
               'minutes': 'min',
               'seconds': 'sec'
          };
          var pspc_show_weeks = 0;
          var pspc_psv = 8.2;
     </script>
     <!-- module psproductcountdown end -->

</head>

<body id="index" class="lang-en country-us currency-usd layout-full-width page-index tax-display-disabled">



     <main id="page">

          <header id="header">
               <!--top most header-->
               <nav class="header-nav">
                    <div class="container">
                         <div class="left-nav">
                              <div id="cznavcmsblock" class="nav-cms-block">
                                   <p><span class="offer-text">Tell a friends about Market place &amp; get 30% off.</span></p>
                              </div>

                         </div>

                         <div class="right-nav">
                              <div id="_desktop_contact_link">
                                   <div id="contact-link">

                                        <div class="email">
                                             <i class="fa fa-envelope-o"></i>
                                             <a href="mailto:buy@marketplace@com">buy@marketplace.com </a>
                                        </div>

                                        <div class="contact_number">
                                             <i class="fa fa-whatsapp"></i>
                                             <a href="https://wa.me/254111893789" target="_blank">Agree via WhatsApp</a><br>
                                             <i class="fa fa-phone"></i>
                                             <a href="tel:+254111893789">Call: +254 111 893 789</a>
                                        </div>

                                   </div>
                              </div>


                              <div class="language-selector dropdown js-dropdown" id="_desktop_language_selector">
                                   <span class="hidden-lg-up language">Language:</span>
                                   <span class="expand-more" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="language-dropdown">
                                        <span><img class="lang-flag lazyload" data-src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/l/1.jpg"></span>
                                        <span class="hidden-md-down">English </span>
                                        <span class="hidden-lg-up language-iso_code text-uppercase">en</span>
                                   </span>
                                
                              </div>

                              <div class="currency-selector dropdown js-dropdown" id="_desktop_currency_selector">
                                   <span class="currency hidden-lg-up">Currency : </span>
                                   <span class="expand-more _gray-darker" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="currency-dropdown">
                                       KES
                                   </span>
                                
                              </div>
                         </div>

                    </div>
               </nav>
               <!--top most header end-->



               <div class="header-top">
                    <div class="container">

                         <div class="js-top-menu mobile" id="_mobile_base_menu"></div>

                         <div class="header_logo">
                              <h1>
                                   <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/">
                                        <img class="logo img-responsive" src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/logo-1733981001.svg" alt="Demo Store" loading="lazy">
                                   </a>
                              </h1>
                         </div>

                         <!-- Block search module TOP -->


                         <div id="search_block_top" class="search-widget">
                              <span class="search_button" data-target="#search-toggle" data-toggle="collapse" aria-expanded="false"></span>
                              <div id="search-toggle" class="search_toggle collapse" aria-expanded="false">
                                   <form id="searchbox" method="get" action="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/search">
                                        <div class="czsearch-main">
                                             <input type="hidden" name="controller" value="search">
                                             <input type="hidden" name="orderby" value="position" />
                                             <input type="hidden" name="orderway" value="desc" />

                                             <div class="select-wrapper">
                                                  <select id="search_category" name="search_category" class="form-control">
                                                       <option value="all">All Categories</option>
                                                       <option value="6">&nbsp&nbspAccessories</option>
                                                       <option value="7">&nbsp&nbsp&nbsp&nbspTV & Speaker</option>
                                                       <option value="8">&nbsp&nbsp&nbsp&nbspMacBook</option>
                                                       <option value="12">&nbsp&nbsp&nbsp&nbspWireless Printer</option>
                                                       <option value="13">&nbsp&nbsp&nbsp&nbspEarbuds Bose</option>
                                                       <option value="14">&nbsp&nbsp&nbsp&nbspGadgets</option>
                                                       <option value="3">&nbsp&nbspPhones</option>
                                                       <option value="4">&nbsp&nbsp&nbsp&nbspApple Ipad</option>
                                                       <option value="5">&nbsp&nbsp&nbsp&nbspBasic Phones</option>
                                                       <option value="19">&nbsp&nbsp&nbsp&nbspFeature Phones</option>
                                                       <option value="20">&nbsp&nbsp&nbsp&nbspSmart Phones</option>
                                                       <option value="9">&nbsp&nbspSmart Devices</option>
                                                       <option value="21">&nbsp&nbsp&nbsp&nbspGame Controller</option>
                                                       <option value="22">&nbsp&nbsp&nbsp&nbspHeadphone</option>
                                                       <option value="23">&nbsp&nbsp&nbsp&nbspSmart Watch</option>
                                                       <option value="24">&nbsp&nbsp&nbsp&nbspSmart Speakers</option>
                                                       <option value="10">&nbsp&nbspLaptop & Computers</option>
                                                       <option value="25">&nbsp&nbsp&nbsp&nbspConvertible Laptops</option>
                                                       <option value="26">&nbsp&nbsp&nbsp&nbspPersonal Computers</option>
                                                       <option value="27">&nbsp&nbsp&nbsp&nbspUltraportable Laptops</option>
                                                       <option value="28">&nbsp&nbsp&nbsp&nbspMacBook</option>
                                                       <option value="11">&nbsp&nbspChargers & Cables</option>
                                                       <option value="29">&nbsp&nbsp&nbsp&nbspAdapter Plug</option>
                                                       <option value="30">&nbsp&nbsp&nbsp&nbspBettery Chargers</option>
                                                       <option value="31">&nbsp&nbsp&nbsp&nbspUSB Type Cable</option>
                                                       <option value="32">&nbsp&nbsp&nbsp&nbspUSB-C Charger</option>
                                                  </select>
                                             </div>

                                             <input class="search_query form-control" type="text" id="search_query_top" name="s" placeholder="Search Product Here..." value="" />

                                             <div id="cz_url_ajax_search" style="display:none">
                                                  <input type="hidden" value="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/modules/cz_blocksearch/controller_ajax_search.php" class="url_ajax" />
                                             </div>
                                        </div>
                                        <button type="submit" class="btn search-icon-btn">
                                             <div class="submit-text">Search</div>
                                        </button>
                                   </form>
                              </div>
                         </div>

                         <script type="text/javascript">
                              var limit_character = "<p class='limit'>Number of characters at least are 3</p>";
                         </script>

                         <style text="text/css">
                              #search_block_top #search_query_top {
                                   padding: 8px 45px 8px 168px;
                              }

                              @media (max-width: 1199px) and (min-width: 992px) {
                                   #search_block_top #search_query_top {
                                        padding: 8px 45px 8px 120px;
                                   }
                              }

                              @media (max-width: 991px) {
                                   #search_block_top #search_query_top {
                                        padding: 6px 45px 6px 140px;
                                   }
                              }

                              @media (max-width: 480px) {
                                   #search_block_top #search_query_top {
                                        padding: 8px 35px 8px 120px;
                                   }
                              }
                         </style>
                         <!-- /Block search module TOP -->


                         <div class="header-top-right">

                              <div class="user-info js-dropdown">
                                   <span class="user-info-title _gray-darker" data-toggle="dropdown">
                                        <span class="user-icon"></span>
                                        <div class="account-wrap">
                                             <span class="account_text">Account</span>
                                             <span class="account_subtext"> Log in </span>
                                        </div>
                                   </span>

                                   <ul class="dropdown-menu">
                                        <li>
                                             <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/my-account" class="dropdown-item"
                                                  title="Log in to your customer account"
                                                  rel="nofollow">
                                                  Login
                                             </a>
                                        </li>
                                        <li>
                                             <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/registration" data-link-action="display-register-form">
                                                  Register
                                             </a>
                                        </li>
                                   </ul>
                              </div>


                              <div class="head-wishlist">
                                   <a
                                        class="ap-btn-wishlist"
                                        href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/module/stfeature/mywishlist"
                                        title="Wishlist"
                                        rel="nofollow">
                                        <i class="material-icons">&#xE87E;</i>
                                        <span class="icon">Wishlist</span>
                                        <span class="ap-total-wishlist">0</span>
                                   </a>
                              </div>

                              <div class="head-compare">
                                   <a
                                        class="ap-btn-compare"
                                        href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/module/stfeature/productscompare"
                                        title="Compare"
                                        rel="nofollow">
                                        <i class="material-icons">&#xE863;</i>
                                        <span class="icon">Compare</span>
                                        <span class="ap-total-compare"></span>
                                   </a>
                              </div>
                              <div id="desktop_cart">
                                   <div class="blockcart" data-refresh-url="//demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/module/ps_shoppingcart/ajax">
                                        <div class="header blockcart-header">

                                             <div class="shopping-cart" rel="nofollow">
                                                  <span class="icon"> </span>
                                                  <span class="mobile_count">0</span>
                                                  <span class="cart-products-count hidden-sm-down">My Cart<span class="value"> $0.00</span></span>
                                             </div>

                                             <div class="cart_block block exclusive">
                                                  <div class="top-block-cart">
                                                       <div class="toggle-title">Shopping Cart (0)</div>
                                                       <span aria-hidden="true" class="close-icon"><i class="material-icons">close</i></span>
                                                  </div>
                                                  <div class="block_content">
                                                       <div class="no-more-item">
                                                            <div class="no-img"></div>
                                                            <div class="empty-text">Your cart is empty.</div>
                                                            <p>You may check out all the available products and buy some in the shop.</p>
                                                            <a rel="nofollow" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/" class="continue"><button type="button" class="btn btn-primary">Continue shopping</button></a>
                                                       </div>
                                                  </div>
                                             </div>

                                        </div>
                                   </div>
                              </div>

                         </div>
                    </div>
                    <div class="overlay"></div>

                    <span id="moremenu_text" style="display:none;">More</span>
                    <span id="morecategory_text" style="display:none;">More Categories</span>
                    <span id="lesscategory_text" style="display:none;">Less Categories</span>

               </div>


               <div class="header-top-inner">
                    <div class="container">


                         <div class="vertical-menu menu js-top-menu position-static hidden-md-down">
                              <div id="czverticalmenublock" class="block verticalmenu-block">
                                   <h4 class="expand-more title h3 block_title" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="verticalmenu-dropdown">
                                        Browse All Category
                                        <span class="dropdown-arrow"></span>
                                   </h4>
                                   <div class="block_content verticalmenu_block dropdown-menu" aria-labelledby="verticalmenu-dropdown" id="_desktop_vertical_menu">
                                        <div class="title_main_menu hidden-lg-up">
                                             <div class="title_menu">Browse All Category</div>
                                        </div>

                                        <ul class="top-menu" id="top-menu" data-depth="0">
                                             <li class="category" id="category-17"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/17-android-tv" class="dropdown-item" data-depth="0">Android TV</a></li>
                                             <li class="category" id="category-4"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/4-apple-ipad" class="dropdown-item" data-depth="0">Apple Ipad</a></li>
                                             <li class="category" id="category-6"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/6-accessories" class="dropdown-item" data-depth="0"><span class="pull-xs-right sub-menu-arrow"></span><span class="pull-xs-right hidden-lg-up"><span data-target="#top_sub_menu_89821" data-toggle="collapse" class="navbar-toggler collapse-icons"><i class="material-icons add">&#xE145;</i><i class="material-icons remove">&#xE15B;</i></span></span> <span class="pull-xs-right sub-menu-arrow"></span>Accessories</a>
                                                  <div class="sub-menu js-sub-menu collapse" id="top_sub_menu_89821">
                                                       <ul class="top-menu" data-depth="1">
                                                            <li class="category" id="category-7"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/7-tv-speaker" class="dropdown-item dropdown-submenu" data-depth="1"><span class="pull-xs-right sub-menu-arrow"></span><span class="pull-xs-right hidden-lg-up"><span data-target="#top_sub_menu_28974" data-toggle="collapse" class="navbar-toggler collapse-icons"><i class="material-icons add">&#xE145;</i><i class="material-icons remove">&#xE15B;</i></span></span>TV &amp; Speaker</a>
                                                                 <div class="sub-menu collapse" id="top_sub_menu_28974">
                                                                      <ul class="top-menu" data-depth="2">
                                                                           <li class="category" id="category-15"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/15-home-theatre-systems" class="dropdown-item" data-depth="2">Home Theatre Systems</a></li>
                                                                           <li class="category" id="category-16"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/16-party-speakers" class="dropdown-item" data-depth="2">Party Speakers</a></li>
                                                                           <li class="category" id="category-17"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/17-android-tv" class="dropdown-item" data-depth="2">Android TV</a></li>
                                                                           <li class="category" id="category-18"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/18-tv-audio-accessories" class="dropdown-item" data-depth="2">TV &amp; Audio Accessories</a></li>
                                                                      </ul>
                                                                      <div class="menu-images-container"></div>
                                                                 </div>
                                                            </li>
                                                            <li class="category" id="category-8"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/8-macbook" class="dropdown-item dropdown-submenu" data-depth="1">MacBook</a></li>
                                                            <li class="category" id="category-12"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/12-wireless-printer" class="dropdown-item dropdown-submenu" data-depth="1">Wireless Printer</a></li>
                                                            <li class="category" id="category-13"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/13-earbuds-bose" class="dropdown-item dropdown-submenu" data-depth="1">Earbuds Bose</a></li>
                                                            <li class="category" id="category-14"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/14-gadgets" class="dropdown-item dropdown-submenu" data-depth="1">Gadgets</a></li>
                                                       </ul>
                                                       <div class="menu-images-container"></div>
                                                  </div>
                                             </li>
                                             <li class="category" id="category-21"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/21-game-controller" class="dropdown-item" data-depth="0">Game Controller</a></li>
                                             <li class="category" id="category-22"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/22-headphone" class="dropdown-item" data-depth="0">Headphone</a></li>
                                             <li class="category" id="category-23"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/23-smart-watch" class="dropdown-item" data-depth="0">Smart Watch</a></li>
                                             <li class="category" id="category-25"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/25-convertible-laptops" class="dropdown-item" data-depth="0">Convertible Laptops</a></li>
                                             <li class="category" id="category-28"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/28-macbook" class="dropdown-item" data-depth="0">MacBook</a></li>
                                             <li class="category" id="category-29"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/29-adapter-plug" class="dropdown-item" data-depth="0">Adapter Plug</a></li>
                                        </ul>
                                   </div>
                              </div>
                         </div>
                         <!-- Module Horizontalmenu-->
                         <div id="_desktop_base_menu">
                              <div class="container_base_horizontalmenu col-sm-12">
                                   <div id="base-menu-horizontal" class="base-menu-horizontal clearfix">
                                        <div class="title-horizontalmenu-mobile default-open" title="Shop Categories">
                                             <div class="menu-title">Menu</div>
                                        </div>

                                        <div class="horizontalmain-menu">
                                             <div class="title_main_menu">
                                                  <div class="title_menu">Menu</div>
                                                  <i class="material-icons menu-close">&#xE5CD;</i>
                                             </div>

                                             <ul class="horizontalmenu-content">

                                                  <li class="level-1 label-danger parent">
                                                       <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/3-phones" class="baseinnermenu">
                                                            <span class="material-icons base-left-arrow">arrow_forward</span>
                                                            <span class="catagory">Phones</span> <i class="material-icons expand-more">&#xe313;</i>
                                                            <div class="menu-subtitle">Sale</div>
                                                       </a>

                                                       <span data-target="#top_sub_menu_65453" data-toggle="collapse" class="navbar-toggler collapse-icons">
                                                            <i class="material-icons add">&#xe145;</i>
                                                            <i class="material-icons remove">&#xE15B;</i>
                                                       </span>

                                                       <div class="base-sub-menu menu-dropdown col-xs-12 col-sm-12 base-sub-left" id="top_sub_menu_65453">

                                                            <div class="base-menu-row five-column">

                                                                 <div class="base-menu-col col-xs-12 col-sm-2 ">












                                                                      <ul class="ul-column ">
                                                                           <li class="menu-item item-header">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/9-smart-devices" class="submenu-title">Smart Devices</a>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/12-wireless-printer" class="submenu-title">Wireless Printer</a>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/21-game-controller" class="submenu-title">Game Controller</a>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/22-headphone" class="submenu-title">Headphone</a>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/20-smart-phones" class="submenu-title">Smart Phones</a>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/23-smart-watch" class="submenu-title">Smart Watch</a>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/24-smart-speakers" class="submenu-title">Smart Speakers</a>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/26-personal-computers" class="submenu-title">Personal Computers</a>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/8-macbook" class="submenu-title">MacBook</a>
                                                                           </li>
                                                                      </ul>
                                                                 </div>
                                                                 <div class="base-menu-col col-xs-12 col-sm-2 ">












                                                                      <ul class="ul-column ">
                                                                           <li class="menu-item item-header">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/10-laptop-computers" class="submenu-title">Laptop & Computers</a>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/4-apple-ipad" class="submenu-title">Apple Ipad</a>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/23-smart-watch" class="submenu-title">Smart Watch</a>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/5-basic-phones" class="submenu-title">Basic Phones</a>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/6-accessories" class="submenu-title">Accessories</a>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/14-gadgets" class="submenu-title">Gadgets</a>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/19-feature-phones" class="submenu-title">Feature Phones</a>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/25-convertible-laptops" class="submenu-title">Convertible Laptops</a>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/27-ultraportable-laptops" class="submenu-title">Ultraportable Laptops</a>
                                                                           </li>
                                                                      </ul>
                                                                 </div>
                                                                 <div class="base-menu-col col-xs-12 col-sm-4 product-listview product-slider background-gray">






                                                                      <ul class="ul-column menu-product-carousel_1 owl-carousel">
                                                                           <li class="menu-item item-header">
                                                                                <a href="#" class="submenu-title">Featured Products</a>
                                                                           </li>
                                                                           <li class="menu-item item-line product-block owl-item">
                                                                                <article class="product_item product-miniature js-product-miniature">
                                                                                     <div class="products">
                                                                                          <div class="thumbnail-container clearfix">
                                                                                               <div class="baseproduct-image">
                                                                                                    <a class="product_img_link product-thumbnail" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/chargers-cables/1-hummingbird-printed-t-shirt.html" title="New Featured MacBook Pro With Apple M1 Pro Chip">
                                                                                                         <img class="replace-2x img-responsive" src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/244-home_default/hummingbird-printed-t-shirt.jpg" alt="New Featured MacBook Pro With Apple M1 Pro Chip" title="New Featured MacBook Pro With Apple M1 Pro Chip" height="236" width="307" />

                                                                                                    </a>

                                                                                                    <p class="discount-percentage product-flags discount-product">
                                                                                                         <span class="product-flag flash-sale discount">
                                                                                                              <i class="material-icons left">&#xe3e7;</i>
                                                                                                              -10%
                                                                                                         </span>
                                                                                                    </p>


                                                                                               </div>
                                                                                               <div class="baseproduct-desc">
                                                                                                    <div class="product-description">
                                                                                                         <h3 class="product-title">
                                                                                                              <a class="product-name" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/chargers-cables/1-hummingbird-printed-t-shirt.html" title="New Featured MacBook Pro With Apple M1 Pro Chip">
                                                                                                                   New Featured MacBook Pro With Apple M1 Pro Chip
                                                                                                              </a>
                                                                                                         </h3>
                                                                                                         <div class="content_price product-price-and-shipping">
                                                                                                              <span class="price  special-price">
                                                                                                                   $810.00
                                                                                                              </span>
                                                                                                              <span class="old-price regular-price">
                                                                                                                   $900.00
                                                                                                              </span>


                                                                                                         </div>
                                                                                                    </div>
                                                                                               </div>
                                                                                          </div>
                                                                                     </div>
                                                                                </article>
                                                                           </li>
                                                                           <li class="menu-item item-line product-block owl-item">
                                                                                <article class="product_item product-miniature js-product-miniature">
                                                                                     <div class="products">
                                                                                          <div class="thumbnail-container clearfix">
                                                                                               <div class="baseproduct-image">
                                                                                                    <a class="product_img_link product-thumbnail" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/usb-type-cable/2-rumbloo-silicone-controller-grip-cover-for-oculus-quest-2.html" title="Rumbloo Silicone Controller Grip Cover for Oculus Quest 2">
                                                                                                         <img class="replace-2x img-responsive" src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/239-home_default/rumbloo-silicone-controller-grip-cover-for-oculus-quest-2.jpg" alt="Rumbloo Silicone Controller Grip Cover for Oculus Quest 2" title="Rumbloo Silicone Controller Grip Cover for Oculus Quest 2" height="236" width="307" />

                                                                                                    </a>

                                                                                                    <p class="discount-percentage product-flags discount-product">
                                                                                                         <span class="product-flag flash-sale discount">
                                                                                                              <i class="material-icons left">&#xe3e7;</i>
                                                                                                              -15%
                                                                                                         </span>
                                                                                                    </p>


                                                                                               </div>
                                                                                               <div class="baseproduct-desc">
                                                                                                    <div class="product-description">
                                                                                                         <h3 class="product-title">
                                                                                                              <a class="product-name" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/usb-type-cable/2-rumbloo-silicone-controller-grip-cover-for-oculus-quest-2.html" title="Rumbloo Silicone Controller Grip Cover for Oculus Quest 2">
                                                                                                                   Rumbloo Silicone Controller Grip Cover for Oculus Quest 2
                                                                                                              </a>
                                                                                                         </h3>
                                                                                                         <div class="content_price product-price-and-shipping">
                                                                                                              <span class="price  special-price">
                                                                                                                   $102.00
                                                                                                              </span>
                                                                                                              <span class="old-price regular-price">
                                                                                                                   $120.00
                                                                                                              </span>


                                                                                                         </div>
                                                                                                    </div>
                                                                                               </div>
                                                                                          </div>
                                                                                     </div>
                                                                                </article>
                                                                           </li>
                                                                           <li class="menu-item item-line product-block owl-item">
                                                                                <article class="product_item product-miniature js-product-miniature">
                                                                                     <div class="products">
                                                                                          <div class="thumbnail-container clearfix">
                                                                                               <div class="baseproduct-image">
                                                                                                    <a class="product_img_link product-thumbnail" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/3-the-best-is-yet-to-come-framed-poster.html" title="The best is yet to come&#039; Framed poster">
                                                                                                         <img class="replace-2x img-responsive" src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/222-home_default/the-best-is-yet-to-come-framed-poster.jpg" alt="The best is yet to come&#039; Framed poster" title="The best is yet to come&#039; Framed poster" height="236" width="307" />

                                                                                                    </a>



                                                                                               </div>
                                                                                               <div class="baseproduct-desc">
                                                                                                    <div class="product-description">
                                                                                                         <h3 class="product-title">
                                                                                                              <a class="product-name" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/3-the-best-is-yet-to-come-framed-poster.html" title="The best is yet to come&#039; Framed poster">
                                                                                                                   The best is yet to come&#039; Framed poster
                                                                                                              </a>
                                                                                                         </h3>
                                                                                                         <div class="content_price product-price-and-shipping">
                                                                                                              <span class="price ">
                                                                                                                   $99.00
                                                                                                              </span>


                                                                                                         </div>
                                                                                                    </div>
                                                                                               </div>
                                                                                          </div>
                                                                                     </div>
                                                                                </article>
                                                                           </li>
                                                                           <li class="menu-item item-line product-block owl-item">
                                                                                <article class="product_item product-miniature js-product-miniature">
                                                                                     <div class="products">
                                                                                          <div class="thumbnail-container clearfix">
                                                                                               <div class="baseproduct-image">
                                                                                                    <a class="product_img_link product-thumbnail" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/4-samsung-qn85aa-series-neo-qled-4k-uhd-smart-tv.html" title="Samsung QN85AA Series Neo QLED 4K UHD Smart TV">
                                                                                                         <img class="replace-2x img-responsive" src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/216-home_default/samsung-qn85aa-series-neo-qled-4k-uhd-smart-tv.jpg" alt="Samsung QN85AA Series Neo QLED 4K UHD Smart TV" title="Samsung QN85AA Series Neo QLED 4K UHD Smart TV" height="236" width="307" />

                                                                                                    </a>



                                                                                               </div>
                                                                                               <div class="baseproduct-desc">
                                                                                                    <div class="product-description">
                                                                                                         <h3 class="product-title">
                                                                                                              <a class="product-name" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/4-samsung-qn85aa-series-neo-qled-4k-uhd-smart-tv.html" title="Samsung QN85AA Series Neo QLED 4K UHD Smart TV">
                                                                                                                   Samsung QN85AA Series Neo QLED 4K UHD Smart TV
                                                                                                              </a>
                                                                                                         </h3>
                                                                                                         <div class="content_price product-price-and-shipping">
                                                                                                              <span class="price ">
                                                                                                                   $560.00
                                                                                                              </span>


                                                                                                         </div>
                                                                                                    </div>
                                                                                               </div>
                                                                                          </div>
                                                                                     </div>
                                                                                </article>
                                                                           </li>
                                                                      </ul>
                                                                 </div>
                                                                 <div class="base-menu-col col-xs-12 col-sm-4 customhtml">




                                                                      <ul class="ul-column ">
                                                                           <li class="menu-item item-line ">
                                                                                <div class="html-block">
                                                                                     <div><img src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/cms/menu-banner.jpg" width="490" height="282" /></div>
                                                                                     <div class="menu-banner-html">
                                                                                          <div class="main-title">Weekend Discount <br />Latest Phones</div>
                                                                                          <div class="offer-title">From $199.00</div>
                                                                                          <div class="shopnow"><a class="btn shopnow-link" href="#">Shop Now</a></div>
                                                                                     </div>
                                                                                </div>
                                                                           </li>
                                                                      </ul>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                  </li>

                                                  <li class="level-1 label-info parent">
                                                       <a href="#" class="baseinnermenu">
                                                            <span class="material-icons base-left-arrow">arrow_forward</span>
                                                            <span class="catagory">Categories</span> <i class="material-icons expand-more">&#xe313;</i>
                                                            <div class="menu-subtitle">Hot</div>
                                                       </a>

                                                       <span data-target="#top_sub_menu_34368" data-toggle="collapse" class="navbar-toggler collapse-icons">
                                                            <i class="material-icons add">&#xe145;</i>
                                                            <i class="material-icons remove">&#xE15B;</i>
                                                       </span>

                                                       <div class="base-sub-menu menu-dropdown col-xs-12 col-sm-12 base-sub-left" id="top_sub_menu_34368">

                                                            <div class="base-menu-row ">

                                                                 <div class="base-menu-col col-xs-12 col-sm-2 ">













                                                                      <ul class="ul-column ">
                                                                           <li class="menu-item item-header">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/11-chargers-cables" class="submenu-title">Chargers & Cables</a>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/29-adapter-plug" class="submenu-title">Adapter Plug</a>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/30-bettery-chargers" class="submenu-title">Bettery Chargers</a>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/31-usb-type-cable" class="submenu-title">USB Type Cable</a>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/32-usb-c-charger" class="submenu-title">USB-C Charger</a>
                                                                           </li>
                                                                           <li class="menu-item item-header">
                                                                                <a href="#" class="submenu-title">Products</a>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/best-sellers" class="submenu-title">Best sellers</a>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/new-products" class="submenu-title">New products</a>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/prices-drop" class="submenu-title">Prices drop</a>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/sitemap" class="submenu-title">Sitemap</a>
                                                                           </li>
                                                                      </ul>
                                                                 </div>
                                                                 <div class="base-menu-col col-xs-12 col-sm-2 ">













                                                                      <ul class="ul-column ">
                                                                           <li class="menu-item item-header">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/7-tv-speaker" class="submenu-title">TV & Speaker</a>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/15-home-theatre-systems" class="submenu-title">Home Theatre Systems</a>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/16-party-speakers" class="submenu-title">Party Speakers</a>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/17-android-tv" class="submenu-title">Android TV</a>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/18-tv-audio-accessories" class="submenu-title">TV & Audio Accessories</a>
                                                                           </li>
                                                                           <li class="menu-item item-header">
                                                                                <a href="#" class="submenu-title">Pages</a>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/content/2-legal-notice" class="submenu-title">Legal Notice</a>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/contact-us" class="submenu-title">Contact us</a>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/content/5-secure-payment" class="submenu-title">Secure payment</a>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/content/1-delivery" class="submenu-title">Delivery</a>
                                                                           </li>
                                                                      </ul>
                                                                 </div>
                                                                 <div class="base-menu-col col-xs-12 col-sm-4 menu-category">











                                                                      <ul class="ul-column ">
                                                                           <li class="menu-item item-line ">
                                                                                <div class="html-block">
                                                                                     <div class="categorylist">
                                                                                          <div class="cate-image"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/14-gadgets"><img src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/cms/menu-category/cat-1.jpg" /></a>
                                                                                               <div class="cate-heading"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/14-gadgets">Gadgets</a></div>
                                                                                          </div>
                                                                                     </div>
                                                                                </div>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <div class="html-block">
                                                                                     <div class="categorylist">
                                                                                          <div class="cate-image"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/23-smart-watch"><img src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/cms/menu-category/cat-2.jpg" /></a>
                                                                                               <div class="cate-heading"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/23-smart-watch">Smart Watch</a></div>
                                                                                          </div>
                                                                                     </div>
                                                                                </div>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <div class="html-block">
                                                                                     <div class="categorylist">
                                                                                          <div class="cate-image"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/22-headphone"><img src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/cms/menu-category/cat-3.jpg" /></a>
                                                                                               <div class="cate-heading"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/22-headphone">Headphone</a></div>
                                                                                          </div>
                                                                                     </div>
                                                                                </div>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <div class="html-block">
                                                                                     <div class="categorylist">
                                                                                          <div class="cate-image"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/20-smart-phones"><img src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/cms/menu-category/cat-4.jpg" /></a>
                                                                                               <div class="cate-heading"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/20-smart-phones">Smart Phones</a></div>
                                                                                          </div>
                                                                                     </div>
                                                                                </div>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <div class="html-block">
                                                                                     <div class="categorylist">
                                                                                          <div class="cate-image"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/8-macbook"><img src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/cms/menu-category/cat-5.jpg" /></a>
                                                                                               <div class="cate-heading"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/8-macbook">MacBook</a></div>
                                                                                          </div>
                                                                                     </div>
                                                                                </div>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <div class="html-block">
                                                                                     <div class="categorylist">
                                                                                          <div class="cate-image"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/13-earbuds-bose"><img src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/cms/menu-category/cat-6.jpg" /></a>
                                                                                               <div class="cate-heading"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/13-earbuds-bose">Earbuds Bose</a></div>
                                                                                          </div>
                                                                                     </div>
                                                                                </div>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <div class="html-block">
                                                                                     <div class="categorylist">
                                                                                          <div class="cate-image"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/24-smart-speakers"><img src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/cms/menu-category/cat-7.jpg" /></a>
                                                                                               <div class="cate-heading"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/24-smart-speakers">Smart Speakers</a></div>
                                                                                          </div>
                                                                                     </div>
                                                                                </div>
                                                                           </li>
                                                                           <li class="menu-item item-line ">
                                                                                <div class="html-block">
                                                                                     <div class="categorylist">
                                                                                          <div class="cate-image"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/6-accessories"><img src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/img/cms/menu-category/cat-8.jpg" /></a>
                                                                                               <div class="cate-heading"><a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/6-accessories">Accessories</a></div>
                                                                                          </div>
                                                                                     </div>
                                                                                </div>
                                                                           </li>
                                                                      </ul>
                                                                 </div>
                                                                 <div class="base-menu-col col-xs-12 col-sm-4 product-listview product-slider background-gray">





                                                                      <ul class="ul-column menu-product-carousel_2 owl-carousel">
                                                                           <li class="menu-item item-line product-block owl-item">
                                                                                <article class="product_item product-miniature js-product-miniature">
                                                                                     <div class="products">
                                                                                          <div class="thumbnail-container clearfix">
                                                                                               <div class="baseproduct-image">
                                                                                                    <a class="product_img_link product-thumbnail" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/convertible-laptops/7-oneplus-nord-2r-wireless-earbuds-with-dual-mic.html" title="OnePlus Nord 2r Wireless Earbuds with Dual Mic">
                                                                                                         <img class="replace-2x img-responsive" src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/187-home_default/oneplus-nord-2r-wireless-earbuds-with-dual-mic.jpg" alt="OnePlus Nord 2r Wireless Earbuds with Dual Mic" title="OnePlus Nord 2r Wireless Earbuds with Dual Mic" height="236" width="307" />

                                                                                                    </a>

                                                                                                    <p class="discount-percentage product-flags discount-product">
                                                                                                         <span class="product-flag flash-sale discount">
                                                                                                              <i class="material-icons left">&#xe3e7;</i>
                                                                                                              -5
                                                                                                         </span>
                                                                                                    </p>


                                                                                               </div>
                                                                                               <div class="baseproduct-desc">
                                                                                                    <div class="product-description">
                                                                                                         <h3 class="product-title">
                                                                                                              <a class="product-name" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/convertible-laptops/7-oneplus-nord-2r-wireless-earbuds-with-dual-mic.html" title="OnePlus Nord 2r Wireless Earbuds with Dual Mic">
                                                                                                                   OnePlus Nord 2r Wireless Earbuds with Dual Mic
                                                                                                              </a>
                                                                                                         </h3>
                                                                                                         <div class="content_price product-price-and-shipping">
                                                                                                              <span class="price  special-price">
                                                                                                                   $32.00
                                                                                                              </span>
                                                                                                              <span class="old-price regular-price">
                                                                                                                   $37.00
                                                                                                              </span>


                                                                                                         </div>
                                                                                                    </div>
                                                                                               </div>
                                                                                          </div>
                                                                                     </div>
                                                                                </article>
                                                                           </li>
                                                                           <li class="menu-item item-line product-block owl-item">
                                                                                <article class="product_item product-miniature js-product-miniature">
                                                                                     <div class="products">
                                                                                          <div class="thumbnail-container clearfix">
                                                                                               <div class="baseproduct-image">
                                                                                                    <a class="product_img_link product-thumbnail" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/bettery-chargers/8-hp-smart-tank-all-in-one-wifi-colour-printer.html" title="HP Smart Tank All-in-one WiFi Colour Printer">
                                                                                                         <img class="replace-2x img-responsive" src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/180-home_default/hp-smart-tank-all-in-one-wifi-colour-printer.jpg" alt="HP Smart Tank All-in-one WiFi Colour Printer" title="HP Smart Tank All-in-one WiFi Colour Printer" height="236" width="307" />

                                                                                                    </a>



                                                                                               </div>
                                                                                               <div class="baseproduct-desc">
                                                                                                    <div class="product-description">
                                                                                                         <h3 class="product-title">
                                                                                                              <a class="product-name" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/bettery-chargers/8-hp-smart-tank-all-in-one-wifi-colour-printer.html" title="HP Smart Tank All-in-one WiFi Colour Printer">
                                                                                                                   HP Smart Tank All-in-one WiFi Colour Printer
                                                                                                              </a>
                                                                                                         </h3>
                                                                                                         <div class="content_price product-price-and-shipping">
                                                                                                              <span class="price ">
                                                                                                                   $225.00
                                                                                                              </span>


                                                                                                         </div>
                                                                                                    </div>
                                                                                               </div>
                                                                                          </div>
                                                                                     </div>
                                                                                </article>
                                                                           </li>
                                                                           <li class="menu-item item-line product-block owl-item">
                                                                                <article class="product_item product-miniature js-product-miniature">
                                                                                     <div class="products">
                                                                                          <div class="thumbnail-container clearfix">
                                                                                               <div class="baseproduct-image">
                                                                                                    <a class="product_img_link product-thumbnail" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/usb-c-charger/9-lg-8-kg-fully-automatic-top-load-washing-machine.html" title="LG 8 kg Fully Automatic Top Load Washing Machine">
                                                                                                         <img class="replace-2x img-responsive" src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/175-home_default/lg-8-kg-fully-automatic-top-load-washing-machine.jpg" alt="LG 8 kg Fully Automatic Top Load Washing Machine" title="LG 8 kg Fully Automatic Top Load Washing Machine" height="236" width="307" />

                                                                                                    </a>



                                                                                               </div>
                                                                                               <div class="baseproduct-desc">
                                                                                                    <div class="product-description">
                                                                                                         <h3 class="product-title">
                                                                                                              <a class="product-name" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/usb-c-charger/9-lg-8-kg-fully-automatic-top-load-washing-machine.html" title="LG 8 kg Fully Automatic Top Load Washing Machine">
                                                                                                                   LG 8 kg Fully Automatic Top Load Washing Machine
                                                                                                              </a>
                                                                                                         </h3>
                                                                                                         <div class="content_price product-price-and-shipping">
                                                                                                              <span class="price ">
                                                                                                                   $230.00
                                                                                                              </span>


                                                                                                         </div>
                                                                                                    </div>
                                                                                               </div>
                                                                                          </div>
                                                                                     </div>
                                                                                </article>
                                                                           </li>
                                                                           <li class="menu-item item-line product-block owl-item">
                                                                                <article class="product_item product-miniature js-product-miniature">
                                                                                     <div class="products">
                                                                                          <div class="thumbnail-container clearfix">
                                                                                               <div class="baseproduct-image">
                                                                                                    <a class="product_img_link product-thumbnail" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/chargers-cables/10-noise-colorfit-ultra-3-bluetooth-calling-smart-watch.html" title="Noise ColorFit Ultra 3 Bluetooth Calling Smart Watch">
                                                                                                         <img class="replace-2x img-responsive" src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/170-home_default/noise-colorfit-ultra-3-bluetooth-calling-smart-watch.jpg" alt="Noise ColorFit Ultra 3 Bluetooth Calling Smart Watch" title="Noise ColorFit Ultra 3 Bluetooth Calling Smart Watch" height="236" width="307" />

                                                                                                    </a>



                                                                                               </div>
                                                                                               <div class="baseproduct-desc">
                                                                                                    <div class="product-description">
                                                                                                         <h3 class="product-title">
                                                                                                              <a class="product-name" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/chargers-cables/10-noise-colorfit-ultra-3-bluetooth-calling-smart-watch.html" title="Noise ColorFit Ultra 3 Bluetooth Calling Smart Watch">
                                                                                                                   Noise ColorFit Ultra 3 Bluetooth Calling Smart Watch
                                                                                                              </a>
                                                                                                         </h3>
                                                                                                         <div class="content_price product-price-and-shipping">
                                                                                                              <span class="price ">
                                                                                                                   $78.00
                                                                                                              </span>


                                                                                                         </div>
                                                                                                    </div>
                                                                                               </div>
                                                                                          </div>
                                                                                     </div>
                                                                                </article>
                                                                           </li>
                                                                           <li class="menu-item item-line product-block owl-item">
                                                                                <article class="product_item product-miniature js-product-miniature">
                                                                                     <div class="products">
                                                                                          <div class="thumbnail-container clearfix">
                                                                                               <div class="baseproduct-image">
                                                                                                    <a class="product_img_link product-thumbnail" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/gadgets/11-iphone-13-128gb-pink-unlocked-premium.html" title="iPhone 13, 128GB, Pink - Unlocked Premium">
                                                                                                         <img class="replace-2x img-responsive" src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/160-home_default/iphone-13-128gb-pink-unlocked-premium.jpg" alt="iPhone 13, 128GB, Pink - Unlocked Premium" title="iPhone 13, 128GB, Pink - Unlocked Premium" height="236" width="307" />

                                                                                                    </a>

                                                                                                    <p class="discount-percentage product-flags discount-product">
                                                                                                         <span class="product-flag flash-sale discount">
                                                                                                              <i class="material-icons left">&#xe3e7;</i>
                                                                                                              -6
                                                                                                         </span>
                                                                                                    </p>


                                                                                               </div>
                                                                                               <div class="baseproduct-desc">
                                                                                                    <div class="product-description">
                                                                                                         <h3 class="product-title">
                                                                                                              <a class="product-name" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/gadgets/11-iphone-13-128gb-pink-unlocked-premium.html" title="iPhone 13, 128GB, Pink - Unlocked Premium">
                                                                                                                   iPhone 13, 128GB, Pink - Unlocked Premium
                                                                                                              </a>
                                                                                                         </h3>
                                                                                                         <div class="content_price product-price-and-shipping">
                                                                                                              <span class="price  special-price">
                                                                                                                   $194.00
                                                                                                              </span>
                                                                                                              <span class="old-price regular-price">
                                                                                                                   $200.00
                                                                                                              </span>


                                                                                                         </div>
                                                                                                    </div>
                                                                                               </div>
                                                                                          </div>
                                                                                     </div>
                                                                                </article>
                                                                           </li>
                                                                           <li class="menu-item item-line product-block owl-item">
                                                                                <article class="product_item product-miniature js-product-miniature">
                                                                                     <div class="products">
                                                                                          <div class="thumbnail-container clearfix">
                                                                                               <div class="baseproduct-image">
                                                                                                    <a class="product_img_link product-thumbnail" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/12-momentum-2k-indoor-security-camera-for-home.html" title="MOMENTUM 2K Indoor Security Camera for Home">
                                                                                                         <img class="replace-2x img-responsive" src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/154-home_default/momentum-2k-indoor-security-camera-for-home.jpg" alt="MOMENTUM 2K Indoor Security Camera for Home" title="MOMENTUM 2K Indoor Security Camera for Home" height="236" width="307" />

                                                                                                    </a>



                                                                                               </div>
                                                                                               <div class="baseproduct-desc">
                                                                                                    <div class="product-description">
                                                                                                         <h3 class="product-title">
                                                                                                              <a class="product-name" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/12-momentum-2k-indoor-security-camera-for-home.html" title="MOMENTUM 2K Indoor Security Camera for Home">
                                                                                                                   MOMENTUM 2K Indoor Security Camera for Home
                                                                                                              </a>
                                                                                                         </h3>
                                                                                                         <div class="content_price product-price-and-shipping">
                                                                                                              <span class="price ">
                                                                                                                   $190.00
                                                                                                              </span>


                                                                                                         </div>
                                                                                                    </div>
                                                                                               </div>
                                                                                          </div>
                                                                                     </div>
                                                                                </article>
                                                                           </li>
                                                                      </ul>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                  </li>
                                                  <li class="level-1 parent show-subcategories "><a class="baseinnermenu" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/6-accessories"><span class="catagory">Accessories</span><i class="material-icons expand-more">&#xe313;</i></a><span data-target="#cat-drop-menu_6" data-toggle="collapse" class="navbar-toggler collapse-icons">
                                                            <i class="material-icons add">&#xe145;</i>
                                                            <i class="material-icons remove">&#xE15B;</i>
                                                       </span>
                                                       <ul id="cat-drop-menu_6" class="menu-dropdown cat-drop-menu base-sub-auto">
                                                            <li class="level-2 parent  "><a class="baseinnermenu" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/7-tv-speaker"><span class="catagory">TV & Speaker</span><i class="material-icons expand-more">&#xe313;</i></a><span data-target="#cat-drop-menu_7" data-toggle="collapse" class="navbar-toggler collapse-icons">
                                                                      <i class="material-icons add">&#xe145;</i>
                                                                      <i class="material-icons remove">&#xE15B;</i>
                                                                 </span>
                                                                 <ul id="cat-drop-menu_7" class="menu-dropdown cat-drop-menu ">
                                                                      <li class="level-3  "><a class="baseinnermenu" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/15-home-theatre-systems"><span class="catagory">Home Theatre Systems</span></a></li>
                                                                      <li class="level-3  "><a class="baseinnermenu" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/16-party-speakers"><span class="catagory">Party Speakers</span></a></li>
                                                                      <li class="level-3  "><a class="baseinnermenu" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/17-android-tv"><span class="catagory">Android TV</span></a></li>
                                                                      <li class="level-3  "><a class="baseinnermenu" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/18-tv-audio-accessories"><span class="catagory">TV & Audio Accessories</span></a></li>
                                                                 </ul>
                                                            </li>
                                                            <li class="level-2  "><a class="baseinnermenu" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/8-macbook"><span class="catagory">MacBook</span></a></li>
                                                            <li class="level-2  "><a class="baseinnermenu" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/12-wireless-printer"><span class="catagory">Wireless Printer</span></a></li>
                                                            <li class="level-2  "><a class="baseinnermenu" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/13-earbuds-bose"><span class="catagory">Earbuds Bose</span></a></li>
                                                            <li class="level-2  "><a class="baseinnermenu" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/14-gadgets"><span class="catagory">Gadgets</span></a></li>
                                                       </ul>
                                                  </li>

                                                  <li class="level-1 label-success parent">
                                                       <a href="#" class="baseinnermenu">
                                                            <span class="material-icons base-left-arrow">arrow_forward</span>
                                                            <span class="catagory">Products</span> <i class="material-icons expand-more">&#xe313;</i>
                                                            <div class="menu-subtitle">New</div>
                                                       </a>

                                                       <span data-target="#top_sub_menu_47333" data-toggle="collapse" class="navbar-toggler collapse-icons">
                                                            <i class="material-icons add">&#xe145;</i>
                                                            <i class="material-icons remove">&#xE15B;</i>
                                                       </span>

                                                       <div class="base-sub-menu menu-dropdown col-xs-12 col-sm-12 base-sub-auto" id="top_sub_menu_47333">

                                                            <div class="base-menu-row product-main-slider">

                                                                 <div class="base-menu-col col-xs-12 col-sm-2 htmlblock-background">




                                                                      <ul class="ul-column ">
                                                                           <li class="menu-item item-line ">
                                                                                <div class="html-block">
                                                                                     <div class="custom-text-html">
                                                                                          <div class="main-title">New Arrivals 2024</div>
                                                                                          <div class="detail">Fully drag and drop mega menu content. Put any amazing HTML content here. Fully drag and drop menu content.</div>
                                                                                          <a class="btn shopnow-link" href="#">Shop Now</a>
                                                                                     </div>
                                                                                </div>
                                                                           </li>
                                                                      </ul>
                                                                 </div>
                                                                 <div class="base-menu-col col-xs-12 col-sm-10 ">





                                                                      <ul class="ul-column menu-product-carousel_3 owl-carousel">
                                                                           <li class="menu-item item-line product-block owl-item">
                                                                                <article class="product_item product-miniature js-product-miniature">
                                                                                     <div class="products">
                                                                                          <div class="thumbnail-container clearfix">
                                                                                               <div class="baseproduct-image">
                                                                                                    <a class="product_img_link product-thumbnail" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/headphone/13-beats-by-dr-dre-pro-over-the-ear-headphones.html" title="Beats by Dr. Dre Pro Over the Ear Headphones">
                                                                                                         <img class="replace-2x img-responsive" src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/144-home_default/beats-by-dr-dre-pro-over-the-ear-headphones.jpg" alt="Beats by Dr. Dre Pro Over the Ear Headphones" title="Beats by Dr. Dre Pro Over the Ear Headphones" height="236" width="307" />

                                                                                                    </a>

                                                                                                    <p class="discount-percentage product-flags discount-product">
                                                                                                         <span class="product-flag flash-sale discount">
                                                                                                              <i class="material-icons left">&#xe3e7;</i>
                                                                                                              -15%
                                                                                                         </span>
                                                                                                    </p>


                                                                                               </div>
                                                                                               <div class="baseproduct-desc">
                                                                                                    <div class="product-description">
                                                                                                         <h3 class="product-title">
                                                                                                              <a class="product-name" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/headphone/13-beats-by-dr-dre-pro-over-the-ear-headphones.html" title="Beats by Dr. Dre Pro Over the Ear Headphones">
                                                                                                                   Beats by Dr. Dre Pro Over the Ear Headphones
                                                                                                              </a>
                                                                                                         </h3>
                                                                                                         <div class="content_price product-price-and-shipping">
                                                                                                              <span class="price  special-price">
                                                                                                                   $50.15
                                                                                                              </span>
                                                                                                              <span class="old-price regular-price">
                                                                                                                   $59.00
                                                                                                              </span>


                                                                                                         </div>
                                                                                                    </div>
                                                                                               </div>
                                                                                          </div>
                                                                                     </div>
                                                                                </article>
                                                                           </li>
                                                                           <li class="menu-item item-line product-block owl-item">
                                                                                <article class="product_item product-miniature js-product-miniature">
                                                                                     <div class="products">
                                                                                          <div class="thumbnail-container clearfix">
                                                                                               <div class="baseproduct-image">
                                                                                                    <a class="product_img_link product-thumbnail" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/14-insta360-go-3-small-lightweight-action-camera.html" title="Insta360 GO 3 – Small &amp; Lightweight Action Camera">
                                                                                                         <img class="replace-2x img-responsive" src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/138-home_default/insta360-go-3-small-lightweight-action-camera.jpg" alt="Insta360 GO 3 – Small &amp; Lightweight Action Camera" title="Insta360 GO 3 – Small &amp; Lightweight Action Camera" height="236" width="307" />

                                                                                                    </a>



                                                                                               </div>
                                                                                               <div class="baseproduct-desc">
                                                                                                    <div class="product-description">
                                                                                                         <h3 class="product-title">
                                                                                                              <a class="product-name" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/smart-devices/14-insta360-go-3-small-lightweight-action-camera.html" title="Insta360 GO 3 – Small &amp; Lightweight Action Camera">
                                                                                                                   Insta360 GO 3 – Small &amp; Lightweight Action Camera
                                                                                                              </a>
                                                                                                         </h3>
                                                                                                         <div class="content_price product-price-and-shipping">
                                                                                                              <span class="price ">
                                                                                                                   $100.00
                                                                                                              </span>


                                                                                                         </div>
                                                                                                    </div>
                                                                                               </div>
                                                                                          </div>
                                                                                     </div>
                                                                                </article>
                                                                           </li>
                                                                           <li class="menu-item item-line product-block owl-item">
                                                                                <article class="product_item product-miniature js-product-miniature">
                                                                                     <div class="products">
                                                                                          <div class="thumbnail-container clearfix">
                                                                                               <div class="baseproduct-image">
                                                                                                    <a class="product_img_link product-thumbnail" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/tv-audio-accessories/15-latest-4k-full-hdr-smart-mi-tv-1388-cm.html" title="Latest 4K Full HDR Smart Mi TV 138.8 Cm">
                                                                                                         <img class="replace-2x img-responsive" src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/131-home_default/latest-4k-full-hdr-smart-mi-tv-1388-cm.jpg" alt="Latest 4K Full HDR Smart Mi TV 138.8 Cm" title="Latest 4K Full HDR Smart Mi TV 138.8 Cm" height="236" width="307" />

                                                                                                    </a>



                                                                                               </div>
                                                                                               <div class="baseproduct-desc">
                                                                                                    <div class="product-description">
                                                                                                         <h3 class="product-title">
                                                                                                              <a class="product-name" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/tv-audio-accessories/15-latest-4k-full-hdr-smart-mi-tv-1388-cm.html" title="Latest 4K Full HDR Smart Mi TV 138.8 Cm">
                                                                                                                   Latest 4K Full HDR Smart Mi TV 138.8 Cm
                                                                                                              </a>
                                                                                                         </h3>
                                                                                                         <div class="content_price product-price-and-shipping">
                                                                                                              <span class="price ">
                                                                                                                   $190.00
                                                                                                              </span>


                                                                                                         </div>
                                                                                                    </div>
                                                                                               </div>
                                                                                          </div>
                                                                                     </div>
                                                                                </article>
                                                                           </li>
                                                                           <li class="menu-item item-line product-block owl-item">
                                                                                <article class="product_item product-miniature js-product-miniature">
                                                                                     <div class="products">
                                                                                          <div class="thumbnail-container clearfix">
                                                                                               <div class="baseproduct-image">
                                                                                                    <a class="product_img_link product-thumbnail" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/home-theatre-systems/16-apple-macbook-air-133-with-retina-display.html" title="Apple MacBook Air 13.3&quot; With Retina Display">
                                                                                                         <img class="replace-2x img-responsive" src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/119-home_default/apple-macbook-air-133-with-retina-display.jpg" alt="Apple MacBook Air 13.3&quot; With Retina Display" title="Apple MacBook Air 13.3&quot; With Retina Display" height="236" width="307" />

                                                                                                    </a>

                                                                                                    <p class="discount-percentage product-flags discount-product">
                                                                                                         <span class="product-flag flash-sale discount">
                                                                                                              <i class="material-icons left">&#xe3e7;</i>
                                                                                                              -12%
                                                                                                         </span>
                                                                                                    </p>


                                                                                               </div>
                                                                                               <div class="baseproduct-desc">
                                                                                                    <div class="product-description">
                                                                                                         <h3 class="product-title">
                                                                                                              <a class="product-name" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/home-theatre-systems/16-apple-macbook-air-133-with-retina-display.html" title="Apple MacBook Air 13.3&quot; With Retina Display">
                                                                                                                   Apple MacBook Air 13.3&quot; With Retina Display
                                                                                                              </a>
                                                                                                         </h3>
                                                                                                         <div class="content_price product-price-and-shipping">
                                                                                                              <span class="price  special-price">
                                                                                                                   $772.64
                                                                                                              </span>
                                                                                                              <span class="old-price regular-price">
                                                                                                                   $878.00
                                                                                                              </span>


                                                                                                         </div>
                                                                                                    </div>
                                                                                               </div>
                                                                                          </div>
                                                                                     </div>
                                                                                </article>
                                                                           </li>
                                                                           <li class="menu-item item-line product-block owl-item">
                                                                                <article class="product_item product-miniature js-product-miniature">
                                                                                     <div class="products">
                                                                                          <div class="thumbnail-container clearfix">
                                                                                               <div class="baseproduct-image">
                                                                                                    <a class="product_img_link product-thumbnail" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/tv-speaker/17-google-pixel-buds-pro-noise-canceling-earbuds.html" title="Google Pixel Buds Pro - Noise Canceling Earbuds">
                                                                                                         <img class="replace-2x img-responsive" src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/101-home_default/google-pixel-buds-pro-noise-canceling-earbuds.jpg" alt="Google Pixel Buds Pro - Noise Canceling Earbuds" title="Google Pixel Buds Pro - Noise Canceling Earbuds" height="236" width="307" />

                                                                                                    </a>



                                                                                               </div>
                                                                                               <div class="baseproduct-desc">
                                                                                                    <div class="product-description">
                                                                                                         <h3 class="product-title">
                                                                                                              <a class="product-name" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/tv-speaker/17-google-pixel-buds-pro-noise-canceling-earbuds.html" title="Google Pixel Buds Pro - Noise Canceling Earbuds">
                                                                                                                   Google Pixel Buds Pro - Noise Canceling Earbuds
                                                                                                              </a>
                                                                                                         </h3>
                                                                                                         <div class="content_price product-price-and-shipping">
                                                                                                              <span class="price ">
                                                                                                                   $45.00
                                                                                                              </span>


                                                                                                         </div>
                                                                                                    </div>
                                                                                               </div>
                                                                                          </div>
                                                                                     </div>
                                                                                </article>
                                                                           </li>
                                                                           <li class="menu-item item-line product-block owl-item">
                                                                                <article class="product_item product-miniature js-product-miniature">
                                                                                     <div class="products">
                                                                                          <div class="thumbnail-container clearfix">
                                                                                               <div class="baseproduct-image">
                                                                                                    <a class="product_img_link product-thumbnail" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/wireless-printer/18-redmi-pad-4-gb-ram-128-gb-rom-1061-inch-tablet.html" title="REDMI Pad 4 GB RAM 128 GB ROM 10.61 Inch Tablet">
                                                                                                         <img class="replace-2x img-responsive" src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/92-home_default/redmi-pad-4-gb-ram-128-gb-rom-1061-inch-tablet.jpg" alt="REDMI Pad 4 GB RAM 128 GB ROM 10.61 Inch Tablet" title="REDMI Pad 4 GB RAM 128 GB ROM 10.61 Inch Tablet" height="236" width="307" />

                                                                                                    </a>



                                                                                               </div>
                                                                                               <div class="baseproduct-desc">
                                                                                                    <div class="product-description">
                                                                                                         <h3 class="product-title">
                                                                                                              <a class="product-name" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/wireless-printer/18-redmi-pad-4-gb-ram-128-gb-rom-1061-inch-tablet.html" title="REDMI Pad 4 GB RAM 128 GB ROM 10.61 Inch Tablet">
                                                                                                                   REDMI Pad 4 GB RAM 128 GB ROM 10.61 Inch Tablet
                                                                                                              </a>
                                                                                                         </h3>
                                                                                                         <div class="content_price product-price-and-shipping">
                                                                                                              <span class="price ">
                                                                                                                   $100.00
                                                                                                              </span>


                                                                                                         </div>
                                                                                                    </div>
                                                                                               </div>
                                                                                          </div>
                                                                                     </div>
                                                                                </article>
                                                                           </li>
                                                                           <li class="menu-item item-line product-block owl-item">
                                                                                <article class="product_item product-miniature js-product-miniature">
                                                                                     <div class="products">
                                                                                          <div class="thumbnail-container clearfix">
                                                                                               <div class="baseproduct-image">
                                                                                                    <a class="product_img_link product-thumbnail" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/macbook/19-hp-spectre-x360-14-2-in-1-laptop-100-rgb.html" title="HP Spectre X360 14 2-in-1 Laptop 100% RGB">
                                                                                                         <img class="replace-2x img-responsive" src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/85-home_default/hp-spectre-x360-14-2-in-1-laptop-100-rgb.jpg" alt="HP Spectre X360 14 2-in-1 Laptop 100% RGB" title="HP Spectre X360 14 2-in-1 Laptop 100% RGB" height="236" width="307" />

                                                                                                    </a>



                                                                                               </div>
                                                                                               <div class="baseproduct-desc">
                                                                                                    <div class="product-description">
                                                                                                         <h3 class="product-title">
                                                                                                              <a class="product-name" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/macbook/19-hp-spectre-x360-14-2-in-1-laptop-100-rgb.html" title="HP Spectre X360 14 2-in-1 Laptop 100% RGB">
                                                                                                                   HP Spectre X360 14 2-in-1 Laptop 100% RGB
                                                                                                              </a>
                                                                                                         </h3>
                                                                                                         <div class="content_price product-price-and-shipping">
                                                                                                              <span class="price ">
                                                                                                                   $880.00
                                                                                                              </span>


                                                                                                         </div>
                                                                                                    </div>
                                                                                               </div>
                                                                                          </div>
                                                                                     </div>
                                                                                </article>
                                                                           </li>
                                                                           <li class="menu-item item-line product-block owl-item">
                                                                                <article class="product_item product-miniature js-product-miniature">
                                                                                     <div class="products">
                                                                                          <div class="thumbnail-container clearfix">
                                                                                               <div class="baseproduct-image">
                                                                                                    <a class="product_img_link product-thumbnail" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/macbook/20-google-home-smart-home-speaker-google-assistant.html" title="Google Home - Smart Home Speaker Google Assistant">
                                                                                                         <img class="replace-2x img-responsive" src="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/80-home_default/google-home-smart-home-speaker-google-assistant.jpg" alt="Google Home - Smart Home Speaker Google Assistant" title="Google Home - Smart Home Speaker Google Assistant" height="236" width="307" />

                                                                                                    </a>



                                                                                               </div>
                                                                                               <div class="baseproduct-desc">
                                                                                                    <div class="product-description">
                                                                                                         <h3 class="product-title">
                                                                                                              <a class="product-name" href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/macbook/20-google-home-smart-home-speaker-google-assistant.html" title="Google Home - Smart Home Speaker Google Assistant">
                                                                                                                   Google Home - Smart Home Speaker Google Assistant
                                                                                                              </a>
                                                                                                         </h3>
                                                                                                         <div class="content_price product-price-and-shipping">
                                                                                                              <span class="price ">
                                                                                                                   $85.00
                                                                                                              </span>


                                                                                                         </div>
                                                                                                    </div>
                                                                                               </div>
                                                                                          </div>
                                                                                     </div>
                                                                                </article>
                                                                           </li>
                                                                      </ul>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                  </li>

                                                  <li class="level-1 ">
                                                       <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/8-macbook" class="baseinnermenu">
                                                            <span class="material-icons base-left-arrow">arrow_forward</span>
                                                            <span class="catagory">MacBook</span> </a>


                                                  </li>

                                                  <li class="level-1 ">
                                                       <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/en/contact-us" class="baseinnermenu">
                                                            <span class="material-icons base-left-arrow">arrow_forward</span>
                                                            <span class="catagory">Contact us</span> </a>


                                                  </li>

                                                  <li class="level-1 ">
                                                       <a href="https://demos.codezeel.com/prestashop/PRS21/PRS210518/default/blog.html" class="baseinnermenu">
                                                            <span class="material-icons base-left-arrow">arrow_forward</span>
                                                            <span class="catagory">Blog</span> </a>


                                                  </li>

                                             </ul>

                                             <div class="js-top-menu mobile" id="_mobile_vertical_menu"></div>

                                             <div class="js-top-menu-bottom">
                                                  <div id="_mobile_currency_selector"></div>
                                                  <div id="_mobile_language_selector"></div>
                                                  <div id="_mobile_contact_link"></div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <!-- /Module Horizontalmenu -->

                    </div>
               </div>

          </header>