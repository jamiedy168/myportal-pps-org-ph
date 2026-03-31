<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $member->last_name }}, {{ $member->first_name }} EVENT ID CARD</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 3.5in; /* Card width */
            height: 2.5in; /* Card height */
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 16px;
            font-family: Arial, sans-serif;
            text-align: center; /* Center text horizontally */
        }
        p {
            margin: 0;
            
        }
        .card-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
        }
        .name {
            font-weight: bold;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: {{ $fontSizeLastname }};
           
        }
        .first-name {
            font-weight: bold;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: {{ $fontSizeFirstname }};
        }
        .member-type {
            font-size: 19px;
            margin-top: 5px;
        }
        .qr-code {
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="card-container">
        <p style="margin-top: -7px !important">&nbsp;</p>
        <p class="name">
            @if ($member->suffix == null)
                {{ $member->last_name }}, {{ $member->suffix }}
            @else
                {{ $member->last_name }} {{ $member->suffix }}.,
            @endif
           
        </p>
        <p class="first-name">{{ $member->first_name }}</p>

        @if($member->member_type_name == "DIPLOMATE" || $member->member_type_name == "FELLOW" || $member->member_type_name == "EMERITUS FELLOW")
            <p class="member-type">MEMBER</p>
        @else
            <p style="height: 10px;"></p>
        @endif

        <img class="qr-code" src="data:image/svg+xml;base64,{{ base64_encode(QrCode::size(70)->generate($member->pps_no)) }}" alt="QR Code" />
    </div>
</body>
</html>
