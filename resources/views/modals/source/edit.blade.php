<div class="modal fade" id="editSourceModal" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Source Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('settings.source.update') }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Left Element -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="edit_supplier">Supplier <span style="color: red;">*</span></label>
                                <input type="hidden" class="form-control" name="source_id" id="edit_source_id">
                                <select class="form-control select2 @error('supplier') is-invalid @enderror" name="supplier_id" id="edit_supplier" required>
                                </select>

                                @error('supplier')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="edit_item_code">Item Code <span style="color: red;">*</span></label>
                                <input type="text" class="form-control @error('item_code') is-invalid @enderror" name="item_code" id="edit_item_code"
                                    value="{{ old('item_code') }}" required>

                                @error('item_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_description">Description <span style="color: red;">*</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="edit_description" cols="5"
                                    rows="3" required>{{ old('description') }}</textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="edit_unit_price">Unit Price <span style="color: red;">*</span></label>
                                <input type="text" class="form-control @error('unit_price') is-invalid @enderror" name="unit_price" id="edit_unit_price"
                                    value="{{ old('unit_price') }}" required>

                                @error('unit_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="edit_currency_rate">Currency Rate <span style="color: red;">*</span></label>
                                <input type="text" class="form-control @error('currency_rate') is-invalid @enderror" name="currency_rate" id="edit_currency_rate"
                                    value="{{ old('currency_rate') }}" required>

                                @error('currency_rate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="edit_tp_php">Total Price (Php)</label>
                                <input type="text" class="form-control @error('tp_php') is-invalid @enderror" name="tp_php" id="edit_tp_php"
                                    value="{{ old('tp_php') }}" required readonly>

                                @error('tp_php')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="edit_tp_php_less_tax">Total Price (Less Tax in PH)</label>
                                <input type="text" class="form-control @error('tp_php_less_tax') is-invalid @enderror" name="tp_php_less_tax" id="edit_tp_php_less_tax"
                                    value="{{ old('tp_php_less_tax') }}" required readonly>

                                @error('tp_php_less_tax')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- End Left Element -->
                    <!-- Right Element -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_uom">UOM</label>
                                <select class="form-control @error('uom_id') is-invalid @enderror" name="uom_id" id="edit_uom">
                                    <option value="" selected disabled>Select unit of measurement</option>
                                    @foreach ($unitOfMeasurements as $uom)
                                        <option value="{{ $uom->id }}" {{ (old('uom_id') == $uom->id ? 'selected' : '') }}>{{ $uom->uom }}</option>
                                    @endforeach
                                </select>

                                @error('uom_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_segment">Segment</label>
                                <select class="form-control @error('segment') is-invalid @enderror" name="segment" id="edit_segment">
                                    <option value="" selected disabled>Select Segment</option>
                                    @foreach ($segments as $segment)
                                        <option value="{{ $segment->id }}" {{ (old('uom_id') == $segment->id ? 'selected' : '') }}>{{ $segment->segment }}</option>
                                    @endforeach
                                </select>

                                @error('sgement')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_item_category">Item Category <span style="color: red;">*</span></label>
                                <select class="form-control @error('item_category_id') is-invalid @enderror" name="item_category_id" id="edit_item_category" required>
                                    <option value="" selected disabled>Select Item Category</option>
                                    @foreach ($itemCategories as $itemCategory)
                                        <option value="{{ $itemCategory->id }}" {{ (old('item_category') == $itemCategory->id ? 'selected' : '') }}>{{ $itemCategory->category_name }}</option>
                                    @endforeach
                                </select>

                                @error('item_category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edit_mandatory_peripherals">Mandatory Peripherals</label>
                                <input type="text" class="form-control select2 @error('mandatory_peripherals') is-invalid @enderror" name="mandatory_peripherals[]" multiple="multiple" id="edit_mandatory_peripherals"
                                    value="{{ old('mandatory_peripherals') }}">

                                @error('mandatory_peripherals')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_cost_of_peripherals">Cost of Peripherals</label>
                                <input type="text" class="form-control @error('cost_of_peripherals') is-invalid @enderror" name="cost_of_peripherals" id="edit_cost_of_peripherals"
                                    value="{{ old('cost_of_peripherals') }}">

                                @error('cost_of_peripherals')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_standard_price">Standard Price</label>
                                <input type="text" class="form-control @error('standard_price') is-invalid @enderror" name="standard_price" id="edit_standard_price" required
                                    value="{{ old('standard_price') }}" readonly>

                                @error('standard_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_profitability">Profitability</label>
                                <input type="text" class="form-control @error('profitability') is-invalid @enderror" name="profitability" id="edit_profitability" required
                                    value="{{ old('profitability') }}"  readonly>

                                @error('profitability')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- End Right Element -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
