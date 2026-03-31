<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table class="table align-items-center mb-0"  id="annual-dues-table">
        <thead>
            <tr>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">First Name</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Middle Name</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Last Name</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Suffix</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">PRC Number</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">PPS Number</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Chapter Name</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Member Type</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Joined Date/Time</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Attended Date/Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($memberListAttendance as $memberListAttendance2)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><h6 class="mb-0">{{ $memberListAttendance2->first_name }}</h6></td>
                <td><h6 class="mb-0">{{ $memberListAttendance2->middle_name }}</h6></td>
                <td><h6 class="mb-0">{{ $memberListAttendance2->last_name }}</h6></td>
                <td><h6 class="mb-0">{{ $memberListAttendance2->suffix }}</h6></td>
                <td><h6 class="mb-0">{{ $memberListAttendance2->prc_number }}</h6></td>
                <td><h6 class="mb-0">{{ $memberListAttendance2->pps_no }}</h6></td>
                <td><h6 class="mb-0">{{ $memberListAttendance2->chapter_name }}</h6></td>
                <td><h6 class="mb-0">{{ $memberListAttendance2->member_type_name }}</h6></td>
                <td><h6 class="mb-0">{{ \Carbon\Carbon::parse($memberListAttendance2->joined_dt)->format('m-d-y h:i A') }}</h6></td>
                <td><h6 class="mb-0">{{ \Carbon\Carbon::parse($memberListAttendance2->attended_dt)->format('m-d-y h:i A') }}</h6></td>
            </tr>
          
               @endforeach
 
          
        </tbody>
    </table>
</body>
</html>