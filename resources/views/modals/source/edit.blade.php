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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="segment">Segment</label>
                                <select class="form-control @error('segment') is-invalid @enderror" name="segment" id="edit_segment">
                                    <option value="" selected disabled>Select Segment</option>
                                    <option value="CHEM">CHEM</option>
                                    <option value="COAG">COAG</option>
                                    <option value="HEMA">HEMA</option>
                                    <option value="HEMA & CHEM">HEMA and CHEM</option>
                                    <option value="IMMUNO">IMMUNO</option>
                                    <option value="INDUSTRIAL MICRO">INDUSTRIAL MICRO</option>
                                    <option value="MOLECULAR">MOLECULAR</option>
                                    <option value="SPECIAL LINES">SPECIAL LINES</option>
                                    <option value=NULL>NONE</option>
                                </select>
                            </div>

                            @error('sgement')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="item_category">Item Category</label>
                                <select class="form-control @error('item_category') is-invalid @enderror" name="item_category" id="edit_item_category">
                                    <option value="" selected disabled>Select Item Category</option>
                                    <option value="ACCESSORIES">ACCESSORIES</option>
                                    <option value="CONSUMABLES">CONSUMABLES</option>
                                    <option value="MACHINE">MACHINE</option>
                                    <option value="PIPETORS">PIPETORS</option>
                                    <option value="SPAREPARTS">SPAREPARTS</option>
                                    <option value="REAGENTS">REAGENTS</option>
                                    <option value="OTHERS">OTHERS</option>
                                </select>
                            </div>
                            
                            @error('item_category')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="standard_price">Standard Price</label>
                                <input type="text" class="form-control @error('standard_price') is-invalid @enderror" name="standard_price" id="edit_standard_price"
                                    value="{{ old('standard_price') }}" required>
                            </div>
                            
                            @error('standard_price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="profitability">Profitability</label>
                                <input type="text" class="form-control @error('profitability') is-invalid @enderror" name="profitability" id="edit_profitability"
                                    value="{{ old('profitability') }}" required readonly>
                            </div>
                            
                            @error('profitability')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
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
