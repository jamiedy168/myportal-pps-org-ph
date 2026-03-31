<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<body>
    <center>
        <img src="{{Storage::disk('s3')->temporaryUrl('others/pps-logo.png', now()->addMinutes(230))}}" alt="" height="150px" width="145px">
    </center>

    
    <h5>Dear {{ $first_name }} {{ $last_name }},</h5>

    <p>Your registration for the PPS Portal has been declined as of this time due to : 
        <br> 
         {{ $disapprove_reason }}
    </p>
    <br>
    <p>  
        You may send us an email within the week to determine your preferred address for the system. 
    </p>
    <br>
    <p>
        We appreciate your interest and thank you for your understanding.
    </p>
    
    <br>
    <p>
        Best regards,
        Philippine Pediatric Society 
    </p>

     

</body>
</html>

