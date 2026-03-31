
$('.event_title').select2({    
    
}).on('select2:open', function (e) {
      document.querySelector('.select2-search__field').focus();
});


$('#search-prc-form').submit(function (e) {
  e.preventDefault()
  $("#member_picture").attr('src', defaultProfileImg);

  $('#type_transaction').val("prc");
  var urlCheckIfPaidViaPRC = $( "#urlEventCheckAttendanceCountViaPRC" ).val();
  var urlCheckMemberExistViaPRC = $( "#urlCheckMemberExistViaPRC" ).val();
  var urlNotAttendedViaPRC = $( "#urlEventMemberNotAttendedViaPRC" ).val();

  var urlCheckIfPaidInEventViaPRC = $( "#urlEventCheckAttendanceViaPRC" ).val();
  var urlCheckAttendedViaPRC = $( "#urlCheckAttendedViaPRC" ).val();



  var token = $( "#token" ).val();
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': token
      }
  });
    //CHECK IF MEMBER EXIST IN THE DATABASE
    $.ajax({
      url: urlCheckMemberExistViaPRC,
      type: 'GET',
      data: {
          'prc_no': $("#searchbox-prc").val(),
      },
      success: function (res) {
        //Member exist
        if(res >= 1)
        {
          //CHECK IF ALREADY ATTENDED
          $.ajax({
            url: urlCheckAttendedViaPRC,
            type: 'GET',
            data: {
                'prc_no': $("#searchbox-prc").val(),
                'event_id' : $( "#event_id" ).val()
            },
            success:function(dataattend){
              //MEMBER ALREADY ATTENDED
              if (dataattend.event_transaction >= 1) {
                
                    $('#pps_no2').val("");
                    $('#attendee_name').text("");
                    $('#attendee_type').text("");
                    $('#attendee_gender').text("");
                    $('#payment_status').text("");
                    $('#member_joined_dt').text("");
                    $('#member_payment_dt').text("");
                    $('#attendee_prc_no').text("");
                    
                    var message = 'This member, ' + dataattend.member_info.first_name + ' ' + dataattend.member_info.last_name + ', has already completed their attendance for this event.';
                    Swal.fire({
                        title: "Warning!",
                        text: message,
                        icon: "warning",
                        confirmButtonText: "Okay"
                    });
                }
            
                else
                {
                  $.ajax({
                    url: urlCheckIfPaidViaPRC,
                    type: 'GET',
                    data: {
                        'prc_no': $("#searchbox-prc").val(),
                        'event_id' : $( "#event_id" ).val()
                    },
                    success: function (result) {
                     // MEMBER REGISTERED ONLINE
                      if(result >= 1)
                        {
                          $.ajax({
                            type : 'get',
                            url: urlCheckIfPaidInEventViaPRC,
                            data : {  'prc_no': $("#searchbox-prc").val(),
                                      'event_id' : $( "#event_id" ).val()
                                  },
                            success:function(data){
                      
                              // Check if member paid on the event
                              if(data.attendee.paid == true)
                              {
                                $('#pps_no2').val(data.attendee.pps_no);
                                notif.showNotification('top', 'right', 'Success, Member can proceed to next step!', 'success');
                                $('#btnAttend').prop('disabled', false);
                            
                                var name = data.attendee.first_name + ' ' + data.attendee.middle_name + ' ' + data.attendee.last_name + ' ' + data.attendee.suffix;
                                name = name.replace(/null/g, '').replace(/\s+/g, ' ').trim();
                                
                                
                                var joined_dt = moment(data.attendee.joined_dt).format('MMMM DD, YYYY h:mm a');
                                var payment_dt = moment(data.attendee.payment_dt).format('MMMM DD, YYYY h:mm a');
              
                                $('#attendee_name').text(name);
                                $('#attendee_type').text(data.attendee.member_type_name);
                                $('#attendee_gender').text(data.attendee.gender);
                                if(data.attendee.prc_number == null)
                                {
                                  $('#attendee_prc_no').text("N/A");
                                }
                                else
                                {
                                  $('#attendee_prc_no').text(data.attendee.prc_number);
                                }
                                $('#payment_status').text('PAID');
                                $('#payment_status').removeClass("text-warning");
                                $('#payment_status').removeClass("text-danger");
                                $('#payment_status').addClass("text-success");
                                $('#member_joined_dt').text(joined_dt);
                                $('#member_payment_dt').text(payment_dt);
                                $("#member_picture").attr('src', data.picture_url);
                              }
              
                              // Member not paid on the event
                              else
                              {
                                notif.showNotification('top', 'right', 'Warning: Member must pay for the event first!', 'warning');
            
                                $('#btnAttend').prop('disabled', true);
                                var name = data.attendee.first_name + ' ' + data.attendee.middle_name + ' ' + data.attendee.last_name + ' ' + data.attendee.suffix;
                                name = name.replace(/null/g, '').replace(/\s+/g, ' ').trim();
                                
                                var joined_dt = moment(data.attendee.joined_dt).format('MMMM DD, YYYY h:mm a');
                                $('#attendee_name').text(name);
                                $('#attendee_type').text(data.attendee.member_type_name);
                                $('#attendee_gender').text(data.attendee.gender);
                                if(data.attendee.prc_number == null)
                                {
                                  $('#attendee_prc_no').text("N/A");
                                }
                                else
                                {
                                  
                                  $('#attendee_prc_no').text(data.attendee.prc_number);
                                }
                                $('#payment_status').text('FOR PAYMENT');
                                $('#payment_status').removeClass("text-danger");
                                $('#payment_status').removeClass("text-success");
                                $('#payment_status').addClass("text-warning");
                                $('#member_joined_dt').text(joined_dt);
                                $('#member_payment_dt').text('N/A');
                                $("#member_picture").attr('src', data.picture_url);
                              }
                              
                            }
                          });
                        }
                      // MEMBER NOT REGISTERED ONLINE
                      else
                      {
                        $.ajax({
                          type : 'get',
                          url: urlNotAttendedViaPRC,
                          data : {  'prc_no': $("#searchbox-prc").val(),
                                    'event_id' : $( "#event_id" ).val()
                                },
                          success:function(notAttended){
                            
                            notif.showNotification('top', 'right', 'Warning: Member found, but not registered for the event yet!', 'warning');
                       
                            var name = notAttended.non_attendee.first_name + ' ' + notAttended.non_attendee.middle_name + ' ' + notAttended.non_attendee.last_name + ' ' + notAttended.non_attendee.suffix;
                            name = name.replace(/null/g, '').replace(/\s+/g, ' ').trim();
                            
                            $('#pps_no2').val(notAttended.non_attendee.pps_no);
                            $('#attendee_name').text(name);
                            $('#attendee_type').text(notAttended.non_attendee.member_type_name);
                            $('#attendee_gender').text(notAttended.non_attendee.gender);
                            if(notAttended.non_attendee.prc_number == null)
                            {
                              $('#attendee_prc_no').text("N/A");
                            }
                            else
                            {
                              $('#attendee_prc_no').text(notAttended.non_attendee.prc_number);
                            }
                            
                            $('#payment_status').text('NOT REGISTERED');
                            $('#payment_status').removeClass("text-success");
                            $('#payment_status').removeClass("text-warning");
                            $('#payment_status').addClass("text-danger");
                            $('#member_joined_dt').text('N/A');
                            $('#member_payment_dt').text('N/A');
                  
                            $("#member_picture").attr('src', notAttended.picture_url);
          
                          }
                        });
                      }
                    }
                  });
                }
            }
          });
        }
        else{

          $('#pps_no2').val("");
          $('#attendee_name').text("");
          $('#attendee_type').text("");
          $('#attendee_gender').text("");
          $('#payment_status').text("");
          $('#member_joined_dt').text("");
          $('#member_payment_dt').text("");
          $('#attendee_prc_no').text("");

          

          Swal.fire({
            title: "Warning!",
            text: "The member was not found in the list.",
            icon: "warning",
            confirmButtonText: "Okay"
          });
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
         
      }
    });


});

