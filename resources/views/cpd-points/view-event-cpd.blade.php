<x-page-template bodyClass='g-sidenav-show bg-gray-200'>
    <x-auth.navbars.sidebar activePage='cpdpoints' activeItem='cpdpoints-member-view' activeSubitem=''></x-auth.navbars.sidebar>
    <main class="main-content main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-auth.navbars.navs.auth pageTitle='CPD Points'></x-auth.navbars.navs.auth>
       
        <div class="container-fluid my-3 py-4">
          

            <div class="row" id="refreshDiv">
                <div class="col-lg-12 col-12 h-100">
                    
                    
                    <div class="row">
               
                        <div class="col-lg-12 col-12 mb-3">
                            
                            <div class="card">
                                <div class="card-header pb-0 p-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="mb-0">{{ $event->title }} EARNED CPD POINTS</h6>
                                        </div>
                                        {{-- <div class="col-md-6 d-flex justify-content-end align-items-center">
                                            <i class="material-icons me-2 text-lg">date_range</i>
                                            <small>01 - 07 June 2021</small>
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <ul class="list-group">
                                        @foreach ($cpdpointsevent as $cpdpointsevent2)
                                            <li class="list-group-item border-0 justify-content-between ps-0 pb-0 border-radius-lg">
                                                <div class="d-flex">
                                                    <div class="d-flex align-items-center">
                                                        <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i class="material-icons text-lg">expand_less</i></button>
                                                        <div class="d-flex flex-column">
                                                            <h6 class="mb-1 text-dark text-sm">{{ $cpdpointsevent2->topic_name }}</h6>
                                                            <span class="text-xs">{{ Carbon\Carbon::parse($cpdpointsevent2->created_at)->format('d F Y') }}, at {{ Carbon\Carbon::parse($cpdpointsevent2->created_at)->format('h: i a') }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold ms-auto">
                                                        + {{ $cpdpointsevent2->points }}
                                                    </div>
                                                </div>
                                                <hr class="horizontal dark mt-3 mb-2">
                                            </li>
                                        @endforeach
                                        <br>
                                            
                                        {{ $cpdpointsevent->appends($_GET)->links('vendor.pagination.bootstrap-5') }}
                                     
                                    </ul>
                                </div>
                            </div>
                        </div>
        
                        
                       
                    </div>

                    

                    
                </div>
       

              
            </div>




         
            <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
        </div>
    </main>
    
    <x-plugins></x-plugins>
    <link href="{{ asset('assets') }}/css/loader.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/cpd-points.css" rel="stylesheet" />
    @push('js')
    <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets') }}/js/select2.min.js"></script>
    <link href="{{ asset('assets') }}/css/select2.min.css" rel="stylesheet" />
    <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
    <script src="{{ asset('assets') }}/js/cpd-points.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/chartjs.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>

    <!-- Kanban scripts -->

    {{-- <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script> --}}


  
    @endpush
</x-page-template>
