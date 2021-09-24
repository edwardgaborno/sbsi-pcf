@extends('layouts.app')
@section('title','PCF - PCF Create Request')

@push('styles')
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
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">PCF Request</h1>
                </div>
                
                @include('PCF.sub.partials.items')
                @include('PCF.sub.partials.foc')
                
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('PCF.store') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <!-- Left Element -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pcf_no">PCF No.</label>
                                            <input type="text" class="form-control" name="pcf_no" id="pcf_no"
                                                value="{{ old('pcf_no', $pcf_no) }}" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date">Date</label>
                                            <input type="date" class="form-control" name="date" id="date"
                                                value="{{ old('item_code') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="institution">Institution</label>
                                            <textarea class="form-control" name="institution" id="institution" cols="5"
                                                rows="3">{{ old('institution') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <textarea class="form-control" name="address" id="address" cols="5"
                                                rows="3">{{ old('address') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="contact_person">Contact Person</label>
                                            <input type="text" class="form-control" name="contact_person" id="contact_person"
                                                value="{{ old('contact_person') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="designation">Designation</label>
                                            <input type="text" class="form-control" name="designation" id="designation"
                                                value="{{ old('designation') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="thru_duration_contract">Thru Designation</label>
                                            <input type="text" class="form-control" name="thru_designation" id="thru_duration_contract"
                                                value="{{ old('thru_duration_contract') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="institution">Supplier/Manufacturer</label>
                                            <input type="text" class="form-control" name="supplier" id="supplier"
                                                value="{{ old('supplier') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="terms">Terms</label>
                                            <input type="text" class="form-control" name="terms" id="terms"
                                                value="{{ old('supplier') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="validity">Validity</label>
                                            <input type="text" class="form-control" name="validity" id="validity"
                                                value="{{ old('validity') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="delivery">Delivery</label>
                                            <input type="text" class="form-control" name="delivery" id="delivery"
                                                value="{{ old('delivery') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="warranty">Warranty (For Machines Only)</label>
                                            <input type="text" class="form-control" name="warranty" id="warranty"
                                                value="{{ old('supplier') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="contract_duration">Duration of Contract</label>
                                            <input type="number" class="form-control" name="contract_duration" id="contract_duration"
                                                value="{{ old('contract_duration') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="date_bidding">Date of Bidding</label>
                                            <input type="date" class="form-control" name="date_bidding" id="date_bidding"
                                                value="{{ old('date_bidding') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="bid_docs_price">Bid Docs Price</label>
                                            <input type="text" class="form-control" name="bid_docs_price" id="bid_docs_price"
                                                value="{{ old('bid_docs_price') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Left Element -->
                                <!-- Right Element -->
                                <div class="row">
                                    {{-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="psr">PSR</label>
                                            <input type="text" class="form-control" name="psr" id="psr"
                                                value="{{ old('psr') }}" required>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="manager">Manager</label>
                                                <select class="form-control" name="manager" id="manager">
                                                    <option value="" selected>Please select Manager</option>
                                                    <option value="Rachelle Anne Carrera">Rachelle Anne Carrera</option>
                                                    <option value="Gloria Cutang">Gloria Cutang</option>
                                                    <option value="Gilbert Gravata">Gilbert Gravata</option>
                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="annual_profit">Annual Profit</label>
                                            <input type="text" class="form-control" name="annual_profit" id="annual_profit"
                                                value="{{ old('annual_profit','0') }}" readonly required> 
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="annual_profit_rate">Annual Profit Rate</label>
                                            <input type="text" class="form-control" name="annual_profit_rate" id="annual_profit_rate"
                                                value="{{ old('annual_profit_rate', '0') }}" readonly required>
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
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
        <!-- Modal Component -->

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
                    { data: 'source.item_code' },
                    { data: 'source.description' },
                    { data: 'quantity' },
                    { data: 'sales' },
                    { data: 'total_sales' },
                    { data: 'action' },
                ],
            });
            getGrandTotal();
        });

        //start of select2 function -- item_code
        $(function () {
            $('#source_item_code-i').select2({
                allowClear: true,
                minimumInputLength: 3,
                placeholder: 'Item code',
                ajax: {
                    url: '{{ route("settings.source.source_search") }}',
                    dataType: 'json',
                },
            });
        });

        $('#source_item_code-i').on('select2:select', function (e) {
            var data = e.params.data;
            var source_id = data.id
            if(source_id) {
                $.ajax({
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/settings.source/get-details/source=' + source_id,
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
                    Swal.fire(
                        'Something went wrong!',
                        'Please contact your system administrator!',
                        'error'
                    )
                    clearItemInputs();
                });
            }
        });

        $( "#source_item_code-i" ).on('change', function(e) {
            clearItemInputs();
            document.getElementById("quantity-i").disabled = true;
            document.getElementById("sales-i").disabled = true;
        });
        //end of select2 function

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
            $("#item_code-i").val("");
            $("#description-i").val("");
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

        //delete item from pcfList table
        let item_id;
        $('#pcfItem_datatable').on('click', '.pcfListDelete', function (e) {
            e.preventDefault();
            item_id = $(this).data('id');
            Swal.fire({
                title: 'Delete this item?',
                text: "This item will be permanently deleted.",
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
                        Swal.fire(
                            'Success!',
                            'The item has been deleted.',
                            'success'
                        )
                        //reload Item List dataTable
                        $('#pcfItem_datatable').DataTable().ajax.reload();
                        getGrandTotal()
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        Swal.fire(
                            'Something went wrong!',
                            'Please contact your system administrator!',
                            'error'
                        )
                    });
                }
            })
        })

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
                    { data: 'action' },
                ],
            });
            getGrandTotal();
        });

        //start of select2 function -- machine item code;
        $(function () {
            $('#source_item_code-foc').select2({
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
                url: '/settings.source/get-details/source=' + source_id,
                contentType: "application/json; charset=utf-8",
                cache: false,
                dataType: 'json',
                }).done(function(data) {
                    $('#description-foc').val(data.description);
                    $("#tp_php-foc").val(data.tp_php);
                    $("#cost_of_peripherals-foc").val(data.cost_of_peripherals);

                    calculateOpexFOC();
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    Swal.fire(
                        'Something went wrong!',
                        'Please contact your system administrator!',
                        'error'
                    )
                    clearFOCInputs();
                });
            }
        });

        $( "#source_item_code-foc" ).on('change', function(e) {
            clearFOCInputs();
        });
        //end of select2 function;

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
                title: 'Delete this item?',
                text: "This item will be permanently deleted.",
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
                        Swal.fire(
                            'Success!',
                            'The item has been deleted.',
                            'success'
                        )
                        //reload Item List dataTable
                        $('#pcfFOC_dataTable').DataTable().ajax.reload();
                        getGrandTotal();
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        Swal.fire(
                            'Something went wrong!',
                            'Please contact your system administrator!',
                            'error'
                        )
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
                $("#annual_profit").val(response.annual_profit);
                $("#annual_profit_rate").val(response.annual_profit_rate);
            }).fail(function(jqXHR, textStatus, errorThrown) {
                Swal.fire(
                    'Something went wrong!',
                    'Please contact your system administrator!',
                    'error'
                )
            });
        }
    </script>

    <script>
        $(function(){
            var dtToday = new Date();
            
            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();
            if(month < 10)
                month = '0' + month.toString();
            if(day < 10)
                day = '0' + day.toString();
            
            var maxDate = year + '-' + month + '-' + day;

            $('#date, #date_bidding').attr('min', maxDate);
        });
    </script>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush