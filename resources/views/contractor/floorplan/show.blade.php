@extends('contractor.layouts.default')

@php
    $name = $floorplan->pivot->is_keep_same_name == 1 ? $floorplan->plan_name : $floorplan->pivot->floor_plan_rename;
    $price = $floorplan->pivot->floor_plan_price ? $floorplan->pivot->floor_plan_price : 0;
@endphp

@section('subheader')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .box-thumbnail {
            transition: box-shadow .3s !important;
        }

        .box-thumbnail:hover {
            box-shadow: 0 0 11px rgba(33, 33, 33, .2) !important;
        }

        img {
            transition: transform 0.3s ease-in-out;
            cursor: pointer;
        }

        .enlarged {
            transform: scale(1.4);
        }

        .additional_text table {
            width: auto !important;
            /* Reset the width to auto */
            height: auto !important;
            /* Reset the height to auto */
        }
    </style>
    <div class="subheader py-2 py-lg-12 subheader-transparent" id="kt_subheader">
        <div class="container">
            <div class="d-flex justify-content-between">
                <a href="{{ route('contractor.floorplans.index', ['subdomain' => $subdomain]) }}" class="btn text-white mb-5"
                    style="background-color: grey;height:max-content;">
                    <i class="las la-arrow-left text-white"></i>
                    <span>Back</span>
                </a>

                <div class="d-flex flex-column">
                    {{-- <a href="{{ route('contractor.productgroups.index', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id, 'group' => 0]) }}" class="btn text-white btn-primary">Options & Colors</a> --}}

                    @foreach ($floorplan->videos as $video)
                        <a href="#" class="mt-1 btn text-white floorplan-video" data-src="{{ $video['vid_url'] }}"
                            data-alt="{{ $video['vid_name'] }}" style="background-color: gray; min-width:175px;"><i
                                class="fa fa-play text-white"></i> Video {{ $video['vid_name'] }}</a>
                    @endforeach
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center font-weight-bold my-2">
                            <span class="label label-dot label-sm bg-dark opacity-75 mx-3"></span>
                            <a href="{{ route('contractor.floorplans.index', ['subdomain' => $subdomain]) }}"
                                class="text-dark text-hover-black opacity-75 hover-opacity-100">Floor Plans</a>
                            <span class="label label-dot label-sm bg-dark opacity-75 mx-3"></span>
                            <a href=""
                                class="text-dark text-hover-black opacity-75 hover-opacity-100">{{ $name }}</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-6 mobile-floor-card">
                <div class="card card-custom card-stretch box-thumbnail">
                    <div class="card-body p-0 item-image">
                        <img src="{{ $floorplan->images[0]['pic_url'] }}" onclick="toggleSize(this)"
                            alt="{{ $floorplan->images[0]['pic_name'] }}">
                    </div>

                    <div class="card-header border-0 p-5">
                        <div class="card-title">
                            <div class="card-label">
                                <div class="h1" style="color:rgb(29, 29, 31);">{{ $name }}</div>
                                <div class="h6" style="color:rgb(29, 29, 31);">{{ $floorplan->plan_description }}</div>
                                <div class="font-size-sm mt-3" style="color:rgb(29, 29, 31)">{!! $floorplan->plan_additional_text !!}</div>
                                <div class="font-size-sm mt-3 additional_text" style="color:rgb(29, 29, 31)">
                                    {!! $floorplan->pivot->floor_plan_additional_text !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row mobile-floor-card-detail">
                    {{-- <div class="col-12 d-flex justify-content-end">
                    <div class="row">
                        @foreach ($floorplan->videos as $video)
                            @if (count($floorplan->videos) == 1)
                                <a href="#"  class="m-1 btn text-white floorplan-video" data-src="{{ $video['vid_url'] }}" data-alt="{{ $video['vid_name'] }}" style="background-color: gray; min-width:172px;"><i class="fa fa-play text-white"></i> Video {{$video['vid_name']}}</a>
                            @elseif(count($floorplan->videos) == 2)
                                <div class="col-md-6 d-flex justify-content-end">
                                    <a href="#" class="mt-1 ml-1 btn text-white floorplan-video" data-src="{{ $video['vid_url'] }}" data-alt="{{ $video['vid_name'] }}" style="background-color: gray; min-width:175px;"><i class="fa fa-play text-white"></i> Video {{$video['vid_name']}}</a>
                                </div>
                            @else
                                <div class="col-md-4 d-flex justify-content-end">
                                    <a href="#" class="mt-1 ml-1 btn text-white floorplan-video" data-src="{{ $video['vid_url'] }}" data-alt="{{ $video['vid_name'] }}" style="background-color: gray; min-width:130px;"><i class="fa fa-play text-white"></i> Video {{$video['vid_name']}}</a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div> --}}
                    @foreach ($floorplan->images as $image)
                        @php
                            $src = $image['pic_url'];
                            $alt = $image['pic_name'];
                        @endphp
                        <div class="col-sm-6 py-5">
                            <div class="item-small-image floorplan-image" data-src="{{ $src }}"
                                data-alt="{{ $alt }}">
                                <img src="{{ $src }}" alt="{{ $alt }}">
                            </div>
                            <div class="mt-2 text-center">{{ $alt }}</div>
                        </div>
                    @endforeach
                </div>
                <hr />

                <div class="card-body">
                    <div class="h2 text-center">
                        Contact Us
                    </div>

                    @include('contractor.floorplan.contact_us_embed', ['floorplan_name'=> $name])

                    <form
                        action="{{ route('contractor.contact.submit', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id]) }}"
                        enctype="multipart/form-data" method="POST" style="display:none;">
                        @csrf
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" id="name" name="name" class="form-control form-control-solid"
                                placeholder="Enter your name" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" id="email" name="email" class="form-control form-control-solid"
                                placeholder="Enter your email" required>
                        </div>
                        <div class="form-group">
                            <label>State</label>
                            <select class="form-control form-control-solid" name="state">
                                <option value="AL">Alabama</option>
                                <option value="AK">Alaska</option>
                                <option value="AZ">Arizona</option>
                                <option value="AR">Arkansas</option>
                                <option value="CA">California</option>
                                <option value="CO">Colorado</option>
                                <option value="CT">Connecticut</option>
                                <option value="DE">Delaware</option>
                                <option value="DC">District Of Columbia</option>
                                <option value="FL">Florida</option>
                                <option value="GA">Georgia</option>
                                <option value="HI">Hawaii</option>
                                <option value="ID">Idaho</option>
                                <option value="IL">Illinois</option>
                                <option value="IN">Indiana</option>
                                <option value="IA">Iowa</option>
                                <option value="KS">Kansas</option>
                                <option value="KY">Kentucky</option>
                                <option value="LA">Louisiana</option>
                                <option value="ME">Maine</option>
                                <option value="MD">Maryland</option>
                                <option value="MA">Massachusetts</option>
                                <option value="MI">Michigan</option>
                                <option value="MN">Minnesota</option>
                                <option value="MS">Mississippi</option>
                                <option value="MO">Missouri</option>
                                <option value="MT">Montana</option>
                                <option value="NE">Nebraska</option>
                                <option value="NV">Nevada</option>
                                <option value="NH">New Hampshire</option>
                                <option value="NJ">New Jersey</option>
                                <option value="NM">New Mexico</option>
                                <option value="NY">New York</option>
                                <option value="NC">North Carolina</option>
                                <option value="ND">North Dakota</option>
                                <option value="OH">Ohio</option>
                                <option value="OK">Oklahoma</option>
                                <option value="OR">Oregon</option>
                                <option value="PA">Pennsylvania</option>
                                <option value="RI">Rhode Island</option>
                                <option value="SC">South Carolina</option>
                                <option value="SD">South Dakota</option>
                                <option value="TN">Tennessee</option>
                                <option value="TX">Texas</option>
                                <option value="UT">Utah</option>
                                <option value="VT">Vermont</option>
                                <option value="VA">Virginia</option>
                                <option value="WA">Washington</option>
                                <option value="WV">West Virginia</option>
                                <option value="WI">Wisconsin</option>
                                <option value="WY">Wyoming</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Zip Code</label>
                            <input type="text" id="zip_code" name="zip_code" class="form-control form-control-solid"
                                placeholder="Enter your zip code">
                        </div>
                        <div class="form-group">
                            <label>What are you interested in buying</label>
                            <select class="form-control form-control-solid" name="interest_in_buy">
                                @foreach (json_decode($category_mapping) as $key => $category_id)
                                    <?php
                                    $category = DB::table('floor_plan_categories')->where('id', $category_id)->first();
                                    ?>
                                    <option value={{ $category->id }}>{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Floor Plan you are interested in</label>
                            <select class="form-control form-control-solid" name="interest_in_floor_plan">
                                @foreach ($contractor_floorplans as $key => $contractor_floorplan)
                                    <option value={{ $contractor_floorplan->id }}>{{ $contractor_floorplan->plan_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Number of Homes you want to build</label>
                            <select class="form-control form-control-solid" name="number_of_home">
                                @foreach ($number_of_homes as $key => $number_of_home)
                                    <option value={{ $key }}>{{ $number_of_home }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Budget (completed home, all in budget)</label>
                            <select class="form-control form-control-solid" name="budget">
                                @foreach ($budgets as $key => $budget)
                                    <option value={{ $key }}>{{ $budget }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Time Frame</label>
                            <select class="form-control form-control-solid" name="time_frame">
                                @foreach ($time_frames as $key => $time_frame)
                                    <option value={{ $key }}>{{ $time_frame }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Comment</label>
                            <textarea id="comment" name="comment" class="form-control form-control-solid" placeholder="Enter your comment"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn">Submit</button>
                        </div>
                    </form>
                </div>
                <div class="d-flex justify-content-end align-items-center flex-wrap mr-9">
                    <a href="{{ route('contractor.productgroups.index', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id, 'group' => 0]) }}" id="design-center-show-page"
                        class="blue-color option-button card-link d-none">Design Center</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="floorplan-zoom-modal">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>

    

    <script>
        function toggleSize(element) {
            element.classList.toggle('enlarged');
        }

        $(document).ready(function() {
            var showPageHref = $('#design-center-show-page').attr('href');
            $('#design-center-footer').attr('href', showPageHref   );
        })
    </script>
@endsection
