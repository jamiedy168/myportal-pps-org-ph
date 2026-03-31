
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <style>
        .select2-container .select2-selection--single {
            height: 44px !important;   /* Bootstrap 5 input height */
            line-height: 42 px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 42px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px !important;
        }

    </style>
    <x-auth.navbars.sidebar activePage="members" activeItem="listing" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="Listing"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->

      <div class="container-fluid px-2 px-md-4">

        <div class="card card-body mx-3 mx-md-4 mt-3">
            <div class="row gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="{{ asset('assets') }}/img/pps-logo.png" alt="profile_image"
                            class="w-100 border-radius-lg shadow-sm">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            Philippine Pediatric Society
                        </h5>
                        <p class="mb-0 font-weight-normal text-sm">
                            Please fill-up your information below.
                        </p>
                    </div>
                </div>
            </div>
            <form action="" method="POST" id="updateNewMemberInfoForm">
                <input type="hidden" id="token" value="{{ csrf_token() }}">
                <input type="hidden" id="member_type_id" value="{{ $member->mem_type_id }}">
                <input type="hidden" value="{{ url('update-member-new-info-submit')}}" id="urlUpdateNewInfoUrl">
                <div class="row mt-2">
                <div class="col-lg-12 col-12">
                    <label class="form-label text-bold">
                    Taxpayer Identification Number (TIN) <code><b>*</b></code>
                    </label>
                    <div class="input-group input-group-outline" style="margin-top: -5px !important">
                    <input 
                        type="text" 
                        class="form-control member_required" 
                        id="tin_number" 
                        name="tin_number" 
                        inputmode="numeric" 
                        pattern="\d{9,12}" 
                        minlength="9" 
                        maxlength="12" 
                        placeholder="Enter 9–12 digit TIN, numbers only" 
                        oninput="this.value = this.value.replace(/[^0-9]/g, ''); this.setCustomValidity('');"
                        required
                        oninvalid="this.setCustomValidity('TIN must be 9 to 12 digits and contain numbers only.')"
                        />
                    </div>
                </div>
                </div>



                <div class="row mt-2">
                    <div class="col-lg-6 col-12">
                        <label class="form-label text-bold">Unit/House Number<code> <b>*</b></code></label>
                        <div class="input-group input-group-outline" style="margin-top: -5px !important">
                            <input type="text" class="form-control member_required" id="house_number" name="house_number">
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <label class="form-label text-bold">Street Name<code> <b>*</b></code></label>
                        <div class="input-group input-group-outline" style="margin-top: -5px !important">
                            <input type="text" class="form-control member_required" id="street_name" name="street_name"> 
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-lg-12 col-md-12 col-12">
                        <label class="form-label text-bold">Region<code> <b>*</b></code></label>
                        <div class="input-group input-group-outline" style="margin-top: -5px !important">
                        <select id="region" name="region_id" class="form-control member_required"></select>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-lg-12 col-md-12 col-12">
                        <label class="form-label text-bold">Province<code> <b>*</b></code></label>
                        <div class="input-group input-group-outline" style="margin-top: -5px !important">
                        <select id="province" name="province_id" class="form-control member_required"></select>
                        </div>
                    </div>
                </div>
            
                <div class="row mt-2">
                <div class="col-lg-6 col-md-6 col-12">
                        <label class="form-label text-bold">City<code> <b>*</b></code></label>
                        <div class="input-group input-group-outline" style="margin-top: -5px !important">
                        <select id="city" name="city_id" class="form-control member_required"></select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <label class="form-label text-bold">Barangay<code> <b>*</b></code></label>
                        <div class="input-group input-group-outline" style="margin-top: -5px !important">
                        <select id="barangay" name="barangay_id" class="form-control member_required"></select>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                <div class="col-lg-6 col-md-6 col-12">
                        <label class="form-label text-bold">Postal Code</label>
                        <div class="input-group input-group-outline" style="margin-top: -5px !important">
                        <input type="number" class="form-control" id="postal_code" name="postal_code">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <label class="form-label text-bold">Country<code> <b>*</b></code></label>
                        <div class="input-group input-group-outline" style="margin-top: -5px !important">
                        <select id="country_name" name="country_name" class="form-control member_required">
                                <option></option>
                        </select>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <button class="btn btn-success" type="submit">Update</button>
                    </div>
                </div>
            </form>
           
        </div>
      </div>
        <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
 
    </main>
    <x-plugins></x-plugins>
    <link href="{{ asset('assets') }}/css/loader.css" rel="stylesheet" />
  @push('js')
  <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('assets') }}/js/member-datatable.js"></script>
  <script src="{{ asset('assets') }}/js/member.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/datatables.js"></script>
  <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>
    <script src="{{ asset('assets') }}/js/select2.min.js"></script>
  <link href="{{ asset('assets') }}/css/select2.min.css" rel="stylesheet" />
  <script>
    


  </script>

    @endpush
  </x-page-template>
  