<x-page-template bodyClass='g-sidenav-show bg-gray-200'>
    <x-auth.navbars.sidebar activePage='cpdpoints' activeItem='index' activeSubitem=''></x-auth.navbars.sidebar>
    <main class="main-content main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-auth.navbars.navs.auth pageTitle='CPD Points'></x-auth.navbars.navs.auth>
       
        <div class="container-fluid my-3 py-4">
            <div class="loading" id="loading3"> 
                <img src="{{ asset('assets') }}/img/pps-logo.png" style="height: 60px !important; width: 60px !important" alt="img-blur-shadow" class="icons">
              </div>
            <div class="row mt-0" style="margin-top: -15px !important">
                
                <div class="col-lg-8 col-12 mb-3">
                    <div class="card">
                        {{-- <div class="card-header p-3 pb-0 bg-gradient-danger">
                            <div class="row">
                                <div class="col-8">
                                    <h6 class="mb-2 text-white">CHOOSE MEMBER TO UPLOAD DOCUMENTS</h6>
                                </div>
                                <div class="col-4 text-end">
                                    <a href="#" class="btn btn-link btn-icon-only btn-rounded text-white icon-move-right my-auto" style="margin-top: -5px !important">
                                        <i class="fas fa-calendar" aria-hidden="true"></i>
                                            
                                    </a>
                                </div>
                            </div>
                        </div> --}}
                        <div class="card-body">
                            <div class="row mt-0">
                                <div class="col-12">
                                    
                                    <div class="row mt-4">
                                        <div class="col-lg-6"></div>
                                        <div class="col-lg-6 col-12">
                                            <div class="input-group input-group-outline">
                                                <label class="form-label">Search here..</label>
                                                <input type="text" class="form-control" id="searchbox-input" style="height: 46px !important">
                                                <button class="btn bg-gradient-danger btn-lg" id="searchBtn"><i class="fas fa-search"></i></button>
                                                </div>
                                        </div>
                                        
                                    </div>
                                    <div class="table table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Member
                                                       </th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Points
                                                    </th>   
                                                  

                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" style="text-align: center !important">
                                                        Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($member as $member2)
                                                
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                            <div>
                                                                @if ($member2->picture == null)
                                                                <img src="{{ asset('assets') }}/img/pps-logo.png"
                                                                    class="avatar avatar-md me-3" alt="image">
                                                                @else
                                                                <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $member2->picture, now()->addMinutes(230))}}"
                                                                class="avatar avatar-md me-3" alt="image">
                                                                @endif
                                                            </div>
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $member2->first_name }} {{ $member2->middle_name }} {{ $member2->last_name }} {{ $member2->suffix }}   
                                                                </h6>
                                                               
                                                                @if ($member2->prc_number == null)
                                                                    <p class="text-sm"><b class="text-danger">PRC No.: </b> N/A</p>
                                                                @else
                                                                <p class="text-sm"><b class="text-danger">PRC No.: </b>{{ $member2->prc_number }}</p>    
                                                                @endif
                                                                 
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td class="text-center">
                                                        @if ($member2->cpd_points == "")
                                                            0
                                                        @else
                                                            {{ $member2->cpd_points }}
                                                        @endif
                                                        
                                                    </td>
                                                    
                                                    <td style="text-align: center !important">
                                                        <a href="cpdpoints-view/{{ Crypt::encrypt( $member2->pps_no )}}" class="btn btn-icon btn-danger btn-outline-danger w-100 mt-3" style="height: 37px !important;" type="button">
                                                            <span class="btn-inner--icon"><i class="material-icons">visibility</i></span>
                                                            <span class="btn-inner--text">&nbsp;VIEW</span>
                                                        </a>
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
                </div>
                <div class="col-lg-4 col-12">
                    <div class="card">
                        <div class="card-header p-3 pb-0 bg-gradient-danger">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="mb-2 text-white">TOP CPD POINTS</h6>
                                </div>
                                
                                
                            </div>
                        </div>
                        <div class="card-body">
                            {{-- <div class="row">
                                <div class="col-12 col-lg-12">
                                    <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">TOP CPD POINTS</h6>
                                </div>
                            </div> --}}

                            <div class="row mt-2">
                                <div class="col-12 col-lg-12">
                                    <div class="nav-wrapper position-relative end-0">
                                        <ul class="nav nav-pills nav-fill p-1" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link mb-0 px-0 py-1 active " data-bs-toggle="tab" href="javascript:;"
                                                    role="tab" aria-selected="true">
                                                    <i class="material-icons text-lg position-relative">home</i>
                                                    <span class="ms-1">Monthly</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link mb-0 px-0 py-1 " data-bs-toggle="tab" href="javascript:;"
                                                    role="tab" aria-selected="false">
                                                    <i class="material-icons text-lg position-relative">email</i>
                                                    <span class="ms-1">Yearly</span>
                                                </a>
                                            </li>
                                          
                                        </ul>
                                    </div>
                                </div>
                            </div>


                            
                            <div class="row gx-4 mt-4">
                                @if (is_object($top_member))
                                <div class="col-auto">
                                   
                                    <div class="avatar avatar-xl position-relative">
                                        
                                        <img src="{{URL::asset('/img/profile/'.$top_member->picture)}}" alt="profile_image"
                                            class="w-100 rounded-circle shadow-sm">
                                    </div>
                                </div>
                                <div class="col-auto my-auto">
                                    <div class="h-100">
                                        <h5 class="mb-1">
                                           1. {{ $top_member->first_name }} {{ $top_member->middle_name }} {{ $top_member->last_name }} {{ $top_member->suffix }}
                                        </h5>
                                        <p class="mb-0 font-weight-normal text-sm" style="margin-left: 23px !important">
                                            <b>POINTS: </b> {{ $top_member->points }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="row mt-0">
                                <div class="col-12">
                                    
                                   
                                    <div class="table table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                       </th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" style="text-align: center !important">
                                                        </th>
                                                    <th
                                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($second_member as $second_member2)
                                                    <tr>
                                                        <td>
                                                            <div>
                                                                @if ($second_member2->picture == null)
                                                                <img src="{{ asset('assets') }}/img/pps-logo.png"
                                                                    class="avatar avatar-md me-3" alt="image">
                                                                @else
                                                                <img src="{{URL::asset('/img/profile/'.$second_member2->picture)}}"
                                                                class="avatar avatar-md me-3" alt="image">
                                                                @endif
                                                            </div>
                                                       
                                                        </td>
                                                        <td class="text-md text-bold">
                                                            2. {{ $second_member2->first_name }} {{ $second_member2->middle_name }} {{ $second_member2->last_name }} {{ $second_member2->suffix }}
                                                            @if ($second_member2->cpd_points == "")
                                                                <p style="margin-left: 20px !important">Points: 0</p>
                                                            @else
                                                                <p style="margin-left: 20px !important">Points: {{ $second_member2->cpd_points }}</p>
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
                </div>
            </div>


         
            <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
        </div>
    </main>
    
    <x-plugins></x-plugins>
    <link href="{{ asset('assets') }}/css/loader.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/event-attendance.css" rel="stylesheet" />
    @push('js')
    <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets') }}/js/select2.min.js"></script>
    <link href="{{ asset('assets') }}/css/select2.min.css" rel="stylesheet" />
    <script src="{{ asset('assets') }}/js/event-attendance.js"></script>
    <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/choices.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/photoswipe.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/photoswipe-ui-default.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>

    <!-- Kanban scripts -->

    {{-- <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script> --}}


  
    @endpush
</x-page-template>
