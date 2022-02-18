@extends('layouts.app')
@section('title', 'PCF - Profitability Percentage List')

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
                        <h1 class="h3 mb-0 text-gray-800">Profitability Percentage List</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- DataTales Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <div class="row">
                                        @can('price_management_create')
                                            <div class="col-md-4 offset-md-8">
                                                <a href="#" data-toggle="modal" data-target="#add-price-modal" class="btn btn-primary float-right"><i class="fas fa-plus-circle"></i> Add New Profit Rate</a>
                                            </div>
                                        @endcan
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped dt-responsive" id="price-datatable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr class="thead-dark">
                                                    <th>ID</th>
                                                    <th>Item Category</th>
                                                    <th>Percentage</th>
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
            @include('modals.profitability_percentages.create')
            @include('modals.profitability_percentages.edit')
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
            $('#price-datatable').DataTable({
                "stripeClasses": [],
                processing: true,
                serverSide: true,
                responsive: true,
                searchable: true,
                ordering: true,
                ajax: {
                    url: "{{ route('settings.profitability_percentage.show') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'item_category'
                    },
                    {
                        data: 'percentage'
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

        let profit_rate_id;

        $('#price-datatable').on('click', '.edit-pricing-modal', function(e) {
            e.preventDefault();
            profit_rate_id = $(this).data('id');
            if (profit_rate_id) {
                $.ajax({
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/settings/profitability-percentage/edit/' + profit_rate_id,
                    contentType: "application/json; charset=utf-8",
                    cache: false,
                    dataType: 'json',
                }).done(function(data) {
                    $('#profit_rate_id').val(data.id);
                    // $('#edit-item-category').val(data.item_category);
                    $('#edit-item-category [value='+data.item_category_id+']').prop('selected', true);
                    $('#edit-price-percentage').val(data.percentage);
                    $('#edit-price-modal').modal('show');
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    Swal.fire(
                        'Something went wrong!',
                        'Please contact your system administrator!',
                        'error'
                    )
                });
            }
        });

        $('#price-datatable').on('click', '.enable-pricing', function(e) {
            e.preventDefault();
            profit_rate_id = $(this).data('id');
            if (profit_rate_id) {
                enablePrice(profit_rate_id);
            }
        });

        $('#price-datatable').on('click', '.disable-pricing', function(e) {
            e.preventDefault();
            profit_rate_id = $(this).data('id');
            if (profit_rate_id) {
                disablePrice(profit_rate_id);
            }
        });

        function disablePrice(profit_rate_id) {
            Swal.fire({
                title: 'Disable Profit Rate',
                text: "This will make profitability percentage Inactive, Do you want to proceed?",
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
                        url: '/settings/profitability-percentage/ajax/disable-profitability-percentage/' + profit_rate_id,
                        headers: {
                            'X-CSRF-Token': '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            //reload table 
                            $("#price-datatable").DataTable().ajax.reload();
                            Swal.fire(
                                'Success!',
                                'Profit Rate has been disabled',
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
            });
        }

        function enablePrice(profit_rate_id) {
            Swal.fire({
                title: 'Enable Profit Rate',
                text: "This will make profitability percentage Active, Do you want to proceed?",
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
                        url: '/settings/profitability-percentage/ajax/enable-profitability-percentage/' + profit_rate_id,
                        headers: {
                            'X-CSRF-Token': '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            //reload table 
                            $("#price-datatable").DataTable().ajax.reload(null, false);
                            Swal.fire(
                                'Success!',
                                'Profit Rate has been enabled',
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
            });
        }
    </script>
    @if(Session::has('store_errors'))        
    <script>
        $(function() {
            $('#add-price-modal').modal('show');
        });
    </script>
    {{Session::forget('store_errors')}}
    @endif
    @if(Session::has('update_errors'))        
    <script>
        $(function() {
            $("#profit_rate_id").val({!! session('update_errors') !!});
            $('#edit-price-modal').modal('show');

        });
    </script>
    {{Session::forget('update_errors')}}
    @endif
@endsection
