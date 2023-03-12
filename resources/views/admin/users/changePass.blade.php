@extends('layouts.admin')

@section('title')
    <title>Tài khoản</title>
@endsection

@section('content')
    <div id="content" class="container-fluid pt-4">
        <div class="card">
            @include('partials.admin.title-form',['name'=>'Đổi mật khẩu'])
            <div class="card-body">
                <form method="POST" action="{{ route('users.changePassword',['id' => \Illuminate\Support\Facades\Auth::id()]) }}">
                    @csrf
                    <div class="form-group">
                        <label for="password-old">Mật khẩu hiện tại</label>
                        <input class="form-control" type="password" name="passCurrent" id="password-old">
                    </div>
                    <div class="form-group">
                        @error("passCurrent")
                        <small class="text-validate form-text text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu mới</label>
                        <input class="form-control" type="password" name="password" id="password">
                    </div>
                    <div class="form-group">
                        @error("password")
                        <small class="text-validate form-text text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="pass-confirm">Xác nhận mật khẩu</label>
                        <input class="form-control" type="password" name="passConfirm" id="pass-confirm">
                    </div>
                    <div class="form-group">
                        @error("passConfirm")
                        <small class="text-validate form-text text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection

