<x-page-template bodyClass='g-sidenav-show bg-gray-200'>
<style>
    .select2-container {
    height: 100%;
  
  }
  
  .select2-container {
    width: 100% !important;
    
  }
  
  
  
  .select2-container .select2-selection--single {
    height: 37px !important;
   
  }
  
  
  
  .select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #d2d6da;
    margin: 3px;
  
  }
  
  
  
  .select2-results__options {
    font-weight: 400;
    font-size: 0.8571em;
  }
</style>

    <div class="container-fluid px-5 my-6">

       
        
        <div class="row" id="topic_details">
            <div class="col-lg-4 col-12 mb-lg-0 mb-4 mx-auto">
                <div class="card shadow-lg">
                    @if ($eventTopic->is_plenary === true)
                        <span class="badge rounded-pill bg-danger w-30 mt-n2 mx-auto">PLENARY</span>
                    @else
                        <span class="badge rounded-pill bg-danger w-30 mt-n2 mx-auto">EVENT</span>
                    @endif
                    
                    
                    <div class="card-header text-center pt-4 pb-3">
                        <div class="row mt-1">
                            <div class="col-12 col-md-12 col-lg-12 text-center">
                                <img src="{{ asset('assets') }}/img/illustrations/pps-logo.png" alt="avatar" class="rounded-circle shadow-sm" style="height: 120px !important; width: 120px !important">
                            
                            </div>
                        </div>
                        <h3 class="font-weight-bold mt-2">
                            {{ $event->title }}
                        </h3>
                        <p class="text-bold mt-0">{{ $eventTopic->topic_name }}</p>
                    </div>
                    <div class="card-body text-lg-start text-center pt-0" style="text-align: center !important">
                        <span class="ps-3">{{Carbon\Carbon::parse($event->start_dt)->format('F d, Y')}}  - {{Carbon\Carbon::parse($event->end_dt)->format('F d, Y')}}</span>
                        <br>
                        <span class="ps-3">{{Carbon\Carbon::parse($event->start_time)->format('h:i a')}}  - {{Carbon\Carbon::parse($event->end_time)->format('h:i a')}}</span>
                        <br>
                        <br>
                        <br>
                       
                          {{-- Start of hidden inputs --}}
                          <input type="hidden" value="{{ url('event-topic-attend-none-question')}}" id="urlEventTopicAttendNoneQuestion">
                          <input type="hidden" value="{{ url('event-topic-attend-with-question')}}" id="urlEventTopicAttendWithQuestion">
                          <input type="hidden" value="{{ url('event-topic-check-attendance')}}" id="urlEventTopicCheckAttendance">
                          <input type="hidden" value="{{ url('event-topic-attend-plenary')}}" id="urlEventTopicAttendPlenary">
                          <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">
                          <input type="hidden" id="topic_name" name="topic_name" value="{{ $eventTopic->topic_name }}">


                         {{-- {{ auth()->user()->pps_no }}  --}}
                          {{-- End of hidden inputs --}}
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                @if ($eventTopic->with_examination)
                                    <button type="button" id="attendance_with_question_choose"
                                    class="btn btn-icon bg-gradient-danger w-100 d-lg-block mt-3 mb-0">
                                    PROCEED
                                    {{-- <i class="fas fa-arrow-right ms-1"></i> --}}
                                    </button>
                                @elseif ($eventTopic->is_plenary)    
                                    <button type="button"
                                        class="btn btn-icon bg-gradient-danger w-100 d-lg-block mt-3 mb-0" id="plenary_btn_choose">
                                    PROCEED
                                    {{-- <i class="fas fa-arrow-right ms-1"></i> --}}
                                    </button>
                                @else
                                    
                                    <button type="button"
                                    class="btn btn-icon bg-gradient-danger w-100 d-lg-block mt-3 mb-0" id="attendance_only_choose">
                                    ATTEND NOW
                                    {{-- <i class="fas fa-arrow-right ms-1"></i> --}}
                                    </button>
                                @endif
                                
                            </div>
                        </div>
                       
                      
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="display: none !important" id="plenary_form">
            <div class="col-lg-4 col-12 mb-lg-0 mb-4 mx-auto">
                <div class="card shadow-lg">
                   
        
                    <div class="card-header text-center pt-4 pb-3">
                        <div class="row mt-1">
                            <div class="col-12 col-md-12 col-lg-12 text-center">
                                <img src="{{ asset('assets') }}/img/illustrations/pps-logo.png" alt="avatar" class="rounded-circle shadow-sm" style="height: 120px !important; width: 120px !important">
                            
                            </div>
                        </div>
                        <h3 class="font-weight-bold mt-2">
                            {{ $event->title }}
                        </h3>
                        <p class="text-bold mt-0">{{ $eventTopic->topic_name }}</p>
                    </div>
                    <div class="card-body text-lg-start text-center pt-0">
                        <div class="row">
                            <div class="col-12">
                                <label class="text-danger">Please Input Information Below</label>
                            </div>
                        </div>
                      
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <label class="form-label text-bold">First Name<code> <b>*</b></code></label>
                                <div class="input-group input-group-outline" >
                                    <input type="text" class="form-control" id="plenary_first_name">
                                </div>
                               
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-lg-12 col-12">
                                <label class="form-label text-bold">Last Name<code> <b>*</b></code></label>
                                <div class="input-group input-group-outline">
                                    <input type="text" class="form-control" id="plenary_last_name">
                                </div>
                               
                            </div>
                        </div>
                        
                        <div class="row mt-1">
                            <div class="col-lg-12 col-12">
                                <label class="form-label text-bold">PRC Number<code> <b>*</b></code></label>
                                <div class="input-group input-group-outline">
                                    <input type="number" class="form-control" id="plenary_prc_number">
                                </div>
                               
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="button"
                                        class="btn btn-icon bg-gradient-danger w-100 d-lg-block mt-3 mb-0" id="plenary_btn">
                                    NEXT
                                    {{-- <i class="fas fa-arrow-right ms-1"></i> --}}
                                    </button>
                            </div>
                        </div>
                       
                      
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="display: none !important" id="business_meeting_form">
            <div class="col-lg-4 col-12 mb-lg-0 mb-4 mx-auto">
                <div class="card shadow-lg">
                   
        
                    <div class="card-header text-center pt-4 pb-3">
                        <div class="row mt-1">
                            <div class="col-12 col-md-12 col-lg-12 text-center">
                                <img src="{{ asset('assets') }}/img/illustrations/pps-logo.png" alt="avatar" class="rounded-circle shadow-sm" style="height: 120px !important; width: 120px !important">
                            
                            </div>
                        </div>
                        <h3 class="font-weight-bold mt-2">
                            {{ $event->title }}
                        </h3>
                        <p class="text-bold mt-0">{{ $eventTopic->topic_name }}</p>
                    </div>
                    <div class="card-body text-lg-start text-center pt-0">
                        <div class="row">
                            <div class="col-12">
                                <label class="text-danger">Please Input Information Below</label>
                            </div>
                        </div>
                      
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <label class="form-label text-bold">First Name<code> <b>*</b></code></label>
                                <div class="input-group input-group-outline" >
                                    <input type="text" class="form-control" id="business_meeting_first_name">
                                </div>
                               
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-lg-12 col-12">
                                <label class="form-label text-bold">Last Name<code> <b>*</b></code></label>
                                <div class="input-group input-group-outline">
                                    <input type="text" class="form-control" id="business_meeting_last_name">
                                </div>
                               
                            </div>
                        </div>
                        
                        <div class="row mt-1">
                            <div class="col-lg-12 col-12">
                                <label class="form-label text-bold">PRC Number<code> <b>*</b></code></label>
                                <div class="input-group input-group-outline">
                                    <input type="number" class="form-control" id="business_meeting_prc_number">
                                </div>
                               
                            </div>
                        </div>

                        <div class="row mt-1">
                            <div class="col-lg-12 col-12">
                                <label class="form-label text-bold">Chapter<code> <b>*</b></code></label>
                                    <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                        <select name="member_chapter" id="business_meeting_member_chapter" class="member_chapter" required>
                                            <option value="">Choose</option>
                                            @foreach ($chapter as $chapter2)
                                                <option value="{{ $chapter2->chapter_name }}">{{ $chapter2->chapter_name }}</option>
                                            @endforeach
                                        
                                        </select>
                                    </div>
                               
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="button"
                                        class="btn btn-icon bg-gradient-danger w-100 d-lg-block mt-3 mb-0" id="attendance_only">
                                    NEXT
                                    {{-- <i class="fas fa-arrow-right ms-1"></i> --}}
                                    </button>
                            </div>
                        </div>
                       
                      
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="display: none !important" id="examination_form">
            <div class="col-lg-4 col-12 mb-lg-0 mb-4 mx-auto">
                <div class="card shadow-lg">
                   
        
                    <div class="card-header text-center pt-4 pb-3">
                        <div class="row mt-1">
                            <div class="col-12 col-md-12 col-lg-12 text-center">
                                <img src="{{ asset('assets') }}/img/illustrations/pps-logo.png" alt="avatar" class="rounded-circle shadow-sm" style="height: 120px !important; width: 120px !important">
                            
                            </div>
                        </div>
                        <h3 class="font-weight-bold mt-2">
                            {{ $event->title }}
                        </h3>
                        <p class="text-bold mt-0">{{ $eventTopic->topic_name }}</p>
                    </div>
                    <div class="card-body text-lg-start text-center pt-0">
                        <div class="row">
                            <div class="col-12">
                                <label class="text-danger">Please Input Information Below</label>
                            </div>
                        </div>
                      
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <label class="form-label text-bold">First Name<code> <b>*</b></code></label>
                                <div class="input-group input-group-outline" >
                                    <input type="text" class="form-control" id="examination_first_name">
                                </div>
                               
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-lg-12 col-12">
                                <label class="form-label text-bold">Last Name<code> <b>*</b></code></label>
                                <div class="input-group input-group-outline">
                                    <input type="text" class="form-control" id="examination_last_name">
                                </div>
                               
                            </div>
                        </div>
                        
                        <div class="row mt-1">
                            <div class="col-lg-12 col-12">
                                <label class="form-label text-bold">PRC Number<code> <b>*</b></code></label>
                                <div class="input-group input-group-outline">
                                    <input type="number" class="form-control" id="examination_prc_number">
                                </div>
                               
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="button"
                                        class="btn btn-icon bg-gradient-danger w-100 d-lg-block mt-3 mb-0" id="attendance_with_question">
                                    NEXT
                                    {{-- <i class="fas fa-arrow-right ms-1"></i> --}}
                                    </button>
                            </div>
                        </div>
                       
                      
                    </div>
                </div>
            </div>
        </div>

    

    </div>
    <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
    <x-auth.footers.guest.social-icons-footer></x-auth.footers.guest.social-icons-footer>
    <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  
    <x-plugins></x-plugins>
    @push('js')
    
    <script>
       
        var event_id =  {{ $event->id }};
        var event_topic_id =  {{ $eventTopic->id }};

    </script>
    <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets') }}/js/select2.min.js"></script>
    <link href="{{ asset('assets') }}/css/select2.min.css" rel="stylesheet" />
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('assets') }}/js/topic-attendance.js"></script>
    <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>  
   
    @endpush
</x-page-template>