$('#qr_code_form').submit(function (e) {
  e.preventDefault()

  $("#member_picture").attr('src', defaultProfileImg);



  var urlCheckIfPaid = $( "#urlEventCheckAttendanceCount" ).val();
  var urlCheckMemberExist = $( "#urlCheckMemberExist" ).val();
  var urlNotAttended = $( "#urlEventMemberNotAttended" ).val();
  var urlCheckIfPaidInEvent = $( "#urlEventCheckAttendance" ).val();
  var urlCheckAttended = $( "#urlCheckAttended" ).val();
  
  var token = $( "#token" ).val();
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': token
      }
  });
  //CHECK IF MEMBER EXIST IN THE DATABASE
  $.ajax({
    url: urlCheckMemberExist,
    type: 'GET',
    data: {
        'pps_no': $("#pps_no_qr").val(),
    },
    success: function (res) {
      //Member exist
       if(res >= 1)
       {
         //CHECK IF ALREADY ATTENDED
        $.ajax({
          url: urlCheckAttended,
          type: 'GET',
          data: {
              'pps_no': $("#pps_no_qr").val(),
              'event_id' : $( "#event_id" ).val()
          },
          success:function(dataattend){

            if(dataattend >= 1)
            {

              $('#pps_no_qr').val("");
              $('#pps_no2').val("");
              $('#attendee_name').text("");
              $('#attendee_type').text("");
              $('#attendee_gender').text("");
              $('#payment_status').text("");
              $('#member_joined_dt').text("");
              $('#member_payment_dt').text("");
              $('#attendee_prc_no').text("");

              var message = 'This member has already completed their attendance for this event.';
              Swal.fire({
                title: "Warning!",
                text: message,
                icon: "warning",
                confirmButtonText: "Okay"
              });
            }
            else
            {
              $.ajax({
                url: urlCheckIfPaid,
                type: 'GET',
                data: {
                    'pps_no': $("#pps_no_qr").val(),
                    'event_id' : $( "#event_id" ).val()
                },
                success: function (result) {
                  // MEMBER REGISTERED ONLINE
                  if(result >= 1)
                  {
                    $.ajax({
                      type : 'get',
                      url: urlCheckIfPaidInEvent,
                      data : { 'pps_no' : $("#pps_no_qr").val(),
                                'event_id' : $( "#event_id" ).val()
                            },
                      success:function(data){
                     
                      
                        // Check if member paid on the event
                        if(data.attendee.paid == true)
                        {
                          $("#pps_no_qr").val("");
                          $('#pps_no2').val(data.attendee.pps_no);
                          notif.showNotification('top', 'right', 'Success, Member can proceed to next step!', 'success');
                          $('#btnAttend').prop('disabled', false);
                      
                          var name = data.attendee.first_name + ' ' + data.attendee.middle_name + ' ' + data.attendee.last_name + ' ' + data.attendee.suffix;
                          name = name.replace(/null/g, '').replace(/\s+/g, ' ').trim();
                          
                          
                          var joined_dt = moment(data.attendee.joined_dt).format('MMMM DD, YYYY h:mm a');
                          var payment_dt = moment(data.attendee.payment_dt).format('MMMM DD, YYYY h:mm a');
        
                          $('#attendee_name').text(name);
                          $('#attendee_type').text(data.attendee.member_type_name);
                          $('#attendee_gender').text(data.attendee.gender);
                          if(data.attendee.prc_number == null)
                          {
                            $('#attendee_prc_no').text("N/A");
                          }
                          else
                          {
                            $('#attendee_prc_no').text(data.attendee.prc_number);
                          }
                          $('#payment_status').text('PAID');
                          $('#payment_status').removeClass("text-warning");
                          $('#payment_status').removeClass("text-danger");
                          $('#payment_status').addClass("text-success");
                          $('#member_joined_dt').text(joined_dt);
                          $('#member_payment_dt').text(payment_dt);
                          $("#member_picture").attr('src', data.picture_url);
                        }
        
                        // Member not paid on the event
                        else
                        {
                          notif.showNotification('top', 'right', 'Warning: Member must pay for the event first!', 'warning');
                          $("#pps_no_qr").val("");
                          $('#btnAttend').prop('disabled', true);
                         
                          var name = data.attendee.first_name + ' ' + data.attendee.middle_name + ' ' + data.attendee.last_name + ' ' + data.attendee.suffix;
                          name = name.replace(/null/g, '').replace(/\s+/g, ' ').trim();
                          
                          var joined_dt = moment(data.attendee.joined_dt).format('MMMM DD, YYYY h:mm a');
                          $('#attendee_name').text(name);
                          $('#attendee_type').text(data.attendee.member_type_name);
                          $('#attendee_gender').text(data.attendee.gender);
                          if(data.attendee.prc_number == null)
                          {
                            $('#attendee_prc_no').text("N/A");
                          }
                          else
                          {
                            
                            $('#attendee_prc_no').text(data.attendee.prc_number);
                          }
                          $('#payment_status').text('FOR PAYMENT');
                          $('#payment_status').removeClass("text-danger");
                          $('#payment_status').removeClass("text-success");
                          $('#payment_status').addClass("text-warning");
                          $('#member_joined_dt').text(joined_dt);
                          $('#member_payment_dt').text('N/A');
                          $("#member_picture").attr('src', data.picture_url);
                        }
                        
                      }
                    });
                  }
                  // MEMBER NOT REGISTERED ONLINE
                  else
                  {
                    $.ajax({
                      type : 'get',
                      url: urlNotAttended,
                      data : { 'pps_no' : $("#pps_no_qr").val(),
                                'event_id' : $( "#event_id" ).val()
                            },
                      success:function(notAttended){
                        $('#pps_no_qr').val("");
                        notif.showNotification('top', 'right', 'Warning: Member found, but not registered for the event yet!', 'warning');
                        
                        var name = notAttended.non_attendee.first_name + ' ' + notAttended.non_attendee.middle_name + ' ' + notAttended.non_attendee.last_name + ' ' + notAttended.non_attendee.suffix;
                        name = name.replace(/null/g, '').replace(/\s+/g, ' ').trim();
                        
                        
                        $('#pps_no2').val(notAttended.non_attendee.pps_no);
                        $('#attendee_name').text(name);
                        $('#attendee_type').text(notAttended.non_attendee.member_type_name);
                        $('#attendee_gender').text(notAttended.non_attendee.gender);
                        if(notAttended.non_attendee.prc_number == null)
                        {
                          $('#attendee_prc_no').text("N/A");
                        }
                        else
                        {
                          $('#attendee_prc_no').text(notAttended.non_attendee.prc_number);
                        }
                        
                        $('#payment_status').text('NOT REGISTERED');
                        $('#payment_status').removeClass("text-success");
                        $('#payment_status').removeClass("text-warning");
                        $('#payment_status').addClass("text-danger");
                        $('#member_joined_dt').text('N/A');
                        $('#member_payment_dt').text('N/A');
               
                        $("#member_picture").attr('src', notAttended.picture_url);
      
                      }
                    });
                  }
                }
              });
            }
          }
        });
       
       
        
      
       }
       else
       {
        $('#pps_no_qr').val("");
        $('#pps_no2').val("");
        $('#attendee_name').text("");
        $('#attendee_type').text("");
        $('#attendee_gender').text("");
        $('#payment_status').text("");
        $('#member_joined_dt').text("");
        $('#member_payment_dt').text("");
        $('#attendee_prc_no').text("");


        Swal.fire({
          title: "Warning!",
          text: "The member was not found in the list.",
          icon: "warning",
          confirmButtonText: "Okay"
        });
       }
    },
    error: function (jqXHR, textStatus, errorThrown) {
       
    }
  });

});

