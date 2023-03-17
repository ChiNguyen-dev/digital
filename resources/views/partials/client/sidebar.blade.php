<div class="sidebar-filter">
    <div class="filter-list">
        <h5>Danh mục</h5>
        <div>
            {!! $menuSidebar !!}
        </div>
    </div>
</div>
<div class="sidebar-filter">
    <div class="filter-list">
        <h5>Giá bán</h5>
        <div>
            <ul>
                <li class="item-link">
                    <a href="{{ route('products.category',[
                                      'cateSlug' => $category->slug,
                                      'gia-ban' => \Str::slug('Dưới 10 triệu'),
                                      'sap-xep' => request('sap-xep')]) }}">
                        Dưới 10 triệu
                    </a>
                </li>
                <li class="item-link">
                    <a href="{{ route('products.category',[
                                 'cateSlug' => $category->slug,
                                 'gia-ban' => \Str::slug('10 - 20 triệu'),
                                 'sap-xep' => request('sap-xep')]) }}">
                        10 - 20 triệu
                    </a>
                </li>
                <li class="item-link">
                    <a href="{{ route('products.category',[
                                     'cateSlug' => $category->slug,
                                     'gia-ban' => \Str::slug('20 - 30 triệu'),
                                     'sap-xep' => request('sap-xep')]) }}">
                        20 - 30 triệu
                    </a>
                </li>
                <li class="item-link">
                    <a href="{{ route('products.category',[
                                         'cateSlug' => $category->slug,
                                         'gia-ban' => \Str::slug('trên 40 triệu'),
                                         'sap-xep' => request('sap-xep')]) }}">
                        trên 40 triệu
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="banner-item">
    <img src="https://cdn.shopify.com/s/files/1/0099/8739/1539/files/left_banner.jpg?v=1613544012" alt="">
</div>
<div class="banner-item">
    <img src="https://cdn.shopify.com/s/files/1/0099/8739/1539/files/left_banner_bfed8ae8-28b9-4d18-96d9-56153746d2c8.jpg?v=1613544582" alt="left_banner.webp">
</div>