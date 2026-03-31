function deleteApplicant(id)
{

    Swal.fire({

        customClass: {
            confirmButton: "btn bg-gradient-success",
            cancelButton: "btn bg-gradient-danger"
        },
        buttonsStyling: !1,
        
        title: "Are you sure?",
        text: "You want to delete the application of this applicant?",
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
            var token = $("#token").val();
            var url = $( "#urlDelete" ).val();

            $.ajax({
                type : 'get',
                url: url,
                data : { 'id' : id
                        
                         },
                success:function(data){
                  
                    Swal.fire({
                        title: "Deleted!",
                        text: "Member successfuly deleted!",
                        icon: "success",
                        confirmButtonText: "Okay"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload()
                        }
                        else{
                            location.reload()
                        }
                    });
                                                    
                }
            });
        }
    });

    
}

$(document).ready(function() {

    $('#searchbox-input').on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".test").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        }); 
    });

    $('#searchBtn').on("click", function() {
        var value = $("#searchbox-input").val().toLowerCase();
        $(".test").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        }); 
    });

    $("#modalDisapprove").on("show.bs.modal", function(e) {
                
        var first_name = $(e.relatedTarget).data('target-first_name');
        var last_name = $(e.relatedTarget).data('target-last_name');
        var pps_no = $(e.relatedTarget).data('target-pps_no');
        var email_address = $(e.relatedTarget).data('target-email_address');
      
        
        
        var memberName = 'DISAPPROVE' + ' ' + first_name + ' ' + last_name + '?';
        
        $('#disapproveText').text(memberName);
        $('#pps_no').val(pps_no);
        $('#email_address').val(email_address);
        $('#first_name').val(first_name);
        $('#last_name').val(last_name);

        
    });


    $('#disapproveBtn').click(function() {
        if($("#disapprove_reason").val() == "")
        {
            notif.showNotification('top', 'right', 'Warning, please fill-up reason field !', 'warning');
            $("#disapprove_reason").focus();
        }
        else
        {
            notif.showSwal('disapprove-member');
        }
    });

 

});


$(function(){
    $(window).on('load',function(){
        $('#loading2').hide();
    });
});


