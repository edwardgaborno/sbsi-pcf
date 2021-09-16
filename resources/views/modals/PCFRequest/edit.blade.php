<div class="modal fade" id="editPCFRequestModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit PCF Request </h5>
                @hasanyrole('National Sales Manager|Accounting|Accounting manager')
                    <span class="badge badge-danger mt-2 ml-5">Only PSR have permission to update the details of this request</span>
                @endhasanyrole
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">PCF Request</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Item List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Machines & Inclusions</a>
                    </li>
                    @can('upload_pcf')
                    <li class="nav-item">
                        <a class="nav-link" id="upload-tab" data-toggle="tab" href="#upload" role="tab" aria-controls="upload" aria-selected="false">Upload PCF Document</a>
                    </li>
                    @endcan
                </ul>
                <div class="tab-content" id="myTabContent">
                    @can('upload_pcf')
                    <div class="tab-pane fade" id="upload" role="tabpanel" aria-labelledby="upload-tab">
                        <form action="{{ route('PCF.storeFile') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="upload_file"></label>
                                                <!--  For single file upload  -->
                                                <input type="file" name="upload_file" 
                                                    accept="application/pdf"
                                                    class="@error('upload_file') is-invalid @enderror" 
                                                    data-max-file-size="5MB" 
                                                    credits="false"/>
            
                                                @error('upload_file')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                                <input type="hidden" name="pcf_id" id="for_upload_id">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                        </form>
                    </div>
                    @endcan
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <form action="{{ route('PCF.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <!-- Left Element -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="specimen_type">PCF No.</label>
                                            <input type="hidden" name="pcf_request_id" id="pcf_request_id">
                                            <input type="text" class="form-control" name="pcf_no" id="edit_pcf_no"
                                                value="{{ old('pcf_no') }}" readonly required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="edit_date">Date</label>
                                            <input type="date" class="form-control" name="date" id="edit_date"
                                                value="{{ old('date') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="edit_institution">Institution</label>
                                            <input type="text" class="form-control" name="institution" id="edit_institution"
                                                value="{{ old('edit_institution') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="edit_address">Address</label>
                                            <textarea class="form-control" name="address" id="edit_address" cols="5"
                                                rows="3">{{ old('edit_address') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="edit_contact_person">Contact Person</label>
                                            <input type="text" class="form-control" name="contact_person" id="edit_contact_person"
                                                value="{{ old('edit_contact_person') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="edit_designation">Designation</label>
                                            <input type="text" class="form-control" name="designation" id="edit_designation"
                                                value="{{ old('edit_designation') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="edit_thru_designation">Thru Designation</label>
                                            <input type="text" class="form-control" name="thru_designation" id="edit_thru_designation"
                                                value="{{ old('edit_thru_designation') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="edit_supplier">Supplier/Manufacturer</label>
                                            <input type="text" class="form-control" name="supplier" id="edit_supplier"
                                                value="{{ old('edit_supplier') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="edit_terms">Terms</label>
                                            <input type="text" class="form-control" name="terms" id="edit_terms"
                                                value="{{ old('edit_terms') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="edit_validity">Validity</label>
                                            <input type="text" class="form-control" name="validity" id="edit_validity"
                                                value="{{ old('edit_validity') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="edit_delivery">Delivery</label>
                                            <input type="text" class="form-control" name="delivery" id="edit_delivery"
                                                value="{{ old('edit_delivery') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="edit_warranty">Warranty (For Machines Only)</label>
                                            <input type="text" class="form-control" name="warranty" id="edit_warranty"
                                                value="{{ old('edit_warranty') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="edit_contract_duration">Duration of Contract</label>
                                            <input type="text" class="form-control" name="contract_duration" id="edit_contract_duration" 
                                                value="{{ old('edit_contract_duration') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="edit_date_bidding">Date of Bidding</label>
                                            <input type="date" class="form-control" name="date_bidding" id="edit_date_bidding"
                                                value="{{ old('date_bidding') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="specimen_type">Bid Docs Price</label>
                                            <input type="text" class="form-control" name="bid_docs_price" id="edit_bid_docs_price"
                                                value="{{ old('bid_docs_price') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Left Element -->
                                <!-- Right Element -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="specimen_type">PSR</label>
                                            <input type="text" class="form-control" name="psr" id="edit_psr"
                                                value="{{ old('psr') }}" readonly required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="specimen_type">Manager</label>
                                            <input type="text" class="form-control" name="manager" id="edit_manager"
                                                value="{{ old('manager') }}" readonly required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="specimen_type">Annual Profit</label>
                                            <input type="text" class="form-control" name="annual_profit" id="edit_annual_profit"
                                                value="{{ old('profit') }}" readonly required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="specimen_type">Anual Profit Rate</label>
                                            <input type="text" class="form-control" name="annual_profit_rate" id="edit_annual_profit_rate"
                                                value="{{ old('profit_rate') }}" readonly required>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Right Element -->
                            </div>
                            <!-- Content Row -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                                @can('psr_request_edit')
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                                @endcan
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        @can('psr_request_create')
                            <form id="first_table">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="test_name_id">Test Code</label>
                                                <input type="hidden" class="form-control" name="pcf_no_add_items" id="pcf_no_add_item"> <!-- pcf no --> 
                                                <input type="hidden" class="form-control" name="hidden_item_code" id="hidden_item_code"> <!-- item code --> 
                                                <select class="form-control" name="item_code_add_item" id="item_code_add_item">
                                                    <option value="" selected>Please select Item Code</option>
                                                    @foreach ($sources as $source)
                                                        <option value="{{ $source->id }}">{{ $source->item_code }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="description_add_item">Item Description</label>
                                                <input type="text" class="form-control" name="description" id="description_add_item"
                                                    value="{{ old('description') }}" placeholder="source description" readonly required>
                                                <input type="hidden" class="form-control" name="rate_foc" id="rate_add_item"
                                                    value="{{ old('rate_foc') }}" placeholder="currency rate" required>
                                                <input type="hidden" class="form-control" name="tp_php_foc" id="tp_php_add_item"
                                                    value="{{ old('tp_php_foc') }}" placeholder="trasfer price" required>    
                                                <input type="hidden" class="form-control" name="cost_periph_foc" id="cost_periph_add_item"
                                                    value="{{ old('cost_periph_foc') }}" placeholder="cost peripherals" required>
                                                {{-- <input type="text" class="form-control" name="transfer_price_foc" id="transfer_price_add_item"
                                                    value="{{ old('transfer_price_foc') }}" placeholder="transfer price" required>
                                                <input type="text" class="form-control" name="mandatory_peripherals_foc" id="mandatory_peripherals_add_item"
                                                    value="{{ old('mandatory_peripherals_foc') }}" placeholder="mandatory peripherals" required> --}}
                                                <input type="hidden" class="form-control" name="opex_foc" id="opex_add_item"
                                                    value="{{ old('opex_foc') }}" placeholder="opex" required>
                                                <input type="hidden" class="form-control" name="net_sales_foc" id="net_sales_add_item"
                                                    value="{{ old('net_sales_foc') }}" placeholder="net sales" required>
                                                <input type="hidden" class="form-control" name="gross_profit_foc" id="gross_profit_add_item"
                                                    value="{{ old('gross_profit_foc') }}" placeholder="gross profit" required>
                                                <input type="hidden" class="form-control" name="total_gross_profit_foc" id="total_gross_profit_add_item"
                                                    value="{{ old('total_gross_profit_foc') }}" placeholder="total gross profit" required>
                                                <input type="hidden" class="form-control" name="total_net_sales_foc" id="total_net_sales_add_item"
                                                    value="{{ old('total_net_sales_foc') }}" placeholder="total net sales" required>
                                                <input type="hidden" class="form-control" name="profit_rate_foc" id="profit_rate_add_item"
                                                    value="{{ old('profit_rate_foc') }}" placeholder="profit rate" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="quantity_add_item">Quantity (Per Year)</label>
                                                <input type="number" class="form-control" name="quantity" id="quantity_add_item" onkeyup="getTotalSales()"
                                                    value="{{ old('quantity') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="sales_add_item">Sales</label>
                                                <input type="number" class="form-control" name="sales" id="sales_add_item" onkeyup="getTotalSales()"
                                                    value="{{ old('sales') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="total_sales_add_item">Total Sales</label>
                                                <input type="text" class="form-control" name="total_sales" id="total_sales_add_item"
                                                    value="{{ old('total_sales') }}" readonly required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="submit_item"></label>
                                                    <button type="submit" class="btn btn-primary form-control btn-submit" id="submit_item"><i class="fas fa-plus-circle"></i> Add
                                                        Item</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endcan
                        <div class="row">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="addItemDatatable" width="100%"
                                        cellspacing="0">
                                        <thead>
                                            <tr bgcolor="gray" class="text-white">
                                                <th>Item Code</th>
                                                <th>Item Description</th>
                                                <th>Quantity (Per Year)</th>
                                                <th>Sales</th>
                                                <th>Total Sales</th>
                                                <th>Action</th>
                                            </tr> 
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        @can('psr_request_create')
                            <form id="second_table">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="test_name_id">Item Code</label>
                                                <input type="hidden" class="form-control" name="pcf_no_add_items_foc" id="pcf_no_add_item_foc"> <!-- pcf no --> 
                                                <input type="hidden" class="form-control" name="hidden_item_code_foc" id="hidden_item_code_foc"> <!-- item code -->
                                                <select class="form-control" name="item_code_foc" id="item_code_foc">
                                                    <option value="" selected>Please select Item Code</option>
                                                    @foreach ($sources as $source)
                                                        <option value="{{ $source->id }}">{{ $source->item_code }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="item_description_foc">Item Description</label>
                                                <input type="text" class="form-control" name="item_description_foc" id="item_description_foc"
                                                    value="{{ old('item_description_foc') }}" readonly required>
                                                <input type="hidden" class="form-control" name="rate_foc" id="rate_foc"
                                                    value="{{ old('rate_foc') }}" required>
                                                <input type="hidden" class="form-control" name="tp_php_foc" id="tp_php_foc"
                                                    value="{{ old('tp_php_foc') }}" required>    
                                                <input type="hidden" class="form-control" name="cost_periph_foc" id="cost_periph_foc"
                                                    value="{{ old('cost_periph_foc') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="serial_no_foc">Serial No.</label>
                                                <input type="text" class="form-control" name="serial_no_foc" id="serial_no_foc"
                                                    value="{{ old('serial_no_foc') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="type_foc">Type</label>
                                                <select class="form-control" name="type_foc" id="type_foc">
                                                    <option value="MACHINE">MACHINE</option>
                                                    <option value="COGS" selected>COGS</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="qty_foc">Quantity</label>
                                                <input type="number" class="form-control" name="qty_foc" id="qty_foc" onkeyup="getComputationFOC()"
                                                    value="{{ old('qty_foc') }}" required>
                                                <input type="hidden" class="form-control" name="opx_foc" id="opx_foc"
                                                    value="{{ old('opx_foc') }}" required>
                                                <input type="hidden" class="form-control" name="total_cost_foc" id="total_cost_foc"
                                                    value="{{ old('total_cost_foc') }}" required>    
                                                <input type="hidden" class="form-control" name="cost_year_foc" id="cost_year_foc"
                                                    value="{{ old('cost_year_foc') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="submit_foc"></label>
                                                    <button type="submit" class="btn btn-primary form-control btn-submit" id="submit_foc"><i class="fas fa-plus-circle"></i> Add
                                                        Item</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endcan
                        <div class="row">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="addFOCdataTable" width="100%"
                                        cellspacing="0">
                                        <thead>
                                            <tr bgcolor="gray" class="text-white">
                                                <th>Item Code</th>
                                                <th>Item Description</th>
                                                <th>Serial No.</th>
                                                <th>Type</th>
                                                <th>Quantity</th>
                                                <th>Action</th>
                                            </tr> 
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
