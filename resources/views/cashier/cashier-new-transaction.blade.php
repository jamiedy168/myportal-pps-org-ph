<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="cashier" activeItem="cashier-new-transaction" activeSubitem="">
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
                            <h5 class="mb-4">New Transaction</h5>

                            <form method="POST" action="{{ url('cashier-new-transaction-proceed') }}" role="form text-left" enctype="multipart/form-data" >
                                @csrf
                                <div class="row mt-4">
                                    <div class="col-lg-2">

                                    </div>
                                    <div class="col-lg-8 col-12" >
                                        <label class="text-gradient text-danger">Choose Member</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-2">

                                    </div>
                                    {{-- <div class="col-lg-8 col-12" >
                                        <div class="input-group input-group-outline">
                                            <select class="choosemember" id="choosemember" name="selected_pps_no" required>
                                                    <option value="">-- CHOOSE MEMBER --</option>
                                                    @foreach ($member as $member2)
                                                        <option value="{{ Crypt::encrypt( $member2->pps_no )}}">{{ $member2->first_name }} {{ $member2->middle_name }} {{ $member2->last_name }} | {{ $member2->member_type_name }} | {{ $member2->prc_number }}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div> --}}
                                    <input type="hidden" id="memberSearchUrl" value="{{ route('cashier.searchMemberDropDown') }}">

                                    <div class="col-lg-8 col-12">
                                        <div class="input-group input-group-outline">
                                            <select class="choosemember form-control" id="choosemember" name="selected_pps_no" required></select>
                                        </div>
                                    </div>
                                </div>


                                <div class="row mt-4 mb-3">
                                    <div class="col-lg-3">

                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <button class="btn btn-danger w-100 btn-lg" type="submit">PROCEED</button>
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
    <link href="{{ asset('assets') }}/css/cashier-annual-dues.css" rel="stylesheet" />


    @push('js')
    <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets') }}/js/select2.min.js"></script>
    <link href="{{ asset('assets') }}/css/select2.min.css" rel="stylesheet" />
    <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
    <script src="{{ asset('assets') }}/js/cashier-new-transaction.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('assets') }}/js/moment.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>

    @endpush


</x-page-template>
