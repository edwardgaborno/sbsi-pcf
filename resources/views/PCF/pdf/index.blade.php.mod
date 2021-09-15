<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PCF Request</title>
    <style>
        
        * {
            font-family: Arial;
            font-size: 9;
        }
        .container {
            margin: auto;
        }
        .header-container {
            display: inline-flex;
        }
        table, td, th {
            border: 1px solid black;
        }
        .pcf-no,
        .revision-container {
            float: right !important;
        }
        .pdf-title {
            text-align: center;
            text-decoration: underline;
        }

        .pdf-details {
            border: none !important;
        }

        .td-column {
            font: bold;
            align: center;
            width: 50%;
        }
        .td-details {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="grid-container">
        <div class="header-container">
            <div class="logo">
                <img src="{{ public_path("img/sbsi-logo-mod.png") }}" height="70" width="200">
            </div>
            <div class="pcf-no">
                <h3>PCF NO: {{ $pcf_no }}</h3>
            </div>
        </div>
        <div class="header-details-container">
            <div class="pdf-title">
                <h2>PROFITABILITY COMPUTATION FORM</h2>
            </div>
        </div>
        <table class="pdf-details">
            <tr>
                <td class="td-column">DATE: </td>
                <td class="td-details">{{ $get_pcf_list[0]->date }}</td>
            </tr>
            <tr>
                <td>INSTITUTION: </td>
                <td>{{ $get_pcf_list[0]->institution }}</td>
            </tr>
            <tr>
                <td class="td-column">ADDRESS: </td>
                <td>{{ $get_pcf_list[0]->address }}</td>
            </tr>
            <tr>
                <td class="td-column">CONTACT PERSON: </td>
                <td>{{ $get_pcf_list[0]->contact_person }}</td>
            </tr>
            <tr>
                <td class="td-column">DESIGNATION: </td>
                <td>{{ $get_pcf_list[0]->designation }}</td>
            <tr>
            <tr>
                <td class="td-column">THRU DESIGNATION: </td>
                <td>{{ $get_pcf_list[0]->thru_designation }}</td>
            </tr>
            <tr>
                <td class="td-column">SUPPLIER: </td>
                <td>{{ $get_pcf_list[0]->supplier }}</td>
            </tr>
            <tr>
                <td class="td-column">TERMS: </td>
                <td>{{ $get_pcf_list[0]->terms }}</td>
            </tr>
            <tr>
                <td class="td-column">VALIDITY: </td>
                <td>{{ $get_pcf_list[0]->validity }}</td>
            </tr>
            <tr>
                <td class="td-column">DELIVERY: </td>
                <td>{{ $get_pcf_list[0]->delivery }}</td>
            </tr>
            <tr>
                <td class="td-column">WARRANT (FOR MACHINES ONLY): </td>
                <td>{{ $get_pcf_list[0]->warranty }}</td>
            </tr>
            <tr>
                <td class="td-column">DURATION OF CONTRACT (NO. OF YEARS): </td>
                <td>{{ $get_pcf_list[0]->duration }}</td>
            </tr>
            <tr>
                <td class="td-column">DATE OF BIDDING: </td>
                <td>{{ $get_pcf_list[0]->date_biding }}</td>
            </tr>
            <tr>
                <td class="td-column">BID DOCS PRICE: </td>
                <td>{{ number_format($get_pcf_list[0]->bid_docs_price,2) }}</td>
            </tr>
            <tr>
                <td class="td-column">PSR and Manager: </td>
                <td>{{ $get_pcf_list[0]->psr .' ,'. $get_pcf_list[0]->manager }}</td>
            </tr>
            <tr>
                <td class="td-column">Annual Profit: </td>
                <td style="text-align: right; background-color: #fff200;">{{ number_format($get_pcf_list[0]->annual_profit,2) }}</td>
            </tr>
            <tr>
                <td class="td-column">Annual Profit Rate: </td>
                <td style="text-align: right; background-color: #fff200;">{{ $get_pcf_list[0]->annual_profit_rate.'%' }}</td>
            </tr>
        <table>
        <table>
            <thead>
                <tr>
                    <th>ITEM CODE</th>
                    <th>ITEM DESCRIPTION</th>
                    <th>QTY (PER YEAR)</th>
                    <th>SALES</th>
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
                        <td style="text-align: center">{{ $request->quantity }}</td>
                        <td style="text-align: right">{{ number_format($request->sales,2) }}</td>
                        <td style="text-align: right">{{ number_format($request->total_sales,2) }}</td>
                        <td style="text-align: right">{{ $request->above_standard_price }}</td>
                    </tr>
                    @php
                        $grand_total_sales += $request->total_sales; 
                    @endphp
                @endforeach
                <tr style="font-weight: bold;">
                    <td colspan="4" style="text-align: right;">TOTAL SALES</td>
                    <td style="text-align: right; background-color: #fff200;">{{ ($grand_total_sales == 0 ? '- ' : number_format($grand_total_sales, 2)) }}</td>
                </tr>
            </tbody>
        </table>
        <h5>MACHINES AND INCLUSIONS (FOC REAGENTS, LIS CONNECTIVITY, INTERFACE, OTHER ITEMS)</h5>
        <table>
            <thead>
                <tr>
                    <th>ITEM CODE</th>
                    <th>ITEM DESCRIPTION</th>
                    <th colspan="2">SERIAL NO. (IF MACHINE TO BE BID IS NOT BRAND NEW)</th>
                    <th>QTY</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($get_pcf_inclusions as $request)
                    <tr>
                        <td>{{ $request->item_code }}</td>
                        <td>{{ $request->description }}</td>
                        <td>{{ ($request->type == 'MACHINE' ? $request->type : '') }}</td>
                        <td>{{ ($request->type == 'COGS' ? $request->type : '') }}</td>
                        <td style="text-align: right;">{{ $request->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="revision-container" style="margin-top: 20px;">
            <table class="table-revision">
                <tr>
                    <td align="center">FM-ACC-07</td>
                </tr>
                <tr>
                    <td>Revision No. 002</td>
                </tr>
                <tr>
                    <td>Effective Date: 07/12/2021</td>
                </tr>
            </table>
        </div>
        <div class="div-footer-container">
            <div class="approve-by-container">
                <span>Approve By: _____________</span>
                <span style="padding-left: 85px;">Accounting</span>
            </div>
        </div>
        <div class="docs-note">
            <span>NOTE: NO PCF SHALL PROCEED TO BIDDING WITHOUT ACCOUNTING SIGNATURE</span>
        </div>
    </div>
</body>
</html>