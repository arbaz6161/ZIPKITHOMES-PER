    <div class="form-group">
        <label for="plan_name">Floor Plan Name :</label>
        <input id="plan_name" name="plan_name"
            class="form-control form-control-solid @error('plan_name') is-invalid @enderror" placeholder="Enter plan name"
            value="{{ old('plan_name', $floorplan['plan_name']) }}">
        @error('plan_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="plan_description">Title Text :</label>
        <input id="plan_description" name="plan_description"
            class="form-control form-control-solid @error('plan_description') is-invalid @enderror"
            placeholder="Enter plan title" value="{{ old('plan_description', $floorplan['plan_description']) }}">
        @error('plan_description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="category_id">Category:</label>
        <select name="category_id" id="category_id" class="form-control form-control-solid custom-select">
            <option value=""></option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @if ($floorplan['category_id'] == $category->id) selected @endif>
                    {{ $category->category_name }}</option>
            @endforeach
        </select>
        @error('category_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="order">Order:</label>
        <input id="order" name="order" type="number"
            class="form-control form-control-solid @error('order') is-invalid @enderror" placeholder="Enter order"
            value="{{ old('order', $floorplan['order']) }}">
        @error('order')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="plan_additional_text">Additional Plan Information :</label>
        <textarea id="plan_additional_text" name="plan_additional_text"
            class="form-control form-control-solid @error('plan_additional_text') is-invalid @enderror my-mce-editor"
            placeholder="Enter additional information" rows="10">{{ old('plan_additional_text', $floorplan['plan_additional_text']) }}</textarea>
        @error('plan_additional_text')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    @for ($i = 0; $i < old('image_cnt', $image_cnt); $i++)
        <div class="row align-items-start image-row" tabindex="{{ $i + 1 }}">
            <div class="form-group col-md-6 col-sm-12">
                <label for="pic_name{{ $i + 1 }}">{{ $i == 0 ? 'Key Pic Name' : 'Pic' . ($i + 1) . 'Name' }}
                    :</label>
                <input id="pic_name{{ $i + 1 }}" name="images[{{ $i + 1 }}][pic_name]"
                    class="form-control form-control-solid @error('images.' . ($i + 1) . '.pic_name') is-invalid @enderror"
                    placeholder="{{ $i == 0 ? 'Enter key pic name' : 'Enter picture' . ($i + 1) . 'name' }}"
                    value="{{ old('images.' . ($i + 1) . '.pic_name', isset($floorplan['images'][$i]['pic_name']) ? $floorplan['images'][$i]['pic_name'] : '') }}">
                @error('images.' . ($i + 1) . '.pic_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-md-5 col-11">
                <label for="">&nbsp;</label>
                <div class="custom-file">
                    <input type="hidden" name="images[{{ $i + 1 }}][pic_url]"
                        value="{{ old('images.' . ($i + 1) . '.pic_url', isset($floorplan['images'][$i]['pic_url']) ? $floorplan['images'][$i]['pic_url'] : '') }}">
                    <input type="file"
                        class="custom-file-input @error('images.' . ($i + 1) . '.pic_url') is-invalid @enderror"
                        id="customFile">
                    <label class="custom-file-label"
                        for="customFile">{{ old('images.' . ($i + 1) . '.pic_url', isset($floorplan['images'][$i]['pic_url']) ? $floorplan['images'][$i]['pic_url'] : '') == '' ? 'Drag Picture Here' : 'File attached' }}</label>
                    @error('images.' . ($i + 1) . '.pic_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                @if (old(
                        'images.' . ($i + 1) . '.pic_url',
                        isset($floorplan['images'][$i]['pic_url']) ? $floorplan['images'][$i]['pic_url'] : '') != '')
                    <div class="preview-image">
                        <img class="img-thumbnail"
                            src="{{ old('images.' . ($i + 1) . '.pic_url', isset($floorplan['images'][$i]['pic_url']) ? $floorplan['images'][$i]['pic_url'] : '') }}">
                    </div>
                @endif
            </div>
            @unless ($i == 0)
                <div class="col-1">
                    <button type="button" class="btn btn-sm btn-clean btn-icon image-delete"><i
                            class="icon-xl la la-trash-o"></i></button>
                </div>
            @endunless
        </div>
    @endfor

    <div class="d-flex justify-content-end mb-5">
        <input type="hidden" name="image_cnt" value="{{ old('image_cnt', $image_cnt) }}">
        <button type="button" class="btn btn-info add-more-image">Add More Images</button>
    </div>

    @for ($i = 0; $i < old('video_cnt', $video_cnt); $i++)
        <div class="row align-items-start video-row" tabindex="{{ $i + 1 }}">
            <div class="form-group col-md-6 col-sm-12">
                <label
                    for="vid_name{{ $i + 1 }}">{{ $i == 0 ? 'Key Media Name' : 'Media' . ($i + 1) . 'Name' }}
                    :</label>
                <input id="vid_name{{ $i + 1 }}" name="media[{{ $i + 1 }}][vid_name]"
                    class="form-control form-control-solid @error('media.' . ($i + 1) . '.vid_name') 
                is-invalid @enderror"
                    placeholder="{{ $i == 0 ? 'Enter key media name' : 'Enter media' . ($i + 1) . ' name' }}"
                    value="{{ old('media.' . ($i + 1) . '.vid_name', isset($floorplan['videos'][$i]['vid_name']) ? $floorplan['videos'][$i]['vid_name'] : '') }}">
                @error('media.' . ($i + 1) . '.vid_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-md-5 col-11">
                <label for="">&nbsp;</label>
                <div class="custom-file d-flex">

                    <input type="text" class="form-control form-control-solid"
                        placeholder='{{ old('media.' . ($i + 1) . '.vid_url', isset($floorplan['videos'][$i]['vid_url']) ? $floorplan['videos'][$i]['vid_url'] : '') == '' ? 'Please enter the video file link or upload a video file' : $floorplan['videos'][$i]['vid_url'] }}'
                        style="border-color: #E4E6EF; border-radius: 0.42rem 0 0 0.42rem;"
                        id="mediaURL{{ $i + 1 }}" name="media[{{ $i + 1 }}][custom_vid_url]">
                    <label class="custom-file-input-video-parent">
                        <input type="hidden" name="media[{{ $i + 1 }}][vid_url]"
                            value="{{ old('media.' . ($i + 1) . '.vid_url', isset($floorplan['videos'][$i]['vid_url']) ? $floorplan['videos'][$i]['vid_url'] : '') }}">
                        <input type="file" accept="video/*"
                            class="custom-file-input-video @error('media.' . ($i + 1) . '.vid_url') is-invalid @enderror"
                            id="customMedia{{ $i + 1 }}" name="customMedia{{ $i + 1 }}">Browse
                    </label>
                    @error('media.' . ($i + 1) . '.vid_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                @if (old(
                        'media.' . ($i + 1) . '.vid_url',
                        isset($floorplan['videos'][$i]['vid_url']) ? $floorplan['videos'][$i]['vid_url'] : '') != '')
                    <div class="preview-video">
                        <video class="video-thumbnail" width="50%" controls>
                            <source
                                src="{{ old('media.' . ($i + 1) . '.vid_url', isset($floorplan['videos'][$i]['vid_url']) ? $floorplan['videos'][$i]['vid_url'] : '') }}"
                                type="{{ old('media.' . ($i + 1) . '.vid_url_type', isset($floorplan['videos'][$i]['vid_url_type']) ? $floorplan['videos'][$i]['vid_url_type'] : '') }}">
                        </video>
                    </div>
                @endif
            </div>
            @unless ($i == 0)
                <div class="col-1">
                    <button type="button" class="btn btn-sm btn-clean btn-icon media-delete"><i
                            class="icon-xl la la-trash-o"></i></button>
                </div>
            @endunless
        </div>
    @endfor
    <div class="d-flex justify-content-end mb-5">
        <input type="hidden" name="video_cnt" value="{{ old('video_cnt', $video_cnt) }}">
        <button type="button" class="btn btn-info add-more-video">Add More Videos</button>
    </div>
