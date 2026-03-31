<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>

    <x-auth.navbars.sidebar activePage="" activeItem="" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-auth.navbars.navs.auth pageTitle="Dashboard"></x-auth.navbars.navs.auth>
        <!-- End Navbar -->
       
        <div class="container-fluid py-4">
            <br>
       
            <div class="row mb-0">
                <div class="col-md-6 mx-auto text-center">
                    <img src="{{ asset('assets') }}/img/pps-logo.png" height="90%" width="50%">
                                                   
                   
                </div>
            </div>
            <div class="row mt-0">
                <div class="col-md-6 mx-auto text-center">
                    <h2 class="text-danger">Temporarily Unavailable</h2>
                    <p class="text-secondary">We are currently performing emergency maintenance on the payment module of our PPS portal system. We anticipate it will be operational shortly. We apologize for any inconvenience this may cause.</p>
                </div>
            </div>
           

            {{-- START OF MODAL CHANGE PASSWORD --}}
            <div class="modal fade" id="modal-change-password" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
                <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                    <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h6 class="text-white modal-title">CHANGE PASSWORD</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        
                            
                        </button>
                    </div>
                   
                    <form method="POST" id="change-default-password" enctype="multipart/form-data" >
                        @csrf    
                        
                        <div class="modal-body">
                            <input type="hidden" id="session_default_password" value="{{ auth()->user()->default_password }}">
                            <input type="hidden" id="session_user_id" value="{{ auth()->user()->id }}">
                          
                            <input type="hidden" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" value="{{ url('change-default-password') }}" id="urlChangeDefaultPassword">
                            <div class="row">
                                <div class="col-lg-12 col-12">
                                    <label class="form-label text-bold">New Password<code> <b>*</b></code></label>
                                    <div class="input-group input-group-outline" id="passwordDiv" style="margin-top: -5px !important">
                                    <input type="password" class="form-control" name="password" id="password">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-12">
                                    <label class="form-label text-bold">Re-type new Password<code> <b>*</b></code></label>
                                    <div class="input-group input-group-outline" id="passwordDiv2" style="margin-top: -5px !important">
                                    <input type="password" class="form-control password" name="re-password" id="re-password">
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="display:none !important" id="notMatchRow">
                                <div class="col-lg-12 col-12">
                                    <label class="form-label text-bold text-danger">Password does not match!</label>  
                                </div>
                            </div>
                            <div class="row" style="display:none !important" id="matchRow">
                                <div class="col-lg-12 col-12">
                                    <label class="form-label text-bold text-success">Password match!</label>  
                                </div>
                            </div>
                        

                
                        </div>
                        <div class="modal-footer" style="border-top: none !important">
                            <button type="submit" id="btn-change-default-password" class="btn btn-gradient btn-danger">Save</button>
                            <button type="button" class="btn btn-link ml-auto" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                    </div>
                </div>
                </div>
                {{-- END OF MODAL CHANGE PASSWORD --}}

                
            <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
        </div>
    </main>
    <x-plugins></x-plugins>
    @push('js')
    <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
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
