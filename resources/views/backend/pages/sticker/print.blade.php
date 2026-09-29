<!DOCTYPE html>
<html>
<head>
    <style>
        @page {
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .label {
            width: 100%;
            height: 100%;
            padding: 10px;
            overflow: hidden;
            position: relative;
        }

        .page-break {
            page-break-after: always;
        }

        .description {
            float: left;
            padding-top: 0.7px;
            width: 50%;
            height: 28px;
            text-align: center;
            font-size: 10px;
            font-weight: bold;
            line-height: 1.2;
            overflow: hidden;
        }

        .spacer {
            margin-top: 70px;
        }

        .clear {
            clear: both;
        }
    </style>
</head>
<body>
    @foreach ($items as $item)
        <div class="label {{ !$loop->last ? 'page-break' : '' }}">

            <!-- Spacer to push content down -->
            <div class="spacer"></div>

            <!-- Top Row: Part ID, Description, MRP -->
            <div style="float: left; width: 25%; text-align: left; font-size: 10px; font-weight: bold;">
                <div style="padding-left: 15px;">
                    {{ $item->part_id }}
                </div>
            </div>

            <div class="description">
                {{ $item->description }}
            </div>

            <div style="float: left; width: 25%; text-align: right; font-size: 10px; font-weight: bold;">
                <div style="padding-right: 15px;">
                    MRP: {{ number_format($item->rate, 0) }}
                </div>
            </div>

            <div class="clear"></div>

            <!-- Bottom Row: QR Left, Invoice Number Centered Vertically, QR Right -->
            <div style="float: left; width: 33.33%; text-align: left; height: 60px;">
                <div style="padding-left: 15px;">
                    <img src="{{ $item->qrCode }}" alt="QR Code Left" width="60" height="60">
                </div>
            </div>

            <div style="float: left; width: 33.33%; height: 40px; text-align: center; font-size: 10px; font-weight: bold;">
                <div style="padding-top: 20px">
                    {{ $item->invoice_number }}
                </div>
            </div>

            <div style="float: left; width: 33.33%; text-align: right; height: 60px;">
                <div style="padding-right: 15px;">
                    <img src="{{ $item->qrCode }}" alt="QR Code Right" width="60" height="60">
                </div>
            </div>

            <div class="clear"></div>

        </div>
        @if($loop->iteration == 1) @break @endif
        @endforeach
</body>
</html>
