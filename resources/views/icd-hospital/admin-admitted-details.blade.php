
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="ICD" activeItem="admin-admitted-view" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="Patient ICD"></x-auth.navbars.navs.auth>
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
                                    <input type="text" class="form-control" value="{{ $patient_info->patient_initial }}" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group input-group-static">
                                    <label>Type of Patient</label>
                                    <input type="text" class="form-control" value="{{ $patient_info->type_of_patient }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-6 col-md-6">
                                <div class="input-group input-group-static">
                                    <label>Gender</label>
                                    <input type="text" class="form-control" value="{{ $patient_info->gender }}" readonly>
                                </div>
                            </div>
                            <div class="col-6 col-md-6">
                                <div class="input-group input-group-static">
                                    <label>Date of Birth</label>
                                    <input type="text" class="form-control" value="{{Carbon\Carbon::parse($patient_info->date_of_birth)->format('Y-m-d')}}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-6 col-md-4">
                                <div class="input-group input-group-static">
                                    <label>Date Admitted</label>
                                    <input type="text" class="form-control" value="{{Carbon\Carbon::parse($patient_info->date_admitted)->format('Y-m-d')}}" readonly>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="input-group input-group-static">
                                    <label>Date Discharged</label>
                                    <input type="text" class="form-control" value="{{Carbon\Carbon::parse($patient_info->date_discharged)->format('Y-m-d')}}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="input-group input-group-static">
                                    <label>Outcome</label>
                                    <input type="text" class="form-control" value="{{ $patient_info->outcome }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-12">
                                <h5>ICD/Diagnosis Details</h5>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-12 col-md-12">
                                <div class="input-group input-group-static">
                                    <label>Hospital</label>
                                    <input type="text" class="form-control" value="{{ $patient_info->hosp_name }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-4 col-md-3">
                                <div class="input-group input-group-static">
                                    <label class="text-bold text-danger">ICD No.</label>
                                    <input type="text" class="form-control text-center" value="{{ $patient_info->icd_no }}" readonly>
                                </div>
                            </div>
                            <div class="col-8 col-md-9">
                                <div class="input-group input-group-static">
                                    <label class="text-bold text-danger">Primary Diagnosis</label>
                                    <input type="text" class="form-control" value="{{ $patient_info->primary_diagnosis }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-4 col-md-3">
                                <div class="input-group input-group-static">
                                    <label class="text-bold text-danger">ICD No.</label>
                                    <input type="text" class="form-control text-center" value="{{ $patient_info->icd_no2 }}" readonly>
                                </div>
                            </div>
                            <div class="col-8 col-md-9">
                                <div class="input-group input-group-static">
                                    <label class="text-bold text-danger">Secondary Diagnosis</label>
                                    <input type="text" class="form-control" value="{{ $patient_info->secondary_diagnosis }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-4 col-md-3">
                                <div class="input-group input-group-static">
                                    <label class="text-bold text-danger">ICD No.</label>
                                    <input type="text" class="form-control text-center" value="{{ $patient_info->icd_no3 }}" readonly>
                                </div>
                            </div>
                            <div class="col-8 col-md-9">
                                <div class="input-group input-group-static">
                                    <label class="text-bold text-danger">Tertiary Diagnosis</label>
                                    <input type="text" class="form-control" value="{{ $patient_info->tertiary_diagnosis }}" readonly>
                                </div>
                            </div>
                        </div>

                        <br>
                        <br>
                        <hr>

                        <div class="row mt-2">
                            <div class="col-6 col-md-4">
                                <div class="input-group input-group-static">
                                    <label><b>Date Uploaded:</b> {{Carbon\Carbon::parse($patient_info->created_at)->format('F d, Y - h:i a')}}</label>
                                    
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="input-group input-group-static">
                                    <label><b>Uploaded By:</b> {{ $patient_info->created_by }}</label>
                                    
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
  