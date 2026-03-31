<x-page-template bodyClass='g-sidenav-show bg-gray-200'>
    <style>
        .select2-container {
        height: 100%;
      
      }
      
      .select2-container {
        width: 100% !important;
        
      }
      
      
      
      .select2-container .select2-selection--single {
        height: 37px !important;
       
      }
      
      
      
      .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #d2d6da;
        margin: 3px;
      
      }
      
      
      
      .select2-results__options {
        font-weight: 400;
        font-size: 0.8571em;
      }
    </style>
    
        <div class="container-fluid px-5 my-6">
    
           
            
            <div class="row" id="topic_details">
                <div class="col-lg-4 col-12 mb-lg-0 mb-4 mx-auto">
                    <div class="card shadow-lg">
                     
                        
                        
                        <div class="card-header text-center pt-4 pb-3">
                            <div class="row mt-1">
                                <div class="col-12 col-md-12 col-lg-12 text-center">
                                    <img src="{{ asset('assets') }}/img/illustrations/pps-logo.png" alt="avatar" class="rounded-circle shadow-sm" style="height: 120px !important; width: 120px !important">
                                
                                </div>
                            </div>
                            <br>
                            <h5 class="mt-2">
                                Attention! The QR code you scanned is no longer valid. Kindly take note of this and avoid using it moving forward. Thank you for your understanding and cooperation.
                            </h5>
                            <br>
                            <br>

                            <a href="/sign-in"
                                    class="btn btn-icon bg-gradient-danger w-100 d-lg-block mt-3 mb-0" id="attendance_only_choose">
                                    RETURN TO PORTAL
                                    
                            </a>
                            <br>
                            
                        </div>
                     
                    </div>
                </div>
            </div>
    
         
            
       
        
    
        </div>
        <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
        <x-auth.footers.guest.social-icons-footer></x-auth.footers.guest.social-icons-footer>
        <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
      
        <x-plugins></x-plugins>
        @push('js')
        

        <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
        <script src="{{ asset('assets') }}/js/select2.min.js"></script>
        <link href="{{ asset('assets') }}/css/select2.min.css" rel="stylesheet" />
        <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
        <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
        <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>  
       
        @endpush
    </x-page-template>
    