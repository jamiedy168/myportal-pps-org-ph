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
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Email Address</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Contact Number</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Chapter Name</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Member Type</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Birthdate</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Age</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Gender</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Address</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Picture</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Is VIP</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">VIP Description</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">TIN</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Unit/House Number</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Province</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">City</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Barangay</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Country</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">PMA Number</th>

                
            </tr>
        </thead>
        <tbody>
            @foreach ($memberList as $memberList2)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><h6 class="mb-0">{{ $memberList2->first_name }}</h6></td>
                <td><h6 class="mb-0">{{ $memberList2->middle_name }}</h6></td>
                <td><h6 class="mb-0">{{ $memberList2->last_name }}</h6></td>
                <td><h6 class="mb-0">{{ $memberList2->suffix }}</h6></td>
                <td><h6 class="mb-0">{{ $memberList2->prc_number }}</h6></td>
                <td><h6 class="mb-0">{{ $memberList2->pps_no }}</h6></td>
                <td><h6 class="mb-0">{{ $memberList2->email_address }}</h6></td>
                <td><h6 class="mb-0">{{ $memberList2->contact_number }}</h6></td>
                <td><h6 class="mb-0">{{ $memberList2->chapter_name }}</h6></td>
                <td><h6 class="mb-0">{{ $memberList2->member_type_name }}</h6></td>
                <td><h6 class="mb-0">{{ $memberList2->birthdate }}</h6></td>
                <td><h6 class="mb-0">{{ $memberList2->age() }}</h6></td>
                <td><h6 class="mb-0">{{ $memberList2->gender }}</h6></td>
                <td><h6 class="mb-0">{{ $memberList2->address }}</h6></td>
                <td><h6 class="mb-0">{{ $memberList2->picture }}</h6></td>
                <td><h6 class="mb-0">{{ $memberList2->vip }}</h6></td>
                <td><h6 class="mb-0">{{ $memberList2->vip_description }}</h6></td>
                <td><h6 class="mb-0">{{ $memberList2->tin_number }}</h6></td>
                <td><h6 class="mb-0">{{ $memberList2->house_number }}</h6></td>
                <td><h6 class="mb-0">{{ $memberList2->province_name }}</h6></td>
                <td><h6 class="mb-0">{{ $memberList2->city_name }}</h6></td>
                <td><h6 class="mb-0">{{ $memberList2->barangay_name }}</h6></td>
                <td><h6 class="mb-0">{{ $memberList2->country_text }}</h6></td>
                <td><h6 class="mb-0">{{ $memberList2->pma_number }}</h6></td>
                
            </tr>
          
               @endforeach
 
          
        </tbody>
    </table>
</body>
</html>