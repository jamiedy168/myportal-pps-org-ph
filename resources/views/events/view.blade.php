<x-page-template bodyClass='g-sidenav-show bg-gray-200'>
    <x-auth.navbars.sidebar activePage='events' activeItem='listing' activeSubitem=''></x-auth.navbars.sidebar>
    <main class="main-content main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-auth.navbars.navs.auth pageTitle='Events'></x-auth.navbars.navs.auth>
       
        <div class="container-fluid my-3 py-4">
            {{-- <div class="loading" id="loading3"> 
                <img src="{{ asset('assets') }}/img/pps-logo.png" style="height: 60px !important; width: 60px !important" alt="img-blur-shadow" class="icons">
              </div> --}}
            <div class="row">
                <div class="col-12">
                    <div class="card" id="eventDetailsRow">
                        <div class="card-body">
                            <h5 class="mb-4 text-gradient text-danger">Event Details</h5>
                            <input type="hidden" id="role_id" value="{{ auth()->user()->role_id }}">
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


                                    @if ($business_meeting_attend) 
                                        <span class="badge badge-success">Attended the business meeting</span>
                                    @endif
                              
                                    <br>
                                  
                                    
                                    <ul class="mt-3">
                                        <li>{{ $event->description }}
                                        </li>

                                    </ul>

                                    <form method="POST" role="form" enctype="multipart/form-data" >
                                        @csrf
                                        <input type="hidden" name="pps_no" id="pps_no" value="{{ auth()->user()->pps_no }}">
                                        <input type="hidden" name="event_id" id="event_id" value="{{ $event->id }}">
                                        <input type="hidden" name="price" id="price" value="{{ $event->prices }}">
                                        {{-- <input type="hidden" name="vip" id="vip" value="{{ $member->vip }}"> --}}
                                        <input type="hidden" name="points" id="points" value="{{ $event->points }}">
                                        <input type="hidden" name="status" id="event_status_validation" value="{{ $event->status }}">
                                       
                                        {{-- <input type="hidden" value="{{ url('event-join') }}" id="urlEventJoin"> --}}
                                        <input type="hidden" value="{{ url('event-check-joined') }}" id="urlEventCheckJoined">
                                        <input type="hidden" id="token2" name="token2" value="{{ csrf_token() }}">
                                       
                                    </form>

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

                                  
                                            <div class="d-sm-flex bg-gray-100 border-radius-lg p-2 my-2">
                                                <p class="text-sm font-weight-bold my-auto ps-sm-2"> LIST OF TOPIC</p>
                                                
                                            </div>
                                        </div>
                                    </div>

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
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($eventTopic as $eventTopic2)
                                                            <tr>
                                                                <td class="text-sm text-center">
                                                                    {{ $loop->iteration }}
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
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-12">
                                            {{ $eventTopic->appends($_GET)->links('vendor.pagination.bootstrap-5') }}
                                        </div>
                                    </div>
                                 
                                @if ($eventTransactionCount >= 1)
                                    <div class="row mt-2">
                                        <div class="col-12 mb-md-0 mb-4">
                                            <h6 class="mb-0 text-gradient text-danger">Your Transaction</h6>
                                            <div
                                                class="card card-body border card-plain border-radius-lg h-60">
                                                <div class="row mt-0">
                                                    <div class="col-12">
                                                        <ul class="list-group">
                                                            <li
                                                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                                                <div class="d-flex align-items-center">
                                                                    <button
                                                                        class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i
                                                                            class="material-icons text-lg">priority_high</i></button>
                                                                    <div class="d-flex flex-column">
                                                                        <h6 class="mb-1 text-dark text-sm">Joined Date/Time</h6>
                                                                        <span class="text-xs">{{ Carbon\Carbon::parse($eventTransaction->joined_dt)->format('d F Y ') }} at {{ \Carbon\Carbon::parse($eventTransaction->joined_dt)->format('g:i A ')}}</span>
                                                                       
                                                                        @if ($eventTransaction->paid == true)
                                                                            @if ($member->vip !=true)
                                                                            <br>
                                                                                <h6 class="mb-1 text-dark text-sm">Payment Date/Time</h6>
                                                                                <span class="text-xs">{{ Carbon\Carbon::parse($eventTransaction->payment_dt)->format('d F Y ') }} at {{ \Carbon\Carbon::parse($eventTransaction->payment_dt)->format('g:i A ')}} <b class="text-danger">
                                                                                    @if ($eventTransaction->payment_mode != null)
                                                                                        via {{ $eventTransaction->payment_mode }}
                                                                                    @endif 
                                                                                </b></span>
                                                                            @endif
                                                                        @endif
                                                                       
                                                                       
                                                                        
                                                                        
                                                                    </div>
                                                                </div>
                                                                @if ($eventTransaction->paid == false)
                                                                <div
                                                                    class="d-flex align-items-center">
                                                                    <div class="d-flex flex-column">
                                                                        
                                                                        <h6 class="mb-1 text-danger text-gradient text-sm">FOR PAYMENT</h6>
                                                                       <a class="btn btn-danger btn-sm" href="/event-pay/{{ Crypt::encrypt( $eventTransaction->id )}}">PAY NOW</a>
                                                                    
                                                                        
                                                                    </div>
                                                                  
                                                                </div>
                                                                
                                                               
                                                                @else
                                                                    @if ($event->price != 0)
                                                                        <div
                                                                        class="d-flex align-items-center text-danger text-gradient text-sm font-weight-bold">
                                                                            PAID VIA {{ strtoupper($eventTransaction->payment_mode) }}
                                                                        </div>  
                                                                    @endif
                                                
                                                                @endif
                                                                
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($event->selected_members == true)
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <label class="text-xs text-danger" style="font-style: italic !important;">
                                                Note: This event is for limited participant only!
                                            </label>
                                        </div>
                                    </div>
                                @endif




                              
                                    <div class="row mt-3">
                                        <div class="col-6">
                                        
                                        
                                           
                                        @if ($eventTransactionCount >= 1)
                                            @if ($member->vip == false || $member->vip == null)
                                                <div class="disabled-button-wrapper" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="User already joined on this event">
                                                    <button class="btn bg-gradient-warning mb-0 mt-lg-auto w-100" disabled> 
                                                        Joined
                                                    </button>
                                                </div>
                                            @endif


                                        @else
                                            @if ($event->status == "COMPLETED")
                                                <div class="disabled-button-wrapper" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Unable to join, event already completed">
                                                    @if (isset($member->vip) == null || isset($member->vip) == false)
                                                        @if($event->payment_open == true)
                                                            <button class="btn bg-gradient-warning mb-0 mt-lg-auto w-100" disabled>
                                                                Pay to join
                                                            </button>
                                                        @else
                                                            <button class="btn bg-gradient-warning mb-0 mt-lg-auto w-100" disabled onclick="btnEventPaymentCloseBtn()">
                                                                Pay to join
                                                            </button>
                                                        @endif
                                                    @else
                                                        <button class="btn bg-gradient-warning mb-0 mt-lg-auto w-100" disabled>
                                                            Joined
                                                        </button>   
                                                    @endif
                                                    
                                                </div>
                                            
                                            @else
                                                @if (isset($member->vip) == null || isset($member->vip) == false)
                                                    @if($event->payment_open == true)
                                                        <button class="btn bg-gradient-warning mb-0 mt-lg-auto w-100" id="btnEventJoin" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Join Event"
                                                            name="button">
                                                            Pay to join
                                                        </button>
                                                    @else
                                                        <button class="btn bg-gradient-warning mb-0 mt-lg-auto w-100"  onclick="btnEventPaymentCloseBtn()" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Join Event"
                                                            name="button">
                                                            Pay to join
                                                        </button>
                                                    @endif
                                                    
                                                @else
                                                    <button class="btn bg-gradient-warning mb-0 mt-lg-auto w-100" disabled type="button"
                                                    name="button">
                                                    Joined
                                                    </button>
                                                    <label class="mt-2 text-danger">Note: This event is free to all the VIP's and they will automatically joined without clicking the join button. </label>
                                                @endif
                                            
                                            @endif
                                        
                                        @endif

                                           
                                            
                                        </div>
                                        <div class="col-6">
                                            <a class="btn bg-gradient-danger mb-0 mt-lg-auto w-100" type="button" href="/event-listing"
                                                name="button">
                                                Return
                                            </a>
                                        </div>
                                    </div>

                                    <br>
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
    @push('js')
    <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets') }}/js/event.js"></script>
    <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/choices.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/photoswipe.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/photoswipe-ui-default.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>
    <script>
        @if (Session::has('status'))
            @if (Session::get('status') == 'success')
                Swal.fire({
                    title: "Success!",
                    text: "Payment has been completed!",
                    icon: "success",
                    confirmButtonText: "Okay"
                });
            @elseif (Session::get('status') == 'failed')
                Swal.fire("Warning", "Payment has been failed, please try again", "error");
            @endif
        
        @endif
    </script>
    <!-- Kanban scripts -->

    {{-- <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script> --}}


  
    @endpush
</x-page-template>
