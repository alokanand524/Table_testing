<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
    <h1>Processing.....</h1>

    <script>
    window.onload = function() {
        var options = {
            "key": "{{ env('RAZORPAY_KEY') }}", // Fetch Razorpay key from .env
            "amount": {{ $amount }}, // Amount in paise
            "currency": "INR",
            "name": "iFrameit",
            "description": "Test Transaction",
            "order_id": "{{ $orderId }}", // Razorpay Order ID
            "handler": function(response) {
                var payid = response.razorpay_payment_id;
                // Redirect after successful payment
                window.location.href = "/people/create"; 
            },
            "prefill": {
                "name": "{{ auth()->user()->name ?? 'Customer' }}",
                "email": "{{ auth()->user()->email ?? 'customer@example.com' }}",
                "contact": "{{ auth()->user()->mobile ?? '9000090000' }}"
            },
            "notes": {
                "address": "Customer Billing Address"
            },
            "theme": {
                "color": "#3399cc"
            }
        };

        var rzp1 = new Razorpay(options);
        rzp1.on('payment.failed', function(response) {
            alert('Payment Failed! Please try again.');
        });
        rzp1.open();
    };
    </script>
</body>
</html>
