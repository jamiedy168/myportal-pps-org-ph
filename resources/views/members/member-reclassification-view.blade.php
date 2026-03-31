
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="members" activeItem="reclassification" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="View Application"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->

    
      <div class="container-fluid my-3 py-4">

        
        <div class="row" style="margin-top: -20px !important">
            <div class="col-lg-4 col-12 h-100" >
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="card ">
                            <div class="card-body">
                                <div class="row gx-3">
                                    <div class="col-auto">
                                        <div class="avatar avatar-xl position-relative">
                                            @if ($reclassification->picture == null)
                                                <img src="{{ asset('assets') }}/img/pps-logo.png"
                                                   class="w-100 rounded-circle shadow-sm" alt="image">
                                            @else
                                                <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $reclassification->picture, now()->addMinutes(230))}}"
                                                class="w-100 rounded-circle shadow-sm" alt="image">
                                            @endif
                                            
                                        </div>
                                    </div>
                                    <div class="col-auto my-auto">
                                        <div class="h-100">
                                            <h5 class="mb-1 text-danger">
                                                {{ $reclassification->first_name }} {{ $reclassification->middle_name }} {{ $reclassification->last_name }} {{ $reclassification->suffix }}
                                            </h5>
                                            <p class="mb-0 font-weight-normal text-sm text-secondary">
                                                PRC Number: {{ $reclassification->prc_number }}
                                            </p>
                                            <p class="mb-0 font-weight-normal text-sm text-secondary">
                                                Chapter: {{ $reclassification->chapter_name }}
                                            </p>
                                        </div>
                                    </div>
                                    
                                </div>

                               
                                <hr>

                                <div class="row">
                                    <div class="col-md-12 col-12 mb-md-0 mb-4">
                                        <div class="card card-body border card-plain border-radius-lg ">
                                            <p style="text-align: center !important" class="text-md text-bold"> MEMBER TYPE </p>
                                            <h4 class="mb-0" style="text-align: center !important; font-size: 27px !important">
                                                {{ $reclassification->member_type_name }}
                                            </h4>
                                           
                                           
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-12 h-100">
                <div class="card">
                    <div class="card-header text-center bg-danger" style="height: 60px !important">
                        @if ($reclassification->member_type_name == 'RESIDENT/TRAINEES')
                            <h5 style="color: white !important">RESIDENCY CERTIFICATE</h5>
                        @elseif ($reclassification->member_type_name == 'GOVERNMENT_PHYSICIAN')    
                            <h5 style="color: white !important">GOVERNMENT PHYSICIAN CERTIFICATE</h5>
                        @elseif ($reclassification->member_type_name == 'FELLOWS-IN-TRAINING')    
                            <h5 style="color: white !important">FELLOWS-IN-TRAINING CERTIFICATE</h5>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 text-center">
                                <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $reclassification->file_name, now()->addMinutes(230))}}"  class="img-fluid" >
                               
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#modalApprove">APPROVE</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 

            <!-- Start of Approve Modal -->
            <div class="modal fade" id="modalApprove" tabindex="-1" role="dialog" aria-labelledby="exampleModalSignTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content"  style="background: #fff !important;">
                        <div class="modal-body p-0">
                            <div class="card card-plain">
                                <div class="card-header ">
                                    <div class="row">
                                        <div class="col-11">
                                            <h5 class="text-gradient text-danger">Choose Member Type</h5>
                                        </div>
                                        <div class="col-1">
                                            <button style="text-align: right !important" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                <span class="text-primary" aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form method="POST" id="form_reclassification_submit" enctype="multipart/form-data">
                                        @csrf
                                        <hr class="horizontal dark mt-0 mb-4"  style="margin-top: -25px !important">
                                        <input type="hidden" name="file_name" id="file_name" value="{{ $reclassification->file_name }}">
                                        <input type="hidden" name="pps_no" id="pps_no" value="{{ $reclassification->pps_no }}">
                                        <input type="hidden" name="reclassification_id" id="reclassification_id" value="{{ $reclassification->id }}">
                                        <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">
                                        <input type="hidden" value="{{ url('member-reclassification-save') }}" id="urlMemberReclassificationSave">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <select name="member_type_id" id="member_type_id" class="form-control member_type_id" required>
                                                    <option value="">Choose</option>
                                                    @foreach ($member_type as $member_type2)
                                                        <option value="{{ $member_type2->id }}" {{ $member_type2->id == $reclassification->member_type ? 'selected' : '' }}>{{ $member_type2->member_type_name }}</option>
                                                    @endforeach
                                            
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12" style="text-align: right !important">
                                                <button class="btn btn-danger" type="submit">Save</button>
                                                <button class="btn btn-warning" type="button" data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                    
                                </div>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End of Approve Modal --}}
        <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
      </div>
    </main>
    <x-plugins></x-plugins>
    <link href="{{ asset('assets') }}/css/loader.css" rel="stylesheet" />
  @push('js')
  <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/datatables.js"></script>
  <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
  <script src="{{ asset('assets') }}/js/member-reclassification.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>
  <script src="{{ asset('assets') }}/js/select2.min.js"></script>
  <link href="{{ asset('assets') }}/css/select2.min.css" rel="stylesheet" />
  <link href="{{ asset('assets') }}/css/user-maintenance.css" rel="stylesheet" />

    @endpush
  </x-page-template>
  