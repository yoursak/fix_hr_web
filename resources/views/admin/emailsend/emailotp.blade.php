<!DOCTYPE html>
<html>
<head>
    <title>FixHRAdmin</title>
</head>
<body>
    <p>Dear {{ $details['name'] }}</p>

    <p>{{ $details['title'] }}</p>
    <p>{{ $details['body'] }} ,and is valid for only 10 minutes</p>
    
    <p>(Genrated at {{now()}})</p>
   
    <p>*********************************</p>
    <p>This is auto-genrated email. Do not reply to this email.</p>


    <p>Thank you</p>
</body>
</html>