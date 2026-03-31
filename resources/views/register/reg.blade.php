<x-page-template bodyClass='bg-gray-200'>

  {{-- <div class="container-fluid bg-primary">
    <div class="row">
      <br>
      <div class="col-md-1">
        <img src="{{ asset('assets') }}/img/default-avatar.png" alt="avatar" class="rounded-circle shadow-sm" style="height: 50px !important; width: 50px !important">
      </div>
      <div class="col-md-9">
        <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 d-flex flex-column text-white">
          Member System
      </a>
      <br>
      </div>
    </div>
    
   
</div> --}}


    <main class="position-relative border-radius-lg ">
        <div class="container-fluid py-0">
          <div class="loading" id="loading"> 
            <img src="{{ asset('assets') }}/img/pps-logo.png" style="height: 60px !important; width: 60px !important" alt="img-blur-shadow" class="icons">
          </div>
          {{-- <div class="row text-center">
            <div class="col-md-12">
              <img height="20%" width="20%" src="{{ asset('assets') }}/img/illustrations/illustration-signup.jpg">
            </div>
          </div> --}}
            <div class="row">



            


                <div class="col-12 text-center">
                  <img src="{{ asset('assets') }}/img/illustrations/pps-logo.png" alt="avatar" class="rounded-circle shadow-sm" style="height: 120px !important; width: 120px !important">
                  <h3 class="mt-1">Philippine Pediatric Society, Inc.</h3>
                  <h5 class="font-weight-normal opacity-6">Registration</h5>
                  <div class="multisteps-form mb-5">
                    <!--progress bar-->
                    
                    <div class="row" >
                      <div class="col-12 col-md-9 col-lg-9 mx-auto my-5">
                        <div class="card">
                          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-danger shadow-primary border-radius-lg pt-4 pb-3">
                              <div class="multisteps-form__progress">
                                <button class="multisteps-form__progress-btn js-active" type="button" title="Personal Info">
                                  <span>Personal/Contact Information</span>
                                </button>
                                {{-- <button class="multisteps-form__progress-btn" type="button" title="Contact Info">
                                  <span>Contact Information</span>
                                </button> --}}
                                {{-- <button class="multisteps-form__progress-btn" type="button" title="Educational">
                                  <span>Educational/Work Experience</span>
                                </button> --}}
                                <button class="multisteps-form__progress-btn" id="prc_tab" disabled type="button" title="PRC Info">
                                  <span>PRC / Document Information</span>
                                </button>
                              </div>
                            </div>
                          </div>
                          <div class="card-body" id="card-body" >
                            <form class="multisteps-form__form" method="POST" id="applicantSave" enctype="multipart/form-data">
                              {{-- <form class="multisteps-form__form" method="POST" role="form text-left" id="emailUpdateForm" enctype="multipart/form-data" action="{{ url('save-applicant-member') }}"> --}}
                                @csrf
                                <div class="multisteps-form__panel js-active" data-animation="FadeIn">
                                  <div class="multisteps-form__content">
                                    <h5 class="font-weight-bolder mb-0">Personal/Contact Information</h5>
                                    <p class="mb-0 text-sm">Please provide information below</p>

                                    {{-- Start of hidden input --}}
                                    <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">
                                    <input type="hidden" value="{{ url('save-applicant-member') }}" id="urlApplicantSave">
                                    <input type="hidden" value="{{ url('check-prc-exist')}}" id="urlCheckPRCExist">
                                    <input type="hidden" value="{{ $type }}" id="applicant-type">

                                
                                   
                                    {{-- End of hidden input --}}


                                    <div class="row mt-5 mb-3">
                                      <div class="col-lg-4 col-md-4 col-12" style="margin-top: -50px !important">
                                        
                                          <img src="{{ asset('assets') }}/img/placeholder.jpg" id="profile_picture" class="img-fluid shadow border-radius-xl" style="max-width: 100% !important; width: 200px !important; height: auto !important; "  alt="team-2" >
                                          
                                        <br>
                                        <br>
                                        <label for="file-input-profile" class="btn btn-danger">
                                          UPLOAD PROFILE PHOTO
                                        </label>
                                        <input style="display:none;" id="file-input-profile" name="picture" type="file" accept="image/*" onchange="document.getElementById('profile_picture').src = window.URL.createObjectURL(this.files[0])" />
                                      </div>

                                      <div class="col-12 col-lg-8 col-md-8">
                                        <div class="row" style="margin-top: -30px !important">
                                          <div class="col-12 col-lg-6 col-md-6">
                                            <div class="input-group input-group-static">
                                                <label class="col-form-label">First Name <code><b>*</b></code></label>
                                                <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Juan">
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                          <div class="input-group input-group-static">
                                              <label class="col-form-label">Middle Name</label>
                                              <input type="text" class="form-control" name="middle_name" id="middle_name" placeholder="Santos">
                                          </div>
                                        </div>
                                        </div>

                                        <div class="row mt-3">
                                          <div class="col-12 col-lg-6 col-md-6">
                                              <div class="input-group input-group-static">
                                                  <label class="col-form-label">Last Name <code><b>*</b></code></label>
                                                  <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Dela Cruz">
                                              </div>
                                          </div>
                                          <div class="col-12 col-lg-6 col-md-6">
                                              <div class="input-group input-group-static">
                                                  <label class="col-form-label">Suffix</label>
                                                  <input type="text" name="suffix" id="suffix" class="form-control" placeholder="Jr.">
                                              </div>
                                          </div>
                                        </div>


                                        <div class="row">
                                          <div class="col-12">
                                            <div class="row">
                                                <div class="col-12 col-lg-4 col-md-4" style="text-align:left">
                                                    <label class="col-form-label mt-4">Birth Date <code><b>*</b></code></label>
                                                    <select class="form-control" name="birthmonth"
                                                        id="choices-month">
                                                      <option>January</option>
                                                      <option>February</option>
                                                      <option>March</option>
                                                      <option>April</option>
                                                      <option>May</option>
                                                      <option>June</option>
                                                      <option>July</option>
                                                      <option>August</option>
                                                      <option>September</option>
                                                      <option>October</option>
                                                      <option>November</option>
                                                      <option>December</option>
                                                    </select>
                                                </div>
                                                <div class="col-6 col-lg-4 col-md-4">
                                                    <label class="col-form-label mt-4 ms-0">&nbsp;</label>
                                                    <select class="form-control" name="birthdate" id="choices-day"></select>
                                                </div>
                                                <div class="col-6 col-lg-4 col-md-4">
                                                    <label class="col-form-label mt-4">&nbsp;</label>
                                                    <select class="form-control" name="birthyear" id="choices-year"></select>
                                                </div>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="row mt-3">
                                          {{-- <div class="col-12 col-md-5 col-lg-5" style="text-align: left !important">
                                            <label class="col-form-label mt-1 ms-0">Nationality <code><b>*</b></code></label>
                                              <select class="form-control" name="nationality" id="nationality">
                                                <option value="">Choose Nationality</option>
                                                @foreach ($nationality as $nationality2)
                                                  <option value="{{ $nationality2->id }}">{{ $nationality2->nationality_name }}</option>
                                                @endforeach
    
                                              </select>
                                          </div> --}}
                                          <div class="col-12 col-md-5 col-lg-5" style="text-align: left !important;">
                                            <label class="col-form-label mt-1 ms-0">Telephone Number </label>
                                            <div class="input-group input-group-static">
                                              <input type="tel" name="telephone_number" id="telephone_number"  class="form-control multisteps-form__input" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="11">
                                            </div>
                                          </div>
                                          <div class="col-5 col-lg-3 col-md-3 mt-1" style="text-align: left !important">
                                            <label class="col-form-label ms-0">Country Code</label>
                                            <select class="form-control mt-2" name="country_code"
                                                id="country_code">
                                                <option value="+63" selected="">+63</option>
                                                <option value="OTHERS">OTHERS</option>  
                                            </select>
                                          </div>
                                          <div class="col-7 col-md-4 col-lg-4" style="text-align: left !important;">
                                            <label class="col-form-label mt-1 ms-0">Mobile Number <code><b>*</b></code></label>
                                            <div class="input-group input-group-static">
                                              <input type="text" 
                                                name="mobile_number" 
                                                id="mobile_number" 
                                                class="form-control multisteps-form__input" 
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" 
                                                placeholder="9XXXXXXXXX">

                                            </div>
                                          </div>
                                        </div>

                                   
                                        <div class="row mt-3">
                                          <div class="col-12 col-md-12 col-lg-12 mt-2 text-center">
                                            <div class="input-group input-group-static mb-4">
                                              <label class="col-form-label">Email Address <code><b>*</b></code></label>
                                              <input type="email" name="email_address" id="email_address" class="form-control multisteps-form__input">
                                            </div>
                                          </div>
                                        </div>

                                        <div class="row mt-1">
                                          <div class="col-6 col-md-4 col-lg-4 mt-2" style="text-align: left !important">
                                              <label class="col-form-label"> <code><b>*</b></code> Foreign National ?</label>
                                          </div>
                                          <div class="col-3 col-md-2 col-lg-2 mt-3" style="text-align: left !important">
                                            <div class="form-check mb-3">
                                              <input class="form-check-input foreign_national" type="radio" name="foreign_national" id="foreign_national" value="true">
                                              <label class="custom-control-label" for="foreign_national">Yes</label>
                                            </div>
                                          </div>
                                          <div class="col-3 col-md-4 col-lg-4 mt-3" style="text-align: left !important">
                                            <div class="form-check mb-3">
                                              <input class="form-check-input foreign_national" type="radio" name="foreign_national" id="foreign_national" value="false">
                                              <label class="custom-control-label" for="foreign_national">No</label>
                                            </div>
                                          </div>
                                        </div>
                                      
  
                                        
                                      </div>

                                    </div>

                                   

                                    {{-- <div class="row mt-1">
                                      <div class="col-4" style="text-align: left">
                                        <label class="col-form-label mt-1 ms-0">Birthplace <code><b>*</b></code></label>
                                        <div class="input-group input-group-static">
                                            <input type="text" name="birthplace" id="birthplace" class="form-control" placeholder="Manila">
                                        </div>
                                      </div>
                                      <div class="col-4" style="text-align: left">
                                        <label class="col-form-label mt-1 ms-0">Gender <code><b>*</b></code></label>
                                        <select class="form-control" name="gender" id="gender">
                                          <option value="MALE">Male</option>
                                          <option value="FEMALE">Female</option>
                                          <option value="OTHERS">Others</option>
                                      </select>
                                      </div>
                                      <div class="col-4" style="text-align: left">
                                        <label class="col-form-label mt-1 ms-0">Civil Status <code><b>*</b></code></label>
                                          <select class="form-control" name="civil_status" id="civil_status">
                                              <option value="SINGLE">Single</option>
                                              <option value="MARRIED">Married</option>
                                              <option value="DIVORCED">Divorced</option>
                                              <option value="SEPARATED">Separated</option>
                                              <option value="WIDOWED">Widowed</option>
                                          </select>
                                      </div>


                                    </div>


                                    <div class="row mt-2" style="text-align: left">
                                      <div class="col-4">
                                        <label class="col-form-label mt-1 ms-0">Citizenship <code><b>*</b></code></label>
                                        <div class="input-group input-group-static">
                                            <input type="text" name="citizenship" id="citizenship" class="form-control" placeholder="Filipino">
                                        </div>
                                      </div>
                                      <div class="col-4">
                                        <label class="col-form-label mt-1 ms-0">Nationality <code><b>*</b></code></label>
                                          <select class="form-control" name="nationality" id="nationality">
                                            <option value="">Choose Nationality</option>
                                            @foreach ($nationality as $nationality2)
                                              <option value="{{ $nationality2->id }}">{{ $nationality2->nationality_name }}</option>
                                            @endforeach

                                          </select>
                                      </div>
                                      <div class="col-4">
                                        <label class="col-form-label mt-1 ms-0">Religion</label>
                                        <div class="input-group input-group-static">
                                            <input type="text" name="religion" id="religion" class="form-control" placeholder="Catholic">
                                        </div>
                                      </div>

                                      
                                    </div> --}}

                                  
                                  </div>
  
  
                                  <div class="button-row d-flex mt-4">
                                    <br>
                                    <button class="btn btn-outline-dark mb-0 js-btn-prev" type="button" title="Prev">Prev</button>
                                    <button class="btn bg-danger text-white ms-auto mb-0 js-btn-next" id="js-btn-next" type="button" title="Next">Next</button>
                                  </div>
                                </div>

                                


                               
                                <div class="multisteps-form__panel" data-animation="FadeIn">
                                  <h5 class="font-weight-bolder mb-0">PRC / Document Information</h5>
                                  <p class="mb-0 text-sm">Please provide information below</p>
                                  <div class="multisteps-form__content">
                                    <br>

                                    

                                    <br>

                                    <div class="row text-start">
                                      <div class="col-1">
                                      </div>
                                      <div class="col-10 mt-sm-0">
                                      <small class="text-danger" style="font-size: 12px; font-weight: bold">*REMINDERS</small>
                                      </div>
                                    </div>
                                    <div class="row text-start mt-0">
                                      <div class="col-1">
                                      </div>
                                      <div class="col-10 mt-sm-0">
                                      <small style="font-size: 12px;">1. If applicant's nationality is not a Filipino, you can skip the prc information and upload only your identification card</small>
                                      </div>
                                    </div>
                                    <div class="row text-start mt-0">
                                      <div class="col-1">
                                      </div>  
                                      <div class="col-10 mt-sm-0">
                                      <small style="font-size: 12px;">2. Please upload a clear copy of the documents that required to upload.</small>
                                      </div>
                                    </div>
                                  <br>
  
                                      
                    
    
                                    <br>
                                    <div class="row text-start">
                                      <div class="col-1">
                                      </div>
                                      <div class="col-10 mt-4 mt-sm-0 text-center">
                                        <div class="input-group input-group-static mb-4">
                                          <label>PRC Number</label>
                                          <input type="number" id="prc_number" name="prc_number" class="form-control multisteps-form__input">
                                          <label class="text-danger" style="font-weight:bold; display: none !important" id="prcexist">*Existing PRC Number</label>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row text-start">
                                      <div class="col-1">
                                      </div>
                                      <div class="col-5 mt-4 mt-sm-0 text-center">
                                        <div class="input-group input-group-static mb-4">
                                          <label>PRC Registration Date</label>
                                          <input type="date" name="prc_registration_dt" id="prc_registration_dt" class="datetimepicker form-control multisteps-form__input">
                                        </div>
                                     </div>
                                     <div class="col-5 mt-4 mt-sm-0 text-center">
                                      <div class="input-group input-group-static mb-4">
                                        <label>PRC Expiration Date</label>
                                        <input type="date" name="prc_validity" id="prc_validity" class="datetimepicker form-control multisteps-form__input">
                                      </div>
                                   </div>
                                    </div>
                                   
    
                                    <div class="row text-start">
                                      <div class="col-1">
                                      </div>
                                      <div class="col-10 mt-4 mt-sm-0 text-center">
                                        <div class="input-group input-group-static mb-4">
                                          <label>PMA Number</label>
                                          <input type="text" name="pma_number" id="pma_number" class="form-control multisteps-form__input">
                                        </div>
                                      </div>
                                    </div>

                                   

                                    <div class="row mt-3 text-start">
                                      <div class="col-1">
                                      </div>
                                      <div class="col-10 mt-sm-0">
                                        <label class="text-bold text-danger">LIST OF DOCUMENTS</label>
                                      </div>
                                    </div>

                                    <div class="row mb-3" id="prc-front-row" style="text-align: left !important; display: none !important">
                                      <div class="col-lg-1">

                                      </div>
                                      <div class="col-lg-10 col-12">
                                        <label class="form-label text-bold">PRC ID (FRONT) <code><b>(REQUIRED)</b></code></label>
                                        <div class="form-group border border-radius-lg">
                                            <input id="file-input-front" name="front_id_image" type="file" accept="image/jpg, image/jpeg, image/png" >
                                        </div>
                                      </div>

                                     
                                      <div class="col-lg-1">

                                      </div>
                                    </div>


                                    <div class="row mb-3" id="prc-back-row" style="text-align: left !important; display: none !important">
                                      <div class="col-lg-1">

                                      </div>
                                      <div class="col-lg-10 col-12">
                                        <label class="form-label text-bold">PRC ID (BACK) <code><b>(REQUIRED)</b></code></label>
                                        <div class="form-group border border-radius-lg">
                                            <input id="file-input-back" name="back_id_image" type="file" accept="image/jpg, image/jpeg, image/png" >
                                        </div>
                                      </div>
                                     
                                      <div class="col-lg-1">

                                      </div>
                                    </div>

           

                                    <div class="row mb-3" id="certificate_residency-row" style="text-align: left !important; display: none !important">
                                      <div class="col-lg-1">

                                      </div>
                                      <div class="col-lg-10 col-12">
                                        <label class="form-label text-bold">CERTIFICATE OF RESIDENCY <code><b>(REQUIRED)</b></code></label>
                                        <div class="form-group border border-radius-lg">
                                            <input id="file-input-residency" name="residency_certificate" type="file" accept="image/jpg, image/jpeg, image/png" >
                                        </div>
                                      </div>
                                      <div class="col-lg-1">

                                      </div>
                                    </div>

                                    <div class="row mb-3" id="government-physician-row" style="text-align: left !important; display: none !important">
                                      <div class="col-lg-1">

                                      </div>
                                      <div class="col-lg-10 col-12">
                                        <label class="form-label text-bold">GOVERNMENT PHYSICIAN CERTIFICATE <code><b>(REQUIRED)</b></code></label>
                                        <div class="form-group border border-radius-lg">
                                            <input id="file-input-government" name="government_physician_certificate" type="file" accept="image/jpg, image/jpeg, image/png" >
                                        </div>
                                      </div>
                                      <div class="col-lg-1">

                                      </div>
                                    </div>

                                    <div class="row mb-3" id="identification-card-row" style="text-align: left !important; display: none !important">
                                      <div class="col-lg-1">

                                      </div>
                                      <div class="col-lg-10 col-12">
                                        <label class="form-label text-bold">IDENTIFICATION CARD <code><b>(REQUIRED)</b></code></label>
                                        <div class="form-group border border-radius-lg">
                                            <input id="file-input-identification-card" name="identification_card" type="file" accept="image/jpg, image/jpeg, image/png" >
                                        </div>
                                      </div>
                                      <div class="col-lg-1">

                                      </div>
                                    </div>


                                    <div class="row mb-3" id="fellows-in-training-row" style="text-align: left !important; display: none !important">
                                      <div class="col-lg-1">

                                      </div>
                                      <div class="col-lg-10 col-12">
                                        <label class="form-label text-bold">CERTIFICATE OF FELLOWSHIP TRAINING <code><b>(REQUIRED)</b></code></label>
                                        <div class="form-group border border-radius-lg">
                                            <input id="file-input-fellows-in-training" name="fellows_in_training_certificate" type="file" accept="image/jpg, image/jpeg, image/png" >
                                        </div>
                                      </div>
                                      <div class="col-lg-1">

                                      </div>
                                    </div>

                                    

                                    {{-- <div class="row">
                                      <div class="col-1">

                                      </div>
                                      <div class="col-5">
                                       
                                        <div
                                        class="card card-body border card-plain border-radius-lg">
                                        <div class="row">
                                          <div class="col-9">
                                            <h6 class="text-secondary text-sm text-uppercase" style="margin-top: -10px !important; text-align: left !important">PRC ID (FRONT)</h6>
                                          </div>
                                          <div class="col-3 text-right" style="margin-top: -14px !important">
                                            <span class="badge badge-sm bg-gradient-success">Not Required</span>
                                          </div>
                                        </div>
                                        <hr>
                                          <div class="row mt-2">
                                            <div class="col-12">
                                              <img src="{{ asset('assets') }}/img/imageicon.png" alt="avatar"
                                              id="file-ip-1-preview" style="width: 150px !important; height: 130px !important">
                                            </div>
                                          </div>
                                          <hr>
                                          <div class="row mt-2">
                                            <div class="col-12">
                                              <input style="display:none;" id="file-input-front" name="front_id_image" type="file" accept="image/*" onchange="document.getElementById('file-ip-1-preview').src = window.URL.createObjectURL(this.files[0])"/>
                                              <button class="btn btn-danger w-100" type="button" onclick="openFilePRCFront()">CHOOSE IMAGE</button>
                                            </div>
                                          </div>
                                          <div class="row mt-0 mb-0" style="margin-top: -10px !important; margin-bottom: -20px !important">
                                            <div class="col-12 mb-0">
                                              <button class="btn btn-warning w-100" type="button" onclick="clearPRCFront()">REMOVE</button>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-5">
                                       
                                        <div
                                        class="card card-body border card-plain border-radius-lg">
                                        <div class="row">
                                          <div class="col-9">
                                            <h6 class="text-secondary text-sm text-uppercase" style="margin-top: -10px !important; text-align: left !important">PRC ID (BACK)</h6>
                                          </div>
                                          <div class="col-3 text-right" style="margin-top: -14px !important">
                                            <span class="badge badge-sm bg-gradient-success">Not Required</span>
                                          </div>
                                        </div>
                                        <hr>
                                          <div class="row mt-2">
                                            <div class="col-12">
                                              <img src="{{ asset('assets') }}/img/imageicon.png" alt="avatar"
                                              id="file-ip-2-preview" style="width: 150px !important; height: 130px !important">
                                            </div>
                                          </div>
                                          <hr>
                                          <div class="row mt-2">
                                            <div class="col-12">
                                              <input style="display:none;" id="file-input-back" name="back_id_image" type="file" accept="image/*" onchange="document.getElementById('file-ip-2-preview').src = window.URL.createObjectURL(this.files[0])"/>
                                              <button class="btn btn-danger w-100" type="button" onclick="openFilePRCBack()">CHOOSE IMAGE</button>
                                            </div>
                                          </div>
                                          <div class="row mt-0 mb-0" style="margin-top: -10px !important; margin-bottom: -20px !important">
                                            <div class="col-12 mb-0">
                                              <button class="btn btn-warning w-100" type="button" onclick="clearPRCBack()">REMOVE</button>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div> --}}

                                    {{-- <button class="g-recaptcha" 
                                    data-sitekey="{{ config('services.recaptcha.site_key') }}" 
                                    data-callback='onSubmit' 
                                    data-action='submit'>Submit</button> --}}
                      
                                    {{-- <div class="g-recaptcha" data-sitekey="{{config('services.recaptcha.site_key')}}"></div>
   --}}
  
                                    <div class="row">
                                      <div class="button-row d-flex mt-4 col-12">
                                        <button class="btn btn-outline-dark mb-0 js-btn-prev" type="button" title="Prev">Prev</button>
                                        <button class="btn bg-danger text-white ms-auto mb-0" type="submit" id="btnApplicantSavebtnApplicantSave" title="Submit">Submit</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                

                            </form>
                          </div>
                        </div>
                        <p class="text-sm mt-3 mb-0">Already a member?
                            <a href="{{ route('login') }}" class="text-dark font-weight-bolder">Click here to sign in
                            </a></p>
                      </div>
                      
                    </div>
                  </div>
                
                  
                </div>
              </div>
              
        </div>
      
    </main>
    <link href="{{ asset('assets') }}/css/custom-member-info.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/loader.css" rel="stylesheet" />
    @push('js')
    <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets') }}/js/custom-member-applicant.js"></script>
    <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>

    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
      <script src="{{ asset('assets') }}/js/plugins/multistep-form.js"></script>
      <script src="{{ asset('assets') }}/js/plugins/choices.min.js"></script>
      <script src="{{ asset('assets') }}/js/plugins/quill.min.js"></script>
      <script src="{{ asset('assets') }}/js/plugins/flatpickr.min.js"></script>
    
      <script src="https://www.google.com/recaptcha/api.js" async defer></script>



      <script>




      if (document.querySelector('.datetimepicker')) {
            flatpickr('.datetimepicker', {
                allowInput: true
            }); // flatpickr
        }

      if (document.getElementById('gender')) {
            var gender = document.getElementById('gender');
            const example = new Choices(gender,{
              shouldSort: false,
              position: 'bottom',
            });
        }
        if (document.getElementById('doctor_classification')) {
            var doctor_classification = document.getElementById('doctor_classification');
            const example = new Choices(doctor_classification,{
              shouldSort: false,
              position: 'bottom',
              searchEnabled: false
            });
        }


        

        if (document.getElementById('choices-month')) {
            var choices = document.getElementById('choices-month');
            const example = new Choices(choices,{
              shouldSort: false,
              position: 'bottom',
              fuseOptions: { includeScore: true, includeMatches: true, threshold: 0.4, location: 0, distance: 100, maxPatternLength: 32, minMatchCharLength: 1 }
              
              
              
            });
        }


        

      if (document.getElementById('choices-day')) {
            var day = document.getElementById('choices-day');
            setTimeout(function () {
                const example = new Choices(day,{
                  position: 'bottom',
                  fuseOptions: { includeScore: true, includeMatches: true, threshold: 0.4, location: 0, distance: 100, maxPatternLength: 32, minMatchCharLength: 1 }
                });
            }, 1);


            for (y = 01; y <= 31; y++) {
                var optn = document.createElement("OPTION");
                optn.text = y;
                optn.value = y;

                if (y == 01) {
                    optn.selected = true;
                }

                day.options.add(optn);
            }

        }
        


        if (document.getElementById('choices-year')) {
            var year = document.getElementById('choices-year');
            setTimeout(function () {
                const example = new Choices(year,{
                  position: 'bottom',
                  fuseOptions: { includeScore: true, includeMatches: true, threshold: 0.4, location: 0, distance: 100, maxPatternLength: 32, minMatchCharLength: 1 }
                });
            }, 1);

            for (y = 1900; y <= 2060; y++) {
                var optn = document.createElement("OPTION");
                optn.text = y;
                optn.value = y;

                if (y == 2023) {
                    optn.selected = true;
                }

                year.options.add(optn);
            }
        }

        if (document.getElementById('year_graduated')) {
            var year2 = document.getElementById('year_graduated');
            setTimeout(function () {
                const example = new Choices(year2,{
                  position: 'bottom',
                  fuseOptions: { includeScore: true, includeMatches: true, threshold: 0.4, location: 0, distance: 100, maxPatternLength: 32, minMatchCharLength: 1 }
                });
            }, 1);

            for (y = 1800; y <= 2060; y++) {
                var optn = document.createElement("OPTION");
                optn.text = y;
                optn.value = y;

                if (y == 2023) {
                    optn.selected = true;
                }

                year2.options.add(optn);
            }
        }

        if (document.getElementById('from_year')) {
            var year3 = document.getElementById('from_year');
            setTimeout(function () {
                const example = new Choices(year3,{
                  position: 'bottom',
                  fuseOptions: { includeScore: true, includeMatches: true, threshold: 0.4, location: 0, distance: 100, maxPatternLength: 32, minMatchCharLength: 1 }
                });
            }, 1);

            for (y = 1800; y <= 2060; y++) {
                var optn = document.createElement("OPTION");
                optn.text = y;
                optn.value = y;

                if (y == 2023) {
                    optn.selected = true;
                }

                year3.options.add(optn);
            }
        }


        if (document.getElementById('to_year')) {
            var year4 = document.getElementById('to_year');
            setTimeout(function () {
                const example = new Choices(year4,{
                  position: 'bottom',
                  fuseOptions: { includeScore: true, includeMatches: true, threshold: 0.4, location: 0, distance: 100, maxPatternLength: 32, minMatchCharLength: 1 }
                });
            }, 1);

            for (y = 1800; y <= 2060; y++) {
                var optn = document.createElement("OPTION");
                optn.text = y;
                optn.value = y;

                if (y == 2023) {
                    optn.selected = true;
                }

                year4.options.add(optn);
            }
        }




        
        if (document.getElementById('from_year2')) {
            var year5 = document.getElementById('from_year2');
            setTimeout(function () {
                const example = new Choices(year5,{
                  position: 'bottom',
                  fuseOptions: { includeScore: true, includeMatches: true, threshold: 0.4, location: 0, distance: 100, maxPatternLength: 32, minMatchCharLength: 1 }
                });
            }, 1);

            for (y = 1800; y <= 2060; y++) {
                var optn = document.createElement("OPTION");
                optn.text = y;
                optn.value = y;

                if (y == 2023) {
                    optn.selected = true;
                }

                year5.options.add(optn);
            }
        }


        
      if (document.getElementById('country_code')) {
            var element = document.getElementById('country_code');
            const example = new Choices(element, {
                searchEnabled: false,
                shouldSort: false,
                position: 'bottom',
            });
        };

        if (document.getElementById('gender')) {
            var element = document.getElementById('gender');
            const example = new Choices(element, {
                searchEnabled: false,
                shouldSort: false,
                position: 'bottom',
            });
        };

        if (document.getElementById('civil_status')) {
            var element = document.getElementById('civil_status');
            const example = new Choices(element, {
              searchEnabled: false,
                shouldSort: false,
                position: 'bottom',
            });
        };

        if (document.getElementById('nationality')) {
            var element = document.getElementById('nationality');
            const example = new Choices(element, {
              searchEnabled: true,
                shouldSort: false,
                position: 'bottom',
            });
        };

        function showPreview(event) {
            if (event.target.files.length > 0) {
                var src = URL.createObjectURL(event.target.files[0]);
                var preview = document.getElementById("file-ip-1-preview");
                preview.src = src;
                preview.style.display = "block";
            }
        }


        if (document.getElementById('editor')) {
            var quill = new Quill('#editor', {
                theme: 'snow' // Specify theme in configuration
            });
        }
    
        if (document.getElementById('choices-multiple-remove-button')) {
            var element = document.getElementById('choices-multiple-remove-button');
            const example = new Choices(element, {
                removeItemButton: true
            });

            example.setChoices(
                [{
                        value: 'One',
                        label: 'Label One',
                        disabled: true
                    },
                    {
                        value: 'Two',
                        label: 'Label Two',
                        selected: true
                    },
                    {
                        value: 'Three',
                        label: 'Label Three'
                    },
                ],
                'value',
                'label',
                false,
            );
        }

  
        
      </script>
      @endpush
    </x-page-template>
