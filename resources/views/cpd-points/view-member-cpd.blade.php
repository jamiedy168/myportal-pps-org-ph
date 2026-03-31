<x-page-template bodyClass='g-sidenav-show bg-gray-200'>
    <x-auth.navbars.sidebar activePage='cpdpoints' activeItem='cpdpoints-member-view' activeSubitem=''></x-auth.navbars.sidebar>
    <main class="main-content main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-auth.navbars.navs.auth pageTitle='CPD Points'></x-auth.navbars.navs.auth>
       
        <div class="container-fluid my-3 py-4">
            {{-- <div class="loading" id="loading3"> 
                <img src="{{ asset('assets') }}/img/pps-logo.png" style="height: 60px !important; width: 60px !important" alt="img-blur-shadow" class="icons">
            </div> --}}

            {{-- <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="alert alert-warning" role="alert" style="color: white !important">
                        <strong>NOTE: Your CPD points will be updated within 24 hours.</strong>  
                    </div>
                </div>
            </div>  --}}

            {{-- <a href="{{ url('/event-download-certificate/event/ANNUALCONVENTIONCERFTIFICATE2024.jpg') }}">Download Image</a> --}}
          
            {{-- <div class="col-lg-12 col-12 h-100" >
            <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="card ">
                
                        <div class="card-body">
                            <div class="row gx-3">
                                <div class="col-auto">
                                    <div class="avatar avatar-xl position-relative">
                                            @if (auth()->user()->picture)
                                            <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . auth()->user()->picture, now()->addMinutes(240))}}" alt="profile_image"
                                            class="w-100 rounded-circle shadow-sm">
                                        @else
                                            <img src="{{ asset('assets') }}/img/default-avatar.png" alt="avatar"  class="w-100 rounded-circle shadow-sm">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-auto my-auto">
                                    <div class="h-100">
                                        <h6 class="mb-1">
                                            {{ $member->first_name }} {{ $member->middle_name }} {{ $member->last_name }}
                                        </h6>
                                        <p class="mb-0 font-weight-normal text-sm text-success">
                                            {{ $member->member_type_name }}
                                        </p>
                                    </div>
                                </div>
                                
                            </div>

                            
                            
                            <hr>


                            <div class="row">
                                <div class="col-12 col-lg-12">
                                    <div class="accordion" id="accordionRental">
                                        @foreach ($years as $year)
                                            <div class="accordion-item my-2">
                                                <h5 class="accordion-header" id="headingFour">
                                                    <button class="accordion-button border-bottom font-weight-bold" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapse{{ $year }}" aria-expanded="false"
                                                        aria-controls="collapseFour">
                                                        {{ $year }}
                                                        <i
                                                            class="collapse-close material-icons text-sm font-weight-bold pt-1 position-absolute end-0 me-3">add</i>
                                                        <i
                                                            class="collapse-open material-icons text-sm font-weight-bold pt-1 position-absolute end-0 me-3">remove</i>
                                                    </button>
                                                </h5>
                                                <div id="collapse{{ $year }}" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                                    data-bs-parent="#accordionRental">
                                                    <div class="accordion-body text-sm opacity-8 text-bold">
                                                        1 POINTS
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    
                                        
                                    </div>
                                </div>
                            </div>

                            
                        </div>
                    </div>
                </div>
            </div>
        </div> --}} 

        <div class="row" id="refreshDiv">
            <div class="col-lg-12 col-12 h-100">
                
                
                <div class="row">
           
                    <div class="col-lg-12 col-12 mb-3">
                        
                        <div class="card">
                            <div class="card-header pb-0 p-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="mb-0">Events/Seminar Points Earned</h6>
                                    </div>
                                    {{-- <div class="col-md-6 d-flex justify-content-end align-items-center">
                                        <i class="material-icons me-2 text-lg">date_range</i>
                                        <small>01 - 07 June 2021</small>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <div class="row gx-3">
                                    <div class="col-auto">
                                        <div class="avatar avatar-xl position-relative">
                                             @if (auth()->user()->picture)
                                                <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . auth()->user()->picture, now()->addMinutes(240))}}" alt="profile_image"
                                                class="w-100 rounded-circle shadow-sm">
                                            @else
                                                <img src="{{ asset('assets') }}/img/default-avatar.png" alt="avatar"  class="w-100 rounded-circle shadow-sm">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-auto my-auto">
                                        <div class="h-100">
                                            <h6 class="mb-1">
                                               {{ $member->first_name }} {{ $member->middle_name }} {{ $member->last_name }}
                                            </h6>
                                            <p class="mb-0 font-weight-normal text-sm text-success">
                                                {{ $member->member_type_name }}
                                            </p>
                                        </div>
                                    </div>
                                    
                                </div>
                                <br>
                                <ul class="list-group">
                                    @foreach ($event as $event2)
                                        <li class="list-group-item border-0 justify-content-between ps-0 pb-0 border-radius-lg">
                                            <div class="d-flex">
                                                <div class="d-flex align-items-center">
                                                    <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-chevron-up"></i></button>
                                                    <div class="d-flex flex-column">
                                                        @if ($event2->cpd_points >= $event2->max_cpd)
                                                            <h6 class="mb-1 text-dark text-sm">{{ $event2->title }} <code>({{ $event2->max_cpd }} POINTS</code>)</h6>
                                                        @else
                                                            <h6 class="mb-1 text-dark text-sm">{{ $event2->title }} <code>({{ $event2->cpd_points }} POINTS</code>)</h6>
                                                        @endif
                                                       
                                                        {{-- <span class="text-xs">{{ Carbon\Carbon::parse($cpdpointsevent2->created_at)->format('d F Y') }}, at {{ Carbon\Carbon::parse($cpdpointsevent2->created_at)->format('h: i a') }}</span> --}}
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center text-sm font-weight-bold ms-auto">
                                                    <div class="dropdown">
                                                        <button class="btn bg-gradient-danger dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                          Action
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                          <li><a class="dropdown-item" href="cpdpoints-view-event-cpd/{{ Crypt::encrypt( $event2->id )}}">View</a></li>
                                                          @if ($event2->certificate_image != null)
                                                            {{-- @if ($cpdpoints >= $event2->max_cpd ) --}}
                                                            {{--FOR THE MEAN TIME CONDITION, CHECK IF CATEGORY IS SEMINAR --}}
                                                                @if($event2->name == 'ANNUAL CONVENTION')
                                                                    <li><a class="dropdown-item" href="{{ url('/event-download-certificate/event/'.$event2->certificate_image.'/'.$event2->id) }}">Download Certificate</a></li>
                                                                @elseif($event2->name == 'SEMINAR')
                                                                    <li><a class="dropdown-item" href="{{ url('/event-download-certificate-seminar/event/'.$event2->certificate_image.'/'.$event2->id) }}">Download Certificate</a></li>
                                                                @endif
                                                                
                                                            {{-- @else   
                                                            <li><a class="dropdown-item" href="#" onclick="belowCPD()">Download Certificate</a></li>
                                                            @endif --}}
                                                           
                                                          @endif
                                                          
                                                        
                                                        </ul>
                                                      </div>
                                                </div>
                                            </div>
                                            <hr class="horizontal dark mt-3 mb-2">
                                        </li>
                                    @endforeach
                                    <br>
                                        
                                   
                                </ul>
                            </div>
                        </div>
                    </div>
    
                    
                   
                </div>

                

                
            </div>
            {{-- <div class="col-lg-4 col-12 h-100" >
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="card ">
                   
                            <div class="card-body">
                                <div class="row gx-3">
                                    <div class="col-auto">
                                        <div class="avatar avatar-xl position-relative">
                                             @if (auth()->user()->picture)
                                                <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . auth()->user()->picture, now()->addMinutes(240))}}" alt="profile_image"
                                                class="w-100 rounded-circle shadow-sm">
                                            @else
                                                <img src="{{ asset('assets') }}/img/default-avatar.png" alt="avatar"  class="w-100 rounded-circle shadow-sm">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-auto my-auto">
                                        <div class="h-100">
                                            <h6 class="mb-1">
                                               {{ $member->first_name }} {{ $member->middle_name }} {{ $member->last_name }}
                                            </h6>
                                            <p class="mb-0 font-weight-normal text-sm text-success">
                                                {{ $member->member_type_name }}
                                            </p>
                                        </div>
                                    </div>
                                    
                                </div>

                                
                             
                                <hr>

                                <div class="row">
                                    <div class="col-md-12 col-12 mb-md-0 mb-4">
                                        <div class="card card-body border card-plain border-radius-lg ">
                                            <p style="text-align: center !important" class="text-md text-bold">TOTAL CPD POINTS</p>
                                            <h1 class="mb-0 text-danger" style="text-align: center !important; font-size: 61px !important">
                                              {{ $cpdpoints }}
                                            </h1>
                                           
                                           
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-lg-12">
                                        <div class="accordion" id="accordionRental">

                                            <div class="accordion-item my-2">
                                                <h5 class="accordion-header" id="headingFour">
                                                    <button class="accordion-button border-bottom font-weight-bold" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapse2024" aria-expanded="false"
                                                        aria-controls="collapseFour">
                                                        2024
                                                        <i
                                                            class="collapse-close material-icons text-sm font-weight-bold pt-1 position-absolute end-0 me-3">add</i>
                                                        <i
                                                            class="collapse-open material-icons text-sm font-weight-bold pt-1 position-absolute end-0 me-3">remove</i>
                                                    </button>
                                                </h5>
                                                <div id="collapse2024" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                                    data-bs-parent="#accordionRental">
                                                    <div class="accordion-body text-sm opacity-8 text-bold">
                                                        {{ $cpdpointsyear2024 }} POINTS
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="accordion-item my-2">
                                                <h5 class="accordion-header" id="headingFour">
                                                    <button class="accordion-button border-bottom font-weight-bold" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false"
                                                        aria-controls="collapseFour">
                                                        2023
                                                        <i
                                                            class="collapse-close material-icons text-sm font-weight-bold pt-1 position-absolute end-0 me-3">add</i>
                                                        <i
                                                            class="collapse-open material-icons text-sm font-weight-bold pt-1 position-absolute end-0 me-3">remove</i>
                                                    </button>
                                                </h5>
                                                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                                    data-bs-parent="#accordionRental">
                                                    <div class="accordion-body text-sm opacity-8 text-bold">
                                                        N/A
                                                    </div>
                                                </div>
                                            </div>
                                           
                                            <div class="accordion-item my-2">
                                                <h5 class="accordion-header" id="headingTwo">
                                                    <button class="accordion-button border-bottom font-weight-bold" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                                        aria-controls="collapseTwo">
                                                        2022
                                                        <i
                                                            class="collapse-close material-icons text-sm font-weight-bold pt-1 position-absolute end-0 me-3">add</i>
                                                        <i
                                                            class="collapse-open material-icons text-sm font-weight-bold pt-1 position-absolute end-0 me-3">remove</i>
                                                    </button>
                                                </h5>
                                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                                    data-bs-parent="#accordionRental">
                                                    <div class="accordion-body text-sm opacity-8 text-bold">
                                                       N/A
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item my-2">
                                                <h5 class="accordion-header" id="headingThree">
                                                    <button class="accordion-button border-bottom font-weight-bold" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false"
                                                        aria-controls="collapseThree">
                                                        2021
                                                        <i
                                                            class="collapse-close material-icons text-sm font-weight-bold pt-1 position-absolute end-0 me-3">add</i>
                                                        <i
                                                            class="collapse-open material-icons text-sm font-weight-bold pt-1 position-absolute end-0 me-3">remove</i>
                                                    </button>
                                                </h5>
                                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                                    data-bs-parent="#accordionRental">
                                                    <div class="accordion-body text-sm opacity-8 text-bold">
                                                        N/A
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                        </div>
                                    </div>
                                </div>

                               
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

          
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
