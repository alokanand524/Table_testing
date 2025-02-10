<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Person Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Person Details</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h3>Name: {{ $person->name }}</h3>
        <h4>Email: {{ $person->email }}</h4>
        <h4>Mobile: {{ $person->mobile }}</h4>
        <h4>Status: {{ $person->status }}</h4>

        <h2>Transactions</h2>
        @foreach ($person->transactions as $transaction)
            <div class="card">
                <div class="card-body">
                    <h5>Order No: {{ $transaction->order_no ?: 'Not Paid Yet' }}</h5>
                    <p>Amount: {{ $transaction->amount }}</p>
                    <p>Status: {{ $transaction->status }}</p>
                    @if ($transaction->status == 'unpaid')

                    <form action="{{ route('people.payment') }}" method="POST">
                    @csrf
                        <input type="hidden" name="id" value="{{ $transaction->id }}"> <!-- Pass the transaction ID -->
                        <button type="submit" class="btn btn-success">Pay Now</button>
                    </form>

                    @endif
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>
