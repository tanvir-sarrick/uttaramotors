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
            /* border: 1px solid #000; */
        }

        .label {
            width: 100vw;
            height: 228px;
            border: 1px solid #000;
            /* box-sizing: border-box; */
            position: relative;
            page-break-after: always;
            padding: 10px;
        }

        .content {
            padding-top: 90px;
            font-size: 13px;
            font-weight: bold;
            text-align: center;
            /* white-space: nowrap; */
            letter-spacing: 1px;
        }

        .qr-code {
            position: absolute;
            bottom: 15%;
            left: 13%;
        }

        .qr-code svg {
            width: 45px;
            height: 45px;
        }
    </style>
</head>
{{-- This is for Snappy --}}
<body>
    @foreach ($items as $item)
        <div class="label">
            <div class="content">
                {{ $item->part_id }} {{ $item->description }} Qty. {{ $item->qty }}
            </div>

            <div class="qr-code">
                {{-- {!! $qrCode !!} --}}
                {{-- <img src="data:image/png;base64,{{ base64_encode($qrCode) }}"/> --}}
                <img src="{{ $qrCode }}" alt="QR Code" width="70" height="70">
            </div>
        </div>
    @endforeach
</body>
</html>
