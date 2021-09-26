<!DOCTYPE html>
<html>
<head>
    <title>Solicitação</title>
</head>
<body>
    <h1>{{env('MAIL_FROM_NAME')}}</h1>

    <div>
        <p>Hello {{$interested->interested_name}}, we have good news for you.</p>
        <p>The product that you was interested, now are available.</p>

        <p>{{$interested->product->product_type}}: {{$interested->product->product_name}}</p>
        <br>

        <p>Have a nice day, we is waiting for you.</p>
    </div>
</body>
</html>
