<div class="modal fade" id="add-mp-modal" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Peripheral</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('settings.mandatory_peripheral.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="item_code">Item Code <span style="color: red;">*</span></label>
                                <select name="source_id" id="item_code" class="form-control @error('source_id') is-invalid @enderror select2" required>
                                    <option value="" selected disabled></option>
                                </select>

                                @error('source_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="item_description">Item Description<span style="color: red;"> *</span></label>
                                <input type="text" class="form-control @error('item_description') is-invalid @enderror" name="item_description" id="item_description" value="{{ old('item_description') }}" readonly>

                                @error('item_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="quantity">Quantity<span style="color: red;"> *</span></label>
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" id="quantity" min="0" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" value="{{ old('quantity') }}">

                                @error('quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="peripherals-category-id">Peripheral Category<span style="color: red;"> *</span></label>
                                <select class="form-control @error('peripherals_category_id') is-invalid @enderror" name="peripherals_category_id" id="peripherals-category-id" required>
                                    <option value="" selected disabled>Select peripheral category</option>
                                    @foreach ($mpCategories as $mpCategory)
                                        <option value="{{ $mpCategory->id }}" {{ (old('peripherals_category_id') == $mpCategory->id ? 'selected' : '') }}>{{ $mpCategory->mp_category }}</option>
                                    @endforeach
                                </select>

                                @error('peripherals_category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
