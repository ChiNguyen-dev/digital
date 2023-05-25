@extends('layouts.form')

@section('content')
    <h2>Digital - Đăng ký tài khoản</h2>
    <div class="content">
        Xin chào, vui lòng nhập thông tin đăng ký
    </div>
    <form action="{{ route('Client.register') }}" method="POST">
        @csrf
        <input type="text" name="name" class="@error('name') mb-0 @enderror" placeholder="Họ và tên" value="{{ old('name') }}">
        @error('name')
        <div class="form-group">
            <small class="text-validate form-text text-danger">{{ $message }}</small>
        </div>
        @enderror
        <input type="email" name="email" class="@error('email') mb-0 @enderror" placeholder="Địa chỉ email" value="{{ old('email') }}">
        @error('email')
        <div class="form-group">
            <small class="text-validate form-text text-danger">{{ $message }}</small>
        </div>
        @enderror
        <div class="phone-number @error('phone_number') mb-0 @enderror">
            <div class="before">
                <img src="https://cdn-icons-png.flaticon.com/512/555/555515.png" alt="">
                <span>+ 84</span>
            </div>
            <input type="text" name="phone_number" placeholder="Số điện thoại" value="{{ old('phone_number') }}">
        </div>
        @error('phone_number')
        <div class="form-group">
            <small class="text-validate form-text text-danger">{{ $message }}</small>
        </div>
        @enderror
        <input type="password" name="password" class="@error('password') mb-0 @enderror" placeholder="Mật khẩu" value="{{ old('password') }}">
        @error('password')
        <div class="form-group">
            <small class="text-validate form-text text-danger">{{ $message }}</small>
        </div>
        @enderror
        <button type="submit" name="btn-submit">Đăng ký</button>
    </form>
    <p class="register">Bạn đã có tài khoản Digial? <a href="{{ route('Client.login') }}">Đăng nhập</a></p>
@endsection
