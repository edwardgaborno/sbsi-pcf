@extends('layouts.app')
@section('title', 'PCF - Institution List')

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
                        <h1 class="h3 mb-0 text-gray-800">Institution List</h1>
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
                                                <a href="#" data-toggle="modal" data-target="#add-institution-modal" class="btn btn-primary float-right"><i class="fas fa-plus-circle"></i> Add New Institution</a>
                                            </div>
                                        @endcan
                                    </div>
                                </div>
                                @if (auth()->user()->hasRole('Administrator') ||
    auth()->user()->hasRole('Super Administrator'))
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped dt-responsive" id="institution-datatable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr class="thead-dark">
                                                        <th>ID</th>
                                                        <th>Institution</th>
                                                        <th>Address</th>
                                                        <th>Contact Person</th>
                                                        <th>Designation</th>
                                                        <th>Thru Designation</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>
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
            @include('modals.institutions.create')
            @include('modals.institutions.edit')
            <!-- End of Modal Component -->
            <!-- Footer -->
            @include('layouts.footer')
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
@endsection

@push('modals')
    <div class="modal fade" id="add_address_modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Address</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3 id="_institution" class="text-center text-dark"></h3>

                    <div class="row mt-2">
                        <input type="hidden" class="institution_id">
                        <div class="col-12" id="_address"></div>
                        <div class="col-12">
                            <input type="text" class="form-control address">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveAddress()">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endpush

@section('scripts')
    <script>
        const institution = document.querySelector('#_institution')
        const _address = document.querySelector('#_address')                
        const _institution_id = document.querySelector('.institution_id')

        const addAddress = async (id) => {
            const res = await callApi('post', "{!! route('settings.institution.instituion.data') !!}", {id})
            if (res.status === 200) {
                const data = res.data.data
                const addresses = res.data.data.addresses
                let textarea = ''

                institution.innerText = res.data.data.institution
                _institution_id.value = id
                addresses.map(el => {
                    textarea += `<textarea rows="2" class="form-control" readonly>${el.address}</textarea><br />`
                })
                _address.innerHTML = textarea
                $('#add_address_modal').modal('show')
            }
        }

        const saveAddress = async () => {
            const address = document.querySelector('.address').value
            const institution_id = document.querySelector('.institution_id').value
            const res = await callApi('post', "{!! route('settings.institution.store_address') !!}", {address, institution_id})
                .catch(err => displayMessage('error', 'Error!', err.response.data.message))
                
            if (res.status === 201) {
                $('#add_address_modal').modal('toggle')
                document.querySelector('.address').value = ''
                return displayMessage('success', 'Success!', res.data.message)
            }
        }

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

        $(function() {
            $('#institution-datatable').DataTable({
                "stripeClasses": [],
                processing: true,
                serverSide: true,
                responsive: true,
                searchable: true,
                ordering: true,
                ajax: {
                    url: "{{ route('settings.institution.list') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'institution'
                    },
                    {
                        data: 'address'
                    },
                    {
                        data: 'contact_person'
                    },
                    {
                        data: 'designation'
                    },
                    {
                        data: 'thru_designation'
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

        let institution_id;

        $('#institution-datatable').on('click', '.edit-institution-modal', function(e) {
            e.preventDefault();
            institution_id = $(this).data('id');
            if (institution_id) {
                $.ajax({
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/settings.institution/get-institution-details/' + institution_id,
                    contentType: "application/json; charset=utf-8",
                    cache: false,
                    dataType: 'json',
                }).done(function(data) {
                    $('#edit-institution-modal').modal('show');
                    $('#edit-institution-id').val(data.id);
                    $('#edit-institution').val(data.institution);
                    $('#edit-address').val(data.address);
                    $('#edit-contact-person').val(data.contact_person);
                    $('#edit-designation').val(data.designation);
                    $('#edit-thru-designation').val(data.thru_designation);
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Oops! Something went wrong.',
                        text: 'Please contact your system administrator.'
                    })
                });
            }
        })

        $('#institution-datatable').on('click', '.enable-institution', function(e) {
            e.preventDefault();
            institution = $(this).data('id');
            if (institution) {
                enableInstitution(institution);
            }
        });

        $('#institution-datatable').on('click', '.disable-institution', function(e) {
            e.preventDefault();
            institution = $(this).data('id');
            if (institution) {
                disableInstitution(institution);
            }
        });

        function disableInstitution(institution_id) {
            Swal.fire({
                title: 'Disable Institution',
                text: "This will make institution Inactive, Do you want to proceed?",
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
                        url: '/settings.institution/ajax/disable-institution/' + institution_id,
                        headers: {
                            'X-CSRF-Token': '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            //reload table 
                            $("#institution-datatable").DataTable().ajax.reload(null, false);
                            Swal.fire(
                                'Success!',
                                'Institution has been disabled',
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

        function enableInstitution(institution_id) {
            Swal.fire({
                title: 'Enable Institution',
                text: "This will make institution Active, Do you want to proceed?",
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
                        url: '/settings.institution/ajax/enable-institution/' + institution_id,
                        headers: {
                            'X-CSRF-Token': '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            //reload table 
                            $("#institution-datatable").DataTable().ajax.reload(null, false);
                            Swal.fire(
                                'Success!',
                                'Institution has been enabled',
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

        @if ($errors->has('edit_institution'))
            $('#edit-institution-modal').modal('show');
        @elseif($errors->has('institution'))
            $('#add-institution-modal').modal('show');
        @endif
    </script>
@endsection
