
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="patientICD" activeItem="admitted-upload" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="Ward Patient ICD"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->

      
      <div class="container-fluid py-4">
        <div class="loading" id="loading2" style="display: none !important"> 
            <img src="{{ asset('assets') }}/img/pps-logo.png" style="height: 60px !important; width: 60px !important" alt="img-blur-shadow" class="icons">
        </div>

        <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">
        <input type="hidden" value="{{ url('icd-admitted-upload-save') }}" id="urlICDAdmittedUpload">
        <input type="hidden" value="{{ url('icd-admitted-upload-check-exist') }}" id="urlICDAdmittedUploadCheckExist">
      
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 ">
                <div class="card mx-3 mx-md-4 ">
                    <div class="card-header p-3 pb-2 bg-danger">
                        <h5 class="font-weight-bolder mb-0 text-white">Ward Patient ICD Upload</h5>
                        <p class="mb-0 text-sm text-white">Please choose file and upload.</p>
                    </div>
                    <div class="card-body pt-4 p-3">
                        <div class="row mt-4">
                            <div class="col-12 ">

                                <div class="row">
                                    <div class="col-12 col-md-12">
                                        <label class="form-label text-bold">Month and Year</label>
                                        <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                            <input type="month" class="form-control" name="month_year_icd" id="month_year_icd" required>
                                        </div>  
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12 col-md-12">
                                        <label class="form-label text-bold">Patient Type</label>
                                        <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                            <input type="text" class="form-control" value="{{ $patient_type->category }}" name="patient_type_id" id="patient_type_id" readonly>
                                        </div>  
                                    </div>
                                </div>
                                <br>
                               
                                <form method="POST" class="form-control border dropzone" id="my-awesome-dropzone" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="fallback">
                                                <input name="file" type="file" required id="icd_admitted_file" />
                                            </div>
                                        </div>
                                    </div> 
                                </form>
            
                                <br>
            
                                <div class="row">
                                    <div class="col-12" style="text-align: right !important">
                                        <button class="btn btn-danger" type="button" id="uploadBtn" form="admittedForm">Upload</button>
                                        <a class="btn btn-warning" href="/icd-admitted-view" id="uploadBtn" form="admittedForm">Cancel</a>
                                    </div>
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
  <script src="{{ asset('assets') }}/js/plugins/dropzone.min.js"></script>
  <script src="{{ asset('assets') }}/js/icd-admitted.js"></script>
  <script src="{{ asset('assets') }}/js/select2.min.js"></script>
  <link href="{{ asset('assets') }}/css/select2.min.css" rel="stylesheet" />
  <link href="{{ asset('assets') }}/css/admitted-upload.css" rel="stylesheet" />

  {{-- <script>
     Dropzone.autoDiscover = false;
        var drop = document.getElementById('admittedForm')
        var myDropzone = new Dropzone(drop, {
            url: "/file/post",
            addRemoveLinks: true,
            maxFiles:1,
        });

 </script> --}}

    @endpush
  </x-page-template>
  