function btnEventPaymentCloseBtn()
{
    Swal.fire({
      title: "Warning!",
      text: "Payments cannot be processed yet. Payments will be available starting December 16, 2025.",
      icon: "warning",
      confirmButtonText: "Okay"
    })
}

function virtualClose()
{
  Swal.fire({
    title: "Notice",
    text: "The virtual session for this event hasn’t started yet. Please check back soon.",
    icon: "warning",
    confirmButtonText: "Okay"
  })
}



$(document).on('click', '#youtube_url_button', function () {
  if($("#youtube_url").val() == '')
  {
    notif.showNotification('top', 'right', 'Warning, please fill-up youtube live url !', 'warning');
    $("#youtube_url").focus();
  }
  else
  {
    var event_id = $("#event_id").val();
    var url = $( "#urlEventYoutubeLiveUrl" ).val();
    var token = $( "#token" ).val();
    var youtube_url = $( "#youtube_url" ).val();
  
    
    Swal.fire({
      customClass: {
        confirmButton: "btn bg-gradient-success",
        cancelButton: "btn bg-gradient-danger"
    },
    buttonsStyling: !1,
    
    title: "Are you sure?",
    text: "You want to add youtube live url?",
    icon: "warning",
    showCancelButton: true,
    showCancelButton: !0,
    confirmButtonText: "Yes, proceed!",
    }).then((result) => {
        if (result.isConfirmed) {
  
          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
          });
  
          $.ajax({
            type: 'get',
            url: url,
            data: { 'event_id' : event_id,
                    'youtube_url' : youtube_url
         },
           
            success: (data) => {

              $("#youtube_live_url_row").load(window.location.href + " #youtube_live_url_row");
                Swal.fire({
                  title: "Success!",
                  text: "Youtube live URL successfully added.",
                  icon: "success",
                  confirmButtonText: "Okay"
                })
              },
              error: function(data) {
                  Swal.fire({
                    title: "Warning!",
                    text: "Something went wrong",
                    icon: "warning",
                    confirmButtonText: "Okay"
                  })
              }
          });
          
  
          }
      });
  }
  
});

$(document).on('click', '#questionnaire_link_button', function () {
  if($("#questionnaire_link").val() == '')
    {
      notif.showNotification('top', 'right', 'Warning, please fill-up qustionnaire link !', 'warning');
      $("#questionnaire_link").focus();
    }
    else
    {
      var event_id = $("#event_id").val();
      var url = $( "#urlEventQuestionnaireLinkUrl" ).val();
      var token = $( "#token" ).val();
      var questionnaire_link = $( "#questionnaire_link" ).val();

      Swal.fire({
        customClass: {
          confirmButton: "btn bg-gradient-success",
          cancelButton: "btn bg-gradient-danger"
      },
      buttonsStyling: !1,
      
      title: "Are you sure?",
      text: "You want to add this questionnaire link?",
      icon: "warning",
      showCancelButton: true,
      showCancelButton: !0,
      confirmButtonText: "Yes, proceed!",
      }).then((result) => {
        if (result.isConfirmed) {
  

          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
          });
  
          $.ajax({
            type: 'get',
            url: url,
            data: { 'event_id' : event_id,
                    'questionnaire_link' : questionnaire_link
         },
           
            success: (data) => {

              $("#questionnaire_row").load(window.location.href + " #questionnaire_row");
                Swal.fire({
                  title: "Success!",
                  text: "Questionnaire link successfully added.",
                  icon: "success",
                  confirmButtonText: "Okay"
                })
              },
              error: function(data) {
                  Swal.fire({
                    title: "Warning!",
                    text: "Something went wrong",
                    icon: "warning",
                    confirmButtonText: "Okay"
                  })
              }
          });
          
  
          }
      });
    }

});

$(document).on('click', '#survey_link_button', function () {

  if($("#survey_link").val() == '')
    {
      notif.showNotification('top', 'right', 'Warning, please fill-up survey link !', 'warning');
      $("#survey_link").focus();
    }
  else
    {
      var event_id = $("#event_id").val();
      var url = $( "#urlEventSurveyLinkUrl" ).val();
      var token = $( "#token" ).val();
      var survey_link = $( "#survey_link" ).val();
    
      Swal.fire({
        customClass: {
          confirmButton: "btn bg-gradient-success",
          cancelButton: "btn bg-gradient-danger"
      },
      buttonsStyling: !1,
      
      title: "Are you sure?",
      text: "You want to add this survey link?",
      icon: "warning",
      showCancelButton: true,
      showCancelButton: !0,
      confirmButtonText: "Yes, proceed!",
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
          });
        
          $.ajax({
            type: 'get',
            url: url,
            data: { 'event_id' : event_id,
                    'survey_link' : survey_link
         },
           
            success: (data) => {
                $("#survey_row").load(window.location.href + " #survey_row");
                Swal.fire({
                  title: "Success!",
                  text: "Survey link successfully added.",
                  icon: "success",
                  confirmButtonText: "Okay"
                })
              },
              error: function(data) {
                  Swal.fire({
                    title: "Warning!",
                    text: "Something went wrong",
                    icon: "warning",
                    confirmButtonText: "Okay"
                  })
              }
          });
        }
      })
    }
    

});


