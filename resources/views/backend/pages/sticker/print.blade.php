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
            /* border: 2px solid #ad0909; */
            padding: 10px;
            /* box-sizing: border-box; */
            overflow: hidden;
        }

        .page-break {
            page-break-after: always;
        }

        .content {
            padding: 55px 50px 0 50px;
            font-size: 10px;
            font-weight: bold;
            text-align: center;
            line-height: 1.2;
            height: 28px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .qr-code {
            padding: 5px 0 10px 30px;
        }
    </style>
</head>
{{-- This is For mPDF --}}
<body>
    @foreach ($items as $item)
        <div class="label {{ !$loop->last ? 'page-break' : '' }}">
            <div class="content">
                {{ $item->part_id }} {{ $item->description }} Qty. {{ $item->qty }}
            </div>
            <div class="qr-code">
                <img src="{{ $qrCode }}" alt="QR Code" width="60" height="60">
            </div>
        </div>
    @endforeach
</body>
</html>
