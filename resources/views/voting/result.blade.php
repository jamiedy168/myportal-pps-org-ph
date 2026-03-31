<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="voting" activeItem="listing" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-auth.navbars.navs.auth pageTitle="Election Result"></x-auth.navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-lg-12 text-center">
                                    <h4 class="text-danger">{{ $voting->title }} RESULT</h4>
                                    @if ($voting->status == "ONGOING")
                                        <p class="text-danger">(ONGOING)</p>
                                    @elseif ($voting->status == "UPCOMING")    
                                        <p class="text-danger">(UPCOMING)</p>
                                    @else
                                        <p class="text-success">(COMPLETED)</p>
                                    @endif
                                    
                                </div>
                            </div>
                            
                     

                            <div class="row">
                                <div class="col-12">
                                    <h5 class="text-header">
                                        Board of Trustees
                                    </h5>
                                </div>
                                <hr>
                            </div>

                            <div class="row mt-4">
                                @foreach ($BOTcandidates as $BOTcandidates2)
                                

                                    <div class="col-lg-3 col-6">
                                        <div class="card h-100">
                                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                            <a class="d-block blur-shadow-image">
                                                @if ($BOTcandidates2 == null)
                                                    <img src="{{ asset('assets') }}/img/pps-logo.png" alt="img-blur-shadow" class="img-fluid shadow border-radius-lg">
                                                @else
                                                    <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $BOTcandidates2->picture, now()->addMinutes(30))}}" alt="img-blur-shadow" class="img-fluid shadow border-radius-lg">
                                                @endif
                                            
                                            </a>
                                            
                                        </div>
                                        <div class="card-body text-center mb-0">
                                            <p class="mb-0 text-sm">Candidate #{{ $loop->iteration }}</p>
                                            <h5 class="font-weight-normal mt-1 text-danger">
                                                {{ $BOTcandidates2->first_name }} {{ $BOTcandidates2->middle_name }} {{ $BOTcandidates2->last_name }} {{ $BOTcandidates2->suffix }}
                                            </h5>
                                            <h3 class="mt-0 text-danger text-bold">
                                                <span id="botCount" countto="{{ $BOTcandidates2->voting_count }}">{{ $BOTcandidates2->voting_count }}</span>
                                            </h3>
                                            <p class="text-xs">VOTE COUNT</p>
                                        </div>
                                 
                                        
                                        </div>
                                    </div>

                                @endforeach
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <h5 class="text-header">
                                        Chapter Representative
                                    </h5>
                                </div>
                                <hr>
                            </div>

                            <div class="row mt-4">
                                @foreach ($ChapRepcandidates as $ChapRepcandidates2)
                                 


                                    <div class="col-lg-3 col-6">
                                        <div class="card h-100">
                                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                            <a class="d-block blur-shadow-image">
                                                @if ($ChapRepcandidates2 == null)
                                                    <img src="{{ asset('assets') }}/img/pps-logo.png" alt="img-blur-shadow" class="img-fluid shadow border-radius-lg">
                                                @else
                                                    <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $ChapRepcandidates2->picture, now()->addMinutes(30))}}" alt="img-blur-shadow" class="img-fluid shadow border-radius-lg">
                                                @endif
                                            
                                            </a>
                                            
                                        </div>
                                        <div class="card-body text-center mb-0">
                                            <p class="mb-0 text-sm">Candidate #{{ $loop->iteration }}</p>
                                            <h5 class="font-weight-normal mt-1 text-danger">
                                                {{ $ChapRepcandidates2->first_name }} {{ $ChapRepcandidates2->middle_name }} {{ $ChapRepcandidates2->last_name }} {{ $ChapRepcandidates2->suffix }}
                                            </h5>
                                            <h3 class="mt-0 text-danger text-bold">
                                                <span id="botCount" countto="{{ $ChapRepcandidates2->voting_count }}">{{ $ChapRepcandidates2->voting_count }}</span>
                                            </h3>
                                            <p class="text-xs">VOTE COUNT</p>
                                        </div>
                                 
                                        
                                        </div>
                                    </div>
                                @endforeach
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
    <script src="{{ asset('assets') }}/js/plugins/countup.min.js"></script>
    <script>
        if (document.getElementById('botCount')) {
            const countUp = new CountUp('botCount', document.getElementById("botCount").getAttribute("countTo"));
            if (!countUp.error) {
                countUp.start();
            } else {
                console.error(countUp.error);
            }
        }

        if (document.getElementById('chapRepCount')) {
            const countUp = new CountUp('botCount', document.getElementById("botCount").getAttribute("countTo"));
            if (!countUp.error) {
                countUp.start();
            } else {
                console.error(countUp.error);
            }
        }

        
    </script>
    @endpush
</x-page-template>