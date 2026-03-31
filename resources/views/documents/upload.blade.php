<x-page-template bodyClass='g-sidenav-show bg-gray-200'>
    <x-auth.navbars.sidebar activePage='documents' activeItem='documents-upload' activeSubitem=''></x-auth.navbars.sidebar>
    <main class="main-content main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-auth.navbars.navs.auth pageTitle='Checklist'></x-auth.navbars.navs.auth>
       
        <div class="container-fluid my-3 py-4">
            <div class="loading" id="loading3"> 
                <img src="{{ asset('assets') }}/img/pps-logo.png" style="height: 60px !important; width: 60px !important" alt="img-blur-shadow" class="icons">
            </div>

            <div class="row" style="margin-top: -20px !important" id="refreshDiv">
                <div class="col-lg-8 col-12">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <label class="text-bold">Documents</label>
                        </div>
                    </div>
                    <div class="row mt-3 mb-2">
                        {{-- START OF HIDDEN INPUT --}}
                        <input type="hidden" value="{{ url('documents-delete') }}" id="urlDeleteDocument">
                        {{-- END OF HIDDEN INPUT --}}
                        <div class="col-lg-4 col-12 mb-4">
                            <div class="card">
                                <div class="card-body p-3 pt-2">
                                    
                                    <div class="icon icon-lg icon-shape bg-gradient-info shadow text-center border-radius-xl mt-n4 position-absolute">
                                        <i class="material-icons opacity-10" aria-hidden="true">image</i>
                                    </div>
                                    <div class="text-end pt-1">
                                        <p class="text-sm mb-0 text-capitalize text-bold">IMAGE</p>
                                        <h4 class="mb-0" id="image_count" countto="{{ $image_count }}">{{ $image_count }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12 mb-4">
                            <div class="card">
                                <div class="card-body p-3 pt-2">
                                    <div class="icon icon-lg icon-shape bg-gradient-danger shadow text-center border-radius-xl mt-n4 position-absolute">
                                        <i class="material-icons opacity-10" aria-hidden="true">picture_as_pdf</i>
                                    </div>
                                    <div class="text-end pt-1">
                                        <p class="text-sm mb-0 text-capitalize text-bold">PDF</p>
                                        <h4 class="mb-0" id="pdf_count" countto="{{ $pdf_count }}">{{ $pdf_count }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12 mb-3">
                            <div class="card">
                                <div class="card-body p-3 pt-2">
                                    <div class="icon icon-lg icon-shape bg-gradient-warning shadow text-center border-radius-xl mt-n4 position-absolute">
                                        <i class="fas fa-file-word opacity-10" aria-hidden="true"></i>
                                    </div>
                                    <div class="text-end pt-1">
                                        <p class="text-sm mb-0 text-capitalize">OTHERS</p>
                                        <h4 class="mb-0" id="others_count" countto="{{ $other_count }}">{{ $other_count }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row" style="margin-top: -15px !important">
               
                        <div class="col-lg-12 col-12 mb-3">
                            <div class="row">
                                <div class="col-lg-12 col-12">
                                    <label class="text-bold">Recent Documents</label>
                                </div>
                            </div>
                            <div class="card">
                               
                                <div class="card-body">
                                    <div class="row mt-0">
                                        <div class="col-12 col-lg-12">
                                            <div class="table table-responsive">
                                                <table class="table align-items-center mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th
                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                                TYPE</th>
                                                            <th
                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                Document Name</th>
                                                            <th
                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                                DATE UPLOADED/TIME</th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($recent_documents as $recent_documents2)
                                                            <tr>
                                                                <td class="text-center">
                                                                    @if ($recent_documents2->file_type == 'PDF' || $recent_documents2->file_type == 'pdf')
                                                                        <img src="{{ asset('assets') }}/img/pdf-file.png" class="icon icon-md">
                                                                    @elseif($recent_documents2->file_type == 'PNG' || $recent_documents2->file_type == 'png')
                                                                        <img src="{{ asset('assets') }}/img/png-file.png" class="icon icon-md">
                                                                    @elseif($recent_documents2->file_type == 'JPG' || $recent_documents2->file_type == 'JPEG' || $recent_documents2->file_type == 'jpg' || $recent_documents2->file_type == 'jpeg')
                                                                        <img src="{{ asset('assets') }}/img/jpg-file.png" class="icon icon-md">
                                                                    @else
                                                                        <img src="{{ asset('assets') }}/img/docs-file.png" class="icon icon-md">
                                                                    @endif
                                                                    
                                                                </td>
                                                                <td>
                                                                    <a class="mb-1 text-dark text-sm text-bold" href="#">{{ $recent_documents2->document_name }}</a>
                                                                </td>
                                                                <td class="text-center">
                                                                    <p class="text-sm text-secondary mb-0">{{ $recent_documents2->upload_dt->format('F d, Y h: i a') }}</p>
                                                                </td>
                                                                
                                                            </tr>
                                                         
                                                        
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                                
                                            
                                          
                                        </div>
                                    </div>
                                  </div>
                            </div>
                        </div>
        
                        <div class="col-lg-4 col-12 mb-3">
                           
                        </div>
                       
                    </div>


                    
                </div>
                <div class="col-lg-4 col-12">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <div class="card">
                       
                                <div class="card-body">
                                    <div class="row gx-3">
                                        <div class="col-auto">
                                            <div class="avatar avatar-xl position-relative">
                                                <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $member->picture, now()->addMinutes(230))}}" alt="profile_image"
                                                    class="w-100 rounded-circle shadow-sm">
                                            </div>
                                        </div>
                                        <div class="col-auto my-auto">
                                            <div class="h-100">
                                                <h6 class="mb-1">
                                                    {{ $member->first_name }} {{ $member->middle_name }} {{ $member->last_name }} {{ $member->suffix }}
                                                </h6>
                                                <p class="mb-0 font-weight-normal text-sm text-success">
                                                    {{ $member->type }}
                                                </p>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <button class="btn btn-icon btn-danger w-100" style="height: 35px !important;" type="button" data-bs-toggle="modal" data-bs-target="#modalUploadDocument">
                                                <span class="btn-inner--icon"><i class="material-icons">add</i></span>
                                                <span class="btn-inner--text">&nbsp;UPLOAD DOCUMENT</span></button>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mt-4">
                                        <div class="col-8">
                                            <h6 class="mb-0">Checklist</h6>
                                        </div>
                                        <div class="col-4" style="text-align: right !important">
                                            <h6 class="mb-0">{{ $countChecklistChecked }}/{{ $checklist_count }}</h6>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-lg-12 col-12">
                                            <ul class="list-group">
                                                @foreach ($checklist as $checklist3)
                                                    
                                                
                                                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon icon-shape me-2 bg-gradient-danger shadow text-center">
                                                            <i class="fas fa-file-alt opacity-10 pt-1"></i>
                                                        </div>
                                                        <div class="d-flex flex-column">
                                                            <a class="mb-1 text-dark text-sm text-bold" href="#" data-bs-toggle="modal" data-bs-target="#modalViewDocument{{ $checklist3->id }}">{{ $checklist3->document_name }}</a>
                                                            @switch($checklist3->document_count)
                                                                @case(0)
                                                                <span class="text-xs text-danger">0 DOCUMENTS</span>
                                                                    @break
                                                            
                                                                @default
                                                                <span class="text-xs text-success">{{ $checklist3->document_count }} DOCUMENTS</span>
                                                            @endswitch
                                                            

                                                        </div>
                                                    </div>
                                                    <div class="d-flex mt-2">
                                                        @switch($checklist3->document_count)
                                                            @case(0)
                                                            <button class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 p-3 btn-sm d-flex align-items-center justify-content-center">
                                                                <i class="material-icons text-lg">close</i>
                                                            </button>
                                                                @break
                                                            @default
                                                            <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 p-3 btn-sm d-flex align-items-center justify-content-center">
                                                                <i class="material-icons text-lg">done</i>
                                                            </button>
                                                        @endswitch
                                                        
                                                    </div>
                                                </li>
                                               {{-- START MODAL VIEW DOCUMENT --}}
                                                <div class="modal fade" id="modalViewDocument{{$checklist3->id}}" tabindex="-1" role="dialog" aria-labelledby="modalViewDocument" aria-hidden="true">
                                                   
                                                    <div class="modal-dialog modal-dialog-scrollable modal-danger modal-dialog-centered modal-lg" role="document">
                                                    <div class="modal-content">
                                                    
                                                        <div class="modal-header bg-gradient-danger">
                                                        <h6 class="modal-title font-weight-bold" id="modal-title-notification" style="color: white !important">{{$checklist3->document_name}}</h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                            
                                                        </button>
                                                        </div>
                                                        <div class="modal-body" id="deleteRefresh">
                                                            

                                                            @foreach ($document as $document2)
                                                                @if ($document2->document_id == $checklist3->id)
                                                               
                                                                    <div class="row">
                                                                        <div class="col-12 col-md-12 col-lg-12 text-center">
                                                                           
                                                                            <iframe frameborder="0" style="width: 90%;height: 100vh;" src="{{Storage::disk('s3')->temporaryUrl('checklist/' . $document2->file_name, now()->addMinutes(30))}}#toolbar=0"></iframe>
                                                                            <br>
                                                                            <p class="text-sm text-bold">{{ $document2->original_file_name }}</p>
                                                                            <p class="text-sm text-bold" style="margin-top: -15px !important">Date and Time Uploaded: {{ Carbon\Carbon::parse($document2->upload_dt)->format('F d, Y h:i A') }}</p>
                                                                            <p class="text-sm text-bold" style="margin-top: -15px !important">Uploaded By: {{ $document2->created_by }}</p>
                                                                        </div>

                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-1 col-lg-1"></div>
                                                                        <div class="col-5 col-lg-5">
                                                                            <a class="btn btn-icon btn-outline-success w-100"  href="/documents-download/{{  $document2->file_name }}">
                                                                                <span class="btn-inner--icon"><i class="material-icons">download</i></span>
                                                                                <span class="btn-inner--text">&nbsp;Download</span>
                                                                            </a>
                                                                        </div>
                                                                        <div class="col-5 col-lg-5">
                                                                            <button class="btn btn-icon btn-danger w-100 deleteid" id="{{ $document2->id }}">
                                                                                <span class="btn-inner--icon"><i class="material-icons">close</i></span>
                                                                                <span class="btn-inner--text">&nbsp;Delete</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="col-1 col-lg-1"></div>
                                                                    </div>
                                                                    <br>
                                                                    <hr>
                                                                    <br>
                                                                    
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                        
                                                    </div>
                                                    </div>
                                                </div>
                                                {{-- END OF MODAL VIEW DOCUMENT --}}
                                               
                                                @endforeach
                                               
                                                
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- START MODAL UPLOAD DOCUMENT --}}
                <div class="modal fade" id="modalUploadDocument" tabindex="-1" role="dialog" aria-labelledby="modalUploadDocument" aria-hidden="true">
                    <div class="loading" id="loading5" style="display: none;"> 
                        <img src="{{ asset('assets') }}/img/pps-logo.png" style="height: 60px !important; width: 60px !important" alt="img-blur-shadow" class="icons">
                    </div>
                    <div class="modal-dialog modal-dialog-scrollable modal-danger modal-dialog-centered modal-lg" role="document">
                      <div class="modal-content">
                       
                        <div class="modal-header bg-gradient-danger">
                          <h6 class="modal-title font-weight-bold" id="modal-title-notification" style="color: white !important">UPLOAD DOCUMENTS</h6>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            
                          </button>
                        </div>
                        <div class="modal-body">
                           
                            <div class="row mt-0">
                                <div class="col-12">
                                    <form method="POST" role="form text-left" id="documents-upload" enctype="multipart/form-data">
                                         {{-- Start of hiddem input --}}
                                         <input type="hidden" value="{{ url('documents-upload-submit') }}" id="urlDocumentsUpload">
                                         <input type="hidden" id="token2" name="token2" value="{{ csrf_token() }}">
                                         <input type="hidden" value="{{ $member->pps_no }}" name="pps_no" id="pps_no">
                                        {{-- End of hidden input --}}
                                        
                                        <div class="row mt-3">
                                            <div class="col-lg-7 col-12 mb-2">
                                                <label class="form-label text-bold">Documents<code> <b>*</b></code></label>
                                                <div class="form-group border border-radius-lg">
                                                    <input type="file" name="images[]" id="images" required multiple >
                                                </div>
                                            </div>
                                            <div class="col-lg-5 col-12 mt-1">
                                                <label class="form-label text-bold">Category<code> <b>*</b></code></label>
                                                <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                    <select name="document_id" id="document_id" class="form-control document_id" required>
                                                        <option value="">Choose</option>
                                                        @foreach ($checklist as $checklist2)
                                                            <option value="{{ $checklist2->id }}">{{ $checklist2->document_name }}</option>
                                                        @endforeach
                                                    </select>
                                                  </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 col-lg-12">
                                                <div class="form-group">
                                                    <div id="image_preview">
                                                    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12" style="text-align: right !important">
                                                <button type="submit" class="btn bg-gradient-danger btn-lg mt-4 mb-3">Upload</button>
                                                <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn bg-gradient-warning btn-lg mt-4 mb-3">Cancel</button>
                                            </div>  
                                        </div>
                                          
                                         
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                      </div>
                    </div>
                  </div>
                {{-- END OF MODAL UPLOAD DOCUMENT --}}
            </div>


              



         
            <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
        </div>
    </main>
    
    <x-plugins></x-plugins>
    <link href="{{ asset('assets') }}/css/loader.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/documents-upload.css" rel="stylesheet" />
    @push('js')
    <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets') }}/js/select2.min.js"></script>
    <link href="{{ asset('assets') }}/css/select2.min.css" rel="stylesheet" />
    <script src="{{ asset('assets') }}/js/documents-upload.js"></script>
    <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/choices.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/photoswipe.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/photoswipe-ui-default.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/countup.min.js"></script>

    <!-- Kanban scripts -->

    {{-- <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script> --}}


  
    @endpush
</x-page-template>
