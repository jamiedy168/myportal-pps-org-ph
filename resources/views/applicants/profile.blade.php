<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="applicants" activeItem="listing" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-auth.navbars.navs.auth pageTitle="Profile"></x-auth.navbars.navs.auth>
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            {{-- <div class="loading" id="loading6"> 
                <img src="{{ asset('assets') }}/img/pps-logo.png" style="height: 60px !important; width: 60px !important" alt="img-blur-shadow" class="icons">
            </div> --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-4"></h5>
                                <div class="row">
                                    <div class="col-xl-5 col-lg-6 text-center">
                                        <img class="w-70 border-radius-lg shadow-lg mx-auto"
                                        
                                            src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $applicantInfo->picture, now()->addMinutes(30))}}" alt="profile">
                                        <div class="my-gallery d-flex mt-4 pt-2" itemscope
                                           >  
                                           
                                            @if ($applicantInfo->front_id_image != null)
                                            <figure class="ms-3" itemprop="associatedMedia" itemscope
                                                >
                                                <a href="{{Storage::disk('s3')->temporaryUrl('applicant/' . $applicantInfo->front_id_image, now()->addMinutes(30))}}"
                                                    itemprop="contentUrl" data-size="500x600">
                                                    <img class="w-100 min-height-100 max-height-100 border-radius-lg shadow"
                                                        src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $applicantInfo->front_id_image, now()->addMinutes(30))}}"
                                                        itemprop="thumbnail" alt="Image description" />
                                                </a>
                                            </figure>
                                            @endif

                                            @if ($applicantInfo->front_id_image != null)
                                                <figure class="ms-3" itemprop="associatedMedia" itemscope
                                                    >
                                                    <a href="{{Storage::disk('s3')->temporaryUrl('applicant/' . $applicantInfo->back_id_image, now()->addMinutes(30))}}"
                                                        itemprop="contentUrl" data-size="500x600">
                                                        <img class="w-100 min-height-100 max-height-100 border-radius-lg shadow"
                                                            src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $applicantInfo->back_id_image, now()->addMinutes(30))}}"
                                                            itemprop="thumbnail" alt="Image description" />
                                                    </a>
                                                </figure>
                                            @endif

                                            @if ($applicantInfo->residency_certificate != null)
                                                <figure class="ms-3" itemprop="associatedMedia" itemscope
                                                    >
                                                    <a href="{{Storage::disk('s3')->temporaryUrl('applicant/' . $applicantInfo->residency_certificate, now()->addMinutes(30))}}"
                                                        itemprop="contentUrl" data-size="500x600">
                                                        <img class="w-100 min-height-100 max-height-100 border-radius-lg shadow"
                                                            src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $applicantInfo->residency_certificate, now()->addMinutes(30))}}"
                                                            itemprop="thumbnail" alt="Image description" />
                                                    </a>
                                                </figure>
                                             @endif

                                             @if ($applicantInfo->government_physician_certificate != null)
                                                <figure class="ms-3" itemprop="associatedMedia" itemscope
                                                    >
                                                    <a href="{{Storage::disk('s3')->temporaryUrl('applicant/' . $applicantInfo->government_physician_certificate, now()->addMinutes(30))}}"
                                                        itemprop="contentUrl" data-size="500x600">
                                                        <img class="w-100 min-height-100 max-height-100 border-radius-lg shadow"
                                                            src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $applicantInfo->government_physician_certificate, now()->addMinutes(30))}}"
                                                            itemprop="thumbnail" alt="Image description" />
                                                    </a>
                                                </figure>
                                             @endif

                                             @if ($applicantInfo->identification_card != null)
                                                <figure class="ms-3" itemprop="associatedMedia" itemscope
                                                    >
                                                    <a href="{{Storage::disk('s3')->temporaryUrl('applicant/' . $applicantInfo->identification_card, now()->addMinutes(30))}}"
                                                        itemprop="contentUrl" data-size="500x600">
                                                        <img class="w-100 min-height-100 max-height-100 border-radius-lg shadow"
                                                            src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $applicantInfo->identification_card, now()->addMinutes(30))}}"
                                                            itemprop="thumbnail" alt="Image description" />
                                                    </a>
                                                </figure>
                                             @endif
                                             @if ($applicantInfo->fellows_in_training_certificate != null)
                                                <figure class="ms-3" itemprop="associatedMedia" itemscope
                                                    >
                                                    <a href="{{Storage::disk('s3')->temporaryUrl('applicant/' . $applicantInfo->fellows_in_training_certificate, now()->addMinutes(30))}}"
                                                        itemprop="contentUrl" data-size="500x600">
                                                        <img class="w-100 min-height-100 max-height-100 border-radius-lg shadow"
                                                            src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $applicantInfo->fellows_in_training_certificate, now()->addMinutes(30))}}"
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

                                   

                                        <h3 class="mt-lg-0 mt-4">{{ $applicantInfo->first_name }} {{ $applicantInfo->middle_name }} {{ $applicantInfo->last_name }}</h3>
                                        {{-- <p class="mb-0 mt-0" style="margin-top: -12px !important">{{ $applicantInfo->email_address }}</p> --}}
                                        <span class="badge badge-danger">For Approval</span>
                                        @if ($applicantInfo->applicant_type == "NONMEMBER")
                                            <span class="badge badge-success"> NON-MEMBER</span>
                                        @elseif ($applicantInfo->applicant_type == "EMERITUSFELLOW")
                                            <span class="badge badge-success"> EMERITUS FELLOW</span>
                                        @elseif ($applicantInfo->applicant_type == "ALLIEDHEALTHPROFESSIONALS")
                                            <span class="badge badge-success"> ALLIED HEALTH PROFESSIONALS</span>
                                        @elseif ($applicantInfo->applicant_type == "RESIDENTTRAINEES")
                                            <span class="badge badge-success"> RESIDENT/TRAINEES</span>
                                        @elseif ($applicantInfo->applicant_type == "GOVERNMENTPHYSICIAN")
                                            <span class="badge badge-success"> GOVERNMENT PHYSICIAN</span>
                                        @else
                                            <span class="badge badge-success"></span>
                                        @endif
                                        
                                        <p class="text-dark mt-2">{{ $applicantInfo->email_address }}</p>

                                    
                                        <hr class="horizontal gray-light my-2">
                                       
                                        <h6 class="mt-2 bg-gray-200">Profile Information</h6>
    
                                        <div class="row mt-0">
                                            <div class="col-4">
                                                <label class="text-dark"><strong>First Name:</strong></label>
                                            </div>
                                            <div class="col-8">
                                                @if ($applicantInfo->first_name != null)
                                                    <label class="text-dark">{{ $applicantInfo->first_name }}</label>   
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
                                                @if ($applicantInfo->middle_name != null)
                                                    <label class="text-dark">{{ $applicantInfo->middle_name }}</label>   
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
                                                @if ($applicantInfo->last_name != null)
                                                <label class="text-dark">{{ $applicantInfo->last_name }}</label>   
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
                                                <label class="text-dark">{{ Carbon\Carbon::parse($applicantInfo->birthdate)->format('F d, Y') }}</label>
                                            </div>
                                        </div>
                                        <div class="row mt-0">
                                            <div class="col-4">
                                                <label class="text-dark"><strong>Age:</strong></label>
                                            </div>
                                            <div class="col-8">
                                                <label class="text-dark">{{ $applicantInfo->age() }} years old</label>
                                            </div>
                                        </div>
                                        <div class="row mt-0">
                                            <div class="col-4">
                                                <label class="text-dark"><strong>Mobile Number:</strong></label>
                                            </div>
                                            <div class="col-8">
                                                @if ($applicantInfo->mobile_number != null)
                                                    <label class="text-dark">{{ $applicantInfo->country_code }} {{ $applicantInfo->mobile_number }}</label>   
                                                @else
                                                    <label class="text-dark">N/A</label>
                                                @endif
                                                
                                            </div>
                                        </div>
                                        <div class="row mt-0">
                                            <div class="col-4">
                                                <label class="text-dark"><strong>Telephone Number:</strong></label>
                                            </div>
                                            <div class="col-8">
                                                @if ($applicantInfo->telephone_number != null)
                                                    <label class="text-dark">{{ $applicantInfo->telephone_number }}</label>   
                                                @else
                                                    <label class="text-dark">N/A</label>
                                                @endif
                                                
                                            </div>
                                        </div>
                                        <div class="row mt-0">
                                            <div class="col-4">
                                                <label class="text-dark"><strong>Foreign National?</strong></label>
                                            </div>
                                            <div class="col-8">
                                                @if ($applicantInfo->is_foreign == true)
                                                    <label class="text-dark">YES</label>
                                                @else
                                                    <label class="text-dark">NO</label>
                                                @endif
                                                
                                            </div>
                                        </div>
                                        <div class="row mt-0">
                                            <div class="col-4">
                                                <label class="text-dark"><strong>PRC Number:</strong></label>
                                            </div>
                                            <div class="col-8">
                                                @if ($applicantInfo->prc_number != null)
                                                    <label class="text-dark">{{ $applicantInfo->prc_number }} <code>&nbsp;(Valid until {{ Carbon\Carbon::parse($applicantInfo->prc_validity)->format('F d, Y') }})</code></label>   
                                                @else
                                                    <label class="text-dark">N/A</label>
                                                @endif
                                                
                                            </div>
                                        </div>
                                        <div class="row mt-0">
                                            <div class="col-4">
                                                <label class="text-dark"><strong>PMA Number:</strong></label>
                                            </div>
                                            <div class="col-8">
                                                @if ($applicantInfo->pma_number != null)
                                                    <label class="text-dark">{{ $applicantInfo->pma_number }}</label>   
                                                @else
                                                    <label class="text-dark">N/A</label>
                                                @endif
                                                
                                            </div>
                                        </div>
                                        
                                       
                             
                                        
                                        <div class="row mt-4">
                                            <div class="col-12">
                                               
                                                <button class="btn btn-outline-secondary mb-2 mt-lg-auto w-100" type="button" data-bs-toggle="modal" data-bs-target="#modal-notification"
                                                    name="button">APPROVE</button>
                                                    <button class="btn bg-gradient-danger mb-0 mt-lg-auto w-100" type="button" data-bs-toggle="modal" data-bs-target="#modalDisapprove"
                                                    name="button">DISAPPROVE</button>
                                            </div>
                                    
                                        </div>
    
                                        {{-- START OF MODAL APPROVE --}}
                                        <div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
                                            <div class="loading" id="loading" style="display: none;"> 
                                                <img src="{{ asset('assets') }}/img/pps-logo.png" style="height: 60px !important; width: 60px !important" alt="img-blur-shadow" class="icons">
                                            </div>
                                            <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header bg-danger">
                                                    <h6 class="text-white modal-title">APPROVE APPLICANT</h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                    
                                                      
                                                    </button>
                                                </div>
    
                                                {{-- <div class="spinner-border text-primary" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div> --}}
                                                <form method="POST" id="applicantSave" enctype="multipart/form-data">
                                                    @csrf
                                                <div class="modal-body">
                                                    <input type="hidden" id="token" value="{{ csrf_token() }}">
                                                    <input type="hidden" value="{{ url('accept-applicants') }}" id="urlAccept">
                                                    <input type="hidden" name="pps_no" value="{{ $applicantInfo->pps_no }}" id="pps_no">
                                                    <input type="hidden" name="first_name" id="first_name" value="{{ $applicantInfo->first_name }}">
                                                    <input type="hidden" name="last_name" id="last_name" value="{{ $applicantInfo->last_name }}">   
                                                    <input type="hidden" name="email_address" id="email_address" value="{{ $applicantInfo->email_address }}">
                                                    <input type="hidden" name="picture" id="picture" value="{{ $applicantInfo->picture }}">
                                                    <input type="hidden" name="password" id="password" value="123PPS">
                                                  
    
                                                {{-- <div class="row mt-3">
                                                    
                                                    <div class="col-lg-12 col-12 mt-1">
                                                        <label class="form-label text-bold">Status<code> <b>*</b></code></label>
                                                        <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                            <select name="member_status" id="member_status" class="form-control member_status" required>
                                                                <option value="">Choose</option>
                                                                <option value="MEMBER">MEMBER</option>
                                                                <option value="MEMBER">NON-MEMBER</option>
                                                               
                                                            </select>
                                                            </div>
                                                    </div>
                                                </div> --}}
    
                                               
    
                                                <div class="row mt-2">
                                                    
                                                    <div class="col-lg-12 col-12 mt-1">
                                                        <label class="form-label text-bold">Choose member type<code> <b>*</b></code></label>
                                                        <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                            <select name="member_type" id="member_type" class="form-control member_type" required>
                                                                <option value="">Choose</option>
                                                                @foreach ($member_type as $member_type2)
                                                                    <option value="{{ $member_type2->id }}">{{ $member_type2->member_type_name }}</option>
                                                                @endforeach
                                                               
                                                            </select>
                                                            </div>
                                                    </div>
                                                </div>
    
                                                {{-- <div class="row mt-2">
                                                    <div class="col-lg-12 col-12 mt-1">
                                                        <label class="form-label text-bold">Chapter Assign<code> <b>*</b></code></label>
                                                        <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                            <select name="member_chapter" id="member_chapter" class="form-control member_chapter" required>
                                                                <option value="">Choose</option>
                                                                @foreach ($chapter as $chapter2)
                                                                    <option value="{{ $chapter2->id }}">{{ $chapter2->chapter_name }}</option>
                                                                @endforeach
                                                               
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div> --}}
    
                                                <br>
                                                
    
                                        
                                                </div>
                                                <div class="modal-footer" style="border-top: none !important">
                                                  <button type="submit" class="btn btn-gradient btn-danger">Approve</button>
                                                  <button type="button" class="btn btn-link ml-auto" data-bs-dismiss="modal">Cancel</button>
                                                </div>
                                                </form>
                                              </div>
                                            </div>
                                          </div>
                                          {{-- END OF MODAL APPROVE --}}
    
    
                                        {{-- START MODAL DISAPPROVE --}}
                                        <div class="modal fade" id="modalDisapprove" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                                            <div class="loading" id="loading2" style="display: none;"> 
                                                <img src="{{ asset('assets') }}/img/pps-logo.png" style="height: 60px !important; width: 60px !important" alt="img-blur-shadow" class="icons">
                                            </div>
                                            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header" style="border-bottom: none !important">
                
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                      <span class="text-primary" aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body p-0">
                                                  <div class="card card-plain">
                                                    <div class="card-header pb-0 text-left">
                                                      <h5 class="text-gradient text-danger">DISAPPROVE {{ $applicantInfo->first_name }} {{ $applicantInfo->last_name }}?</h5>
                                                      <p class="mb-0">Fill up information below.</p>
                                                    </div>
                                                    <div class="card-body">
                                                      <form method="POST" role="form text-left" id="emailUpdateForm" enctype="multipart/form-data" action="{{ url('update-email') }}">
                                                        @csrf
                                                        {{-- HIDDEN INPUT --}}
                                                        <input type="hidden" id="pps_no2" name="pps_no" value="{{ $applicantInfo->pps_no }}">
                                                        <input type="hidden" id="token2" value="{{ csrf_token() }}">
                                                        <input type="hidden" value="{{ url('applicant-disapprove')}}" id="urlDisapprove2">
                                                        <input type="hidden" id="email_address2" name="email_address" value="{{ $applicantInfo->email_address }}">
                                                        <input type="hidden" id="first_name2" name="first_name" value="{{ $applicantInfo->first_name }}">
                                                        <input type="hidden" id="last_name2" name="last_name" value="{{ $applicantInfo->email_last_name }}">
                                                        <input type="hidden" id="disapprove_by2" name="disapprove_by" value="{{ auth()->user()->name }}">
                                                      
                                
                                                        {{-- END OF HIDDEN INPUT --}}
                                                        <div class="input-group input-group-outline my-3 is-filled" id="emailRowUpdate">
                                                          <label class="form-label">Reason</label>
                                                          <textarea class="form-control" rows="5" id="disapprove_reason2"></textarea>
                                                        
                                                        </div>
                                                       
                                                  
                                                        <div class="text-center">
                                                          <button id="disapproveBtn" type="button" class="btn btn-round bg-gradient-danger btn-lg w-100 mt-4 mb-0">Submit</button>
                                                        </div>
                                                        <br>
                                                      </form>
                                                    </div>
                                                    
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        {{-- END MODAL DISAPPROVE --}}
    
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
        if (document.getElementById('choices-quantity')) {
            var element = document.getElementById('choices-quantity');
            const example = new Choices(element, {
                searchEnabled: false,
                itemSelectText: ''
            });
        };

        if (document.getElementById('choices-material')) {
            var element = document.getElementById('choices-material');
            const example = new Choices(element, {
                searchEnabled: false,
                itemSelectText: ''
            });
        };

        if (document.getElementById('choices-colors')) {
            var element = document.getElementById('choices-colors');
            const example = new Choices(element, {
                searchEnabled: false,
                itemSelectText: ''
            });
        };

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
