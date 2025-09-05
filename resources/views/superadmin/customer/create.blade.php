@extends("superadmin.layouts.default")

@section("content")
<div class="main-content container">
    <div class="row mt-6">
        <div class="col-lg-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">New Customer</h3>
                </div>
                <!--begin::Form-->
                <form action="{{ route('super.customers.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @if ( session()->has('error') )
                    <div>{{ session()->get('error') }}</div>
                    @endif

                    <div class="card-body">
                        @include('superadmin.customer.form', ['customer' =>
                        [
                        'contractor_id' => '',
                        'source_website' => '',
                        'name' => '',
                        'email' => '',
                        'phone' => '',
                        'home_location' => '',
                        'home_state' => '',
                        'home_zip' => '',
                        'note' => ''
                        ],
                        ])
                        <div class="d-flex justify-content-end mt-10">
                            <button type="submit" class="btn btn-primary">Save the new customer</button>
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