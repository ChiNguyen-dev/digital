@extends('layouts.admin')

@section('title')
    <title>Admin | Thành viên</title>
@endsection

@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link rel="stylesheet" href="{{ asset('assets/admin/css/productForm.css') }}">
@endsection

@section('content')
    <div id="content" class="container-fluid pt-4">
        <div class="card">
            @include('partials.admin.title-form', ['name' => 'Chỉnh sửa thông tin'])
            <div class="card-body">
                <form method="POST" action="{{ route('users.update', ['id' => $user->id]) }}">
                    @csrf
                    <div class="form-input-group d-flex align-items-center">
                        <label for="name">Họ và tên:</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{ $user->name }}">
                    </div>
                    <div class="form-input-group d-flex align-items-center">
                        <label for="email">Email:</label>
                        <input class="form-control" type="text" name="email" id="email"
                            value="{{ $user->email }}">
                    </div>
                    <div class="form-input-group d-flex align-items-center">
                        <label for="phone_number">Số điện thoại:</label>
                        <input class="form-control" type="text" name="phone_number" id="phone_number"
                               value="{{ $user->phone_number }}">
                    </div>
                    <div class="form-input-group d-flex align-items-center">
                        <label for="address">Địa chỉ:</label>
                        <input class="form-control" type="text" name="address" id="address"
                               value="{{ $user->address }}">
                    </div>
                    <div class="form-input-group d-flex align-items-center">
                        <label for="password" style="flex-basis: 16.8%;">Vai trò (<span class="text-danger">*</span>):</label>
                        <select class="select2-role" name="role_id[]" multiple>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->roles->contains('id', $role->id) ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="button-group">
                        <a href="{{ route('users.index') }}" class="button-cancel">Hủy</a>
                        <button type="submit" class="button">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/admin/js/user/select2.js') }}"></script>
@endsection
