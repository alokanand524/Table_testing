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
    // Ensure the Razorpay gateway opens automatically when the page loads
    window.onload = function() {
        var options = {
            "key": "{{ env('RAZORPAY_KEY') }}", // Enter the Key ID generated from the Dashboard
            "amount": {{ $amount }}, // Amount is in currency subunits. Default currency is INR.
            "currency": "INR",
            "name": "iFrameit", // Your business name
            "description": "Test Transaction",

            'handler': function(response) {
                // these three lines are use to verify the payment
                var payid = response.razorpay_payment_id;
                var orderid = response.razorpay_order_id;
                var signature = response.razorpay_signature;

                window.location.href = "{{ route('razorpay.callback') }}?payid=" + payid + "&orderid=" + orderid + "&signature=" + signature;
                // alert('Payment Success : ' + payid);
               
               // window.location.href = "/razorpay";  // Redirect to a success page or perform any action
            },

            "order_id": "{{$orderId}}", // Pass the `id` obtained in the response of Step 1

            "prefill": {
                "name": "Gaurav Kumar", // Your customer's name
                "email": "gaurav.kumar@example.com",
                "contact": "9000090000" // Provide the customer's phone number
            },
            "notes": {
                "address": "Razorpay Corporate Office"
            },
            "theme": {
                "color": "#3399cc"
            }
        };

        // Create a new instance of Razorpay and open it
        var rzp1 = new Razorpay(options);
        rzp1.open();
    };
    </script>
</body>
</html>