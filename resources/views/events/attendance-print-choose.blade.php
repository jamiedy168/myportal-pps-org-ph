<x-page-template bodyClass='g-sidenav-show bg-gray-200'>
    <x-auth.navbars.sidebar activePage='attendance' activeItem='attendance-print-choose-event' activeSubitem=''></x-auth.navbars.sidebar>
    <main class="main-content main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-auth.navbars.navs.auth pageTitle='Events'></x-auth.navbars.navs.auth>
       
        <div class="container-fluid my-3 py-4">
              <div class="row mt-0 justify-content-md-center" style="margin-top: -15px !important">
               
                <div class="col-lg-10 col-12">
                    <div class="card">
                        <div class="card-header p-3 pb-0 bg-gradient-danger">
                            <div class="row">
                                <div class="col-8">
                                    <h6 class="mb-2 text-white">CHOOSE EVENT</h6>
                                </div>
                                <div class="col-4 text-end">
                                    <a href="#" class="btn btn-link btn-icon-only btn-rounded text-white icon-move-right my-auto" style="margin-top: -5px !important">
                                        <i class="material-icons" aria-hidden="true">calendar</i>
                                            
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mt-0">
                                <div class="col-12">
                                    <form class="form-horizontal" action="/choose-print-attendance-search" method="GET" autocomplete="off">
                                        <div class="row mt-4">
                                            <div class="col-lg-6"></div>
                                            <div class="col-lg-6 col-12">
                                                <div class="input-group input-group-outline">
                                                    <label class="form-label">Search here..</label>
                                                    <input type="text" class="form-control" id="searchbox-input" name="title" value="{{ $title }}" style="height: 46px !important">
                                                    <button class="btn bg-gradient-danger btn-lg" id="searchBtn" type="submit"><i class="material-icons">search</i></button>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </form>
                                    <div class="table table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                       </th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" style="text-align: center !important">
                                                        Date</th>
                                                    <th
                                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($event as $event2)
                                                
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                            <div>
                                                                @if ($event2->event_image == null)
                                                                <img src="{{ asset('assets') }}/img/pps-logo.png"
                                                                    class="avatar avatar-md me-3" alt="image">
                                                                @else
                                                                <img src="{{Storage::disk('s3')->temporaryUrl('event/' . $event2->event_image, now()->addMinutes(230))}}"
                                                                class="avatar avatar-md me-3" alt="image">
                                                                @endif
                                                            </div>
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $event2->title }}
                                                                </h6>
                                                                @if ($event2->name != 'EXAMINATION')
                                                                    <label>Category: {{ $event2->name }}</label>
                                                                @else
                                                                    <label>Category: {{ $event2->name }} {{ ' | ' . $event2->examination_category }}</label>
                                                                @endif
                                                                
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td style="text-align: center !important">
                                                        <p class="text-sm text-secondary mb-0">{{ $event2->start_dt->format('F d, Y') }}</p>
                                                        <p class="text-sm text-secondary mb-0">{{ $event2->start_time->format('h: i a') }}</p>
                                                    </td>
                                                    
                                                    <td class="align-middle text-center">
                                                        <a href="print-attendance/{{ Crypt::encrypt( $event2->id )}}" class="btn btn-icon btn-danger btn-outline-danger w-100 mt-3"    type="button">
                                                            <span class="btn-inner--text">Select</span>
                                                            <span style="margin-top: -10px !important" class="btn-inner--icon"><i class="material-icons">chevron_right</i></span>
                                                                
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    {{ $event->appends($_GET)->links('vendor.pagination.bootstrap-5') }}
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
    <link href="{{ asset('assets') }}/css/event-attendance.css" rel="stylesheet" />
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
