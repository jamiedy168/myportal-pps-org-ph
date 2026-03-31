<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="payment" activeItem="listing-payment" activeSubitem="">
    </x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-auth.navbars.navs.auth pageTitle="Annual Dues"></x-auth.navbars.navs.auth>
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
                        <h6 class="text-lg mb-0 mt-2" id="event_title">{{ $paymentList->description }}</h6>
                        <p class="text-sm mb-0" id="event_category">{{ 'YEAR' . ' ' .$paymentList->year_dues }}</p>
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
                            <h6 class="text-dark text-sm font-weight-bold mb-0">Created Date</h6>
                            <p class="text-secondary font-weight-normal text-xs mt-1 mb-0" id="created_at">{{ Carbon\Carbon::parse($paymentList->created_at)->format('d M Y g:i A') }}</p>
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
                            <h6 class="mb-3 text-sm" id="member_name">{{ $paymentList->first_name }} {{ $paymentList->middle_name }} {{ $paymentList->last_name }} {{ $paymentList->suffix }}</h6>
                            
                            <span class="mb-2 text-xs">Email Address: <span
                                    class="text-dark ms-2 font-weight-bold" id="email_address" style="word-break: break-all !important;">{{ $paymentList->email_address }}</span></span>
                            <span class="text-xs mb-2">Contact Number: <span
                                    class="text-dark ms-2 font-weight-bold" id="mobile_number">{{ $paymentList->country_code }} {{ $paymentList->mobile_number }}</span></span>
                            <span class="mb-2 text-xs">Member Type: <span
                                class="text-dark font-weight-bold ms-2" id="type">{{ $paymentList->member_type_name }}
                                </span></span>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-lg-4 col-12 ms-auto">
                <form method="POST" role="form text-left" enctype="multipart/form-data" action="{{ url('payment-online') }}">
                    @csrf
                   
                    
                    <input type="hidden" name="transaction_id" id="transaction_id" value="{{ $paymentList->transaction_id }}">
                    <input type="hidden" name="customer_name" id="customer_name" value="{{ $paymentList->first_name }} {{ $paymentList->middle_name }} {{ $paymentList->last_name }} {{ $paymentList->suffix }}">
                    <input type="hidden" name="email_adddress" id="event_email_adddress" value="{{ $paymentList->email_address }}">
                    <input type="hidden" name="mobile_number" id="mobile_number" value="{{ $paymentList->mobile_number }}">

                    
                    <input type="hidden" name="description" id="description" value="{{ $paymentList->description }}">
                    <input type="hidden" name="total_price" id="total_price" value="{{ $paymentList->total_amount }}">
                    <input type="hidden" name="pps_no" id="pps_no" value="{{ $paymentList->pps_no }}">
                    <input type="hidden" name="year_dues" id="year_dues" value="{{ $paymentList->year_dues }}">
                    <input type="hidden" name="member_type" id="member_type" value="{{ $paymentList->member_type_name }}">
                    
                    
                    
                    
                    <h6 class="mb-3">Order Summary</h6>
                    <div class="d-flex justify-content-between">
                        <span class="mb-2 text-sm">
                            Price:
                        </span>
                        <span class="text-dark font-weight-bold ms-2" id="price">&#8369; {{ number_format($paymentList->total_amount, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="mb-2 text-sm">
                            Discount:
                        </span>
                        <span class="text-dark ms-2 font-weight-bold">&#8369; 0.00</span>
                    </div>

                    <div class="d-flex justify-content-between mt-2">
                        <span class="mb-2 text-lg text-danger">
                            Total: 
                        </span>
                        <span class="text-dark text-lg ms-2 font-weight-bold" id="total_amount">&#8369; {{ number_format($paymentList->total_amount, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <span class="mb-2">
                           Choose Payment Type:
                        </span>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="payment_type" checked="checked" value="gcash">
                            <label class="form-check-label" for="gcashinput">GCASH</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="payment_type" value="card">
                            <label class="form-check-label" for="inlineRadio2">CARD</label>
                          </div>
                    </div>
                    <div id="" class="desc paymentgcash">
                        <div >
                            <label class="mb-2 text-danger" style="font-style: italic !important">
                               Note: Paymongo service fee + 3% for gcash transaction
                            </label>
                        </div>
                        <div>
                            <label class="mb-2 text-danger text-bolder" style="font-style: italic !important">
                              Total (Fee included) = &#8369; {{ number_format($paymentList->total_amount * 1.030, 2) }}
                             
                            </label>
                        </div>
                    </div>


                    <div id="" class="desc paymentcard" style="display: none !important">
                        <div>
                            <label class="mb-2 text-danger" style="font-style: italic !important">
                               Note: Paymongo service fee + 4% + ₱ 15.00 for card transaction.
                            </label>
                        </div>
                        <div>
                            <label class="mb-2 text-danger text-bolder" style="font-style: italic !important">
                              Total (Fee included) = ₱ {{ number_format(($paymentList->total_amount * 1.040) + 15, 2) }}
                             
                            </label>
                        </div>
                    </div>
                    
                    
                    

                    <div class="d-flex justify-content-between mt-4">
                        <button type="submit" class="btn btn-warning w-100" type="button">  
                            PAY NOW</button>
                        {{-- <a type="button" class="btn btn-warning w-100" href="/payment-hold">  
                            PAY NOW</a> --}}
                    </div>
                 
                  
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

  <script src="{{ asset('assets') }}/js/payment.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>

    @endpush
  </x-page-template>
  