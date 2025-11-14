    <div class="form-group">
        <label for="contractor_id">Contract Name :</label>
        <select name="contractor_id" id="contractor_id" class="form-control form-control-solid custom-select">
            @foreach ($contractors as $contractor)
                <option value="{{ $contractor->id }}" @if($contractor->company_name == $category_mapping["contractor_name"]) selected @endif>{{ $contractor->company_name }}</option>
            @endforeach
        </select>
        @error('contractor_name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label>Category Mapping :</label>
        <select name="category_ids[]" id="category_ids" multiple multiselect-hide-x="true">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @if(strpos($category_mapping["category_ids"], '"' . $category->id . '"') !== false) selected @endif>{{ $category->category_name }}</option>
            @endforeach
        </select>
    </div>
