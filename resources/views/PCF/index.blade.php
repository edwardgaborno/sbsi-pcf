@extends('layouts.app')
@section('title','PCF - PCF Request')

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

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- DataTales Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    @can('psr_request_create')
                                        <div class="row">
                                            <div class="col-md-4 offset-md-8">
                                                <a href="{{ route('PCF.sub.addrequest') }}"
                                                    class="btn btn-primary float-right"><i class="fas fa-plus-circle"></i> New
                                                    Request</a>
                                            </div>
                                        </div>
                                    @endcan
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" id="pcf_dataTable" width="100%"
                                            cellspacing="0">
                                            <thead>
                                                <tr bgcolor="gray" class="text-white">
                                                    <th>PCF No.</th>
                                                    <th>Date</th>
                                                    <th>Institution</th>
                                                    <th>PSR</th>
                                                    <th>Annual Profit</th>
                                                    <th>Annual Profit Rate</th>
                                                    <th style="text-align: center; vertical-align: middle">Actions</th>
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
                    <!-- Content Row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
        <!-- Modal Component -->
        @include('modals.PCFRequest.add')
        @include('modals.PCFRequest.edit')
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
            $('#pcf_dataTable').DataTable({
                "stripeClasses": [],
                processing: false,
                serverSide: true,
                ordering: true,
                ajax: {
                    url: "{{ route('PCF.list') }}",
                },
                columns: [
                    { data: 'pcf_no' },
                    { data: 'date' },
                    { data: 'institution' },
                    { data: 'psr' },
                    { data: 'annual_profit' },
                    { data: 'annual_profit_rate' },
                    { data: 'actions', orderable: false, searchable: false }
                ],
            });
        });
        
        let pcf_id;

        $('#pcf_dataTable').on('click', '.editPCFRequest', function (e) {
            e.preventDefault();
            pcf_id = $(this).data('id');
            if (pcf_id){
                $.ajax({
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/PCF/get/pcf_details=' + pcf_id,
                    contentType: "application/json; charset=utf-8",
                    cache: false,
                    dataType: 'json',
                }).done(function(data) {
                    $('#pcf_request_id').val(data.id);
                    $('#edit_pcf_no').val(data.pcf_no);
                    $('#edit_date').val(data.date);
                    $('#edit_institution').val(data.institution);
                    $('#edit_address').val(data.address);
                    $('#edit_contact_person').val(data.contact_person);
                    $('#edit_designation').val(data.designation);
                    $('#edit_thru_designation').val(data.thru_designation);
                    $('#edit_supplier').val(data.supplier);
                    $('#edit_terms').val(data.terms);
                    $('#edit_validity').val(data.validity);
                    $('#edit_warranty').val(data.warranty);
                    $('#edit_delivery').val(data.delivery);
                    $("#edit_contract_duration").val(data.contract_duration);
                    $('#edit_date_bidding').val(data.date_bidding);
                    $('#edit_bid_docs_price').val(data.bid_docs_price);
                    $('#edit_psr').val(data.psr);
                    $('#edit_manager').val(data.manager);
                    $('#edit_annual_profit').val(data.annual_profit);
                    $('#edit_annual_profit_rate').val(data.annual_profit_rate);
                    $('#editPCFRequestModal').modal('show');
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    Swal.fire(
                        'Something went wrong!',
                        'Please contact your system administrator!',
                        'error'
                    )
                });
            }
        })

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
                            loadAddItemTable(pcf_no); 
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
                            loadAddedFocItemTable(pcf_no); 
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

        function loadAddItemTable(pcf_no) {
            //delete first the table before reinitialize
            $("#addItemDatatable").dataTable().fnDestroy();
            $("#pcf_no_add_item").val(pcf_no);
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

        function loadAddedFocItemTable(pcf_no) {
            //delete first the table before reinitialize
            $("#addFOCdataTable").dataTable().fnDestroy();
            $("#pcf_no_add_item_foc").val(pcf_no);
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
                    { data: 'action' }
                ],
            });

            //reload datatable data 
            table.ajax.reload().draw();
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
                        $("#edit_annual_profit").val(response.annual_profit);
                        $("#edit_annual_profit_rate").val(response.annual_profit_rate);
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
                    url: "{{ route('PCF.sub.store-items') }}",
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
                        loadAddItemTable(pcf_no); 
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
                }else if (target == "COGS"){
                    depreciable_life_foc = 1;
                }

                $.ajax({
                    url: "{{ route('PCF.sub.store-foc') }}",
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
                        loadAddedFocItemTable(pcf_foc); 
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
                        $("#cost_periph_add_item").val(response.cost_periph);
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
                        $("#cost_periph_foc").val(response.cost_periph);
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

        function ApproveRequest(data) {
            Swal.fire({
                title: 'Approve Request',
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
                        url: '/PCF/ajax/approve-request/' + id,
                        headers: {
                            'X-CSRF-Token': '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            //reload table 
                            $("#dataTable").DataTable().ajax.reload(null, false);
                            //fire the alert message
                            Swal.fire(
                                'Success!',
                                'PCF Request has been approved successfully!',
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

        function DisApproveRequest(data) {
            Swal.fire({
                title: 'Disapprove Request',
                text: "Are you sure?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirm'
            }).then((result) => {
                if (result.isConfirmed) {

                    var id = data.data('id');

                    console.log(id);
                    $.ajax({
                        type: 'GET',
                        dataType: 'json',
                        url: '/PCF/ajax/disapprove-request/' + id,
                        headers: {
                            'X-CSRF-Token': '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            //reload table
                            $("#dataTable").DataTable().ajax.reload(null, false);
                            //fire the alert message
                            Swal.fire(
                                'Disapprove Success!',
                                'Request has been disapproved!',
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            FilePond.registerPlugin(FilePondPluginFileValidateType);
            
            var inputElement = document.querySelector('input[name="upload_file"]');
            var store = FilePond.create((inputElement),
            {
                labelIdle: `Drag & Drop document file or <span class="filepond--label-action">Browse</span>`,
                imagePreviewHeight: 170,
            });
            
            store.setOptions({
                allowPdfPreview: true,
                pdfPreviewHeight: 320,
                pdfComponentExtraParams: 'toolbar=0&view=fit&page=1',
                server: {
                    url: "{{ route('store.pcf-document') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
            });
        });
    </script>
@endsection