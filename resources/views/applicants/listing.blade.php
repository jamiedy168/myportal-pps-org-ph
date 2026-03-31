
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="applicants" activeItem="listing" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="Listing"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->
      
      <div class="container-fluid py-4">
        {{-- <div class="loading" id="loading2"> 
            <img src="{{ asset('assets') }}/img/pps-logo.png" style="height: 60px !important; width: 60px !important" alt="img-blur-shadow" class="icons">
        </div> --}}
        {{-- <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header pb-0">
                        <div class="d-lg-flex">
                            <div>
                                <h5 class="mb-0">Applicants</h5>
                                <p class="text-sm mb-0">
                                    List of all applicants.
                                </p>

                           
                            </div>
                          
                        </div>
                    </div>
                    <div class="card-body px-0 pb-0">
                        <div class="table-responsive">
                            <table class="table table-flush" id="products-list">
                                <thead class="thead-light">
                                    <tr>
                                        <th data-sortable="false"></th>
                                        <th class="text-center">Application Date</th>
                                        <th class="text-center">Status</th>
                                        
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($applicantList as $applicantLists )
                                        
                                    
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    <img src="{{URL::asset('/img/profile/'.$applicantLists->picture)}}"
                                                        class="avatar avatar-md me-3" style="height: 60px !important; width: 60px !important" alt="table image">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <a class="mb-0 text-sm" href="applicant-profile/{{ Crypt::encrypt( $applicantLists->pps_no )}}" style="font-weight: bold">{{ $applicantLists->first_name }} {{ $applicantLists->middle_name }} {{ $applicantLists->last_name }} {{ $applicantLists->suffix }}
                                                    </a>
                                                    <p class="text-sm font-weight-normal text-secondary mb-0"><span
                                                        class="text-primary font-weight-bold">PRC NO.:</span>
                                                        {{ $applicantLists->prc_number }}</p>
                                                        <p class="text-sm font-weight-normal text-secondary mb-0"><span
                                                            class="text-primary font-weight-bold">PMA NO.:</span>
                                                            {{ $applicantLists->pma_number }}</p>
                                                    
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-sm font-weight-normal text-secondary mb-0">{{ $applicantLists->created_at->format('M d, Y') }}</p>
                                            <p class="text-sm font-weight-normal text-secondary mb-0">{{ $applicantLists->created_at->format('H:m A') }}</p>
                                        </td>
                                        <td class="text-sm text-center">
                                            <span class="badge badge-danger badge-sm">FOR APPROVAL</span>
                                        </td>
                                        
                                        <td class="text-sm">
                                            <a href="javascript:;" data-bs-toggle="tooltip"
                                                data-bs-original-title="Preview product">
                                                <i
                                                    class="material-icons text-secondary position-relative text-lg">visibility</i>
                                            </a>
                                            <a href="javascript:;" class="mx-3" data-bs-toggle="tooltip"
                                                data-bs-original-title="Edit product">
                                                <i
                                                    class="material-icons text-secondary position-relative text-lg">drive_file_rename_outline</i>
                                            </a>
                                            <a href="javascript:;" data-bs-toggle="tooltip"
                                                data-bs-original-title="Delete product">
                                                <i
                                                    class="material-icons text-secondary position-relative text-lg">delete</i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                



                                   
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Product</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>SKU</th>
                                        <th>Quantity</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
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
                        <h6 class="mb-0">List of all Applicants</h6>
                    </div>
                    <div class="card-body pt-4 p-3">
                        <form class="form-horizontal" action="{{ route('applicant-list-search') }}" method="GET" autocomplete="off">
                            @csrf
                            <div class="row">
                                
                                <div class="col-lg-6 col-12">
                                    <div class="input-group input-group-outline">
                                        <label class="form-label">Search here..</label>
                                        <input type="text" class="form-control" value="{{ $name }}" id="search-input" name="searchinput" style="height: 46px !important">
                                        <button class="btn bg-gradient-danger btn-lg" type="submit" id="searchBtn"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        
                        <br>

                        <div class="row mt-0">
                            <div class="col-12">

                                <div class="table-responsive">
                                    <table class="table table-flush" id="applicant-data-table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th style="text-align: center !important"></th>
                                                <th>Applicant</th>
                                               
                                                <th></th>
                                               
                                   
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($applicantList as $applicantLists )
                                                <tr class="bg-gray-10">
                                                    <td style="text-align: center !important">
                                                        <div class="mt-3">
                                                            <img src="{{ asset('assets') }}/img/default-avatar.png"
                                                            
                                                            class="avatar avatar-md me-4" style="height: 80px !important; width: 80px !important" alt="table image">
                                                            {{-- <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $applicantLists->picture, now()->addMinutes(30))}}"
                                                            
                                                                class="avatar avatar-md me-4" style="height: 80px !important; width: 80px !important" alt="table image"> --}}
                                                        </div>
                     
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column">
                                    
                                                            <a class="mb-2 text-sm text-primary" href="applicant-profile/{{ Crypt::encrypt( $applicantLists->pps_no )}}" style="font-weight: bold">{{ $applicantLists->first_name }} {{ $applicantLists->middle_name }} {{ $applicantLists->last_name }} {{ $applicantLists->suffix }}</a>
                                                          
                                                            <span class="mb-2 text-xs">Email Address: <span
                                                                    class="text-dark ms-sm-2 font-weight-bold">{{ $applicantLists->email_address }}</span></span>
                                                            <span class="mb-2 text-xs">PRC Number: <span
                                                                    class="text-dark ms-sm-2 font-weight-bold">{{ $applicantLists->prc_number }}</span></span>
                                                            <span class="mb-2 text-xs">Date/Time Applied: <span
                                                                class="text-dark font-weight-bold ms-sm-2">{{ Carbon\Carbon::parse($applicantLists->created_at)->format('F d, Y') }}</span></span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="ms-auto text-end">
                                                            <div class="row mt-3">
                                                                <div class="col-sm-12">
                                                                    <a class="btn btn-icon btn-sm btn-success w-100" type="button" href="applicant-profile/{{ Crypt::encrypt( $applicantLists->pps_no )}}">
                                                                        <span class="btn-inner--icon"><i class="material-icons">visibility</i></span>
                                                                      <span class="btn-inner--text">VIEW</span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <button class="btn btn-icon btn-sm btn-danger w-100" type="button" data-bs-target="#modalDisapprove" data-bs-toggle="modal"
                                                                    data-target-first_name="{{ $applicantLists->first_name }}"
                                                                    data-target-last_name="{{ $applicantLists->last_name }}"
                                                                    data-target-pps_no="{{ $applicantLists->pps_no }}"
                                                                    data-target-email_address="{{ $applicantLists->email_address }}">
                                                                        <span class="btn-inner--icon"><i class="material-icons">delete</i></span>
                                                                      <span class="btn-inner--text">DISAPPROVE</span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <input type="hidden" value="{{ url('applicant-delete')}}" id="urlDelete">
                                                                    <button class="btn btn-icon btn-sm btn-danger w-100" type="button" id="{{ $applicantLists->id }}" onClick="deleteApplicant(this.id)">
                                                                        <span class="btn-inner--icon"><i class="material-icons">delete</i></span>
                                                                      <span class="btn-inner--text">DELETE</span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                           
                                                        </div>
                                                    </td>
                                                    
                                                </tr>
                                            @endforeach
                                      
                                        </tbody>
                                 
                                    </table>
                                </div>
                                <br>
                                {{ $applicantList->appends($_GET)->links('vendor.pagination.bootstrap-5') }}
      
                            </div>
                        </div>

                        
                        
                        {{-- @foreach ($applicantList as $applicantLists )
                        <ul class="list-group test" id="myList">
                           
                            <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                <div class="mt-3">
                                  
                                    <img src="{{Storage::disk('s3')->temporaryUrl('applicant/' . $applicantLists->picture, now()->addMinutes(30))}}"
                                    
                                        class="avatar avatar-md me-4" style="height: 80px !important; width: 80px !important" alt="table image">
                                </div>
                                <div class="d-flex flex-column">
                                    
                                    <a class="mb-2 text-sm text-primary" href="applicant-profile/{{ Crypt::encrypt( $applicantLists->pps_no )}}" style="font-weight: bold">{{ $applicantLists->first_name }} {{ $applicantLists->middle_name }} {{ $applicantLists->last_name }} {{ $applicantLists->suffix }}</a>
                                  
                                    <span class="mb-2 text-xs">Email Address: <span
                                            class="text-dark ms-sm-2 font-weight-bold">{{ $applicantLists->email_address }}</span></span>
                                    <span class="mb-2 text-xs">PRC Number: <span
                                            class="text-dark ms-sm-2 font-weight-bold">{{ $applicantLists->prc_number }}</span></span>
                                    <span class="mb-2 text-xs">Date/Time Applied: <span
                                        class="text-dark font-weight-bold ms-sm-2">{{ Carbon\Carbon::parse($applicantLists->created_at)->format('F d, Y') }}</span></span>
                                </div>
                                <div class="ms-auto text-end">
                                    <div class="row mt-3">
                                        <div class="col-sm-12">
                                            <a class="btn btn-icon btn-sm btn-success w-100" type="button" href="applicant-profile/{{ Crypt::encrypt( $applicantLists->pps_no )}}">
                                                <span class="btn-inner--icon"><i class="material-icons">visibility</i></span>
                                              <span class="btn-inner--text">VIEW</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button class="btn btn-icon btn-sm btn-danger w-100" type="button" data-bs-target="#modalDisapprove" data-bs-toggle="modal"
                                            data-target-first_name="{{ $applicantLists->first_name }}"
                                            data-target-last_name="{{ $applicantLists->last_name }}"
                                            data-target-pps_no="{{ $applicantLists->pps_no }}"
                                            data-target-email_address="{{ $applicantLists->email_address }}">
                                                <span class="btn-inner--icon"><i class="material-icons">delete</i></span>
                                              <span class="btn-inner--text">DISAPPROVE</span>
                                            </button>
                                        </div>
                                    </div>
                                   
                                </div>
                               
                            </li>
                           
                          
                        </ul>
                        
                        @endforeach --}}
                      
                        <br>
                    </div>
                </div>
            </div>
           
        </div>

        {{-- START MODAL DISAPPROVE --}}
        <div class="modal fade" id="modalDisapprove" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
            <div class="loading" id="loading" style="display: none;"> 
                <img src="{{ asset('assets') }}/img/pps-logo.png" alt="img-blur-shadow" style="height: 60px !important; width: 60px !important" class="icons">
            </div>
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
              <div class="modal-content">
                <div class="modal-body p-0">
                  <div class="card card-plain">
                    <div class="card-header pb-0 text-left">
                      <h5 class="text-gradient text-danger" id="disapproveText"></h5>
                      <p class="mb-0">Fill up information below.</p>
                    </div>
                    <div class="card-body">
                      <form method="POST" role="form text-left" id="emailUpdateForm" enctype="multipart/form-data" action="{{ url('update-email') }}">
                        @csrf
                        {{-- HIDDEN INPUT --}}
                        <input type="hidden" id="pps_no" name="pps_no">
                        <input type="hidden" id="token" value="{{ csrf_token() }}">
                        <input type="hidden" value="{{ url('applicant-disapprove')}}" id="urlDisapprove">
                        <input type="hidden" id="email_address" name="email_address">
                        <input type="hidden" id="first_name" name="first_name">
                        <input type="hidden" id="last_name" name="last_name">
                        <input type="hidden" id="disapprove_by" name="disapprove_by" value="{{ auth()->user()->name }}">
                      

                        
                                       
                    
                        {{-- END OF HIDDEN INPUT --}}
                        <div class="input-group input-group-outline my-3 is-filled" id="emailRowUpdate">
                          <label class="form-label">Reason</label>
                          <textarea class="form-control" rows="5" id="disapprove_reason"></textarea>
                        
                        </div>
                       
                  
                        <div class="text-center">
                          <button id="disapproveBtn" type="button" class="btn btn-round bg-gradient-danger btn-lg w-100 mt-4 mb-0">Submit</button>
                        </div>
                        <br>
                      </form>
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
          {{-- END MODAL DISAPPROVE --}}
        <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
    </div>
    </main>
    <x-plugins></x-plugins>
    <link href="{{ asset('assets') }}/css/loader.css" rel="stylesheet" />
  @push('js')
  <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('assets') }}/js/applicant-listing.js"></script>
  <script src="{{ asset('assets') }}/js/applicant-data-table.js"></script>
  
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/datatables.js"></script>
  <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>

    <script>

        

        if (document.getElementById('products-list')) {
            const dataTableSearch = new simpleDatatables.DataTable("#products-list", {
                searchable: true,
                fixedHeight: false,
                perPage: 5
            });

            document.querySelectorAll(".export").forEach(function (el) {
                el.addEventListener("click", function (e) {
                    var type = el.dataset.type;

                    var data = {
                        type: type,
                        filename: "material-" + type,
                    };

                    if (type === "csv") {
                        data.columnDelimiter = "|";
                    }

                    dataTableSearch.export(data);
                });
            });
        };


      if (document.getElementById('choices-country')) {
        var country = document.getElementById('choices-country');
        const example = new Choices(country);
      }
  
      var openFile = function(event) {
        var input = event.target;
  
        // Instantiate FileReader
        var reader = new FileReader();
        reader.onload = function() {
          imageFile = reader.result;
  
          document.getElementById("imageChange").innerHTML = '<img width="200" src="' + imageFile + '" class="rounded-circle w-100 shadow" />';
        };
        reader.readAsDataURL(input.files[0]);
      };
    </script>
    @endpush
  </x-page-template>
  