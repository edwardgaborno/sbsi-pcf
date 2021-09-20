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
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">PCF Request</h1>
                </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- DataTales Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    @can('pcf_request_create')
                                        <div class="row">
                                            <div class="col-md-4 offset-md-8">
                                                <a href="{{ route('PCF.create_request') }}"
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
    </script>

    <script> 
        let pcf_request_id;

        $('#pcf_dataTable').on('click', '.editPCFRequest', function (e) {
            e.preventDefault();
            pcf_request_id = $(this).data('id');
            if (pcf_request_id){
                $.ajax({
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/PCF/get/pcf_details=' + pcf_request_id,
                    contentType: "application/json; charset=utf-8",
                    cache: false,
                    dataType: 'json',
                }).done(function(data) {
                    $('#pcf_request_id').val(data.id);
                    $('#pcf_request_id-i').val(data.id); //pcfList pcf_request_id;
                    $('#pcf_request_id-foc').val(data.id); //pcfInclusion pcf_request_id;

                    $('#edit_pcf_no').val(data.pcf_no);
                    $('#edit_pcf_no-i').val(data.pcf_no); //pcfList pcf no;
                    $('#edit_pcf_no-foc').val(data.pcf_no); //pcfInclusion pcf no;

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

                    editItemDataTable(pcf_request_id);
                    editFOCDataTable(pcf_request_id)
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    Swal.fire(
                        'Something went wrong!',
                        'Please contact your system administrator!',
                        'error'
                    )
                });
            }
        });

        //Item List DataTable
        function editItemDataTable(pcf_request_id) {
            $('#edit_pcfItem_dataTable').DataTable({
                "stripeClasses": [],
                destroy: true,
                processing: false,
                serverSide: true,
                responsive: true,
                searchable: true,
                ordering: true,
                ajax: {
                    url : '/PCF/ajax/items-list/' + pcf_request_id,
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
        }

        //start of select2 function -- item_code
        $(function () {
            $('#source_item_code-i').select2({
                dropdownParent: $('#editPCFRequestModal'),
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

        $("#source_item_code-i").on('change', function(e) {
            document.getElementById("quantity-i").disabled = true;
            document.getElementById("sales-i").disabled = true;

            clearItemInputs();
        });
        //end of select2 function

        //on pcfList form submit; ajax
        $('#edit_pcfListForm').on('submit',function(e){
            e.preventDefault();
            let pcf_no = $("#edit_pcf_no-i").val();
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
                    clearItemInputs();
                    Swal.fire(
                        'Success!',
                        'Item added successfully!',
                        'success'
                    );
                    //refresh added items table
                    $('#edit_pcfItem_dataTable').DataTable().ajax.reload();
                    getGrandTotal(pcf_no);
                },
                error: function (response) {
                    clearItemInputs();
                    Swal.fire(
                        'Something went wrong!',
                        'Please contact your system administrator!',
                        'error'
                    );
                },
            });
        }); 

        //delete pcfList Items
        $('#edit_pcfItem_dataTable').on('click', '.pcfListDelete', function (e) {
            e.preventDefault();
            let item_id = $(this).data('id');
            let pcf_no = $("#edit_pcf_no-i").val();
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
                        $('#edit_pcfItem_dataTable').DataTable().ajax.reload();
                        getGrandTotal(pcf_no);
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        Swal.fire(
                            'Something went wrong!',
                            'Please contact your system administrator!',
                            'error'
                        )
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
        function editFOCDataTable(pcf_request_id) {
            $('#edit_pcfFOC_dataTable').DataTable({
                "stripeClasses": [],
                destroy: true,
                processing: false,
                serverSide: true,
                responsive: true,
                searchable: true,
                ordering: true,
                ajax: {
                    url : '/PCF/ajax/inclusions-list/' + pcf_request_id,
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
        }

        //start of select2 function -- machine item code;
        $(function () {
            $('#source_item_code-foc').select2({
                dropdownParent: $('#editPCFRequestModal'),
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

        //foc on form submit; ajax function
        $('#edit_pcfFOCForm').on('submit',function(e){
            e.preventDefault();
            let p_c_f_request_id = $("#pcf_request_id-foc").val();
            let source_id = $("#source_item_code-foc").val();
            let pcf_no = $("#edit_pcf_no-foc").val();
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
                    p_c_f_request_id:pcf_request_id,
                    source_id:source_id,
                    pcf_no:pcf_no, 
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
                    Swal.fire(
                        'Success!',
                        'Item added successfully!',
                        'success'
                    );
                    //referesh FOC data table
                    $('#edit_pcfFOC_dataTable').DataTable().ajax.reload();
                    //get grand totals 
                    getGrandTotal(pcf_no);
                },
                error: function (data) {
                    clearFOCInputs();
                    Swal.fire(
                        'Something went wrong!',
                        'Please contact your system administrator!',
                        'error'
                    );
                },
            });
        });

        //delete machines and inclusions items;
        $('#edit_pcfFOC_dataTable').on('click', '.pcfInclusionDelete', function (e) {
            e.preventDefault();
            let foc_id = $(this).data('id');
            let pcf_no = $("#edit_pcf_no-foc").val();
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
                        $('#edit_pcfFOC_dataTable').DataTable().ajax.reload();
                        getGrandTotal(pcf_no);
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        Swal.fire(
                            'Something went wrong!',
                            'Please contact your system administrator!',
                            'error'
                        )
                    });
                }
            })
        });

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
                $("#edit_annual_profit").val(response.annual_profit);
                $("#edit_annual_profit_rate").val(response.annual_profit_rate);
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
        //Approve PCF Request;
        $('#pcf_dataTable').on('click', '.approvePcfRequest', function (e) {
            e.preventDefault();
            pcf_request_id = $(this).data('id');
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
                    $.ajax({
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '/PCF/ajax/approve-request/' + pcf_request_id,
                        contentType: "application/json; charset=utf-8",
                        cache: false,
                        dataType: 'json',
                    }).done(function(data) {
                        $('#pcf_dataTable').DataTable().ajax.reload();
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        Swal.fire(
                            'Something went wrong!',
                            'Please contact your system administrator!',
                            'error'
                        )
                    });
                }
            });
        });

        //Disapprove PCF Request;
        $('#pcf_dataTable').on('click', '.disapprovePcfRequest', function (e) {
            e.preventDefault();
            pcf_request_id = $(this).data('id');
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
                    $.ajax({
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '/PCF/ajax/disapprove-request/' + pcf_request_id,
                        contentType: "application/json; charset=utf-8",
                        cache: false,
                        dataType: 'json',
                    }).done(function(data) {
                        $('#pcf_dataTable').DataTable().ajax.reload();
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        Swal.fire(
                            'Something went wrong!',
                            'Please contact your system administrator!',
                            'error'
                        )
                    });
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var inputElement = document.querySelector('input[name="upload_file"]');
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
@endsection

@push('scripts')
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush