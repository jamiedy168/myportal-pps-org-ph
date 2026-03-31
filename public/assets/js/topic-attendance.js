$(document).ready(function() {
    $('.member_chapter').select2({     
        }).on('select2:open', function (e) {
          document.querySelector('.select2-search__field').focus();
    });
});

$(document).on('click', '#adminnotallowed', function () {
    Swal.fire({
        title: "Warning!",
        text: "Admin are not allowed to join on this event!",
        icon: "warning",
        confirmButtonText: "Okay"
    })
});


$(document).on('click', '#attendance_only_choose', function () {
    $("#business_meeting_form").show();
    $("#topic_details").hide();
});


$(document).on('click', '#attendance_only', function () {

  
    if($( "#business_meeting_first_name" ).val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up first name!', 'warning');
    }
    else if($( "#business_meeting_last_name" ).val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up first name!', 'warning');
    }
    else if($( "#business_meeting_prc_number" ).val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up prc_number!', 'warning');
    }
    else if($( "#business_meeting_member_chapter" ).val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please choose member chapter!', 'warning');
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
            text: "You want to proceed?",
            icon: "warning",
            showCancelButton: true,
            showCancelButton: !0,
            confirmButtonText: "Yes, proceed!",
        }).then((result) => {
            if (result.isConfirmed) {
         
                var token = $("#token").val();
                var url = $( "#urlEventTopicAttendNoneQuestion" ).val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                });
                $.ajax({
                    type: 'get',
                    url: url,
                    data: {  
                            'event_id' : event_id, 
                            'event_topic_id' : event_topic_id,
                            'event_topic_name' : $("#topic_name").val(),
                            'business_meeting_first_name' : $("#business_meeting_first_name").val(),
                            'business_meeting_last_name' : $("#business_meeting_last_name").val(),
                            'business_meeting_prc_number' : $("#business_meeting_prc_number").val(),
                            'business_meeting_member_chapter' : $("#business_meeting_member_chapter").val(),
                            
                            
                     },
                   
                    success: (data) => {

                         if(data.message == "notpaid")
                         {
                            Swal.fire({
                                title: "Registration Reminder!",
                                text: "You need to pay for the annual convention before joining this business meeting.",
                                icon: "warning",
                                confirmButtonText: "Okay"
                            })
                         }
        
    
                        else if(data.message == "alreadyattended")
                        {
                            var messages = "You've already joined this topic, and your attendance has already been recorded."
                            Swal.fire({
                                title: "Already Registered!",
                                text: messages,
                                icon: "warning",
                                confirmButtonText: "Okay"
                            })
                        }
                        else if(data.message == "notallowedbusinessmeeting")
                        {
                            Swal.fire({
                                title: "Registration Reminder!",
                                text: "Only individuals recognized as Diplomates, Fellows, and Emeritus Fellows of PPS are permitted to participate in the Business Meeting.",
                                icon: "warning",
                                confirmButtonText: "Okay"
                            })
                        }
    
                        else if(data.message == "success_business_meeting")
                        {
                            var message = 'Congratulations on completing the session on ' + data.event_topic_name + '! Your engagement and insights are invaluable. Check your profile for updates on CPD points and upcoming sessions.';
    
                            Swal.fire({
                                title: "Session Completed!",
                                text: "Welcome to the 2025 PPS Business Meeting. Your attendance has been recorded. ",
                                icon: "success",
                                confirmButtonText: "Okay"
                            }).then((result) => {
                                window.location.href = '/sign-in'
                              });
                        }
                        
                        else
                        {
                            var message = 'Congratulations on completing the session on ' + data.event_topic_name + '! Your engagement and insights are invaluable. Check your profile for updates on CPD points and upcoming sessions.';
    
                            Swal.fire({
                                title: "Session Completed!",
                                text: message,
                                icon: "success",
                                confirmButtonText: "Okay"
                            }).then((result) => {
                                window.location.href = '/sign-in'
                          });
                        }
                     
                
                    },
                    error: function(data) { 
                        Swal.fire({
                            title: "Warning!",
                            text: "PRC Number not found",
                            icon: "warning",
                            confirmButtonText: "Okay"
                        })
                    }
                });
               
            }
        });
    }
    

});


$(document).on('click', '#attendance_with_question_choose', function () {
    $("#examination_form").show();
    $("#topic_details").hide();
});

