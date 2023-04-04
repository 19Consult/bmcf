<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<div class="container">
    Hi {{ $data['name'] }},
    You have documents to review. Please <a href="{{route("ndaList")}}">click</a> here (link to nda list)</br>
    </br>
    Thank you,</br>
    Membership team</br>
    <a href="{{route("welcome")}}">BeMyCoFounders.com</a>
</div>
</body>
</html>
