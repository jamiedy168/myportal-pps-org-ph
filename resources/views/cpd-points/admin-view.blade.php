<x-page-template bodyClass='g-sidenav-show bg-gray-200'>
    <x-auth.navbars.sidebar activePage='cpdpoints' activeItem='cpdpoints-admin-view' activeSubitem=''></x-auth.navbars.sidebar>
    <main class="main-content main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-auth.navbars.navs.auth pageTitle='CPD Points'></x-auth.navbars.navs.auth>
       
        <div class="container-fluid my-3 py-4">
            <div class="row mt-0" style="margin-top: -15px !important">
                <div class="col-lg-12 col-12 mb-3">
                    <div class="card">
                       
                        <div class="card-body">
                            <div class="row mt-0">
                                <div class="col-12">
                                    <form class="form-horizontal" action="{{ route('cpdpoints-admin-view-search') }}" method="GET" autocomplete="off">
                                        @csrf
                                        <div class="row mt-4">
                                            <div class="col-lg-6"></div>
                                            <div class="col-lg-6 col-12">
                                                <div class="input-group input-group-outline">
                                                    <label class="form-label">Search here..</label>
                                                    <input type="text" class="form-control" name="searchinput" id="searchbox-input" value="{{ $name }}" style="height: 46px !important">
                                                    <button class="btn bg-gradient-danger btn-lg" type="submit" id="searchBtn"><i class="fas fa-search"></i></button>
                                                    </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="table table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Member
                                                       </th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Type
                                                    </th>   
                                                  

                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" style="text-align: center !important">
                                                        Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($member as $member2)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex px-2 py-1">
                                                                <div>
                                                                    @if ($member2->picture == null)
                                                                    <img src="{{ asset('assets') }}/img/pps-logo.png"
                                                                        class="avatar avatar-md me-3" alt="image">
                                                                    @else
                                                                    <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $member2->picture, now()->addMinutes(230))}}"
                                                                    class="avatar avatar-md me-3" alt="image">
                                                                    @endif
                                                                </div>
                                                                <div class="d-flex flex-column justify-content-center">
                                                                    <h6 class="mb-0 text-sm">{{ $member2->first_name }} {{ $member2->middle_name }} {{ $member2->last_name }} {{ $member2->suffix }}   
                                                                    </h6>
                                                                
                                                                    @if ($member2->prc_number == null)
                                                                        <p class="text-sm"><b class="text-danger">PRC No.: </b> N/A</p>
                                                                    @else
                                                                    <p class="text-sm"><b class="text-danger">PRC No.: </b>{{ $member2->prc_number }}</p>    
                                                                    @endif
                                                                    
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td class="text-center">
                                                           {{ $member2->member_type_name }}
                                                            
                                                        </td>
                                                        
                                                        <td style="text-align: center !important">
                                                            <a href="cpdpoints-admin-view-member/{{ Crypt::encrypt( $member2->pps_no )}}" class="btn btn-icon btn-danger btn-outline-danger w-100 mt-3" style="height: 37px !important;" type="button">
                                                                <span class="btn-inner--icon"><i class="material-icons">visibility</i></span>
                                                                <span class="btn-inner--text">&nbsp;VIEW CPD</span>
                                                            </a>
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <br>
                                    {{ $member->appends($_GET)->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
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
    <script src="{{ asset('assets') }}/js/event-attendance.js"></script>
    <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/choices.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/photoswipe.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/photoswipe-ui-default.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>

    <!-- Kanban scripts -->

    {{-- <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script> --}}


  
    @endpush
</x-page-template>
