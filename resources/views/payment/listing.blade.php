<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="payment" activeItem="listing-payment" activeSubitem="">
    </x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-auth.navbars.navs.auth pageTitle="Annual Dues"></x-auth.navbars.navs.auth>
        <!-- End Navbar -->
 
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="mb-0">List of Payment</h5>
                                <span class="badge bg-{{ ($paymongoMode ?? 'test') === 'live' ? 'success' : 'secondary' }} text-uppercase">
                                    PayMongo Mode: {{ strtoupper($paymongoMode ?? 'test') }}
                                </span>
                            </div>

                            <div class="row">
                                
                                <div class="col-lg-6 col-12">
                                    <div class="input-group input-group-outline">
                                        <label class="form-label">Search here..</label>
                                        <input type="text" class="form-control" id="searchbox-input" style="height: 46px !important">
                                        <button class="btn bg-gradient-danger btn-lg" id="searchBtn"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <button class="btn btn-warning" type="button" onclick="window.location.reload();">Reload Data</button>
                                </div>
                                {{-- <div class="col-lg-2">
                                    <div class="input-group input-group-outline">
                                       
                                        <button class="btn bg-gradient-danger btn-lg" id="searchBtn">Filter</button>
                                       
                                    </div>
                                </div> --}}
                                
                            </div>
                          
                            
                            <div class="row mt-5">
                                <div class="col-12">
                                    
                                    <div class="table table-responsive" id="table_transaction">
                                        <table class="table align-items-center mb-0" id="payment-table">
                                            <thead>
                                                <tr>
                                                    <th
                                                        class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">
                                                       </th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                                        Description</th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                                        PayMongo Ref</th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                                        Mode</th>
                                                    <th
                                                        class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                                        Amount</th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                                        Status</th>
                                                    <th></th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($paymentList as $paymentList2)
                                               
                                                    <tr>
                                                        <td class="text-center"> 
                                                            {{ $loop->iteration }}
                                                        </td>
                                                        <td>
                                                            @if ($paymentList2->payment_dt == null)
                                                                <a href="payment-online-final/{{ Crypt::encrypt( $paymentList2->id )}}" >
                                                                    <h6 class="mb-0">{{ $paymentList2->description }} ({{ $paymentList2->year_dues }})</h6>
                                                                </a>
                                                            @else
                                                                <h6 class="mb-0">{{ $paymentList2->description }} ({{ $paymentList2->year_dues }})</h6>
                                                            @endif
                                                      
                                                          
                                                            {{-- @if ($paymentList2->description == "Member Annual Dues")
                                                                <h6 class="mb-0">{{ $paymentList2->description }} ({{ $paymentList2->year_dues }})
                                                                </h6>
                                                            @else
                                                                <h6 class="mb-0">{{ $paymentList2->description }}
                                                                </h6>
                                                            @endif --}}
                                                            
                                                        </td>
                                                        <td>
                                                            <span class="text-xs font-weight-bold">
                                                                {{ $paymentList2->paymongo_payment_id ?? '—' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="text-xs font-weight-bold text-secondary">
                                                                {{ $paymentList2->payment_mode ?? strtoupper($paymongoMode ?? 'TEST') }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="text-secondary text-sm font-weight-bolder">&#8369; {{ number_format($paymentList2->total_amount, 2) }}</span>
                                                        </td>
                                                        
                                                        <td class="text-xs font-weight-normal">
                                                            <div class="d-flex align-items-center">
                                                                @if ($paymentList2->payment_dt == null)
                                                                <button
                                                                class="btn btn-icon-only btn-rounded btn-outline-warning mb-0 me-2 btn-sm d-flex align-items-center justify-content-center"><i
                                                                    class="material-icons text-sm"
                                                                    aria-hidden="true">schedule</i></button>
                                                                <span class="text-warning text-bold">FOR PAYMENT</span>
                                                                @else
                                                                    <button
                                                                    class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-2 btn-sm d-flex align-items-center justify-content-center"><i
                                                                        class="material-icons text-sm"
                                                                        aria-hidden="true">attach_money</i></button>
                                                                    <span class="text-success text-bold">PAID <br> {{ Carbon\Carbon::parse($paymentList2->payment_dt)->format('M. d, Y - h: i a') }} via {{ $paymentList2->payment_mode }}</span>
                                                                @endif
                                                            </div>
                                
                                                        </td>

                                                        <td class="text-center">
                                                            @if ($paymentList2->payment_dt == null)
                                                                <a href="payment-online-final/{{ Crypt::encrypt( $paymentList2->id )}}" class="btn btn-icon btn-danger btn-outline-danger w-100 mt-3" style="height: 37px !important;" type="button" >
                                                                    <span class="btn-inner--icon"><i class="material-icons">credit_card</i></span>
                                                                    <span class="btn-inner--text">&nbsp;PAY ONLINE</span>
                                                                </a>
                                                                {{-- <a href="#" class="btn btn-icon btn-danger btn-outline-danger w-100 mt-3" style="height: 37px !important;" type="button" data-bs-toggle="modal" 
                                                                    data-bs-target="#modalOnlinePayment-{{ $paymentList2->id }}">
                                                                    <span class="btn-inner--icon"><i class="material-icons">credit_card</i></span>
                                                                    <span class="btn-inner--text">&nbsp;PAY ONLINE</span>
                                                                </a> --}}
                                                            @else
                                                                <button type="button" class="btn btn-icon btn-warning btn-outline-danger w-100 mt-3" style="height: 37px !important;" type="button" data-bs-toggle="modal" data-bs-target="#modalAnnualDuesReceipt-{{ $paymentList2->id }}">
                                                                    <span class="btn-inner--icon"><i class="material-icons">credit_card</i></span>
                                                                    <span class="btn-inner--text">&nbsp;VIEW RECEIPT</span>
                                                                </button>
                                                            @endif
                                                            
                                                        </td>

                                                    </tr>
                                                        
                                                        <!-- Start of online payment modal -->
                                                        <div class="modal fade paymentmodals" id="modalOnlinePayment-{{ $paymentList2->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalSignTitle" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                                                                <div class="modal-content"  style="background: #fff !important;">
                                                                    <div class="modal-body p-0">
                                                                        <div class="card card-plain">
                                                                            <div class="card-header ">
                                                                                <div class="row">
                                                                                    <div class="col-11">
                                                                                        <h5 class="text-gradient text-danger">Online Payment</h5>
                                                                                    </div>
                                                                                    <div class="col-1">
                                                                                        <button style="text-align: right !important" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                                                            <span class="text-primary" aria-hidden="true">&times;</span>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <hr class="horizontal dark mt-0 mb-4"  style="margin-top: -25px !important">
                                                                                <div class="row">
                                                                                    <div class="col-lg-12 col-md-12 col-12">
                                                                                        <div class="d-flex">
                                                                                            <div>
                                                                                                <img src="{{ asset('assets') }}/img/pps-logo.png"
                                                                                                    class="avatar avatar-xxl me-3" alt="product image">
                                                                                            </div>
                                                                                            <div>
                                                                                                <h6 class="text-lg mb-0 mt-2" id="event_title">{{ $paymentList2->description }}</h6>
                                                                                                <p class="text-sm mb-0" id="event_category">{{ 'YEAR' . ' ' .$paymentList2->year_dues }}</p>
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
                                                                                                    <p class="text-secondary font-weight-normal text-xs mt-1 mb-0" id="created_at">{{ Carbon\Carbon::parse($paymentList2->created_at)->format('d M Y g:i A') }}</p>
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
                                                                                                    <h6 class="mb-3 text-sm" id="member_name">{{ $paymentList2->first_name }} {{ $paymentList2->middle_name }} {{ $paymentList2->last_name }} {{ $paymentList2->suffix }}</h6>
                                                                                                    
                                                                                                    <span class="mb-2 text-xs">Email Address: <span
                                                                                                            class="text-dark ms-2 font-weight-bold" id="email_address" style="word-break: break-all !important;">{{ $paymentList2->email_address }}</span></span>
                                                                                                    <span class="text-xs mb-2">Contact Number: <span
                                                                                                            class="text-dark ms-2 font-weight-bold" id="mobile_number">{{ $paymentList2->country_code }} {{ $paymentList2->mobile_number }}</span></span>
                                                                                                    <span class="mb-2 text-xs">Member Type: <span
                                                                                                        class="text-dark font-weight-bold ms-2" id="type">{{ $paymentList2->member_type_name }}
                                                                                                        </span></span>
                                                                                                </div>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                    
                                                                                    <div class="col-lg-4 col-12 ms-auto">
                                                                                        <form method="POST" role="form text-left" enctype="multipart/form-data" action="{{ url('payment-online') }}">
                                                                                            @csrf
                                                                                           
                                                                                            
                                                                                            <input type="hidden" name="transaction_id" id="transaction_id" value="{{ $paymentList2->transaction_id }}">
                                                                                            <input type="hidden" name="customer_name" id="customer_name" value="{{ $paymentList2->first_name }} {{ $paymentList2->middle_name }} {{ $paymentList2->last_name }} {{ $paymentList2->suffix }}">
                                                                                            <input type="hidden" name="email_adddress" id="event_email_adddress" value="{{ $paymentList2->email_address }}">
                                                                                            <input type="hidden" name="description" id="description" value="{{ $paymentList2->description }}">
                                                                                            <input type="hidden" name="total_price" id="total_price" value="{{ $paymentList2->total_amount }}">
                                                                                            <input type="hidden" name="pps_no" id="pps_no" value="{{ $paymentList2->pps_no }}">
                                                                                            <input type="hidden" name="year_dues" id="year_dues" value="{{ $paymentList2->year_dues }}">
                                                                                            <input type="hidden" name="member_type" id="member_type" value="{{ $paymentList2->member_type_name }}">
                                                                                            
                                                                                            
                                                                                            
                                                                                            
                                                                                            <h6 class="mb-3">Order Summary</h6>
                                                                                            <div class="d-flex justify-content-between">
                                                                                                <span class="mb-2 text-sm">
                                                                                                    Price:
                                                                                                </span>
                                                                                                <span class="text-dark font-weight-bold ms-2" id="price">&#8369; {{ number_format($paymentList2->total_amount, 2) }}</span>
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
                                                                                                <span class="text-dark text-lg ms-2 font-weight-bold" id="total_amount">&#8369; {{ number_format($paymentList2->total_amount, 2) }}</span>
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
                                                                                                      Total (Fee included) = &#8369; {{ number_format($paymentList2->total_amount * 1.030, 2) }}
                                                                                                     
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
                                                                                                      Total (Fee included) = ₱ {{ number_format(($paymentList2->total_amount * 1.040) + 15, 2) }}
                                                                                                     
                                                                                                    </label>
                                                                                                </div>
                                                                                            </div>
                                                                                            
                                                                                            






                                                                                          




                                                                                      





                                                                                            {{-- <div class="d-flex justify-content-between" id="gcashservicefeetotal" style="display: none !important">
                                                                                                <label class="mb-2 text-danger text-bolder" style="font-style: italic !important">
                                                                                                  Total (Fee included) = ₱ {{ number_format($paymentList2->total_amount * 1.025, 2) }}
                                                                                                 
                                                                                                </label>
                                                                                            </div> --}}






                                                                                            {{-- <div class="d-flex justify-content-between mt-1" id="cardservicefee" style="display: none !important">
                                                                                                <label class="mb-2 text-danger" style="font-style: italic !important">
                                                                                                   Note: Paymongo service fee + 3.5% + ₱ 15.00
                                                                                                </label>
                                                                                            </div>

                                                                                           

                                                                                            <div class="d-flex justify-content-between" id="cardservicefeetotal" style="display: none !important">
                                                                                                <label class="mb-2 text-danger text-bolder" style="font-style: italic !important">
                                                                                                  Total (Fee included) = ₱ {{ number_format(($paymentList2->total_amount * 1.035) + 15, 2) }}
                                                                                                 
                                                                                                </label>
                                                                                            </div> --}}

                                                                                            

                                                                                            <div class="d-flex justify-content-between mt-4">
                                                                                                <button type="submit" class="btn btn-warning w-100" type="button">  
                                                                                                    PAY NOW</button>
                                                                                            </div>
                                                                                         
                                                                                          
                                                                                        </form>
                                                                                    </div>
                                                                                   
                                                                                </div>
                                                                            </div>
                                                                        
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- End of online payment modal --}}

                                                        <!-- Start of Receipt Modal -->
                                                        <div class="modal fade" id="modalAnnualDuesReceipt-{{ $paymentList2->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalSignTitle" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                                <div class="modal-content"  style="background: #fff !important;">
                                                                    <div class="modal-body p-0">
                                                                        <div class="card card-plain">
                                                                            <div class="card-header ">
                                                                                <div class="row">
                                                                                    <div class="col-11">
                                                                                        <h5 class="text-gradient text-danger">Receipt</h5>
                                                                                    </div>
                                                                                    <div class="col-1">
                                                                                        <button style="text-align: right !important" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                                                            <span class="text-primary" aria-hidden="true">&times;</span>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <hr class="horizontal dark mt-0 mb-4"  style="margin-top: -25px !important">
                                                                                <div id="printPDF">

                                                                                
                                                                                    <div class="row">
                                                                                        <div class="col-lg-12 col-md-12 col-12">
                                                                                            <div class="d-flex">
                                                                                                <div>
                                                                                                    <img src="{{ asset('assets') }}/img/pps-logo.png"
                                                                                                        class="avatar avatar-xxl me-3" alt="product image">
                                                                                                </div>
                                                                                                <div>
                                                                                                    <h6 class="text-lg mb-0 mt-2" id="event_title">{{ $paymentList2->description }} </h6>
                                                                                                    <p class="text-sm mb-0" id="year_dues">Year {{ $paymentList2->year_dues }}</p>
                                                                                                    @if ($paymentList2->or_no == null)
                                                                                                        <p class="text-sm mb-0" id="or_no">OR Number: N/A</p>
                                                                                                    @else
                                                                                                        <p class="text-sm mb-0" id="or_no">OR Number: {{ $paymentList2->or_no }}</p>
                                                                                                    @endif
                                                                                            
                                                                                                    {{-- <p class="text-sm mb-1" id="event_description">{{ $eventTransaction2->description }}</p> --}}
                                                                                                    <span class="badge badge-sm bg-gradient-warning">PAID VIA {{ $paymentList2->payment_mode }}</span>
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
                                                                                                        <i class="material-icons text-success text-gradient text-lg">done</i>
                                                                                                    </span>
                                                                                                    <div class="timeline-content">
                                                                                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Payment Date</h6>
                                                                                                        <p class="text-secondary font-weight-normal text-xs mt-1 mb-0">{{ Carbon\Carbon::parse($paymentList2->payment_dt)->format('d M Y g:i A') }}</p>
                                                                                                    </div>
                                                                                                </div>
                                                                                            
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-5 col-12">
                                                                                    
                                                                                            <h6 class="mb-2">Billing Information</h6>
                                                                                            <ul class="list-group">
                                                                                                <li
                                                                                                    class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                                                                                    <div class="d-flex flex-column">
                                                                                                        <h6 class="mb-3 text-sm">{{ $paymentList2->first_name }} {{ $paymentList2->middle_name }} {{ $paymentList2->last_name }} {{ $paymentList2->suffix }}</h6>
                                                                                                        <span class="mb-2 text-xs">Email Address: <span
                                                                                                            class="text-dark ms-2 font-weight-bold" id="email_address" style="word-break: break-all !important;">{{ $paymentList2->email_address }}</span></span>
                                                                                                        <span class="text-xs mb-2">Contact Number: <span
                                                                                                                class="text-dark ms-2 font-weight-bold" id="mobile_number">{{ $paymentList2->country_code }} {{ $paymentList2->mobile_number }}</span></span>
                                                                                                        <span class="mb-2 text-xs">Member Type: <span
                                                                                                            class="text-dark font-weight-bold ms-2" id="type">{{ $paymentList2->type }}
                                                                                                            </span></span>
                                                                                                    </div>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                        <div class="col-lg-4 col-12 ms-auto">
                                                                                            <h6 class="mb-3">Order Summary</h6>
                                                                                            <div class="d-flex justify-content-between">
                                                                                                <span class="mb-2 text-sm">
                                                                                                    Event Price:
                                                                                                </span>
                                                                                                <span class="text-dark font-weight-bold ms-2">₱  {{ number_format($paymentList2->total_amount, 2) }}</span>
                                                                                            </div>
                                                                                            <div class="d-flex justify-content-between">
                                                                                                <span class="mb-2 text-sm">
                                                                                                    Amount:
                                                                                                </span>
                                                                                                @if ($paymentList2->payment_mode == "gcash")
                                                                                                    <span class="text-dark ms-2 font-weight-bold">₱ {{ number_format($paymentList2->total_amount, 2) }}</span>
                                                                                                @else
                                                                                                    <span class="text-dark ms-2 font-weight-bold">₱ {{ number_format($paymentList2->total_amount, 2) }}</span>
                                                                                                @endif
                                                                                                
                                                                                            </div>
                                                                                            <div class="d-flex justify-content-between">
                                                                                                <span class="text-sm">
                                                                                                    Discount:
                                                                                                </span>
                                                                                                <span class="text-dark ms-2 font-weight-bold">₱ 0.00</span>
                                                                                            </div>
                                                                                            <div class="d-flex justify-content-between">
                                                                                                <span class="text-sm">
                                                                                                    Change:
                                                                                                </span>
                                                                                                @if ($paymentList2->change == null)
                                                                                                    <span class="text-dark ms-2 font-weight-bold">₱ 0.00</span>
                                                                                                @else
                                                                                                    <span class="text-dark ms-2 font-weight-bold">₱ {{ number_format($paymentList2->change, 2) }}</span>
                                                                                                @endif
                                                                                                
                                                                                            </div>
                                                                                            <div class="d-flex justify-content-between mt-4">
                                                                                                <span class="mb-2 text-lg text-danger">
                                                                                                    Total:
                                                                                                </span>
                                                                                                <span class="text-dark text-lg ms-2 font-weight-bold">₱ {{ number_format($paymentList2->total_amount, 2) }}</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mt-2" style="text-align: right !important">
                                                                                    <div class="col-md-12 col-12">
                                                                                        <button class="btn btn-danger" type="button" id="printBtn">PRINT</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- End of Receipt Modal --}}
                                              
                                                @endforeach
                                                 
                                              
                                            </tbody>
                                        </table>
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
    <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
    <script src="{{ asset('assets') }}/js/payment.js"></script>
    <script src="{{ asset('assets') }}/js/payment-data-table.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/choices.min.js"></script>
    <script src="{{ asset('assets') }}/js/moment.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/photoswipe.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/photoswipe-ui-default.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/datatables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script>

