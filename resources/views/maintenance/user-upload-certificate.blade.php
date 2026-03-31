
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="" activeItem="" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="Events"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->
      <div class="container-fluid py-4">
      
        <div class="card">
            <div class="card-header bg-danger pb-0 px-3">
                <div class="row mb-2">
                    <div class="col-8">
                        <h6 class="mb-0 text-white">Upload Certificate</h6>
                    </div>
                    <div
                        class="col-4 d-flex justify-content-start justify-content-md-end" style="text-align: right !important">
                        <i class="material-icons me-2 text-xl text-white">shopping_cart</i>
                        
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" id="form_reclassification" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">
                    <input type="hidden" value="{{ url('user-maintenance-reclassification-save') }}" id="urlReclassificationSave">
                    @if ($member->member_type_name == 'RESIDENT/TRAINEES')
                        <div class="row mb-3" id="certificate_residency-row">
                            <div class="col-lg-1"></div>
                            <div class="col-lg-10 col-12">
                                <label class="form-label text-bold">
                                    CERTIFICATE OF RESIDENCY <code><b>(REQUIRED)</b></code>
                                </label>
                                <div class="form-group border border-radius-lg">
                                    <input id="file-input-residency" name="residency_certificate" type="file" accept="image/jpg, image/jpeg, image/png" onchange="previewResidencyCertificate(event)">
                                </div>
                                <div class="mt-3" style="text-align: center !important">
                                    <img id="preview-residency" src="" alt="Preview of uploaded certificate" class="img-fluid d-none border rounded" style="max-width: 100%; max-height: 400px;">
                                </div>
                            </div>
                            <div class="col-lg-1"></div>
                        </div>
                    @endif

                    @if ($member->member_type_name == 'GOVERNMENT_PHYSICIAN')
                        <div class="row mb-3" id="government-physician-row">
                            <div class="col-lg-1">

                            </div>
                            <div class="col-lg-10 col-12">
                                <label class="form-label text-bold">GOVERNMENT PHYSICIAN CERTIFICATE <code><b>(REQUIRED)</b></code></label>
                                <div class="form-group border border-radius-lg">
                                    <input id="file-input-government" name="government_physician_certificate" type="file" accept="image/jpg, image/jpeg, image/png"  onchange="previewGovernmentCertificate(event)">
                                </div>
                                <div class="mt-3" style="text-align: center !important">
                                    <img id="preview-government" src="" alt="Preview of uploaded certificate" class="img-fluid d-none border rounded" style="max-width: 100%; max-height: 400px;">
                                </div>
                            </div>
                            <div class="col-lg-1">

                            </div>
                        </div>
                    @endif

                    @if ($member->member_type_name == 'FELLOWS-IN-TRAINING')
                        <div class="row mb-3" id="fellows-in-training-row">
                            <div class="col-lg-1">

                            </div>
                            <div class="col-lg-10 col-12">
                                <label class="form-label text-bold">CERTIFICATE OF FELLOWSHIP TRAINING <code><b>(REQUIRED)</b></code></label>
                                <div class="form-group border border-radius-lg">
                                    <input id="file-input-fellows-in-training" name="fellows_in_training_certificate" type="file" accept="image/jpg, image/jpeg, image/png" onchange="previewFellowsTrainingCertificate(event)">
                                </div>
                                <div class="mt-3" style="text-align: center !important">
                                    <img id="preview-fellows-training" src="" alt="Preview of uploaded certificate" class="img-fluid d-none border rounded" style="max-width: 100%; max-height: 400px;">
                                </div>
                            </div>

                            <div class="col-lg-1">

                            </div>
                        </div>

                    @endif

                    <div class="row">
                        <div class="col-md-12 col-12" style="text-align: center !important">
                            <button type="submit" class="btn btn-danger">Save</button>
                            <a class="btn btn-warning" href="/dashboard">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <br>
      </div>
      <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
    </main>
    <x-plugins></x-plugins>
    <link href="{{ asset('assets') }}/css/loader.css" rel="stylesheet" />
    
  @push('js')
  <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
  <script src="{{ asset('assets') }}/js/user-maintenance-upload-certificate.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>
    @endpush
  </x-page-template>
  