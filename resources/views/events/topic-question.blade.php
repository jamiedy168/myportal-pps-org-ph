<x-page-template bodyClass='g-sidenav-show bg-gray-200'>
    <x-auth.navbars.sidebar activePage='events' activeItem='listing' activeSubitem=''></x-auth.navbars.sidebar>
    <main class="main-content main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-auth.navbars.navs.auth pageTitle='Events'></x-auth.navbars.navs.auth>

        <div class="container-fluid my-3 ">
              {{-- START OF ADD QUESTION MODAL --}}
              <div class="modal fade" id="modalAddQuestion" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered " role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                    <div class="card card-plain">
                        <div class="card-header p-3 pb-0">
                        <div class="row">
                            <div class="col-8">
                                <h6 class="mb-0 text-danger">ADD NEW QUESTION</h6>
                                <p class="text-sm mb-0 font-weight-normal">Please fill-up information below</p>
                            </div>
                            <div class="col-4" style="text-align: right !important">
                                <button type="button" class="btn-close" style="color: black !important" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>

                        </div>

                        <div class="card-body pb-3">
                            <form method="POST" role="form" enctype="multipart/form-data" id="form-add-question">
                                @csrf
                                {{-- START OF HIDDEN INPUT --}}
                                    <input type="hidden" value="{{ url('event-topic-add-question') }}" id="urlEventTopicAddQuestion">
                                    <input type="hidden" value="{{ url('event-topic-add-fb-live-url') }}" id="urlEventTopicAddFBLiveUrl">
                                    <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">
                                    <input type="hidden" id="topic_id" name="topic_id" value="{{ $eventTopicId }}">
                                    <input type="hidden" id="letter" name="letter[]" value="A">
                                    <input type="hidden" id="letter" name="letter[]" value="B">
                                    <input type="hidden" id="letter" name="letter[]" value="C">
                                    <input type="hidden" id="letter" name="letter[]" value="D">
                                    <input type="hidden" id="letter" name="letter[]" value="E">
                                    <input type="hidden" id="letter" name="letter[]" value="F">
                                {{-- END OF HIDDEN INPUT --}}
                                <div class="row">
                                    <div class="col-12">
                                        <label class="form-label text-bold">QUESTION</label>
                                    <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                        <textarea class="form-control" rows="3" required id="question" name="question" placeholder="Enter question here.."></textarea>

                                    </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="input-group input-group-outline mb-4">
                                            <span class="input-group-text text-bold" style="position: initial !important;" id="basic-addon1">A.) &nbsp;</span>
                                            <input type="text" id="choiceA" required name="choices[]" class="form-control" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="input-group input-group-outline mb-4">
                                            <span class="input-group-text text-bold" style="position: initial !important;" id="basic-addon1">B.) &nbsp;</span>
                                            <input type="text" class="form-control" required name="choices[]" id="choiceB" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="input-group input-group-outline mb-4">
                                            <span class="input-group-text text-bold" style="position: initial !important;" id="basic-addon1">C.) &nbsp;</span>
                                            <input type="text" class="form-control" name="choices[]" id="choiceC" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="input-group input-group-outline mb-4">
                                            <span class="input-group-text text-bold" style="position: initial !important;" id="basic-addon1">D.) &nbsp;</span>
                                            <input type="text" class="form-control" name="choices[]" id="choiceD" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="input-group input-group-outline mb-4">
                                            <span class="input-group-text text-bold" style="position: initial !important;" id="basic-addon1">E.) &nbsp;</span>
                                            <input type="text" class="form-control" name="choices[]" id="choiceE" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="input-group input-group-outline mb-4">
                                            <span class="input-group-text text-bold" style="position: initial !important;" id="basic-addon1">F.) &nbsp;</span>
                                            <input type="text" class="form-control" name="choices[]" id="choiceF" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-5 col-lg-5">
                                        <label class="form-label text-bold">CHOOSE CORRECT ANSWER</label>
                                    <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                        <select name="answer" id="answer" required class="form-control text-center">
                                            <option value="">Choose</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                            <option value="E">E</option>
                                            <option value="F">F</option>

                                        </select>

                                    </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12" style="text-align: right !important">
                                    <button class="btn btn-danger" type="submit">
                                            SAVE
                                    </button>
                                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">
                                            CANCEL
                                    </button>
                                    </div>
                                </div>

                            </form>



                        </div>

                    </div>
                    </div>
                </div>
                </div>
                </div>
              {{-- END OF ATTENDEE MODAL --}}

              {{-- START OF UPDATE MODAL --}}
              <div class="modal fade" id="modalUpdateTopic" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                        <div class="card card-plain">
                            <div class="card-header p-3 pb-0">
                                <div class="row">
                                    <div class="col-8">
                                        <h6 class="mb-0 text-danger">UPDATE TOPIC DETAILS</h6>
                                        <p class="text-sm mb-0 font-weight-normal">Please fill-up information below</p>
                                    </div>
                                    <div class="col-4" style="text-align: right !important">
                                        <button type="button" class="btn-close" style="color: black !important" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>

                            </div>

                            <div class="card-body pb-3">
                                <form method="POST" role="form" enctype="multipart/form-data" id="form-update-topic">
                                    @csrf
                                    {{-- START OF HIDDEN INPUT --}}
                                        <input type="hidden" value="{{ url('event-topic-update') }}" id="urlEventTopicUpdate">
                                    {{-- END OF HIDDEN INPUT --}}
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                        <label class="form-label text-bold">Topic Name<code> <b>*</b></code></label>
                                        <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                            <input type="text" class="form-control" placeholder="Enter Topic Name" name="topic_name" id="topic_name" required value="{{ $eventTopic->topic_name }}">
                                        </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12 col-md-6">
                                        <label class="form-label text-bold">CPD Points Onsite<code> <b>*</b></code></label>
                                        <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                            <input type="number" class="form-control" step="any" min="0" placeholder="Enter Points Onsite" name="points_on_site" id="points_on_site" value="{{ $eventTopic->points_on_site }}">
                                        </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label text-bold">CPD Points Online<code> <b>*</b></code></label>
                                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                            <input type="number" class="form-control" step="any" min="0" placeholder="Enter Points Online" name="points_online" id="points_online" value="{{ $eventTopic->points_online }}">
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="row mt-3">
                                        <div class="col-12" style="text-align: right !important">
                                        <button class="btn btn-danger" type="submit">
                                                SAVE
                                        </button>
                                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">
                                                CANCEL
                                        </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                        </div>
                    </div>
                </div>
              </div>
              {{-- END OF UPDATE MODAL --}}



              <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-2">

                        <div class="card-body p-3">
                            <h5 class="mb-4 text-gradient text-danger">EVENT TOPIC INFORMATION</h5>
                            <div class="row mt-1">
                                <div class="col-12 col-lg-9 mx-auto">
                                    <span><h4 class="mt-lg-0 mt-4 ">TOPIC: {{ $eventTopic->topic_name }} <a href="#" data-bs-toggle="tooltip" type="button" data-bs-placement="top" title="Update Topic Details" class="btn btn-link btn-icon-only btn-rounded text-warning icon-move-right my-auto" style="margin-top: -5px !important"> 
                                        <i class="material-icons" data-bs-toggle="modal" data-bs-target="#modalUpdateTopic" aria-hidden="true">edit</i></a></h4></span> 
                                
                                    @switch($eventTopic->status)
                                        @case("UPCOMING")
                                            <span class="badge badge-warning">{{ $eventTopic->status }}</span>
                                            @break
                                        @case("ONGOING")
                                            <span class="badge badge-danger">{{ $eventTopic->status }}</span>
                                        @break
                                        @case("COMPLETED")
                                            <span class="badge badge-success">{{ $eventTopic->status }}</span>
                                        @break

                                        @default
                                        <span class="badge badge-primary">{{ $eventTopic->status }}</span>
                                    @endswitch
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <div class="d-sm-flex bg-gray-100 border-radius-lg p-2 my-1">
                                                <p class="text-sm font-weight-bold my-auto ps-sm-2">  <i class="fas fa-paste text-lg opacity-6" style="margin-top: 7px !important"></i> &nbsp;EVENT TITLE</p>
                                                <label class="ms-sm-auto mt-sm-2 mt-2 w-sm-50 w-70" style="text-transform: uppercase">{{ $eventTopic->title }}</label>
                                            </div>
                                            <div class="d-sm-flex bg-gray-100 border-radius-lg p-2 my-2">
                                                <p class="text-sm font-weight-bold my-auto ps-sm-2"> <i class="fas fa-calendar text-lg opacity-6" style="margin-top: 7px !important"></i> &nbsp;DATE</p>
                                                @if ($eventTopic->start_dt == $eventTopic->end_dt)
                                                    <label class="ms-sm-auto mt-sm-2 mt-2 w-sm-50 w-70" style="text-transform: uppercase">{{ Carbon\Carbon::parse($eventTopic->start_dt)->format('F d, Y') }}</label>
                                                @else
                                                <label class="ms-sm-auto mt-sm-2 mt-2 w-sm-50 w-70" style="text-transform: uppercase">{{ Carbon\Carbon::parse($eventTopic->start_dt)->format('F d, Y') }} - {{ Carbon\Carbon::parse($eventTopic->end_dt)->format('F d, Y') }} </label>
                                                @endif
                                            </div>
                                            <div class="d-sm-flex bg-gray-100 border-radius-lg p-2 my-2">
                                                <p class="text-sm font-weight-bold my-auto ps-sm-2"> <i class="fas fa-calendar text-lg opacity-6" style="margin-top: 7px !important"></i> &nbsp;TIME</p>
                                                <label class="ms-sm-auto mt-sm-2 mt-2 w-sm-50 w-70" style="text-transform: uppercase">{{ Carbon\Carbon::parse($eventTopic->start_time)->format('h: i a') }} - {{ Carbon\Carbon::parse($eventTopic->end_time)->format('h: i a') }}</label>
                                            </div>
                                            <div class="d-sm-flex bg-gray-100 border-radius-lg p-2 my-2">
                                                <p class="text-sm font-weight-bold my-auto ps-sm-2"> <i class="fas fa-location-arrow text-lg opacity-6" style="margin-top: 7px !important"></i> &nbsp;VENUE</p>
                                                <label class="ms-sm-auto mt-sm-2 mt-2 w-sm-50 w-70" style="text-transform: uppercase">{{ $eventTopic->venue }}</label>
                                            </div>
                                            <div class="d-sm-flex bg-gray-100 border-radius-lg p-2 my-2">
                                                <p class="text-sm font-weight-bold my-auto ps-sm-2"> <i class="fas fa-trophy text-lg opacity-6" style="margin-top: 7px !important"></i> &nbsp;CPD POINTS ONSITE</p>
                                                <label class="ms-sm-auto mt-sm-2 mt-2 w-sm-50 w-70" style="text-transform: uppercase">{{ $eventTopic->points_on_site }}</label>
                                            </div>
                                            <div class="d-sm-flex bg-gray-100 border-radius-lg p-2 my-2">
                                                <p class="text-sm font-weight-bold my-auto ps-sm-2"> <i class="fas fa-trophy text-lg opacity-6" style="margin-top: 7px !important"></i> &nbsp;CPD POINTS ONLINE</p>
                                                <label class="ms-sm-auto mt-sm-2 mt-2 w-sm-50 w-70" style="text-transform: uppercase">{{ $eventTopic->points_online }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <input type="text" value="{{ $eventtopicurl }}"> --}}


                                <div class="col-12 col-lg-3" style="text-align: center !important">
                                    <div class="row mt-7">
                                        <div class="col-12">
                                            {!! QrCode::size(250)->generate($eventtopicurl) !!}
                                           <input type="hidden" value="{{ $eventtopicurl }}">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12 col-lg-12">
                                            <a class="btn btn-danger" href="/event-topic-download-qr/{{ Crypt::encrypt($eventtopicurl)}}">Download QR Code</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <hr class="horizontal dark my-2">

                            {{-- <div class="row mt-2" id="fb_live_url_row">
                                <div class="col-12 col-lg-12 col-md-12">
                                    <label class="form-label text-bold">Input Facebook Live URL<code> <b>*</b></code></label>
                                    <div class="input-group input-group-outline">
                                        <input type="text" class="form-control" id="fb_url" name="fb_url" value="{{ $eventTopic->fb_live_url }}" style="height: 44px !important">
                                        <button class="btn bg-gradient-success btn-lg" type="button" id="fb_url_button">SAVE URL</button>
                                    </div>
                                </div>
                            </div>  --}}

                            <div class="row mt-5">
                                <div class="col-md-12 mx-auto text-center">
                                    <h4>List of Questions</h4>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-12" style="text-align: right !important">
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalAddQuestion">Add new question</button>
                                </div>
                            </div>

                            <div class="row mb-5" id="refreshDiv">
                                <div class="col-md-12 mx-auto">
                                    <div class="accordion" id="accordionRental">
                                        @foreach ($questions as $questions2)
                                            <div class="accordion-item my-2">
                                                <h6 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button border-bottom font-weight-bold" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapse-{{ $questions2->id }}" aria-expanded="true"
                                                        aria-controls="collapseOne">
                                                        {{ $loop->iteration }}. {{ $questions2->question }}
                                                        <i
                                                            class="collapse-close material-icons text-sm font-weight-bold pt-1 position-absolute end-0 me-3">add</i>
                                                        <i
                                                            class="collapse-open material-icons text-sm font-weight-bold pt-1 position-absolute end-0 me-3">remove</i>
                                                    </button>
                                                </h6>
                                                <div id="collapse-{{ $questions2->id }}" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                                    data-bs-parent="#accordionRental">
                                                    <div class="accordion-body text-sm opacity-8">
                                                      <div class="row">
                                                        @foreach ($choices as $choices2)
                                                            @if ($choices2->topic_question_id == $questions2->id)
                                                            <div class="col-12 col-md-6 col-lg-6">
                                                                @if ($questions2->answer == $choices2->letter)
                                                                    <label class="text-danger text-bold">
                                                                        <b>{{ $choices2->letter }}. </b> {{ ucfirst($choices2->choices_description) }}
                                                                    </label>
                                                                @else
                                                                    <label>
                                                                        <b>{{ $choices2->letter }}. </b> {{ ucfirst($choices2->choices_description) }}
                                                                    </label>
                                                                @endif

                                                            </div>

                                                            @endif
                                                        @endforeach

                                                      </div>
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

                <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
            </div>
    </main>
    <x-plugins></x-plugins>
    <link href="{{ asset('assets') }}/css/topic-question.css" rel="stylesheet" />
    @push('js')
    <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets') }}/js/topic-question.js"></script>
    <script src="{{ asset('assets') }}/js/select2.min.js"></script>
    <link href="{{ asset('assets') }}/css/select2.min.css" rel="stylesheet" />
    <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/choices.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>
    <!-- Kanban scripts -->

    @endpush
</x-page-template>
