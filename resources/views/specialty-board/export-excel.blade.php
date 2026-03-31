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
    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">PPS No.</th>
    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">PRC Number</th>
      <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">First Name</th>
      <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Middle Name</th>
      <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Last Name</th>
      <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Suffix</th>
      <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Chapter</th>
      <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Member Type</th>
      <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Member Type Applied</th>
      <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Date Applied</th>
      <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">PASSED? (Y/N)</th>
  </tr>
  </thead>
  <tbody>
  @foreach ($specialtyBoard as $specialtyBoard2)
  <tr>
    <td>{{ $loop->iteration }}</td>
    <td><h6 class="mb-0">{{ $specialtyBoard2->pps_no }}</h6></td>
      <td><h6 class="mb-0">{{ $specialtyBoard2->prc_number }}</h6></td>
      <td><h6 class="mb-0">{{ $specialtyBoard2->first_name }}</h6></td>
      <td><h6 class="mb-0">{{ $specialtyBoard2->middle_name }}</h6></td>
      <td><h6 class="mb-0">{{ $specialtyBoard2->last_name }}</h6></td>
      <td><h6 class="mb-0">{{ $specialtyBoard2->suffix }}</h6></td>
      <td><h6 class="mb-0">{{ $specialtyBoard2->chapter_name }}</h6></td>
      <td><h6 class="mb-0">{{ $specialtyBoard2->member_type_name }}</h6></td>
      <td><h6 class="mb-0">{{ $specialtyBoard2->member_type_applied }}</h6></td>
      <td><h6 class="mb-0">{{ $specialtyBoard2->apply_dt }}</h6></td>
      <td></td>
  </tr>

  @endforeach


  </tbody>
</table>
</body>
</html>
