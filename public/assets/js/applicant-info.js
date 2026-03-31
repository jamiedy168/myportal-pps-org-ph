$(document).ready(function() {

    $('.member_status').select2({     
        dropdownParent: $("#modal-notification")  
        }).on('select2:open', function (e) {
          document.querySelector('.select2-search__field').focus();
    });

    $('.member_type').select2({     
        dropdownParent: $("#modal-notification")  
        }).on('select2:open', function (e) {
          document.querySelector('.select2-search__field').focus();
    });

    $('.member_chapter').select2({     
        dropdownParent: $("#modal-notification")  
        }).on('select2:open', function (e) {
          document.querySelector('.select2-search__field').focus();
    });

    

    $('#acceptApplicant').click(function() {
        $("#loading").fadeIn();

        var token = $("#token").val();
        var urls = $( "#urlAccept" ).val();
        var pps_no = $( "#pps_no" ).val();
        var password = $( "#password" ).val();
        var first_name = $( "#first_name" ).val();
        var last_name = $( "#last_name" ).val();
        var email_address = $( "#email_address" ).val();
        var picture = $( "#picture" ).val();
        
    

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
        });

        $.ajax({
            type : 'get',
            url: urls,
            data : { 'pps_no' : pps_no,
                     'password' : password,
                     'first_name' : first_name,
                     'last_name' : last_name,
                     'email_address' : email_address,
                     'picture' : picture
                     },
            success:function(res){
                $("#loading").fadeOut();
                $('#modal-notification').modal('hide');
                Swal.fire({
                    title: "Saved!",
                    text: "Member successfuly approve!",
                    icon: "success",
                    confirmButtonText: "Okay"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location=res.url;
                    }
                    else{
                        window.location=res.url;
                    }
                });
                
                                                
            }
        });

    });


    $('#applicantSave').submit(function(e) {
        e.preventDefault();

        Swal.fire({

            customClass: {
                confirmButton: "btn bg-gradient-success",
                cancelButton: "btn bg-gradient-danger"
            },
            buttonsStyling: !1,
            
            title: "Are you sure?",
            text: "You want to add this applicant as official member of Philippine Pediatric Society Inc.?",
            icon: "warning",
            showCancelButton: true,
            showCancelButton: !0,
            confirmButtonText: "Yes, proceed!",
            
        }).then((result) => {
            if (result.isConfirmed) {

                    $("#loading").fadeIn();
                    var token = $("#token").val();
                    var url = $( "#urlAccept" ).val();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': token
                        }
                    });

                    var formData = new FormData(this);
                    
                    formData.append('pps_no',$( "#pps_no" ).val());
                    formData.append('first_name',$( "#first_name" ).val());
                    formData.append('last_name',$( "#last_name" ).val());
                    formData.append('email_address',$( "#email_address" ).val());
                    formData.append('picture',$( "#picture" ).val());
                    formData.append('password',$( "#password" ).val());
                    // formData.append('member_status',$( "#member_status" ).val());
                    formData.append('member_type',$( "#member_type" ).val());
                    // formData.append('member_chapter',$( "#member_chapter" ).val());
                    
                    
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
                                text: "Applicant successfully added as official member of Philippine Pediatric Society",
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

    });

    $('#disapproveBtn').click(function() {
      
        if($("#disapprove_reason2").val() == "")
        {
            notif.showNotification('top', 'right', 'Warning, please fill-up reason field !', 'warning');
            $("#disapprove_reason2").focus();
        }
        else
        {
            notif.showSwal('disapprove-member2');
        }
    });
});

$(function(){
    $(window).on('load',function(){
        $('#loading6').hide();

    });
});