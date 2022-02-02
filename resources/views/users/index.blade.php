@extends('layouts.app')
@section('title','PCF - User Accounts')

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
                    <h1 class="h3 mb-0 text-gray-800">User List</h1>
                </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- DataTales Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <div class="row">
                                        <div class="col-md-4 offset-md-8">
                                            <a href="{{ route('users.create') }}" id="#addUser" class="btn btn-primary float-right">
                                                <i class="fas fa-plus-circle"></i> Create New User</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered dt-responsive nowrap" id="user_dataTable" width="100%"
                                            cellspacing="0">
                                            <thead>
                                                <tr bgcolor="gray" class="text-white">
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>User Type</th>
                                                    <th>Department</th>
                                                    <th>Status</th>
                                                    <th style="text-align: center; vertical-align: middle">Actions</th>
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
        @include('modals.users.edit')
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
            $('#user_dataTable').DataTable({
                "stripeClasses": [],
                processing: false,
                responsive: true,
                serverSide: true,
                ordering: true,
                ajax: {
                    url: "{{ route('users.list') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'email' },
                    { data: 'role' },
                    { data: 'department' },
                    { data: 'status', orderable: false, searchable: false },
                    { data: 'actions', orderable: false, searchable: false }
                ],
            });

        });

        let user_id;

        $('#user_dataTable').on('click', '.editUser', function (e) {
            e.preventDefault();
            user_id = $(this).data('id');
            if (user_id){
                $.ajax({
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/user-management/users/details/' + user_id,
                    contentType: "application/json; charset=utf-8",
                    cache: false,
                    dataType: 'json',
                }).done(function(data) {
                    $('#editUserModal').modal('show');
                    $('#user_id').val(data.id);
                    $('#edit_name').val(data.name);
                    $('#edit_email').val(data.email);
                    $('#edit_role').val(data.roles[0].id)
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    Swal.fire(
                        'Something went wrong!',
                        'Please contact your system administrator!',
                        'error'
                    )
                });
            }
        });

        function approveUser(data) {
            Swal.fire({
                title: 'Approve User Account',
                text: "This account is awaiting administrative approval",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirm'
            }).then((result) => {
                if (result.isConfirmed) {
                    var id = data.data('id');
                    $.ajax({
                        type: 'GET',
                        dataType: 'json',
                        url: '/user-management/users/ajax/approve-user-account/' + id,
                        headers: {
                            'X-CSRF-Token': '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            //reload table 
                            $("#user_dataTable").DataTable().ajax.reload(null, false);
                            Swal.fire(
                                'Success!',
                                'User account has been approved',
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
        
        function enableUser(data) {
            Swal.fire({
                title: 'Enable User Account',
                text: "This will enable the account",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirm'
            }).then((result) => {
                if (result.isConfirmed) {
                    var id = data.data('id');
                    $.ajax({
                        type: 'GET',
                        dataType: 'json',
                        url: '/user-management/users/ajax/enable-user-account/' + id,
                        headers: {
                            'X-CSRF-Token': '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            //reload table 
                            $("#user_dataTable").DataTable().ajax.reload(null, false);
                            Swal.fire(
                                'Success!',
                                'User account has been enabled',
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
        function disableUser(data) {
            Swal.fire({
                title: 'Disable User Account',
                text: "This will disable the user account",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirm'
            }).then((result) => {
                if (result.isConfirmed) {
                    var id = data.data('id');
                    $.ajax({
                        type: 'GET',
                        dataType: 'json',
                        url: '/user-management/users/ajax/disable-user-account/' + id,
                        headers: {
                            'X-CSRF-Token': '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            //reload table 
                            $("#user_dataTable").DataTable().ajax.reload(null, false);
                            Swal.fire(
                                'Success!',
                                'User account has been disabled',
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


        // delete user;
        $('#user_dataTable').on('click', '.deleteUser', function (e) {
            e.preventDefault();
            user_id = $(this).data('id');
            Swal.fire({
                title: 'Delete User Account',
                text: "This user account will be permanently deleted",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirm'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: 'DELETE',
                        url: '/user-management/users/ajax/delete/account/' + user_id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    }).done(function(data) {
                        $("#user_dataTable").DataTable().ajax.reload();
                        Swal.fire(
                            'Success!',
                            'User account has been deleted',
                            'success'
                        )
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        Swal.fire(
                            'Something went wrong!',
                            'Please contact your system administrator!',
                            'error'
                        )
                    });
                }
            })
        });
    </script>

    <script>
        @if (count($errors) > 0)
            $('#editUserModal').modal('show');
        @endif
    </script>
@endsection