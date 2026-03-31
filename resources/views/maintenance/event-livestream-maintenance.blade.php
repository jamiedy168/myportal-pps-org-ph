
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="maintenance" activeItem="event-livestream-maintenance" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="Livestream Maintenance"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->
      <div class="container-fluid py-4">
        <div class="row mt-2">
            <div class="col-lg-12 col-12">
                <div class="card">
                    <div class="card-header pb-0 px-3">
                        <h6 class="mb-0">LIST OF EVENT</h6>
                    </div>
                    <div class="card-body pt-4 p-3 mb-2">
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="table-responsive">
                                    <table class="table align-items-center mb-0">
                                      <thead>
                                        <tr>
                                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Event Tile</th>
                                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date/Time</th>
                                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                          <th class="text-secondary opacity-7 text-center"></th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($event as $event2)
                                            <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <h6 class="mb-0">{{ $event2->title }}</h6>
                                                </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{Carbon\Carbon::parse($event2->start_dt)->format('M. d, Y')}}  - {{Carbon\Carbon::parse($event2->end_dt)->format('M. d, Y')}}</p>
                                                <p class="text-xs font-weight-bold mb-0">{{Carbon\Carbon::parse($event2->start_time)->format('h:i a')}} - {{Carbon\Carbon::parse($event2->end_time)->format('h:i a')}}</p>
                                            
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm badge-success">{{ $event2->status }}</span>
                                            </td>
                                            
                                            <td class="align-middle">
                                                <a  href="event-livestream-select-member/{{ Crypt::encrypt( $event2->id )}}" class="btn btn-sm w-100 btn-danger text-white font-weight-normal text-sm">
                                                Select
                                                </a>
                                            </td>
                                            </tr>
                                        @endforeach
                                
                                
                                
                                        
                                      </tbody>
                                    </table>
                                  </div>
                            </div>
                        </div>
  
                        {{ $event->appends($_GET)->links('vendor.pagination.bootstrap-5') }}

                       
                    </div>
                   
                </div>
            </div> 
        <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
    </div>
    </main>
    <x-plugins></x-plugins>
    <link href="{{ asset('assets') }}/css/event-livestream-maintenance.css" rel="stylesheet" />
  @push('js')

  <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('assets') }}/js/maintenance.js"></script>
  <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/datatables.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/choices.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>

    @endpush
  </x-page-template>
  