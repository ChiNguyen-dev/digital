@extends('layouts.admin')

@section('title')
    <title>Admin | Vai trò</title>
@endsection

@section('content')
    <div id="content" class="container-fluid pt-2">
        <div class="card">
            @include('partials.admin.title-form',['name'=>'Chỉnh sửa vai trò'])
            <div class="card-body">
                <form method="POST" action="{{ route('roles.update',['id' => $role->id]) }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tên vai trò:</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{ $role->name }}">
                    </div>
                    <div class="form-group">
                        <label for="display_name">Mô tả:</label>
                        <textarea class="form-control" name="display_name" id="display_name" cols="30"
                                  rows="3">{{ $role->display_name }}</textarea>
                    </div>
                    <div class="form-group mb-0">
                        <label for="display_name">Chọn hành vi:</label>
                    </div>
                    @foreach($permissionsParent as $permissionParentItem)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card bg-light mb-3" style="max-width: 100%;">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" class="mr-2 choose-actions" id="{{ Str::slug($permissionParentItem->name, '-') }}">
                                            <label class="form-check-label font-weight-bold" for="{{ Str::slug($permissionParentItem->name, '-') }}">
                                                {{ $permissionParentItem->name }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            @foreach($permissionParentItem->permissions as $permissionChildrentItem)
                                                <div class="col-md-3">
                                                    <div class="d-flex align-items-center">
                                                        <input {{ $role->permissions->contains('id', $permissionChildrentItem->id) ? 'checked' : '' }}
                                                               value="{{ $permissionChildrentItem->id }}"
                                                               id="{{ Str::slug($permissionChildrentItem->name, '-') }}"
                                                               class="mr-2 action_role" name="action_role[]" type="checkbox">
                                                        <label class="form-check-label"
                                                               for="{{ Str::slug($permissionChildrentItem->name, '-') }}">
                                                            {{ $permissionChildrentItem->name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/admin/js/role/index.js') }}"></script>
@endsection

