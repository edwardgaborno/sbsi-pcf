@extends('layouts.app')
@section('title','PCF - Create New Source')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .accordion .fa {
            margin-right: 0.5rem;
        }
        .accordion button, .accordion button:hover, .accordion button:focus {
            text-decoration: none;
        }
        .select2-selection ,
        .select2-selection--single {
            height: 38px !important;
        }
        .select2-selection,
        .select2-selection--single,
        .select2-selection--clearable {
            height: 38px !important;
        }
        .select2-selection__clear > span {
            line-height: 35px !important;
        }
        .select2-container--default,
        .select2-selection--single
        .select2-selection__arrow {
            height: 38px !important;
        }
    </style>
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
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Create New Source</h1>
                </div>

                <div class="">
                    <a href="{{ route('settings.source.index') }}" class="btn btn-sm btn-light mr-2"><i class="fas fa-arrow-circle-left"></i> Back to index page</a>
                </div>
                <br>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ route('settings.source.store') }}" method="post">
                                        @csrf
                                        <!-- Left Element -->
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="supplier">Supplier <span style="color: red;">*</span></label>
                                                    <select class="form-control select2 @error('supplier') is-invalid @enderror" name="supplier_id" id="supplier" required>
                                                        <option value="" selected disabled></option>
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
                                                    <label for="item_code">Item Code <span style="color: red;">*</span></label>
                                                    <input type="text" class="form-control @error('item_code') is-invalid @enderror" name="item_code" id="item_code"
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
                                                    <label for="description">Description <span style="color: red;">*</span></label>
                                                    <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description" required>
                                
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
                                                    <label for="unit_price">Unit Price <span style="color: red;">*</span></label>
                                                    <input type="text" class="form-control @error('unit_price') is-invalid @enderror" name="unit_price" id="unit_price"
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
                                                    <label for="currency_rate">Currency Rate <span style="color: red;">*</span></label>
                                                    <input type="text" class="form-control @error('currency_rate') is-invalid @enderror" name="currency_rate" id="currency_rate"
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
                                                    <label for="tp_php">Total Price (Php)</label>
                                                    <input type="text" class="form-control @error('tp_php') is-invalid @enderror" name="tp_php" id="tp_php"
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
                                                    <label for="tp_php_less_tax">Total Price (Less Tax in PH)</label>
                                                    <input type="text" class="form-control @error('tp_php_less_tax') is-invalid @enderror" name="tp_php_less_tax" id="tp_php_less_tax"
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
                                                    <label for="uom">UOM</label>
                                                    <select class="form-control @error('uom_id') is-invalid @enderror" name="uom_id" id="uom_id">
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
                                                    <label for="segment">Segment</label>
                                                    <select class="form-control @error('segment') is-invalid @enderror" name="segment_id" id="segment">
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
                                                    <label for="item_category">Item Category <span style="color: red;">*</span></label>
                                                    <select class="form-control @error('item_category_id') is-invalid @enderror" name="item_category_id" id="item_category" required>
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
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="mandatory_peripherals">Mandatory Peripherals</label>
                                                    <select class="form-control select2 @error('mandatory_peripherals_ids') is-invalid @enderror" name="mandatory_peripherals_ids[]" multiple="multiple" id="mandatory_peripherals">
                                                    </select>

                                                    @error('mandatory_peripherals_ids')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="cost_of_peripherals">Cost of Peripherals</label>
                                                    <input type="text" class="form-control @error('cost_of_peripherals') is-invalid @enderror" name="cost_of_peripherals" id="cost_of_peripherals"
                                                        value="{{ old('cost_of_peripherals') }}" readonly>

                                                    @error('cost_of_peripherals')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="standard_price">Standard Price</label>
                                                    <input type="text" class="form-control @error('standard_price') is-invalid @enderror" name="standard_price" id="standard_price"
                                                        value="{{ old('standard_price') }}" required readonly>

                                                    @error('standard_price')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="profitability">Profitability (%)</label>
                                                    <input type="text" class="form-control @error('profitability') is-invalid @enderror" name="profitability" id="profitability"
                                                        value="{{ old('profitability') }}" required readonly>

                                                    @error('profitability')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Right Element -->
                                        <button type="submit" class="btn btn-primary float-right">{{ __('Add Source') }}</button>
                                        <a href="{{ route('settings.source.index') }}" class="btn btn-link float-right mr-2">{{ __('Cancel') }}</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Content Row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
        <!-- Footer -->
        @include('layouts.footer')
        <!-- End of Footer -->
    </div>
    <!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush

