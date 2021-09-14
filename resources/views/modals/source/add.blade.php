<div class="modal fade" id="addSourceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Source Entry</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('settings.source.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <!-- Left Element -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="specimen_type">Supplier</label>
                                <input type="text" class="form-control @error('supplier') is-invalid @enderror" name="supplier" id="supplier"
                                    value="{{ old('supplier') }}" required>
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
                                <input type="text" class="form-control @error('item_code') is-invalid @enderror" name="item_code" id="item_code"
                                    value="{{ old('item_code') }}" required>
                            </div>
                            
                            @error('item_code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" cols="5"
                                    rows="3">{{ old('description') }}</textarea>
                            </div>
                            
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="specimen_type">Unit Price</label>
                                <input type="number" class="form-control @error('unit_price') is-invalid @enderror" name="unit_price" id="unit_price"
                                    step=".01" value="{{ old('unit_price') }}" required>
                            </div>

                            
                            @error('unit_price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="specimen_type">Currency Rate</label>
                                <input type="number" class="form-control @error('currency_rate') is-invalid @enderror" name="currency_rate" id="currency_rate"
                                    step=".01" value="{{ old('currency_rate') }}" required>
                            </div>
                            
                            @error('currency_rate')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="specimen_type">Total Price (Php)</label>
                                <input type="number" class="form-control @error('tp_php') is-invalid @enderror" name="tp_php" id="tp_php"
                                    step=".01" value="{{ old('tp_php') }}" required readonly>
                            </div>
                            
                            @error('tp_php')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <!-- End Left Element -->
                    <!-- Right Element -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="specimen_type">Item Group</label>
                                <input type="text" class="form-control @error('item_group') is-invalid @enderror" name="item_group" id="item_group"
                                    value="{{ old('item_group') }}" required>
                            </div>
                            
                            @error('item_group')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="specimen_type">UOM</label>
                                <input type="text" class="form-control @error('uom') is-invalid @enderror" name="uom" id="uom"
                                    value="{{ old('uom') }}" required>
                            </div>
                            
                            @error('uom')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="specimen_type">Mandatory Peripherals</label>
                                <input type="text" class="form-control @error('mandatory_peripherals') is-invalid @enderror" name="mandatory_peripherals" id="mandatory_peripherals"
                                    value="{{ old('mandatory_peripherals') }}" required>
                            </div>
                            
                            @error('mandatory_peripherals')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="specimen_type">Cost of Peripherals</label>
                                <input type="text" class="form-control @error('cost_of_peripherals') is-invalid @enderror" name="cost_of_peripherals" id="cost_of_peripherals"
                                    value="{{ old('cost_of_peripherals') }}" required>
                            </div>
                            
                            @error('cost_of_peripherals')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="segment">Segment</label>
                                <select class="form-control @error('segment') is-invalid @enderror" name="segment" id="segment">
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
                                <select class="form-control @error('item_category') is-invalid @enderror" name="item_category" id="item_category">
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
                                <input type="text" class="form-control @error('standard_price') is-invalid @enderror" name="standard_price" id="standard_price"
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
                                <input type="text" class="form-control @error('profitability') is-invalid @enderror" name="profitability" id="profitability"
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
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
