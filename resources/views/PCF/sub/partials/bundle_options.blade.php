<div class="modal fade" id="bundleItemsModal" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bundle Items</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <form id="pcfListForm">
                        <div class="table-responsive">
                            <table class="table table-borderless table-sm" id="bundleItemsTable">
                                <thead>
                                    <tr>
                                        <th width="20%" class="">Item Code</th>
                                        <th width="50%" class="">Item Description</th>
                                        <th width="20%" class="">Quantity</th>
                                        <th width="10%" class=""></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><select name="source_id[]" id="item_code_bundle" class="form-control itemCodeBundle" required></select></td>
                                        <th><input type="text" class="form-control" name="description[]" id="description_bundle" placeholder="Description" readonly ></th>
                                        <th><input type="number" class="form-control" name="quantity[]" id="quantity_bundle" required></th>
                                        <td><button type="button" name="add" id="add" class="btn btn-success btn-icon"><i class="fas fa-plus-circle"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>