@extends('layouts.app')
@section('title','PCF - Create New User')
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
                    <h1 class="h3 mb-0 text-gray-800">Create New User</h1>
                </div>

                <div class="">
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-light mr-2"><i class="fas fa-arrow-circle-left"></i> Back to index page</a>
                </div>
                <br>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ route('users.store') }}" method="post">
                                        @csrf
                                            <!-- Left Element -->
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="name">Name <span style="color: red;">*</span></label>
                                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                                                            value="{{ old('name') }}" required>

                                                        @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="email">Email <span style="color: red;">*</span></label>
                                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email"
                                                            value="{{ old('email') }}" required>

                                                        @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Password <span style="color: red;">*</span></label>
                                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password"
                                                            value="{{ old('password') }}" autocomplete="new-password" required>
                                                        <span  style="float: right; margin-top: -25px; margin-right: 10px; position: relative; z-index: 2; cursor: pointer;" toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>

                                                        @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="password_confirmation">Confirm Password <span style="color: red;">*</span></label>
                                                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation"
                                                            value="{{ old('password_confirmation') }}" autocomplete="new-password" required>
                                                        <span  style="float: right; margin-top: -25px; margin-right: 10px; position: relative; z-index: 2; cursor: pointer;" toggle="#password_confirmation" class="fa fa-fw fa-eye field-icon toggle-password"></span>

                                                        @error('password_confirmation')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Left Element -->
                                            <!-- Right Element -->
                                            @can('role_access')
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="role">User Role <span style="color: red;">*</span></label>
                                                            <select class="form-control @error('role') is-invalid @enderror" name="role" id="role" required>
                                                                <option value="" selected disabled>Select user role</option>
                                                                    @foreach(\Spatie\Permission\Models\Role::orderBy('name', 'asc')->get() as $role)
                                                                        <option value="{{ $role->id }}" {{ old('role') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                                                    @endforeach
                                                            </select>

                                                            @error('role')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="department_id">Departments <span style="color: red;">*</span></label>
                                                            <select class="form-control @error('department_id') is-invalid @enderror" name="department_id" id="department_id" required>
                                                                <option value="" selected disabled>Select user department</option>
                                                                    @foreach($departments as $department)
                                                                        <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>{{ $department->department }}</option>
                                                                    @endforeach
                                                            </select>

                                                            @error('department_id')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="area_region">Area</label>
                                                            <select class="form-control @error('area_region') is-invalid @enderror" name="area_region" id="area_region">
                                                                <option value="" selected disabled>Select user area</option>
                                                                <option value="Luzon" {{ (old('area_region') == 'Luzon' ? 'selected' : '') }}>Luzon</option>
                                                                <option value="Visayas" {{ (old('area_region') == 'Visayas' ? 'selected' : '') }}>Visayas</option>
                                                                <option value="Mindanao" {{ (old('area_region') == 'Mindanao' ? 'selected' : '') }}>Mindanao</option>
                                                            </select>

                                                            @error('area_region')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="product_segment_id">Strategic Business Unit (SBU)</label><br>
                                                            @foreach ($productSegments as $productSegment)
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" name="product_segment_id[]" id="product_segment{{$productSegment->id}}" value="{{ $productSegment->id }}"  {{ in_array($productSegment->id, old('product_segment_id', [])) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="product_segment{{$productSegment->id}}">{{ $productSegment->product_segment }}</label>
                                                                </div>
                                                            @endforeach
                                                            @error('product_segment_id')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            @endcan
                                            <!-- End Right Element -->
                                            <button type="submit" class="btn btn-primary mr-2">{{ __('Add') }}</button>
                                            <a href="{{ route('users.index') }}"class="btn btn-light">{{ __('Cancel') }}</a>
                                    </form>
                                </div>
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

@section('scripts')
    <script>
        $(".toggle-password").click(function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    </script>
@endsection