
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="reports" activeItem="view-reports" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="Reports"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->
      <div class="container-fluid py-4">


        <div class="row mt-1 justify-content-md-center">
            <div class="col-12 col-md-10">
                <div class="card mb-4">
                    <div class="card-header p-3 pb-2 bg-danger" style="height: 80px !important">
                        <h6 class="mb-1 text-white">{{ $reports->report_title }} Report</h6>
                        <p class="text-sm text-white">{{ $reports->description }}</p>
                    </div>
                    <div class="card-body pb-2">
                      <form method="POST" role="form text-left" enctype="multipart/form-data" id="form-generate-report">
                        @csrf
                        <input type="hidden" id="token" value="{{ csrf_token() }}">
                        <input type="hidden" value="{{ url('reports-event-attendance-generate')}}" id="urlGenerateEventAttendance">
                        <div class="row mb-2">
                          <div class="col-12 col-md-12">
                              <div class="row justify-content-md-center">
                                  <div class="col-lg-8 col-12">
                                    <label class="form-label text-bold">Event</label>
                                    <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                        <select name="event_id" id="event_id" class="form-control event_id">
                                                <option value="">Select Event</option>
                                            @foreach ($event as $event2)
                                                <option value="{{ $event2->id }}">{{ $event2->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <div class="row mt-3 mb-3 justify-content-md-center">
                          <div class="col-12 col-md-12" style="text-align: center !important">
                              <button class="btn btn-icon btn-3 btn-danger" type="submit">
                                  <span class="btn-inner--icon"><i class="material-icons">upgrade</i></span>
                                   <span class="btn-inner--text">Generate</span>
                              </button>
                          </div>
                        </div>
                      </form>
                     
                    </div>
                </div>
            </div>
        </div>



      </div>
      <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
    </main>
    <x-plugins></x-plugins>
    <link href="{{ asset('assets') }}/css/loader.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/report.css" rel="stylesheet" />

  @push('js')
  <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>
  <script src="{{ asset('assets') }}/js/select2.min.js"></script>
  <script src="{{ asset('assets') }}/js/report.js"></script>


    @endpush
  </x-page-template>
