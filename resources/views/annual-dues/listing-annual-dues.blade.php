<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="annual-dues" activeItem="listing-annual-dues" activeSubitem="">
    </x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-auth.navbars.navs.auth pageTitle="Cashier"></x-auth.navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="loading" id="loading2"> 
                <img src="{{ asset('assets') }}/img/pps-logo.png" style="height: 60px !important; width: 60px !important" alt="img-blur-shadow" class="icons">
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-4">List of Annual Dues</h5>

                            <div class="row">
                                
                                <div class="col-lg-6 col-12">
                                    <div class="input-group input-group-outline">
                                        <label class="form-label">Search here..</label>
                                        <input type="text" class="form-control" id="search-input" style="height: 46px !important">
                                        <button class="btn bg-gradient-danger btn-lg" id="searchBtn"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-2">
                                    <div class="input-group input-group-outline">
                                       
                                        <button class="btn bg-gradient-danger btn-lg" id="searchBtn">Filter</button>
                                       
                                    </div>
                                </div> --}}
                                
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-12">
                                    
                                    <div class="table table-responsive" id="table_transaction">
                                        <table class="table align-items-center mb-0"  id="annual-dues-table">
                                            <thead>
                                                <tr>
                                                    <th
                                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                       </th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                                        Description</th>
                                                
                                                    <th
                                                        class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                                        Amount</th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                                        Year</th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                                        </th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($annualDuesList as $annualDuesList2)
                                               
                                                <tr>
                                                    <td>
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td>
                                                      
                                                        <h6 class="mb-0">{{ $annualDuesList2->description }}</h6>
                                                    </td>
                                                    
                                                    <td>
                                                        <span class="text-secondary text-sm">₱ {{ number_format($annualDuesList2->amount, 2) }}</span>
                                                    </td>
                                                    
                                                    <td>
                                                        <span class="text-secondary text-sm text-bold"> {{ $annualDuesList2->year_dues }}</span>
                                                    </td>

                                                    <td>
                                                        <div class="d-flex">
                                                            <button data-bs-toggle="modal" data-bs-target="#modalUpdateAnnualDues" class="btn btn-link btn-icon-only btn-rounded btn-md text-dark icon-move-right my-auto"
                                                            data-target-id="{{ $annualDuesList2->id }}"
                                                            data-target-description="{{ $annualDuesList2->description }}"
                                                            data-target-amount="{{ $annualDuesList2->amount }}"
                                                            data-target-year_dues="{{ $annualDuesList2->year_dues }}">
                                                                <i class="material-icons text-warning">
                                                                    edit
                                                                  </i>
                                                            </button>
                                                            <button type="button" id="{{ $annualDuesList2->id }}" onClick="deleteAnnualDues(this.id)" class="btn btn-link btn-icon-only btn-rounded btn-md text-dark icon-move-right my-auto">
                                                              <i class="material-icons text-danger">
                                                                  delete
                                                                </i>
                                                          </button>
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



            {{-- Start of modal update annual dues --}}
            <div class="modal fade" id="modalUpdateAnnualDues" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                <div class="loading" id="loading3" style="display: none;"> 
                    <img src="{{ asset('assets') }}/img/pps-logo.png" style="height: 60px !important; width: 60px !important" alt="img-blur-shadow" class="icons">
                </div>
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        
                        <div class="modal-body p-0">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-left">
                                    <div class="row">
                                        <div class="col-11">
                                            <h5 class="text-gradient text-danger">Update Annual Dues</h5>
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
                                    <form method="POST" id="update-annual-dues" role="form text-left" enctype="multipart/form-data" >
                                        @csrf
                                      {{-- Start of hidden input --}}
                                        <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="annual_dues_id" id="annual_dues_id">
                                        <input type="hidden" value="{{ url('update-annual-dues') }}" id="urlAnnualUpdate">
                                        <input type="hidden" value="{{ url('delete-annual-dues') }}" id="urlAnnualDelete">
                                        {{-- End of hidden input --}}


                                    <div class="row">
                                        <div class="col-1">
    
                                        </div>
                                        <div class="col-lg-10 col-12">
                                        <label class="form-label text-bold">Description<code> <b>*</b></code></label>
                                        <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                            <input type="text" class="form-control" name="description" id="description">
                                        </div>
                                        <p class="text-danger inputerror mt-0" style="display: none">The name field is required. </p>
                                        </div>
                                        
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-1">
    
                                        </div>
                                        <div class="col-lg-5 col-12">
                                        <label class="form-label text-bold">Amount<code> <b>*</b></code></label>
                                        <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                        
                                            <input type="number" class="form-control text-center"  name="amount" id="amount">
                                        </div>
                                        <p class="text-danger inputerror mt-0" style="display: none">The name field is required. </p>
                                        </div>
                                        <div class="col-lg-5 col-12">
                                            <label class="form-label">Year<code> <b>*</b></code></label>
                                        <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                            <select name="year_dues" id="year_dues" class="form-control year" style="text-align: center !important">
                                                
                                                @for ($year = date('Y')-4; $year <= date('Y')+5; $year++)
                                                        <option value="{{$year}}">{{$year}}</option>
                                                @endfor
    
                                            </select>
                                        </div>
                                        </div>
                                        
                                    </div>

                                    <div class="row mt-5">
                                        <div class="col-lg-7">
    
                                        </div>
                                        <div class="col-lg-4 col-12" style="text-align: right !important">
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

            <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
        </div>
    </main>
    <x-plugins></x-plugins>
    <link href="{{ asset('assets') }}/css/loader.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/annual-dues.css" rel="stylesheet" />
    @push('js')
    <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
    <script src="{{ asset('assets') }}/js/select2.min.js"></script>
    <link href="{{ asset('assets') }}/css/select2.min.css" rel="stylesheet" />
    <script src="{{ asset('assets') }}/js/annual-dues-list.js"></script>
    <script src="{{ asset('assets') }}/js/annual-dues-data-table.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/choices.min.js"></script>
    <script src="{{ asset('assets') }}/js/moment.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/datatables.js"></script>

    <script>
        

    </script>


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
            @elseif (Session::get('wrongpayment') == 'failed')
                Swal.fire("Warning", "Payment id not found, please try again", "error");    
            @endif
        
        @endif
    </script>
    @endpush
</x-page-template>
