@extends('layouts.app')
@section('title', 'PCF - Department list')

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
                        <div class="col-12">
                            <!-- DataTales Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <div class="row">
                                        {{-- @can('institution_create') --}}
                                        <div class="col-md-4 offset-md-8">
                                            <a href="javascript:void(0)" onclick="addNewDepartment()" class="btn btn-primary float-right"><i class="fas fa-plus-circle"></i> Add New Department</a>
                                        </div>
                                        {{-- @endcan --}}
                                    </div>
                                </div>
                                @if (Auth::user()->hasRole('Administrator') || Auth::user()->hasRole('Super Administrator'))
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped dt-responsive" id="department_table" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr class="thead-dark">
                                                        <th>ID</th>
                                                        <th>Department</th>
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

            <!-- Footer -->
            @include('layouts.footer')
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
@endsection

@push('modals')
    <div class="modal fade" id="add_department_modal" data-backdrop="static" data-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Department</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('settings.institution.store') }}" method="post">
                    @csrf
                    <div class="modal-body">

                        <div class="row mb-4">

                            <div class="col-12">
                                <label>Department</label>
                                <input type="text" class="form-control" id="department">
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" onclick="saveDepartment()">Save</button>
                        </div>
                </form>
            </div>
        </div>
    </div>

@endpush

@section('scripts')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        const callApi = async (method, url, data) => {
            return axios({
                method,
                url,
                data
            })
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

        const displayMessage = ($type, $message) => {
            Toast.fire({
                icon: $type,
                html: $message
            })
        }


        const destroyDepartmentTable = () => {
            $('#department_table').DataTable().clear().destroy()
        }

        const initDepartmentTable = () => {
            $('#department_table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{!! route('settings.department.index') !!}",
                },
                columns: @json($columns)
            });
        }

        const saveDepartment = async () => {
            const department = $('#department').val()
            const res = await callApi('post', "{!! route('settings.department.store') !!}", {
                department
            }).catch(err => {
                console.error(err.response)
                const errors = err.response.data.message
                let errorMessage = '';
                Object.keys(errors).forEach((key) =>  errorMessage += '<li>' + errors[key] + '</li>')

                return displayMessage('error', errorMessage)
            })

            if (res.status === 201) {
                destroyDepartmentTable()
                initDepartmentTable()
                $("#add_department_modal").modal('toggle')
                return displayMessage('success', res.data.message)
            }

        }

        const addNewDepartment = () => {
            $('#add_department_modal').modal('show')
        }

        const editDepartment = (id) => {
            alert(id)
        }
        initDepartmentTable()
    </script>
@endsection
