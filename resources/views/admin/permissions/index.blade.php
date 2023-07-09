@extends('layouts.admin')

@section('title')
    <title>Admin | Quyền</title>
@endsection

@section('content')
    <div class="row container-fluid ml-0 pt-2">
        <div class="card w-100" id="list-product">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách quyền</h5>
                <div class="form-search form-inline">
                    <form action="#" class="d-flex">
                        <input type="text" class="form-control form-search shadow-none" placeholder="Tìm kiếm"
                               name="search" value="{{ request()->search }}">
                        <button type="submit" class="button ml-3"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </div>
            </div>
            <div class="card-body pb-0">
                <div class="analytic pb-3">
                    <div class="analytic__status">
                        <a href="#" class="text-primary">
                            Số lượng <span class="text-muted">({{ $status->permissionQty }})</span>
                        </a>
                        <a href="#" class="text-primary">
                            Thùng rác <span class="text-muted analytic__status__number-delete">({{ $status->deletedQty }})</span>
                        </a>
                    </div>
                    <div class="analytic__add mr-0">
                        <a href="{{ route('permissions.create') }}" class="button">Thêm</a>
                    </div>
                </div>
                <table class="table table-striped mb-5">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tên</th>
                        <th scope="col">Key code</th>
                        <th scope="col">Thời gian</th>
                        <th scope="col" class="text-center">Tác vụ</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($permissions as $key => $permission)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>{{ Str::of($permission->key_code)->isEmpty() ? 'default' : $permission->key_code }}</td>
                            <td>{{ $permission->created_at }}</td>
                            <td class="d-flex align-items-center justify-content-center">
                                <a href="{{ route('permissions.edit',['id' => $permission->id]) }}"
                                   class="btn-edit text-success" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a data-url="{{ route('permissions.delete',['id' => $permission->id]) }}"
                                   href="#" class="btn-delete text-danger" title="Delete">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $permissions->links() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/admin/js/permission/index.js') }}"></script>
@endsection

