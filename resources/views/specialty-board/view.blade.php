
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="specialtyBoard" activeItem="specialty-board-view" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="Specialty Board"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->

      <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-9 col-12">
                          <div class="row mt-3">
                            <div class="col-12 col-md-9">
                                <h3 class="mb-4 text-danger">{{ $member_info->first_name }} {{ $member_info->middle_name }} {{ $member_info->last_name }} {{ $member_info->suffix }}</h3>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-12 col-md-12">
                                <h6>Surname, Given Name, Middle Name: <label class="text-lg">{{ $member_info->first_name }} {{ $member_info->middle_name }} {{ $member_info->last_name }} {{ $member_info->suffix }}</label></h6>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-12 col-md-12">
                              <h6>Chapter: <label class="text-lg">{{ $member_info->chapter_name  }}</label></h6>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-12 col-md-12">
                              <h6>Member Type: <label class="text-lg">{{ $member_info->member_type_name  }}</label></h6>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-12 col-md-12">
                              <h6>PRC Number: <label class="text-lg">{{ $member_info->prc_number }}</label></h6>
                            </div>
                          </div>





                        </div>
                        <div class="col-md-3 col-12">
                          @if ($member_info->picture == null)
                            <img src="{{ asset('assets') }}/img/pps-logo.png"
                            class="w-100 shadow-sm border-radius-lg" alt="image">
                          @else

                            <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $member_info->picture, now()->addMinutes(240))}}" alt="profile_image"
                                            class="w-100 shadow-sm border-radius-lg">
                          @endif

                        </div>
                      </div>

                      <div class="row mt-3">
                        <div class="col-12 col-md-3 ms-md-auto">
                          <a class="btn bg-gradient-warning w-100" href="/specialty-board-update-profile" type="button" aria-expanded="false">
                            Update Profile
                          </a>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 col-md-3 ms-md-auto">
                          <div class="dropdown">
                            <button class="btn bg-gradient-danger dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                              New Application
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">


                                @if($member_info->completed_profile == true)
                                    @if ($price_list == null)
                                        <li><a class="dropdown-item" href="specialty-board-payment/{{ Crypt::encrypt( 1 )}}">Written Examination</a></li>
                                    @else
                                        <li><a class="dropdown-item" href="specialty-board-payment/{{ Crypt::encrypt( $completed_profile->id )}}">Written Examination</a></li>
                                    @endif

                                @else
                                    <li><a class="dropdown-item" href="#" id="profileNotCompeleteBtn">Written Examination</a></li>
                                @endif


                              <li><a class="dropdown-item" href="#">Written and Oral Examination</a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                      <div class="row mt-5 mb-3">
                        <div class="col-12">
                            <h5 class="ms-3">List of Application</h5>

                            <div class="table table-responsive table-bordered">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Description</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Date Applied</th>



                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Status</th>

                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($specialty_board as $specialty_board2)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div>
                                                            <img src="{{ asset('assets') }}/img/pps-logo.png"
                                                                class="avatar avatar-md me-3" alt="table image">
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">FOR {{ $specialty_board2->apply_description }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <p class="text-sm text-secondary mb-0">{{Carbon\Carbon::parse($specialty_board2->apply_dt)->format('F d, Y')}}</p>
                                                </td>



                                                <td class="align-middle text-center">
                                                    @if ($specialty_board2->status == "FOR APPROVAL")
                                                        <p class="text-sm text-secondary mb-0 text-bold text-warning">{{ $specialty_board2->status }}</p>
                                                    @elseif($specialty_board2->status == "PASSED")
                                                        <p class="text-sm text-secondary mb-0 text-bold text-success">{{ $specialty_board2->status }}</p>
                                                    @elseif($specialty_board2->status == "FAILED")
                                                        <p class="text-sm text-secondary mb-0 text-bold text-danger">{{ $specialty_board2->status }}</p>
                                                    @else
                                                        <p class="text-sm text-secondary mb-0 text-bold">{{ $specialty_board2->status }}</p>
                                                    @endif

                                                </td>



                                                <td class="align-middle text-center">
                                                    <button class="btn bg-gradient-danger dropdown-toggle mt-3" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <li><a class="dropdown-item text-bold" href="user-maintenance-edit">Update</a></li>
                                                    </ul>
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
        <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
    </div>
    </main>
    <x-plugins></x-plugins>
    <link href="{{ asset('assets') }}/css/loader.css" rel="stylesheet" />
  @push('js')

  <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('assets') }}/js/select2.min.js"></script>
  <link href="{{ asset('assets') }}/css/select2.min.css" rel="stylesheet" />
  <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
  <script src="{{ asset('assets') }}/js/specialty-board.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>


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
        @endif

    @endif
</script>

    @endpush
  </x-page-template>
