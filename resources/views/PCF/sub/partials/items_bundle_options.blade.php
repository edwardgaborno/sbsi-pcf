<div class="modal fade" id="bundleItemsModal" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bundle Items</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card shadow mb-3">
                    <div class="card-header py-3">
                        <form id="pcfListBundleForm">
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="item_code_bundle">Item Code</label>
                                    <input type="hidden" class="form-control" name="p_c_f_list_id" id="pcfList_id">
                                    <select name="source_id" id="item_code_bundle" class="form-control select2" required></select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="description_bundle">Item Description</label>
                                    <input type="text" class="form-control" name="description" id="description_bundle"
                                        placeholder="Description" readonly>                      
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="quantity_bundle">Quantity</label>
                                    <input type="number" class="form-control" name="quantity" id="quantity_bundle"
                                        value="{{ old('quantity') }}" min="0" required disabled>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary form-control btn-submit" id="submit">
                                <i class="fas fa-plus-circle"></i> Add Item</button>
                        </form>
                    </div>
                </div>
                <div class="card shadow mb-3">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover dt-responsive" width="100%" id="pcfItemBundle_datatable" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Item Code</th>
                                        <th>Item Description</th>
                                        <th>Quantity</th>
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
    </div>
</div>