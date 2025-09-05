@extends("contractor.admin.layouts.default")

@section("content")

@php
if($errors->any())
echo "<script>
    window.showModal = true;
</script>";
@endphp

<div class="main-content container">
    <!--begin::Card-->
    <div class=" card card-custom mt-6">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">STEP 3 - CHOOSE WHICH PRODUCT YOU WANT TO OFFER (WITHIN EACH GROUP).</h3>
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

            <div class="form-group row d-flex align-items-center">
                <div class="col m-0" style="max-width:fit-content;">
                    <span class="switch switch-outline switch-icon switch-success">
                        <label>
                            <input type="checkbox" id="products-filter" />
                            <span></span>
                        </label>
                    </span>
                </div>
                <label class="col font-weight-bold m-0" style="max-width:fit-content;">Only My Products</label>
            </div>

            <div class="row">
                <div class="col-3">
                    <h4>Product Groups</h4>
                    <p>Click on each product
                        group to choose which
                        products you will o!er
                        from each group.
                    </p>
                    <ul class="nav flex-column">
                        @foreach ($contractor->productgroups as $selected_productgroup)
                        <li class="nav-item d-flex justify-content-between">
                            <a class="nav-link {{ !$productgroup ? '' : ($productgroup->id == $selected_productgroup->id ? 'active' : '') }}" href="{{ route('contractor.admin.products.index', ['subdomain' => $subdomain, 'productgroup' => $selected_productgroup->id]) }}">{{ $selected_productgroup->pdt_group_name }}</a>
                            <i class="icon-xl la la-check products-completion {{ $contractor->products()->wherePivot('product_group_id', $selected_productgroup->id)->count() > 0 ? 'completed' : '' }}"></i>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-9">
                    <h4>{{ !$productgroup ? "All products" : $productgroup->pdt_group_name }}</h4>
                    <div class="row products-section">
                        @forelse ($products as $product)
                            @php
                            $selected = in_array($contractor->id, Arr::pluck($product->contractors, "id"));

                            $product_price = "";
                            $is_not_display_price = "";
                            $is_enter_price = "";

                            if($selected) {
                                $values = $product->contractors()->where('contractor_id', $contractor->id)->withPivot('product_price', 'is_not_display_price', 'is_enter_price')->first();

                                $product_price = $values['pivot']['product_price'];
                                $is_not_display_price = $values['pivot']['is_not_display_price'];
                                $is_enter_price = $values['pivot']['is_enter_price'];
                            }
                            @endphp
                            <div class="col-lg-6 col-md-12 p-5  product-box {{ $product->contractor_id == Auth::user()->id ? 'my-product-box' : '' }}">
                                <div class="d-flex">
                                    <div class="item-card {{ $selected ? 'selected' : '' }}">
                                        <div class="item-image">
                                            <img src="{{ $product->images[0]['pic_url'] }}" alt="{{ $product->images[0]['pic_name'] }}">
                                        </div>
                                        <div class="item-card-body">
                                            <div class="row mt-2">
                                                <div class="col">
                                                    <p>{{ $product->pdt_name }}</p>
                                                </div>
                                                <div class="col d-flex justify-content-end align-items-start">
                                                    <button type="button" class="btn open-more-modal text-primary p-0" data-name="{{ $product->pdt_name  }}" data-title="{{ $product->pdt_description }}" data-description="{{ $product->pdt_additional_text }}">
                                                        More Info
                                                    </button>
                                                </div>
                                            </div>
                                            <form method="POST" action="{{ route('contractor.admin.products.update_selection', ['subdomain' => $subdomain, 'product' => $product->id, 'productgroup' => $productgroup]) }}">
                                                @csrf
                                                @method("PUT")
                                                <input type="hidden" name="price_updated" value="1">
                                                <input type="hidden" name="status" value="1">
                                                <input type="hidden" name="is_not_display_price" value="0">
                                                <input type="hidden" name="is_enter_price" value="1">
                                                <div class="d-flex justify-content-center form-group">
                                                    <div class="d-flex justify-content-center align-items-end">
                                                        <label class="mr-2">Enter a product price:</label>
                                                    </div>
                                                    <div>
                                                        <input type="number" placeholder="Price ..." class="form-control mr-2 @error('product_price') is-invalid @enderror" style="max-width: 130px !important" name="product_price" value="{{ $product_price }}" min="0">
                                                        @error('product_price')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <button type="submit" class="btn btn-primary ml-auto" style="height: auto;">SAVE</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="item-buttons">
                                        <button type="button" 
                                            class="btn btn-sm btn{{ !$selected ? '' : '-outline' }}-danger select-item" 
                                            data-status="0" 
                                            data-url="{{ route('contractor.admin.products.update_selection', ['subdomain' => $subdomain, 'product' => $product->id, 'productgroup' => $productgroup]) }}"
                                        >
                                            <i class="fa fa-minus"></i>
                                        </button>

                                        <form method="POST" action="{{ route('contractor.admin.products.update_selection', ['subdomain' => $subdomain, 'product' => $product->id, 'productgroup' => $productgroup]) }}">
                                            @csrf
                                            @method("PUT")

                                            <input type="hidden" name="status" value="1">
                                            <input type="hidden" name="is_not_display_price" value="1">

                                            <button type="submit" 
                                                class="btn btn-sm btn{{ $selected ? '' : '-outline' }}-success mb-2">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                        <div class="alert alert-warning w-100" style="height:40px">No product</div>
                        @endforelse
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="d-flex justify-content-end mt-10 mb-5">
                            <a href="{{ route('contractor.admin.products.list', ['subdomain' => $subdomain]) }}" class="btn btn-primary font-weight-bolder align-self-start">Upload your own Products</a>
                        </div>
                        <div class="d-flex justify-content-end mt-10 mb-5">
                            <a href="{{ route('contractor.admin.thanks', ['subdomain' => $subdomain]) }}" class="btn btn-primary">I'm done, Save my selections!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->
</div>

<form method="POST" id="select-item-form">
    @csrf
    @method('PUT')
    <input type="hidden" name="status">
</form>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $(document).on('change', '#products-filter', function() {
                if($(this).prop('checked')) {
                    $('.product-box').fadeOut();
                    $('.my-product-box').fadeIn(500);
                }
                else {
                    $('.product-box').fadeIn(500);
                }
            })
        });
    </script>
@endsection