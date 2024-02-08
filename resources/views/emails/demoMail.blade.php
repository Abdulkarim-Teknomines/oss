<!DOCTYPE html>
<html>
<head>
    <title>onestopsolution.com</title>
</head>
<body>

    <h1>{{ $mailData['title'] }}</h1>

    <p>{{ $mailData['body'] }}</p>

    <p>{{$mailData['url']}}</p>

    <p>User name : {{$mailData['username']}}</p>
    <p>Password : {{$mailData['password']}}</p>

    <p>Thank you</p>
</body>
</html>