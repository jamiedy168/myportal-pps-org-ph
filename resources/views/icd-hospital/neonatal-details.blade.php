
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="neonatalICD" activeItem="neonatal-view" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="Neonatal ICD"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->
      <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Patient Details</h5>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-6">
                                <div class="input-group input-group-static">
                                    <label>Patient Initial</label>
                                    <input type="text" class="form-control" value="{{ $neontal_info->patient_initial }}" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group input-group-static">
                                    <label>Gender</label>
                                    <input type="text" class="form-control" value="{{ $neontal_info->gender }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-6 col-md-3">
                                <div class="input-group input-group-static">
                                    <label>Gestational Age(weeks)</label>
                                    <input type="text" class="form-control text-center" value="{{ $neontal_info->gestational_age }}" readonly>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="input-group input-group-static">
                                    <label>Birth Weight</label>
                                    <input type="text" class="form-control text-center" value="{{ $neontal_info->birth_weight }}" readonly>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="input-group input-group-static">
                                    <label>Weight/Gestational Age</label>
                                    <input type="text" class="form-control text-center" value="{{ $neontal_info->weight_gestational_age }}" readonly>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="input-group input-group-static">
                                    <label>Patient Birth Location</label>
                                    <input type="text" class="form-control" value="{{ $neontal_info->patient_birth_location }}" readonly>
                                </div>
                            </div>
                            
                        </div>

                        <div class="row mt-4">
                            <div class="col-6 col-md-6">
                                <div class="input-group input-group-static">
                                    <label>Date of Admission</label>
                                    <input type="text" class="form-control text-center" value="{{Carbon\Carbon::parse($neontal_info->date_of_admission)->format('Y-m-d')}}" readonly>
                                </div>
                            </div>
                            <div class="col-6 col-md-6">
                                <div class="input-group input-group-static">
                                    <label>Date Discharged</label>
                                    <input type="text" class="form-control text-center" value="{{Carbon\Carbon::parse($neontal_info->date_discharged)->format('Y-m-d')}}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-12">
                                <h5>ICD/Diagnosis Details</h5>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-6 col-md-4">
                                <div class="input-group input-group-static">
                                    <label>Maturity</label>
                                    <input type="text" class="form-control" value="{{ $neontal_info->maturity }}" readonly>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="input-group input-group-static">
                                    <label>Presentation Upon Delivery</label>
                                    <input type="text" class="form-control" value="{{ $neontal_info->presentation_upon_delivery }}" readonly>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="input-group input-group-static">
                                    <label>Manner of Delivery</label>
                                    <input type="text" class="form-control" value="{{ $neontal_info->manner_of_delivery }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-6 col-md-4">
                                <div class="input-group input-group-static">
                                    <label>APGAR Score</label>
                                    <input type="text" class="form-control text-center" value="{{ $neontal_info->apgar_score }}" readonly>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="input-group input-group-static">
                                    <label>EINC</label>
                                    <input type="text" class="form-control" value="{{ $neontal_info->einc }}" readonly>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="input-group input-group-static">
                                    <label>Incomplete EINC Steps</label>
                                    <input type="text" class="form-control" value="{{ $neontal_info->incomplete_einc_steps }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-6 col-md-4">
                                <div class="input-group input-group-static">
                                    <label>No. of Fetuses</label>
                                    <input type="text" class="form-control text-center" value="{{ $neontal_info->no_of_fetuses }}" readonly>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="input-group input-group-static">
                                    <label>Baby's COVID Status</label>
                                    <input type="text" class="form-control" value="{{ $neontal_info->baby_covid_status }}" readonly>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="input-group input-group-static">
                                    <label>Mother's COVID Status</label>
                                    <input type="text" class="form-control" value="{{ $neontal_info->mother_covid_status }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-6 col-md-4">
                                <div class="input-group input-group-static">
                                    <label>Kangaroo Mother Care (KMC)</label>
                                    <input type="text" class="form-control text-center" value="{{ $neontal_info->no_of_fetuses }}" readonly>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="input-group input-group-static">
                                    <label>Type of Feeding on Discharge</label>
                                    <input type="text" class="form-control" value="{{ $neontal_info->type_feeding_discharge }}" readonly>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="input-group input-group-static">
                                    <label>Use of Donor Human Milk</label>
                                    <input type="text" class="form-control" value="{{ $neontal_info->use_donor_human_milk }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-6 col-md-4">
                                <div class="input-group input-group-static">
                                    <label>Highest Total Bilirubin level(mg/dl)</label>
                                    <input type="text" class="form-control" value="{{ $neontal_info->highest_total_bilirubin }}" readonly>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="input-group input-group-static">
                                    <label>Respiratory Support</label>
                                    <input type="text" class="form-control" value="{{ $neontal_info->respiratory_support }}" readonly>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="input-group input-group-static">
                                    <label>Discharge Outcome(Live/Dead)</label>
                                    <input type="text" class="form-control" value="{{ $neontal_info->discharge_outcome }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12 col-md-12">
                                <div class="input-group input-group-static">
                                    <label>Hospital</label>
                                    <input type="text" class="form-control" value="{{ $neontal_info->hosp_name }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-4 col-md-3">
                                <div class="input-group input-group-static">
                                    <label class="text-bold text-danger">ICD No. 1</label>
                                    <input type="text" class="form-control text-center" value="{{ $neontal_info->icd_no_1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-8 col-md-9">
                                <div class="input-group input-group-static">
                                    <label class="text-bold text-danger">Diagnosis 1: Number and Place of Birth</label>
                                    <input type="text" class="form-control" value="{{ $neontal_info->diagnosis1 }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-4 col-md-3">
                                <div class="input-group input-group-static">
                                    <label class="text-bold text-danger">ICD No. 2</label>
                                    <input type="text" class="form-control text-center" value="{{ $neontal_info->icd_no_2 }}" readonly>
                                </div>
                            </div>
                            <div class="col-8 col-md-9">
                                <div class="input-group input-group-static">
                                    <label class="text-bold text-danger">Diagnosis 2: Hyperbilirubinemia</label>
                                    <input type="text" class="form-control" value="{{ $neontal_info->diagnosis2 }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-4 col-md-3">
                                <div class="input-group input-group-static">
                                    <label class="text-bold text-danger">ICD No. 3</label>
                                    <input type="text" class="form-control text-center" value="{{ $neontal_info->icd_no_3 }}" readonly>
                                </div>
                            </div>
                            <div class="col-8 col-md-9">
                                <div class="input-group input-group-static">
                                    <label class="text-bold text-danger">Diagnosis 3: Respiratory</label>
                                    <input type="text" class="form-control" value="{{ $neontal_info->diagnosis3 }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-4 col-md-3">
                                <div class="input-group input-group-static">
                                    <label class="text-bold text-danger">ICD No. 4</label>
                                    <input type="text" class="form-control text-center" value="{{ $neontal_info->icd_no_4 }}" readonly>
                                </div>
                            </div>
                            <div class="col-8 col-md-9">
                                <div class="input-group input-group-static">
                                    <label class="text-bold text-danger">Diagnosis 4: Sepsis</label>
                                    <input type="text" class="form-control" value="{{ $neontal_info->diagnosis4 }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-4 col-md-3">
                                <div class="input-group input-group-static">
                                    <label class="text-bold text-danger">ICD No. 5</label>
                                    <input type="text" class="form-control text-center" value="{{ $neontal_info->icd_no_5 }}" readonly>
                                </div>
                            </div>
                            <div class="col-8 col-md-9">
                                <div class="input-group input-group-static">
                                    <label class="text-bold text-danger">Diagnosis 5: Asphyxia</label>
                                    <input type="text" class="form-control" value="{{ $neontal_info->diagnosis5 }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-4 col-md-3">
                                <div class="input-group input-group-static">
                                    <label class="text-bold text-danger">ICD No. 6</label>
                                    <input type="text" class="form-control text-center" value="{{ $neontal_info->icd_no_6 }}" readonly>
                                </div>
                            </div>
                            <div class="col-8 col-md-9">
                                <div class="input-group input-group-static">
                                    <label class="text-bold text-danger">Diagnosis 6: Congenital Disease(s)</label>
                                    <input type="text" class="form-control" value="{{ $neontal_info->diagnosis6 }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-4 col-md-3">
                                <div class="input-group input-group-static">
                                    <label class="text-bold text-danger">ICD No. 7</label>
                                    <input type="text" class="form-control text-center" value="{{ $neontal_info->icd_no_7 }}" readonly>
                                </div>
                            </div>
                            <div class="col-8 col-md-9">
                                <div class="input-group input-group-static">
                                    <label class="text-bold text-danger">Diagnosis 7: Others</label>
                                    <input type="text" class="form-control" value="{{ $neontal_info->diagnosis7 }}" readonly>
                                </div>
                            </div>
                        </div>


                        <br>
                        <br>
                        <hr>

                        <div class="row mt-2">
                            <div class="col-6 col-md-4">
                                <div class="input-group input-group-static">
                                    <label><b>Date Uploaded:</b> {{Carbon\Carbon::parse($neontal_info->created_at)->format('F d, Y - h:i a')}}</label>
                                    
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="input-group input-group-static">
                                    <label><b>Uploaded By:</b> {{ $neontal_info->created_by }}</label>
                                    
                                </div>
                            </div>
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
  @push('js')
  <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>  
  <script src="{{ asset('assets') }}/js/icd-admitted.js"></script>



    @endpush
  </x-page-template>
  