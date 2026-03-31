<x-page-template bodyClass='g-sidenav-show bg-gray-200'>
    <x-auth.navbars.sidebar activePage='cpdpoints' activeItem='index' activeSubitem=''></x-auth.navbars.sidebar>
    <main class="main-content main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-auth.navbars.navs.auth pageTitle='CPD Points'></x-auth.navbars.navs.auth>
       
        <div class="container-fluid my-3 py-4">
           

            <div class="row" style="margin-top: -20px !important" id="refreshDiv">
                <div class="col-lg-8 col-12 h-100">
                    
                    
                    <div class="row">
               
                        <div class="col-lg-12 col-12 mb-3">
                            
                            <div class="card">
                                <div class="card-header pb-0 p-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="mb-0">Transactions</h6>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-end align-items-center">
                                            <i class="material-icons me-2 text-lg">date_range</i>
                                            <small>01 - 07 June 2021</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <ul class="list-group">
                                        <li class="list-group-item border-0 justify-content-between ps-0 pb-0 border-radius-lg">
                                            <div class="d-flex">
                                                <div class="d-flex align-items-center">
                                                    <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i class="material-icons text-lg">expand_less</i></button>
                                                    <div class="d-flex flex-column">
                                                        <h6 class="mb-1 text-dark text-sm">via PayPal</h6>
                                                        <span class="text-xs">07 June 2021, at 09:00 AM</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold ms-auto">
                                                    + $ 4,999
                                                </div>
                                            </div>
                                            <hr class="horizontal dark mt-3 mb-2">
                                        </li>
                                        <li class="list-group-item border-0 justify-content-between ps-0 pb-0 border-radius-lg">
                                            <div class="d-flex">
                                                <div class="d-flex align-items-center">
                                                    <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i class="material-icons text-lg">expand_less</i></button>
                                                    <div class="d-flex flex-column">
                                                        <h6 class="mb-1 text-dark text-sm">Partner #90211</h6>
                                                        <span class="text-xs">07 June 2021, at 05:50 AM</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold ms-auto">
                                                    + $ 700
                                                </div>
                                            </div>
                                            <hr class="horizontal dark mt-3 mb-2">
                                        </li>
                                        <li class="list-group-item border-0 justify-content-between ps-0 mb-2 border-radius-lg">
                                            <div class="d-flex">
                                                <div class="d-flex align-items-center">
                                                    <button class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i class="material-icons text-lg">expand_more</i></button>
                                                    <div class="d-flex flex-column">
                                                        <h6 class="mb-1 text-dark text-sm">Services</h6>
                                                        <span class="text-xs">07 June 2021, at 07:10 PM</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center text-danger text-gradient text-sm font-weight-bold ms-auto">
                                                    - $ 1,800
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
        
                        
                       
                    </div>

                    

                    
                </div>
                <div class="col-lg-4 col-12 h-100" >
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <div class="card ">
                       
                                <div class="card-body">
                                    <div class="row gx-3">
                                        <div class="col-auto">
                                            <div class="avatar avatar-xl position-relative">
                                                <img src="{{URL::asset('/img/profile/'.$member->picture)}}" alt="profile_image"
                                                    class="w-100 rounded-circle shadow-sm">
                                            </div>
                                        </div>
                                        <div class="col-auto my-auto">
                                            <div class="h-100">
                                                <h6 class="mb-1">
                                                    {{ $member->first_name }} {{ $member->middle_name }} {{ $member->last_name }} {{ $member->suffix }}
                                                </h6>
                                                <p class="mb-0 font-weight-normal text-sm text-success">
                                                    {{ $member->type }}
                                                </p>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <button class="btn btn-icon btn-danger w-100" style="height: 35px !important;" type="button" data-bs-toggle="modal" data-bs-target="#modalAddCPDPoints">
                                                <span class="btn-inner--icon"><i class="material-icons">add</i></span>
                                                <span class="btn-inner--text">&nbsp;ADD CPD POINTS</span></button>
                                        </div>
                                    </div>
                                 
                                    <hr>

                                    <div class="row">
                                        <div class="col-md-12 col-12 mb-md-0 mb-4">
                                            <div class="card card-body border card-plain border-radius-lg ">
                                                <p style="text-align: center !important" class="text-md text-bold">TOTAL CPD POINTS</p>
                                                <h1 class="mb-0" style="text-align: center !important; font-size: 61px !important">
                                                  {{ $top_member_points }}
                                                </h1>
                                               
                                               
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-lg-12">
                                            <div class="accordion" id="accordionRental">

                                                <div class="accordion-item my-2">
                                                    <h5 class="accordion-header" id="headingFour">
                                                        <button class="accordion-button border-bottom font-weight-bold" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false"
                                                            aria-controls="collapseFour">
                                                            2023
                                                            <i
                                                                class="collapse-close material-icons text-sm font-weight-bold pt-1 position-absolute end-0 me-3">add</i>
                                                            <i
                                                                class="collapse-open material-icons text-sm font-weight-bold pt-1 position-absolute end-0 me-3">remove</i>
                                                        </button>
                                                    </h5>
                                                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                                        data-bs-parent="#accordionRental">
                                                        <div class="accordion-body text-sm opacity-8">
                                                            {{ $top_member_points }} POINTS
                                                        </div>
                                                    </div>
                                                </div>
                                               
                                                <div class="accordion-item my-2">
                                                    <h5 class="accordion-header" id="headingTwo">
                                                        <button class="accordion-button border-bottom font-weight-bold" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                                            aria-controls="collapseTwo">
                                                            2022
                                                            <i
                                                                class="collapse-close material-icons text-sm font-weight-bold pt-1 position-absolute end-0 me-3">add</i>
                                                            <i
                                                                class="collapse-open material-icons text-sm font-weight-bold pt-1 position-absolute end-0 me-3">remove</i>
                                                        </button>
                                                    </h5>
                                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                                        data-bs-parent="#accordionRental">
                                                        <div class="accordion-body text-sm opacity-8">
                                                           0 POINTS
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item my-2">
                                                    <h5 class="accordion-header" id="headingThree">
                                                        <button class="accordion-button border-bottom font-weight-bold" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false"
                                                            aria-controls="collapseThree">
                                                            2021
                                                            <i
                                                                class="collapse-close material-icons text-sm font-weight-bold pt-1 position-absolute end-0 me-3">add</i>
                                                            <i
                                                                class="collapse-open material-icons text-sm font-weight-bold pt-1 position-absolute end-0 me-3">remove</i>
                                                        </button>
                                                    </h5>
                                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                                        data-bs-parent="#accordionRental">
                                                        <div class="accordion-body text-sm opacity-8">
                                                            0 POINTS
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                
                                            </div>
                                        </div>
                                    </div>

                                    {{-- START MODAL ADD CPD POINTST --}}
                                    <div class="modal fade" id="modalAddCPDPoints" tabindex="-1" role="dialog" aria-labelledby="modalAddCPDPoints" aria-hidden="true">
                                        <div class="loading" id="loading5" style="display: none;"> 
                                            <img src="{{ asset('assets') }}/img/pps-logo.png" style="height: 60px !important; width: 60px !important" alt="img-blur-shadow" class="icons">
                                        </div>
                                        <div class="modal-dialog modal-dialog-scrollable modal-danger modal-dialog-centered modal-md" role="document">
                                        <div class="modal-content">
                                        
                                            <div class="modal-header bg-gradient-danger">
                                            <h6 class="modal-title font-weight-bold" id="modal-title-notification" style="color: white !important">ADD CPD POINTS</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                
                                            </button>
                                            </div>
                                            <div class="modal-body">
                                                {{-- Start of hidden input --}}
                                                <input type="hidden" value="{{ url('cpdpoints-submit') }}" id="urlSaveCpdPoints">
                                                <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">
                                                <input type="hidden" id="pps_no" name="pps_no" value="{{ $ids }}">
                                                
                                                {{-- End of hidden input --}}
                                                <div class="row">
                                                    <div class="col-lg-12 col-12 mt-1">
                                                        <label class="form-label text-bold">Choose Category<code> <b>*</b></code></label>
                                                        <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                            <select name="category_name" id="cpd_points_category_id" class="form-control cpd_points_category_id" required>
                                                                <option value="">Choose</option>
                                                                @foreach ($cpd_points_maintenance as $cpd_points_maintenance2)
                                                                    <option value="{{ $cpd_points_maintenance2->category }}">{{ $cpd_points_maintenance2->category }}</option>
                                                                @endforeach
                                                            </select>
                                                          </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-2" style="display: none;" id="event_title_row">
                                                    <div class="col-lg-8 col-12 mt-1">
                                                        <label class="form-label text-bold">Choose Event<code> <b>*</b></code></label>
                                                        <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                            <select name="event_id" id="event_id" class="form-control event_id" required>
                                                                <option value="">Choose</option>
                                                                @foreach ($event as $event2)
                                                                    <option value="{{ $event2->id }}" title="{{ $event2->points }}">{{ $event2->description }}</option>
                                                                @endforeach
                                                            </select>
                                                          </div>
                                                    </div>
                                                    <div class="col-lg-4 col-12 mt-1">
                                                        <label class="form-label text-bold">CPD Points<code> <b>*</b></code></label>
                                                        <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                            <input style="height: 38px !important; text-align: center !important" type="number"  class="form-control" name="points" id="cpd_points" min="0" oninput="validity.valid||(value='');">
                                                          </div>
                                                    </div>
                                                </div>
                                              
                                                <div class="row mt-3" style="text-align: right !important">
                                                    <div class="col-lg-12 col-12">
                                                        <button class="btn btn-danger" type="button" id="btnSaveCpdPoints">Save</button>
                                                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>

                                            </div>
                                            
                                        </div>
                                        </div>
                                    </div>
                                    {{-- END OF MODAL ADD CPD POINTS --}}
                                   
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

              
            </div>

            {{-- <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="card z-index-2 mt-4">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 me-3 float-start">
                                <i class="material-icons opacity-10">leaderboard</i>
                            </div>
                            <h6 class="mb-0">Bar chart</h6>
                            <p class="mb-0 text-sm">Sales related to age average</p>
                        </div>
                        <div class="card-body p-3 pt-0">
                            <div class="chart">
                                <canvas id="bar-chart" class="chart-canvas" height="599" width="656" style="display: block; box-sizing: border-box; height: 300px; width: 328.2px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}


         
            <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
        </div>
    </main>
    
    <x-plugins></x-plugins>
    <link href="{{ asset('assets') }}/css/loader.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/cpd-points.css" rel="stylesheet" />
    @push('js')
    <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets') }}/js/select2.min.js"></script>
    <link href="{{ asset('assets') }}/css/select2.min.css" rel="stylesheet" />
    <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
    <script src="{{ asset('assets') }}/js/cpd-points.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/chartjs.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>

    <!-- Kanban scripts -->

    {{-- <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script> --}}


  
    @endpush
</x-page-template>
