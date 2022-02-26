<div class="modal fade" id="upload_approved_pcf_modal" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Approved PCF Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="upload_pcf_request" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="upload_file"></label>
                                    <!--  For single file upload  -->
                                    <input type="hidden" id="pcf_request_id">
                                    <input type="hidden" id="file_server_id">
                                    <input type="file" name="pcf_rfq" id="file_upload"
                                        accept="application/pdf"
                                        class="@error('upload_file') is-invalid @enderror" 
                                        data-max-file-size="5MB" 
                                        credits="false"/>

                                    @error('upload_file')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-success">Upload Approved PCF</button>
                </div>
            </form>
        </div>
    </div>
</div>
