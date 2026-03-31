
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="specialtyBoard" activeItem="specialty-board-view" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="Specialty Board"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->

      <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
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
                                        <h6 class="text-lg mb-0 mt-2" id="event_title">Specialty Board Application</h6>
                                        <p class="text-sm mb-0" id="event_category">FOR {{ $price_list->type_description }} APPLICATION</p>
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
                                            <h6 class="text-dark text-sm font-weight-bold mb-0">Application Date</h6>
                                            <p class="text-secondary font-weight-normal text-xs mt-1 mb-0" id="event_joined_dt">{{ \Carbon\Carbon::now('Asia/Manila')->format('Y-m-d') }}</p>
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
                                            <h6 class="mb-3 text-sm" id="member_name">{{ $member_info->first_name }} {{ $member_info->middle_name }} {{ $member_info->last_name }} {{ $member_info->suffix }}</h6>
                                            
                                            <span class="mb-2 text-xs">Email Address: <span
                                                    class="text-dark ms-2 font-weight-bold" id="email_address" style="word-break: break-all !important;">{{ $member_info->email_address }}</span></span>
                                            <span class="text-xs mb-2">Contact Number: <span
                                                    class="text-dark ms-2 font-weight-bold" id="mobile_number">{{ $member_info->country_code }} {{ $member_info->mobile_number }}</span></span>
                                            <span class="mb-2 text-xs">Member Type: <span
                                                class="text-dark font-weight-bold ms-2" id="type">{{ $member_info->member_type_name }}
                                                </span></span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-4 col-12 ms-auto">
                                <form method="POST" role="form text-left" enctype="multipart/form-data" action="{{ url('specialty-board-payment-online') }}" id="payment_online">
                                    @csrf
                                    {{-- START OF HIDDEN INPUT --}}
                                    <input type="hidden" name="price" value="{{ $price_list->amount }}">
                                    <input type="hidden" name="customer_name" id="customer_name" value="{{ $member_info->first_name }} {{ $member_info->middle_name }} {{ $member_info->last_name }} {{ $member_info->suffix }}">
                                    <input type="hidden" name="email_adddress" id="email_adddress" value="{{ $member_info->email_address }}">
                                    <input type="hidden" name="member_type_name" id="member_type_name" value="{{ $member_info->member_type_name }}">
                                    <input type="hidden" name="pps_no" id="pps_no" value="{{ $member_info->pps_no }}">
                                    <input type="hidden" name="type_description" value="{{ $price_list->type_description }}">
                                    <input type="hidden" name="pricelist_id" value="{{ $price_list->id }}">
                                    {{-- END OF HIDDEN INPUT --}}

                                <h6 class="mb-3">Order Summary</h6>
                                <div class="d-flex justify-content-between">
                                    <span class="mb-2 text-sm">
                                        Price:
                                    </span>
                                        <span class="text-dark font-weight-bold ms-2" id="price">₱ {{ $price_list->amount }}</span>
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
                                    <span class="text-dark text-lg ms-2 font-weight-bold" id="total_amount">₱ {{ number_format($price_list->amount, 2) }}</span>
                                    
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
                                        Total (Fee included) = ₱ {{ number_format($price_list->amount * 1.030, 2) }}
                                        
                                        </label>
                                    </div>
                                </div>

                                <div id="" class="desc paymentcard" style="display: none !important">
                                    <div>
                                        <label class="mb-2 text-danger" style="font-style: italic !important">
                                           Note: Paymongo service fee + 4.0% + ₱ 15.00 for card transaction.
                                        </label>
                                    </div>
                                    <div>
                                        <label class="mb-2 text-danger text-bolder" style="font-style: italic !important">
                                        Total (Fee included) = ₱ {{ number_format(($price_list->amount * 1.030) + 10, 2) }}
                                        
                                        </label>
                                    </div>
                                   
                                </div>
                                <div class="d-flex justify-content-between mt-4">
                                    <button type="submit" class="btn btn-danger w-100" type="button">  
                                        <span class="btn-inner--icon"><i class="material-icons">credit_card</i></span>
                                        <span class="btn-inner--text">&nbsp;PAY NOW</span></button>
                                </div>
                                </form>
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
  @push('js')

  <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('assets') }}/js/select2.min.js"></script>
  <link href="{{ asset('assets') }}/css/select2.min.css" rel="stylesheet" />
  <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
  <script src="{{ asset('assets') }}/js/specialty-board-payment.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>


    @endpush
  </x-page-template>
  