$("#printBtn").click(function(){

    var element = document.getElementById('printPDF');
html2pdf(element);

    // var element = document.getElementById('printPDF');
    // var opt = {
    // margin:       1,
    // filename:     'myfile.pdf',
    // image:        { type: 'jpeg', quality: 0.98 },
    // html2canvas:  { scale: 2 },
    // jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
    // };
    // html2pdf().set(opt).from(element).save();
});



        function on_change(el){
      var selectedOption = el.target.value;
      if (selectedOption === 'gcash') {
        document.getElementById('gcashDiv').style.display = 'block';
      } else {
        document.getElementById('gcashDiv').style.display = 'none'; // Hide el
      }
      
    }

    @if (Session::has('status'))
        @if (Session::get('status') == 'waiting')
            Swal.fire({
                title: "Please Wait",
                text: "Your payment status is being processed. Please wait for the confirmation and try refreshing the page after 5-10 seconds.",
                icon: "info",
                confirmButtonText: "Okay"
            });
        @elseif (Session::get('status') == 'success')
            Swal.fire({
                title: "Success!",
                text: "Payment has been completed!",
                icon: "success",
                confirmButtonText: "Okay"
            });
        @elseif (Session::get('status') == 'exist')
            Swal.fire({
                title: "Success!",
                text: "Payment has been completed, but you have existing dues!",
                icon: "success",
                confirmButtonText: "Okay"
            });
        @endif
    @endif

        
    </script>
    @endpush
</x-page-template>
