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
                    <a href="" class="text-dark text-hover-black opacity-75 hover-opacity-100">Cart</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section("content")
<div class="container">
    <h1>Cart</h1>
    <div class="row">
        <div class="col"></div>
        <div class="col-sm-8">
            <div class="card card-custom card-stretch">
                <div class="card-body">
                    @include("contractor.includes.items", ["contractor" => $contractor, "floorplan" => $floorplan, "not_editable" => true, "subdomain" => $subdomain])
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('contractor.pdf.create', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id]) }}" class="btn btn-primary mr-5">Download PDF</a>
                        <a href="{{ route('contractor.email.create', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id]) }}" class="btn btn-primary">Email Us Your Option</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col"></div>
    </div>
</div>
@endsection