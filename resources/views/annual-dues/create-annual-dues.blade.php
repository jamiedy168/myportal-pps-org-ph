<x-page-template bodyClass='g-sidenav-show bg-gray-200'>
    <x-auth.navbars.sidebar activePage='annual-dues' activeItem='create-annual-dues' activeSubitem=''></x-auth.navbars.sidebar>
    <main class="main-content main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-auth.navbars.navs.auth pageTitle='Events'></x-auth.navbars.navs.auth>
       
        <div class="container-fluid my-3 py-4">
            <div class="loading" id="loading3"> 
                <img src="{{ asset('assets') }}/img/pps-logo.png" style="height: 60px !important; width: 60px !important" alt="img-blur-shadow" class="icons">
            </div>
            <div class="row mt-0" style="margin-top: -15px !important">
                <div class="col-lg-1">

                </div>
                <div class="col-lg-9 col-12">
                    <div class="card">
                        <div class="card-header p-3 pb-0 bg-gradient-danger">
                            <div class="row">
                                <div class="col-8">
                                    <h6 class="mb-2 text-white">CREATE ANNUAL DUES</h6>
                                </div>
                                <div class="col-4 text-end">
                                    <a href="#" class="btn btn-link btn-icon-only btn-rounded text-white icon-move-right my-auto" style="margin-top: -5px !important">
                                        <i class="fas fa-calendar" aria-hidden="true"></i>
                                            
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" id="save-annual-dues" role="form text-left" enctype="multipart/form-data" >
                                @csrf

                                {{-- Start of hidden input --}}
                                <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">
                                <input type="hidden" value="{{ url('save-annual-dues') }}" id="urlAnnualSave">
                                {{-- End of hidden input --}}

                                <div class="row">
                                    <div class="col-1">

                                    </div>
                                    <div class="col-lg-10 col-12">
                                    <label class="form-label text-bold">Description<code> <b>*</b></code></label>
                                    <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                        <input type="text" class="form-control" value="Member Annual Dues" name="description" id="description">
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

                                <div class="row mt-4">
                                    <div class="col-1">

                                    </div>
                                    <div class="col-lg-8 col-12">
                                        <button class="btn btn-danger" type="submit">SAVE</button>
                                        <button class="btn btn-warning" type="button" onClick="window.location.reload();">CLEAR</button>
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


         
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
    <script src="{{ asset('assets') }}/js/annual-dues.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/datatables.js"></script>




  
    @endpush
</x-page-template>
