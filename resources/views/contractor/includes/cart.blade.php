<div class="row items-table my-2">
    @unless (isset($not_editable) && $not_editable)
        {{-- <div class="col-sm-2"></div> --}}
    @endunless

    @if (session()->has('items'))
        @php
            $items = App\Helpers\ManageItems::get_items($contractor, $floorplan);
        @endphp
        @forelse ($items as $key => $item)
            @php
                $product = $contractor
                    ->products()
                    ->where('product_id', $item['product_id'])
                    ->withPivot('is_not_display_price', 'is_enter_price', 'product_price')
                    ->first();
            @endphp
            <div class="col-sm-3 item-tiny-image">
                <img src="{{ $product->images[0]['pic_url'] }}" alt="" loading="lazy">
            </div>
            <div class="title-wrapper d-flex flex-row col-sm-9">
                <div class="col-sm-11 p-0">
                    <div class="item-tiny-title p-0" style="font-weight:700; font-size: 14px;">{{ $product->pdt_name }}
                    </div>
                    {{--  <div class="d-flex justify-content-between p-0 mt-2">
                        <div class=" item-tiny-amount p-0" style="font-weight:500; font-size: 14px;">QTY: {{ $item['product_quantity'] }}</div>
                        <div class=" item-tiny-amount pr-4 pt-0" style="font-weight:500; font-size: 14px;">
                            ${{ $product->pivot->is_not_display_price || !$product->pivot->is_enter_price ? 0 : $product->pivot->product_price * $item['product_quantity'] }}
                        </div>
                    </div>  --}}
                </div>
                @unless (isset($not_editable) && $not_editable)
                    <div class="delete-icon col-sm-1 p-0 align-items-start mb-1">
                        <a href="{{ route('contractor.items.destroy', ['subdomain' => $subdomain, 'item' => $key]) }}"
                            class="btn btn-sm btn-clean btn-icon delete" data-id="{{ $key }}">
                            <i class="icon-xl la la-trash-o text-danger"></i>
                        </a>
                    </div>
                @endunless
            </div>
            <div class="col-sm-12 mb-5">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <input type="hidden" id="floorplan" value="{{ $floorplan->id }}">
                <input type="hidden" id="product" value="{{ $product->id }}">

                <div class="commentSection_{{ $product->id }}">
                    @if (isset($item['comment']))
                        <div class="comment-container">
                            <div class="col-sm-3 text-sm-start comment-label">
                                Comment:
                            </div>

                            <div class="col-sm-8 text-sm-start comment-text">
                                <span>{{ $item['comment'] }}</span>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button id="editButton" class="editButton p-0 m-0 mr-1" data-product-id="{{ $product->id }}" style="border: none; background-color: transparent;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                        <g id="Group_52" data-name="Group 52" transform="translate(-0.22 0.248)">
                                            <circle id="Ellipse_6" data-name="Ellipse 6" cx="10" cy="10" r="10" transform="translate(0.22 -0.248)" fill="#12850a"/>
                                            <g id="g2151" transform="translate(5.819 5.319)">
                                            <path id="path851" d="M-337.772-1097.738a.365.365,0,0,0,0-.541l-1.81-1.81a.382.382,0,0,0-.541,0l-2.936,2.93-2.932,2.927c-.151.938-.307,1.881-.458,2.819l2.809-.468c1.518-1.519,2.236-2.233,2.96-2.955S-339.242-1096.267-337.772-1097.738Z" transform="translate(346.448 1100.201)" fill="none" stroke="#fefeff" stroke-linecap="round" stroke-linejoin="round" stroke-width="0.8"/>
                                            <rect id="rect919" width="0.553" height="3.365" rx="0.277" transform="matrix(-0.707, 0.707, -0.707, -0.707, 7.981, 3.16)" fill="#fff"/>
                                            <path id="path925" d="M-344.769-955.918l-1.615-1.615-.064,1.656Z" transform="translate(346.448 964.665)" fill="#fff"/>
                                            <rect id="rect927" width="0.553" height="3.365" rx="0.277" transform="matrix(-0.707, 0.707, -0.707, -0.707, 3.239, 7.872)" fill="#fff"/>
                                            </g>
                                        </g>
                                    </svg>
                                </button>

                                <button id="deleteButton" class="deleteButton p-0 m-0 mr-1" data-product-id="{{ $product->id }}" style="border: none; background-color: transparent;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                        <g id="Group_53" data-name="Group 53" transform="translate(-0.284 0.248)">
                                            <circle id="Ellipse_9" data-name="Ellipse 9" cx="10" cy="10" r="10" transform="translate(0.284 -0.248)" fill="#e02020"/>
                                            <g id="g2234" transform="translate(6.972 4.433)">
                                            <path id="rect989-9" d="M-872.868-414.187H-867a.34.34,0,0,1,.341.34v8.084a.34.34,0,0,1-.341.34h-5.872a.34.34,0,0,1-.341-.34v-8.084A.34.34,0,0,1-872.868-414.187Z" transform="translate(873.209 415.293)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="0.8"/>
                                            <path id="path1131" d="M-872.764-428.6h6.525" transform="translate(872.789 428.902)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="0.8"/>
                                            <path id="path1133" d="M-847.834-394.011v6.5" transform="translate(849.257 396.249)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="0.8"/>
                                            <path id="path1135" d="M-814.784-394.011v6.5" transform="translate(818.062 396.249)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="0.8"/>
                                            <path id="path1137" d="M-781.734-394.011v6.5" transform="translate(786.866 396.249)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="0.8"/>
                                            <path id="path1139" d="M-831.685-433.911h1.916" transform="translate(834.014 433.911)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="0.8"/>
                                            </g>
                                        </g>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="comment-form-container p-0 m-0" style="display: block;">
                            <div class="col-sm-12 p-0">
                                <label for="comments"><strong>Comment: </strong></label>
                                <textarea name="comment" id="comment_{{ $product->id }}"
                                    class="form-control form-control-solid w-100  @error('comment') is-invalid @enderror" placeholder="Note ...."
                                    rows="1" style="color: #767676 !important; height: 70px; resize:none; width:100%; border: 1px solid #E8E8E8; border-radius: 8px;"></textarea>
                            </div>
                            <div class=" d-flex justify-content-end mt-2 p-0">
                                <button id="submitButton" class="submitButton btn product-btn" data-product-id="{{ $product->id }}" style="border-radius: 8px; padding: 6px; width: 100px;">Submit</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="alert alert-secondary w-100"
                style="color: black; padding:30px; background-color: #F8F8F8; font-size: large; font-weight: 400;">No
                chosen items</div>
        @endforelse
    @else
        <div class="alert alert-secondary w-100"
            style="color: black; padding:30px; background-color: #F8F8F8; font-size: large; font-weight: 400;">No chosen
            items</div>
    @endif
