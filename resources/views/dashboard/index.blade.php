<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>

    <style>
        /* Force SweetAlert2 to sit on top of everything */
        .swal2-container {
            z-index: 99999 !important;
        }
        .swal2-popup {
            z-index: 100000 !important;
        }

    </style>
    <x-auth.navbars.sidebar activePage="dashboard" activeItem="analytics" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-auth.navbars.navs.auth pageTitle="Dashboard"></x-auth.navbars.navs.auth>
        <!-- End Navbar -->
       
        <div class="container-fluid py-4">

            <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="alert alert-success" role="alert" style="color: white !important">
                        <strong>Welcome to Philippine Pediatric Society Membership Portal.</strong> This is your dashboard. 
                    </div>
                </div>
            </div> 
            {{-- <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="alert alert-warning" role="alert" style="color: white !important">
                        <strong>NOTE: Your CPD points will be updated within 24 hours.</strong>  
                    </div>
                </div>
            </div>  --}}
             <input type="hidden" id="role_id" value="{{ auth()->user()->role_id }}">

            <div class="row">
                <div class="col-12 col-lg-8 col-md-12">
                    <div class="row mb-2">
                        <div class="col-md-4 col-sm-6 col-6 mb-2">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <h1 class="text-gradient text-danger"> <span id="status2" countto="{{ $cpdpoints }}">{{ $cpdpoints }}</span> <span
                                            class="text-lg ms-n1"></span></h1>
                                    <h6 class="mb-0 font-weight-bolder">CPD Points</h6>
                                    <p class="opacity-8 mb-0 text-sm">Your total CPD points</p>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-4 col-sm-6 col-6 mb-2">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <h1 class="text-gradient text-danger"> <span id="status2" countto="">N/A</span> <span
                                            class="text-lg ms-n1"></span></h1>
                                    <h6 class="mb-0 font-weight-bolder">Events/Seminars</h6>
                                    <p class="opacity-8 mb-0 text-sm">Total Events/Seminar Attended</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-6 mb-2">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <h1 class="text-gradient text-danger"> <span id="status2" countto="">N/A</span> <span
                                            class="text-lg ms-n1"></span></h1>
                                    <h6 class="mb-0 font-weight-bolder">Payment</h6>
                                    <p class="opacity-8 mb-0 text-sm">Total Pending Payments</p>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                 
                    <input type="hidden" value="{{ auth()->user()->pps_no }}" id="pps_no">
                    <input type="hidden" 
                        name="second_completed_profile" 
                        value="{{ $member?->second_completed_profile }}" 
                        id="second_completed_profile">

                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body p-3 position-relative">
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <div class="mb-5 mt-0">
                                                <h6 class="mb-0 text-danger">Upcoming Events</h6>
                                                <p class="text-sm">List of upcoming events.</p>
                                                
                                            </div>
                                            <div class="row mt-5">
                                               
                                                @foreach ($event as $events)
                                                    <div class="col-xl-4 col-md-6 mb-xl-0 mb-4 mb-7">
                                                        <div class="card card-blog card-plain h-100">
                                                            
                                                            <div class="card-header p-0 mt-n4 mx-3">
                                                                <a class="d-block shadow-xl border-radius-xl">
                                                                    @if ($events->event_image == null)
                                                                        <img  src="{{ asset('assets') }}/img/pps-logo.png"
                                                                        alt="img-blur-shadow" class="img-fluid shadow border-radius-xl mt-4">
                                                                    @else
                                                                        <img  src="{{Storage::disk('s3')->temporaryUrl('event/' . $events->event_image, now()->addMinutes(230))}}"
                                                                            alt="img-blur-shadow" class="img-fluid shadow border-radius-xl">
                                                                    @endif
                                                                </a>
                                                            </div>
                                                            <div class="card-body p-3">
                                                                <p class="mb-0 text-sm">Event</p>

                                                                {{-- Start of hidden input --}}
                                                                    <input type="hidden" value="{{ url('event-check-joined') }}" id="urlEventCheckJoined">
                                                                    <input type="hidden" id="token2" name="token2" value="{{ csrf_token() }}">

                                                                    
                                                                    <input type="hidden" value="{{ url('voting-check-allowed') }}" id="urlVotingCheckAllowed">
                                                                {{-- End of hidden input --}}
                                                                <a href="javascript:;">
                                                                    <h5>
                                                                        {{ $events->title }}
                                                                    </h5>
                                                                </a>
                                                                <p class="mt-2 text-xs">
                                                                    {{ $events->description }}
                                                                </p>

                                                                <p class="text-xs">
                                                                    {{Carbon\Carbon::parse($events->start_dt)->format('M. d, Y')}} -  {{Carbon\Carbon::parse($events->end_dt)->format('M. d, Y')}}
                                                                </p>

                                                                
                        
                                                                <p class="text-xs mb-2" style="margin-top: -15px !important">
                                                                    {{Carbon\Carbon::parse($events->start_time)->format('h:i a')}} - {{Carbon\Carbon::parse($events->end_time)->format('h:i a')}} 
                                                                </p>

                                                            
                                                                    <p class="mb-4 text-sm text-danger">
                                                                        @if ($events->paid == true)
                                                                            <span class="badge badge-success badge-sm">
                                                                                        PAID
                                                                            </span>
                                                                        @endif    
                                                                        @if ($events->selected_members == true)
                                                                            <span class="badge badge-warning badge-sm">
                                                                                        SELECTED PARTICIPANTS
                                                                            </span>
                                                                        @endif    
                                                                    </p>
                                                                
                                                               
                                                               

                                                                <div class="d-flex align-items-center justify-content-between">
                                                                    
                                                                    {{-- CHECK IF USER IS ADMIN  OR CASHIER --}}
                                                                    @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 4)
                                                                        <button type="button" class="btn btn-outline-primary btn-sm mb-0 btnEventJoinDashboard" id="btnEventJoinDashboard" data-event-id="{{ $events->id }}" data-event-price="{{ $events->prices }}">
                                                                            Pay to Join
                                                                        </button>

                                                                        <div class="avatar-group mt-0">
                                                                            ₱ 0.00
                                                                        </div>
                                                                    @else


                                                                        
                                                                       
                                                                                                                                                    {{-- CHECK IF USER IS VIP --}}
                                                                        @if ($member->vip == true)
                                                                            <a type="button" class="btn btn-outline-primary btn-sm mb-0" href="event-view/{{ Crypt::encrypt( $events->id )}}">
                                                                                VIEW EVENT
                                                                            </a>

                                                                            <div class="avatar-group mt-0">
                                                                                ₱ 0.00
                                                                            </div>
                                                                        @endif  

                                                                        {{-- CHECK IF USER IS FOREIGN DELEGATE --}}
                                                                        @if ($member->member_type_name == "FOREIGN DELEGATE")
                                                                            @if ($events->paid == true)
                                                                                <a type="button" class="btn btn-outline-primary btn-sm mb-0" href="event-view/{{ Crypt::encrypt( $events->id )}}">
                                                                                    VIEW EVENT
                                                                                </a>
                                                                            @else
                                                                                @if ($events->payment_open == true)
                                                                                    <button type="button" class="btn btn-outline-primary btn-sm mb-0 btnEventJoinDashboard" id="btnEventJoinDashboard" data-event-id="{{ $events->id }}" data-event-price="{{ $events->prices }}">
                                                                                        Pay to Join
                                                                                    </button>
                                                                                @else
                                                                                    <button type="button" class="btn btn-outline-primary btn-sm mb-0" onclick="btnEventPaymentCloseBtn()">
                                                                                        Pay to Join
                                                                                    </button>
                                                                                @endif
                                                                            @endif
                                                                            

                                                                            <div class="avatar-group mt-0">
                                                                                $ {{ number_format($events->prices, 2) }} 
                                                                            </div>
                                                                        @endif  

                                                                        {{-- CHECK IF USER IS REGULAR MEMBER --}}
                                                                        @if ($member->member_type_name != "FOREIGN DELEGATE" && $member->vip != true)
                                                                        
                                                                                @if ($events->paid == true)
                                                                                    <a type="button" class="btn btn-outline-primary btn-sm mb-0" href="event-view/{{ Crypt::encrypt( $events->id )}}">
                                                                                        VIEW EVENT
                                                                                    </a>
                                                                                @else
                                                                                    @if ($events->payment_open == true)
                                                                                        <button type="button" class="btn btn-outline-primary btn-sm mb-0 btnEventJoinDashboard" id="btnEventJoinDashboard" data-event-id="{{ $events->id }}" data-event-price="{{ $events->prices }}">
                                                                                            Pay to Join
                                                                                        </button>
                                                                                    @else
                                                                                        <button type="button" class="btn btn-outline-primary btn-sm mb-0" onclick="btnEventPaymentCloseBtn()">
                                                                                            Pay to Join
                                                                                        </button>
                                                                                    @endif
                                                                                @endif
                                                                        
                                                                        

                                                                            <div class="avatar-group mt-0">
                                                                                ₱ {{ number_format($events->prices, 2) }} 
                                                                            </div>
                                                                        @endif  

                                                                        
                                                            
                                                                    @endif   
                                                                                       
                                                                    
                                                                </div>
                                                            </div>

                                                          
                                                        </div>
                                                    </div>
                                                @endforeach


                                                @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 4)
                                                    @foreach ($voting as $voting2)
                                                        <div class="col-xl-4 col-md-6 mb-xl-0 mb-4 mb-7">
                                                            <div class="card card-blog card-plain h-100">
                                                                
                                                                <div class="card-header p-0 mt-n4 mx-3">
                                                                    <a class="d-block shadow-xl border-radius-xl">
                                                                        @if ($voting2->picture == null)
                                                                            <img  src="{{ asset('assets') }}/img/pps-logo.png"
                                                                            alt="img-blur-shadow" class="img-fluid shadow border-radius-xl">
                                                                        @else
                                                                            <img src="{{Storage::disk('s3')->temporaryUrl('others/' . $voting2->picture, now()->addMinutes(230))}}"
                                                                                alt="img-blur-shadow" class="img-fluid shadow border-radius-xl">
                                                                        @endif
                                                                    </a>
                                                                </div>
                                                                <div class="card-body p-3">
                                                                    <p class="mb-0 text-sm">Election</p>

                                                                
                                                                    <a href="javascript:;">
                                                                        <h5>
                                                                        {{ $voting2->title }}
                                                                        </h5>
                                                                    </a>
                                                                    <p class="mb-0 text-xs" style="white-space: pre-wrap !important; margin-top: -30px !important">
                                                                        {{ $voting2->description }}
                                                                    </p>

                                                                    <p class="text-xs">
                                                                        {{Carbon\Carbon::parse($voting2->date_from)->format('M. d, Y')}} -  {{Carbon\Carbon::parse($voting2->date_to)->format('M. d, Y')}}
                                                                    </p>

                                                                    <p class="text-xs mb-2" style="margin-top: -15px !important">
                                                                        {{Carbon\Carbon::parse($voting2->time_from)->format('h:i a')}} - {{Carbon\Carbon::parse($voting2->time_to)->format('h:i a')}} 
                                                                    </p>
                                                                    <p class="mb-4 text-sm text-danger">
                                                                        
                                                                            <span class="badge badge-warning badge-sm">
                                                                            UPCOMING
                                                                            </span>
                                                                    </p>
                                                                    
         
                                                                    <div class="d-flex align-items-center justify-content-between">
                                                                        <button type="button" onclick="adminnotallowedvote()" class="btn btn-outline-primary btn-sm mb-0 w-100">
                                                                            VOTE NOW
                                                                        </button>
                                                                
                                                 
                                                                    </div>
                                                                </div>

                                                            
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @elseif ($member->member_type_name == "DIPLOMATE" || $member->member_type_name == "FELLOW" || $member->member_type_name == "EMERITUS FELLOW")
                                                    @foreach ($voting as $voting2)
                                                        <div class="col-xl-4 col-md-6 mb-xl-0 mb-4 mb-7">
                                                            <div class="card card-blog card-plain h-100">
                                                                <div class="card-header p-0 mt-n4 mx-3">
                                                                    <a class="d-block shadow-xl border-radius-xl">
                                                                        @if ($voting2->picture == null)
                                                                            <img  src="{{ asset('assets') }}/img/pps-logo.png"
                                                                            alt="img-blur-shadow" class="img-fluid shadow border-radius-xl">
                                                                        @else
                                                                            <img src="{{Storage::disk('s3')->temporaryUrl('others/' . $voting2->picture, now()->addMinutes(230))}}"
                                                                                alt="img-blur-shadow" class="img-fluid shadow border-radius-xl">
                                                                        @endif
                                                                    </a>
                                                                </div>
                                                                <div class="card-body p-3">
                                                                    <p class="mb-0 text-sm">Election</p>

                                                                    <a href="javascript:;">
                                                                        <h5>
                                                                        {{ $voting2->title }}
                                                                        </h5>
                                                                    </a>
                                                                    <p class="mb-0 text-xs" style="white-space: pre-wrap !important; margin-top: -30px !important">
                                                                        {{ $voting2->description }}
                                                                    </p>

                                                                    <p class="text-xs">
                                                                        {{Carbon\Carbon::parse($voting2->date_from)->format('M. d, Y')}} -  {{Carbon\Carbon::parse($voting2->date_to)->format('M. d, Y')}}
                                                                    </p>

                                                                    <p class="text-xs mb-2" style="margin-top: -15px !important">
                                                                        {{Carbon\Carbon::parse($voting2->time_from)->format('h:i a')}} - {{Carbon\Carbon::parse($voting2->time_to)->format('h:i a')}} 
                                                                    </p>
                                                                    <p class="mb-4 text-sm text-danger">
                                                                            @if ($voting2->status == "ONGOING")
                                                                                <span class="badge badge-danger badge-sm">
                                                                                    {{ $voting2->status }}
                                                                                </span>
                                                                            @elseif($voting2->status == "UPCOMING")
                                                                                <span class="badge badge-warning badge-sm">
                                                                                    {{ $voting2->status }}
                                                                                </span>
                                                                            @else
                                                                                <span class="badge badge-success badge-sm">
                                                                                    {{ $voting2->status }}
                                                                                </span>    
                                                                            @endif
                                                                            
                                                                    </p>
                                                                    
                                                                
                                                                

                                                                    <div class="d-flex align-items-center justify-content-between">

                                                                        @if ($member->member_type_name == "DIPLOMATE" || $member->member_type_name == "FELLOW" || $member->member_type_name == "EMERITUS FELLOW")
                                                                            @if ($voting2->status == "ONGOING")
                                                                                <button type="button" class="btn btn-outline-primary btn-sm mb-0 votenow w-100" id="{{ $voting2->id }}">VOTE NOW</button>
                                                                            @else
                                                                                <button type="button" disabled class="btn btn-outline-primary btn-sm mb-0 votenow w-100" onclick="votingClose()">VOTE NOW</button>
                                                                            @endif 
                                                                        @else
                                                                            <button type="button" onclick="notallowedvote()" class="btn btn-outline-primary btn-sm mb-0 w-100">
                                                                                VOTE NOW
                                                                            </button>
                                                                                
                                                                
                                                                        @endif
                                                                        
                                                                                        
                                                                        
                                                                    </div>
                                                                </div>

                                                            
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                                
                                              
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4 col-md-12">
                    <div class="card h-100">
                        <div class="card-header pb-0 text-left">
                            <div class="row">
                                <div class="col-11">
                                    <h5 class="text-gradient text-danger">Recent Transaction</h5>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush list mt-0" style="margin-top: -15px !important; ">
                                @forelse ($ormaster as $ormaster2)
                                    <li class="list-group-item px-0 border-0">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <h6 class="text-sm font-weight-normal mb-0">{{ $loop->iteration }}</h6>
                                        </div>
                                        <div class="col">
                                        <p class="text-xs font-weight-bold mb-0 text-danger">DESCRIPTION</p>
                                        <h6 class="text-sm font-weight-normal mb-0">{{ $ormaster2->description }} {{ $ormaster2->year_dues }}{{ $ormaster2->title }}</h6>
                                        </div>
                                    
                                        <div class="col text-center">
                                        <p class="text-xs font-weight-bold mb-0 text-danger">STATUS</p>
                                        <h6 class="text-sm font-weight-bold mb-0 text-success">PAID</h6>
                                        
                                        </div>
                                    </div>
                                    <hr class="horizontal dark mt-3 mb-1">
                                    </li>
                                @empty
                                    <p style="margin-top: -15px !important; text-align: center !important">No transaction found.</p>
                                @endforelse
                             
                              </ul>
                        </div>
                      </div>
                </div>      
            </div>
    
            <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
        </div>
    </main>
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
    <x-plugins></x-plugins>
    @push('js')
    <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/chartjs.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/world.js"></script>
    <script src="{{ asset('assets') }}/js/dashboard.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/countup.min.js"></script>
    <script>


    </script>
    @endpush
</x-page-template>
