@extends('contractor.layouts.default')

@php
if ($errors->any()) {
if (session()->has('color-list') && session()->get('color-list')) {
echo '<script>
    window.showColorListModal = true;

</script>';
}
echo '<script>
    window.showColorModal = true;

</script>';
}

$floorplan_name =
$floorplan->pivot->is_keep_same_name == 1 ? $floorplan->plan_name : $floorplan->pivot->floor_plan_rename;
@endphp

@section('subheader')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<style>
    .swiper {
        width: 100%;
        height: 100%;
    }

    .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .swiper-slide img {
        display: block;
        height: 100%;
        object-fit: cover;
    }

    .swiper-button-next {
        color: gray;
    }

    .swiper-button-prev {
        color: gray;
    }

    .product-btn {
        background-color: #007AFF;
        color: rgb(255, 255, 255);
    }

    .product-btn:hover {
        background-color: #007AFF;
        color: rgb(255, 255, 255);
    }

</style>

<div class="subheader pt-2 pt-lg-12 subheader-transparent" id="kt_subheader">
    <div class="container">
        <a href="{{ route('contractor.floorplans.show', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id]) }}" class="btn text-white btn-sm mb-5" style="background-color: grey;">
            <i class="las la-arrow-left text-white"></i>
            <span>Back</span>
        </a>
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex flex-column">
                <div class="d-flex align-items-center font-weight-bold my-2">
                    <span class="label label-dot label-sm bg-dark opacity-75 mx-3"></span>
                    <a href="{{ route('contractor.floorplans.index', ['subdomain' => $subdomain]) }}" class="text-dark text-hover-black opacity-75 hover-opacity-100">Floor Plans</a>
                    <span class="label label-dot label-sm bg-dark opacity-75 mx-3"></span>
                    <a href="{{ route('contractor.floorplans.show', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id]) }}" class="text-dark text-hover-black opacity-75 hover-opacity-100">{{ $floorplan_name }}</a>
                    <span class="label label-dot label-sm bg-dark opacity-75 mx-3"></span>
                    <a href="" class="text-dark text-hover-black opacity-75 hover-opacity-100">Options &
                        Colors</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')

