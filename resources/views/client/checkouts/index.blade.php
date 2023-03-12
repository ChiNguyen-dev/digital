@extends('layouts.client')

@section('title')
    <title>Thanh toán</title>
@endsection

@section('content')
    <div class="wp-content pb-5">
        <form action="{{ route('orders.store') }}" method="post">
            @csrf
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="title-check">Thông tin khách hàng</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row d-flex">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fw-500" for="name">Họ và tên:</label>
                                            <input type="text" name="name" placeholder="Nhập vào họ và tên" id="name"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   value="{{ old('name') }}">
                                        </div>
                                        <div class="form-group">
                                            @error("name")
                                            <small class="text-validate form-text text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label class="fw-500">Danh xưng:</label>
                                        </div>
                                        <div class="d-flex">
                                            <div class="d-flex align-items-center mr-3">
                                                <input class="mr-1" type="radio" name="nickname" id="nickname1" checked>
                                                <label class="mb-0" for="nickname1">Anh</label>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <input class="mr-1" type="radio" name="nickname" id="nickname2">
                                                <label class="mb-0" for="nickname2">Chị</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-flex">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fw-500" for="name">Email:</label>
                                            <input type="text" id="name" name="email" placeholder="Địa chỉ email"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   value="{{ old('email') }}">
                                        </div>
                                        <div class="form-group">
                                            @error("email")
                                            <small class="text-validate form-text text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fw-500" for="name">Số điện thoại:</label>
                                            <input type="text" name="phone" id="name"
                                                   placeholder="Nhập vào số điện thoại"
                                                   class="form-control @error('phone') is-invalid @enderror"
                                                   value="{{ old('phone') }}">
                                        </div>
                                        <div class="form-group">
                                            @error("phone")
                                            <small class="text-validate form-text text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-flex">
                                    <div class="col-md-12">
                                        <label class="fw-500" for="province">Địa chỉ:</label>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select id="province" name="province" data-type="1"
                                                    class="form-control select-address @error('province') is-invalid @enderror"
                                                    data-url="{{ route('checkout.changeAddress') }}">
                                                <option value="">Chọn tỉnh, thành phố</option>
                                                @foreach($provinces as $province)
                                                    <option value="{{ $province->matp }}">{{ $province->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            @error("province")
                                            <small class="text-validate form-text text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select id="district" data-type="2" name="district"
                                                    class="form-control select-address @error('district') is-invalid @enderror"
                                                    data-url="{{ route('checkout.changeAddress') }}">
                                                <option value="">Chọn quận, huyện</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            @error("district")
                                            <small class="text-validate form-text text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select id="ward" name="ward" data-type="3"
                                                    class="form-control select-address @error('ward') is-invalid @enderror"
                                                    data-url="{{ route('checkout.changeAddress') }}">
                                                <option value="">Chọn phường, xã, thị trấn</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            @error("ward")
                                            <small class="text-validate form-text text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="fw-500" for="required-different">Yêu cầu khác (<span
                                                    class="text-danger">* không bắt buộc</span>)</label>
                                            <textarea class="form-control" id="required-different" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="row ">
                            <div class="col-md-12">
                                <h5 class="title-check">Sản phẩm</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        @foreach(Cart::instance('shopping')->content() as $item)
                                            <div class="item-check">
                                                <div class="item-image">
                                                    <img src="{{ asset($item->options->image) }}">
                                                </div>
                                                <div class="item-detail-infor">
                                                    <p>{{ $item->name }}</p>
                                                    <div class="color-box">
                                                        <strong>Màu sắc:</strong>
                                                        <span class="active_color">
                                                            @php $color = \App\Models\Color::find($item->options->color) @endphp
                                                            <i style="background-color: {{ $color->style }}; color: {{ $color->style }};"
                                                               title="Space Gray"
                                                               class="fa-solid fa-circle-check"></i>
                                                        </span>
                                                    </div>
                                                    <div class="box-quantity">
                                                        Số lượng: {{ $item->qty }}
                                                        <strong
                                                            class="text-danger">{{ number_format($item->price,0,',','.') }}
                                                            đ</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="box-total">
                                    <p>Tổng thanh toán:</p>
                                    <p class="text-danger">{{ Cart::instance('shopping')->subtotal(0,',','.') }}đ</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="type-checkout">
                                    <div class="d-flex align-items-center mr-3 mb-3">
                                        <input class="mr-1" type="radio" name="payment_method" id="type1" checked value="1">
                                        <label class="mb-0" for="type1">Thanh toán tại nhà</label>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <input class="mr-1" type="radio" name="payment_method" id="type2" value="0">
                                        <label class="mb-0" for="type2">Thanh toán qua thẻ</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="btn-order">
                                    <button type="submit">Đặt hàng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/client/js/checkout/index.js') }}"></script>
@endsection
