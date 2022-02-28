@extends('layouts.app')
@section('title','PCF - PCF Create Request')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .accordion .fa {
            margin-right: 0.5rem;
        }

        .accordion button, .accordion button:hover, .accordion button:focus {
            text-decoration: none;
        }
        .pull-left{
            float:left!important;
        }
        .pull-right{
            float:right!important;
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
        .select2-container--default,
        .select2-selection--single,
        .select2-selection__rendered {
            line-height: 38px !important;
        }
        .select2-container--default 
        .select2-selection--single 
        .select2-selection__arrow {
            height: 38px !important;
        }
        #wrapper #content-wrapper {
            overflow-x: visible !important;
        }
        div.sticky {
            position: -webkit-sticky;
            position: sticky;
            top: 0;
            padding: 20px;
            z-index: 999;
        }
        div.submit-pcf {
            position: -webkit-sticky;
            position: sticky;
            bottom: 0;
            padding: 20px;
            z-index: 999;
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
                    <h1 class="h3 mb-0 text-gray-800">PCF Request</h1>
                </div>

                <div class="">
                    <a href="{{ route('PCF.index') }}" class="btn btn-sm btn-light mr-2"><i class="fas fa-arrow-circle-left"></i> Back to index page</a>
                </div>
                <br>
                <div class="row sticky">
                    <div class="col-md-12">
                        <div class="card" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); border-radius: 8px;">
                            <div class="card-body">
                                <form action="{{ route('PCF.store') }}" method="post" id="submit_pcf_request_form">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-1">
                                            <label for="pcf_no">PCF No.</label>
                                            <input type="text" class="form-control @error('pcf_no') is-invalid @enderror" name="pcf_no" id="pcf_no"
                                                value="{{ old('pcf_no', $pcf_no) }}" required readonly>

                                            @error('pcf_no')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-1">
                                            <label for="pcf_no">RFQ No.</label>
                                            <input type="text" class="form-control @error('rfq_no') is-invalid @enderror" name="rfq_no" id="rfq_no"
                                                value="{{ old('rfq_no', $rfq_no) }}" required readonly>

                                            @error('rfq_no')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label for="institution">Institution</label>
                                            <select name="institution_id" id="institution" class="form-control @error('institution') is-invalid @enderror select2" required>
                                                <option value="" selected disabled></option>
                                            </select>
                    
                                            @error('institution')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror 
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label for="address">Address</label>
                                            <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="address" value="{{ old('address') }}" disabled>
                                        
                                            @error('address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                                <label for="contact_person">Contact Person</label>
                                                <input type="text" class="form-control @error('contact_person') is-invalid @enderror" name="contact_person" id="contact_person"
                                                    value="{{ old('contact_person') }}" required>

                                                @error('contact_person')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="designation">Designation</label>
                                            <input type="text" class="form-control @error('designation') is-invalid @enderror" name="designation" id="designation"
                                                value="{{ old('designation') }}" required>

                                            @error('designation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="thru_contact_person">Thru Contact Person</label>
                                            <input type="text" class="form-control @error('thru_contact_person') is-invalid @enderror" name="thru_contact_person" id="thru_contact_person"
                                                value="{{ old('thru_contact_person') }}">

                                            @error('thru_contact_person')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="thru_designation">Thru Designation</label>
                                            <input type="text" class="form-control @error('thru_designation') is-invalid @enderror" name="thru_designation" id="thru_designation"
                                                value="{{ old('thru_designation') }}">

                                            @error('thru_designation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="institution">Supplier/Manufacturer</label>
                                            <input type="text" class="form-control @error('supplier') is-invalid @enderror" name="supplier" id="supplier"
                                                value="{{ old('supplier') }}" required>

                                            @error('supplier')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="terms">Terms</label>
                                            <input type="text" class="form-control @error('terms') is-invalid @enderror" name="terms" id="terms"
                                                value="{{ old('terms') }}" required>

                                            @error('terms')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="validity">Validity</label>
                                            <input type="text" class="form-control @error('validity') is-invalid @enderror" name="validity" id="validity"
                                                value="{{ old('validity') }}" required>
                                            
                                            @error('validity')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="delivery">Delivery</label>
                                            <input type="text" class="form-control @error('delivery') is-invalid @enderror" name="delivery" id="delivery"
                                                value="{{ old('delivery') }}" required>

                                            @error('delivery')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="warranty">Warranty (For Machines Only)</label>
                                            <input type="text" class="form-control @error('warranty') is-invalid @enderror" name="warranty" id="warranty"
                                                value="{{ old('warranty') }}">

                                            @error('warranty')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="contract_duration">Duration of Contract</label>
                                            <input type="number" class="form-control @error('contract_duration') is-invalid @enderror" name="contract_duration" id="contract_duration"
                                                value="{{ old('contract_duration') }}">

                                            @error('contract_duration')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="date_bidding">Date Bidding</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <input type="checkbox" id="dateBiddingCheckBox" aria-label="Checkbox for following date input">
                                                        <label class="form-check-label" for="dateBiddingCheckBox">
                                                            N/A
                                                        </label>
                                                    </div>
                                                </div>
                                                <input type="date" class="form-control @error('date_bidding') is-invalid @enderror" name="date_bidding" id="date_bidding"
                                                    value="{{ old('date_bidding') }}" aria-describedby="date_bidding">
                                                
                                                @error('date_bidding')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="bid_docs_price">Bid Docs Price</label>
                                            <input type="number" class="form-control @error('bid_docs_price') is-invalid @enderror" name="bid_docs_price" id="bid_docs_price"
                                                value="{{ old('bid_docs_price') }}">

                                            @error('bid_docs_price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="manager">Manager</label>
                                            <select class="form-control @error('manager') is-invalid @enderror" name="manager" id="manager" required>
                                                <option value="" selected disabled>Select Manager</option>
                                                <option value="Rachelle Anne Carrera">Rachelle Anne Carrera</option>
                                                <option value="Gloria Cutang">Gloria Cutang</option>
                                                <option value="Gilbert Gravata">Gilbert Gravata</option>
                                            </select>

                                            @error('manager')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="annual_profit">Annual Profit</label>
                                            <input type="text" class="form-control @error('annual_profit') is-invalid @enderror" name="annual_profit" id="annual_profit"
                                                value="{{ old('annual_profit','0') }}" readonly required> 

                                            @error('annual_profit')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="annual_profit_rate">Annual Profit Rate (%)</label>
                                            <input type="text" class="form-control @error('annual_profit_rate') is-invalid @enderror" name="annual_profit_rate" id="annual_profit_rate"
                                                value="{{ old('annual_profit_rate', '0.00') }}" readonly required>

                                            @error('annual_profit_rate')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- End Right Element -->
                                    {{-- <button type="submit" class="btn btn-primary float-right">{{ __('Submit PCF Request') }}</button>
                                    <a href="{{ route('PCF.index') }}" class="btn btn-link float-right mr-2">{{ __('Cancel') }}</a> --}}
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="accordion" id="accordionExample">
                    @include('PCF.sub.partials.items')
                    @include('PCF.sub.partials.sources')
                    @include('PCF.sub.partials.machines')
                </div>
                <div class="row pt-2 pcf-submit">
                    <div class="col-md-12">
                        <button type="submit" id="submit_pcf_request" class="btn btn-primary form-control mt-2"><i class="far fa-save"></i> &nbsp;{{ __('Submit PCF Request') }}</button>
                        <a href="{{ route('PCF.index') }}" class="btn btn-danger form-control mt-2"><i class="fas fa-times"></i>&nbsp;{{ __('Cancel') }}</a>
                    </div>
                </div>
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
    function CopyToClipboard(item_code, btn_id) {
        var doc = document
        , text = doc.getElementById(item_code)
        , range, selection;

        if (doc.body.createTextRange) {
            range = doc.body.createTextRange();
            range.moveToElementText(text);
            range.select();
        } else if (window.getSelection) {
            selection = window.getSelection();        
            range = doc.createRange();
            range.selectNodeContents(text);
            selection.removeAllRanges();
            selection.addRange(range);
        }

        document.execCommand('copy');
        window.getSelection().removeAllRanges();
        document.getElementById(btn_id).innerHTML="Copied";
    }

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        showCloseButton: true,
        timer: 2500,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    //scripts for pcfList, starts here;
    document.addEventListener('DOMContentLoaded', function() {
        $('#pcfItem_datatable').DataTable({
            "stripeClasses": [],
            processing: false,
            serverSide: true,
            responsive: true,
            searchable: true,
            ordering: true,
            ajax: {
                url : "{{ route('PCF.sub.item_list', $pcf_no) }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            columns: [
                { data: 'supplier' },
                { data: 'source.item_code' },
                { data: 'source.description' },
                { data: 'quantity' },
                { data: 'uom' },
                { data: 'sales' },
                { data: 'total_sales' },
                { data: 'above_standard_price' },
                { data: 'actions' },
            ],
        });

        $('#mandatory_peripherals_datatable').DataTable({
            "stripeClasses": [],
            processing: false,
            serverSide: true,
            responsive: true,
            searchable: true,
            ordering: true,
            ajax: {
                url : "{{ route('PCF.sub.get_pcf_list_mandatory_items', $pcf_no) }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            columns: [
                { data: 'item_code' },
                { data: 'item_description' },
                { data: 'quantity' },
                { data: 'item_category' },
            ],
        });

        $('#pcfFOC_dataTable').DataTable({
            "stripeClasses": [],
            processing: false,
            serverSide: true,
            responsive: true,
            searchable: true,
            ordering: true,
            ajax: {
                url : "{{ route('PCF.sub.foc_list', $pcf_no) }}",
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
                { data: 'actions' },
            ],
        });

        $('#pcf_view_sources_datatable').DataTable({
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "stripeClasses": [],
                processing: true,
                serverSide: true,
                responsive: true,
                searchable: true,
                ordering: true,
                ajax: {
                    url: "{{ route('settings.source.full_list') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                columns: [
                    { data: 'supplier' },
                    { data: 'item_code' },
                    { data: 'description' },
                    { data: 'uom' },
                    { data: 'item_category' },
                    { data: 'copy' },
                ],
            });

            $(function () {
                $(".collapse.show").each(function () {
                    $(this)
                    .prev(".card-header")
                    .find(".fa")
                    .addClass("fa-minus")
                    .removeClass("fa-plus");
                });
                $(".collapse")
                    .on("show.bs.collapse", function () {
                    $(this)
                        .prev(".card-header")
                        .find(".fa")
                        .removeClass("fa-plus")
                        .addClass("fa-minus");
                    })
                    .on("hide.bs.collapse", function () {
                    $(this)
                        .prev(".card-header")
                        .find(".fa")
                        .removeClass("fa-minus")
                        .addClass("fa-plus");
                    });

                var now = new Date(),
                minDate = now.toISOString().substring(0,10);

                $('#date_bidding').prop('min', minDate);

                $('#dateBiddingCheckBox').change(function() {
                    if($(this).is(":checked")) {
                        document.getElementById('date_bidding').type = 'text';
                        document.getElementById("date_bidding").readOnly = true;
                        document.getElementById("bid_docs_price").readOnly = true;
                    }
                    else {
                        document.getElementById('date_bidding').type = 'date';
                        document.getElementById("date_bidding").readOnly = false;

                        document.getElementById("bid_docs_price").readOnly = false;
                    }
                })   
            });
        getGrandTotalProfit();
        getSources();
        getInstitutions();
        getSuppliers();
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

                $("#source_item_code_item").select2({
                    data: data,
                    width: "100%",
                    allowClear: true,
                    placeholder: 'Item code',
                });

                $("#source_item_code_inclusion").select2({
                    data: data,
                    width: "100%",
                    allowClear: true,
                    placeholder: 'Item code',
                });

            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            });
    }

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
                $("#institution").select2({
                    data: data,
                    width: "100%",
                    allowClear: true,
                    placeholder: 'Institution',
                });

            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            });
    }

    $('#source_item_code_item').on('select2:select', function (e) {
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
                console.log(data.standard_price);
                document.getElementById("description_item").value = data.description;
                document.getElementById("currency_rate_item").value = data.currency_rate;
                document.getElementById("tp_php_item").value = data.tp_php;
                document.getElementById("is_above_standard_price").value = data.standard_price;
                document.getElementById("cost_of_peripherals_item").value = data.cost_of_peripherals;
                document.getElementById("quantity_item").disabled = false;
                document.getElementById("unit_price_item").disabled = false;
                document.getElementById("unit_price_item").disabled = false;
                calculateItemListOpex();
            }).fail(function(jqXHR, textStatus, errorThrown) {
                Toast.fire({
                    icon: 'error',
                    title: 'Oops! Something went wrong.',
                    text: 'Please contact your system administrator.'
                })
            });
        }
    });

    $('#institution').on('select2:select', function (e) {
        var data = e.params.data;
        document.getElementById("address").value = data.address;
        document.getElementById("contact_person").value = data.contact_person;    
        document.getElementById("designation").value = data.designation;    
        document.getElementById("thru_contact_person").value = data.thru_contact_person;
        document.getElementById("thru_designation").value = data.thru_designation;
    });

    $('#institution').on('change', function (e) {
        if ($(this).val() == null) {
            clearInstitutionContacts();
        }
    });

    $( "#source_item_code_item" ).on('change', function(e) {
        if ($(this).val() == null) {
            clearItemInputs();
        }
    });

    $('#submit_pcf_request').click( function() {
        $('#submit_pcf_request_form').submit();
    });

    const item_inputs = document.querySelectorAll('#unit_price_item, #quantity_item');
    item_inputs.forEach(i => {
        i.addEventListener('input', function() {
            calculateItemListOpex();
            calculateItemListNetSales();
            calculateItemListTotalSales();
            calculateAboveStandardPrice();
            calculateItemListGrossProfit();
            calculateItemListTotalGrossProfit();
            calculateItemListTotalNetSales();
            calculateItemListProfitRatePerItem();
            getGrandTotalProfit();
        });
    })

    function calculateItemListOpex() {
        var currency_rate_item = $("#currency_rate_item").val();
        var total_price_item = $("#tp_php_item").val();
        
        if (currency_rate_item && total_price_item) {
            if (parseFloat(currency_rate_item) == 1 ) {
                var opex_item = total_price_item * 1.15;
            } else if (parseFloat(currency_rate_item) > 1) {
                var opex_item = total_price_item * 1.35;
            } 
            $("#opex_item").val(opex_item.toFixed(2));
        }
    }

    function calculateItemListNetSales() {
        var unit_price_item = $("#unit_price_item").val();
        var net_sales_item = unit_price_item / 1.12;
        $("#net_sales_item").val(net_sales_item.toFixed(2));
    }

    function calculateItemListTotalSales() {
        var quantity_item = $("#quantity_item").val();
        var unit_price_item = $("#unit_price_item").val();
        var total_sales_item = unit_price_item * quantity_item;

        $("#total_sales_item").val(total_sales_item.toFixed(2));
    }

    function calculateAboveStandardPrice() {
        var unit_price_item = $("#unit_price_item").val();
        var standard_price = $("#is_above_standard_price").val();

        if (parseInt(unit_price_item) > parseInt(standard_price)) {
            $("#above_standard_price").val("Yes");
        } else {
            $("#above_standard_price").val("No");
        }
    }

    function calculateItemListGrossProfit() {
        var net_sales_item = $("#net_sales_item").val();
        var opex_item = $("#opex_item").val();
        var total_cost_mandatory_peripheral_item = $("#cost_of_peripherals_item").val();
        var gross_profit_item = (net_sales_item - opex_item) - total_cost_mandatory_peripheral_item;

        $("#gross_profit_item").val(gross_profit_item.toFixed(2));
    }

    function calculateItemListTotalGrossProfit() {
        var gross_profit_item = $("#gross_profit_item").val();
        var quantity_item = $("#quantity_item").val();
        var total_gross_profit_item = gross_profit_item * quantity_item;

        $("#total_gross_profit_item").val(total_gross_profit_item.toFixed(2));
    }

    function calculateItemListTotalNetSales() {
        var total_sales_item = $("#total_sales_item").val();
        var total_net_sales_item = total_sales_item / 1.12;

        $("#total_net_sales_item").val(total_net_sales_item.toFixed(2));
    }

    function calculateItemListProfitRatePerItem() {
        var gross_profit_item = $("#gross_profit_item").val();
        var net_sales_item = $("#net_sales_item").val();

        if (gross_profit_item && net_sales_item) {
            var profit_rate_item = (gross_profit_item / net_sales_item) * 100;
            $("#profit_rate_item").val(profit_rate_item.toFixed(2));
        }
    }

    //on pcfList form submit; ajax
    $('#pcfListForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('PCF.sub.check_if_item_exist') }}",
            method:'GET',
            data: {
                pcf_no: document.getElementById("pcf_no").value,
                rfq_no: document.getElementById("pcf_no").value,
                source_id: document.getElementById("source_item_code_item").value,
            },
            success: function(response) {
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
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('PCF.sub.store_items') }}",
            method:'POST',
            data: {
                pcf_no: document.getElementById("pcf_no").value,
                rfq_no: document.getElementById("pcf_no").value,
                source_id: document.getElementById("source_item_code_item").value,
                product_segment_id: document.getElementById("product_segment_id").value,
                quantity: document.getElementById("quantity_item").value,
                sales: document.getElementById("unit_price_item").value,
                total_sales: document.getElementById("total_sales_item").value,
                opex: document.getElementById("opex_item").value,
                net_sales: document.getElementById("net_sales_item").value,
                gross_profit: document.getElementById("gross_profit_item").value,
                total_gross_profit: document.getElementById("total_gross_profit_item").value,
                total_net_sales: document.getElementById("total_net_sales_item").value,
                profit_rate: document.getElementById("profit_rate_item").value
            },
            success: function(response) {
                clearItemInputs();
                $("#source_item_code_item").val('').trigger('change')
                // getGrandTotal(pcf_no);
                $('#pcfItem_datatable').DataTable().ajax.reload();
                $('#mandatory_peripherals_datatable').DataTable().ajax.reload();
                Toast.fire({
                    icon: 'success',
                    title: 'Added',
                    text: 'The product has been added to the current item list.'
                })
            },
            error: function (response) {
                clearItemInputs();
                Toast.fire({
                    icon: 'error',
                    title: 'Oops! Something went wrong.',
                    text: 'Please contact your system administrator.'
                })
            },
        });
    }

    function clearItemInputs() {
        document.getElementById("description_item").value = '',
        document.getElementById("currency_rate_item").value = '',
        document.getElementById("tp_php_item").value = '0.00',
        document.getElementById("cost_of_peripherals_item").value = '0.00',
        document.getElementById("quantity_item").value = '',
        document.getElementById("unit_price_item").value = '0.00',
        document.getElementById("total_sales_item").value = '0.00',
        document.getElementById("opex_item").value = '',
        document.getElementById("net_sales_item").value = '0.00',
        document.getElementById("gross_profit_item").value = '0.00',
        document.getElementById("total_gross_profit_item").value = '0.00',
        document.getElementById("total_net_sales_item").value = '0.00',
        document.getElementById("profit_rate_item").value = '',

        calculateItemListOpex();
        calculateItemListNetSales();
        calculateItemListTotalSales();
        calculateItemListGrossProfit();
        calculateItemListTotalGrossProfit();
        calculateItemListTotalNetSales();
        calculateItemListProfitRatePerItem();

        getGrandTotalProfit();

        document.getElementById("quantity_item").disabled = true;
        document.getElementById("unit_price_item").disabled = true;
    }

    function clearInstitutionContacts() {
        document.getElementById("address").value = "";
        document.getElementById("contact_person").value = "";    
        document.getElementById("designation").value = "";    
        document.getElementById("thru_contact_person").value = "";
        document.getElementById("thru_designation").value = "";
    }
    //delete item from pcfList table
    let item_id;
    $('#pcfItem_datatable').on('click', '.pcfListDelete', function (e) {
        e.preventDefault();
        item_id = $(this).data('id');
        Swal.fire({
            title: 'Remove this item?',
            text: "This item will be removed from the current item listing",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: 'DELETE',
                    url: '/PCF.sub/ajax/delete/pcf-list/' + item_id,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                }).done(function(response) {
                    $('#pcfItem_datatable').DataTable().ajax.reload();
                    $('#mandatory_peripherals_datatable').DataTable().ajax.reload();
                    getGrandTotalProfit();
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
    })
</script>

<script>
    $('#source_item_code_inclusion').on('select2:select', function (e) {
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
                $("#currency_rate_inclusion").val(data.currency_rate);
                $('#description_inclusion').val(data.description);
                $("#tp_php_inclusion").val(data.tp_php);
                $("#cost_of_peripherals_inclusion").val(data.cost_of_peripherals);
                $("#quantity_inclusion").val("1");
                calculateInclusionListOpex();
                calculateInclusionTotalCost();
                calculateInclusionTotalCostPerYear();
                getGrandTotalProfit();
            }).fail(function(jqXHR, textStatus, errorThrown) {
                Toast.fire({
                    icon: 'error',
                    title: 'Oops! Something went wrong.',
                    text: 'Please contact your system administrator.'
                })
                clearInclusionInputs();
            });
        }
    });

    $("#source_item_code_inclusion").on('change', function(e) {
        if ($(this).val() == null) {
            console.log('walang value');
            clearInclusionInputs();
        }

    });
    //end of select2 function;

    const inclusion_inputs = document.querySelectorAll('#quantity_inclusion');
    inclusion_inputs.forEach(i => {
        i.addEventListener('input', function() {
            calculateInclusionListOpex();
            calculateInclusionTotalCost();
            calculateInclusionTotalCostPerYear();

            getGrandTotalProfit();
        });
    })

    $("#type_inlcusion").on('change', function() {
        calculateInclusionListOpex();
        calculateInclusionTotalCost();
        calculateInclusionTotalCostPerYear();

        getGrandTotalProfit();
    });

    function calculateInclusionListOpex() {
        var total_price_inclussion = $("#tp_php_inclusion").val();
        var currency_rate_inclussion = $("#currency_rate_inclusion").val();

        if (currency_rate_inclussion && total_price_inclussion) {
            if (parseInt(currency_rate_inclussion) == 1) {
            var opex_inclusion = total_price_inclussion * 1.15;
            } else if (parseInt(currency_rate_inclussion) > 1) {
                var opex_inclusion = total_price_inclussion * 1.35;
            }
            $("#opex_inclusion").val(opex_inclusion.toFixed(2));
        }
    }

    function calculateInclusionTotalCost() {
        var quantity_inclusion = $("#quantity_inclusion").val();
        var opex_inclusion = $("#opex_inclusion").val();
        var total_cost_inclusion = quantity_inclusion * opex_inclusion;
        console.log(total_cost_inclusion);
        $("#total_cost_inclusion").val(total_cost_inclusion.toFixed(2));
    }

    function calculateInclusionTotalCostPerYear() {
        var total_cost_inclusion = $("#total_cost_inclusion").val();
        var depreciable_life_inclusion = $("#type_inlcusion").val();

        if (depreciable_life_inclusion == "COGS") {
            var total_cost_per_year_inclusion = total_cost_inclusion / 1;
        } else if(depreciable_life_inclusion == "MACHINE") {
            var total_cost_per_year_inclusion = total_cost_inclusion / 5;
        }

        console.log(total_cost_per_year_inclusion);

        $("#total_cost_per_year_inclussion").val(total_cost_per_year_inclusion);
    }

    function getGrandTotalProfit() {
        var pcf_no = $("#pcf_no").val();
        if (pcf_no) {
            $.ajax({
                method: 'GET',
                url: '/PCF.sub/ajax/get-grand-total-profit/' + pcf_no,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            }).done(function(response) {
                var total_gross_profit = $("#total_gross_profit_item").val();
                var total_cost_per_year_inclusion = $("#total_cost_per_year_inclussion").val();
                var total_net_sales_item = $("#total_net_sales_item").val();
                var total_grand_profit = (parseFloat(total_gross_profit) + parseFloat(response.sumTotalGrossProfit)) - (parseFloat(total_cost_per_year_inclusion) +parseFloat(response.sumTotalCostPerYear));
                if (total_net_sales_item.length > 0) {
                    var profit_rate = (total_grand_profit / (parseFloat(response.sumTotalNetSales) + parseFloat(total_net_sales_item))) * 100;
                } else {
                    var profit_rate = (total_grand_profit / parseFloat(response.sumTotalNetSales)) * 100;
                }
                // console.log(profit_rate);
                $("#annual_profit").val(total_grand_profit);
                $("#annual_profit_rate").val(profit_rate.toFixed(2));
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
            });
        }
    }

    //on pcfMachinesForm submit; ajax
    $('#pcfMachinesForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('PCF.sub.check_if_inclusion_exist') }}",
            method:'GET',
            data: {
                pcf_no: document.getElementById("pcf_no").value,
                rfq_no: document.getElementById("pcf_no").value,
                source_id: document.getElementById("source_item_code_inclusion").value,
            },
            success: function(response) {
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
                            clearInclusionInputs();
                        }
                    })
                } else {
                    saveInclusionList();
                    clearInclusionInputs();
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
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('PCF.sub.store_foc') }}",
            method:'POST',
            data: {
                pcf_no: document.getElementById("pcf_no").value,
                rfq_no: document.getElementById("rfq_no").value,
                source_id: document.getElementById("source_item_code_inclusion").value,
                serial_no: document.getElementById("serial_no_inclusion").value,
                type: document.getElementById("type_inclusion").value,
                quantity: document.getElementById("quantity_inclusion").value,
                opex: document.getElementById("opex_inclusion").value,
                total_cost: document.getElementById("total_cost_inclusion").value,
                cost_year: document.getElementById("cost_year_inclusion").value,
                depreciable_life: document.getElementById("depreciable_life_inclusion").value,
            },
            success: function(response) {
                clearInclusionInputs();
                $("#source_item_code_inclusion").val('').trigger('change')
                // getGrandTotal(pcf_no);
                $('#pcfFOC_dataTable').DataTable().ajax.reload();
                Toast.fire({
                    icon: 'success',
                    title: 'Added',
                    text: 'The product has been added to the current item list.'
                })
            },
            error: function (response) {
                clearInclusionInputs();
                Toast.fire({
                    icon: 'error',
                    title: 'Oops! Something went wrong.',
                    text: 'Please contact your system administrator.'
                })
            },
        });
    }

    function clearInclusionInputs() {
        $("#currency_rate_inclusion").val("");
        $("#item_code_inclusion").val("");
        $("#description_inclusion").val("");
        $("#type_inclusion").val("");
        $("#tp_php_inclusion").val("0.00");
        $("#cost_of_peripherals_inclusion").val("0.00");
        $("#opex_inclusion").val("");
        $("#serial_no_inclusion").val("N / A");
        $("#quantity_inclusion").val("");
        $("#cost_year_inclusion").val("0.00");
        $("#total_cost_inclusion").val("0.00");
        $("#depreciable_life_inclusion").val("");

        calculateInclusionListOpex();
        calculateInclusionTotalCost();
        calculateInclusionTotalCostPerYear();

        getGrandTotalProfit();
    }

    let foc_id;
    $('#pcfFOC_dataTable').on('click', '.pcfInclusionDelete', function (e) {
        e.preventDefault();
        foc_id = $(this).data('id');
        Swal.fire({
            title: 'Remove this item?',
            text: "This item will be removed from the current session",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: 'DELETE',
                    url: '/PCF.sub/ajax/delete/pcf-foc/' + foc_id,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                }).done(function(response) {
                    $('#pcfFOC_dataTable').DataTable().ajax.reload();
                    // getGrandTotal();
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
    })

    $("#supplier_filter").on('change', function () {
        var supplier_id = $(this).val();
        if (supplier_id) {
            $('#pcf_view_sources_datatable').DataTable().clear().destroy();
            $('#pcf_view_sources_datatable').DataTable({
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "stripeClasses": [],
                processing: true,
                serverSide: true,
                responsive: true,
                searchable: true,
                ordering: true,
                ajax: {
                    url: '/settings.source/ajax/get-source-suppliers/' + supplier_id,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                columns: [
                    { data: 'supplier' },
                    { data: 'item_code' },
                    { data: 'description' },
                    { data: 'uom' },
                    { data: 'item_category' },
                    { data: 'copy' },
                ],
            });
        } else {
            $('#pcf_view_sources_datatable').DataTable().clear().destroy();
            $('#pcf_view_sources_datatable').DataTable({
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "stripeClasses": [],
                processing: true,
                serverSide: true,
                responsive: true,
                searchable: true,
                ordering: true,
                ajax: {
                    url: "{{ route('settings.source.full_list') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                columns: [
                    { data: 'supplier' },
                    { data: 'item_code' },
                    { data: 'description' },
                    { data: 'uom' },
                    { data: 'item_category' },
                    { data: 'copy' },
                ],
            });
        }
    });

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
                $("#edit_supplier").select2({
                    data: data,
                    width: "100%",
                    allowClear: true,
                    placeholder: 'Supplier',
                });

                $("#supplier_filter").select2({
                    data: data,
                    width: "100%",
                    allowClear: true,
                    placeholder: 'Supplier',
                    dropdownParent: $("#pcf_view_sources_datatable")
                });

            }).fail(function(jqXHR, textStatus, errorThrown) {
                Swal.fire(
                    'Something went wrong!',
                    'Please contact your system administrator!',
                    'error'
                )
            });
    }
</script>
@endsection