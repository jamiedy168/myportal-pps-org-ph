

$("#userTypeBtn").click(function(){
    if($("#user_type").val() == "HOSPITAL")
        {
            window.location.href = '/user-maintenance-new-hospital';

        }   
    else if($("#user_type").val() == "ATTENDANCE")
        {
            window.location.href = '/user-maintenance-new-attendance';

        }     
});

$(document).ready(function() {


    if($('.user_type').length > 0)
    {
        $('.user_type').select2({     
            dropdownParent: $("#modalNewUser")  
            }).on('select2:open', function (e) {
              document.querySelector('.select2-search__field').focus();
        });
    }

    if($('.hospital').length > 0)
        {
            $('.hospital').select2({     
                }).on('select2:open', function (e) {
                  document.querySelector('.select2-search__field').focus();
            });
        }

    
    
    if($('.gender').length > 0)
    {
        $('.gender').select2({     
        }).on('select2:open', function (e) {
        document.querySelector('.select2-search__field').focus();
        });
    }

    if($('.member_chapter').length > 0)
    {
        $('.member_chapter').select2({     
        }).on('select2:open', function (e) {
        document.querySelector('.select2-search__field').focus();
        });
    }

    if($('.member_type').length > 0)
    {
        $('.member_type').select2({     
        }).on('select2:open', function (e) {
        document.querySelector('.select2-search__field').focus();
        });
    }

    if($('.classification').length > 0)
    {
        $('.classification').select2({     
        }).on('select2:open', function (e) {
        document.querySelector('.select2-search__field').focus();
        });
    }

    if($('.roles').length > 0)
    {
        $('.roles').select2({     
        }).on('select2:open', function (e) {
        document.querySelector('.select2-search__field').focus();
        });
    }

    if($('.is_active').length > 0)
    {
        $('.is_active').select2({     
        }).on('select2:open', function (e) {
            document.querySelector('.select2-search__field').focus();
        });
    }

    if($('.country_code').length > 0)
    {
        $('.country_code').select2({     
        }).on('select2:open', function (e) {
        document.querySelector('.select2-search__field').focus();
        });
    }

  
 
});

// $(function(){
//     $(window).on('load',function(){
//         $('#loading').hide();
      
//     });
// });

$('#user-update-image').submit(function(e) {
    e.preventDefault();

    if (document.getElementById("file-input-profile").files.length == 0) {
        notif.showNotification('top', 'right', 'Warning, please upload picture!', 'warning');
        document.getElementById("file-input-profile").focus();
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
            text: "You want to update your image?",
            icon: "warning",
            showCancelButton: true,
            showCancelButton: !0,
            confirmButtonText: "Yes, proceed!",
            
        }).then((result) => {
            if (result.isConfirmed) {
                $("#loading2").fadeIn();
                var token = $("#token").val();
                var url = $( "#urlUserMaintenanceUpdateImage" ).val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                });
    
                var picture = $('#file-input-profile').prop('files')[0];
    
                var formData = new FormData(this);
                        
                formData.append('pps_no',$( "#pps_no" ).val());
                formData.append('picture', picture);
    
    
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $("#loading2").fadeOut();
                        Swal.fire({
                            title: "Saved!",
                            text: "User image successfully updated",
                            icon: "success",
                            confirmButtonText: "Okay"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                                
                            }
                            else{
                                location.reload();
                            }
                        });
    
                    },
                    error: function(data) {
                        $("#loading2").fadeOut();
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
        
    } 



});


$('#user-maintenance-update').submit(function(e) {
    e.preventDefault();

    if($( "#first_name" ).val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up first name!', 'warning');
    }
    else if($( "#last_name" ).val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up last name!', 'warning');
    }   
    // else if($( "#member_chapter" ).val() == "")
    // {
    //     notif.showNotification('top', 'right', 'Warning, please fill-up chapter!', 'warning');
    // }

    else if($( "#birthdate" ).val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up birthdate!', 'warning');
    }

    else if($( "#gender" ).val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up gender!', 'warning');
    }
    
    
    else if($( "#member_type" ).val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up type!', 'warning');
    } 
    // else if($( "#member_chapter" ).val() == "")
    // {
    //     notif.showNotification('top', 'right', 'Warning, please fill-up chapter!', 'warning');
    // } 
    else if($( "#member_type" ).val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up member type!', 'warning');
    } 
    else if($( "#member_classification" ).val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up classification!', 'warning');
    } 
    else if($( "#roles" ).val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up role!', 'warning');
    } 
    else if($( "#is_active" ).val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up status!', 'warning');
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
            text: "You want to update the user information?",
            icon: "warning",
            showCancelButton: true,
            showCancelButton: !0,
            confirmButtonText: "Yes, proceed!",
            
        }).then((result) => {
            if (result.isConfirmed) {
    
                    $("#loading").fadeIn();
                    var token = $("#token").val();
                    var url = $( "#urlUserMaintenanceUpdate" ).val();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': token
                        }
                    });
    
                    var formData = new FormData(this);
                    
                    formData.append('first_name',$( "#first_name" ).val());
                    formData.append('middle_name',$( "#middle_name" ).val());
                    formData.append('last_name',$( "#last_name" ).val());
                    formData.append('birthdate',$( "#birthdate" ).val());
                    formData.append('gender',$( "#gender" ).val());
                    formData.append('telephone_number',$( "#telephone_number" ).val());
                    formData.append('mobile_number',$( "#mobile_number" ).val());
                    formData.append('prc_number',$( "#prc_number" ).val());
                    formData.append('prc_registration_dt',$( "#prc_registration_dt" ).val());
                    formData.append('prc_validity',$( "#prc_validity" ).val());
                    formData.append('pma_number',$( "#pma_number" ).val());
                    
                    
                    
                    
                    formData.append('user_id',$( "#user_id" ).val());
                    formData.append('member_chapter',$( "#member_chapter" ).val());
                    formData.append('member_type',$( "#member_type" ).val());
                    formData.append('member_classification',$( "#member_classification" ).val());
                    formData.append('roles',$( "#roles" ).val());
                    formData.append('is_active',$( "#is_active" ).val());
                    formData.append('fellowintraining',$( "#fellowintraining" ).val());
                   
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: (data) => {
                            $("#loading").fadeOut();
                            Swal.fire({
                                title: "Saved!",
                                text: "User info successfully updated",
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
                                text: "Something error",
                                icon: "error",
                                confirmButtonText: "Okay"
                            })
                        }
                    });
                  
                  
            }
        });
    }

    


});

