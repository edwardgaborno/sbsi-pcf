@extends('layouts.app')
@section('title','PCF - Source List')

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
                    <h1 class="h3 mb-0 text-gray-800">Source List</h1>
                </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- DataTales Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <div class="row">
                                        @can('source_create')
                                        <div class="col-md-4 offset-md-8">
                                            <a href="{{ route('settings.source.create') }}" class="btn btn-primary float-right"><i class="fas fa-plus-circle"></i> Add New Source</a>
                                        </div>
                                        @endcan
                                    </div>
                                </div>
                            @if(auth()->user()->hasRole('Administrator') || auth()->user()->hasRole('Super Administrator') || auth()->user()->hasRole('Accounting'))
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="supplier_filter">Filtered By:</label>
                                                <select class="form-control select2 @error('supplier') is-invalid @enderror" name="supplier" id="supplier_filter" required>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped dt-responsive" id="source_dataTable" width="100%"
                                            cellspacing="0">
                                            <thead>
                                                <tr class="thead-dark">
                                                    <th>ID</th>
                                                    <th>Supplier</th>
                                                    <th>Item Code</th>
                                                    <th>Description</th>
                                                    <th>Unit Price</th>
                                                    <th>Currency Rate</th>
                                                    <th>Total Price (Php)</th>
                                                    <th>UOM</th>
                                                    <th>Mandatory Peripherals</th>
                                                    <th>Cost Of Peripherals</th>
                                                    <th>Segment</th>
                                                    <th>Item Category</th>
                                                    <th>Standard Price</th>
                                                    <th>Profitability</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                            @if(auth()->user()->hasRole('PSR') || auth()->user()->hasRole('Marketing'))
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover dt-responsive" id="psrSource_dataTable" width="100%"
                                            cellspacing="0">
                                            <thead>
                                                <tr class="thead-dark">
                                                    <th>Supplier</th>
                                                    <th>Item Code</th>
                                                    <th>Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                            </div>
                        </div>
                    </div>
                    <!-- Content Row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
        <!-- Modal Component -->
        @include('modals.source.edit')
        @include('modals.mandatory_peripherals.index')
        <!-- End of Modal Component -->
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
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            showCloseButton: true,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        $("#supplier_filter").on('change', function () {
            var supplier_id = $(this).val();
            if (supplier_id) {
                $('#source_dataTable').DataTable().clear().destroy();
                $('#source_dataTable').DataTable({
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
                        { data: 'id' },
                        { data: 'supplier' },
                        { data: 'item_code' },
                        { data: 'description' },
                        { data: 'unit_price' },
                        { data: 'currency_rate' },
                        { data: 'tp_php' },
                        { data: 'uom' },
                        { data: 'mandatory_peripherals' },
                        { data: 'cost_of_peripherals' },
                        { data: 'segment' },
                        { data: 'item_category' },
                        { data: 'standard_price' },
                        { data: 'profitability' },
                        { data: 'actions', orderable: false, searchable: false }
                    ],
                });
            } else {
                $('#source_dataTable').DataTable().clear().destroy();
                $('#source_dataTable').DataTable({
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
                        { data: 'id' },
                        { data: 'supplier' },
                        { data: 'item_code' },
                        { data: 'description' },
                        { data: 'unit_price' },
                        { data: 'currency_rate' },
                        { data: 'tp_php' },
                        { data: 'uom' },
                        { data: 'mandatory_peripherals' },
                        { data: 'cost_of_peripherals' },
                        { data: 'segment' },
                        { data: 'item_category' },
                        { data: 'standard_price' },
                        { data: 'profitability' },
                        { data: 'actions', orderable: false, searchable: false }
                    ],
                });
            }
        });

        $("#source_dataTable").on('click', '.view-mp-details', function (e) {
            e.preventDefault();
            var mp_ids = $(this).data('mp_ids');
            $('#mandatory_peripherals_datatable').DataTable().clear().destroy();
            $('#mandatory_peripherals_datatable').DataTable({
                "stripeClasses": [],
                processing: true,
                serverSide: true,
                responsive: true,
                ordering: true,
                ajax: {
                    headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/settings.source/ajax/view-source-mandatory-peripherals/' + mp_ids,
                },
                columns: [
                    { data: 'item_code' },
                    { data: 'item_description' },
                    { data: 'quantity' },
                    { data: 'item_category' },
                ],
            });
        });

        $(function() {
            $('#psrSource_dataTable').DataTable({
                "stripeClasses": [],
                processing: true,
                serverSide: true,
                responsive: true,
                searchable: true,
                ordering: true,
                ajax: {
                    url: "{{ route('settings.source.psr_list') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                columns: [
                    { data: 'supplier' },
                    { data: 'item_code' },
                    { data: 'description' },
                ],
            });
        });

        $(function() {
            $('#source_dataTable').DataTable({
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
                    { data: 'id' },
                    { data: 'supplier' },
                    { data: 'item_code' },
                    { data: 'description' },
                    { data: 'unit_price' },
                    { data: 'currency_rate' },
                    { data: 'tp_php' },
                    { data: 'uom' },
                    { data: 'mandatory_peripherals' },
                    { data: 'cost_of_peripherals' },
                    { data: 'segment' },
                    { data: 'item_category' },
                    { data: 'standard_price' },
                    { data: 'profitability' },
                    { data: 'actions', orderable: false, searchable: false }
                ],
            });
        });

        let source_id;

        $('#source_dataTable').on('click', '.editSourceDetails', function (e) {
            e.preventDefault();
            source_id = $(this).data('id');
            let unit_price = '';
            let tp_php = '';
            let tp_php_less_tax = '';
            let cost_of_peripherals = '';
            let standard_price = '';
            if (source_id){
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
                    var unit_price = data.unit_price.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    var tp_php = data.tp_php.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    var tp_php_less_tax = data.tp_php_less_tax.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    if (data.cost_of_peripherals) {
                        var cost_of_peripherals = data.cost_of_peripherals.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                    var standard_price = data.standard_price.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    $('#editSourceModal').modal('show');
                    $('#edit_source_id').val(data.id);
                    $('#edit_supplier').val(data.supplier_id).select2({
                        width: "100%",
                        allowClear: true,
                        placeholder: 'Supplier',
                    });
                    $('#edit_uom [value='+data.uom_id+']').prop('selected', true);
                    $('#edit_item_code').val(data.item_code);
                    $('#edit_description').val(data.description);
                    $('#edit_unit_price').val(unit_price);
                    $('#edit_currency_rate').val(data.currency_rate);
                    $('#edit_tp_php').val(tp_php);
                    $('#edit_tp_php_less_tax').val(tp_php_less_tax);
                    // $('#edit_mandatory_peripherals').multiSelect('select', data.mandatory_peripherals);
                    $('#edit_mandatory_peripherals').val(data.mandatory_peripherals_ids).select2({
                        width: "100%",
                        multiple:true,
                        allowClear: true,
                    });
                    $('#edit_cost_of_peripherals').val(cost_of_peripherals);
                    $('#edit_segment [value='+data.segment_id+']').prop('selected', true);
                    $('#edit_item_category [value='+data.item_category_id+']').prop('selected', true);
                    $('#edit_standard_price').val(standard_price);
                    $('#edit_profitability').val(data.profitability);
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Oops! Something went wrong.',
                        text: 'Please contact your system administrator.'
                    })
                });
            }
        })

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
                    $("#edit_mandatory_peripherals").select2({
                        data: data,
                        width: "100%",
                        multiple:true,
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

        const edit_element = document.querySelectorAll('#edit_unit_price, #edit_currency_rate, #edit_cost_of_peripherals');
        edit_element.forEach(j => {
            j.addEventListener('input', function() {
                editCalculateTP();
                editCalculateStandardPrice();
            });
        });

        $("#edit_item_category").change(function(){
            editCalculateStandardPrice();
            document.getElementById("edit_item_category").value !== "MACHINE"
                ? document.getElementById("edit_profitability").value = "50%"
                : document.getElementById("edit_profitability").value = "30%"
        });

        function editCalculateTP()
        {
            const unit_price = parseFloat(document.getElementById("edit_unit_price").value.replace(/,/g, ''));
            const currency_rate = parseFloat(document.getElementById("edit_currency_rate").value.replace(/,/g, ''));

            if (!isNaN(unit_price) && !isNaN(currency_rate)) {
                document.getElementById("edit_tp_php").value = (unit_price * currency_rate).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); 
            } else {
                document.getElementById("edit_tp_php").value = '';
            }
        }

        function editCalculateStandardPrice()
        {
            const currency_rate = parseFloat(document.getElementById("edit_currency_rate").value.replace(/,/g, ''));
            const tp_php = parseFloat(document.getElementById("edit_tp_php").value.replace(/,/g, ''));
            const cost_of_peripherals = parseFloat(document.getElementById("edit_cost_of_peripherals").value.replace(/,/g, ''));
            const item_category = document.getElementById("edit_item_category").value;
            const standard_price = document.getElementById("edit_standard_price");

            if (currency_rate === 1) {
                if (!isNaN(cost_of_peripherals) && item_category === "MACHINE") {
                    standard_price.value = ((((tp_php * 1.15) + cost_of_peripherals) / (1 - 0.3)) * 1.12).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); 
                }
                else if (isNaN(cost_of_peripherals) && item_category === "MACHINE") {
                    standard_price.value = ((((tp_php * 1.15) + 0) / (1 - 0.3)) * 1.12).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); 
                }
                else if (!isNaN(cost_of_peripherals) && item_category !== "MACHINE") {
                    standard_price.value = ((((tp_php * 1.15) + cost_of_peripherals) / (1 - 0.5)) * 1.12).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); 
                }
                else if (isNaN(cost_of_peripherals) && item_category !== "MACHINE") {
                    standard_price.value = ((((tp_php * 1.15) + 0) / (1 - 0.5)) * 1.12).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); 
                }
            }
            else {
                if (!isNaN(cost_of_peripherals) && item_category === "MACHINE") {
                    standard_price.value = ((((tp_php * 1.3) + cost_of_peripherals) / (1 - 0.3)) * 1.12).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); 
                }
                else if (isNaN(cost_of_peripherals) && item_category === "MACHINE") {
                    standard_price.value = ((((tp_php * 1.3) + 0) / (1 - 0.3)) * 1.12).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); 
                }
                else if (!isNaN(cost_of_peripherals) && item_category !== "MACHINE") {
                    standard_price.value = ((((tp_php * 1.3) + cost_of_peripherals) / (1 - 0.5)) * 1.12).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); 
                }
                else if (isNaN(cost_of_peripherals) && item_category !== "MACHINE") {
                    standard_price.value = ((((tp_php * 1.3) + 0) / (1 - 0.5)) * 1.12).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); 
                }
            }
        }

        $('#edit_unit_price').keyup(function(event) {

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

        $('#edit_currency_rate').keyup(function(event) {

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

        $('#edit_cost_of_peripherals').keyup(function(event) {

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

    <script>
        @if (count($errors) > 0)
            $('#editSourceModal').modal('show');
        @endif
    </script>
@endsection