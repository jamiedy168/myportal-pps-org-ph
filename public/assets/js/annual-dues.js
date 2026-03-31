$(document).ready(function() {
    $('.year').select2({     
        }).on('select2:open', function (e) {
          document.querySelector('.select2-search__field').focus();
    });
});


$(function(){
    $(window).on('load',function(){
        $('#loading3').hide();

    });
});


$('#save-annual-dues').submit(function(e) {
    e.preventDefault();

    if($( "#description" ).val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up description!', 'warning');
    }
    else if($( "#amount" ).val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up amount!', 'warning');
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
            text: "You want to create this annual fee and notify member?",
            icon: "warning",
            showCancelButton: true,
            showCancelButton: !0,
            confirmButtonText: "Yes, proceed!",
            
        }).then((result) => {
            if (result.isConfirmed) {
    
                    $("#loading3").fadeIn();
                    var token = $("#token").val();
                    var url = $( "#urlAnnualSave" ).val();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': token
                        }
                    });
    
                    var formData = new FormData(this);
                    
                    formData.append('description',$( "#description" ).val());
                    formData.append('amount',$( "#amount" ).val());
                    formData.append('year_dues',$( "#year_dues" ).val());
                   
                    
                    
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: (data) => {
                            $("#loading3").fadeOut();
                            if(data == "exist")
                            {
                                Swal.fire({
                                    title: "Warning!",
                                    text: "Year of annual dues already created.",
                                    icon: "error",
                                    confirmButtonText: "Okay"
                                })
                            }
                            else
                            {
                                Swal.fire({
                                    title: "Saved!",
                                    text: "Annual Dues successfully created",
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
    }


});