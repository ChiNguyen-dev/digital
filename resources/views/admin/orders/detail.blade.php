@extends('layouts.admin')

@section('title')
    <title>Admin | Đơn Hàng</title>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/detailOrder.css') }}">
@endsection

@section('content')
    <div class="row container-fluid ml-0 pt-2">
        <div class="card w-100" id="list-product">
            <div class="card-header font-weight-bold d-flex align-items-center">
                <h5 class="m-0 ">Thông tin chi tiết</h5>
            </div>
            <div class="card-body">
                <div class="row mb-4 pl-3">
                    <div class="col-md-12">
                        <h6>Mã đơn hàng:</h6>
                    </div>
                    <div class="col-md-12">
                        <p class="">#{{ $order->id }}</p>
                    </div>
                    <div class="col-md-12">
                        <h6>Số điện thoại:</h6>
                    </div>
                    <div class="col-md-12">
                        <p class="">{{ $customer->phone_number }}</p>
                    </div>
                    <div class="col-md-12">
                        <h6>Email:</h6>
                    </div>
                    <div class="col-md-12">
                        <p class="">{{ $customer->email }}</p>
                    </div>
                    <div class="col-md-12">
                        <h6>Địa chỉ:</h6>
                    </div>
                    <div class="col-md-12">
                        <p class="">{{ $customer->address }}</p>
                    </div>
                    <div class="col-md-12">
                        <h6>Phương thức thanh toán:</h6>
                    </div>
                    <div class="col-md-12">
                        <p class="">
                            - {{ $order->payment_method == 1 ? 'Thanh toán tại nhà' : 'Thanh toán qua thẻ' }}</p>
                    </div>
                    <div class="col-md-12">
                        <div class="form-action form-inline">
                            @can(config('permissions.modules.orders.update'))
                                <form action="{{ route('orders.update') }}" method="POST">
                                    @csrf
                                    <select class="form-control mr-1" name="option">
                                        <option @if($order->status == null) selected @endif value="">Chọn</option>
                                        <option @if($order->status == 1) selected @endif value="1">Thành công</option>
                                        <option @if($order->status == 0) selected @endif value="0">Đang xử lý</option>
                                        <option @if($order->status == 2) selected @endif value="2">Bỏ vào thùng rác
                                        </option>
                                    </select>
                                    <input type="hidden" name="check[]" value="{{ $order->id }}">
                                    <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5>Sản phẩm đơn hàng:</h5>
                    </div>
                    <div class="col-md-12">
                        <table id="table-cart" class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">Thứ tự</th>
                                <th scope="col">Hình ảnh</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Đơn giá</th>
                                <th scope="col">Màu sắc</th>
                                <th scope="col">Thành tiền</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $qty = 0; @endphp
                            @foreach($order_item as $key => $v)
                                <tr>
                                    <th class="text-center col-stt" scope="row">{{ $key + 1 }}</th>
                                    <td class="col-img col-img">
                                        <img src="{{ asset($v->product->feature_image_path)  }}"
                                             alt="{{ $v->product->feature_image_name }}">
                                    </td>
                                    <td class="col-name">{{ $v->product->name }}</td>
                                    <td class="text-center col-qty">{{ $v->quantity }}</td>
                                    @php $item = $v->product; @endphp
                                    <td class="text-center">{{ number_format($item->price,0,',','.') }}đ</td>
                                    <td class="text-center">{{ $v->color->name }}</td>
                                    <td class="text-center">{{ number_format($v->quantity * $item->price,0,',','.') }}
                                        đ
                                    </td>
                                </tr>
                                @php $qty += $v->quantity; @endphp
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <h5>Giá trị đơn hàng</h5>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="row">
                            <div class="col-md-2 text-right">
                                <h6 class="mb-0">Tổng số lượng:</h6>
                            </div>
                            <div class="col-md-10">
                                <h6 class="mb-0">{{ $qty }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2 text-right">
                                <p class="amount-item text-danger">Tổng đơn hàng:</p>
                            </div>
                            <div class="col-md-10">
                                <p class="total-order text-danger">{{ number_format($order->total, 0,',','.') }}đ</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
