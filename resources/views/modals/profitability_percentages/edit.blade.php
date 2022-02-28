<div class="modal fade" id="edit-price-modal" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Profitability Percentage</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('settings.profitability_percentage.update') }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit-item-category">Item Category<span style="color: red;"> *</span></label>
                                <input type="hidden" name="profit_rate_id" id="profit_rate_id">
                                <select class="form-control @error('item_category_id') is-invalid @enderror" name="item_category_id" id="edit-item-category" required>
                                    <option value="" selected disabled>Select item category</option>
                                    @foreach ($item_categories as $item_category)
                                        <option value="{{ $item_category->id }}" {{ (old('item_category_id') == $item_category->id ? 'selected' : '') }}>{{ $item_category->category_name }}</option>
                                    @endforeach
                                </select>

                                @error('item_category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit-price-percentage">Percentage<span style="color: red;"> *</span></label>
                                <input type="number" class="form-control @error('percentage') is-invalid @enderror" name="percentage" id="edit-price-percentage" value="{{ old('percentage') }}" min="0" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" step="0.00" required>

                                @error('percentage')
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
                    <button type="submit" class="btn btn-primary"><i class="far fa-save"></i> &nbsp;Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
