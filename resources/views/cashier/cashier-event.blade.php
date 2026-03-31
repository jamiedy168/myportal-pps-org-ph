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
                            <h5 class="mb-4">Event Transaction</h5>
                            <form class="form-horizontal" action="{{ route('cashier-search-event') }}" method="GET" autocomplete="off">
                                @csrf
                                <div class="row">
                                    
                                    <div class="col-lg-6 col-12">
                                        <div class="input-group input-group-outline">
                                            <label class="form-label">Search here..</label>
                                            <input type="text" class="form-control" id="searchbox-input" name="searchinput" style="height: 46px !important">
                                            <button class="btn bg-gradient-danger btn-lg" type="submit"  id="searchBtn"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="input-group input-group-outline">
                                            <button class="btn bg-gradient-danger btn-lg dropdown dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
                                                ACTION
                                              </button>
                                              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                {{-- <li><a class="dropdown-item" id="newTransactionBtn" type="button" data-bs-toggle="modal" data-bs-target="#modalEventNewTransaction">New Transaction</a></li> --}}
                                                <li><a class="dropdown-item" id="updateOnlinePayment" type="button" data-bs-toggle="modal" data-bs-target="#modalEventUpdateOnlinePayment">Update Online Payment</a></li>
                                              </ul>
                                        </div>
                                        
                                    </div>
                                    
                                    
                                </div>
                            </form>
                             <div class="row">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalSyncPayment">SYNC ONLINE PAYMENT</button>
                                </div>
                            </div>

                            
                            <div class="row mt-5">
                                <div class="col-12">
                                    
                                    <div class="table table-responsive" id="table_transaction">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th
                                                        class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                        Attendee</th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                                        Category/Title</th>
                                                
                                                    
                                                    <th
                                                        class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                                        PRICE/AMOUNT</th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                                        Status</th>
                                                    <th></th>
                                                   
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($eventTransaction as $eventTransaction2)
                                               
                                                <tr>
                                                    <td>


                                                        <div class="d-flex flex-column mt-1">
                                        
                                                            <a class="mb-1 text-sm text-danger" style="font-weight: bold">{{ $eventTransaction2->first_name }} {{ $eventTransaction2->middle_name }} {{ $eventTransaction2->last_name }} {{ $eventTransaction2->suffix }}</a>
                                                              @if ($eventTransaction2->prc_number == null)
                                                              <span class="mb-1 text-xs">PRC Number: <span
                                                                class="text-dark ms-sm-2 font-weight-bold">N/A</span></span>
                                                              @else
                                                              <span class="mb-1 text-xs">PRC Number: <span
                                                                class="text-dark ms-sm-2 font-weight-bold">{{ $eventTransaction2->prc_number }}</span></span>
                                                              @endif
                                                              
                                                                <span class="mb-1 text-xs">Member Type: <span
                                                                    class="text-dark font-weight-bold ms-sm-2">{{ $eventTransaction2->member_type_name }}</span></span>
                                                            </div>


                                                        {{-- <div class="d-flex px-2 py-1">
                                                            <div>
                                                                <img src="{{URL::asset('/img/profile/'.$eventTransaction2->picture)}}"
                                                                    class="avatar avatar-md me-3" alt="table image">
                                                            </div>
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0">{{ $eventTransaction2->first_name }} {{ $eventTransaction2->middle_name }} {{ $eventTransaction2->last_name }} {{ $eventTransaction2->suffix }}
                                                                </h6>
                                                                <span class="text-success text-sm">{{ $eventTransaction2->type }}</span>
                                                            </div>
                                                        </div> --}}
                                                    </td>
                                                    <td>
                                                        <h6 class="mb-0 text-sm">{{ $eventTransaction2->category_name }} ({{ $eventTransaction2->title }})
                                                        </h6>        
                                                      
                                                    </td>
                                                    

                                                    
                                                    <td>
                                                        <span class="text-secondary text-sm text-bold">₱ {{ number_format($eventTransaction2->total_amount, 2) }}</span>
                                                    </td>
                                                    <td class="text-xs font-weight-normal">
                                                        <div class="d-flex align-items-center">
                                                            @if ($eventTransaction2->payment_dt == null)
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
                                                                <span class="text-success text-bold">PAID <br> {{ Carbon\Carbon::parse($eventTransaction2->payment_dt)->format('M. d, Y - h: i a') }} via {{ $eventTransaction2->payment_mode }}
                                                                <br>
                                                                @if ($eventTransaction2->or_no == null)
                                                                    OR #: N/A
                                                                @else
                                                                    OR #: {{ $eventTransaction2->or_no }}
                                                                @endif 
                                                            </span>
                                                                
                                                            @endif
                                                        </div>



                                                        {{-- <div class="d-flex align-items-center">
                                                            
                                                            @if ($eventTransaction2->paid == false)
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
                                                                    <span class="text-success text-bold">PAID</span>
                                                            @endif
                                                            
                                                        </div> --}}
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($eventTransaction2->paid == false)
                                                        <a href="cashier-event-pay/{{ Crypt::encrypt( $eventTransaction2->id )}}" class="btn btn-icon btn-danger btn-outline-danger w-100 mt-3" style="height: 37px !important;" type="button">
                                                            <span class="btn-inner--icon"><i class="material-icons">credit_card</i></span>
                                                            <span class="btn-inner--text">&nbsp;VIEW</span>
                                                        </a>
                                                            
                                                        @else
                                                        <div class="disabled-button-wrapper w-100" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="User already paid on this event. Paid via {{ $eventTransaction2->payment_mode }} on {{ Carbon\Carbon::parse($eventTransaction2->payment_dt)->format('M. d Y g:i A') }}">
                                                            <button disabled class="btn btn-icon btn-danger btn-outline-danger w-100 mt-3" style="height: 37px !important;" type="button">
                                                                <span class="btn-inner--icon"><i class="material-icons">credit_card</i></span>
                                                                <span class="btn-inner--text">&nbsp;VIEW</span></button>
                                                        </div>
                                                        <div style="margin-top:-20px !important">
                                                            <button class="btn btn-icon btn-danger btn-outline-danger w-100 mt-3" style="height: 37px !important;" type="button" data-bs-toggle="modal" data-bs-target="#modalEventReceipt-{{ $eventTransaction2->id }}">
                                                                <span class="btn-inner--icon"><i class="material-icons">receipt_long</i></span>
                                                                <span class="btn-inner--text">&nbsp;VIEW RECEIPT</span>
                                                            </button>
                                                        </div>
                                                       
                                                        @endif
                                                        
                                                    </td>

                                                </tr>

                                                <!-- Start of Receipt Modal -->
                                                <div class="modal fade" id="modalEventReceipt-{{ $eventTransaction2->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalSignTitle" aria-hidden="true">
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
                                                                        <div class="row">
                                                                            <div class="col-lg-12 col-md-12 col-12">
                                                                                <div class="d-flex">
                                                                                    <div>
                                                                                        <img src="{{ asset('assets') }}/img/pps-logo.png"
                                                                                            class="avatar avatar-xxl me-3" alt="product image">
                                                                                    </div>
                                                                                    <div>
                                                                                        <h6 class="text-lg mb-0 mt-2" id="event_title">{{ $eventTransaction2->title }}</h6>
                                                                                        <p class="text-sm mb-0" id="event_category">{{ $eventTransaction2->category_name }}</p>
                                                                                        <p class="text-sm mb-1" id="event_description">{{ $eventTransaction2->description }}</p>
                                                                                        <span class="badge badge-sm bg-gradient-warning">PAID VIA {{ $eventTransaction2->payment_mode }}</span>
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
                                                                                            <i class="material-icons text-secondary text-lg">calendar_month</i>
                                                                                        </span>
                                                                                        <div class="timeline-content">
                                                                                            <h6 class="text-dark text-sm font-weight-bold mb-0">Joined Date</h6>
                                                                                            <p class="text-secondary font-weight-normal text-xs mt-1 mb-0">{{ Carbon\Carbon::parse($eventTransaction2->joined_dt)->format('d M Y g:i A') }}</p>
                                                                                        </div>
                                                                                    </div>
                                                                                    
                                                                                    <div class="timeline-block mb-3">
                                                                                        <span class="timeline-step">
                                                                                            <i class="material-icons text-success text-gradient text-lg">done</i>
                                                                                        </span>
                                                                                        <div class="timeline-content">
                                                                                            <h6 class="text-dark text-sm font-weight-bold mb-0">Payment Date</h6>
                                                                                            <p class="text-secondary font-weight-normal text-xs mt-1 mb-0">{{ Carbon\Carbon::parse($eventTransaction2->payment_dt)->format('d M Y g:i A') }}</p>
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
                                                                                            <h6 class="mb-3 text-sm">{{ $eventTransaction2->first_name }} {{ $eventTransaction2->middle_name }} {{ $eventTransaction2->last_name }} {{ $eventTransaction2->suffix }}</h6>
                                                                                            <span class="mb-2 text-xs">Email Address: <span
                                                                                                class="text-dark ms-2 font-weight-bold" id="email_address" style="word-break: break-all !important;">{{ $eventTransaction2->email_address }}</span></span>
                                                                                            <span class="text-xs mb-2">Contact Number: <span
                                                                                                    class="text-dark ms-2 font-weight-bold" id="mobile_number">{{ $eventTransaction2->country_code }} {{ $eventTransaction2->mobile_number }}</span></span>
                                                                                            <span class="mb-2 text-xs">Member Type: <span
                                                                                                class="text-dark font-weight-bold ms-2" id="type">{{ $eventTransaction2->type }}
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
                                                                                    <span class="text-dark font-weight-bold ms-2">₱  {{ number_format($eventTransaction2->prices, 2) }}</span>
                                                                                </div>
                                                                                <div class="d-flex justify-content-between">
                                                                                    <span class="mb-2 text-sm">
                                                                                        Amount:
                                                                                    </span>
                                                                                    @if ($eventTransaction2->payment_mode == "gcash")
                                                                                        <span class="text-dark ms-2 font-weight-bold">₱ {{ number_format($eventTransaction2->total_amount, 2) }}</span>
                                                                                    @else
                                                                                        <span class="text-dark ms-2 font-weight-bold">₱ {{ number_format($eventTransaction2->amount, 2) }}</span>
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
                                                                                    @if ($eventTransaction2->change == null)
                                                                                        <span class="text-dark ms-2 font-weight-bold">₱ 0.00</span>
                                                                                    @else
                                                                                        <span class="text-dark ms-2 font-weight-bold">₱ {{ number_format($eventTransaction2->change, 2) }}</span>
                                                                                    @endif
                                                                                    
                                                                                </div>
                                                                                <div class="d-flex justify-content-between mt-4">
                                                                                    <span class="mb-2 text-lg text-danger">
                                                                                        Total:
                                                                                    </span>
                                                                                    <span class="text-dark text-lg ms-2 font-weight-bold">₱ {{ number_format($eventTransaction2->total_amount, 2) }}</span>
                                                                                </div>
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
                                    <br>
                                    
                                    {{ $eventTransaction->appends($_GET)->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                            {{-- START MODAL PAY --}}
                            <div class="modal fade" id="modalEventPay" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                                <div class="loading" id="loading2" style="display: none;"> 
                                    <img src="{{ asset('assets') }}/img/pps-logo.png" style="height: 60px !important; width: 60px !important" alt="img-blur-shadow" class="icons">
                                </div>
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content">
                                    
                                    <div class="modal-body p-0">
                                        <div class="card card-plain">
                                        <div class="card-header pb-0 text-left">
                                            <div class="row">
                                                <div class="col-11">
                                                    <h5 class="text-gradient text-danger">Transaction</h5>
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
                                            <div class="row">
                                                <div class="col-lg-12 col-md-6 col-12">
                                                    <div class="d-flex">
                                                        <div>
                                                            <img src="{{ asset('assets') }}/img/pps-logo.png"
                                                                class="avatar avatar-xxl me-3" alt="product image">
                                                        </div>
                                                        <div>
                                                            <h6 class="text-lg mb-0 mt-2" id="event_title"></h6>
                                                            <p class="text-sm mb-0" id="event_category"></p>
                                                            <p class="text-sm mb-3" id="event_description"></p>
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
                                                                <p class="text-secondary font-weight-normal text-xs mt-1 mb-0" id="event_joined_dt"></p>
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
                                                                <h6 class="mb-3 text-sm" id="member_name"></h6>
                                                                
                                                                <span class="mb-2 text-xs">Email Address: <span
                                                                        class="text-dark ms-2 font-weight-bold" id="email_address" style="word-break: break-all !important;"></span></span>
                                                                <span class="text-xs mb-2">Contact Number: <span
                                                                        class="text-dark ms-2 font-weight-bold" id="mobile_number"></span></span>
                                                                <span class="mb-2 text-xs">Member Type: <span
                                                                    class="text-dark font-weight-bold ms-2" id="type">
                                                                    </span></span>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                
                                                <div class="col-lg-4 col-12 ms-auto">
                                                    <form method="POST" role="form" enctype="multipart/form-data" id="cashier-event-pay">
                                                        @csrf
                                                        {{-- Start of hidden input --}}
                                                        <input type="hidden" id="price_validation">
                                                        <input type="hidden" id="change_validation">
                                                        <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">
                                                        <input type="hidden" value="{{ url('cashier-event-pay')}}" id="urlCashierEventPay">
                                                        <input type="hidden" name="transaction_id" id="transaction_id">
                                                        <input type="hidden" name="pps_no" id="pps_no">
                                                        <input type="text" name="total" id="total_price">
                                                        
                                                        <h6 class="mb-3">Order Summary</h6>
                                                        <div class="d-flex justify-content-between">
                                                            <span class="mb-2 text-sm">
                                                                Price:
                                                            </span>
                                                            <span class="text-dark font-weight-bold ms-2" id="price"></span>
                                                        </div>
                                                        <div class="d-flex justify-content-between">
                                                            <span class="mb-2 text-sm">
                                                                Discount:
                                                            </span>
                                                            <span class="text-dark ms-2 font-weight-bold">₱ 0.00</span>
                                                        </div>
                                                        {{-- <div class="d-flex justify-content-between mt-2">
                                                            <span class="text-sm">
                                                                Input Amount:
                                                            </span>
                                                        
                                                           
                                                        
                                                        <div class="d-flex justify-content-between mt-0">
                                                            <div class="input-group input-group-outline">
                                                            
                                                                <input type="number" id="member_amount" min="0" oninput="this.value = Math.abs(this.value)" required class="form-control text-center" placeholder="₱ 0.00">
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-between mt-0">
                                                            <span class="text-sm">
                                                                Input OR Number:
                                                            </span>
                                                        </div>
                                                        
                                                        <div class="d-flex justify-content-between mt-0">
                                                            <div class="input-group input-group-outline">
                                                            
                                                                <input type="number" id="or_no" min="0" oninput="this.value = Math.abs(this.value)" required class="form-control text-center">
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-between mt-2">
                                                            <span class="mb-2 text-sm">
                                                                Change:
                                                            </span>
                                                            <span class="text-dark ms-2 font-weight-bold" id="change"></span>
                                                        </div> --}}
                                                        <div class="d-flex justify-content-between mt-2">
                                                            <span class="mb-2 text-lg text-danger">
                                                                Total:
                                                            </span>
                                                            <span class="text-dark text-lg ms-2 font-weight-bold" id="total_amount"></span>
                                                        </div>
                                                        <div class="d-flex justify-content-between mt-4">
                                                            <button type="submit" class="btn btn-danger w-100" type="button">PAY</button>
                                                        </div>
                                                        {{-- End of hidden input --}}
                                                    </form>
                                                </div>
                                               
                                            </div>
                                        </div>
                                        
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            {{-- END MODAL PAY --}}


                            {{-- START MODAL CHOOSE EVENT --}}
                            <div class="modal fade" id="modalEventNewTransaction" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                            
                                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                    <div class="modal-content">
                                    
                                        <div class="modal-body p-0">
                                            <div class="card card-plain">
                                                <div class="card-header pb-0 text-left">
                                                    <div class="row">
                                                        <div class="col-11">
                                                            <h5 class="text-gradient text-danger">Choose Event</h5>
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
                                                    
                                                    <div class="row mt-5">
                                                        <div class="col-12">
                                                            
                                                            <div class="table table-responsive" id="table_transaction">
                                                                <table class="table align-items-center mb-0">
                                                                    <thead>
                                                                        <tr>
                                                                            <th
                                                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                                                </th>
                                                                            <th
                                                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                                                                Title</th>
                                             
                                                                            <th
                                                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                                                            </th>
                                                                         
                                                                           
                                                                            
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($event as $event2)
                                                                        <tr>
                                                                            <td class="text-center">
                                                                                <div class="d-flex px-2 py-1">
                                                                                    <div>
                                                                                        <img src="{{ asset('assets') }}/img/pps-logo.png"
                                                                                            class="avatar avatar-lg me-3" alt="table image">
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                        
                                                                            <td class="text-left">
                                                                                <span class="text-secondary text-sm text-bold"> {{ $event2->title }}</span>
                                                                            </td>

                                                                            <td class="text-xs font-weight-normal">
                                                                                <div class="d-flex align-items-center mt-3">
                                                                                    <a class="btn btn-danger" type="button" href="cashier-event-transaction/{{ Crypt::encrypt( $event2->id )}}">Select</a>
                                                                                </div>
                                                                            </td>
    
                                                                        </tr>
                    
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
                                </div>
                            </div>
                            {{-- END MODAL CHOOSE EVENT --}}


                            {{-- START MODAL UPDATE PAYMENT --}}
                            <div class="modal fade" id="modalEventUpdateOnlinePayment" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                            
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        
                                        <div class="modal-body p-0">
                                            <div class="card card-plain">
                                                <div class="card-header pb-0 text-left">
                                                    <div class="row">
                                                        <div class="col-11">
                                                            <h5 class="text-gradient text-danger">Update Online Payment</h5>
                                                        </div>
                                                        <div class="col-1">
                                                            <button style="text-align: right !important" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                                <span class="text-primary" aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    
                                                    <hr>
                                                </div>
                                                <div class="card-body p-3 pt-0">
                                                  
                                                    <form method="POST" role="form" enctype="multipart/form-data" id="cashierupdateonlinepaymentform">
                                                        @csrf
                                                        <input type="hidden" id="token2" name="token" value="{{ csrf_token() }}">
                                                        <input type="hidden" value="{{ url('cashier-update-event-online-payment') }}" id="urlCashierEventUpdatePayment">
                                          
                                                    <div class="row">
                                                        <div class="col-1">     
                    
                                                        </div>
                                                        <div class="col-lg-10 col-12">
                                                        <label class="form-label text-bold">Select Member<code> <b>*</b></code></label>
                                                        <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                                            <input type="hidden" id="memberSearchUrl" value="{{ route('cashier.searchMemberDropDownWithoutEncrypt') }}">
                                                            <select name="pps_no" id="pps_no_update" class="form-control updated-payment-member" required></select>
                                                            
                                                             {{-- <select name="pps_no" id="pps_no_update" class="form-control updated-payment-member">
                                                                <option value="">-- Select --</option>
                                                                @foreach ($member as $member2)
                                                                    <option value="{{ $member2->pps_no }}">{{ $member2->first_name }} {{ $member2->middle_name }} {{ $member2->last_name }} | {{ $member2->prc_number }}</option>
                                                                @endforeach
                                                            </select> --}}
                                                        </div>
                                                        <p class="text-danger inputerror mt-0" style="display: none">The or number field is required. </p>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-1">     
                    
                                                        </div>
                                                        <div class="col-lg-10 col-12">
                                                        <label class="form-label text-bold">Select Event<code> <b>*</b></code></label>
                                                        <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                                            <select name="event_id" id="event_id_update" class="form-control update-payment-event">
                                                                <option value="">-- Select --</option>
                                                                
                                                                @foreach ($event as $event2)
                                                                    <option value="{{ $event2->id }}">{{ $event2->title }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <p class="text-danger inputerror mt-0" style="display: none">The or number field is required. </p>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-1">     
                    
                                                        </div>
                                                        <div class="col-lg-10 col-12">
                                                        <label class="form-label text-bold">Input Paymongo Transaction Number<code> <b>*</b></code></label>
                                                        <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                                            <input type="text" class="form-control" name="paymongo_transaction_number" id="paymongo_transaction_number_update" required>
                                                        </div>
                                                        <p class="text-danger inputerror mt-0" style="display: none">The or number field is required. </p>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="row mt-5">
                                                        <div class="col-lg-2">
                    
                                                        </div>
                                                        <div class="col-lg-9 col-12" style="text-align: right !important">
                                                            <button class="btn btn-danger" type="submit">UPDATE</button>
                                                            <button class="btn btn-warning" type="button" data-bs-dismiss="modal">CANCEL</button>
                                                        </div>
                                                        
                                                    </div>
                                                    </form>
                                                </div>
                                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- END MODAL CHOOSE EVENT --}}


                            
                              {{-- Start of modal sync online payment --}}
                              <div class="modal fade" id="modalSyncPayment" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">

                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        
                                        <div class="modal-body p-0">
                                            <div class="card card-plain">
                                                <div class="card-header pb-0 text-left">
                                                    <div class="row">
                                                        <div class="col-11">
                                                            <h5 class="text-gradient text-danger">Sync Online Payment</h5>
                                                        </div>
                                                        <div class="col-1">
                                                            <button style="text-align: right !important" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                                <span class="text-primary" aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    
                                                    <hr>
                                                </div>
                                                <div class="card-body p-3 pt-0">
                                                    <form method="POST" action="cashier-sync-event-payment"  role="form text-left" enctype="multipart/form-data" >
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-1">     
                        
                                                            </div>
                                                            <div class="col-lg-10 col-12">
                                                                <label class="form-label text-bold">Payment Date From<code> <b>*</b></code></label>
                                                                <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                                                    <input type="date" class="form-control" name="date_from" id="date_from" required>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-1">     
                        
                                                            </div>
                                                            <div class="col-lg-10 col-12">
                                                                <label class="form-label text-bold">Payment Date To<code> <b>*</b></code></label>
                                                                <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                                                    <input type="date" class="form-control" name="date_to" id="date_to" required>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="row mt-5">
                                                            <div class="col-lg-2">
                        
                                                            </div>
                                                            <div class="col-lg-9 col-12" style="text-align: right !important">
                                                                <button class="btn btn-danger" type="submit">SYNC</button>
                                                                <button class="btn btn-warning" type="button" data-bs-dismiss="modal">CANCEL</button>
                                                            </div>
                                                            
                                                        </div>
                                                    </form>
                                                </div>
                                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- End of modal sync payment --}}
                            


                            
                          
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
    <script src="{{ asset('assets') }}/js/cashier-event.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/choices.min.js"></script>
    <script src="{{ asset('assets') }}/js/moment.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/photoswipe.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/photoswipe-ui-default.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>
    <script src="{{ asset('assets') }}/js/select2.min.js"></script>
    <link href="{{ asset('assets') }}/css/select2.min.css" rel="stylesheet" />


    <script>
        @if (Session::has('status'))
            @if (Session::get('status') == 'success')
                Swal.fire({
                    title: "Success!",
                    text: "Payment has been completed!",
                    icon: "success",
                    confirmButtonText: "Okay"
                });
            @elseif (Session::get('status') == 'failed')
                Swal.fire("Warning", "Payment has been failed, please try again", "error");
            @elseif (Session::get('status') == 'wrongpayment')
                Swal.fire("Warning", "Payment id not found, please try again", "error");    
            @elseif (Session::get('status') == 'sync')
                Swal.fire({
                    title: "{{ Session::get('total_updated') }} Payments Updated!",
                    text: "Paymongo Payment Successfully Updated!",
                    icon: "success",
                    confirmButtonText: "Okay"
                });  
            @endif
        
        @endif
    </script>
    @endpush
</x-page-template>
