@extends('layouts.form')

@section('content')
    <h2>Digital - Đăng nhập</h2>
    <div class="content">
        Xin chào, vui lòng nhập thông tin đăng nhập
    </div>
    <form action="{{ route('Client.login') }}" method="POST">
        @csrf
        <input type="email" name="email" class="@error("email") mb-0 @enderror" placeholder="Địa chỉ email" value=" {{ old('email') }}">
        @error("email")
        <div class="form-group">
            <small class="text-validate form-text text-danger">{{ $message }}</small>
        </div>
        @enderror
        <input type="password" name="password" placeholder="Mật khẩu">
        <div class="form-group">
            @error("password")
            <small class="text-validate form-text text-danger">{{ $message }}</small>
            @enderror
            @error("invalid")
            <small class="text-validate form-text text-danger">{{ $message }}</small>
            @enderror
            <a href="#" class="forgot-pass">Quên mật khẩu</a>
        </div>
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
