<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<div class="container">

    <p>Hi {{ $data['user_name'] }}</br>
    Your request to the project access was approved. Please, <a href="{{route("viewProject", ['id' => $data['project_id']])}}">click here</a>.</p>

    <p>Thank you,</br>
    Membership team</br>
    <a href="{{route("welcome")}}">BeMyCoFounders.com</a></p>

</div>
</body>
</html>