$(function(){
    $(window).on('load',function(){
        $('#loading3').hide();
      
    });
});

$(document).ready(function()  {
  $('#qr_scanner_img').hide();
  $('#btnAttend').prop('disabled', true);

  $('#scan_qr_code').click(function () {
    $('#pps_no_qr').show();
    $('#type_transaction').val("qrcode");
    $('#pps_no_qr').val("");
    $('#preview').fadeOut();
    $('#qr_scanner_img').fadeIn();
    $('#pps_no_qr').focus();
    $('#scan_qr_text').show();
    
  })

  $('#start_camera').click(function () {
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
    scanner.addListener('scan', function (content) {
      // console.log(content);
    });
    Instascan.Camera.getCameras().then(function (cameras) {
      
      if (cameras.length > 0) {
        
        $('#start_camera, #stop_camera, #scan_qr_code').click(function () {
          if (this.id === 'start_camera') {
            $('#type_transaction').val("camera");
            $('#qr_scanner_img').fadeOut();
            $('#preview').fadeIn();
            $('#scan_qr_text').hide();
            $('#pps_no_qr').hide();
            scanner.start(cameras[0]);
          } else if (this.id === 'stop_camera') {
            $('#type_transaction').val("camera");
            $('#preview').fadeOut();
            $('#scan_qr_text').hide();
            scanner.stop();
          } else if (this.id === 'scan_qr_code') {
            scanner.stop();
            $('#pps_no_qr').show();
            $('#type_transaction').val("qrcode");
            $('#pps_no_qr').val("");
            $('#preview').fadeOut();
            $('#qr_scanner_img').fadeIn();
            $('#pps_no_qr').focus();
            $('#scan_qr_text').show();
            
          }
       });
       
        
      } else {
        console.error('No cameras found.');
      }
    }).catch(function (e) {
      console.error(e);
    });
     scanner.addListener('scan',function(c){
      var pps_no = c;
      var url = $( "#urlEventCheckAttendanceCount" ).val();
      var url2 = $( "#urlEventCheckAttendance" ).val();
      var url3 = $( "#urlEventMemberNotAttended" ).val();
      
      var token = $( "#token" ).val();
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': token
          }
      });
      $.ajax({
        type : 'get',
        url: url,
        data : { 'pps_no' : pps_no,
                 'event_id' : $( "#event_id" ).val()
              },
        success:function(res){
         
          var audio = $("audio")[0];
          audio.play();
          $('#btnAttend').prop('disabled', false);
          
          // Check if member is existed in tbl_event_transaction
          if(res >= 1)
          {
            $.ajax({
              type : 'get',
              url: url2,
              data : { 'pps_no' : pps_no,
                       'event_id' : $( "#event_id" ).val()
                    },
              success:function(data){
                $('#pps_no2').val(data.pps_no);
             
                // Check if member paid on the event
                if(data.attendee.paid == true)
                {
                  $('#pps_no2').val(data.attendee.pps_no);
                  var name = data.attendee.first_name + ' ' + data.attendee.middle_name + ' ' + data.attendee.last_name + ' ' + data.attendee.suffix;
                  var joined_dt = moment(data.attendee.joined_dt).format('MMMM DD, YYYY h:mm a');
                  var payment_dt = moment(data.attendee.payment_dt).format('MMMM DD, YYYY h:mm a');

                  $('#attendee_name').text(name);
                  $('#attendee_type').text(data.attendee.type);
                  $('#attendee_gender').text(data.attendee.gender);
                  if(data.prc_number == null)
                  {
                    $('#attendee_prc_no').text("N/A");
                  }
                  else
                  {
                    $('#attendee_prc_no').text(data.prc_number);
                  }
                  $('#payment_status').text('PAID');
                  $('#payment_status').removeClass("text-warning");
                  $('#payment_status').removeClass("text-danger");
                  $('#payment_status').addClass("text-success");
                  $('#member_joined_dt').text(joined_dt);
                  if(data.price == 0)
                  {
                    $('#member_payment_dt').text("N/A (FREE EVENT) ");
                  }
                  else
                  {
                    $('#member_payment_dt').text(payment_dt);
                  }
                  
                  $("#member_picture").attr('src', data.picture_url);
                }

                // Member not paid on the event
                else
                {
                  $('#btnAttend').prop('disabled', true);
                  var name = data.attendee.first_name + ' ' + data.attendee.middle_name + ' ' + data.attendee.last_name + ' ' + data.attendee.suffix;
                  var joined_dt = moment(data.attendee.joined_dt).format('MMMM DD, YYYY h:mm a');
                  $('#attendee_name').text(name);
                  $('#attendee_type').text(data.attendee.type);
                  $('#attendee_gender').text(data.attendee.gender);
                  if(data.prc_number == null)
                  {
                    $('#attendee_prc_no').text("N/A");
                  }
                  else
                  {
                    $('#attendee_prc_no').text(data.attendee.prc_number);
                  }
                  $('#payment_status').text('FOR PAYMENT');
                  $('#payment_status').removeClass("text-danger");
                  $('#payment_status').removeClass("text-success");
                  $('#payment_status').addClass("text-warning");
                  $('#member_joined_dt').text(joined_dt);
                  $('#member_payment_dt').text('N/A');
                  $("#member_picture").attr('src', data.picture_url);
                }
                
                     
              }
            });
          }


          // MEMBER NOT REGISTERED ONLINE
          else{
            $.ajax({
              type : 'get',
              url: url3,
              data : { 'pps_no' : pps_no,
                       'event_id' : $( "#event_id" ).val()
                    },
              success:function(notAttended){
                $('#btnAttend').prop('disabled', true);

                var name = notAttended.non_attendee.first_name + ' ' + notAttended.non_attendee.middle_name + ' ' + notAttended.non_attendee.last_name + ' ' + notAttended.non_attendee.suffix;

                $('#pps_no2').val(notAttended.non_attendee.pps_no);
                $('#attendee_name').text(name);
                $('#attendee_type').text(notAttended.non_attendee.type);
                $('#attendee_gender').text(notAttended.non_attendee.gender);
                if(notAttended.non_attendee.prc_number == null)
                {
                  $('#attendee_prc_no').text("N/A");
                }
                else
                {
                  $('#attendee_prc_no').text(notAttended.non_attendee.prc_number);
                }
                
                $('#payment_status').text('NOT REGISTERED');
                $('#payment_status').removeClass("text-success");
                $('#payment_status').removeClass("text-warning");
                $('#payment_status').addClass("text-danger");
                $('#member_joined_dt').text('N/A');
                $('#member_payment_dt').text('N/A');

                $("#member_picture").attr('src', notAttended.picture_url);
                
              }
            });

          }

              
        }
      });
  
     })
  });


     $('.member').click(function(e){
      
       var url = $( "#urlEventCheckAttendanceCount" ).val();
       var url2 = $( "#urlEventCheckAttendance" ).val();
       var url3 = $( "#urlEventMemberNotAttended" ).val();
       var pps_no = $(this).attr("data-id");


       var token = $( "#token" ).val();
       $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': token
           }
       });

       $.ajax({
        type : 'get',
        url: url,
        data : { 'pps_no' : pps_no,
                 'event_id' : $( "#event_id" ).val()
              },
        success:function(res){
          $('#searchMemberModal').modal('hide');
          $('#btnAttend').prop('disabled', false);
          // Check if member is existed in tbl_event_transaction
          if(res >= 1)
          {
            $.ajax({
              type : 'get',
              url: url2,
              data : { 'pps_no' : pps_no,
                        'event_id' : $( "#event_id" ).val()
                    },
              success:function(data){
                $('#pps_no2').val(data.pps_no);
                // Check if member paid on the event
                if(data.paid == true)
                {
                  var name = data.first_name + ' ' + data.middle_name + ' ' + data.last_name + ' ' + data.suffix;
                  var joined_dt = moment(data.joined_dt).format('MMMM DD, YYYY h:mm a');
                  var payment_dt = moment(data.payment_dt).format('MMMM DD, YYYY h:mm a');

                  $('#attendee_name').text(name);
                  $('#attendee_type').text(data.type);
                  $('#attendee_gender').text(data.gender);
                  if(data.prc_no == null)
                  {
                    $('#attendee_prc_no').text("N/A");
                  }
                  else
                  {
                    $('#attendee_prc_no').text(data.prc_no);
                  }
                  $('#payment_status').text('PAID');
                  $('#payment_status').removeClass("text-warning");
                  $('#payment_status').removeClass("text-danger");
                  $('#payment_status').addClass("text-success");
                  $('#member_joined_dt').text(joined_dt);
                  $('#member_payment_dt').text(payment_dt);
                  $("#member_picture").attr('src','/img/profile/'+data.picture);
                }

                // Member not paid on the event
                else
                {
                  var name = data.first_name + ' ' + data.middle_name + ' ' + data.last_name + ' ' + data.suffix;
                  var joined_dt = moment(data.joined_dt).format('MMMM DD, YYYY h:mm a');
                  $('#attendee_name').text(name);
                  $('#attendee_type').text(data.type);
                  $('#attendee_gender').text(data.gender);
                  if(data.prc_no == null)
                  {
                    $('#attendee_prc_no').text("N/A");
                  }
                  else
                  {
                    
                    $('#attendee_prc_no').text(data.prc_no);
                  }
                  $('#payment_status').text('FOR PAYMENT');
                  $('#payment_status').removeClass("text-danger");
                  $('#payment_status').removeClass("text-success");
                  $('#payment_status').addClass("text-warning");
                  $('#member_joined_dt').text(joined_dt);
                  $('#member_payment_dt').text('N/A');
                  $("#member_picture").attr('src','/img/profile/'+data.picture);
                }
                
              }
            });
          }


          // MEMBER NOT REGISTERED ONLINE
          else{
            $.ajax({
              type : 'get',
              url: url3,
              data : { 'pps_no' : pps_no,
                        'event_id' : $( "#event_id" ).val()
                    },
              success:function(notAttended){

                var name = notAttended.first_name + ' ' + notAttended.middle_name + ' ' + notAttended.last_name + ' ' + notAttended.suffix;
                $('#pps_no2').val(notAttended.pps_no);
                $('#attendee_name').text(name);
                $('#attendee_type').text(notAttended.type);
                $('#attendee_gender').text(notAttended.gender);
                if(notAttended.prc_no == null)
                {
                  $('#attendee_prc_no').text("N/A");
                }
                else
                {
                  $('#attendee_prc_no').text(notAttended.prc_no);
                }
                
                $('#payment_status').text('NOT REGISTERED');
                $('#payment_status').removeClass("text-success");
                $('#payment_status').removeClass("text-warning");
                $('#payment_status').addClass("text-danger");
                $('#member_joined_dt').text('N/A');
                $('#member_payment_dt').text('N/A');
                $("#member_picture").attr('src','/img/profile/'+notAttended.picture);
                
              }
            });

          }
          
              
        }
      });



    }); 
    $("#btnAttend").click(function() {

      if( $('#type_transaction').val() == "qrcode")
        {
          $('#pps_no_qr').focus();
        }
        else{
          $('#searchbox-prc').focus();
        }


      if($('#pps_no2').val() == "")
      {
        $('#pps_no_qr').val("");
        notif.showNotification('top', 'right', 'Warning, please choose attendee first!', 'warning');
      }
      else{
          Swal.fire({
            customClass: {
              confirmButton: "btn bg-gradient-success",
              cancelButton: "btn bg-gradient-danger"
          },
          buttonsStyling: !1,
          
          title: "Are you sure?",
          text: "You want to attend this member on the event?",
          icon: "warning",
          showCancelButton: true,
          showCancelButton: !0,
          confirmButtonText: "Yes, proceed!",
        }).then((result) => {
            if (result.isConfirmed) {
                var url = $( "#urlEventCheckAttendanceCount2" ).val();

                var token = $( "#token" ).val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                });

                $.ajax({
                  type : 'get',
                  url: url,
                  data : { 'pps_no' : $('#pps_no2').val(),
                           'event_id' : $( "#event_id" ).val()
                        },
                  success:function(res){
                    
                    $('#pps_no_qr').val("");

                    // Condition if member attended but not yet paid
                    if(res.status == 'attended_not_paid')
                    {
                      Swal.fire({
                        title: "Success!",
                        text: "Member attended, please note about your pending payment!",
                        icon: "success",
                        confirmButtonText: "Okay"
                      }).then((result) => {
                        window.open(res.download_url, '_blank');
                          
                      });

                      $('#pps_no2').val();
                      $('#attendee_name').text("");
                      $('#attendee_type').text("");
                      $('#attendee_gender').text("");
                      $('#attendee_prc_no').text("");
                      $('#payment_status').text("");
                      $('#member_joined_dt').text("");
                      $('#member_payment_dt').text("");
                      $("#member_picture").attr('src','/img/pps/pps-logo.png');

                    }
                    // Condition if member attended 
                    else if(res.status == 'attended_paid')
                    {
                      Swal.fire({
                        title: "Success!",
                        text: "Member successfully attended!",
                        icon: "success",
                        confirmButtonText: "Okay"
                      }).then((result) => {
                        window.open(res.download_url, '_blank');
                          
                      });

                      $('#pps_no2').val();
                      $('#attendee_name').text("");
                      $('#attendee_type').text("");
                      $('#attendee_gender').text("");
                      $('#attendee_prc_no').text("");
                      $('#payment_status').text("");
                      $('#member_joined_dt').text("");
                      $('#member_payment_dt').text("");
                      $("#member_picture").attr('src','/img/pps/pps-logo.png');

                    }

                    // Condition if member not registered but attended 
                    else if(res.status == 'save_not_registered')
                    {
                      Swal.fire({
                        title: "Success!",
                        text: "Member attended, please note about your pending payment!",
                        icon: "success",
                        confirmButtonText: "Okay"
                      }).then((result) => {

                        window.open(res.download_url, '_blank');
                          
                      });

                      $('#pps_no2').val();
                      $('#attendee_name').text("");
                      $('#attendee_type').text("");
                      $('#attendee_gender').text("");
                      $('#attendee_prc_no').text("");
                      $('#payment_status').text("");
                      $('#member_joined_dt').text("");
                      $('#member_payment_dt').text("");
                      $("#member_picture").attr('src','/img/pps/pps-logo.png');
                    }

                    else if(res.status == 'existing')
                    {
                      Swal.fire("Warning", "Member already attended on this event!", "warning")
                    }


                  }
                });
            }
        });
      }
        
    });
});



