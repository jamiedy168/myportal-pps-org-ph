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
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Last Name</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Middle Name</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">PPS Number</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">PRC Number</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Chapter Name</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Email address</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Member Type</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Total Amount</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">OR Number</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Payment Date</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Payment Mode</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Transaction Type</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Annual Year</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Event Title</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Transaction ID</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Checkout Session ID</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Paymongo ID</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach ($ormaster as $ormaster2)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><h6 class="mb-0">{{ $ormaster2->first_name }}</h6></td>
                <td><h6 class="mb-0">{{ $ormaster2->last_name }}</h6></td>
                <td><h6 class="mb-0">{{ $ormaster2->middle_name }}</h6></td>
                <td><h6 class="mb-0">{{ $ormaster2->pps_no }}</h6></td>
                <td><h6 class="mb-0">{{ $ormaster2->prc_number }}</h6></td>
                <td><h6 class="mb-0">{{ $ormaster2->chapter_name }}</h6></td>
                <td><h6 class="mb-0">{{ $ormaster2->email_address }}</h6></td>
                <td><h6 class="mb-0">{{ $ormaster2->member_type_name }}</h6></td>
                <td><h6 class="mb-0">{{ $ormaster2->total_amount }}</h6></td>
                <td><h6 class="mb-0">{{ $ormaster2->or_no }}</h6></td>
                <td><h6 class="mb-0">{{ Carbon\Carbon::parse($ormaster2->payment_dt)->format('F d, Y') }}</h6></td>
                <td><h6 class="mb-0">{{ $ormaster2->payment_mode }}</h6></td>
                <td><h6 class="mb-0">{{ $ormaster2->transaction_type }}</h6></td>
                <td><h6 class="mb-0">{{ $ormaster2->annual_year }}</h6></td>
                <td><h6 class="mb-0">{{ $ormaster2->event_title }}</h6></td>
                <td><h6 class="mb-0">{{ $ormaster2->transaction_id }}</h6></td>
                <td><h6 class="mb-0">{{ $ormaster2->check_out_sessions_id }}</h6></td>
                <td><h6 class="mb-0">{{ $ormaster2->paymongo_payment_id }}</h6></td>
                
            </tr>
          
               @endforeach
 
          
        </tbody>
    </table>
</body>
</html>