
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
                        <h6 class="text-lg mb-0 mt-2" id="event_title">{{ $event->title }}</h6>
                        <p class="text-sm mb-0" id="event_category">{{ $event->category }}</p>
                        <p class="text-sm mb-3" id="event_description" style="white-space: pre-wrap !important;">{{ $event->description }}</p>
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
                            <p class="text-secondary font-weight-normal text-xs mt-1 mb-0" id="event_joined_dt">Pay to join</p>
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
                            <h6 class="mb-3 text-sm" id="member_name">{{ $info->first_name }} {{ $info->middle_name }} {{ $info->last_name }} {{ $info->suffix }}</h6>
                            
                            <span class="mb-2 text-xs">Email Address: <span
                                    class="text-dark ms-2 font-weight-bold" id="email_address" style="word-break: break-all !important;">{{ $info->email_address }}</span></span>
                            <span class="text-xs mb-2">Contact Number: <span
                                    class="text-dark ms-2 font-weight-bold" id="mobile_number">{{ $info->country_code }} {{ $info->mobile_number }}</span></span>
                            <span class="mb-2 text-xs">Member Type: <span
                                class="text-dark font-weight-bold ms-2" id="type">{{ $info->member_type_name }}
                                </span></span>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-lg-4 col-12 ms-auto">
                <form method="POST" role="form text-left" enctype="multipart/form-data" action="{{ url('event-payment-online') }}" id="payment_online">
                    @csrf
                    {{-- Start of hidden input --}}
                        <input type="hidden" name="price" value="{{ $event->prices }}">
                        <input type="hidden" name="event_customer_name" id="event_customer_name" value="{{ $info->first_name }} {{ $info->middle_name }} {{ $info->last_name }} {{ $info->suffix }}">
                        <input type="hidden" name="event_email_adddress" id="event_email_adddress" value="{{ $info->email_address }}">
                        <input type="hidden" name="mobile_number" id="mobile_number" value="{{ $info->mobile_number }}">

                        <input type="hidden" name="event_title" id="event_title" value="{{ $event->title }}">
                        <input type="hidden" name="pps_no" id="pps_no" value="{{ $info->pps_no }}">
                        <input type="hidden" name="event_id" id="event_id" value="{{ $event->id }}">
                        <input type="hidden" name="member_type_name" id="member_type_name" value="{{ $info->member_type_name }}">
                        <input type="hidden" value="{{ $pps_no_encrypt }}" id="pps_no_encrypt">
                        <input type="hidden" value="{{ $member->member_type }}" id="member_type_id">

                    {{-- End of hidden input --}}


                    {{-- START OF TOPIC MODAL --}}
                    <div class="modal fade" id="modalChooseTopic" tabindex="-1" role="dialog" aria-labelledby="exampleModalSignTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered " role="document">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-left">
                                    <div class="row">
                                        <div class="col-8">
                                            <h5 class="">Topic</h5>
                                        </div>
                                        <div class="col-4" style="text-align: right !important">
                                            <button type="button" class="btn-close" style="color: black !important" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <p class="mb-0">Please choose your desired topic to attend in the list.</p>
                                    
                                </div>
                                <div class="card-body pb-3">

                                    <input type="hidden" id="token" value="{{ csrf_token() }}">
                                    <input type="hidden" value="{{ url('event-count-topic-attendee')}}" id="urlCountTopicAttendee">

                                    <div class="row">
                                        @foreach ($eventTopic as $eventTopic2)
                                            <div class="col-6">
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="radio" name="topic_id" id="topic" value="{{ $eventTopic2->id }}">
                                                    <label class="custom-control-label text-bold" for="topic">{{ $eventTopic2->topic_name }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="row" style="text-align: right !important">
                                        <div class="col-12 col-lg-12">
                                            <button type="button" class="btn btn-danger" id="proceed_payment_btn">PROCEED</button>
                                            <button type="button" class="btn btn-link ml-auto" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    {{-- END OF TOPIC MODAL --}}


                    <h6 class="mb-3">Order Summary</h6>
                    <div class="d-flex justify-content-between">
                        <span class="mb-2 text-sm">
                            Price:
                        </span>
                        @if ($info->member_type_name == "FOREIGN DELEGATE")
                            <span class="text-dark font-weight-bold ms-2" id="price">$ {{ number_format($event->prices, 2) }}</span>
                        @else
                            <span class="text-dark font-weight-bold ms-2" id="price">₱ {{ number_format($event->prices, 2) }}</span>
                        @endif
                       
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="mb-2 text-sm">
                            Discount:
                        </span>
                        @if ($info->member_type_name == "FOREIGN DELEGATE")
                            <span class="text-dark ms-2 font-weight-bold">$ 0.00</span>
                        @else
                            <span class="text-dark ms-2 font-weight-bold">₱ 0.00</span>
                        @endif
                        
                    </div>

                    <div class="d-flex justify-content-between mt-2">
                        <span class="mb-2 text-lg text-danger">
                            Total: 
                        </span>
                        @if ($info->member_type_name == "FOREIGN DELEGATE")
                            <span class="text-dark text-lg ms-2 font-weight-bold" id="total_amount">$ {{ number_format($event->prices, 2) }}</span>
                        @else
                            <span class="text-dark text-lg ms-2 font-weight-bold" id="total_amount">₱ {{ number_format($event->prices, 2) }}</span>
                        @endif
                        
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
                        @if ($info->member_type_name == "FOREIGN DELEGATE")
                            <div>
                                
                            </div>
                        @else
                            <div>
                                <label class="mb-2 text-danger text-bolder" style="font-style: italic !important">
                                Total (Fee included) = ₱ {{ number_format($event->prices * 1.030, 2) }}
                                
                                </label>
                            </div>
                            
                        @endif
                       
                    </div>


                    <div id="" class="desc paymentcard" style="display: none !important">
                        <div>
                            <label class="mb-2 text-danger" style="font-style: italic !important">
                               Note: Paymongo service fee + 4.0% + ₱ 15.00 for card transaction.
                            </label>
                        </div>
                        @if ($info->member_type_name == "FOREIGN DELEGATE")
                            <div>

                            </div>
                        @else
                            <div>
                                <label class="mb-2 text-danger text-bolder" style="font-style: italic !important">
                                Total (Fee included) = ₱ {{ number_format(($event->prices * 1.030) + 10, 2) }}
                                
                                </label>
                            </div>
                        @endif
                       
                    </div>


                   {{-- NO IMAGE PROFILE  --}}
                   @if ($member->picture == null)    
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-danger w-100 upload-certificate" id="noimage" type="button">  
                            <span class="btn-inner--icon"><i class="material-icons">credit_card</i></span>
                            <span class="btn-inner--text">&nbsp;PAY NOW</span></button>
                    </div>    
                   {{-- RESIDENTTRAINEES  --}}
                   @elseif ($member->member_type == 6 && $member->residency_certificate == null)
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-danger w-100 upload-certificate" id="residencycert" type="button">  
                                <span class="btn-inner--icon"><i class="material-icons">credit_card</i></span>
                                <span class="btn-inner--text">&nbsp;PAY NOW</span></button>
                        </div>

                    {{-- GOVERNMENT PHYSICIAN  --}}
                    @elseif ($member->member_type == 7 && $member->government_physician_certificate == null)    
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-danger w-100 upload-certificate" id="governmentcert" type="button">  
                                <span class="btn-inner--icon"><i class="material-icons">credit_card</i></span>
                                <span class="btn-inner--text">&nbsp;PAY NOW</span></button>
                        </div>

                    {{-- FELLOWS IN TRAINING  --}}
                    @elseif ($member->member_type == 9 && $member->fellows_in_training_certificate == null)    
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-danger w-100 upload-certificate" id="fellowscert" type="button">  
                                <span class="btn-inner--icon"><i class="material-icons">credit_card</i></span>
                                <span class="btn-inner--text">&nbsp;PAY NOW</span></button>
                        </div>

                
                    {{-- OTHER TYPE OF MEMBER  --}}
                    @else
                        @if ($event->selected_members == true)
                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-danger w-100" type="button" data-bs-toggle="modal" data-bs-target="#modalChooseTopic">  
                                    <span class="btn-inner--icon"><i class="material-icons">credit_card</i></span>
                                    <span class="btn-inner--text">&nbsp;PAY NOW</span></button>
                            </div>
                        @else
                            <div class="d-flex justify-content-between mt-4">
                                <button type="submit" class="btn btn-danger w-100" type="button">  
                                    <span class="btn-inner--icon"><i class="material-icons">credit_card</i></span>
                                    <span class="btn-inner--text">&nbsp;PAY NOW</span></button>
                            </div>
                        @endif    

                    @endif

                    
                    {{-- <div class="d-flex justify-content-between mt-4">
                        <a type="submit" class="btn btn-danger w-100" type="button" href="/payment-hold">  
                            <span class="btn-inner--icon"><i class="material-icons">credit_card</i></span>
                            <span class="btn-inner--text">&nbsp;PAY NOW</span></a>
                    </div> --}}
                   
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
  <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
  <script src="{{ asset('assets') }}/js/payment.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>

    @endpush
  </x-page-template>
  