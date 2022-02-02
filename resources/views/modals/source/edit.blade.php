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
                        <div class="col-md-4">
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_item_name">Item Name</label>
                                <input type="hidden" class="form-control" name="source_id" id="edit_source_id">
                                <input type="text" class="form-control @error('supplier') is-invalid @enderror" 
                                    name="item_name" id="edit_item_name" value="{{ old('item_name') }}" required>

                                @error('item_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
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
                                <input type="text" class="form-control @error('unit_price') is-invalid @enderror" name="unit_price" id="edit_unit_price"
                                    value="{{ old('unit_price') }}" required>

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
                                <input type="text" class="form-control @error('currency_rate') is-invalid @enderror" name="currency_rate" id="edit_currency_rate"
                                    value="{{ old('currency_rate') }}" required>

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
                                <input type="text" class="form-control @error('tp_php') is-invalid @enderror" name="tp_php" id="edit_tp_php"
                                    value="{{ old('tp_php') }}" required readonly>

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
                        <div class="col-md-6">
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_uom">UOM</label>
                                <select class="form-control @error('uom') is-invalid @enderror" name="uom" id="edit_uom">
                                    <option value="" selected disabled>Select UOM</option>
                                    <option value="SET" {{ (old("uom") == "SET" ? "selected" : "")}}>SET</option>
                                    <option value="UN" {{ (old("uom") == "UN" ? "selected" : "")}}>UN</option>
                                    <option value="PK" {{ (old("uom") == "PK" ? "selected" : "")}}>PK</option>
                                    <option value="PACK" {{ (old("uom") == "PACK" ? "selected" : "")}}>PACK</option>
                                    <option value="PC" {{ (old("uom") == "PC" ? "selected" : "")}}>PC</option>
                                    <option value="KIT" {{ (old("uom") == "KIT" ? "selected" : "")}}>KIT</option>
                                    <option value="UNIT" {{ (old("uom") == "UNIT" ? "selected" : "")}}>UNIT</option>
                                </select>
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
                                    <option value="CHEM" {{ (old("segment") == "CHEM" ? "selected" : "")}}>CHEM</option>
                                    <option value="COAG" {{ (old("segment") == "COAG" ? "selected" : "")}}>COAG</option>
                                    <option value="HEMA" {{ (old("segment") == "HEMA" ? "selected" : "")}}>HEMA</option>
                                    <option value="HEMA & CHEM" {{ (old("segment") == "HEMA & CHEM" ? "selected" : "")}}>HEMA and CHEM</option>
                                    <option value="IMMUNO" {{ (old("segment") == "IMMUNO" ? "selected" : "")}}>IMMUNO</option>
                                    <option value="INDUSTRIAL MICRO" {{ (old("segment") == "INDUSTRIAL MICRO" ? "selected" : "")}}>INDUSTRIAL MICRO</option>
                                    <option value="MOLECULAR" {{ (old("segment") == "MOLECULAR" ? "selected" : "")}}>MOLECULAR</option>
                                    <option value="SPECIAL LINES" {{ (old("segment") == "SPECIAL LINES" ? "selected" : "")}}>SPECIAL LINES</option>
                                    <option value=NULL>NONE</option>
                                </select>

                                @error('sgement')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_item_category">Item Category</label>
                                <select class="form-control @error('item_category') is-invalid @enderror" name="item_category" id="edit_item_category">
                                    <option value="" selected disabled>Select Item Category</option>
                                    <option value="ACCESSORIES" {{ (old("item_category") == "ACCESSORIES" ? "selected" : "")}}>ACCESSORIES</option>
                                    <option value="CONSUMABLES" {{ (old("item_category") == "CONSUMABLES" ? "selected" : "")}}>CONSUMABLES</option>
                                    <option value="MACHINE" {{ (old("item_category") == "MACHINE" ? "selected" : "")}}>MACHINE</option>
                                    <option value="PIPETORS" {{ (old("item_category") == "PIPETORS" ? "selected" : "")}}>PIPETORS</option>
                                    <option value="SPAREPARTS" {{ (old("item_category") == "SPAREPARTS" ? "selected" : "")}}>SPAREPARTS</option>
                                    <option value="REAGENTS" {{ (old("item_category") == "REAGENTS" ? "selected" : "")}}>REAGENTS</option>
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
                                    value="{{ old('standard_price') }}" readonly>

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
