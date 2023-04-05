@extends('layouts.client')

@section('title')
    <title>Trang khách hàng</title>
@endsection

@section('content')
    <section class="bread-crumb">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="home">
                            <a href="">Trang chủ</a>
                            <span class="mr_lr">&nbsp;/&nbsp;</span>
                        </li>
                        <li>
                            <a href="">Tài khoản</a>
                        </li>
                        <li class="last">
                            <h5>Tài khoản</h5>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="page_customer_account">
        <div class="wp-container">
            <div class="row">
                <div class="col-left-ac">
                    <div class="block-account">
                        <div class="infor">
                            <div class="thumbnail">
                                <img src="https://cdn-user-icons.flaticon.com/98578/98578114/1680694404780.svg?token=exp=1680695305~hmac=4538ed6f49608897a3fc0a061fbee4fc" alt="">
                            </div>
                            <p>{{ Auth::guard('client')->user()->name }}</p>
                            <a href="{{ route('Client.logout') }}" class="click_logout">Đăng xuất</a>
                        </div>
                        <ul>
                            <li>
                                <a href="" class="title-info active">Tài khoản của tôi</a>
                            </li>
                            <li>
                                <a href="" class="title-info">Đơn hàng của tôi</a>
                            </li>
                            <li>
                                <a href="" class="title-info">Đổi mật khẩu</a>
                            </li>
                            <li>
                                <a href="" class="title-info">Sản phẩm yêu thích</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-right-ac">
                    <h1 class="title-head">
                        Thông tin cá nhân
                        <button class="btn">Sửa thông tin</button>
                    </h1>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
@endsection
