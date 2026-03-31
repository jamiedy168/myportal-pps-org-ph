
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="ICD" activeItem="admin-admitted-view" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-auth.navbars.navs.auth pageTitle="Ward Patient ICD"></x-auth.navbars.navs.auth>
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
                            </p>
                            <h5 class="font-weight-normal mt-0">
                                {{ $registry_admitted->patient_initial }}
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
                                    <p class="mb-0 mt-0 text-sm"> {{Carbon\Carbon::parse($registry_admitted->created_at)->format('F d, Y')}}</p>
                                </div>
                                <div class="col-12 col-md-6">
                                    <p class="mb-0 text-xs text-bold">Uploaded By</p>
                                    <p class="mb-0 mt-0 text-sm"> {{ $registry_admitted->created_by }}</p>
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
                                        <input type="text" class="form-control" name="hosp_name" id="hosp_name" value="{{ $registry_admitted->hosp_name }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-6 col-md-4">
                                    <label class="form-label text-bold">Date of Birth</label>
                                    <div class="input-group input-group-dynamic" id="titleRow" style="margin-top: -5px !important">
                                        <input type="text" class="form-control" name="date_of_birth" id="date_of_birth" value="{{Carbon\Carbon::parse($registry_admitted->date_of_birth)->format('F d, Y')}}">
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label text-bold">Age</label>
                                    <div class="input-group input-group-dynamic" id="titleRow" style="margin-top: -5px !important">
                                        <input type="text" class="form-control text-center" name="age" id="age" value="{{ $registry_admitted->age() }}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-5">
                                    <label class="form-label text-bold">Gender</label>
                                    <div class="input-group input-group-dynamic" id="titleRow" style="margin-top: -5px !important">
                                        <input type="text" class="form-control" name="gender" id="gender" value="{{ $registry_admitted->gender }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12 col-md-3">
                                    <label class="form-label text-bold">Weight</label>
                                    <div class="input-group input-group-dynamic" id="titleRow" style="margin-top: -5px !important">
                                        <input type="text" class="form-control" name="weight" id="weight" value="{{ $registry_admitted->weight }}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label text-bold">Type of Patient</label>
                                    <div class="input-group input-group-dynamic" id="titleRow" style="margin-top: -5px !important">
                                        <input type="text" class="form-control" name="type_of_patient" id="type_of_patient" value="{{ $registry_admitted->type_of_patient }}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-5">
                                    <label class="form-label text-bold">Outcome</label>
                                    <div class="input-group input-group-dynamic" id="titleRow" style="margin-top: -5px !important">
                                        <input type="text" class="form-control" name="outcome" id="outcome" value="{{ $registry_admitted->outcome }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label text-bold">Date Admitted</label>
                                    <div class="input-group input-group-dynamic" id="titleRow" style="margin-top: -5px !important">
                                        <input type="text" class="form-control" name="weight" id="weight" value="{{Carbon\Carbon::parse($registry_admitted->date_admitted)->format('F d, Y')}}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label text-bold">Date Discharged</label>
                                    <div class="input-group input-group-dynamic" id="titleRow" style="margin-top: -5px !important">
                                        <input type="text" class="form-control" name="date_of_birth" id="date_of_birth" value="{{Carbon\Carbon::parse($registry_admitted->date_discharged)->format('F d, Y')}}">
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
                            <ul class="list-group list-group-flush" data-toggle="checklist">
                                <li
                                    class="list-group-item border-0 flex-column align-items-start ps-0 py-0 mb-3">
                                    <div class="checklist-item checklist-item-danger ps-2 ms-3">
                                        <div class="d-flex align-items-center">

                                            <h6 class="mb-0 text-dark text-sm">PRIMARY</h6>

                                        </div>
                                        <div class="d-flex align-items-center ms-4 mt-3 ps-1">
                                            <div class="col-md-3 col-5">
                                                <p class="mb-0 text-secondary">ICD</p>
                                                <span class="text-md">{{ $registry_admitted->icd_no }}</span>
                                            </div>
                                            <div class="col-md-9 col-7">
                                                <p class="mb-0 text-secondary">Diagnosis</p>
                                                <span class="text-md">{{ $registry_admitted->primary_diagnosis }}</span>
                                            </div>

                                        </div>
                                    </div>
                                    <hr class="horizontal dark mt-4 mb-0">
                                </li>
                                <li
                                    class="list-group-item border-0 flex-column align-items-start ps-0 py-0 mb-3">
                                    <div class="checklist-item checklist-item-dark ps-2 ms-3">
                                        <div class="d-flex align-items-center">

                                            <h6 class="mb-0 text-dark text-sm">SECONDARY</h6>

                                        </div>
                                        <div class="d-flex align-items-center ms-4 mt-3 ps-1">
                                            <div class="col-md-3 col-5">
                                                <p class="mb-0 text-secondary">ICD</p>
                                                <span class="text-md">{{ $registry_admitted->icd_no2 }}</span>
                                            </div>
                                            <div class="col-md-9 col-7">
                                                <p class="mb-0 text-secondary">Diagnosis</p>
                                                <span class="text-md">{{ $registry_admitted->secondary_diagnosis }}</span>
                                            </div>

                                        </div>
                                    </div>
                                    <hr class="horizontal dark mt-4 mb-0">
                                </li>
                                <li
                                    class="list-group-item border-0 flex-column align-items-start ps-0 py-0 mb-3">
                                    <div class="checklist-item checklist-item-warning ps-2 ms-3">
                                        <div class="d-flex align-items-center">

                                            <h6 class="mb-0 text-dark text-sm">TERTIARY</h6>

                                        </div>
                                        <div class="d-flex align-items-center ms-4 mt-3 ps-1">
                                            <div class="col-md-3 col-5">
                                                <p class="mb-0 text-secondary">ICD</p>
                                                <span class="text-md">{{ $registry_admitted->icd_no3 }}</span>
                                            </div>
                                            <div class="col-md-9 col-7">
                                                <p class="mb-0 text-secondary">Diagnosis</p>
                                                <span class="text-md">{{ $registry_admitted->tertiary_diagnosis }}</span>
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

