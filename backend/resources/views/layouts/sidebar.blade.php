@php
    $settings = App\Models\WebsiteSettings::first();
@endphp

<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="index" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('public/images/websiteimages/'. $settings->site_favicon) }}" alt="" height="26">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('public/images/websiteimages/'. $settings->site_logo) }}" alt="" height="50" width="50"><h4>{{ $settings->site_name }}</h4>
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

               {{-- <li>
                    <a href="javascript: void(0);">
                        <i class="bx bx-home-alt icon nav-icon"></i>
                        <span class="menu-item" data-key="t-dashboard">Dashboard</span>
                        <span class="badge rounded-pill bg-primary">2</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="index" data-key="t-ecommerce">Ecommerce</a></li>
                        <li><a href="dashboard-sales" data-key="t-sales">Sales</a></li>
                    </ul>
                </li> --}}
                <li class="menu-title" data-key="t-applications">Members Area</li>
                <li class="{{ request()->routeIs('projects.*') ? 'mm-active' : '' }}">
                    <a href="{{route('projects.index')}}">
                        <i class="bx bx-buildings icon nav-icon"></i>
                        <span class="menu-item">Projects</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('users.*') ? 'mm-active' : '' }}">
                    <a href={{route('users.index')}}>
                        <i class="bx bx-user"></i>
                        <span class="menu-item">Users</span>
                    </a>
                </li>
                <li class="menu-title" data-key="t-applications">Website Admin</li>
                <li class="{{ request()->routeIs('hero_sections.*') ? 'mm-active' : '' }}">
                    <a href="{{route('hero_sections.index')}}">
                        <i class="bx bx-image icon nav-icon"></i>
                        <span class="menu-item">Hero Sections</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('banners.*') ? 'mm-active' : '' }}">
                    <a href="{{route('banners.index')}}">
                        <i class="bx bx-image icon nav-icon"></i>
                        <span class="menu-item">Banners</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('sections.*') ? 'mm-active' : '' }}">
                    <a href="{{route('sections.index')}}">
                        <i class="bx bx-image icon nav-icon"></i>
                        <span class="menu-item">Sections</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('services.*') ? 'mm-active' : '' }}">
                    <a href="{{route('services.index')}}">
                        <i class="bx bx-briefcase icon nav-icon"></i>
                        <span class="menu-item">Services</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('testimonials.*') ? 'mm-active' : '' }}">
                    <a href="{{route('testimonials.index')}}">
                        <i class="bx bx-comment-dots icon nav-icon"></i>
                        <span class="menu-item">Testimonials</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('packages.*') ? 'mm-active' : '' }}">
                    <a href="{{route('packages.index')}}">
                        <i class="bx bx-package icon nav-icon"></i>
                        <span class="menu-item">Packages</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('website_settings.*') ? 'mm-active' : '' }}">
                    <a href="javascript: void(0);" class="has-arrow {{ request()->routeIs('website_settings.*') ? 'mm-active' : '' }}">
                        <i class="bx bx-cog icon nav-icon"></i>
                        <span class="menu-item">Settings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('website_settings.index')}}">Website Setting</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->