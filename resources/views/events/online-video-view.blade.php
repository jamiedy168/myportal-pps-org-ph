
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="events" activeItem="online-video" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="Events"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->
      <div class="container-fluid py-4">    
        <div class="card card-body mx-3 mx-md-4 ">

            {{-- <div class="row">
                <div class="col-12">
                    <div class="tab-content shadow-dark border-radius-lg" id="v-pills-tabContent">
                        <div class="tab-pane fade show position-relative active height-400 border-radius-lg"
                            id="cam1" role="tabpanel" aria-labelledby="cam1"
                            style="background-image: url('{{ asset('assets') }}/img/bg-smart-home-1.jpg'); background-size:cover;">
                            <div class="position-absolute d-flex top-0 w-100">
                                <p class="text-white font-weight-normal p-3 mb-0">17.05.2021 4:34PM</p>
                                <div class="ms-auto p-3">
                                    <span class="badge badge-secondary">
                                        <i class="fas fa-dot-circle text-danger"></i>
                                        Recording</span>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade position-relative height-400 border-radius-lg" id="cam2"
                            role="tabpanel" aria-labelledby="cam2"
                            style="background-image: url('{{ asset('assets') }}/img/bg-smart-home-2.jpg'); background-size:cover;">
                            <div class="position-absolute d-flex top-0 w-100">
                                <p class="text-white font-weight-normal p-3 mb-0">17.05.2021 4:35PM</p>
                                <div class="ms-auto p-3">
                                    <span class="badge badge-secondary">
                                        <i class="fas fa-dot-circle text-danger"></i>
                                        Recording</span>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div> --}}

            <div class="row">
                <div class="col-md-12 col-12 mb-4">
                    <br>
                    <div class="ratio ratio-16x9">
                        <video src="{{Storage::disk('s3')->temporaryUrl('event-video/'. $eventTopicDetails->video_name, now()->addMinutes(60))}}" controls></video>
                    </div>
                   
                    {{-- <div class="ratio ratio-16x9">
                        <iframe  src={{Storage::disk('s3')->temporaryUrl('event-video/'. $eventTopicDetails->video_name, now()->addMinutes(60))}} allowfullscreen></iframe>
                    </div> --}}

                    <div class="row mt-2">
                        <div class="col-12">
                            <h4 class="mt-lg-0">{{ $eventTopicDetails->title }}</h4>
                            <p class="text-bold">TOPIC: {{ $eventTopicDetails->topic_name }}</p>
                        </div>
                    </div>
                
                    
                    @if (auth()->user()->role_id == 3)
                        @if(!$event->virtual_exam_close)
                            @if ($topic_attend_count == 0)
                                @if($checkEventPaid >= 1)
                                    <div class="row mt-2">
                                        <div class="col-12" style="text-align: right !important;">
                                            @if ($cpdpoints < $eventTopicDetails->max_cpd)
                                                @if ($eventTopicDetails->is_plenary == true)
                                                    <a class="btn btn-success w-100" href="/event-online-topic-question-answer-plenary-temp/{{ Crypt::encrypt( $eventTopicDetails->id )}}">Start Examination</a>
                                                    <!-- <a class="btn btn-success w-100" href="/event-online-topic-question-answer-plenary/{{ Crypt::encrypt( $eventTopicDetails->id )}}">Start Examination</a> -->
                                                @else
                                                    @if ($eventTopicDetails->with_examination == true)
                                                        <a class="btn btn-success w-100" href="/event-online-topic-question-answer/{{ Crypt::encrypt( $eventTopicDetails->id )}}">Start Examination</a>
                                                    @endif
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="row mt-2">
                                        <div class="col-12" style="text-align: right !important;">
                                            <button type="button" class="btn btn-success w-100" onclick="notpaidconvention()">Start Examination</button>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endif
                    @endif
                   

                    
                    
                </div>
                <div class="col-12 col-md-12" style="margin-top: -20px !important">
                    <div class="row mt-0">
                        <div class="col-12 cold-md-4">
                            <label class=" text-bold">CPD POINTS EARNED: {{ $cpdpoints }}</label>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class=" text-bold">MAXIMUM CPD POINTS EARNED: {{ $eventTopicDetails->max_cpd }}</label>
                        </div>
                    </div>
                    <div class="row" style="text-align: left !important">
                        <div class="col-12">
                            <ul class="list-group">
                                <li class="list-group-item border-0 mb-1 bg-danger border-radius-lg">
                                    <h5 class="text-white" style="text-align: center !important;">List of Topics</h5>
                                </li>
                                @foreach ($eventTopic as $eventTopic2)
                                    <li class="list-group-item border-0 mb-1 bg-gray-100 border-radius-lg @if ($eventTopicDetails->id == $eventTopic2->id)
                                    checklist-item checklist-item-primary
                                @endif">
                                    <a class="nav-link mb-0 px-0" href="/event-online-video-view/{{ Crypt::encrypt( $eventTopic2->id )}}"
                                        role="tab" aria-selected="true">
                                      <div class="row mb-0">
                                        {{-- <div class="col-4">
                                            <div class="avatar avatar-xl position-relative">
                                                <img src="{{ asset('assets') }}/img/pps-logo.png" alt="profile_image"
                                                    class="w-100 border-radius-lg shadow-sm">
                                            </div>
                                        </div> --}}
                                        <div class="col-12 text-align-center">
                                          {{-- <p class="font-weight-normal">{{ ($eventTopic ->currentpage()-1) * $eventTopic ->perpage() + $loop->index + 1 }}. {{ $eventTopic2->topic_name }}</p> --}}
                                          <p class="font-weight-normal">{{ $eventTopic2->code }}. {{ $eventTopic2->topic_name }}</p>
                                        </div>
                                      </div>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    
                </div>
            </div>

                    
            <div class="row mt-2">
                <div class="col-xs-12">
                    {{ $eventTopic->appends($_GET)->links('vendor.pagination.bootstrap-5') }}
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
  <script src="{{ asset('assets') }}/js/event-video.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>  

    @endpush
  </x-page-template>
  