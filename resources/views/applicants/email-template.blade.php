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
    

    {{-- <center>
        <img src="{{ asset('assets') }}/img/pps-logo.png" alt="" height="40px" width="40px">
    </center> --}}
    <p> Warm greetings! This is to acknowledge the receipt of your registration details. </p>

    <p style="color: rgb(216, 14, 14) !important"><b>Status:</b> For Approval</p>

    <p>Please expect an email within three working days regarding the status of your registration. </p>
 
    <p>Thank you!</p>
 


    

<br>
    

    <footer>Philippine Pediatric Society, Inc.</footer>
    
</body>
</html>

