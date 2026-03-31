
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="ICD" activeItem="admin-new-code" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="New ICD Code"></x-auth.navbars.navs.auth>
      <!-- End Navbar -->
      <div class="container-fluid py-4">
      

        <div class="card card-body mx-3 mx-md-4 ">

             {{-- Start of hidden input --}}
             <input type="hidden" value="{{ url('icd-admin-add-code') }}" id="urlICDAdminAddCode">
             <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">
     
             
             {{-- End of hidden input --}}
            
            <div class="row mt-4">
                <div class="col-12">
                    <div class="mb-3 ps-3">
                        <h6 class="mb-1">New ICD Code</h6>
                        <p class="text-sm">List of new ICD code.</p>
                    </div>

                    
                    <br>    

                    <div class="row my-1">
                        <div class="col-12">
                        
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            
                                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">ICD Code</th>
                                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">Type
                                            </th>
                                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">Uploaded By
                                            </th>
                                            <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($icdtemp as $icdtemp2)    
                                        <tr>
                                            <td>
                                                <p class="mb-0 font-weight-bold text-sm"> {{ ($icdtemp->currentPage() - 1) * $icdtemp->perPage() + $loop->index + 1 }}. {{ $icdtemp2->description }}</p>
                                            </td>
                                            <td>
                                                <span class="badge badge-sm bg-gradient-success">NEW</span>
                                            </td>
                                            <td>
                                                <p class="mb-0 font-weight-normal text-sm">{{ $icdtemp2->created_by }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <button class="btn btn-danger btn-sm mt-1 add_list" data-id="{{ $icdtemp2->id }}" data-description="{{ $icdtemp2->description }}">Add to List</button>
                                            </td>
                                            
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            {{ $icdtemp->appends($_GET)->links('vendor.pagination.bootstrap-5') }}
                           
                        </div>
                    </div>
                    <br>
                

               


                
                </div>
            </div>
            
        </div>
      
      </div>
      <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
    </main>
    <x-plugins></x-plugins>
    <link href="{{ asset('assets') }}/css/loader.css" rel="stylesheet" />
  @push('js')
  <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>  
  <script src="{{ asset('assets') }}/js/icd-admin.js"></script>



    @endpush
  </x-page-template>
  