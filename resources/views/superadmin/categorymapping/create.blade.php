@extends('superadmin.layouts.default')

@section('content')
<div class="main-content container">
    <div class="row mt-6">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">Add Category Mapping</h3>
                </div>
                <!--begin::Form-->
                <form action="{{ route('super.categorymapping.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @if ( session()->has('error') )
                        <div class="alert alert-danger" role="alert"> {{ session()->get('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="card-body">
                        @include('superadmin.categorymapping.form',
                        [
                            'category_mapping' =>
                            [
                                'contractor_id' => '',
                                'contractor_name' => '',
                                'category_ids' => '',
                            ],
                        ])

                        <div class="d-flex justify-content-end mt-10">
                            <button type="submit" class="btn btn-primary">Add Category Mapping</button>
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
