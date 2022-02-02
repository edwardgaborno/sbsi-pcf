<div class="modal fade" id="edit-institution-modal" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Institution Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('settings.institution.update') }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Left Element -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit-institution">Institution</label>
                                <input type="hidden" name="institution_id" id="edit-institution-id">
                                <input type="text" class="form-control @error('institution') is-invalid @enderror" 
                                    name="institution" id="edit-institution" value="{{ old('institution') }}" required>

                                @error('institution')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit-address">Address</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="edit-address"
                                    value="{{ old('address') }}" required>

                                @error('address')
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
                                <label for="edit-contact-person">Contact Person</label>
                                <input type="text" class="form-control @error('contact_person') is-invalid @enderror" name="contact_person" id="edit-contact-person"
                                    value="{{ old('contact_person') }}" required>

                                @error('contact_person')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit-designation">Designation</label>
                                <input type="text" class="form-control @error('designation') is-invalid @enderror" name="designation" id="edit-designation"
                                    value="{{ old('designation') }}" required>

                                @error('designation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit-thru-designation">Thru Designation</label>
                                <input type="text" class="form-control @error('thru_designation') is-invalid @enderror" name="thru_designation" id="edit-thru-designation"
                                    value="{{ old('thru_designation') }}" required>

                                @error('thru_designation')
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
