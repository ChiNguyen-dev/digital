@extends('layouts.client')

@section('title')
    <title>Trang chủ</title>
@endsection

@section('vendors')
    <link rel="stylesheet" href="{{ asset('assets/vendors/carousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/carousel/assets/owl.theme.default.min.css') }}">
@endsection

@section('content')
    <div class="wp-content">
        <div class="wp-slider">
            <div class="owl-carousel owl-theme">
                @foreach($sliders as $slider)
                    <img src="{{ asset($slider->image_path) }}" alt="{{ $slider->name }}">
                @endforeach
            </div>
        </div>
        <div class="wp-service">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="box-shipment">
                            <div class="thumbnail-ship">
                                <img src="https://cdn.shopify.com/s/files/1/0099/8739/1539/files/1.png?v=1613543841" alt="shipment.png">
                            </div>
                            <div class="ship-content">
                                <h6>Free shipment</h6>
                                <p>delivery charges are not hidden charges shipping policy.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 pb-5">
                        <div class="box-support">
                            <div class="thumbnail-supp">
                                <img src="https://cdn.shopify.com/s/files/1/0099/8739/1539/files/2.png?v=1613543841" alt="support.png">
                            </div>
                            <div class="supp-content">
                                <h6>24*7 Support</h6>
                                <p>offers a wide range of services! Look no further.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box-services">
                            <div class="thumbnail-services">
                                <img src="https://cdn.shopify.com/s/files/1/0099/8739/1539/files/services-3.png?v=1613544991" alt="services.png">
                            </div>
                            <div class="services-content">
                                <h6>Gifts and voucher</h6>
                                <p>all gift cards expire 1year from date of their creation.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="Banner-with-SideText">
            <div class="row d-flex align-items-center ">
                <div class="col-md-4">
                    <div class="block-text-wrapper">
                        <span class="deals">REVOLVE VERSION</span>
                        <h2>DISCOVER QUALITY<br>OF SPEAKER</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua...</p>
                        <button class="btn-block-text">Read More</button>
                    </div>
                </div>
                <div class="col-md-4 pr-0">
                    <div class="banner-item banner-item__image--position effect-scale">
                        <div class="banner-item__image">
                            <img
                                src="https://cdn.shopify.com/s/files/1/0099/8739/1539/files/banner_img.jpg?v=1613544775"
                                alt="">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 p-4">
                    <div class="banner-item effect-hover">
                        <div class="banner-item__image">
                            <img
                                src="https://cdn.shopify.com/s/files/1/0099/8739/1539/files/banner_img_1.png?v=1613544579"
                                alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="slick-list">
            <div class="slick-list__banner">
                <img src="https://cdn.shopify.com/s/files/1/0099/8739/1539/files/banner.jpg?v=1613544775" alt="">
            </div>
            <ul class="slick-list__items">
                <li>
                    <a href="" class="slick-list__item">
                        <img
                            src="https://cdn.shopify.com/s/files/1/0099/8739/1539/collections/5_857e1bff-a806-4804-b699-65b80540a84a.jpg?v=1566540600"
                            alt="">
                        <div class="collection-list-grid__title">
                            <h6>Bluetooth speaker</h6>
                            <p class="number-products">5 products</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="" class="slick-list__item">
                        <img
                            src="https://cdn.shopify.com/s/files/1/0099/8739/1539/collections/3_6bcedfe8-e199-4650-8ec1-dd877364a2fd.jpg?v=1566540380"
                            alt="">
                        <div class="collection-list-grid__title">
                            <h6>Airpods</h6>
                            <p class="number-products">6 products</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="" class="slick-list__item">
                        <img
                            src="https://cdn.shopify.com/s/files/1/0099/8739/1539/collections/2_4b4d4a60-abc6-450b-a4cc-6ec7bb19ac05.jpg?v=1566540225"
                            alt="">
                        <div class="collection-list-grid__title">
                            <h6>Smart Watch</h6>
                            <p class="number-products">4 products</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="" class="slick-list__item">
                        <img src="https://cdn.shopify.com/s/files/1/0099/8739/1539/collections/1.jpg?v=1566540678"
                             alt="">
                        <div class="collection-list-grid__title">
                            <h6>Best selling</h6>
                            <p class="number-products">5 products</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="" class="slick-list__item">
                        <img
                            src="https://cdn.shopify.com/s/files/1/0099/8739/1539/collections/2_526ed2b0-3949-4920-8f0d-58f6a3228020.jpg?v=1566540286"
                            alt="">
                        <div class="collection-list-grid__title">
                            <h6>bluetooth</h6>
                            <p class="number-products">5 products</p>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <div class="wp-products">
            <div class="item-header">
                <h2>Sản phẩm bán chạy</h2>
            </div>
            <ul class="list-items" style="width: 100%; max-width: 1200px; margin: 0 auto">
                <div class="owl-carousel items">
                    @foreach($appleWatchs as $product)
                        <li class="item-link">
                            <div class="item-card-grid">
                                <a href="{{ route('products.detail',['slug' => $product->slug]) }}">
                                    <div class="image">
                                        <img src="{{ asset($product->feature_image_path) }}"
                                             alt="{{ $product->feature_image_name }}">
                                    </div>
                                </a>
                                <div class="product-item-details">
                                    <div class="evaluates">
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                    </div>
                                    <div class="title">
                                        <a href="{{ route('products.detail',['slug' => $product->slug]) }}"
                                           title="{{ $product->name }}">
                                            {{ $product->name }}
                                        </a>
                                    </div>
                                    <div class="price text-danger">
                                        {{ number_format($product->price,0,',','.') }}
                                        <span class="text-decoration-underline">đ</span>
                                    </div>
                                </div>
                                <div class="product-buttons">
                                    <a href="#" title="yêu thích">
                                        <i class="fa-regular fa-heart"></i>
                                    </a>
                                    <a href="{{ route('products.detail', ['slug' => $product->slug]) }}"
                                       title="chi tiết">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                    <a href="#" title="so sánh">
                                        <i class="fa-solid fa-down-left-and-up-right-to-center"></i>
                                    </a>
                                </div>
                                <div class="product-labels">
                                    <span class="sale">sale</span>
                                    <span class="new">new</span>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </div>
            </ul>
        </div>
        <div class="wp-products">
            <div class="item-header">
                <h2>MacBook Pro</h2>
            </div>
            <ul class="list-items">
                @foreach($macbooks as $macbook)
                    <li class="item-link">
                        <div class="item-card-grid">
                            <a href="{{ route('products.detail',['slug' => $macbook->slug]) }}">
                                <div class="image">
                                    <img src="{{ asset($macbook->feature_image_path) }}"
                                         alt="{{ $macbook->feature_image_name }}">
                                </div>
                            </a>
                            <div class="product-item-details">
                                <div class="evaluates">
                                    <i class="fa-regular fa-star"></i>
                                    <i class="fa-regular fa-star"></i>
                                    <i class="fa-regular fa-star"></i>
                                    <i class="fa-regular fa-star"></i>
                                    <i class="fa-regular fa-star"></i>
                                </div>
                                <div class="title">
                                    <a href="{{ route('products.detail',['slug' => $macbook->slug]) }}"
                                       title="{{ $macbook->name }}">
                                        {{ $macbook->name }}
                                    </a>
                                </div>
                                <div class="price text-danger">
                                    {{ number_format($macbook->price,0,',','.') }}
                                    <span class="text-decoration-underline">đ</span>
                                </div>
                            </div>
                            <div class="product-buttons">
                                <a href="#" title="yêu thích">
                                    <i class="fa-regular fa-heart"></i>
                                </a>
                                <a href="{{ route('products.detail', ['slug' => $macbook->slug]) }}"
                                   title="chi tiết">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                                <a href="#" title="so sánh">
                                    <i class="fa-solid fa-down-left-and-up-right-to-center"></i>
                                </a>
                            </div>
                            <div class="product-labels">
                                <span class="sale">sale</span>
                                <span class="new">new</span>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="wp-products">
            <div class="item-header">
                <h2>smart phone</h2>
            </div>
            <ul class="list-items" style="width: 100%; max-width: 1200px; margin: 0 auto">
                <div class="owl-carousel items">
                    @foreach($iphones as $iphone)
                        <li class="item-link">
                            <div class="item-card-grid">
                                <a href="{{ route('products.detail',['slug' => $iphone->slug]) }}">
                                    <div class="image">
                                        <img src="{{ asset($iphone->feature_image_path) }}"
                                             alt="{{ $iphone->feature_image_name }}">
                                    </div>
                                </a>
                                <div class="product-item-details">
                                    <div class="evaluates">
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                    </div>
                                    <div class="title">
                                        <a href="{{ route('products.detail',['slug' => $iphone->slug]) }}"
                                           title="{{ $iphone->name }}">
                                            {{ $iphone->name }}
                                        </a>
                                    </div>
                                    <div class="price text-danger">
                                        {{ number_format($iphone->price,0,',','.') }}
                                        <span class="text-decoration-underline">đ</span>
                                    </div>
                                </div>
                                <div class="product-buttons">
                                    <a href="#" title="yêu thích">
                                        <i class="fa-regular fa-heart"></i>
                                    </a>
                                    <a href="{{ route('products.detail', ['slug' => $iphone->slug]) }}"
                                       title="chi tiết">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                    <a href="#" title="so sánh">
                                        <i class="fa-solid fa-down-left-and-up-right-to-center"></i>
                                    </a>
                                </div>
                                <div class="product-labels">
                                    <span class="sale">sale</span>
                                    <span class="new">new</span>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </div>
            </ul>
        </div>
    </div>
@endsection

