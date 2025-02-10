<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Razorpay</title>
</head>
<body>
    

    <h1>Payment</h1>
    <form action="{{ route('razorpay.payment') }}" method="POST" >
        @csrf
        Amount: <input type="text" name="amount" id="amount">
        <button type="submit">Pay Now</button>
    </form>

</body>
</html>