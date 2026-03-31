<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="voting" activeItem="listing" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-auth.navbars.navs.auth pageTitle="Election Details"></x-auth.navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">

             {{-- Start of modal update election --}}
             <div class="modal fade" id="modalUpdateElection"  role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered " role="document">
                    <div class="modal-content">
                        <form method="POST" role="form text-left" enctype="multipart/form-data" id="update-election-form">
                            @csrf
                            <div class="modal-body p-0">
                                <div class="card card-plain" id="cartListModal">
                                    <div class="card-header pb-0 text-left">
                                        <div class="row">
                                            <div class="col-11">
                                                <h5 class="text-gradient text-danger">Update Election Details</h5>
                                            </div>
                                            <div class="col-1">
                                                <button style="text-align: right !important" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span class="text-primary" aria-hidden="true">&times;</span>
                                                </button>   
                                            </div>
                                        </div>
                  
                                    </div>
                                    <div class="card-body p-3 pt-0">

                                        <input type="hidden" id="token" name="token2" value="{{ csrf_token() }}">
                                        <input type="hidden" value="{{ url('voting-update') }}" id="urlVotingUpdate">
                                        <input type="hidden" value="{{ $voting->id }}" id="voting_id">


                                        <div class="row mt-2">
                                            <div class="col-12 col-lg-12 col-md-12">
                                                <label class="form-label text-bold">Title<code> <b>*</b></code></label>
                                                <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                    <input type="text" class="form-control" value="{{ $voting->title }}" id="title" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-6 col-lg-6 col-md-6">
                                                <label class="form-label text-bold">Date From<code> <b>*</b></code></label>
                                                <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                    <input type="date" class="form-control" value="{{Carbon\Carbon::parse($voting->date_from)->format('Y-m-d')}}" id="date_from" required>
                                                </div>
                                            </div>
                                            <div class="col-6 col-lg-6 col-md-6">
                                                <label class="form-label text-bold">Date To<code> <b>*</b></code></label>
                                                <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                    <input type="date" class="form-control" value="{{Carbon\Carbon::parse($voting->date_to)->format('Y-m-d')}}" id="date_to" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-6 col-lg-6 col-md-6">
                                                <label class="form-label text-bold">Start Time<code> <b>*</b></code></label>
                                                <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                    <input type="time" class="form-control" value="{{Carbon\Carbon::parse($voting->time_from)->format('H:i:s')}}" id="time_from" required>
                                                </div>
                                            </div>
                                            <div class="col-6 col-lg-6 col-md-6">
                                                <label class="form-label text-bold">End Time<code> <b>*</b></code></label>
                                                <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                    <input type="time" class="form-control" value="{{Carbon\Carbon::parse($voting->time_to)->format('H:i:s')}}" id="time_to" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-12 col-lg-12 col-md-12">
                                                <label class="form-label text-bold">Description</label>
                                                <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                   <textarea name="" id="description" rows="4" class="form-control">{{ $voting->description }}</textarea>
                                                </div>
                                            </div>
                                        </div>

      

                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <h5 class="text-header text-danger">Election Image</h5>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-lg-6 col-md-6 col-6 text-center">
                          
                                                <img src="{{Storage::disk('s3')->temporaryUrl('others/' . $voting->picture, now()->addMinutes(30))}}" class="img-fluid shadow border-radius-xl" style="max-width: 100% !important; width: 200px !important; height: auto !important; "  alt="team-2" >
                                                
                            
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-6 text-center">
                                            
                                                <input style="display:none;" class="voting-picture" id="file-input-profile" name="picture" type="file" accept="image/*" onchange="document.getElementById('profile_picture').src = window.URL.createObjectURL(this.files[0])" />
                                                <img src="{{ asset('assets') }}/img/placeholder.jpg" id="profile_picture" class="img-fluid shadow border-radius-xl" style="max-width: 100% !important; width: 200px !important; height: auto !important; "  alt="team-2" >
                                                
                                              <br>
                                              <br>
                                              <label for="file-input-profile" class="btn btn-danger">
                                                UPDATE ELECTION PHOTO
                                              </label>
                                              
                                            </div>
                                        </div>
                                   

                                        <hr>
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <button class="btn btn-danger" type="submit">Update</button>
                                                <button class="btn btn-warning" type="button" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                            </div>
                                        </div>
                                  
                                   
                                    </div>
                                
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- End of modal update election --}}

            {{-- Start of modal update status --}}
            <div class="modal fade" id="modalUpdateElectionStatus"  role="dialog" aria-labelledby="modal-form" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered " role="document">
                <div class="modal-content">
                    <form method="POST" role="form text-left" enctype="multipart/form-data" id="update-election-status-form">
                        @csrf
                        <div class="modal-body p-0">
                            <div class="card card-plain" id="cartListModal">
                                <div class="card-header pb-0 text-left">
                                    <div class="row">
                                        <div class="col-11">
                                            <h5 class="text-gradient text-danger">Update Election Status</h5>
                                        </div>
                                        <div class="col-1">
                                            <button style="text-align: right !important" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                <span class="text-primary" aria-hidden="true">&times;</span>
                                            </button>   
                                        </div>
                                    </div>
                
                                </div>
                                <div class="card-body p-3 pt-0">

                                    <input type="hidden" value="{{ url('voting-update-status') }}" id="urlVotingUpdateStatus">

                                    <div class="row mt-1">
                                        <div class="col-12 col-lg-12 col-md-12">
                                            <label class="form-label text-bold">Status</label>
                                            <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                <select name="status2" id="status2" required class="status2">
                                                    <option value="">--SELECT--</option>
                                                    <option value="UPCOMING" {{ $voting->status == 'UPCOMING' ? 'selected' : '' }}>UPCOMING</option>
                                                    <option value="ONGOING" {{ $voting->status == 'ONGOING' ? 'selected' : '' }}>ONGOING</option>
                                                    <option value="COMPLETED" {{ $voting->status == 'COMPLETED' ? 'selected' : '' }}>COMPLETED</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                        

                                    <hr>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <button class="btn btn-danger" type="submit">Update</button>
                                            <button class="btn btn-warning" type="button" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                        </div>
                                    </div>
                                
                                
                                </div>
                            
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            </div>
            {{-- End of modal update status --}}

            {{-- Start of modal add bot --}}
            <div class="modal fade" id="modalAddBOT" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered " role="document">
                    <div class="modal-content">
                       
                            <div class="modal-body p-0">
                                <div class="card card-plain">
                                    <div class="card-header pb-0 text-left">
                                        <div class="row">
                                            <div class="col-11">
                                                <h5 class="text-gradient text-danger">ADD NEW BOARD OF TRUSTEES CANDIDATE</h5>
                                            </div>
                                            <div class="col-1">
                                                <button style="text-align: right !important" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span class="text-primary" aria-hidden="true">&times;</span>
                                                </button>   
                                            </div>
                                        </div>
                  
                                    </div>
                                    <div class="card-body p-3 pt-0">

                                        <input type="hidden" value="{{ url('voting-add-bot-candidate-update') }}" id="urlCandidateAddBot">
        
                                        <div class="row mt-1">
                                            <div class="col-12 col-md-12 mb-0">
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
                                        </div>
                                


                                        <hr>
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <button class="btn btn-danger" id="add_bot_btn" type="button">Add</button>
                                                <button class="btn btn-warning" type="button" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                            </div>
                                        </div>
                                  
                                   
                                    </div>
                                
                                </div>
                            </div>
                       
                    </div>
                </div>
            </div>
            {{-- End of modal add bot --}}


            {{-- Start of modal add chapter representative --}}
            <div class="modal fade" id="modalAddChapRep" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered " role="document">
                    <div class="modal-content">
                        
                            <div class="modal-body p-0">
                                <div class="card card-plain">
                                    <div class="card-header pb-0 text-left">
                                        <div class="row">
                                            <div class="col-11">
                                                <h5 class="text-gradient text-danger">ADD NEW BOARD OF TRUSTEES CANDIDATE</h5>
                                            </div>
                                            <div class="col-1">
                                                <button style="text-align: right !important" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span class="text-primary" aria-hidden="true">&times;</span>
                                                </button>   
                                            </div>
                                        </div>
                    
                                    </div>
                                    <div class="card-body p-3 pt-0">

                                        <input type="hidden" value="{{ url('voting-add-chap-rep-candidate-update') }}" id="urlCandidateAddChapRep">
        
                                        <div class="row mt-1">
                                            <div class="col-12 col-md-12 mb-0">
                                                <label class="form-label text-bold">Choose Candidates<code> <b>*</b></code></label>
                                                <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                <select name="candidate_pps_no" id="chaprep_candidate_pps_no" class="candidate_pps_no ">
                                                    <option value="">-- Select --</option>
                                                    @foreach ($member as $member2)
                                                            <option value="{{ $member2->pps_no }}">{{ $member2->first_name }} {{ $member2->middle_name }} {{ $member2->last_name }} {{ $member2->suffix }} | {{ $member2->prc_number }}</option>
                                                    @endforeach
                                                </select>
                                                </div>
                                            </div>
                                        </div>
                                


                                        <hr>
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <button class="btn btn-danger" id="add_chap_rep_btn" type="button">Add</button>
                                                <button class="btn btn-warning" type="button" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                            </div>
                                        </div>
                                    
                                    
                                    </div>
                                
                                </div>
                            </div>
                        
                    </div>
                </div>
            </div>
            {{-- End of modal add chapter representative --}}


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-4">Election Details</h5>
                            <div class="row">
                                <div class="col-xl-5 col-lg-6 text-center">
                                    <img class="w-100 border-radius-lg shadow-lg mx-auto"
                                        src="{{Storage::disk('s3')->temporaryUrl('others/' . $voting->picture, now()->addMinutes(30))}}" alt="chair">
                                    <div class="my-gallery d-flex mt-4 pt-2" itemscope>
                                        <figure itemprop="associatedMedia" itemscope
                                          >
                                            <a href="{{Storage::disk('s3')->temporaryUrl('others/' . $voting->picture, now()->addMinutes(30))}}"
                                                itemprop="contentUrl" data-size="500x600">
                                                <img class="w-100 min-height-100 max-height-100 border-radius-lg shadow"
                                                    src="{{Storage::disk('s3')->temporaryUrl('others/' . $voting->picture, now()->addMinutes(30))}}"
                                                    alt="Election Image" />
                                            </a>
                                        </figure>
                                    </div>
                                    
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
                                <div class="col-lg-4 mx-auto">
                                    <h3 class="mt-lg-0 mt-4">{{ $voting->title }}</h3>
                                    
                                    <h6 class="mb-0 mt-1">{{Carbon\Carbon::parse($voting->date_from)->format('M. d, Y')}}  - {{Carbon\Carbon::parse($voting->date_to)->format('M. d, Y')}}</h6>
                                    <h6 class="mb-0 mt-0">{{Carbon\Carbon::parse($voting->time_from)->format('h:i a')}}  - {{Carbon\Carbon::parse($voting->time_to)->format('h:i a')}}</h6>
                                    @if ($voting->status == "UPCOMING")
                                        <span class="badge badge-warning">{{ $voting->status }}</span>
                                    @elseif ($voting->status == "ONGOING")
                                        <span class="badge badge-danger">{{ $voting->status }}</span>
                                    @else
                                        <span class="badge badge-success">{{ $voting->status }}</span>
                                    @endif
                                    
                                    <br>
                                    <label class="mt-4">Description:</label>
                                    <ul>
                                        <li>{{ $voting->description }}</li>
                                       
                                    </ul>
                                    {{-- <p class="mt-0 text-bold">STATUS: <b class="text-success">VOTED</b></p> --}}
                                  

                                   
                                    @if(auth()->user()->role_id == 1)
                                        <div class="row mt-6">
                                            <div class="col-lg-8 col-12">
                                                
                                                <a href="/voting-result/{{ Crypt::encrypt( $voting->id )}}" class="btn bg-gradient-success mb-0 mt-lg-auto w-100" type="button"
                                                    name="button">VIEW VOTING RESULT</a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                @if(auth()->user()->role_id == 1)
                                    <div class="col-lg-2 mt-2">
                                        <div class="dropdown">
                                            <a href="#" class="btn bg-gradient-warning dropdown-toggle " data-bs-toggle="dropdown" id="navbarDropdownMenuLink2">
                                                 Action
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
                                                @if ($voting->status == "UPCOMING")
                                                    <li>
                                                        <a class="dropdown-item"href="javascript:;" data-bs-toggle="modal" data-bs-target="#modalUpdateElection" >
                                                            Update Details
                                                        </a>
                                                    </li>
                                                @else
                                                    <li>
                                                        <a class="dropdown-item"href="javascript:;" onclick="restrictUpdate()" >
                                                            Update Details
                                                        </a>
                                                    </li>
                                                @endif
                                                <li>
                                                    <a class="dropdown-item"href="javascript:;" data-bs-toggle="modal" data-bs-target="#modalUpdateElectionStatus">
                                                        Update Status
                                                    </a>
                                                </li>
                                               
                                               
                                                
                                            </ul>
                                        </div>
                                        {{-- <div class="dropstart">
                                            <a href="javascript:;" class="text-secondary" id="dropdownMarketingCard"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="material-icons text-xl">more_vert</i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-lg-start px-2 py-3"
                                                aria-labelledby="dropdownMarketingCard">
                                                    @if ($voting->status == "UPCOMING")
                                                        <li>
                                                            <a class="dropdown-item border-radius-md"
                                                                href="javascript:;" data-bs-toggle="modal" data-bs-target="#modalUpdateElection" >Update Details
                                                            </a>
                                                        </li>
                                                    @else
                                                        <li>
                                                            <a class="dropdown-item border-radius-md"
                                                                href="javascript:;" onclick="restrictUpdate()">Update Details
                                                            </a>
                                                        </li>
                                                    @endif
                                                        <li>
                                                            <a class="dropdown-item border-radius-md"
                                                                href="javascript:;">Update Status
                                                            </a>
                                                        </li>
                                         
                        
                                            </ul>
                                        </div> --}}
                                     
                                    </div>
                                @endif
                                
                            </div>
                            <hr class="horizontal dark">




        
                          
                            @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 4)
                                {{-- START OF ADMIN VIEWING --}}
                                <div class="row mt-5">
                                    <div class="col-12">
                                        <h5 class="ms-3 text-danger">Candidates</h5>
                                        <div class="row mt-3">
                                            <div class="col-8 col-lg-8">
                                                <h5 class="ms-3">Board of Trustees</h5>
                                            </div>
                                            <div class="col-4 col-lg-4">
                                                @if ($voting->status == "UPCOMING")
                                                    <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#modalAddBOT" >ADD NEW BOARD OF TRUSTEES CANDIDATE</button>
                                                @else
                                                    <button class="btn btn-success" type="button" onclick="restrictUpdate()" >ADD NEW BOARD OF TRUSTEES CANDIDATE</button>
                                                @endif
                                                
                                            </div>
                                        </div>

                                         
                                        <hr>
                                        <div class="row">
                                            <div class="col-12 col-lg-12">
                                                <div class="table table-responsive" id="bottable">
                                                    <table class="table align-items-center mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th> </th>
                                                               
                                                                <th
                                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                    Candidates</th>
            
                                                                <th
                                                                    class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7">
                                                                    PRC Number</th>

                                                                <th
                                                                    class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7">
                                                                    Chapter</th>
                                                                  
                                                                
                                                            
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($candidateBOT as $candidateBOT2)
                                                       
                                                                <tr>
                                                                    <td class="align-middle text-center">
                                                                        {{ $loop->iteration }}.
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex px-2 py-1">
                                                                            <div>
                                                                                <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $candidateBOT2->picture, now()->addMinutes(30))}}"
                                                                                    class="avatar avatar-md me-3" alt="table image">
                                                                            </div>
                                                                            <div class="d-flex flex-column justify-content-center">
                                                                                <h6 class="mb-0 text-sm">{{ $candidateBOT2->first_name }} {{ $candidateBOT2->middle_name }} {{ $candidateBOT2->last_name }} {{ $candidateBOT2->suffix }}
                                                                                </h6>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="align-middle text-center">
                                                                        {{ $candidateBOT2->prc_number }}
                                                                    </td>
                                                                                                                  
                                                                    <td class="text-center">
                                                                        {{ $candidateBOT2->chapter_name }}
                                                                    </td>
                                                                    
                                                                </tr>
                                                            @endforeach
                                                          
                                                           
                                                           
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                       
                                    </div>
                                </div>
    
    
                                <div class="row mt-5">
                                    <div class="col-12">
                                        <div class="row mt-3">
                                            <div class="col-8 col-lg-8">
                                                <h5 class="ms-3">Chapter Representative</h5>
                                            </div>
                                            <div class="col-4 col-lg-4">
                                                @if ($voting->status == "UPCOMING")
                                                    <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#modalAddChapRep" >ADD NEW CHAPTER REPRESENTATIVE CANDIDATE</button>
                                                @else
                                                    <button class="btn btn-success" type="button" onclick="restrictUpdate()">ADD NEW CHAPTER REPRESENTATIVE CANDIDATE</button>
                                                @endif
                                                
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-12 col-lg-12">
                                                <div class="table table-responsive" id="chapreptable">
                                                    <table class="table align-items-center mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th> </th>
                                                               
                                                                <th
                                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                    Candidates</th>
            
                                                                <th
                                                                    class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7">
                                                                    PRC Number</th>
                                                                  
                                                                
                                                                    <th
                                                                    class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7">
                                                                    Chapter</th>
                                                                  
                                                                
                                                             
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($candidateChapRep as $candidateChapRep2)
                                                       
                                                                <tr>
                                                                    <td class="align-middle text-center">
                                                                        {{ $loop->iteration }}.
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex px-2 py-1">
                                                                            <div>
                                                                                
                                                                                <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $candidateChapRep2->picture, now()->addMinutes(30))}}"
                                                                                    class="avatar avatar-md me-3" alt="table image">
                                                                            </div>
                                                                            <div class="d-flex flex-column justify-content-center">
                                                                                <h6 class="mb-0 text-sm">{{ $candidateChapRep2->first_name }} {{ $candidateChapRep2->middle_name }} {{ $candidateChapRep2->last_name }} {{ $candidateChapRep2->suffix }}
                                                                                </h6>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="align-middle text-center">
                                                                        {{ $candidateChapRep2->prc_number }}
                                                                    </td>
                                                                                                                  
                                                                    <td class="text-center">
                                                                        {{ $candidateChapRep2->chapter_name }}
                                                                    </td>
                                                                    
                                                                </tr>
                                                            @endforeach
                                                          
                                                           
                                                           
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                       
                                    </div>
                                </div>
                                {{-- END OF ADMIN VIEWING --}}

                           
                                @else
                                
                                {{-- START OF MEMBER VIEWING --}}
                                   <div class="row mt-5">
                                    <div class="col-12">
                                        <h5 class="ms-3 text-danger">Candidates</h5>
                                        <div class="row mt-3">
                                            <div class="col-12 col-lg-12">
                                                <h5 class="ms-3">Board of Trustees</h5>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-12 col-lg-12">
                                                <div class="table table-responsive">
                                                    <table class="table align-items-center mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th> </th>
                                                            
                                                                <th
                                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                    Candidates</th>
                                
                                                                <th
                                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                    VOTED</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($candidateVotedBOT as $candidateVotedBOT2)
                                                    
                                                                <tr>
                                                                    <td class="align-middle text-center">
                                                                        {{ $loop->iteration }}.
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex px-2 py-1">
                                                                            <div>
                                                                                @if ($candidateVotedBOT2 == null)
                                                                                    <img src="{{ asset('assets') }}/img/pps-logo.png"
                                                                                    class="avatar avatar-md me-3" alt="table image">
                                                                                @else
                                                                                    <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $candidateVotedBOT2->picture, now()->addMinutes(30))}}"
                                                                                    class="avatar avatar-md me-3" alt="table image">
                                                                                @endif
                                                                                
                                                                                
                                                                            </div>
                                                                            <div class="d-flex flex-column justify-content-center">
                                                                                <h6 class="mb-0 text-sm">{{ $candidateVotedBOT2->first_name }} {{ $candidateVotedBOT2->middle_name }} {{ $candidateVotedBOT2->last_name }} {{ $candidateVotedBOT2->suffix }}
                                                                                </h6>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                
                                                            
                                                                                                                
                                                                    <td class="align-middle text-center">
                                                                            @if ($candidateVotedBOT2->voted == 1)
                                                                                <i class="material-icons text-xxl text-boldest ms-1 text-success remove_candidate2" data-container="body" data-animation="true">done</i>
                                                                            @else
                                                                                <i class="material-icons text-xl ms-1 text-boldest text-danger remove_candidate2" data-container="body" data-animation="true">close</i>
                                                                            @endif
                                                                    </td>
                                                                    
                                                                </tr>
                                                            @endforeach
                                                        
                                                        
                                                        
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-12 col-lg-12">
                                                <h5 class="ms-3">Chapter Representative</h5>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-12 col-lg-12">
                                                <div class="table table-responsive">
                                                    <table class="table align-items-center mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th> </th>
                                                            
                                                                <th
                                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                    Candidates</th>
                                
                                                                <th
                                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                    VOTED</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($candidateVotedChapRep as $candidateVotedChapRep2)
                                                    
                                                                <tr>
                                                                    <td class="align-middle text-center">
                                                                        {{ $loop->iteration }}.
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex px-2 py-1">
                                                                            <div>
                                                                                @if ($candidateVotedChapRep2 == null)
                                                                                    <img src="{{ asset('assets') }}/img/pps-logo.png"
                                                                                    class="avatar avatar-md me-3" alt="table image">
                                                                                @else
                                                                                    <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $candidateVotedChapRep2->picture, now()->addMinutes(30))}}"
                                                                                    class="avatar avatar-md me-3" alt="table image">
                                                                                @endif
                                                                                
                                                                            </div>
                                                                            <div class="d-flex flex-column justify-content-center">
                                                                                <h6 class="mb-0 text-sm">{{ $candidateVotedChapRep2->first_name }} {{ $candidateVotedChapRep2->middle_name }} {{ $candidateVotedChapRep2->last_name }} {{ $candidateVotedChapRep2->suffix }}
                                                                                </h6>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                
                                                            
                                                                                                                
                                                                    <td class="align-middle text-center">
                                                                
                                                                            @if ($candidateVotedChapRep2->voted == 1)
                                                                                <i class="material-icons text-xxl text-boldest ms-1 text-success remove_candidate2" data-container="body" data-animation="true">done</i>
                                                                            @else
                                                                                <i class="material-icons text-xl ms-1 text-boldest text-danger remove_candidate2" data-container="body" data-animation="true">close</i>
                                                                            @endif
                                                                        
                                                                        
                                                                    </td>
                                                                    
                                                                </tr>
                                                            @endforeach
                                                        
                                                        
                                                        
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    
                                    </div>
                                </div>
                                {{-- END OF MEMBER VIEWING --}}

                            @endif
                            
                        </div>
                    </div>
                </div>
            </div>
            <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
        </div>
    </main>
    <x-plugins></x-plugins>
    <link href="{{ asset('assets') }}/css/voting.css" rel="stylesheet" />
    @push('js')
    <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/choices.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/photoswipe.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/photoswipe-ui-default.min.js"></script>
    <script src="{{ asset('assets') }}/js/vote-details.js"></script>
    <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>

    <script src="{{ asset('assets') }}/js/select2-new.min.js"></script>
    <link href="{{ asset('assets') }}/css/select2-new.min.css" rel="stylesheet" />
    <script>




        if (document.getElementById('choices-quantity')) {
            var element = document.getElementById('choices-quantity');
            const example = new Choices(element, {
                searchEnabled: false,
                itemSelectText: ''
            });
        };

        if (document.getElementById('choices-material')) {
            var element = document.getElementById('choices-material');
            const example = new Choices(element, {
                searchEnabled: false,
                itemSelectText: ''
            });
        };

        if (document.getElementById('choices-colors')) {
            var element = document.getElementById('choices-colors');
            const example = new Choices(element, {
                searchEnabled: false,
                itemSelectText: ''
            });
        };

        // Gallery Carousel
        if (document.getElementById('products-carousel')) {
            var myCarousel = document.querySelector('#products-carousel')
            var carousel = new bootstrap.Carousel(myCarousel)
        }


        // Products gallery

        var initPhotoSwipeFromDOM = function (gallerySelector) {

            // parse slide data (url, title, size ...) from DOM elements
            // (children of gallerySelector)
            var parseThumbnailElements = function (el) {
                var thumbElements = el.childNodes,
                    numNodes = thumbElements.length,
                    items = [],
                    figureEl,
                    linkEl,
                    size,
                    item;

                for (var i = 0; i < numNodes; i++) {

                    figureEl = thumbElements[i]; // <figure> element
                    // include only element nodes
                    if (figureEl.nodeType !== 1) {
                        continue;
                    }

                    linkEl = figureEl.children[0]; // <a> element

                    size = linkEl.getAttribute('data-size').split('x');

                    // create slide object
                    item = {
                        src: linkEl.getAttribute('href'),
                        w: parseInt(size[0], 10),
                        h: parseInt(size[1], 10)
                    };

                    if (figureEl.children.length > 1) {
                        // <figcaption> content
                        item.title = figureEl.children[1].innerHTML;
                    }

                    if (linkEl.children.length > 0) {
                        // <img> thumbnail element, retrieving thumbnail url
                        item.msrc = linkEl.children[0].getAttribute('src');
                    }

                    item.el = figureEl; // save link to element for getThumbBoundsFn
                    items.push(item);
                }

                return items;
            };

            // find nearest parent element
            var closest = function closest(el, fn) {
                return el && (fn(el) ? el : closest(el.parentNode, fn));
            };

            // triggers when user clicks on thumbnail
            var onThumbnailsClick = function (e) {
                e = e || window.event;
                e.preventDefault ? e.preventDefault() : e.returnValue = false;

                var eTarget = e.target || e.srcElement;

                // find root element of slide
                var clickedListItem = closest(eTarget, function (el) {
                    return (el.tagName && el.tagName.toUpperCase() === 'FIGURE');
                });

                if (!clickedListItem) {
                    return;
                }

                // find index of clicked item by looping through all child nodes
                // alternatively, you may define index via data- attribute
                var clickedGallery = clickedListItem.parentNode,
                    childNodes = clickedListItem.parentNode.childNodes,
                    numChildNodes = childNodes.length,
                    nodeIndex = 0,
                    index;

                for (var i = 0; i < numChildNodes; i++) {
                    if (childNodes[i].nodeType !== 1) {
                        continue;
                    }

                    if (childNodes[i] === clickedListItem) {
                        index = nodeIndex;
                        break;
                    }
                    nodeIndex++;
                }



                if (index >= 0) {
                    // open PhotoSwipe if valid index found
                    openPhotoSwipe(index, clickedGallery);
                }
                return false;
            };

            // parse picture index and gallery index from URL (#&pid=1&gid=2)
            var photoswipeParseHash = function () {
                var hash = window.location.hash.substring(1),
                    params = {};

                if (hash.length < 5) {
                    return params;
                }

                var vars = hash.split('&');
                for (var i = 0; i < vars.length; i++) {
                    if (!vars[i]) {
                        continue;
                    }
                    var pair = vars[i].split('=');
                    if (pair.length < 2) {
                        continue;
                    }
                    params[pair[0]] = pair[1];
                }

                if (params.gid) {
                    params.gid = parseInt(params.gid, 10);
                }

                return params;
            };

            var openPhotoSwipe = function (index, galleryElement, disableAnimation, fromURL) {
                var pswpElement = document.querySelectorAll('.pswp')[0],
                    gallery,
                    options,
                    items;

                items = parseThumbnailElements(galleryElement);

                // define options (if needed)
                options = {

                    // define gallery index (for URL)
                    galleryUID: galleryElement.getAttribute('data-pswp-uid'),

                    getThumbBoundsFn: function (index) {
                        // See Options -> getThumbBoundsFn section of documentation for more info
                        var thumbnail = items[index].el.getElementsByTagName('img')[
                                0], // find thumbnail
                            pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                            rect = thumbnail.getBoundingClientRect();

                        return {
                            x: rect.left,
                            y: rect.top + pageYScroll,
                            w: rect.width
                        };
                    }

                };

                // PhotoSwipe opened from URL
                if (fromURL) {
                    if (options.galleryPIDs) {
                        // parse real index when custom PIDs are used
                        // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
                        for (var j = 0; j < items.length; j++) {
                            if (items[j].pid == index) {
                                options.index = j;
                                break;
                            }
                        }
                    } else {
                        // in URL indexes start from 1
                        options.index = parseInt(index, 10) - 1;
                    }
                } else {
                    options.index = parseInt(index, 10);
                }

                // exit if index not found
                if (isNaN(options.index)) {
                    return;
                }

                if (disableAnimation) {
                    options.showAnimationDuration = 0;
                }

                // Pass data to PhotoSwipe and initialize it
                gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
                gallery.init();
            };

            // loop through all gallery elements and bind events
            var galleryElements = document.querySelectorAll(gallerySelector);

            for (var i = 0, l = galleryElements.length; i < l; i++) {
                galleryElements[i].setAttribute('data-pswp-uid', i + 1);
                galleryElements[i].onclick = onThumbnailsClick;
            }

            // Parse URL and open gallery if it contains #&pid=3&gid=1
            var hashData = photoswipeParseHash();
            if (hashData.pid && hashData.gid) {
                openPhotoSwipe(hashData.pid, galleryElements[hashData.gid - 1], true, true);
            }
        };

        // execute above function
        initPhotoSwipeFromDOM('.my-gallery');

    </script>
    @endpush
</x-page-template>