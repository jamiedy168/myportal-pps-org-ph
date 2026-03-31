<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
   
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

        <div class="container-fluid py-4">
           
            <div class="row">
                <div class="col-12">
                    <div class="multisteps-form mb-9">
                        <!--progress bar-->
                        <div class="row">
                            <div class="col-12 col-lg-8 mx-auto my-5">
                            </div>
                        </div>
                        <!--form panels-->
                        <div class="row">
                            <div class="col-12 col-lg-8 m-auto">
                                <div class="card">
                                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                      
    
                                        <div class="bg-gradient-danger shadow-primary border-radius-lg pt-4 pb-3">
                                            <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Questions</h4>
                                            <p class="text-white text-center">TOPIC: {{ $eventTopic->topic_name }}</p>
                                           
                                            <div class="multisteps-form__progress">
                                                @foreach ($eventTopicQuestion as $eventTopicQuestion2)
                                                    <button class="multisteps-form__progress-btn {{ $loop->first ? 'js-active' : '' }}" type="button" disabled>Question {{ $loop->iteration }}</button>
                                                @endforeach
                                                    <button class="multisteps-form__progress-btn" type="button" title="Result" disabled>
                                                        Result
                                                    </button>
                                               
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form class="multisteps-form__form">
                                            @foreach ($eventTopicQuestion as $eventTopicQuestion2)
                                                <div class="multisteps-form__panel border-radius-xl bg-white {{ $loop->first ? 'js-active' : '' }}"
                                                    data-animation="FadeIn">
                                                    <p>Please answer all question below.</p>

                                                    <div class="multisteps-form__content">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <h6>{{ $loop->iteration }}. {{ $eventTopicQuestion2->question }}</h6>
                                                            </div>
                                                        </div>
                                                        @foreach ($choices as $choices2)
                                                            @if ($choices2->topic_question_id == $eventTopicQuestion2->id)
                                                                <div class="row mb-2 bg-gray-200 mb-3 row-{{ $choices2->id }} rows-{{ $choices2->letter }}" id="row-{{ $choices2->letter }}">
                                                                    <div class="col-10 align-middle my-auto">
                                                                        <div class="form-check my-auto">
                                                                            <input class="form-check-input" type="radio" name="member_answer" id="{{ $choices2->id }}" value="{{ $choices2->letter }}">
                                                                            <label class="custom-control-label" for="member_answer"><b>{{ $choices2->letter }}.</b> {{ $choices2->choices_description }}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif   
                                                            
                                                        @endforeach
                                                        
                                                       
                                                        <div class="button-row d-flex mt-2">
                                                            <button data-correct-answer="{{ $eventTopicQuestion2->answer }}" class="btn bg-gradient-success btn-lg ms-auto mb-0 js-btn-next check_answer" id="js-btn-next"
                                                                type="button" title="Next">Next</button>
                                                        </div>
                                                        <br>
                                                        <br>
                                                        <br>
                                                        <br>
                                                        <br>
                                                        <br>
                                                        <br>
                                                       
                                                    </div>
                                                    
                                                    
                                                </div>
                                               
                                               
                                            @endforeach

                                    <div class="multisteps-form__panel pt-3 border-radius-xl bg-white h-100"
                                        data-animation="FadeIn">
                                       
                                        <div class="multisteps-form__content mt-3">
                                            <div class="row">
                                                <div class="col-12 col-md-6 text-center">
                                                    <h4 class="text-success">Examination Result</h4>
                                                    <img src="{{ asset('assets') }}/img/check.png" style="height: 110px !important; width: 110px !important" alt="img-blur-shadow">
                                                    <p style="font-size: large !important;">Nice job, you passed!</p>
                                                    
                                                </div>
                                                <div class="col-12 col-md-5 text-center">
                                                   <div class="row">
                                                        <div class="col-12 bg-gray-200">
                                                            <p style="font-weight: bolder !important; font-color: black !important">
                                                                YOUR SCORE
                                                            </p>
                                                            <h2 style="margin-top: -18px !important">
                                                                100%
                                                            </h2>
                                                            <hr style="margin-top: -10px !important">
                                                            <p style="font-size: small !important; margin-top: -10px !important">PASSING SCORE: 100%</p>


                                                        </div>
                                                   </div>
                                                   <div class="row mt-3">
                                                        <div class="col-12 bg-gray-200">
                                                            <p style="font-weight: bolder !important; font-color: black !important">
                                                                YOUR POINTS
                                                            </p>
                                                            <h2 style="margin-top: -18px !important">
                                                                {{ $eventTopicQuestionCount }}/{{ $eventTopicQuestionCount }}
                                                            </h2>
                                                            <hr style="margin-top: -10px !important">
                                                            <p style="font-size: small !important; margin-top: -10px !important">PASSING POINTS: {{ $eventTopicQuestionCount }}</p>


                                                        </div>
                                                    </div>
                                              
                                                </div>
                                               
                                            </div>
                                            <br>
                                         
                                            <div class="button-row d-flex mt-0 mt-md-4 mt-2">
                                                <input type="hidden" value="{{ url('event-online-topic-proceed-score') }}" id="urlEventOnlineTopicProceedScore">
                                                <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">
                                                <input type="hidden" id="event_topic_id" value="{{ $eventTopic->id }}">
                                                <input type="hidden" id="event_id" value="{{ $eventTopic->event_id }}">

                                                <button class="btn bg-gradient-success btn-lg ms-auto mb-0" id="complete_answer"
                                                    type="button" title="Complete">Click here to complete your attendance</button>
                                            </div>
                                            
                                        </div>
                                    </div>
                                                    
                                      
                                         
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
        </div>
        <x-auth.footers.guest.social-icons-footer></x-auth.footers.guest.social-icons-footer>

    </main>
    <x-plugins></x-plugins>
    <style>

        .wrong-answer
        {
            border:1.5px solid rgb(251, 10, 10) !important;
        }

        .correct-answer
        {
            border:1.5px solid rgb(11, 218, 8) !important;
        }

    </style>
    @push('js')
    <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
    <script src="{{ asset('assets') }}/js/online-topic-question-answer.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/choices.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/multistep-form.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>

    @endpush
</x-page-template>
