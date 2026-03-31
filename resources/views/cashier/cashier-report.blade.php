<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="cashier" activeItem="cashier-report" activeSubitem="">
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
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="mb-0">Reports</h5>
                                <span class="badge bg-{{ ($paymongoMode ?? 'test') === 'live' ? 'success' : 'secondary' }} text-uppercase">
                                    PayMongo Mode: {{ strtoupper($paymongoMode ?? 'test') }}
                                </span>
                            </div>

                            
                                <div class="row">
                                    <div class="col-12 col-md">
                                        <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#modalExportReport">Export Excel</button>
                                    </div>
                                </div>
                        

                            <div class="row mt-3">
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
                                                        PayMongo Ref</th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                                        Mode</th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                                        Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($ormaster as $ormaster2)
                                               
                                                <tr>
                        
                                                        <td>
                                                            <div class="d-flex flex-column mt-1">
                                        
                                                            <a class="mb-1 text-sm text-danger" style="font-weight: bold">{{ $ormaster2->first_name }} {{ $ormaster2->middle_name }} {{ $ormaster2->last_name }} {{ $ormaster2->suffix }}</a>
                                                              @if ($ormaster2->prc_number == null)
                                                              <span class="mb-1 text-xs">PRC Number: <span
                                                                class="text-dark ms-sm-2 font-weight-bold">N/A</span></span>
                                                              @else
                                                              <span class="mb-1 text-xs">PRC Number: <span
                                                                class="text-dark ms-sm-2 font-weight-bold">{{ $ormaster2->prc_number }}</span></span>
                                                              @endif
                                                              
                                                                <span class="mb-1 text-xs">Member Type: <span
                                                                    class="text-dark font-weight-bold ms-sm-2">{{ $ormaster2->member_type_name }}</span></span>
                                                            </div>
                                                        </td>
                                                  
                                                    <td>
                                                            <h6 class="mb-0 text-sm">{{ $ormaster2->description }} ({{ $ormaster2->year_dues }})
                                                            </h6>                             
                                                    </td>
                                                    
                                                    <td class="text-center">
                                                        <span class="text-secondary text-sm font-weight-bolder">₱ {{ number_format($ormaster2->total_amount, 2) }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="text-xs font-weight-bold">{{ $ormaster2->paymongo_payment_id ?? '—' }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="text-xs text-secondary font-weight-bold">{{ $ormaster2->payment_mode ?? strtoupper($paymongoMode ?? 'TEST') }}</span>
                                                    </td>
                                                    <td class="text-xs font-weight-normal">
                                                        
                                                        <div class="d-flex align-items-center">
                                                            @if ($ormaster2->payment_dt == null)
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
                                                                <span class="text-success text-bold">PAID <br> {{ Carbon\Carbon::parse($ormaster2->payment_dt)->format('M. d, Y - h: i a') }} via {{ $ormaster2->payment_mode }}
                                                                <br>
                                                                @if ($ormaster2->or_no == null)
                                                                    OR #: N/A
                                                                @else
                                                                    OR #: {{ $ormaster2->or_no }}
                                                                @endif 
                                                            </span>
                                                                
                                                            @endif

                                                            

                                                        </div>
                            
                                                    </td>


                                                </tr>

                                                  
                                            @endforeach
                                                   
                                             
                                              
                                            </tbody>
                                        </table>
                                       
                                    </div>
                                    <br>
                                    {{ $ormaster->appends($_GET)->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                    
                        </div>
                    </div>
                </div>
            </div>


            {{-- START OF GENERATE EXCEL MODAL --}}
          <div class="modal fade" id="modalExportReport" tabindex="-1" role="dialog" aria-labelledby="modalChooseType" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered " role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="card card-plain">
                            <div class="card-header p-3 pb-0">
                                <div class="row">
                                    <div class="col-8">
                                        
                                    </div>
                                    <div class="col-4" style="text-align: right !important">
                                        <button type="button" class="btn-close" style="color: black !important" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="card-body">
                                <form class="form-horizontal" action="{{ url('cashier-export-excel') }}" method="POST" target="__blank" autocomplete="off">
                                    @csrf
                                    <div class="row mt-0 text-center">
                                        <div class="col-12">
                                            <h4 class="font-weight-bolder">Generate Excel Report</h4>
                                            <p class="mb-0">Please provide information below</p>
                                        </div>
                                    </div>
                                    <hr>
                              
                
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-12 col-12">
                                            <label class="form-label text-bold">Transaction Type<code> <b>*</b></code></label>
                                            <div class="input-group input-group-outline" id="transaction_type" style="margin-top: -5px !important">
                                                <select class="transaction_type" id="transaction_type" name="transaction_type" required>
                                                    <option value="">-- CHOOSE TRANSACTION TYPE --</option>
                                                    <option value="ALL">ALL</option>
                                                    <option value="ANNUAL DUES">ANNUAL DUES</option>
                                                    <option value="EVENT">EVENT</option>
                                                </select>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <label class="form-label text-bold">Date From<code> <b>*</b></code></label>
                                            <div class="input-group input-group-outline" id="date_from" style="margin-top: -5px !important">
                                            <input type="date" class="form-control" name="date_from" id="date_from" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <label class="form-label text-bold">Date To<code> <b>*</b></code></label>
                                            <div class="input-group input-group-outline" id="date_to" style="margin-top: -5px !important">
                                            <input type="date" class="form-control" name="date_to" id="date_to" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-lg-12 col-12">
                                            <button class="btn btn-danger w-100" type="submit">
                                                GENERATE
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- END OF GENERATE EXCEL MODAL --}}



      
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
    <script src="{{ asset('assets') }}/js/cashier-report.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('assets') }}/js/moment.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>

    @endpush
</x-page-template>
