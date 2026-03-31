
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="maintenance" activeItem="user-maintenance" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="Edit User"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->

      <div class="loading" id="loading" style="display: none !important">
        <img src="{{ asset('assets') }}/img/pps-logo.png" style="height: 60px !important; width: 60px !important" alt="img-blur-shadow" class="icons">
      </div>

      <div class="container-fluid py-4">

        <!-- Start of update image Modal -->
        <div class="modal fade" id="modalUpdateImage" tabindex="-1" role="dialog" aria-labelledby="modalUpdateImage" aria-hidden="true">
            <div class="loading" id="loading2" style="display: none;">
                <img src="{{ asset('assets') }}/img/pps-logo.png" alt="img-blur-shadow" style="height: 60px !important; width: 60px !important" class="icons">
            </div>
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content"  style="background: #fff !important;">
                    <form method="POST" id="user-update-image" role="form text-left" enctype="multipart/form-data" >
                        @csrf
                        <div class="modal-body p-0">

                            <div class="card card-plain">
                                <div class="card-header ">
                                    <div class="row">
                                        <div class="col-11">
                                            <h5 class="text-gradient text-danger">Update Image</h5>
                                        </div>
                                        <div class="col-1">
                                            <button style="text-align: right !important" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                <span class="text-primary" aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" value="{{ url('user-maintenance-update-image') }}" id="urlUserMaintenanceUpdateImage">
                                   <div class="row mt-2">
                                    <div class="col-lg-12 col-md-12 col-12 text-center">

                                        <img src="{{ asset('assets') }}/img/placeholder.jpg" id="profile_picture" class="img-fluid shadow border-radius-xl" style="max-width: 100% !important; width: 200px !important; height: auto !important; "  alt="team-2" >

                                      <br>
                                      <br>
                                      <label for="file-input-profile" class="btn btn-danger">
                                        UPLOAD PROFILE PHOTO
                                      </label>
                                      <input style="display:none;" id="file-input-profile" name="picture" type="file" accept="image/*" onchange="document.getElementById('profile_picture').src = window.URL.createObjectURL(this.files[0])" />
                                    </div>
                                   </div>

                                </div>
                                <hr class="horizontal gray-light my-2">
                                <div class="card-footer">
                                    <button class="btn btn-danger" type="submit">
                                        UPDATE
                                    </button>
                                    <button class="btn btn-block btn-light" data-bs-dismiss="modal">
                                        CANCEL
                                    </button>
                                </div>

                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        {{-- End of Receipt Modal --}}



        <form method="POST" id="user-maintenance-update" role="form text-left" enctype="multipart/form-data" >
            @csrf

             {{-- Start of hidden input --}}
             <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">
             <input type="hidden" value="{{ url('user-maintenance-update') }}" id="urlUserMaintenanceUpdate">
             <input type="hidden" value="{{ url('user-maintenance-update-image') }}" id="urlUserMaintenanceUpdateImage">
             <input type="hidden" id="pps_no" name="pps_no" value="{{ $userInfo->pps_no }}">
             <input type="hidden" id="user_id" name="user_id" value="{{ $userInfo->id }}">
             {{-- End of hidden input --}}


            <div class="row mb-2">
                <div class="col-lg-12 col-12">
                    <div class="card card-body" id="profile">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-sm-auto col-4">
                                <div class="avatar avatar-xl position-relative">
                                    @if ($userInfo->picture == null)
                                        <img src="{{ asset('assets') }}/img/pps-logo.png" alt="profile"
                                        class="w-100 rounded-circle shadow-sm">
                                        <label for="file-input" data-bs-toggle="modal" data-bs-target="#modalUpdateImage"
                                        class="btn btn-sm btn-icon-only bg-gradient-light position-absolute bottom-0 end-0 mb-n2 me-n2">
                                        <i class="fa fa-pen top-0" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="" aria-hidden="true" data-bs-original-title="Update Image"
                                            aria-label="Update Image"></i><span class="sr-only">Update Image</span>
                                    </label>
                                    @else
                                        <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $userInfo->picture, now()->addMinutes(30))}}" alt="profile"
                                        class="w-100 rounded-circle shadow-sm">
                                        <label for="file-input" data-bs-toggle="modal" data-bs-target="#modalUpdateImage"
                                        class="btn btn-sm btn-icon-only bg-gradient-light position-absolute bottom-0 end-0 mb-n2 me-n2">
                                        <i class="fa fa-pen top-0" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="" aria-hidden="true" data-bs-original-title="Update Image"
                                            aria-label="Edit Image"></i><span class="sr-only">Update Image</span>
                                    </label>
                                    @endif

                                </div>
                            </div>
                            <div class="col-sm-auto col-8 my-auto">
                                <div class="h-100">
                                    <h5 class="mb-1 font-weight-bolder">
                                        @if ($userInfo->first_name == null)
                                            {{ $userInfo->name }}
                                        @else
                                            {{ $userInfo->first_name }} {{ $userInfo->middle_name }} {{ $userInfo->last_name }}
                                        @endif

                                    </h5>
                                    <p class="mb-0 font-weight-normal text-sm">
                                        {{ $userInfo->member_type_name }} / {{ $userInfo->description }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-auto ms-sm-auto mt-sm-0 mt-3 d-flex">

                            </div>
                        </div>
                        <hr>
                        <div class="row mt-3">
                            <div class="col-12 col-lg-12">
                                <h5>Basic Information</h5>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-lg-3 col-3">
                                <label class="form-label text-bold">First Name</label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                <input type="text" class="form-control" name="first_name" id="first_name" value="{{ $userInfo->first_name }}">
                            </div>

                            </div>
                            <div class="col-lg-3 col-3">
                                <label class="form-label text-bold">Middle Name</label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                <input type="text" class="form-control" name="middle_name" id="middle_name" value="{{ $userInfo->middle_name }}">
                            </div>

                            </div>
                            <div class="col-lg-3 col-3">
                                <label class="form-label text-bold">Last Name</label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                <input type="text" class="form-control" name="last_name" id="last_name" value="{{ $userInfo->last_name }}">
                            </div>

                            </div>
                            <div class="col-lg-3 col-3">
                                <label class="form-label text-bold">Suffix</label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                <input type="text" class="form-control" name="suffix" id="suffix" value="{{ $userInfo->suffix }}">
                            </div>

                            </div>
                        </div>

                        <div class="row mt-1">
                            <div class="col-lg-3 col-6">
                                <label class="form-label text-bold">Birthdate</label>
                                <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                    <input type="date" class="form-control" name="birthdate" id="birthdate" value="{{ \Carbon\Carbon::parse($userInfo->birthdate)->format('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <label class="form-label text-bold">Gender</label>
                                <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                    <select name="gender" id="gender" class="form-control gender">
                                        <option value="">-- SELECT --</option>
                                        <option value="MALE" {{ $userInfo->gender == 'MALE' ? 'selected' : '' }}>MALE</option>
                                        <option value="FEMALE" {{ $userInfo->gender == 'FEMALE' ? 'selected' : '' }}>FEMALE</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12 col-lg-12">
                                <h5>Contact Information</h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-5 col-4">
                                <label class="form-label text-bold">Telephone Number</label>
                                <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                    <input type="number" class="form-control" name="telephone_number" id="telephone_number" value="{{ $userInfo->telephone_number }}">
                                </div>
                            </div>
                            <div class="col-lg-2 col-4">
                                <label class="form-label text-bold">Country Code</label>
                                <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                    <select name="country_code" id="country_code" class="form-control country_code">
                                        <option value="+63" {{ $userInfo->country_code == '+63' ? 'selected' : '' }}>+63</option>
                                        <option value="OTHERS" {{ $userInfo->country_code == 'OTHERS' ? 'selected' : '' }}>OTHERS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-5 col-4">
                                <label class="form-label text-bold">Mobile Number</label>
                                <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                    <input type="number" class="form-control" name="mobile_number" id="mobile_number" value="{{ $userInfo->mobile_number }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-5 col-5">
                                <label class="form-label text-bold">Email Address</label>
                                <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                    <input type="email" class="form-control" name="email_address" id="email_address" value="{{ $userInfo->email_address }}">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12 col-lg-12">
                                <h5>PRC/Document Information</h5>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-lg-4 col-4">
                                <label class="form-label text-bold">PRC Number</label>
                                <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                    <input type="number" class="form-control" name="prc_number" id="prc_number" value="{{ $userInfo->prc_number }}">
                                </div>
                            </div>
                            <div class="col-lg-4 col-4">
                                <label class="form-label text-bold">PRC Registration Date</label>
                                <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                    <input type="date" class="form-control" name="prc_registration_dt" id="prc_registration_dt" value="{{ \Carbon\Carbon::parse($userInfo->prc_registration_dt)->format('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-lg-4 col-4">
                                <label class="form-label text-bold">PRC Expiration Date</label>
                                <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                    <input type="date" class="form-control" name="prc_validity" id="prc_validity" value="{{ \Carbon\Carbon::parse($userInfo->prc_validity)->format('Y-m-d') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-4 col-12">
                                <label class="form-label text-bold">PMA Number</label>
                                <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                    <input type="text" class="form-control" name="pma_number" id="pma_number" value="{{ $userInfo->pma_number }}">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-lg-4 col-4">
                                <label class="form-label text-bold">Chapter</label>
                                <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                    <select name="member_chapter" id="member_chapter" class="form-control member_chapter" style="text-align: center !important">
                                            <option value="">Choose</option>
                                        @foreach ($chapter as $chapter2)
                                            <option value="{{ $chapter2->id }}" {{ ( $chapter2->id == $userInfo->member_chapter) ? 'selected' : '' }}>{{ $chapter2->chapter_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="col-lg-4 col-4">
                                <label class="form-label text-bold">Member Type</label>
                                <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                    <select name="member_type" id="member_type" class="form-control member_type" style="text-align: center !important">
                                            <option value="">Choose</option>
                                        @foreach ($type as $type2)
                                            <option value="{{ $type2->id }}" {{ ( $type2->id == $userInfo->member_type) ? 'selected' : '' }}>{{ $type2->member_type_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="col-lg-4 col-4">
                                <label class="form-label text-bold">Classification</label>
                                <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                    <select name="member_classification" id="member_classification" class="form-control classification" style="text-align: center !important">
                                        <option value="">Choose</option>
                                        @foreach ($classification as $classification2)
                                            <option value="{{ $classification2->id }}" {{ ( $classification2->id == $userInfo->member_classification_id) ? 'selected' : '' }}>{{ $classification2->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="fellowintraining" id="fellowintraining" {{ $userInfo->is_fellows_in_training ? 'checked' : '' }}>
                                    <label class="custom-control-label form-label text-bold" for="fellowintraining">Is Fellows-in-training?</label>
                                </div>
                            </div>
                        </div>
                        

                        <div class="row mt-4">
                            <div class="col-12 col-lg-12">
                                <h5>Access Information</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-4">
                                <label class="form-label text-bold">Role</label>
                                <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                    <select name="roles" id="roles" class="form-control roles" style="text-align: center !important">
                                        <option value="">Choose</option>
                                        @foreach ($role as $role2)
                                            <option value="{{ $role2->id }}" {{ ( $role2->id == $userInfo->role_id) ? 'selected' : '' }}>{{ $role2->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-4">
                                <label class="form-label text-bold">Status</label>
                                <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                    <select name="is_active" id="is_active" class="form-control is_active" style="text-align: center !important">
                                        <option value="true" {{ $userInfo->is_active == true ? 'selected' : '' }}>ACTIVE</option>
                                        <option value="false" {{ $userInfo->is_active == false ? 'selected' : '' }}>INACTIVE</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 col-lg-12">
                            <button class="btn btn-danger" type="submit">SAVE</button>
                            <a class="btn btn-warning" href="/user-maintenance">Return</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
    </div>
    </main>
    <x-plugins></x-plugins>
    <link href="{{ asset('assets') }}/css/loader.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/user-maintenance.css" rel="stylesheet" />
  @push('js')

  <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('assets') }}/js/user-maintenance.js"></script>
  <script src="{{ asset('assets') }}/js/user-maintenance-data-table.js"></script>
  <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/datatables.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/choices.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/datatables.js"></script>
  <script src="{{ asset('assets') }}/js/select2.min.js"></script>
  <link href="{{ asset('assets') }}/css/select2.min.css" rel="stylesheet" />


    @endpush
  </x-page-template>
