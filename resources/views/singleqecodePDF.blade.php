<!DOCTYPE html>
<html>

<head>
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

        /* .label {
            page-break-after: always;
        } */


        .top_header,
        .main_body,
        .footer {
            width: 100%;
            border-collapse: collapse;
        }

        .topheader_left,
        .topheader_right,
        .mainbody_left,
        .mainbody_right,
        .footer_left,
        .footer_right {
            vertical-align: top;
        }

        .topheader_left,
        .mainbody_left,
        .footer_left {
            width: 60%;
        }

        .topheader_right,
        .mainbody_right,
        .footer_right {
            width: 40%;
        }

        .topheader_left h6,
        .topheader_left p,
        .topheader_left h5,
        .mainbody_right p,
        .footer_left p,
        .footer_right p {
            margin: 0px!important;
            padding: 0px!important;
        }

        .title h4 {
            margin: 0px 0px;
            padding: 0px;
            text-align: left;
        }
    </style>
</head>

<body>
    @php
        $imagePath = public_path('images/bajaj.jpg');
    @endphp
    <div class="label">
        <table class="top_header" cellspacing="0" cellpadding="0">
            <tr>
                <td class="topheader_left">
                    <h6>Bajaj Auto Limited</h6>
                    <p>Akurdi, Pune 411 035 India</p>
                    <h5 class="code">DD121181</h5>
                </td>
                <td class="topheader_right">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents($imagePath)) }}" alt="Bajaj Logo" width="100" height="50" />
                </td>
            </tr>
        </table>
        <div class="title">
            <h4 class="description" style="margin-bottom:5px; font-size: 15px;">ELEMENT OIL FILTER</h4>
        </div>

        <table class="main_body" cellspacing="0" cellpadding="0">
            <tr>
                <td class="mainbody_left" style="margin: 0px">
                    <img style="margin-left: 15px" src="data:image/png;base64,{{ base64_encode($qrCode) }}" height="45" width="45"/>

                    <p class="qty" style="margin-left: 15px; font-size:12px;" >Qty. 1 N</p>
                </td>
                <td class="mainbody_right">
                    <p style="margin-top: 25px!important; font-size:12px;">R-00</p>
                </td>
            </tr>
        </table>

        <table class="footer" cellspacing="0" cellpadding="0">
            <tr>
                <td class="footer_left">
                    <p style="margin: 0px; font-size:12px;">MADE IN INDIA</p>
                </td>
                <td class="footer_right">
                    <p style="margin: 0px; font-size:12px;">FEB 2021</p>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
