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
                            <form id="first_table">
                                @csrf
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
                                            {{-- <input type="hidden" class="form-control" name="transfer_price_foc" id="transfer_price_add_item"
                                                value="{{ old('transfer_price_foc') }}" placeholder="transfer price" required>
                                            <input type="hidden" class="form-control" name="mandatory_peripherals_foc" id="mandatory_peripherals_add_item"
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
                            </form>
                        </div>
                    </div>
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
                            <form id="second_table">
                                @csrf
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
                                                value="N/A{{ old('serial_no_foc') }}" required>
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
                                                value="{{ old('pcf_no', $pcf_no) }}" required>
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
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="duration_contract">Duration of Contract</label>
                                            <input type="number" class="form-control" name="duration_contract" id="duration_contract"
                                                value="{{ old('duration_contract') }}" required>
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
        $(document).ready(function() {
            var pcf_no_old = $("#pcf_no").val();
            var pcf_no = $("#pcf_no_add_item").val(pcf_no_old);
            
            $('#addItemDatatable').DataTable({
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
        });

        //FOR FOC Table List
        $(document).ready(function() {
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

        function getTotalSales() {
            var quantity = $("#quantity_add_item").val();
            var sales = $("#sales_add_item").val();
            var  total_sales = sales * quantity;
            $("#total_sales_add_item").val(total_sales.toFixed(2));

            //get opex value
            getOpexValue();

            //get net sales
            getNetSales();

            //get gross profit
            getGrossProfit();

            //get total gross profit
            getTotalGrossProfit();

            //get total net sales
            getTotalNetSales();

            //get profit rate
            getProfitRate();
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

        $("#submit_item").click(function(e){
                e.preventDefault();

                var _token = $('#first_table').find('input[name="_token"]').val();
                var pcf_no = $("#pcf_no_add_item").val();
                var item_code = $("#hidden_item_code").val();
                var description = $("#description_add_item").val();
                var quantity = $("#quantity_add_item").val();
                var sales = $("#sales_add_item").val();
                var total_sales = $("#total_sales_add_item").val();
                var transfer_price = $("#tp_php_add_item").val();
                var mandatory_peripherals = $("#cost_periph_add_item").val();
                var opex = $("#opex_add_item").val();
                var net_sales = $("#net_sales_add_item").val();
                var gross_profit = $("#gross_profit_add_item").val();
                var total_gross_profit = $("#total_gross_profit_add_item").val();
                var total_net_sales = $("#total_net_sales_add_item").val();
                var profit_rate = $("#profit_rate_add_item").val();

                $.ajax({
                    url: "{{ route('PCF.sub.additems') }}",
                    type:'POST',
                    data: {
                        _token:_token, 
                        pcf_no:pcf_no, 
                        item_code:item_code,
                        description:description,
                        quantity:quantity,
                        sales:sales,
                        total_sales:total_sales,
                        transfer_price:transfer_price,
                        mandatory_peripherals:mandatory_peripherals,
                        opex:opex,
                        net_sales:net_sales,
                        gross_profit:gross_profit,
                        total_gross_profit:total_gross_profit,
                        total_net_sales:total_net_sales,
                        profit_rate:profit_rate
                    },
                    success: function(data) {
                        clearInputs();
                        Swal.fire(
                            'Success!',
                            'Item added successfully!',
                            'success'
                        );
                        
                        //refresh added items table
                        refreshAddedItemsTable(); 
                        //get grand totals
                        getGrandTotals(pcf_no);

                    },
                    error: function (data) {
                        clearInputs();
                        Swal.fire(
                            'Something went wrong!',
                            'Please contact your system administrator!',
                            'error'
                        );
                    },
                });
        }); 

        //FOC Add Item Button Click
        $("#submit_foc").click(function(e){
                e.preventDefault();

                var _token = $('#second_table').find('input[name="_token"]').val();
                var pcf_foc = $("#pcf_no_add_item_foc").val();
                var item_code_foc = $("#hidden_item_code_foc").val();
                var description_foc = $("#item_description_foc").val();
                var quantity_foc = $("#qty_foc").val();
                var serial_no_foc = $("#serial_no_foc").val();
                var type_foc = $("#type_foc").val();
                var mandatory_peripherals_foc = $("#cost_periph_foc").val();
                var opex_foc = $("#opx_foc").val();
                var total_cost_foc = $("#total_cost_foc").val();
                var cost_year_foc = $("#cost_year_foc").val();
                var depreciable_life_foc = 0;

                var target = $("#type_foc").val();

                if (target == "MACHINE"){
                    depreciable_life_foc = 5;
                } else if (target == "COGS"){
                    depreciable_life_foc = 1;
                }

                $.ajax({
                    url: "{{ route('PCF.sub.addfoc') }}",
                    type:'POST',
                    data: {
                        _token:_token, 
                        pcf_foc:pcf_foc, 
                        item_code_foc:item_code_foc,
                        description_foc:description_foc,
                        quantity_foc:quantity_foc,
                        serial_no_foc:serial_no_foc,
                        type_foc:type_foc,
                        mandatory_peripherals_foc:mandatory_peripherals_foc,
                        opex_foc:opex_foc,
                        total_cost_foc:total_cost_foc,
                        depreciable_life_foc:depreciable_life_foc,
                        cost_year_foc:cost_year_foc
                    },
                    success: function(data) {
                        clearInputs();
                        Swal.fire(
                            'Success!',
                            'Item added successfully!',
                            'success'
                        );
                        //referesh FOC data table
                        refreshAddedFOCTable(); 
                        //get grand totals 
                        getGrandTotals(pcf_foc);

                    },
                    error: function (data) {
                        clearInputs();
                        Swal.fire(
                            'Something went wrong!',
                            'Please contact your system administrator!',
                            'error'
                        );
                    },
                });
        });

        function clearInputs() {
            $("#item_code_add_item").val("");
            $("#hidden_item_code").val("");
            $("#description_add_item").val("");
            $("#rate_add_item").val("");
            $("#tp_php_add_item").val("");
            $("#cost_periph_add_item").val("");
            $("#quantity_add_item").val("");
            $("#sales_add_item").val("");
            $("#total_sales_add_item").val("");
            $("#opex_add_item").val("");
            $("#net_sales_add_item").val("");
            $("#gross_profit_add_item").val("");
            $("#total_gross_profit_add_item").val("");
            $("#total_net_sales_add_item").val("");
            $("#profit_rate_add_item").val("");
            $("#item_code_foc").val("");
            $("#hidden_item_code_foc").val("");
            $("#item_description_foc").val("");
            $("#rate_foc").val("");
            $("#tp_php_foc").val("");
            $("#cost_periph_foc").val("");
            $("#serial_no_foc").val("");
            $("#type_foc").val("");
            $("#qty_foc").val("");
            $("#opx_foc").val("");
            $("#total_cost_foc").val("");
            $("#cost_year_foc").val("");
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

        //Get description on combobox selected index changed
        $("#item_code_add_item").on('change', function(){
            var item_code = $(this).val();
            if (item_code){
                $.ajax({
                    type: 'GET',
                    dataType: 'json',
                    url: '/PCF.sub/ajax/get-descriptions/' + item_code,
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        $("#hidden_item_code").val(response.item_code);
                        $("#description_add_item").val(response.description);
                        $("#rate_add_item").val(response.currency_rate);
                        $("#tp_php_add_item").val(response.tp_php);
                        $("#cost_periph_add_item").val(response.cost_of_peripherals);
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
                $("#hidden_item_code").val("");
                $("#description_add_item").val("");
                $("#rate_add_item").val("");
                $("#tp_php_add_item").val("");
                $("#cost_periph_add_item").val("");
            }
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

        //Get the computation for FOC items
        function getComputationFOC() {
            var quantity = $("#qty_foc").val();
            var opx = ($("#tp_php_foc").val() * 1.3) + parseInt($("#cost_periph_foc").val());
            var total_cost = opx * quantity;
            var dep_life = 0;

            var target = $("#type_foc").val();

            if (target == "MACHINE"){
                dep_life = 5;
            }else if (target == "COGS"){
                dep_life = 1;
            }
            
            var cost_year = total_cost / dep_life;
            $("#opx_foc").val(opx.toFixed(2));
            $("#total_cost_foc").val(total_cost.toFixed(2));
            $("#cost_year_foc").val(cost_year.toFixed(2));

        }
        
        function getOpexValue() {
            var currency_rate = $("#rate_add_item").val();
            var transfer_price = $("#tp_php_add_item").val();
            var cost_periph = $("#cost_periph_add_item").val();
            
            if (parseInt(currency_rate) == 1) {
                var opex = transfer_price * 1.15 + parseInt(cost_periph);
            } else {
                var opex = transfer_price * 1.3 + parseInt(cost_periph);
            }

            $("#opex_add_item").val(opex.toFixed(2));
        }

        function getNetSales() {
            var sales = $("#sales_add_item").val();
            var net_sales = sales/1.12;

            $("#net_sales_add_item").val(net_sales.toFixed(2));
        }

        function getGrossProfit() {
            var net_sales = $("#net_sales_add_item").val();
            var opex = $("#opex_add_item").val();
            var cost_periph = $("#cost_periph_add_item").val();

            var gross_profit = net_sales - opex;
            $("#gross_profit_add_item").val(gross_profit.toFixed(2));
        }

        function getTotalGrossProfit() {
            var gross_profit = $("#gross_profit_add_item").val();
            var quantity = $("#quantity_add_item").val();
            
            var total_gross_profit = gross_profit * quantity;

            $("#total_gross_profit_add_item").val(total_gross_profit.toFixed(2));
        }

        function getTotalNetSales() {
            var total_sales = $("#total_sales_add_item").val();

            var total_net_sales = total_sales / 1.12;

            $("#total_net_sales_add_item").val(total_net_sales.toFixed(2));
        }

        function getProfitRate() {
            var gross_profit = $("#gross_profit_add_item").val();
            var sales = $("#sales_add_item").val();

            var profit_rate = (gross_profit / sales) * 100;

            $("#profit_rate_add_item").val(profit_rate.toFixed(0));
        }

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