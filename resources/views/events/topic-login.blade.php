<x-page-template bodyClass='g-sidenav-show bg-gray-200'>
  
    <main class="main-content main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
     
       
        <div class="container-fluid my-3 ">
        

              <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-2">
                      
                        <div class="card-body p-3">
                            <h5 class="mb-4 text-gradient text-danger">Login</h5>
                            <div class="row mt-1">
                                <div class="col-3 text-center">
                                    <button class="btn btn-danger">
                                        dsadsadsa
                                    </button>
                                </div>
                            </div>
                           
                          
                        



                        </div>
                    </div>
                </div>

              </div>

        



            
                
            </div>
    </main>
    <x-plugins></x-plugins>
    <link href="{{ asset('assets') }}/css/event.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/loader.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/event-create-upload-image.css" rel="stylesheet" />
    @push('js')
    <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets') }}/js/event.js"></script>
    <script src="{{ asset('assets') }}/js/select2.min.js"></script>
    <link href="{{ asset('assets') }}/css/select2.min.css" rel="stylesheet" />
    <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/photoswipe.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/photoswipe-ui-default.min.js"></script>
    <script src="{{ asset('assets') }}/js/event-update-upload-image.js"></script>
    <script src="{{ asset('assets') }}/js/moment.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/choices.min.js"></script>

    <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>
    <!-- Kanban scripts -->
  
    @endpush
</x-page-template>