<div class="container" style="margin-bottom: 140px">
    @if (session()->has('success'))
    <div class="alert alert-primary" role="alert"> {{ session()->get('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @elseif(session()->has('error'))
    <div class="alert alert-danger" role="alert"> {{ session()->get('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div class="row mt-5">
        <div class="col-md-3 pr-10" style="background-color: #F8F8F8; border-radius:8px;">
            <h3 class="product-group" style="font-display: bold; font-size:24px; margin-top: 25px; margin-bottom:20px;">Product Groups</h3>
            <div class="row" style="background-color: #F8F8F8;">
                @foreach ($productgroups as $index => $productgroup)
                <div class="col-md-12" style="margin-bottom: 5px;">
                    <div class="product-group">
                        <a class="nav-link {{ $productgroup->id == $group_id ? 'nav-link-selected' : '' }} {{ !$group_id && !$index ? 'nav-link-selected' : '' }}" href="{{ route('contractor.productgroups.index', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id, 'group' => $productgroup->id]) }}">
                            <span style="font-weight: 600">{{ $productgroup->pdt_group_name }}</span>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="col-md-9" id="option_color_wrraper">
            <h3 class="options_colours">
                <span>Options & Colors</span>
                <span class="label label-dot label-sm bg-dark mx-3"></span>
                <span id="selected-product-group">{{ $group->pdt_group_name }}</span>
            </h3>
            <div class="row" id="products-container">
                @forelse ($products as $product)
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="cards card-custom card-stretch" style="border-radius: 8px">
                        <div class="cards-body item-tiny-image product-image" data-image-list="{{ $product->images }}" data-name="{{ $product->pdt_name }}" data-additional-text="{{ $product->pdt_additional_text }}" plan-price="{{ $product->plan_price }}">
                            <img style="padding: 21px" src="{{ $product->images[0]['pic_url'] }}" alt="{{ $product->images[0]['pic_name'] }}" loading="lazy">
                                </div>
                            <div class=" cards" style="width: 100%; border: 1px solid #EBEDF3 ">
                            <div class="border-0 p-3">
                                <form method="POST" action="{{ route('contractor.items.store', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id]) }}" id="product-form">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="comment" value="{{ old('comment') }}">
                                    <input type="hidden" name="color" value="{{ old('color') }}">
                                    <div class="card-title text-truncate" style="font-weight:bold; font-size: 14px; line-height: 27px; margin-bottom: 5px !important;">
                                        {{ $product->pdt_name }}
                                    </div>

                                    <div class="card-title text-truncate" style="text-align: left; font: normal normal normal 16px; letter-spacing: 0px; color: #061018; opacity: 1;"> {{ $product->pdt_description }}</div>

                                    <!-- Pricing and Quantity Section -->
                                    {{--  <div class="row mb-3">
                                        <div class="col-md-4 d-flex align-items-center">
                                            <h5 class="mb-0" style="color: #007AFF">
                                                ${{ $product->pivot->is_not_display_price || !$product->pivot->is_enter_price ? '0.00' : number_format($product->pivot->product_price, 2) }}
                                            </h5>
                                        </div>
                                        <div class="col-md-4 d-flex align-items-center">
                                            <span class="decrease-btn btn btn-link"><i class="fas fa-minus"></i></span>
                                            <input type="number" name="product_quantity" class="quantity form-control form-control-sm mx-2" style="width: -webkit-fill-available;" value="1" min="1">
                                            <span class="increase-btn btn btn-link"><i class="fas fa-plus"></i></span>
                                        </div>
                                    </div>  --}}

                                    <!-- Buttons Section -->
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn-selects" style="font-weight: 600;">
                                            Select
                                        </button>
                                    </div>

                                    <div class="d-flex justify-content-end mt-2">
                                        <button type="button" class="btn-block product-image quick-view-btn" style="color: #0071E3; background-color: #F2F9FF; font-weight: 600;" data-product-id="{{ $product->id }}" data-name="{{ $product->pdt_name }}" data-description="{{ $product->pdt_description }}" data-price="{{ $product->pivot->is_not_display_price || !$product->pivot->is_enter_price ? '0.00' : number_format($product->pivot->product_price, 2) }}" data-image-list="{{ json_encode($product->images) }}" data-additional-text="{{ $product->pdt_additional_text }}">
                                            Quick view
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                    <div class="alert alert-warning w-100">No product</div>
                @endforelse
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="selectionsModal" tabindex="-1" role="dialog" aria-labelledby="selectionsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-right " style="min-width: 480px;" role="document">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-selection" style="background-color: #F8F8F8; display:flex; justify-content: space-between;">
                        <h5 class="modal-title" id="selectionsModalLabel">My Selections</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            ×
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        @include('contractor.includes.cart', [
                            'contractor' => $contractor,
                            'floorplan' => $floorplan,
                            'subdomain' => $subdomain,
                        ])
                    </div>

                    <div class="modal-selection-footer">
                        <a href="{{ route('contractor.pdf.create', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id]) }}" class="btn product-btn">Download PDF</a>
                        <a href="{{ route('contractor.email.create', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id]) }}" class="btn product-btn-secondary">Email Us Your Option</a>
                    </div>
                    {{-- <div class="justify-content-between mt-5 d-flex">
                        <div class="mt-3">
                                    <a href="{{ route('contractor.project.create', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id]) }}"
                            class="btn product-btn">Create Project</a>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>

        <div class="modal fade" id="product-zoom-modal" style="border-radius: 8px">
            <div class="modal-dialog modal-lg modal-dialog-centered" class="">
                <div class="modal-content">
                    <form method="POST" action="{{ route('contractor.items.store', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id]) }}" id="product-form">
                        @csrf

                        <input type="hidden" name="comment" value="{{ old('comment') }}">
                        <input type="hidden" name="color" value="{{ old('color') }}">

                        <!-- Modal Header -->
                        <div class="modal-header" style="display: flex; border-bottom:white">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body" style="padding: 0 50px 20px 50px">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sliding Modal -->
        <div class="modal fade" id="product-select" tabindex="-1" role="dialog" aria-labelledby="productSelectLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-right modal-dialog-centered" role="document" style="position">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title" id="productSelectLabel"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <!-- Content will be injected by JavaScript -->
                    </div>
                </div>
            </div>
        </div>

        @include('contractor.includes.item-single')
        @include('contractor.includes.item-list', ['contractor' => $contractor, 'floorplan' => $floorplan])
@endsection

<style>
    /* Override Bootstrap's modal styles */
    .modal-dialog-right {
        position: absolute;
        left: auto;
        right: 0;
        height: 100%;
        height: max-content !important;
        transform: translateX(100%);
        transition: transform 0.3s ease-in-out;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
    }

    .modal-dialog-right .modal-content {
        height: 100%;
        border-radius: 0;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    .modal.fade .modal-dialog-right {
        display: none;
    }
    .modal.fade.show .modal-dialog-right {
        display: block;
        transform: translateX(0);
        position: absolute;
        left: auto;
        margin: auto !important right: 0;
    }

    .modal-backdrop.show {
        opacity: 0.5;
    }

    /* Override Bootstrap's modal styles */
    .modal-dialog-right {
        position: absolute;
        right: 0;
        height: 100%;
        transform: translateX(100%);
        transition: transform 0.3s ease-in-out;
    }

    .modal.fade.show .modal-dialog-right {
        transform: translateX(0);
    }

    .modal-dialog-right .modal-content {
        height: 100%;
        min-height: 100vh;
        border-radius: 0;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    /* Ensure the close button is visible */
    .modal-header .close {
        font-size: 1.5rem;
        color: #000;
        /* Change to the color you want */
    }

    .modal-backdrop.show {
        opacity: 0.5;
    }

    .modal-dialog {
        margin-top: auto !important;
    }

    .container-fluid {
        height: 74%;
    }

    .modal-selection {
        align-items: center;
        padding: 36px 34px
    }

    .modal-selection h5 {
        font: normal normal 24px;
        letter-spacing: 0px;
        color: #061018;
        font-weight: 700
    }

    .modal-selection-footer {
        align-items: center;
        padding: 36px 34px;
        background-color: #F8F8F8;
        display: flex;
        flex-direction: row;
        gap: 10px;
    }

    .btn.product-btn {
        font-weight: 500;
        border-radius: 4px;
        padding: 10px;
        display: block;
        width: 100%;
        text-align: center;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
    }

    .btn.product-btn-secondary {
        border: 1px solid #007bff !important;
        font-weight: 500;
        border-radius: 4px;
        padding: 10px;
        display: block;
        width: 100%;
        text-align: center;
        text-decoration: none;
        color: #007bff;
    }
</style>
