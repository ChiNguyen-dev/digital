<div id="sidebar" class="bg-white">
    <ul id="sidebar-menu">
        <li class="nav-link">
            <div class="d-flex align-items-center justify-content-between">
                <a href="{{ route('admin.dashboard') }}">
                    <div class="nav-link-icon d-inline-block"><i class="far fa-folder"></i></div>
                    Dashboard
                </a>
            </div>
        </li>
        @can(config('permissions.modules.sliders.show'))
            <li class="nav-link">
                <div class="d-flex align-items-center justify-content-between">
                    <a href="{{ route('sliders.index') }}">
                        <div class="nav-link-icon d-inline-block"><i class="far fa-folder"></i></div>
                        Slider
                    </a>
                </div>
            </li>
        @endcan
        @can(config('permissions.guards.isAdmin'))
            <li class="nav-link">
                <div class="d-flex align-items-center justify-content-between">
                    <a href="{{ route('users.index') }}">
                        <div class="nav-link-icon d-inline-block"><i class="far fa-folder"></i></div>
                        Thành viên
                    </a>
                </div>
            </li>
        @endcan
        @canany([config('permissions.modules.colors.show'),config('permissions.modules.categories.show'),config('permissions.modules.products.show')])
            <li class="nav-link">
                <div class="d-flex align-items-center justify-content-between">
                    <a href="{{ route('product.index') }}">
                        <div class="nav-link-icon d-inline-block"><i class="far fa-folder"></i></div>
                        Sản phẩm
                    </a>
                    <i class="arrow fas fa-angle-right"></i>
                </div>
                <ul class="sub-menu">
                    @can(config('permissions.modules.colors.show'))
                        <li><a href="{{ route('color.index') }}">Danh sách màu sắc</a></li>
                    @endcan
                    @can(config('permissions.modules.categories.show'))
                        <li><a href="{{ route('categories.index') }}">Danh sách danh mục</a></li>
                    @endcan
                </ul>
            </li>
        @endcanany
        @can(config('permissions.guards.isAdmin'))
            @canany([config('permissions.modules.customers.show'),config('permissions.modules.orders.show')])
                <li class="nav-link">
                    <div class="d-flex align-items-center justify-content-between">
                        <a href="">
                            <div class="nav-link-icon d-inline-block"><i class="far fa-folder"></i></div>
                            Bán hàng
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                    </div>
                    <ul class="sub-menu">
                        @can(config('permissions.modules.customers.show'))
                            <li><a href="{{ route( 'customer.index') }}">Danh sách khách hàng</a></li>
                        @endcan
                        @can(config('permissions.modules.orders.show'))
                            <li><a href="{{ route('orders.index') }}">Danh sách đơn hàng</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            <li class="nav-link">
                <div class="d-flex align-items-center justify-content-between">
                    <a href="{{ route('roles.index') }}">
                        <div class="nav-link-icon d-inline-block"><i class="far fa-folder"></i></div>
                        Danh sách vai trò
                    </a>
                </div>
            </li>
            <li class="nav-link">
                <div class="d-flex align-items-center justify-content-between">
                    <a href="{{ route('permissions.index') }}">
                        <div class="nav-link-icon d-inline-block"><i class="far fa-folder"></i></div>
                        Danh sách quyền
                    </a>
                </div>
            </li>
        @endcan
    </ul>
</div>
