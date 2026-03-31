<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="cashier" activeItem="cashier-annual-dues" activeSubitem="">
    </x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <style>
            input[type=checkbox] {
                transform: scale(1.3) !important;
            }
        </style>
        <!-- Navbar -->
        <x-auth.navbars.navs.auth pageTitle="Cashier"></x-auth.navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-4">Annual Dues Payment</h5>

                            <div class="row">
                                <div class="col-8 col-lg-8 col-md-8">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="col-lg-12">
                                                <div class="d-flex">
                                                    <div>
                                                        @if ($member->picture == null)
                                                            <img src="{{ asset('assets') }}/img/pps-logo.png}"
                                                            class="avatar avatar-xxl me-3" alt="product image">
                                                        @else
                                                            <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $member->picture, now()->addMinutes(230))}}"
                                                            class="avatar avatar-xxl me-3" alt="product image">
                                                        @endif
                                                       
                                                    </div>
                                                    <div>
                                                        <h6 class="text-lg mb-0 mt-2">{{ $member->first_name }} {{ $member->middle_name }} {{ $member->last_name }}</h6>
                                                        <p class="text-sm mb-0"><b>PRC Number: </b> {{ $member->prc_number }}</p>
                                                        <span class="badge badge-sm bg-gradient-success">{{ $member->member_type_name }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3 mb-0">
                                        <div class="col-12 col-lg-12 col-md-12" style="text-align: right !important">
                                            <button class="btn btn-icon btn-warning" type="button" data-bs-toggle="modal" data-bs-target="#modalAddAnnualDues">
                                                <span class="btn-inner--icon"><i class="material-icons">add</i></span>
                                              <span class="btn-inner--text">Add annual dues</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row mt-0 mb-2">
                                        <div class="col-12 col-lg-12 col-md-12">
                                            <div class="card card-body border card-plain border-radius-lg" id="chooseannualdues">
                                               <div class="row">
                                                <div class="col-12">
                                                    <h6 class="mb-0">Choose pending annual dues below</h6>
                                                </div>
                                               </div>
                                               <div class="row mt-2">
                                                 <div class="col-12">
                                                    <ul class="list-group">
                                                        @forelse ($paymentList as $paymentList2)
                                                        <li
                                                            class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                                            <div class="d-flex align-items-center">
                                                                <button
                                                                    class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i
                                                                        class="material-icons text-lg">paid</i></button>
                                                                <div class="d-flex flex-column">
                                                                    <h6 class="mb-1 text-dark text-sm">{{ $paymentList2->description }} {{ $paymentList2->year_dues }}</h6>
                                                                    <span class="text-sm">Price: <b class="text-success text-gradient font-weight-bold">₱ {{ number_format($paymentList2->duesamount, 2) }}</b></span>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="d-flex align-items-center text-danger text-white text-sm font-weight-bold">
                                                                <button class="btn btn-success add_cart" data-id="{{ $paymentList2->id }}">Add to cart</button>
                                                            </div>
                                                        </li>
                                                        <hr class="mt-0 mb-0">
                                                        @empty
                                                        <h6 class="text-center text-danger">-- NONE -- </h6>
                                                        @endforelse
                                                    </ul>
                                                 </div>
                                               </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="col-4 col-lg-4 col-md-4">
                                     {{-- Start of hidden input --}}
                                     <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">
                                     <input type="hidden" value="{{ url('cashier-annual-dues-add-cart')}}" id="urlCashierAnnualDuesAddCart">
                                     <input type="hidden" value="{{ url('cashier-annual-dues-remove-cart')}}" id="urlCashierAnnualDuesRemoveCart">
                                     <input type="hidden" id="pps_no" name="pps_no" value="{{ $member->pps_no }}">
                                     {{-- End of hidden input --}}
                                    <div class="card h-100 mb-4" id="cartListRow">
                                        <div class="card-header bg-danger pb-0 px-3">
                                            <div class="row mb-2">
                                                <div class="col-8">
                                                    <h6 class="mb-0 text-white">Cart List</h6>
                                                </div>
                                                <div
                                                    class="col-4 d-flex justify-content-start justify-content-md-end" style="text-align: right !important">
                                                    <i class="material-icons me-2 text-xl text-white">shopping_cart</i>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body pt-4 p-3 annualduespaymentrefresh">
                                            <input type="hidden" value="{{ $carttotal }}" id="carttotal">
                                            <div class="row">
                                                <div class="col-12 col-lg-12">
                                                    @forelse ($cart as $cart2)
                                                        <div class="card mb-2">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-9">
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <p class="text-bold text-dark text-sm mb-0">{{ $cart2->description }} {{ $cart2->year_dues }}</p>
                                                                                <span class="text-sm mt-0"><b class="text-success text-gradient font-weight-bold">₱ {{ number_format($cart2->duesamount, 2) }}</b></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-3">
                                                                        <div class="row mt-2">
                                                                            <div class="col-12">
                                                                                <button class="btn bg-gradient-danger btn-sm mt-auto mb-0 ms-2 removeCart" type="button" name="button" data-id="{{ $cart2->id }}"><i class="material-icons text-sm">delete</i></button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            
                                                            </div>
                                                        
                                                        </div>
                                                    @empty
                                                    <h6 class="text-center text-danger">-- Empty cart --</h6>
                                                    @endforelse
                                                </div>
                                            </div>
                                           
                                        </div>
                                        <div class="card-footer pb-0 px-3">
                                            <hr>
                                            <div class="row">
                                                <div class="col-8">
                                                    <h6>Subtotal:</h6>
                                                </div>
                                                <div class="col-4" style="text-align: right !important">
                                                    <h6>₱ {{ number_format($cartsubtotal, 2) }}</h6>
                                                </div>
                                              
                                            </div>
                                            <div class="row">
                                                <div class="col-8">
                                                    <h6>Discount:</h6>
                                                </div>
                                                <div class="col-4" style="text-align: right !important">
                                                    <h6>₱ 0.00</h6>
                                                </div>
                                              
                                            </div>
                                            <hr class="mt-0">
                                            <div class="row">
                                                <div class="col-6">
                                                    <h5 class="mb-3 text-danger text-bold">TOTAL:</h5>
                                                </div>
                                                <div class="col-6" style="text-align: right !important">
                                                    <h5 class="mb-3 text-danger text-bold">₱ {{ number_format($carttotal, 2) }}</h5>
                                                </div>
                                              
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-12">
                                                    @if ($cartcount == 0)
                                                        <button class="btn btn-danger w-100" type="button" onclick="emptycart()">PAY VIA ONLINE</button>
                                                        <button class="btn btn-danger w-100" type="button" onclick="emptycart()">PAY VIA CASH</button>
                                                        <button class="btn btn-danger w-100" type="button" onclick="emptycart()">PAY VIA CHEQUE</button>
                                                        <button class="btn btn-danger w-100" type="button" onclick="emptycart()">PAY VIA BANK TRANSAFER</button>
                                                    @else   
                                                        <button class="btn btn-danger w-100" type="button" data-bs-toggle="modal" data-bs-target="#modalChoosePaymentType" >PAY VIA ONLINE</button>
                                                        <button class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#modalAnnualDuesPay" type="button">PAY VIA CASH</button>
                                                        <button class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#modalAnnualDuesPayCheque" type="button">PAY VIA CHEQUE</button>
                                                        <button class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#modalAnnualDuesPayBankTransfer" type="button">PAY VIA BANK TRANSFER</button>
                                                    </form>
                                                    @endif
                                                    
                                                </div>
                                               
                                              
                                            </div>

                                                {{-- Start of modal choose online payment method --}}
                                                <div class="modal fade" id="modalChoosePaymentType" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered " role="document">
                                                        <div class="modal-content">
                                                            <form method="POST" role="form text-left" enctype="multipart/form-data" action="{{ url('cashier-annual-dues-payment-online') }}">
                                                                @csrf
                                                                <div class="modal-body p-0">
                                                                    <div class="card card-plain" id="cartListModal">
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
                                                                            <input type="hidden" name="total" value="{{ $carttotal }}">
                                                                            <input type="hidden" id="pps_no2" name="pps_no2" value="{{  $member->pps_no }}">
                                                                                <hr>
                                                                            <div class="row">
                                                                                <div class="col-12 col-lg-12 col-md-12">
                                                                                    <label class="form-label text-bold">Select Payment Type<code> <b>*</b></code></label>
                                                                                <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                                                    <select required name="payment_type" required id="payment_type" class="form-control payment_type">
                                                                                        <option value="">-- Select --</option>
                                                                                        <option value="gcash">GCASH</option>
                                                                                        <option value="card">CARD</option>
                                                                           
                                                                                    </select>
                                                                                </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mt-3 mb-3" style="display: none !important" id="gcashtransaction">
                                                                                <div class="col-12">
                                                                                    <label class="mb-2 text-danger" style="font-style: italic !important">
                                                                                        Note: Paymongo service fee + 3% for gcash transaction.
                                                                                     </label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mt-3 mb-3" style="display: none !important" id="cardtransaction">
                                                                                <div class="col-12">
                                                                                    <label class="mb-2 text-danger" style="font-style: italic !important">
                                                                                        Note: Paymongo service fee + 4.0% + ₱ 15.00 for card transaction.
                                                                                     </label>
                                                                                </div>
                                                                            </div>
                                                                            <br>
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <button class="btn btn-danger btn-lg w-100" type="submit" >PAY NOW</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- End of modal choose online payment method --}}

                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                           

                    
                        </div>
                    </div>
                </div>
            </div>


 
            {{-- Start of modal payment using cash --}}
            <div class="modal fade" id="modalAnnualDuesPay" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered " role="document">
                    <div class="modal-content">
                    
                        <div class="modal-body p-0">
                            <div class="card card-plain" id="cartListModal">
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

                                    <form method="POST" role="form text-left" enctype="multipart/form-data" id="cashier-annual-dues-payment-form">
                                        @csrf

                                        {{-- Start of hidden input --}}
                                        <input type="hidden" value="{{ url('cashier-annual-dues-pay')}}" id="urlCashierAnnualDuesPay">
                                        <input type="hidden" id="token4" name="token4" value="{{ csrf_token() }}">
                                        <input type="hidden" id="pps_no4" name="pps_no" value="{{ $member->pps_no }}">
                                        <input type="hidden" value="{{ $carttotal }}" id="carttotal4">
                                        {{-- End of hidden input --}}

                                        <hr class="horizontal dark mt-0 mb-4">

                                
                                   
                                        <div class="text-center text-muted mb-4">
                                            <h3>Enter Amount</h3>
                                        </div>
                                        <div class="row gx-2 gx-sm-3 mb-3">
                                            <div class="col">
                                                <div class="input-group input-group-outline">
                                                    <button class="btn bg-gradient-danger btn-lg counter-btn" type="button" id="minusBtn" ><i class="fas fa-minus"></i></button>
                                                    <input type="number" required class="form-control amount3" min="{{ $carttotal }}" id="amount3" style="height: 46px !important; font-size: 20px !important; text-align:center !important">
                                                    <button class="btn bg-gradient-danger btn-lg counter-btn" type="button" id="plusBtn"><i class="fas fa-plus"></i></button>
    
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="row mt-0" style="margin-top: -20px !important; display: none !important"  id="warningDiv">
                                            <div class="col-12 text-center">
                                                <label class="text-danger text-bold">Warning! Amount is lower than total</label>
                                            </div>
                                        </div> --}}

                                        <div class="row ">
                                            <div class="col">
                                                <h4>TOTAL:</h4>
                                            </div>
                                            <div class="col text-right" style="text-align: right !important">
                                                <h4 class="">₱ {{ number_format($carttotal, 2) }}</h4>
                                               
                                            </div>
                                        </div>

                                
                            
                                        <hr>
                                        <div class="row ">
                                            <div class="col">
                                                <h4>CHANGE:</h4>
                                            </div>
                                            <div class="col text-right" style="text-align: right !important">
                                                <h4 class="" id="changeText">₱ 0.00</h4>
                                                <input type="hidden" id="change">
                                            </div>
                                        </div>
                                    

                                        <div class="row mt-2">
                                            <div class="col-lg-12 col-12">
                                                <label class="form-label text-bold">OR Number<code> <b>*</b></code></label>
                                                <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                  <input type="number" class="form-control text-center" placeholder="Enter OR Number" name="or_no" id="or_no" required>
                                                </div>
                                              </div>
                                        </div>
                                        <br>

                                        
                                        <div class="row ">
                                            <div class="col-12 col-lg-6">
                                                <button type="submit" class="btn bg-gradient-warning w-100" id="paycashierBtn">Pay</button>
                                                
                                            </div>
                                            <div class="col-12 col-lg-6">
                                            
                                                <button type="button" class="btn bg-gradient-danger w-100" data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                            
                                        </div>
                                    </form>
                                </div>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End of modal payment using cash --}}

            {{-- Start of modal payment using bank transafer --}}
            <div class="modal fade" id="modalAnnualDuesPayBankTransfer" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered " role="document">
                    <div class="modal-content">
                    
                        <div class="modal-body p-0">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-left">
                                    <div class="row">
                                        <div class="col-11">
                                            <h5 class="text-gradient text-danger">Payment using bank transafer</h5>
                                        </div>
                                        <div class="col-1">
                                            <button style="text-align: right !important" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                <span class="text-primary" aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                    
                                
                                </div>
                                <div class="card-body p-3 pt-0">
                                    <form method="POST" role="form text-left" enctype="multipart/form-data" id="cashier-annual-dues-payment-bank-transfer-form">
                                        @csrf
                                            {{-- Start of hidden input --}}
                                            <input type="hidden" value="{{ url('cashier-annual-dues-pay-bank-transfer')}}" id="urlCashierAnnualDuesPayBankTransfer">
                                            {{-- End of hidden input --}}
                                    <hr>
                                        <div class="row">
                                            <div class="col-12 col-lg-12 col-md-12">
                                                <label class="form-label text-bold">Bank Name<code> <b>*</b></code></label>
                                                <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                    <select required name="bank_name" id="bank_name" class="form-control bank_transfer_name" required>
                                                        <option value="">-- Select --</option>
                                                        <option value="Asia United Bank">Asia United Bank</option>
                                                        <option value="Bank of Commerce">Bank of Commerce</option>
                                                        <option value="BDO Unibank, Inc">Bank of the Philippine Islands</option>
                                                        <option value="BDO">BDO</option>
                                                        <option value="BPI">BPI</option>
                                                        <option value="Chinabank">Chinabank</option>
                                                        <option value="Citibank">Citibank</option>
                                                        <option value="Development Bank of the Philippines">Development Bank of the PhilippinesAsia United Bank</option>
                                                        <option value="EastWest">EastWest</option>
                                                        <option value="Landbank">Landbank</option>
                                                        <option value="Maybank Philippines, Incorporated">Maybank Philippines, Incorporated</option>
                                                        <option value="Metrobank">Metrobank</option>
                                                        <option value="Philippine National Bank">Philippine National Bank</option>
                                                        <option value="Philippine Savings Bank">Philippine Savings Bank</option>
                                                        <option value="RCBC">RCBC</option>
                                                        <option value="Robinsons Bank">Robinsons Bank</option>
                                                        <option value="Security Bank">Security Bank</option>
                                                        <option value="Unionbank">Unionbank</option>
                            
                
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-12 col-lg-12 col-md-12">
                                                <label class="form-label text-bold">Bank Transaction Number<code> <b>*</b></code></label>
                                                <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                    <input type="text" class="form-control" placeholder="Enter transaction number" required name="bank_transfer_transaction_number" id="bank_transfer_transaction_number">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <label class="form-label text-bold">Date<code> <b>*</b></code></label>
                                                <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                    <input type="date" class="form-control" name="bank_transfer_dt" id="bank_transfer_dt" required>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                    <label class="form-label text-bold">Amount<code> <b>*</b></code></label>
                                                <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                    <input type="number" class="form-control" placeholder="Enter amount" name="amount_bank_transfer" id="amount_bank_transfer" min="{{ $carttotal }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-12 col-lg-12 col-md-12">
                                                <label class="form-label text-bold">Remarks<code> <b>*</b></code></label>
                                                <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                    <textarea class="form-control" rows="3" name="bank_transfer_remarks" id="bank_transfer_remarks"></textarea>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-12 col-lg-6">
                                                <button type="submit" class="btn bg-gradient-warning w-100" id="paycashierBtn">Pay</button>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <button type="button" class="btn bg-gradient-danger w-100" data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                            
                                        </div>
                                    </form>
                                </div>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End of modal payment using cash --}}


             {{-- Start of modal payment using cheque --}}
             <div class="modal fade" id="modalAnnualDuesPayCheque" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                <div class="loading" id="loading3" style="display: none;"> 
                    <img src="{{ asset('assets') }}/img/pps-logo.png" style="height: 60px !important; width: 60px !important" alt="img-blur-shadow" class="icons">
                </div>
                <div class="modal-dialog modal-dialog-centered " role="document">
                    <div class="modal-content">
                    
                        <div class="modal-body p-0">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-left">
                                    <div class="row">
                                        <div class="col-11">
                                            <h5 class="text-gradient text-danger">Payment using cheque</h5>
                                        </div>
                                        <div class="col-1">
                                            <button style="text-align: right !important" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                <span class="text-primary" aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                    
                                
                                </div>
                                <div class="card-body p-3 pt-0">
                                    <form method="POST" role="form text-left" enctype="multipart/form-data" id="cashier-annual-dues-payment-cheque-form">
                                        @csrf
                                         {{-- Start of hidden input --}}
                                         <input type="hidden" value="{{ url('cashier-annual-dues-pay-cheque')}}" id="urlCashierAnnualDuesPayCheque">
                                         {{-- End of hidden input --}}
                                    <hr>
                                        <div class="row">
                                            <div class="col-12 col-lg-12 col-md-12">
                                                <label class="form-label text-bold">Bank Name<code> <b>*</b></code></label>
                                            <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                <select required name="bank_name" id="bank_name" class="form-control bank_name">
                                                    <option value="">-- Select --</option>
                                                    <option value="Security Bank">Security Bank</option>
                                                    <option value="Landbank">Landbank</option>
                                                    <option value="Unionbank">Unionbank</option>
                                                    <option value="Philippine National Bank">Philippine National Bank</option>
                                                    <option value="BDO">BDO</option>
                                                    <option value="BDO Unibank, Inc">Bank of the Philippine Islands</option>
                                                    <option value="Chinabank">Chinabank</option>
                                                    <option value="Asia United Bank">Asia United Bank</option>
                                                    <option value="Development Bank of the Philippines">Development Bank of the PhilippinesAsia United Bank</option>
                                                    <option value="Metrobank">Metrobank</option>
                                                    <option value="Bank of Commerce">Bank of Commerce</option>
                                                    <option value="BPI">BPI</option>
                                                    <option value="Citibank">Citibank</option>
                                                    <option value="EastWest">EastWest</option>
                                                    <option value="Robinsons Bank">Robinsons Bank</option>
                                                    <option value="Maybank Philippines, Incorporated">Maybank Philippines, Incorporated</option>
                                                    <option value="Philippine Savings Bank">Philippine Savings Bank</option>
                                                    <option value="RCBC">RCBC</option>

                                                </select>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-12 col-lg-12 col-md-12">
                                                <label class="form-label text-bold">Cheque Number<code> <b>*</b></code></label>
                                                <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                    <input type="number" class="form-control" placeholder="Enter cheque number" required name="cheque_number" id="cheque_number">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <label class="form-label text-bold">Posting Date<code> <b>*</b></code></label>
                                                <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                    <input type="date" class="form-control" name="posting_dt" id="posting_dt" required>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                    <label class="form-label text-bold">Amount<code> <b>*</b></code></label>
                                                <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                    <input type="number" class="form-control" placeholder="Enter amount" name="amount_cheque" id="amount_cheque" min="{{ $carttotal }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-12 col-lg-6">
                                                <button type="submit" class="btn bg-gradient-warning w-100" id="paycashierBtn">Pay</button>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <button type="button" class="btn bg-gradient-danger w-100" data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                            
                                        </div>
                                    </form>
                                </div>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End of modal payment using cash --}}


            {{-- Start of modal payment using online --}}
            <div class="modal fade" id="modalAnnualDuesPayOnline" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                <div class="loading" id="loading4" style="display: none;"> 
                    <img src="{{ asset('assets') }}/img/pps-logo.png" style="height: 60px !important; width: 60px !important" alt="img-blur-shadow" class="icons">
                </div>
                <div class="modal-dialog modal-dialog-centered " role="document">
                    <div class="modal-content">
                    
                        <div class="modal-body p-0">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-left">
                                    <div class="row">
                                        <div class="col-11">
                                            <h5 class="text-gradient text-danger">Payment online</h5>
                                        </div>
                                        <div class="col-1">
                                            <button style="text-align: right !important" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                <span class="text-primary" aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                    
                                
                                </div>
                                <div class="card-body p-3 pt-0">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-6 col-12">
                                            <div class="d-flex">
                                                <div>
                                                    <img src="{{ asset('assets') }}/img/pps-logo.png"
                                                        class="avatar avatar-xxl me-3" alt="product image">
                                                </div>
                                                <div>
                                                    {{-- <h6 class="text-lg mb-0 mt-2" id="event_title">{{ $event->title }}</h6>
                                                    <p class="text-sm mb-0" id="event_category">{{ $event->category }}</p>
                                                    <p class="text-sm mb-3" id="event_description">{{ $event->description }}</p>
                                                    <span class="badge badge-sm bg-gradient-warning">FOR PAYMENT</span> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End of modal payment using online --}}



            {{-- START MODAL ADD ANNUAL DUES --}}
            <div class="modal fade" id="modalAddAnnualDues" tabindex="-1" role="dialog" aria-labelledby="modalAddAnnualDues" aria-hidden="true">
                
                <div class="modal-dialog modal-danger modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                
                    <div class="modal-header bg-gradient-danger">
                    <h6 class="modal-title font-weight-bold" id="modal-title-notification" style="color: white !important">ADD ANNUAL DUES</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        
                    </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" value="{{ url('cashier-annual-dues-add-annual-dues')}}" id="urlCashierAddAnnualDues">
                        <div class="row mt-2">
                            <div class="col-12">
                                @foreach ($annualDuesList as $annualDuesList2)
                                    
                                
                                    <div class="d-flex">
                                        {{-- <div class="form-check form-check-lg my-auto">
                                            <input class="form-check-input" type="checkbox"
                                                id="flexSwitchCheckDefault2">
                                        </div> --}}
                                        <div class="my-auto ms-4">
                                            <div class="h-100">
                                                <h6 class="mb-0">{{ $annualDuesList2->description }} ({{ $annualDuesList2->year_dues }})</h6>
                                                <p class="mb-0 text-sm">Year {{ $annualDuesList2->year_dues }}</p>
                                                
                                            </div>
                                        </div>
                                      
                                        <button class="btn btn-danger ms-auto me-3 my-auto btn-lg addannualdues" data-id="{{ $annualDuesList2->id }}">ADD</button>    
                                    </div>
                                    <hr class="horizontal dark">
                                @endforeach
                            </div>
                        </div>
                        {{-- <div class="row mt-1">
                            <div class="col-12 col-md-12">
                                <button class="btn btn-danger w-100 btn-lg">ADD</button>    
                            </div>
                        </div> --}}
                      
                   
                    </div>
                    
                </div>
                </div>
            </div>
            {{-- END OF MODAL ANNUAL DUES --}}

            <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
        </div>
    </main>
    <x-plugins></x-plugins>
    <link href="{{ asset('assets') }}/css/loader.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/cashier-annual-dues.css" rel="stylesheet" />


    @push('js')
    <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets') }}/js/select2.min.js"></script>
    <link href="{{ asset('assets') }}/css/select2.min.css" rel="stylesheet" />
    <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
    <script src="{{ asset('assets') }}/js/cashier-annual-dues.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('assets') }}/js/moment.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>


    <script>

        
    // var carttotal = "{{ $carttotal }}";
        

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
            @endif
        
        @endif
    </script>
    @endpush
</x-page-template>
