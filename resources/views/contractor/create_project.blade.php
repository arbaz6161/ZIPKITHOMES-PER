@extends("contractor.layouts.default")

@php
    $floorplan_name = $floorplan->pivot->is_keep_same_name == 1 ? $floorplan->plan_name : $floorplan->pivot->floor_plan_rename;
@endphp

@section("subheader")
    <div class="subheader py-2 py-lg-12 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex flex-column">
                    <div class="d-flex align-items-center font-weight-bold my-2">
                        <span class="label label-dot label-sm bg-dark opacity-75 mx-3"></span>
                        <a href="{{ route('contractor.floorplans.index', ['subdomain' => $subdomain]) }}" class="text-dark text-hover-black opacity-75 hover-opacity-100">Floor Plans</a>
                        <span class="label label-dot label-sm bg-dark opacity-75 mx-3"></span>
                        <a href="{{ route('contractor.floorplans.show', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id]) }}" class="text-dark text-hover-black opacity-75 hover-opacity-100">{{ $floorplan_name }}</a>
                        <span class="label label-dot label-sm bg-dark opacity-75 mx-3"></span>
                        <a href="{{ route('contractor.productgroups.index', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id]) }}" class="text-dark text-hover-black opacity-75 hover-opacity-100">Options & Colors</a>
                        <span class="label label-dot label-sm bg-dark opacity-75 mx-3"></span>
                        <a href="" class="text-dark text-hover-black opacity-75 hover-opacity-100">Create New Project</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("content")
    <div class="container">

        <h1>Create new Project</h1>

        <div class="row mt-5">
            <div class="col"></div>
            <div class="col-sm-8">
                <div class="card card-custom card-stretch">
                    <div class="card-body">
                        <form action="{{ route('contractor.project.store', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="item-image">
                                        <img src="{{ $floorplan->images[0]['pic_url'] }}" alt="{{ $floorplan->images[0]['pic_name'] }}">
                                    </div>
                                    <p class="text-center">{{ $floorplan_name }}</p>
                                </div>
                                <div class="col-sm-8">
                                    <div class="col-sm-12 form-group">
                                        <input type="text" name="name" class="form-control form-control-solid @error('name') is-invalid @enderror" placeholder="Enter project name i.e: 123 Main Street..." value="{{ old('name') }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <input type="text" name="address_line" class="form-control form-control-solid @error('address_line') is-invalid @enderror" placeholder="Enter your address line" value="{{ old('address_line') }}">
                                        @error('address_line_')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <input type="text" name="city" class="form-control form-control-solid @error('city') is-invalid @enderror" placeholder="Enter your city" value="{{ old('city') }}">
                                        @error('city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <input type="text" name="postal_code" class="form-control form-control-solid @error('postal_code') is-invalid @enderror" placeholder="Enter your zipcode" value="{{ old('postal_code') }}">
                                        @error('postal_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <hr>
                            @if (auth()->check())
                                <button type="submit" class="btn btn-primary float-right">Create Project</button>
                            @else
                                <span class="btn btn-primary float-right registration">Create Acoount</span>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
            <div class="col"></div>
        </div>
    </div>

    <div class="modal fade" id="registration-model">
        <div class="modal-dialog modal modal-dialog-centered">
            <div class="modal-content">
    
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Register Account</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
    
                <form action="{{ route('contractor.login', ['subdomain' => $subdomain]) }}" method="GET">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="col-sm-12 form-group">
                            Please log in to your account before creating a project. If you don't have an account, register <a href="{{ route('contractor.register', ['subdomain' => $subdomain]) }}">here</a>.
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection