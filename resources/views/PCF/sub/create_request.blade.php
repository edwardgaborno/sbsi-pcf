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
                <div class="row" style="position: sticky; top: 0;">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('PCF.store') }}" method="post" id="submit_pcf_request_form">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label for="pcf_no">PCF No.</label>
                                            <input type="text" class="form-control @error('pcf_no') is-invalid @enderror" name="pcf_no" id="pcf_no"
                                                value="{{ old('pcf_no', $pcf_no) }}" required readonly>

                                            @error('pcf_no')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="pcf_no">RFQ No.</label>
                                            <input type="text" class="form-control @error('rfq_no') is-invalid @enderror" name="rfq_no" id="rfq_no"
                                                value="{{ old('rfq_no', $rfq_no) }}" required readonly>

                                            @error('rfq_no')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-3">
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
                                        <div class="form-group col-md-4">
                                            <label for="terms">Terms</label>
                                            <input type="text" class="form-control @error('terms') is-invalid @enderror" name="terms" id="terms"
                                                value="{{ old('terms') }}" required>

                                            @error('terms')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="validity">Validity</label>
                                            <input type="text" class="form-control @error('validity') is-invalid @enderror" name="validity" id="validity"
                                                value="{{ old('validity') }}" required>
                                            
                                            @error('validity')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="delivery">Delivery</label>
                                            <input type="text" class="form-control @error('delivery') is-invalid @enderror" name="delivery" id="delivery"
                                                value="{{ old('delivery') }}" required>

                                            @error('delivery')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
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
                                            <label for="annual_profit_rate">Annual Profit Rate</label>
                                            <input type="text" class="form-control @error('annual_profit_rate') is-invalid @enderror" name="annual_profit_rate" id="annual_profit_rate"
                                                value="{{ old('annual_profit_rate', '0') }}" readonly required>

                                            @error('annual_profit_rate')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- End Right Element -->
                                    <button type="submit" class="btn btn-primary float-right">{{ __('Submit PCF Request') }}</button>
                                    <a href="{{ route('PCF.index') }}" class="btn btn-link float-right mr-2">{{ __('Cancel') }}</a>
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
                <button type="button" id="submit_pcf_request" class="btn btn-primary float-right">{{ __('Submit PCF Request') }}</button>
                <a href="{{ route('PCF.index') }}" class="btn btn-link float-right mr-2">{{ __('Cancel') }}</a>
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
        // console.log(item_code);
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
        getGrandTotal();
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

    getSources();
    getInstitutions();

    //start of select2 function -- item_code
    // $(function () {
    //     $('#source_item_code-i').select2({
    //         width: "100%",
    //         allowClear: true,
    //         minimumInputLength: 1,
    //         placeholder: 'Item code',
    //         ajax: {
    //             delay: 250,
    //             url: '{{ route("settings.source.source_search") }}',
    //             dataType: 'json',
    //         },
    //     });
    // });

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
                document.getElementById("description-i").value = data.description;
                document.getElementById("currency_rate-i").value = data.currency_rate;
                document.getElementById("tp_php-i").value = data.tp_php;
                document.getElementById("cost_of_peripherals-i").value = data.cost_of_peripherals;

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

    $('#institution').on('select2:select', function (e) {
        var data = e.params.data;
        document.getElementById("address").value = data.address;
        document.getElementById("contact_person").value = data.contact_person;    
        document.getElementById("designation").value = data.designation;    
        document.getElementById("thru_duration_contract").value = data.thru_designation;
    });

    $( "#source_item_code-i" ).on('change', function(e) {
        clearItemInputs();
        document.getElementById("quantity-i").disabled = true;
        document.getElementById("sales-i").disabled = true;
    });
    //end of select2 function

    $('#submit_pcf_request').click( function() {
        $('#submit_pcf_request_form').submit();
    });

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
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('PCF.sub.store_items') }}",
            method:'POST',
            data: {
                pcf_no: document.getElementById("pcf_no").value,
                rfq_no: document.getElementById("pcf_no").value,
                source_id: document.getElementById("source_item_code-i").value,
                quantity: document.getElementById("quantity-i").value,
                sales: document.getElementById("sales-i").value,
                total_sales: document.getElementById("total_sales-i").value,
                opex: document.getElementById("opex-i").value,
                net_sales: document.getElementById("net_sales-i").value,
                gross_profit: document.getElementById("gross_profit-i").value,
                total_gross_profit: document.getElementById("total_gross_profit-i").value,
                total_net_sales: document.getElementById("total_net_sales-i").value,
                profit_rate: document.getElementById("profit_rate-i").value
            },
            success: function(response) {
                clearItemInputs();
                $("#source_item_code-i").val('').trigger('change')
                getGrandTotal(pcf_no);
                $('#pcfItem_datatable').DataTable().ajax.reload();
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
            var opex = transfer_price * 1.15 + 0;
        }
        else if (parseInt(currency_rate) !== 1 && cost_of_peripherals !== '') {
            var opex = transfer_price * 1.3 + parseFloat(cost_of_peripherals);
        }
        else if (parseInt(currency_rate) !== 1 && cost_of_peripherals == '') {
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
        document.getElementById("description-i").value,
        document.getElementById("currency_rate-i").value,
        document.getElementById("tp_php-i").value
        document.getElementById("cost_of_peripherals-i").value
        document.getElementById("quantity-i").value,
        document.getElementById("sales-i").value,
        document.getElementById("total_sales-i").value,
        document.getElementById("opex-i").value,
        document.getElementById("net_sales-i").value,
        document.getElementById("gross_profit-i").value,
        document.getElementById("total_gross_profit-i").value,
        document.getElementById("total_net_sales-i").value,
        document.getElementById("profit_rate-i").value
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
                    getGrandTotal()
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
    //scripts for pcfInclusion, starts here;
    $(function() {
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
        getGrandTotal();
    });

    // //start of select2 function -- machine item code;
    // $(function () {
    //     $('#source_item_code-foc').select2({
    //         width: "100%",
    //         allowClear: true,
    //         minimumInputLength: 3,
    //         placeholder: 'Item code',
    //         ajax: {
    //             delay: 250,
    //             url: '{{ route("settings.source.source_search") }}',
    //             dataType: 'json',
    //         },
    //     });
    // });

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

    $("#source_item_code-foc").on('change', function(e) {
        clearFOCInputs();
    });
    //end of select2 function;

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
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('PCF.sub.store_foc') }}",
            method:'POST',
            data: {
                pcf_no: document.getElementById("pcf_no").value,
                rfq_no: document.getElementById("rfq_no").value,
                source_id: document.getElementById("source_item_code-foc").value,
                serial_no: document.getElementById("serial_no-foc").value,
                type: document.getElementById("type-foc").value,
                quantity: document.getElementById("quantity-foc").value,
                opex: document.getElementById("opex-foc").value,
                total_cost: document.getElementById("total_cost-foc").value,
                cost_year: document.getElementById("cost_year-foc").value,
                depreciable_life: document.getElementById("depreciable_life-foc").value,
            },
            success: function(response) {
                clearFOCInputs();
                $("#source_item_code-foc").val('').trigger('change')
                getGrandTotal(pcf_no);
                $('#pcfFOC_dataTable').DataTable().ajax.reload();
                Toast.fire({
                    icon: 'success',
                    title: 'Added',
                    text: 'The product has been added to the current item list.'
                })
            },
            error: function (response) {
                clearFOCInputs();
                Toast.fire({
                    icon: 'error',
                    title: 'Oops! Something went wrong.',
                    text: 'Please contact your system administrator.'
                })
            },
        });
    }

    //FOC Opex Function
    function calculateOpexFOC()
    {
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
        $("#type-foc").val("");
        $("#tp_php-foc").val("");
        $("#cost_of_peripherals-foc").val("");
        $("#opex-foc").val("");
        $("#serial_no-foc").val("N / A");
        $("#quantity-foc").val("");
        $("#cost_year-foc").val("");
        $("#total_cost-foc").val("");
        $("#depreciable_life-foc").val("");
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
                    getGrandTotal();
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

    function getGrandTotal() {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url : "{{ route('PCF.sub.get_grand_total', $pcf_no) }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        }).done(function(response) {
            document.getElementById("annual_profit").value = response.annual_profit;
            document.getElementById("annual_profit_rate").value = response.annual_profit_rate;
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
    </script>
    <script>
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

        $(function() {
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
    </script>
@endsection