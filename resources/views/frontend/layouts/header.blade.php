@php
    $settings = DB::table('settings')->first();
    $categories = getAllCategory();
@endphp

<header class="header shop">

    {{-- ================= TOP BAR ================= --}}
    <div class="topbar">
        <div class="container">
            <div class="row">

                <div class="col-lg-6 col-md-12 col-12">
                    <div class="top-left">
                        <ul class="list-main">
                            <li>
                                <i class="ti-headphone-alt"></i>
                                {{ $settings->phone ?? '' }}
                            </li>
                            <li>
                                <i class="ti-email"></i>
                                {{ $settings->email ?? '' }}
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 col-12">
                    <div class="right-content">
                        <ul class="list-main">
                            <li>
                                <i class="ti-location-pin"></i>
                                <a href="{{ route('order.track') }}">Track Order</a>
                            </li>

                            @auth
                                <li>
                                    <i class="ti-user"></i>
                                    <a href="{{ auth()->user()->role === 'admin' ? route('admin') : route('user') }}"
                                       target="_blank">
                                        Dashboard
                                    </a>
                                </li>
                                <li>
                                    <i class="ti-power-off"></i>
                                    <a href="{{ route('user.logout') }}">Logout</a>
                                </li>
                            @else
                                <li>
                                    <i class="ti-power-off"></i>
                                    <a href="{{ route('login.form') }}">Login</a> /
                                    <a href="{{ route('register.form') }}">Register</a>
                                </li>
                            @endauth
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ================= MIDDLE ================= --}}
    <div class="middle-inner">
        <div class="container">
            <div class="row">

                {{-- LOGO --}}
                <div class="col-lg-2 col-md-2 col-12">
                    <div class="logo">
                        <a href="{{ route('home') }}">
                            <img
                                src="{{ $settings && $settings->logo ? asset($settings->logo) : asset('images/default-logo.png') }}"
                                alt="logo">
                        </a>
                    </div>
                    <div class="mobile-nav"></div>
                </div>

                {{-- SEARCH --}}
                <div class="col-lg-8 col-md-7 col-12">
                    <div class="search-bar-top">
                        <div class="search-bar">
                            <select>
                                <option>All Category</option>
                                @foreach($categories as $cat)
                                    <option>{{ $cat->title }}</option>
                                @endforeach
                            </select>

                            <form method="POST" action="{{ route('product.search') }}">
                                @csrf
                                <input name="search" placeholder="Search Products Here..." type="search">
                                <button class="btnn" type="submit">
                                    <i class="ti-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- CART / WISHLIST --}}
                <div class="col-lg-2 col-md-3 col-12">
                    <div class="right-bar">

                        {{-- WISHLIST --}}
                        <div class="sinlge-bar shopping">
                            <a href="{{ route('wishlist') }}" class="single-icon">
                                <i class="fa fa-heart-o"></i>
                                <span class="total-count">{{ wishlistCount() }}</span>
                            </a>
                        </div>

                        {{-- CART --}}
                        <div class="sinlge-bar shopping">
                            <a href="{{ route('cart') }}" class="single-icon">
                                <i class="ti-bag"></i>
                                <span class="total-count">{{ cartCount() }}</span>
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ================= NAV ================= --}}
    <div class="header-inner">
        <div class="container">
            <div class="cat-nav-head">
                <nav class="navbar navbar-expand-lg">
                    <div class="navbar-collapse">
                        <ul class="nav main-menu menu navbar-nav">

                            <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                                <a href="{{ route('home') }}">Home</a>
                            </li>

                            <li class="{{ request()->routeIs('about-us') ? 'active' : '' }}">
                                <a href="{{ route('about-us') }}">About Us</a>
                            </li>

                            <li class="{{ request()->routeIs('product-grids','product-lists') ? 'active' : '' }}">
                                <a href="{{ route('product-grids') }}">Products</a>
                                <span class="new">New</span>
                            </li>

                            {{-- CATEGORY DROPDOWN --}}
                            <li>
                                <a href="javascript:void(0);">
                                    Category <i class="ti-angle-down"></i>
                                </a>
                                <ul class="dropdown">
                                    @foreach($categories as $cat)
                                        <li>
                                            <a href="{{ route('product-cat', $cat->slug) }}">
                                                {{ $cat->title }}
                                            </a>

                                            @if($cat->child_cat->count())
                                                <ul class="dropdown sub-dropdown">
                                                    @foreach($cat->child_cat as $sub)
                                                        <li>
                                                            <a href="{{ route('product-sub-cat', [$cat->slug, $sub->slug]) }}">
                                                                {{ $sub->title }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </li>

                            <li class="{{ request()->routeIs('blog') ? 'active' : '' }}">
                                <a href="{{ route('blog') }}">Blog</a>
                            </li>

                            <li class="{{ request()->routeIs('contact') ? 'active' : '' }}">
                                <a href="{{ route('contact') }}">Contact Us</a>
                            </li>

                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>

</header>
