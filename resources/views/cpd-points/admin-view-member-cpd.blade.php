<x-page-template bodyClass='g-sidenav-show bg-gray-200'>
    <x-auth.navbars.sidebar activePage='cpdpoints' activeItem='cpdpoints-admin-view' activeSubitem=''></x-auth.navbars.sidebar>
    <main class="main-content main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-auth.navbars.navs.auth pageTitle='CPD Points'></x-auth.navbars.navs.auth>
       
        <div class="container-fluid my-3 py-4">
           

            <div class="row" style="margin-top: -20px !important">
                <div class="col-lg-4 col-12 h-100" >
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <div class="card ">
                       
                                <div class="card-body">
                                    <div class="row gx-3">
                                        <div class="col-auto">
                                            <div class="avatar avatar-xl position-relative">
                                                @if ($member->picture == null)
                                                    <img src="{{ asset('assets') }}/img/pps-logo.png"
                                                       class="w-100 rounded-circle shadow-sm" alt="image">
                                                @else
                                                    <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $member->picture, now()->addMinutes(230))}}"
                                                    class="w-100 rounded-circle shadow-sm" alt="image">
                                                @endif
                                                
                                            </div>
                                        </div>
                                        <div class="col-auto my-auto">
                                            <div class="h-100">
                                                <h6 class="mb-1">
                                                    {{ $member->first_name }} {{ $member->middle_name }} {{ $member->last_name }} {{ $member->suffix }}
                                                </h6>
                                                <p class="mb-0 font-weight-normal text-sm text-success">
                                                    {{ $member->type }}
                                                </p>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-12">
                                            
                                        </div>
                                    </div>
                                 
                                    <hr>

                                    <div class="row">
                                        <div class="col-md-12 col-12 mb-md-0 mb-4">
                                            <div class="card card-body border card-plain border-radius-lg ">
                                                <p style="text-align: center !important" class="text-md text-bold"> TOTAL CPD POINTS YEAR {{ now()->year }}</p>
                                                <h1 class="mb-0" style="text-align: center !important; font-size: 61px !important">
                                                 {{ $cpdpointsyearcount }}
                                                </h1>
                                               
                                               
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="row">
                                        <div class="col-12 col-lg-12">
                                            <div class="accordion" id="accordionRental">
                                                @foreach ($pointsPerYear as $year => $sumPoints)
                                                <div class="accordion-item my-2">
                                                    <h5 class="accordion-header" id="heading{{ $year }}">
                                                        <button class="accordion-button border-bottom font-weight-bold" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapse{{ $year }}" aria-expanded="false"
                                                            aria-controls="collapse{{ $year }}">
                                                           {{ $year }}
                                                            <i class="collapse-close material-icons text-sm font-weight-bold pt-1 position-absolute end-0 me-3">add</i>
                                                            <i class="collapse-open material-icons text-sm font-weight-bold pt-1 position-absolute end-0 me-3">remove</i>
                                                        </button>
                                                    </h5>
                                                    <div id="collapse{{ $year }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $year }}"
                                                        data-bs-parent="#accordionRental">
                                                        <div class="accordion-body text-sm opacity-8">
                                                            {{ $sumPoints }} POINTS &nbsp; &nbsp; - &nbsp; &nbsp;<a href="#" style="text-align: right !important" class="text-danger">Generate Certificate</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            
                                               
                                               
                                              
                                                
                                                
                                            </div>
                                        </div>
                                    </div> --}}
                                    <hr>

                                    <div class="row">
                                        <div class="col-12 col-lg-12">
                                            <div class="row">
                                                <div class="col-md-12 col-12">
                                                    <h6 class="mb-1 text-danger">List of Events</h6>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 col-12">
                                                    <ul class="list-group">
                                                        @foreach ($event as $event2)
                                                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                                            <div class="d-flex flex-column">
                                                                @if ($event2->cpd_points >= $event2->max_cpd) 
                                                                    <h6 class="mb-1 font-weight-bold text-xs">{{ $event2->title }} <span style="font-size: 12px !important; color: rgb(243, 56, 56) !important; font-weight: bold !important">({{ $event2->max_cpd }} POINTS) </span></h6>
                                                                @else
                                                                    <h6 class="mb-1 font-weight-bold text-xs">{{ $event2->title }} <span style="font-size: 12px !important;  color: rgb(243, 56, 56) !important; font-weight: bold !important">({{ $event2->cpd_points }} POINTS) </span></h6>
                                                                @endif
                                                                
                                                                <span class="text-xs mb-1">{{Carbon\Carbon::parse($event2->start_dt)->format('M. d, Y')}}</span>
                                                                @if ($event2->certificate_image != null)
                                                                    {{-- @if ($cpdpoints >= $event2->max_cpd ) --}}
                                                                    {{--FOR THE MEAN TIME CONDITION, CHECK IF CATEGORY IS SEMINAR --}}
                                                                        @if($event2->name == 'ANNUAL CONVENTION')
                                                                            <a target="blank_" href="{{ url('/event-download-certificate2/event/'.$event2->certificate_image.'/'.$event2->id.'/'.$ids) }}" class="text-danger text-sm"> Download Certificate</a>   
                                                                        @elseif ($event2->name == 'SEMINAR')    
                                                                            <a href="{{ url('/event-download-certificate-seminar-2/event/'.$event2->certificate_image.'/'.$event2->id.'/'.$ids) }}" class="text-danger text-sm"> Download Certificate</a>   
                                                                        @endif
                                                                       
                                                                    {{-- @else 
                                                                        <a href="#" class="text-danger text-sm" onclick="belowCPD()"> Download Certificate</a>   
                                                                    @endif --}}
                                                                @endif
                                                                
                                                            </div>
                                                         
                                                            </li>
                                                        @endforeach
                                                        
                                                      </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-12 h-100">
                    <div class="row">
               
                        <div class="col-lg-12 col-12 mb-3">
                            
                            <div class="card">
                                <div class="card-header pb-0 p-3">
                                    <form class="form-horizontal" action="{{ route('cpdpoints-admin-view-search-points', ['pps_no' => $pps_no]) }}" method="GET" autocomplete="off">
                                        @csrf
                                        <div class="row mt-4">
                                            <div class="col-lg-6"></div>
                                            <div class="col-lg-6 col-12">
                                                <div class="input-group input-group-outline">
                                                    <label class="form-label">Search here..</label>
                                                    <input type="text" class="form-control" name="searchinput" id="searchbox-input" value="{{ $name }}"  style="height: 46px !important">
                                                    <button class="btn bg-gradient-danger btn-lg" type="submit" id="searchBtn">
                                                        <i class="fas fa-search"></i></button>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                           
                                            <div class="col-lg-12 col-12" style="text-align: right !important">
                                                <code><a class="text-danger" href="/cpdpoints-admin-view-member/{{ $pps_no }}">Clear</a></code>
                                            </div>
                                        </div>
                                    </form>
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
