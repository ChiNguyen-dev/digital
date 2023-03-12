@extends('layouts.admin')

@section('title')
    <title>Tài khoản</title>
@endsection

@section('content')
    <div id="content" class="container-fluid pt-4">
        <div class="card">
            @include('partials.admin.title-form',['name'=>'Cập nhật thông tin'])
            <div class="card-body">
                <form method="POST" action="{{ route('users.account.update',['id' => $user->id ]) }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Họ và tên</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{ $user->name }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control" type="email" name="email" id="email" value="{{ $user->email }}">
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Số điện thoại</label>
                        <input class="form-control" type="text" name="phone_number" id="phone_number"
                               value="{{ $user->phone_number }}">
                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ</label>
                        <input class="form-control" type="text" name="address" id="address"
                               value="{{ $user->address }}">
                    </div>
                    <div class="form-group">
                        <label for="updated_at">Thay đổi gần đây :</label>
                        <input class="form-control" type="text" name="updated_at" id="updated_at"
                               value="{{ $user->updated_at }}" disabled>
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection
