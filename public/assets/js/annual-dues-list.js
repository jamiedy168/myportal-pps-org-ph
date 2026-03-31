$(document).ready(function() {

    $(function(){
        $(window).on('load',function(){
            $('#loading2').hide();
        
        });
    });

    $("#modalUpdateAnnualDues").on("show.bs.modal", function(e) {
    
        var id = $(e.relatedTarget).data('target-id');
        var description = $(e.relatedTarget).data('target-description');
        var amount = $(e.relatedTarget).data('target-amount');
        var year_dues = $(e.relatedTarget).data('target-year_dues');
        
        // var email_update = $(e.relatedTarget).data('target-email-update');
        // var email_status = $(e.relatedTarget).data('target-email-status');
    
        $('#annual_dues_id').val(id);
        $('#description').val(description);
        $('#amount').val(amount);

        $("#year_dues").select2().val(year_dues).trigger("change");
        // $("input[name=status_update]").val([email_status]);
        // $('#pps_email_update_2').val(email_update);
        
    
    });

    $('#update-annual-dues').submit(function(e) {
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
                
                title: "Are you sure",
                text: "You want to update this annual fee?",
                icon: "warning",
                showCancelButton: true,
                showCancelButton: !0,
                confirmButtonText: "Yes, proceed!",
                
            }).then((result) => {
                if (result.isConfirmed) {
        
                        $("#loading3").fadeIn();
                        var token = $("#token").val();
                        var url = $( "#urlAnnualUpdate" ).val();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': token
                            }
                        });
        
                        var formData = new FormData(this);
                        
                        formData.append('id',$( "#annual_dues_id" ).val());
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
                             
                                    Swal.fire({
                                        title: "Success!",
                                        text: "Annual Dues successfully updated",
                                        icon: "success",
                                        confirmButtonText: "Okay"
                                    }).then((result) => {
                                        location.reload();
                                    });
                        
                            },
                            error: function(data) { 
                                $("#loading3").fadeOut();
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

});


function deleteAnnualDues(id)
{
    Swal.fire({

        customClass: {
            confirmButton: "btn bg-gradient-success",
            cancelButton: "btn bg-gradient-danger"
        },
        buttonsStyling: !1,
        
        title: "Are you sure",
        text: "You want to delete this annual fee?",
        icon: "warning",
        showCancelButton: true,
        showCancelButton: !0,
        confirmButtonText: "Yes, proceed!",
        
    }).then((result) => {
        if (result.isConfirmed) {

                var token = $("#token").val();
                var url = $( "#urlAnnualDelete" ).val();
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
                        
                            Swal.fire({
                                title: "Deleted!",
                                text: "Annual Dues successfully deleted",
                                icon: "success",
                                confirmButtonText: "Okay"
                            }).then((result) => {
                                location.reload();
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
}
