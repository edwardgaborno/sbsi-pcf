<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <h1 class="h5 mb-0 text-gray-800">MACHINES AND INCLUSIONS (FOC REAGENTS, LIS CONNECTIVITY, INTERFACE, OTHER ITEMS)</h1>
        </div>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <form id="second_table" action="{{ route('PCF.sub.store_foc') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="source_item_code-foc">Item Code</label>
                            <input type="hidden" class="form-control" name="pcf_no" id="pcf_no_add_item_foc" value="{{ $pcf_no }}"> <!-- pcf no -->  
                            
                            <select name="source_id" id="source_item_code-foc" class="form-control select2"></select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="item_description_foc">Item Description</label>
                            <input type="text" class="form-control" name="description" id="description-foc"
                                value="{{ old('item_description_foc') }}" readonly required>

                            <input type="hidden" class="form-control" name="tp_php" id="tp_php-foc" placeholder="Total price (tp_php)">    
                            <input type="hidden" class="form-control" name="cost_of_peripherals" id="cost_of_peripherals-foc" placeholder="Cost of peripherals">
                            <input type="hidden" class="form-control" name="opex" id="opex-foc" placeholder="Opex">
                            <input type="hidden" class="form-control" name="total_cost" id="total_cost-foc" placeholder="Total Cost">    
                            <input type="hidden" class="form-control" name="cost_year" id="cost_year-foc" placeholder="Cost year">
                            <input type="hidden" class="form-control" name="depreciable_life" id="depreciable_life-foc" placeholder="Depreciable life">

                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="serial_no_foc">Serial No.</label>
                            <input type="text" class="form-control" name="serial_no" id="serial_no-foc"
                                value="N / A {{ old('serial_no-foc') }}" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="type_foc">Type</label>
                            <select class="form-control" name="type" id="type-foc">
                                <option value="" selected disabled>Select type</option>
                                <option value="MACHINE">MACHINE</option>
                                <option value="COGS">COGS</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="quantity-foc">Quantity</label>
                            <input type="number" class="form-control" name="quantity" id="quantity-foc"
                                value="{{ old('quantity-foc') }}" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="submit"></label>
                                <button type="submit" class="btn btn-primary form-control btn-submit" id="submit">
                                    <i class="fas fa-plus-circle"></i> Add Item</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="pcfFOC_dataTable" width="100%"
                cellspacing="0">
                <thead>
                    <tr bgcolor="gray" class="text-white">
                        <th>Item Code</th>
                        <th>Item Description</th>
                        <th>Serial No.</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr> 
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>