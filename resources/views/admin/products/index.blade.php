@extends('layouts.admin')

@section('title')
    <title>Admin | Sản phẩm</title>
@endsection

@section('content')
    <div class="row container-fluid ml-0 pt-2">
        <div class="card w-100" id="list-product">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách sản phẩm</h5>
                <div class="form-search form-inline">
                    <form action="{{ route('product.search') }}" class="d-flex" method="POST">
                        @csrf
                        <input type="text" class="form-control form-search" placeholder="Tìm kiếm" name="search"
                               value="{{ request()->search }}">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary ml-2">
                    </form>
                </div>
            </div>
            <div class="card-body pb-0">
                <div class="analytic">
                    <div class="analytic__status">
                        <a href="" class="text-primary">
                            Thành công <span class="text-muted">({{ $status->success }})</span>
                        </a>
                        <a href="" class="text-primary">
                            Đang xử lý <span class="text-muted">({{ $status->processing }})</span>
                        </a>
                        <a href="" class="text-primary">
                            Số lượng <span class="text-muted">({{ $status->quantity }})</span>
                        </a>
                        <a href="" class="text-primary">
                            Thùng rác <span
                                class="text-muted analytic__status__number-delete">({{ $status->deleted }})</span>
                        </a>
                    </div>
                    @can(config('permissions.modules.products.add'))
                        <div class="analytic__add mr-0">
                            <a href="{{route('product.create')}}" class="btn btn-primary text-white text-center">
                                Thêm sản mới
                            </a>
                        </div>
                    @endcan
                </div>
                <form action="{{ route('product.updateAll') }}" method="POST">
                    @csrf
                    <div class="form-action form-inline py-3">
                        @can(config('permissions.guards.isAdmin'))
                            <select class="form-control mr-1" name="option">
                                <option value="">Chọn</option>
                                <option value="1">Công khai</option>
                                <option value="0">Đang xử lý</option>
                                <option value="2">Bỏ vào thùng rác</option>
                            </select>
                            <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                        @endcan
                    </div>
                    <table class="table table-striped table-checkall mb-3">
                        <thead>
                        <tr>
                            @can(config('permissions.guards.isAdmin'))
                                <th scope="col"><input name="check" type="checkbox" class="checkAll"></th>
                            @endcan
                            <th scope="col">#</th>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Danh mục</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Trạng thái</th>
                            @canany([config('permissions.guards.isPermissionEdit'),config('permissions.guards.isPermissionDelete')])
                                <th scope="col">Tác vụ</th>
                            @endcanany
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $key => $item)
                            <tr>
                                @can(config('permissions.guards.isAdmin'))
                                    <td>
                                        <input type="checkbox" value="{{ $item->id }}" class="checkBox" name="check[]">
                                    </td>
                                @endcan
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <div class="image-item">
                                        <img src="{{ asset( $item->feature_image_path )}}"
                                             alt="{{ $item->feature_image_name }}" title="{{ $item->name }}">
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('product.edit',['id'=> $item->id]) }}" title="{{ $item->name }}"
                                       class="text-item">
                                        {{ $item->name }}
                                    </a>
                                </td>
                                <td>{{ number_format($item->price) }}đ</td>
                                <td>{{ optional($item->category)->cate_name }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td class="text-center">
                                        <span
                                            class="{{ $item->status === 0 ? 'badge bg-warning' : 'badge bg-success text-white' }}">
                                         {{ $item->status === 0 ? 'đang xử lý' : 'công khai' }}
                                        </span>
                                </td>
                                <td class="text-center">
                                    @can(config('permissions.modules.products.edit'),[$item->id])
                                        <a href="{{ route('product.edit',['id'=> $item->id]) }}"
                                           class="btn-edit text-success" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    @endcan
                                    @can(config('permissions.modules.products.delete'),[$item->id])
                                        <a href="#" data-url="{{ route('product.delete',['id'=> $item->id]) }}"
                                           class="btn-delete text-danger" title="Delete">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </form>
                {{ $products->appends(['search'=>request()->search])->links() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/admin/js/product/index.js') }}"></script>
@endsection
