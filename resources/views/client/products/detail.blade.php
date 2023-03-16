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
        <div class="trace">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="trace-list">
                            <li class="trace-item">
                                <i class="fa fa-home"></i>
                                <a href="{{ route('client.home') }}" class="trace-item__link">Trang chủ</a>
                            </li>
                            {!! $stracePath !!}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="product-infor">
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <div class="row">
                            <div class="product-album">
                                <div class="slider__detail">
                                    <div class="thumbnail-item">
                                        <img src="{{ asset($product->feature_image_path) }}"
                                             alt="{{ $product->feature_image_name }}">
                                    </div>
                                    <div class="next-prev">
                                        <a href="" class="btn-prev"><i class="fa-solid fa-angle-left"></i></a>
                                        <a href="" class="btn-next"><i class="fa-solid fa-angle-right"></i></a>
                                    </div>
                                </div>
                                <div class="carousel-detail">
                                    <ul class="thumbnail-main">
                                        @foreach($product->images as $key => $item)
                                            <li class="carousel__thumbnail-item {{ $product->feature_image_name == $item->image_name ? 'active' : '' }}">
                                                <img src="{{ asset($item->image_path) }}" alt="{{ $item->image_name }}">
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="intro-text">
                                    <p>Digital là đại lý bán lẻ ủy quyền các nhà phân phối chính hãng Apple Việt Nam</p>
                                    <p>Sản phẩm chính hãng Apple mới 100% nguyên seal. Phụ kiện chính hãng gồm: hộp
                                        trùng imei, cable, sách hướng dẫn.</p>
                                </div>
                                <div class="items-same">
                                    <p>Sản phẩm liên quan</p>
                                    <ul class="list-item">
                                        @foreach($itemsRelated as $item)
                                            <li>
                                                <div class="item-box">
                                                    <a href="{{ route('products.detail',['slug' => $item->slug]) }}">
                                                        <div class="img-box">
                                                            <img src="{{ asset($item->feature_image_path) }}"
                                                                 alt="{{ $item->feature_image_name }}">
                                                        </div>
                                                    </a>
                                                    <div class="name-box">
                                                        <a href="{{ route('products.detail',['slug' => $item->slug]) }}">{{ $item->name }}</a>
                                                    </div>
                                                    <div class="price-box">
                                                        <strong>{{ number_format($item->price,0,',','.') }}đ</strong>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="product-infor">
                                        <h1 class="product-name">{{ $product->name }}</h1>
                                        <div class="price-box">
                                            <strong>{{ number_format($product->price,0,',','.') }}<span
                                                    class="text-decoration-underline">đ</span></strong>
                                            <div class="installment">
                                                <span>Trả góp từ</span>
                                                <strong>1.158.000 ₫ / 1 tháng</strong>
                                            </div>
                                        </div>
                                        <div class="color-box">
                                            <strong>Màu sắc:</strong>
                                            @foreach($product->colors as $key => $color)
                                                <span class="{{  $key == 0 ? 'active_color' : '' }}"
                                                      data-color="{{ $color->id }}">
                                                    <i class="fa-solid fa-circle-check"
                                                       style="background-color: {{ $color->style }};
                                                       color: {{ $color->style }};"
                                                       title="{{ $color->name }}"></i>
                                                </span>
                                            @endforeach
                                        </div>
                                        <ul class="list-infor">
                                            <li>
                                                <i class="fa-solid fa-circle-check"></i>
                                                Hàng có sẵn
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-circle-check"></i>
                                                Sản phẩm chính hãng Apple Việt Nam mới 100% nguyên seal
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-circle-check"></i>
                                                Giá đã bao gồm VAT
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-circle-check"></i>
                                                Bảo hành 12 tháng chính hãng
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-circle-check"></i>
                                                Giảm giá 10% khi mua phụ kiện kèm theo
                                            </li>
                                        </ul>
                                        @if(!empty($product->short_desc))
                                            <div class="short_desc">
                                                <div class="desc-title">Thông số tóm tắt</div>
                                                <div class="desc_content middle">
                                                    {!! $product->short_desc !!}
                                                </div>
                                            </div>
                                        @endif
                                        <div class="btn-group-detail">
                                            <a href="" class="add-to-cart"
                                               data-url="{{ route('carts.add',['id' => $product->id]) }}"
                                               data-cart="{{ route('carts.index') }}">
                                                <i class="fa-solid fa-cart-arrow-down"></i>
                                                Thêm vào giỏ
                                            </a>
                                            <a href="" class="btn-buy-now add-to-cart"
                                               data-url="{{ route('carts.add',['id' => $product->id]) }}"
                                               data-cart="{{ route('checkout.index') }}">
                                                <i class="fa-solid fa-credit-card"></i>
                                                Mua ngay
                                            </a>
                                        </div>
                                        <div class="call-order">
                                            Gọi đặt mua : <span>0819.778.801</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="sale-box">
                                    <p>Mua máy tính tặng túi chống sốc, miễn phí cài phần mềm…</p>
                                </div>
                                <div class="policy-sale">
                                    <div class="title">Chính sách bán hàng</div>
                                    <div class="policy-sale__content right">
                                        <ul>
                                            <li>Dùng thử 10 ngày miễn phí đổi máy. (Macbook Like New)</li>
                                            <li>Lỗi 1 Đổi 1 trong 30 ngày đầu. (Macbook Like New)</li>
                                            <li>Giao hàng tận nhà toàn quốc</li>
                                            <li>Thanh toán khi nhận hàng (nội thành)</li>
                                            <li>Hỗ trợ phần mềm trọn đời</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if(!empty($product->content))
                    <div class="row">
                        <div class="col-md-12">
                            <div id="desc-product">
                                <div class="content-full">
                                    {!! $product->content !!}
                                </div>
                                <div class="view-more">
                                    <div class="more">
                                        <span>Xem thêm đặc điểm nổi bật</span>
                                        <i class="fa-solid fa-caret-down"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('assets/client/js/product/index.js') }}"></script>
    <script src="{{ asset('assets/client/js/cart/index.js') }}"></script>
@endsection
