    <div class="form-group">
        <label for="category_name">Category Name :</label>
        <input id="category_name" name="category_name" class="form-control form-control-solid @error('category_name') is-invalid @enderror" placeholder="Enter category name" value="{{ old('category_name', $category['category_name']) }}">
        @error('category_name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="category_description">Category Description :</label>
        <input id="category_description" name="category_description" class="form-control form-control-solid @error('category_description') is-invalid @enderror" placeholder="Enter category description" value="{{ old('category_description', $category['category_description']) }}">
        @error('category_description')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="is_active">Is Active :</label>
        <input id="is_active" type="checkbox" name="is_active" class="form-control-solid @error('is_active') is-invalid @enderror" @if($category['is_active']) checked @endif value="active">
        @error('is_active')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
