<div class="modal fade" id="editSourceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_supplier">Supplier</label>
                                <input type="hidden" class="form-control" name="source_id" id="edit_source_id">
                                <input type="text" class="form-control @error('supplier') is-invalid @enderror" 
                                    name="supplier" id="edit_supplier" value="{{ old('supplier') }}" required>

                                @error('supplier')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_item_code">Item Code</label>
                                <input type="text" class="form-control @error('item_code') is-invalid @enderror" name="item_code" id="edit_item_code"
                                    value="{{ old('item_code') }}" required>

                                @error('item_code')
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
                                <label for="edit_description">Description</label>
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_unit_price">Unit Price</label>
                                <input type="number" class="form-control @error('unit_price') is-invalid @enderror" name="unit_price" id="edit_unit_price"
                                    step=".01" value="{{ old('unit_price') }}" required>

                                @error('unit_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_currency_rate">Currency Rate</label>
                                <input type="number" class="form-control @error('currency_rate') is-invalid @enderror" name="currency_rate" id="edit_currency_rate"
                                    step=".01" value="{{ old('currency_rate') }}" required>

                                @error('currency_rate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_tp_php">Total Price (Php)</label>
                                <input type="number" class="form-control @error('tp_php') is-invalid @enderror" name="tp_php" id="edit_tp_php"
                                    step=".01" value="{{ old('tp_php') }}" required readonly>

                                @error('tp_php')
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edit_item_group">Item Group</label>
                                <input type="text" class="form-control @error('item_group') is-invalid @enderror" name="item_group" id="edit_item_group"
                                    value="{{ old('item_group') }}">

                                @error('item_group')
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
                                <label for="edit_uom">UOM</label>
                                <input type="text" class="form-control @error('uom') is-invalid @enderror" name="uom" id="edit_uom"
                                    value="{{ old('uom') }}">

                                @error('uom')
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
                                <label for="edit_mandatory_peripherals">Mandatory Peripherals</label>
                                <input type="text" class="form-control @error('mandatory_peripherals') is-invalid @enderror" name="mandatory_peripherals" id="edit_mandatory_peripherals"
                                    value="{{ old('mandatory_peripherals') }}">

                                @error('mandatory_peripherals')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
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
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_segment">Segment</label>
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

                                @error('segment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_item_category">Item Category</label>
                                <select class="form-control @error('item_category') is-invalid @enderror" name="item_category" id="edit_item_category" required>
                                    <option value="" selected disabled>Select Item Category</option>
                                    <option value="ACCESSORIES">ACCESSORIES</option>
                                    <option value="CONSUMABLES">CONSUMABLES</option>
                                    <option value="MACHINE">MACHINE</option>
                                    <option value="PIPETORS">PIPETORS</option>
                                    <option value="SPAREPARTS">SPAREPARTS</option>
                                    <option value="REAGENTS">REAGENTS</option>
                                    <option value="OTHERS">OTHERS</option>
                                </select>

                                @error('item_category')
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
                                <label for="edit_standard_price">Standard Price</label>
                                <input type="text" class="form-control @error('standard_price') is-invalid @enderror" name="standard_price" id="edit_standard_price" required
                                    value="{{ old('standard_price') }}" >

                                @error('standard_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
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
