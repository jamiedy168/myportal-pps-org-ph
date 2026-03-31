<x-page-template bodyClass='g-sidenav-show bg-gray-200'>
    <x-auth.navbars.sidebar activePage='attendance' activeItem='attendance-print-choose-event' activeSubitem=''></x-auth.navbars.sidebar>
    <main class="main-content main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-auth.navbars.navs.auth pageTitle='Events'></x-auth.navbars.navs.auth>
       
        <div class="container-fluid my-3 py-4">
              <div class="row mt-0 justify-content-md-center" style="margin-top: -15px !important">
               
                <div class="col-lg-12 col-12">
                    <div class="card">
                        <div class="card-header p-3 pb-0 bg-gradient-danger">
                            <div class="row">
                                <div class="col-8">
                                    <h6 class="mb-2 text-white">CHOOSE ATTENDEE</h6>
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
                                    <form class="form-horizontal" action="{{ url('print-attendance-search/'.$id) }}" method="GET" autocomplete="off">
                                        <div class="row mt-4">
                                            <div class="col-lg-6"></div>
                                            <div class="col-lg-6 col-12">
                                                <div class="input-group input-group-outline">
                                                    <label class="form-label">Search here..</label>
                                                    <input type="text" class="form-control" id="searchbox-input" name="searchTerm" value="{{ $name }}" style="height: 46px !important">
                                                    <button class="btn bg-gradient-danger btn-lg" id="searchBtn"><i class="material-icons">search</i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                   
                                </div>
                            </div>
                            <div class="row mt-0">
                                <div class="col-12">
    
                                    <div class="table-responsive">
                                        <table class="table table-flush" >
                                            <thead class="thead-light">
                                                <tr>
                                                    <th></th>
                                                    <th>Attendee</th>
                                                    <th class="text-center">Chapter</th>
                                                    <th class="text-center">Date/Time Attended</th>
                                                    <th></th>
                                                   
                                       
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($event_transaction as $event_transaction2)
                                                    <tr class="bg-gray-10">
                                                        <td>
                                                            <div class="mt-3">
                                                                @if ( $event_transaction2->picture == null )
                                                                    <img src="{{ asset('assets') }}/img/default-avatar.png"
                                                                    class="avatar avatar-md me-4" style="height: 60px !important; width: 60px !important" alt="table image">
                                                                @else
                                                                    <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $event_transaction2->picture, now()->addMinutes(30))}}"
                                                                    class="avatar avatar-md me-4" style="height: 60px !important; width: 60px !important" alt="table image">
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex flex-column">
                                                                <a class="mb-1 mt-2 text-danger" href="javascript:void(0); " style="font-weight: bold">{{ $event_transaction2->first_name }} {{ $event_transaction2->middle_name }} {{ $event_transaction2->last_name }} {{ $event_transaction2->suffix }}</a>
                                                                @if ($event_transaction2->prc_number == null)
                                                                    <span class="text-sm">PRC Number: <span
                                                                        class="text-dark ms-sm-2 font-weight-bold">N/A</span></span>
                                                                @else
                                                                    <span class="text-sm">PRC Number: <span
                                                                        class="text-dark ms-sm-2 font-weight-bold">{{ $event_transaction2->prc_number }}</span></span>
                                                                @endif
                                                                <span class="text-sm">Member Type: <span
                                                                    class="text-dark ms-sm-2 font-weight-bold">{{ $event_transaction2->member_type_name }}</span></span>
                                        
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="d-flex flex-column">
                                                                <label class="mt-4">{{ $event_transaction2->chapter_name }}</label>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="d-flex flex-column">
                                                                <label class="mt-4"> {{ Carbon\Carbon::parse($event_transaction2->attended_dt)->format('M. d, Y h:i A') }}</label>
                                                            </div>
                                                        </td>
                                                        <td class="text-sm">
                                                           
                                                            <a target="_blank" class="btn bg-gradient-danger mt-3" type="button" id="dropdownMenuButton" aria-expanded="false"
                                                                href="{{ url('/event-download-identification-card/'. encrypt($event_transaction2->id)) }}">
                                                                    Print Event ID
                                                            </a>

                                                          
                                                          
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                     
                                        </table>
                                    </div>
                                    <br>
                                    {{ $event_transaction->appends($_GET)->links('vendor.pagination.bootstrap-5') }}
                                    
                                  
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
