
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="members" activeItem="reclassification" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="Listing"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->

      <div class="container-fluid">
        <div class="row mt-6">
            <div class="col-md-12">
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
                                    List of member with re-classification
                                </p>
                            </div>
                        </div>
                        
                    </div>
         
        
                    <form class="form-horizontal" action="{{ route('member-reclassification-search') }}" method="GET" autocomplete="off">
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
                                        @foreach ($reclassificationList as $reclassificationList2 ) 
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        @if ($reclassificationList2->picture == null)
                                                        <img src="{{ asset('assets') }}/img/pps-logo.png"
                                                            class="avatar avatar-md me-3" alt="image">
                                                        @else
                                                        <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $reclassificationList2->picture, now()->addMinutes(230))}}"
                                                        class="avatar avatar-md me-3" alt="image">
                                                        @endif
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $reclassificationList2->first_name }} {{ $reclassificationList2->middle_name }} {{ $reclassificationList2->last_name }} {{ $reclassificationList2->suffix }}   
                                                        </h6>
                                                    
                                                        @if ($reclassificationList2->prc_number == null)
                                                            <p class="text-sm"><b class="text-danger">PRC No.: </b> N/A</p>
                                                        @else
                                                        <p class="text-sm"><b class="text-danger">PRC No.: </b>{{ $reclassificationList2->prc_number }}</p>    
                                                        @endif
                                                        
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="text-center align-middle">
                                               {{ $reclassificationList2->member_type_name }}
                                            </td>
                                            
                                            <td style="text-align: center !important">
                                                <a href="member-reclassification-view/{{ Crypt::encrypt( $reclassificationList2->id )}}" class="btn btn-icon btn-danger btn-outline-danger mt-3" style="height: 35px !important;" type="button">
                                                    <span class="btn-inner--icon"><i class="material-icons">visibility</i></span>
                                                    <span class="btn-inner--text">&nbsp;VIEW APPLICATION</span>
                                                </a>
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                             
                                </table>
                            </div>
                            <br>
                            {{ $reclassificationList->appends($_GET)->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    </div>
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
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/datatables.js"></script>
  <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>

  <script>
    


  </script>

    @endpush
  </x-page-template>
  