
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="patientICD" activeItem="admitted-view" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="Ward Patient ICD"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->
      <div class="container-fluid py-4">
        {{-- Start of hidden input --}}
        <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">
        <input type="hidden" value="{{ url('icd-delete-ward-patient') }}" id="urlICDWardPatientDelete">
        {{-- End of hidden input --}}
        <div class="row mt-0">
            <div class="col-lg-8 col-12">
                <div class="card">
                    <div class="card-header p-3 pb-2 bg-danger" style="height: 75px !important">
                        <h6 class="mb-1 text-white">Ward Patient</h6>
                        <p class="text-sm text-white">List of all ward patient.</p>
                    </div>
                    <div class="card-body pt-4 p-3">
                        <div class="row">
                            <div class="col-12">
                                <h4>{{ $formattedDateRange }} </h4>
                                <h6 style="margin-top: -8px !important">({{ $registry_header->record_count }} patients)</h6>
                            </div>
                        </div>
                        <form class="form-horizontal" action="{{ route('icd-admitted-search-month', ['id' => $id]) }}" method="GET" autocomplete="off">
                            @csrf
                            <div class="row mt-2">
                                <div class="col-lg-12 col-12">
                                    <div class="input-group input-group-outline">
                                        <label class="form-label">Search patient here..</label>
                                        <input type="text" class="form-control" name="searchinput" id="search-input" style="height: 46px !important">
                                        <button class="btn bg-gradient-danger btn-lg" id="searchBtn" type="submit"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <ul class="list-group" id="refreshDiv">
                            @foreach ($registry_admitted as $registry_admitted2)
                                <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-3 text-sm">{{ $registry_admitted2->patient_initial }}</h6>
                                        <span class="mb-2 text-xs">Date Admitted: <span
                                                class="text-dark font-weight-bold ms-sm-2">{{Carbon\Carbon::parse($registry_admitted2->date_admitted)->format('F d, Y')}}</span></span>
                                        <span class="mb-2 text-xs">Date Discharged: <span
                                                class="text-dark ms-sm-2 font-weight-bold">{{Carbon\Carbon::parse($registry_admitted2->date_discharged)->format('F d, Y')}}</span></span>
                                        <span class="text-xs">ICD Code(s): 
                                            <span class="text-dark ms-sm-2 font-weight-bold">   
                                                {{ $registry_admitted2->icd_no ? $registry_admitted2->icd_no . ',' : '' }}
                                                {{ $registry_admitted2->icd_no2 ? $registry_admitted2->icd_no2 . ',' : '' }}
                                                {{ $registry_admitted2->icd_no3 ? $registry_admitted2->icd_no3 : '' }}
                                            </span>
                                        </span>
                                    </div>
                                    <div class="ms-auto text-end">
                                        <a class="btn btn-link text-dark px-3 mb-0" href="/icd-admitted-view-patient/{{ Crypt::encrypt( $registry_admitted2->id )}}"><i
                                            class="material-icons text-sm me-2">visibility</i>View Patient</a>
                                        <button class="btn btn-link text-danger text-gradient px-3 mb-0"
                                        id="{{ $registry_admitted2->id }}" onClick="deleteWardPatient(this.id)"><i
                                                class="material-icons text-sm me-2">delete</i>Delete</button>
                                    </div>
                                </li>
                            @endforeach
                            
                        </ul>
                        <div class="row mt-2" id="refreshDiv2">
                            <div class="col-12">
                                {{ $registry_admitted->appends($_GET)->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="col-lg-4 col-12 mt-md-0 mt-4">
                <div class="card mb-4">
                    <div class="card-header pb-0 px-3">
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="mb-0">TOP 10 ICD</h6>
                            </div>
                            
                        </div>
                    </div>
                    <div class="card-body pt-1 p-3">
                        <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Top ICD for {{ $formattedDateRange }}</h6>
                        <hr>
                        <ul class="list-group">
                            @foreach ($countValues as $index => $countValues2)
                                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                    <div class="d-flex align-items-center">
                                        <button
                                            class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center">
                                            <span class="text-lg">{{ $index + 1 }}</span>
                                        </button>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-1 text-dark text-sm">{{ $countValues2->value }}</h6>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center text-danger text-gradient text-sm font-weight-bold">
                                        {{ $countValues2->count }}
                                    </div>
                                </li>
                                <hr>
                              
                            @endforeach


                        </ul>
                      
                    </div>
                </div>
            </div>
        </div>


      
      </div>
      <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
    </main>
    <x-plugins></x-plugins>
    <link href="{{ asset('assets') }}/css/loader.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/icd-admitted.css" rel="stylesheet" />
  @push('js')
  <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>  
  <script src="{{ asset('assets') }}/js/icd-registry-ward.js"></script>



    @endpush
  </x-page-template>
  