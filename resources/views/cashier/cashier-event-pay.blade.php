<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="cashier" activeItem="cashier-event" activeSubitem="">
    </x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-auth.navbars.navs.auth pageTitle="Cashier"></x-auth.navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-4 text-danger text-gradient">Event Payment</h5>

                           
                       
                            <hr class="horizontal dark mt-0 mb-4">
                            <div class="row">
                                <div class="col-lg-12 col-md-6 col-12">
                                    <div class="d-flex">
                                        <div>
                                            <img src="{{ asset('assets') }}/img/pps-logo.png"
                                                class="avatar avatar-xxl me-3" alt="product image">
                                        </div>
                                        <div>
                                            <h6 class="text-lg mb-0 mt-2" id="event_title">{{ $eventTransaction->title }}</h6>
                                            <p class="text-sm mb-0" id="event_category">{{ $eventTransaction->category_name }}</p>
                                            <p class="text-sm mb-3" id="event_description">{{ $eventTransaction->description }}</p>
                                            <span class="badge badge-sm bg-gradient-warning">FOR PAYMENT</span>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <hr class="horizontal dark mt-4 mb-4">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-12">
                                    <h6 class="mb-3">Timeline</h6>
                                    <div class="timeline timeline-one-side">
                                        <div class="timeline-block mb-3">
                                            <span class="timeline-step">
                                                <i class="material-icons text-secondary text-lg">notifications</i>
                                            </span>
                                            <div class="timeline-content">
                                                <h6 class="text-dark text-sm font-weight-bold mb-0">Joined Date</h6>
                                                <p class="text-secondary font-weight-normal text-xs mt-1 mb-0" id="event_joined_dt">{{ Carbon\Carbon::parse($eventTransaction->joined_dt)->format('d M Y g:i A') }}</p>
                                            </div>
                                        </div>
                                        <div class="timeline-block mb-3">
                                            <span class="timeline-step">
                                                <i class="material-icons text-secondary text-lg">schedule</i>
                                            </span>
                                            <div class="timeline-content">
                                                <h6 class="text-dark text-sm font-weight-bold mb-0">Date/Time Payment</h6>
                                                <p class="text-secondary font-weight-normal text-xs mt-1 mb-0 text-warning">For Payment</p>
                                            </div>
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                                <div class="col-lg-5 col-12">
                                    
                                    <h6 class="mb-3">Billing Information</h6>
                                    <ul class="list-group">
                                        <li
                                            class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-3 text-sm" id="member_name">{{ $eventTransaction->first_name }} {{ $eventTransaction->middle_name }} {{ $eventTransaction->last_name }} {{ $eventTransaction->suffix }}</h6>
                                                
                                                <span class="mb-2 text-xs">Email Address: <span
                                                        class="text-dark ms-2 font-weight-bold" id="email_address" style="word-break: break-all !important;">{{ $eventTransaction->email_address }}</span></span>
                                                <span class="text-xs mb-2">Contact Number: <span
                                                        class="text-dark ms-2 font-weight-bold" id="mobile_number">{{ $eventTransaction->country_code }} {{ $eventTransaction->mobile_number }}</span></span>
                                                <span class="mb-2 text-xs">Member Type: <span
                                                    class="text-dark font-weight-bold ms-2" id="type">{{ $eventTransaction->type }}
                                                    </span></span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                
                                <div class="col-lg-4 col-12 ms-auto">
                                    <form method="POST" role="form text-left" enctype="multipart/form-data" action="{{ url('cashier-event-payment') }}">
                                        @csrf
                                        {{-- Start of hidden input --}}
                                        <input type="hidden" id="price_validation">
                                        <input type="hidden" id="change_validation">
                                        <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">
                                        <input type="hidden" value="{{ url('cashier-event-pay')}}" id="urlCashierEventPay">
                                        <input type="hidden" name="transaction_id" id="transaction_id" value="{{ $eventTransaction->id }}">
                                        <input type="hidden" name="event_customer_name" id="event_customer_name" value="{{ $eventTransaction->first_name }} {{ $eventTransaction->middle_name }} {{ $eventTransaction->last_name }} {{ $eventTransaction->suffix }}">
                                        <input type="hidden" name="event_email_adddress" id="event_email_adddress" value="{{ $eventTransaction->email_address }}">
                                        <input type="hidden" name="event_title" id="event_title" value="{{ $eventTransaction->title }}">
                                        <input type="hidden" name="total_price" id="total_price" value="{{ $eventTransaction->price }}">
                                        <input type="hidden" name="pps_no" id="pps_no" value="{{ $eventTransaction->pps_no }}">

                                        
                                        
                                        <h6 class="mb-3">Order Summary</h6>
                                        <div class="d-flex justify-content-between">
                                            <span class="mb-2 text-sm">
                                                Price:
                                            </span>
                                            <span class="text-dark font-weight-bold ms-2" id="price">₱ {{ number_format($eventTransaction->price, 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="mb-2 text-sm">
                                                Discount:
                                            </span>
                                            <span class="text-dark ms-2 font-weight-bold">₱ 0.00</span>
                                        </div>

                                        <div class="d-flex justify-content-between mt-2">
                                            <span class="mb-2 text-lg text-danger">
                                                Total: 
                                            </span>
                                            <span class="text-dark text-lg ms-2 font-weight-bold" id="total_amount">₱ {{ number_format($eventTransaction->price, 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mt-4">
                                            <button type="submit" class="btn btn-warning w-100" type="button">  
                                                <span class="btn-inner--icon"><i class="material-icons">credit_card</i></span>
                                                <span class="btn-inner--text">&nbsp;PAY ONLINE</span></button>
                                                
                                                
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <button class="btn btn-danger w-100" type="button" data-bs-toggle="modal" data-bs-target="#modalEventCasierPay">  
                                                <span class="btn-inner--icon"><i class="fas fa-cash-register"></i></span>
                                                <span class="btn-inner--text">&nbsp;PAY AT THE CASHIER</span></button>
                                        </div>
                                        {{-- End of hidden input --}}
                                    </form>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- START MODAL PAY --}}
            <div class="modal fade" id="modalEventCasierPay" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
               
                <div class="modal-dialog modal-dialog-centered " role="document">
                    <div class="modal-content">
                    
                        <div class="modal-body p-0">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-left">
                                    <div class="row">
                                        <div class="col-11">
                                            <h5 class="text-gradient text-danger">Payment</h5>
                                        </div>
                                        <div class="col-1">
                                            <button style="text-align: right !important" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                <span class="text-primary" aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                    
                                
                                </div>
                                <div class="card-body p-3 pt-0">
                                    <hr class="horizontal dark mt-0 mb-4">

                                    {{-- Start of hidden input --}}
                                    <input type="hidden" value="{{ url('cashier-event-pay-manual')}}" id="urlCashierEventPayManual">
                                    <input type="hidden" id="priceofevent" value="{{ $eventTransaction->price }}">
                                    <input type="hidden" id="token2" name="token2" value="{{ csrf_token() }}">
                                    <input type="hidden" name="transaction_id" id="transaction_ids" value="{{ $eventTransaction->id }}">
                                    {{-- End of hidden input --}}
                                   
                                      <div class="text-center text-muted mb-4">
                                        <h3>Enter Amount</h3>
                                      </div>
                                      <div class="row gx-2 gx-sm-3 mb-3">
                                        <div class="col">
                                            <div class="input-group input-group-outline">
                                                <button class="btn bg-gradient-danger btn-lg counter-btn" id="minusBtn" ><i class="fas fa-minus"></i></button>
                                                <input type="number" class="form-control amount3" id="amount3" min="{{ $eventTransaction->price }}" style="height: 46px !important; font-size: 20px !important; text-align:center !important">
                                                <button class="btn bg-gradient-danger btn-lg counter-btn" id="plusBtn"><i class="fas fa-plus"></i></button>
                                                
                                            </div>
                                        </div>
                                    
                                      </div>

                                      <div class="row ">
                                        <div class="col">
                                            <h6>Event Price</h6>
                                        </div>
                                        <div class="col text-right" style="text-align: right !important">
                                            <h6 class="">₱ {{ number_format($eventTransaction->price, 2) }}</h6>
                                            
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col">
                                            <h6>Discount</h6>
                                        </div>
                                        <div class="col text-right" style="text-align: right !important">
                                            <h6 class="">₱ 0.00</h6>
                                        </div>
                                      </div>
                                      <div class="row ">
                                        <div class="col">
                                            <h6>Change</h6>
                                        </div>
                                        <div class="col text-right" style="text-align: right !important">
                                            <h6 class="" id="change3"></h6>
                                            <input type="hidden" id="final_change">
                                        </div>
                                      </div>
                                      <hr>
                                      <div class="row ">
                                        <div class="col">
                                            <h4>TOTAL:</h4>
                                        </div>
                                        <div class="col text-right" style="text-align: right !important">
                                            <h4 class="">₱ {{ number_format($eventTransaction->price, 2) }}</h4>
                                        </div>
                                      </div>
                                      <br>

                                      
                                      <div class="row ">
                                        <div class="col-12 col-lg-6">
                                            <button type="button" class="btn bg-gradient-warning w-100" id="paycashierBtn">Pay</button>
                                            
                                        </div>
                                        <div class="col-12 col-lg-6">
                                          
                                            <button type="button" class="btn bg-gradient-danger w-100" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                        
                                      </div>
                                </div>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- END MODAL PAY --}}
            <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
        </div>
    </main>
    <x-plugins></x-plugins>
    <link href="{{ asset('assets') }}/css/loader.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/cashier-event.css" rel="stylesheet" />
    @push('js')
    <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
    <script src="{{ asset('assets') }}/js/cashier-event.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/choices.min.js"></script>
    <script src="{{ asset('assets') }}/js/moment.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/photoswipe.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/photoswipe-ui-default.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>

    @endpush
</x-page-template>
