<x-page-template bodyClass=''>
    <div class="container position-sticky z-index-sticky top-0">
      <div class="row">
        <div class="col-12">
          <!-- Navbar -->
          <nav class="navbar navbar-expand-lg blur border-radius-lg top-0 z-index-3 shadow position-absolute mt-4 py-2 start-0 end-0 mx-4">
              <x-auth.navbars.navs.guest p='ps-2 pe-0' btn='bg-gradient-info' textColor='' svgColor='dark'></x-auth.navbars.navs.guest>
          </nav>
          <!-- End Navbar -->
        </div>
      </div>
    </div>
    <main class="main-content  mt-0">
      <section>
        <div class="page-header min-vh-100">
          <div class="container">
            {{-- <div class="loading" id="loading"> 
              <img src="{{ asset('assets') }}/img/pps-logo.png" style="height: 60px !important; width: 60px !important" alt="img-blur-shadow" class="icons">
            </div> --}}
            <div class="row">
              <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
                <div class="position-relative bg-gray-200 h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center" style="background-image: url('{{ asset('assets') }}/img/illustrations/pps-logo.png'); background-size: cover;"></div>
              </div>
              <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
                <div class="card card-plain">
                  <div class="card-header">
                    <h4 class="font-weight-bolder">Reset password</h4>
                    <p class="mb-0">You will receive an e-mail in maximum 60 seconds</p>
                  </div>
                  <div class="card-body">
                    <form role="form" method="POST" id="send-email-reset-password" enctype="multipart/form-data">
                        @csrf
                        {{-- Start of hidden input --}}
                          <input type="hidden" id="token" value="{{ csrf_token() }}">
                          <input type="hidden" value="{{ url('send-email-reset-password') }}" id="urlSendEmailResetPassword">
                        {{-- End of hidden input --}}
                        <div class="row">
                        <div class="col-lg-12 col-12 col-md-12">
                            <label class="form-label text-bold">Email Address</label>
                            <div class="input-group input-group-outline" style="margin-top: -5px !important">
                              <input type="email" class="form-control" placeholder="Enter email address" name="email_address" id="email_address">
                            </div>
                          </div>
                      </div>
                  
                      <div class="text-center">
                        <button type="submit" class="btn btn-lg bg-gradient-danger btn-lg w-100 mt-4 mb-0">Send</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
    <link href="{{ asset('assets') }}/css/loader.css" rel="stylesheet" />
    @push('js')
    <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
    <script src="{{ asset('assets') }}/js/reset-password.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script>
      
    
    </script>
    
    @endpush
  </x-page-template>