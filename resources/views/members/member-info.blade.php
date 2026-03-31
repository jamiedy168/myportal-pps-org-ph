<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="members" activeItem="listing" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-auth.navbars.navs.auth pageTitle="Listing"></x-auth.navbars.navs.auth>
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <div class="loading" id="loading6">
                <img src="{{ asset('assets') }}/img/pps-logo.png" style="height: 60px !important; width: 60px !important" alt="img-blur-shadow" class="icons">
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-4"></h5>
                                <div class="row">
                                    <div class="col-xl-5 col-lg-6 text-center">
                                        @if ($member_info->picture == null)
                                            <img class="w-70 border-radius-lg shadow-lg mx-auto"
                                            src="{{ asset('assets') }}/img/default-avatar.png" alt="profile">
                                        @else
                                            <img class="w-70 border-radius-lg shadow-lg mx-auto"
                                            src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $member_info->picture, now()->addMinutes(30))}}" alt="profile">
                                        @endif

                                        <div class="my-gallery d-flex mt-4 pt-2" itemscope
                                           >

                                            @if ($member_info->front_id_image != null)
                                            <figure class="ms-3" itemprop="associatedMedia" itemscope
                                                >
                                                <a href="{{Storage::disk('s3')->temporaryUrl('applicant/' . $member_info->front_id_image, now()->addMinutes(30))}}"
                                                    itemprop="contentUrl" data-size="500x600">
                                                    <img class="w-100 min-height-100 max-height-100 border-radius-lg shadow"
                                                        src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $member_info->front_id_image, now()->addMinutes(30))}}"
                                                        itemprop="thumbnail" alt="Image description" />
                                                </a>
                                            </figure>
                                            @endif

                                            @if ($member_info->front_id_image != null)
                                                <figure class="ms-3" itemprop="associatedMedia" itemscope
                                                    >
                                                    <a href="{{Storage::disk('s3')->temporaryUrl('applicant/' . $member_info->back_id_image, now()->addMinutes(30))}}"
                                                        itemprop="contentUrl" data-size="500x600">
                                                        <img class="w-100 min-height-100 max-height-100 border-radius-lg shadow"
                                                            src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $member_info->back_id_image, now()->addMinutes(30))}}"
                                                            itemprop="thumbnail" alt="Image description" />
                                                    </a>
                                                </figure>
                                            @endif

                                            @if ($member_info->residency_certificate != null)
                                                <figure class="ms-3" itemprop="associatedMedia" itemscope
                                                    >
                                                    <a href="{{Storage::disk('s3')->temporaryUrl('applicant/' . $member_info->residency_certificate, now()->addMinutes(30))}}"
                                                        itemprop="contentUrl" data-size="500x600">
                                                        <img class="w-100 min-height-100 max-height-100 border-radius-lg shadow"
                                                            src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $member_info->residency_certificate, now()->addMinutes(30))}}"
                                                            itemprop="thumbnail" alt="Image description" />
                                                    </a>
                                                </figure>
                                             @endif

                                             @if ($member_info->government_physician_certificate != null)
                                                <figure class="ms-3" itemprop="associatedMedia" itemscope
                                                    >
                                                    <a href="{{Storage::disk('s3')->temporaryUrl('applicant/' . $member_info->government_physician_certificate, now()->addMinutes(30))}}"
                                                        itemprop="contentUrl" data-size="500x600">
                                                        <img class="w-100 min-height-100 max-height-100 border-radius-lg shadow"
                                                            src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $member_info->government_physician_certificate, now()->addMinutes(30))}}"
                                                            itemprop="thumbnail" alt="Image description" />
                                                    </a>
                                                </figure>
                                             @endif

                                             @if ($member_info->identification_card != null)
                                                <figure class="ms-3" itemprop="associatedMedia" itemscope
                                                    >
                                                    <a href="{{Storage::disk('s3')->temporaryUrl('applicant/' . $member_info->identification_card, now()->addMinutes(30))}}"
                                                        itemprop="contentUrl" data-size="500x600">
                                                        <img class="w-100 min-height-100 max-height-100 border-radius-lg shadow"
                                                            src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $member_info->identification_card, now()->addMinutes(30))}}"
                                                            itemprop="thumbnail" alt="Image description" />
                                                    </a>
                                                </figure>
                                             @endif

                                        </div>

                                        <!-- Root element of PhotoSwipe. Must have class pswp. -->
                                        <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

                                            <div class="pswp__bg"></div>
                                            <!-- Slides wrapper with overflow:hidden. -->
                                            <div class="pswp__scroll-wrap">
                                                <!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
                                                <!-- don't modify these 3 pswp__item elements, data is added later on. -->
                                                <div class="pswp__container">
                                                    <div class="pswp__item"></div>
                                                    <div class="pswp__item"></div>
                                                    <div class="pswp__item"></div>
                                                </div>
                                                <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
                                                <div class="pswp__ui pswp__ui--hidden">
                                                    <div class="pswp__top-bar">
                                                        <!--  Controls are self-explanatory. Order can be changed. -->
                                                        <div class="pswp__counter"></div>
                                                        <button
                                                            class="btn btn-white btn-sm pswp__button pswp__button--close">Close
                                                            (Esc)</button>
                                                        <button
                                                            class="btn btn-white btn-sm pswp__button pswp__button--fs">Fullscreen</button>
                                                        <button
                                                            class="btn btn-white btn-sm pswp__button pswp__button--arrow--left">Prev
                                                        </button>
                                                        <button
                                                            class="btn btn-white btn-sm pswp__button pswp__button--arrow--right">Next
                                                        </button>
                                                        <!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR -->
                                                        <!-- element will get class pswp__preloader--active when preloader is running -->
                                                        <div class="pswp__preloader">
                                                            <div class="pswp__preloader__icn">
                                                                <div class="pswp__preloader__cut">
                                                                    <div class="pswp__preloader__donut"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                                                        <div class="pswp__share-tooltip"></div>
                                                    </div>
                                                    <div class="pswp__caption">
                                                        <div class="pswp__caption__center"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-lg-5 mx-auto">



                                        <h3 class="mt-lg-0 mt-4">{{ $member_info->first_name }} {{ $member_info->middle_name }} {{ $member_info->last_name }}</h3>
                                        {{-- <p class="mb-0 mt-0" style="margin-top: -12px !important">{{ $applicantInfo->email_address }}</p> --}}
                                        @if($member_info->status == "FOR APPROVAL")
                                            <span class="badge badge-danger">For Approval</span>
                                        @elseif($member_info->status == "DISAPPROVE")
                                            <span class="badge badge-danger">Disapprove</span>
                                        @endif



                                        @if ($member_info->applicant_type == "NONMEMBER")
                                            <span class="badge badge-success"> NON-MEMBER</span>
                                        @elseif ($member_info->applicant_type == "EMERITUSFELLOW")
                                            <span class="badge badge-success"> EMERITUS FELLOW</span>
                                        @elseif ($member_info->applicant_type == "ALLIEDHEALTHPROFESSIONALS")
                                            <span class="badge badge-success"> ALLIED HEALTH PROFESSIONALS</span>
                                        @elseif ($member_info->applicant_type == "RESIDENTTRAINEES")
                                            <span class="badge badge-success"> RESIDENT/TRAINEES</span>
                                        @elseif ($member_info->applicant_type == "GOVERNMENTPHYSICIAN")
                                            <span class="badge badge-success"> GOVERNMENT PHYSICIAN</span>
                                        @else
                                            <span class="badge badge-success"></span>
                                        @endif

                                        <p class="text-dark mt-2">{{ $member_info->email_address }}</p>
                                        <div class="d-flex flex-wrap gap-2">
                                            <span class="badge bg-gradient-secondary">{{ $member_info->pps_no }}</span>
                                            @if($member_info->member_type_name)
                                                <span class="badge bg-gradient-info">{{ $member_info->member_type_name }}</span>
                                            @endif
                                            @if($member_info->classification_name)
                                                <span class="badge bg-gradient-dark">{{ $member_info->classification_name }}</span>
                                            @endif
                                            @if($member_info->member_status)
                                                <span class="badge bg-gradient-primary">{{ $member_info->member_status }}</span>
                                            @endif
                                            @if($member_info->vip)
                                                <span class="badge bg-gradient-warning text-dark">VIP</span>
                                            @endif
                                            @if($member_info->chapter_name)
                                                <span class="badge bg-gradient-success">{{ $member_info->chapter_name }}</span>
                                            @endif
                                        </div>
                                        <div class="mt-3">
                                            <a class="btn btn-sm bg-gradient-primary" href="/member-info-update/{{ Crypt::encrypt($member_info->pps_no) }}">Edit Member</a>
                                        </div>

                                        <hr class="horizontal gray-light my-2">

                                        <h6 class="mt-2 bg-gray-200">Profile Information</h6>

                                        <div class="row mt-0">
                                            <div class="col-4">
                                                <label class="text-dark"><strong>First Name:</strong></label>
                                            </div>
                                            <div class="col-8">
                                                @if ($member_info->first_name != null)
                                                    <label class="text-dark">{{ $member_info->first_name }}</label>
                                                @else
                                                    <label class="text-dark">N/A</label>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="row mt-0">
                                            <div class="col-4">
                                                <label class="text-dark"><strong>Middle Name:</strong></label>
                                            </div>
                                            <div class="col-8">
                                                @if ($member_info->middle_name != null)
                                                    <label class="text-dark">{{ $member_info->middle_name }}</label>
                                                @else
                                                    <label class="text-dark">N/A</label>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="row mt-0">
                                            <div class="col-4">
                                                <label class="text-dark"><strong>Last Name:</strong></label>
                                            </div>
                                            <div class="col-8">
                                                @if ($member_info->last_name != null)
                                                <label class="text-dark">{{ $member_info->last_name }}</label>
                                                @else
                                                    <label class="text-dark">N/A</label>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="row mt-0">
                                            <div class="col-4">
                                                <label class="text-dark"><strong>Date of Birth:</strong></label>
                                            </div>
                                            <div class="col-8">
                                                <label class="text-dark">{{ Carbon\Carbon::parse($member_info->birthdate)->format('F d, Y') }}</label>
                                            </div>
                                        </div>
                                        <div class="row mt-0">
                                            <div class="col-4">
                                                <label class="text-dark"><strong>Age:</strong></label>
                                            </div>
                                            <div class="col-8">
                                                <label class="text-dark">{{ $member_info->age() }} years old</label>
                                            </div>
                                        </div>
                                        <div class="row mt-0">
                                            <div class="col-4">
                                                <label class="text-dark"><strong>Gender:</strong></label>
                                            </div>
                                            <div class="col-8">
                                                <label class="text-dark">{{ $member_info->gender ?? 'N/A' }}</label>
                                            </div>
                                        </div>
                                        <div class="row mt-0">
                                            <div class="col-4">
                                                <label class="text-dark"><strong>Civil Status:</strong></label>
                                            </div>
                                            <div class="col-8">
                                                <label class="text-dark">{{ $member_info->civil_status ?? 'N/A' }}</label>
                                            </div>
                                        </div>
                                        <div class="row mt-0">
                                            <div class="col-4">
                                                <label class="text-dark"><strong>Citizenship:</strong></label>
                                            </div>
                                            <div class="col-8">
                                                <label class="text-dark">{{ $member_info->citizenship ?? 'N/A' }}</label>
                                            </div>
                                        </div>
                                        <div class="row mt-0">
                                            <div class="col-4">
                                                <label class="text-dark"><strong>Nationality:</strong></label>
                                            </div>
                                            <div class="col-8">
                                                <label class="text-dark">{{ $member_info->nationality ?? 'N/A' }}</label>
                                            </div>
                                        </div>
                                        <div class="row mt-0">
                                            <div class="col-4">
                                                <label class="text-dark"><strong>Religion:</strong></label>
                                            </div>
                                            <div class="col-8">
                                                <label class="text-dark">{{ $member_info->religion ?? 'N/A' }}</label>
                                            </div>
                                        </div>
                                        <div class="row mt-0">
                                            <div class="col-4">
                                                <label class="text-dark"><strong>Birthplace:</strong></label>
                                            </div>
                                            <div class="col-8">
                                                <label class="text-dark">{{ $member_info->birthplace ?? 'N/A' }}</label>
                                            </div>
                                        </div>

                                        <div class="row mt-0">
                                            <div class="col-4">
                                                <label class="text-dark"><strong>Foreign National?</strong></label>
                                            </div>
                                            <div class="col-8">
                                                @if ($member_info->is_foreign == true)
                                                    <label class="text-dark">YES</label>
                                                @else
                                                    <label class="text-dark">NO</label>
                                                @endif

                                            </div>
                                        </div>






                                        {{-- <div class="row mt-4">
                                            <div class="col-12">

                                                <button class="btn btn-outline-secondary mb-2 mt-lg-auto w-100" type="button" data-bs-toggle="modal" data-bs-target="#modal-notification"
                                                    name="button">APPROVE</button>
                                                    <button class="btn bg-gradient-danger mb-0 mt-lg-auto w-100" type="button" data-bs-toggle="modal" data-bs-target="#modalDisapprove"
                                                    name="button">DISAPPROVE</button>
                                            </div>

                                        </div> --}}






                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="row mt-3">
                                        <div class="col-12 col-md-6 col-xl-4 mt-md-0 mt-4 position-relative">
                                            <div class="card card-plain h-100">
                                                <div class="card-header pb-0 p-3">
                                                    <div class="row bg-gray-200">
                                                        <div class="col-8 d-flex align-items-center">
                                                            <h6 class="mb-0">Contact Information</h6>
                                                        </div>
                                                        <div class="col-4 text-end">
                                                            <a href="javascript:;">
                                                                <i class="fas fa-address-card text-secondary text-sm"
                                                                    ></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body p-3">
                                                    {{-- <p class="text-sm">
                                                        Hi, I’m Alec Thompson, Decisions: If you can’t decide, the answer is no. If two
                                                        equally difficult paths, choose the one more painful in the short term (pain
                                                        avoidance is creating an illusion of equality).
                                                    </p> --}}
                                                    <hr class="horizontal gray-light my-1">

                                                    <div class="row mt-0">
                                                        <div class="col-5">
                                                            <label class="text-dark"><strong>Mobile Number:</strong></label>
                                                        </div>
                                                        <div class="col-7">
                                                            <label class="text-dark">{{ $member_info->country_code }} {{ $member_info->mobile_number }}</label>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-0">
                                                        <div class="col-5 col-sm-5">
                                                            <label class="text-dark"><strong>Email:</strong></label>
                                                        </div>
                                                        <div class="col-7 col-sm-7" style="word-break: break-all !important;">
                                                            <label class="text-dark">{{ $member_info->email_address }}</label>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-0">
                                                        <div class="col-5">
                                                            <label class="text-dark"><strong>Telephone Number:</strong></label>
                                                        </div>
                                                        <div class="col-7">
                                                            @if ($member_info->telephone_number == null)
                                                            <label class="text-dark"> ----- </label>
                                                            @else
                                                            <label class="text-dark">{{ $member_info->telephone_number }}</label>
                                                            @endif

                                                        </div>
                                                    </div>
                                                    <div class="row mt-0">
                                                        <div class="col-5">
                                                            <label class="text-dark"><strong>Home Address:</strong></label>
                                                        </div>
                                                        <div class="col-7">
                                                            <label class="text-dark">
                                                                {{ $member_info->house_number }} {{ $member_info->street_name }},
                                                                {{ $member_info->barangay_name }}, {{ $member_info->city_name }},
                                                                {{ $member_info->province_name }} {{ $member_info->postal_code }}
                                                            </label>
                                                        </div>
                                                    </div>


                                                    <div class="row mt-0">
                                                        <div class="col-5">
                                                            <label class="text-dark"><strong>Clinic Address:</strong></label>
                                                        </div>
                                                        <div class="col-7">
                                                            @if ($member_info->clinic_address == null)
                                                            <label class="text-dark"> ------ </label>
                                                            @else
                                                            <label class="text-dark">{{ $member_info->clinic_address }}</label>
                                                            @endif

                                                        </div>
                                                    </div>

                                                    <div class="row mt-0">
                                                        <div class="col-5">
                                                            <label class="text-dark"><strong>Country:</strong></label>
                                                        </div>
                                                        <div class="col-7">
                                                            <label class="text-dark">{{ $member_info->country_text ?? $member_info->country_name ?? '------' }}</label>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-0">
                                                        <div class="col-5">
                                                            <label class="text-dark"><strong>TIN Number:</strong></label>
                                                        </div>
                                                        <div class="col-7">
                                                            <label class="text-dark">{{ $member_info->tin_number ?? '------' }}</label>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-0">
                                                        <div class="col-5">
                                                            <label class="text-dark"><strong>Mailing Address:</strong></label>
                                                        </div>
                                                        <div class="col-7">
                                                            @if ($member_info->mailing_address == null)
                                                            <label class="text-dark"> ------ </label>
                                                            @else
                                                            <label class="text-dark">{{ $member_info->mailing_address }}</label>
                                                            @endif

                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                            <hr class="vertical dark">
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-4 mt-md-0 mt-4 position-relative">
                                            <div class="card card-plain h-100">
                                                <div class="card-header pb-0 p-3">
                                                    <div class="row bg-gray-200">
                                                        <div class="col-8 d-flex align-items-center">
                                                            <h6 class="mb-0">Educational Background</h6>
                                                        </div>
                                                        <div class="col-4 text-end">
                                                            <a href="javascript:;">
                                                                <i class="fas fa-user-graduate text-secondary text-sm"
                                                                    ></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body p-3">

                                                    <hr class="horizontal gray-light my-1">

                                                    <div class="row mt-0">
                                                        <div class="col-5">
                                                            <label class="text-dark"><strong>Graduated Overseas:</strong></label>
                                                        </div>
                                                        <div class="col-7">
                                                            @if ($member_info->graduated_school == true)
                                                            <label class="text-dark"> YES </label>
                                                            @else
                                                            <label class="text-dark">NO</label>
                                                            @endif

                                                        </div>
                                                    </div>

                                                    <div class="row mt-0">
                                                        <div class="col-5">
                                                            <label class="text-dark"><strong>Medical School:</strong></label>
                                                        </div>
                                                        <div class="col-7">
                                                            @if ($member_info->medical_school == null)
                                                            <label class="text-dark"> ----- </label>
                                                            @else
                                                            <label class="text-dark">{{ $member_info->medical_school }}</label>
                                                            @endif

                                                        </div>
                                                    </div>
                                                    <div class="row mt-0">
                                                        <div class="col-5">
                                                            <label class="text-dark"><strong>Year Graduated:</strong></label>
                                                        </div>
                                                        <div class="col-7">
                                                            @if ($member_info->year_graduated == null)
                                                            <label class="text-dark"> ----- </label>
                                                            @else
                                                            <label class="text-dark">{{ $member_info->year_graduated }}</label>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="vertical dark">
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-4 mt-md-0 mt-4 position-relative">
                                            <div class="card card-plain h-100">
                                                <div class="card-header pb-0 p-3">
                                                    <div class="row bg-gray-200">
                                                        <div class="col-8 d-flex align-items-center">
                                                            <h6 class="mb-0">PRC Information</h6>
                                                        </div>
                                                        <div class="col-4 text-end">
                                                            <a href="javascript:;">
                                                                <i class="fas fa-id-badge text-secondary text-sm"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Edit Profile"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body p-3">

                                                    <hr class="horizontal gray-light my-1">
                                                    <div class="row mt-0">
                                                        <div class="col-5">
                                                            <label class="text-dark"><strong>PRC Number:</strong></label>
                                                        </div>

                                                        <div class="col-7">
                                                            @if ($member_info->prc_number == null)
                                                                <label class="text-dark">N/A</label>
                                                            @else
                                                                <label class="text-dark">{{ $member_info->prc_number }}</label>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row mt-0">
                                                        <div class="col-5">
                                                            <label class="text-dark"><strong>PRC Validity:</strong></label>
                                                        </div>
                                                        <div class="col-7">
                                                            @if ($member_info->prc_validity == null)
                                                                <label class="text-dark">N/A</label>
                                                            @else
                                                                <label class="text-dark">{{ $member_info->prc_validity->format('F d, Y') }}</label>
                                                            @endif

                                                        </div>
                                                    </div>
                                                    <div class="row mt-0">
                                                        <div class="col-5">
                                                            <label class="text-dark"><strong>PMA Number:</strong></label>
                                                        </div>
                                                        <div class="col-7">
                                                            <label class="text-dark">{{ $member_info->pma_number }}</label>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-0">
                                                        <div class="col-5">
                                                            <label class="text-dark"><strong>PRC Registration Date:</strong></label>
                                                        </div>
                                                        <div class="col-7">
                                                            <label class="text-dark">
                                                                {{ $member_info->prc_registration_dt ? Carbon\Carbon::parse($member_info->prc_registration_dt)->format('F d, Y') : 'N/A' }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-0">
                                                        <div class="col-5">
                                                            <label class="text-dark"><strong>Doctor Classification:</strong></label>
                                                        </div>
                                                        <div class="col-7">
                                                            <label class="text-dark">{{ $member_info->doctor_classification ?? 'N/A' }}</label>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-0">
                                                        <div class="col-5">
                                                            <label class="text-dark"><strong>Applicant Type:</strong></label>
                                                        </div>
                                                        <div class="col-7">
                                                            <label class="text-dark">{{ $member_info->applicant_type ?? 'N/A' }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="vertical dark">
                                        </div>
                                    </div>

                                </div>
                            <br>
                        </div>
                    </div>
                </div>
            </div>

            <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
        </div>
    </main>
    <x-plugins></x-plugins>
    <link href="{{ asset('assets') }}/css/loader.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/applicant-profile.css" rel="stylesheet" />
    @push('js')
    <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets') }}/js/select2.min.js"></script>
    <link href="{{ asset('assets') }}/css/select2.min.css" rel="stylesheet" />
    <script src="{{ asset('assets') }}/js/applicant-info.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/choices.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/photoswipe.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/photoswipe-ui-default.min.js"></script>
    <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>
    <script>



        // Gallery Carousel
        if (document.getElementById('products-carousel')) {
            var myCarousel = document.querySelector('#products-carousel')
            var carousel = new bootstrap.Carousel(myCarousel)
        }


        // Products gallery

        var initPhotoSwipeFromDOM = function (gallerySelector) {

            // parse slide data (url, title, size ...) from DOM elements
            // (children of gallerySelector)
            var parseThumbnailElements = function (el) {
                var thumbElements = el.childNodes,
                    numNodes = thumbElements.length,
                    items = [],
                    figureEl,
                    linkEl,
                    size,
                    item;

                for (var i = 0; i < numNodes; i++) {

                    figureEl = thumbElements[i]; // <figure> element
                    // include only element nodes
                    if (figureEl.nodeType !== 1) {
                        continue;
                    }

                    linkEl = figureEl.children[0]; // <a> element

                    size = linkEl.getAttribute('data-size').split('x');

                    // create slide object
                    item = {
                        src: linkEl.getAttribute('href'),
                        w: parseInt(size[0], 10),
                        h: parseInt(size[1], 10)
                    };

                    if (figureEl.children.length > 1) {
                        // <figcaption> content
                        item.title = figureEl.children[1].innerHTML;
                    }

                    if (linkEl.children.length > 0) {
                        // <img> thumbnail element, retrieving thumbnail url
                        item.msrc = linkEl.children[0].getAttribute('src');
                    }

                    item.el = figureEl; // save link to element for getThumbBoundsFn
                    items.push(item);
                }

                return items;
            };

            // find nearest parent element
            var closest = function closest(el, fn) {
                return el && (fn(el) ? el : closest(el.parentNode, fn));
            };

            // triggers when user clicks on thumbnail
            var onThumbnailsClick = function (e) {
                e = e || window.event;
                e.preventDefault ? e.preventDefault() : e.returnValue = false;

                var eTarget = e.target || e.srcElement;

                // find root element of slide
                var clickedListItem = closest(eTarget, function (el) {
                    return (el.tagName && el.tagName.toUpperCase() === 'FIGURE');
                });

                if (!clickedListItem) {
                    return;
                }

                // find index of clicked item by looping through all child nodes
                // alternatively, you may define index via data- attribute
                var clickedGallery = clickedListItem.parentNode,
                    childNodes = clickedListItem.parentNode.childNodes,
                    numChildNodes = childNodes.length,
                    nodeIndex = 0,
                    index;

                for (var i = 0; i < numChildNodes; i++) {
                    if (childNodes[i].nodeType !== 1) {
                        continue;
                    }

                    if (childNodes[i] === clickedListItem) {
                        index = nodeIndex;
                        break;
                    }
                    nodeIndex++;
                }



                if (index >= 0) {
                    // open PhotoSwipe if valid index found
                    openPhotoSwipe(index, clickedGallery);
                }
                return false;
            };

            // parse picture index and gallery index from URL (#&pid=1&gid=2)
            var photoswipeParseHash = function () {
                var hash = window.location.hash.substring(1),
                    params = {};

                if (hash.length < 5) {
                    return params;
                }

                var vars = hash.split('&');
                for (var i = 0; i < vars.length; i++) {
                    if (!vars[i]) {
                        continue;
                    }
                    var pair = vars[i].split('=');
                    if (pair.length < 2) {
                        continue;
                    }
                    params[pair[0]] = pair[1];
                }

                if (params.gid) {
                    params.gid = parseInt(params.gid, 10);
                }

                return params;
            };

            var openPhotoSwipe = function (index, galleryElement, disableAnimation, fromURL) {
                var pswpElement = document.querySelectorAll('.pswp')[0],
                    gallery,
                    options,
                    items;

                items = parseThumbnailElements(galleryElement);

                // define options (if needed)
                options = {

                    // define gallery index (for URL)
                    galleryUID: galleryElement.getAttribute('data-pswp-uid'),

                    getThumbBoundsFn: function (index) {
                        // See Options -> getThumbBoundsFn section of documentation for more info
                        var thumbnail = items[index].el.getElementsByTagName('img')[
                                0], // find thumbnail
                            pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                            rect = thumbnail.getBoundingClientRect();

                        return {
                            x: rect.left,
                            y: rect.top + pageYScroll,
                            w: rect.width
                        };
                    }

                };

                // PhotoSwipe opened from URL
                if (fromURL) {
                    if (options.galleryPIDs) {
                        // parse real index when custom PIDs are used
                        // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
                        for (var j = 0; j < items.length; j++) {
                            if (items[j].pid == index) {
                                options.index = j;
                                break;
                            }
                        }
                    } else {
                        // in URL indexes start from 1
                        options.index = parseInt(index, 10) - 1;
                    }
                } else {
                    options.index = parseInt(index, 10);
                }

                // exit if index not found
                if (isNaN(options.index)) {
                    return;
                }

                if (disableAnimation) {
                    options.showAnimationDuration = 0;
                }

                // Pass data to PhotoSwipe and initialize it
                gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
                gallery.init();
            };

            // loop through all gallery elements and bind events
            var galleryElements = document.querySelectorAll(gallerySelector);

            for (var i = 0, l = galleryElements.length; i < l; i++) {
                galleryElements[i].setAttribute('data-pswp-uid', i + 1);
                galleryElements[i].onclick = onThumbnailsClick;
            }

            // Parse URL and open gallery if it contains #&pid=3&gid=1
            var hashData = photoswipeParseHash();
            if (hashData.pid && hashData.gid) {
                openPhotoSwipe(hashData.pid, galleryElements[hashData.gid - 1], true, true);
            }
        };

        // execute above function
        initPhotoSwipeFromDOM('.my-gallery');

    </script>
    @endpush
</x-page-template>
