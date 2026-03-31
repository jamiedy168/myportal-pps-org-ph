
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="events" activeItem="livestream" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="Events"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->
      <div class="container-fluid py-4">
      
      <div class="card card-body mx-3 mx-md-4 ">

        <div class="row mt-4">
            <div class="col-12">
                <div class="mb-3 ps-3">
                    <h6 class="mb-1">Events</h6>
                    <p class="text-sm">Please choose event below.</p>

                   
                </div>
                <form class="form-horizontal" action="{{ route('event-livestream-search') }}" method="GET" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group input-group-outline">
                                <label class="form-label">Search here..</label>
                                <input type="text" class="form-control" name="searchinput" id="search-input" style="height: 44px !important">
                                <button class="btn bg-gradient-danger btn-lg" type="submit"><i class="material-icons">search</i></button>
                            </div>
                        </div>
                    </div>
                </form>
                <br>

           
                <div class="row">
                    <div class="col-12 col-md-12">
                        @foreach ($event as $event2)
                            
                        <div class="d-flex align-items-center">
                            <div class="text-center w-5">
                                <i class="material-icons-round text-lg opacity-6">calendar_month</i>
                            </div>
                            <div class="my-auto ms-3">
                                <div class="h-100">
                                    <p class="text-sm mb-1 text-bold">
                                        {{ $event2->title }} 
                                    </p>
                                    <p class="mb-1 text-xs">
                                        {{Carbon\Carbon::parse($event2->start_dt)->format('M. d, Y')}}  - {{Carbon\Carbon::parse($event2->end_dt)->format('M. d, Y')}} | {{Carbon\Carbon::parse($event2->start_time)->format('h:i a')}} - {{Carbon\Carbon::parse($event2->end_time)->format('h:i a')}}
                                    </p>
                                    @if ($event2->date_attended != null)
                                        <p class="mb-1 text-sm">
                                            <b class="text-success">Date/Time Attended: </b>{{Carbon\Carbon::parse($event2->date_attended)->format('M. d, Y h:i a')}} 
                                        </p>
                                    @endif
                                    
                                </div>
                            </div>
                           
                                
                            {{--CHECK IF PAID--}}
                            @if ($event2->paid_event >= 1)
                                {{--CHECK IF COMPLETED--}}
                                @if($event2->status == 'COMPLETED')
                                    <a href="#" class="text-primary text-sm icon-move-right my-auto ms-auto me-3" onclick="completed()">SELECT
                                        <i class="fas fa-arrow-right text-xs ms-1" aria-hidden="true"></i>
                                    </a>
                                {{--CHECK IF UPCOMING--}}    
                                @elseif($event2->status == 'UPCOMING')    
                                    <a href="#" class="text-primary text-sm icon-move-right my-auto ms-auto me-3" onclick="upcoming()">SELECT
                                        <i class="fas fa-arrow-right text-xs ms-1" aria-hidden="true"></i>
                                    </a>
                                @else
                                    @if($event2->is_livestream == false)
                                        <a href="#" class="text-primary text-sm icon-move-right my-auto ms-auto me-3" onclick="notLiveStream()">SELECT
                                            <i class="fas fa-arrow-right text-xs ms-1" aria-hidden="true"></i>
                                        </a>
                                    @else
                                        <a href="event-livestream-video-view/{{ Crypt::encrypt( $event2->id )}}" class="text-primary text-sm icon-move-right my-auto ms-auto me-3">SELECT
                                            <i class="fas fa-arrow-right text-xs ms-1" aria-hidden="true"></i>
                                        </a>
                                    @endif
                                
                                    
                                @endif
                               
                            {{--UNPAID--}}
                            @else
                                <a href="#" class="text-primary text-sm icon-move-right my-auto ms-auto me-3" onclick="unpaid()">SELECT
                                    <i class="fas fa-arrow-right text-xs ms-1" aria-hidden="true"></i>
                                </a>
                            @endif
                            
                            
                        </div>
                        <hr class="horizontal dark">
                    @endforeach
                      
                    </div>
                </div>
                {{ $event->appends($_GET)->links('vendor.pagination.bootstrap-5') }}
             
            </div>
        </div>

      </div>
        <br>
      </div>
      <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
    </main>
    <x-plugins></x-plugins>
    <link href="{{ asset('assets') }}/css/loader.css" rel="stylesheet" />
  @push('js')
  <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('assets') }}/js/livestream.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>  

    @endpush
  </x-page-template>
  