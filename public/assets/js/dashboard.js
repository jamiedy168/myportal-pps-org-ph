function notallowedvote()
{
    Swal.fire({
      title: "Warning,",
      text: "Only diplomate, fellow and emeritus fellow are allowed to vote.",
      icon: "warning",
      confirmButtonText: "Okay"
    })
}

function adminnotallowedvote()
{
    Swal.fire({
      title: "Warning,",
      text: "Unauthorize person are not allowed to join.",
      icon: "warning",
      confirmButtonText: "Okay"
    })
}

function votingClose()
{
    Swal.fire({
      title: "Warning,",
      text: "Voting is not allowed at this time, please check the election date and time.",
      icon: "warning",
      confirmButtonText: "Okay"
    })
}


function btnEventPaymentCloseBtn()
{
    Swal.fire({
      title: "Warning!",
      text: "Payments cannot be processed yet. Payments will be available starting December 16, 2025.",
      icon: "warning",
      confirmButtonText: "Okay"
    })
}











$(document).on('click', '.votenow', function () {
    Swal.fire({

      customClass: {
          confirmButton: "btn bg-gradient-success",
          cancelButton: "btn bg-gradient-danger"
      },
      buttonsStyling: !1,
      
      title: "Are you sure?",
      text: "You want to cast your vote now?",
      icon: "warning",
      showCancelButton: true,
      showCancelButton: !0,
      confirmButtonText: "Yes, proceed!",
  }).then((result) => {
    if (result.isConfirmed) {
        var token = $("#token2").val();
        var url = $( "#urlVotingCheckAllowed" ).val();
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': token
          }
      });
        $.ajax({
          type: 'get',
          url: url,
          data: { 'voting_id' : this.id,      
              },
          
          success: (data) => {
           
            if(data == "alreadyvoted")
            {
              Swal.fire({
                  title: "Warning!",
                  text: "You already vote on this election.",
                  icon: "warning",
                  confirmButtonText: "Okay"
              })
            }
            // else if(data == "notjoined")
            // {
            //   Swal.fire({
            //     title: "Warning!",
            //     text: "You need to join/pay the annual convention first.",
            //     icon: "warning",
            //     confirmButtonText: "Okay"
            //   })
            // }
            // else if(data == "paymenttimenotmeet")
            // {
            //   Swal.fire({
            //     title: "Unable to vote!",
            //     text: "Sorry, you did not meet the required date/time payment for annual convention.",
            //     icon: "warning",
            //     confirmButtonText: "Okay"
            //   })
            // }
            // else if(data == "existannualdues")
            // {
            //   Swal.fire({
            //       title: "Warning!",
            //       text: "You have remaining annual dues that need to pay before casting your vote!",
            //       icon: "warning",
            //       confirmButtonText: "Okay"
            //   })
            // }
            else
            {
              var firsturl = "/voting-election/";
              var voting_id = data;
              window.location.href = firsturl + voting_id;
            
            }
          },
          error: function(data) { 
              Swal.fire({
                  title: "Warning!",
                  text: "Something error",
                  icon: "error",
                  confirmButtonText: "Okay"
              })
          }
      });
    }
  })
 
});







$(document).ready(function(){


  var pps_no = $('#pps_no').val();
  var second_completed_profile = $('#second_completed_profile').val();

  console.log("PPS_NO:" + pps_no);
  console.log("PROFILE:" + second_completed_profile);
  var role_id = $('#role_id').val();
  if(role_id == 3)
  {
    if (!second_completed_profile || second_completed_profile === "0") 
    {
      Swal.fire({
        customClass: {
          confirmButton: "btn bg-gradient-success",
        },
        buttonsStyling: false,

        title: "Notice!",
        text: "Please update your membership profile with your TIN and address for our system upgrade.",
        icon: "warning",
        showCancelButton: false,       // no cancel button
        confirmButtonText: "Proceed!",
        allowOutsideClick: false,      // can't click overlay
        allowEscapeKey: false,         // can't press ESC
        allowEnterKey: false,          // can't close with Enter
        showCloseButton: false,        // no "X" close button
        backdrop: true,                // dark overlay (blocks clicks behind)
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = '/update-member-new-info/' + btoa(pps_no);
        }
      });
    }
  }




  if($('#session_default_password').val() == true )
  {
    $('#modal-change-password').modal('show');
  }
  else
  {
    $('#modal-change-password').modal('hide');
  }

  $('.password').keyup(function() {
    if ($('#password').val() != $('#re-password').val()) 
    {
      $("#passwordDiv").addClass("is-invalid");
      $("#passwordDiv2").addClass("is-invalid");

      $("#passwordDiv").removeClass("is-valid");
      $("#passwordDiv2").removeClass("is-valid");

      $('#notMatchRow').show();
      $('#matchRow').hide();
      
    } 
    else if ($('#password').val() == "" && $('#re-password').val() == "") 
      { 
        $("#passwordDiv").removeClass("is-valid");
        $("#passwordDiv2").removeClass("is-valid");
  
        $("#passwordDiv").removeClass("is-invalid");
        $("#passwordDiv2").removeClass("is-invalid");
  
        $('#notMatchRow').hide();
        $('#matchRow').hide();
      }
    else 
      { 
        $("#passwordDiv").addClass("is-valid");
        $("#passwordDiv2").addClass("is-valid");
  
        $("#passwordDiv").removeClass("is-invalid");
        $("#passwordDiv2").removeClass("is-invalid");
  
        $('#notMatchRow').hide();
        $('#matchRow').show();
      }
  });

  $('#change-default-password').submit(function(e) {
    e.preventDefault();

    if ($('#password').val() == "") 
    {
      notif.showNotification('top', 'right', 'Warning, please enter your password!', 'warning');
      document.getElementById("password").focus();
    }
    else if ($('#password').val() != $('#re-password').val()) 
    {
      $("#passwordDiv").addClass("is-invalid");
      $("#passwordDiv2").addClass("is-invalid");

      $("#passwordDiv").removeClass("is-valid");
      $("#passwordDiv2").removeClass("is-valid");

      $('#notMatchRow').show();
      $('#matchRow').hide();
    } 
    else 
    { 
      $("#passwordDiv").addClass("is-valid");
      $("#passwordDiv2").addClass("is-valid");

      $("#passwordDiv").removeClass("is-invalid");
      $("#passwordDiv2").removeClass("is-invalid");

      $('#notMatchRow').hide();
      $('#matchRow').show();

      var token = $("#token").val();
      var url = $( "#urlChangeDefaultPassword" ).val();
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': token
          }
      });
      var formData = new FormData(this);        
      formData.append('password',$( "#password" ).val());
      formData.append('user_id',$( "#session_user_id" ).val());
      

      $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: (data) => {


         
          $('#modal-change-password').modal('hide');
            Swal.fire({
                title: "Success!",
                text: "Password successfully changed",
                icon: "success",
                confirmButtonText: "Okay"
            });

        },
        error: function(data) {
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
  
  


    $('.btnEventJoinDashboard').on('click', function(){
        var event_id = $(this).data("event-id");
        var price = $(this).data("event-price");
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
        else{
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
          
      
    });
});

function joinAdminEvent()
{
  Swal.fire({
    title: "Warning!",
    text: "Admin can not join in the event.",
    icon: "warning",
    confirmButtonText: "Okay"
  })
}
