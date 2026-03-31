$(document).ready(function() {
    $('.status').select2({        
      dropdownParent: $('#modalUpdateElection').closest('div')
     
    }).on('select2:open', function (e) {
        document.querySelector('.select2-search__field').focus();
    });

    $('.status2').select2({        
        dropdownParent: $('#modalUpdateElectionStatus').closest('div')
       
      }).on('select2:open', function (e) {
          document.querySelector('.select2-search__field').focus();
      });

    $('.candidate_pps_no').select2({  
      dropdownParent: $('#modalAddBOT').closest('div'), 
      minimumInputLength: 2,      
    }).on('select2:open', function (e) {
        document.querySelector('.select2-search__field').focus();
    });

    $('#chaprep_candidate_pps_no').select2({  
      dropdownParent: $('#modalAddChapRep').closest('div'), 
      minimumInputLength: 2,      
    }).on('select2:open', function (e) {
        document.querySelector('.select2-search__field').focus();
    });


});



$('#modalUpdateElection').on('hidden.bs.modal', function () {


  $("#profile_picture").attr('src','/img/placeholder.jpg');

  $(this).find('form').trigger('reset');
  $(this).removeData('bs.modal');
});


$('#update-election-form').submit(function(e) {
  e.preventDefault();
    Swal.fire({

      customClass: {
          confirmButton: "btn bg-gradient-success",
          cancelButton: "btn bg-gradient-danger"
      },
      buttonsStyling: !1,
      
      title: "Are you sure",
      text: "You want to update this election?",
      icon: "warning",
      showCancelButton: true,
      showCancelButton: !0,
      confirmButtonText: "Yes, proceed!",
      
  }).then((result) => {
    if (result.isConfirmed) {
      var token = $("#token").val();
      var url = $( "#urlVotingUpdate" ).val();
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': token
          }
      });

      var picture = $('#file-input-profile').prop('files')[0];


      var formData = new FormData(this);
      formData.append('picture', picture);
      formData.append('voting_id',$( "#voting_id" ).val());
      formData.append('title',$( "#title" ).val());
      formData.append('date_from',$( "#date_from" ).val());
      formData.append('date_to',$( "#date_to" ).val());
      formData.append('time_from',$( "#time_from" ).val());
      formData.append('time_to',$( "#time_to" ).val());
      formData.append('description',$( "#description" ).val());
      

        $.ajax({
          type: 'POST',
          url: url,
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          success: (data) => {
                  Swal.fire({
                      title: "Success!",
                      text: "Election Details successfully updated",
                      icon: "success",
                      confirmButtonText: "Okay"
                  }).then((result) => {
                    $('#modalUpdateElection').modal('hide');
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
});


$('#update-election-status-form').submit(function(e) {
    e.preventDefault();
      Swal.fire({
  
        customClass: {
            confirmButton: "btn bg-gradient-success",
            cancelButton: "btn bg-gradient-danger"
        },
        buttonsStyling: !1,
        
        title: "Are you sure",
        text: "You want to update the status of election?",
        icon: "warning",
        showCancelButton: true,
        showCancelButton: !0,
        confirmButtonText: "Yes, proceed!",
        
    }).then((result) => {
      if (result.isConfirmed) {
 
        var token = $("#token").val();
        var url = $( "#urlVotingUpdateStatus" ).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
        });

  
        var formData = new FormData(this);
        formData.append('voting_id',$( "#voting_id" ).val());
        formData.append('status2',$( "#status2" ).val());

          $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                    Swal.fire({
                        title: "Success!",
                        text: "Election status successfully updated",
                        icon: "success",
                        confirmButtonText: "Okay"
                    }).then((result) => {
                      $('#modalUpdateElectionStatus').modal('hide');
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
  });


$('#add_bot_btn').click(function(e) {

  var candidate_pps_no = $( "#bot_candidate_pps_no" ).val();
  
  if(candidate_pps_no == "")
  {
      notif.showNotification('top', 'right', 'Please choose candidate in the list!', 'warning');
      $('#bot_candidate_pps_no').select2('open');
  }
  else
  {
      var token = $("#token").val();
      var url = $( "#urlCandidateAddBot" ).val();
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': token
          }
      });

      $.ajax({
          type: 'get',
          url: url,
          data: { 'pps_no' : $( "#bot_candidate_pps_no" ).val(),      
                  'voting_id' : $( "#voting_id" ).val(),    
              },
          
          success: (data) => {
 
              if(data == "exist")
              {
                
                  notif.showNotification('top', 'right', 'Warning, This member is already on the list of candidates!', 'warning');
                  
              }
              else
              {
                $('#modalAddBOT').modal('hide');
                $( "#bottable" ).load(window.location.href + " #bottable" );
                  notif.showNotification('top', 'right', 'Success, New candidate added on the list!', 'success');
              }
      
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


$('#add_chap_rep_btn').click(function(e) {

  var candidate_pps_no = $( "#chaprep_candidate_pps_no" ).val();
  
  if(candidate_pps_no == "")
  {
      notif.showNotification('top', 'right', 'Please choose candidate in the list!', 'warning');
      $('#bot_candidate_pps_no').select2('open');
  }
  else
  {
      var token = $("#token").val();
      var url = $( "#urlCandidateAddChapRep" ).val();
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': token
          }
      });

      $.ajax({
          type: 'get',
          url: url,
          data: { 'pps_no' : $( "#chaprep_candidate_pps_no" ).val(),      
                  'voting_id' : $( "#voting_id" ).val(),    
              },
          
          success: (data) => {
 
              if(data == "exist")
              {
                
                  notif.showNotification('top', 'right', 'Warning, This member is already on the list of candidates!', 'warning');
                  
              }
              else
              {
                $('#modalAddChapRep').modal('hide');
                $( "#chapreptable" ).load(window.location.href + " #chapreptable" );
                  notif.showNotification('top', 'right', 'Success, New candidate added on the list!', 'success');
              }
      
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

function restrictUpdate()
{
    Swal.fire({
      title: "Warning!",
      text: "Election cannot update or modify while the status is ongoing.",
      icon: "warning",
      confirmButtonText: "Okay"
  })
}