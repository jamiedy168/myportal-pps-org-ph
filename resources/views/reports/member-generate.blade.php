
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="reports" activeItem="view-reports" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="Reports"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->
      <div class="container-fluid py-4">


        <div class="row mt-1">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header p-3 pb-2 bg-danger" style="height: 80px !important">
                        <h6 class="mb-1 text-white">{{ $reports->report_title }} Report</h6>
                        <p class="text-sm text-white">{{ $reports->description }}</p>
                    </div>
                    <div class="card-body pb-2">
                      <form method="POST" role="form text-left" enctype="multipart/form-data" id="form-generate-report">
                        @csrf
                        <input type="hidden" id="token" value="{{ csrf_token() }}">
                        <input type="hidden" value="{{ url('reports-member-generate')}}" id="urlGenerateMember">
                        <div class="row mb-2">
                          <div class="col-12">
                              <div class="row justify-content-md-center">
                                  <div class="col-lg-4 col-12">
                                    <label class="form-label text-bold">Member Type</label>
                                    <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                        <select name="member_type" id="member_type" class="form-control member_type" multiple>
                                            @foreach ($member_type as $type2)
                                              <option value="{{ $type2->id }}">{{ $type2->member_type_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                  </div>
                                  <div class="col-lg-4 col-12">
                                      <label class="form-label text-bold">Chapter</label>
                                      <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                        <select name="member_chapter" id="member_chapter" class="form-control member_chapter" style="text-align: center !important">
                                                <option value="" selected>All</option>
                                            @foreach ($chapter as $chapter2)
                                                <option value="{{ $chapter2->id }}">{{ $chapter2->chapter_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                  </div>
                                  <div class="col-lg-4 col-12">
                                    <label class="form-label text-bold">Classification</label>
                                    <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                      <select name="classification" id="classification" class="form-control classification" style="text-align: center !important">
                                              <option value="" selected>All</option>
                                          @foreach ($classification as $classification2)
                                              <option value="{{ $classification2->id }}">{{ $classification2->description }}</option>
                                          @endforeach
                                      </select>
                                  </div>
                                </div>


                              </div>
                          </div>
                        </div>
                        <div class="row mt-3 justify-content-md-center">
                          <div class="col-12 col-md-10" >
                              <button class="btn btn-icon btn-3 btn-danger" type="submit">
                                  <span class="btn-inner--icon"><i class="material-icons">upgrade</i></span>
                              <span class="btn-inner--text">Generate</span>
                              </button>

                          </div>
                        </div>
                      </form>
                      <div class="table-responsive" id="refreshDiv">
                        <table class="table align-items-center mb-0">
                          <thead>
                            <tr>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Member Type</th>
                              <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Chapter</th>
                              <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Generated By</th>
                              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($reports_member as $reports_member2)
                            <tr>
                              <td>
                                <h6 class="mb-0 text-sm ellipsis">
                                  {{ $loop->iteration }}. &nbsp;{{ $reports_member2->member_type }}
                                </h6>
                              </td>
                              
                              <td class="text-center">
                                @if ($reports_member2->chapter == null)
                                <p class="text-sm text-secondary mb-0">ALL</p>
                                @else
                                <p class="text-sm text-secondary mb-0">{{ $reports_member2->chapter_name }}</p>
                                @endif


                              </td>
                              <td class="text-center">
                                <p class="text-sm text-secondary mb-0">{{ $reports_member2->created_by }}</p>
                              </td>
                              <td class="align-middle text-center text-sm">
                                @if ($reports_member2->status == 'COMPLETED')
                                  <span class="badge badge-sm badge-success">Completed</span>
                                @else
                                  <span class="badge badge-sm badge-danger">Generating</span>
                                @endif

                              </td>

                            </tr>
                            @endforeach


                          </tbody>
                        </table>
                        <br>
                        {{ $reports_member->appends($_GET)->links('vendor.pagination.bootstrap-5') }}
                      </div>

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
    <link href="{{ asset('assets') }}/css/report-member-generate.css" rel="stylesheet" />

  @push('js')
  <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>
  <script src="{{ asset('assets') }}/js/select2.min.js"></script>
  <script src="{{ asset('assets') }}/js/report-member-generate.js"></script>


    @endpush
  </x-page-template>
