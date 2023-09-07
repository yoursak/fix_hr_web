<!DOCTYPE html>
<html>
<head>
    <title>FixHRAdmin</title>
</head>
<body>
    <p>Dear {{ $details['name']}}</p>  

    <p>{{ $details['title'] }}</p>
    <p>{{ $details['body'] }}, No need of password. You can access by OTP</p>

    <p>Login Now: <span>https://phplaravel-1083191-3790162.cloudwaysapps.com/</span></p>
    
    <p>(Genrated at {{now()}})</p>
   
    <p>*********************************</p>
    <p>This is auto-genrated email. Do not reply to this email.</p>


    <p>Thank you</p>
</body>
</html>