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

    <br>
    
  
    <p>We are pleased to announce that your registration in the PPS Portal has been successfully approved. </p>
 
    <p>Login credentials:</p>
    <p>EMAIL ADDRESS: {{ $applicant_email }}</p>
    <p>PASSWORD: 123PPS</p>
    <br>
    <h6 style="color: rgb(236, 39, 39) !important"><i><b>IMPORTANT: </b>Immediately update your password on initial login. </i></h6>
    <p>Thank you!</p>
<br>
    

<footer>Philippine Pediatric Society, Inc.</footer>
    
</body>
</html>