</div>

<style>
    .comment-container {
        border: 1px solid #E8E8E8;
        border-radius: 8px;
        background-color: #F2F2F2;
        padding: 10px !important
    }

    .comment-label {
        font-weight: bold;
        padding: 0 !important
    }

    .comment-text {
        color: #767676;
        padding: 0 !important
    }

    .items-table {
        padding-inline: 33px 44px;
    }

    .item-tiny-title {
        display: flex;
        align-items: center;
        text-align: left;
        font: normal 14px;
        color: #061018;
    }

    .item-tiny-amount {
        text-align: left;
        font: normal 16px Poppins;
        color: #0071E3;

    }

    .title-wrapper {
        display: flex;
        flex-direction: column;
    }

    .delete-icon {
        display: flex;
        align-items: center;
    }
</style>

<script>
    $(document).ready(function() {
        $(document).on('click', '.submitButton', function() {

            const productId = $(this).data('product-id');
            const floorplan = $('#floorplan').val();
            const routeUrl = '{{ url('floorplans') }}/' + floorplan + '/items/update';
            const comment = $('#comment_' + productId).val();

            if (comment == '') {
                alert('Comment is required.');
                e.preventDefault(); // Prevent the AJAX call
                return false; // Exit the function
            }

            $.ajax({
                url: routeUrl,
                method: 'POST',
                data: {
                    comment: comment,
                    product_id: productId,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    const productId = response.data['product_id'];
                    const className = '.commentSection_' + productId;

                    $(className).empty();
                    const commentHtml = `
                        <div class="comment-container">
                        <div class="col-sm-3 text-sm-start comment-label pl-0">
                            Comment:
                        </div>

                        <div class="col-sm-8 text-sm-start comment-text">
                            <span>${response.data['comment']}</span>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button id="editButton" class="editButton p-0 m-0 mr-1" data-product-id="${productId}" style="border: none; background-color: transparent;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                    <g id="Group_52" data-name="Group 52" transform="translate(-0.22 0.248)">
                                        <circle id="Ellipse_6" data-name="Ellipse 6" cx="10" cy="10" r="10" transform="translate(0.22 -0.248)" fill="#12850a"/>
                                        <g id="g2151" transform="translate(5.819 5.319)">
                                        <path id="path851" d="M-337.772-1097.738a.365.365,0,0,0,0-.541l-1.81-1.81a.382.382,0,0,0-.541,0l-2.936,2.93-2.932,2.927c-.151.938-.307,1.881-.458,2.819l2.809-.468c1.518-1.519,2.236-2.233,2.96-2.955S-339.242-1096.267-337.772-1097.738Z" transform="translate(346.448 1100.201)" fill="none" stroke="#fefeff" stroke-linecap="round" stroke-linejoin="round" stroke-width="0.8"/>
                                        <rect id="rect919" width="0.553" height="3.365" rx="0.277" transform="matrix(-0.707, 0.707, -0.707, -0.707, 7.981, 3.16)" fill="#fff"/>
                                        <path id="path925" d="M-344.769-955.918l-1.615-1.615-.064,1.656Z" transform="translate(346.448 964.665)" fill="#fff"/>
                                        <rect id="rect927" width="0.553" height="3.365" rx="0.277" transform="matrix(-0.707, 0.707, -0.707, -0.707, 3.239, 7.872)" fill="#fff"/>
                                        </g>
                                    </g>
                                </svg>
                            </button>

                            <button id="deleteButton" class="deleteButton p-0 m-0 mr-1" data-product-id="${productId}" style="border: none; background-color: transparent;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                    <g id="Group_53" data-name="Group 53" transform="translate(-0.284 0.248)">
                                        <circle id="Ellipse_9" data-name="Ellipse 9" cx="10" cy="10" r="10" transform="translate(0.284 -0.248)" fill="#e02020"/>
                                        <g id="g2234" transform="translate(6.972 4.433)">
                                        <path id="rect989-9" d="M-872.868-414.187H-867a.34.34,0,0,1,.341.34v8.084a.34.34,0,0,1-.341.34h-5.872a.34.34,0,0,1-.341-.34v-8.084A.34.34,0,0,1-872.868-414.187Z" transform="translate(873.209 415.293)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="0.8"/>
                                        <path id="path1131" d="M-872.764-428.6h6.525" transform="translate(872.789 428.902)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="0.8"/>
                                        <path id="path1133" d="M-847.834-394.011v6.5" transform="translate(849.257 396.249)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="0.8"/>
                                        <path id="path1135" d="M-814.784-394.011v6.5" transform="translate(818.062 396.249)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="0.8"/>
                                        <path id="path1137" d="M-781.734-394.011v6.5" transform="translate(786.866 396.249)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="0.8"/>
                                        <path id="path1139" d="M-831.685-433.911h1.916" transform="translate(834.014 433.911)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="0.8"/>
                                        </g>
                                    </g>
                                </svg>
                            </button>
                        </div>
                    </div>
                    `;

                    $(className).html(commentHtml);
                },
                error: function(xhr, status, error) {
                    alert('Request failed!');
                    console.error(error);
                }
            });
        });

        $(document).on('click', '.editButton', function() {
            const productId = $(this).data('product-id');
            var className = '.commentSection_' + productId;
            $(className).empty();
            const commentHtml = `
                <div class="comment-form-container p-0 m-0" style="display: block;">
                    <div class="col-sm-12 p-0">
                        <label for="comments"><strong>Comment: </strong></label>

                        <textarea name="comment" id="comment_${productId}"
                            class="form-control form-control-solid w-100  @error('comment') is-invalid @enderror" placeholder="Note ...."
                            rows="1" style="color: #767676 !important; height: 70px; resize:none; width:100%; border: 1px solid #E8E8E8; border-radius: 8px;"></textarea>
                    </div>
                    <div class=" d-flex justify-content-end mt-2 p-0">
                        <button id="submitButton" class="submitButton btn product-btn" data-product-id="${productId}" style="border-radius: 8px; padding: 6px; width: 100px;">Submit</button>
                    </div>
                </div>
            `;

            $(className).html(commentHtml);
        });

        $(document).on('click', '.deleteButton', function() {
            const productId = $(this).data('product-id');
            const floorplan = $('#floorplan').val();
            const routeUrl = '{{ url('floorplans') }}/' + floorplan + '/items/update';
            const comment = '';

            $.ajax({
                url: routeUrl,
                method: 'POST',
                data: {
                    comment: comment,
                    product_id: productId,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    const productId = response.data['product_id'];
                    const className = '.commentSection_' + productId;

                    $(className).empty();
                    const commentHtml = `
                        <div class="comment-form-container p-0 m-0" style="display: block;">
                            <div class="col-sm-12 p-0">
                                <label for="comments"><strong>Comment: </strong></label>

                                <textarea name="comment" id="comment_${productId}"
                                    class="form-control form-control-solid w-100  @error('comment') is-invalid @enderror" placeholder="Note ...."
                                    rows="1" style="color: #767676 !important; height: 70px; resize:none; width:100%; border: 1px solid #E8E8E8; border-radius: 8px;"></textarea>
                            </div>
                            <div class=" d-flex justify-content-end mt-2 p-0">
                                <button id="submitButton" class="submitButton btn product-btn" data-product-id="${productId}" style="border-radius: 8px; padding: 6px; width: 100px;">Submit</button>
                            </div>
                        </div>
                    `;

                    $(className).html(commentHtml);
                },
                error: function(xhr, status, error) {
                    alert('Request failed!');
                    console.error(error);
                }
            });
        });
    });
</script>
