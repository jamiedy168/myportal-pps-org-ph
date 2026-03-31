function notpaidconvention()
{
    Swal.fire({
        title: "Warning!",
        text: "You need to pay for the annual convention before taking this examination.",
        icon: "warning",
        confirmButtonText: "Okay"
    })
}

$(document).ready(function () {
    $("#start-facebook-live-btn").click(function () {
        $("#facebook-live-only").show();
        $("#online-video-only").hide();

        $("#start-facebook-live-btn").hide();
        $("#stop-facebook-live-btn").show();

        var url = $( "#urlEventFacebookLiveAttend" ).val();
        var token = $( "#token" ).val();
        var pps_no = $( "#pps_no" ).val();
        var topic_id = $( "#topic_id" ).val();
        var event_id = $( "#event_id" ).val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
          });
          $.ajax({
            type: 'get',
            url: url,
            data: { 'pps_no' : pps_no,
                    'topic_id' : topic_id,
                    'event_id' : event_id,
         },
           
            success: (data) => {
       
              },
              error: function(data) {

              }
          });

    });

    $("#stop-facebook-live-btn").click(function () {
        $("#facebook-live-only").hide();
        $("#online-video-only").show();

        $("#start-facebook-live-btn").show();
        $("#stop-facebook-live-btn").hide();
      $("#reloadDiv").load(window.location.href + " #reloadDiv > *", function () {
        FB.XFBML.parse(); // Reinitialize Facebook embed
    });
        
    });
});

