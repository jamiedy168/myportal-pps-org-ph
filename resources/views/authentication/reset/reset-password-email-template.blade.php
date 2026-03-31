<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<body>
    <h5>Greetings {{ $full_name }}!</h5>

    <br>
    <p>You are requesting to reset your password, click the below link to proceed to next step.</p>

    <a href="{{ url('reset-password-form/'.$crypt)}}">Link to reset your password.</a>

    <br>
    <br>

    <footer>Thank you from Philippine Pediatric Society Inc.!</footer>
    
</body>
</html>

