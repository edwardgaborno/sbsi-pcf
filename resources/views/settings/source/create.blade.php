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
                                            <div class="col-md-6">
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
                                            <div class="col-md-6">
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
                                                    <input type="number" class="form-control @error('unit_price') is-invalid @enderror" name="unit_price" id="unit_price"
                                                        step=".01" value="{{ old('unit_price') }}" required>

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
                                                    <input type="number" class="form-control @error('currency_rate') is-invalid @enderror" name="currency_rate" id="currency_rate"
                                                        step=".01" min="1" value="{{ old('currency_rate') }}" required>

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
                                                    <input type="number" class="form-control @error('tp_php') is-invalid @enderror" name="tp_php" id="tp_php"
                                                        step=".01" value="{{ old('tp_php') }}" required readonly>

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
                                                    <label for="specimen_type">UOM</label>
                                                    <input type="text" class="form-control @error('uom') is-invalid @enderror" name="uom" id="uom"
                                                        value="{{ old('uom') }}">

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
                                                    <input type="number" class="form-control @error('cost_of_peripherals') is-invalid @enderror" name="cost_of_peripherals" id="cost_of_peripherals"
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
                                                        <option value="CHEM">CHEM</option>
                                                        <option value="COAG">COAG</option>
                                                        <option value="HEMA">HEMA</option>
                                                        <option value="HEMA & CHEM">HEMA and CHEM</option>
                                                        <option value="IMMUNO">IMMUNO</option>
                                                        <option value="INDUSTRIAL MICRO">INDUSTRIAL MICRO</option>
                                                        <option value="MOLECULAR">MOLECULAR</option>
                                                        <option value="SPECIAL LINES">SPECIAL LINES</option>
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
                                                        <option value="ACCESSORIES">ACCESSORIES</option>
                                                        <option value="CONSUMABLES">CONSUMABLES</option>
                                                        <option value="MACHINE">MACHINE</option>
                                                        <option value="PIPETORS">PIPETORS</option>
                                                        <option value="SPAREPARTS">SPAREPARTS</option>
                                                        <option value="REAGENTS">REAGENTS</option>
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
                                                    <input type="number" class="form-control @error('standard_price') is-invalid @enderror" name="standard_price" id="standard_price"
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
            const unit_price = parseFloat(document.getElementById("unit_price").value);
            const currency_rate = parseFloat(document.getElementById("currency_rate").value);

            (!isNaN(unit_price) && !isNaN(currency_rate))
                ? document.getElementById("tp_php").value = (unit_price * currency_rate).toFixed(2)
                : document.getElementById("tp_php").value = ''
        }

        function calculateStandardPrice()
        {
            const currency_rate = parseFloat(document.getElementById("currency_rate").value);
            const tp_php = document.getElementById("tp_php").value;
            const cost_of_peripherals = parseFloat(document.getElementById("cost_of_peripherals").value);
            const item_category = document.getElementById("item_category").value;

            const standard_price = document.getElementById("standard_price");

            if (currency_rate === 1) {
                if (!isNaN(cost_of_peripherals) && item_category === "MACHINE") {
                    standard_price.value = ((((tp_php * 1.15) + cost_of_peripherals) / (1 - 0.3)) * 1.12).toFixed(2)
                }
                else if (isNaN(cost_of_peripherals) && item_category === "MACHINE") {
                    standard_price.value = ((((tp_php * 1.15) + 0) / (1 - 0.3)) * 1.12).toFixed(2)
                }
                else if (!isNaN(cost_of_peripherals) && item_category !== "MACHINE") {
                    standard_price.value = ((((tp_php * 1.15) + cost_of_peripherals) / (1 - 0.5)) * 1.12).toFixed(2)
                }
                else if (isNaN(cost_of_peripherals) && item_category !== "MACHINE") {
                    standard_price.value = ((((tp_php * 1.15) + 0) / (1 - 0.5)) * 1.12).toFixed(2)
                }
            }
            else {
                if (!isNaN(cost_of_peripherals) && item_category === "MACHINE") {
                    standard_price.value = ((((tp_php * 1.3) + cost_of_peripherals) / (1 - 0.3)) * 1.12).toFixed(2)
                }
                else if (isNaN(cost_of_peripherals) && item_category === "MACHINE") {
                    standard_price.value = ((((tp_php * 1.3) + 0) / (1 - 0.3)) * 1.12).toFixed(2)
                }
                else if (!isNaN(cost_of_peripherals) && item_category !== "MACHINE") {
                    standard_price.value = ((((tp_php * 1.3) + cost_of_peripherals) / (1 - 0.5)) * 1.12).toFixed(2)
                }
                else if (isNaN(cost_of_peripherals) && item_category !== "MACHINE") {
                    standard_price.value = ((((tp_php * 1.3) + 0) / (1 - 0.5)) * 1.12).toFixed(2)
                }
            }
        }
    </script>
@endsection