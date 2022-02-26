<div class="card">
    <div class="card-header" id="headingOne">
        <h2 class="mb-0">
        <button class="btn btn-link btn-block text-dark text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            <i class="fa fa-plus"></i>ITEM LIST
        </button>
        </h2>
    </div>
    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
        <div class="card-body py-3" style="margin: 20px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); border-radius: 8px;">
            <form id="pcfListForm">
                @csrf
                <div class="row">
                    <div class="form-group col-md-1">
                        <label for="product_segment_id">SBU</label>
                        <select name="product_segment_id" id="product_segment_id" class="form-control @error('product_segment_id') is-invalid @enderror" required>
                            @foreach ($productSegments as $productSegment)
                                <option value="{{ $productSegment->id }}" {{ ($pcfRequest->product_segment_id == $productSegment->id ? "selected" : '') }}>{{ $productSegment->product_segment }}</option>
                            @endforeach
                        </select>

                        @error('product_segment_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror 
                    </div>
                    <div class="form-group col-md-2">
                        <label for="source_item_code_item">Item Code (<a href="#" data-toggle="modal" data-target="#pcf_view_sources_modal">View Sources</a>)</label>
                        <input type="hidden" class="form-control" name="pcf_no" id="pcf_no" value="{{ $pcfRequest->pcf_no }}"> <!-- pcf no -->                        
                        <select name="source_id" id="source_item_code_item" class="form-control @error('source_id') is-invalid @enderror select2" required>
                            <option value="" selected disabled></option>
                        </select>

                        @error('source_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror 
                    </div>
                    <div class="form-group col-md-3">
                        <label for="description">Item Description</label>
                        <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description_item"
                            placeholder="Description" readonly >

                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <input type="hidden" class="form-control" name="currency_rate" id="currency_rate_item">
                        <input type="hidden" class="form-control" name="tp_php" id="tp_php_item" value="0.00">    
                        <input type="hidden" class="form-control" name="cost_of_peripherals" id="cost_of_peripherals_item" value="0.00">
                        <input type="hidden" class="form-control" name="opex" id="opex_item">
                        <input type="hidden" class="form-control" name="net_sales" id="net_sales_item" value="0.00">
                        <input type="hidden" class="form-control" name="gross_profit" id="gross_profit_item" value="0.00">
                        <input type="hidden" class="form-control" name="total_gross_profit" id="total_gross_profit_item" value="0.00">
                        <input type="hidden" class="form-control" name="total_net_sales" id="total_net_sales_item" value="0.00">
                        <input type="hidden" class="form-control" name="profit_rate" id="profit_rate_item">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="quantity_add_item">Quantity (Per Year)</label>
                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" id="quantity_item"
                            value="{{ old('quantity') }}" required disabled>

                        @error('quantity')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-2">
                        <label for="sales_add_item">Unit Price</label>
                        <input type="text" class="form-control @error('sales') is-invalid @enderror" name="sales" id="unit_price_item"
                            value="{{ old('sales') }}" required disabled>

                        @error('sales')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-2">
                        <label for="total_sales_add_item">Total Sales</label>
                        <input type="text" class="form-control @error('total_sales') is-invalid @enderror" name="total_sales" id="total_sales_item"
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
        <div class="card-body" style="margin: 20px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); border-radius: 8px;">
            <h5 class="card-title">Item List</h5>
            <div class="table-responsive">
                <table class="table table-striped table-hover dt-responsive" id="pcfItem_datatable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Supplier</th>
                            <th>Item Code</th>
                            <th>Item Description</th>
                            <th>Quantity (Per Year)</th>
                            <th>UOM</th>
                            <th>Unit Price</th>
                            <th>Total Sales</th>
                            <th>Above Standard Price</th>
                            <th>Actions</th>
                        </tr> 
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-body" style="margin: 20px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); border-radius: 8px;">
            <h5 class="card-title">Mandatory Peripherals</h5>
            <div class="table-responsive">
                <table class="table table-striped table-hover dt-responsive" id="mandatory_peripherals_datatable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Item Code</th>
                            <th>Item Description</th>
                            <th>Quantity</th>
                            <th>Item Category</th>
                        </tr> 
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>