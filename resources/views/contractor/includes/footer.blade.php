<div class="footer py-4 d-flex flex-lg-column mt-5" style="background-color: rgb(245, 245, 247)" id="kt_footer">
    <!--begin::Container-->
    <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
        <!--begin::Copyright-->
        <div class="text-dark order-1">
            <span class="text-muted font-weight-bold mr-2">{{ date('Y') }} </span>
            {{-- <a href="#" target="_blank" class="text-dark-75 text-hover-primary">focusproject.com</a> --}}
        </div>
        <!--end::Copyright-->

        <!--begin::Nav-->
        <div class="nav nav-dark order-2">
            <a href="#" id="design-center-footer" class="nav-link pr-3 pl-0" style="display:none;">Design Center</a>
            <!-- Additional menu items based on subdomain -->
            @if ($subdomain == 'mvp')
            <div class="nav nav-dark">
                @isset($setting['about_url'])
                <a href="{{ $setting['about_url'] }}" target="_blank" class="nav-link pr-3 pl-0">About</a>
                @else
                <a href="https://mountainvalleyprefab.com/about/" target="_blank" class="nav-link pr-3 pl-0">About</a>
                @endisset
                <a href="https://mountainvalleyprefab.com/" target="_blank" class="nav-link px-3">Team</a>
                @isset($setting['contact_url'])
                <a href="{{ $setting['contact_url'] }}" target="_blank" class="nav-link pr-3 pl-0">Contact</a>
                @else
                <a href="https://mountainvalleyprefab.com/contact/" target="_blank" class="nav-link pr-3 pl-0">Contact</a>
                @endisset
            </div>
            @elseif($subdomain == 'floorplans')
            <div class="nav nav-dark">
                @isset($setting['about_url'])
                <a href="{{ $setting['about_url'] }}" target="_blank" class="nav-link pr-3 pl-0">About</a>
                @else
                <a href="https://www.zipkithomes.com/about/" target="_blank" class="nav-link pr-3 pl-0">About</a>
                @endisset
                <a href="https://www.zipkithomes.com/" target="_blank" class="nav-link px-3">Team</a>
                @isset($setting['contact_url'])
                <a href="{{ $setting['contact_url'] }}" target="_blank" class="nav-link pr-3 pl-0">Contact</a>
                @else
                <a href="https://www.zipkithomes.com/contact-us/" target="_blank" class="nav-link pr-3 pl-0">Contact</a>
                @endisset
            </div>
            @else
            <div class="nav nav-dark">
                @isset($setting['about_url'])
                <a href="{{ $setting['about_url'] }}" target="_blank" class="nav-link pr-3 pl-0">About</a>
                @else
                <a href="https://www.thetrails-shurtzcanyon.com/" target="_blank" class="nav-link pr-3 pl-0">About</a>
                @endisset
                <a href="https://www.thetrails-shurtzcanyon.com/" target="_blank" class="nav-link px-3">Team</a>
                @isset($setting['contact_url'])
                <a href="{{ $setting['contact_url'] }}" target="_blank" class="nav-link pr-3 pl-0">Contact</a>
                @else
                <a href="https://www.thetrails-shurtzcanyon.com/#register" target="_blank" class="nav-link pr-3 pl-0">Contact</a>
                @endisset
            </div>
            @endif
        </div>
        <!--end::Nav-->
    </div>


    <!--end::Container-->
    @php
        $cart_item = \App\Helpers\ManageItems::get_last_floor_plan($subdomain);
    @endphp
    <div class="side-btn">
        <button type="button" data-toggle="modal" data-target="#selectionsModal">
            View My Collection
        </button>
        <span class="card_nmbr">{{ $cart_item['count'] }}</span>
    </div>
</div>
<script>
    function go_to_cart_page(_self) {
        let count = $(_self).attr('data-count');
        let url = $(_self).attr('data-href');
        url = url.replace('productgroups', 'cart/create');
        if (count > 0) {
            location.href = url;
        } else {
            alert('There are not any items in your cart now. Please add your items!');
        }
    }

    $(document).ready(function() {
       // Get the current URL path
       var currentPath = window.location.pathname;

        // Use a regular expression to check if the path matches /floorplans/ followed by a number (ID)
        var regex = /^\/floorplans\/\d+$/;

        if (regex.test(currentPath)) {
            // Show the Design Center link if the path matches
            $('#design-center-footer').show();
        }
    })
</script>

<style>
    .side-btn {
        position: fixed;
        top: 30%;
        right: -50px;
        rotate: -90deg;
    }

    .side-btn button {
        padding: 14px 30px;
        border: 0px;
        background: #DBDBDB 0% 0% no-repeat padding-box;
        border-radius: 2px;
    }

    .card_nmbr {
        position: absolute;
        top: -15px;
        right: -5px;
        width: 27px;
        height: 27px;
        background: #0071E3 0% 0% no-repeat padding-box;
        font-size: 15px;
        color: #fff;
        border-radius: 50%;
        z-index: 2;
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
        rotate: 90deg;
    }

</style>
