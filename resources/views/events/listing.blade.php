
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="events" activeItem="listing" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="Events"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->
      <div class="container-fluid py-4">
        {{-- <div class="loading" id="loading2"> 
            <img src="{{ asset('assets') }}/img/pps-logo.png" style="height: 60px !important; width: 60px !important" alt="img-blur-shadow" class="icons">
        </div> --}}
      <div class="card card-body mx-3 mx-md-4 ">
          
        <div class="row mt-4">
            <div class="col-12">
                <div class="mb-5 ps-3">
                    <h6 class="mb-1">Events</h6>
                    <p class="text-sm">List of all events.</p>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="input-group input-group-outline">
                            <label class="form-label">Search here..</label>
                            <input type="text" class="form-control" id="searchbox-input" style="height: 46px !important">
                            <button class="btn bg-gradient-danger btn-lg" id="searchBtn"><i class="material-icons">search</i></button>
                            </div>
                    </div>
                    
                </div>
                

           
                <div class="row">
                    <div class="col-lg-4 col-md-6 ">
                        <div class="nav-wrapper position-relative end-0">
                            <ul class="nav nav-pills nav-fill p-1" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1 active btnStatus" data-bs-toggle="tab" 
                                        role="tab" aria-selected="true" category-one="all">
                                        
                                        <span class="ms-1">ALL</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1 btnStatus" data-bs-toggle="tab" 
                                        role="tab" aria-selected="false" category-one="UPCOMING">
                                        
                                        <span class="ms-1">UPCOMING</span>
                                </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1 btnStatus" data-bs-toggle="tab"
                                        role="tab" aria-selected="false" category-one="ONGOING" >
                                        
                                        <span class="ms-1">ONGOING</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1 btnStatus" data-bs-toggle="tab"
                                        role="tab" aria-selected="false" category-one="COMPLETED" >
                                        
                                        <span class="ms-1">COMPLETED</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                <br>
                <br>
                <div class="tab-content tab-space">
                    <div class="tab-pane active" id="all">
                        <div class="row">
                            @foreach ($event as $events)
                                @php
                                    $isAdmin = auth()->user()->role_id == 1 || auth()->user()->role_id == 4;
                                    $memberType = optional($member)->member_type_name;
                                    $isVip = (bool) optional($member)->vip;
                                    $pricePhp = $events->prices ?? 0;
                                @endphp
                                <div class="col-xl-3 col-md-6 mb-xl-0 mb-4 mt-3 cardEvent filtered" category="{{ $events->status }}">
                                    <div class="card h-100 shadow-lg">
                                        <div class="card-header p-0 mx-3">
                                            @if ($events->event_image == null)
                                            
                                                <a class="d-block shadow-xl border-radius-xl">
                                                    <img src="{{ asset('assets') }}/img/pps-logo.png" style="width: 100% !important; height: 150px !important"
                                                        alt="event-image" class="img-fluid shadow border-radius-xl">
                                                </a>
                                            
                                            @else
                                            
                                                <a class="d-block shadow-xl border-radius-xl">
                                                    
                                                    <img src="{{Storage::disk('s3')->temporaryUrl('event/' . $events->event_image, now()->addMinutes(230))}}"
                                                        alt="event-image" class="img-fluid shadow border-radius-xl">
                                                </a>
                                            
                                                
                                            @endif
                                            {{-- <a class="d-block shadow-xl border-radius-xl">
                                                <img  src="{{URL::asset('/img/event/'.$events->event_image)}}"
                                                    alt="event-image" class="img-fluid shadow border-radius-xl">
                                            </a> --}}
                                        </div>
                                        <div class="card-body ">
                                            <div class="row">
                                                <div class="col-9">
                                                    <a href="javascript:;">
                                                        <h6>
                                                            {{ $events->title }}    
                                                        </h6>
                                                    </a>
                                                </div>
                                                <div class="col-3">
                                                    @if (auth()->user()->role_id == 1)
                                                    <a href="event-update/{{ Crypt::encrypt( $events->id )}}" class="btn btn-link btn-icon-only btn-rounded text-warning icon-move-right my-auto" style="margin-top: -5px !important">
                                                        <i class="material-icons" aria-hidden="true">edit</i>
                                                    
                                                    </a>
                                                    @endif
                                                </div>
                                            </div>

                                            
                                           
                                           
                                            <p class="mb-0 text-uppercase text-secondary text-xs  opacity-7">
                                                {{Carbon\Carbon::parse($events->start_dt)->format('M. d, Y')}}  - {{Carbon\Carbon::parse($events->end_dt)->format('M. d, Y')}}
                                          
                                                &nbsp;
                                            
                                            </p>   
                                            <p class="mb-0 text-uppercase text-secondary text-xs opacity-7"> 
                                                {{Carbon\Carbon::parse($events->start_time)->format('h:i a')}} - {{Carbon\Carbon::parse($events->end_time)->format('h:i a')}} 
                                            </p>
                                           
                                            <p class="mb-4 text-sm text-danger">
                                                @switch($events->status)
                                                    @case("UPCOMING")
                                                        <span class="badge badge-warning badge-sm">
                                                            {{ $events->status }}
                                                        </span>
                                                            @if ($events->selected_members == true)
                                                                <span class="badge badge-warning badge-sm">
                                                                            SELECTED PARTICIPANTS
                                                                </span>
                                                            @endif   
                                                        @break
                                                    @case("ONGOING")
                                                        <span class="badge badge-danger badge-sm">
                                                            {{ $events->status }}
                                                        </span>
                                                            @if ($events->selected_members == true)
                                                                    <span class="badge badge-warning badge-sm">
                                                                                SELECTED PARTICIPANTS
                                                                    </span>
                                                            @endif   
                                                        @break
                                                    @break

                                                    @default
                                                        <span class="badge badge-success badge-sm">
                                                            {{ $events->status }}
                                                        </span>
                                                        @if ($events->selected_members == true)
                                                                <span class="badge badge-warning badge-sm">
                                                                            SELECTED PARTICIPANTS
                                                                </span>
                                                        @endif   
                                                @endswitch
                                             

                                                @if ($events->business_meeting_attend_id) 
                                                    <span class="badge badge-success badge-sm">Business Meeting (Attended)</span>
                                                @endif
                                               
                                            </p>   
                                           
                                          
                                        </div>
                                        <div class="card-footer" style="margin-top: -65px !important">
                                            <hr>
                                            <div class="d-flex align-items-center justify-content-between">
                                                @if ($isAdmin)
                                                    <a type="button" class="btn btn-outline-primary btn-sm mb-0" href="event-view/{{ Crypt::encrypt( $events->id )}}">
                                                        VIEW EVENT
                                                    </a>
                                                    <div class="avatar-group mt-0">
                                                        ₱ 0.00
                                                    </div>
                                                @else
                                                    {{-- CHECK IF USER IS VIP --}}
                                                    @if ($isVip === true)
                                                        <a type="button" class="btn btn-outline-primary btn-sm mb-0" href="event-view/{{ Crypt::encrypt( $events->id )}}">
                                                            VIEW EVENT
                                                        </a>
                                                        <div class="avatar-group mt-0">
                                                            ₱ 0.00
                                                        </div>
                                                    @endif  

                                                    @if ($memberType === "FOREIGN DELEGATE")
                                                        <a type="button" class="btn btn-outline-primary btn-sm mb-0" href="event-view/{{ Crypt::encrypt( $events->id )}}">
                                                            VIEW EVENT
                                                        </a>
                                                        <div class="avatar-group mt-0">
                                                            $ {{ number_format($events->prices, 2) }}
                                                        </div>
                                                    @endif

                                                    @if ($memberType !== "FOREIGN DELEGATE" && $isVip !== true)
                                                        <a type="button" class="btn btn-outline-primary btn-sm mb-0" href="event-view/{{ Crypt::encrypt( $events->id )}}">
                                                            VIEW EVENT
                                                        </a>
                                                        <div class="avatar-group mt-0">
                                                            ₱ {{ number_format($pricePhp, 2) }}
                                                        </div>
                                                    @endif

                                                @endif

                                                


                                                {{-- @if (isset($member->vip) == null || isset($member->vip) == false)
                                                    <a type="button" class="btn btn-outline-primary btn-sm mb-0" href="event-view/{{ Crypt::encrypt( $events->id )}}">
                                                        VIEW EVENT
                                                    </a>
                                        
                                                    <div class="avatar-group mt-0">
                                                        @if (isset($member->member_type_name) != "FOREIGN DELEGATE")
                                                        ₱ 0.00
                                                        @elseif ($member->member_type_name == "FOREIGN DELEGATE")   
                                                            $ {{ number_format($events->prices, 2) }}
                                                        @else
                                                            ₱ {{ number_format($events->prices, 2) }}
                                                        @endif 


                                                    
                                                    </div>

                                                    @else
                                                    <a class="btn btn-outline-primary btn-sm mb-0" href="event-view/{{ Crypt::encrypt( $events->id )}}">
                                                        View
                                                    </a>
                                                    <div class="avatar-group mt-0"> 
                                                        @if ($member->member_type_name == "FOREIGN DELEGATE")
                                                            $ 0.00
                                                        @else
                                                            ₱ 0.00
                                                        @endif
                                                    </div>
                                                        
                                                @endif --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

         
                </div>
                <br>
            </div>
        </div>
          
      </div>
        <br>
      </div>
      <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
    </main>
    <x-plugins></x-plugins>
    <link href="{{ asset('assets') }}/css/loader.css" rel="stylesheet" />
  @push('js')
  <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('assets') }}/js/event.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>

    @endpush
  </x-page-template>
  
