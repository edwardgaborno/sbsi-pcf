<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <h1 class="h5 mb-0 text-gray-800">ITEM LIST</h1>
        </div>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <form id="pcfListForm" action="{{ route('PCF.sub.store_items') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="test_name_id">Test Code</label>
                            <input type="hidden" class="form-control" name="pcf_no" id="pcf_no" value="{{ $pcf_no }}"> <!-- pcf no -->
                            
                            <select name="source_id" id="source_item_code-i" class="form-control select2"></select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="description">Item Description</label>
                            <input type="text" class="form-control" name="description" id="description-i"
                                placeholder="Description" readonly required>

                            <input type="hidden" class="form-control" name="currency_rate" id="currency_rate-i"
                                placeholder="currency rate" >
                            <input type="hidden" class="form-control" name="tp_php" id="tp_php-i"
                                placeholder="trasfer price">    
                            <input type="hidden" class="form-control" name="cost_of_peripherals" id="cost_of_peripherals-i"
                                placeholder="cost peripherals">
                            <input type="hidden" class="form-control" name="opex" id="opex-i"
                                placeholder="opex">
                            <input type="hidden" class="form-control" name="net_sales" id="net_sales-i"
                                placeholder="net sales">
                            <input type="hidden" class="form-control" name="gross_profit" id="gross_profit-i"
                                placeholder="gross profit">
                            <input type="hidden" class="form-control" name="total_gross_profit" id="total_gross_profit-i"
                                placeholder="total gross profit">
                            <input type="hidden" class="form-control" name="total_net_sales" id="total_net_sales-i"
                                placeholder="total net sales">
                            <input type="hidden" class="form-control" name="profit_rate" id="profit_rate-i"
                                placeholder="profit rate">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="quantity_add_item">Quantity (Per Year)</label>
                            <input type="number" class="form-control" name="quantity" id="quantity-i"
                                value="{{ old('quantity') }}" required disabled>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="sales_add_item">Sales</label>
                            <input type="number" class="form-control" name="sales" id="sales-i"
                                value="{{ old('sales') }}" required disabled>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="total_sales_add_item">Total Sales</label>
                            <input type="text" class="form-control" name="total_sales" id="total_sales-i"
                                value="{{ old('total_sales') }}" readonly required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="submit_item"></label>
                                <button type="submit" class="btn btn-primary form-control btn-submit" id="submit_item">
                                    <i class="fas fa-plus-circle"></i> Add Item</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="pcfItem_datatable" width="100%"
                cellspacing="0">
                <thead>
                    <tr bgcolor="gray" class="text-white">
                        <th>Item Code</th>
                        <th>Item Description</th>
                        <th>Quantity (Per Year)</th>
                        <th>Sales</th>
                        <th>Total Sales</th>
                        <th>Action</th>
                    </tr> 
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>