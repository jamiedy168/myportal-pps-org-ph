
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="events" activeItem="listing" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="Events"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->
      <div class="container-fluid py-4">
        {{-- <div class="loading" id="loading2"> 
            <img src="{{ asset('assets') }}/img/pps-logo.png" style="height: 60px !important; width: 60px !important" alt="img-blur-shadow" class="icons">
        </div> --}}
      <div class="card card-body ">
        <h5 class="mb-4 text-danger text-gradient">Payment</h5>
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
                                    class="text-dark ms-2 font-weight-bold" id="mobile_number">{{ $eventTransaction->mobile_number }}</span></span>
                            <span class="mb-2 text-xs">Member Type: <span
                                class="text-dark font-weight-bold ms-2" id="type">{{ $eventTransaction->type }}
                                </span></span>
                        </div>
                    </li>
                </ul>
            </div>
            
            <div class="col-lg-4 col-12 ms-auto">
                <form method="POST" role="form text-left" enctype="multipart/form-data" action="{{ url('event-payment') }}">
                    @csrf
                    {{-- Start of hidden input --}}
                    <input type="hidden" id="price_validation">
                    <input type="hidden" id="change_validation">
                    <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">
                    {{-- <input type="hidden" value="{{ url('cashier-event-pay')}}" id="urlCashierEventPay"> --}}
                    <input type="hidden" name="transaction_id" id="transaction_id" value="{{ $eventTransaction->id }}">
                    <input type="hidden" name="event_customer_name" id="event_customer_name" value="{{ $eventTransaction->first_name }} {{ $eventTransaction->middle_name }} {{ $eventTransaction->last_name }} {{ $eventTransaction->suffix }}">
                    <input type="hidden" name="event_email_adddress" id="event_email_adddress" value="{{ $eventTransaction->email_address }}">
                    <input type="hidden" name="event_title" id="event_title" value="{{ $eventTransaction->title }}">
                    <input type="hidden" name="total_price" id="total_price" value="{{ $eventTransaction->price }}">
                    <input type="hidden" name="pps_no" id="pps_no" value="{{ $eventTransaction->pps_no }}">
                    <input type="hidden" name="eventId" id="eventId" value="{{ $eventTransaction->eventId }}">
                    
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
                        <button type="submit" class="btn btn-danger w-100" type="button">  
                            <span class="btn-inner--icon"><i class="material-icons">credit_card</i></span>
                            <span class="btn-inner--text">&nbsp;PAY NOW</span></button>
                    </div>
                    {{-- End of hidden input --}}
                </form>
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

  <script src="{{ asset('assets') }}/js/event.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>

    @endpush
  </x-page-template>
  