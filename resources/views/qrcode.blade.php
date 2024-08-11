<!DOCTYPE html>
<html>
<head>
    <title>Barcode PDF</title>
    <style>
        @page {
            margin: 0px;
            /* Set the margin for the page */
        }

        body {
            margin: 10;
            padding: 0px;
            font-family: Arial, sans-serif;
        }

    </style>
</head>
<body>
    <div>
        <h3 style="font-size: 15px;">Product: 0001245259636</h3>
        {{-- <img src="data:image/png;base64,{{ $barcode }}" alt="Barcode" width="335" height="50"> --}}
        @php

echo '<img src="data:image/jpeg;base64,' . DNS1D::getBarcodeJPG('www.globalinformatics.com.bd/', 'C39+',3,33) . '" alt="barcode" width="330"   />';

        @endphp
    </div>
</body>
</html>
