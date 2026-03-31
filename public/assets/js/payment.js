
$('#residencycert').click(function() {
    Swal.fire({
        customClass: {
            confirmButton: "btn bg-gradient-success",
            cancelButton: "btn bg-gradient-danger"
        },
        buttonsStyling: !1,
        
        title: "Warning!",
        text: "You need to upload your residency certificate before joining this event. Do you want to proceed to the upload page?",
        icon: "warning",
        showCancelButton: !0,
        confirmButtonText: "Yes, proceed!"
    }).then((result) => {
        if (result.isConfirmed) {
            var firsturl = "/user-maintenance-upload-certificate/";
            var pps_no = $('#pps_no_encrypt').val();
            window.location.href = firsturl + pps_no;
        }
    });
});


$('#governmentcert').click(function() {
    Swal.fire({
        customClass: {
            confirmButton: "btn bg-gradient-success",
            cancelButton: "btn bg-gradient-danger"
        },
        buttonsStyling: !1,
        
        title: "Warning!",
        text: "You need to upload your government physician certificate before joining this event. Do you want to proceed to the upload page?",
        icon: "warning",
        showCancelButton: !0,
        confirmButtonText: "Yes, proceed!"
    }).then((result) => {
        if (result.isConfirmed) {
            var firsturl = "/user-maintenance-upload-certificate/";
            var pps_no = $('#pps_no_encrypt').val();
            window.location.href = firsturl + pps_no;
        }
    });
});

$('#fellowscert').click(function() {
    Swal.fire({
        customClass: {
            confirmButton: "btn bg-gradient-success",
            cancelButton: "btn bg-gradient-danger"
        },
        buttonsStyling: !1,
        
        title: "Warning!",
        text: "You need to upload your fellows in training certificate before joining this event. Do you want to proceed to the upload page?",
        icon: "warning",
        showCancelButton: !0,
        confirmButtonText: "Yes, proceed!"
    }).then((result) => {
        if (result.isConfirmed) {
            var firsturl = "/user-maintenance-upload-certificate/";
            var pps_no = $('#pps_no_encrypt').val();
            window.location.href = firsturl + pps_no;
        }
    });
});

$('#noimage').click(function() {
    Swal.fire({
        customClass: {
            confirmButton: "btn bg-gradient-success",
            cancelButton: "btn bg-gradient-danger"
        },
        buttonsStyling: !1,
        
        title: "Warning!",
        text: "You need to upload your profile image first before joining this event. Do you want to proceed to the update profile page?",
        icon: "warning",
        showCancelButton: !0,
        confirmButtonText: "Yes, proceed!"
    }).then((result) => {
        if (result.isConfirmed) {
            var firsturl = "/member-info-update/";
            var pps_no = $('#pps_no_encrypt').val();
            window.location.href = firsturl + pps_no;
        }
    });
});







$(document).ready(function() {
    $("input[name$='payment_type']").click(function() {
        var type = $(this).val();


        $("div.desc").hide();
        $(".payment" + type).show();
    });

});

$(document).on('click', '#proceed_payment_btn', function () {

    if($('input[name="topic_id"]:checked').val() == null)
    {
        notif.showNotification('top', 'right', 'Warning, please choose one topic first!', 'warning');
    }
    else
    {
        var url = $( "#urlCountTopicAttendee" ).val();
        var token = $( "#token" ).val();
    
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': token
          }
        });
        
        $.ajax({
          type: 'get',
          url: url,
          data: { 'topic_id' : $('input[name="topic_id"]:checked').val(),
                   'event_id' : $('#event_id').val(),
       },
         
          success: (data) => {
            if(data == "maxlimit")
            {
                notif.showNotification('top', 'right', 'Warning, this topic already reach the maximum participant that allowed to join, please choose another topic!', 'warning');
            }
            else
            {
                 $('form#payment_online').submit();
            }
    
          },
          error: function(data) {
             Swal.fire({
                    title: "Warning!",
                    text: "Something went wrong!",
                    icon: "error",
                    confirmButtonText: "Okay"
                })
          }
        });
    }




});




