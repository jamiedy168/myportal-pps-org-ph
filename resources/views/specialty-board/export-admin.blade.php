<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>

    <x-auth.navbars.sidebar activePage='specialtyBoard' activeItem='specialty-board-admin-export' activeSubitem=''></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-auth.navbars.navs.auth pageTitle='Reports'></x-auth.navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row mt-1">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header p-3 pb-2 bg-danger" style="height: 80px !important">
                            <h6 class="mb-1 text-white">Export</h6>
                            <p class="text-sm text-white">Export specialty board pending application.</p>
                        </div>
                        <div class="card-body pb-2">
                            <form method="POST" role="form text-left" enctype="multipart/form-data" action="{{ url('specialty-board-admin-generate-export')}}" >
                                @csrf
                                <input type="hidden" id="token" value="{{ csrf_token() }}">
                                <input type="hidden" value="{{ url('specialty-board-admin-generate-export')}}" id="urlExportSpecialtyBoard">
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <div class="row justify-content-md-center">
                                            <div class="col-lg-5 col-12 mt-2">
                                                <label class="form-label text-bold">Member Type Applied</label>
                                                <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                                    <select name="member_type" id="member_type" class="form-control member_type">
                                                        <option value="" selected>All</option>
                                                        @foreach ($member_type as $type2)
                                                            <option value="{{ $type2->id }}">{{ $type2->member_type_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-5 col-12 mt-2">
                                                <label class="form-label text-bold">Chapter</label>
                                                <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                                    <select name="member_chapter" id="member_chapter" class="form-control member_chapter" style="text-align: center !important">
                                                        <option value="" selected>All</option>
                                                        @foreach ($chapter as $chapter2)
                                                            <option value="{{ $chapter2->id }}">{{ $chapter2->chapter_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-12 col-lg-12 text-center">
                                        <button class="btn btn-lg btn-success" type="submit" style="width: 180px !important;">EXPORT</button>
                                    </div>
                                </div>
                            </form>
                            <br>
                        </div>
                    </div>
                </div>
            </div>

            <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
        </div>
    </main>
    <x-plugins></x-plugins>
    @push('js')
        <link href="{{ asset('assets') }}/css/specialty-board-export.css" rel="stylesheet" />
        <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
        <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="{{ asset('assets') }}/js/select2.min.js"></script>
        <link href="{{ asset('assets') }}/css/select2.min.css" rel="stylesheet" />
        <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
        <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
        <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>
        <script src="{{ asset('assets') }}/js/specialty-board-export.js"></script>
    @endpush
</x-page-template>
