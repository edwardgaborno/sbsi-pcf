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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="institution">Institution</label>
                                <input type="text" class="form-control @error('institution') is-invalid @enderror" 
                                    name="institution" id="institution" value="{{ old('institution') }}" required>

                                @error('institution')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="address" cols="20" rows="3">
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="contact-person">Contact Person</label>
                                <input type="text" class="form-control @error('contact_person') is-invalid @enderror" name="contact_person" id="contact-person"
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
                                <label for="designation">Designation</label>
                                <input type="text" class="form-control @error('designation') is-invalid @enderror" name="designation" id="designation"
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
                                <label for="thru-designation">Thru Designation</label>
                                <input type="text" class="form-control @error('thru_designation') is-invalid @enderror" name="thru_designation" id="thru-designation"
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
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