$(document).on('click', '#survey_link_date_time_button', function () {

  if($("#survey_link_date_time").val() == '')
    {
      notif.showNotification('top', 'right', 'Warning, please fill-up survey link date and time!', 'warning');
      $("#survey_link_date_time").focus();
    }

  else
    {
      var event_id = $("#event_id").val();
      var url = $( "#urlEventSurveyLinkDateTimeUrl" ).val();
      var token = $( "#token" ).val();
      var survey_link_date_time = $( "#survey_link_date_time" ).val();
    
      Swal.fire({
        customClass: {
          confirmButton: "btn bg-gradient-success",
          cancelButton: "btn bg-gradient-danger"
      },
      buttonsStyling: !1,
      
      title: "Are you sure?",
      text: "You want to save this survey link date and time?",
      icon: "warning",
      showCancelButton: true,
      showCancelButton: !0,
      confirmButtonText: "Yes, proceed!",
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
          });
        
          $.ajax({
            type: 'get',
            url: url,
            data: { 'event_id' : event_id,
                    'survey_link_date_time' : survey_link_date_time
         },
           
            success: (data) => {
                $("#survey_date_time_row").load(window.location.href + " #survey_date_time_row");
                Swal.fire({
                  title: "Success!",
                  text: "Survey link date and time successfully added.",
                  icon: "success",
                  confirmButtonText: "Okay"
                })
              },
              error: function(data) {
                  Swal.fire({
                    title: "Warning!",
                    text: "Something went wrong",
                    icon: "warning",
                    confirmButtonText: "Okay"
                  })
              }
          });
        }
      })
    }

});

function unpaid()
{
  Swal.fire({
    title: "Warning!",
    text: "You need to pay for this event before taking this examination.",
    icon: "warning",
    confirmButtonText: "Okay"
  })
}

function eventCompleted()
{
  Swal.fire({
    title: "Warning!",
    text: "You cannot select this event. It is currently closed.",
    icon: "warning",
    confirmButtonText: "Okay"
  })
}


$(document).on('click', '.removeEventImage', function () {
  $("#loading").fadeIn();
  var id = $(this).attr('data-id');
  var url = $( "#urlImageRemove" ).val();
  var token2 = $( "#token2" ).val();

  
  Swal.fire({
    customClass: {
      confirmButton: "btn bg-gradient-success",
      cancelButton: "btn bg-gradient-danger"
  },
  buttonsStyling: !1,
  
  title: "Are you sure?",
  text: "You want to remove this image?",
  icon: "warning",
  showCancelButton: true,
  showCancelButton: !0,
  confirmButtonText: "Yes, proceed!",
  }).then((result) => {
      if (result.isConfirmed) {

        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': token2
          }
        });

        $.ajax({
          type: 'get',
          url: url,
          data: { 'id' : id,
       },
         
          success: (data) => {
            $("#imageRows").load(window.location.href + " #imageRows");
            $("#loading").fadeOut();
              Swal.fire({
                title: "Removed!",
                text: "Image successfully removed.",
                icon: "success",
                confirmButtonText: "Okay"
              })
            },
            error: function(data) {
              $("#loading").fadeOut();
                Swal.fire({
                  title: "Warning!",
                  text: "Something error",
                  icon: "error",
                  confirmButtonText: "Okay"
                })
            }
        });
        
 
       
        }
    });

});


