
<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
    <x-auth.navbars.sidebar activePage="events" activeItem="create-event" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <x-auth.navbars.navs.auth pageTitle="Events"></x-auth.navbars.navs.auth>


      <div class="loading" id="loading" style="display: none;"> 
        <img src="{{ asset('assets') }}/img/pps-logo.png" style="height: 60px !important; width: 60px !important" alt="img-blur-shadow" class="icons">
      </div>

      <div class="container-fluid py-4">

        {{-- START OF UPLOAD MODAL --}}
        <div class="modal fade" id="modalUploadCreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalSignTitle" aria-hidden="true">
          <div class="loading" id="loading2" style="display: none;"> 
            <img src="{{ asset('assets') }}/img/pps-logo.png" alt="img-blur-shadow" style="height: 60px !important; width: 60px !important" class="icons">
          </div>
          <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
              <div class="modal-body p-0">
                <div class="card card-plain">
                  <div class="card-header pb-0 text-left">
                      <div class="row">
                          <div class="col-8">
                              <h5 class="">New Event Image</h5>
                          </div>
                          <div class="col-4" style="text-align: right !important">
                              <button type="button" class="btn-close" style="color: black !important" data-bs-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                      </div>
                      
                      <p class="mb-0">Upload new event images.</p>
                      
                  </div>
                  <div class="card-body pb-3">

                  <form method="POST" role="form text-left" id="file-upload" enctype="multipart/form-data">
                    @csrf
                    {{-- Start of hidden input --}}
                      <input type="hidden" value="{{ url('event-upload-image') }}" id="urlEventImageUpload">
                      <input type="hidden" id="token2" name="token2" value="{{ csrf_token() }}">
                     
                    {{-- End of hidden input --}}
                    <label>EVENT BANNER</label>
                      <div class="form-group border border-radius-lg">
                       
                          <input type="file" name="files[]" id="files" accept="image/jpeg, image/png" required multiple accept="image/jpeg, image/png" required>
                      </div>
                      <br>
                      <label>EVENT CERTIFICATE</label>
                      <div class="form-group border border-radius-lg">
                       
                        <input type="file" name="certificate_image" id="certificate_image" accept="image/jpeg, image/png" accept="image/jpeg, image/png">
                      </div>
                      <div class="form-group">
                          <div id="image_preview" style="width:100%;">
                          
                          </div>  
                      </div>
                      <div class="form-group">
                        <div id="certificate_preview" style="width:100%;">
                        
                        </div>
                      </div>


                      <div class="text-center">
                        <button type="submit" class="btn bg-gradient-danger btn-lg btn-rounded w-100 mt-4 mb-3">Upload</button>
                      </div>
                    </form>
                  </div>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
        {{-- END OF UPLOAD MODAL --}}



        {{-- START OF DELETE MODAL --}}
        <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
          <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
            <div class="modal-content">
              <div class="loading" id="loading" style="display: none;"> 
                <img src="{{ asset('assets') }}/img/pps-logo.png" style="height: 60px !important; width: 60px !important" alt="img-blur-shadow" class="icons">
              </div>
              <form method="POST" role="form text-left" id="event-delete-image" enctype="multipart/form-data">
                @csrf
              <div class="modal-header">
                <h6 class="modal-title font-weight-normal" id="modal-title-notification">Your attention is required</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">
                
                <input type="hidden" id="delete_id" name="delete_id">
                <input type="hidden" value="{{ url('event-delete-image') }}" id="urlImageDelete">
                <div class="py-3 text-center">
                  <i class="material-icons h1 text-secondary">
                    notifications_active
                  </i>
                  <h4 class="text-gradient text-danger mt-4">Are you sure</h4>
                  <p>You want to remove this image?</p>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Yes, Remove it</button>
                <button type="button" class="btn btn-link ml-auto" data-bs-dismiss="modal">Cancel</button>
              </div>
              </form>
            </div>
          </div>
        </div>
        {{-- END OF DELETE MODAL --}}


        <form method="POST" role="form" enctype="multipart/form-data"  id="event-create-save">
          @csrf
          {{-- Start of hidden input --}}
          <input type="hidden" id="token" value="{{ csrf_token() }}">
          <input type="hidden" value="{{ url('event-create-save')}}" id="urlEventSave">
          <input type="hidden" value="{{ csrf_token() }}" id="session" name="session">
          {{-- End of hidden input --}}

          <div class="col-lg-12 col-md-12 col-12">
            <div class="row">
              <div class="col-xl-12 col-md-12 col-12 mt-xl-0 mt-4">
                <div class="card">
                  <div class="card-header p-3 pb-2 bg-danger">
                    <h5 class="font-weight-bolder mb-0 text-white">New Event</h5>
                    <p class="mb-0 text-sm text-white">Please fill-up event information below</p>
                  </div>
                  <div class="card-body border-radius-lg p-3">
                    <div class="row">
                      <div class="row mt-3">
                          <div class="col-12 col-md-12 col-xl-12 position-relative">
                              <div class="card card-plain h-100">
                                  <div class="card-header pb-0 p-3">
                                      <h6 class="mb-0 text-danger">Event Details</h6>
                                  </div>
                                  <div class="card-body p-3">
                                    
                                    <div class="row">
                                      <div class="col-12">
                                        <label class="form-label text-bold">Title<code> <b>*</b></code></label>
                                        <div class="input-group input-group-outline" id="titleRow" style="margin-top: -5px !important">
                                          <input type="text" class="form-control" placeholder="Enter Title" name="title" id="event_title">
                                        </div>
                                        <p class="text-danger inputerror mt-0" style="display: none">The name field is required. </p>
                                      </div>
                                    </div>
              
                                    <div class="row mt-2">
                                      <div class="col-12">
                                          <label class="form-label text-bold">Category<code> <b>*</b></code></label>
                                        <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                          <select name="category" id="event_category" class="form-control event_category">
                                              <option value="">-- Select --</option>
                                              @foreach ($eventCategory as $category)
                                                      <option value="{{ $category->id }}">{{ $category->name }}</option>
                                              @endforeach
                                          </select>
                                        </div>
                                      </div>
                                    </div>
              
                                  <div class="row mt-2" id="examination_category_row" style="display: none">
                                    <div class="col-12">
                                        <label class="form-label text-bold">Examination Category<code> <b>*</b></code></label>
                                      <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                        <select name="examination_category" id="event_examination_category" class="form-control event_examination_category">
                                            <option value="">Choose</option>
                                            <option value="Written Examination Only">Written Examination Only</option>
                                            <option value="Oral Examination Only">Oral Examination Only</option>
                                            <option value="Written and Oral Examination">Written and Oral Examination</option>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
              
                                  <div class="row mt-2">
                                    <div class="col-lg-6 col-6">
                                        <label class="form-label text-bold">Date From<code> <b>*</b></code></label>
                                      <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                        <input type="date" class="form-control" id="event_date_from">
                                      </div>
                                    </div>
                                    <div class="col-lg-6 col-6">
                                      <label class="form-label text-bold">Date To<code> <b>*</b></code></label>
                                    <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                      <input type="date" class="form-control" id="event_date_to">
                                    </div>
                                  </div>
                                </div>
              
                                <div class="row mt-2">
                                  <div class="col-6">
                                      <label class="form-label text-bold">Start Time<code> <b>*</b></code></label>
                                    <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                      <input type="time" class="form-control" id="event_start_time">
                                    </div>
                                  </div>
                                  <div class="col-6">
                                      <label class="form-label text-bold">End Time<code> <b>*</b></code></label>
                                    <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                      <input type="time" class="form-control" id="event_end_time">
                                    </div>
                                  </div>
                                </div>
              
                                <div class="row mt-2">
                                  <div class="col-12 col-md-6">
                                      <label class="form-label text-bold">Venue<code> <b>*</b></code></label>
                                    <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                      <input type="text" class="form-control" placeholder="Enter Venue" name="venue" id="event_venue">
                                    </div>
                                  </div>
                                  <div class="col-12 col-md-6">
                                    <label class="form-label text-bold">Maximum CPD Points Earned<code> <b>*</b></code></label>
                                    <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                      <input type="number" step="0.1" class="form-control" placeholder="Enter Maximum CPD Points" name="max_cpd" id="max_cpd">
                                    </div>
                                  </div>
            
                                </div>
                                <div class="row mt-2">
                                  <div class="col-12">
                                      <label class="form-label text-bold">Description</label>
                                    <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                      <textarea name="description" id="event_description" class="form-control"></textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="row mt-2">
                                  <div class="col-12">
                                      <label class="form-label text-bold">For selected participants only?</label>
                                      &nbsp;&nbsp;&nbsp;<div class="form-check form-check-inline">
                                        <input class="form-check-input selected_members" type="radio" name="selected_members" id="true_radio" value="true">
                                        <label class="form-check-label" for="true_radio">YES</label>
                                      </div>
                                      <div class="form-check form-check-inline">
                                        <input class="form-check-input selected_members" type="radio" name="selected_members" id="false_radio" value="false" checked>
                                        <label class="form-check-label" for="false_radio">NO</label>
                                      </div>
                                  </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-9 col-lg-9 col-12" style="text-align: right !important">
                                      
                                    </div>
                                    <div class="col-md-3 col-lg-3 col-12" style="text-align: right !important">
                                      <button class="btn btn-warning w-100" type="button" id="addTopic">Add Another Topic</button>
                                    </div>
                                </div>
              
                                <div class="row item">
                                  <div class="col-lg-4 col-12">
                                    <label class="form-label text-bold">Topic<code> <b>*</b></code></label>
                                    <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                      <input type="text" class="form-control" placeholder="Enter Topic" name="event_topic[]" id="event_topic">
                                    </div>
                                  </div>
                                  <div class="col-lg-2 col-12">
                                    <label class="form-label text-bold">CPD Points(On-site)<code> <b>*</b></code></label>
                                    <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                      <input type="number" step="0.1" class="form-control text-center" placeholder="Enter Points" name="points_onsite[]" id="points_onsite">
                                    </div>
                                  </div>
                                  <div class="col-lg-2 col-12">
                                    <label class="form-label text-bold">CPD Points(Online)<code> <b>*</b></code></label>
                                    <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                      <input type="number" step="0.1" class="form-control text-center" placeholder="Enter Points" name="points_online[]" id="points_online">
                                    </div>
                                  </div>
                                  <div class="col-lg-2 col-12">
                                    <label class="form-label text-bold">Max Topic Attendee</code></label>
                                    <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                      <input type="number" class="form-control text-center" placeholder="Enter Max Attendee" name="event_max_attendee[]" id="event_max_attendee">
                                    </div>
                                  </div>
                                  <div class="col-lg-1 col-12">
                                    <label class="form-label text-bold">Examination</label>
                                    <div class="form-check" style="text-align: center !important">
                                      <input class="form-check-input" type="checkbox" id="with_examination[]" name="with_examination[]">
                                    </div>
                                  </div>
                                </div>
              
                                <div id="items"></div>
                                     
                                  </div>
                              </div>
                            
                          </div>
                          
                         
                      </div>
                    
                    </div>
                    
                   
                    <hr>  
                    <div class="row">
                      <div class="col-12">
                        <div class="bg-success border-radius-lg p-2 my-4 text-white">
                          <div class="row">
                            <div class="col-12">
                              <p class="text-sm font-weight-bold my-auto ps-sm-2">List of exempted from the payment of annual convention. </p>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6 col-lg-6">
                              <ul>
                                <li><p class="text-xs font-weight-bold my-auto ps-sm-2">Emeritus Fellow </p></li>
                                <li><p class="text-xs font-weight-bold my-auto ps-sm-2">Past National Presidents </p></li>
                                <li><p class="text-xs font-weight-bold my-auto ps-sm-2">Incumbent members of the Board of Trustees</p></li>

                                
                              </ul>
                            
                            </div>
                            <div class="col-6 col-lg-6">
                              <ul>
                                <li><p class="text-xs font-weight-bold my-auto ps-sm-2">Incumbent and Past Chapter Presidents</p></li>
                                <li><p class="text-xs font-weight-bold my-auto ps-sm-2">Incumbent Presidents of PPS Subspecialty Societies and PPS Section Heads </p></li>
                              </ul>
                            
                            </div>
                          </div>
                          
                      </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="row mt-3">
                          <div class="col-12 col-md-6 col-xl-6 position-relative">
                              <div class="card card-plain h-100">
                                  <div class="card-header pb-0 p-3">
                                    <div class="row">
                                      <div class="col-md-8 d-flex align-items-center">
                                          <h6 class="mb-0 text-danger">Pricing Scheme</h6>
                                      </div>
                                      <div class="col-md-4 text-end">
                                          <a href="javascript:;">
                                              <i class="fas fa-wallet text-secondary text-sm"
                                                  data-bs-toggle="tooltip" data-bs-placement="top"
                                                  title="Edit Profile"></i>
                                          </a>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="card-body p-3">
                                    <hr class="horizontal gray-light">
                                    <div class="row" style="margin-top: -24px !important">
                                      <div class="col-md-12">
                                        <div class="table-responsive">
                                          <table class="table align-items-center mb-0">
                                            <thead>
                                              <tr>
                                                <th class="text-xs text-bold">MEMBER TYPE</th>
                                                <th class="text-xs text-bold text-center">PRICE</th>
                                              </tr>
                                            </thead>
                                            <tbody> 
                                              @foreach ($member_type as $member_type2) <tr>
                                                <td class="text-secondary">
                                                  <div class="d-flex px-2 py-0">
                                                    <div class="d-flex flex-column justify-content-center">
                                                      @if ($member_type2->member_type_name == "FOREIGN DELEGATE")
                                                        <h5 class="mb-0 text-xs">{{ $member_type2->member_type_name }} (USD $)</h5>
                                                      @else
                                                        <h5 class="mb-0 text-xs">{{ $member_type2->member_type_name }}</h5>
                                                      @endif
                                                     
                                                    </div>
                                                  </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                  <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                                    <input type="hidden" class="form-control text-center" name="member_type_id[]" id="event_member_type" value="{{ $member_type2->id }}">
                                                    <input type="number" class="form-control text-center" placeholder="Enter Amount" name="event_price[]" id="event_price" value="0">
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
                              <hr class="vertical dark">
                          </div>
                          <div class="col-12 col-md-6 col-xl-6 mt-md-0 mt-4 position-relative">
                              <div class="card card-plain h-100">
                                  <div class="card-header pb-0 p-3">
                                      <div class="row">
                                          <div class="col-md-8 d-flex align-items-center">
                                              <h6 class="mb-0 text-danger">Event Organizer</h6>
                                          </div>
                                          <div class="col-md-4 text-end">
                                              <a href="javascript:;">
                                                  <i class="fas fa-user-edit text-secondary text-sm"
                                                      data-bs-toggle="tooltip" data-bs-placement="top"
                                                      title="Edit Profile"></i>
                                              </a>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="card-body" style="overflow-y:auto; overflow-x: hidden; height:auto; max-height:500px;">
                                     {{-- Start of hidden input --}}
                                        <input type="hidden" value="{{ url('event-add-organizer') }}" id="urlAddOrganizer">
                                        <input type="hidden" value="{{ url('event-remove-organizer') }}" id="urlRemoveOrganizer">
                                      {{-- End of hidden input --}}

                                      <div class="row mt-0" style="margin-top: -10px !important">
                                        <div class="col-6">
                                            <label class="form-label text-bold">Organizer<code> <b>*</b></code></label>
                                          <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                            <select name="organizer" id="organizer" class="form-control organizer">
                                                <option value="">-- Select --</option>
                                                @foreach ($member as $member2)  
                                                        <option value="{{ $member2->pps_no }}">{{ $member2->first_name }} {{ $member2->middle_name }} {{ $member2->last_name }}</option>
                                                @endforeach
                                            </select>
                                          </div>
                                        </div>
                                        <div class="col-4">
                                            <label class="form-label text-bold">Type<code> <b>*</b></code></label>
                                          <div class="input-group input-group-outline" style="margin-top: -5px !important">
                                            <select name="organizer_type" id="organizer_type" class="form-control organizer_type">
                                                <option value="">-- Select --</option>
                                                @foreach ($organizer_type as $organizer_type2)
                                                        <option value="{{ $organizer_type2->id }}">{{ $organizer_type2->organizer_type }}</option>
                                                @endforeach
                                            </select>
                                          </div>
                                        </div>
                                        <div class="col-2">
                                          <button class="btn btn-icon btn-2 btn-sm btn-warning" id="addOrganizerBtn" type="button" style="margin-top: 32px !important; font-size: 15px !important">
                                            <span class="btn-inner--icon"><i class="material-icons" style="font-size: 15px !important">add</i></span>
                                          </button>
                                        </div>
                                      </div>  
            
                                      <br>
                                      <div id="selectedOrganizerRow" style="overflow-y:auto; overflow-x: hidden; height:auto;max-height:320px;">

                                        <div class="row mt-2">
                                          <div class="col-8">
                                            <h5 class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Selected Organizer ({{ $organizerCount }})</h5>
                                          </div>
                                          <div class="col-4 text-center">
                                            <h5 class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"></h5>
                                          </div>
                                        </div>

                                        @foreach ($organizer as $organizer2)
                                          <div class="row mt-2">
                                            <div class="col-8">
                                              <h6 class="text-secondary text-sm text-medium"> {{ $loop->iteration }}. {{ $organizer2->first_name }} {{ $organizer2->middle_name }} {{ $organizer2->last_name }} {{ $organizer2->suffix }}</h6>
                                              <p class="text-sm" style="margin-top: -10px !important; margin-left: 15px !important">{{ $organizer2->organizer_type }}</p>
                                            </div>
                                            <div class="col-4 text-center">
                                              <a class="removeOrganizer btn btn-link" style="margin-top: -8px !important; margin-left: 10px !important" data-id="{{ $organizer2->pps_no }}">REMOVE</a>
                                            </div>
                                          </div>
                                          <hr style="margin-top: -10px !important">
                                        @endforeach
                                      </div>
                                  </div>
                              </div>
                          </div>
                         
                      </div>
                     
                    </div>
                      
                  </div>
                </div>
              </div>
            </div>
          </div>

          <br>

          <div class="row">
            <div class="col-xl-12 col-md-12 col-12 mt-xl-0 mt-2">
              <div class="card">
                <div class="card-header p-3 pb-0">
                  <div class="row">
                    <div class="col-6">
                      <h6 class="font-weight-bolder mb-0 text-danger" style="margin-bottom: 10px !important">Event Image's</h6>
                      
                    </div>
                    <div class="col-6" style="text-align: right !important">
                      <button type="button" class="btn bg-gradient-warning " data-bs-toggle="modal" data-bs-target="#modalUploadCreate">
                        Upload Image
                      </button>
                    </div>
                    <hr class="dark horizontal my-0">
                  </div>
                  
                </div>
                <div class="card-body border-radius-lg p-3">
                  <div class="row" id="imageRows">
                    {{-- Start of hidden input --}}
                    <input type="hidden" value="{{ url('event-remove-image') }}" id="urlImageRemove">
                    <input type="hidden" id="token2" name="token2" value="{{ csrf_token() }}">
                    {{-- End of hidden input --}}
                    @foreach ($eventImage as $eventImage2)
                      <div class="col-4" style="margin-top: 10px !important">
                        <h5>{{ $eventImage2->type_of_event_image }}</h5>
                        <div class="img-wrap">
                          <span class="close removeEventImage" id="removeEventImage" data-id="{{ $eventImage2->id }}">&times;</span>
                          <img id="eventimage" class="w-80 min-height-80 max-height-80 border-radius-lg shadow"
                          src="{{Storage::disk('s3')->temporaryUrl('event/' . $eventImage2->file_name, now()->addMinutes(230))}}"
                          
                          itemprop="thumbnail" alt="Image description" />
                        </div>
                       
                      </div>
                    @endforeach
                    
                  </div>
                

                </div>
              </div>
            </div>

          </div>
          <br>
          <div class="row">
            <div class="col-12">
              <button class="btn btn-danger" type="submit">Save Event</button>
              <button class="btn btn-warning" type="button">Cancel</button>
            </div>
          </div>

        </form>


        


        <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
      </div>
    </main>
    <x-plugins></x-plugins>
