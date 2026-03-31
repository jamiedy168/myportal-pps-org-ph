
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="voting" activeItem="listing" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="Listing"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->

      <div class="container-fluid px-2 px-md-4">
        
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
                            List of all election
                        </p>
                    </div>
                </div>
                
            </div>
        </div>
      </div>
      
      <div class="container-fluid py-4">
        <section class="py-3">

            <input type="hidden" id="token2" name="token2" value="{{ csrf_token() }}">
            <input type="hidden" value="{{ url('voting-check-allowed') }}" id="urlVotingCheckAllowed">
            
            <div class="row mt-lg-4 mt-2">
                @foreach ($voting as $votingList)
                    <div class="col-lg-4 col-md-6 mb-5">
                        <div class="card h-100">
                            <div class="card-body p-3">
                                <div class="d-flex mt-n2">
                                    <div class="avatar avatar-xl bg-gradient-danger border-radius-xl p-2 mt-n4">
                                        <img src="{{ asset('assets') }}/img/pps-logo.png"
                                            alt="chapter logo">
                                    </div>
                                    <div class="ms-3 my-auto">
                                        <h6 class="mb-0 text-lg">{{ $votingList->title }}</h6>
                                        <span class="badge badge-warning badge-sm">{{ $votingList->status }}</span> 
                                 
                                       
                                       
                                    </div>
                                    {{-- <div class="ms-auto">
                                        <div class="dropdown">
                                            <button class="btn btn-link text-secondary ps-0 pe-2"
                                                id="navbarDropdownMenuLink" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-ellipsis-v text-lg"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end me-sm-n4 me-n3"
                                                aria-labelledby="navbarDropdownMenuLink">
                                                <a class="dropdown-item">View</a>
                                                @if (auth()->user()->role_id == 1)
                                                 <a class="dropdown-item" href="javascript:;">Update</a>
                                                 @endif

                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                                <p class="text-sm mt-3">{{ $votingList->description }}</p>
                                <p class="mb-0 text-uppercase text-secondary text-xs text-bold opacity-7">
                                    {{Carbon\Carbon::parse($votingList->date_from)->format('M. d, Y')}}  - {{Carbon\Carbon::parse($votingList->date_to)->format('M. d, Y')}}
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    {{Carbon\Carbon::parse($votingList->time_from)->format('h:i a')}}  - {{Carbon\Carbon::parse($votingList->time_to)->format('h:i a')}}
                                </p>
                                <hr class="horizontal dark">
                                <div class="row mb-0 mt-0" style="margin-bottom: -16px !important">
                                    <div class="col-6">
                                        <p class="text-secondary text-sm font-weight-bold mb-0">{{ $votingList->candidate_count }} CANDIDATES</p>
                                    </div>
                                    <div class="col-6 text-end mt-0 mb-0">
                                        @if(auth()->user()->role_id == 1)
                                            <a class="btn btn-outline-danger btn-sm" type="button" name="button" href="voting-details/{{ Crypt::encrypt( $votingList->id )}}">VIEW</a>
                                        @else
                                            @if ($member->member_type_name == "DIPLOMATE" || $member->member_type_name == "FELLOW" || $member->member_type_name == "EMERITUS FELLOW")
                                               @if ($votingList->transcount == 0)
                                                    @if($votingList->status == "ONGOING")
                                                        <a class="btn btn-outline-danger btn-sm votenow" type="button" name="button" href="#" id="{{ $votingList->id }}" >VOTE NOW</a>
                                                    @else
                                                        <button class="btn btn-outline-danger btn-sm" disabled type="button" onclick="votingClose()">VOTE NOW</button>
                                                    @endif
                                                   
                                                @else
                                                    <a href="/voting-details/{{ Crypt::encrypt( $votingList->id )}}" class="btn btn-outline-danger btn-sm" type="button" name="button">VIEW</a>    
                                                @endif
                                            @else
                                            <a class="btn btn-outline-danger btn-sm" type="button" name="button" href="#" onclick="notallowedvote()">VOTE NOW</a>
                                                {{-- <a class="btn btn-outline-danger btn-sm" type="button" name="button" href="voting-elect/{{ Crypt::encrypt( $votingList->id )}}" >VOTE NOW</a> --}}
                                                
                                                
                                            @endif
                                            
                                            
                                        @endif
                                        
                                        
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

  
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/datatables.js"></script>
  <script src="{{ asset('assets') }}/js/vote-listing.js"></script>
  <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>


  <script>
    @if (Session::has('status'))
        @if (Session::get('status') == 'alreadyvoted')
            Swal.fire("Warning", "You already done voting in this election", "warning");
        @elseif (Session::get('status') == 'existannualdues')
            Swal.fire("Warning", "You have remaining annual dues that need to pay before casting your vote", "warning"); 
        @elseif (Session::get('status') == 'notjoined')
            Swal.fire("Warning", "You need to join/pay the annual convention first.", "warning"); 
        @elseif (Session::get('status') == 'paymenttimenotmeet')
            Swal.fire("Unable to vote!", "Sorry you did not meet the required date/time payment for annual convention.", "warning"); 
            
        @endif
    
    @endif
</script>
  
    @endpush
  </x-page-template>
  