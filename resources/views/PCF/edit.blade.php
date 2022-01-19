@extends('layouts.app')
@section('title','PCF - PCF Request')

@push('styles')
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<div id="wrapper">

    <!-- Sidebar -->
    @include('layouts.sidebar')
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            @include('layouts.navbar')
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- DataTales Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                @can('pcf_request_edit')
                                    <h5 class="modal-title">Edit PCF Request </h5>
                                @endcan
                                @can('psr_upload_pcf')
                                    <h5 class="modal-title">Upload Approved PCF Request </h5>
                                @endcan
                                </div>

                                <div class="card-body">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    @can('pcf_request_edit')
                                        <li class="nav-item">
                                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">PCF Request</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Item List</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Machines & Inclusions</a>
                                        </li>
                                    @endcan
                                    @can('psr_upload_pcf')
                                        <li class="nav-item">
                                            <a class="nav-link" id="upload-tab" data-toggle="tab" href="#upload" role="tab" aria-controls="upload" aria-selected="true">Upload PCF Document</a>
                                        </li>
                                    @endcan
                                    </ul>

                                    <div class="tab-content" id="myTabContent">
                                        @can('psr_upload_pcf')
                                        <div class="tab-pane show active fade" id="upload" role="tabpanel" aria-labelledby="upload-tab">
                                            <form action="{{ route('PCF.putFile', $p_c_f_request->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="upload_file"></label>
                                                                    <!--  For single file upload  -->
                                                                    <input type="file" name="pcf_rfq" 
                                                                        accept="application/pdf"
                                                                        class="@error('upload_file') is-invalid @enderror" 
                                                                        data-max-file-size="5MB" 
                                                                        credits="false"/>
                                
                                                                    @error('upload_file')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="{{ route('PCF.index') }}" class="btn btn-link">
                                                        <i class="fas fa-times"></i> Cancel</a>
                                                    <button type="submit" class="btn btn-primary">Upload</button>
                                                </div>
                                            </form>
                                        </div>
                                        @endcan
                                        @can('pcf_request_edit')
                                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                            <form action="{{ route('PCF.update', $p_c_f_request->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <!-- Left Element -->
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="specimen_type">PCF No.</label>
                                                                <input type="text" class="form-control" name="pcf_no" id="edit_pcf_no"
                                                                    value="{{ old('pcf_no', $p_c_f_request->pcf_no) }}" readonly required>

                                                                @error('pcf_no')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="pcf_no">RFQ No.</label>
                                                            <input type="text" class="form-control @error('rfq_no') is-invalid @enderror" name="rfq_no" id="edit_rfq_no"
                                                                value="{{ old('rfq_no', $p_c_f_request->rfq_no) }}" required readonly>
                
                                                            @error('rfq_no')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="institution">Institution</label>
                                                            <select name="institution_id" id="edit_institution" class="form-control @error('institution') is-invalid @enderror select2" required>
                                                                <option value="{{ old('institution_id', $p_c_f_request->institution_id) }}" selected>{{ $p_c_f_request->institution->institution }}</option>
                                                            </select>
                                    
                                                            @error('institution')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror 
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="address">Address</label>
                                                            <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="edit_address" cols="5"
                                                                rows="3" disabled>{{ old('address', $p_c_f_request->institution->address) }}</textarea>
                
                                                            @error('address')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                                <label for="contact_person">Contact Person</label>
                                                                <input type="text" class="form-control @error('contact_person') is-invalid @enderror" name="contact_person" id="edit_contact_person"
                                                                    value="{{ old('contact_person', $p_c_f_request->institution->contact_person) }}" required disabled>
                
                                                                @error('contact_person')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="designation">Designation</label>
                                                            <input type="text" class="form-control @error('designation') is-invalid @enderror" name="designation" id="edit_designation"
                                                                value="{{ old('designation', $p_c_f_request->institution->designation) }}" disabled>
                
                                                            @error('designation')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="thru_duration_contract">Thru Designation</label>
                                                            <input type="text" class="form-control @error('thru_designation') is-invalid @enderror" name="thru_designation" id="edit_thru_duration_contract"
                                                                value="{{ old('thru_designation', $p_c_f_request->institution->thru_designation) }}" disabled>
                
                                                            @error('thru designation')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="edit_supplier">Supplier/Manufacturer</label>
                                                                <input type="text" class="form-control" name="supplier" id="edit_supplier"
                                                                    value="{{ old('supplier', $p_c_f_request->supplier) }}" required>

                                                                @error('supplier')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="edit_terms">Terms</label>
                                                                <input type="text" class="form-control" name="terms" id="edit_terms"
                                                                    value="{{ old('terms', $p_c_f_request->terms) }}" required>

                                                                @error('terms')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="edit_validity">Validity</label>
                                                                <input type="text" class="form-control" name="validity" id="edit_validity"
                                                                    value="{{ old('validity', $p_c_f_request->validity) }}" required>

                                                                @error('validity')
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
                                                                <label for="edit_delivery">Delivery</label>
                                                                <input type="text" class="form-control" name="delivery" id="edit_delivery"
                                                                    value="{{ old('delivery', $p_c_f_request->delivery) }}" required>

                                                                @error('delivery')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="edit_warranty">Warranty (For Machines Only)</label>
                                                                <input type="text" class="form-control" name="warranty" id="edit_warranty"
                                                                    value="{{ old('warranty', $p_c_f_request->warranty) }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="edit_contract_duration">Duration of Contract</label>
                                                                <input type="number" class="form-control" name="contract_duration" id="edit_contract_duration" 
                                                                    value="{{ old('contract_duration', $p_c_f_request->contract_duration) }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="edit_date_bidding">Date of Bidding</label>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">
                                                                        <input type="checkbox" id="edit_date_bidding_checkbox" aria-label="Checkbox for following date input" {{ (old('date_bidding', $p_c_f_request->date_bidding) == null ? "checked" : '') }}>
                                                                        <label class="form-check-label" for="dateBiddingCheckBox">
                                                                            N/A
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <input type="{{ (old('date_bidding', $p_c_f_request->date_bidding) == null ? "text" : 'date') }}" class="form-control" name="date_bidding" id="edit_date_bidding"
                                                                    value="{{ old('date_bidding', $p_c_f_request->date_bidding) }}" {{ (old('date_bidding', $p_c_f_request->date_bidding) == null ? "readonly" : '')}}>
                                                                
                                                                @error('date_bidding')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="specimen_type">Bid Docs Price</label>
                                                                <input type="number" class="form-control" name="bid_docs_price" id="edit_bid_docs_price"
                                                                    value="{{ old('bid_docs_price', $p_c_f_request->bid_docs_price) }}" {{ (old('bid_docs_price', $p_c_f_request->bid_docs_price) == null ? "readonly" : '') }}>
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
                                                                    value="{{ old('psr', $p_c_f_request->psr) }}" readonly required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="manager">Manager</label>
                                                            <select class="form-control @error('manager') is-invalid @enderror" name="manager" id="edit_manager" required>
                                                                <option value="" {{ (old('manager', $p_c_f_request->manager) == null ? "selected disabled": "")}}>Select Manager</option>
                                                                <option value="Rachelle Anne Carrera" {{ (old('manager', $p_c_f_request->manager) == "Rachelle Anne Carrera" ? "selected" : "")}}>Rachelle Anne Carrera</option>
                                                                <option value="Gloria Cutang" {{ (old('manager', $p_c_f_request->manager) == "Gloria Cutang" ? "selected" : "")}}>Gloria Cutang</option>
                                                                <option value="Gilbert Gravata" {{ (old('manager', $p_c_f_request->manager) == "Gilbert Gravata" ? "selected" : "")}}>Gilbert Gravata</option>
                                                            </select>
                
                                                            @error('manager')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="specimen_type">Annual Profit</label>
                                                                <input type="text" class="form-control" name="annual_profit" id="edit_annual_profit"
                                                                    value="{{ old('annual_profit', $p_c_f_request->annual_profit) }}" readonly required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="specimen_type">Anual Profit Rate</label>
                                                                <input type="text" class="form-control" name="annual_profit_rate" id="edit_annual_profit_rate"
                                                                    value="{{ old('annual_profit_rate', $p_c_f_request->annual_profit_rate) }}" readonly required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Right Element -->
                                                </div>
                                                <!-- Content Row -->
                                                <div class="modal-footer">
                                                    <a href="{{ route('PCF.index') }}" class="btn btn-link">
                                                        <i class="fas fa-times"></i> Cancel</a>
                                                    @can('pcf_request_edit')
                                                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                                                    @endcan
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                            <div class="card-body">
                                                <form id="edit_pcfListForm">
                                                    @csrf
                                                    <div class="form-row">
                                                        <div class="form-group col-md-2">                   
                                                            <label for="source_item_code-i">Item Code</label>
                                                            <input type="hidden" class="form-control" name="pcf_no" id="pcf_no" value="{{ $p_c_f_request->pcf_no }}"> <!-- pcf no -->                        
                                                            <select name="source_id" id="source_item_code-i" class="form-control select2">
                                                                <option value="" selected disabled></option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="description">Item Description</label>
                                                            <input type="text" class="form-control" name="description" id="description-i"
                                                                placeholder="Description" readonly required>

                                                            <input type="hidden" name="pcf_request_id" id="pcf_request_id-i" class="form-control" value="{{ $p_c_f_request->id }}">
                                                            <input type="hidden" name="pcf_no" id="edit_pcf_no-i" class="form-control" value="{{ $p_c_f_request->pcf_no }}">
                                                            <input type="hidden" name="rfq_no" id="edit_rfq_no-i" class="form-control" value="{{ $p_c_f_request->rfq_no }}">
                                                            <input type="hidden" class="form-control" name="currency_rate" id="currency_rate-i">
                                                            <input type="hidden" class="form-control" name="tp_php" id="tp_php-i">    
                                                            <input type="hidden" class="form-control" name="cost_of_peripherals" id="cost_of_peripherals-i">
                                                            <input type="hidden" class="form-control" name="opex" id="opex-i">
                                                            <input type="hidden" class="form-control" name="net_sales" id="net_sales-i">
                                                            <input type="hidden" class="form-control" name="gross_profit" id="gross_profit-i">
                                                            <input type="hidden" class="form-control" name="total_gross_profit" id="total_gross_profit-i">
                                                            <input type="hidden" class="form-control" name="total_net_sales" id="total_net_sales-i">
                                                            <input type="hidden" class="form-control" name="profit_rate" id="profit_rate-i">
                                                        </div>
                                                        <div class="form-group col-md-2">
                                                            <label for="quantity_add_item">Quantity (Per Year)</label>
                                                            <input type="number" class="form-control" name="quantity" id="quantity-i" min="1"
                                                                value="{{ old('quantity') }}" required disabled>
                                                        </div>
                                                        <div class="form-group col-md-2">
                                                            <label for="sales_add_item">Sales</label>
                                                            <input type="number" class="form-control" name="sales" id="sales-i"
                                                                value="{{ old('sales') }}" required disabled>
                                                        </div>
                                                        <div class="form-group col-md-2">
                                                            <label for="total_sales_add_item">Total Sales</label>
                                                            <input type="text" class="form-control" name="total_sales" id="total_sales-i"
                                                                value="{{ old('total_sales') }}" readonly required>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary form-control btn-submit mt-2 mb-3" id="submit_item">
                                                        <i class="fas fa-plus-circle"></i> Add Item</button>
                                                </form>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-hover dt-responsive" id="edit_pcfItem_dataTable" width="100%"
                                                            cellspacing="0">
                                                            <thead>
                                                                <tr>
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
                                            <div class="card-body">
                                                <form id="edit_pcfFOCForm">
                                                    @csrf
                                                    <div class="form-row">
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="source_item_code-foc">Item Code</label>
                                                                <select name="source_id" id="source_item_code-foc" class="form-control select2">
                                                                    <option value="" selected disabled></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="item_description_foc">Item Description</label>
                                                                <input type="text" class="form-control" name="description" id="description-foc"
                                                                    value="{{ old('item_description_foc') }}" readonly required>
                                                                
                                                                <input type="hidden" class="form-control" name="p_c_f_request_id" id="pcf_request_id-foc" value="{{ $p_c_f_request->id }}" placeholder="PCF Request Id">
                                                                <input type="hidden" class="form-control" name="pcf_no" id="edit_pcf_no-foc" value="{{ $p_c_f_request->pcf_no }}" placeholder="PCF No.">
                                                                <input type="hidden" class="form-control" name="rfq_no" id="edit_rfq_no-foc" value="{{ $p_c_f_request->rfq_no }}" placeholder="PCF No.">
                                                                <input type="hidden" class="form-control" name="tp_php" id="tp_php-foc" placeholder="Total price (tp_php)">    
                                                                <input type="hidden" class="form-control" name="cost_of_peripherals" id="cost_of_peripherals-foc" placeholder="Cost of peripherals">
                                                                <input type="hidden" class="form-control" name="opex" id="opex-foc" placeholder="Opex">
                                                                <input type="hidden" class="form-control" name="total_cost" id="total_cost-foc" placeholder="Total Cost">    
                                                                <input type="hidden" class="form-control" name="cost_year" id="cost_year-foc" placeholder="Cost year">
                                                                <input type="hidden" class="form-control" name="depreciable_life" id="depreciable_life-foc" placeholder="Depreciable life">

                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="serial_no_foc">Serial No.</label>
                                                                <input type="text" class="form-control" name="serial_no" id="serial_no-foc"
                                                                    value="N / A {{ old('serial_no-foc') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="type_foc">Type</label>
                                                                <select class="form-control" name="type" id="type-foc">
                                                                    <option value="" selected disabled>Select type</option>
                                                                    <option value="MACHINE">MACHINE</option>
                                                                    <option value="COGS">COGS</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="quantity-foc">Quantity</label>
                                                                <input type="number" class="form-control" name="quantity" id="quantity-foc" min="1"
                                                                    value="{{ old('quantity-foc') }}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary form-control btn-submit mt-2 mb-3" id="submit">
                                                        <i class="fas fa-plus-circle"></i> Add Item</button>
                                                </form>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-hover dt-responsive" id="edit_pcfFOC_dataTable" width="100%"
                                                            cellspacing="0">
                                                            <thead>
                                                                <tr>
                                                                    <th>Item Code</th>
                                                                    <th>Item Description</th>
                                                                    <th>Serial No.</th>
                                                                    <th>Type</th>
                                                                    <th>Quantity</th>
                                                                    <th>Actions</th>
                                                                </tr> 
                                                            </thead>
                                                            <tbody>
                                                                
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Content Row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
        <!-- Modal Component -->
        @include('PCF.sub.partials.items_bundle_options')
        @include('PCF.sub.partials.machines_bundle_options')
        <!-- End of Modal Component -->
        <!-- Footer -->
        @include('layouts.footer')
        <!-- End of Footer -->
    </div>
    <!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->
