<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <div class="container">
        <p>
            Hi {{ $data['name'] }},</br>
            You have documents to review. Please <a href="{{route("ndaList")}}">click</a> here
        </p>
        </br>
        </br>
        <p>
            Thank you,</br>
            Membership team</br>
            <a href="{{route("welcome")}}">BeMyCoFounders.com</a>
        </p>
    </div>
</body>
</html>
