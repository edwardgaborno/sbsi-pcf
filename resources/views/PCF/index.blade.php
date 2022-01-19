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
                    <div class="col">
                        <div class="card shadow">
                            @can('pcf_request_create')
                            <div class="card-header py-3">
                                <div class="row">
                                    <div class="col-md-4 offset-md-8">
                                        <a href="{{ route('PCF.create_request') }}" class="btn btn-primary float-right">
                                            <i class="fas fa-plus-circle"></i> New PCF Request</a>
                                    </div>
                                </div>
                            </div>
                            @endcan
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover dt-responsive" id="pcf_dataTable" width="100%"
                                        cellspacing="0">
                                        <thead>
                                            <tr class="thead-dark">
                                                <th>PCF No.</th>
                                                <th>RFQ No.</th>
                                                <th>Date</th>
                                                <th>Institution</th>
                                                <th>PSR</th>
                                                <th>Annual Profit</th>
                                                <th>Annual Profit Rate</th>
                                                <th>Updated By:</th>
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
        @include('PCF.sub.partials.items_bundle_options')
        @include('PCF.sub.partials.machines_bundle_options')
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
                processing: true,
                serverSide: true,
                responsive: true,
                ordering: true,
                ajax: {
                    url: "{{ route('PCF.list') }}",
                },
                columns: [
                    { data: 'pcf_no' },
                    { data: 'rfq_no' },
                    { data: 'date_requested' },
                    { data: 'institution' },
                    { data: 'psr' },
                    { data: 'annual_profit' },
                    { data: 'annual_profit_rate' },
                    { data: 'updated_by', orderable: false, searchable: false },
                    { data: 'status', orderable: false },
                    { data: 'actions', orderable: false, searchable: false }
                ],
            });
        });
    </script>

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
        
        //Approve PCF Request;
        $('#pcf_dataTable').on('click', '.approvePcfRequest', function (e) {
            e.preventDefault();
            pcfRequest_id = $(this).data('id');
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
                        url: '/PCF/ajax/approve-request/' + pcfRequest_id,
                        contentType: "application/json; charset=utf-8",
                        cache: false,
                        dataType: 'json',
                    }).done(function(data) {
                        $('#pcf_dataTable').DataTable().ajax.reload();
                        Toast.fire({
                            icon: 'success',
                            title: 'Your approval has been recorded.'
                        })
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        Toast.fire({
                            icon: 'error',
                            title: 'Oops! Something went wrong.',
                            text: 'Please contact your system administrator.'
                        })
                    });
                }
            });
        });

        //Disapprove PCF Request;
        $('#pcf_dataTable').on('click', '.disapprovePcfRequest', function (e) {
            e.preventDefault();
            pcfRequest_id = $(this).data('id');
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
                        url: '/PCF/ajax/disapprove-request/' + pcfRequest_id,
                        contentType: "application/json; charset=utf-8",
                        cache: false,
                        dataType: 'json',
                    }).done(function(data) {
                        $('#pcf_dataTable').DataTable().ajax.reload();
                        Toast.fire({
                            icon: 'success',
                            title: 'Your disapproval has been recorded.'
                        })
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        Toast.fire({
                            icon: 'error',
                            title: 'Oops! Something went wrong.',
                            text: 'Please contact your system administrator.'
                        })
                    });
                }
            });
        });
    </script>
@endsection
