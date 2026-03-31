
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="members" activeItem="listing" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="Listing"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->

      <div class="container-fluid px-2 px-md-4">
        <div class="loading" id="loading6"> 
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
        </div>
      </div>
      
      <div class="container-fluid py-4">
        <section class="py-3">
            <div class="row mb-4 mb-md-0">
                <div class="col-md-8 me-auto my-auto text-left">
                    {{-- <h5>Some of Our Awesome Projects</h5>
                    <p>This is the paragraph where you can write more details about your projects. Keep you user
                        engaged by <br> providing meaningful information.</p> --}}
                </div>
                <div class="col-lg-4 col-md-12 my-auto text-end">
                    <a type="button" href="/member-listing-all" class="btn bg-gradient-danger mb-0 mt-0 mt-md-n9 mt-lg-0">
                       Member List
                    </a>
                </div>
            </div>
            <div class="row mt-lg-4 mt-2">
                @foreach ($chapter as $chapter2)
                    <div class="col-lg-4 col-md-6 mb-5">
                        <div class="card h-100">
                            <div class="card-body p-3">
                                <div class="d-flex mt-n2">
                                    <div class="avatar avatar-xl bg-gradient-danger border-radius-xl p-2 mt-n4">
                                        <img src="{{ asset('assets') }}/img/pps-logo.png"
                                            alt="chapter logo">
                                    </div>
                                    <div class="ms-3 my-auto">
                                        <h6 class="mb-0 text-lg">{{ $chapter2->chapter_name }}</h6>
                                        @if ($chapter2->is_active == true)
                                            <span class="badge badge-success badge-sm">ACTIVE</span> 
                                        @else
                                            <span class="badge badge-danger badge-sm">INACTIVE</span>    
                                        @endif
                                       
                                       
                                    </div>
                                    <div class="ms-auto">
                                        <div class="dropdown">
                                            <button class="btn btn-link text-secondary ps-0 pe-2"
                                                id="navbarDropdownMenuLink" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-ellipsis-v text-lg"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end me-sm-n4 me-n3"
                                                aria-labelledby="navbarDropdownMenuLink">
                                                <a class="dropdown-item" href="member-listing-chapter/{{ Crypt::encrypt( $chapter2->id )}}">View</a>
                                                <a class="dropdown-item" href="javascript:;">Update</a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm mt-3">Sample description for PPS Chapter </p>
                                <hr class="horizontal dark">
                                <div class="row mb-0 mt-0" style="margin-bottom: -16px !important">
                                    <div class="col-6">
                                       
                                        <p class="text-secondary text-sm font-weight-bold mb-0">{{ $chapter2->member_count }} Member</p>
                                    </div>
                                    <div class="col-6 text-end mt-0 mb-0">
                                        <a class="btn btn-outline-danger btn-sm" href="member-listing-chapter/{{ Crypt::encrypt( $chapter2->id )}}" type="button" name="button">VIEW</a>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>   
                @endforeach
                    
            </div>
        </section>
        <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
      </div>
    </main>
    <x-plugins></x-plugins>
    <link href="{{ asset('assets') }}/css/loader.css" rel="stylesheet" />
  @push('js')
  <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('assets') }}/js/applicant-listing.js"></script>

  
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
  
  <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>

  <script>
    $(function(){
    $(window).on('load',function(){
        $('#loading6').hide();

    });
});
  </script>

    @endpush
  </x-page-template>
  