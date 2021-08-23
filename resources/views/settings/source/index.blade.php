@extends('layouts.app')
@section('title','PCF - Source List')

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
                    <h1 class="h3 mb-0 text-gray-800">Source List</h1>
                </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- DataTales Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <div class="row">
                                        <div class="col-md-4 offset-md-8">
                                            <a href="#" data-toggle="modal" data-target="#addSourceModal"
                                                class="btn btn-primary float-right"><i class="fas fa-plus-circle"></i> New
                                                Source</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" id="dataTable" width="100%"
                                            cellspacing="0">
                                            <thead>
                                                <tr bgcolor="gray" class="text-white">
                                                    <th>ID</th>
                                                    <th>Supplier</th>
                                                    <th>Item Code</th>
                                                    <th>Description</th>
                                                    <th>Unit Price</th>
                                                    <th>Currency Rate</th>
                                                    <th>Total Price pHp</th>
                                                    <th>Item Group</th>
                                                    <th>UOM</th>
                                                    <th>Mandatory Peripherals</th>
                                                    <th>Cost Of Peripherals</th>
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
                    </div>
                    <!-- Content Row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
        <!-- Modal Component -->
        @include('modals.source.add')
        @include('modals.source.edit')
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
            $('#dataTable').DataTable({
                "stripeClasses": [],
                processing: false,
                serverSide: true,
                ordering: true,
                ajax: {
                    "url": '{!! route('settings.source.list') !!}'
                },
                "columns": [
                    { data: 'id' },
                    { data: 'supplier' },
                    { data: 'item_code' },
                    { data: 'description' },
                    { data: 'unit_price' },
                    { data: 'currency_rate' },
                    { data: 'tp_php' },
                    { data: 'item_group' },
                    { data: 'uom' },
                    { data: 'mandatory_peripherals' },
                    { data: 'cost_periph' },
                    { data: 'actions' }
                ],
            });

        });

        function editSource(data) {
            var edit_id = data.data('id');
            var edit_supplier = data.data('supplier');
            var edit_item_code = data.data('item_code');
            var edit_description = data.data('description');
            var edit_unit_price = data.data('unit_price');
            var edit_currency_rate = data.data('currency_rate');
            var edit_tp_php = data.data('tp_php');
            var edit_item_group = data.data('item_group');
            var edit_uom = data.data('uom');
            var edit_mandatory_peripherals = data.data('mandatory_peripherals');
            var edit_cost_periph = data.data('cost_periph');

            $("#edit_id").val(edit_id);
            $("#edit_supplier").val(edit_supplier);
            $("#edit_item_code").val(edit_item_code);
            $("#edit_description").val(edit_description);
            $("#edit_unit_price").val(edit_unit_price);
            $("#edit_currency_rate").val(edit_currency_rate);
            $("#edit_tp_php").val(edit_tp_php);
            $("#edit_item_group").val(edit_item_group);
            $("#edit_uom").val(edit_uom);
            $("#edit_mandatory_peripherals").val(edit_mandatory_peripherals);
            $("#edit_cost_periph").val(edit_cost_periph);
        }

        function getTotalPrice() {
            var unit_price = $("#unit_price").val();
            var currency_rate = $("#currency_rate").val();
            // var total_price = $("#tp_php").val();
           var  total_price = unit_price * currency_rate;
           $("#tp_php").val(total_price);
        }

        function getTotalPriceEdit() {
            var unit_price = $("#edit_unit_price").val();
            var currency_rate = $("#edit_currency_rate").val();
            // var total_price = $("#tp_php").val();
           var  total_price = unit_price * currency_rate;
           $("#edit_tp_php").val(total_price);
        }

        function formatNumber (num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
        }
    </script>
@endsection