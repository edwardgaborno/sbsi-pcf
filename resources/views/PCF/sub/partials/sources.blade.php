<div class="modal fade" id="pcf_view_sources_modal" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Source List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card shadow mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="supplier_filter">Filtered By:</label>
                                    <select class="form-control select2 @error('supplier') is-invalid @enderror" name="supplier" id="supplier_filter" required>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover dt-responsive nowrap" width="100%" id="pcf_view_sources_datatable" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Supplier</th>
                                        <th>Item Code</th>
                                        <th>Description</th>
                                        <th>UOM</th>
                                        <th>Item Category</th>
                                        <th>Copy</th>
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
    </div>
</div>