<div class="card">
    <div class="card-header" id="headingTwo">
        <h2 class="mb-0">
            <button class="btn btn-link btn-block text-dark text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                <i class="fa fa-plus"></i>MACHINES AND INCLUSIONS (FOC REAGENTS, LIS CONNECTIVITY, INTERFACE, OTHER ITEMS)
            </button>
        </h2>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
        <div class="card-body py-3" style="margin: 20px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); border-radius: 8px;">
            <form id="pcfMachinesForm">
                @csrf
                <div class="row">
                    <div class="form-group col-md-2">
                        <label for="source_item_code_inclusion">Item Code</label>
                        <input type="hidden" class="form-control" name="pcf_no" id="pcf_no_add_item_inclusion" value="{{ $pcfRequest->pcf_no }}"> <!-- pcf no -->  
                        <select name="source_id" id="source_item_code_inclusion" class="form-control @error('source_id') is-invalid @enderror select2" required>
                            <option value="" selected disabled></option>
                        </select>

                        @error('source_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="description_inclusion">Item Description</label>
                        <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description_inclusion"
                            value="{{ old('description') }}" readonly required>

                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <input type="hidden" class="form-control" name="currency_rate" id="currency_rate_inclusion">    
                        <input type="hidden" class="form-control" name="tp_php" id="tp_php_inclusion" value="0.00">    
                        <input type="hidden" class="form-control" name="cost_of_peripherals" id="cost_of_peripherals_inclusion" value="0.00">
                        <input type="hidden" class="form-control" name="opex" id="opex_inclusion">
                        <input type="hidden" class="form-control" name="total_cost" id="total_cost_inclusion" value="0.00">    
                        {{-- <input type="text" class="form-control" name="depreciable_life" id="depreciable_life_inclusion"> --}}
                        <input type="hidden" class="form-control" name="cost_year" id="total_cost_per_year_inclussion" value="0.00">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="type_inclusion">Type</label>
                        <select class="form-control @error('type') is-invalid @enderror" name="type" id="type_inlcusion" required>
                            <option value="COGS">COGS</option>
                            <option value="MACHINE">MACHINE</option>
                        </select>

                        @error('type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-2">
                        <label for="quantity_inclusion">Quantity</label>
                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" id="quantity_inclusion">
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
        <div class="card-body" style="margin: 20px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); border-radius: 8px;">
            <h5 class="card-title">Machines & Inclusions</h5>
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