@extends('layouts.form')

@section('content')
    <h2>Digital - Đăng nhập</h2>
    <div class="content">
        Xin chào, vui lòng nhập thông tin đăng nhập
    </div>
    <form action="{{ route('Client.login') }}" method="POST">
        @csrf
        <input type="email" name="email" placeholder="Địa chỉ email" value=" {{ old('email') }}">
        <input type="password" name="password" placeholder="Mật khẩu">
        @if($errors->any())
            <div class="box-error">
                <small class="d-block text-validate text-danger">*Sai thông tin đăng nhập</small>
                <a href="#" class="forgot-pass">Quên mật khẩu</a>
            </div>
        @else
            <a href="#" class="forgot-pass">Quên mật khẩu</a>
        @endif
        <button type="submit" name="btn-submit">Đăng nhập</button>
    </form>
    <p class="separator">Hoặc</p>
    <button type="submit" class="login-google">
        Đăng nhập bằng Google
        <div class="icon-gg">
            <img src="https://cdn-icons-png.flaticon.com/512/281/281764.png" alt="">
        </div>
    </button>
    <p class="register">Chưa có tài khoản Digial? <a href="{{ route('Client.register') }}">Đăng ký ngay</a></p>
@endsection
