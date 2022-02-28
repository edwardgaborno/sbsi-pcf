@extends('layouts.app')
@section('title','PCF - Cancelled PCF Requests')

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
                    <h1 class="h3 mb-0 text-gray-800">Cancelled PCF Requests</h1>
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
        @include('modals.approvals.index')
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
                order: [1, 'DESC'],
                ajax: {
                    url: "{{ route('PCF.cancelled_list') }}",
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

        //view approval details
        $("#pcf_dataTable").on('click', '.view-approval-details', function (e) {
            e.preventDefault();
            var pcf_request_id = $(this).data('pcf_request_id');
            $('#pcf_approval_datatable').DataTable().clear().destroy();
            $('#pcf_approval_datatable').DataTable({
                "stripeClasses": [],
                processing: true,
                serverSide: true,
                responsive: true,
                ordering: true,
                order: [5 , 'DESC'],
                ajax: {
                    headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/PCF/ajax/view-pcf-approvals/' + pcf_request_id,
                },
                columns: [
                    { data: 'approval_status' },
                    { data: 'done_by' },
                    { data: 'position' },
                    { data: 'department' },
                    { data: 'remarks' },
                    { data: 'date' },
                ],
            });
        });
    </script>
@endsection
