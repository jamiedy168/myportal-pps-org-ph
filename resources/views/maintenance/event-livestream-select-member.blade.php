
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="maintenance" activeItem="event-livestream-maintenance" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="Livestream Maintenance"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->
      <div class="container-fluid py-4">
        <div class="row mt-0" style="margin-top: -15px !important">
            <div class="col-lg-12 col-12 mb-3">
                <div class="card">
                   
                    <div class="card-body">

                        <input type="hidden" value="{{ $event->id }}" id="event_id">
                        <input type="hidden" value="{{ url('event-add-livestream-member') }}" id="urlEventAddLiveStreamMember">
                        <input type="hidden" value="{{ url('event-remove-livestream-member') }}" id="urlEventRemoveLiveStreamMember">
                        <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">

                        <div class="row">
                            <div class="col-lg-12 col-12 mt-1">
                                <label class="form-label text-bold">Choose Participant<code> <b>*</b></code></label>
                                <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                    <select name="pps_no" id="pps_member" class="form-control pps_member" required>
                                        <option value="">Select Participant</option>
                                        @foreach ($livestream_member_choose as $member2)
                                            <option value="{{ $member2->pps_no }}">{{ $member2->first_name }} {{ $member2->middle_name }} {{ $member2->last_name }} {{ $member2->suffix }} | {{ $member2->prc_number }}</option>
                                        @endforeach
                                    </select>
                                    
                                  </div>
                            </div>
                        
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-12">
                                <button class="btn btn-success btn-lg" id="addParticipantBtn">ADD TO LIST</button>
                            </div>
                        </div>


                        <div class="row mt-0">
                            <div class="col-12">
                                <form class="form-horizontal" action="{{ route('event-livestream-search-participant', ['id' => $id]) }}" method="GET" autocomplete="off">
                                    @csrf
                                    <div class="row mt-4">
                                        <div class="col-lg-6"></div>
                                        <div class="col-lg-6 col-12">
                                            <div class="input-group input-group-outline">
                                                <label class="form-label">Search here..</label>
                                                <input type="text" class="form-control" name="searchinput" id="searchbox-input" value="{{ $name }}" style="height: 46px !important">
                                                <button class="btn bg-gradient-danger btn-lg" type="submit" id="searchBtn"><i class="fas fa-search"></i></button>
                                                </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="table table-responsive" id="refreshDiv">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Member
                                                   </th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Type
                                                </th>   
                                              

                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" style="text-align: center !important">
                                                    Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($livestream_member as $livestream_member2)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex px-2 py-1">
                                                                <div>
                                                                   
                                                                    <img src="{{ asset('assets') }}/img/pps-logo.png"
                                                                        class="avatar avatar-md me-3" alt="image">
                                                                </div>
                                                                <div class="d-flex flex-column justify-content-center">
                                                                    <h6 class="mb-0 text-sm">{{ $livestream_member2->first_name }} {{ $livestream_member2->middle_name }} {{ $livestream_member2->last_name }} {{ $livestream_member2->suffix }}   
                                                                    </h6>
                                                                
                                                                    @if ($livestream_member2->prc_number == null)
                                                                        <p class="text-sm"><b class="text-danger">PRC No.: </b> N/A</p>
                                                                    @else
                                                                    <p class="text-sm"><b class="text-danger">PRC No.: </b>{{ $livestream_member2->prc_number }}</p>    
                                                                    @endif
                                                                    
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td class="text-center">
                                                           {{ $livestream_member2->member_type_name }}
                                                        </td>
                                                        
                                                        <td style="text-align: center !important">
                                                            <a href="#" id="{{ $livestream_member2->pps_no }}" onClick="removeParticipant(this.id, '{{ $livestream_member2->event_id }}')" class="btn btn-icon btn-danger btn-outline-danger  mt-3" style="height: 37px !important;" type="button">
                                                                <span class="btn-inner--icon"><i class="material-icons">delete</i></span>
                                                                <span class="btn-inner--text">&nbsp;REMOVE</span>
                                                            </a>
                                                        </td>

                                                    </tr>
                                                @endforeach
                                         
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                {{ $livestream_member->appends($_GET)->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                      </div>
                </div>
            </div>
            
        </div>
        <link href="{{ asset('assets') }}/css/event-livestream-maintenance.css" rel="stylesheet" />
        <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
    </div>
    </main>
    <x-plugins></x-plugins>
  @push('js')

  <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('assets') }}/js/maintenance.js"></script>
  <script src="{{ asset('assets') }}/js/select2.min.js"></script>
  <link href="{{ asset('assets') }}/css/select2.min.css" rel="stylesheet" />
  <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/datatables.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/choices.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>

    @endpush
  </x-page-template>
  