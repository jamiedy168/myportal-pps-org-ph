@props(['bodyClass'])
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets') }}/img/apple-icon.png">
  <link rel="icon" type="image/png" href="{{ asset('assets') }}/img/pps-logo.png">
  <title>
    Philippine Pediatric Society
  </title>

    <!-- Open Graph / Viber -->
    <meta property="og:title" content="Philippine Pediatric Society" />
    <meta property="og:description" content="Portal for Philippine Pediatric Society" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{ asset('assets') }}/img/pps-logo.png" />
    <meta property="og:site_name" content="Philippine Pediatric Society" />


  <!--     Metas    -->
  {{-- @if (env('IS_DEMO'))
    <meta name="keywords" content="creative tim, updivision, html dashboard, laravel, material, html css dashboard laravel, laravel material dashboard laravel, laravel material dashboard laravel pro, laravel material dashboard, laravel material dashboard pro, material admin, laravel dashboard, laravel dashboard pro, laravel admin, web dashboard, bootstrap 5 dashboard laravel, bootstrap 5, css3 dashboard, bootstrap 5 admin laravel, material dashboard bootstrap 5 laravel, frontend, responsive bootstrap 5 dashboard, material dashboard, material laravel bootstrap 5 dashboard" />
    <meta name="description" content="Fullstack tool for building Laravel apps with hundreds of UI components and ready-made CRUDs" />
    <meta itemprop="name" content="Material Dashboard 2 PRO Laravel by Creative Tim & UPDIVISION" />
    <meta itemprop="description" content="Fullstack tool for building Laravel apps with hundreds of UI components and ready-made CRUDs" />
    <meta itemprop="image" content="https://s3.amazonaws.com/creativetim_bucket/products/158/original/material-dashboard-pro-laravel.jpg" />
    <meta name="twitter:card" content="product" />
    <meta name="twitter:site" content="@creativetim" />
    <meta name="twitter:title" content="Material Dashboard 2 PRO Laravel by Creative Tim & UPDIVISION" />
    <meta name="twitter:description" content="Fullstack tool for building Laravel apps with hundreds of UI components and ready-made CRUDs" />
    <meta name="twitter:creator" content="@creativetim" />
    <meta name="twitter:image" content="https://s3.amazonaws.com/creativetim_bucket/products/158/original/material-dashboard-pro-laravel.jpg" />
    <meta property="fb:app_id" content="655968634437471" />
    <meta property="og:title" content="Material Dashboard 2 PRO Laravel by Creative Tim & UPDIVISION" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="https://www.creative-tim.com/live/material-dashboard-pro-laravel" />
    <meta property="og:image" content="https://s3.amazonaws.com/creativetim_bucket/products/158/original/material-dashboard-pro-laravel.jpg" />
    <meta property="og:description" content="Fullstack tool for building Laravel apps with hundreds of UI components and ready-made CRUDs" />
    <meta property="og:site_name" content="Creative Tim" />
  @endif --}}

  <!--     Fonts and icons     -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round&display=swap" rel="stylesheet">

  <!-- Nucleo Icons -->
  <link href="{{ asset('assets') }}/css/nucleo-icons.css" rel="stylesheet" />
  <link href="{{ asset('assets') }}/css/nucleo-svg.css" rel="stylesheet" />



  <!-- Font Awesome Icons -->
  {{-- <script src="https://kit.fontawesome.com/a1c828d5d0.js" crossorigin="anonymous"></script> --}}

  <link href="{{ asset('assets') }}/font-awesome/css/all.min.css" rel="stylesheet" />

  {{-- <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script> --}}
  {{-- <script src="https://kit.fontawesome.com/eed578d183.js" crossorigin="anonymous"></script> --}}

  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('assets') }}/css/material-dashboard.css?v=3.0.1" rel="stylesheet" />

</head>
<body class="{{ $bodyClass }}">

{{ $slot }}


<script src="{{ asset('assets') }}/js/core/popper.min.js"></script>
<script src="{{ asset('assets') }}/js/core/bootstrap.min.js"></script>
<script src="{{ asset('assets') }}/js/plugins/smooth-scrollbar.min.js"></script>


<!-- Kanban scripts -->
<script src="{{ asset('assets') }}/js/plugins/dragula/dragula.min.js"></script>
<script src="{{ asset('assets') }}/js/plugins/jkanban/jkanban.js"></script>
@stack('js')
<script>
  var win = navigator.platform.indexOf('Win') > -1;
  if (win && document.querySelector('#sidenav-scrollbar')) {
    var options = {
      damping: '0.5'
    }
    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
  }
</script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{ asset('assets') }}/js/material-dashboard.min.js?v=3.0.1"></script>

</body>
</html>
