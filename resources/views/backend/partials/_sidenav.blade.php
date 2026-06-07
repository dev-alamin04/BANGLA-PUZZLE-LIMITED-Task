<!-- sidebar  -->
<nav id="sidebar" class="sidebar" >
    <!-- Logo  -->
    <div class="logo d-flex justify-content-center">
        <a class="large_logo" href="{{ route('admin.dashboard') }}"><img
                src="{{ asset($systemSetting->logo ?? 'backend/assets/images/logo-default.svg') }} " alt="" /></a>
        <a class="small_logo" href="{{ route('admin.dashboard') }}">
            <img class="rounded-circle"
                src="{{ asset($systemSetting->favicon ?? 'backend/assets/images/logo-minimize.svg') }}" alt="logo"
                style="object-fit: contain; height: 35px; width: 45px; margin-top: 5px;" />
        </a>

        <div class="sidebar_close_icon d-lg-none">
            <i class="ti-close"></i>
        </div>
    </div>
    <li class="">
        <hr>
    </li>
    <ul id="sidebar_menu" class="mt-5">
        <li class="">
            <a href="/admin/dashboard" aria-expanded="false" class="active">
                <div class="nav_icon_small">
                    <i class="fas fa-home"></i>
                </div>
                <div class="nav_title">
                    <span>Dashboard</span>
                </div>
            </a>
        </li>
        <li class="">
            <a href="/admin/users" aria-expanded="false" class="active">
                <div class="nav_icon_small">
                    <i class="fas fa-users"></i>
                </div>
                <div class="nav_title">
                    <span>User Management</span>
                </div>
            </a>
        </li>

        <li class="">
            <a class="has-arrow" href="#" aria-expanded="false">
                <div class="nav_icon_small">
                    <i class="fas fa-shopping-basket"></i>
                </div>
                <div class="nav_title">
                    <span>Ecommerce</span>
                </div>
            </a>
            <ul>
                <li> <a href="/admin/categories">Categories</a> </li>
                <li> <a href="/admin/subcategories">Subcategories</a> </li>
                <li> <a href="/admin/products">Products</a> </li>
            </ul>
        </li>

        {{-- <li class="">
            <a>              
                <div class="nav_title">
                    <span>Settings & Support</span>
                </div>
            </a>
        </li> --}}


        <li class="">
            <a class="has-arrow" href="#" aria-expanded="false">
                <div class="nav_icon_small">
                    <i class="fa-solid fa-gear"></i>
                </div>
                <div class="nav_title">
                    <span>Settings</span>
                </div>
            </a>
            <ul>
                <li> <a href="/admin/profile">Profile Settings</a> </li>
                <li> <a href="/admin/system-setting">System Settings</a> </li>
                <li> <a href="/admin/dynamic-page">Dynamic Page</a> </li>
                <li> <a href="/admin/mail-setting">Mail Settings</a> </li>
            </ul>
        </li>
    </ul>
</nav>
<!--/ sidebar  -->
