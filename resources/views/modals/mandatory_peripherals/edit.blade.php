<div class="modal fade" id="edit-mp-modal" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Mandatory Peripheral</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('settings.mandatory_peripheral.update') }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_item_code">Item Code<span style="color: red;"> *</span></label>
                                <input type="hidden" name="mp_id" id="edit-mp-id" value="{{ old('mp_id') }}">
                                <select name="source_id" id="edit_item_code" class="form-control @error('source_id') is-invalid @enderror select2" required>
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
                                <label for="edit_item_description">Item Description<span style="color: red;"> *</span></label>
                                <input type="text" class="form-control @error('item_description') is-invalid @enderror" name="item_description" id="edit_item_description" readonly>

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
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" id="edit-quantity" min="0" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" value="{{ old('quantity') }}">

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
                                <select class="form-control @error('peripherals_category_id') is-invalid @enderror" name="peripherals_category_id" id="edit-peripherals-category-id" required>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> &nbsp;Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="far fa-save"></i> &nbsp;Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
