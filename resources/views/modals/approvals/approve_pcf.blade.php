<div class="modal fade" id="approve_pcf_modal" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approve PCF</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="approvePcfRequest">
                @csrf
                <div class="modal-body">
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="item_code_bundle">Remarks (Optional)</label>
                                    <input type="hidden" class="form-control" name="pcf_request_id" id="approve_pcf_request_id">
                                    <textarea class="form-control" name="remarks" id="approve_remarks" cols="20" rows="5">
                                        
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger form-control" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success form-control" id="submit"> Approve PCF</button>
                </div>
            </form>
        </div>
    </div>
</div>