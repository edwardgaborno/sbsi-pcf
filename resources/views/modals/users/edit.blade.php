<div class="modal fade" id="addSourceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Source Entry</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('settings.source.add') }}" method="post">
                @csrf
                <div class="modal-body">
                    <!-- Left Element -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="specimen_type">Supplier</label>
                                <input type="text" class="form-control" name="supplier" id="supplier"
                                    value="{{ old('supplier') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="specimen_type">Item Code</label>
                                <input type="text" class="form-control" name="item_code" id="item_code"
                                    value="{{ old('item_code') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description" id="description" cols="5"
                                    rows="3">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="specimen_type">Unit Price</label>
                                <input type="text" class="form-control" name="unit_price" id="unit_price" onkeyup="getTotalPrice()"
                                    value="{{ old('unit_price') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="specimen_type">Currency Rate</label>
                                <input type="text" class="form-control" name="currency_rate" id="currency_rate" onkeyup="getTotalPrice()"
                                    value="{{ old('currency_rate') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="specimen_type">Total Price pHp</label>
                                <input type="text" class="form-control" name="tp_php" id="tp_php"
                                    value="{{ old('tp_php') }}" required>
                            </div>
                        </div>
                    </div>
                    <!-- End Left Element -->
                    <!-- Right Element -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="specimen_type">Item Group</label>
                                <input type="text" class="form-control" name="item_group" id="item_group"
                                    value="{{ old('item_group') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="specimen_type">UOM</label>
                                <input type="text" class="form-control" name="uom" id="uom"
                                    value="{{ old('uom') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="specimen_type">Mandatory Peripherals</label>
                                <input type="text" class="form-control" name="mandatory_peripherals" id="mandatory_peripherals"
                                    value="{{ old('mandatory_peripherals') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="specimen_type">Cost of Peripherals</label>
                                <input type="text" class="form-control" name="cost_periph" id="cost_periph"
                                    value="{{ old('cost_periph') }}" required>
                            </div>
                        </div>
                    </div>
                    <!-- End Right Element -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