$(document).on('click', '#attendance_with_question', function () {

    var token = $("#token").val();
    var url = $( "#urlEventTopicAttendWithQuestion" ).val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token
        }
    });


    if($( "#examination_first_name" ).val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up first name!', 'warning');
    }
    else if($( "#examination_last_name" ).val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up first name!', 'warning');
    }
    else if($( "#examination_prc_number" ).val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up prc_number!', 'warning');
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
            text: "You want to proceed?",
            icon: "warning",
            showCancelButton: true,
            showCancelButton: !0,
            confirmButtonText: "Yes, proceed!",
        }).then((result) => {
            if (result.isConfirmed) {
                
                $.ajax({
                    type: 'get',
                    url: url,
                    data: {   
                            'event_id' : event_id, 
                            'event_topic_id' : event_topic_id,
                            'event_topic_name' : $("#topic_name").val(),
                            'examination_first_name' : $("#examination_first_name").val(),
                            'examination_last_name' : $("#examination_last_name").val(),
                            'examination_prc_number' : $("#examination_prc_number").val(),
                            
                    },
                
                    success: (data) => {

                        if(data.message == "notpaid")
                        {
                            Swal.fire({
                                title: "Registration Reminder!",
                                text: "You need to pay for the annual convention before joining this session.",
                                icon: "warning",
                                confirmButtonText: "Okay"
                            })
                        }
                      
                        else if(data.message == 'alreadyattended')
                        {
                            Swal.fire({
                                title: "Registration Reminder!",
                                text: "Please note that you have already attended this topic.",
                                icon: "warning",
                                confirmButtonText: "Okay"
                            })
                        }
                        else
                        {
                            window.location=data.url;
                        }
    
                    },
                    error: function(data) { 
                        Swal.fire({
                            title: "Warning!",
                            text: "PRC Number not found",
                            icon: "warning",
                            confirmButtonText: "Okay"
                        })
                    }
                });
                
            }
        });
    }

  

 



});

$(document).on('click', '#plenary_btn_choose', function () {
    $("#plenary_form").show();
    $("#topic_details").hide();
});


$(document).on('click', '#plenary_btn', function () {

    var token = $("#token").val();
    var url = $( "#urlEventTopicAttendPlenary" ).val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token
        }
    });

    if($( "#plenary_first_name" ).val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up first name!', 'warning');
    }
    else if($( "#plenary_last_name" ).val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up first name!', 'warning');
    }
    else if($( "#plenary_prc_number" ).val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up prc_number!', 'warning');
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
            text: "You want to proceed?",
            icon: "warning",
            showCancelButton: true,
            showCancelButton: !0,
            confirmButtonText: "Yes, proceed!",
        }).then((result) => {
            
    
            if (result.isConfirmed) {
                
                $.ajax({
                    type: 'get',
                    url: url,
                    data: {  
                            'event_id' : event_id, 
                            'event_topic_id' : event_topic_id,
                            'plenary_first_name' : $("#plenary_first_name").val(),
                            'plenary_last_name' : $("#plenary_last_name").val(),
                            'plenary_prc_number' : $("#plenary_prc_number").val(),
                            
                    },
                
                    success: (data) => {
                        
    
                        if(data.message == 'alreadyattended')
                        {
                            Swal.fire({
                                title: "Registration Reminder!",
                                text: "Please be aware that you have already completed the evaluation form.",
                                icon: "warning",
                                confirmButtonText: "Okay"
                            })
                        }
                        else if(data.message == "notpaid")
                        {
                            Swal.fire({
                                title: "Registration Reminder!",
                                text: "You need to pay for the annual convention before joining this plenary session.",
                                icon: "warning",
                                confirmButtonText: "Okay"
                            })
                        }
                        else
                        {
                            window.location=data.url;
                        }
                        // else if(data.message == 'accept')
                        // {
                        //     window.location=data.url;
                        // }
                        // else
                        // {
                        //     Swal.fire({
                        //         title: "Registration Reminder!",
                        //         text: "You need to pay for the annual convention before joining this business meeting.",
                        //         icon: "warning",
                        //         confirmButtonText: "Okay"
                        //     })
    
                        // }
                        // else
                        // {
                        //     Swal.fire({
                        //         title: "Registration Reminder!",
                        //         text: "We noticed you still need to register at the main entrance for the annual convention. Please do so to enjoy full access to all sessions and activities.",
                        //         icon: "warning",
                        //         confirmButtonText: "Okay"
                        //     })
                        // }
                    },
                    error: function(data) { 
                        Swal.fire({
                            title: "Warning!",
                            text: "PRC Number not found",
                            icon: "warning",
                            confirmButtonText: "Okay"
                        })
                    }
                });
                
            }
        });
    }

   


});