<link href="{{ asset('assets') }}/css/event.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/css/loader.css" rel="stylesheet" />
<link href="{{ asset('assets') }}/css/event-create-upload-image.css" rel="stylesheet" />


  @push('js')


  <script src="{{ asset('assets') }}/js/plugins/jquery-3.6.0.min.js"></script>
  {{-- <script src="{{ asset('assets') }}/js/event-data-tables.js"></script> --}}
  <script src="{{ asset('assets') }}/js/event.js"></script>
  <script src="{{ asset('assets') }}/js/event-committee.js"></script>
  <script src="{{ asset('assets') }}/js/event-organizer.js"></script>
  {{-- <script src="{{ asset('assets') }}/js/plugins/fullcalendar.min.js"></script> --}}
  <script src="{{ asset('assets') }}/js/select2.min.js"></script>
  <link href="{{ asset('assets') }}/css/select2.min.css" rel="stylesheet" />


  <script src="{{ asset('assets') }}/js/event-create-upload-image.js"></script>
  <script src="{{ asset('assets') }}/js/event-create-certificate-image.js"></script>
  <script src="{{ asset('assets') }}/js/moment.js"></script>
  <script src="{{ asset('assets') }}/js/custom-swal.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/bootstrap-notify.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/sweetalert.min.js"></script>
  <script src="{{ asset('assets') }}/js/plugins/datatables.js"></script>


  <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>

<script>


</script>

  @endpush
  </x-page-template>
  