<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome Email</title>
</head>
<body>
    <h1>Welcome Email</h1>

    <p>You have successfully registered your account. Welcome!</p>

    <p>Name: {{ $mailData['name'] }}</p>
    <p>Email: {{ $mailData['email'] }}</p>
</body>
</html>
