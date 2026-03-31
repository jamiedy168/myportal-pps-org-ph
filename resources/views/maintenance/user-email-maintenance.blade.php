<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>

     <x-auth.navbars.sidebar activePage="maintenance" activeItem="email-maintenance" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-auth.navbars.navs.auth pageTitle="Email"></x-auth.navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="loading" id="loading" style="display: none !important"> 
                <img src="{{ asset('assets') }}/img/pps-logo.png" style="height: 60px !important; width: 60px !important" alt="img-blur-shadow" class="icons">
              </div>
          
            <div class="row">
                <div class="col-lg-2">

                </div>
                <div class="col-sm-12 col-lg-8">
                    <div class="card">
                        <div class="card-body p-3 position-relative">
                            <form method="POST" role="form text-left" id="maintenance-user-email-update" enctype="multipart/form-data">
                                @csrf
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="mb-2 mt-0">
                                        <h6 class="mb-0">Maintenance</h6>
                                        <p class="text-sm">Change email address</p>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-1">
                                            
                                        </div>
                                        <div class="col-12 col-lg-9">
                                            <label class="form-label text-bold">Current Email Address<code> <b>*</b></code></label>
                                          <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                            <input type="email" class="form-control" placeholder="Enter current email address" value="{{ auth()->user()->email }}">
                                          </div>
                                        </div>
                                        <div class="col-1">
                                            
                                        </div>
              
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-1">
                                            
                                        </div>
                                        <div class="col-12 col-lg-9">
                                            <label class="form-label text-bold">New Email Address<code> <b>*</b></code></label>
                                          <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                            <input type="email" required class="form-control" placeholder="Enter new email address" name="email_address" id="email_address">
                                          </div>
                                        </div>
                                        <div class="col-1">
                                            
                                        </div>
              
                                    </div>

                                    <input type="hidden" value="{{ url('user-maintenance-update-email') }}" id="urlUserMaintenanceResetEmail">
                                    <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">
                                    <input type="hidden" value="{{ auth()->user()->id }}" id="user_id">

                                     <div class="row mt-4 mb-3" style="text-align: right !important">
                                        <div class="col-md-10">
                                            <button type='submit' class="btn bg-gradient-danger mb-0">Update</button>
                                            <a type='button' href="/dashboard" class="btn bg-gradient-warning mb-0">Cancel</a>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-1">
                    
                </div>
            </div>

                
            <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
        </div>
    </main>
    <x-plugins></x-plugins>
    <link href="{{ asset('assets') }}/css/loader.css" rel="stylesheet" />
    @push('js')
    <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
    <script src="{{ asset('assets') }}/js/user-maintenance.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/chartjs.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/world.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/countup.min.js"></script>
    <script>


    </script>
    @endpush
</x-page-template>
