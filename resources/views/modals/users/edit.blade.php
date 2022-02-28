<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update User Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('users.update') }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Left Element -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Name <span style="color: red;">*</span></label>
                                <input type="hidden" name="user_id" id="user_id" value="{{ old('user_id') }}">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="edit_name"
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
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="edit_email"
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
                                <label for="password">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password"
                                    value="{{ old('password') }}" autocomplete="new-password">
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
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation"
                                    value="{{ old('password_confirmation') }}" autocomplete="new-password">
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
                                    <select class="form-control @error('role') is-invalid @enderror" name="role" id="edit_role" required>
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
                                    <select class="form-control @error('department_id') is-invalid @enderror" name="department_id" id="edit_department_id" required>
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
                                    <select class="form-control @error('area_region') is-invalid @enderror" name="area_region" id="edit_area_region">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> &nbsp;Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="far fa-save"></i> &nbsp;Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
