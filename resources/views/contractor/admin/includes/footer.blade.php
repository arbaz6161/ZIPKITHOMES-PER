<div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
    <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted font-weight-bold mr-2">{{ date('Y') }} </span>
            {{-- <a href="#" target="_blank" class="text-dark-75 text-hover-primary">focusproject.com</a> --}}
        </div>
        <div class="nav nav-dark order-1 order-md-2">
            @isset($setting['about_url'])
                <a href="{{ $setting['about_url'] }}" target="_blank" class="nav-link pr-3 pl-0">About</a>
            @else
                <a href="#About" target="_blank" class="nav-link pr-3 pl-0">About</a>
            @endisset
            <a href="https://www.thetrails-shurtzcanyon.com/" target="_blank" class="nav-link px-3">Team</a>
            @isset($setting['contact_url'])
                <a href="{{ $setting['contact_url'] }}" target="_blank" class="nav-link pr-3 pl-0">Contact</a>
            @else
                <a href="#Contact" target="_blank" class="nav-link pr-3 pl-0">Contact</a>
            @endisset
        </div>
    </div>
</div>

<div class="modal fade" id="more-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
