@extends('layouts.app')
@section('title','PCF - Create New Source')

@section('content')
<div id="wrapper">

    <!-- Sidebar -->
    @include('layouts.sidebar')
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            @include('layouts.navbar')
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Create New Source</h1>
                </div>

                <div class="">
                    <a href="{{ route('settings.source.index') }}" class="btn btn-sm btn-light mr-2"><i class="fas fa-arrow-circle-left"></i> Back to index page</a>
                </div>
                <br>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ route('settings.source.store') }}" method="post">
                                        @csrf
                                        <!-- Left Element -->
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="specimen_type">Supplier</label>
                                                    <input type="text" class="form-control @error('supplier') is-invalid @enderror" name="supplier" id="supplier"
                                                        value="{{ old('supplier') }}" required>

                                                    @error('supplier')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="item_name">Item Name</label>
                                                    <input type="text" class="form-control @error('item_name') is-invalid @enderror" name="item_name" id="item_name"
                                                        value="{{ old('item_name') }}" required>

                                                    @error('item_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="specimen_type">Item Code</label>
                                                    <input type="text" class="form-control @error('item_code') is-invalid @enderror" name="item_code" id="item_code"
                                                        value="{{ old('item_code') }}" required>

                                                    @error('item_code')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" cols="5"
                                                        rows="3" required>{{ old('description') }}</textarea>

                                                    @error('description')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="specimen_type">Unit Price</label>
                                                    <input type="text" class="form-control @error('unit_price') is-invalid @enderror" name="unit_price" id="unit_price"
                                                        value="{{ old('unit_price') }}" required>

                                                    @error('unit_price')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="specimen_type">Currency Rate</label>
                                                    <input type="text" class="form-control @error('currency_rate') is-invalid @enderror" name="currency_rate" id="currency_rate"
                                                        value="{{ old('currency_rate') }}" required>

                                                    @error('currency_rate')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="specimen_type">Total Price (Php)</label>
                                                    <input type="text" class="form-control @error('tp_php') is-invalid @enderror" name="tp_php" id="tp_php"
                                                        value="{{ old('tp_php') }}" required readonly>

                                                    @error('tp_php')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Left Element -->
                                        <!-- Right Element -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="specimen_type">Item Group</label>
                                                    <input type="text" class="form-control @error('item_group') is-invalid @enderror" name="item_group" id="item_group"
                                                        value="{{ old('item_group') }}">

                                                    @error('item_group')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="uom">UOM</label>
                                                    <select class="form-control @error('uom') is-invalid @enderror" name="uom" id="uom">
                                                        <option value="" selected disabled>Select UOM</option>
                                                        <option value="SET" {{ (old("uom") == "SET" ? "selected" : "")}}>SET</option>
                                                        <option value="UN" {{ (old("uom") == "UN" ? "selected" : "")}}>UN</option>
                                                        <option value="PK" {{ (old("uom") == "PK" ? "selected" : "")}}>PK</option>
                                                        <option value="PACK" {{ (old("uom") == "PACK" ? "selected" : "")}}>PACK</option>
                                                        <option value="PC" {{ (old("uom") == "PC" ? "selected" : "")}}>PC</option>
                                                        <option value="KIT" {{ (old("uom") == "KIT" ? "selected" : "")}}>KIT</option>
                                                        <option value="UNIT" {{ (old("uom") == "UNIT" ? "selected" : "")}}>UNIT</option>
                                                    </select>
                                                    @error('uom')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="specimen_type">Mandatory Peripherals</label>
                                                    <input type="text" class="form-control @error('mandatory_peripherals') is-invalid @enderror" name="mandatory_peripherals" id="mandatory_peripherals"
                                                        value="{{ old('mandatory_peripherals') }}">

                                                    @error('mandatory_peripherals')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="specimen_type">Cost of Peripherals</label>
                                                    <input type="text" class="form-control @error('cost_of_peripherals') is-invalid @enderror" name="cost_of_peripherals" id="cost_of_peripherals"
                                                        value="{{ old('cost_of_peripherals') }}">

                                                    @error('cost_of_peripherals')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="segment">Segment</label>
                                                    <select class="form-control @error('segment') is-invalid @enderror" name="segment" id="segment">
                                                        <option value="" selected disabled>Select Segment</option>
                                                        <option value="CHEM" {{ (old("segment") == "CHEM" ? "selected" : "")}}>CHEM</option>
                                                        <option value="COAG" {{ (old("segment") == "COAG" ? "selected" : "")}}>COAG</option>
                                                        <option value="HEMA" {{ (old("segment") == "HEMA" ? "selected" : "")}}>HEMA</option>
                                                        <option value="HEMA & CHEM" {{ (old("segment") == "HEMA & CHEM" ? "selected" : "")}}>HEMA and CHEM</option>
                                                        <option value="IMMUNO" {{ (old("segment") == "IMMUNO" ? "selected" : "")}}>IMMUNO</option>
                                                        <option value="INDUSTRIAL MICRO" {{ (old("segment") == "INDUSTRIAL MICRO" ? "selected" : "")}}>INDUSTRIAL MICRO</option>
                                                        <option value="MOLECULAR" {{ (old("segment") == "MOLECULAR" ? "selected" : "")}}>MOLECULAR</option>
                                                        <option value="SPECIAL LINES" {{ (old("segment") == "SPECIAL LINES" ? "selected" : "")}}>SPECIAL LINES</option>
                                                        <option value=NULL>NONE</option>
                                                    </select>

                                                    @error('sgement')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="item_category">Item Category</label>
                                                    <select class="form-control @error('item_category') is-invalid @enderror" name="item_category" id="item_category">
                                                        <option value="" selected disabled>Select Item Category</option>
                                                        <option value="ACCESSORIES" {{ (old("item_category") == "ACCESSORIES" ? "selected" : "")}}>ACCESSORIES</option>
                                                        <option value="CONSUMABLES" {{ (old("item_category") == "CONSUMABLES" ? "selected" : "")}}>CONSUMABLES</option>
                                                        <option value="MACHINE" {{ (old("item_category") == "MACHINE" ? "selected" : "")}}>MACHINE</option>
                                                        <option value="PIPETORS" {{ (old("item_category") == "PIPETORS" ? "selected" : "")}}>PIPETORS</option>
                                                        <option value="SPAREPARTS" {{ (old("item_category") == "SPAREPARTS" ? "selected" : "")}}>SPAREPARTS</option>
                                                        <option value="REAGENTS" {{ (old("item_category") == "REAGENTS" ? "selected" : "")}}>REAGENTS</option>
                                                        <option value="OTHERS">OTHERS</option>
                                                    </select>

                                                    @error('item_category')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="standard_price">Standard Price</label>
                                                    <input type="text" class="form-control @error('standard_price') is-invalid @enderror" name="standard_price" id="standard_price"
                                                        value="{{ old('standard_price') }}" required readonly>

                                                    @error('standard_price')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="profitability">Profitability</label>
                                                    <input type="text" class="form-control @error('profitability') is-invalid @enderror" name="profitability" id="profitability"
                                                        value="{{ old('profitability') }}" required readonly>

                                                    @error('profitability')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Right Element -->
                                        <button type="submit" class="btn btn-primary float-right">{{ __('Add Source') }}</button>
                                        <a href="{{ route('settings.source.index') }}" class="btn btn-link float-right mr-2">{{ __('Cancel') }}</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Content Row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
        <!-- Footer -->
        @include('layouts.footer')
        <!-- End of Footer -->
    </div>
    <!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->
@endsection

@section('scripts')
    <script>
        const element = document.querySelectorAll('#unit_price, #currency_rate, #cost_of_peripherals');
        element.forEach(i => {
            i.addEventListener('input', function() {
                calculateTP();
                calculateStandardPrice();
            });
        });

        document.getElementById('item_category').addEventListener('change', function() {
            calculateStandardPrice();
            document.getElementById("item_category").value !== "MACHINE"
                ? document.getElementById("profitability").value = "50%"
                : document.getElementById("profitability").value = "30%"
        });

        function calculateTP()
        {
            const unit_price = parseFloat(document.getElementById("unit_price").value.replace(/,/g, ''));
            const currency_rate = parseFloat(document.getElementById("currency_rate").value.replace(/,/g, ''));

            if (!isNaN(unit_price) && !isNaN(currency_rate)) {
                document.getElementById("tp_php").value = (unit_price * currency_rate).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); 
            } else {
                document.getElementById("tp_php").value = '';
            }
        }

        function calculateStandardPrice()
        {
            const currency_rate = parseFloat(document.getElementById("currency_rate").value.replace(/,/g, ''));
            const tp_php = parseFloat(document.getElementById("tp_php").value.replace(/,/g, ''));
            const cost_of_peripherals = parseFloat(document.getElementById("cost_of_peripherals").value.replace(/,/g, ''));
            const item_category = document.getElementById("item_category").value;
            const standard_price = document.getElementById("standard_price");

            if (currency_rate === 1) {
                if (!isNaN(cost_of_peripherals) && item_category === "MACHINE") {
                    standard_price.value = ((((tp_php * 1.15) + cost_of_peripherals) / (1 - 0.3)) * 1.12).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); 
                }
                else if (isNaN(cost_of_peripherals) && item_category === "MACHINE") {
                    standard_price.value = ((((tp_php * 1.15) + 0) / (1 - 0.3)) * 1.12).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); 
                }
                else if (!isNaN(cost_of_peripherals) && item_category !== "MACHINE") {
                    standard_price.value = ((((tp_php * 1.15) + cost_of_peripherals) / (1 - 0.5)) * 1.12).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); 
                }
                else if (isNaN(cost_of_peripherals) && item_category !== "MACHINE") {
                    standard_price.value = ((((tp_php * 1.15) + 0) / (1 - 0.5)) * 1.12).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); 
                }
            }
            else {
                if (!isNaN(cost_of_peripherals) && item_category === "MACHINE") {
                    standard_price.value = ((((tp_php * 1.3) + cost_of_peripherals) / (1 - 0.3)) * 1.12).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); 
                }
                else if (isNaN(cost_of_peripherals) && item_category === "MACHINE") {
                    standard_price.value = ((((tp_php * 1.3) + 0) / (1 - 0.3)) * 1.12).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); 
                }
                else if (!isNaN(cost_of_peripherals) && item_category !== "MACHINE") {
                    standard_price.value = ((((tp_php * 1.3) + cost_of_peripherals) / (1 - 0.5)) * 1.12).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); 
                }
                else if (isNaN(cost_of_peripherals) && item_category !== "MACHINE") {
                    standard_price.value = ((((tp_php * 1.3) + 0) / (1 - 0.5)) * 1.12).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); 
                }
            }
        }

        $('#unit_price').keyup(function(event) {

            // skip for arrow keys
            if(event.which >= 37 && event.which <= 40) return;

            // format number
            $(this).val(function(index, value) {
                return value
                // .replace(/\D/g, "")
                .replace(/[^0-9.]/g, '')
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                ;
            });
        });

        $('#currency_rate').keyup(function(event) {

            // skip for arrow keys
            if(event.which >= 37 && event.which <= 40) return;

            // format number
            $(this).val(function(index, value) {
                return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                ;
            });
        });
        
        $('#cost_of_peripherals').keyup(function(event) {

            // skip for arrow keys
            if(event.which >= 37 && event.which <= 40) return;

            // format number
            $(this).val(function(index, value) {
                return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                ;
            });
        });
    </script>
@endsection