
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="voting" activeItem="listing" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="Create Election"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->
      
      <div class="container-fluid py-4">
       
    

        <div class="row mt-2">
            <div class="col-lg-12 col-12">
                <div class="card">
                    
                    <div class="card-body pt-4 p-3">
                        <div class="row gx-4">
                            <div class="col-auto">
                                <div class="avatar avatar-xl position-relative">
                                    <img src="{{ asset('assets') }}/img/pps-logo.png" alt="profile_image"
                                        class="w-100 border-radius-lg shadow-sm">
                                </div>
                            </div>
                            <div class="col-auto my-auto">
                                <div class="h-100">
                                    <h5 class="mb-1">
                                        {{ $voting->title }}
                                    </h5>
                                    <p class="mb-0 text-uppercase text-secondary text-xs text-bold opacity-7">
                                        {{Carbon\Carbon::parse($voting->date_from)->format('M. d, Y')}}  - {{Carbon\Carbon::parse($voting->date_to)->format('M. d, Y')}}
                                    </p>
                                    <p class="mb-0 text-uppercase text-secondary text-xs text-bold opacity-7">
                                        {{Carbon\Carbon::parse($voting->time_from)->format('h:i a')}}  - {{Carbon\Carbon::parse($voting->time_to)->format('h:i a')}}
                                    </p>

                                    
                                    <p class="mb-0 font-weight-normal text-sm">
                                        {{ $voting->description }}
                                    </p>
                                </div>
                            </div>
                            
                        </div>

                
                    </div>
                </div>
            </div>
           
        </div>

        <div class="row mt-2">
            <div class="col-lg-12 col-12">
                <div class="card">
                    
                    <div class="card-body pt-4 p-3">
                        <div class="row mt-0" style="margin-top: -10px !important">
                            <div class="col-md-12 col-12">
                                <div class="bg-success border-radius-lg p-2 my-4 text-white">
                                    <div class="row">
                                      <div class="col-12">
                                        <p class="text-sm font-weight-bold my-auto ps-sm-2">Instructions upon voting: </p>
                                      </div>
                                    </div>
          
                                    <div class="row">
                                      <div class="col-12 col-lg-12  ">
                                        <ul>
                                          <li><p class="text-xs font-weight-bold my-auto ps-sm-2">Only diplomate, fellow and emeritus fellow are allowed to vote.</p></li>
                                          <li><p class="text-xs font-weight-bold my-auto ps-sm-2">Voter must have no remaining unpaid annual dues before voting.</p></li>

                                          
                                        </ul>
                                      
                                      </div>
                                     
                                    </div>
                                    
                                </div>
                                
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="mb-5 ps-3">
                                            <h6 class="mb-1">Candidates</h6>
                                            <p class="text-sm">Please choose your selected candidates</p>
                                        </div>

                                    

                                        <div class="row">
                                            <div class="col-md-12">
                                                <h6 class="text-header" id="botcount">BOARD OF TRUSTEES ( {{ $countVotedBOT }}/{{ $voting->bot_max_vote }} )</h6>
                                            </div>
                                        </div>
                                        <hr>


                                        <div class="row mt-5">
                                             {{-- Start of hidden input --}}
                                                <input type="hidden" id="token" value="{{ csrf_token() }}">
                                                <input type="hidden" value="{{ url('voting-select-candidate')}}" id="urlVotingSelectCandidate">
                                                <input type="hidden" value="{{ url('voting-select-candidate-bot')}}" id="urlVotingSelectCandidateBot">
                                                <input type="hidden" value="{{ url('voting-select-candidate-chap-rep')}}" id="urlVotingSelectCandidateChapRep">
                                                <input type="hidden" value="{{ url('voting-remove-selected-candidate')}}" id="urlVotingRemoveSelectCandidate">
                                                <input type="hidden" value="{{ url('voting-finalize')}}" id="urlVotingFinalize">
                                                <input type="hidden" value="{{ $ids }}" id="voting_id">
                                            {{-- End of hidden input --}}

                                            @foreach ($botCandidate as $botCandidate2)
                                                <div class="col-lg-3 col-6 mb-5">
                                                    <div class="card h-100">
                                                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                                        <a class="d-block blur-shadow-image">
                                                            @if ($botCandidate2->picture == null)
                                                                <img src="{{ asset('assets') }}/img/pps-logo.png" alt="profile"
                                                                class="img-fluid shadow border-radius-lg">
                                                            @else
                                                                <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $botCandidate2->picture, now()->addMinutes(30))}}" alt="img-blur-shadow" class="img-fluid shadow border-radius-lg">
                                                            @endif
                                                        
                                                        </a>
                                                        
                                                    </div>
                                                    <div class="card-body text-center mb-0">
                                                        <p class="mb-0 text-sm">Candidate #{{ $loop->iteration }}</p>
                                                        <h5 class="font-weight-normal mt-1 text-danger">
                                                            {{ $botCandidate2->first_name }} {{ $botCandidate2->middle_name }} {{ $botCandidate2->last_name }} {{ $botCandidate2->suffix }}
                                                        </h5>
                                                        <p class="text-xs text-uppercase text-secondary" style="margin-bottom: -1px !important">- {{ $botCandidate2->chapter_name }}</p>
                                                        <p style="margin-top: 2px !important" class="text-xs text-uppercase text-secondary">- {{ $botCandidate2->member_type_name }}</p>
                                                    </div>
                                                    <hr class="dark horizontal mb-0" style="margin-top: -17px !important">
                                                    <div class="card-footer d-flex mt-0">
                                                        <button type="button" class="btn btn-danger btn-sm mb-0 w-100 select_candidate_bot" id="{{ $botCandidate2->pps_no }}">VOTE</button>
                                                    </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    
                                        <div class="row mt-5">
                                            <div class="col-md-12">
                                                <h6 class="text-header" id="chaprepcount">CHAPTER REPRESENTATIVE ( {{ $countVotedChapRep }}/{{ $voting->chaprep_max_vote }} )</h6>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row mt-5">

                                            @foreach ($chapRepCandidate as $chapRepCandidate2)
                                                <div class="col-lg-3 col-6 mb-5">
                                                    <div class="card h-100">
                                                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                                        <a class="d-block blur-shadow-image">
                                                            @if ($chapRepCandidate2->picture == null)
                                                                <img src="{{ asset('assets') }}/img/pps-logo.png" alt="profile"
                                                                class="img-fluid shadow border-radius-lg">
                                                            @else
                                                                <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $chapRepCandidate2->picture, now()->addMinutes(30))}}" alt="img-blur-shadow" class="img-fluid shadow border-radius-lg">
                                                            @endif
                                                        
                                                        </a>
                                                        
                                                    </div>
                                                    <div class="card-body text-center mb-0">
                                                        <p class="mb-0 text-sm">Candidate #{{ $loop->iteration }}</p>
                                                        <h5 class="font-weight-normal mt-1 text-danger">
                                                            {{ $chapRepCandidate2->first_name }} {{ $chapRepCandidate2->middle_name }} {{ $chapRepCandidate2->last_name }} {{ $chapRepCandidate2->suffix }}
                                                        </h5>
                                                        <p class="text-xs text-uppercase text-secondary" style="margin-bottom: -1px !important">- {{ $chapRepCandidate2->chapter_name }}</p>
                                                        <p style="margin-top: 2px !important" class="text-xs text-uppercase text-secondary">- {{ $chapRepCandidate2->member_type_name }}</p>
                                                    </div>
                                                    <hr class="dark horizontal mb-0" style="margin-top: -17px !important">
                                                    <div class="card-footer d-flex mt-0">
                                                        <button type="button" class="btn btn-danger btn-sm mb-0 w-100 select_candidate_chap_rep" id="{{ $chapRepCandidate2->pps_no }}">VOTE</button>
                                                    </div>
                                                    </div>
                                                </div>

                                        @endforeach
                                            
                                            {{-- @foreach ($chapRepCandidate as $chapRepCandidate2)
                                                <div class="col-xl-3 col-6 mb-xl-0 mb-4 h-100">
                                                    <div class="card card-blog card-plain">
                                                        <div class="card-header p-0 mt-n4 mx-3">
                                                            <a class="d-block shadow-xl border-radius-xl">
                                                                <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $chapRepCandidate2->picture, now()->addMinutes(30))}}"
                                                                    alt="img-blur-shadow" class="img-fluid shadow border-radius-xl">
                                                            </a>
                                                        </div>
                                                        <div class="card-body p-3">
                                                            <p class="mb-0 text-sm">Candidate #{{ $loop->iteration }}</p>
                                                            <a href="javascript:;">
                                                                <h5>
                                                                    {{ $chapRepCandidate2->first_name }} {{ $chapRepCandidate2->middle_name }} {{ $chapRepCandidate2->last_name }} {{ $chapRepCandidate2->suffix }}
                                                                </h5>
                                                            </a>
                                                    
                                                            <p class="text-xs text-uppercase text-secondary text-bold" style="margin-bottom: -1px !important">- {{ $chapRepCandidate2->chapter_name }}</p>
                                                            <p style="margin-top: 0px !important" class="mb-4 text-xs text-uppercase text-secondary text-bold">- {{ $chapRepCandidate2->member_type_name }}</p>
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <button type="button" class="btn btn-outline-danger btn-sm mb-0 w-100 select_candidate_chap_rep" id="{{ $chapRepCandidate2->pps_no }}">VOTE</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach --}}

                                            
                                        </div>



                                    </div>
                                </div>
                            </div>
                        </div>

       
                        
                
                    </div>
                </div>
            </div>
           
        </div>

        <div class="row mt-3">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="card">
                    <div class="card-header p-3 pb-0 bg-danger">
                        <h6 class="mb-0 text-white">Selected Candidate</h6>
                        <p class="text-sm mb-0 font-weight-normal text-white">Summary of your selected candidates</p>
                        <p></p>
                    </div>
                    <div class="card-body border-radius-lg p-3">
                        <div class="row" id="refreshDiv">
                            <div class="col-12">
                                <div class="table table-responsive">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Candidate</th>
                                                <th
                                                    class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Position</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Action</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($selectedCandidate as $selectedCandidate2)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                            <div>
                                                                @if ($selectedCandidate2 == null)
                                                                    <img src="{{ asset('assets') }}/img/pps-logo.png"
                                                                    class="avatar avatar-md me-3" alt="table image">
                                                                @else
                                                                    <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $selectedCandidate2->picture, now()->addMinutes(30))}}"
                                                                    class="avatar avatar-md me-3" alt="table image">
                                                                @endif
                                                                
                                                            </div>
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $selectedCandidate2->first_name }} {{ $selectedCandidate2->middle_name }} {{ $selectedCandidate2->last_name }} {{ $selectedCandidate2->suffix }}
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <h6 class="mb-0 text-sm">{{ $selectedCandidate2->position }}
                                                        </h6>
                                                    </td>
                                                    <td class="align-middle text-end">
                                                        <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                                            <i id="{{ $selectedCandidate2->candidate_pps_no }}" class="material-icons text-xl ms-1 text-danger remove_candidate2" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove from list" data-container="body" data-animation="true">close</i>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            
                                         
                                       
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-12 col-md-12">
                                <button class="btn btn-success" type="button" id="finalize_btn">
                                    FINALIZE VOTE
                                </button>
                                <button class="btn btn-link" type="button">
                                    CANCEL
                                </button>
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
    <link href="{{ asset('assets') }}/css/voting.css" rel="stylesheet" />
  @push('js')
  <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>

  
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/js/vote-elect.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/datatables.js"></script>
  <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>

  <script src="{{ asset('assets') }}/js/select2.min.js"></script>
  <link href="{{ asset('assets') }}/css/select2.min.css" rel="stylesheet" />



  
    @endpush
  </x-page-template>
  