
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="neonatalICD" activeItem="neonatal-view" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="Neonatal"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->
      <div class="container-fluid py-4">
        <div class="row mt-4">
            <div class="col-lg-4 mb-3">
                <div class="card mt-4 h-100" data-animation="true">
                    <div class="card-header p-0 position-relative mt-n4 mx-7 z-index-2">
                        <a class="d-block blur-shadow-image">
                            <img src="{{ asset('assets') }}/img/default-avatar.png" alt="img-blur-shadow"
                                class="img-fluid shadow border-radius-lg">
                        </a>
                    </div>
                    <div class="card-body text-center">
                        <p class="font-weight-bolder mt-4 mb-0">
                            Patient Initial
                        </h5>
                        <h5 class="font-weight-normal mt-0">
                            {{ $registry_neonatal->patient_initial }}
                        </h5>
                        
                        {{-- <p class="mb-0">
                            The place is close to Barceloneta Beach and bus stop just 2 min by walk and near to
                            "Naviglio" where you can enjoy the main night life in Barcelona.
                        </p> --}}
                    </div>
                    
                    <div class="card-footer">
                        <hr>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <p class="mb-0 text-xs text-bold">Date Uploaded</p>
                                <p class="mb-0 mt-0 text-sm"> {{Carbon\Carbon::parse($registry_neonatal->created_at)->format('F d, Y')}}</p>
                            </div>
                            <div class="col-12 col-md-6">
                                <p class="mb-0 text-xs text-bold">Uploaded By</p>
                                <p class="mb-0 mt-0 text-sm"> {{ $registry_neonatal->created_by }}</p>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-lg-8 mt-lg-0 mt-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="font-weight-bolder">Patient Information</h5>
                        <div class="row mt-4">
                            <div class="col-12 col-md-12">
                                <label class="form-label text-bold">Hospital</label>
                                <div class="input-group input-group-dynamic" id="titleRow" style="margin-top: -5px !important">
                                    <input type="text" class="form-control" name="hosp_name" id="hosp_name" value="{{ $registry_neonatal->hosp_name }}">
                                </div>  
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label text-bold">Patient Birth Location</label>
                                <div class="input-group input-group-dynamic" id="titleRow" style="margin-top: -5px !important">
                                    <input type="text" class="form-control" name="date_of_birth" id="date_of_birth" value="{{ $registry_neonatal->patient_birth_location }}">
                                </div>  
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label text-bold">Gestational Age(weeks)</label>
                                <div class="input-group input-group-dynamic" id="titleRow" style="margin-top: -5px !important">
                                    <input type="text" class="form-control text-center" name="age" id="age" value="{{ $registry_neonatal->gestational_age }}">
                                </div>  
                            </div>
                        
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label text-bold">Birth Weight</label>
                                <div class="input-group input-group-dynamic" id="titleRow" style="margin-top: -5px !important">
                                    <input type="text" class="form-control text-center" name="weight" id="weight" value="{{ $registry_neonatal->birth_weight }}">
                                </div>  
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label text-bold">Gender</label>
                                <div class="input-group input-group-dynamic" id="titleRow" style="margin-top: -5px !important">
                                    <input type="text" class="form-control" name="gender" id="gender" value="{{ $registry_neonatal->gender }}">
                                </div>  
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label text-bold">Date Admitted</label>
                                <div class="input-group input-group-dynamic" id="titleRow" style="margin-top: -5px !important">
                                    <input type="text" class="form-control" name="weight" id="weight" value="{{Carbon\Carbon::parse($registry_neonatal->date_of_admission)->format('F d, Y')}}">
                                </div>  
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label text-bold">Date Discharged</label>
                                <div class="input-group input-group-dynamic" id="titleRow" style="margin-top: -5px !important">
                                    <input type="text" class="form-control" name="date_of_birth" id="date_of_birth" value="{{Carbon\Carbon::parse($registry_neonatal->date_discharged)->format('F d, Y')}}">
                                </div>  
                            </div>
                        </div>

                 
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mt-3">
                <div class="card mt-4">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-danger shadow text-center border-radius-xl mt-n4 float-start">
                            <i class="material-icons opacity-10">splitscreen</i>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="font-weight-bolder">ICD/Diagnosis Details</h5>
                            </div>
                           
                        </div>
                    </div>
                    <div class="card-body p-3 pt-4">

                        <div class="row mt-1">
                            <div class="col-12 col-md-4">
                                <label class="form-label text-bold">Maturity</label>
                                <div class="input-group input-group-dynamic" id="titleRow" style="margin-top: -5px !important">
                                    <input type="text" class="form-control" name="date_of_birth" id="date_of_birth" value="{{ $registry_neonatal->maturity }}">
                                </div>  
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label text-bold">Presentation Upon Delivery</label>
                                <div class="input-group input-group-dynamic" id="titleRow" style="margin-top: -5px !important">
                                    <input type="text" class="form-control" name="date_of_birth" id="date_of_birth" value="{{ $registry_neonatal->presentation_upon_delivery }}">
                                </div>  
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label text-bold">Manner of Delivery</label>
                                <div class="input-group input-group-dynamic" id="titleRow" style="margin-top: -5px !important">
                                    <input type="text" class="form-control" name="date_of_birth" id="date_of_birth" value="{{ $registry_neonatal->manner_of_delivery }}">
                                </div>  
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 col-md-4">
                                <label class="form-label text-bold">APGAR Score</label>
                                <div class="input-group input-group-dynamic" id="titleRow" style="margin-top: -5px !important">
                                    <input type="text" class="form-control" name="date_of_birth" id="date_of_birth" value="{{ $registry_neonatal->apgar_score }}">
                                </div>  
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label text-bold">EINC</label>
                                <div class="input-group input-group-dynamic" id="titleRow" style="margin-top: -5px !important">
                                    <input type="text" class="form-control" name="date_of_birth" id="date_of_birth" value="{{ $registry_neonatal->einc }}">
                                </div>  
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label text-bold">Incomplete EINC Steps</label>
                                <div class="input-group input-group-dynamic" id="titleRow" style="margin-top: -5px !important">
                                    <input type="text" class="form-control" name="date_of_birth" id="date_of_birth" value="{{ $registry_neonatal->incomplete_einc_steps }}">
                                </div>  
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 col-md-4">
                                <label class="form-label text-bold">No. of Fetuses</label>
                                <div class="input-group input-group-dynamic" id="titleRow" style="margin-top: -5px !important">
                                    <input type="text" class="form-control" name="date_of_birth" id="date_of_birth" value="{{ $registry_neonatal->no_of_fetuses }}">
                                </div>  
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label text-bold">Baby's COVID Status</label>
                                <div class="input-group input-group-dynamic" id="titleRow" style="margin-top: -5px !important">
                                    <input type="text" class="form-control" name="date_of_birth" id="date_of_birth" value="{{ $registry_neonatal->baby_covid_status }}">
                                </div>  
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label text-bold">Mother's COVID Status</label>
                                <div class="input-group input-group-dynamic" id="titleRow" style="margin-top: -5px !important">
                                    <input type="text" class="form-control" name="date_of_birth" id="date_of_birth" value="{{ $registry_neonatal->mother_covid_status }}">
                                </div>  
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 col-md-4">
                                <label class="form-label text-bold">Kangaroo Mother Care (KMC)</label>
                                <div class="input-group input-group-dynamic" id="titleRow" style="margin-top: -5px !important">
                                    <input type="text" class="form-control" name="date_of_birth" id="date_of_birth" value="{{ $registry_neonatal->kangaroo_mother_care }}">
                                </div>  
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label text-bold">Type of Feeding on Discharge</label>
                                <div class="input-group input-group-dynamic" id="titleRow" style="margin-top: -5px !important">
                                    <input type="text" class="form-control" name="date_of_birth" id="date_of_birth" value="{{ $registry_neonatal->type_feeding_discharge }}">
                                </div>  
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label text-bold">Use of Donor Human Milk</label>
                                <div class="input-group input-group-dynamic" id="titleRow" style="margin-top: -5px !important">
                                    <input type="text" class="form-control" name="date_of_birth" id="date_of_birth" value="{{ $registry_neonatal->use_donor_human_milk }}">
                                </div>  
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 col-md-4">
                                <label class="form-label text-bold">Highest Total Bilirubin level(mg/dl)</label>
                                <div class="input-group input-group-dynamic" id="titleRow" style="margin-top: -5px !important">
                                    <input type="text" class="form-control" name="date_of_birth" id="date_of_birth" value="{{ $registry_neonatal->highest_total_bilirubin }}">
                                </div>  
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label text-bold">Respiratory Support</label>
                                <div class="input-group input-group-dynamic" id="titleRow" style="margin-top: -5px !important">
                                    <input type="text" class="form-control" name="date_of_birth" id="date_of_birth" value="{{ $registry_neonatal->respiratory_support }}">
                                </div>  
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label text-bold">Discharge Outcome(Live/Dead)</label>
                                <div class="input-group input-group-dynamic" id="titleRow" style="margin-top: -5px !important">
                                    <input type="text" class="form-control" name="date_of_birth" id="date_of_birth" value="{{ $registry_neonatal->discharge_outcome }}">
                                </div>  
                            </div>
                        </div>

                        <ul class="list-group list-group-flush mt-4" data-toggle="checklist">
                            <li
                                class="list-group-item border-0 flex-column align-items-start ps-0 py-0 mb-3">
                                <div class="checklist-item checklist-item-danger ps-2 ms-3">
                                    <div class="d-flex align-items-center">
                                        
                                        <h6 class="mb-0 text-dark text-sm">ICD NO. 1</h6>
                                       
                                    </div>
                                    <div class="d-flex align-items-center ms-4 mt-3 ps-1">
                                        <div class="col-md-3 col-5">
                                            <p class="mb-0 text-secondary">ICD</p>
                                            <span class="text-md">{{ $registry_neonatal->icd_no_1 }}</span>
                                        </div>
                                        <div class="col-md-9 col-7">
                                            <p class="mb-0 text-secondary">Diagnosis: Number and Place of Birth</p>
                                            <span class="text-md">{{ $registry_neonatal->diagnosis1 }}</span>
                                        </div>
                                       
                                    </div>
                                </div>
                                <hr class="horizontal dark mt-4 mb-0">
                            </li>
                            <li
                                class="list-group-item border-0 flex-column align-items-start ps-0 py-0 mb-3">
                                <div class="checklist-item checklist-item-dark ps-2 ms-3">
                                    <div class="d-flex align-items-center">
                                        
                                        <h6 class="mb-0 text-dark text-sm">ICD NO. 2</h6>
                                       
                                    </div>
                                    <div class="d-flex align-items-center ms-4 mt-3 ps-1">
                                        <div class="col-md-3 col-5">
                                            <p class="mb-0 text-secondary">ICD</p>
                                            <span class="text-md">{{ $registry_neonatal->icd_no_2 }}</span>
                                        </div>
                                        <div class="col-md-9 col-7">
                                            <p class="mb-0 text-secondary">Diagnosis: Hyperbilirubinemia</p>
                                            <span class="text-md">{{ $registry_neonatal->diagnosis2 }}</span>
                                        </div>
                                       
                                    </div>
                                </div>
                                <hr class="horizontal dark mt-4 mb-0">
                            </li>
                            <li
                                class="list-group-item border-0 flex-column align-items-start ps-0 py-0 mb-3">
                                <div class="checklist-item checklist-item-warning ps-2 ms-3">
                                    <div class="d-flex align-items-center">
                                        
                                        <h6 class="mb-0 text-dark text-sm">ICD NO. 3</h6>
                                       
                                    </div>
                                    <div class="d-flex align-items-center ms-4 mt-3 ps-1">
                                        <div class="col-md-3 col-5">
                                            <p class="mb-0 text-secondary">ICD</p>
                                            <span class="text-md">{{ $registry_neonatal->icd_no_3 }}</span>
                                        </div>
                                        <div class="col-md-9 col-7">
                                            <p class="mb-0 text-secondary">Diagnosis: Respiratory</p>
                                            <span class="text-md">{{ $registry_neonatal->diagnosis2 }}</span>
                                        </div>
                                       
                                    </div>
                                </div>
                                <hr class="horizontal dark mt-4 mb-0">
                            </li>
                            <li
                            class="list-group-item border-0 flex-column align-items-start ps-0 py-0 mb-3">
                            <div class="checklist-item checklist-item-info ps-2 ms-3">
                                <div class="d-flex align-items-center">
                                    
                                    <h6 class="mb-0 text-dark text-sm">ICD NO. 4</h6>
                                   
                                </div>
                                <div class="d-flex align-items-center ms-4 mt-3 ps-1">
                                    <div class="col-md-3 col-5">
                                        <p class="mb-0 text-secondary">ICD</p>
                                        <span class="text-md">{{ $registry_neonatal->icd_no_4 }}</span>
                                    </div>
                                    <div class="col-md-9 col-7">
                                        <p class="mb-0 text-secondary">Diagnosis: Sepsis</p>
                                        <span class="text-md">{{ $registry_neonatal->diagnosis4 }}</span>
                                    </div>
                                   
                                </div>
                            </div>
                            <hr class="horizontal dark mt-4 mb-0">
                            </li>
                            <li
                            class="list-group-item border-0 flex-column align-items-start ps-0 py-0 mb-3">
                            <div class="checklist-item checklist-item-success ps-2 ms-3">
                                <div class="d-flex align-items-center">
                                    
                                    <h6 class="mb-0 text-dark text-sm">ICD NO. 5</h6>
                                   
                                </div>
                                <div class="d-flex align-items-center ms-4 mt-3 ps-1">
                                    <div class="col-md-3 col-5">
                                        <p class="mb-0 text-secondary">ICD</p>
                                        <span class="text-md">{{ $registry_neonatal->icd_no_5 }}</span>
                                    </div>
                                    <div class="col-md-9 col-7">
                                        <p class="mb-0 text-secondary">Diagnosis: Asphyxia</p>
                                        <span class="text-md">{{ $registry_neonatal->diagnosis5 }}</span>
                                    </div>
                                   
                                </div>
                            </div>
                            <hr class="horizontal dark mt-4 mb-0">
                            </li>
                            <li
                            class="list-group-item border-0 flex-column align-items-start ps-0 py-0 mb-3">
                            <div class="checklist-item checklist-item-danger ps-2 ms-3">
                                <div class="d-flex align-items-center">
                                    
                                    <h6 class="mb-0 text-dark text-sm">ICD NO. 6</h6>
                                   
                                </div>
                                <div class="d-flex align-items-center ms-4 mt-3 ps-1">
                                    <div class="col-md-3 col-5">
                                        <p class="mb-0 text-secondary">ICD</p>
                                        <span class="text-md">{{ $registry_neonatal->icd_no_6 }}</span>
                                    </div>
                                    <div class="col-md-9 col-7">
                                        <p class="mb-0 text-secondary">Diagnosis: Congenital Disease(s)</p>
                                        <span class="text-md">{{ $registry_neonatal->diagnosis6 }}</span>
                                    </div>
                                   
                                </div>
                            </div>
                            <hr class="horizontal dark mt-4 mb-0">
                            </li>
                            <li
                            class="list-group-item border-0 flex-column align-items-start ps-0 py-0 mb-3">
                            <div class="checklist-item checklist-item-warning ps-2 ms-3">
                                <div class="d-flex align-items-center">
                                    
                                    <h6 class="mb-0 text-dark text-sm">ICD NO. 7</h6>
                                   
                                </div>
                                <div class="d-flex align-items-center ms-4 mt-3 ps-1">
                                    <div class="col-md-3 col-5">
                                        <p class="mb-0 text-secondary">ICD</p>
                                        <span class="text-md">{{ $registry_neonatal->icd_no_7 }}</span>
                                    </div>
                                    <div class="col-md-9 col-7">
                                        <p class="mb-0 text-secondary">Diagnosis: Others</p>
                                        <span class="text-md">{{ $registry_neonatal->diagnosis7 }}</span>
                                    </div>
                                   
                                </div>
                            </div>
                            <hr class="horizontal dark mt-4 mb-0">
                            </li>
                            
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
    <link href="{{ asset('assets') }}/css/icd-neonatal.css" rel="stylesheet" />
  @push('js')
  <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>  
  <script src="{{ asset('assets') }}/js/icd-neonatal-view.js"></script>



    @endpush
  </x-page-template>
  