$('#event-create-save').submit(function(e) {
  e.preventDefault();

  var category = $("#event_category option:selected").text();

    if(category == 'EXAMINATION' && $("#event_examination_category").val() == "")
    {
      notif.showNotification('top', 'right', 'Warning, please fill-up examination category !', 'warning');
      $("#event_examination_category").focus();
    }

    else if($("#event_date_to").val() < $("#event_date_from").val())
    {
        notif.showNotification('top', 'right', 'Warning, end time should not be lower than start time !', 'warning');
        $("#event_date_from").focus();
    }

    else if($("#event_title").val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up event title!', 'warning');
        $("#event_title").focus();
    }

    else if($("#event_category").val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up event category !', 'warning');
        $("#event_category").focus();
    }
    else if($("#event_date_from").val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up event date from !', 'warning');
        $("#event_date_from").focus();
    }
    else if($("#event_date_to").val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up event date to !', 'warning');
        $("#event_date_to").focus();
    }
    else if($("#event_start_time").val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up event start time !', 'warning');
        $("#event_start_time").focus();
    }
    else if($("#event_end_time").val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up event end time !', 'warning');
        $("#event_end_time").focus();
    }
    else if($("#event_venue").val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up event venue !', 'warning');
        $("#event_venue").focus();
    }
    else if($("#max_cpd").val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up event maximum cpd points !', 'warning');
        $("#max_cpd").focus();
    }
    else if($("#event_description").val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up event description !', 'warning');
        $("#event_description").focus();
    }
    else if($("#event_topic").val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up event topic !', 'warning');
        $("#event_topic").focus();
    }



    


    else
    {
          Swal.fire({
            customClass: {
              confirmButton: "btn bg-gradient-success",
              cancelButton: "btn bg-gradient-danger"
          },
          buttonsStyling: !1,
          
          title: "Are you sure?",
          text: "You want to save this event?",
          icon: "warning",
          showCancelButton: true,
          showCancelButton: !0,
          confirmButtonText: "Yes, proceed!",
      }).then((result) => {
        if (result.isConfirmed) {
          $("#loading").fadeIn();
            var url = $( "#urlEventSave" ).val();
            var token = $( "#token" ).val();
            
      
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': token
              }
          });


          
          var formData = new FormData(this);

          $('input[name="event_topic"]').each(function(){
            formData.append('event_topic', $(this).val());
          });

          $('input[name="points_onsite"]').each(function(){
            formData.append('points_onsite', $(this).val());
          });

          $('input[name="points_online"]').each(function(){
            formData.append('points_online', $(this).val());
          });

          $('input[name="with_examination[]"]').each(function() {
            if ($(this).is(':checked')) {
              formData.append('with_examination[]', '1'); 
            } else {
              formData.append('with_examination[]', '0'); 
            }
          });
          

          $('input[name="member_type_id"]').each(function(){
            formData.append('member_type_id', $(this).val());
          });

          $('input[name="event_price"]').each(function(){
            formData.append('event_price', $(this).val());
          });

          $('input[name="event_max_attendee"]').each(function(){
            formData.append('event_max_attendee', $(this).val());
          });

          
          formData.append('event_title',$( "#event_title" ).val());
          formData.append('event_category',$( "#event_category" ).val());
          formData.append('event_examination_category',$( "#event_examination_category" ).val());
          formData.append('event_date_from',$( "#event_date_from" ).val());
          formData.append('event_date_to',$( "#event_date_to" ).val());
          formData.append('event_start_time',$( "#event_start_time" ).val());
          formData.append('event_end_time',$( "#event_end_time" ).val());
          formData.append('event_venue',$( "#event_venue" ).val());
          formData.append('max_cpd',$( "#max_cpd" ).val());
          formData.append('event_description',$( "#event_description" ).val());
          formData.append('session',$( "#session" ).val());
          formData.append('selected_members',$(".selected_members:checked").val());
          formData.append('selected_members',$('input[name="selected_members"]:checked').val());

          $.ajax({
              type: 'post',
              url: url,
              data: formData,
              cache: false,
              contentType: false,
              processData: false,
              success: (data) => {
                $("#loading").fadeOut();

                Swal.fire({
                    title: "Saved!",
                    text: "Event successfully created.",
                    icon: "success",
                    confirmButtonText: "Okay"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location=data.url;
                        
                    }
                    else{
                        window.location=data.url;
                    }
                });
          
              },
              error: function(data) {
                $("#loading").fadeOut();
                Swal.fire({
                    title: "Warning!",
                    text: "Event not save!",
                    icon: "error",
                    confirmButtonText: "Okay"
                })
              }
          });
          


          
          }
      });
    }

});




