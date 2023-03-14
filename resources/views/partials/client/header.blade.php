<div class="wp__header">
    <div class="wp-container">
        <nav class="header-over">
            <div class="header-over__left">
                <div class="header-over__left-time">
                    <i class="fa-regular fa-clock"></i>
                    <span>Office Time : 9 AM TO 6 PM </span>
                </div>
                <div class="header-over__left-mail">
                    <i class="fa-solid fa-envelope"></i>
                    <span> contact@gmail.com.vn </span>
                </div>
            </div>
            <div class="header-over__right">
                <div class="header-over__right-shopping">
                    <i class="fa-solid fa-bag-shopping"></i>
                    <span>Sản phẩm</span>
                </div>
                <div class="header-over__right-socials">
                    <i class="fa-brands fa-twitter"></i>
                    <i class="fa-brands fa-facebook-f"></i>
                    <i class="fa-brands fa-pinterest-p"></i>
                    <i class="fa-brands fa-instagram"></i>
                    <i class="fa-brands fa-tumblr"></i>
                </div>
            </div>
        </nav>
    </div>
    <div class="wp-container--bg">
        <div class="wp-container">
            <nav class="header-under">
                <div class="logo">
                    <div class="icon-respon"><i class="fa-solid fa-bars"></i></div>
                    <a href="/"><img
                            src="https://cdn.shopify.com/s/files/1/0099/8739/1539/files/logo_c9b7ac76-a46a-4f08-8efa-31116091c03e.png?v=1613544583"
                            alt="logo"></a>
                </div>
                <div class="mega-menu">
                    <ul class="list-menu">
                        {!! $megaMenuHeader !!}
                    </ul>
                </div>
                <div class="child-content">
                    <div class="header-search">
                        <img src="{{ asset('assets/images/search.svg') }}" alt="">
                    </div>
                    <div class="my-account">
                        <i class="fa-solid fa-user"></i>
                        <div class="list-infor">
                            <ul class="infor-menu">
                                @if(!session()->exists('user'))
                                    <li class="infor-item">
                                        <a href="{{ route('Client.login') }}">Đăng nhập <i class="fa-solid fa-key"></i></a>
                                    </li>
                                @else
                                    <li class="infor-item">
                                        <a href="{{ route('Client.logout') }}">Đăng xuất <i class="fa-solid fa-arrow-right-from-bracket"></i></a>
                                    </li>
                                @endif
                                <li class="infor-item">
                                    <a href="{{ route('Client.register') }}">Đăng ký <i class="fa-solid fa-user-plus"></i></a>
                                </li>

                                <li class="infor-item">
                                    <a href="">Yêu thích <i class="fa-regular fa-heart"></i></a>
                                </li>
                                <li class="infor-item">
                                    <a href="">So sánh <i class="fa-solid fa-down-left-and-up-right-to-center"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="header-cart">
                        <a href="{{ route('carts.index') }}">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </a>
                        <span class="num-cart">
                            {{ Cart::instance('shopping')->count() }}
                        </span>
                    </div>
                </div>
            </nav>
            <div class="mega-menu--responsive">
                <div class="menu_sidebar_mobile animate__animated animate__bounce">
                    <div class="sidebar-title">
                        <i class="fa-sharp fa-solid fa-xmark"></i>
                    </div>
                    <ul class="list-menu-responsive">
                        {!! $menuResponse !!}
                    </ul>
                    <div class="list-contact">
                        <div class="item-contact">
                            <img
                                src="https://bizweb.dktcdn.net/100/438/408/themes/897269/assets/messages.svg?1678115195386"
                                alt="">
                            <a href="#">Tư vấn qua zalo</a>
                        </div>
                        <div class="item-contact">
                            <img
                                src="https://bizweb.dktcdn.net/100/438/408/themes/897269/assets/vector_userui.svg?1678115195386"
                                alt="">
                            <a href="#">Đăng nhập</a>
                        </div>
                        <div class="item-contact">
                            <img src="https://bizweb.dktcdn.net/100/438/408/themes/897269/assets/car.svg?1678115195386"
                                 alt="">
                            <a href="#">Đơn hàng của tôi</a>
                        </div>
                        <div class="item-contact">
                            <img
                                src="https://bizweb.dktcdn.net/100/438/408/themes/897269/assets/location.svg?1678115195386"
                                alt="">
                            <a href="#">Hệ thống cửa hàng</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="block-search animate__animated animate__bounce">
            <form>
                <input type="text" name="search" placeholder="Tìm kiếm" data-url="{{ route('home.search') }}">
                <span class="btn-close"><i class="fa-solid fa-xmark"></i></span>
                <div id="search-result-print">
                    <ul class="list-item-search"></ul>
                </div>
            </form>
        </div>
    </div>
</div>

