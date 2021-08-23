<div class="modal fade" id="addPCFRequestModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New PCF Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('PCF.add') }}" method="post">
                @csrf
                <div class="modal-body">
                    <!-- Left Element -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="specimen_type">PCF No.</label>
                                <input type="text" class="form-control" name="pcf_no" id="pcf_no"
                                    value="{{ old('pcf_no') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="specimen_type">Date</label>
                                <input type="date" class="form-control" name="date" id="date"
                                    value="{{ old('date') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Institutuion</label>
                                <input type="text" class="form-control" name="institution" id="institution"
                                    value="{{ old('institution') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="specimen_type">Duration of Contract</label>
                                <input type="text" class="form-control" name="duration" id="duration" 
                                    value="{{ old('duration') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="specimen_type">Date of Bidding</label>
                                <input type="date" class="form-control" name="date_bidding" id="date_bidding"
                                    value="{{ old('date_bidding') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="specimen_type">Bid Docs Price</label>
                                <input type="text" class="form-control" name="bid_docs_price" id="bid_docs_price"
                                    value="{{ old('bid_docs_price') }}" required>
                            </div>
                        </div>
                    </div>
                    <!-- End Left Element -->
                    <!-- Right Element -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="specimen_type">PSR</label>
                                <input type="text" class="form-control" name="psr" id="psr"
                                    value="{{ old('psr') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="specimen_type">Manager</label>
                                <input type="text" class="form-control" name="manager" id="manager"
                                    value="{{ old('manager') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="specimen_type">Annual Profit</label>
                                <input type="text" class="form-control" name="profit" id="profit"
                                    value="{{ old('profit') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="specimen_type">Anual Profit Rate</label>
                                <input type="text" class="form-control" name="profit_rate" id="profit_rate"
                                    value="{{ old('profit_rate') }}" required>
                            </div>
                        </div>
                    </div>
                    <!-- End Right Element -->
                </div>
                <!-- Content Row -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable" width="100%"
                            cellspacing="0">
                            <thead>
                                <tr bgcolor="gray" class="text-white">
                                    <th>Item Code</th>
                                    <th>Item Description</th>
                                    <th>Quantity (Per Year)</th>
                                    <th>Sales</th>
                                    <th>Total Sales</th>
                                    <th>Actions</th>
                                </tr> 
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Content Row -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
