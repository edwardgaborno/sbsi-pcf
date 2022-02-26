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
            font-size: 12px;
            text-transform: uppercase;
        }
        .container {
            padding: 0px;
            margin: auto;
        }
        .quotation-logo {
            position: relative;
            text-align: center;
        }
        .quotation-logo > img {
            height: 50px;
            width: 250px;
        }
        .quotation-date {
            position: relative;
            line-height: 0.2;
        }
        .quotation-date > p {
            text-transform: capitalize;
            float: right;
            margin-right: 20px;
            
        }
        .quotation-title{
            text-align: center;
            position: relative;
            display: inline;
        }

        .quotation-title > h1 {
            font-size: 14px ;
        }
        .quotation-title > p:nth-child(3) {
            font-size: 13px;
            font-weight: bold;
        }
        .quotation-title > p {
            font-size: 12px;
            line-height: 0.2;
        }
        .institutions {
            position: relative;
            line-height: 0.2;
        }
        .institutions > h2 {
            font-size: 12px solid;
        }
        .institutions > p {
            font-size: 12px;
        }
        .contact {
            position: relative;
            line-height: 0.2;
        }
        .contact .attn > p:nth-child(1) {
            font-weight: bold;
        }
        .contact .attn > p:nth-child(2) {
            padding-left: 58px;
        }
        .contact .thru > p:nth-child(1) {
            font-weight: bold;
        }
        /* Item Table CSS */
        .item-table-container {
            position: relative;
            top: 20px;
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
        }

        .itemTable th,
        .itemTable td {
            padding: 5px;
            text-align: center;
        }
        /* End Item Table CSS */
        .packageInclusions {
            position: relative;
            top: 40px;
        }
        .inclusion-container {
            position: relative;
            top: 40px;
        }
        .inclusionTable {
            border: 1px solid;
            border-collapse: collapse;
            position: relative;
            width: 100%;
        }
        .inclusionTable th,
        .inclusionTable td {
            border: 1px solid;
            padding: 5px;
            text-align: center;
        }
        .agreements-container {
            position: relative;
            top: 80px;
            line-height: 0.2;
        }
        .thanks-message {
            position: relative;
            top: 80px;
            text-align: center;
            font-style: italic;
            text-transform: none;
            font-weight: bold;
            font-size: 14px;
        }
        .approver-container{
            position: relative;
            top: 120px;
            line-height: 0.2;
        }
        .rfq-no {
            position: relative; 
            top: 200px; 
            line-height: 0.2; 
            text-align: right; 
            margin-right: 30px;
        }
        .company-info {
            position: fixed; 
            text-align: center;
            bottom: -40px; 
            left: 0px; 
            right: 0px;
            height: 50px;
            font-size: 9px;
            line-height: 0.4;
        }
        .company-contact > p {
            display: inline;
            padding-right: 10px;
        }
    </style>

</head>
<body>
    <div class="container">
        <div class="quotation-logo">
            <img src="{{ public_path("img/sbsi-logo-mod.png") }}">
        </div>
        <br>
        <div class="quotation-date">
            <p>{{ Carbon\Carbon::parse($pcf_request->created_at)->format('F d, Y') }}</p>
        </div>
        <br>
        <div class="quotation-title">
            <h1>Q U O T A T I O N</h1>
            <p>AS THE DISTRIBUTOR OF</p>
            <p>{{ $pcf_request->supplier }}</p>
            <p>PRODUCT OF THE PHILIPPINES</p>
        </div>
        <br>
        <div class="institutions">
            <h2>{{ $pcf_request->institution->institution }}</h2>
            <p>{{ $pcf_request->institution->address }}</p>
        </div>
        <br>
        <div class="contact">
            <div class="attn">
                <p>ATTN: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $pcf_request->contact_person }}</p>
                <p>{{ $pcf_request->designation }}</p>
            </div>
            <div class="thru">
                <p>THRU: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $pcf_request->thru_contact_person }}</p>
            </div>
        </div>
        <div class="item-table-container">
            <table class="itemTable">
                <thead style="background-color: #122D60 ; color: white;">
                    <tr>
                        <th>ITEM CODE</th>
                        <th>ITEM DESCRIPTION</th>
                        <th>QTY (PER YEAR)</th>
                        <th>UNIT PRICE</th>
                        <th>TOTAL PRICE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pcf_item_lists as $request)
                        <tr>
                            <td>{{ $request->source->item_code }}</td>
                            <td>{{ $request->source->description }}</td>
                            <td>{{ $request->quantity }}</td>
                            <td>{{ number_format($request->sales,2) }}</td>
                            <td>{{ number_format($request->total_sales,2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="packageInclusions">
            <span><strong>PACKAGE INCLUSIONS</strong></span>
        </div>
        <br>
        @foreach ($pcf_request_inclusions as $inclusion)
            @if($inclusion)
            <div class="inclusion-container">
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
                            <td>{{ $inclusion->source->item_code }}</td>
                            <td>{{ $inclusion->source->description }}</td>
                            <td>{{ $inclusion->serial_no }}</td>
                            <td>{{ $inclusion->type }}</td>
                            <td>{{ $inclusion->quantity }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @endif
        @endforeach
        <br>
        <div class="agreements-container">
            <p><span style="font-weight: bold;">TERMS:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $pcf_request->terms }}</p>
            <p><span style="font-weight: bold;">VALIDITY:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $pcf_request->validity }}</p>
            <p><span style="font-weight: bold;">DELIVERY:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $pcf_request->delivery }}</p>
            <p><span style="font-weight: bold;">WARRANTY:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $pcf_request->warranty }}</p>
        </div>
        <br>
        <div class="thanks-message">
            <p>Thank you for giving us the opportunity to be of service!</p>
        </div>
        <br>
        <div class="approver-container">
            <div class="nsm" style="display: inline-block; float: left; margin-left: 10%;">
                <p style="padding: 10px 50px 0px 50px; border-top: 1px solid; font-size: 14px; font-weight: bold;">IRYNE I. DE LEON</p>
                <p style="padding: 0px 50px 0px 30px;">National Sales Manager</p>
            </div>
            <div class="cfo" style="display: inline-block; float: right; margin-right: 10%;">
                <p style="padding: 10px 50px 0px 50px; border-top: 1px solid; font-size: 14px; font-weight: bold;">PERSEVERANDA A. IBEA, CPA</p>
                <p style="padding: 0px 50px 0px 80px;">Chief Finance Officer</p>
            </div>
        </div>
        <br>
        <div class="rfq-no">
            <p>SAL - {{ $pcf_request->rfq_no }}</p>
            <p>IDDL/PAI/RASC/IE/MAFAB</p>
        </div>
        <div class="company-info">
            <div class="company-address">
                <p>6023 Sacred Heart cor. Kamagong Sts,. Brgy.San Antonio, Makati City, Metro Manila, Philippines 1203</p>
            </div>
            <div class="company-contact">
                <p>Phone +63(2)8824-4551</p>
                <p>Fax +63(2)8896-9382</p>
                <p>info@sbsi.com.ph</p>
                <p>www.sbsi.com.ph</p>
            </div>
            <div class="company-tin">
                <p>VAT Reg. TIN: 201-841-917-000</p>
            </div>
        </div>
    </div>
</body>

</html>