
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="reports" activeItem="view-reports" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="Reports"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->
      <div class="container-fluid py-4">
        

        <div class="row mt-1">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header p-3 pb-2 bg-danger" style="height: 80px !important">
                        <h6 class="mb-1 text-white">Reports</h6>
                        <p class="text-sm text-white">List of all reports.</p>
                    </div>
                    <div class="card-body pb-2">
                      <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                          <thead>
                            <tr>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Title</th>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Description</th>
                              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>

                              <th class="text-secondary opacity-7"></th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($reports as $reports2)
                            <tr>
                              <td>
                                <div class="d-flex px-2 py-1">
                               
                                  <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">{{ $loop->iteration }}. &nbsp;{{ $reports2->report_title }}</h6>
                                  
                                  </div>
                                </div>
                              </td>
                              <td>
                             
                                <p class="text-sm text-secondary mb-0">{{ $reports2->description }}</p>
                              </td>
                              <td class="align-middle text-center text-sm">
                                @if ($reports2->is_active == true)
                                  <span class="badge badge-sm badge-success">Active</span>
                                @else
                                  <span class="badge badge-sm badge-danger">Inactive</span>
                                @endif
                                
                              </td>
                             
                              <td class="align-middle text-center">
                                <button class="btn btn-sm bg-gradient-danger dropdown-toggle mt-3" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                  Action
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton"> 
                                    <li><a class="dropdown-item text-bold" href="/reports-choose/{{ Crypt::encrypt( $reports2->id )}}">
                                        <i class="fas fa-eye"></i>&nbsp; Generate Report
                                        </a>
                                    </li>  
                                </ul>
                              </td>
                            </tr>
                            @endforeach
                            
                  
                          </tbody>
                        </table>
                        <br>
                        {{ $reports->appends($_GET)->links('vendor.pagination.bootstrap-5') }}
                      </div>
                       
                    </div>
                </div>
            </div>
        </div>
      

      
      </div>
      <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
    </main>
    <x-plugins></x-plugins>
    <link href="{{ asset('assets') }}/css/loader.css" rel="stylesheet" />

  @push('js')
  <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
    @endpush
  </x-page-template>
  