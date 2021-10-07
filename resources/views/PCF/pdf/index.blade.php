<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profitability Computation Form</title>
    <style>
        body {
            font-family: 'Arial';
            font-size: 9px;
            text-transform: uppercase;
        }
        .table,
        .table td,
        .table th {
            border: 0px solid;
            text-align: left;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .table th,
        .table td {
            padding: 5px;
        }

        .pcf_no,
        .pcf_no td,
        .pcf_no th {
            border: 1px solid;
            text-align: left;
        }

        .pcf_no {
            border-collapse: collapse;
            position: relative;
            top: -418px;
            left: 500px;
            width: 250px;
        }

        .itemTable,
        .itemTable td,
        .itemTable th {
            border: 1px solid;
        }

        .itemTable {
            border: 1px solid;
            border-collapse: collapse;
            border-bottom: none;
            width: 100%;
            position: relative;
            top: -30px;
        }

        .itemTable th,
        .itemTable td {
            padding: 5px;
            text-align: center;
        }

        .itemTable {
            border-left: none !important;
            border-right: none !important;
        }

        .machinesTable,
        .machinesTable td,
        .machinesTable th {
            border: 1px solid;
        }

        .machinesTable {
            border: 1px solid;
            border-collapse: collapse;
            border-bottom: none;
            width: 100%;
            position: relative;
            top: -30px;
        }

        .machinesTable th,
        .machinesTable td {
            padding: 5px;
            text-align: center;
        }

        .inclusionsTitle {
            position: relative;
            top: -25px;
        }

        .footerTable,
        .footerTable td,
        .footerTable th {
            border: 1px solid;
        }

        .footerTable {
            position: relative;
            top: -120px;
            left: -5px;
            border: 1px solid;
            border-collapse: collapse;
        }

        .footerTable th,
        .footerTable td {
            padding: 5px;
            text-align: center;
        }

        .approvedByTable {
            margin-top: 80px;
        }
        .docs-note {
            position: relative;
            top: 23px;
            font-weight: bold !important;
            text-align: left;
        }

        .signed-note {
            position: relative;
            top: 15px;
            font-weight: bold !important;
            text-align: left;
        }
    </style>

</head>

<body>
    <table class="table">
        <tbody>
            <tr>
                <th>
                    <left>
                        <img height="50" width="220" src="{{ public_path("img/sbsi-logo-mod.png") }}"><br>
                    </left>
                </th>
            </tr>
            <tr>
                <th colspan="5"><center>PROFITABILITY COMPUTATION FORM</center></th>
            </tr>
            <tr>
                <th style="width: 30%;">DATE:</th>
                <td style="width: 40%;"><center>{{ Carbon\Carbon::parse($get_pcf_list[0]->date)->format('F d, Y') }}</center></td>
            </tr>
            <tr>
                <th>INSTITUTION:</th>
                <td><center>{{ $get_pcf_list[0]->institution }}</center></td>
            </tr>
            <tr>
                <th>ADDRESS:</th>
                <td><center>{{ $get_pcf_list[0]->address }}</center></td>
            </tr>
            <tr>
                <th>CONTACT PERSON:</th>
                <td><center>{{ $get_pcf_list[0]->contact_person }}</center></td>
            </tr>
            <tr>
                <th>DESIGNATION:</th>
                <td><center>{{ $get_pcf_list[0]->designation }}</center></td>
            </tr>
            <tr>
                <th>THRU DESIGNATION:</th>
                <td><center>{{ $get_pcf_list[0]->thru_designation }}</center></td>
            </tr>
            <tr>
                <th>SUPPLIER:</th>
                <td><center>{{ $get_pcf_list[0]->supplier }}</center></td>
            </tr>
            <tr>
                <th>TERMS:</th>
                <td><center>{{ $get_pcf_list[0]->terms }}</center></td>
            </tr>
            <tr>
                <th>VALIDITY:</th>
                <td><center>{{ $get_pcf_list[0]->validity }}</center></td>
            </tr>
            <tr>
                <th>DELIVERY:</th>
                <td><center>{{ $get_pcf_list[0]->delivery }}</center></td>
            </tr>
            <tr>
                <th>WARRANT (FOR MACHINES ONLY):</th>
                <td><center>{{ $get_pcf_list[0]->warranty }}</center></td>
            </tr>

            <tr>
                <th>DURATION OF CONTRACT (NO. OF YEARS):</th>
                <td><center>{{ $get_pcf_list[0]->duration }}</center></td>
            </tr>
            <tr>
                <th>DATE OF BIDDING:</th>
                @if($get_pcf_list[0]->date_bidding)
                <td><center>{{ Carbon\Carbon::parse($get_pcf_list[0]->date_bidding)->format('F d, Y') }}</center></td>
                @endif
            </tr>
            <tr>
                <th>BID DOCS PRICE:</th>
                @if($get_pcf_list[0]->bid_docs_price)
                <td><center>{{ number_format($get_pcf_list[0]->bid_docs_price, 2) }}</center></td>
                @endif
            </tr>
            <tr>
                <th>PSR and MANAGER:</th>
                <td><center>{{ $get_pcf_list[0]->psr .', '. $get_pcf_list[0]->manager }}</center></td>
            </tr>
            <tr>
                <th>ANNUAL PROFIT:</th>
                <td style="text-align: right; background-color: #fff200; font-weight: bold;">
                    {{ number_format($get_pcf_list[0]->annual_profit,2) }}
                </td>
            </tr>
            <tr>
                <th>ANNUAL PROFIT RATE:</th>
                <td style="text-align: right; background-color: #fff200; font-weight: bold;">
                    {{ $get_pcf_list[0]->annual_profit_rate.'%' }}
                </td>
            </tr>
        </tbody>
    </table>
    <table class="pcf_no">
        <tbody>
            <tr>
                <td style="width: 20%; font-weight: bold; background-color: #fff200">PCF NO.</td>
                <td style="width: 40%; background-color: #fff200">
                    <center>
                        {{ $pcf_no }}
                    </center>
                </td>
            </tr>
            <tr>
                <td style="width: 20%; font-weight: bold;">RFQ NO:</td>
                <td></td>
            </tr>
            <tr>
                <td style="width: 20%; font-weight: bold;">INVOLVED:</td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <table class="itemTable">
        <thead>
            <tr>
                <th>ITEM CODE</th>
                <th>ITEM DESCRIPTION</th>
                <th>QTY (PER YEAR)</th>
                <th>UNIT PRICE</th>
                <th>TOTAL SALES</th>
                <th>ABOVE STANDARD PRICE?</th>
            </tr>
        </thead>
        <tbody>
            @php
                $grand_total_sales = 0;
            @endphp
            @foreach ($get_pcf_list as $request)
            <tr>
                <td>{{ $request->item_code }}</td>
                <td>{{ $request->description }}</td>
                <td>{{ $request->quantity }}</td>
                <td>{{ number_format($request->sales,2) }}</td>
                <td>{{ number_format($request->total_sales,2) }}</td>
                <td>{{ $request->above_standard_price }}</td>
            @foreach ($itemBundles as $bundle)
                <tr>
                    <td>{{ $bundle->item_code }}</td>
                    <td>{{ $bundle->description }}</td>
                    <td>{{ $bundle->quantity }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
            </tr>
            @php
                $grand_total_sales += $request->total_sales; 
            @endphp
            @endforeach
            <tr style="font-weight: bold;">
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td style="border: none; text-align: center; background-color: #fff200;">TOTAL SALES</td>
                <td style="border: none; text-align: center; background-color: #fff200;">{{ ($grand_total_sales == 0 ? '- ' : number_format($grand_total_sales, 2)) }}</td>
                <td style="border: none;"></td>
            </tr>
        </tbody>
    </table>
    <h3 class="inclusionsTitle">MACHINES AND INCLUSIONS (FOC REAGENTS, LIS CONNECTIVITY, INTERFACE, OTHER ITEMS)</h3>
    <table class="machinesTable">
        <thead>
            <tr>
                <th>ITEM CODE</th>
                <th>ITEM DESCRIPTION</th>
                <th colspan="2">SERIAL NO. ( IF MACHINE TO BE BID IS NOT BRAND NEW)</th>
                <th>QTY</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($get_pcf_inclusions as $request)
                <tr>
                    <td>{{ $request->item_code }}</td>
                    <td>{{ $request->description }}</td>
                    <td>{{ $request->serial_no }}</td>
                    <td>{{ $request->type }}</td>
                    <td>{{ $request->quantity }}</td>
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
            @endforeach
        </tbody>
    </table>

    <table class="approvedByTable" style="width: 200px;">
        <tbody>
            <tr>
                <td style="text-align: left; font-weight: bold;">Approved by:</td>
            @if(!empty($approver[0]->name))
                <td style="text-decoration: underline; text-align: center;">
                    {{ $approver[0]->name }}
                </td>
            @else
                <td style="text-decoration: underline; text-align: center;"></td>
            @endif
            </tr>
            <tr>
                <td></td>
                <td style="text-align: center;">Accounting</td>
            </tr>
        </tbody>
    </table>
            
    <table class="footerTable" style="width: 200px; margin-left: auto">
        <tbody>
            <tr>
                <td style="text-align: center;">FM-ACC-07</td>
            </tr>
            <tr>
                <td style="text-align: left;">Revision No. 002</td>
            </tr>
            <tr>
                <td style="text-align: left;">Effective Date: 07/12/2021</td>
            </tr>
        </tbody>
    </table>

    @if(!empty($approver[0]->name))
    <div class="signed-note">
        <span>NOTE: THIS DOCUMENT HAS BEEN ELECTRONICALLY SIGNED BY THE APPROVER.</span>
    </div>
    @endif
    <div class="docs-note">
        <span>NOTE: NO PCF SHALL PROCEED TO BIDDING WITHOUT ACCOUNTING SIGNATURE.</span>
    </div>
</body>

</html>