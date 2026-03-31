<x-page-template bodyClass='g-sidenav-show bg-gray-200'>
  <x-auth.navbars.sidebar activePage='attendance' activeItem='attendance-event' activeSubitem=''></x-auth.navbars.sidebar>
  <main class="main-content main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <x-auth.navbars.navs.auth pageTitle='Events'></x-auth.navbars.navs.auth>
     
      <style>
        .modal-dialog {
  height: 90%; /* = 90% of the .modal-backdrop block = %90 of the screen */
}
.modal-content {
  height: 100%; /* = 100% of the .modal-dialog block */
}
      </style>
      <div class="container-fluid my-3 py-4">
          {{-- <div class="loading" id="loading3"> 
              <img src="{{ asset('assets') }}/img/pps-logo.png" style="height: 60px !important; width: 60px !important" alt="img-blur-shadow" class="icons">
          </div> --}}
          <div class="row mt-0" style="margin-top: -20px !important">
              {{-- Start of hidden input --}}
              
              
              <input type="hidden" value="{{ url('event-attendance-check-count') }}" id="urlEventCheckAttendanceCount">
              <input type="hidden" value="{{ url('event-attendance-check-count2') }}" id="urlEventCheckAttendanceCount2">
              <input type="hidden" value="{{ url('event-attendance-check') }}" id="urlEventCheckAttendance">
              <input type="hidden" value="{{ url('event-attendance-check-via-prc') }}" id="urlEventCheckAttendanceViaPRC">  
              <input type="hidden" value="{{ url('event-member-not-attended') }}" id="urlEventMemberNotAttended">
              <input type="hidden" value="{{ url('event-member-not-attended-via-prc') }}" id="urlEventMemberNotAttendedViaPRC">

              <input type="hidden" value="{{ url('check-member-exist') }}" id="urlCheckMemberExist">
              <input type="hidden" value="{{ url('event-check-attended') }}" id="urlCheckAttended">
              <input type="hidden" value="{{ url('check-member-exist-via-prc') }}" id="urlCheckMemberExistViaPRC">
              <input type="hidden" value="{{ url('event-check-attended-via-prc') }}" id="urlCheckAttendedViaPRC">
              <input type="hidden" value="{{ url('event-attendance-check-count-via-prc') }}" id="urlEventCheckAttendanceCountViaPRC">
              <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">
              <input type="hidden" id="event_id" name="event_id" value="{{ $event_id }}">
              <input type="hidden" id="pps_no2" name="pps_no">
              <input type="hidden" id="type_transaction" name="type_transaction">

              
              <audio>
                <source src="{{ asset('assets') }}/audio/qrsoundeffect.mp3"></source>

              </audio>
              {{-- End of hidden input --}}
              <div class="col-lg-4 col-12">
                <div class="row">
                  <div class="col-12">
                    <div class="card">
                      <div class="card-header p-3 pb-0 bg-gradient-danger">
                          <div class="row">
                              <div class="col-8">
                                  <h6 class="mb-2 text-white">&nbsp;</h6>
                              </div>
                              <div class="col-4 text-end">
                                  <a href="#" class="btn btn-link btn-icon-only btn-rounded text-white icon-move-right my-auto" style="margin-top: -5px !important">
                                      <i class="fas fa-camera" aria-hidden="true"></i>
                                          
                                  </a>
                              </div>
                          </div>
                      </div>
                      <div class="card-body">
                        <form action="" method="POST" id="qr_code_form">
                          <div class="input-group input-group-outline">
                            <input type="text" class="form-control" id="pps_no_qr" required name="pps_no_qr" style="display: none !important">
                          </div>
                          
                          <button type="submit" class="btn btn-success" style="opacity: 0 !important; margin-top: -20px !important">search</button>
                        </form>
                        <div class="row">
                          <div class="col-12 text-center">
                            <h5 id="scan_qr_text" style="display: none !important">SCAN ATTENDEE QR CODE</h5>
                            <video id="preview" style="width: 100%; height: 180px; display: none;" class="w-100 border-radius-lg shadow-sm"></video>
                            <img src="{{ asset('assets') }}/img/barcode_now.gif" style="height: 230px;" class="w-100 border-radius-lg shadow-sm" id="qr_scanner_img" />
                          </div>
                        </div>
                        <div class="row mt-3">
                          <div class="col-12">
                            <button class="btn btn-success w-100" id="start_camera">START CAMERA</button>
                          </div>
                        </div>
                        <div class="row" style="margin-top: -5px !important">
                          <div class="col-12">
                            <button class="btn btn-danger w-100" id="stop_camera">STOP CAMERA</button>
                          </div>
                        </div>
                        <div class="row" style="margin-top: -5px !important">
                          <div class="col-12">
                            <button class="btn btn-warning w-100" id="scan_qr_code">SCAN QR CODE</button>
                          </div>
                        </div>
                       
                        {{-- <div class="row">
                          <div class="col-12">
                            <input type="text" class="form-control" name="text" id="text">
                          </div>
                        </div> --}}
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row mt-2">
                  <div class="col-12 col-lg-12">
                    <div class="card">
                    
                      <div class="card-body">
                        <div class="row" style="text-align: center !important">
                          <div class="col-md-12 mb-md-0 mb-4">
                              <div
                                  class="card card-body border card-plain border-radius-lg ">
                                  <h6 class="mb-0" style="margin-top: -10px !important">
                                    STATUS
                                 </h6>
                                  <h3 class="mb-0 text-success" id="payment_status">
                                 
                                 </h3>
                              </div>
                          </div>
                          
                      </div>
                        
                      </div>
                    </div>
                  </div>
                </div>
                  
              </div>
              <div class="col-lg-8 col-12" style="margin-top:-10px !important">
                <div class="row mt-1">
                  <div class="col-12 col-lg-12">
                    <div class="card">
                    
                      <div class="card-body">
                        <div class="row mt-0">
                          <div class="col-md-6">
                            <h5 class="mb-1">Attendee Details</h5>
                          </div>
                          <div class="col-md-6" style="text-align: right !important">
                            {{-- <button class="btn bg-gradient-warning mb-0" type="button" name="button" data-bs-toggle="modal" data-bs-target="#searchMemberModal">
                              <span class="btn-inner--icon"><i class="fas fa-search" aria-hidden="true"></i></span>
                              <span class="btn-inner--text">&nbsp;Search</span></button> --}}
                              <form action="" method="POST" id="search-prc-form">
                                <div class="input-group input-group-outline">
                                  <label class="form-label">Enter PRC Number</label>
                                  <input type="text" class="form-control" id="searchbox-prc" required name="searchbox-prc" style="height: 46px !important">
                                  <button class="btn bg-gradient-danger btn-lg" id="searchPRCBtn" type="submit"><i class="material-icons">search</i></button>
                                </div>
                              </form>
                          </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-xl-5 col-lg-6 text-center">
                                <img class="w-100 border-radius-lg shadow-lg mx-auto"
                                    src="{{ asset('assets') }}/img/pps-logo.png" alt="profile" id="member_picture">                                
                            </div>
                            <div class="col-lg-7 mx-auto mt-0">
                                <h4 class="mt-lg-0 mt-3 text-gradient text-danger" id="attendee_name"></h4>
                                <ul class="list-unstyled mx-auto">
                                  <li class="d-flex">
                                      <p class="mb-0 text-bold"><i class="material-icons text-lg opacity-6" style="margin-top: 7px !important">person</i> &nbsp; Member Type:</p>
                                      <span class="badge badge-success ms-auto" id="attendee_type"></span>
                                  </li>
                                  <li>
                                      <hr class="horizontal dark">
                                  </li>
                                  <li class="d-flex">
                                      <p class="mb-0 text-bold"><i class="material-icons text-lg opacity-6" style="margin-top: 7px !important">wc</i> &nbsp;Gender:</p>
                                      
                                          <label class="ms-auto" id="attendee_gender"></label>
                                      
                                  </li>
                                  <li>
                                      <hr class="horizontal dark">
                                  </li>
                                  <li class="d-flex">
                                      <p class="mb-0 text-bold"><i class="material-icons text-lg opacity-6" style="margin-top: 7px !important">badge</i> &nbsp;PRC Number:</p>
                                      <label class="ms-auto" id="attendee_prc_no"></label>
                                  </li>
                              </ul>
                                
                                <hr>
                              
                                {{-- <label class="mt-4">Description</label>
                                <ul>
                                    <li>The most beautiful curves of this swivel stool adds an elegant touch to
                                        any environment</li>
                                    <li>Memory swivel seat returns to original seat position</li>
                                    <li>Comfortable integrated layered chair seat cushion design</li>
                                    <li>Fully assembled! No assembly required</li>
                                </ul> --}}
                              
                                <div class="row mt-0" style="margin-top: -20px !important">
                                  <label class="mt-4 text-gradient text-danger text-bold">EVENT TRANSACTION:</label>
                                    <div class="col-lg-12">
                                      <div class="d-sm-flex bg-gray-100 border-radius-lg p-2 my-2"> 
                                        <p class="text-xs font-weight-bold my-auto ps-sm-2"> <i class="material-icons text-lg opacity-6" style="margin-top: 7px !important">event</i> &nbsp;EVENT TITLE:</p>
                                        <label class="text-xs ms-sm-auto mt-sm-3 mt-2 w-sm-50 w-70" style="text-transform: uppercase">{{ $event_name }}</label>
                                      </div>
                                      <div class="d-sm-flex bg-gray-100 border-radius-lg p-2 my-2"> 
                                        <p class="text-xs font-weight-bold my-auto ps-sm-2"> <i class="material-icons text-lg opacity-6" style="margin-top: 7px !important">event</i> &nbsp;DATE/TIME JOINED:</p>
                                        <label class="text-xs ms-sm-auto mt-sm-3 mt-2 w-sm-50 w-70" style="text-transform: uppercase" id="member_joined_dt"></label>
                                      </div>
                                      <div class="d-sm-flex bg-gray-100 border-radius-lg p-2 my-2"> 
                                      <p class="text-xs font-weight-bold my-auto ps-sm-2"> <i class="material-icons text-lg opacity-6" style="margin-top: 7px !important">event</i> &nbsp;DATE/TIME PAYMENT:</p>
                                      <label class="text-xs ms-sm-auto mt-sm-3 mt-2 w-sm-50 w-70" style="text-transform: uppercase" id="member_payment_dt"></label>
                                      </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                  <div class="col-12">
                                    <button class="btn btn-danger w-100 text-white" id="btnAttend" disabled>REGISTERED</button>
                                  </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>


          <div class="modal fade" id="searchMemberModal" tabindex="-1" role="dialog" aria-labelledby="searchMemberModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-body p-0">
                  <div class="card card-plain">
                    <div class="card-header pb-0">
                      <div class="row">
                        <div class="col-10">
                          <h5 class="">Search</h5>
                        </div>
                        <div class="col-2" style="text-align: right !important">
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="text-danger">×</span>
                          </button>
                        </div>
                      </div>
                      
                        
                        <p class="mb-0">Search member attendee below.</p>
                    </div>
                    <div class="card-body pb-3">
                      <form role="form text-left">
                        <div class="row">
                          <div class="col-lg-12 col-12">
                            <div class="input-group input-group-outline">
                                <label class="form-label">Search here..</label>
                                <input type="text" class="form-control" id="searchbox-input" style="height: 46px !important">
                                <button class="btn bg-gradient-danger btn-lg" id="searchBtn"><i class="fas fa-search"></i></button>
                            </div>
                          </div>
                        </div>

                        {{-- <div class="row">
                          <div class="col-12 col-lg-12">
                            <div class="table-responsive p-0">
                              <table class="table table-hover align-items-center mb-0" id="datatable-search">
                                  <thead>
                                      <tr>
                                          <th
                                              class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                              </th>
                                          
                                          <th
                                              class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                              </th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @foreach ($member as $member2)
                                      <tr data-id="{{ $member2->pps_no }}" class="member">
                                          <td>
                                              <div class="d-flex px-3 py-1">
                                                  <div>
                                                      <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $member2->picture, now()->addMinutes(230))}}"
                                                          class="avatar me-3" alt="image">
                                                  </div>
                                                  <div class="d-flex flex-column justify-content-center">
                                                      <h6 class="mb-0 text-sm">{{ $member2->first_name }} {{ $member2->middle_name }} {{ $member2->last_name }} {{ $member2->suffix }}</h6>
                                                      <p class="text-sm font-weight-normal text-secondary mb-0"><span
                                                              class="text-warning">PRC NO.:</span>
                                                              @if ($member2->prc_number == null)
                                                                N/A
                                                              @else
                                                                {{ $member2->prc_number }}
                                                              @endif
                                                              </p>
                                                  </div>
                                              </div>
                                          </td>
                                         
                                          <td class="align-middle text-end">
                                              <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                                  <i class="fas fa-plus ms-1 text-success"></i>
                                              </div>
                                          </td>
                                      </tr>
                                      @endforeach
                                  </tbody>
                              </table>
                          </div>
                          <br>
                          </div>
                        </div> --}}
                      </form>
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
  <script>
    const defaultProfileImg = "{{ asset('assets/img/pps-logo.png') }}";
  </script>

  
  <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>

  <script src="{{ asset('assets') }}/js/instascan.min.js"></script>
  <script src="{{ asset('assets') }}/js/select2.min.js"></script>
  <link href="{{ asset('assets') }}/css/select2.min.css" rel="stylesheet" />
  <script src="{{ asset('assets') }}/js/event-attendance.js"></script>
  <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/datatables.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/js/moment.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>

  <!-- Kanban scripts -->

  {{-- <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script> --}}
  <script>
    const dataTableSearch = new simpleDatatables.DataTable("#datatable-search", {
      "dom": '<"top"i>rt<"bottom"flp><"clear">',
      searchable: true,
      fixedHeight: false,
    });

  </script>


  @endpush
</x-page-template>
