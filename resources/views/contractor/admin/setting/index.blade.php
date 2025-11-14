@extends('contractor.admin.layouts.default')

@section('content')
    <div class="main-content container">
        <!--begin::Card-->
        <div class=" card card-custom mt-6">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">Url Setting</h3>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('contractor.admin.setting.urls.store', ['subdomain' => $subdomain]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @if (session()->has('error'))
                        <div>{{ session()->get('error') }}</div>
                    @endif
                    @if (session()->has('success'))
                        <div class="text-success"
                            style="width:100%; padding:5px; font-size:13px; font-weight:bold; text-align-center">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    <div class="form-group">
                        <div>
                            <label for="home_url">Home Url</label>
                            <input id="home_url" name="home_url" class="form-control form-control-solid"
                                placeholder="Enter home url" value="{{ old('home_url', $setting['home_url']) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <label for="about_url">About Url</label>
                            <input id="about_url" name="about_url" class="form-control form-control-solid"
                                placeholder="Enter about url" value="{{ old('about_url', $setting['about_url']) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <label for="contact_url">Contact Url</label>
                            <input id="contact_url" name="contact_url" class="form-control form-control-solid"
                                placeholder="Enter contact url" value="{{ old('contact_url', $setting['contact_url']) }}">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-10">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
        <!--end::Card-->
    </div>
@endsection
