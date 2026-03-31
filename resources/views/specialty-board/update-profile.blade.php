
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="specialtyBoard" activeItem="specialty-board-view" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="Specialty Board"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->

      <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                  <div class="card-header p-3 pb-2 bg-danger">
                    <h5 class="font-weight-bolder mb-0 text-white">Update Profile</h5>
                    <p class="mb-0 text-sm text-white">Please fill-up information below</p>
                  </div>
                    <div class="card-body">
                       <form method="POST" role="form text-left" id="update-profile" enctype="multipart/form-data">
                        @csrf
                        {{-- Start of hidden input --}}
                          <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">
                          <input type="hidden" value="{{ url('specialty-board-update-submit') }}" id="urlSpecialtyBoardUpdate">
                          <input type="hidden" value="{{ $cpdpointsum }}" id="cpdpointsum">
                          
                          {{-- End of hidden input --}}
                       

                        <div class="row mt-2">
                          <div class="col-md-12">
                              <h5>Personal Information</h5>
                          </div>
                        </div>

                        <input type="hidden" value="{{ $member_info->member_type_name }}">

                        <div class="row">
                          <div class="col-md-3 col-12">
                            <label class="form-label text-bold">First Name<code> <b>*</b></code></label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <input type="text" class="form-control" placeholder="Enter First Name" name="first_name" id="first_name" value="{{ $member_info->first_name }}">
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The first name field is required. </p>
                          </div>
                          <div class="col-md-3 col-12">
                            <label class="form-label text-bold">Middle Name</label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <input type="text" class="form-control" placeholder="Enter Middle Name" name="middle_name" id="middle_name" value="{{ $member_info->middle_name }}">
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The middle name field is required. </p>
                          </div>
                          <div class="col-md-3 col-12">
                            <label class="form-label text-bold">Last Name<code> <b>*</b></code></label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <input type="text" class="form-control" placeholder="Enter Last Name" name="last_name" id="last_name" value="{{ $member_info->last_name }}">
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The last name field is required. </p>
                          </div>
                          <div class="col-md-3 col-12">
                            <label class="form-label text-bold">Suffix</label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <input type="text" class="form-control" placeholder="Enter Suffix" name="suffix" id="suffix" value="{{ $member_info->suffix }}">
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The suffix field is required. </p>
                          </div>
                          
                        </div>

                        <div class="row mt-2">
                          <div class="col-md-4 col-12">
                            <label class="form-label text-bold">Gender<code> <b>*</b></code></label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <select name="gender" id="gender" class="form-control gender">
                                <option value="">-- SELECT --</option>
                                <option value="MALE" {{ $member_info->gender == 'MALE' ? 'selected' : '' }}>MALE</option>
                                <option value="FEMALE" {{ $member_info->gender == 'FEMALE' ? 'selected' : '' }}>FEMALE</option>
                            </select>
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The gender field is required. </p>
                          </div>
                          <div class="col-md-4 col-8">
                            <label class="form-label text-bold">Date of Birth<code> <b>*</b></code></label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <input type="date" class="form-control" value="{{ \Carbon\Carbon::parse($member_info->birthdate)->format('Y-m-d') }}" name="birthdate" id="birthdate">
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The birthdate field is required. </p>
                          </div>
                          <div class="col-md-4 col-4">
                            <label class="form-label text-bold">Age<code> <b>*</b></code></label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <input type="text" class="form-control" value="{{ $member_info->age() }}" placeholder="Enter Age" name="age" id="age" disabled>
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The age field is required. </p>
                          </div>
                        </div>

                        <div class="row mt-2">
                          <div class="col-md-4 col-12">
                            <label class="form-label text-bold">Nationality<code> <b>*</b></code></label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <select name="nationality" id="nationality" class="form-control nationality">
                                <option value="">-- SELECT --</option>
                                @foreach ($nationality as $nationality2)
                                  <option value="{{ $nationality2->id }}" {{ ( $nationality2->id == $member_info->nationality) ? 'selected' : '' }}>{{ $nationality2->nationality_name }}</option>
                                @endforeach
                               
                            </select>
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The nationality field is required. </p>
                          </div>
                          <div class="col-md-4 col-12">
                            <label class="form-label text-bold">Civil Status<code> <b>*</b></code></label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <select name="civil_status" id="civil_status" class="form-control civil_status">
                                <option value="">-- SELECT --</option>
                                <option value="SINGLE" {{ $member_info->civil_status == 'SINGLE' ? 'selected' : '' }}>Single</option>
                                <option value="MARRIED" {{ $member_info->civil_status == 'MARRIED' ? 'selected' : '' }}>Married</option>
                                <option value="DIVORCED" {{ $member_info->civil_status == 'DIVORCED' ? 'selected' : '' }}>Divorced</option>
                                <option value="SEPARATED" {{ $member_info->civil_status == 'SEPARATED' ? 'selected' : '' }}>Separated</option>
                                <option value="WIDOWED" {{ $member_info->civil_status == 'WIDOWED' ? 'selected' : '' }}>Widowed</option>
                              </select>
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The civil Status field is required. </p>
                          </div>
                          <div class="col-md-4 col-12">
                            <label class="form-label text-bold">PRC Number<code> <b>*</b></code></label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <input type="text" class="form-control" value="{{ $member_info->prc_number }}" placeholder="Enter PRC Number" name="prc_number" id="prc_number">
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The PRC Number field is required. </p>
                          </div>
                        </div>

                        <div class="row mt-4">
                          <div class="col-md-12">
                              <h5>Contact Information</h5>
                          </div>
                        </div>

                        <div class="row mt-2">
                          <div class="col-md-12 col-12">
                            <label class="form-label text-bold">Address<code> <b>*</b></code></label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <input type="text" class="form-control" value="{{ $member_info->address }}" placeholder="Enter Address" name="address" id="address">
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The address field is required. </p>
                          </div>
                        </div>
                        <div class="row mt-2">
                          <div class="col-md-2 col-4">
                            <label class="form-label text-bold">Area Code</label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <select name="country_code" id="country_code" class="form-control area_code">
                                <option value="+63" {{ $member_info->country_code == '+63' ? 'selected' : '' }}>+63</option>
                                <option value="OTHERS" {{ $member_info->country_code == 'OTHERS' ? 'selected' : '' }}>Others</option>
                              </select>
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The area code field is required. </p>
                          </div>
                          <div class="col-md-4 col-8">
                            <label class="form-label text-bold">Mobile Number<code> <b>*</b></code></label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <input type="number" class="form-control mobile_number" value="{{ $member_info->mobile_number }}" maxlength="10" placeholder="Enter Mobile Number" name="mobile_number" id="mobile_number">
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The mobile number field is required. </p>
                          </div>
                          <div class="col-md-6 col-12">
                            <label class="form-label text-bold">Email Address<code> <b>*</b></code></label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <input type="email" class="form-control" value="{{ $member_info->email_address }}" placeholder="Enter Email Address" name="email_address" id="email_address">
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The email address field is required. </p>
                          </div>
                        </div>

                        <div class="row mt-2">
                          <div class="col-md-9 col-12">
                            <label class="form-label text-bold">Medical School<code> <b>*</b></code></label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <input type="text" class="form-control" value="{{ $member_info->medical_school }}" placeholder="Enter Medical School" name="medical_school" id="medical_school">
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The medical school field is required. </p>
                          </div>
                          <div class="col-md-3 col-12">
                            <label class="form-label text-bold">Year Graduated<code> <b>*</b></code></label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <select name="medical_school_year" id="medical_school_year" class="form-control medical_school_year">
                                <option value="">--SELECT--</option>
                                @foreach($years as $year)
                                  <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                                      {{ $year }}
                                  </option>
                                @endforeach
                              </select>
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The year graduated field is required. </p>
                          </div>
                        </div>


                        <div class="row mt-4">
                          <div class="col-md-12">
                              <h5>Training History</h5>
                          </div>
                        </div>

                        <div class="row mt-1">
                          <div class="col-md-12">
                              <h6>I. Residency</h6>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-5 col-12">
                            <label class="form-label text-bold">Institution<code> <b>*</b></code></label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <input type="text" class="form-control" value="{{ $member_info->ins_institution }}" placeholder="Enter Institution" name="institution" id="institution">
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The institution field is required. </p>
                          </div>
                          <div class="col-md-2 col-6">
                            <label class="form-label text-bold">Date Started<code> <b>*</b></code></label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <input type="month" class="form-control" value="{{ \Carbon\Carbon::parse($member_info->ins_date_started)->format('Y-m') }}" name="ins_date_started" id="ins_date_started">
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The institution date started field is required. </p>
                          </div>
                          <div class="col-md-2 col-6">
                            <label class="form-label text-bold">Date Ended<code> <b>*</b></code></label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <input type="month" class="form-control"  value="{{ \Carbon\Carbon::parse($member_info->ins_date_ended)->format('Y-m') }}" name="ins_date_ended" id="ins_date_ended">
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The institution date ended field is required. </p>
                          </div>
                          <div class="col-md-3 col-12">
                            <label class="form-label text-bold">Department Chair<code> <b>*</b></code></label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <input type="text" class="form-control" value="{{ $member_info->ins_department_chair }}" placeholder="Enter Institution Department Chair" name="ins_department_chair" id="ins_department_chair">
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The institution department chair field is required. </p>
                          </div>
                        </div>
                        <br>
                        <div class="row mt-1">
                          <div class="col-md-12">
                              <h6>II. Subspecialty Training</h6>
                          </div>
                        </div>
                        
                        <div class="row">
                          <div class="col-md-4 col-12">
                            <label class="form-label text-bold">Subspecialty<code> <b>*</b></code></label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <input type="text" class="form-control" value="{{ $member_info->subspecialty }}" placeholder="Enter Subspecialty" name="subspecialty" id="subspecialty">
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The subspecialty field is required. </p>
                          </div>
                          <div class="col-md-4 col-12">
                            <label class="form-label text-bold">Institution<code> <b>*</b></code></label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <input type="text" class="form-control" value="{{ $member_info->sub_institution }}" placeholder="Enter Subspecialty Institution" name="sub_institution" id="sub_institution">
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The subspecialty institution field is required. </p>
                          </div>
                          <div class="col-md-2 col-6">
                            <label class="form-label text-bold">Date Started<code> <b>*</b></code></label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <input type="month" class="form-control" value="{{ \Carbon\Carbon::parse($member_info->sub_date_started)->format('Y-m') }}" name="sub_date_started" id="sub_date_started">
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The subspecialty date started field is required. </p>
                          </div>
                          <div class="col-md-2 col-6">
                            <label class="form-label text-bold">Date Ended<code> <b>*</b></code></label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <input type="month" class="form-control"  value="{{ \Carbon\Carbon::parse($member_info->sub_date_ended)->format('Y-m') }}" name="sub_date_ended" id="sub_date_ended">
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The subspecialty date ended field is required. </p>
                          </div>
                        </div>
                        <div class="row mt-2">
                          <div class="col-md-4 col-12">
                            <label class="form-label text-bold">Section Chief<code> <b>*</b></code></label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <input type="text" class="form-control" value="{{ $member_info->sub_section_chief }}" placeholder="Enter Subspecialty Section Chief" name="sub_section_chief" id="sub_section_chief">
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The subspecialty section chief field is required. </p>
                          </div>
                        </div>
                        <br>
                        <div class="row mt-1">
                          <div class="col-md-12">
                              <h6>III. Academic Degrees</h6>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-4 col-12">
                            <label class="form-label text-bold">Degree<code> <b>*</b></code></label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <input type="text" class="form-control" value="{{ $member_info->academic_degree }}" placeholder="Enter Academic Degree" name="academic_degree" id="academic_degree">
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The academic degree field is required. </p>
                          </div>
                          <div class="col-md-4 col-12">
                            <label class="form-label text-bold">Institution<code> <b>*</b></code></label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <input type="text" class="form-control" value="{{ $member_info->academic_institution }}" placeholder="Enter Academic Institution" name="academic_institution" id="academic_institution">
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The academic institution field is required. </p>
                          </div>
                          <div class="col-md-2 col-6">
                            <label class="form-label text-bold">Date Started<code> <b>*</b></code></label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <input type="month" class="form-control" value="{{ \Carbon\Carbon::parse($member_info->academic_date_started)->format('Y-m') }}" name="academic_date_started" id="academic_date_started">
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The academic date started field is required. </p>
                          </div>
                          <div class="col-md-2 col-6">
                            <label class="form-label text-bold">Date Ended<code> <b>*</b></code></label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <input type="month" class="form-control"  value="{{ \Carbon\Carbon::parse($member_info->academic_date_ended)->format('Y-m') }}" name="academic_date_ended" id="academic_date_ended">
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The academic date ended field is required. </p>
                          </div>
                        </div>
                        <div class="row mt-2">
                          <div class="col-md-4 col-12">
                            <label class="form-label text-bold">Dean<code> <b>*</b></code></label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <input type="text" class="form-control" value="{{ $member_info->academic_dean }}" placeholder="Enter Academic Dean" name="academic_dean" id="academic_dean">
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The academic dean field is required. </p>
                          </div>
                        </div>
                        <br>
                        <div class="row mt-1">
                          <div class="col-md-12">
                              <h6>IV. Research Papers and Publications</h6>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-4 col-12">
                            <label class="form-label text-bold">Title<code> <b>*</b></code></label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <input type="text" class="form-control" value="{{ $member_info->research_title }}" placeholder="Enter Institution" name="research_title" id="research_title">
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The research/publication title field is required. </p>
                          </div>
                          <div class="col-md-3 col-12">
                            <label class="form-label text-bold">Authorship<code> <b>*</b></code></label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <select name="research_authorship" id="research_authorship" class="form-control research_authorship">
                                <option value="">-- SELECT --</option>
                                <option value="PRIMARY" {{ $member_info->research_authorship == 'PRIMARY' ? 'selected' : '' }}>PRIMARY</option>
                                <option value="CO-AUTHOR" {{ $member_info->research_authorship == 'CO-AUTHOR' ? 'selected' : '' }}>CO-AUTHOR</option>
                            </select>
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The research/publication authorship field is required. </p>
                          </div>
                          <div class="col-md-3 col-12">
                            <label class="form-label text-bold">Publication Status<code> <b>*</b></code></label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <select name="research_publication_status" id="research_publication_status" class="form-control research_publication_status">
                                <option value="">-- SELECT --</option>
                                <option value="PUBLISHED" {{ $member_info->research_publication_status == 'PUBLISHED' ? 'selected' : '' }}>PUBLISHED</option>
                                <option value="UNPUBLISHED" {{ $member_info->research_publication_status == 'UNPUBLISHED' ? 'selected' : '' }}>UNPUBLISHED</option>
                            </select>
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The research/publication status field is required. </p>
                          </div>
                          <div class="col-md-2 col-12">
                            <label class="form-label text-bold">Year<code> <b>*</b></code></label>
                            <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                              <select name="research_publication_year" id="research_publication_year" class="form-control research_publication_year">
                                <option value="">--SELECT--</option>
                                @foreach($years as $year)
                                  <option value="{{ $year }}" {{ $year == $selectedYearResearch ? 'selected' : '' }}>
                                      {{ $year }}
                                  </option>
                                @endforeach
                              </select>
                            </div>
                            <p class="text-danger inputerror mt-0" style="display: none">The research/publication year field is required. </p>
                          </div>
                        </div>

                        <div class="row mt-5">
                          <div class="col-md-12">
                              <h6>V. Summary of CPD Units from PPS-Accredited Conference</h6>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-12">
                            <div class="table table-responsive table-bordered">
                              <table class="table align-items-center mb-0">
                                  <thead>
                                      <tr>
                                        <th></th>
                                          <th
                                              class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                              Year</th>
                                          <th
                                              class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                              PPS Accredited Activities</th>
                                          <th
                                              class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                              Units Earned</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @php
                                        $totalPoints = 0;
                                    @endphp
                                    @foreach ($cpdpointsevent as $cpdpointsevent2)
                                      @php
                                          $totalPoints += $cpdpointsevent2->points;
                                      @endphp
                                      <tr>
                                          <td>{{ $loop->iteration }}.  </td>
                                          <td>
                                            <h6 class="mb-0 text-sm">{{ \Carbon\Carbon::parse($cpdpointsevent2->created_at)->format('Y') }}
                                            </h6>
                                          </td>
                                          <td>
                                            <h6 class="mb-0 text-sm">{{ $cpdpointsevent2->topic_name }}
                                            </h6>
                                          </td>
                                          <td class="text-center">
                                            <h6 class="mb-0 text-sm">{{ $cpdpointsevent2->points }}
                                            </h6>
                                          </td>
                
                                      </tr>
                                    @endforeach
                                    <tr>
                                      <td colspan="3" class="text-right"><strong>Total Points:</strong></td>
                                      <td class="text-center"><strong>{{ $totalPoints }}</strong></td>
                                    </tr>
                                     
                                     
                                  </tbody>
                                
                              </table>
                          </div>
                          </div>
                        </div>
                        
                        <div class="row mt-5">
                          <div class="col-md-2 col-12">
                            <button type="submit" class="btn btn-success w-100">UPDATE</button>
                          </div>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
        </div>
        <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
    </div>
    </main>
    <x-plugins></x-plugins>
    <link href="{{ asset('assets') }}/css/loader.css" rel="stylesheet" />
  @push('js')

  <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('assets') }}/js/select2.min.js"></script>
  <link href="{{ asset('assets') }}/css/select2.min.css" rel="stylesheet" />
  <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
  <script src="{{ asset('assets') }}/js/specialty-board-update.js"></script>
  <link href="{{ asset('assets') }}/css/specialty-board-update.css" rel="stylesheet" />

    @endpush
  </x-page-template>
  