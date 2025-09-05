@extends('superadmin.layouts.default')

@section('content')
<div class="main-content container">
    <div class="row mt-6">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">Add Floor Plan Category</h3>
                </div>
                <!--begin::Form-->
                <form action="{{ route('super.categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @if ( session()->has('error') )
                        <div class="alert alert-danger" role="alert"> {{ session()->get('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="card-body">
                        @include('superadmin.categories.form',
                        [
                        'category' =>
                        [
                        'category_name' => '',
                        'category_description' => '',
                        'is_active' => ''
                        ],
                        ])

                        <div class="d-flex justify-content-end mt-10">
                            <button type="submit" class="btn btn-primary">Add Floor Plan Category</button>
                        </div>
                    </div>
                </form>
                <!--end::Form-->
            </div>
            <!--end::Card-->
        </div>
    </div>
</div>
@endsection
