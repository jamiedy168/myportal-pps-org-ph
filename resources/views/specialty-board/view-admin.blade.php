<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>

    <x-auth.navbars.sidebar activePage='specialtyBoard' activeItem='specialty-board-admin-view' activeSubitem=''></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-auth.navbars.navs.auth pageTitle='Reports'></x-auth.navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-6 mb-4">
                            <div class="card">
                                <div class="card-header p-3 py-2">
                                    <div
                                        class="icon icon-lg icon-shape bg-gradient-danger shadow text-center border-radius-xl mt-n4 position-absolute">
                                        <i class="material-icons text-white opacity-10">
                                            account_circle
                                        </i>
                                    </div>
                                    <div class="text-end pt-1">
                                        <p class="text-sm mb-0 text-capitalize">Applicant</p>
                                        <h4 class="mb-0">1,600</h4>
                                    </div>
                                </div>
                                <hr class="dark horizontal my-0">
                                <div class="card-footer p-3">
                                    <p class="mb-0"><span class="text-success text-sm font-weight-bolder">Total Pending Applicant</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-6 mb-4">
                            <div class="card">
                                <div class="card-header p-3 py-2">
                                    <div
                                        class="icon icon-lg icon-shape bg-gradient-info shadow text-center border-radius-xl mt-n4 position-absolute">
                                        <i class="material-icons text-white opacity-10">
                                            pan_tool
                                        </i>
                                    </div>
                                    <div class="text-end pt-1">
                                        <p class="text-sm mb-0 text-capitalize">Diplomate</p>
                                        <h4 class="mb-0">357</h4>
                                    </div>
                                </div>
                                <hr class="dark horizontal my-0">
                                <div class="card-footer p-3">
                                    <p class="mb-0"><span class="text-success text-sm font-weight-bolder">Total Pending Diplomate</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-6 mb-4">
                            <div class="card">
                                <div class="card-header p-3 py-2">
                                    <div
                                        class="icon icon-lg icon-shape bg-gradient-info shadow text-center border-radius-xl mt-n4 position-absolute">
                                        <i class="material-icons text-white opacity-10">
                                            pan_tool
                                        </i>
                                    </div>
                                    <div class="text-end pt-1">
                                        <p class="text-sm mb-0 text-capitalize">Fellow</p>
                                        <h4 class="mb-0">357</h4>
                                    </div>
                                </div>
                                <hr class="dark horizontal my-0">
                                <div class="card-footer p-3">
                                    <p class="mb-0"><span class="text-success text-sm font-weight-bolder">Total Pending Fellow</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-6 mb-4">
                            <div class="card">
                                <div class="card-header p-3 py-2">
                                    <div
                                        class="icon icon-lg icon-shape bg-gradient-info shadow text-center border-radius-xl mt-n4 position-absolute">
                                        <i class="material-icons text-white opacity-10">
                                            pan_tool
                                        </i>
                                    </div>
                                    <div class="text-end pt-1">
                                        <p class="text-sm mb-0 text-capitalize">Emeritus</p>
                                        <h4 class="mb-0">357</h4>
                                    </div>
                                </div>
                                <hr class="dark horizontal my-0">
                                <div class="card-footer p-3">
                                    <p class="mb-0"><span class="text-success text-sm font-weight-bolder">Total Pending Emeritus</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>List of all Applicants</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Value</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Ads Spent</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Refunds</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($specialty_board as $specialty_board2)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-3 py-1">
                                                        <div>
                                                            <img src="https://raw.githubusercontent.com/creativetimofficial/public-assets/master/soft-ui-design-system/assets/img/ecommerce/blue-shoe.jpg"
                                                                class="avatar me-3" alt="image">
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $specialty_board2->first_name }} {{ $specialty_board2->middle_name }} {{ $specialty_board2->last_name }}</h6>
                                                            <p class="text-sm"><b class="text-danger">PRC No.: </b>{{ $specialty_board2->prc_number }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-normal mb-0">$130.992</p>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <p class="text-sm font-weight-normal mb-0">$9.500</p>
                                                </td>
                                                <td class="align-middle text-end">
                                                    <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                                        <p class="text-sm font-weight-normal mb-0">13</p>
                                                        <i class="ni ni-bold-down text-sm ms-1 text-success"></i>
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
            <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
        </div>
    </main>
    <x-plugins></x-plugins>
    @push('js')
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/chartjs.min.js"></script>
    @endpush
</x-page-template>
