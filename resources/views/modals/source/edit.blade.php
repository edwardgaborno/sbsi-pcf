<div class="modal fade" id="editSourceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Source Dertails</h5>
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="specimen_type">Supplier</label>
                                <input type="hidden" class="form-control" name="source_id" id="edit_source_id">
                                <input type="text" class="form-control @error('supplier') is-invalid @enderror" 
                                    name="supplier" id="edit_supplier" value="{{ old('supplier') }}" required>
                            </div>

                            @error('supplier')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="specimen_type">Item Code</label>
                                <input type="text" class="form-control" name="item_code" id="edit_item_code"
                                    value="{{ old('item_code') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description" id="edit_description" cols="5"
                                    rows="3">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="specimen_type">Unit Price</label>
                                <input type="number" class="form-control" name="unit_price" id="edit_unit_price"
                                    step=".01" value="{{ old('unit_price') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="specimen_type">Currency Rate</label>
                                <input type="number" class="form-control" name="currency_rate" id="edit_currency_rate"
                                    step=".01" value="{{ old('currency_rate') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="specimen_type">Total Price (Php)</label>
                                <input type="number" class="form-control" name="tp_php" id="edit_tp_php"
                                    step=".01" value="{{ old('tp_php') }}" required readonly>
                            </div>
                        </div>
                    </div>
                    <!-- End Left Element -->
                    <!-- Right Element -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="specimen_type">Item Group</label>
                                <input type="text" class="form-control" name="item_group" id="edit_item_group"
                                    value="{{ old('item_group') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="specimen_type">UOM</label>
                                <input type="text" class="form-control" name="uom" id="edit_uom"
                                    value="{{ old('uom') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="specimen_type">Mandatory Peripherals</label>
                                <input type="text" class="form-control" name="mandatory_peripherals" id="edit_mandatory_peripherals"
                                    value="{{ old('mandatory_peripherals') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="specimen_type">Cost of Peripherals</label>
                                <input type="text" class="form-control" name="cost_of_peripherals" id="edit_cost_of_peripherals"
                                    value="{{ old('cost_periph') }}" required>
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
