@extends("superadmin.layouts.default")

@section("content")
<div class="main-content container">
    <!--begin::Card-->
    <div class=" card card-custom mt-6">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Customers</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <a href="{{ route('super.customers.create') }}" class="btn btn-primary font-weight-bolder">
                    <i class="icon-xl la la-plus"></i>
                    Add Customer
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
                        <div class="dropdown">
                            <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown">
                                {{ is_null($contractor) ? "ALL CONTRACTOR" : $contractor->company_name }}
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('super.customers.index') }}">ALL CONTRACTOR</a>
                                @foreach ($contractors as $contractor)
                                <a class="dropdown-item" href="{{ route('super.customers.index', ['contractor' => $contractor->id]) }}">{{ $contractor->company_name }}</a>
                                @endforeach
                            </div>
                        </div>
                        <th></th>
                        <th title="Field #1">website</th>
                        <th title="Field #1">Name</th>
                        <th title="Field #2">Email</th>
                        <th title="Field #3">Home Location</th>
                        <th title="Field #4">Home State</th>
                        <th title="Field #5">Note</th>
                        <th title="Field #6">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customers as $customer)
                    <tr>
                        <td>{{ $customer->contractor->company_name }}</td>
                        <td>{{ $customer->source_website }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->home_location}}</td>
                        <td>{{ $customer->home_state}}</td>
                        <td>{!! $customer->note !!}</td>
                        <td class="d-flex justify-content-end">
                            <a href="{{ route('super.customers.edit', ['customer' => $customer->id]) }}" class="btn btn-sm btn-clean btn-icon"><i class="icon-xl la la-pen"></i></a>
                            <a href="{{ route('super.customers.destroy', ['customer' => $customer->id]) }}" class="btn btn-sm btn-clean btn-icon delete"><i class="icon-xl la la-trash-o"></i></a>
                        </td>
                    </tr>
                    @empty
                    <!-- <div class="alert alert-warning">No product</div> -->
                    @endforelse
                </tbody>
            </table>
            <!--end: Datatable-->
        </div>
    </div>
    <!--end::Card-->
</div>
@endsection