$(document).ready(function() {

  let template = `
    <div class="row mt-2 item" style="margin-bottom: 10px;">
      <div class="col-lg-4 col-12">
        <label class="form-label text-bold">Topic<code><b>*</b></code></label>
        <div class="input-group input-group-outline" style="margin-top: -5px !important">
          <input type="text" class="form-control" placeholder="Enter Topic" name="event_topic[]" id="event_topic">
        </div>
      </div>
      <div class="col-lg-2 col-12">
        <label class="form-label text-bold">CPD Points(On-site)<code><b>*</b></code></label>
        <div class="input-group input-group-outline" style="margin-top: -5px !important">
          <input type="number" step="0.1" class="form-control text-center" placeholder="Enter Points" name="points_onsite[]" id="points_onsite">
        </div>
      </div>
      <div class="col-lg-2 col-12">
        <label class="form-label text-bold">CPD Points(Online)<code><b>*</b></code></label>
        <div class="input-group input-group-outline" style="margin-top: -5px !important">
          <input type="number" step="0.1" class="form-control text-center" placeholder="Enter Points" name="points_online[]" id="points_online">
        </div>
      </div>
      <div class="col-lg-2 col-12">
        <label class="form-label text-bold">Max Topic Attendee<code><b>*</b></code></label>
        <div class="input-group input-group-outline" style="margin-top: -5px !important">
          <input type="number" class="form-control text-center" placeholder="Enter Max Attendee" name="event_max_attendee[]" id="event_max_attendee">
        </div>
      </div>
      <div class="col-lg-1 col-12">
        <label class="form-label text-bold">Examination</label>
        <div class="form-check" style="text-align: center !important">
          <input class="form-check-input" type="checkbox" name="with_examination[]" id="with_examination[]">
        </div>
      </div>
      <div class="col-lg-1 col-12 text-center">
        <button class="btn btn-icon btn-danger removeTopic" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove" style="margin-top: 30px !important">
          <i class="material-icons">close</i>
        </button>
      </div>
    </div>
  `;
  // Append the template when the "Add Topic" button is clicked
  $("#addTopic").on("click", () => {
    $("#items").append(template);
  });

  // Remove the row when the "Remove" button is clicked
  $("body").on("click", ".removeTopic", function() {
    $(this).closest(".item").remove();
  });

  $('input[type=checkbox]').change(function() {
    if ($(this).is(':checked')) {
      $('#event_price').val(0);
       
    } else {
      $('#event_price').val(null);
    }
});



  $('.btnStatus').on('click', function(){

    const cards = document.querySelectorAll('.cardEvent');
    for(card of cards){
      
      const cardCategory = card.getAttribute('category');
      const categoryOne = this.getAttribute('category-one');
      const categoryTwo = this.getAttribute('category-two');
      
      if(cardCategory ===  categoryOne || cardCategory ===  categoryTwo || categoryOne === 'all'){
        card.style.display = 'block';
      } else{
        card.style.display = 'none';
      }
    }
  });

  
  $('#btnEventJoin').on('click', function(){

    var event_id = $( "#event_id" ).val();
    var price = $( "#price" ).val();
    var pps_no = $( "#pps_no" ).val();
    var role_id = $( "#role_id" ).val();



    if(role_id == 1 || role_id == 4)
      {
        Swal.fire({
          title: "Warning!",
          text: "Admin cannot join on the event",
          icon: "warning",
          confirmButtonText: "Okay"
        })
      }
      else
      {
        Swal.fire({
          customClass: {
            confirmButton: "btn bg-gradient-success",
            cancelButton: "btn bg-gradient-danger"
        },
        buttonsStyling: !1,
        
        title: "Are you sure?",
        text: "Do you want to join this event?",
        icon: "warning",
        showCancelButton: true,
        showCancelButton: !0,
        confirmButtonText: "Yes, proceed!",
        }).then((result) => {
          if (result.isConfirmed) {
              var token2 = $("#token2").val();
              var url = $( "#urlEventCheckJoined" ).val();

              $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': token2
                  }
              });
              $.ajax({
                  type : 'get',
                  url: url,
                  data : { 'pps_no' : pps_no,
                          'event_id' : event_id,
                          'price' : price,
                      },
                  success:function(data){
                    $("#loading3").fadeOut();
                    if(data.action == "annualduespending")
                    {
                      
                      Swal.fire({
                        title: "Warning!",
                        text: "Kindly settle your pending annual dues to proceed with the event.",
                        icon: "error",
                        confirmButtonText: "Okay"
                      }).then((result) => {

                        window.location.href = '/payment-listing'

                      });

                    }
                    else if(data.action == "notselected")
                        {
                          Swal.fire({
                            title: "Warning!",
                            text: "Unable to join, this event is limited to selected participants only",
                            icon: "error",
                            confirmButtonText: "Okay"
                          })

                        }
                    else if(data.action == "organizer")
                    {
                
                      Swal.fire({
                        title: "Warning!",
                        text: "You have been selected as one of organizing committee of this event. This event is free for all the committee",
                        icon: "warning",
                        confirmButtonText: "Okay"
                      })
                    }
                    else if(data.action == "exist")
                    {
                    
                      Swal.fire({
                        title: "Warning!",
                        text: "You already joined on this event.",
                        icon: "warning",
                        confirmButtonText: "Okay"
                      })
                    } 
                    else if(data.action == "free")
                    {
                          Swal.fire({
                          title: "Success!",
                          text: "Member successfully joined on this event!",
                          icon: "success",
                          confirmButtonText: "Okay"
                        }).then((result) => {
                          if (result.isConfirmed) 
                          {
                            location.reload();
                          }
                          else
                          {
                            location.reload();
                          }
                      
                        });
                    }
                    else
                    {
                    
                      window.location=data.url;
                     
                    }
    
                  }
                });
          }
      });
      }  


    // if($("#event_status_validation").val() == "COMPLETED")
    // {
    //   notif.showNotification('top', 'right', 'Warning, unable to join, event already completed!', 'warning');
    // }
    // else{
    //   Swal.fire({
    //     customClass: {
    //       confirmButton: "btn bg-gradient-success",
    //       cancelButton: "btn bg-gradient-danger"
    //   },
    //   buttonsStyling: !1,
      
    //   title: "Are you sure?",
    //   text: "You want to join on this event?",
    //   icon: "warning",
    //   showCancelButton: true,
    //   showCancelButton: !0,
    //   confirmButtonText: "Yes, proceed!",
    //   }).then((result) => {
    //       if (result.isConfirmed) {
    //         $("#loading3").fadeIn();
    //         var token2 = $("#token2").val();
    //         var url = $( "#urlEventCheckJoined" ).val();

    //         $.ajaxSetup({
    //           headers: {
    //             'X-CSRF-TOKEN': token2
    //           }
    //         });

    //         $.ajax({
    //           type : 'get',
    //           url: url,
    //           data : { 'pps_no' : $( "#pps_no" ).val(),
    //                    'event_id' : $( "#event_id" ).val(),
    //                    'price' : $( "#price" ).val(),
    //                },
    //           success:function(data){
    //             $("#loading3").fadeOut();
    //             if(data.exist == true)
    //             {
    //               Swal.fire({
    //                 title: "Warning!",
    //                 text: "Member already joined on this event!",
    //                 icon: "error",
    //                 confirmButtonText: "Okay"
    //               })
                 
    //             }
    //             else
    //             {
    //               if(data.amount == 'free')
    //               {
    //                 Swal.fire({
    //                   title: "Success!",
    //                   text: "Member successfully joined on this event!",
    //                   icon: "success",
    //                   confirmButtonText: "Okay"
    //                 }).then((result) => {
    //                   if (result.isConfirmed) 
    //                   {
    //                     window.location=data.url;
    //                   }
    //                   else
    //                   {
    //                     window.location=data.url;
    //                   }
                   
    //                 });
                    
    //               }
    //               else if(data.amount == 'not_free')
    //               {
    //                 window.location=data.url;
    //               }
    //             }
 
    //           }
    //         });

    //       }
    //     });
     
    // }
    
  });



  $('#searchbox-input').on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $(".filtered").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      }); 
  });

  if ($("#event_category").length > 0)
  {
    $('.event_category').select2({       
    }).on('select2:open', function (e) {
          document.querySelector('.select2-search__field').focus();
    });
  }

  if ($(".event_category").length > 0)
  {
    $('.event_examination_category').select2({       
    }).on('select2:open', function (e) {
        document.querySelector('.select2-search__field').focus();
    });
  }

  if ($(".event_status").length > 0)
  {
    $('.event_status').select2({       
    }).on('select2:open', function (e) {
        document.querySelector('.select2-search__field').focus();
    });
  }
  
  

  if ($(".organizer").length > 0)
  {
    $('.organizer').select2({       
    }).on('select2:open', function (e) {
        document.querySelector('.select2-search__field').focus();
    });
  }


  if ($(".organizer_type").length > 0)
  {
    $('.organizer_type').select2({       
    }).on('select2:open', function (e) {
        document.querySelector('.select2-search__field').focus();
    });
  }






  



  $('#event_category').on('change', function() {
    var event = $("#event_category option:selected").text();
    if ( event == 'EXAMINATION')
    {
      $("#examination_category_row").show();
    }
    else
    {
      $("#examination_category_row").hide();
      $("#event_examination_category").val('').trigger('change')

    }
  });

  $('#event_category_update').on('change', function() {
    var event = $("#event_category_update option:selected").text();
    if ( event == 'EXAMINATION')
    {
      $("#examination_category_row").show();
    }
    else
    {
      $("#examination_category_row").hide();
      $("#event_examination_category").val('').trigger('change')

    }
  });
        
    

    $('#file-upload').submit(function(e) {
      e.preventDefault();
      $("#loading2").fadeIn();
      var url = $( "#urlEventImageUpload" ).val();
      var token2 = $( "#token2" ).val();
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': token
          }
      });

      var formData = new FormData(this);
 
      let TotalFiles = $('#files')[0].files.length; //Total files
      let files = $('#files')[0];
      for (let i = 0; i < TotalFiles; i++) {
          formData.append('files' + i, files.files[i]);
      }
      formData.append('TotalFiles', TotalFiles);
      formData.append('certificate_image', $('#certificate_image').prop('files')[0]);
      formData.append('session',$( "#session" ).val());


      $.ajax({
          type: 'post',
          url: url,
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          success: (data) => {
              $("#loading2").fadeOut();
              $('#modalUploadCreate').modal('hide');
              $("#files").val(null);
              $("#image_preview").empty();
              $("#certificate_preview").empty();
              $("#imageRows").load(window.location.href + " #imageRows");
      
          },
          error: function(data) {
              // console.log(data);
          }
      });
   });

   $('#file-upload2').submit(function(e) {
    e.preventDefault();
    $("#loading4").fadeIn();
    var url = $( "#urlEventImageUpload2" ).val();
    var token2 = $( "#token2" ).val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token2
        }
    });

    var formData = new FormData(this);

    let TotalFiles = $('#files')[0].files.length; //Total files
    let files = $('#files')[0];
    for (let i = 0; i < TotalFiles; i++) {
        formData.append('files' + i, files.files[i]);
    }
    formData.append('TotalFiles', TotalFiles);
    formData.append('event_id',$( "#event_id_update_upload" ).val())


    $.ajax({
        type: 'post',
        url: url,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: (data) => {
        
             $("#loading4").fadeOut();
            $('#uploadModal').modal('hide');
            $("#files").val(null);
            $("#image_preview").empty();
            $("#certificate_preview").empty();
            $("#imageRowUpdate").load(window.location.href + " #imageRowUpdate");
    
        },
        error: function(data) {
            // console.log(data);
        }
    });
 });

     


  $('#addGroupCommittee').click(function(e) {
    e.preventDefault();
    
    var urladd = $( "#urladdCommitteeGroup" ).val();
    var token = $( "#token" ).val();

    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': token
      }
    });

    $.ajax({
      type: 'get',
      url: urladd,
      data: { 'group_name' : $( "#committee-group-input" ).val(),
   },
     
      success: (data) => {
        if(data == "save")
        {
          notif.showNotification('top', 'right', 'New comittee group added!', 'danger');
          $("#lists").load(window.location.href + " #lists");
          $('#committee-group-input').val('');
         
        }

        else
        {
          notif.showNotification('top', 'right', 'Warning! committee group name already exist!', 'warning');
        }
      
     
      },
      error: function(data) {
          // console.log(data);
      }
    });


  });



   $('#event-delete-image').submit(function(e) {
    e.preventDefault();
    $("#loading").fadeIn();
    var url = $( "#urlImageDelete" ).val();
    var token2 = $( "#token2" ).val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token
        }
    });

    var formData = new FormData(this);
    formData.append('delete_id',$( "#delete_id" ).val());

    $.ajax({
        type: 'post',
        url: url,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: (data) => {
       
            $("#loading").fadeOut();
            $('#modalDelete').modal('hide');
            $(this).find('form').trigger('reset');
            $("#imageRows").load(window.location.href + " #imageRows");
    
        },
        error: function(data) {
            // console.log(data);
        }
    });
 });

 $('#event-delete-image2').submit(function(e) {
  e.preventDefault();
  $("#loading5").fadeIn();
  var url = $( "#urlImageDelete2" ).val();
  var token2 = $( "#token2" ).val();

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': token
      }
  });

  var formData = new FormData(this);
  formData.append('delete_id',$( "#delete_id_update" ).val());

  $.ajax({
      type: 'post',
      url: url,
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: (data) => {
     
          $("#loading5").fadeOut();
          $('#modalRemoveImageUpdate').modal('hide');
          $("#imageRowUpdate").load(window.location.href + " #imageRowUpdate");
  
      },
      error: function(data) {
          // console.log(data);
      }
  });
});


   var token = $("#token").val();
    

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token
        }
    });

    $('#saveEventBtn').click(function() {

      var title = $("#title").val();
      var category = $("#event_category option:selected").text();
      var category_id = $("#event_category").val();
      
      var event_date = $("#event_date").val();
      var start_time = $("#event_start").val();
      var end_time = $("#event_end").val();
      var momentObj = moment(event_date + start_time, 'YYYY-MM-DDLT');
			var momentObj2 = moment(event_date + end_time, 'YYYY-MM-DDLT');
      var start_dt = momentObj.format('YYYY-MM-DDTHH:mm:s');
			var end_dt = momentObj2.format('YYYY-MM-DDTHH:mm:s');
      var urlCheckEvent = $( "#urlCheckEvent" ).val();

        if(category == 'EXAMINATION' && $("#event_examination_category").val() == "")
        {
          notif.showNotification('top', 'right', 'Warning, please fill-up examination category !', 'warning');
          $("#event_examination_category").focus();
        }

        else if(end_time < start_time)
        {
            notif.showNotification('top', 'right', 'Warning, end time should not be lower than start time !', 'warning');
            $("#event_end").focus();
        }

        else if($("#title").val() == "")
        {
            notif.showNotification('top', 'right', 'Warning, please fill-up event title!', 'warning');
            $("#title").focus();
        }
        else if($("#event_category").val() == "")
        {
            notif.showNotification('top', 'right', 'Warning, please fill-up event category !', 'warning');
            $("#event_category").focus();
        }
        else if($("#event_date").val() == "")
        {
            notif.showNotification('top', 'right', 'Warning, please fill-up event date !', 'warning');
            $("#event_date").focus();
        }
        else if($("#event_start").val() == "")
        {
            notif.showNotification('top', 'right', 'Warning, please fill-up event start time !', 'warning');
            $("#event_start").focus();
        }
        else if($("#event_end").val() == "")
        {
            notif.showNotification('top', 'right', 'Warning, please fill-up event end time !', 'warning');
            $("#event_end").focus();
        }
        else if($("#event_end").val() == "")
        {
            notif.showNotification('top', 'right', 'Warning, please fill-up event end time !', 'warning');
            $("#event_end").focus();
        }
        else if($("#event_venue").val() == "")
        {
            notif.showNotification('top', 'right', 'Warning, please fill-up event venue !', 'warning');
            $("#event_venue").focus();
        }
        else if($("#event_limit").val() == "")
        {
            notif.showNotification('top', 'right', 'Warning, please fill-up participant limit !', 'warning');
            $("#event_limit").focus();
        }
        else if($("#event_price").val() == "")
        {
            notif.showNotification('top', 'right', 'Warning, please fill-up event price !', 'warning');
            $("#event_price").focus();
        }
        else if($("#event_points").val() == "")
        {
            notif.showNotification('top', 'right', 'Warning, please fill-up CPD Points !', 'warning');
            $("#event_points").focus();
        }

      
        
        else
        {
          $.ajax({
            type : 'get',
            url: urlCheckEvent,
            data : { 'title' : title,
                     'start_dt' : start_dt,
                     'end_dt' : end_dt,
                     'category' : category_id
                  },
            success:function(res){
            
              if(res >= 1)
              {
                $("#titleRow").addClass("is-invalid");
                $("#titleRow").removeClass("is-valid");
                notif.showNotification('top', 'right', 'Warning, existing event!', 'warning');
                $("#title").focus();
              }
              else{ 
                $("#titleRow").removeClass("is-invalid");
                $("#titleRow").addClass("is-valid");
                $("#title").focus();
                notif.showSwal('insert-event');
                
              }
              
                            
            }
          });
            
        }

    });







    $('#updateEventBtn').click(function() {

      var title = $("#title_update").val();

      var category = $("#event_category_update option:selected").text();
      var category_id = $("#event_category_update").val();
      var examination_category = $("#event_examination_category_update").val();
      var venue = $("#event_venue_update").val();
      var participant_limit = $("#event_limit_update").val();
      var description = $("#event_description_update").val();
      var price = $("#event_price_update").val();
      var points = $("#event_points_update").val();
      var event_id = $("#event_id_update").val();
      var status = $("#event_status_update").val();
      
      

      var event_date = $("#event_date_update").val();
      var start_time = $("#event_start_update").val();
      var end_time = $("#event_end_update").val();
      var momentObj = moment(event_date + start_time, 'YYYY-MM-DDLT');
			var momentObj2 = moment(event_date + end_time, 'YYYY-MM-DDLT');
      var start_dt = momentObj.format('YYYY-MM-DDTHH:mm:s');
			var end_dt = momentObj2.format('YYYY-MM-DDTHH:mm:s');
      var urlCheckEventUpdate = $( "#urlCheckEventUpdate" ).val();

      if(category == 'EXAMINATION' && $("#event_examination_category_update").val() == "")
        {
          notif.showNotification('top', 'right', 'Warning, please fill-up examination category !', 'warning');
          $("#event_examination_category_update").focus();
        }
      else if(end_time < start_time)
      {
          notif.showNotification('top', 'right', 'Warning, end time should not be lower than start time !', 'warning');
          $("#event_end_update").focus();
      }
      else if(title == "")
      {
          notif.showNotification('top', 'right', 'Warning, please fill-up event title!', 'warning');
          $("#title_update").focus();
      }
      else if(category_id == "")
      {
          notif.showNotification('top', 'right', 'Warning, please fill-up event category !', 'warning');
          $("#category_id").focus();
      }
      else if(event_date == "")
        {
            notif.showNotification('top', 'right', 'Warning, please fill-up event date !', 'warning');
            $("#event_date_update").focus();
        }
        else if(start_time == "")
        {
            notif.showNotification('top', 'right', 'Warning, please fill-up event start time !', 'warning');
            $("#event_start_update").focus();
        }
        else if(end_time == "")
        {
            notif.showNotification('top', 'right', 'Warning, please fill-up event end time !', 'warning');
            $("#event_end_update").focus();
        }
        else if(venue == "")
        {
            notif.showNotification('top', 'right', 'Warning, please fill-up event venue !', 'warning');
            $("#event_venue_update").focus();
        }
        else if(participant_limit == "")
        {
            notif.showNotification('top', 'right', 'Warning, please fill-up participant limit !', 'warning');
            $("#event_limit_update").focus();
        }
        else if(price == "")
        {
            notif.showNotification('top', 'right', 'Warning, please fill-up event price !', 'warning');
            $("#event_price_update").focus();
        }
        else if(points == "")
        {
            notif.showNotification('top', 'right', 'Warning, please fill-up CPD Points !', 'warning');
            $("#event_points_update").focus();
        }

        else if(status == "")
        {
            notif.showNotification('top', 'right', 'Warning, please fill-up event status !', 'warning');
            $("#event_status_update").focus();
        }

 

      else
      {
        $.ajax({
          type : 'get',
          url: urlCheckEventUpdate,
          data : { 'title' : title,
                   'start_dt' : start_dt,
                   'end_dt' : end_dt,
                   'category' : category_id,
                   'id' : event_id
                },
          success:function(res){

            if(res >= 1)
            {
              $("#titleRow").addClass("is-invalid");
              $("#titleRow").removeClass("is-valid");
              notif.showNotification('top', 'right', 'Warning, existing event!', 'warning');
              $("#title").focus();
            }
            else{ 
              $("#titleRow").removeClass("is-invalid");
              $("#titleRow").addClass("is-valid");
              $("#title").focus();
              notif.showSwal('update-event');
              
            }
            
          
          }
        });
        
          
      }
      

       
    });



    $("#modalDelete").on("show.bs.modal", function(e) {
      var id = $(e.relatedTarget).data('target-id');
      $('#delete_id').val(id); 
    });

    $("#modalRemoveImageUpdate").on("show.bs.modal", function(e) {   
      var id = $(e.relatedTarget).data('target-id');
      $('#delete_id_update').val(id);
    });

  $('#uploadModal').on('hidden.bs.modal', function () {
    $(this).find('form').trigger('reset');
    $("#image_preview").empty();
    $("#certficate_preview").empty();
  });
  $('#modalUploadCreate').on('hidden.bs.modal', function () {
    $(this).find('form').trigger('reset');
    $("#image_preview").empty();
    $("#certificate_preview").empty();
  });


  


    // var urlCalendarEvent = $("#urlCalendarEvent").val();

    
    // var calendar = new FullCalendar.Calendar(document.getElementById("calendar"), {
    //   contentHeight: 710,
    //   initialView: "dayGridMonth",
    //   headerToolbar: {
    //     start: 'title', // will normally be on the left. if RTL, will be on the right
    //     center: '',
    //     end: 'today prev,next' // will normally be on the right. if RTL, will be on the left
    //   },
    //   selectable: true,
    //   editable: true,
    //   displayEventTime: false,
    //   eventSources:
    //   [{
    //             url: urlCalendarEvent,
    //             method: 'GET',
    //             backgroundColor: '#2098c7',

    //             extendedProps: {
    //               category: 'category',
                
    //            }      
                
    //     }],
    //     eventColor: 'white',
    //     eventDidMount: function(info) {


    //       if(-1 != info.event.extendedProps.category.indexOf("MOCK EXAM")) {
              
    //           info.el.style.backgroundColor  = '#4CAF50';
              
    //       }

    //       else if(-1 != info.event.extendedProps.category.indexOf("EXAMINATION")) {
              
    //         info.el.style.backgroundColor  = '#ffaa3f';
            
    //       }

    //       else if(-1 != info.event.extendedProps.category.indexOf("INDUCTION")) {
              
    //         info.el.style.backgroundColor  = '#2872d3';
            
    //       }

       
    //       else {
    //           info.el.style.backgroundColor  = "#ce3333";
              
    //       }
  
    //   },
    
    // });
  
    // calendar.render();


});





