
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="maintenance" activeItem="user-maintenance" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="User Maintenance"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->

      <div class="loading" id="loading" style="display: none !important"> 
        <img src="{{ asset('assets') }}/img/pps-logo.png" style="height: 60px !important; width: 60px !important" alt="img-blur-shadow" class="icons">
      </div>

      <div class="container-fluid py-4">
    
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-4">List of PPS User</h5>

                        <form class="form-horizontal" action="{{ route('user-maintenance-search-user') }}" method="GET" autocomplete="off">
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

                        <div class="row mb-0 mt-2">
                            <div class="col-lg-12 col-md-12 col-12 my-auto text-end">
                                <button type="button" type="button" class="btn bg-gradient-danger"  data-bs-toggle="modal" data-bs-target="#modalNewUser">
                                   ADD NEW USER
                                </button>
                            </div>
                        </div>

                        {{-- START MODAL NEW USER --}}
                        <div class="modal fade" id="modalNewUser" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                              <div class="modal-content">
                                <div class="modal-header bg-danger" style="border-bottom: none !important">
                                    <h6 class="text-white">NEW USER</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                     
                                    </button>
                                </div>
                                <div class="modal-body p-0">
                                  <div class="card card-plain">
                                 
                                    <div class="card-body">
                                        <div class="row mt-3">
                                            <div class="col-lg-12 col-12 mt-1">
                                                <label class="form-label text-bold">Please choose type of user<code> <b>*</b></code></label>
                                                <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                    <select name="user_type" id="user_type" class="form-control user_type" required>
                                                        <option value="">Choose</option>
                                                        <option value="PPS MEMBER">PPS MEMBER</option>
                                                        <option value="HOSPITAL">HOSPITAL</option>
                                                        <option value="ATTENDANCE">ATTENDANCE ADMIN</option>
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-12" style="text-align: right !important">
                                                <button class="btn btn-danger" type="button" id="userTypeBtn">PROCEED</button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        {{-- END MODAL NEW USER --}}
                        
                        <div class="row mt-0">
                            <div class="col-12">

                                <div class="table-responsive">
                                    <table class="table table-flush" >
                                        <thead class="thead-light">
                                            <tr>
                                                <th></th>
                                                <th>Name</th>
                                                <th class="text-center">Username / Email</th>
                                                <th class="text-center">Member Type</th>
                                                <th class="text-center">PRC #</th>
                                                <th class="text-center">Status</th>
                                                <th></th>
                                               
                                   
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($userList as $userList2 )
                                                <tr class="bg-gray-10">
                                                    <td>
                                                        <div class="mt-3">
                                                            @if ( $userList2->picture == null )
                                                                <img src="{{ asset('assets') }}/img/default-avatar.png"
                                                                class="avatar avatar-md me-4" style="height: 60px !important; width: 60px !important" alt="table image">
                                                            @else
                                                                <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $userList2->picture, now()->addMinutes(30))}}"
                                                                class="avatar avatar-md me-4" style="height: 60px !important; width: 60px !important" alt="table image">
                                                            @endif
                                                            
                                                        </div>
                     
                                                    </td>
                                                    <td>
                                                        
                                                        <div class="d-flex flex-column">
                                                            @if ($userList2->first_name == null)
                                                                <a class="mb-1 mt-2 text-danger" href="javascript:void(0);" style="font-weight: bold">{{ $userList2->name }}</a>
                                                            @else
                                                            <a class="mb-1 mt-2 text-danger" href="javascript:void(0); " style="font-weight: bold">{{ $userList2->first_name }} {{ $userList2->middle_name }} {{ $userList2->last_name }}</a>
                                                            @endif
                                                          
                                                            <span class="text-sm">Role: <span
                                                                class="text-dark ms-sm-2 font-weight-bold">{{ $userList2->roles_name }}</span></span>
                                        
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex flex-column">
                                                            <label class="mt-4">{{ $userList2->email }}</label>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($userList2->member_type_name == null)
                                                            <label class="mt-4">N/A</label>
                                                        @else
                                                            <label class="mt-4">{{ $userList2->member_type_name }}</label>
                                                        @endif
                                                        
                                                       
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($userList2->prc_number == null)
                                                            <label class="mt-4">N/A</label>
                                                        @else
                                                            <label class="mt-4">{{ $userList2->prc_number }}</label>
                                                        @endif
                                                        
                                                       
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($userList2->is_active == true)
                                                        <span class="badge badge-sm badge-success ms-auto mt-4">ACTIVE</span>
                                                        @else
                                                            <span class="badge badge-sm badge-danger ms-auto mt-4">INACTIVE</span>
                                                        @endif
                                                       
                                                    </td>
                                                    <td class="text-sm">
                                                        <input type="hidden" value="{{ url('user-maintenance-reset-password') }}" id="urlUserMaintenanceResetPassword">
                                                        <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">
                                                        @if ($userList2->role_id == 5)
                                                            
                                                        @endif
                                                        <button class="btn bg-gradient-danger dropdown-toggle mt-3" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton"> 
                                                            @if ($userList2->role_id != 5)
                                                                <li><a class="dropdown-item text-bold" href="user-maintenance-edit/{{ Crypt::encrypt( $userList2->pps_no )}}">Update</a></li>
                                                            @endif
                                                            
                                                            <li><a class="dropdown-item text-bold" id="{{ $userList2->id }}" onClick="reset_password(this.id)"  href="#">Reset Password</a></li>
                                                            
                                                        </ul>
                                                      
                                                    </td>
                                                </tr>
                                            @endforeach
                                      
                                        </tbody>
                                 
                                    </table>
                                </div>
                                <br>
                                {{ $userList->appends($_GET)->links('vendor.pagination.bootstrap-5') }}
                                
                                {{-- <div class="table table-responsive">
                                    <table class="table align-items-center mb-0" id="user-data-table">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                </th>
                                                <th
                                                    class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                                    Name
                                                </th>
                                            
                                                <th
                                                    class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                                    Role
                                                </th>
                                                <th
                                                    class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                                    Username/Email
                                                </th>
                                                <th
                                                    class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                                    Position
                                                </th>
                                        

                                            </tr>
                                        </thead>
                                        <tbody>
                                           @foreach ($userList as $userList2)
                                            <tr>
                                                <td style="text-align: center !important">
                                                    @if ($userList2->picture == null)
                                                        <img src="{{ asset('assets') }}/img/pps-logo.png"
                                                        class="avatar avatar-md" alt="profile image">
                                                    @else
                                                        <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $userList2->picture, now()->addMinutes(30))}}"
                                                        class="avatar avatar-md" alt="profile image">
                                                    @endif
                                                   
                                                </td>
                                                <td>
                                                  @if ($userList2->first_name == null)
                                                  <h6 class="mb-0 text-secondary">{{ $userList2->name }}</h6>
                                                  @else
                                                  <h6 class="mb-0 text-secondary">{{ $userList2->first_name }} {{ $userList2->middle_name }} {{ $userList2->last_name }}</h6>
                                                  @endif
                                                </td>
                                                
                                                <td>
                                                    <span class="text-secondary text-sm">{{ $userList2->roles_name }}</span>
                                                </td>
                                                <td>
                                                    <span class="text-secondary text-sm">{{ $userList2->email }}</span>
                                                </td>
                                                
                                                <td>
                                                    <button class="btn bg-gradient-danger dropdown-toggle mt-3" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <li><a class="dropdown-item text-bold" href="user-maintenance-edit/{{ Crypt::encrypt( $userList2->pps_no )}}">Update</a></li>
                                                        <li><a class="dropdown-item text-bold" href="#">Reset Password</a></li>
                                                        
                                                    </ul>
                                                     
                                                     
                                                </td>
                                            </tr>
                                          
                                            @endforeach
                                 
                                          
                                        </tbody>
                                    </table>
                                </div> --}}
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
  <link href="{{ asset('assets') }}/css/user-maintenance.css" rel="stylesheet" />
  <script src="{{ asset('assets') }}/js/user-maintenance.js"></script>
  {{-- <script src="{{ asset('assets') }}/js/user-maintenance-data-table.js"></script> --}}
  <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/datatables.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/choices.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>


    @endpush
  </x-page-template>
  