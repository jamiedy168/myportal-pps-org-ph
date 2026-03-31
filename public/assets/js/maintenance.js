
$("#modalUpdate").on("show.bs.modal", function(e) {
    
    var id = $(e.relatedTarget).data('target-id');
    var email_update = $(e.relatedTarget).data('target-email-update');
    var email_status = $(e.relatedTarget).data('target-email-status');

    $('#email_id').val(id);
    $('#pps_email_update').val(email_update);
    $("input[name=status_update]").val([email_status]);
    $('#pps_email_update_2').val(email_update);
    

});


$("#modalDelete").on("show.bs.modal", function(e) {
    
    var id = $(e.relatedTarget).data('target-id');
  

    $('#delete_id').val(id);
   
    
    
});


$(document).ready(function() {
    if($('.pps_member').length > 0)
    {
        $('.pps_member').select2({  
            minimumInputLength: 2,     
        }).on('select2:open', function (e) {
        document.querySelector('.select2-search__field').focus();
        });
    }


});



function removeParticipant(id,event_id)
  {

    var url = $( "#urlEventRemoveLiveStreamMember" ).val();
    var token = $( "#token" ).val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token
        }
    });

    $.ajax({
        type: 'get',
        url: url,
        data: { 'event_id' : event_id,
                'pps_no' : id
     },
       
        success: (data) => {
            $( "#refreshDiv" ).load(window.location.href + " #refreshDiv" );
            notif.showNotification('top', 'right', 'Success, participant successfully removed from event livestream!', 'success');

            
          },
          error: function(data) {
            
          }
      });
  }

$(document).on('click', '#addParticipantBtn', function () {

    var event_id = $( "#event_id" ).val();
    var pps_no = $('#pps_member').val();
    var url = $( "#urlEventAddLiveStreamMember" ).val();
    var token = $( "#token" ).val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token
        }
    });

    $.ajax({
        type: 'get',
        url: url,
        data: { 'event_id' : event_id,
                'pps_no' : pps_no
     },
       
        success: (data) => {
            if(data=="exist")
            {
                notif.showNotification('top', 'right', 'Warning, participant already selected!', 'warning');
            }
            else
            {
                $( "#refreshDiv" ).load(window.location.href + " #refreshDiv" );
                notif.showNotification('top', 'right', 'Success, participant successfully selected event livestream!', 'success');

            }
            
          },
          error: function(data) {
            
          }
      });
      

  
    
});







