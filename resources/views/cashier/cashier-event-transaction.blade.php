<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="cashier" activeItem="cashier-event" activeSubitem="">
    </x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-auth.navbars.navs.auth pageTitle="Cashier"></x-auth.navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
        
            <div class="row">
                <div class="col-12 col-lg-12 col-md-12">
                    <div class="card mt-4">
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-12 d-flex align-items-center">
                                    <h5 class="mb-0 text-danger">Item Details</h5>
                                </div>
                               
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-md-12 mb-md-0 mb-4">
                                    <div class="card card-body border card-plain border-radius-lg ">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-6 col-12">
                                                <div class="d-flex">
                                                    <div>
                                                        <img src="{{ asset('assets') }}/img/pps-logo.png"
                                                            class="avatar avatar-xxl me-3" alt="product image">
                                                    </div>
                                                    <div>
                                                        <h6 class="text-lg mb-0 mt-2" id="event_title">{{ $event->title }}</h6>
                                                        <p class="text-sm mb-0" id="event_category">{{ $event->category }}</p>
                                                        <p class="text-sm mb-0" id="event_description">{{ $event->description }}</p>
                                                        @if ($event->start_dt == $event->end_dt)
                                                            <span class="badge badge-sm bg-gradient-warning">{{Carbon\Carbon::parse($event->start_dt)->format('M. d, Y')}} {{Carbon\Carbon::parse($event->start_time)->format('h:m a')}} - {{Carbon\Carbon::parse($event->end_time)->format('h:m a')}}  </span>
                                                        @else
                                                        <span class="badge badge-sm bg-gradient-warning">{{Carbon\Carbon::parse($event->start_dt)->format('M. d, Y')}} -  {{Carbon\Carbon::parse($event->end_dt)->format('M. d, Y')}} {{Carbon\Carbon::parse($event->start_time)->format('h:m a')}} - {{Carbon\Carbon::parse($event->end_time)->format('h:m a')}} </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 d-flex align-items-center">
                                    <h5 class="mb-0 text-danger">Billing Information</h5>
                                </div>
                               
                            </div>
                            <div class="row">
                                <div class="col-md-7 col-12 col-lg-7">
                                    <div class="card card-body border card-plain border-radius-lg">
                                        {{-- Start of hidden input --}}
                                          
                                        <input type="hidden" value="{{ url('cashier-event-add-customer') }}" id="urlAddCustomer">
                                        <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">
                                        <input type="hidden" id="event_id" name="event_id" value="{{ $event->id }}">
                                        {{-- End of hidden input --}}
                                       
                                        <div class="row">
                                            <div class="col-10 col-md-10 col-lg-10">
                                                <label class="form-label text-bold">Select Member Customer<code> <b>*</b></code></label>
                                                <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                    <select name="member" id="member" class="form-control member">
                                                        <option value="">-- Select --</option>
                                                        @foreach ($member as $member2)  
                                                                <option value="{{ $member2->pps_no }}">{{ $member2->first_name }} {{ $member2->middle_name }} {{ $member2->last_name }}</option>
                                                        @endforeach
                                                    </select>
                                                  </div>
                                            </div>
                                            <div class="col-2">
                                                <button class="btn btn-icon btn-2 btn-sm btn-warning" id="addMemberCustomerBtn" type="button" style="margin-top: 32px !important; font-size: 15px !important">
                                                  <span class="btn-inner--icon"><i class="material-icons" style="font-size: 15px !important">add</i></span>
                                                </button>
                                              </div>
                                        </div>
                                        <div class="row" id="memberselected">
                                            <div class="col-12 col-md-12 col-lg-12">
                                                <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-2 mt-2 ">Selected</h6>    
                                                <ul class="list-group">
                                                    @foreach ($cart as $cart2)
                                                    
                                                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                                            <div class="d-flex align-items-center">
                                                                <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i class="material-icons text-lg">expand_less</i></button>
                                                                <div class="d-flex flex-column">
                                                                    <h6 class="mb-1 text-dark text-sm">{{ $cart2->first_name }} {{ $cart2->middle_name }} {{ $cart2->last_name }} {{ $cart2->suffix }}</h6>
                                                                    <span class="text-xs">{{ $cart2->member_type_name }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                                                                ₱ {{ number_format($cart2->price, 2) }}
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>   
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-5 col-12 col-lg-5">
                                    <div class="row mt-5">
                                        <div class="col-12 col-md-12">
                                            <h4 class="font-bold">Subtotal:</h4>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12 col-md-12">
                                            <h4 class="font-bold">Discount:</h4>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="row mt-2">
                                        <div class="col-12 col-md-12">
                                            <h4 class="font-bold">Total:</h4>
                                        </div>
                                    </div>

                                    
                                    <div class="row mt-5">
                                        <div class="col-12">
                                            <button class="btn btn-danger w-100">Pay via online</button>
                                            <button class="btn btn-danger w-100">Pay via cash</button>
                                            <button class="btn btn-danger w-100">Pay via cheque</button>
                                        </div>
                                    </div>
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
    <link href="{{ asset('assets') }}/css/cashier-event.css" rel="stylesheet" />
    @push('js')
    <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets') }}/js/cashier-event.js"></script>
    <script src="{{ asset('assets') }}/js/select2.min.js"></script>
    <link href="{{ asset('assets') }}/css/select2.min.css" rel="stylesheet" />
    <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>

    @endpush
</x-page-template>
