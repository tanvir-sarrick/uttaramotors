<!DOCTYPE html>
<html>
<head>
    <style>
        @page {
            margin: 0px;
        }

        body {
            margin: 10px;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .qr-code svg {
            width: 45px;   /* or any size you want */
            height: 45px;  /* maintain aspect ratio or set height too */
        }
    </style>
</head>

<body>
    @foreach ($items as $item)
        <div class="label" style="padding: 10px; position: relative;">
            <div class="title" style="font-size: 12px; margin: 60px 0 15px 20px;">
                <span style="font-weight: bold;">{{ $item->part_id }}</span> &nbsp; <span style="font-weight: bold;">{{ $item->description }}</span> &nbsp; Qty. {{ $item->qty }}
            </div>

            <div class="qr-code" style="margin-left: 20px;">
                {{-- <img src="data:image/png;base64,{{ base64_encode($qrCode) }}" height="45" width="45" /> --}}
                {{-- <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code" height="45" width="45"/> --}}
                {!! $qrCode !!}
            </div>
        </div>
    @endforeach
</body>
</html>
