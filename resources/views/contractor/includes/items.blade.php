<div class="row align-items-center items-table my-2">
    <div class="col-sm-4 text-sm-center">
        <strong>Image</strong>
    </div>
    <div class="col-sm-{{ isset($not_editable) && $not_editable ? '3' : '2' }}">
        <strong>Option</strong>
    </div>
    <div class="col-sm-3">
        <strong>Upgrade Cost</strong>
    </div>
    @unless (isset($not_editable) && $not_editable)
        <div class="col-sm-2"></div>
    @endunless
    @if (session()->has('items'))
        @php
            $items = App\Helpers\ManageItems::get_items($contractor, $floorplan);
        @endphp
        @forelse ($items as $key => $item)
            @php
                $product = $contractor->products()->where('product_id', $item['product_id'])->withPivot('is_not_display_price', 'is_enter_price', 'product_price')->first();
            @endphp
            <div class="col-sm-4 item-tiny-image">
                <img src="{{ $product->images[0]['pic_url'] }}" alt="{{ $product->images[0]['pic_name'] }}">
            </div>
            <div class="col-sm-{{ isset($not_editable) && $not_editable ? '3' : '2' }}" style="font-size:0.8em">{{ $product->pdt_name }}</div>
            <div class="col-sm-3">${{ $product->pivot->is_not_display_price || !$product->pivot->is_enter_price ? 0 : $product->pivot->product_price}}</div>
            @unless (isset($not_editable) && $not_editable)
                <div class="col-sm-2">
                    <a href="{{ route('contractor.items.destroy', ['subdomain' => $subdomain, 'item' => $key]) }}" class="btn btn-sm btn-clean btn-icon delete" data-id="{{ $key }}">
                        <i class="icon-xl la la-trash-o text-danger"></i>
                    </a>
                </div>
            @endunless
            @if($subdomain == 'shurtzcanyon')
                @if ($item['comment'])
                    <div class="col-sm-11 row mx-5 comment-container">
                        <div class="col-sm-3 text-sm-center comment-label">
                            <strong>Comment: </strong>
                        </div>
                        <div class="col-sm-8 text-sm-start comment-text">
                            <span>{{ $item['comment'] }}</span>
                        </div>
                    </div>
                @else
                    <div class="col-12">
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            <label for="comments"><strong>Comment: </strong></label>
                            <input type="hidden" id="floorplan" value="{{ $floorplan->id }}">
                            <input type="hidden" id="product" value="{{ $product->id }}">
                            <textarea
                                name="comment"
                                id="comment"
                                class="form-control form-control-solid w-10 @error('comment') is-invalid @enderror"
                                placeholder="Note ...."
                                rows="1"
                            ></textarea>

                        <div class="col-sm-2 d-flex align-items-end">
                            <button id="submitButton" class="btn product-btn">Submit</button>
                        </div>
                    </div>
                @endif
            @endif
            @empty
            <div class="alert alert-secondary w-100" style="color: black;">No chosen items</div>
        @endforelse
    @else
    <div class="alert alert-secondary w-100" style="color: black;">No chosen items</div>
    @endif
</div>

<hr>

<style>
    .comment-container {
        border: 2px solid #dcd7d7;
        border-radius: 8px;
        background-color: #f8f9fa;
    }

    .comment-label {
        font-weight: bold;
        color:
    }

    .comment-text {
        color:
    }

    .swiper {
        width: 100%;
        height: 100%;
    }

    .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .swiper-slide img {
        display: block;
        /* width: 100%; */
        height: 100%;
        object-fit: cover;
    }

    .swiper-button-next {
        color: gray;
    }

    .swiper-button-prev {
        color: gray;
    }

    .product-btn {
        background-color: #007AFF;
        color: rgb(255,255,255);
    }

    .product-btn:hover {
        background-color: #007AFF;
        color: rgb(255,255,255);
    }
</style>

<script>
    $(document).ready(function() {
        $('#submitButton').click(function() {

            const floorplan = $('#floorplan').val();
            const routeUrl = '{{ url("floorplans") }}/' + floorplan + '/items/update';

            $.ajax({
                url: routeUrl,
                method: 'POST',
                data: {
                    comment: $('#comment').val(),
                    product_id: $('#product').val(),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // For Laravel CSRF protection
                },
                success: function(response) {
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    alert('Request failed!');
                    console.error(error);
                }
            });
        });
    });
</script>
