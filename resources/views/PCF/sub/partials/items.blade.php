<div class="card">
    <div class="card-header" id="headingOne">
        <h2 class="mb-0">
        <button class="btn btn-link btn-block text-dark text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            <i class="fa fa-plus"></i>ITEM LIST
        </button>
        </h2>
    </div>
    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
        <div class="card-body py-3">
            <form id="pcfListForm">
                @csrf
                <div class="row">
                    <div class="form-group col-md-2">
                        <label for="source_item_code-i">Item Name</label>
                        <input type="hidden" class="form-control" name="pcf_no" id="pcf_no" value="{{ $pcf_no }}"> <!-- pcf no -->                        
                        <select name="source_id" id="source_item_code-i" class="form-control @error('source_id') is-invalid @enderror select2" required>
                            <option value="" selected disabled></option>
                        </select>

                        @error('source_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror 
                    </div>
                    <div class="form-group col-md-4">
                        <label for="description">Item Description</label>
                        <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description-i"
                            placeholder="Description" readonly >

                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <input type="hidden" class="form-control" name="currency_rate" id="currency_rate-i">
                        <input type="hidden" class="form-control" name="tp_php" id="tp_php-i">    
                        <input type="hidden" class="form-control" name="cost_of_peripherals" id="cost_of_peripherals-i">
                        <input type="hidden" class="form-control" name="opex" id="opex-i">
                        <input type="hidden" class="form-control" name="net_sales" id="net_sales-i">
                        <input type="hidden" class="form-control" name="gross_profit" id="gross_profit-i">
                        <input type="hidden" class="form-control" name="total_gross_profit" id="total_gross_profit-i">
                        <input type="hidden" class="form-control" name="total_net_sales" id="total_net_sales-i">
                        <input type="hidden" class="form-control" name="profit_rate" id="profit_rate-i">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="quantity_add-i">Quantity (Per Year)</label>
                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" id="quantity-i"
                            value="{{ old('quantity') }}" required disabled>

                        @error('quantity')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-2">
                        <label for="sales_add-i">Selling Price</label>
                        <input type="text" class="form-control @error('sales') is-invalid @enderror" name="sales" id="sales-i"
                            value="{{ old('sales') }}" required disabled>

                        @error('sales')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-2">
                        <label for="total_sales_add-i">Total Sales</label>
                        <input type="text" class="form-control @error('total_sales') is-invalid @enderror" name="total_sales" id="total_sales-i"
                            value="{{ old('total_sales') }}" readonly required>

                        @error('total_sales')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary form-control btn-submit mt-2" id="submit">
                        <i class="fas fa-plus-circle"></i> Add Item</button>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover dt-responsive" id="pcfItem_datatable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Item Code</th>
                            <th>Item Description</th>
                            <th>Quantity (Per Year)</th>
                            <th>Bundled Product</th>
                            <th>Selling Price</th>
                            <th>Total Sales</th>
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