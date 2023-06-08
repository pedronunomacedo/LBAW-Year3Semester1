<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order State Update</title>
</head>
<body>
    
    <h1 class="display-6"><strong>Tech4You</strong></h1>
    <h2 style="color: #6495ED">Order Update</h2>
    <p>Dear {{ $mailData['name'] }}, </p>

    <p><strong>Order Number:</strong> {{ $mailData['order']->id }}</p>
    <p><strong>Order Date:</strong> {{ $mailData['order']->orderdate }}</p>
    <p><strong>Order Status:</strong> {{ $mailData['order']->orderstate }}</p>


    <p>The status of your order has been updated, as shown above.</p>

    <p>You can check the status of your order at any time, by going to <strong>My Orders</strong> section in your account.</p>
    <br></br>
    <p style="color: #999998">If you have any questions related to this order, or the items it relates to, please contact your organization ...</p>
</body>
</html>
