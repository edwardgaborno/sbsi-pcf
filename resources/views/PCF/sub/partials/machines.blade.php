<div class="card">
    <div class="card-header" id="headingTwo">
        <h2 class="mb-0">
            <button class="btn btn-link btn-block text-dark text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                <i class="fa fa-plus"></i>MACHINES AND INCLUSIONS (FOC REAGENTS, LIS CONNECTIVITY, INTERFACE, OTHER ITEMS)
            </button>
        </h2>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
        <div class="card-body py-3">
            <form id="pcfMachinesForm">
                @csrf
                <div class="row">
                    <div class="form-group col-md-2">
                        <label for="source_item_code-foc">Item Code</label>
                        <input type="hidden" class="form-control" name="pcf_no" id="pcf_no_add_item_foc" value="{{ $pcf_no }}"> <!-- pcf no -->  
                        
                        <select name="source_id" id="source_item_code-foc" class="form-control @error('source_id') is-invalid @enderror select2" required></select>

                        @error('source_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="item_description_foc">Item Description</label>
                        <input type="text" class="form-control" name="description @error('description') is-invalid @enderror" id="description-foc"
                            value="{{ old('item_description_foc') }}" readonly required>

                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <input type="hidden" class="form-control" name="tp_php" id="tp_php-foc">    
                        <input type="hidden" class="form-control" name="cost_of_peripherals" id="cost_of_peripherals-foc">
                        <input type="hidden" class="form-control" name="opex" id="opex-foc">
                        <input type="hidden" class="form-control" name="total_cost" id="total_cost-foc">    
                        <input type="hidden" class="form-control" name="cost_year" id="cost_year-foc">
                        <input type="hidden" class="form-control" name="depreciable_life" id="depreciable_life-foc">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="serial_no_foc">Serial No.</label>
                        <input type="text" class="form-control @error('serial_no') is-invalid @enderror" name="serial_no" id="serial_no-foc"
                            value="N / A {{ old('serial_no-foc') }}">

                        @error('serial_no')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-2">
                        <label for="type_foc">Type</label>
                        <select class="form-control @error('type') is-invalid @enderror" name="type" id="type-foc" required>
                            <option value="" selected disabled>Select type</option>
                            <option value="MACHINE">MACHINE</option>
                            <option value="COGS">COGS</option>
                        </select>

                        @error('type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-2">
                        <label for="quantity-foc">Quantity</label>
                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" id="quantity-foc"
                            value="{{ old('quantity-foc') }}" required>
                        
                        @error('quantity')
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
                <table class="table table-striped table-hover dt-responsive" id="pcfFOC_dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Item Code</th>
                            <th>Item Description</th>
                            <th>Serial No.</th>
                            <th>Type</th>
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