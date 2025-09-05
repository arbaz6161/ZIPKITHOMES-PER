<div id="kt_header" class="header header-fixed bg-white">
    <!--begin::Container-->
    <div class="container d-flex align-items-stretch">
        <!--begin::Left-->
        <div class="d-flex align-items-stretch flex-grow-1 border-bottom">
            <!--begin::Header Logo-->
            @if ($subdomain == 'shurtzcanyon')
            <div class="header-logo">
                <a href="https://www.thetrails-shurtzcanyon.com/">
                    @isset($contractor->logo)
                    <img src="{{ $contractor->logo }}" class="logo-default max-h-40px" alt="Logo">
                    @else
                    <img src="{{ asset('img/client/cropped-zipkit-logo.png') }}" class="logo-default max-h-40px" alt="Myplanbase Logo">
                    @endif
                </a>
            </div>
            @elseif($subdomain == 'mvp')
            <div class="header-logo">
                <a href="https://mountainvalleyprefab.com/">
                    @isset($contractor->logo)
                    <img src="{{ $contractor->logo }}" class="logo-default max-h-40px" alt="Logo">
                    @else
                    <img src="{{ asset('img/client/cropped-zipkit-logo.png') }}" class="logo-default max-h-40px" alt="Myplanbase Logo">
                    @endif
                </a>
            </div>
            @else
            <div class="header-logo">
                <a href="https://www.zipkithomes.com/">
                    @isset($contractor->logo)
                    <img src="{{ $contractor->logo }}" class="logo-default max-h-40px" alt="Logo">
                    @else
                    <img src="{{ asset('img/client/cropped-zipkit-logo.png') }}" class="logo-default max-h-40px" alt="Myplanbase Logo">
                    @endif
                </a>
            </div>

            @endif
            <!--end::Header Logo-->
            <!--begin::Header Menu Wrapper-->
            <div class="header-menu-wrapper header-menu-wrapper-left ml-auto" id="kt_header_menu_wrapper">
                <!--begin::Header Menu-->
                <div id="kt_header_menu" class="header-menu header-menu-left header-menu-mobile header-menu-layout-default">
                    <!--begin::Header Nav-->
                    <ul class="menu-nav">
                        @if ($subdomain == 'shurtzcanyon')
                        <li class="menu-item menu-item-submenu menu-item-rel {{ request()->route()->getName() == 'contractor.home' ? 'menu-item-here' : '' }}">
                            @isset($setting['home_url'])
                            <a href="{{ $setting['home_url'] }}" class="menu-link">
                                <span class="menu-text">Home</span>
                            </a>
                            @elseif($subdomain == 'mvp')

                            @else
                            <a href="https://www.thetrails-shurtzcanyon.com/" class="menu-link">
                                <span class="menu-text">Home</span>
                            </a>
                            @endisset

                        </li>
                        @else
                        <li class="menu-item menu-item-submenu menu-item-rel {{ request()->route()->getName() == 'contractor.home' ? 'menu-item-here' : '' }}">
                            @isset($setting['home_url'])
                            <a href="{{ $setting['home_url'] }}" class="menu-link">
                                <span class="menu-text">Home</span>
                            </a>
                            @elseif($subdomain == 'mvp')
                            <a href="https://mountainvalleyprefab.com/" class="menu-link">
                                <span class="menu-text">Home</span>
                            </a>
                            @else
                            <a href="https://www.zipkithomes.com/" class="menu-link">
                                <span class="menu-text">Home</span>
                            </a>
                            @endisset

                        </li>
                        @endif
                        <li class="menu-item menu-item-submenu menu-item-rel {{ request()->route()->getName() == 'contractor.floorplans.index' ? 'menu-item-here' : '' }}">
                            <a href="{{ route('contractor.floorplans.index', ['subdomain' => $subdomain]) }}" class="menu-link">
                                <span class="menu-text">Floor plans</span>
                            </a>
                        </li>
                        @if ($subdomain == 'shurtzcanyon')
                        <li class="menu-item menu-item-submenu menu-item-rel">
                            @isset($setting['about_url'])
                            <a href="{{ $setting['about_url'] }}" class="menu-link">
                                <span class="menu-text">About</span>
                            </a>
                            @else
                            <a href="https://www.thetrails-shurtzcanyon.com/" class="menu-link">
                                <span class="menu-text">About</span>
                            </a>
                            @endisset
                        </li>
                        @else
                        <li class="menu-item menu-item-submenu menu-item-rel">
                            @isset($setting['about_url'])
                            <a href="{{ $setting['about_url'] }}" class="menu-link">
                                <span class="menu-text">About</span>
                            </a>
                            @elseif($subdomain == 'mvp')
                            <a href="https://mountainvalleyprefab.com/about/" class="menu-link">
                                <span class="menu-text">About</span>
                            </a>
                            @else
                            <a href="https://www.zipkithomes.com/about/" class="menu-link">
                                <span class="menu-text">About</span>
                            </a>
                            @endisset
                        </li>
                        @endif
                        @if ($subdomain == 'shurtzcanyon')
                        <li class="menu-item menu-item-submenu menu-item-rel">
                            <a href="https://www.thetrails-shurtzcanyon.com/#register" class="menu-link">
                                <span class="menu-text">Contact us</span>
                            </a>
                        </li>
                        @elseif($subdomain == 'mvp')
                        <li class="menu-item menu-item-submenu menu-item-rel">
                            <a href="https://mountainvalleyprefab.com/contact/" class="menu-link">
                                <span class="menu-text">Contact us</span>
                            </a>
                        </li>
                        @else
                        <li class="menu-item menu-item-submenu menu-item-rel">
                            <a href="https://www.zipkithomes.com/contact-us/" class="menu-link">
                                <span class="menu-text">Contact us</span>
                            </a>
                        </li>
                        @endif
                        <li class="menu-item menu-item-submenu menu-item-rel">
                            @php
                            $cart_item = \App\Helpers\ManageItems::get_last_floor_plan($subdomain);
                            @endphp
                            {{-- <button data-href="{{ $cart_item['url'] }}" data-count="{{ $cart_item['count'] }}"
                            class="menu-link nav-cart-button btn text-white btn-hover-white btn-hover-text-dark"
                            style="background-color:gray; border-color: gray !important;"
                            onclick="go_to_cart_page(this)">
                            <span class="icon-xl las la-shopping-cart"></span>
                            </button> --}}
                        </li>
                        @if (auth()->check())
                        <li class="menu-item menu-item-submenu menu-item-rel">
                            <form action="{{ route('contractor.logout', ['subdomain' => $subdomain]) }}" method="POST">
                                @csrf
                                <button type="submit" style="background-color:gray;    border-color: gray !important;" class="menu-link nav-cart-button btn text-white btn-hover-white btn-hover-text-dark">Logout</button>
                            </form>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
