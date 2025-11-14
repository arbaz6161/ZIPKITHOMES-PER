@extends("superadmin.layouts.default")

@section("content")
<div class="main-content container">
    <!--begin::Card-->
    <div class=" card card-custom mt-6">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Floor Plans</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <a href="{{ route('super.floorplans.create') }}" class="btn btn-primary font-weight-bolder">
                    <i class="icon-xl la la-plus"></i>
                    Add Floor Plan
                </a>
                <!--end::Button-->
            </div>
        </div>

        <div class="card-body">
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

            <div class="overlay loading d-none"></div>
            <div class="spinner-border text-primary loading d-none" role="status">
                <span class="sr-only">Loading...</span>
            </div>

            <!--begin::Search Form-->
            <div class="mb-7">
                <div class="row align-items-center">
                    <div class="col-lg-9 col-xl-8">
                        <div class="row align-items-center">
                            <div class="col-md-4 my-2 my-md-0">
                                <div class="input-icon">
                                    <input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query" />
                                    <span>
                                        <i class="flaticon2-search-1 text-muted"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Search Form-->
            <!--end: Search Form-->
            <!--begin: Datatable-->
            <table class="datatable datatable-bordered table-responsive datatable-head-custom" id="kt_datatable">
                <thead>
                    <tr>
                        <th title="Field #1">Plan Name</th>
                        <th title="Field #2">Plan Images</th>
                        <th title="Field #2">Plan Videos</th>
                        <th title="Field #3">Contractor</th>
                        <th title="Field #4">Category</th>
                        <th title="Field #5">Order</th>
                        <th title="Field #6">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($floorplans as $floorplan)
                    <tr>
                        <td>{{ $floorplan->plan_name }}</td>
                        <td>
                            <div class="preview-image">
@if(isset($floorplan->images[0]))                                
<img class="img-thumbnail" src="{{ $floorplan->images[0]['pic_url'] }}" alt="pic2 image">
@else
    <span>No image</span>
@endif                            
</div>
                        </td>
                        <td>
                            @if(isset($floorplan->videos[0]))
                                @php
                                    $videoUrl = explode('=', $floorplan->videos[0]['vid_url']);
                                    $videoUrl = isset($videoUrl[1]) ? $videoUrl[1] : '';
                                @endphp
                                <div class="preview-video">
                                    <iframe 
                                        width="100%" height="100"
                                        src="{{ 'https:\/\/www.youtube.com\/embed\/' . $videoUrl }}"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                        referrerpolicy="strict-origin-when-cross-origin" 
                                        allowfullscreen>
                                    </iframe>
                                </div>
                                {{--  <video style="width:100% !important; height: auto !important; object-fit: cover;"controls>
                                    <source src="{{ $floorplan->videos[0]['vid_url'] }}">
                                </video>  --}}
                            @endif
                        </td>
                        <td>{{ (!empty($floorplan->owner) ? $floorplan->owner->company_name : "") }}</td>
                        <td>{{ (!empty($floorplan->category) ? $floorplan->category->category_name : "") }}</td>
                        <td>{{ (!empty($floorplan->order) ? $floorplan->order : "") }}</td>
                        <td class="d-flex justify-content-end">
                            <a href="{{ route('super.floorplans.edit', ['floorplan' => $floorplan->id]) }}" class="btn btn-sm btn-clean btn-icon"><i class="icon-xl la la-pen"></i></a>
                            <a href="{{ route('super.floorplans.destroy', ['floorplan' => $floorplan->id]) }}" class="btn btn-sm btn-clean btn-icon delete"><i class="icon-xl la la-trash-o"></i></a>
                        </td>
                    </tr>
                    @empty
                    <!-- <div class="alert alert-warning">No floor plans added yet</div> -->
                    @endforelse
                </tbody>
            </table>
            <!--end: Datatable-->
        </div>
    </div>
    <!--end::Card-->
</div>
@endsection
