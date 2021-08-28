<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PCF Request</title>
    <style>
        .container {
            margin: auto;
        }
        .header-container  {
            display: inline-flex;
        }
        table, td, th {
            border: 1px solid black;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        .pcf-no {
            float: right !important;
        }
        .pdf-title {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-container">
            <div class="logo">
                <img src="{{ public_path("img/sbsi-logo.png") }}" height="100" width="100">
            </div>
            <div class="pcf-no">
                <h6>PCF No: </h6>
            </div>
        </div>
        <div class="pdf-title">
            <h2>PROFITABILITY COMPUTATION FORM</h2>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ITEM CODE</th>
                    <th>ITEM DESCRIPTION</th>
                    <th>QTY (PER YEAR)</th>
                    <th>SALES</th>
                    <th>TOTAL SALES</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($get_pcf_list as $request)
                    <tr>
                        <td>{{ $request->item_code }}</td>
                        <td>{{ $request->description }}</td>
                        <td>{{ $request->quantity }}</td>
                        <td>{{ $request->sales }}</td>
                        <td>{{ $request->total_sales }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>