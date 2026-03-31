$(document).ready(function(){



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


      $('#send-email-reset-password').submit(function(e) {
        e.preventDefault();
    
        // Show SweetAlert loading dialog
        Swal.fire({
            title: 'Sending...',
            text: 'Please wait while we process your request.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    
        var token = $("#token").val();
        var url = $("#urlSendEmailResetPassword").val();
    
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
        });
    
        var formData = new FormData(this);        
        formData.append('email_address', $("#email_address").val());
    
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                Swal.close(); // Close the loading dialog
    
                if (data == "notfound") {
                    Swal.fire({
                        title: "Warning!",
                        text: "Email not found",
                        icon: "warning",
                        confirmButtonText: "Okay"
                    });
                } else {
                    Swal.fire({
                        title: "Success!",
                        text: "Please check your email to know how to change your password.",
                        icon: "success",
                        confirmButtonText: "Okay"
                    }).then((result) => {
                        window.location = data.url;
                    });
                }
            },
            error: function(data) {
                Swal.close(); // Close the loading dialog in case of error
    
                Swal.fire({
                    title: "Error!",
                    text: "Something went wrong. Please try again.",
                    icon: "error",
                    confirmButtonText: "Okay"
                });
            }
        });
    });
    


      $('#reset-password').submit(function(e) {
        e.preventDefault();
        $("#loading").fadeIn();
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
          var url = $( "#urlResetPasswordSubmit" ).val();
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': token
              }
          });
          var formData = new FormData(this);        
          formData.append('password',$( "#password" ).val());
          formData.append('email_address',$( "#email_address" ).val());
          
    
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
                    title: "Success!",
                    text: "Password successfully changed",
                    icon: "success",
                    confirmButtonText: "Okay"
                }).then((result) => {
                    if (result.isConfirmed) 
                    {
                      window.location=data.url;
                    }
                    else
                    {
                      window.location=data.url;
                    }
                 
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

})


$(function(){
    $(window).on('load',function(){
        $('#loading').hide();

    });
});