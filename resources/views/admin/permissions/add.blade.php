@extends('layouts.admin')

@section('title')
    <title>Admin | Quyền</title>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/productForm.css') }}">
@endsection

@section('content')
    <div id="content" class="container-fluid pt-2">
        <div class="card">
            @include('partials.admin.title-form',['name'=>'Thêm quyền'])
            <div class="card-body">
                <form method="POST" action="{{ route('permissions.store') }}">
                    @csrf
                    <div class="form-input-group d-flex align-items-center">
                        <label for="name">Tên (<span class="text-danger">*</span>):</label>
                        <input type="text" name="name" id="name" value="">
                    </div>
                    <div class="form-input-group d-flex align-items-center">
                        <label for="display_name">Mô tả (<span class="text-danger">*</span>):</label>
                        <input type="text" name="display_name" id="display_name" value="">
                    </div>
                    <div class="form-input-group d-flex align-items-center">
                        <label for="parent_id">Chọn quyền (<span class="text-danger">*</span>):</label>
                        <select name="parent_id" id="parent_id">
                            <option value="0">Chọn quyền cha</option>
                            {!! $htmlOptions !!}
                        </select>
                    </div>
                    <div class="form-input-group d-flex align-items-center">
                        <label for="key_code">Key code (<span class="text-danger">*</span>):</label>
                        <input type="text" name="key_code" id="key_code" value="">
                    </div>
                    <div class="button-group">
                        <a href="{{ route('permissions.index') }}" class="button-cancel">Hủy</a>
                        <button type="submit" class="button">Thêm mới</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

