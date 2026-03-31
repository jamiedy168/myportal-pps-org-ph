@props(['activePage', 'activeItem', 'activeSubitem'])
<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0 d-flex align-items-center text-wrap" href="#">
            <img src="{{ asset('assets') }}/img/pps-logo.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-2 font-weight-bold text-white">PHILIPPINE PEDIATRIC SOCIETY</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto h-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item mb-2 mt-0">
                <a data-bs-toggle="collapse" href="#ProfileNav" class="nav-link text-white" aria-controls="ProfileNav"
                    role="button" aria-expanded="false">
                    @if (auth()->user()->picture)
                    <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . auth()->user()->picture, now()->addMinutes(240))}}" alt="avatar" class="avatar">
                    @else
                    <img src="{{ asset('assets') }}/img/default-avatar.png" alt="avatar" class="avatar">
                    @endif
                    <span class="nav-link-text ms-2 ps-1">{{ auth()->user()->name }}</span>
                </a>
                <div class="collapse" id="ProfileNav" style="">
                    <ul class="nav ">

                        <form method="POST" action="{{ route('logout') }}" class="d-none" id="logout-form">
                            @csrf
                        </form>
                        @if (auth()->user()->role_id == 5)
                            <li class="nav-item" style="display: none !important">
                                <a class="nav-link text-white" href="/email-user-maintenance">
                                    <span class="sidenav-mini-icon"> C </span>
                                    <span class="sidenav-normal  ms-3  ps-1"> Change Email </span>
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link text-white" href="/email-user-maintenance">
                                    <span class="sidenav-mini-icon"> C </span>
                                    <span class="sidenav-normal  ms-3  ps-1"> Change Email </span>
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 3 ||auth()->user()->role_id == 4)
                            <li class="nav-item">
                                <a class="nav-link text-white" href="/member-info-update/{{ Crypt::encrypt( auth()->user()->pps_no )}}">
                                    <span class="sidenav-mini-icon"> U </span>
                                    <span class="sidenav-normal  ms-3  ps-1"> Update Profile </span>
                                </a>
                            </li>
                        @endif
                        

                        <li class="nav-item">
                            <a class="nav-link text-white " href="{{ route('logout') }}"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <span class="sidenav-mini-icon"> L </span>
                                <span class="sidenav-normal  ms-3  ps-1"> Logout </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <hr class="horizontal light mt-0">
           
            @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 3 ||auth()->user()->role_id == 4)
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#dashboardsExamples"
                        class="nav-link text-white {{ $activePage == 'dashboard' ? ' active ' : '' }} "
                        aria-controls="dashboardsExamples" role="button" aria-expanded="false">
                        <i class="material-icons-round opacity-10">dashboard</i>
                        <span class="nav-link-text ms-2 ps-1">Dashboards</span>
                    </a>
                    <div class="collapse {{ $activePage == 'dashboard' ? ' show ' : '' }}  " id="dashboardsExamples">
                        <ul class="nav ">
                            <li class="nav-item {{ $activeItem == 'analytics' ? ' active ' : '' }}  ">
                                <a class="nav-link text-white {{ $activeItem == 'analytics' ? ' active' : '' }}  "
                                    href="{{ route('dashboard') }}">
                                    <span class="sidenav-mini-icon"> H </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Home </span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
            @endif
            




        @if (auth()->user()->role_id == 4)
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#cashierDropdown"
                    class="nav-link text-white {{ $activePage == 'cashier' ? ' active ' : '' }}"
                    aria-controls="cashierDropdown" role="button" aria-expanded="false">
                    <i class="material-icons-round">point_of_sale</i>
                    <span class="nav-link-text ms-2 ps-1">Cashier</span>
                </a>
                <div class="collapse {{ $activePage == 'cashier' ? 'show' : '' }} " id="cashierDropdown">
                    <ul class="nav ">
                        <li class="nav-item {{ $activeItem == 'cashier-new-transaction' ? ' active ' : '' }}">
                            <a class="nav-link text-white {{ $activeItem == 'cashier-new-transaction' ? ' active ' : '' }}"
                            href="/cashier-new-transaction">
                                <span class="sidenav-mini-icon"> N </span>
                                <span class="sidenav-normal  ms-2  ps-1"> New Transaction </span>
                            </a>
                        </li>
                        <li class="nav-item {{ $activeItem == 'cashier-event' ? ' active ' : '' }}">
                            <a class="nav-link text-white {{ $activeItem == 'cashier-event' ? ' active ' : '' }}"
                            href="/cashier-event">
                                <span class="sidenav-mini-icon"> E </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Events </span>
                            </a>
                        </li>
                        <li class="nav-item {{ $activeItem == 'cashier-annual-dues' ? ' active ' : '' }}">
                            <a class="nav-link text-white {{ $activeItem == 'cashier-annual-dues' ? ' active ' : '' }}"
                            href="/cashier-annual-dues">
                                <span class="sidenav-mini-icon"> A </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Annual Dues </span>
                            </a>
                        </li>
                        <li class="nav-item {{ $activeItem == 'cashier-report' ? ' active ' : '' }}">
                            <a class="nav-link text-white {{ $activeItem == 'cashier-report' ? ' active ' : '' }}"
                            href="/cashier-report">
                                <span class="sidenav-mini-icon"> R </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Reports </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif
        @if (auth()->user()->role_id == 1)
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#applicantsDropdown"
                    class="nav-link text-white {{ $activePage == 'applicants' ? ' active ' : '' }}"
                    aria-controls="applicantsDropdown" role="button" aria-expanded="false">
                    <i class="material-icons-round">group</i>
                    <span class="nav-link-text ms-2 ps-1">Applicants</span>
                </a>
                <div class="collapse {{ $activePage == 'applicants' ? 'show' : '' }} " id="applicantsDropdown">
                    <ul class="nav ">
                        <li class="nav-item {{ $activeItem == 'listing' ? ' active ' : '' }}">
                            <a class="nav-link text-white {{ $activeItem == 'listing' ? ' active ' : '' }}"
                            href="/applicant-listing">
                                <span class="sidenav-mini-icon"> L </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Listing </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif
        @if (auth()->user()->role_id == 1)
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#membersDropdown"
                    class="nav-link text-white {{ $activePage == 'members' ? ' active ' : '' }}"
                    aria-controls="membersDropdown" role="button" aria-expanded="false">
                    <i class="material-icons-round">group</i>
                    <span class="nav-link-text ms-2 ps-1">Members</span>
                </a>
                <div class="collapse {{ $activePage == 'members' ? 'show' : '' }} " id="membersDropdown">
                    <ul class="nav ">
                        <li class="nav-item {{ $activeItem == 'listing' ? ' active ' : '' }}">
                            <a class="nav-link text-white {{ $activeItem == 'listing' ? ' active ' : '' }}"
                            href="/member-listing">
                                <span class="sidenav-mini-icon"> L </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Listing </span>
                            </a>
                        </li>
                        <li class="nav-item {{ $activeItem == 'reclassification' ? ' active ' : '' }}">
                            <a class="nav-link text-white {{ $activeItem == 'reclassification' ? ' active ' : '' }}"
                            href="/member-reclassification">
                                <span class="sidenav-mini-icon"> R </span>
                                <span class="sidenav-normal ms-2  ps-1"> Re-classification(Non-Member) </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif
            @if (auth()->user()->role_id == 1)
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'audit' ? ' active ' : '' }}" href="/audit-trails">
                    <i class="material-icons-round opacity-10">history</i>
                    <span class="nav-link-text ms-2 ps-1">Audit Trails</span>
                </a>
            </li>
            @endif
            @if (auth()->user()->role_id == 1)
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#annualDuesDropdown"
                    class="nav-link text-white {{ $activePage == 'annual-dues' ? ' active ' : '' }}"
                    aria-controls="annualDuesDropdown" role="button" aria-expanded="false">
                    <i class="material-icons-round">remember_me</i>
                    <span class="nav-link-text ms-2 ps-1">Annual Dues</span>
                </a>
                <div class="collapse {{ $activePage == 'annual-dues' ? 'show' : '' }} " id="annualDuesDropdown">
                    <ul class="nav ">
                        <li class="nav-item {{ $activeItem == 'create-annual-dues' ? ' active ' : '' }}">
                            <a class="nav-link text-white {{ $activeItem == 'create-annual-dues' ? ' active ' : '' }}"
                            href="/create-annual-dues">
                                <span class="sidenav-mini-icon"> C </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Create </span>
                            </a>
                        </li>
                        <li class="nav-item {{ $activeItem == 'listing-annual-dues' ? ' active ' : '' }}">
                            <a class="nav-link text-white {{ $activeItem == 'listing-annual-dues' ? ' active ' : '' }}"
                            href="/listing-annual-dues">
                                <span class="sidenav-mini-icon"> L </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Listing </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif
            @if (auth()->user()->role_id == 3)
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#paymentDropdown"
                    class="nav-link text-white {{ $activePage == 'payment' ? ' active ' : '' }}"
                    aria-controls="paymentDropdown" role="button" aria-expanded="false">
                    <i class="material-icons-round">payments</i>
                    <span class="nav-link-text ms-2 ps-1">Payment</span>
                </a>
                <div class="collapse {{ $activePage == 'payment' ? 'show' : '' }} " id="paymentDropdown">
                    <ul class="nav ">
                        <li class="nav-item {{ $activeItem == 'listing-payment' ? ' active ' : '' }}">
                            <a class="nav-link text-white {{ $activeItem == 'listing-payment' ? ' active ' : '' }}"
                            href="/payment-listing">
                                <span class="sidenav-mini-icon"> L </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Listing </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif
            @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 3)
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#eventsDropdown"
                    class="nav-link text-white {{ $activePage == 'events' ? ' active ' : '' }}"
                    aria-controls="eventsDropdown" role="button" aria-expanded="false">
                    <i class="material-icons-round">calendar_month</i>
                    <span class="nav-link-text ms-2 ps-1">Events</span>
                </a>
                <div class="collapse {{ $activePage == 'events' ? 'show' : '' }} " id="eventsDropdown">
                    <ul class="nav ">
                        <li class="nav-item {{ $activeItem == 'listing' ? ' active ' : '' }}">
                            <a class="nav-link text-white {{ $activeItem == 'listing' ? ' active ' : '' }}"
                            href="/event-listing">
                                <span class="sidenav-mini-icon"> L </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Listing </span>
                            </a>
                        </li>
                        @if (auth()->user()->role_id == 3)
                            <li class="nav-item {{ $activeItem == 'online-video' ? ' active ' : '' }}">
                                <a class="nav-link text-white {{ $activeItem == 'online-video' ? ' active ' : '' }}"
                                href="/event-online-video">
                                    <span class="sidenav-mini-icon"> V </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Virtual </span>
                                </a>
                            </li>
                        @endif
                        @if (auth()->user()->role_id == 3)
                            <li class="nav-item {{ $activeItem == 'livestream' ? ' active ' : '' }}">
                                <a class="nav-link text-white {{ $activeItem == 'livestream' ? ' active ' : '' }}"
                                href="/event-livestream-video">
                                    <span class="sidenav-mini-icon"> L </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Livestream </span>
                                </a>
                            </li>
                        @endif
                        @if (auth()->user()->role_id == 1)
                            <li class="nav-item {{ $activeItem == 'create-event' ? ' active ' : '' }}">
                                <a class="nav-link text-white {{ $activeItem == 'create-event' ? ' active ' : '' }}"
                                href="/event-create">
                                    <span class="sidenav-mini-icon"> C </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Create </span>
                                </a>
                            </li>
                            
                        @endif
                    </ul>
                </div>
            </li>
            @endif

            @if (auth()->user()->role_id == 6)
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#attendanceDropdown"
                    class="nav-link text-white {{ $activePage == 'attendance' ? ' active ' : '' }}"
                    aria-controls="attendanceDropdown" role="button" aria-expanded="false">
                    <i class="material-icons-round">calendar_month</i>
                    <span class="nav-link-text ms-2 ps-1">Attendance</span>
                </a>
                <div class="collapse {{ $activePage == 'attendance' ? 'show' : '' }} " id="attendanceDropdown">
                    <ul class="nav ">
                        <li class="nav-item {{ $activeItem == 'attendance-event' ? ' active ' : '' }}">
                            <a class="nav-link text-white {{ $activeItem == 'attendance-event' ? ' active ' : '' }}"
                            href="/event-choose-attendance">
                                <span class="sidenav-mini-icon"> E </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Events </span>
                            </a>
                        </li>
                        <li class="nav-item {{ $activeItem == 'attendance-print-choose-event' ? ' active ' : '' }}">
                            <a class="nav-link text-white {{ $activeItem == 'attendance-print-choose-event' ? ' active ' : '' }}"
                            href="/choose-print-attendance">
                                <span class="sidenav-mini-icon"> P </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Printing </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif

            @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 3)
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#cpdpointsDropdown"
                    class="nav-link text-white {{ $activePage == 'cpdpoints' ? ' active ' : '' }}"
                    aria-controls="paymentDropdown" role="button" aria-expanded="false">
                    <i class="material-icons-round">credit_score</i>
                    <span class="nav-link-text ms-2 ps-1">CPD Points</span>
                </a>
                <div class="collapse {{ $activePage == 'cpdpoints' ? 'show' : '' }} " id="cpdpointsDropdown">
                    <ul class="nav ">
                        {{-- ADMIN --}}
                        @if (auth()->user()->role_id == 1)
                            <li class="nav-item {{ $activeItem == 'cpdpoints-admin-view' ? ' active ' : '' }}">
                                <a class="nav-link text-white {{ $activeItem == 'cpdpoints-admin-view' ? ' active ' : '' }}"
                                href="/cpdpoints-admin-view">
                                    <span class="sidenav-mini-icon"> V </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> View </span>
                                </a>
                            </li>
                        @endif

                        {{-- MEMBER --}}
                        @if (auth()->user()->role_id == 3)
                            <li class="nav-item {{ $activeItem == 'cpdpoints-member-view' ? ' active ' : '' }}">
                                <a class="nav-link text-white {{ $activeItem == 'cpdpoints-member-view' ? ' active ' : '' }}"
                                href="/cpdpoints-member-view">
                                    <span class="sidenav-mini-icon"> V </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> View </span>
                                </a>
                            </li>
                        @endif


                    </ul>
                </div>
            </li>
            @endif
            

            {{-- @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 3)
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#specialtyBoardDropdown"
                        class="nav-link text-white {{ $activePage == 'specialtyBoard' ? ' active ' : '' }}"
                        aria-controls="specialtyBoardDropdown" role="button" aria-expanded="false">
                        <i class="material-icons-round">description</i>
                        <span class="nav-link-text ms-2 ps-1">Specialty Board</span>
                    </a>
                    <div class="collapse {{ $activePage == 'specialtyBoard' ? 'show' : '' }} " id="specialtyBoardDropdown">
                        <ul class="nav ">


                            @if (auth()->user()->role_id == 3)
                                <li class="nav-item {{ $activeItem == 'specialty-board-view' ? ' active ' : '' }}">
                                    <a class="nav-link text-white {{ $activeItem == 'specialty-board-view' ? ' active ' : '' }}"
                                    href="/specialty-board-view">
                                        <span class="sidenav-mini-icon"> V </span>
                                        <span class="sidenav-normal  ms-2  ps-1"> View </span>
                                    </a>
                                </li>
                            @endif

                        
                            @if (auth()->user()->role_id == 1)
                                <li class="nav-item {{ $activeItem == 'specialty-board-admin-view' ? ' active ' : '' }}">
                                    <a class="nav-link text-white {{ $activeItem == 'specialty-board-admin-view' ? ' active ' : '' }}"
                                    href="/specialty-board-admin-view">
                                        <span class="sidenav-mini-icon"> V </span>
                                        <span class="sidenav-normal  ms-2  ps-1"> View </span>
                                    </a>
                                </li>
                                    <li class="nav-item {{ $activeItem == 'specialty-board-admin-export' ? ' active ' : '' }}">
                                        <a class="nav-link text-white {{ $activeItem == 'specialty-board-admin-export' ? ' active ' : '' }}"
                                        href="/specialty-board-admin-export">
                                            <span class="sidenav-mini-icon"> E </span>
                                            <span class="sidenav-normal  ms-2  ps-1"> Export </span>
                                        </a>
                                    </li>
                            @endif


                        </ul>
                    </div>
                </li>
            @endif --}}


            {{-- @if (auth()->user()->role_id == 1 || Session::get('member_type') == 'DIPLOMATE' || Session::get('member_type') == 'FELLOW' || Session::get('member_type') == 'EMERITUS FELLOW') --}}
            @if (auth()->user()->role_id == 1)
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#votingDropdown"
                        class="nav-link text-white {{ $activePage == 'voting' ? ' active ' : '' }}"
                        aria-controls="votingDropdown" role="button" aria-expanded="false">
                        <i class="material-icons-round">group</i>
                        <span class="nav-link-text ms-2 ps-1">Election</span>
                    </a>
                    <div class="collapse {{ $activePage == 'voting' ? 'show' : '' }} " id="votingDropdown">
                        <ul class="nav ">
                            <li class="nav-item {{ $activeItem == 'listing' ? ' active ' : '' }}">
                                <a class="nav-link text-white {{ $activeItem == 'listing' ? ' active ' : '' }}"
                                href="/voting-listing">
                                    <span class="sidenav-mini-icon"> L </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Listing </span>
                                </a>
                            </li>
                            @if (auth()->user()->role_id == 1)
                                <li class="nav-item {{ $activeItem == 'create' ? ' active ' : '' }}">
                                    <a class="nav-link text-white {{ $activeItem == 'create' ? ' active ' : '' }}"
                                    href="/voting-create">
                                        <span class="sidenav-mini-icon"> C </span>
                                        <span class="sidenav-normal  ms-2  ps-1"> Create </span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
            @endif

            @if (auth()->user()->role_id == 1)
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#ICDDropdown"
                    class="nav-link text-white {{ $activePage == 'ICD' ? ' active ' : '' }}"
                    aria-controls="patientICDDropdown" role="button" aria-expanded="false">
                    <i class="material-icons-round">local_hospital</i>
                    <span class="nav-link-text ms-2 ps-1">ICD</span>
                </a>
                <div class="collapse {{ $activePage == 'ICD' ? 'show' : '' }} " id="ICDDropdown">
                    <ul class="nav ">
                        <li class="nav-item {{ $activeItem == 'admin-new-code' ? ' active ' : '' }}">
                            <a class="nav-link text-white {{ $activeItem == 'admin-new-code' ? ' active ' : '' }}"
                            href="/icd-admin-new-code">
                                <span class="sidenav-mini-icon"> N </span>
                                <span class="sidenav-normal  ms-2  ps-1"> New ICD Code </span>
                            </a>
                        </li>
                        <li class="nav-item {{ $activeItem == 'admin-admitted-view' ? ' active ' : '' }}">
                            <a class="nav-link text-white {{ $activeItem == 'admin-admitted-view' ? ' active ' : '' }}"
                            href="/icd-admin-admitted-view">
                                <span class="sidenav-mini-icon"> W </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Ward Patient </span>
                            </a>
                        </li>
                        <li class="nav-item {{ $activeItem == 'admin-neonatal-view' ? ' active ' : '' }}">
                            <a class="nav-link text-white {{ $activeItem == 'admin-neonatal-view' ? ' active ' : '' }}"
                            href="/icd-admin-neonatal-view">
                                <span class="sidenav-mini-icon"> N </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Neonatal </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif

            {{-- @if (auth()->user()->role_id == 5)
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#icdHospitalDropdown"
                    class="nav-link text-white {{ $activePage == 'icdhospital' ? ' active ' : '' }}"
                    aria-controls="icdHospitalDropdown" role="button" aria-expanded="false">
                    <i class="material-icons-round">credit_score</i>
                    <span class="nav-link-text ms-2 ps-1">ICD</span>
                </a>
                <div class="collapse {{ $activePage == 'icdhospital' ? 'show' : '' }} " id="icdHospitalDropdown">
                    <ul class="nav ">
                        <li class="nav-item {{ $activeItem == 'admitted-upload' ? ' active ' : '' }}">
                            <a class="nav-link text-white {{ $activeItem == 'admitted-upload' ? ' active ' : '' }}"
                            href="/icd-admitted-upload">
                                <span class="sidenav-mini-icon"> A </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Admitted </span>
                            </a>
                        </li>
                        <li class="nav-item {{ $activeItem == 'neonatal-upload' ? ' active ' : '' }}">
                            <a class="nav-link text-white {{ $activeItem == 'neonatal-upload' ? ' active ' : '' }}"
                            href="/icd-neonatal-upload">
                                <span class="sidenav-mini-icon"> N </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Neonatal </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif --}}

            @if (auth()->user()->role_id == 5)
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#templateICDDropdown"
                    class="nav-link text-white {{ $activePage == 'templateICD' ? ' active ' : '' }}"
                    aria-controls="neonatalICDDropdown" role="button" aria-expanded="false">
                    <i class="material-icons-round">description</i>
                    <span class="nav-link-text ms-2 ps-1">Template</span>
                </a>
                <div class="collapse {{ $activePage == 'templateICD' ? 'show' : '' }} " id="templateICDDropdown">
                    <ul class="nav ">
                        <li class="nav-item {{ $activeItem == 'template-download' ? ' active ' : '' }}">
                            <a class="nav-link text-white {{ $activeItem == 'template-download' ? ' active ' : '' }}"
                            href="/icd-template-download">
                                <span class="sidenav-mini-icon"> D </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Download </span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>
            @endif



            @if (auth()->user()->role_id == 5)
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#patientICDDropdown"
                    class="nav-link text-white {{ $activePage == 'patientICD' ? ' active ' : '' }}"
                    aria-controls="patientICDDropdown" role="button" aria-expanded="false">
                    <i class="material-icons-round">local_hospital</i>
                    <span class="nav-link-text ms-2 ps-1">Ward Patient</span>
                </a>
                <div class="collapse {{ $activePage == 'patientICD' ? 'show' : '' }} " id="patientICDDropdown">
                    <ul class="nav ">
                        <li class="nav-item {{ $activeItem == 'admitted-upload' ? ' active ' : '' }}">
                            <a class="nav-link text-white {{ $activeItem == 'admitted-upload' ? ' active ' : '' }}"
                            href="/icd-admitted-upload">
                                <span class="sidenav-mini-icon"> U </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Upload </span>
                            </a>
                        </li>
                        <li class="nav-item {{ $activeItem == 'admitted-view' ? ' active ' : '' }}">
                            <a class="nav-link text-white {{ $activeItem == 'admitted-view' ? ' active ' : '' }}"
                            href="/icd-admitted-view">
                                <span class="sidenav-mini-icon"> V </span>
                                <span class="sidenav-normal  ms-2  ps-1"> View </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif

            @if (auth()->user()->role_id == 5)
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#neonatalICDDropdown"
                    class="nav-link text-white {{ $activePage == 'neonatalICD' ? ' active ' : '' }}"
                    aria-controls="neonatalICDDropdown" role="button" aria-expanded="false">
                    <i class="material-icons-round">local_hospital</i>
                    <span class="nav-link-text ms-2 ps-1">Neonatal</span>
                </a>
                <div class="collapse {{ $activePage == 'neonatalICD' ? 'show' : '' }} " id="neonatalICDDropdown">
                    <ul class="nav ">
                        <li class="nav-item {{ $activeItem == 'neonatal-upload' ? ' active ' : '' }}">
                            <a class="nav-link text-white {{ $activeItem == 'neonatal-upload' ? ' active ' : '' }}"
                            href="/icd-neonatal-upload">
                                <span class="sidenav-mini-icon"> U </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Upload </span>
                            </a>
                        </li>
                        <li class="nav-item {{ $activeItem == 'neonatal-view' ? ' active ' : '' }}">
                            <a class="nav-link text-white {{ $activeItem == 'neonatal-view' ? ' active ' : '' }}"
                            href="/icd-neonatal-view">
                                <span class="sidenav-mini-icon"> V </span>
                                <span class="sidenav-normal  ms-2  ps-1"> View </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif

            @if (auth()->user()->role_id == 1)
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#reportsDropdown"
                    class="nav-link text-white {{ $activePage == 'reports' ? ' active ' : '' }}"
                    aria-controls="reportsDropdown" role="button" aria-expanded="false">
                    <i class="material-icons-round">backup_table</i>
                    <span class="nav-link-text ms-2 ps-1">Reports</span>
                </a>
                <div class="collapse {{ $activePage == 'reports' ? 'show' : '' }} " id="reportsDropdown">
                    <ul class="nav ">
                        <li class="nav-item {{ $activeItem == 'view-reports' ? ' active ' : '' }}">
                            <a class="nav-link text-white {{ $activeItem == 'view-reports' ? ' active ' : '' }}"
                            href="/reports-view">
                                <span class="sidenav-mini-icon"> V </span>
                                <span class="sidenav-normal  ms-2  ps-1"> View </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif




            @if (auth()->user()->role_id == 1)
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#maintenanceDropdown"
                    class="nav-link text-white {{ $activePage == 'maintenance' ? ' active ' : '' }}"
                    aria-controls="maintenanceDropdown" role="button" aria-expanded="false">
                    <i class="material-icons-round">settings</i>
                    <span class="nav-link-text ms-2 ps-1">Maintenance</span>
                </a>
                <div class="collapse {{ $activePage == 'maintenance' ? 'show' : '' }} " id="maintenanceDropdown">
                    {{-- <ul class="nav ">
                        <li class="nav-item {{ $activeItem == 'email-maintenance' ? ' active ' : '' }}">
                            <a class="nav-link text-white {{ $activeItem == 'email-maintenance' ? ' active ' : '' }}"
                            href="/email-maintenance">
                                <span class="sidenav-mini-icon"> E </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Email </span>
                            </a>
                        </li>
                    </ul> --}}
                    <ul class="nav ">
                        <li class="nav-item {{ $activeItem == 'user-maintenance' ? ' active ' : '' }}">
                            <a class="nav-link text-white {{ $activeItem == 'user-maintenance' ? ' active ' : '' }}"
                            href="/user-maintenance">
                                <span class="sidenav-mini-icon"> U </span>
                                <span class="sidenav-normal  ms-2  ps-1"> User </span>
                            </a>
                        </li>
                        <li class="nav-item {{ $activeItem == 'event-livestream-maintenance' ? ' active ' : '' }}">
                            <a class="nav-link text-white {{ $activeItem == 'event-livestream-maintenance' ? ' active ' : '' }}"
                            href="/event-livestream-maintenance">
                                <span class="sidenav-mini-icon"> E </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Event Livestream </span>
                            </a>
                        </li>
                        <li class="nav-item {{ $activeItem == 'payment-gateway' ? ' active ' : '' }}">
                            <a class="nav-link text-white {{ $activeItem == 'payment-gateway' ? ' active ' : '' }}"
                            href="/payment-gateway">
                                <span class="sidenav-mini-icon"> P </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Payment Gateway </span>
                            </a>
                        </li>
                        <li class="nav-item {{ $activeItem == 'audit-trails' ? ' active ' : '' }}">
                            <a class="nav-link text-white {{ $activeItem == 'audit-trails' ? ' active ' : '' }}"
                            href="/audit-trails">
                                <span class="sidenav-mini-icon"> A </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Audit Trails </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif

        </ul>
    </div>
    <div class="sidenav-footer w-100 bottom-0 mt-2 ">

    </div>
</aside>
