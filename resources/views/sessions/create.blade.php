<x-page-template bodyClass="">
{{-- 
    <!-- Navbar -->
    <nav
        class="navbar navbar-expand-lg position-absolute top-0 z-index-3 w-100 shadow-none my-3 navbar-transparent mt-4">
        <x-auth.navbars.navs.guest p='' btn='bg-gradient-primary' textColor='text-white' svgColor='white'>
        </x-auth.navbars.navs.guest>
    </nav>
    <!-- End Navbar --> --}}
    <main class="main-content  mt-0">
        {{-- <div class="page-header align-items-start min-vh-100"
            style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container my-5">
                <div class="row signin-margin">
                    <div class="col-lg-5 col-md-8 col-12 mx-auto">
                        <div class="card z-index-0 fadeIn3 fadeInBottom">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                    <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Sign in</h4>
                                    <div class="row mt-3">
                                        <div class="col-2 text-center ms-auto">
                                            <a class="btn btn-link px-3" href="javascript:;">
                                                <i class="fa fa-facebook text-white text-lg"></i>
                                            </a>
                                        </div>
                                        <div class="col-2 text-center px-1">
                                            <a class="btn btn-link px-3" href="javascript:;">
                                                <i class="fa fa-github text-white text-lg"></i>
                                            </a>
                                        </div>
                                        <div class="col-2 text-center me-auto">
                                            <a class="btn btn-link px-3" href="javascript:;">
                                                <i class="fa fa-google text-white text-lg"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6>You can login with these 3 user types:</h6>
                                <ol>
                                    <li class="text-sm font-weight-normal">Username <strong>admin@material.com</strong> and Password
                                        <strong>secret</strong></li>
                                    <li class="text-sm font-weight-normal">Username <strong>creator@material.com</strong> and Password
                                       <strong>secret</strong></li>
                                    <li class="text-sm font-weight-normal"> Username <strong>member@material.com</strong> and Password
                                        <strong>secret</strong></li>
                                </ol>
                                <form role="form" method="POST" action="{{ route('login') }}" class="text-start">
                                    @csrf
                                    @if (Session::has('status'))
                                    <div class="alert alert-success alert-dismissible text-white" role="alert">
                                        <span class="text-sm">{{ Session::get('status') }}</span>
                                        <button type="button" class="btn-close text-lg py-3 opacity-10"
                                            data-bs-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @endif

                                    <div class="input-group input-group-outline mt-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name='email'
                                            value='admin@material.com'>
                                    </div>
                                    @error('email')
                                    <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror

                                    <div class="input-group input-group-outline mt-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" name='password' value='secret'>
                                    </div>
                                    @error('password')
                                    <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror
                                    <div class="form-check form-switch d-flex align-items-center my-3">
                                        <input class="form-check-input" type="checkbox" id="rememberMe">
                                        <label class="form-check-label mb-0 ms-2" for="rememberMe">Remember me</label>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Sign
                                            in</button>
                                    </div>
                                    <p class="text-sm text-center mt-3">
                                        Forgot your password? Reset your password
                                        <a href="{{ route('verify') }}"
                                            class="text-primary text-gradient font-weight-bold">here</a>
                                    </p>
                                    <p class="mt-4 text-sm text-center">
                                        Don't have an account?
                                        <a href="{{ route('register') }}"
                                            class="text-primary text-gradient font-weight-bold">Sign
                                            up</a>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <x-auth.footers.guest.basic-footer textColor='text-white'></x-auth.footers.guest.basic-footer>
        </div> --}}
        <section>
            <div class="page-header min-vh-100">
              <div class="container">
                <div class="row">
                  <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
                    <div class="position-relative bg-gray-200 h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center" style="background-image: url('{{ asset('assets') }}/img/illustrations/pps-logo.png'); background-size: cover;"></div>
                  </div>
                  <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
                    <div class="card card-plain">
                        @if (Session::has('status'))
                        <div class="alert alert-success alert-dismissible text-white mx-4" role="alert">
                            <span class="text-sm">{{ Session::get('status') }}</span>
                            <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                      <div class="card-header text-center">
                        <h4 class="font-weight-bolder">Sign In</h4>
                        <p class="mb-0">Enter your email and password to sign in</p>
                      </div>
                      <div class="card-body mt-2">
                        <form role="form" method="POST" action="{{ route('login') }}" class="text-start">
                            @csrf
                            <input type="hidden" id="token" value="{{ csrf_token() }}">
                          <div id="emailDiv" class="input-group input-group-outline mb-3 my-3">
                            <label class="form-label">Email</label>
                            <input type="email" name='email' class="form-control" value="{{ old('email') }}">
                          </div>
                          @error('email')
                          <p class='text-danger inputerror'>{{ $message }} </p>
                          @enderror
                          <div class="input-group input-group-outline mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name='password' class="form-control">
                          </div>
                          @error('password')
                          <p class='text-danger inputerror'>{{ $message }} </p>
                          @enderror
                          {{-- <div class="form-check form-switch d-flex align-items-center my-3">
                            <input class="form-check-input" type="checkbox" id="rememberMe" name="rememberMe">
                            <label class="form-check-label mb-0 ms-2" for="rememberMe">Remember me</label>
                          </div> --}}
                          <div class="text-center">
                            <button type="submit" class="btn btn-lg bg-gradient-danger btn-lg w-100 mt-4 mb-0">Sign in</button>
                          </div>
                          <p class="text-sm text-center mt-3">
                            Forgot your password? Reset your password
                            <a href="/reset-email"
                                class="text-danger text-gradient font-weight-bold">here</a>
                        </p>
                          {{-- <label style="margin-top: 15px !important">Forgot Password?</label> --}}
                        </form>
                      </div>
                      <div class="card-footer text-center pt-0 px-lg-2 px-1">
                        <hr>
                        <p class="mb-0 text-sm mx-auto">
                         For Non-PPS Member
                          {{-- <a href="#" data-bs-toggle="modal" data-bs-target="#modalChooseType"  class="text-danger text-gradient font-weight-bold">Click here to register</a> --}}
                        </p>
                        <div class="text-center">
                            <button type="button" class="btn btn-lg bg-gradient-warning btn-lg w-100 mt-4 mb-0" data-bs-toggle="modal" data-bs-target="#modalChooseType">Register Account Now</button>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>

          {{-- START OF TYPE MODAL --}}
          <div class="modal fade" id="modalChooseType" tabindex="-1" role="dialog" aria-labelledby="modalChooseType" aria-hidden="true">
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
                                <div class="row mt-0 text-center">
                                    <div class="col-12">
                                        <h4 class="font-weight-bolder">PPS Status</h4>
                                        <p class="mb-0">Please choose status below</p>
                                    </div>
                                </div>
                                <hr>
                                @foreach ($type as $type2)
                                    <div class="row mt-0 text-center" style="margin-top: -10px !important">
                                        <div class="col-12">
                                            <a href="/apply-member/{{ str_replace(array("/"," ","-","_"), array("","","".""), $type2->member_type_name)  }}" class="btn btn-lg bg-gradient-danger btn-lg w-100 mt-4 mb-0">{{ str_replace('_', ' ', $type2->member_type_name)  }}</a>
                                        </div>
                                    </div>
                                @endforeach
                                



                                {{-- <div class="row mt-0 text-center" style="margin-top: -10px !important">
                                    <div class="col-12">
                                        <a href="/apply-member/resident" class="btn btn-lg bg-gradient-danger btn-lg w-100 mt-4 mb-0">Resident</a>
                                    </div>
                                </div>
                                <div class="row mt-0 text-center" style="margin-top: -7px !important">
                                    <div class="col-12">
                                        <a href="/apply-member/physician" class="btn btn-lg bg-gradient-danger btn-lg w-100 mt-4 mb-0">Physician</a>
                                    </div>
                                </div>
                                <div class="row mt-0 text-center" style="margin-top: -7px !important">
                                    <div class="col-12">
                                        <a href="/apply-member/government-physician" class="btn btn-lg bg-gradient-danger btn-lg w-100 mt-4 mb-0">Government Physician</a>
                                    </div>
                                </div>
                                <div class="row mt-0 text-center" style="margin-top: -7px !important">
                                    <div class="col-12">
                                        <a href="/apply-member/allied-health-professional" class="btn btn-lg bg-gradient-danger btn-lg w-100 mt-4 mb-0">Allied Health Professional</a>
                                    </div>
                                </div>
                                <div class="row mt-0 text-center" style="margin-top: -7px !important">
                                    <div class="col-12">
                                        <a href="/apply-member/others" class="btn btn-lg bg-gradient-danger btn-lg w-100 mt-4 mb-0">Others</a>
                                    </div>
                                </div> --}}
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- END OF TYPE MODAL --}}
    </main>
    @push('js')
    <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
    <script>
        $(function () {
    
            function checkForInput(element) {
    
                const $label = $(element).parent();
    
                if ($(element).val().length > 0) {
                    $label.addClass('is-filled');
                } else {
                    $label.removeClass('is-filled');
                }
            }
            var input = $(".input-group input");
            input.focusin(function () {
                $(this).parent().addClass("focused is-focused");
            });

            $('input').each(function () {
                checkForInput(this);
            });

            $('input').on('change keyup', function () {
                checkForInput(this);
            });
    
            input.focusout(function () {
                $(this).parent().removeClass("focused is-focused");
            });
        });


        $(document).ready(function() {
            var token = $("#token").val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });


            $('#email').keyup(function() {
                $value = $(this).val();
                
                $.ajax({
                    type : 'get',
                    url: "{{ url('check-email')}}",
                    data : {'email':$value},
                    success:function(data){

                       

                        if(data == 1)
                        {
                       
                            $( "#emailDiv" ).addClass( "is-valid" );
                            $( "#emailDiv" ).removeClass( "is-invalid" );
                        }
                        else
                        {   
                            $( "#emailDiv" ).addClass( "is-invalid" );
                            $( "#emailDiv" ).removeClass( "is-valid" );
                        }
                        
                    }
                });
            });
           
        });
    
    </script>
    
    @endpush
</x-page-template>
