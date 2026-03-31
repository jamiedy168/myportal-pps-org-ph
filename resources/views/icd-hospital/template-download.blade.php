
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="templateICD" activeItem="template-download" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="ICD Template"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->
      <div class="container-fluid py-4">
      

      
        <div class="card card-body mx-3 mx-md-4 ">
            <div class="row text-center mt-4">
                <div class="col-10 mx-auto">
                  <h5 class="font-weight-normal">Download Template</h5>
                  <p>Please choose a template below that you want to download.</p>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-sm-3 ms-auto text-center">
                  <input type="checkbox" class="btn-check" id="btncheck1">
                    <a href="{{ url('/icd-patient-template-download/others/patient_admitted_template.xlsx') }}">
                        <label class="btn btn-lg btn-outline-danger border-2 px-6 py-5" for="btncheck1">
                            <i class="far fa-file-excel"></i>
                    
                            </i>
                        </label>
                    </a>
                  <h6><a href="{{ url('/icd-patient-template-download/others/patient_admitted_template.xlsx') }}">Ward Patient</a></h6>
                </div>
                <div class="col-sm-3 me-auto text-center">
                  <input type="checkbox" class="btn-check" id="btncheck2">
                    <a href="{{ url('/icd-neonatal-template-download/others/neonatal_template.xlsx') }}">
                        <label class="btn btn-lg btn-outline-danger border-2 px-6 py-5" for="btncheck2">
                            <i class="far fa-file-excel"></i>
                
                            </i>
                        </label>
                    </a>
                  <h6><a href="{{ url('/icd-neonatal-template-download/others/neonatal_template.xlsx') }}">Neonatal</a></h6>
                </div>
                
              </div>
          
            <br>
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




    @endpush
  </x-page-template>
  