function reset_password(id)
  {

      Swal.fire({

        customClass: {
            confirmButton: "btn bg-gradient-success",
            cancelButton: "btn bg-gradient-danger"
        },
        buttonsStyling: !1,
        
        title: "Are you sure?",
        text: "You want reset the password of this user?",
        icon: "warning",
        showCancelButton: true,
        showCancelButton: !0,
        confirmButtonText: "Yes, proceed!",
        
    }).then((result) => {
        if (result.isConfirmed) {

                $("#loading").fadeIn();
                var token = $("#token").val();
                var url = $( "#urlUserMaintenanceResetPassword" ).val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                });

                $.ajax({
                    type: 'get',
                    url: url,
                    data: { 'id' : id,
                          },
                    success: (data) => {
                       
                        $("#loading").fadeOut();
                        Swal.fire({
                            title: "Success!",
                            text: "Password successfully reset",
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
  }


  $('#maintenance-user-email-update').submit(function(e) {
    e.preventDefault();
    $("#email_address").val();
    

    Swal.fire({

        customClass: {
            confirmButton: "btn bg-gradient-success",
            cancelButton: "btn bg-gradient-danger"
        },
        buttonsStyling: !1,
        
        title: "Are you sure?",
        text: "You want to update your email address?",
        icon: "warning",
        showCancelButton: true,
        showCancelButton: !0,
        confirmButtonText: "Yes, proceed!",
        
    }).then((result) => {
        if (result.isConfirmed) {
            $("#loading").fadeIn();
            var token = $("#token").val();
            var url = $( "#urlUserMaintenanceResetEmail" ).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });
            var formData = new FormData(this);
                    
            formData.append('email_address',$( "#email_address" ).val());
            formData.append('user_id',$( "#user_id" ).val());
            
           
            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    $("#loading").fadeOut();
                    if(data=="exist")
                        {
                            Swal.fire({
                                title: "Warning!",
                                text: "Email address already exist",
                                icon: "error",
                                confirmButtonText: "Okay"
                            })
                        }
                    else
                        {
                            Swal.fire({
                                title: "Success!",
                                text: "User email successfully updated",
                                icon: "success",
                                confirmButtonText: "Okay"
                            }).then((result) => {
                                window.location.href = '/dashboard'
                               
                            });
                        }
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



  $('#user-maintenance-add-new-hospital').submit(function(e) {
    e.preventDefault();

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
            var url = $( "#urlUserMaintenanceAddNewHospital" ).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });

            var formData = new FormData(this);
                    
            formData.append('default',$( "#password" ).val());
            formData.append('first_name',$( "#first_name" ).val());
            formData.append('middle_name',$( "#middle_name" ).val());
            formData.append('last_name',$( "#last_name" ).val());
            formData.append('suffix',$( "#suffix" ).val());
            formData.append('username',$( "#username" ).val());
            formData.append('hospital_id',$( "#hospital_id" ).val());


            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    if(data == "existusername")
                        {
                            Swal.fire({
                                title: "Warning!",
                                text: "Username already exist",
                                icon: "warning",
                                confirmButtonText: "Okay"
                            })
                        }
                    else
                        {
                            Swal.fire({
                                title: "Succes!",
                                text: "New user successfully added",
                                icon: "success",
                                confirmButtonText: "Okay"
                            }).then((result) => {
                                window.location.href = '/user-maintenance';
                            });
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
    });


});


$('#user-maintenance-add-new-attendance').submit(function(e) {
    e.preventDefault();
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
            var url = $( "#urlUserMaintenanceAddNewAttendance" ).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });

            var formData = new FormData(this);
                    
            formData.append('default',$( "#password" ).val());
            formData.append('first_name',$( "#first_name" ).val());
            formData.append('middle_name',$( "#middle_name" ).val());
            formData.append('last_name',$( "#last_name" ).val());
            formData.append('suffix',$( "#suffix" ).val());
            formData.append('username',$( "#username" ).val());



            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    if(data == "existusername")
                        {
                            Swal.fire({
                                title: "Warning!",
                                text: "Email already exist",
                                icon: "warning",
                                confirmButtonText: "Okay"
                            })
                        }
                    else
                        {
                            Swal.fire({
                                title: "Succes!",
                                text: "New attendance user successfully added",
                                icon: "success",
                                confirmButtonText: "Okay"
                            }).then((result) => {
                                window.location.href = '/user-maintenance';
                            });
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
    });


});