$(function(){
  $(window).on('load',function(){
      $('#loading2').hide();
      $('#loading3').hide();
    
  });
});


        
        // Products gallery

        var initPhotoSwipeFromDOM = function (gallerySelector) {

          // parse slide data (url, title, size ...) from DOM elements
          // (children of gallerySelector)
          var parseThumbnailElements = function (el) {
              var thumbElements = el.childNodes,
                  numNodes = thumbElements.length,
                  items = [],
                  figureEl,
                  linkEl,
                  size,
                  item;

              for (var i = 0; i < numNodes; i++) {

                  figureEl = thumbElements[i]; // <figure> element
                  // include only element nodes
                  if (figureEl.nodeType !== 1) {
                      continue;
                  }

                  linkEl = figureEl.children[0]; // <a> element

                  size = linkEl.getAttribute('data-size').split('x');

                  // create slide object
                  item = {
                      src: linkEl.getAttribute('href'),
                      w: parseInt(size[0], 10),
                      h: parseInt(size[1], 10)
                  };

                  if (figureEl.children.length > 1) {
                      // <figcaption> content
                      item.title = figureEl.children[1].innerHTML;
                  }

                  if (linkEl.children.length > 0) {
                      // <img> thumbnail element, retrieving thumbnail url
                      item.msrc = linkEl.children[0].getAttribute('src');
                  }

                  item.el = figureEl; // save link to element for getThumbBoundsFn
                  items.push(item);
              }

              return items;
          };

          // find nearest parent element
          var closest = function closest(el, fn) {
              return el && (fn(el) ? el : closest(el.parentNode, fn));
          };

          // triggers when user clicks on thumbnail
          var onThumbnailsClick = function (e) {
              e = e || window.event;
              e.preventDefault ? e.preventDefault() : e.returnValue = false;

              var eTarget = e.target || e.srcElement;

              // find root element of slide
              var clickedListItem = closest(eTarget, function (el) {
                  return (el.tagName && el.tagName.toUpperCase() === 'FIGURE');
              });

              if (!clickedListItem) {
                  return;
              }

              // find index of clicked item by looping through all child nodes
              // alternatively, you may define index via data- attribute
              var clickedGallery = clickedListItem.parentNode,
                  childNodes = clickedListItem.parentNode.childNodes,
                  numChildNodes = childNodes.length,
                  nodeIndex = 0,
                  index;

              for (var i = 0; i < numChildNodes; i++) {
                  if (childNodes[i].nodeType !== 1) {
                      continue;
                  }

                  if (childNodes[i] === clickedListItem) {
                      index = nodeIndex;
                      break;
                  }
                  nodeIndex++;
              }



              if (index >= 0) {
                  // open PhotoSwipe if valid index found
                  openPhotoSwipe(index, clickedGallery);
              }
              return false;
          };

          // parse picture index and gallery index from URL (#&pid=1&gid=2)
          var photoswipeParseHash = function () {
              var hash = window.location.hash.substring(1),
                  params = {};

              if (hash.length < 5) {
                  return params;
              }

              var vars = hash.split('&');
              for (var i = 0; i < vars.length; i++) {
                  if (!vars[i]) {
                      continue;
                  }
                  var pair = vars[i].split('=');
                  if (pair.length < 2) {
                      continue;
                  }
                  params[pair[0]] = pair[1];
              }

              if (params.gid) {
                  params.gid = parseInt(params.gid, 10);
              }

              return params;
          };

          var openPhotoSwipe = function (index, galleryElement, disableAnimation, fromURL) {
              var pswpElement = document.querySelectorAll('.pswp')[0],
                  gallery,
                  options,
                  items;

              items = parseThumbnailElements(galleryElement);

              // define options (if needed)
              options = {

                  // define gallery index (for URL)
                  galleryUID: galleryElement.getAttribute('data-pswp-uid'),

                  getThumbBoundsFn: function (index) {
                      // See Options -> getThumbBoundsFn section of documentation for more info
                      var thumbnail = items[index].el.getElementsByTagName('img')[
                              0], // find thumbnail
                          pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                          rect = thumbnail.getBoundingClientRect();

                      return {
                          x: rect.left,
                          y: rect.top + pageYScroll,
                          w: rect.width
                      };
                  }

              };

              // PhotoSwipe opened from URL
              if (fromURL) {
                  if (options.galleryPIDs) {
                      // parse real index when custom PIDs are used
                      // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
                      for (var j = 0; j < items.length; j++) {
                          if (items[j].pid == index) {
                              options.index = j;
                              break;
                          }
                      }
                  } else {
                      // in URL indexes start from 1
                      options.index = parseInt(index, 10) - 1;
                  }
              } else {
                  options.index = parseInt(index, 10);
              }

              // exit if index not found
              if (isNaN(options.index)) {
                  return;
              }

              if (disableAnimation) {
                  options.showAnimationDuration = 0;
              }

              // Pass data to PhotoSwipe and initialize it
              gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
              gallery.init();
          };

          // loop through all gallery elements and bind events
          var galleryElements = document.querySelectorAll(gallerySelector);

          for (var i = 0, l = galleryElements.length; i < l; i++) {
              galleryElements[i].setAttribute('data-pswp-uid', i + 1);
              galleryElements[i].onclick = onThumbnailsClick;
          }

          // Parse URL and open gallery if it contains #&pid=3&gid=1
          var hashData = photoswipeParseHash();
          if (hashData.pid && hashData.gid) {
              openPhotoSwipe(hashData.pid, galleryElements[hashData.gid - 1], true, true);
          }
      };

      // execute above function
      initPhotoSwipeFromDOM('.my-gallery');


      






