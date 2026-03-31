
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
                                            <!-- Image that will trigger the file input -->
                                            <img 
                                                src="{{ asset('assets') }}/img/edit-profile.jpg" 
                                                id="profile_picture" 
                                                class="img-fluid shadow border-radius-xl" 
                                                style="max-width: 100% !important; width: 200px !important; height: auto !important; cursor: pointer;" 
                                                alt="team-2" 
                                                onclick="document.getElementById('file-input-profile').click();">
                                            <br><br>
                                    
                                            <!-- Label for manually triggering file input (optional) -->
                                            <label for="file-input-profile" class="btn btn-danger">
                                                UPLOAD PROFILE PHOTO
                                            </label>
                                    
                                            <!-- Hidden file input -->
                                            <input 
                                                style="display:none;" 
                                                id="file-input-profile" 
                                                name="picture" 
                                                type="file" 
                                                accept="image/*" 
                                                onchange="document.getElementById('profile_picture').src = window.URL.createObjectURL(this.files[0])" 
                                            />
                                        </div>
                                    </div>
                                    

                                </div>
                                <hr class="horizontal gray-light my-2">
                                <div class="card-footer" style="text-align: center !important;">
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

        <form method="POST" id="member-info-update-form" role="form text-left" enctype="multipart/form-data" >
            @csrf

             {{-- Start of hidden input --}}
             <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">
             <input type="hidden" value="{{ url('member-info-update-submit') }}" id="urlMemberInfoUpdate">
             <input type="hidden" id="pps_no" name="pps_no" value="{{ $userInfo->pps_no }}">
             <input type="hidden" id="user_id" name="user_id" value="{{ $userInfo->id }}">
             <input type="hidden" id="infoids" name="infoids" value="{{ $userInfo->infoids }}">

             {{-- End of hidden input --}}


            <div class="row mb-4">
                <div class="col-lg-12 col-12">
                    <div class="card card-body" id="profile">
                        <div class="row">
                            <div class="col-md-9 col-12">
                                <div class="row">
                                    <div class="col-sm-auto col-4">
                                        <div class="avatar avatar-xl position-relative">
                                            @if ($userInfo->picture == null)
                                                <img src="{{ asset('assets') }}/img/edit-profile.jpg" alt="profile"
                                                     class="rounded-circle shadow-sm profile_picture mt-3" style="height: 100px !important; width: 100px !important;  margin-left: 15px !important">
                                            @else
                                                <img id="profile_picture" src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $userInfo->picture, now()->addMinutes(30))}}" alt="profile"
                                                     class="rounded-circle shadow-sm profile_picture mt-3"  style="height: 100px !important; width: 100px !important; margin-left: 15px !important">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-auto col-8 my-auto">
                                        <div class="h-100">
                                            <h5 class="mb-1 font-weight-bolder">
                                                {{ $userInfo->first_name }} {{ $userInfo->middle_name }} {{ $userInfo->last_name }} {{ $userInfo->suffix }}
                                            </h5>
                                            <p class="mb-0 font-weight-normal text-sm">
                                                {{ $userInfo->member_type_name }} @if($userInfo->chapter_name)/ {{ $userInfo->chapter_name }}@endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-12 text-center">
                                {!! QrCode::size(200)->generate(auth()->user()->pps_no) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-body mb-4">
                <h5>Basic Information</h5>
                <div class="row mt-3">
                    <div class="col-md-3 col-12">
                        <label class="form-label text-bold">First Name</label>
                        <input type="text" class="form-control member_required" name="first_name" value="{{ $userInfo->first_name }}">
                    </div>
                    <div class="col-md-3 col-12">
                        <label class="form-label text-bold">Middle Name</label>
                        <input type="text" class="form-control" name="middle_name" value="{{ $userInfo->middle_name }}">
                    </div>
                    <div class="col-md-3 col-12">
                        <label class="form-label text-bold">Last Name</label>
                        <input type="text" class="form-control member_required" name="last_name" value="{{ $userInfo->last_name }}">
                    </div>
                    <div class="col-md-3 col-12">
                        <label class="form-label text-bold">Suffix</label>
                        <input type="text" class="form-control" name="suffix" value="{{ $userInfo->suffix }}">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-3 col-12">
                        <label class="form-label text-bold">Birthdate</label>
                        <input type="date" class="form-control member_required" name="birthdate" value="{{ $userInfo->birthdate }}">
                    </div>
                    <div class="col-md-3 col-12">
                        <label class="form-label text-bold">Gender</label>
                        <select class="form-control member_required" name="gender">
                            <option value="">Select</option>
                            <option value="MALE" {{ $userInfo->gender == 'MALE' ? 'selected' : '' }}>Male</option>
                            <option value="FEMALE" {{ $userInfo->gender == 'FEMALE' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-12">
                        <label class="form-label text-bold">Email</label>
                        <input type="email" class="form-control member_required" name="email_address" value="{{ $userInfo->email_address }}">
                    </div>
                    <div class="col-md-3 col-12">
                        <label class="form-label text-bold">Mobile Number</label>
                        <input type="text" class="form-control member_required" name="mobile_number" value="{{ $userInfo->mobile_number }}">
                    </div>
                </div>
            </div>

            <div class="card card-body mb-4">
                <h5>Professional Information</h5>
                <div class="row mt-3">
                    <div class="col-md-3 col-12">
                        <label class="form-label text-bold">PRC Number</label>
                        <input type="text" class="form-control member_required" name="prc_number" value="{{ $userInfo->prc_number }}">
                    </div>
                    <div class="col-md-3 col-12">
                        <label class="form-label text-bold">PRC Registration Date</label>
                        <input type="date" class="form-control" name="prc_registration_dt" value="{{ $userInfo->prc_registration_dt }}">
                    </div>
                    <div class="col-md-3 col-12">
                        <label class="form-label text-bold">PRC Expiration Date</label>
                        <input type="date" class="form-control" name="prc_validity" value="{{ optional($userInfo->prc_validity)->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-3 col-12">
                        <label class="form-label text-bold">PMA Number</label>
                        <input type="text" class="form-control" name="pma_number" value="{{ $userInfo->pma_number }}">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4 col-12">
                        <label class="form-label text-bold">Chapter</label>
                        <select name="member_chapter" id="member_chapter" class="form-control member_chapter">
                            <option value="{{ $userInfo->member_chapter }}">{{ $userInfo->chapter_name }}</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-12">
                        <label class="form-label text-bold">TIN</label>
                        <input type="text" class="form-control member_required" id="tin_number" name="tin_number" value="{{ $userInfo->tin_number }}" inputmode="numeric" pattern="\\d{9,12}" minlength="9" maxlength="12">
                    </div>
                    <div class="col-md-4 col-12">
                        <label class="form-label text-bold">PPS Number</label>
                        <input type="text" class="form-control" value="{{ $userInfo->pps_no }}" disabled>
                    </div>
                </div>
            </div>

            <div class="card card-body mb-4">
                <h5>Address Information</h5>
                <div class="row mt-2">
                    <div class="col-lg-6 col-12">
                        <label class="form-label text-bold">Unit/House Number<code> <b>*</b></code></label>
                        <input type="text" value="{{ $userInfo->house_number }}" class="form-control member_required" id="house_number" name="house_number">
                    </div>
                    <div class="col-lg-6 col-12">
                        <label class="form-label text-bold">Street Name<code> <b>*</b></code></label>
                        <input type="text" value="{{ $userInfo->street_name }}" class="form-control member_required" id="street_name" name="street_name">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-lg-12 col-md-12 col-12">
                        <label class="form-label text-bold">Region<code> <b>*</b></code></label>
                        <select id="region" name="region_id" class="form-control member_required"></select>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-lg-12 col-md-12 col-12">
                        <label class="form-label text-bold">Province<code> <b>*</b></code></label>
                        <select id="province" name="province_id" class="form-control member_required"></select>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-lg-6 col-md-6 col-12">
                        <label class="form-label text-bold">City<code> <b>*</b></code></label>
                        <select id="city" name="city_id" class="form-control member_required"></select>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <label class="form-label text-bold">Barangay<code> <b>*</b></code></label>
                        <select id="barangay" name="barangay_id" class="form-control member_required"></select>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-lg-6 col-md-6 col-12">
                        <label class="form-label text-bold">Postal Code</label>
                        <input type="number" class="form-control" value="{{ $userInfo->postal_code }}" id="postal_code" name="postal_code">
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <label class="form-label text-bold">Country<code> <b>*</b></code></label>
                        <select id="country_name" name="country_name"  class="form-control member_required">
                            <option value="{{ $userInfo->country_name }}">{{ $userInfo->country_text ?? $userInfo->country_name }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 col-lg-12">
                    <button class="btn btn-danger btn-lg" type="submit">Update</button>
                </div>
            </div>

        </form>

        <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
    </div>
    </main>
    <x-plugins></x-plugins>
    <link href="{{ asset('assets') }}/css/loader.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/user-maintenance.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/user-maintenance.css" rel="stylesheet" />
  @push('js')

  <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
    <script>
        window.userRegion = { id: "{{ $userInfo->region_id ?? '' }}" };
        window.userProvince = { id: "{{ $userInfo->province_id ?? '' }}" };
        window.userCity = { id: "{{ $userInfo->city_id ?? '' }}" };
        window.userBarangay = { id: "{{ $userInfo->barangay_id ?? '' }}" };
    </script>

  <script src="{{ asset('assets') }}/js/member-update.js"></script>
  <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/choices.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
  <script src="{{ asset('assets') }}/js/select2.min.js"></script>
  <link href="{{ asset('assets') }}/css/select2.min.css" rel="stylesheet" />



    @endpush
  </x-page-template>
