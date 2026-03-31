
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="members" activeItem="listing" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="Listing"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->

      <div class="container-fluid px-2 px-md-4">
        <div class="loading" id="loading6" style="display: none !important"> 
            <img src="{{ asset('assets') }}/img/pps-logo.png" style="height: 60px !important; width: 60px !important" alt="img-blur-shadow" class="icons">
        </div>
        <div class="page-header min-height-150 border-radius-xl mt-4"
            style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
            <span class="mask bg-gradient-primary opacity-6"></span>
        </div>
        <div class="card card-body mx-3 mx-md-4 mt-n6">
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
                            List of chapters and members
                        </p>
                    </div>
                </div>
                
            </div>
            <div class="row mb-4 mb-md-0">
                <div class="col-md-8 me-auto my-auto text-left">
                    {{-- <h5>Some of Our Awesome Projects</h5>
                    <p>This is the paragraph where you can write more details about your projects. Keep you user
                        engaged by <br> providing meaningful information.</p> --}}
                </div>
                <div class="col-lg-4 col-md-12 my-auto text-end">
                    <a type="button" href="/member-listing" class="btn bg-gradient-danger mb-0 mt-0 mt-md-n9 mt-lg-0">
                       Chapter List
                    </a>
                </div>
            </div>

            <form class="form-horizontal" action="{{ route('member-search-listing-all') }}" method="GET" autocomplete="off">
                @csrf
                <div class="row mt-2">
                    <div class="col-lg-6 col-12">
                        <div class="input-group input-group-outline">
                            <label class="form-label">Search here..</label>
                            <input type="text" class="form-control" name="searchinput" id="search-input" style="height: 46px !important" value="{{ $name }}">
                            <button class="btn bg-gradient-danger btn-lg" id="searchBtn" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="row mt-0">
                <div class="col-12">

                    <div class="table-responsive">
                        <table class="table table-flush" >
                            <thead class="thead-light">
                                <tr>
                                    <th></th>
                                    <th>Member</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                   
                       
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($member as $member2 )
                                    <tr class="bg-gray-10">
                                        <td>
                                            <div class="mt-3">
                                                @if ( $member2->picture == null )
                                                    <img src="{{ asset('assets') }}/img/default-avatar.png"
                                                    class="avatar avatar-md me-4" style="height: 60px !important; width: 60px !important" alt="table image">
                                                @else
                                                    <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $member2->picture, now()->addMinutes(30))}}"
                                                    class="avatar avatar-md me-4" style="height: 60px !important; width: 60px !important" alt="table image">
                                                @endif
                                                
                                            </div>
         
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                        
                                                <a class="mb-2 text-sm text-primary" href="member-info/{{ Crypt::encrypt( $member2->pps_no )}}" style="font-weight: bold">{{ $member2->first_name }} {{ $member2->middle_name }} {{ $member2->last_name }} {{ $member2->suffix }}</a>
                                              
                                                <span class="mb-2 text-xs">Email Address: <span
                                                        class="text-dark ms-sm-2 font-weight-bold">{{ $member2->email_address }}</span></span>
                                                @if ($member2->prc_number == null)
                                                    <span class="mb-2 text-xs">PRC Number: <span
                                                        class="text-dark ms-sm-2 font-weight-bold">N/A</span></span>
                                                @else
                                                    <span class="mb-2 text-xs">PRC Number: <span
                                                        class="text-dark ms-sm-2 font-weight-bold">{{ $member2->prc_number }}</span></span>
                                                @endif
                                                
                                                {{-- <span class="mb-2 text-xs">Member Since: <span
                                                    class="text-dark font-weight-bold ms-sm-2">{{ Carbon\Carbon::parse($member2->member_approved_dt)->format('F d, Y') }}</span></span> --}}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class=" text-sm text-bold">{{ $member2->chapter_name }}</span><br>
                                            <span class=" text-sm">{{ $member2->member_type_name }}</span>
                                        </td>
                                        <td>
                                            @if ($member2->is_active == true)
                                                <span class="badge badge-sm badge-success mt-4">ACTIVE</span>
                                            @else
                                                <span class="badge badge-sm badge-danger mt-4">INACTIVE</span>
                                            @endif
                                            
                                        </td>
                                        <td>
                                            <a class="btn btn-icon btn-sm btn-danger w-100 mt-3" type="button" href="member-info/{{ Crypt::encrypt( $member2->pps_no )}}">
                                                <span class="btn-inner--icon"><i class="material-icons">visibility</i></span>
                                              <span class="btn-inner--text">VIEW</span>
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
      
      <div class="container-fluid py-4">
       
        <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
      </div>
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

  <script>
    


  </script>

    @endpush
  </x-page-template>
  