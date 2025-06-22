<!DOCTYPE html>
<html>
<head>
    <title>Laravel 12 Import Export Excel to Database Example - ItSolutionStuff.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>
<body>

<div class="container">
    <div class="card mt-5">
        <h3 class="card-header p-3"><i class="fa fa-star"></i> Laravel 12 Import Export Excel to Database Example - ItSolutionStuff.com</h3>
        <div class="card-body">
            @session('success')
                <div class="alert alert-success" role="alert">
                    {{ $value }}
                </div>
            @endsession

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('invoices.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" class="form-control"><br>
                <button class="btn btn-success"><i class="fa fa-file"></i> Import User Data</button>
            </form>

            <table class="table table-bordered mt-3">
                <tr>
                    <th>SN.</th>
                    <th>Brand</th>
                    <th>Part ID</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Rate</th>
                    <th>Amount</th>
                </tr>
                @foreach($invoices as $user)
                    <tr>
                        <td>{{ $user->sl_no }}</td>
                        <td>{{ $user->brand }}</td>
                        <td>{{ $user->part_id }}</td>
                        <td>{{ $user->description }}</td>
                        <td>{{ $user->qty }}</td>
                        <td>{{ $user->rate }}</td>
                        <td>{{ $user->amount }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
</body>
</html>
