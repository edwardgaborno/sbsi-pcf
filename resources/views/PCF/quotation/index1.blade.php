<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Request for Quotation Form</title>
    <style>
        body {
            font-family: 'Arial';
            font-size: 9px;
            text-transform: uppercase;
        }

        .date {
            float: right !important;
        }

        .packageInclusions {
            position: relative;
            top: 80px;
        }

        .headerTable {
            margin-left: auto;
            margin-right: auto;
            padding: 5px;
            margin-top: 30px;
        }

        .institutionTable {
            position: relative;
            top: 30px;
        }

        .attnTable {
            position: relative;
            top: 50px;
            width: 100%;
        }

        .itemTable,
        .itemTable td,
        .itemTable th {
            border: 1px solid;
        }

        .itemTable {
            border: 1px solid;
            border-collapse: collapse;
            width: 100%;
            position: relative;
            top: 70px;
        }

        .itemTable th,
        .itemTable td {
            padding: 5px;
            text-align: center;
        }

        .inclusionTable {
            border: 1px solid;
            border-collapse: collapse;
            position: relative;
            top: 85px;
            width: 100%;
        }

        .inclusionTable th,
        .inclusionTable td {
            border: 1px solid;
            padding: 5px;
            text-align: center;
        }

        .termsTable {
            width: 100%;
            position: relative;
            top: 100px;
        }

        .thanksTable {
            position: relative;
            top: 130px;
            width: 100%;
            text-transform: none !important;
            font-size: 12px;
        }

        .signatoryTable {
            width: 100%;
            position: relative;
            top: 180px;
        }

        .quotation-logo {
            text-align: center;
            position: relative;
        }

        .quotation-logo > img {
            height: 50px;
            width: 250px;
        }

    </style>

</head>
<body>
    <div class="quotation-logo">
        <img src="{{ public_path("img/sbsi-logo-mod.png") }}">
    </div>
    <div class="date">
        {{ Carbon\Carbon::parse($pcfList[0]->created_at)->format('F d, Y') }}
    </div>

    <table class="headerTable">
        <tbody>
            <tr>
                <td style="text-align: center; font-weight:bold; ">Q U O T A T I O N</td>
            </tr>
            <tr>
                <td style="text-align: center;">AS THE DISTRIBUTER OF</td>
            </tr>
            <tr>
                <td style="text-align: center; font-weight: bold">{{ $pcfList[0]->supplier }}</td>
            </tr>
            <tr>
                <td style="text-align: center;">PRODUCTS IN THE PHILIPPINES</td>
            </tr>
        </tbody>
    </table>
    <table class="institutionTable">
        <tbody>
            <tr>
                <td style="font-weight: bold" width="100%">
                    {{ $pcfList[0]->institution }}
                </td>
            </tr>
            <tr>
                <td width="50%">
                    {{ $pcfList[0]->institution_address }}
                </td>
            </tr>
        </tbody>
    </table>

    <table class="attnTable">
        <tbody>         
            <tr>
                <td style="font-weight: bold" width="30%">ATTN: {{ $pcfList[0]->contact_person }}</td>
                <td></td>
            </tr>            
            <tr>
                <td style="font-weight: bold" width="30%">THRU: {{ $pcfList[0]->thru_designation }}</td>
                <td></td>
            </tr>  
        </tbody>
    </table>

    <table class="itemTable">
        <thead style="background-color: #122D60 ; color: white">
            <tr>
                <th>ITEM CODE</th>
                <th>ITEM DESCRIPTION</th>
                <th>QTY (PER YEAR)</th>
                <th>UNIT PRICE</th>
                <th>TOTAL SALES</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pcfList as $request)
            <tr>
                <td>{{ $request->item_code }}</td>
                <td>{{ $request->description }}</td>
                <td>{{ $request->quantity }}</td>
                <td>{{ number_format($request->sales,2) }}</td>
                <td>{{ number_format($request->total_sales,2) }}</td>
            </tr>
                @foreach ($itemBundles as $bundle)
                <tr>
                    <td>{{ $bundle->item_code }}</td>
                    <td>{{ $bundle->description }}</td>
                    <td>{{ $bundle->quantity }}</td>
                    <td></td>
                    <td></td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <div class="packageInclusions">
        <span><strong>PACKAGE INCLUSIONS</strong></span>
    </div>

    @foreach ($pcfInclusions as $inclusion)
    @if($inclusion)
    <table class="inclusionTable">
        <thead style="background-color: #122D60 ; color: white">
            <tr>
                <th>ITEM CODE</th>
                <th>ITEM DESCRIPTION</th>
                <th colspan="2">SERIAL NO. ( IF MACHINE TO BE BID IS NOT BRAND NEW)</th>
                <th>QTY</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $inclusion->item_code }}</td>
                <td>{{ $inclusion->description }}</td>
                <td>{{ $inclusion->serial_no }}</td>
                <td>{{ $inclusion->type }}</td>
                <td>{{ $inclusion->quantity }}</td>
            </tr>
            @foreach ($machineBundles as $bundle)
                <tr>
                    <td>{{ $bundle->item_code }}</td>
                    <td>{{ $bundle->description }}</td>
                    <td></td>
                    <td></td>
                    <td>{{ $bundle->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
    @endforeach

    <table class="termsTable">
        <tbody>         
            <tr>
                <td style="font-weight: bold" width="15%">TERMS:</td>
                <td>{{ $pcfList[0]->terms }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold">VALIDITY:</td>
                <td>{{ $pcfList[0]->validity }}</td>
            </tr> 
            <tr>
                <td style="font-weight: bold">DELIVERY:</td>
                <td>{{ $pcfList[0]->delivery }}</td>
            </tr> 
            <tr>
                <td style="font-weight: bold">WARRANTY:</td>
                <td>{{ $pcfList[0]->warranty }}</td>
            </tr> 
        </tbody>
    </table>
    <table class="thanksTable">
        <tbody>
            <tr>
                <td style="text-align: center; font-weight:bold; font-style: italic ">
                    Thank you for giving us the opportunity to be of service!
                </td>
            </tr>
        </tbody>
    </table>
    <table class="signatoryTable" style="text-align:center">
        <tr>
            {{-- @if($pcfList[0]->is_nsm_approved == 1) --}}
            <td style="font-weight: bold; width: 45%; font-size: 15px;">IRYNE I. DE LEON</td>
            <td style="font-weight: bold; width: 55%;"></td>
            {{-- @endif --}}

            {{-- @if($pcfList[0]->is_cfo_approved == 1) --}}
            <td style="font-weight: bold; width: 45%">IRYNE I. DE LEON</td>
            <td style="font-weight: bold; width: 55%;">PERSEVERANDA A. IBEA, CPA</td>
            {{-- @endif --}}
        </tr>
        {{-- @if(($pcfList[0]->is_nsm_approved === 0 || $pcfList[0]->is_nsm_approved === null) || ($pcfList[0]->is_cfo_approved === 0 || $pcfList[0]->is_cfo_approved === null)) --}}
        <tr>
            <td>National Sales Manager</td>
            <td>Chief Finance Officer</td>
        </tr>
        {{-- @endif --}}
    </table>
</body>

</html>