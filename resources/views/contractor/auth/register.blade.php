@extends('admin.layouts.logindefault')

@section('title', 'Myplanbase - Home Buyer Login Credentials Required')

@section('content')
<div class="main-container">
    <div class="container-login">
        <div class="wrap-login">
            <div class="logo">
                <a href="{{route('super.welcome')}}">
                    <img src="{{ asset('img/client/cropped-zipkit-logo.png') }}" style="width:100%;max-height:100px;" alt="Myplanbase Logo">
                </a>
            </div>
            <div class="login100-form-title-1 py-3">
                Home Buyer Registration
            </div>
            <div class="py-3 px-5">
                <form method="post" action="{{ route('contractor.register', ['subdomain' => $subdomain]) }}">
                    @csrf
                    @if ( session()->has('error') )
                    <div style="width:100%; padding:5px; font-size:13px; font-weight:bold; color:#f00; text-align:center;">
                        {{ session()->get('error') }}
                    </div>
                    @endif
                    @if(session()->has('success'))
                    <div class="text-success" style="width:100%; padding:5px; font-size:13px; font-weight:bold;  text-align-center">
                        {{ session()->get('success') }}
                    </div>
                    @endif
                    @if(session()->has('info'))
                    <div class="text-info" style="width:100%; padding:5px; font-size:13px; font-weight:bold; text-align-center">
                        {{ session()->get('info') }}
                    </div>
                    @endif

                    <div class="row align-items-start">
                        <div class="form-group col-lg-12 col-sm-12">
                            <label for="first_name">Fist Name :</label>
                            <input id="first_name" name="first_name" class="form-control form-control-solid @error('first_name') is-invalid @enderror" placeholder="Enter first name" value="{{ old('first_name') }}">
                            @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row align-items-start">
                        <div class="form-group col-lg-12 col-sm-12">
                            <label for="last_name">Last Name :</label>
                            <input id="last_name" name="last_name" class="form-control form-control-solid @error('last_name') is-invalid @enderror" placeholder="Enter last name" value="{{ old('last_name') }}">
                            @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row align-items-start">
                        <div class="form-group col-lg-12 col-sm-12">
                            <label for="email">Email :</label>
                            <input id="email" name="email" class="form-control form-control-solid @error('email') is-invalid @enderror" placeholder="Enter email" value="{{ old('email') }}">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row align-items-start">
                        <div class="form-group col-lg-12 col-sm-12">
                            <label for="password">Password :</label>
                            <input type="password" id="password" name="password" class="form-control form-control-solid @error('password') is-invalid @enderror" placeholder="Enter password">
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-block">Register Home Buyer</button>
                </form>
            </div>

        </div>
    </div>
    @extends('admin.layouts.footerfront')
</div>
@stop

@section("css")
    <style>
        .wrap-login {
            padding: 35px 0px 55px 0px;
        }

        .logo {
            display: flex;
            justify-content: center;
        }

        .login100-form-title-1 {
            background-color: #d9d9d9;
        }

        button {
            margin-top: 20px !important;
            background-color: #ff822a !important;
            color: white !important;
        }
    </style>
@endsection

@section("scripts")
    <script src="{{ asset('../js/custom.js') }}"></script>
@endsection