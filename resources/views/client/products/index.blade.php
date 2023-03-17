@extends('layouts.client')

@section('title')
    <title>Sản phẩm</title>
@endsection

@section('content')
    <div class="container pt-4">
        <div class="row">
            <div class="col-md-3 pl-0">
                @include('partials.client.sidebar')
            </div>
            <div class="col-md-9 col-12">
                <div class="wp-products">
                    <div class="top-filler">
                        <div class="product-count">
                            Kết quả tìm thấy
                            <strong class="text-dark">{{ $products != null ? count($products) : 0 }} sản phẩm</strong>
                            cho bạn.
                        </div>
                        <div class="sort-by-select">
                            <select>
                                <option value="">Sắp xếp theo</option>
                                <option
                                    value="{{ route('products.category', [
                                        'cateSlug' => $category->slug,
                                        'sap-xep' => \Str::slug('Giá thấp đến cao'),
                                        'gia-ban' => request('gia-ban'),
                                    ]) }}">
                                    Giá thấp đến cao
                                </option>
                                <option
                                    value="{{ route('products.category', [
                                        'cateSlug' => $category->slug,
                                        'sap-xep' => \Str::slug('Giá cao đến thấp'),
                                        'gia-ban' => request('gia-ban'),
                                    ]) }}">
                                    Giá cao đến thấp
                                </option>
                            </select>
                        </div>
                    </div>
                    @if ($products != null)
                        <ul class="list-items justify-content-start">
                            <div class="row">
                                @foreach ($products as $product)
                                    <li class="item-link catalog">
                                        <div class="item-card-grid">
                                            <a href="{{ route('products.detail', ['slug' => $product->slug]) }}">
                                                <div class="image">
                                                    <img src="{{ asset($product->feature_image_path) }}"
                                                        alt="{{ $product->feature_image_name }}">
                                                </div>
                                            </a>
                                            <div class="product-item-details">
                                                <div class="evaluates">
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                </div>
                                                <div class="title">
                                                    <a href="{{ route('products.detail', ['slug' => $product->slug]) }}"
                                                        title="{{ $product->name }}">
                                                        {{ $product->name }}
                                                    </a>
                                                </div>
                                                <div class="price text-danger">
                                                    {{ number_format($product->price, 0, ',', '.') }}
                                                    <span class="text-decoration-underline">đ</span>
                                                </div>
                                            </div>
                                            <div class="product-buttons">
                                                <a href="#" title="yêu thích">
                                                    <i class="fa-regular fa-heart"></i>
                                                </a>
                                                <a href="{{ route('products.detail', ['slug' => $product->slug]) }}"
                                                    title="chi tiết">
                                                    <i class="fa-regular fa-eye"></i>
                                                </a>
                                                <a href="#" title="so sánh">
                                                    <i class="fa-solid fa-down-left-and-up-right-to-center"></i>
                                                </a>
                                            </div>
                                            <div class="product-labels">
                                                <span class="sale">sale</span>
                                                <span class="new">new</span>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </div>
                        </ul>
                    @endif
                </div>
                @if ($products != null)
                    <div class="d-flex align-items-center justify-content-end">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/client/js/product/index.js') }}"></script>
@endsection
