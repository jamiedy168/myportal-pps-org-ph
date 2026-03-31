$(document).ready(function() {
    $(".selectcommittee2").click(function() {
    var url = $( "#urlSelectCommittee" ).val();
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
      data: { 'pps_no' : this.id,
              'session' : session
   },
     
      success: (data) => {
          if(data == "exist")
          {
            notif.showNotification('top', 'right', 'Member already selected as committee on this event!', 'warning');
          }
          else{

           $("#selectedCommitteeRow").load(" #selectedCommitteeRow > *");
           $("#commiteeBtnCount").load(" #commiteeBtnCount > *");
           
  
          }
         

        },
        error: function(data) {
            // console.log(data);
        }
    });
    
  });

  $(document).on('click', '.removeCommittee', function () 
  {

    var id = $(this).data("id");

    var urlRemove = $( "#urlRemoveCommittee" ).val();
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
          $("#selectedCommitteeRow").load(" #selectedCommitteeRow > *");
          $("#commiteeBtnCount").load(" #commiteeBtnCount > *");

          },
          error: function(data) {
              // console.log(data);
          }
      });
    

  })

  

  
  
});


