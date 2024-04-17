<!DOCTYPE html>
<html>
<head>
    <title>www.ossdm.com</title>
</head>
<body>

    <h1>{{ $mailData['title'] }}</h1>

    <p>{{ $mailData['body'] }}</p>

    <a href="{{$mailData['url']}}">Click to Login</a>

    <p>User name : {{$mailData['username']}}</p>
    <p>Password : {{$mailData['password']}}</p>

    <p>Thank you</p>
</body>
</html>