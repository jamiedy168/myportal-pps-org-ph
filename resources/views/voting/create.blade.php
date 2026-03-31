
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="voting" activeItem="create" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="Create"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->
      
      <div class="container-fluid py-4">
       
        <div class="row mt-2">
            <div class="col-lg-12 col-12">
                @if (Session::has('status'))
                <div class="alert alert-success alert-dismissible text-white mx-4" role="alert">
                    <span class="text-sm">{{ Session::get('status') }}</span>
                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-lg-12 col-12">
                <div class="card">
                    <div class="card-header p-3 pb-2 bg-danger">
                        <h5 class="font-weight-bolder mb-0 text-white">New Election</h5>
                        <p class="mb-0 text-sm text-white">Please fill-up election information below</p>
                      </div>
                    <div class="card-body pt-4 p-3">
                        <form method="POST" role="form" enctype="multipart/form-data"  id="voting-form">
                            @csrf
                            {{-- Start of hidden input --}}
                                <input type="hidden" id="token" value="{{ csrf_token() }}">
                                <input type="hidden" value="{{ url('voting-create-save')}}" id="urlVotingSave">
                            {{-- End of hidden input --}}
                            <div class="row">
                                <div class="row mt-0">
                                    <div class="col-12 col-md-12 col-xl-12 position-relative">
                                        <div class="card card-plain h-100">
                                            <div class="card-header pb-0 p-3">
                                                <h6 class="mb-0 text-danger">Election Details</h6>
                                            </div>
                                            <div class="card-body p-3">
                                                
                                                <div class="row mt-1">
                                                    <div class="col-12">
                                                        <label class="form-label text-bold">Title<code> <b>*</b></code></label>
                                                        <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                                            <input type="text" class="form-control" placeholder="Enter Title" name="title" id="voting_title">
                                                        </div>
                                                        <p class="text-danger inputerrortitle mt-0" style="display: none">The title field is required. </p>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-lg-6 col-6">
                                                        <label class="form-label text-bold">Date From<code> <b>*</b></code></label>
                                                        <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                            <input type="date" class="form-control" id="voting_date_from">
                                                        </div>
                                                        <p class="text-danger inputerror mt-0" style="display: none">The date from field is required. </p>
                                                    </div>

                                                    <div class="col-lg-6 col-6">
                                                        <label class="form-label text-bold">Date To<code> <b>*</b></code></label>
                                                        <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                            <input type="date" class="form-control" id="voting_date_to">
                                                        </div>
                                                        <p class="text-danger inputerror mt-0" style="display: none">The date to field is required. </p>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-6">
                                                        <label class="form-label text-bold">Start Time<code> <b>*</b></code></label>
                                                        <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                            <input type="time" class="form-control" id="voting_time_from">
                                                        </div>
                                                        <p class="text-danger inputerror mt-0" style="display: none">The start time field is required. </p>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label text-bold">End Time<code> <b>*</b></code></label>
                                                        <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                            <input type="time" class="form-control" id="voting_time_to">
                                                        </div>
                                                        <p class="text-danger inputerror mt-0" style="display: none">The end time field is required. </p>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-12">
                                                        <label class="form-label text-bold">Description</label>
                                                        <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                            <textarea name="description" id="voting_description" class="form-control" rows="5"></textarea>
                                                        </div>
                                                        <p class="text-danger inputerror mt-0" style="display: none">The description field is required. </p>
                                                    </div>
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col-lg-4 col-md-4 col-12">
                                                        
                                                        <input style="display:none;" class="voting-picture" id="file-input-profile" name="picture" type="file" accept="image/*" onchange="document.getElementById('profile_picture').src = window.URL.createObjectURL(this.files[0])" />
                                                        <img src="{{ asset('assets') }}/img/placeholder.jpg" id="profile_picture" class="img-fluid shadow border-radius-xl" style="max-width: 100% !important; width: 200px !important; height: auto !important; "  alt="team-2" >
                                                        
                                                      <br>
                                                      <br>
                                                      <label for="file-input-profile" class="btn btn-danger">
                                                        UPLOAD ELECTION PHOTO
                                                      </label>
                                                      
                                                    </div>
                                                </div>
                                                <br>
                                                <hr class="dark horizontal">

                                                <div class="row mt-4">
                                                    <div class="col-12">
                                                        <h6 class="mb-0 text-danger">Candidate Details</h6>
                                                    </div>
                                                </div>


                                                <div class="row mt-3">
                                                    <div class="col-12 col-md-6">
                                                        <div class="card h-100">
                                                            <div class="card-header p-3 pb-2 bg-danger">
                                                                <h5 class="font-weight-bolder mb-0 text-white">BOARD OF TRUSTEES</h5>
                                                            
                                                            </div>
                                                            <div class="card-body">

                                                                 {{-- Start of hidden input --}}
                                                                    <input type="hidden" value="{{ url('voting-add-bot-candidate')}}" id="urlCandidateAddBot">
                                                                    <input type="hidden" value="{{ url('voting-remove-candidate-bot')}}" id="urlCandidateRemoveBot">
                                                                 {{-- End of hidden input --}}
                                                                <div class="row">
                                                                    <div class="col-lg-12 col-12">
                                                                        <label class="form-label text-bold">Maximum vote allowed for this position<code> <b>*</b></code></label>
                                                                        <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                                            <input type="number" class="form-control" required id="bot_max_vote" style="text-align: center !important" placeholder="Input number here..">
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12 col-md-7 mb-0">
                                                                        <label class="form-label text-bold">Choose Candidates<code> <b>*</b></code></label>
                                                                        <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                                        <select name="candidate_pps_no" id="bot_candidate_pps_no" class="candidate_pps_no ">
                                                                            <option value="">-- Select --</option>
                                                                            @foreach ($member as $member2)
                                                                                    <option value="{{ $member2->pps_no }}">{{ $member2->first_name }} {{ $member2->middle_name }} {{ $member2->last_name }} {{ $member2->suffix }} | {{ $member2->prc_number }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-md-5 mt-4">
                                                                        <button class="btn btn-success btn-lg bot_add_candidate" style="margin-top: 2px !important" type="button" 
                                                                    
                                                                        >
                                                                        Add to list</button>
                                                                        </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12 col-md-12">
                                                                        <div class="table-responsive p-0" id="refreshDivBot">
                                                                            <input type="hidden" value="{{ $countCandidateBot }}" id="count_bot_candidate">
                                                                            <table class="table align-items-center mb-0">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th
                                                                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            Candidate</th>
                                                                                       
                                                                                        <th
                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            Action</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    @if ($countCandidateBot < 1)
                                                                                        <tr style="text-align: center !important">
                                                                                            <td colspan="2">
                                                                                                <label class="text-bold" for="">--EMPTY CANDIDATE--</label>
                                                                                            </td>
                                                                                        </tr>
                                                                                    @else
                                                                                        @foreach ($candidateBot as $candidateBot2)
                                                                                            <tr>
                                                                                                <td>
                                                                                                    <div class="d-flex px-3 py-1">
                                                                                                        <div>
                                                                                                            <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $candidateBot2->picture, now()->addMinutes(30))}}"
                                                                                                                class="avatar me-3" alt="image">
                                                                                                        </div>
                                                                                                        <div class="d-flex flex-column justify-content-center">
                                                                                                            <h6 class="mb-0 text-sm">{{ $candidateBot2->first_name }} {{ $candidateBot2->middle_name }} {{ $candidateBot2->last_name }} {{ $candidateBot2->suffix }}</h6>
                                                                                                            <p class="text-sm font-weight-normal text-secondary mb-0"> PRC NO.: {{ $candidateBot2->prc_number }} | {{ $candidateBot2->chapter_name }}</p>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </td>
                                                                                        
                                                                                            
                                                                                                <td class="align-middle text-center">
                                                                                                    
                                                                                                    <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                                                                                        <i id="{{ $candidateBot2->pps_no }}" class="material-icons text-xl ms-1 text-danger remove_candidateBot" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove from list" data-container="body" data-animation="true">close</i>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                        @endforeach
                                                                                    @endif
                                                                 
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="card h-100">
                                                            <div class="card-header p-3 pb-2 bg-danger">
                                                                <h5 class="font-weight-bolder mb-0 text-white">CHAPTER REPRESENTATIVE</h5>
                                                            
                                                            </div>
                                                            <div class="card-body">

                                                                 {{-- Start of hidden input --}}
                                                                    <input type="hidden" value="{{ url('voting-add-chap-rep-candidate')}}" id="urlCandidateAddChapRep">
                                                                    <input type="hidden" value="{{ url('voting-remove-candidate-chap-rep')}}" id="urlCandidateRemoveChapRep">
                                                                 {{-- End of hidden input --}}
                                                                <div class="row">
                                                                    <div class="col-lg-12 col-12">
                                                                        <label class="form-label text-bold">Maximum vote allowed for this position<code> <b>*</b></code></label>
                                                                        <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                                            <input type="number" class="form-control" required id="chap_rep_max_vote" style="text-align: center !important" placeholder="Input number here..">
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12 col-md-7 mb-0">
                                                                        <label class="form-label text-bold">Choose Candidates<code> <b>*</b></code></label>
                                                                        <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                                        <select name="candidate_pps_no" id="chap_rep_candidate_pps_no" class="candidate_pps_no ">
                                                                            <option value="">-- Select --</option>
                                                                            @foreach ($member as $member2)
                                                                                    <option value="{{ $member2->pps_no }}">{{ $member2->first_name }} {{ $member2->middle_name }} {{ $member2->last_name }} {{ $member2->suffix }} | {{ $member2->prc_number }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-md-5 mt-4">
                                                                        <button class="btn btn-success btn-lg chap_rep_add_candidate" style="margin-top: 2px !important" type="button" 
                                                                    
                                                                        >
                                                                        Add to list</button>
                                                                        </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12 col-md-12">
                                                                        <div class="table-responsive p-0" id="refreshDivChapRep">
                                                                            <input type="hidden" value="{{ $countCandidateChapRep }}" id="count_chap_rep_candidate">
                                                                            <table class="table align-items-center mb-0">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th
                                                                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            Candidate</th>
                                                                                       
                                                                                        <th
                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            Action</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    @if ($countCandidateChapRep < 1)
                                                                                        <tr style="text-align: center !important">
                                                                                            <td colspan="2">
                                                                                                <label class="text-bold" for="">--EMPTY CANDIDATE--</label>
                                                                                            </td>
                                                                                        </tr>
                                                                                    @else
                                                                                        @foreach ($candidateChapRep as $candidateChapRep2)
                                                                                            <tr>
                                                                                                <td>
                                                                                                    <div class="d-flex px-3 py-1">
                                                                                                        <div>
                                                                                                            <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $candidateChapRep2->picture, now()->addMinutes(30))}}"
                                                                                                                class="avatar me-3" alt="image">
                                                                                                        </div>
                                                                                                        <div class="d-flex flex-column justify-content-center">
                                                                                                            <h6 class="mb-0 text-sm">{{ $candidateChapRep2->first_name }} {{ $candidateChapRep2->middle_name }} {{ $candidateChapRep2->last_name }} {{ $candidateChapRep2->suffix }}</h6>
                                                                                                            <p class="text-sm font-weight-normal text-secondary mb-0"> PRC NO.: {{ $candidateChapRep2->prc_number }} | {{ $candidateChapRep2->chapter_name }}</p>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </td>
                                                                                        
                                                                                            
                                                                                                <td class="align-middle text-end">
                                                                                                    <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                                                                                        <i id="{{ $candidateChapRep2->pps_no }}" class="material-icons text-xl ms-1 text-danger remove_candidate_chap_rep" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove from list" data-container="body" data-animation="true">close</i>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                        @endforeach
                                                                                    @endif
                                                                                   
                                            
                                                                                    
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                  
                                                    
                                                </div>
                                               



                                                


                                              

                                                <br>
                                                <br>
                                                <br>
                                                
                                                <hr>
                                                <div class="row mt-3">
                                                    <div class="col-12">
                                                        <button class="btn btn-danger" type="submit">Save</button>
                                                        <button class="btn btn-warning" type="button">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>

                     



                
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
  <script src="{{ asset('assets') }}/js/voting.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/datatables.js"></script>
  <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>

  <script src="{{ asset('assets') }}/js/select2-new.min.js"></script>
  <link href="{{ asset('assets') }}/css/select2-new.min.css" rel="stylesheet" />

  
    @endpush
  </x-page-template>
  