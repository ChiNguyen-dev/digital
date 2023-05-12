@extends('layouts.client')

@section('title')
    <title>Trang chủ</title>
@endsection

@section('content')
    <div class="wp-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="cart-wp">
                        <div class="cart-title">
                            <h5>Giỏ hàng</h5>
                        </div>
                        @if (!empty($carts['count']))
                            <table id="table-cart" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">Thứ tự</th>
                                    <th scope="col">Hình ảnh</th>
                                    <th scope="col">Tên sản phẩm</th>
                                    <th scope="col">Số lượng</th>
                                    <th scope="col">Đơn giá</th>
                                    <th scope="col">Màu sắc</th>
                                    <th scope="col">Xóa</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $index = 0; @endphp
                                @if (!empty($carts['data']))
                                    @foreach ($carts['data'] as $key => $item)
                                        @php $index++ @endphp
                                        <tr>
                                            <th class="text-center col-stt" scope="row">{{ $index }}</th>
                                            <td class="col-img col-img">
                                                <img src="{{ $item->options->image }}" alt="">
                                            </td>
                                            <td class="col-name">
                                                <a href="">{{ $item->name }}</a>
                                            </td>
                                            <td class="text-center col-qty">
                                                <select class="qty_in_cart"
                                                        data-url="{{ route('carts.updateQty', ['id' => $key]) }}">
                                                    @for ($i = 1; $i <= 10; $i++)
                                                        <option
                                                            {{ $i == $item->qty ? 'selected' : '' }} value="{{ $i }}">
                                                            {{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </td>
                                            <td class="text-center">{{ number_format($item->price, 0, ',', '.') }}đ</td>
                                            <td class="text-center">
                                                @php $colors = \App\Models\Product::find($item->id)->colors; @endphp
                                                <select class="color_in_cart"
                                                        data-url="{{ route('carts.updateColor', ['id' => $key]) }}">
                                                    @foreach ($colors as $color)
                                                        <option
                                                            {{ $color->id == $item->options->color ? 'selected' : '' }}
                                                            value="{{ $color->id }}">{{ $color->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="text-center col-remove"
                                                data-url="{{ route('carts.deleteItem', ['id' => $key]) }}">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        @endif
                        <div class="cart-body">
                            <div class="cart-empty">
                                <div class="cart-image">
                                    <img src="{{ asset('assets/images/cart-empty.png') }}" alt="">
                                </div>
                                <p>Giỏ hàng chưa có sản phẩm nào</p>
                                <a href="{{ route('client.home') }}" class="btn-buy-now">Mua sắm ngay</a>
                            </div>
                        </div>
                    </div>
                </div>
                @if (!empty($carts['count']))
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between pb-4 pt-3">
                            <div class="remind">
                                <p>Nhấp vào thanh toán để hoàn tất mua hàng</p>
                                <a href="{{ route('client.home') }}">
                                    <i class="fa-solid fa-hand-point-right"></i>
                                    Mua tiếp
                                </a>
                                <a href="{{ route('carts.delete') }}">
                                    <i class="fa-solid fa-hand-point-right"></i>
                                    Xóa giỏ hàng
                                </a>
                            </div>
                            <div class="order">
                                <div class="total">
                                    Tổng thanh toán: <span>{{ number_format($carts['total'], 0, ',', '.') }}đ</span>
                                </div>
                                <a href="{{ route('checkout.index') }}" class="btn btn-buy">Thanh toán</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/client/js/cart/index.js') }}"></script>
@endsection
