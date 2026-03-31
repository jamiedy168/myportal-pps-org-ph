$(document).ready(function() {

});

$(document).on('click', '#addOrganizerBtn', function () 
{
    if($("#organizer").val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up organizer !', 'warning');
    }
    else if($("#organizer_type").val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up organizer type !', 'warning');
    }
    else
    {
        var organizer = $("#organizer").val();
        var organizer_type = $("#organizer_type").val();
    
        var url = $( "#urlAddOrganizer" ).val();
        var token = $( "#token" ).val();
        var session = $( "#session" ).val();
    
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
        });
    
        $.ajax({
            type: 'get',
            url: url,
            data: { 'pps_no' : organizer,
                    'organizer_type_id' : organizer_type,
                    'session' : session
         },
           
            success: (data) => {
                if(data == "exist")
                {
                    notif.showNotification('top', 'right', 'Member already selected as organizer on this event!', 'warning');
                }
                else
                {
                    // $("#selectedCommitteeRow").load(" #selectedCommitteeRow > *");
                    // $("#tableRowRefresh").load(window.location + " #tableRowRefresh");
                    $("#selectedOrganizerRow").load(window.location + " #selectedOrganizerRow");
                    $("#organizer").select2("val", "");
                    
                    
                }
               
      
              },
              error: function(data) {
                notif.showNotification('top', 'right', 'Something error!', 'danger');
              }
          });
    }


});


$(document).on('click', '.removeOrganizer', function () 
{

  var id = $(this).data("id");


  var urlRemove = $( "#urlRemoveOrganizer" ).val();
    var token = $( "#token" ).val();
    var id = $(this).data("id");

    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': token
      }
    });

    $.ajax({
      type: 'get',
      url: urlRemove,
      data: { 'pps_no' : id,
   },
     
      success: (response) => {
        $("#selectedOrganizerRow").load(window.location + " #selectedOrganizerRow");

        },
        error: function(data) {
            notif.showNotification('top', 'right', 'Something error!', 'danger');
        }
    });
  

})