
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="events" activeItem="livestream" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="Events"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->



      <div class="container-fluid py-4">    
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success text-white" role="alert">
                    Event attended on {{ \Carbon\Carbon::parse($eventAttend->date_attend)->format('F d, Y \a\t h:i A') }}

                </div>
            </div>
        </div>
        <div class="card card-body mx-3 mx-md-4 ">
           
            {{-- <div class="row">
                <div class="col-md-12 col-12 mb-4">
                    <div class="ratio ratio-16x9">
                        <iframe class="youtube-player" 
                            src="{{ $embedUrl }}" 
                            frameborder="0" 
                            allow="fullscreen; autoplay; encrypted-media" 
                            allowfullscreen sandbox="allow-forms allow-scripts allow-pointer-lock allow-same-origin allow-top-navigation">
                        </iframe>
                    </div>
                    
                
                </div>
            </div> --}}

            <div class="row">
                <div class="col-md-12 col-12 mb-4 position-relative">
                    <!-- Transparent div in upper right -->
                    <div style="
                        position: absolute;
                        top: 0;
                        right: 0;
                        width: 100px;
                        height: 70px;
                        z-index: 2;
                        background: transparent;
                        pointer-events: auto;
                    "></div>
            
                    <div class="ratio ratio-16x9">
                        <iframe class="youtube-player" 
                            src="{{ $embedUrl }}" 
                            frameborder="0" 
                            allow="fullscreen; autoplay; encrypted-media" 
                            allowfullscreen 
                            sandbox="allow-forms allow-scripts allow-pointer-lock allow-same-origin allow-top-navigation"
                            style="z-index: 1;">
                        </iframe>
                    </div>
                </div>
            </div>
            


            

            <div class="row mt-2">
                <div class="col-12">
                    <h4 class="mt-lg-0">{{ $event->title }}</h4>
                    <p class="text-bold">{{Carbon\Carbon::parse($event->start_dt)->format('M. d, Y')}}  - {{Carbon\Carbon::parse($event->end_dt)->format('M. d, Y')}}</p>
                    <p style="margin-top: -13px !important" class="text-bold">{{Carbon\Carbon::parse($event->start_time)->format('h:i a')}} - {{Carbon\Carbon::parse($event->end_time)->format('h:i a')}} @ {{ $event->venue }}</p>

                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-12">
                    @if ($event->questionnaire_link != null || $event->questionnaire_link != "")
                        <label>If you have any questions about this event, please click the button below.</label>
                    @endif
                  
                    {{-- <p>ASK QUESTION >>><a class="text-danger" target="blank_" href="{{ $event->questionnaire_link }}"> {{ $event->questionnaire_link }}</a></p>
                    
                    <div id="survey-container">
                        @if (\Carbon\Carbon::now('Asia/Manila')->gte(\Carbon\Carbon::parse($event->survey_link_date_time)->format('Y-m-d H:i:s')))
                            <p>
                                SURVEY LINK >>><a class="text-danger" target="_blank" href="{{ $event->survey_link }}"> {{ $event->survey_link }}</a>
                            </p>
                        @endif
                    </div> --}}
                
                </div>

                
            </div>

            @if ($event->questionnaire_link != null || $event->questionnaire_link != "")
                <div class="row mt-1">
                    <div class="col-12 col-sm-12 col-md-6">
                        <a class="btn btn-warning w-100" target="blank_" href="{{ $event->questionnaire_link }}">CLICK HERE TO ASK QUESTION</a>
                    </div>
                </div>
            @endif
           
            <div class="row mt-1" id="survey-container">
                <div class="col-12 col-sm-12 col-md-6">
                    @if (\Carbon\Carbon::now('Asia/Manila')->gte(\Carbon\Carbon::parse($event->survey_link_date_time)->format('Y-m-d H:i:s')))
                        <a class="btn btn-warning w-100" target="blank_" href="{{ $event->survey_link }}">CLICK HERE FOR SURVEY</a>
                   @endif     
                </div>
            </div>
   
          </div>
   
      </div>
      <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
    </main>
    <x-plugins></x-plugins>
    <link href="{{ asset('assets') }}/css/loader.css" rel="stylesheet" />
  @push('js')
  <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('assets') }}/js/livestream.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>  

    @endpush
  </x-page-template>
  