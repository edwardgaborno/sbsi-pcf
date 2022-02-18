<div class="modal fade" id="add-price-modal" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Profitability Percentage</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('settings.profitability_percentage.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="item_category_id">Item Category<span style="color: red;"> *</span></label>
                                <select class="form-control @error('item_category_id') is-invalid @enderror" name="item_category_id" id="item_category_id" required>
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
                                <label for="price-percentage">Percentage<span style="color: red;"> *</span></label>
                                <input type="number" class="form-control @error('percentage') is-invalid @enderror" name="percentage" id="price-percentage" value="{{ old('percentage') }}" min="0" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" step="0.1" required>

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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
