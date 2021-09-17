@extends('layouts.app')
@section('title','PCF - PCF Add Request')

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
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <h1 class="h5 mb-0 text-gray-800">ITEM LIST</h1>
                        </div>
                    </div>
                </div>
                <div class="card shadow mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <form id="first_table" action="{{ route('PCF.sub.store-items') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="test_name_id">Test Code</label>
                                            <input type="hidden" class="form-control" name="pcf_no" id="pcf_no_add_item"> <!-- pcf no -->
                                            
                                            <select name="source_id" id="source_item_code-i" class="form-control select2"></select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="description">Item Description</label>
                                            <input type="text" class="form-control" name="description" id="description-i"
                                                placeholder="source description" readonly required>

                                            <input type="hidden" class="form-control" name="currency_rate" id="currency_rate-i"
                                                placeholder="currency rate" >
                                            <input type="hidden" class="form-control" name="tp_php" id="tp_php-i"
                                                placeholder="trasfer price">    
                                            <input type="hidden" class="form-control" name="cost_of_peripherals" id="cost_of_peripherals-i"
                                                placeholder="cost peripherals">

                                            {{-- <input type="hidden" class="form-control" name="transfer_price_foc" id="transfer_price_add_item"
                                                placeholder="transfer price">
                                            <input type="hidden" class="form-control" name="mandatory_peripherals" id="mandatory_peripherals_add_item"
                                                placeholder="mandatory peripherals"> --}}

                                            <input type="hidden" class="form-control" name="opex" id="opex-i"
                                                placeholder="opex">
                                            <input type="hidden" class="form-control" name="net_sales" id="net_sales-i"
                                                placeholder="net sales">
                                            <input type="hidden" class="form-control" name="gross_profit" id="gross_profit-i"
                                                placeholder="gross profit">
                                            <input type="hidden" class="form-control" name="total_gross_profit" id="total_gross_profit-i"
                                                placeholder="total gross profit">
                                            <input type="hidden" class="form-control" name="total_net_sales" id="total_net_sales-i"
                                                placeholder="total net sales">
                                            <input type="hidden" class="form-control" name="profit_rate" id="profit_rate-i"
                                                placeholder="profit rate">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="quantity_add_item">Quantity (Per Year)</label>
                                            <input type="number" class="form-control" name="quantity" id="quantity-i"
                                                value="{{ old('quantity') }}" required disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="sales_add_item">Sales</label>
                                            <input type="number" class="form-control" name="sales" id="sales-i"
                                                value="{{ old('sales') }}" required disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="total_sales_add_item">Total Sales</label>
                                            <input type="text" class="form-control" name="total_sales" id="total_sales-i"
                                                value="{{ old('total_sales') }}" readonly required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="submit_item"></label>
                                                <button type="submit" class="btn btn-primary form-control btn-submit" id="submit_item">
                                                    <i class="fas fa-plus-circle"></i> Add Item</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="pcfItem_datatable" width="100%"
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <h1 class="h5 mb-0 text-gray-800">MACHINES AND INCLUSIONS (FOC REAGENTS, LIS CONNECTIVITY, INTERFACE, OTHER ITEMS)</h1>
                        </div>
                    </div>
                </div>
                <div class="card shadow mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <form id="second_table" action="{{ route('PCF.sub.store-foc') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="test_name_id">Item Code</label>
                                            <input type="hidden" class="form-control" name="pcf_no" id="pcf_no_add_item_foc"> <!-- pcf no -->  
                                            
                                            <select name="source_id" id="source_item_code-foc" class="form-control select2"></select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="item_description_foc">Item Description</label>
                                            <input type="text" class="form-control" name="description" id="description-foc"
                                                value="{{ old('item_description_foc') }}" readonly required>

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
                                                value="N/A{{ old('serial_no-foc') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="type_foc">Type</label>
                                            <select class="form-control" name="type" id="type-foc">
                                                <option value="MACHINE">MACHINE</option>
                                                <option value="COGS" selected>COGS</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="quantity-foc">Quantity</label>
                                            <input type="number" class="form-control" name="quantity" id="quantity-foc"
                                                value="{{ old('quantity-foc') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="submit"></label>
                                                <button type="submit" class="btn btn-primary form-control btn-submit" id="submit">
                                                    <i class="fas fa-plus-circle"></i> Add Item</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('PCF.add') }}" method="post">
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
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="institution">Institution</label>
                                            <textarea class="form-control" name="institution" id="institution" cols="5"
                                                rows="3">{{ old('institution') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <textarea class="form-control" name="address" id="address" cols="5"
                                                rows="3">{{ old('address') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="contact_person">Contact Person</label>
                                            <input type="text" class="form-control" name="contact_person" id="contact_person"
                                                value="{{ old('contact_person') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="designation">Designation</label>
                                            <input type="text" class="form-control" name="designation" id="designation"
                                                value="{{ old('designation') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="thru_duration_contract">Thru Designation</label>
                                            <input type="text" class="form-control" name="thru_designation" id="thru_duration_contract"
                                                value="{{ old('thru_duration_contract') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="institution">Supplier/Manufacturer</label>
                                            <input type="text" class="form-control" name="supplier" id="supplier"
                                                value="{{ old('supplier') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
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
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="delivery">Delivery</label>
                                            <input type="text" class="form-control" name="delivery" id="delivery"
                                                value="{{ old('delivery') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="warranty">Warranty (For Machines Only)</label>
                                            <input type="text" class="form-control" name="warranty" id="warranty"
                                                value="{{ old('supplier') }}" required>
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
        $(function() {
            var pcf_no_old = $("#pcf_no").val();
            var pcf_no = $("#pcf_no_add_item").val(pcf_no_old);

            $('#pcfItem_datatable').DataTable({
                "stripeClasses": [],
                processing: false,
                serverSide: true,
                resposive: true,
                searchable: true,
                ordering: true,
                ajax: {
                    url : '/PCF.sub/ajax/list/',
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                columns: [
                    { data: 'source.item_code' },
                    { data: 'description' },
                    { data: 'quantity' },
                    { data: 'sales' },
                    { data: 'total_sales' },
                    { data: 'action' },
                ],
            });
        });

        //start of select2 function -- item_code
        $(function () {
            $('#source_item_code-i').select2({
                allowClear: true,
                minimumInputLength: 3,
                placeholder: 'Item code',
                ajax: {
                    url: '{{ route("PCF.sub.source-search") }}',
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
                url: '/settings.source/get/source=' + source_id,
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

        function calculateTotalSales() {
            var quantity = $("#quantity-i").val();
            var sales = $("#sales-i").val();
            var  total_sales = sales * quantity;
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
    
    </script>
    <script>
        $(function() {
            var pcf_no_old = $("#pcf_no").val();
            var pcf_no = $("#pcf_no_add_item_foc").val(pcf_no_old);

            $('#addFOCdataTable').DataTable({
                "stripeClasses": [],
                processing: false,
                serverSide: true,
                ordering: true,
                ajax: {
                    // "url": '{!! route('PCF.sub.list') !!}',
                    url : '/PCF.sub/ajax/foc-list/' + pcf_no,
                    data : function(data){
                        return data;
                    }
                },
                "columns": [
                    { data: 'item_code' },
                    { data: 'description' },
                    { data: 'serial_no' },
                    { data: 'type' },
                    { data: 'quantity' },
                    { data: 'action' },
                ],
            });
        });

        //start of select2 function -- machine item code;
        $(function () {
            $('#source_item_code-foc').select2({
                allowClear: true,
                minimumInputLength: 3,
                placeholder: 'Item code',
                ajax: {
                    url: '{{ route("PCF.sub.source-search") }}',
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
                url: '/settings.source/get/source=' + source_id,
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
                    clearItemInputs();
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
            $("#serial_no-foc").val("");
            $("#quantity-foc").val("");
            $("#cost_year-foc").val("");
            $("#total_cost-foc").val("");
            $("#depreciable_life-foc").val("");
        }

        function getGrandTotals(pcf_no){
            if (pcf_no){
                $.ajax({
                    type: 'GET',
                    dataType: 'json',
                    url: '/PCF.sub/ajax/get-grand-totals/' + pcf_no,
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        console.log(response);
                        $("#annual_profit").val(response.annual_profit);
                        $("#annual_profit_rate").val(response.annual_profit_rate);
                    },
                    error: function(response) {
                        Swal.fire(
                            'Something went wrong!',
                            'Please contact your system administrator!',
                            'error'
                        )
                    }
                });
            } else {
                $("#annual_profit").val("0");
                $("#annual_profit_rate").val("0");
            }
        }

        function refreshAddedItemsTable() {
            //delete first the table before reinitialize
            $("#addItemDatatable").dataTable().fnDestroy();
            var pcf_no = $("#pcf_no_add_item").val();
            var table = $('#addItemDatatable').DataTable({
                "stripeClasses": [],
                processing: false,
                serverSide: true,
                ordering: true,
                ajax: {
                    // "url": '{!! route('PCF.sub.list') !!}',
                    url : '/PCF.sub/ajax/list/'+pcf_no,
                    data : function(data){
                        return data;
                    }
                },
                "columns": [
                    { data: 'item_code' },
                    { data: 'description' },
                    { data: 'quantity' },
                    { data: 'sales' },
                    { data: 'total_sales' },
                    { data: 'action' },
                ],
            });
            //reload datatable data 
            table.ajax.reload().draw();
        }

        //FOC Refresh Tble After Add Item
        function refreshAddedFOCTable() {
            //delete first the table before reinitialize
            $("#addFOCdataTable").dataTable().fnDestroy();
            var pcf_no = $("#pcf_no_add_item_foc").val();
            var table = $('#addFOCdataTable').DataTable({
                            "stripeClasses": [],
                            processing: false,
                            serverSide: true,
                            ordering: true,
                            ajax: {
                                // "url": '{!! route('PCF.sub.list') !!}',
                                url : '/PCF.sub/ajax/foc-list/'+pcf_no,
                                data : function(data){
                                    return data;
                                }
                            },
                            "columns": [
                                { data: 'item_code' },
                                { data: 'description' },
                                { data: 'serial_no' },
                                { data: 'type' },
                                { data: 'quantity' },
                                { data: 'action' },
                            ],
                        });
            //reload datatable data 
            table.ajax.reload().draw();
        }

        //Format no
        // function formatNumber (num) {
        //     return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
        // }
       
       //Get PCF_No for reference
        $('#pcf_no').keyup(function() {
            $('#pcf_no_add_item').val($(this).val());
        });

        //Get PCF_No for reference
        $('#pcf_no_foc').keyup(function() {
            $('#pcf_no_add_item_foc').val($(this).val());
        });

        //Get description on combobox selected index changed for FOC
        $("#item_code_foc").on('change', function(){
            var item_foc_id = $(this).val();
            if (item_foc_id){
                $.ajax({
                    type: 'GET',
                    dataType: 'json',
                    url: '/PCF.sub/ajax/get-description/' + item_foc_id,
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        $("#hidden_item_code_foc").val(response.item_code);
                        $("#item_description_foc").val(response.description);
                        $("#rate_foc").val(response.currency_rate);
                        $("#tp_php_foc").val(response.tp_php);
                        $("#cost_periph_foc").val(response.cost_of_peripherals);
                    },
                    error: function(response) {
                        Swal.fire(
                            'Something went wrong!',
                            'Please contact your system administrator!',
                            'error'
                        )
                    }
                });
            } else {
                $("#hidden_item_code_foc").val("");
                $("#item_description_foc").val("");
                $("#rate_foc").val("");
                $("#tp_php_foc").val("");
                $("#cost_periph_foc").val("");
            }
        });


        function removeAddedItem(data) {
            var pcf_no = $("#pcf_no_add_item").val();
            Swal.fire({
                title: 'Remove Added Item',
                text: "Are you sure?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirm'
            }).then((result) => {
                if (result.isConfirmed) {

                    var id = data.data('id');

                    $.ajax({
                        type: 'GET',
                        dataType: 'json',
                        url: '/PCF.sub/ajax/remove-added-item/' + id,
                        headers: {
                            'X-CSRF-Token': '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            //reload table 
                            refreshAddedItemsTable(); 
                            getGrandTotals(pcf_no);
                            //fire the alert message
                            Swal.fire(
                                'Success!',
                                'Added item has been removed successfully!',
                                'success'
                            )
                        },
                        error: function(response) {
                            Swal.fire(
                                'Something went wrong!',
                                'Please contact your system administrator!',
                                'error'
                            )
                        }
                    });
                }
            })
        }

        function removeAddedInclusion(data) {
            var pcf_no = $("#pcf_no_add_item_foc").val();
            Swal.fire({
                title: 'Remove Added Inclusion',
                text: "Are you sure?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirm'
            }).then((result) => {
                if (result.isConfirmed) {

                    var id = data.data('id');

                    $.ajax({
                        type: 'GET',
                        dataType: 'json',
                        url: '/PCF.sub/ajax/remove-added-inclusion/' + id,
                        headers: {
                            'X-CSRF-Token': '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            //reload table 
                            refreshAddedFOCTable(); 
                            getGrandTotals(pcf_no);
                            //fire the alert message
                            Swal.fire(
                                'Success!',
                                'Inclusion has been removed successfully!',
                                'success'
                            )
                        },
                        error: function(response) {
                            Swal.fire(
                                'Something went wrong!',
                                'Please contact your system administrator!',
                                'error'
                            )
                        }
                    });
                }
            })
        }
    </script>
@endsection