@endsection

@section('scripts')
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            showCloseButton: true,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        $('#edit_pcfItem_dataTable').DataTable({
            "stripeClasses": [],
            destroy: true,
            processing: false,
            serverSide: true,
            responsive: true,
            searchable: true,
            ordering: true,
            ajax: {
                url : "{{ route('PCF.items_list', $p_c_f_request->id) }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            columns: [
                { data: 'source.item_code' },
                { data: 'source.description' },
                { data: 'quantity' },
                { data: 'sales' },
                { data: 'total_sales' },
                { data: 'actions' },
            ],
        });

        var data = [];

        function getSources () {
            $.ajax({
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/settings.source/ajax/get-source-list',
                    contentType: "application/json; charset=utf-8",
                    cache: false,
                    dataType: 'json',
                }).done(function(res) {
                    data = res.data;

                    $("#source_item_code-i").select2({
                        data: data,
                        width: "100%",
                        allowClear: true,
                        placeholder: 'Item code',
                    });

                    $("#source_item_code-foc").select2({
                        data: data,
                        width: "100%",
                        allowClear: true,
                        placeholder: 'Item code',
                    });

                }).fail(function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                });
        }

        getSources();

        $('#source_item_code-i').on('select2:select', function (e) {
            var data = e.params.data;
            var source_id = data.id
            if(source_id) {
                $.ajax({
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/settings.source/get-description/source=' + source_id,
                    contentType: "application/json; charset=utf-8",
                    cache: false,
                    dataType: 'json',
                }).done(function(data) {
                    $('#description-i').val(data.description);
                    $("#currency_rate-i").val(data.currency_rate);
                    $("#tp_php-i").val(data.tp_php);
                    $("#cost_of_peripherals-i").val(data.cost_of_peripherals);

                    document.getElementById("quantity-i").disabled = false;
                    document.getElementById("sales-i").disabled = false;

                    calculateOpex();
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Oops! Something went wrong.',
                        text: 'Please contact your system administrator.'
                    })
                    clearItemInputs();
                });
            }
        });

        function getInstitutions() {
        $.ajax({
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/settings.institution/ajax/get-institutions-dropdown',
                contentType: "application/json; charset=utf-8",
                cache: false,
                dataType: 'json',
            }).done(function(res) {
                data = res.data;
                $("#edit_institution").select2({
                    data: data,
                    width: "100%",
                    allowClear: true,
                    placeholder: 'Institution',
                });

            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            });
        }

        getInstitutions();

        $('#edit_institution').on('select2:select', function (e) {
            var data = e.params.data;
            document.getElementById("edit_address").value = data.address;
            document.getElementById("edit_contact_person").value = data.contact_person;    
            document.getElementById("edit_designation").value = data.designation;    
            document.getElementById("edit_thru_duration_contract").value = data.thru_designation;
        });

        var now = new Date(),
        minDate = now.toISOString().substring(0,10);

        $('#edit_date_bidding').prop('min', minDate);

        $('#edit_date_bidding_checkbox').change(function() {
            if($(this).is(":checked")) {
                document.getElementById('edit_date_bidding').type = 'text';
                document.getElementById("edit_date_bidding").readOnly = true;
                document.getElementById("edit_bid_docs_price").readOnly = true;
            }
            else {
                document.getElementById('edit_date_bidding').type = 'date';
                document.getElementById("edit_date_bidding").readOnly = false;

                document.getElementById("edit_bid_docs_price").readOnly = false;
            }
        })  

        $("#source_item_code-i").on('change', function(e) {
            document.getElementById("quantity-i").disabled = true;
            document.getElementById("sales-i").disabled = true;

            clearItemInputs();
        });
        //end of select2 function

        //on pcfList form submit; ajax
        $('#edit_pcfListForm').on('submit',function (e) {
            e.preventDefault();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('PCF.sub.check_if_item_exist') }}",
                method:'GET',
                data: {
                    pcf_no: document.getElementById("edit_pcf_no-i").value,
                    rfq_no: document.getElementById("edit_rfq_no-i").value,
                    source_id: document.getElementById("source_item_code-i").value,
                },
                success: function(response) {
                    console.log(response);
                    if (response.is_exist == true) {
                        Swal.fire({
                            title: 'Item already exist',
                            text: "Do you want to proceed?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Confirm'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                saveItemList();
                                clearItemInputs();
                            }
                        })
                    } else {
                        saveItemList();
                        clearItemInputs();
                    }
                },
                error: function (response) {
                    console.log(response);
                    clearItemInputs();
                    Toast.fire({
                        icon: 'error',
                        title: 'Oops! Something went wrong.',
                        text: 'Please contact your system administrator.'
                    })
                },
            });
        }); 

        function saveItemList() {
            let pcf_no = $("#edit_pcf_no-i").val();
            let rfq_no = $("#edit_rfq_no-i").val();
            let p_c_f_request_id = $("#pcf_request_id-i").val();
            let source_id = $("#source_item_code-i").val();
            let description = $("#description-i").val();
            let quantity = $("#quantity-i").val();
            let sales = $("#sales-i").val();
            let total_sales = $("#total_sales-i").val();
            let opex = $("#opex-i").val();
            let net_sales = $("#net_sales-i").val();
            let gross_profit = $("#gross_profit-i").val();
            let total_gross_profit = $("#total_gross_profit-i").val();
            let total_net_sales = $("#total_net_sales-i").val();
            let profit_rate = $("#profit_rate-i").val();
            $.ajax({
                url: "{{ route('PCF.sub.store_items') }}",
                method:'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    pcf_no:pcf_no,
                    rfq_no:rfq_no,
                    p_c_f_request_id:p_c_f_request_id,
                    source_id:source_id,
                    description:description,
                    quantity:quantity,
                    sales:sales,
                    total_sales:total_sales,
                    opex:opex,
                    net_sales:net_sales,
                    gross_profit:gross_profit,
                    total_gross_profit:total_gross_profit,
                    total_net_sales:total_net_sales,
                    profit_rate:profit_rate
                },
                success: function(response) {
                    $("#source_item_code-i").val('').trigger('change')
                    clearItemInputs();
                    $('#edit_pcfItem_dataTable').DataTable().ajax.reload();
                    getGrandTotal(pcf_no);
                    Toast.fire({
                        icon: 'success',
                        title: 'Added',
                        text: 'The product has been added to the current request.'
                    })
                },
                error: function (response) {
                    clearItemInputs();
                    $("#source_item_code-i").val('').trigger('change')
                    Toast.fire({
                        icon: 'error',
                        title: 'Oops! Something went wrong.',
                        text: 'Please contact your system administrator.'
                    })
                },
            });
        }

        $('#edit_pcfItem_dataTable').on('click', '.pcfListCreateBundle', function (e) {
            e.preventDefault();
            $('#bundleItemsModal').modal('show');

            document.getElementById("pcfList_id").value = $(this).data('id');

            $('#pcfItemBundle_datatable').DataTable().clear().destroy();
            getBundleItem($(this).data('id'));
        })
        $('#pcfListBundleForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('PCF.sub.store_bundle_options') }}",
                method:'POST',
                data: {
                    p_c_f_list_id: document.getElementById("pcfList_id").value,
                    source_id: document.getElementById("item_code_bundle").value,
                    quantity: document.getElementById("quantity_bundle").value,
                },
                success: function(response) {
                    $("#item_code_bundle").val('').trigger('change')
                    document.getElementById("description_bundle").value = "";
                    document.getElementById("quantity_bundle").value = "";

                    $('#pcfItemBundle_datatable').DataTable().ajax.reload();

                    Toast.fire({
                        icon: 'success',
                        title: 'Added',
                        text: 'Item has been added as a bundle'
                    })
                },
                error: function (response) {
                    $("#item_code_bundle").val('').trigger('change')
                    document.getElementById("description_bundle").value = "";
                    document.getElementById("quantity_bundle").value = "";

                    $('#pcfItemBundle_datatable').DataTable().ajax.reload();

                    Toast.fire({
                        icon: 'error',
                        title: 'Oops! Something went wrong.',
                        text: 'Please contact your system administrator.'
                    })
                },
            });
        });

        $("#item_code_bundle").select2({
            dropdownParent: $('#bundleItemsModal'),
            width: "100%",
            allowClear: true,
            minimumInputLength: 3,
            placeholder: 'Item code',
            ajax: {
                url: '{{ route("settings.source.source_search") }}',
                dataType: 'json',
            },
        });

        $('#item_code_bundle').on('select2:select', function (e) {
            var data = e.params.data;
            var source_id = data.id
            if(source_id) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: "application/json; charset=utf-8",
                    dataType: 'json',
                    cache: false,
                    method: 'GET',
                    url: '/settings.source/get-description/source=' + source_id,
                }).done(function(data) {
                    document.getElementById("description_bundle").value = data.description;
                    document.getElementById("quantity_bundle").disabled = false;
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Oops! Something went wrong.',
                        text: 'Please contact your system administrator.'
                    });
                });
            }
        });

        $("#item_code_bundle").on('change', function(e) {
            document.getElementById("description_bundle").value = "";
            document.getElementById("quantity_bundle").value = "";
            document.getElementById("quantity_bundle").disabled = true;
        });

        $('#pcfItemBundle_datatable').on('click', '.pcfListBundleDelete', function (e) {
            e.preventDefault();
            bundleItemId = $(this).data('id');
            Swal.fire({
                title: 'Remove item?',
                text: "This item will be removed as a bundled product",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirm'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'DELETE',
                        url: '/PCF.sub/ajax/delete/bundled-item/' + bundleItemId,
                    }).done(function(response) {
                        $('#pcfItemBundle_datatable').DataTable().ajax.reload();
                        Toast.fire({
                            icon: 'success',
                            title: 'Removed',
                            text: 'The product has been removed from the current item listing.'
                        })
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        Toast.fire({
                            icon: 'error',
                            title: 'Oops! Something went wrong.',
                            text: 'Please contact your system administrator.'
                        })
                    });
                }
            })
        });

        //scripts for getting bundleItem, starts here;
        function getBundleItem(bundleItemId) {
            $('#pcfItemBundle_datatable').DataTable({
                "stripeClasses": [],
                processing: false,
                serverSide: true,
                responsive: true,
                searchable: true,
                ordering: true,
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url : "/PCF.sub/ajax/bundled/item-list/" + bundleItemId,
                },
                columns: [
                    { data: 'source.item_code' },
                    { data: 'source.description' },
                    { data: 'quantity' },
                    { data: 'actions' },
                ],
            });
        };
        
        //delete pcfList Items
        $('#edit_pcfItem_dataTable').on('click', '.pcfListDelete', function (e) {
            e.preventDefault();
            let item_id = $(this).data('id');
            let pcf_no = $("#edit_pcf_no-i").val();
            Swal.fire({
                title: 'Delete Item',
                text: "This process will remove the item and all the item associated. Ex: bundled product(s)",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirm'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '/PCF.sub/ajax/delete/pcf-list/' + item_id,
                        contentType: "application/json; charset=utf-8",
                        cache: false,
                        dataType: 'json',
                    }).done(function(data) {
                        $('#edit_pcfItem_dataTable').DataTable().ajax.reload(null, false);
                        getGrandTotal(pcf_no);
                        Toast.fire({
                            icon: 'success',
                            title: 'Removed',
                            text: 'The product has been removed from the current item listing.'
                        })
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        Toast.fire({
                            icon: 'error',
                            title: 'Oops! Something went wrong.',
                            text: 'Please contact your system administrator.'
                        })
                    });
                }
            })
        });

        const element = document.querySelectorAll('#sales-i, #quantity-i');
        element.forEach(i => {
            i.addEventListener('input', function() {
                calculateTotalSales();
                calculateNetSales();
                calculateGrossProfit();
                calculateTotalGrossProfit();
                calculateTotalNetSales();
                calculateProfitRate();
            });
        })

        //Total Sales Function
        function calculateTotalSales() {
            var quantity = $("#quantity-i").val();
            var sales = $("#sales-i").val();
            var total_sales = sales * quantity;
            $("#total_sales-i").val(total_sales.toFixed(2));
        }

        //Opex function
        function calculateOpex() {
            var currency_rate = $("#currency_rate-i").val();
            var transfer_price = $("#tp_php-i").val();
            var cost_of_peripherals = $("#cost_of_peripherals-i").val();
            
            if (parseInt(currency_rate) == 1 && cost_of_peripherals !== '') {
                var opex = transfer_price * 1.15 + parseFloat(cost_of_peripherals);
            } 
            else if (parseInt(currency_rate) == 1 && cost_of_peripherals == '') {
                var opex = transfer_price * 1.13 + 0;
            }
            else if (parseInt(currency_rate) !== 1 && cost_of_peripherals !== '') {
                var opex = transfer_price * 1.15 + parseFloat(cost_of_peripherals);
            } 
            else {
                var opex = transfer_price * 1.3 + 0;
            }

            $("#opex-i").val(opex.toFixed(2));
        }

        //Net Sales function
        function calculateNetSales() {
            var sales = $("#sales-i").val();
            var net_sales = sales / 1.12;

            $("#net_sales-i").val(net_sales.toFixed(2));
        }

        //Gross Profit Function
        function calculateGrossProfit() {
            var net_sales = $("#net_sales-i").val();
            var opex = $("#opex-i").val();
            // var cost_of_peripherals = $("#cost_of_peripherals-i").val();

            var gross_profit = net_sales - opex;

            $("#gross_profit-i").val(gross_profit.toFixed(2));
        }

        //Total Gross Profit Function
        function calculateTotalGrossProfit() {
            var gross_profit = $("#gross_profit-i").val();
            var quantity = $("#quantity-i").val();
            
            var total_gross_profit = gross_profit * quantity;

            $("#total_gross_profit-i").val(total_gross_profit.toFixed(2));
        }

        //Total Net Sales Function
        function calculateTotalNetSales() {
            var total_sales = $("#total_sales-i").val();

            var total_net_sales = total_sales / 1.12;

            $("#total_net_sales-i").val(total_net_sales.toFixed(2));
        }

        //Profit Rate Function
        function calculateProfitRate() {
            var gross_profit = $("#gross_profit-i").val();
            var sales = $("#sales-i").val();

            var profit_rate = (gross_profit / sales) * 100;

            $("#profit_rate-i").val(profit_rate.toFixed(0));
        }

        function clearItemInputs() {
            $("#description-i").val("");
            $("#currency_rate-i").val("");
            $("#rate-i").val("");
            $("#tp_php-i").val("");
            $("#cost_periph-i").val("");
            $("#quantity-i").val("");
            $("#sales-i").val("");
            $("#total_sales-i").val("");
            $("#opex-i").val("");
            $("#net_sales-i").val("");
            $("#gross_profit-i").val("");
            $("#total_gross_profit-i").val("");
            $("#total_net_sales-i").val("");
            $("#profit_rate-i").val("");
        }

        //Machine & Inclusions DataTable
        $('#edit_pcfFOC_dataTable').DataTable({
            "stripeClasses": [],
            destroy: true,
            processing: false,
            serverSide: true,
            responsive: true,
            searchable: true,
            ordering: true,
            ajax: {
                url : "{{ route('PCF.inclusions_list', $p_c_f_request->id) }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            columns: [
                { data: 'source.item_code' },
                { data: 'source.description' },
                { data: 'serial_no' },
                { data: 'type' },
                { data: 'quantity' },
                { data: 'actions', orderable: false, searchable: false },
            ],
        });

        //start of select2 function -- machine item code;
        $(function () {
            $('#source_item_code-foc').select2({
                width: "100%",
                allowClear: true,
                minimumInputLength: 3,
                placeholder: 'Item code',
                ajax: {
                    url: '{{ route("settings.source.source_search") }}',
                    dataType: 'json',
                },
            });
        });

        $('#source_item_code-foc').on('select2:select', function (e) {
            var data = e.params.data;
            var source_id = data.id
            if(source_id) {
                $.ajax({
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/settings.source/get-description/source=' + source_id,
                contentType: "application/json; charset=utf-8",
                cache: false,
                dataType: 'json',
                }).done(function(data) {
                    $('#description-foc').val(data.description);
                    $("#tp_php-foc").val(data.tp_php);
                    $("#cost_of_peripherals-foc").val(data.cost_of_peripherals);

                    calculateOpexFOC();
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Oops! Something went wrong.',
                        text: 'Please contact your system administrator.'
                    })
                    clearFOCInputs();
                });
            }
        });

        $( "#source_item_code-foc" ).on('change', function(e) {
            clearFOCInputs();
        });
        //end of select2 function;

        //foc on form submit; ajax function
        $('#edit_pcfFOCForm').on('submit',function(e){
            e.preventDefault();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('PCF.sub.check_if_inclusion_exist') }}",
                method:'GET',
                data: {
                    pcf_no: document.getElementById("edit_pcf_no-foc").value,
                    rfq_no: document.getElementById("edit_rfq_no-foc").value,
                    source_id: document.getElementById("source_item_code-foc").value,
                },
                success: function(response) {
                    console.log(response);
                    if (response.is_exist == true) {
                        Swal.fire({
                            title: 'Inclusion already exist',
                            text: "Do you want to proceed?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Confirm'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                saveInclusionList();
                                clearItemInputs();
                            }
                        })
                    } else {
                        saveInclusionList();
                        clearItemInputs();
                    }
                },
                error: function (response) {
                    console.log(response);
                    clearItemInputs();
                    Toast.fire({
                        icon: 'error',
                        title: 'Oops! Something went wrong.',
                        text: 'Please contact your system administrator.'
                    })
                },
            });
        });

        function saveInclusionList() {
            let p_c_f_request_id = $("#pcf_request_id-foc").val();
            let source_id = $("#source_item_code-foc").val();
            let pcf_no = $("#edit_pcf_no-foc").val();
            let rfq_no = $("#edit_rfq_no-foc").val();
            let quantity = $("#quantity-foc").val();
            let serial_no = $("#serial_no-foc").val();
            let type = $("#type-foc").val();
            let opex = $("#opex-foc").val();
            let total_cost = $("#total_cost-foc").val();
            let depreciable_life = $("#depreciable_life-foc").val();
            let cost_year = $("#cost_year-foc").val();

            $.ajax({
                url: "{{ route('PCF.sub.store_foc') }}",
                type:'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    p_c_f_request_id:p_c_f_request_id,
                    source_id:source_id,
                    pcf_no:pcf_no, 
                    rfq_no:rfq_no, 
                    quantity:quantity,
                    serial_no:serial_no,
                    type:type,
                    opex:opex,
                    total_cost:total_cost,
                    depreciable_life:depreciable_life,
                    cost_year:cost_year
                },
                success: function(data) {
                    clearFOCInputs();
                    $('#edit_pcfFOC_dataTable').DataTable().ajax.reload(null, false);
                    getGrandTotal(pcf_no);
                    Toast.fire({
                        icon: 'success',
                        title: 'Added',
                        text: 'The product has been added to the current request.'
                    })
                    $("#source_item_code-foc").val('').trigger('change')
                },
                error: function (data) {
                    clearFOCInputs();
                    Toast.fire({
                        icon: 'error',
                        title: 'Oops! Something went wrong.',
                        text: 'Please contact your system administrator.'
                    })
                },
            });
        }

        //delete machines and inclusions items;
        $('#edit_pcfFOC_dataTable').on('click', '.pcfInclusionDelete', function (e) {
            e.preventDefault();
            let foc_id = $(this).data('id');
            let pcf_no = $("#edit_pcf_no-foc").val();
            Swal.fire({
                title: 'Delete Item',
                text: "This process will remove the item and all the item associated. Ex: bundled product(s)",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirm'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '/PCF.sub/ajax/delete/pcf-foc/' + foc_id,
                        contentType: "application/json; charset=utf-8",
                        cache: false,
                        dataType: 'json',
                    }).done(function(data) {
                        $('#edit_pcfFOC_dataTable').DataTable().ajax.reload(null, false);
                        getGrandTotal(pcf_no);
                        Toast.fire({
                            icon: 'success',
                            title: 'Removed',
                            text: 'The product has been removed from the current item listing.'
                        })
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        Toast.fire({
                            icon: 'error',
                            title: 'Oops! Something went wrong.',
                            text: 'Please contact your system administrator.'
                        })
                    });
                }
            })
        });

        $('#edit_pcfFOC_dataTable').on('click', '.pcfInclusionsCreateBundle', function (e) {
            e.preventDefault();
            $('#bundleMachinesModal').modal('show');

            document.getElementById("pcfInclusion_id").value = $(this).data('id');

            $('#pcfInclusionsBundle_datatable').DataTable().clear().destroy();
            getInclusionBundledItem($(this).data('id'));
        })

        $('#pcfMachinesBundleForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('PCF.sub.store_bundle_options') }}",
                method:'POST',
                data: {
                    p_c_f_inclusion_id: document.getElementById("pcfInclusion_id").value,
                    source_id: document.getElementById("machine_item_code_bundle").value,
                    quantity: document.getElementById("machine_quantity_bundle").value,
                },
                success: function(response) {
                    $("#machine_item_code_bundle").val('').trigger('change')
                    document.getElementById("machine_description_bundle").value = "";
                    document.getElementById("machine_quantity_bundle").value = "";

                    $('#pcfInclusionsBundle_datatable').DataTable().ajax.reload();

                    Toast.fire({
                        icon: 'success',
                        title: 'Added',
                        text: 'Item has been added as a bundle'
                    })
                },
                error: function (response) {
                    $("#machine_item_code_bundle").val('').trigger('change')
                    document.getElementById("machine_description_bundle").value = "";
                    document.getElementById("machine_quantity_bundle").value = "";

                    $('#pcfInclusionsBundle_datatable').DataTable().ajax.reload();

                    Toast.fire({
                        icon: 'error',
                        title: 'Oops! Something went wrong.',
                        text: 'Please contact your system administrator.'
                    })
                },
            });
        });

        $("#machine_item_code_bundle").select2({
            dropdownParent: $('#bundleMachinesModal'),
            width: "100%",
            allowClear: true,
            minimumInputLength: 3,
            placeholder: 'Item code',
            ajax: {
                url: '{{ route("settings.source.source_search") }}',
                dataType: 'json',
            },
        });

        $('#machine_item_code_bundle').on('select2:select', function (e) {
            var data = e.params.data;
            var source_id = data.id
            if(source_id) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: "application/json; charset=utf-8",
                    dataType: 'json',
                    cache: false,
                    method: 'GET',
                    url: '/settings.source/get-description/source=' + source_id,
                }).done(function(data) {
                    document.getElementById("machine_description_bundle").value = data.description;
                    document.getElementById("machine_quantity_bundle").disabled = false;
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Oops! Something went wrong.',
                        text: 'Please contact your system administrator.'
                    });
                });
            }
        });

        $("#machine_item_code_bundle").on('change', function(e) {
            document.getElementById("machine_description_bundle").value = "";
            document.getElementById("machine_quantity_bundle").value = "";
            document.getElementById("machine_quantity_bundle").disabled = true;
        });

        $('#pcfInclusionsBundle_datatable').on('click', '.pcfInclusionBundleDelete', function (e) {
            e.preventDefault();
            bundleItemId = $(this).data('id');
            Swal.fire({
                title: 'Remove item?',
                text: "This item will be removed as a bundled product",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirm'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'DELETE',
                        url: '/PCF.sub/ajax/delete/bundled-item/' + bundleItemId,
                    }).done(function(response) {
                        $('#pcfInclusionsBundle_datatable').DataTable().ajax.reload();
                        Toast.fire({
                            icon: 'success',
                            title: 'Removed',
                            text: 'The product has been removed from the current item listing.'
                        })
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        Toast.fire({
                            icon: 'error',
                            title: 'Oops! Something went wrong.',
                            text: 'Please contact your system administrator.'
                        })
                    });
                }
            })
        });

        //scripts for getting bundleItem, starts here;
        function getInclusionBundledItem(bundledItemId) {
            $('#pcfInclusionsBundle_datatable').DataTable({
                "stripeClasses": [],
                processing: false,
                serverSide: true,
                responsive: true,
                searchable: true,
                ordering: true,
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url : "/PCF.sub/ajax/bundled/machines-list/" + bundledItemId,
                },
                columns: [
                    { data: 'source.item_code' },
                    { data: 'source.description' },
                    { data: 'quantity' },
                    { data: 'actions' },
                ],
            });
        };

        //FOC Opex Function
        function calculateOpexFOC() {
            var transfer_price = $("#tp_php-foc").val();
            var cost_of_peripherals = parseFloat($("#cost_of_peripherals-foc").val());

            if (isNaN(cost_of_peripherals)) {
                var opex = (transfer_price * 1.3) + 0;
            }
            else {
                var opex = (transfer_price * 1.13) + cost_of_peripherals;
            }

            $("#opex-foc").val(opex.toFixed(2));
        }

        // on quantity input, calculate total cost and yearly cost
        const foc_element = document.querySelectorAll('#quantity-foc');
        foc_element.forEach(i => {
            i.addEventListener('input', function() {
                calculateTotalCostandYearlyCost();
            });
        })

        //on type change, calculate total cost and yearly cost
        $("#type-foc").on('change', function(e) {
            calculateTotalCostandYearlyCost();
            var target = $("#type-foc").val();
            if (target == "MACHINE")
            {
                $("#depreciable_life-foc").val(5);
            }
            else if (target == "COGS")
            {
                $("#depreciable_life-foc").val(1);
            }
        });

        //Total Cost and Yearly Cost Function
        function calculateTotalCostandYearlyCost() {
            var quantity = $("#quantity-foc").val();
            var opex = $("#opex-foc").val();
            var total_cost = opex * quantity;
            var depreciation_life = 0;

            var target = $("#type-foc").val();

            if (target == "MACHINE"){
                depreciation_life = 5;
            }else if (target == "COGS"){
                depreciation_life = 1;
            }
            
            var cost_year = total_cost / depreciation_life;

            $("#total_cost-foc").val(total_cost.toFixed(2));
            $("#cost_year-foc").val(cost_year.toFixed(2));
        }

        function clearFOCInputs() {
            $("#item_code-foc").val("");
            $("#description-foc").val("");
            $("#tp_php-foc").val("");
            $("#type-foc").val("");
            $("#cost_of_peripherals-foc").val("");
            $("#opex-foc").val("");
            $("#serial_no-foc").val("N / A");
            $("#quantity-foc").val("");
            $("#cost_year-foc").val("");
            $("#total_cost-foc").val("");
            $("#depreciable_life-foc").val("");
        }

        function getGrandTotal(pcf_no) {
            $.ajax({
                type: 'GET',
                dataType: 'json',
                url : "/PCF.sub/ajax/get-grand-total/" + pcf_no,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            }).done(function(response) {
                document.getElementById("edit_annual_profit").value = response.annual_profit;
                document.getElementById("edit_annual_profit_rate").value = response.annual_profit_rate;
            }).fail(function(jqXHR, textStatus, errorThrown) {
                Toast.fire({
                    icon: 'error',
                    title: 'Oops! Something went wrong.',
                    text: 'Please contact your system administrator.'
                })
            });
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var inputElement = document.querySelector('input[name="pcf_rfq"]');
            var store = FilePond.create((inputElement),
            {
                labelIdle: `Drag & Drop document file or <span class="filepond--label-action">Browse</span>`,
                imagePreviewHeight: 170,
            });
            
            store.setOptions({
                server: {
                    url: "{{ route('store.pcf_document') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
            });
        });
    </script>

    <script>
        var now = new Date(),
        minDate = now.toISOString().substring(0,10);

        $('#edit_date_bidding').prop('min', minDate);
    </script>
@endsection

@push('scripts')
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush