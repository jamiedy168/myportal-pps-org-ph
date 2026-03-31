
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="patientICD" activeItem="admitted-view" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="Ward Patient ICD"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->
      <div class="container-fluid py-4">
        

        <div class="row mt-1">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header p-3 pb-2 bg-danger" style="height: 80px !important">
                        <h6 class="mb-1 text-white">Ward Patient ICD View</h6>
                        <p class="text-sm text-white">List of all uploaded ICD.</p>
                    </div>
                    <div class="card-body pb-2">
                         {{-- Start of hidden input --}}
                            <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">
                            <input type="hidden" value="{{ url('icd-delete-ward') }}" id="urlICDWardDelete">
                         {{-- End of hidden input --}}
                        <form class="form-horizontal" action="{{ route('icd-admitted-search') }}" method="GET" autocomplete="off">
                            <div class="row mb-2">
                                <div class="col-12">
                                    <div class="row justify-content-md-center">
                                        <div class="col-lg-5 col-12">
                                            <label class="form-label text-bold">Month/Year From</label>
                                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                                <input type="month" class="form-control" name="date_from" id="date_from" value="{{ $date_from }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-12">
                                            <label class="form-label text-bold">Month/Year To</label>
                                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                                <input type="month" class="form-control" name="date_to" id="date_to" value="{{ $date_to }}">
                                            </div>
                                            
                                        </div>
            
                                        
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-3 justify-content-md-center">
                                <div class="col-12 col-md-10" >
                                    <button class="btn btn-icon btn-3 btn-danger" type="submit">
                                        <span class="btn-inner--icon"><i class="material-icons">search</i></span>
                                    <span class="btn-inner--text">Search</span>
                                    </button>
                                    <a class="btn btn-icon btn-3 btn-warning" href="/icd-admitted-view">
                                        <span class="btn-inner--text">Clear</span>
                                    </a>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Month</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Date Uploaded</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Uploaded By</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($registry_header as $registry_header2)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-3 py-1">
                                                    <div id="container2">
                                                        <div id="name2">{{ substr(Carbon\Carbon::parse($registry_header2->month_year_icd)->format('F'), 0, 2) }}
                                                        </div>
                                                    </div> &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ strtoupper(Carbon\Carbon::parse($registry_header2->month_year_icd)->format('F Y')) }}</h6>
                                                        <p class="text-sm font-weight-normal text-secondary mb-0"><span
                                                                class="text-success">{{ $registry_header2->record_count }}</span> patients</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-normal mb-0">{{Carbon\Carbon::parse($registry_header2->created_at)->format('F d, Y')}}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-sm font-weight-normal mb-0">{{ $registry_header2->created_by }}</p>
                                            </td>
                                            <td class="align-middle text-center">
                                                <button class="btn bg-gradient-danger dropdown-toggle mt-3" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton"> 
                                                    <li><a class="dropdown-item text-bold" href="/icd-admitted-view-month/{{ Crypt::encrypt( $registry_header2->id )}}">
                                                        <i class="fas fa-eye"></i>&nbsp; View All Patients
                                                        </a>
                                                    </li>
                                                    <li><a class="dropdown-item text-bold" href="#" id="{{ $registry_header2->id }}" onClick="deleteRecords(this.id)">
                                                            <i class="fas fa-trash"></i>&nbsp; Delete All Records
                                                        </a>
                                                    </li>
                                                    
                                                </ul>
                                              
                                            </td>
                                        </tr>
                                    @endforeach
                                   
                                </tbody>
                            </table>
                            <br>
                            {{ $registry_header->appends($_GET)->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
      

        {{-- <div class="card card-body mx-3 mx-md-4 ">
            
            <div class="row mt-4">
                <div class="col-12">
                    <div class="mb-3 ps-3">
                        <h6 class="mb-1">Patient ICD View</h6>
                        <p class="text-sm">List of all uploaded patient ICD.</p>
                    </div>

                    <form class="form-horizontal" action="{{ route('icd-admitted-search') }}" method="GET" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4 col-12">
                                <label class="form-label text-bold">Patient Initial</label>
                                <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                    <input type="text" class="form-control" name="patient_initial" id="patient_initial" value="{{ $patient_initial }}">
                                </div>
                                
                            </div>
                            <div class="col-lg-4 col-12">
                                <label class="form-label text-bold">From</label>
                                <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                    <input type="date" class="form-control" name="date_from" id="date_from" value="{{ $date_from }}">
                                </div>
                                
                            </div>
                            <div class="col-lg-4 col-12">
                                <label class="form-label text-bold">To</label>
                                <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                    <input type="date" class="form-control" name="date_to" id="date_to" value="{{ $date_to }}">
                                </div>
                                
                            </div>

                            
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <button class="btn btn-icon btn-3 btn-danger" type="submit">
                                    <span class="btn-inner--icon"><i class="material-icons">search</i></span>
                                <span class="btn-inner--text">Search</span>
                                </button>
                                <a class="btn btn-icon btn-3 btn-warning" href="/icd-admitted-view">
                                    <span class="btn-inner--text">Clear</span>
                                </a>
                            </div>
                        </div>
                    </form>

                    
                    
                    
                    <br>    

                    <div class="row">
                       <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-flush" >
                                <thead class="thead-light">
                                    <tr>
                                        <th></th>
                                        <th class="text-center text-danger">Patient Initial</th>
                                        <th class="text-center text-danger">Month/Year</th>
                                        <th class="text-center text-danger">ICD Codes</th>
                                        
                                        <th class="text-center text-danger">Uploaded Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($icdadmitted as $icdadmitted2)
                                        <tr class="bg-gray-10">
                                            <td><p class="text-sm font-weight-bold mb-0">{{ ($icdadmitted->currentPage() - 1) * $icdadmitted->perPage() + $loop->index + 1 }}.</p></td>
                                            <td class="text-center">
                                                <p class="text-sm font-weight-bold mb-0">{{ $icdadmitted2->patient_initial }}</p>
             
                                            </td>
                                            <td class="text-center">
                                                <p class="text-sm font-weight-bold mb-0">{{Carbon\Carbon::parse($icdadmitted2->month_year_icd)->format('F Y')}}</p>
                                             
                                            </td>
                                            <td class="text-center">
                                                <p class="text-sm font-weight-bold mb-0">
                                                     {{ $icdadmitted2->icd_no ? $icdadmitted2->icd_no . ',' : '' }}
                                                    {{ $icdadmitted2->icd_no2 ? $icdadmitted2->icd_no2 . ',' : '' }}
                                                    {{ $icdadmitted2->icd_no3 ? $icdadmitted2->icd_no3 : '' }}
                                                </p>

                                            </td>
                                        
                                            <td class="text-center">
                                                <p class="text-sm font-weight-bold mb-0">
                                                    {{Carbon\Carbon::parse($icdadmitted2->created_at)->format('Y-m-d')}}
                                                </p>
                                            </td>
                                            <td class="text-center">
                                                <a href="icd-admitted-view-details/{{ Crypt::encrypt( $icdadmitted2->id )}}" class="text-danger">View</a>
                                               
                                            </td>

                                        </tr>
                                        @endforeach
                              
                                </tbody>
                         
                            </table>
                        </div>
                        <br>
                        {{ $icdadmitted->appends($_GET)->links('vendor.pagination.bootstrap-5') }}
                       </div>
                    </div>
                    <br>
                

               


                
                </div>
            </div>
            
        </div> --}}
      
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
  