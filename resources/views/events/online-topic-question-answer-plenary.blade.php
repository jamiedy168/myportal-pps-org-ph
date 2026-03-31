<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
   
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

        <div class="container-fluid py-4">
           
            <input type="hidden" value="{{ url('event-online-topic-speaker-a') }}" id="urlEventOnlineTopicSpeakerA">
            <input type="hidden" value="{{ url('event-topic-speaker-b') }}" id="urlEventTopicSpeakerB">
            <input type="hidden" value="{{ url('event-topic-speaker-c') }}" id="urlEventTopicSpeakerC">
            <input type="hidden" value="{{ url('event-online-topic-finalize-plenary') }}" id="urlEventOnlineTopicFinalizePlenary">
            <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">
            <input type="hidden" id="event_topic_id" value="{{ $eventTopic->id }}">
            <input type="hidden" id="event_id" value="{{ $eventTopic->event_id }}">
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
                                            <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Evaluation Tool For Plenary Session</h4>
                                            <p class="text-white text-center">Session: {{ $eventTopic->topic_name }} </p>
                                           
                                            <div class="multisteps-form__progress">
                                                <button class="multisteps-form__progress-btn js-active" disabled type="button"
                                                title="SPEAKER A">
                                                <span>1. SPEAKER A</span>
                                                </button>
                                                {{-- <button class="multisteps-form__progress-btn" disabled type="button" title="SPEAKER B">2.
                                                    SPEAKER B</button>
                                                <button class="multisteps-form__progress-btn" disabled type="button" title="SPEAKER C">3.
                                                    SPEAKER C</button> --}}
                                                <button class="multisteps-form__progress-btn" disabled type="button" title="SUMMARY">
                                                        SUMMARY</button>
                                               
                                               
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form class="multisteps-form__form">
                                        
                                            <div class="multisteps-form__panel pt-3 border-radius-xl bg-white js-active"
                                                    data-animation="FadeIn">
                                                <div class="row mb-1">
                                                    <div class="col-12">
                                                        <label class="text-danger">EVALUATE EACH TOPIC USING THE FOLLOWING SCALE:</label>
                                                    </div>
                                                </div>
                                                <div class="row align-middle">
                                                    <div class="col-1">
                                                        <label class="text-bold">1</label>
                                                    </div>
                                                    <div class="col-2">
                                                        <label class="text-bold">POOR</label>
                                                    </div>
                                                    <div class="col-1">
                                                        <label class="text-bold">2</label>
                                                    </div>
                                                    <div class="col-2">
                                                        <label class="text-bold">FAIR</label>
                                                    </div>
                                                    <div class="col-1">
                                                        <label class="text-bold">3</label>
                                                    </div>
                                                    <div class="col-2">
                                                        <label class="text-bold">GOOD</label>
                                                    </div>
                                                    <div class="col-1">
                                                        <label class="text-bold">4</label>
                                                    </div>
                                                    <div class="col-2">
                                                        <label class="text-bold">VERY GOOD</label>
                                                    </div>
                                                </div>
                                                <HR>
                                                

                                                <h5 class="font-weight-bolder text-danger mt-2">SPEAKER A</h5>
                                                <div class="multisteps-form__content">
                                                    <div class="row mt-2">
                                                        <div class="col-12 text-center">
                                                            <h5 class="text-bold">CONTENT</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="text-bold">- OBJECTIVES</label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 bg-gray-200 mb-3">
                                                        <div class="col-12 col-md-12 align-middle my-auto">
                                                            
                                                            <div class="row">
                                                               <div class="col-3">
                                                                 <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker1_objectives" value="1">
                                                                    <label class="form-check-label" for="speaker1_objectives">1</label>
                                                                  </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                       <input class="form-check-input" type="radio" name="speaker1_objectives" value="2">
                                                                       <label class="form-check-label" for="speaker1_objectives">2</label>
                                                                     </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                       <input class="form-check-input" type="radio" name="speaker1_objectives" value="3">
                                                                       <label class="form-check-label" for="speaker1_objectives">3</label>
                                                                     </div>
                                                                   </div> 
                                                                   <div class="col-3">
                                                                       <div class="form-check form-check-inline">
                                                                          <input class="form-check-input" type="radio" name="speaker1_objectives" value="4">
                                                                          <label class="form-check-label" for="speaker1_objectives">4</label>
                                                                        </div>
                                                                   </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="text-bold">- INFORMATION PRESENTED</label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 bg-gray-200 mb-3">
                                                        <div class="col-12 col-md-12 align-middle my-auto">
                                                            <div class="row">
                                                               <div class="col-3">
                                                                 <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker1_information_presented" value="1">
                                                                    <label class="form-check-label" for="speaker1_information_presented">1</label>
                                                                  </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                       <input class="form-check-input" type="radio" name="speaker1_information_presented" value="2">
                                                                       <label class="form-check-label" for="speaker1_information_presented">2</label>
                                                                     </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                       <input class="form-check-input" type="radio" name="speaker1_information_presented" value="3">
                                                                       <label class="form-check-label" for="speaker1_information_presented">3</label>
                                                                     </div>
                                                                   </div> 
                                                                   <div class="col-3">
                                                                       <div class="form-check form-check-inline">
                                                                          <input class="form-check-input" type="radio" name="speaker1_information_presented" value="4">
                                                                          <label class="form-check-label" for="speaker1_information_presented">4</label>
                                                                        </div>
                                                                   </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="text-bold">- ORGANIZATION</label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 bg-gray-200 mb-3">
                                                        <div class="col-12 col-md-12 align-middle my-auto">
                                                            <div class="row">
                                                               <div class="col-3">
                                                                 <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker1_organization" value="1">
                                                                    <label class="form-check-label" for="speaker1_organization">1</label>
                                                                  </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                       <input class="form-check-input" type="radio" name="speaker1_organization" value="2">
                                                                       <label class="form-check-label" for="speaker1_organization">2</label>
                                                                     </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                       <input class="form-check-input" type="radio" name="speaker1_organization" value="3">
                                                                       <label class="form-check-label" for="speaker1_organization">3</label>
                                                                     </div>
                                                                   </div> 
                                                                   <div class="col-3">
                                                                       <div class="form-check form-check-inline">
                                                                          <input class="form-check-input" type="radio" name="speaker1_organization" value="4">
                                                                          <label class="form-check-label" for="speaker1_organization">4</label>
                                                                        </div>
                                                                   </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="text-bold">- CONCLUSIONS</label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 bg-gray-200 mb-3">
                                                        <div class="col-12 col-md-12 align-middle my-auto">
                                                            <div class="row">
                                                               <div class="col-3">
                                                                 <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker1_conclusions" value="1">
                                                                    <label class="form-check-label" for="speaker1_conclusions">1</label>
                                                                  </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                       <input class="form-check-input" type="radio" name="speaker1_conclusions" value="2">
                                                                       <label class="form-check-label" for="speaker1_conclusions">2</label>
                                                                     </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                       <input class="form-check-input" type="radio" name="speaker1_conclusions" value="3">
                                                                       <label class="form-check-label" for="speaker1_conclusions">3</label>
                                                                     </div>
                                                                   </div> 
                                                                   <div class="col-3">
                                                                       <div class="form-check form-check-inline">
                                                                          <input class="form-check-input" type="radio" name="speaker1_conclusions" value="4">
                                                                          <label class="form-check-label" for="speaker1_conclusions">4</label>
                                                                        </div>
                                                                   </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-2">
                                                        <div class="col-12 text-center">
                                                            <h5 class="text-bold">DELIVERY</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="text-bold">- CONFIDENCE</label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 bg-gray-200 mb-3">
                                                        <div class="col-12 col-md-12 align-middle my-auto">
                                                            <div class="row">
                                                               <div class="col-3">
                                                                 <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker1_confidence" value="1">
                                                                    <label class="form-check-label" for="speaker1_confidence">1</label>
                                                                  </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                       <input class="form-check-input" type="radio" name="speaker1_confidence" value="2">
                                                                       <label class="form-check-label" for="speaker1_confidence">2</label>
                                                                     </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                       <input class="form-check-input" type="radio" name="speaker1_confidence" value="3">
                                                                       <label class="form-check-label" for="speaker1_confidence">3</label>
                                                                     </div>
                                                                   </div> 
                                                                   <div class="col-3">
                                                                       <div class="form-check form-check-inline">
                                                                          <input class="form-check-input" type="radio" name="speaker1_confidence" value="4">
                                                                          <label class="form-check-label" for="speaker1_confidence">4</label>
                                                                        </div>
                                                                   </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="text-bold">- STATE PRESENCE</label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 bg-gray-200 mb-3">
                                                        <div class="col-12 col-md-12 align-middle my-auto">
                                                            <div class="row">
                                                               <div class="col-3">
                                                                 <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker1_state_presence" value="1">
                                                                    <label class="form-check-label" for="speaker1_state_presence">1</label>
                                                                  </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                       <input class="form-check-input" type="radio" name="speaker1_state_presence" value="2">
                                                                       <label class="form-check-label" for="speaker1_state_presence">2</label>
                                                                     </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                       <input class="form-check-input" type="radio" name="speaker1_state_presence" value="3">
                                                                       <label class="form-check-label" for="speaker1_state_presence">3</label>
                                                                     </div>
                                                                   </div> 
                                                                   <div class="col-3">
                                                                       <div class="form-check form-check-inline">
                                                                          <input class="form-check-input" type="radio" name="speaker1_state_presence" value="4">
                                                                          <label class="form-check-label" for="speaker1_state_presence">4</label>
                                                                        </div>
                                                                   </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="text-bold">- ABILITY TO MAINTAIN AUDIENCE INTEREST AND ENGAGEMENT</label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 bg-gray-200 mb-3">
                                                        <div class="col-12 col-md-12 align-middle my-auto">
                                                            <div class="row">
                                                               <div class="col-3">
                                                                 <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker1_audience_interest" value="1">
                                                                    <label class="form-check-label" for="speaker1_audience_interest">1</label>
                                                                  </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                       <input class="form-check-input" type="radio" name="speaker1_audience_interest" value="2">
                                                                       <label class="form-check-label" for="speaker1_audience_interest">2</label>
                                                                     </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                       <input class="form-check-input" type="radio" name="speaker1_audience_interest" value="3">
                                                                       <label class="form-check-label" for="speaker1_audience_interest">3</label>
                                                                     </div>
                                                                   </div> 
                                                                   <div class="col-3">
                                                                       <div class="form-check form-check-inline">
                                                                          <input class="form-check-input" type="radio" name="speaker1_audience_interest" value="4">
                                                                          <label class="form-check-label" for="speaker1_audience_interest">4</label>
                                                                        </div>
                                                                   </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-12 text-center">
                                                            <h5 class="text-bold">VISUAL AIDS</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="text-bold">- CLARITY OF VISUAL AIDS</label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 bg-gray-200 mb-3">
                                                        <div class="col-12 col-md-12 align-middle my-auto">
                                                            <div class="row">
                                                               <div class="col-3">
                                                                 <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker1_visual_aids" value="1">
                                                                    <label class="form-check-label" for="speaker1_visual_aids">1</label>
                                                                  </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                       <input class="form-check-input" type="radio" name="speaker1_visual_aids" value="2">
                                                                       <label class="form-check-label" for="speaker1_visual_aids">2</label>
                                                                     </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                       <input class="form-check-input" type="radio" name="speaker1_visual_aids" value="3">
                                                                       <label class="form-check-label" for="speaker1_visual_aids">3</label>
                                                                     </div>
                                                                   </div> 
                                                                   <div class="col-3">
                                                                       <div class="form-check form-check-inline">
                                                                          <input class="form-check-input" type="radio" name="speaker1_visual_aids" value="4">
                                                                          <label class="form-check-label" for="speaker1_visual_aids">4</label>
                                                                        </div>
                                                                   </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    <div class="button-row d-flex mt-4">
                                                        <button class="btn bg-gradient-success btn-lg ms-auto mb-0 js-btn-next proceed-next" id="form1btn"
                                                            type="button" title="Next">Next</button>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- <div class="multisteps-form__panel pt-3 border-radius-xl bg-white"
                                                data-animation="FadeIn">
                                                <div class="row mb-1">
                                                    <div class="col-12">
                                                        <label class="text-danger">EVALUATE EACH TOPIC USING THE FOLLOWING SCALE:</label>
                                                    </div>
                                                </div>
                                                <div class="row align-middle">
                                                    <div class="col-1">
                                                        <label class="text-bold">1</label>
                                                    </div>
                                                    <div class="col-2">
                                                        <label class="text-bold">POOR</label>
                                                    </div>
                                                    <div class="col-1">
                                                        <label class="text-bold">2</label>
                                                    </div>
                                                    <div class="col-2">
                                                        <label class="text-bold">FAIR</label>
                                                    </div>
                                                    <div class="col-1">
                                                        <label class="text-bold">3</label>
                                                    </div>
                                                    <div class="col-2">
                                                        <label class="text-bold">GOOD</label>
                                                    </div>
                                                    <div class="col-1">
                                                        <label class="text-bold">4</label>
                                                    </div>
                                                    <div class="col-2">
                                                        <label class="text-bold">VERY GOOD</label>
                                                    </div>
                                                </div>
                                                <HR>
                                        

                                                <h5 class="font-weight-bolder text-danger mt-2">SPEAKER B</h5>
                                                <div class="multisteps-form__content">
                                                    <div class="row mt-2">
                                                        <div class="col-12 text-center">
                                                            <h5 class="text-bold">CONTENT</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="text-bold">- OBJECTIVES</label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 bg-gray-200 mb-3">
                                                        <div class="col-12 col-md-12 align-middle my-auto">
                                                            
                                                            <div class="row">
                                                            <div class="col-3">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker2_objectives" value="1">
                                                                    <label class="form-check-label" for="speaker2_objectives">1</label>
                                                                </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker2_objectives" value="2">
                                                                    <label class="form-check-label" for="speaker2_objectives">2</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker2_objectives" value="3">
                                                                    <label class="form-check-label" for="speaker2_objectives">3</label>
                                                                    </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="speaker2_objectives" value="4">
                                                                        <label class="form-check-label" for="speaker2_objectives">4</label>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="text-bold">- INFORMATION PRESENTED</label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 bg-gray-200 mb-3">
                                                        <div class="col-12 col-md-12 align-middle my-auto">
                                                            <div class="row">
                                                            <div class="col-3">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker2_information_presented" value="1">
                                                                    <label class="form-check-label" for="speaker2_information_presented">1</label>
                                                                </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker2_information_presented" value="2">
                                                                    <label class="form-check-label" for="speaker2_information_presented">2</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker2_information_presented" value="3">
                                                                    <label class="form-check-label" for="speaker2_information_presented">3</label>
                                                                    </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="speaker2_information_presented" value="4">
                                                                        <label class="form-check-label" for="speaker2_information_presented">4</label>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="text-bold">- ORGANIZATION</label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 bg-gray-200 mb-3">
                                                        <div class="col-12 col-md-12 align-middle my-auto">
                                                            <div class="row">
                                                            <div class="col-3">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker2_organization" value="1">
                                                                    <label class="form-check-label" for="speaker2_organization">1</label>
                                                                </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker2_organization" value="2">
                                                                    <label class="form-check-label" for="speaker2_organization">2</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker2_organization" value="3">
                                                                    <label class="form-check-label" for="speaker2_organization">3</label>
                                                                    </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="speaker2_organization" value="4">
                                                                        <label class="form-check-label" for="speaker2_organization">4</label>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="text-bold">- CONCLUSIONS</label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 bg-gray-200 mb-3">
                                                        <div class="col-12 col-md-12 align-middle my-auto">
                                                            <div class="row">
                                                            <div class="col-3">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker2_conclusions" value="1">
                                                                    <label class="form-check-label" for="speaker2_conclusions">1</label>
                                                                </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker2_conclusions" value="2">
                                                                    <label class="form-check-label" for="speaker2_conclusions">2</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker2_conclusions" value="3">
                                                                    <label class="form-check-label" for="speaker2_conclusions">3</label>
                                                                    </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="speaker2_conclusions" value="4">
                                                                        <label class="form-check-label" for="speaker2_conclusions">4</label>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-2">
                                                        <div class="col-12 text-center">
                                                            <h5 class="text-bold">DELIVERY</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="text-bold">- CONFIDENCE</label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 bg-gray-200 mb-3">
                                                        <div class="col-12 col-md-12 align-middle my-auto">
                                                            <div class="row">
                                                            <div class="col-3">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker2_confidence" value="1">
                                                                    <label class="form-check-label" for="speaker2_confidence">1</label>
                                                                </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker2_confidence" value="2">
                                                                    <label class="form-check-label" for="speaker2_confidence">2</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker2_confidence" value="3">
                                                                    <label class="form-check-label" for="speaker2_confidence">3</label>
                                                                    </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="speaker2_confidence" value="4">
                                                                        <label class="form-check-label" for="speaker2_confidence">4</label>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="text-bold">- STATE PRESENCE</label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 bg-gray-200 mb-3">
                                                        <div class="col-12 col-md-12 align-middle my-auto">
                                                            <div class="row">
                                                            <div class="col-3">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker2_state_presence" value="1">
                                                                    <label class="form-check-label" for="speaker1_state_presence">1</label>
                                                                </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker2_state_presence" value="2">
                                                                    <label class="form-check-label" for="speaker2_state_presence">2</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker2_state_presence" value="3">
                                                                    <label class="form-check-label" for="speaker2_state_presence">3</label>
                                                                    </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="speaker2_state_presence" value="4">
                                                                        <label class="form-check-label" for="speaker2_state_presence">4</label>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="text-bold">- ABILITY TO MAINTAIN AUDIENCE INTEREST AND ENGAGEMENT</label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 bg-gray-200 mb-3">
                                                        <div class="col-12 col-md-12 align-middle my-auto">
                                                            <div class="row">
                                                            <div class="col-3">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker2_audience_interest" value="1">
                                                                    <label class="form-check-label" for="speaker2_audience_interest">1</label>
                                                                </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker2_audience_interest" value="2">
                                                                    <label class="form-check-label" for="speaker2_audience_interest">2</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker2_audience_interest" value="3">
                                                                    <label class="form-check-label" for="speaker2_audience_interest">3</label>
                                                                    </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="speaker2_audience_interest" value="4">
                                                                        <label class="form-check-label" for="speaker2_audience_interest">4</label>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-12 text-center">
                                                            <h5 class="text-bold">VISUAL AIDS</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="text-bold">- CLARITY OF VISUAL AIDS</label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 bg-gray-200 mb-3">
                                                        <div class="col-12 col-md-12 align-middle my-auto">
                                                            <div class="row">
                                                            <div class="col-3">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker2_visual_aids" value="1">
                                                                    <label class="form-check-label" for="speaker2_visual_aids">1</label>
                                                                </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker2_visual_aids" value="2">
                                                                    <label class="form-check-label" for="speaker2_visual_aids">2</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker2_visual_aids" value="3">
                                                                    <label class="form-check-label" for="speaker2_visual_aids">3</label>
                                                                    </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="speaker2_visual_aids" value="4">
                                                                        <label class="form-check-label" for="speaker2_visual_aids">4</label>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    <div class="button-row d-flex mt-4">
                                                        <button class="btn bg-gradient-success btn-lg ms-auto mb-0 js-btn-next proceed-next2" id="form2btn"
                                                            type="button" title="Next">Next</button>
                                                    </div>
                                                </div>
                                            </div> --}}

                                            {{-- <div class="multisteps-form__panel pt-3 border-radius-xl bg-white"
                                                data-animation="FadeIn">
                                                <div class="row mb-1">
                                                    <div class="col-12">
                                                        <label class="text-danger">EVALUATE EACH TOPIC USING THE FOLLOWING SCALE:</label>
                                                    </div>
                                                </div>
                                                <div class="row align-middle">
                                                    <div class="col-1">
                                                        <label class="text-bold">1</label>
                                                    </div>
                                                    <div class="col-2">
                                                        <label class="text-bold">POOR</label>
                                                    </div>
                                                    <div class="col-1">
                                                        <label class="text-bold">2</label>
                                                    </div>
                                                    <div class="col-2">
                                                        <label class="text-bold">FAIR</label>
                                                    </div>
                                                    <div class="col-1">
                                                        <label class="text-bold">3</label>
                                                    </div>
                                                    <div class="col-2">
                                                        <label class="text-bold">GOOD</label>
                                                    </div>
                                                    <div class="col-1">
                                                        <label class="text-bold">4</label>
                                                    </div>
                                                    <div class="col-2">
                                                        <label class="text-bold">VERY GOOD</label>
                                                    </div>
                                                </div>
                                                <HR>
                                        

                                                <h5 class="font-weight-bolder text-danger mt-2">SPEAKER C</h5>
                                                <div class="multisteps-form__content">
                                                    <div class="row mt-2">
                                                        <div class="col-12 text-center">
                                                            <h5 class="text-bold">CONTENT</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="text-bold">- OBJECTIVES</label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 bg-gray-200 mb-3">
                                                        <div class="col-12 col-md-12 align-middle my-auto">
                                                            
                                                            <div class="row">
                                                            <div class="col-3">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker3_objectives" value="1">
                                                                    <label class="form-check-label" for="speaker3_objectives">1</label>
                                                                </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker3_objectives" value="2">
                                                                    <label class="form-check-label" for="speaker3_objectives">2</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker3_objectives" value="3">
                                                                    <label class="form-check-label" for="speaker3_objectives">3</label>
                                                                    </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="speaker3_objectives" value="4">
                                                                        <label class="form-check-label" for="speaker3_objectives">4</label>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="text-bold">- INFORMATION PRESENTED</label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 bg-gray-200 mb-3">
                                                        <div class="col-12 col-md-12 align-middle my-auto">
                                                            <div class="row">
                                                            <div class="col-3">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker3_information_presented" value="1">
                                                                    <label class="form-check-label" for="speaker3_information_presented">1</label>
                                                                </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker3_information_presented" value="2">
                                                                    <label class="form-check-label" for="speaker3_information_presented">2</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker3_information_presented" value="3">
                                                                    <label class="form-check-label" for="speaker3_information_presented">3</label>
                                                                    </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="speaker3_information_presented" value="4">
                                                                        <label class="form-check-label" for="speaker3_information_presented">4</label>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="text-bold">- ORGANIZATION</label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 bg-gray-200 mb-3">
                                                        <div class="col-12 col-md-12 align-middle my-auto">
                                                            <div class="row">
                                                            <div class="col-3">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker3_organization" value="1">
                                                                    <label class="form-check-label" for="speaker3_organization">1</label>
                                                                </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker3_organization" value="2">
                                                                    <label class="form-check-label" for="speaker3_organization">2</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker3_organization" value="3">
                                                                    <label class="form-check-label" for="speaker3_organization">3</label>
                                                                    </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="speaker3_organization" value="4">
                                                                        <label class="form-check-label" for="speaker3_organization">4</label>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="text-bold">- CONCLUSIONS</label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 bg-gray-200 mb-3">
                                                        <div class="col-12 col-md-12 align-middle my-auto">
                                                            <div class="row">
                                                            <div class="col-3">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker3_conclusions" value="1">
                                                                    <label class="form-check-label" for="speaker3_conclusions">1</label>
                                                                </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker3_conclusions" value="2">
                                                                    <label class="form-check-label" for="speaker3_conclusions">2</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker3_conclusions" value="3">
                                                                    <label class="form-check-label" for="speaker3_conclusions">3</label>
                                                                    </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="speaker3_conclusions" value="4">
                                                                        <label class="form-check-label" for="speaker3_conclusions">4</label>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-2">
                                                        <div class="col-12 text-center">
                                                            <h5 class="text-bold">DELIVERY</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="text-bold">- CONFIDENCE</label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 bg-gray-200 mb-3">
                                                        <div class="col-12 col-md-12 align-middle my-auto">
                                                            <div class="row">
                                                            <div class="col-3">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker3_confidence" value="1">
                                                                    <label class="form-check-label" for="speaker3_confidence">1</label>
                                                                </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker3_confidence" value="2">
                                                                    <label class="form-check-label" for="speaker3_confidence">2</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker3_confidence" value="3">
                                                                    <label class="form-check-label" for="speaker3_confidence">3</label>
                                                                    </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="speaker3_confidence" value="4">
                                                                        <label class="form-check-label" for="speaker3_confidence">4</label>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="text-bold">- STATE PRESENCE</label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 bg-gray-200 mb-3">
                                                        <div class="col-12 col-md-12 align-middle my-auto">
                                                            <div class="row">
                                                            <div class="col-3">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker3_state_presence" value="1">
                                                                    <label class="form-check-label" for="speaker3_state_presence">1</label>
                                                                </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker3_state_presence" value="2">
                                                                    <label class="form-check-label" for="speaker3_state_presence">2</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker3_state_presence" value="3">
                                                                    <label class="form-check-label" for="speaker3_state_presence">3</label>
                                                                    </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="speaker3_state_presence" value="4">
                                                                        <label class="form-check-label" for="speaker3_state_presence">4</label>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="text-bold">- ABILITY TO MAINTAIN AUDIENCE INTEREST AND ENGAGEMENT</label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 bg-gray-200 mb-3">
                                                        <div class="col-12 col-md-12 align-middle my-auto">
                                                            <div class="row">
                                                            <div class="col-3">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker3_audience_interest" value="1">
                                                                    <label class="form-check-label" for="speaker3_audience_interest">1</label>
                                                                </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker3_audience_interest" value="2">
                                                                    <label class="form-check-label" for="speaker3_audience_interest">2</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker3_audience_interest" value="3">
                                                                    <label class="form-check-label" for="speaker3_audience_interest">3</label>
                                                                    </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="speaker3_audience_interest" value="4">
                                                                        <label class="form-check-label" for="speaker3_audience_interest">4</label>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-12 text-center">
                                                            <h5 class="text-bold">VISUAL AIDS</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="text-bold">- CLARITY OF VISUAL AIDS</label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 bg-gray-200 mb-3">
                                                        <div class="col-12 col-md-12 align-middle my-auto">
                                                            <div class="row">
                                                            <div class="col-3">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker3_visual_aids" value="1">
                                                                    <label class="form-check-label" for="speaker3_visual_aids">1</label>
                                                                </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker3_visual_aids" value="2">
                                                                    <label class="form-check-label" for="speaker3_visual_aids">2</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="speaker3_visual_aids" value="3">
                                                                    <label class="form-check-label" for="speaker3_visual_aids">3</label>
                                                                    </div>
                                                                </div> 
                                                                <div class="col-3">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="speaker3_visual_aids" value="4">
                                                                        <label class="form-check-label" for="speaker3_visual_aids">4</label>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    <div class="button-row d-flex mt-4">
                                                        <button class="btn bg-gradient-success btn-lg ms-auto mb-0 js-btn-next proceed-next3" id="form3btn"
                                                            type="button" title="Next">Next</button>
                                                    </div>
                                                </div>
                                            </div> --}}

                                            <div class="multisteps-form__panel pt-3 border-radius-xl bg-white"
                                                data-animation="FadeIn">
                                                
                                               
                                                <div class="multisteps-form__content">
                                                    <div class="row">
                                                        <div class="col-12 text-center">
                                                            <h5 class="text-bold">SUMMARY SCORE OF EVALUATION</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row" id="refreshDiv">
                                                        <div class="col-12 col-md-12">
                                                            <div class="table-responsive p-0">
                                                                <table class="table align-items-center mb-0">
                                                                    <thead>
                                                                        <tr>
                                                                            <th
                                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                SPEAKER</th>
                                                                            <th
                                                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                TOTAL SCORE</th>
                                                                           
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex px-3 py-1">
                                                                                    <div>
                                                                                        <img src="{{ asset('assets') }}/img/default-avatar.png"
                                                                                            class="avatar me-3" alt="image">
                                                                                    </div>
                                                                                    <div class="d-flex flex-column justify-content-center">
                                                                                        <h6 class="mb-0 text-sm">SPEAKER A</h6>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <p class="text-sm font-weight-bold mb-0">{{ $speakerATotal }}</p>
                                                                            </td>
                                                                          
                                                                        </tr>
                                                                        {{-- <tr>
                                                                            <td>
                                                                                <div class="d-flex px-3 py-1">
                                                                                    <div>
                                                                                        <img src="{{ asset('assets') }}/img/default-avatar.png"
                                                                                            class="avatar me-3" alt="image">
                                                                                    </div>
                                                                                    <div class="d-flex flex-column justify-content-center">
                                                                                        <h6 class="mb-0 text-sm">SPEAKER B</h6>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <p class="text-sm font-weight-bold mb-0">{{ $speakerBTotal }}</p>
                                                                            </td>
                                                                          
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex px-3 py-1">
                                                                                    <div>
                                                                                        <img src="{{ asset('assets') }}/img/default-avatar.png"
                                                                                            class="avatar me-3" alt="image">
                                                                                    </div>
                                                                                    <div class="d-flex flex-column justify-content-center">
                                                                                        <h6 class="mb-0 text-sm">SPEAKER C</h6>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <p class="text-sm font-weight-bold mb-0">{{ $speakerCTotal }}</p>
                                                                            </td>
                                                                          
                                                                        </tr> --}}
                                                                       
                                                                      
                                                                      
                                                                       
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                             
                                                    
                                                    <div class="button-row d-flex mt-4">
                                                        <button class="btn bg-gradient-success btn-lg ms-auto mb-0" id="completebtn"
                                                            type="button" title="Next">COMPLETE EVALUATION</button>
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
    <script src="{{ asset('assets') }}/js/online-topic-question-answer-plenary.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/choices.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/multistep-form.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>

    @endpush
</x-page-template>
