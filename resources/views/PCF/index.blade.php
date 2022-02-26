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
        @include('modals.approvals.approve_pcf')
        @include('modals.approvals.disapprove_pcf')
        @can('upload_pcf')
            @include('modals.upload_approved_pcf_pdf.create')
        @endcan
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
        document.addEventListener('DOMContentLoaded', function() {
            var inputElement = document.querySelector('input[name="pcf_rfq"]');
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

            store.onprocessfile = (error, file) => { 
                $("#file_server_id").val(file.serverId);
            };
        });
        $(function() {
            $('#pcf_dataTable').DataTable({
                "stripeClasses": [],
                processing: true,
                serverSide: true,
                responsive: true,
                ordering: true,
                order: [1, 'DESC'],
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
        
        //Approve PCF Request
        $('#pcf_dataTable').on('click', '.approvePcfRequest', function (e) {
            e.preventDefault();
            var pcf_request_id = $(this).data('id');
            $("#approve_pcf_modal").modal('show');
            document.getElementById("approve_pcf_request_id").value = pcf_request_id;
        });

        //Disapprove PCF Request
        $('#pcf_dataTable').on('click', '.disapprovePcfRequest', function (e) {
            e.preventDefault();
            var pcf_request_id = $(this).data('id');
            $("#disapprove_pcf_modal").modal('show');
            document.getElementById("disapprove_pcf_request_id").value = pcf_request_id;
        });

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

        $('#approvePcfRequest').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('PCF.approve_pcf_request') }}",
                method:'POST',
                data: {
                    p_c_f_request_id: document.getElementById("approve_pcf_request_id").value,
                    remarks: document.getElementById("approve_remarks").value,
                },
                success: function(response) {

                    document.getElementById("approve_pcf_request_id").value = "";
                    document.getElementById("approve_remarks").value = "";
                    $("#approve_pcf_modal").modal('hide');
                    $('#pcf_dataTable').DataTable().ajax.reload();

                    Toast.fire({
                        icon: 'success',
                        title: 'Approved',
                        text: 'PCF request has been approved!'
                    })
                },
                error: function (response) {
                    console.log(response);
                    document.getElementById("approve_pcf_request_id").value = "";
                    document.getElementById("approve_remarks").value = "";
                    $("#approve_pcf_modal").modal('hide');
                    $('#pcf_dataTable').DataTable().ajax.reload();

                    Toast.fire({
                        icon: 'error',
                        title: 'Oops! Something went wrong.',
                        text: 'Please contact your system administrator.'
                    })
                },
            });
        });

        $('#disapprovePcfRequest').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('PCF.disapprove_pcf_request') }}",
                method:'POST',
                data: {
                    p_c_f_request_id: document.getElementById("disapprove_pcf_request_id").value,
                    remarks: document.getElementById("disapprove_remarks").value,
                },
                success: function(response) {
                    document.getElementById("disapprove_pcf_request_id").value = "";
                    document.getElementById("disapprove_remarks").value = "";
                    $("#disapprove_pcf_modal").modal('hide');
                    $('#pcf_dataTable').DataTable().ajax.reload();

                    Toast.fire({
                        icon: 'success',
                        title: 'Disapproved',
                        text: 'PCF request has been Disapproved!'
                    })
                },
                error: function (response) {
                    document.getElementById("disapprove_pcf_request_id").value = "";
                    document.getElementById("disapprove_remarks").value = "";
                    $("#disapprove_pcf_modal").modal('hide');
                    $('#pcf_dataTable').DataTable().ajax.reload();

                    Toast.fire({
                        icon: 'error',
                        title: 'Oops! Something went wrong.',
                        text: 'Please contact your system administrator.'
                    })
                },
            });
        });

        let pcf_request_id;
        $('#pcf_dataTable').on('click', '.cancelPcfRequest', function (e) {
            e.preventDefault();
            pcf_request_id = $(this).data('id');
            Swal.fire({
                title: 'Cancel this PCF request?',
                text: "This request will be removed permanently",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirm'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: 'GET',
                        url: '/PCF/ajax/cancel-pcf-request/' + pcf_request_id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    }).done(function(response) {
                        $('#pcf_dataTable').DataTable().ajax.reload();
                        Toast.fire({
                            icon: 'success',
                            title: 'Cancelled',
                            text: 'PCF request has been cancelled successfully.'
                        })
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                        Toast.fire({
                            icon: 'error',
                            title: 'Oops! Something went wrong.',
                            text: 'Please contact your system administrator.'
                        })
                    });
                }
            })
        })

        $('#pcf_dataTable').on('click', '.approvePcfRequestAndReleaseQuotation', function (e) {
            e.preventDefault();
            pcf_request_id = $(this).data('id');
            Swal.fire({
                title: 'Approve and Release Quotation',
                text: "This request will be approved and PSR can now print the quotation.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirm'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: 'GET',
                        url: '/PCF/ajax/approve-pcf-request-with-remarks/' + pcf_request_id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    }).done(function(response) {
                        $('#pcf_dataTable').DataTable().ajax.reload();
                        Toast.fire({
                            icon: 'success',
                            title: 'Cancelled',
                            text: 'PCF request has been cancelled successfully.'
                        })
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                        Toast.fire({
                            icon: 'error',
                            title: 'Oops! Something went wrong.',
                            text: 'Please contact your system administrator.'
                        })
                    });
                }
            })
        })
    </script>
    <script>
        $('#pcf_dataTable').on('click', '.uploadApprovePcfRequest', function (e) {
            e.preventDefault();
            var pcf_request_id = $(this).data('id');
            $("#pcf_request_id").val(pcf_request_id);
            $("#upload_approved_pcf_modal").modal('show');
        })
    </script>

    @can('upload_pcf')
        <script>
            $("#upload_pcf_request").on('submit', function(e){
                e.preventDefault();
                var id = $("#pcf_request_id").val();
                var url = "{{ route('PCF.putFile',':id') }}";
                var file_server_id = $("#file_server_id").val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url.replace(':id', id),
                    method:'POST',
                    data: {
                        '_method' : 'PUT',
                        pcf_rfq: file_server_id
                    },
                    success: function(response) {
                        clearFileUploadInputs();
                        $("#upload_approved_pcf_modal").modal('hide');
                        $('#pcf_dataTable').DataTable().ajax.reload();
    
                        Toast.fire({
                            icon: 'success',
                            title: 'Approved PCF',
                            text: 'Approved PCF has been uploaded.'
                        })
                    },
                    error: function (response) {
                        clearFileUploadInputs();
                        $("#upload_approved_pcf_modal").modal('hide');
                        $('#pcf_dataTable').DataTable().ajax.reload();
                        Toast.fire({
                            icon: 'error',
                            title: 'Oops! Something went wrong.',
                            text: 'Please contact your system administrator.'
                        })
                    },
                });
            });

            function clearFileUploadInputs() {
                $("#file_server_id").val('');
                $("#pcf_request_id").val('');
                $("#pcf_rfq").val('');
            }
        </script>
    @endcan
    @push('scripts')
        <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @endpush
@endsection
