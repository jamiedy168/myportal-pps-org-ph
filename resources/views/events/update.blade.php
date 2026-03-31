<x-page-template bodyClass='g-sidenav-show bg-gray-200'>
    <x-auth.navbars.sidebar activePage='events' activeItem='listing' activeSubitem=''></x-auth.navbars.sidebar>
    <main class="main-content main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-auth.navbars.navs.auth pageTitle='Events'></x-auth.navbars.navs.auth>
       
        <div class="container-fluid my-3 ">
            {{-- <div class="loading" id="loading3"> 
                <img src="{{ asset('assets') }}/img/pps-logo.png" style="height: 60px !important; width: 60px !important" alt="img-blur-shadow" class="icons">
            </div> --}}

            <div class="row mb-2">
                <div class="col-12">
                    <div class="card" id="eventDetailsRow">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8 col-12">
                                    <h5 class="mb-4 text-gradient text-danger">Event Details</h5>
                                </div>
                                <div class="col-md-4 col-4" style="text-align: right !important" >
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalUpdateEvent">Update Event Details</button>
                                </div>
                            </div>
                           
                            <input type="hidden" id="role_id" value="{{ auth()->user()->role_id }}">
                            {{-- <div class="row">
                                <div class="col-12 col-md-12" style="text-align: right !important">
                                    <button class="btn btn-danger" type="button" onclick="sendconfirmationemail()">SEND CONFIRMATION EMAIL</button>
                                </div>
                            </div> --}}
                            <div class="row">
                                <div class="col-xl-5 col-lg-6 text-center">
                                    @if (is_object($firstImage))
                                    
                                        <img class="w-100 border-radius-lg shadow-lg mx-auto"
                                        src="{{Storage::disk('s3')->temporaryUrl('event/' . $firstImage->file_name, now()->addMinutes(230))}}" alt="image">
                                        
                                    @else
                                        <img class="w-100 border-radius-lg shadow-lg mx-auto"
                                        src="{{ asset('assets') }}/img/pps-logo.png" alt="image">
                                        
                                    @endif
                                   
                                    <div class="my-gallery d-flex mt-4 pt-2" itemscope
                                        itemtype="http://schema.org/ImageGallery">
                                        @foreach ($eventImage as $eventImage2)
                                        <figure class="ms-3" itemprop="associatedMedia" itemscope
                                            itemtype="http://schema.org/ImageObject">
                                            
                                            <a href="{{Storage::disk('s3')->temporaryUrl('event/' . $eventImage2->file_name, now()->addMinutes(230))}}"
                                                itemprop="contentUrl" data-size="500x600">
                                                <img class="w-100 min-height-100 max-height-100 border-radius-lg shadow"
                                                    src="{{Storage::disk('s3')->temporaryUrl('event/' . $eventImage2->file_name, now()->addMinutes(230))}}"
                                                    alt="Image" />
                                            </a>
                                        </figure>
                                            
                                        @endforeach
                                     
                                    </div>
                                    <!-- Root element of PhotoSwipe. Must have class pswp. -->
                                    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
                                  
                                        <div class="pswp__bg"></div>
                                        <!-- Slides wrapper with overflow:hidden. -->
                                        <div class="pswp__scroll-wrap">
                                            <!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
                                            <!-- don't modify these 3 pswp__item elements, data is added later on. -->
                                            <div class="pswp__container">
                                                <div class="pswp__item"></div>
                                                <div class="pswp__item"></div>
                                                <div class="pswp__item"></div>
                                            </div>
                                            <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
                                            <div class="pswp__ui pswp__ui--hidden">
                                                <div class="pswp__top-bar">
                                                    <!--  Controls are self-explanatory. Order can be changed. -->
                                                    <div class="pswp__counter"></div>
                                                    <button
                                                        class="btn btn-white btn-sm pswp__button pswp__button--close">Close
                                                        (Esc)</button>
                                                    <button
                                                        class="btn btn-white btn-sm pswp__button pswp__button--fs">Fullscreen</button>
                                                    <button
                                                        class="btn btn-white btn-sm pswp__button pswp__button--arrow--left">Prev
                                                    </button>
                                                    <button
                                                        class="btn btn-white btn-sm pswp__button pswp__button--arrow--right">Next
                                                    </button>
                                                    <!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR -->
                                                    <!-- element will get class pswp__preloader--active when preloader is running -->
                                                    <div class="pswp__preloader">
                                                        <div class="pswp__preloader__icn">
                                                            <div class="pswp__preloader__cut">
                                                                <div class="pswp__preloader__donut"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                                                    <div class="pswp__share-tooltip"></div>
                                                </div>
                                                <div class="pswp__caption">
                                                    <div class="pswp__caption__center"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mx-auto">
                                    <h3 class="mt-lg-0 mt-4 ">{{ $event->title }}</h3>
                                    
                                    @switch($event->status)
                                        @case("UPCOMING")
                                            <span class="badge badge-warning">{{ $event->status }}</span>
                                            @break
                                        @case("ONGOING")
                                            <span class="badge badge-danger">{{ $event->status }}</span>
                                        @break
                                        @case("COMPLETED")
                                            <span class="badge badge-success">{{ $event->status }}</span>
                                        @break
                                           
                                        @default
                                        <span class="badge badge-primary">{{ $event->status }}</span>
                                    @endswitch
                                    
                                    <br>
                                  
                                    
                                    <ul class="mt-3">
                                        <li>{{ $event->description }}
                                        </li>

                                    </ul>

                              

                                    <div class="row mt-0">
                                        <div class="col-12">
                                            <div class="d-sm-flex bg-gray-100 border-radius-lg p-2 my-1"> 
                                                <p class="text-sm font-weight-bold my-auto ps-sm-2">  <i class="fas fa-paste text-lg opacity-6" style="margin-top: 7px !important"></i> &nbsp;CATEGORY</p>
                                                <label class="ms-sm-auto mt-sm-2 mt-2 w-sm-50 w-70" style="text-transform: uppercase">{{ $event->category }}</label>
                                            </div>
                                            <div class="d-sm-flex bg-gray-100 border-radius-lg p-2 my-2"> 
                                                <p class="text-sm font-weight-bold my-auto ps-sm-2"> <i class="fas fa-calendar text-lg opacity-6" style="margin-top: 7px !important"></i> &nbsp;DATE</p>
                                                @if ($event->start_dt == $event->end_dt)
                                                    <label class="ms-sm-auto mt-sm-2 mt-2 w-sm-50 w-70" style="text-transform: uppercase">{{ $event->start_dt->format('F d, Y') }} </label>
                                                @else
                                                <label class="ms-sm-auto mt-sm-2 mt-2 w-sm-50 w-70" style="text-transform: uppercase">{{ $event->start_dt->format('F d, Y') }} - {{ $event->end_dt->format('F d, Y') }} </label>
                                                @endif
                                                
                                            </div>
                                            <div class="d-sm-flex bg-gray-100 border-radius-lg p-2 my-2"> 
                                                <p class="text-sm font-weight-bold my-auto ps-sm-2"> <i class="fas fa-calendar text-lg opacity-6" style="margin-top: 7px !important"></i> &nbsp;TIME</p>
                                                <label class="ms-sm-auto mt-sm-2 mt-2 w-sm-50 w-70" style="text-transform: uppercase">{{ $event->start_time->format('h: i a') }} - {{ $event->end_time->format('h: i a') }}</label>
                                            </div>
                                            <div class="d-sm-flex bg-gray-100 border-radius-lg p-2 my-2">
                                                <p class="text-sm font-weight-bold my-auto ps-sm-2"> <i class="fas fa-location-arrow text-lg opacity-6" style="margin-top: 7px !important"></i> &nbsp;VENUE</p>
                                                <label class="ms-sm-auto mt-sm-2 mt-2 w-sm-50 w-70" style="text-transform: uppercase">{{ $event->venue }}</label>
                                            </div>
                                            <div class="d-sm-flex bg-gray-100 border-radius-lg p-2 my-2">
                                                <p class="text-sm font-weight-bold my-auto ps-sm-2"> <i class="fas fa-money-bill-alt text-lg opacity-6" style="margin-top: 7px !important"></i> &nbsp;PRICE</p>
                                                
                                                @if (auth()->user()->id == 1 || auth()->user()->id == 4)
                                                    <label class="ms-sm-auto mt-sm-2 mt-2 w-sm-50 w-70" style="text-transform: uppercase">
                                                        ₱ 0.00
                                                    </label>
                                                @else
                                                    @if ($member->vip == true)
                                                        <label class="ms-sm-auto mt-sm-2 mt-2 w-sm-50 w-70" style="text-transform: uppercase">
                                                            ₱ 0.00
                                                        </label>
                                                    @endif

                                                    @if ($member->member_type_name == "FOREIGN DELEGATE")
                                                        <label class="ms-sm-auto mt-sm-2 mt-2 w-sm-50 w-70" style="text-transform: uppercase">
                                                            $  {{ number_format($event->prices, 2) }}
                                                        </label>
                                                    @endif

                                                    @if ($member->member_type_name != "FOREIGN DELEGATE" && $member->vip != true)
                                                        <label class="ms-sm-auto mt-sm-2 mt-2 w-sm-50 w-70" style="text-transform: uppercase">
                                                            ₱  {{ number_format($event->prices, 2) }}
                                                        </label>
                                                    @endif
                                                @endif
                                                {{-- @if (isset($member->vip) == null || isset($member->vip) == false)
                                                <label class="ms-sm-auto mt-sm-2 mt-2 w-sm-50 w-70" style="text-transform: uppercase">
                                                    @if ($member->member_type_name == "FOREIGN DELEGATE")
                                                        $
                                                    @else
                                                        ₱
                                                    @endif
                                                    {{ number_format($event->prices, 2) }}</label>
                                                @else
                                                <label class="ms-sm-auto mt-sm-2 mt-2 w-sm-50 w-70" style="text-transform: uppercase">
                                                    @if ($member->member_type_name == "FOREIGN DELEGATE")
                                                        $
                                                    @else 
                                                        ₱
                                                    @endif
                                                    0.00</label>
                                                @endif  --}}
                                           
                                            </div>
                                            <br>

                                  
                                        </div>
                                    </div>

                                    
                               
                               
                                  

                                    <br>
                                </div>
                            </div>
                         
                            <div class="row">
                                <div class="col-12 col-lg-12 col-md-12">
                                    <div class="d-sm-flex bg-gray-100 border-radius-lg p-2 my-2">
                                        <p class="text-sm font-weight-bold my-auto ps-sm-2"> LIST OF TOPIC</p>
                                        
                                    </div>
                                    <div class="row">
                                        <Div class="col-12">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="table-responsive">
                                                        <table class="table align-items-center mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-uppercase text-xs font-weight-bolder opacity-7 text-center">
        
                                                                    </th>
                                                                    <th class="text-uppercase text-xs font-weight-bolder opacity-7 ps-2">Title
                                                                   
                                                                    </th>
                                                                    <th class="text-uppercase text-xs font-weight-bolder opacity-7 ps-2 text-center">CPD Points On-site
                                                                    
                                                                    </th>
                                                                    <th class="text-uppercase text-xs font-weight-bolder opacity-7 ps-2 text-center">CPD Points Online
                                                                    
                                                                    </th>
                                                                    <th></th>
                                                                    
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($eventTopic as $eventTopic2)
                                                                    <tr>
                                                                        <td class="text-sm text-center">
                                                                            {{ $loop->iteration }}.
                                                                        </td>
                                                                        <td style="text-align: left !important">
                                                                        
                                                                        <h6 class="mb-0 text-sm">{{ $eventTopic2->topic_name }}</h6>
                                                                            
                                                                        </td>
                                                                        <td class="align-middle text-center text-sm">
                                                                            <span class="text-sm"> {{ $eventTopic2->points_on_site }} </span>
                                                                            
                                                                        </td>
                                                                        <td class="align-middle text-center text-sm">
                                                                            <span class="text-sm"> {{ $eventTopic2->points_online }} </span>
                                                                        </td>
                                                                        <td>
                                                                            <a href="/event-topic/{{ Crypt::encrypt( $eventTopic2->id )}}" class="text-danger">VIEW</a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                         
                                        </Div>
                                    </div>
                                    
                                </div>
              
                            </div>

                            <div class="row mt-4">
                                <div class="col-12 col-lg-12 col-md-12">
                                    <div class="d-sm-flex bg-gray-100 border-radius-lg p-2 my-2">
                                        <p class="text-sm font-weight-bold my-auto ps-sm-2"> LIST OF COMMITTEE</p>
                                        
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12 col-lg-12 col-md-12">
                                    <div class="d-sm-flex bg-gray-100 border-radius-lg p-2 my-2">
                                        <p class="text-sm font-weight-bold my-auto ps-sm-2">EVENT LIVE VIDEO</p>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value="{{ $event->id }}" id="event_id">
                            <input type="hidden" value="{{ url('event-youtube-live-url') }}" id="urlEventYoutubeLiveUrl">
                            <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">
                            <div class="row" id="youtube_live_url_row">
                                <div class="col-12 col-lg-12 col-md-12">
                                    <label class="form-label text-bold">Input Youtube Live URL<code> <b>*</b></code></label>
                                    <div class="input-group input-group-outline">
                                        <input type="text" class="form-control" id="youtube_url" name="youtube_url" style="height: 44px !important" value="{{ $event->youtube_live_url }}">
                                        <button class="btn bg-gradient-success btn-lg" type="button" id="youtube_url_button">SAVE URL</button>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12 col-lg-12 col-md-12">
                                    <div class="d-sm-flex bg-gray-100 border-radius-lg p-2 my-2">
                                        <p class="text-sm font-weight-bold my-auto ps-sm-2">QUESTIONNAIRE LINK</p>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value="{{ url('event-questionnaire-link') }}" id="urlEventQuestionnaireLinkUrl">
                            <div class="row" id="questionnaire_row">
                                <div class="col-12 col-lg-12 col-md-12">
                                    <label class="form-label text-bold">Input qustionnaire link<code> <b>*</b></code></label>
                                    <div class="input-group input-group-outline">
                                        <input type="text" class="form-control" id="questionnaire_link" name="questionnaire_link" style="height: 44px !important" value="{{ $event->questionnaire_link }}">
                                        <button class="btn bg-gradient-success btn-lg" type="button" id="questionnaire_link_button">SAVE LINK</button>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12 col-lg-12 col-md-12">
                                    <div class="d-sm-flex bg-gray-100 border-radius-lg p-2 my-2">
                                        <p class="text-sm font-weight-bold my-auto ps-sm-2">SURVEY LINK</p>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value="{{ url('event-survey-link') }}" id="urlEventSurveyLinkUrl">
                            <div class="row" id="survey_row">
                                <div class="col-12 col-lg-12 col-md-12">
                                    <label class="form-label text-bold">Input survey link<code> <b>*</b></code></label>
                                    <div class="input-group input-group-outline">
                                        <input type="text" class="form-control" id="survey_link" name="survey_link" style="height: 44px !important" value="{{ $event->survey_link }}">
                                        <button class="btn bg-gradient-success btn-lg" type="button" id="survey_link_button">SAVE LINK</button>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value="{{ url('event-survey-link-date-time') }}" id="urlEventSurveyLinkDateTimeUrl">
                            <div class="row" id="survey_date_time_row">
                                <div class="col-12 col-lg-12 col-md-12">
                                    <label class="form-label text-bold">Choose survey link date and time<code> <b>*</b></code></label>
                                    <div class="input-group input-group-outline">
                                        <input type="datetime-local" class="form-control" id="survey_link_date_time" name="survey_link_date_time" value="{{ $event->survey_link_date_time }}" style="height: 44px !important" >
                                        <button class="btn bg-gradient-success btn-lg" type="button" id="survey_link_date_time_button">SAVE DATE/TIME</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="modalUpdateEvent" tabindex="-1" role="dialog" aria-labelledby="modalUpdateEvent" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                    <div class="card card-plain">
                        <div class="card-header p-3 pb-0">
                           <div class="row">
                            <div class="col-8">
                                <h6 class="mb-0">Update Event</h6>
                                <p class="text-sm mb-0 font-weight-normal">Update Event Details</p>
                            </div>
                            <div class="col-4" style="text-align: right !important">
                                <button type="button" class="btn-close" style="color: black !important" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                           </div>
                            
                        </div>
                        
                        <div class="card-body pb-3">
                            <div class="row">
                                <div class="col-12">
                                <label class="form-label text-bold">Title<code> <b>*</b></code></label>
                                <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                    <input type="text" class="form-control" placeholder="Enter Title" name="title" id="event_title" value="{{ $event->title }}">
                                </div>
                                <p class="text-danger inputerror mt-0" style="display: none">The name field is required. </p>
                                </div>
                            </div>
                

                        </div>
                        
                    </div>
                    </div>
                </div>
                </div>
            </div>

              

              {{-- <div class="row">
                <div class="col-lg-5">
                    <div class="row mt-1">
                        <div class="col-lg-6">
                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="row">
                                       <div class="col-4">
                                        <div class="icon icon-shape bg-gradient-danger icon-lg text-center border-radius-md shadow-none">
                                            <i class="material-icons text-white opacity-10" aria-hidden="true">group</i>
                                        </div>
                                       </div>
                                        <div class="col-8 my-auto text-end">
                                            <p class="text-sm mb-0 opacity-7">Attendees</p>
                                            <h5 class="font-weight-bolder mb-0">
                                                {{ $attendeeCount }}/{{ $event->participant_limit }}
                                            </h5>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mt-0" style="height: 10px !important; margin-top: -10px !important">
                                        <div class="col-12" style="text-align: right !important">
                                            <a href="#" class="text-danger text-sm text-bold" data-bs-toggle="modal" data-bs-target="#modalAttendee">VIEW</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                         <div class="icon icon-shape bg-gradient-danger icon-lg text-center border-radius-md shadow-none">
                                             <i class="material-icons text-white opacity-10" aria-hidden="true">local_atm</i>
                                         </div>
                                        </div>
                                         <div class="col-8 my-auto text-end">
                                             <p class="text-sm mb-0 opacity-7">Paid</p>
                                             <h5 class="font-weight-bolder mb-0">
                                                 {{ $paid }}/{{ $event->participant_limit }}
                                             </h5>
                                         </div>
                                     </div>
                                     <hr>
                                    <div class="row mt-0" style="height: 10px !important; margin-top: -10px !important">
                                        <div class="col-12" style="text-align: right !important">
                                            <a href="#" class="text-danger text-sm text-bold">VIEW</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <div class="card" style="height: 810px !important">
                                <div class="card-header p-3 pb-0">
                                    <h6 class="mb-0">Committee</h6>
                                    <p class="text-sm mb-0 font-weight-normal">List of all committee.</p>
                                </div>
                                <div class="card-body">
                                    <div class="row mt-0">
                                        <div class="col-12">
                                            <div class="table table-responsive">
                                                <table class="table align-items-center mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th
                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                Member</th>
                                                            <th
                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                                </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($eventComittee as $eventComittee2)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex px-2 py-1">
                                                                    <div>
                                                                        <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $eventComittee2->picture, now()->addMinutes(230))}}"
                                                                            class="avatar avatar-md me-3" alt="table image">
                                                                    </div>
                                                                    <div class="d-flex flex-column justify-content-center">
                                                                        <h6 class="mb-0 text-sm">{{ $eventComittee2->first_name }} {{ $eventComittee2->middle_name }} {{ $eventComittee2->last_name }}
                                                                        </h6>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <a href="#" class="text-danger text-sm text-bold">REMOVE</a>
                                                                
                                                            </td>
                                                            
                                                        </tr>

                                                        @endforeach
 
                                                    
                                                    </tbody>
                                                </table>
                                                <br>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
              </div> --}}


            {{-- START OF ATTENDEE MODAL --}}
            {{-- <div class="modal fade" id="modalAttendee" tabindex="-1" role="dialog" aria-labelledby="modalCommittee" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered " role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                    <div class="card card-plain">
                        <div class="card-header p-3 pb-0">
                           <div class="row">
                            <div class="col-8">
                                <h6 class="mb-0">Attendees</h6>
                                <p class="text-sm mb-0 font-weight-normal">List of all attendees.</p>
                            </div>
                            <div class="col-4" style="text-align: right !important">
                                <button type="button" class="btn-close" style="color: black !important" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                           </div>
                            
                        </div>
                        
                        <div class="card-body pb-3">
                            <div class="row mt-0">
                                <div class="col-12">
                                    <div class="table table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Member</th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                        </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($attendee as $attendee2)
                                                <tr>
                                            
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                            
                                                            <div>
                                                                {{ $loop->iteration }}. &nbsp;
                                                                <img src="{{URL::asset('/img/profile/'.$attendee2->picture)}}"
                                                                    class="avatar avatar-md me-3" alt="table image">
                                                            </div>
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $attendee2->first_name }} {{ $attendee2->middle_name }} {{ $attendee2->last_name }}
                                                                </h6>
                                                                <label>Joined: {{ \Carbon\Carbon::parse($attendee2->joined_dt)->format('m/d/y h:m a')}}</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if ($attendee2->paid == false)
                                                            <p class="text-sm text-danger mb-0 text-bold">UNPAID</p>
                                                        @else
                                                            <p class="text-sm text-success mb-0 text-bold">PAID</p>
                                                        @endif
                                                        
                                                    </td>
                                                    
                                                </tr>

                                                @endforeach

                                            
                                            </tbody>
                                        </table>
                                        <br>
                                        <br>
                                    </div>
                                </div>
                            </div>
                
    
                        
                        </div>
                        
                    </div>
                    </div>
                </div>
                </div>
            </div> --}}
            {{-- END OF ATTENDEE MODAL --}}
            


            
                <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
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
