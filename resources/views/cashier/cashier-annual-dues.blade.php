<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="cashier" activeItem="cashier-annual-dues" activeSubitem="">
    </x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-auth.navbars.navs.auth pageTitle="Cashier"></x-auth.navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            {{-- <div class="loading" id="loading5"> 
                    <img src="{{ asset('assets') }}/img/pps-logo.png" style="height: 60px !important; width: 60px !important" alt="img-blur-shadow" class="icons">
            </div> --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-4">Annual Dues Transaction</h5>
                            <input type="hidden" value="{{ url('cashier-annual-dues-remove') }}" id="urlCashierAnnualDuesRemove">
                            <input type="hidden" id="token" value="{{ csrf_token() }}">
                            <form class="form-horizontal" action="{{ route('cashier-search-annual-dues') }}" method="GET" autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <div class="input-group input-group-outline">
                                            <label class="form-label">Enter name or prc number here..</label>
                                            <input type="search" class="form-control" name="searchinput" id="search-input2" value="{{ $name }}" style="height: 46px !important">
                                            <button class="btn bg-gradient-danger btn-lg" id="searchBtn" type="submit"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="input-group input-group-outline">
                                            {{-- <button class="btn bg-gradient-danger btn-lg" value="{{ $name }}" id="newTransactionBtn" type="button" data-bs-toggle="modal" data-bs-target="#modalAnnualDuesNewTransaction">New Transaction</button> --}}
                                            <a class="btn bg-gradient-danger btn-lg" id="newTransactionBtn" type="button" href="/cashier-new-transaction">New Transaction</a>
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
                                    
                                    <div class="table table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                   
                                                    <th
                                                        class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                                        Member</th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                                        Description</th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xs font-weight-bolder text-center opacity-7 ps-2">
                                                        Price</th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                                        Status</th>
                                                    <th></th>
                                                   
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($transaction as $transaction2)
                                               
                                                <tr>
                                                  
                                                        {{-- <td style="text-align: center !important">
                                                            <div class="mt-2">
                                      
                                                                <img src="{{ asset('assets') }}/img/pps-logo.png"
                                                                    class="avatar avatar-md me-4" style="height: 60px !important; width: 60px !important" alt="table image">
                                                            </div>
                        
                                                        </td> --}}
                                                        <td>
                                                            <div class="d-flex flex-column mt-1">
                                        
                                                            <a class="mb-1 text-sm text-danger" style="font-weight: bold">{{ $transaction2->first_name }} {{ $transaction2->middle_name }} {{ $transaction2->last_name }} {{ $transaction2->suffix }}</a>
                                                              @if ($transaction2->prc_number == null)
                                                              <span class="mb-1 text-xs">PRC Number: <span
                                                                class="text-dark ms-sm-2 font-weight-bold">N/A</span></span>
                                                              @else
                                                              <span class="mb-1 text-xs">PRC Number: <span
                                                                class="text-dark ms-sm-2 font-weight-bold">{{ $transaction2->prc_number }}</span></span>
                                                              @endif
                                                              
                                                                <span class="mb-1 text-xs">Member Type: <span
                                                                    class="text-dark font-weight-bold ms-sm-2">{{ $transaction2->member_type_name }}</span></span>
                                                            </div>
                                                        </td>
                                                  
                                                    <td>
                                                            <h6 class="mb-0 text-sm">{{ $transaction2->description }} ({{ $transaction2->year_dues }})
                                                            </h6>                             
                                                    </td>
                                                    
                                                    <td class="text-center">
                                                        <span class="text-secondary text-sm font-weight-bolder">₱ {{ number_format($transaction2->total_amount, 2) }}</span>
                                                    </td>
                                                    
                                                    <td class="text-xs font-weight-normal">
                                                        
                                                        <div class="d-flex align-items-center">
                                                            @if ($transaction2->payment_dt == null)
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
                                                                <span class="text-success text-bold">PAID <br> {{ Carbon\Carbon::parse($transaction2->payment_dt)->format('M. d, Y - h: i a') }} via {{ $transaction2->payment_mode }}
                                                                <br>
                                                                @if ($transaction2->or_no == null)
                                                                    OR #: N/A
                                                                @else
                                                                    OR #: {{ $transaction2->or_no }}
                                                                @endif 
                                                            </span>
                                                                
                                                            @endif

                                                            

                                                        </div>
                            
                                                    </td>

                                                    <td class="text-center">
                                                        <button class="btn bg-gradient-danger dropdown dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
                                                            ACTION
                                                          </button>
                                                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            @if ($transaction2->payment_dt == null)
                                                                <li><a class="dropdown-item" href="cashier-annual-dues-transaction/{{ Crypt::encrypt( $transaction2->pps_no )}}">PAY NOW</a></li>
                                                            @endif
                                                            @if ($transaction2->payment_dt != null)
                                                                <li><a class="dropdown-item" href="#" data-target-id="{{ $transaction2->id }}" data-bs-toggle="modal" data-bs-target="#modalUpdateORNumber">UPDATE OR NUMBER</a></li>
                                                                <li><a class="dropdown-item" href="#">VIEW RECEIPT</a></li>
                                                            @endif
                                                            
                                                            @if ($transaction2->payment_dt == null)
                                                                <li><a class="dropdown-item remove" id="{{ $transaction2->id }}" href="javascript:void(0)">REMOVE</a></li>
                                                            @endif

                                                            @if ($transaction2->payment_mode == 'gcash' || $transaction2->payment_mode == 'card')
                                                            <li><a class="dropdown-item" href="#" data-target-id="{{ $transaction2->id }}" data-bs-toggle="modal" data-bs-target="#modalUpdateOnlinePayment">UPDATE ONLINE PAYMENT</a></li>
                                                            @endif
                                                            
                                                          </ul>

                                    
                                                    </td> 

                                                </tr>

                                                  
                                            @endforeach
                                                   
                                             
                                              
                                            </tbody>
                                        </table>
                                       
                                    </div>
                                    <br>
                                    {{ $transaction->appends($_GET)->links('vendor.pagination.bootstrap-5') }}
                                    {{-- {{ $transaction->appends($_GET)->links('vendor.pagination.bootstrap-5') }} --}}
                                </div>
                            </div>


                            {{-- START MODAL CHOOSE MEMBER --}}
                            <div class="modal fade" id="modalAnnualDuesNewTransaction" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">

                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">

                                        <div class="modal-header bg-gradient-danger">
                                            <h6 class="modal-title font-weight-bold" id="modal-title-notification" style="color: white !important">ADD ANNUAL DUES</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                
                                            </button>
                                            </div>
                                    
                                        <div class="modal-body p-0">
                                            <div class="card card-plain">
                                             
                                                <div class="card-body p-3 pt-0">
                                                   
                                                    <form method="POST" action="{{ url('cashier-annual-dues-choose-member') }}" role="form text-left" enctype="multipart/form-data" >
                                                        @csrf
                                                        <div class="row mt-4">
                                                            <div class="col-lg-12" >
                                                                <h5 class="text-gradient text-danger">Choose Member</h5>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-12 col-12" >
                                                                <div class="input-group input-group-outline">
                                                                <select class="choosemember" id="choosemember" name="selected_pps_no" required>
                                                                        <option value="">CHOOSE MEMBER BELOW</option>
                                                                        @foreach ($member as $member2)
                                                                            <option value="{{ Crypt::encrypt( $member2->pps_no )}}">{{ $member2->first_name }} {{ $member2->middle_name }} {{ $member2->last_name }} | {{ $member2->member_type_name }} | {{ $member2->prc_number }}</option>
                                                                        @endforeach
                                                                </select>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="row mt-4 mb-3">
                                                            <div class="col-12">
                                                                <button class="btn btn-danger w-100 btn-lg" type="submit">PROCEED</button>
                                                            </div>
                                                        </div>
                                                    </form>

                                                    
                                                    {{-- <div class="row mt-4">
                                                        <div class="col-lg-4" ></div>
                                                        <div class="col-lg-8 col-12" >
                                                            <div class="input-group input-group-outline">
                                                                <label class="form-label">Search here..</label>
                                                                <input type="text" class="form-control" id="search-input" style="height: 46px !important">
                                                                <button class="btn bg-gradient-danger btn-lg" id="searchBtn"><i class="fas fa-search"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mt-5">
                                                        <div class="col-12">
                                                            
                                                            <div class="table table-responsive">
                                                                <table class="table align-items-center mb-0" id="choose-member-table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th
                                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Member
                                                                               </th>
                                                                          
                        
                                                                            <th
                                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" style="text-align: center !important">
                                                                                Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($member as $member2)
                                                                        
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex px-2 py-1">
                                                                                    <div>
                                                                                        @if ($member2->picture == null)
                                                                                        <img src="{{ asset('assets') }}/img/pps-logo.png"
                                                                                            class="avatar avatar-md me-3" alt="image">
                                                                                        @else
                                                                                  
                                                                                        <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $member2->picture, now()->addMinutes(230))}}"
                                                                                        class="avatar avatar-md me-3" alt="image">
                                                                                        @endif
                                                                                    </div>
                                                                                    <div class="d-flex flex-column justify-content-center">
                                                                                        <h6 class="mb-0 text-sm">{{ $member2->first_name }} {{ $member2->middle_name }} {{ $member2->last_name }} {{ $member2->suffix }}   
                                                                                        </h6>
                                                                                        <p class="text-sm">{{ $member2->member_type_name }}</p>
                                                                                        @if ($member2->prc_number == null)
                                                                                            <p class="text-sm" style="margin-top: -17px !important"><b class="text-danger">PRC No.: </b> N/A</p>
                                                                                        @else
                                                                                        <p class="text-sm" style="margin-top: -17px !important"><b class="text-danger">PRC No.: </b>{{ $member2->prc_number }}</p>    
                                                                                        @endif
                                                                                         
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            
                                                                            <td style="text-align: center !important">
                                                                                <a href="cashier-annual-dues-transaction/{{ Crypt::encrypt( $member2->pps_no )}}" class="btn btn-icon btn-danger btn-outline-danger w-100 mt-3" style="height: 37px !important;" type="button">
                                                                                    <span class="btn-inner--icon"><i class="material-icons">done</i></span>
                                                                                    <span class="btn-inner--text">&nbsp;SELECT</span>
                                                                                </a>
                                                                            </td>
                        
                                                                        </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div> --}}

                                                </div>
                                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- END MODAL CHOOSE EVENT --}}

                            {{-- Start of modal update or number --}}
                            <div class="modal fade" id="modalUpdateORNumber" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                                <div class="loading" id="loading3" style="display: none;"> 
                                    <img src="{{ asset('assets') }}/img/pps-logo.png" style="height: 60px !important; width: 60px !important" alt="img-blur-shadow" class="icons">
                                </div>
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        
                                        <div class="modal-body p-0">
                                            <div class="card card-plain">
                                                <div class="card-header pb-0 text-left">
                                                    <div class="row">
                                                        <div class="col-11">
                                                            <h5 class="text-gradient text-danger">Update OR Number</h5>
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
                                                    <form method="POST" id="update-annual-dues-or-number" role="form text-left" enctype="multipart/form-data" >
                                                        @csrf
                                                      {{-- Start of hidden input --}}
                                                        <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">
                                                        <input type="hidden" name="or_master_id" id="or_master_id">
                                                        <input type="hidden" value="{{ url('cashier-update-annual-dues-or-number') }}" id="urlCashierAnnualDuesOrNumberUpdate">
                                                       
                                                        {{-- End of hidden input --}}
                                                    <div class="row">
                                                        <div class="col-1">     
                    
                                                        </div>
                                                        <div class="col-lg-10 col-12">
                                                        <label class="form-label text-bold">Input OR Number<code> <b>*</b></code></label>
                                                        <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                                            <input type="number" class="form-control" name="or_no" id="or_no" required>
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
                            {{-- End of modal update annual dues --}}
                            

                            {{-- Start of modal update online payment --}}
                            <div class="modal fade" id="modalUpdateOnlinePayment" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
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
                                                    <form method="POST" action="{{ url('cashier-update-annual-dues-online-payment') }}" role="form text-left" enctype="multipart/form-data" >
                                                        @csrf
                                                        {{-- Start of hidden input --}}
                                                        <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">
                                                        <input type="hidden" name="or_master_id_2" id="or_master_id_2">
                                                      
                                                        
                                                        {{-- End of hidden input --}}
                                                    <div class="row">
                                                        <div class="col-1">     
                    
                                                        </div>
                                                        <div class="col-lg-10 col-12">
                                                        <label class="form-label text-bold">Input Paymongo Transaction Number<code> <b>*</b></code></label>
                                                        <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                                            <input type="text" class="form-control" name="paymongo_transaction_number" id="paymongo_transaction_number" required>
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
                            {{-- End of modal update annual dues --}}


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
                                                    <form method="POST" action="cashier-sync-annual-dues"  role="form text-left" enctype="multipart/form-data" >
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
                            {{-- End of modal update annual dues --}}
                            
                                                        
                          

                          
                        </div>
                    </div>
                </div>
            </div>
            <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
        </div>
    </main>
    <x-plugins></x-plugins>
    <link href="{{ asset('assets') }}/css/loader.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/cashier-annual-dues.css" rel="stylesheet" />
    @push('js')
    <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
    <script src="{{ asset('assets') }}/js/cashier-annual-dues.js"></script>
    <script src="{{ asset('assets') }}/js/select2.min.js"></script>
    <link href="{{ asset('assets') }}/css/select2.min.css" rel="stylesheet" />
    {{-- <script src="{{ asset('assets') }}/js/cashier-annual-dues-datatable.js"></script> --}}
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/choices.min.js"></script>
    <script src="{{ asset('assets') }}/js/moment.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/photoswipe.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/photoswipe-ui-default.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>
    {{-- <script src="{{ asset('assets') }}/js/plugins/datatables.js"></script> --}}


    <script>
        @if (Session::has('status'))
            @if (Session::get('status') == 'exist')
                Swal.fire({
                    title: "Success!",
                    text: "Payment Successful! please note that this member have remaining annual dues that need to be pay.",
                    icon: "success",
                    confirmButtonText: "Okay"
                });
            @elseif (Session::get('status') == 'completed')
                Swal.fire({
                        title: "Success!",
                        text: "Payment Successful! Member has no remaining annual dues.",
                        icon: "success",
                        confirmButtonText: "Okay"
                    });    
            @elseif (Session::get('status') == 'paymentcomplete')
                Swal.fire({
                        title: "Success!",
                        text: "Payment Successful!",
                        icon: "success",
                        confirmButtonText: "Okay"
                    });   
                    
            @elseif (Session::get('status') == 'sync')
                Swal.fire({
                    title: "{{ Session::get('total_updated') }} Payments Updated!",
                    text: "Paymongo Payment Successfully Updated!",
                    icon: "success",
                    confirmButtonText: "Okay"
                });     
             @elseif (Session::get('status') == 'wrongpayment')
                Swal.fire("Warning", "Payment id not found, please try again", "error");    
            @else
                Swal.fire("Warning", "Payment has been failed, please try again", "error");
            @endif
        
        @endif
    </script>
    @endpush
</x-page-template>
