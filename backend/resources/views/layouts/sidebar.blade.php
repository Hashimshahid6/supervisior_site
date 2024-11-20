<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="index" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-dark-sm.png') }}" alt="" height="26">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo-dark.png') }}" alt="" height="28">
            </span>
        </a>

        <a href="index" class="logo logo-light">
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo-light.png') }}" alt="" height="30">
            </span>
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-light-sm.png') }}" alt="" height="26">
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn">
        <i class="bx bx-menu align-middle"></i>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Dashboard</li>

               <li>
                    <a href="javascript: void(0);">
                        <i class="bx bx-home-alt icon nav-icon"></i>
                        <span class="menu-item" data-key="t-dashboard">Dashboard</span>
                        <span class="badge rounded-pill bg-primary">2</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="index" data-key="t-ecommerce">Ecommerce</a></li>
                        <li><a href="dashboard-sales" data-key="t-sales">Sales</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="bx bx-store icon nav-icon"></i>
                        <span class="menu-item" data-key="t-ecommerce">Ecommerce</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('hero_sections.index')}}" data-key="t-products">Products</a></li>
                        <li><a href="ecommerce-product-detail" data-key="t-product-detail">Product Detail</a></li>
                        <li><a href="ecommerce-orders" data-key="t-orders">Orders</a></li>
                        <li><a href="ecommerce-customers" data-key="t-customers">Customers</a></li>
                        <li><a href="ecommerce-cart" data-key="t-cart">Cart</a></li>
                        <li><a href="ecommerce-checkout" data-key="t-checkout">Checkout</a></li>
                        <li><a href="ecommerce-shops" data-key="t-shops">Shops</a></li>
                        <li><a href="ecommerce-add-product" data-key="t-add-product">Add Product</a></li>
                    </ul>
                </li>

               

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="bx bx-receipt icon nav-icon"></i>
                        <span class="menu-item" data-key="t-invoices">Invoices</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="invoices-list" data-key="t-invoice-list">Invoice List</a></li>
                        <li><a href="invoices-detail" data-key="t-invoice-detail">Invoice Detail</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="bx bx-user-circle icon nav-icon"></i>
                        <span class="menu-item" data-key="t-contacts">Contacts</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="contacts-grid" data-key="t-user-grid">User Grid</a></li>
                        <li><a href="contacts-list" data-key="t-user-list">User List</a></li>
                        <li><a href="contacts-profile" data-key="t-user-profile">Profile</a></li>
                    </ul>
                </li>

                <li class="menu-title" data-key="t-pages">Pages</li>

                <li>
                    <a href="javascript: void(0);">
                        <i class="bx bx-user-pin icon nav-icon"></i>
                        <span class="menu-item" data-key="t-authentication">Authentication</span>
                        <span class="badge rounded-pill bg-info">8</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="auth-login" data-key="t-login">Login</a></li>
                        <li><a href="auth-register" data-key="t-register">Register</a></li>
                        <li><a href="auth-recoverpw" data-key="t-recover-password">Recover Password</a></li>
                        <li><a href="auth-lock-screen" data-key="t-lock-screen">Lock Screen</a></li>
                        <li><a href="auth-logout" data-key="t-logout">Logout</a></li>
                        <li><a href="auth-confirm-mail" data-key="t-confirm-mail">Confirm Mail</a></li>
                        <li><a href="auth-email-verification" data-key="t-email-verification">Email Verification</a></li>
                        <li><a href="auth-two-step-verification" data-key="t-two-step-verification">Two Step Verification</a></li>
                    </ul>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->