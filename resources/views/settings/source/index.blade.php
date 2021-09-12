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
                                        <table class="table table-bordered table-striped" id="source_dataTable" width="100%"
                                            cellspacing="0">
                                            <thead>
                                                <tr bgcolor="gray" class="text-white">
                                                    <th>ID</th>
                                                    <th>Supplier</th>
                                                    <th>Item Code</th>
                                                    <th>Description</th>
                                                    <th>Unit Price</th>
                                                    <th>Currency Rate</th>
                                                    <th>Total Price (Php)</th>
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
        $(function() {
            $('#source_dataTable').DataTable({
                "stripeClasses": [],
                processing: false,
                serverSide: true,
                responsive: true,
                searchable: true,
                ordering: true,
                ajax: {
                    url: "{{ route('settings.source.list') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                columns: [
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
                    { data: 'cost_of_peripherals' },
                    { data: 'actions', orderable: false, searchable: false }
                ],
            });

        });

        let source_id;

        $('#source_dataTable').on('click', '.editSourceDetails', function (e) {
            e.preventDefault();
            source_id = $(this).data('id');
            if (source_id){
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
                    $('#editSourceModal').modal('show');
                    $('#edit_source_id').val(data.id);
                    $('#edit_supplier').val(data.supplier);
                    $('#edit_item_code').val(data.item_code);
                    $('#edit_description').val(data.description);
                    $('#edit_unit_price').val(data.unit_price);
                    $('#edit_currency_rate').val(data.currency_rate);
                    $('#edit_tp_php').val(data.tp_php);
                    $('#edit_item_group').val(data.item_group);
                    $('#edit_uom').val(data.uom);
                    $('#edit_mandatory_peripherals').val(data.mandatory_peripherals);
                    $('#edit_cost_of_peripherals').val(data.cost_of_peripherals);
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    Swal.fire(
                        'Something went wrong!',
                        'Please contact your system administrator!',
                        'error'
                    )
                });
            }
        })

        const element = document.querySelectorAll('#unit_price, #currency_rate, #edit_unit_price, #edit_currency_rate');
        element.forEach(i => {
            i.addEventListener('input', function() {
                calculate();
            });
        });

        function calculate()
        {
            const unit_price = parseFloat(document.getElementById("unit_price").value);
            const currency_rate = parseFloat(document.getElementById("currency_rate").value);
            const edit_unit_price = parseFloat(document.getElementById("edit_unit_price").value);
            const edit_currency_rate = parseFloat(document.getElementById("edit_currency_rate").value);

            const tp_php = document.getElementById("tp_php");
            const edit_tp_php = document.getElementById("edit_tp_php");

            if (!isNaN(unit_price) && !isNaN(currency_rate)) {
                tp_php.value = (unit_price * currency_rate).toFixed(2);
            }
            else if (!isNaN(edit_unit_price) && !isNaN(edit_currency_rate)) {
                edit_tp_php.value = (edit_unit_price * edit_currency_rate).toFixed(2);
            }
            else {
                tp_php.value = '';
                edit_tp_php.value = '';
            }
        }
    </script>

    <script>
        @if (count($errors) > 0)
            $('#editSourceModal').modal('show');
            $('#addSourceModal').modal('show');
        @endif
    </script>
@endsection