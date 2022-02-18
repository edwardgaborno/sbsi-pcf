@extends('layouts.app')
@section('title', 'PCF - Supplier List')

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
                        <h1 class="h3 mb-0 text-gray-800">Supplier List</h1>
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
                                                <a href="#" data-toggle="modal" data-target="#add-supplier-modal" class="btn btn-primary float-right"><i class="fas fa-plus-circle"></i> Add New Supplier</a>
                                            </div>
                                        @endcan
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped dt-responsive" id="supplier-datatable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr class="thead-dark">
                                                    <th>ID</th>
                                                    <th>Supplier Name</th>
                                                    <th>Address</th>
                                                    <th>Email</th>
                                                    <th>Contact Number</th>
                                                    <th>Telephone Number</th>
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
            @include('modals.suppliers.create')
            @include('modals.suppliers.edit')
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
            $('#supplier-datatable').DataTable({
                "stripeClasses": [],
                processing: true,
                serverSide: true,
                responsive: true,
                searchable: true,
                ordering: true,
                ajax: {
                    url: "{{ route('business_partners.supplier.show') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'supplier_name'
                    },
                    {
                        data: 'address'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'contact_number'
                    },
                    {
                        data: 'telephone_number'
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

        let supplier_id;

        $('#supplier-datatable').on('click', '.edit-supplier-modal', function(e) {
            e.preventDefault();
            supplier_id = $(this).data('id');
            if (supplier_id) {
                $.ajax({
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/business-partners/suppliers/ajax/edit/' + supplier_id,
                    contentType: "application/json; charset=utf-8",
                    cache: false,
                    dataType: 'json',
                }).done(function(data) {
                    $('#edit-supplier-id').val(data.id);
                    $('#edit-supplier-name').val(data.supplier_name);
                    $('#edit-address').val(data.address);
                    $('#edit-email').val(data.email);
                    $('#edit-contact-number').val(data.contact_number);
                    $('#edit-telephone-number').val(data.telephone_number);
                    $('#edit-supplier-modal').modal('show');
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    Swal.fire(
                        'Something went wrong!',
                        'Please contact your system administrator!',
                        'error'
                    )
                });
            }
        })

        $('#supplier-datatable').on('click', '.enable-supplier', function(e) {
            e.preventDefault();
            supplier_id = $(this).data('id');
            if (supplier_id) {
                enableSupplier(supplier_id);
            }
        });

        $('#supplier-datatable').on('click', '.disable-supplier', function(e) {
            e.preventDefault();
            supplier_id = $(this).data('id');
            if (supplier_id) {
                disableSupplier(supplier_id);
            }
        });

        function disableSupplier(supplier_id) {
            Swal.fire({
                title: 'Disable Supplier',
                text: "This will make supplier Inactive, Do you want to proceed?",
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
                        url: '/business-partners/suppliers/ajax/disable-supplier/' + supplier_id,
                        headers: {
                            'X-CSRF-Token': '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            //reload table 
                            $("#supplier-datatable").DataTable().ajax.reload();
                            Swal.fire(
                                'Success!',
                                'Supplier has been disabled',
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

        function enableSupplier(supplier_id) {
            Swal.fire({
                title: 'Enable Supplier',
                text: "This will make supplier Active, Do you want to proceed?",
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
                        url: '/business-partners/suppliers/ajax/enable-supplier/' + supplier_id,
                        headers: {
                            'X-CSRF-Token': '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            //reload table 
                            $("#supplier-datatable").DataTable().ajax.reload(null, false);
                            Swal.fire(
                                'Success!',
                                'Supplier has been enabled',
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
            $('#add-supplier-modal').modal('show');
        });
    </script>
    {{Session::forget('store_errors')}}
    @endif
    @if(Session::has('update_errors'))        
    <script>
        $(function() {
            $("#edit-supplier-id").val({!! session('update_errors') !!});
            $('#edit-supplier-modal').modal('show');

        });
    </script>
    {{Session::forget('update_errors')}}
    @endif
@endsection
