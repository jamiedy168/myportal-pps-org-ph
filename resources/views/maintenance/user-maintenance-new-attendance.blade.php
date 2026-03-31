
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="maintenance" activeItem="user-maintenance" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="New Attendance Admin User"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->

      <div class="container-fluid py-4">


        <form method="POST" id="user-maintenance-add-new-attendance" role="form text-left" enctype="multipart/form-data" >
            @csrf

            <input type="hidden" value="{{ url('user-maintenance-add-new-attendance') }}" id="urlUserMaintenanceAddNewAttendance">
            <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">
            <input type="hidden" name="password" id="password" value="123PPS">
            
            <div class="row mb-2 justify-content-md-center">
                <div class="col-lg-9 col-12">
                    <div class="card card-body" id="profile">
                     
                        
                        <div class="row mt-3">
                            <div class="col-12 col-lg-12">
                                <h5>Basic Information</h5>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-3 col-12">
                                <label class="form-label text-bold">First Name</label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                <input type="text" class="form-control" name="first_name" id="first_name" required>
                            </div>
                                
                            </div>
                            <div class="col-lg-3 col-12">
                                <label class="form-label text-bold">Middle Name</label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                <input type="text" class="form-control" name="middle_name" id="middle_name">
                            </div>
                            
                            </div>
                            <div class="col-lg-3 col-12">
                                <label class="form-label text-bold">Last Name</label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                <input type="text" class="form-control" name="last_name" id="last_name" required>
                            </div>
                            
                            </div>
                            <div class="col-lg-3 col-12">
                                <label class="form-label text-bold">Suffix</label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                <input type="text" class="form-control" name="suffix" id="suffix" >
                            </div>
                            
                            </div>
                        </div>

                         
                        <div class="row mt-2">
                            <div class="col-lg-12 col-12">
                                <label class="form-label text-bold">Email Address</label>
                                <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                    <input type="email" class="form-control" name="username" id="username" required>
                                </div>  
                            </div>
                        </div>
                      
                        <div class="row mt-4">
                            <div class="col-12 col-lg-12">
                                <button class="btn btn-danger" type="submit">SAVE</button>
                                <a class="btn btn-warning" href="/user-maintenance">Return</a>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
        </form>    
     
        <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
    </div>
    </main>
    <x-plugins></x-plugins>
    <link href="{{ asset('assets') }}/css/loader.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/user-maintenance.css" rel="stylesheet" />
  @push('js')

  <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('assets') }}/js/user-maintenance.js"></script>
  <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/datatables.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/choices.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/datatables.js"></script>
  <script src="{{ asset('assets') }}/js/select2.min.js"></script>
  <link href="{{ asset('assets') }}/css/select2.min.css" rel="stylesheet" />
    

    @endpush
  </x-page-template>
  