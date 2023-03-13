@extends('layouts.form')

@section('content')
    <h2>Digital - Đăng ký tài khoản</h2>
    <div class="content">
        Xin chào, vui lòng nhập thông tin đăng ký
    </div>
    <form action="">
        <input type="text" name="name" placeholder="Họ và tên">
        <input type="email" name="email" placeholder="Địa chỉ email">
        <div class="phone-number">
            <div class="before">
                <img src="https://cdn-icons-png.flaticon.com/512/555/555515.png" alt="">
                <span>+ 84</span>
            </div>
            <input type="text" name="name" placeholder="Số điện thoại">
        </div>
        <input type="password" name="password" placeholder="Mật khẩu">
        <button type="submit" name="btn-submit">Đăng ký</button>
    </form>
    <p class="register">Bạn đã có tài khoản Digial? <a href="{{ route('Client.login') }}">Đăng nhập</a></p>
@endsection
