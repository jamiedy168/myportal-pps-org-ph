
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="maintenance" activeItem="email-maintenance" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="Email Maintenance"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->
      <div class="container-fluid py-4">
        <div class="row mt-2">
            <div class="col-lg-12 col-12">
                @if (Session::has('status'))
                <div class="alert alert-success alert-dismissible text-white mx-4" role="alert">
                    <span class="text-sm">{{ Session::get('status') }}</span>
                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-lg-12 col-12">
                <div class="card">
                    <div class="card-header pb-0 px-3">
                        <h6 class="mb-0">EMAIL</h6>
                    </div>
                    <div class="card-body pt-4 p-3">
                      <input type="hidden" id="token" value="{{ csrf_token() }}">
                        <div class="row text-right">
                            <div class="col-lg-12 col-12">
                              <button class="btn btn-icon btn-3 btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modal-form">
                                <span class="btn-inner--icon"><i class="material-icons">add</i></span>
                                <span class="btn-inner--text">New Email</span>
                              </button>
                            </div>
                        </div>


                       {{-- START MODAL ADD --}}
                        <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                            <div class="modal-content">
                              <div class="modal-body p-0">
                                <div class="card card-plain">
                                  <div class="card-header pb-0 text-left">
                                    <h5 class="">New Email</h5>
                                    <p class="mb-0">Fill up information below.</p>
                                  </div>
                                  <div class="card-body">
                                    <form method="POST" role="form text-left" id="emailSaveForm" enctype="multipart/form-data" action="{{ url('save-email') }}">
                                      @csrf
                                      <div class="input-group input-group-outline my-3" id="emailRow">
                                        <label class="form-label">Email Address</label>
                                        <input type="email" name="pps_email" id="pps_email" class="form-control" >
                                       
                                      </div>
                                      <div class="row" id="codeInvalid" style="display: none; margin-top: -13px !important">
                                        <div class="col-12 col-lg-6">
                                          <label for="" style="font-size: 10px !important; color: red">Invalid Email Address !</label>
                                        </div>
                                      </div>

                                      <div class="row" id="existRow" style="display: none; margin-top: -13px !important">
                                        <div class="col-12 col-lg-6">
                                          <label for="" style="font-size: 10px !important; color: red">Existing Email Address !</label>
                                        </div>
                                      </div>

                                      {{-- <code id="codeInvalid" style="display: none;">Invalid Email Address</code> --}}
                                      
                                      <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="status" id="customRadio1" value="PRIMARY" checked>
                                        <label class="custom-control-label" for="customRadio1">Primary email address</label>
                                      </div>
                                      <div class="form-check" style="margin-top: -10px">
                                        <input class="form-check-input" type="radio" name="status" id="customRadio2" value="SECONDARY">
                                        <label class="custom-control-label" for="customRadio2">Secondary email address</label>
                                      </div>
                                      <div class="text-center">
                                        <button id="saveEmail" type="button" class="btn btn-round bg-gradient-primary btn-lg w-100 mt-4 mb-0">Save</button>
                                      </div>
                                      <br>
                                    </form>
                                  </div>
                                  
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        {{-- END MODAL ADD --}}

                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                              <thead>
                                <tr>
                                  <th></th>
                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                                  <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2"></th>
                                  <th></th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($emailList as $emailList2)
                                    
                                <tr>
                                    
                                    <td class="mb-0 text-md" style="width: 2%">{{ $loop->iteration }}</td>
                                  <td>
                                    <div class="d-flex px-2 py-1">
                                      <div class="d-flex flex-column justify-content-center">
                                        <h5 class="mb-0 text-sm">{{ $emailList2->pps_email }}</h5>
                                       
                                      </div>
                                    </div>
                                  </td>
                                  <td class="align-middle text-center text-sm">
                                    @if ($emailList2->status == 'PRIMARY')
                                    <span class="badge badge-sm badge-info">PRIMARY</span>&nbsp;<span class="badge badge-sm badge-success">CURRENT USE</span>
                                    @else
                                    <span class="badge badge-sm badge-danger">SECONDARY</span>
                                    @endif
                                    
                                  </td>

                                  <td>
                                    <div class="d-flex">
                                        <button data-bs-toggle="modal" data-bs-target="#modalUpdate" class="btn btn-link btn-icon-only btn-rounded btn-md text-dark icon-move-right my-auto"
                                        data-target-id="{{ $emailList2->id }}"
                                        data-target-email-update="{{ $emailList2->pps_email }}"
                                        data-target-email-status="{{ $emailList2->status }}">
                                            <i class="material-icons text-primary">
                                                edit
                                              </i>
                                        </button>
                                        <button data-bs-toggle="modal" data-bs-target="#modalDelete" class="btn btn-link btn-icon-only btn-rounded btn-md text-dark icon-move-right my-auto"
                                        data-target-id="{{ $emailList2->id }}">
                                          <i class="material-icons text-primary">
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
                          <br>
                          {{ $emailList->appends($_GET)->links('vendor.pagination.bootstrap-5') }}


                          {{-- START MODAL UPDATE --}}
                          <div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                              <div class="modal-content">
                                <div class="modal-body p-0">
                                  <div class="card card-plain">
                                    <div class="card-header pb-0 text-left">
                                      <h5 class="">Update Email</h5>
                                      <p class="mb-0">Fill up information below.</p>
                                    </div>
                                    <div class="card-body">
                                      <form method="POST" role="form text-left" id="emailUpdateForm" enctype="multipart/form-data" action="{{ url('update-email') }}">
                                        @csrf
                                        {{-- HIDDEN INPUT --}}
                                        <input type="hidden" id="email_id" name="email_id">
                                        <input type="hidden" name="pps_email_update_2" id="pps_email_update_2" class="form-control">
                                        {{-- END OF HIDDEN INPUT --}}
                                        <div class="input-group input-group-outline my-3 is-filled" id="emailRowUpdate">
                                          <label class="form-label">Email Address</label>
                                          <input value="" type="email" name="pps_email_update" id="pps_email_update" class="form-control test">
                                        
                                        </div>
                                        <div class="row" id="codeInvalidUpdate" style="display: none; margin-top: -13px !important">
                                          <div class="col-12 col-lg-6">
                                            <label for="" style="font-size: 10px !important; color: red">Invalid Email Address !</label>
                                          </div>
                                        </div>
  
                                        <div class="row" id="existRowUpdate" style="display: none; margin-top: -13px !important">
                                          <div class="col-12 col-lg-6">
                                            <label for="" style="font-size: 10px !important; color: red">Existing Email Address !</label>
                                          </div>
                                        </div>
                                        <div class="form-check mb-3">
                                          <input class="form-check-input test" type="radio" name="status_update" id="status_update1" value="PRIMARY">
                                          <label class="custom-control-label" for="customRadio1">Primary email address</label>
                                        </div>
                                        <div class="form-check">
                                          <input class="form-check-input test" type="radio" name="status_update" id="status_update2" value="SECONDARY">
                                          <label class="custom-control-label" for="customRadio2">Secondary email address</label>
                                        </div>
                                        <div class="text-center">
                                          <button id="updateEmail" type="button" class="btn btn-round bg-gradient-primary btn-lg w-100 mt-4 mb-0">Update</button>
                                        </div>
                                        <br>
                                      </form>
                                    </div>
                                    
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          {{-- END MODAL UPDATE --}}


                          {{-- START OF DELETE MODAL --}}
                          <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
                            <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                              <div class="modal-content">
                                <form method="POST" role="form text-left" id="emailUpdateForm" enctype="multipart/form-data" action="{{ url('delete-email') }}">
                                  @csrf
                                <div class="modal-header">
                                  <h6 class="modal-title font-weight-normal" id="modal-title-notification">Your attention is required</h6>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  
                                  <input type="hidden" id="delete_id" name="delete_id">
                                  <div class="py-3 text-center">
                                    <i class="material-icons h1 text-secondary">
                                      notifications_active
                                    </i>
                                    <h4 class="text-gradient text-danger mt-4">Are you sure</h4>
                                    <p>You want to delete this email address?</p>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-primary">Yes, Delete it</button>
                                  <button type="button" class="btn btn-link ml-auto" data-bs-dismiss="modal">Cancel</button>
                                </div>
                                </form>
                              </div>
                            </div>
                          </div>
                          {{-- END OF DELETE MODAL --}}
                    </div>
                   
                </div>
            </div>
           
        </div>
        <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
    </div>
    </main>
    <x-plugins></x-plugins>
  @push('js')

  <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('assets') }}/js/maintenance.js"></script>
  <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/datatables.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/choices.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
    
    <script>
      $(document).ready(function() {
        
            var token = $("#token").val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });


            $('#saveEmail').click(function() {
                $value = $( "#pps_email" ).val();
                var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

                
                $.ajax({
                    type : 'get',
                    url: "{{ url('check-email-exist')}}",
                    data : {'pps_email':$value},
                    success:function(data){

                       

                        if(data >= 1)
                        {
                          // $('#saveEmail').prop('disabled', true);
                          $( "#emailRow" ).addClass( "is-invalid" );
                          $( "#emailRow" ).removeClass( "is-valid" );
                          $( "#existRow" ).show();
                          $( "#codeInvalid" ).hide();
                          
                       
                           
                        }
                        else
                        {   
                     
                          if (reg.test(pps_email.value) == false) 
                          {
                              $( "#existRow" ).hide();
                              $( "#emailRow" ).addClass( "is-invalid" );
                              $( "#emailRow" ).removeClass( "is-valid" );
                              $( "#codeInvalid" ).show();
                              
                              
                              // $( "#emailRow" ).removeClass( "is-valid" );
                        
                              return false;
                          }
                          else
                          { 
                              $( "#existRow" ).hide();
                              $( "#emailRow" ).addClass( "is-valid" );
                              $( "#emailRow" ).removeClass( "is-invalid" );
                              $( "#codeInvalid" ).hide();

                              notif.showSwal('custom-html2');
                              
                            
                          }
                        }
                        
                    }
                });
            });


            $('#updateEmail').click(function() {
                $value = $( "#pps_email_update" ).val();
                $value2 = $( "#pps_email_update_2" ).val();
                var reg2 = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

                
                $.ajax({
                    type : 'get',
                    url: "{{ url('check-email-exist')}}",
                    data : {'pps_email':$value},
                    success:function(data){

                 if($value == $value2)
                 {
                  notif.showSwal('custom-html3');
                 }

                 else
                 {
                  if(data >= 1)
                        {
                          $( "#emailRowUpdate" ).addClass( "is-invalid" );
                          $( "#emailRowUpdate" ).removeClass( "is-valid" );
                          $( "#existRowUpdate" ).show();
                          $( "#codeInvalidUpdate" ).hide();
                        }
                        else
                        {   
                     
                          if (reg2.test(pps_email_update.value) == false) 
                          {
                              $( "#existRowUpdate" ).hide();
                              $( "#emailRowUpdate" ).addClass( "is-invalid" );
                              $( "#emailRowUpdate" ).removeClass( "is-valid" );
                              $( "#codeInvalidUpdate" ).show();
                        
                              return false;
                          }
                          else
                          { 
                              $( "#existRowUpdate" ).hide();
                              $( "#emailRowUpdate" ).addClass( "is-valid" );
                              $( "#emailRowUpdate" ).removeClass( "is-invalid" );
                              $( "#codeInvalidUpdate" ).hide();

                              notif.showSwal('custom-html3');
                              
                            
                          }
                        }
                 }

                       
                        
                    }
                });
            });
           
        });
    </script>
    @endpush
  </x-page-template>
  