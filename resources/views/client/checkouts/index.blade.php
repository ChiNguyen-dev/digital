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
                        <div class="form_address">
                            <div class="group-country">
                                <div class="form-group select-field">
                                    <select id="different-address" class="form-control"
                                            data-url="{{ route('checkout.index') }}">
                                        <option value="">Địa chỉ khác</option>
                                        @if(!empty($customerVariants))
                                            @foreach($customerVariants as $variant)
                                                <option value="{{ $variant->id }}">
                                                    {{ $variant->name . ', ' . $variant->address }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label>Sổ địa chỉ</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="fied col-md-6">
                                    <fieldset class="form-group">
                                        <input type="text" class="form-control" name="name" id="name" value=""
                                               placeholder=" ">
                                        <label>Họ tên</label>
                                    </fieldset>
                                    <div class="form-group">
                                        @error("name")
                                        <small class="text-validate form-text text-danger m-0">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="fied col-md-6">
                                    <fieldset class="form-group">
                                        <input type="text" class="form-control" name="phone_number" id="phone_number"
                                               value="" placeholder=" ">
                                        <label>Số điện thoại</label>
                                    </fieldset>
                                    <div class="form-group">
                                        @error("phone_number")
                                        <small class="text-validate form-text text-danger m-0">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="fied col-md-12">
                                    <fieldset class="form-group">
                                        <input type="email" class="form-control" name="email" id="email"
                                               placeholder=" " value="">
                                        <label>Email</label>
                                    </fieldset>
                                    <div class="form-group">
                                        @error("email")
                                        <small class="text-validate form-text text-danger m-0">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="fied col-md-12">
                                    <fieldset class="form-group">
                                        <input type="text" class="form-control" name="address" id="address" value=""
                                               placeholder=" ">
                                        <label>Địa chỉ</label>
                                    </fieldset>
                                    <div class="form-group">
                                        @error("address")
                                        <small class="text-validate form-text text-danger m-0">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="group-country d-flex">
                                <fieldset class="form-group select-field">
                                    <select name="province" id="province" class="form-control choose-address"
                                            data-url="{{ route('account.address') }}" data-key='province'>
                                        <option value="">---</option>
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->matp }}">{{ $province->name }}</option>
                                        @endforeach
                                    </select>
                                    <label>Tỉnh thành</label>
                                </fieldset>
                                <fieldset class="form-group select-field">
                                    <select name="district" id="district" class="form-control choose-address"
                                            disabled="disabled" data-url="{{ route('account.address') }}"
                                            data-key='district'>
                                        <option value="">---</option>
                                    </select>
                                    <label>Quận huyện</label>
                                </fieldset>
                                <fieldset class="form-group select-field">
                                    <select name="ward" id="ward" class="form-control" disabled="disabled">
                                        <option value="">---</option>
                                    </select>
                                    <label>Phường xã</label>
                                </fieldset>
                            </div>
                            @error("province")
                            <div class="form-group">
                                <small class="text-validate form-text text-danger m-0">{{$message}}</small>
                            </div>
                            @enderror
                            @error("district")
                            <div class="form-group">
                                <small class="text-validate form-text text-danger m-0">{{$message}}</small>
                            </div>
                            @enderror
                            @error("ward")
                            <div class="form-group">
                                <small class="text-validate form-text text-danger m-0">{{$message}}</small>
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row ">
                            <div class="col-md-12">
                                <h5 class="title-check">Sản phẩm</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        @foreach ($carts->getCartItems() as $item)
                                            <div class="item-check">
                                                <div class="item-image">
                                                    <img src="{{ asset($item->getImage()) }}">
                                                </div>
                                                <div class="item-detail-infor">
                                                    <p>{{ $item->getName() }}</p>
                                                    <div class="color-box">
                                                        <strong>Màu sắc:</strong>
                                                        <span class="active_color">
                                                            @php $colors = $item->getOption('colors') @endphp
                                                            @foreach($colors as $color)
                                                                @if($color->selected)
                                                                    <i style="background-color: {{ $color->style }}; color: {{ $color->style }};"
                                                                       title="Space Gray"
                                                                       class="fa-solid fa-circle-check"></i>
                                                                @endif
                                                            @endforeach
                                                        </span>
                                                    </div>
                                                    <div class="box-quantity">
                                                        Số lượng: {{ $item->getQty() }}
                                                        <strong class="text-danger">
                                                            {{ number_format($item->getPrice(), 0, ',', '.') }}đ
                                                        </strong>
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
                                    <p class="text-danger">{{ number_format($carts->getTotal(), 0,',','.') }}đ</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="type-checkout">
                                    <div class="d-flex align-items-center mr-3 mb-3">
                                        <input class="mr-1" type="radio" name="payment_method" id="type1"
                                               checked value="1">
                                        <label class="mb-0" for="type1">Thanh toán tại nhà</label>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <input class="mr-1" type="radio" name="payment_method" id="type2"
                                               value="0">
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
