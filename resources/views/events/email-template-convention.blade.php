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


    <h5>Dear Dr. {{ $first_name }} {{ $last_name }},</h5>

    <br>
    
  
    <p>Congratulations! You have successfully registered to the 63rd PPS Annual Convention.
       Save your QR code found inside the portal at the rightmost portion of the screen. </p>
 
    <p>Sincerely yours,</p>
    <p>PPS Registration Committee</p>
   
<br>
    

<footer>Philippine Pediatric Society, Inc.</footer>
    
</body>
</html>

