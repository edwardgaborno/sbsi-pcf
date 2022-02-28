<div class="modal fade" id="add-institution-modal" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Institution</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('settings.institution.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <!-- Left Element -->
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="institution">Institution<span style="color: red;"> *</span></label>
                                <input type="text" class="form-control @error('institution') is-invalid @enderror" 
                                    name="institution" id="institution" value="{{ old('institution') }}" required>

                                @error('institution')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="check_availability">Check Availability</label><br>
                                <a class="btn btn-success" id="validateBtn">Validate Institution</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="address">Address<span style="color: red;"> *</span></label>
                                <textarea type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="address" cols="20" rows="3" required>
                                    {{ old('address') }}
                                </textarea>
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="contact-person">Contact Person<span style="color: red;"> *</span></label>
                                <input type="text" class="form-control @error('contact_person') is-invalid @enderror" name="contact_person" id="contact-person"
                                    value="{{ old('contact_person') }}" required>

                                @error('contact_person')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="designation">Designation<span style="color: red;"> *</span></label>
                                <input type="text" class="form-control @error('designation') is-invalid @enderror" name="designation" id="designation"
                                    value="{{ old('designation') }}" required>

                                @error('designation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="thru-contact-person">Thru Contact Person</label>
                                <input type="text" class="form-control @error('thru_contact_person') is-invalid @enderror" name="thru_contact_person" id="thru-contact-person"
                                    value="{{ old('thru_contact_person') }}">

                                @error('thru_contact_person')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="thru-designation">Thru Designation</label>
                                <input type="text" class="form-control @error('thru_designation') is-invalid @enderror" name="thru_designation" id="thru-designation"
                                    value="{{ old('thru_designation') }}">

                                @error('thru_designation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email"
                                    value="{{ old('email') }}">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="contact_number">Contact Number</label>
                                <input type="text" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" id="contact_number"
                                    value="{{ old('contact_number') }}">

                                @error('contact_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="telephone_number">Telephone Number</label>
                                <input type="text" class="form-control @error('telepohone_number') is-invalid @enderror" name="telephone_number" id="telephone_number"
                                    value="{{ old('telephone_number') }}">

                                @error('telephone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- End Left Element -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> &nbsp;Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="far fa-save"></i> &nbsp;Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