@section('scripts')
    <script>
        
        function getSuppliers() {
            $.ajax({
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/business-partners/suppliers/ajax/get-suppliers-dropdown',
                    contentType: "application/json; charset=utf-8",
                    cache: false,
                    dataType: 'json',
                }).done(function(res) {
                    data = res.data;
                    $("#supplier").select2({
                        data: data,
                        width: "100%",
                        allowClear: true,
                        placeholder: 'Supplier',
                    });

                }).fail(function(jqXHR, textStatus, errorThrown) {
                    Swal.fire(
                        'Something went wrong!',
                        'Please contact your system administrator!',
                        'error'
                    )
                });
        }

        function getMandatoryPeripherals() {
            $.ajax({
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/settings/mandatory-peripherals/ajax/get-mandatory-peripherals-dropdown',
                    contentType: "application/json; charset=utf-8",
                    cache: false,
                    dataType: 'json',
                }).done(function(res) {
                    data = res.data;
                    $("#mandatory_peripherals").select2({
                        data: data,
                        width: "100%",
                        allowClear: true,
                        placeholder: 'Select Mandatory Peripherals',
                    });

                }).fail(function(jqXHR, textStatus, errorThrown) {
                    Swal.fire(
                        'Something went wrong!',
                        'Please contact your system administrator!',
                        'error'
                    )
                });
        }

        getSuppliers();
        getMandatoryPeripherals();

        const element = document.querySelectorAll('#unit_price, #currency_rate, #cost_of_peripherals');
        element.forEach(i => {
            i.addEventListener('input', function() {
                calculateTP();
                calculateTPpHpLessTax();
                calculateStandardPrice();
            });
        });

        $('#mandatory_peripherals').on('change', function (e) {
            let mp_ids = $(this).val();
            if (mp_ids.length > 0) {
                $.ajax({
                    method: 'get',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        "ids": mp_ids
                    },
                    url: '/settings.source/ajax/get-cost-peripherals-total/',
                    contentType: "application/json; charset=utf-8",
                    cache: false,
                    dataType: 'json',
                }).done(function(res) {
                    document.getElementById("cost_of_peripherals").value = parseFloat(res.totalCostPeripherals).toFixed(2);
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    Swal.fire(
                        'Somethin went wrong!',
                        jqXHR.responseJSON.message,
                        'error'
                    )
                });
            } else {
                console.log('walang laman');
                document.getElementById("cost_of_peripherals").value = null;
            }
        });

        document.getElementById('item_category').addEventListener('change', function() {
            let item_category_id = document.getElementById("item_category").value
            getItemCategory(item_category_id);
            calculateStandardPrice();
        });

        function getItemCategory(item_category_id) {
            $.ajax({
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/settings.source/ajax/get-profit-rate-percentage/' + item_category_id,
                    contentType: "application/json; charset=utf-8",
                    cache: false,
                    dataType: 'json',
                }).done(function(res) {
                    document.getElementById("profitability").value = res.percentage;
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    Swal.fire(
                        'No profit rate percentage',
                        jqXHR.responseJSON.message,
                        'error'
                    )
                });
        }

        function calculateTP()
        {
            const unit_price = parseFloat(document.getElementById("unit_price").value.replace(/,/g, ''));
            const currency_rate = parseFloat(document.getElementById("currency_rate").value.replace(/,/g, ''));

            if (!isNaN(unit_price) && !isNaN(currency_rate)) {
                document.getElementById("tp_php").value = (unit_price * currency_rate).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); 
            } else {
                document.getElementById("tp_php").value = '';
            }
        }

        function calculateTPpHpLessTax() {
            const unit_price = parseFloat(document.getElementById("unit_price").value.replace(/,/g, ''));
            const currency_rate = parseFloat(document.getElementById("currency_rate").value.replace(/,/g, ''));
            const tp_price = parseFloat(document.getElementById("tp_php").value.replace(/,/g, ''));

            if (!isNaN(unit_price) && !isNaN(currency_rate) && !isNaN(tp_price)) {
                document.getElementById("tp_php_less_tax").value = (tp_price / 1.12).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); 
            } else {
                document.getElementById("tp_php_less_tax").value = '';
            }
        }

        function calculateStandardPrice()
        {
            const currency_rate = parseFloat(document.getElementById("currency_rate").value.replace(/,/g, ''));
            const tp_php_less_tax = parseFloat(document.getElementById("tp_php_less_tax").value.replace(/,/g, ''));
            const cost_of_peripherals = parseFloat(document.getElementById("cost_of_peripherals").value.replace(/,/g, ''));
            const item_category_name=  $( "#item_category option:selected" ).text();
            const standard_price = document.getElementById("standard_price");
            if (currency_rate === 1) {
                if (!isNaN(cost_of_peripherals) && item_category_name === "MACHINE") {
                    standard_price.value = ((((tp_php_less_tax * 1.15) + cost_of_peripherals) / (1 - 0.3)) * 1.12).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); 
                }
                else if (isNaN(cost_of_peripherals) && item_category_name === "MACHINE") {
                    standard_price.value = ((((tp_php_less_tax * 1.15) + 0) / (1 - 0.3)) * 1.12).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); 
                }
                else if (!isNaN(cost_of_peripherals) && item_category_name !== "MACHINE") {
                    standard_price.value = ((((tp_php_less_tax * 1.15) + cost_of_peripherals) / (1 - 0.5)) * 1.12).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); 
                }
                else if (isNaN(cost_of_peripherals) && item_category_name !== "MACHINE") {
                    standard_price.value = ((((tp_php_less_tax * 1.15) + 0) / (1 - 0.5)) * 1.12).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); 
                }
            }
            else {
                if (!isNaN(cost_of_peripherals) && item_category_name === "MACHINE") {
                    standard_price.value = ((((tp_php_less_tax * 1.3) + cost_of_peripherals) / (1 - 0.3)) * 1.12).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); 
                }
                else if (isNaN(cost_of_peripherals) && item_category_name === "MACHINE") {
                    standard_price.value = ((((tp_php_less_tax * 1.3) + 0) / (1 - 0.3)) * 1.12).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); 
                }
                else if (!isNaN(cost_of_peripherals) && item_category_name !== "MACHINE") {
                    standard_price.value = ((((tp_php_less_tax * 1.3) + cost_of_peripherals) / (1 - 0.5)) * 1.12).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); 
                }
                else if (isNaN(cost_of_peripherals) && item_category_name !== "MACHINE") {
                    standard_price.value = ((((tp_php_less_tax * 1.3) + 0) / (1 - 0.5)) * 1.12).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); 
                }
            }
        }

        $('#unit_price').keyup(function(event) {

            // skip for arrow keys
            if(event.which >= 37 && event.which <= 40) return;

            // format number
            $(this).val(function(index, value) {
                return value
                // .replace(/\D/g, "")
                .replace(/[^0-9.]/g, '')
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                ;
            });
        });

        $('#currency_rate').keyup(function(event) {

            // skip for arrow keys
            if(event.which >= 37 && event.which <= 40) return;

            // format number
            $(this).val(function(index, value) {
                return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                ;
            });
        });
        
        $('#cost_of_peripherals').keyup(function(event) {

            // skip for arrow keys
            if(event.which >= 37 && event.which <= 40) return;

            // format number
            $(this).val(function(index, value) {
                return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                ;
            });
        });
    </script>
@endsection