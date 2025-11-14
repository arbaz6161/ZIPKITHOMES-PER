<div class="form-group">
    <label for="contractor_id">CONTRACTORS :</label>
    <select name="contractor_id" id="contractor_id"
        class="form-control form-control-solid custom-select @error('contractor_id') is-invalid @enderror">
        <option value="" {{ old('contractor_id', $customer['contractor_id']) == '' ? 'selected' : '' }}></option>
        @foreach ($contractors as $contractor)
            <option value="{{ $contractor->id }}"
                {{ old('contractor_id', $customer['contractor_id']) == $contractor->id ? 'selected' : '' }}>
                {{ $contractor->company_name }}</option>
        @endforeach
    </select>
    @error('contractor_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="source_website">SOURCE WEBSITE :</label>
    <input id="source_website" name="source_website"
        class="form-control form-control-solid @error('source_website') is-invalid @enderror"
        placeholder="Enter source website" value="{{ old('source_website', $customer['source_website']) }}">
    @error('source_website')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="name">Name :</label>
    <input id="name" name="name" class="form-control form-control-solid @error('name') is-invalid @enderror"
        placeholder="Enter name" value="{{ old('name', $customer['name']) }}">
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="email">Email :</label>
    <input id="email" name="email" type="email"
        class="form-control form-control-solid @error('email') is-invalid @enderror" placeholder="Enter email"
        value="{{ old('email', $customer['email']) }}">
    @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="phone">Phone :</label>
    <input id="phone" name="phone" class="form-control form-control-solid @error('phone') is-invalid @enderror"
        placeholder="Enter phone" value="{{ old('phone', $customer['phone']) }}">
    @error('phone')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="form-group col-md-4">
        <label for="home_location">Home location :</label>
        <input id="home_location" name="home_location"
            class="form-control form-control-solid @error('home_location') is-invalid @enderror"
            placeholder="Enter home location" value="{{ old('home_location', $customer['home_location']) }}">
        @error('home_location')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group col-md-4">
        <label for="home_state">Home state :</label>
        <input id="home_state" name="home_state"
            class="form-control form-control-solid @error('home_state') is-invalid @enderror"
            placeholder="Enter home state" value="{{ old('home_state', $customer['home_state']) }}">
        @error('home_state')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group col-md-4">
        <label for="home_zip">Home zip :</label>
        <input id="home_zip" name="home_zip"
            class="form-control form-control-solid @error('home_zip') is-invalid @enderror" placeholder="Enter home zip"
            value="{{ old('home_zip', $customer['home_zip']) }}">
        @error('home_zip')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>


<div class="form-group">
    <label for="note">Note :</label>
    <textarea id="note" name="note"
        class="form-control form-control-solid @error('note') is-invalid @enderror"
        placeholder="Enter note" rows="3">{{ old('note', $customer['note']) }}</textarea>
    @error('note')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
