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
                                            <a href="#" data-toggle="modal" data-target="#addUserModal"
                                                class="btn btn-primary float-right"><i class="fas fa-plus-circle"></i> New
                                                User</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" id="dataTable" width="100%"
                                            cellspacing="0">
                                            <thead>
                                                <tr bgcolor="gray" class="text-white">
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>User Type</th>
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
        @include('modals.users.add')
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
            $('#dataTable').DataTable({
                "stripeClasses": [],
                processing: false,
                serverSide: true,
                ordering: true,
                ajax: {
                    url: "{{ route('users.list') }}",
                },
                "columns": [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'email' },
                    { data: 'role' },
                    { data: 'status' },
                    { data: 'actions' }
                ],
            });

        });

        function editUser(data) {
            var user_id = data.data('id');
            var name = data.data('name');
            var email = data.data('email');
            var user_type = data.data('user_type');

            $("#user_id").val(user_id);
            $("#edit_name").val(edit_supplier);
            $("#edit_email").val(edit_description);
            $("#edit_user_type").val(edit_unit_price);
        }

        function approveUser(data) {
            Swal.fire({
                title: 'Approve User Account',
                text: "Are you sure?",
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
                            $("#dataTable").DataTable().ajax.reload(null, false);
                            Swal.fire(
                                'Success!',
                                'User account has been approved successfully!',
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
                text: "Are you sure?",
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
                            $("#dataTable").DataTable().ajax.reload(null, false);
                            Swal.fire(
                                'Success!',
                                'User account has been enabled successfully!',
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
                text: "Are you sure?",
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
                            $("#dataTable").DataTable().ajax.reload(null, false);
                            Swal.fire(
                                'Success!',
                                'User account has been disabled successfully!',
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

        function deleteUser(data) {
            Swal.fire({
                title: 'Delete User Account',
                text: "Are you sure?",
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
                        url: '/user-management/users/ajax/delete-user-account/' + id,
                        headers: {
                            'X-CSRF-Token': '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            //reload table 
                            $("#dataTable").DataTable().ajax.reload(null, false);
                            Swal.fire(
                                'Success!',
                                'User account has been deleted successfully!',
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
@endsection