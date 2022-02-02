<div class="modal fade" id="bundleMachinesModal" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bundle Inclussion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <form id="pcfMachinesBundleForm">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="item_code_bundle">Item Code</label>

                                        <select name="source_id" id="machine_item_code_bundle" class="select2" required></select>
                                        <input type="hidden" class="form-control" name="p_c_f_inclusion_id" id="pcfInclusion_id">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="description_bundle">Item Description</label>
                                        <input type="text" class="form-control" name="description" id="machine_description_bundle"
                                            placeholder="Description" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="quantity_bundle">Quantity</label>
                                        <input type="number" class="form-control" name="quantity" id="machine_quantity_bundle"
                                            value="{{ old('quantity') }}" required disabled>
                                    </div>
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
                            <table class="table table-striped table-hover dt-responsive nowrap" width="100%" id="pcfInclusionsBundle_datatable" cellspacing="0">
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