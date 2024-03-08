﻿<?php
include 'header.php';

?>
<!--End header-->
<main class="main">
    <div class="container mb-30">
        <div class="row flex-row-reverse">
            <div class="col-lg-4-5">
                <section class="home-slider position-relative mb-30">
                    <div class="home-slide-cover mt-30">
                        <div class="hero-slider-1 style-4 dot-style-1 dot-style-1-position-1">
                            <div class="single-hero-slider single-animation-wrap" style="background-image: url(assets/imgs/slider/slider-1.jpg);">
                                <div class="slider-content">
                                    <h1 class="display-2 mb-40">
                                        Explore fantastic<br />
                                        clothing deals
                                    </h1>
                                    <p class="mb-65">Sign up for the daily Merchandise Updates</p>
                                    <form style="border: 2px solid #3BB77E;" class="form-subscriber d-flex">
                                        <input type="email" placeholder="Your email address" />
                                        <button class="btn" type="submit">Subscribe</button>
                                    </form>

                                </div>
                            </div>
                            <div class="single-hero-slider single-animation-wrap" style="background-image: url(assets/imgs/slider/slider-2.png)">
                                <div class="slider-content">
                                    <h1 class="display-2 mb-40">
                                        Premium Quality
                                        <br />
                                        Special Offers
                                    </h1>
                                    <p class="mb-65">Save up to 50% off on your first order</p>
                                    <form style="border: 2px solid #3BB77E;" class="form-subcriber d-flex">
                                        <input type="email" placeholder="Your emaill address" />
                                        <button id="colorbtn" class="btn" type="submit">Subscribe</button>
                                    </form>
                                </div>
                            </div>
                            <div class="single-hero-slider single-animation-wrap" style="background-image: url(assets/imgs/slider/slider-3.jpg);">
                                <div class="slider-content">
                                    <h1 class="display-2 mb-40">
                                        Big sale
                                        <br />
                                        on all products
                                    </h1>
                                    <p class="mb-65">Kickstart your shopping journey With Us</p>
                                    <form style="border: 2px solid #3BB77E;" class="form-subcriber d-flex">
                                        <input type="email" placeholder="Your emaill address" />
                                        <button class="btn" type="submit">Subscribe</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="slider-arrow hero-slider-1-arrow"></div>
                    </div>
                </section>
                <!--End hero-->
                <section class="product-tabs section-padding position-relative">
                    <div class="section-title style-2">
                        <h3>Popular Products</h3>
                        <ul class="nav nav-tabs links" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="nav-tab-one" data-bs-toggle="tab" data-bs-target="#tab-one" type="button" role="tab" aria-controls="tab-one" aria-selected="true">All</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="nav-tab-two" data-bs-toggle="tab" data-bs-target="#tab-two" type="button" role="tab" aria-controls="tab-two" aria-selected="false">Milks & Dairies</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="nav-tab-three" data-bs-toggle="tab" data-bs-target="#tab-three" type="button" role="tab" aria-controls="tab-three" aria-selected="false">Coffes & Teas</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="nav-tab-four" data-bs-toggle="tab" data-bs-target="#tab-four" type="button" role="tab" aria-controls="tab-four" aria-selected="false">Pet Foods</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="nav-tab-five" data-bs-toggle="tab" data-bs-target="#tab-five" type="button" role="tab" aria-controls="tab-five" aria-selected="false">Meats</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="nav-tab-six" data-bs-toggle="tab" data-bs-target="#tab-six" type="button" role="tab" aria-controls="tab-six" aria-selected="false">Vegetables</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="nav-tab-seven" data-bs-toggle="tab" data-bs-target="#tab-seven" type="button" role="tab" aria-controls="tab-seven" aria-selected="false">Fruits</button>
                            </li>
                        </ul>
                    </div>
                    <!--End nav-tabs-->
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                            <div class="row product-grid-4">
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-1-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-1-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="hot">Hot</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Snack</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Seeds of Change Organic Quinoe</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$28.85</span>
                                                    <span class="old-price">$32.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-2-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-2-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="sale">Sale</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Hodo Foods</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>All Natural Italian-Style Chicken Meatballs</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 80%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (3.5)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>Stouffer</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$52.85</span>
                                                    <span class="old-price">$55.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-3-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-3-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="new">New</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Snack</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Angie’s Boomchickapop Sweet & Salty</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 85%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>StarKist</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$48.85</span>
                                                    <span class="old-price">$52.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-4-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-4-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Vegetables</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Foster Farms Takeout Crispy Classic</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$17.85</span>
                                                    <span class="old-price">$19.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-5-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-5-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="best">-14%</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Pet Foods</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Blue Diamond Almonds Lightly</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$23.85</span>
                                                    <span class="old-price">$25.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-6-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-6-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Hodo Foods</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Chobani Complete Vanilla Greek</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$54.85</span>
                                                    <span class="old-price">$55.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-7-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-7-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Meats</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Canada Dry Ginger Ale – 2 L Bottle</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$32.85</span>
                                                    <span class="old-price">$33.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-8-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-8-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="sale">Sale</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Snack</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Encore Seafoods Stuffed Alaskan</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$35.85</span>
                                                    <span class="old-price">$37.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-9-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-9-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="hot">Hot</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Coffes</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Gorton’s Beer Battered Fish Fillets</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>Old El Paso</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$23.85</span>
                                                    <span class="old-price">$25.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 d-none d-xl-block">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-10-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-10-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Cream</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Haagen-Dazs Caramel Cone Ice Cream</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 50%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (2.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>Tyson</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$22.85</span>
                                                    <span class="old-price">$24.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                            </div>
                            <!--End product-grid-4-->
                        </div>
                        <!--En tab one-->
                        <div class="tab-pane fade" id="tab-two" role="tabpanel" aria-labelledby="tab-two">
                            <div class="row product-grid-4">
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-10-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-10-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="hot">Hot</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Snack</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Seeds of Change Organic Quinoa, Brown, & Red Rice</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$28.85</span>
                                                    <span class="old-price">$32.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-12-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-12-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="sale">Sale</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Hodo Foods</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>All Natural Italian-Style Chicken Meatballs</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 80%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (3.5)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>Stouffer</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$52.85</span>
                                                    <span class="old-price">$55.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-13-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-13-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="new">New</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Snack</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Angie’s Boomchickapop Sweet & Salty Kettle Corn</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 85%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>StarKist</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$48.85</span>
                                                    <span class="old-price">$52.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-14-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-14-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Vegetables</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Foster Farms Takeout Crispy Classic Buffalo Wings</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$17.85</span>
                                                    <span class="old-price">$19.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-15-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-15-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="best">-14%</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Pet Foods</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Blue Diamond Almonds Lightly Salted Vegetables</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$23.85</span>
                                                    <span class="old-price">$25.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-16-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-16-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Hodo Foods</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Chobani Complete Vanilla Greek Yogurt</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$54.85</span>
                                                    <span class="old-price">$55.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-7-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-7-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Meats</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Canada Dry Ginger Ale – 2 L Bottle - 200ml - 400g</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$32.85</span>
                                                    <span class="old-price">$33.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-8-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-8-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="sale">Sale</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Snack</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Encore Seafoods Stuffed Alaskan Salmon</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$35.85</span>
                                                    <span class="old-price">$37.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-9-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-9-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="hot">Hot</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Coffes</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Gorton’s Beer Battered Fish Fillets with soft paper</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>Old El Paso</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$23.85</span>
                                                    <span class="old-price">$25.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 d-none d-xl-block">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-10-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-10-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Cream</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Haagen-Dazs Caramel Cone Ice Cream Ketchup</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 50%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (2.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>Tyson</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$22.85</span>
                                                    <span class="old-price">$24.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                            </div>
                            <!--End product-grid-4-->
                        </div>
                        <!--En tab two-->
                        <div class="tab-pane fade" id="tab-three" role="tabpanel" aria-labelledby="tab-three">
                            <div class="row product-grid-4">
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-9-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-9-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="hot">Hot</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Snack</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Seeds of Change Organic Quinoa, Brown, & Red Rice</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$28.85</span>
                                                    <span class="old-price">$32.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-8-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-8-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="sale">Sale</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Hodo Foods</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>All Natural Italian-Style Chicken Meatballs</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 80%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (3.5)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>Stouffer</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$52.85</span>
                                                    <span class="old-price">$55.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-7-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-7-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="new">New</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Snack</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Angie’s Boomchickapop Sweet & Salty Kettle Corn</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 85%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>StarKist</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$48.85</span>
                                                    <span class="old-price">$52.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-6-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-6-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Vegetables</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Foster Farms Takeout Crispy Classic Buffalo Wings</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$17.85</span>
                                                    <span class="old-price">$19.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-5-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-5-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="best">-14%</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Pet Foods</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Blue Diamond Almonds Lightly Salted Vegetables</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$23.85</span>
                                                    <span class="old-price">$25.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-4-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-4-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Hodo Foods</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Chobani Complete Vanilla Greek Yogurt</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$54.85</span>
                                                    <span class="old-price">$55.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-3-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-3-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Meats</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Canada Dry Ginger Ale – 2 L Bottle - 200ml - 400g</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$32.85</span>
                                                    <span class="old-price">$33.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-2-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-2-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="sale">Sale</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Snack</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Encore Seafoods Stuffed Alaskan Salmon</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$35.85</span>
                                                    <span class="old-price">$37.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-9-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-9-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="hot">Hot</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Coffes</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Gorton’s Beer Battered Fish Fillets with soft paper</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>Old El Paso</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$23.85</span>
                                                    <span class="old-price">$25.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 d-none d-xl-block">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-1-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-1-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Cream</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Haagen-Dazs Caramel Cone Ice Cream Ketchup</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 50%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (2.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>Tyson</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$22.85</span>
                                                    <span class="old-price">$24.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                            </div>
                            <!--End product-grid-4-->
                        </div>
                        <!--En tab three-->
                        <div class="tab-pane fade" id="tab-four" role="tabpanel" aria-labelledby="tab-four">
                            <div class="row product-grid-4">
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-6-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-6-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="hot">Hot</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Snack</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Seeds of Change Organic Quinoa, Brown, & Red Rice</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$28.85</span>
                                                    <span class="old-price">$32.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-7-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-7-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="sale">Sale</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Hodo Foods</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>All Natural Italian-Style Chicken Meatballs</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 80%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (3.5)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>Stouffer</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$52.85</span>
                                                    <span class="old-price">$55.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-8-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-8-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="new">New</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Snack</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Angie’s Boomchickapop Sweet & Salty Kettle Corn</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 85%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>StarKist</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$48.85</span>
                                                    <span class="old-price">$52.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-9-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-9-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Vegetables</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Foster Farms Takeout Crispy Classic Buffalo Wings</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$17.85</span>
                                                    <span class="old-price">$19.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-4-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-4-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="best">-14%</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Pet Foods</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Blue Diamond Almonds Lightly Salted Vegetables</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$23.85</span>
                                                    <span class="old-price">$25.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-3-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-3-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Hodo Foods</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Chobani Complete Vanilla Greek Yogurt</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$54.85</span>
                                                    <span class="old-price">$55.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-2-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-2-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Meats</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Canada Dry Ginger Ale – 2 L Bottle - 200ml - 400g</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$32.85</span>
                                                    <span class="old-price">$33.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-1-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-1-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="sale">Sale</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Snack</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Encore Seafoods Stuffed Alaskan Salmon</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$35.85</span>
                                                    <span class="old-price">$37.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-11-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-11-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="hot">Hot</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Coffes</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Gorton’s Beer Battered Fish Fillets with soft paper</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>Old El Paso</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$23.85</span>
                                                    <span class="old-price">$25.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 d-none d-xl-block">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-12-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-12-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Cream</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Haagen-Dazs Caramel Cone Ice Cream Ketchup</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 50%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (2.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>Tyson</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$22.85</span>
                                                    <span class="old-price">$24.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                            </div>
                            <!--End product-grid-4-->
                        </div>
                        <!--En tab four-->
                        <div class="tab-pane fade" id="tab-five" role="tabpanel" aria-labelledby="tab-five">
                            <div class="row product-grid-4">
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-12-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-12-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="hot">Hot</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Snack</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Seeds of Change Organic Quinoa, Brown, & Red Rice</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$28.85</span>
                                                    <span class="old-price">$32.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-13-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-13-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="sale">Sale</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Hodo Foods</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>All Natural Italian-Style Chicken Meatballs</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 80%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (3.5)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>Stouffer</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$52.85</span>
                                                    <span class="old-price">$55.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-14-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-14-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="new">New</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Snack</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Angie’s Boomchickapop Sweet & Salty Kettle Corn</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 85%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>StarKist</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$48.85</span>
                                                    <span class="old-price">$52.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-15-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-15-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Vegetables</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Foster Farms Takeout Crispy Classic Buffalo Wings</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$17.85</span>
                                                    <span class="old-price">$19.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-16-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-16-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="best">-14%</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Pet Foods</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Blue Diamond Almonds Lightly Salted Vegetables</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$23.85</span>
                                                    <span class="old-price">$25.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-5-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-5-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Hodo Foods</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Chobani Complete Vanilla Greek Yogurt</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$54.85</span>
                                                    <span class="old-price">$55.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-7-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-7-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Meats</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Canada Dry Ginger Ale – 2 L Bottle - 200ml - 400g</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$32.85</span>
                                                    <span class="old-price">$33.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-8-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-8-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="sale">Sale</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Snack</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Encore Seafoods Stuffed Alaskan Salmon</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$35.85</span>
                                                    <span class="old-price">$37.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-9-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-9-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="hot">Hot</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Coffes</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Gorton’s Beer Battered Fish Fillets with soft paper</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>Old El Paso</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$23.85</span>
                                                    <span class="old-price">$25.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 d-none d-xl-block">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-10-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-10-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Cream</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Haagen-Dazs Caramel Cone Ice Cream Ketchup</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 50%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (2.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>Tyson</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$22.85</span>
                                                    <span class="old-price">$24.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                            </div>
                            <!--End product-grid-4-->
                        </div>
                        <!--En tab five-->
                        <div class="tab-pane fade" id="tab-six" role="tabpanel" aria-labelledby="tab-six">
                            <div class="row product-grid-4">
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-4-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-4-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="hot">Hot</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Snack</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Seeds of Change Organic Quinoa, Brown, & Red Rice</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$28.85</span>
                                                    <span class="old-price">$32.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-6-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-6-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="sale">Sale</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Hodo Foods</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>All Natural Italian-Style Chicken Meatballs</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 80%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (3.5)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>Stouffer</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$52.85</span>
                                                    <span class="old-price">$55.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-8-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-8-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="new">New</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Snack</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Angie’s Boomchickapop Sweet & Salty Kettle Corn</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 85%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>StarKist</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$48.85</span>
                                                    <span class="old-price">$52.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-9-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-9-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Vegetables</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Foster Farms Takeout Crispy Classic Buffalo Wings</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$17.85</span>
                                                    <span class="old-price">$19.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-5-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-5-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="best">-14%</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Pet Foods</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Blue Diamond Almonds Lightly Salted Vegetables</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$23.85</span>
                                                    <span class="old-price">$25.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-6-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-6-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Hodo Foods</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Chobani Complete Vanilla Greek Yogurt</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$54.85</span>
                                                    <span class="old-price">$55.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-7-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-7-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Meats</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Canada Dry Ginger Ale – 2 L Bottle - 200ml - 400g</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$32.85</span>
                                                    <span class="old-price">$33.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-8-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-8-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="sale">Sale</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Snack</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Encore Seafoods Stuffed Alaskan Salmon</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$35.85</span>
                                                    <span class="old-price">$37.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-9-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-9-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="hot">Hot</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Coffes</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Gorton’s Beer Battered Fish Fillets with soft paper</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>Old El Paso</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$23.85</span>
                                                    <span class="old-price">$25.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 d-none d-xl-block">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-10-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-10-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Cream</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Haagen-Dazs Caramel Cone Ice Cream Ketchup</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 50%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (2.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>Tyson</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$22.85</span>
                                                    <span class="old-price">$24.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                            </div>
                            <!--End product-grid-4-->
                        </div>
                        <!--En tab six-->
                        <div class="tab-pane fade" id="tab-seven" role="tabpanel" aria-labelledby="tab-seven">
                            <div class="row product-grid-4">
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-5-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-5-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="hot">Hot</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Snack</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Seeds of Change Organic Quinoa, Brown, & Red Rice</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$28.85</span>
                                                    <span class="old-price">$32.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-3-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-3-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="sale">Sale</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Hodo Foods</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>All Natural Italian-Style Chicken Meatballs</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 80%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (3.5)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>Stouffer</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$52.85</span>
                                                    <span class="old-price">$55.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-7-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-7-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="new">New</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Snack</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Angie’s Boomchickapop Sweet & Salty Kettle Corn</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 85%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>StarKist</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$48.85</span>
                                                    <span class="old-price">$52.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-9-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-9-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Vegetables</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Foster Farms Takeout Crispy Classic Buffalo Wings</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$17.85</span>
                                                    <span class="old-price">$19.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-10-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-10-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="best">-14%</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Pet Foods</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Blue Diamond Almonds Lightly Salted Vegetables</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$23.85</span>
                                                    <span class="old-price">$25.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-16-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-16-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Hodo Foods</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Chobani Complete Vanilla Greek Yogurt</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$54.85</span>
                                                    <span class="old-price">$55.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-7-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-7-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Meats</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Canada Dry Ginger Ale – 2 L Bottle - 200ml - 400g</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$32.85</span>
                                                    <span class="old-price">$33.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-8-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-8-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="sale">Sale</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Snack</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Encore Seafoods Stuffed Alaskan Salmon</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$35.85</span>
                                                    <span class="old-price">$37.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-9-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-9-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="hot">Hot</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Coffes</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Gorton’s Beer Battered Fish Fillets with soft paper</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>Old El Paso</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$23.85</span>
                                                    <span class="old-price">$25.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                                <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 d-none d-xl-block">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href='shop-product-right.html'>
                                                    <img class="default-img" src="assets/imgs/shop/product-10-1.jpg" alt="" />
                                                    <img class="hover-img" src="assets/imgs/shop/product-10-2.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                                                <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href='shop-grid-right.html'>Cream</a>
                                            </div>
                                            <h2><a href='shop-product-right.html'>Haagen-Dazs Caramel Cone Ice Cream Ketchup</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 50%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (2.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href='vendor-details-1.html'>Tyson</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$22.85</span>
                                                    <span class="old-price">$24.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product card-->
                            </div>
                            <!--End product-grid-4-->
                        </div>
                        <!--En tab seven-->
                    </div>
                    <!--End tab-content-->
                </section>
                <!--Products Tabs-->
                <section class="section-padding pb-5">
                    <div class="section-title">
                        <h3 class="">Deals Of The Day</h3>
                        <a class='show-all' href='shop-grid-right.html'>
                            All Deals
                            <i class="fi-rs-angle-right"></i>
                        </a>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="product-cart-wrap style-2">
                                <div class="product-img-action-wrap">
                                    <div class="product-img">
                                        <a href='shop-product-right.html'>
                                            <img src="assets/imgs/banner/banner-5.png" alt="" />
                                        </a>
                                    </div>
                                </div>
                                <div class="product-content-wrap">
                                    <div class="deals-countdown-wrap">
                                        <div class="deals-countdown" data-countdown="2025/03/25 00:00:00"></div>
                                    </div>
                                    <div class="deals-content">
                                        <h2><a href='shop-product-right.html'>Seeds of Change Organic Quinoa, Brown</a></h2>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                        <div>
                                            <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                                        </div>
                                        <div class="product-card-bottom">
                                            <div class="product-price">
                                                <span>$32.85</span>
                                                <span class="old-price">$33.8</span>
                                            </div>
                                            <div class="add-cart">
                                                <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="product-cart-wrap style-2">
                                <div class="product-img-action-wrap">
                                    <div class="product-img">
                                        <a href='shop-product-right.html'>
                                            <img src="assets/imgs/banner/banner-6.png" alt="" />
                                        </a>
                                    </div>
                                </div>
                                <div class="product-content-wrap">
                                    <div class="deals-countdown-wrap">
                                        <div class="deals-countdown" data-countdown="2026/04/25 00:00:00"></div>
                                    </div>
                                    <div class="deals-content">
                                        <h2><a href='shop-product-right.html'>Perdue Simply Smart Organics Gluten</a></h2>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                        <div>
                                            <span class="font-small text-muted">By <a href='vendor-details-1.html'>Old El Paso</a></span>
                                        </div>
                                        <div class="product-card-bottom">
                                            <div class="product-price">
                                                <span>$24.85</span>
                                                <span class="old-price">$26.8</span>
                                            </div>
                                            <div class="add-cart">
                                                <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 d-none d-lg-block">
                            <div class="product-cart-wrap style-2">
                                <div class="product-img-action-wrap">
                                    <div class="product-img">
                                        <a href='shop-product-right.html'>
                                            <img src="assets/imgs/banner/banner-7.png" alt="" />
                                        </a>
                                    </div>
                                </div>
                                <div class="product-content-wrap">
                                    <div class="deals-countdown-wrap">
                                        <div class="deals-countdown" data-countdown="2027/03/25 00:00:00"></div>
                                    </div>
                                    <div class="deals-content">
                                        <h2><a href='shop-product-right.html'>Signature Wood-Fired Mushroom</a></h2>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 80%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (3.0)</span>
                                        </div>
                                        <div>
                                            <span class="font-small text-muted">By <a href='vendor-details-1.html'>Progresso</a></span>
                                        </div>
                                        <div class="product-card-bottom">
                                            <div class="product-price">
                                                <span>$12.85</span>
                                                <span class="old-price">$13.8</span>
                                            </div>
                                            <div class="add-cart">
                                                <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 d-none d-xl-block">
                            <div class="product-cart-wrap style-2">
                                <div class="product-img-action-wrap">
                                    <div class="product-img">
                                        <a href='shop-product-right.html'>
                                            <img src="assets/imgs/banner/banner-8.png" alt="" />
                                        </a>
                                    </div>
                                </div>
                                <div class="product-content-wrap">
                                    <div class="deals-countdown-wrap">
                                        <div class="deals-countdown" data-countdown="2025/02/25 00:00:00"></div>
                                    </div>
                                    <div class="deals-content">
                                        <h2><a href='shop-product-right.html'>Simply Lemonade with Raspberry Juice</a></h2>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 80%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (3.0)</span>
                                        </div>
                                        <div>
                                            <span class="font-small text-muted">By <a href='vendor-details-1.html'>Yoplait</a></span>
                                        </div>
                                        <div class="product-card-bottom">
                                            <div class="product-price">
                                                <span>$15.85</span>
                                                <span class="old-price">$16.8</span>
                                            </div>
                                            <div class="add-cart">
                                                <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--End Deals-->
                <section class="banners">
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="banner-img">
                                <img src="assets/imgs/banner/banner-1.png" alt="" />
                                <div class="banner-text">
                                    <h4>
                                        Everyday Fresh & <br />Clean with Our<br />
                                        Products
                                    </h4>
                                    <a class='btn btn-xs' href='shop-grid-right.html'>Shop Now <i class="fi-rs-arrow-small-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="banner-img">
                                <img src="assets/imgs/banner/banner-2.png" alt="" />
                                <div class="banner-text">
                                    <h4>
                                        Make your Breakfast<br />
                                        Healthy and Easy
                                    </h4>
                                    <a class='btn btn-xs' href='shop-grid-right.html'>Shop Now <i class="fi-rs-arrow-small-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 d-md-none d-lg-flex">
                            <div class="banner-img mb-sm-0">
                                <img src="assets/imgs/banner/banner-3.png" alt="" />
                                <div class="banner-text">
                                    <h4>The best Organic <br />Products Online</h4>
                                    <a class='btn btn-xs' href='shop-grid-right.html'>Shop Now <i class="fi-rs-arrow-small-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--End banners-->
            </div>
            <div class="col-lg-1-5 primary-sidebar sticky-sidebar pt-30">

                <div class="sidebar-widget widget-category-2 mb-30">
                    <h5 class="section-title style-1 mb-30">Top Category</h5>
                    <?php
                    // Fetch categories from the database ordered by popularity
                    $categories = getPopularCategories('categories');

                    // Check if categories exist
                    if (mysqli_num_rows($categories) > 0) {
                        // Limit to show only 5 categories
                        $count = 0;
                        foreach ($categories as $category) {
                            if ($count < 5) {
                               // Fetch the number of products in each category
                               $categoryId = $category['id'];
                               $productCountQuery = "SELECT COUNT(*) AS product_count FROM products WHERE category_name = '{$category['name']}'";
                               $productCountResult = mysqli_query($conn, $productCountQuery);
                               $productCountRow = mysqli_fetch_assoc($productCountResult);
                               $productCount = $productCountRow['product_count'];
                    ?>
                                <ul>
                                    <li>
                                        <a href='shop-grid-right.html'>
                                            <img src="uploads/<?= $category['image']; ?>" /><?= $category['name']; ?>
                                        </a>
                                        <span style="color: #3BB77E;" class="top-sell"><?= $productCount; ?></span>
         
                                    </li>
                                </ul>
                    <?php
                                $count++;
                            } else {
                                break; // Exit the loop once 5 categories are shown
                            }
                        }
                    } else {
                        echo "<p>No categories found</p>";
                    }
                    ?>
                </div>

                <!--top products -->
                <div class="sidebar-widget widget-top-products mb-30">
                    <h5 class="section-title style-1 mb-30">Top Products</h5>
                    <div class="product-widget-2">
                        <?php
                        // Fetch products from the database
                        $products = getAllProducts('products');

                        // Check if products exist
                        if ($products && mysqli_num_rows($products) > 0) {
                            // Limit to show only 5 products
                            $count = 0;
                            while ($item = mysqli_fetch_assoc($products)) {
                                if ($count < 2) {
                        ?>
                                    <article class="border-bottom pb-30 mb-30">
                                        <div class="product-img">
                                            <a href='shop-product-right.html'>
                                                <img src="uploads/shop/<?= $item['image']; ?>" />
                                            </a>
                                        </div>
                                        <div class="product-content">
                                            <h6><a href='shop-product-right.html'><?= $item['product_name']; ?></a></h6>
                                            <div class="product-price">
                                                <span class="selling-price">Ksh <?= number_format($item['selling_price'], 2); ?></span>
                                                <span class="old-price">Ksh <?= number_format($item['original_price'], 2); ?></span>

                                            </div>

                                            <style>
                                                .old-price {
                                                    text-decoration: line-through;
                                                    text-decoration-color: red;
                                                }

                                                .selling-price {
                                                    font-weight: bold;
                                                }
                                            </style>
                                        </div>
                                    </article>
                        <?php
                                    $count++;
                                } else {
                                    break; // Exit the loop once 5 products are shown
                                }
                            }
                        } else {
                            echo "<p>No products found</p>";
                        }
                        ?>
                    </div>

                </div>
                <!--end top products -->
                <div class="sidebar-widget widget-banner mb-30">
                    <img src="assets/imgs/banner/banner-9.png" alt="" />
                </div>


            </div>
        </div>


        <section class="popular-categories section-padding">
            <div class="container wow animate__animated animate__fadeIn">
                <div class="section-title">
                    <div class="title">
                        <h3>Featured Categories</h3>
                        <ul class="list-inline nav nav-tabs links">
                            <li class="list-inline-item nav-item"><a class='nav-link' href='shop-grid-right.html'>Cake & Milk</a></li>
                            <li class="list-inline-item nav-item"><a class='nav-link' href='shop-grid-right.html'>Coffes & Teas</a></li>
                            <li class="list-inline-item nav-item"><a class='nav-link active' href='shop-grid-right.html'>Pet Foods</a></li>
                            <li class="list-inline-item nav-item"><a class='nav-link' href='shop-grid-right.html'>Vegetables</a></li>
                        </ul>
                    </div>
                    <div class="slider-arrow slider-arrow-2 flex-right carausel-10-columns-arrow" id="carausel-10-columns-arrows"></div>
                </div>

                <div class="carausel-10-columns-cover position-relative">
                    <div class="carausel-10-columns-cover position-relative">
                        <div class="carausel-10-columns" id="carausel-10-columns">
                            <?php
                            // Fetch categories from the database
                            $categories = getAllActive('categories');

                            // Check if categories exist
                            if (mysqli_num_rows($categories) > 0) {
                                foreach ($categories as $category) {
                                    // Fetch the number of products in each category
                                    $categoryId = $category['id'];
                                    $productCountQuery = "SELECT COUNT(*) AS product_count FROM products WHERE category_name = '{$category['name']}'";
                                    $productCountResult = mysqli_query($conn, $productCountQuery);
                                    $productCountRow = mysqli_fetch_assoc($productCountResult);
                                    $productCount = $productCountRow['product_count'];
                            ?>
                                    <div class="card-2 bg-9 wow animate__animated animate__fadeInUp" data-wow-delay=".1s">
                                        <figure class="img-hover-scale overflow-hidden">
                                            <a href='shop-grid-right.html'><img style="height: 70px!important;" src="uploads/<?= $category['image']; ?>"></a>
                                        </figure>
                                        <h6 style="font-size: 12px;">
                                            <a href='shop-grid-right.html'><?= $category['name']; ?></a>
                                        </h6>
                                        <span class="font-small"><?= $productCount; ?> Products</span>
                                    </div>
                            <?php
                                }
                            } else {
                                echo "<p>No categories found</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>



            </div>
        </section>

        <!--End category slider-->
        <section class="section-padding mb-30">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0">
                        <h4 class="section-title style-1 mb-30 animated animated">Top Selling</h4>
                        <div class="product-list-small animated animated">
                            <article class="row align-items-center hover-up">
                                <figure class="col-md-4 mb-0">
                                    <a href='shop-product-right.html'><img src="assets/imgs/shop/thumbnail-1.jpg" alt="" /></a>
                                </figure>
                                <div class="col-md-8 mb-0">
                                    <h6>
                                        <a href='shop-product-right.html'>Nestle Original Coffee-Mate Coffee Creamer</a>
                                    </h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    <div class="product-price">
                                        <span>$32.85</span>
                                        <span class="old-price">$33.8</span>
                                    </div>
                                </div>
                            </article>
                            <article class="row align-items-center hover-up">
                                <figure class="col-md-4 mb-0">
                                    <a href='shop-product-right.html'><img src="assets/imgs/shop/thumbnail-2.jpg" alt="" /></a>
                                </figure>
                                <div class="col-md-8 mb-0">
                                    <h6>
                                        <a href='shop-product-right.html'>Nestle Original Coffee-Mate Coffee Creamer</a>
                                    </h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    <div class="product-price">
                                        <span>$32.85</span>
                                        <span class="old-price">$33.8</span>
                                    </div>
                                </div>
                            </article>
                            <article class="row align-items-center hover-up">
                                <figure class="col-md-4 mb-0">
                                    <a href='shop-product-right.html'><img src="assets/imgs/shop/thumbnail-3.jpg" alt="" /></a>
                                </figure>
                                <div class="col-md-8 mb-0">
                                    <h6>
                                        <a href='shop-product-right.html'>Nestle Original Coffee-Mate Coffee Creamer</a>
                                    </h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    <div class="product-price">
                                        <span>$32.85</span>
                                        <span class="old-price">$33.8</span>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-md-0">
                        <h4 class="section-title style-1 mb-30 animated animated">Trending Products</h4>
                        <div class="product-list-small animated animated">
                            <article class="row align-items-center hover-up">
                                <figure class="col-md-4 mb-0">
                                    <a href='shop-product-right.html'><img src="assets/imgs/shop/thumbnail-4.jpg" alt="" /></a>
                                </figure>
                                <div class="col-md-8 mb-0">
                                    <h6>
                                        <a href='shop-product-right.html'>Organic Cage-Free Grade A Large Brown Eggs</a>
                                    </h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    <div class="product-price">
                                        <span>$32.85</span>
                                        <span class="old-price">$33.8</span>
                                    </div>
                                </div>
                            </article>
                            <article class="row align-items-center hover-up">
                                <figure class="col-md-4 mb-0">
                                    <a href='shop-product-right.html'><img src="assets/imgs/shop/thumbnail-5.jpg" alt="" /></a>
                                </figure>
                                <div class="col-md-8 mb-0">
                                    <h6>
                                        <a href='shop-product-right.html'>Seeds of Change Organic Quinoa, Brown, & Red Rice</a>
                                    </h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    <div class="product-price">
                                        <span>$32.85</span>
                                        <span class="old-price">$33.8</span>
                                    </div>
                                </div>
                            </article>
                            <article class="row align-items-center hover-up">
                                <figure class="col-md-4 mb-0">
                                    <a href='shop-product-right.html'><img src="assets/imgs/shop/thumbnail-6.jpg" alt="" /></a>
                                </figure>
                                <div class="col-md-8 mb-0">
                                    <h6>
                                        <a href='shop-product-right.html'>Naturally Flavored Cinnamon Vanilla Light Roast Coffee</a>
                                    </h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    <div class="product-price">
                                        <span>$32.85</span>
                                        <span class="old-price">$33.8</span>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0 d-none d-lg-block">
                        <h4 class="section-title style-1 mb-30 animated animated">Recently added</h4>
                        <div class="product-list-small animated animated">
                            <article class="row align-items-center hover-up">
                                <figure class="col-md-4 mb-0">
                                    <a href='shop-product-right.html'><img src="assets/imgs/shop/thumbnail-7.jpg" alt="" /></a>
                                </figure>
                                <div class="col-md-8 mb-0">
                                    <h6>
                                        <a href='shop-product-right.html'>Pepperidge Farm Farmhouse Hearty White Bread</a>
                                    </h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    <div class="product-price">
                                        <span>$32.85</span>
                                        <span class="old-price">$33.8</span>
                                    </div>
                                </div>
                            </article>
                            <article class="row align-items-center hover-up">
                                <figure class="col-md-4 mb-0">
                                    <a href='shop-product-right.html'><img src="assets/imgs/shop/thumbnail-8.jpg" alt="" /></a>
                                </figure>
                                <div class="col-md-8 mb-0">
                                    <h6>
                                        <a href='shop-product-right.html'>Organic Frozen Triple Berry Blend</a>
                                    </h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    <div class="product-price">
                                        <span>$32.85</span>
                                        <span class="old-price">$33.8</span>
                                    </div>
                                </div>
                            </article>
                            <article class="row align-items-center hover-up">
                                <figure class="col-md-4 mb-0">
                                    <a href='shop-product-right.html'><img src="assets/imgs/shop/thumbnail-9.jpg" alt="" /></a>
                                </figure>
                                <div class="col-md-8 mb-0">
                                    <h6>
                                        <a href='shop-product-right.html'>Oroweat Country Buttermilk Bread</a>
                                    </h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    <div class="product-price">
                                        <span>$32.85</span>
                                        <span class="old-price">$33.8</span>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0 d-none d-xl-block">
                        <h4 class="section-title style-1 mb-30 animated animated">Top Rated</h4>
                        <div class="product-list-small animated animated">
                            <article class="row align-items-center hover-up">
                                <figure class="col-md-4 mb-0">
                                    <a href='shop-product-right.html'><img src="assets/imgs/shop/thumbnail-10.jpg" alt="" /></a>
                                </figure>
                                <div class="col-md-8 mb-0">
                                    <h6>
                                        <a href='shop-product-right.html'>Foster Farms Takeout Crispy Classic Buffalo Wings</a>
                                    </h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    <div class="product-price">
                                        <span>$32.85</span>
                                        <span class="old-price">$33.8</span>
                                    </div>
                                </div>
                            </article>
                            <article class="row align-items-center hover-up">
                                <figure class="col-md-4 mb-0">
                                    <a href='shop-product-right.html'><img src="assets/imgs/shop/thumbnail-11.jpg" alt="" /></a>
                                </figure>
                                <div class="col-md-8 mb-0">
                                    <h6>
                                        <a href='shop-product-right.html'>Angie’s Boomchickapop Sweet & Salty Kettle Corn</a>
                                    </h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    <div class="product-price">
                                        <span>$32.85</span>
                                        <span class="old-price">$33.8</span>
                                    </div>
                                </div>
                            </article>
                            <article class="row align-items-center hover-up">
                                <figure class="col-md-4 mb-0">
                                    <a href='shop-product-right.html'><img src="assets/imgs/shop/thumbnail-12.jpg" alt="" /></a>
                                </figure>
                                <div class="col-md-8 mb-0">
                                    <h6>
                                        <a href='shop-product-right.html'>All Natural Italian-Style Chicken Meatballs</a>
                                    </h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    <div class="product-price">
                                        <span>$32.85</span>
                                        <span class="old-price">$33.8</span>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End 4 columns-->
</main>
<?php include 'includes/footer.php'; ?>
</body>

</html>