@extends('layouts.app')
@section('title', 'PCF - Mandatory Peripheral List')

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
                        <h1 class="h3 mb-0 text-gray-800">Mandatory Peripheral List</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- DataTales Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <div class="row">
                                        @can('institution_create')
                                            <div class="col-md-4 offset-md-8">
                                                <a href="#" data-toggle="modal" data-target="#add-mp-modal" class="btn btn-primary float-right"><i class="fas fa-plus-circle"></i> Add New Peripheral</a>
                                            </div>
                                        @endcan
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped dt-responsive" id="mp-datatable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr class="thead-dark">
                                                    <th>ID</th>
                                                    <th>Item Code</th>
                                                    <th>Item Description</th>
                                                    <th>Quantity</th>
                                                    <th>Category</th>
                                                    <th>Status</th>
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
            @include('modals.mandatory_peripherals.create')
            @include('modals.mandatory_peripherals.edit')
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
            $('#mp-datatable').DataTable({
                "stripeClasses": [],
                processing: true,
                serverSide: true,
                responsive: true,
                searchable: true,
                ordering: true,
                order: [0, 'DESC'],
                ajax: {
                    url: "{{ route('settings.mandatory_peripheral.show') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'item_code'
                    },
                    {
                        data: 'item_description'
                    },
                    {
                        data: 'quantity'
                    },
                    {
                        data: 'category'
                    },
                    {
                        data: 'status',
                        orderable: false
                    },
                    {
                        data: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ],
            });
        });

        let mp_id;

        $('#mp-datatable').on('click', '.edit-mp-modal', function(e) {
            e.preventDefault();
            mp_id = $(this).data('id');
            if (mp_id) {
                $.ajax({
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/settings/mandatory-peripherals/ajax/edit/' + mp_id,
                    contentType: "application/json; charset=utf-8",
                    cache: false,
                    dataType: 'json',
                }).done(function(data) {
                    $('#edit-mp-id').val(data.id);
                    $('#edit-item-code').val(data.item_code);
                    $('#edit-item-description').val(data.item_description);
                    $('#edit-quantity').val(data.quantity);
                    $('#edit-peripherals-category-id [value='+data.peripherals_category_id+']').prop('selected', true);
                    $('#edit-mp-modal').modal('show');
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                    Swal.fire(
                        'Something went wrong!',
                        'Please contact your system administrator!',
                        'error'
                    )
                });
            }
        })

        $('#mp-datatable').on('click', '.enable-mp', function(e) {
            e.preventDefault();
            mp_id = $(this).data('id');
            if (mp_id) {
                enableMandatoryPeripheral(mp_id);
            }
        });

        $('#mp-datatable').on('click', '.disable-mp', function(e) {
            e.preventDefault();
            mp_id = $(this).data('id');
            if (mp_id) {
                disableMandatoryPeripheral(mp_id);
            }
        });

        function disableMandatoryPeripheral(mp_id) {
            Swal.fire({
                title: 'Disable Item Peripheral',
                text: "This will make mandatory peripheral Inactive, Do you want to proceed?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirm'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'GET',
                        dataType: 'json',
                        url: '/settings/mandatory-peripherals/ajax/disable-peripheral/' + mp_id,
                        headers: {
                            'X-CSRF-Token': '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            //reload table 
                            $("#mp-datatable").DataTable().ajax.reload();
                            Swal.fire(
                                'Success!',
                                'Item Peripheral has been disabled',
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

        function enableMandatoryPeripheral(mp_id) {
            Swal.fire({
                title: 'Enable Item Peripheral',
                text: "This will make mandatory peripheral Active, Do you want to proceed?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirm'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'GET',
                        dataType: 'json',
                        url: '/settings/mandatory-peripherals/ajax/enable-peripheral/' + mp_id,
                        headers: {
                            'X-CSRF-Token': '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            //reload table 
                            $("#mp-datatable").DataTable().ajax.reload(null, false);
                            Swal.fire(
                                'Success!',
                                'Item Peripheral has been enabled',
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
    @if(Session::has('store_errors'))        
    <script>
        $(function() {
            $('#add-mp-modal').modal('show');
        });
    </script>
    {{Session::forget('store_errors')}}
    @endif
    @if(Session::has('update_errors'))        
    <script>
        $(function() {
            $("#edit-mp-id").val({!! session('update_errors') !!});
            $('#edit-mp-modal').modal('show');

        });
    </script>
    {{Session::forget('update_errors')}}
    @endif
@endsection
