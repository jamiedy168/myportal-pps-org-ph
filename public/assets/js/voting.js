

$('#voting-form').submit(function(e) {
    e.preventDefault();

    
    if($( "#voting_title" ).val() == "")
    {
        $("#voting_title").focus();
        notif.showNotification('top', 'right', 'Warning, Please fill up title field!', 'warning');
    }
    else if($( "#voting_date_from" ).val() == "")
    {
        $("#voting_date_from").focus();
        notif.showNotification('top', 'right', 'Warning, Please fill up date from field!', 'warning');
    }
    else if($( "#voting_date_to" ).val() == "")
    {
        $("#voting_date_to").focus();
        notif.showNotification('top', 'right', 'Warning, Please fill up date to field!', 'warning');
    }
    else if($( "#voting_time_from" ).val() == "")
    {
        $("#voting_time_from").focus();
        notif.showNotification('top', 'right', 'Warning, Please fill up time from field!', 'warning');
    }
    else if($( "#voting_time_to" ).val() == "")
    {
        $("#voting_time_to").focus();
        notif.showNotification('top', 'right', 'Warning, Please fill up time to field!', 'warning');
    }
    else if($( "#count_bot_candidate" ).val() == 0)
    {
        notif.showNotification('top', 'right', 'Warning, Please choose board of trustees candidate in the list!', 'warning');
    }
    else if($( "#count_chap_rep_candidate" ).val() == 0)
    {
        notif.showNotification('top', 'right', 'Warning, Please choose chapter representative candidate in the list!', 'warning');
    }
    
    else if($( "#bot_max_vote" ).val() == "")
    {
        $("#bot_max_vote").focus();
        notif.showNotification('top', 'right', 'Warning, Please fill up max vote allowed field!', 'warning');
    }
    else if($( "#chap_rep_max_vote" ).val() == "")
    {
        $("#chap_rep_max_vote").focus();
        notif.showNotification('top', 'right', 'Warning, Please fill up max vote allowed field!', 'warning');
    }
    else if($( "#count_bot_candidate" ).val() < $( "#bot_max_vote" ).val())
    {
        var max_vote = $( "#bot_max_vote" ).val();
        var message = 'Warning, you need atleast '+ max_vote+ ' board of trustees candidate selected in the list!';
        notif.showNotification('top', 'right', message, 'warning');
    }

    else if($( "#count_chap_rep_candidate" ).val() < $( "#chap_rep_max_vote" ).val())
    {
        var max_vote = $( "#chap_rep_max_vote" ).val();
        var message = 'Warning, you need atleast '+ max_vote+ ' chapter representative candidate selected in the list!';
        notif.showNotification('top', 'right', message, 'warning');
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
          text: "You want to save this?",
          icon: "warning",
          showCancelButton: true,
          showCancelButton: !0,
          confirmButtonText: "Yes, proceed!",
      }).then((result) => {
        if (result.isConfirmed) {
            var url = $( "#urlVotingSave" ).val();
            var token = $( "#token" ).val();
    
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });
    
            var picture = $('.voting-picture').prop('files')[0];
            
            var formData = new FormData(this);
            formData.append('picture', picture);
            formData.append('voting_title',$( "#voting_title" ).val());
            formData.append('voting_date_from',$( "#voting_date_from" ).val());
            formData.append('voting_date_to',$( "#voting_date_to" ).val());
            formData.append('voting_time_from',$( "#voting_time_from" ).val());
            formData.append('voting_time_to',$( "#voting_time_to" ).val());
            formData.append('voting_description',$( "#voting_description" ).val());
            formData.append('bot_max_vote',$( "#bot_max_vote" ).val());
            formData.append('chap_rep_max_vote',$( "#chap_rep_max_vote" ).val());
            
            
            
            $.ajax({
                type: 'post',
                url: url,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    Swal.fire({
                        title: "Saved!",
                        text: "New voting successfully created.",
                        icon: "success",
                        confirmButtonText: "Okay"
                    }).then((result) => {
                        if (result.isConfirmed) {
                        
                            window.location.href = '/voting-listing'
                            
                        }
                        else{
                            window.location.href = '/voting-listing'
                        }
                    });
    
                },
                error: function(data) {
            
                  Swal.fire({
                      title: "Warning!",
                      text: "Event not save!",
                      icon: "error",
                      confirmButtonText: "Okay"
                  })
                }
            });
        }
      });
    }
    

});



$(document).ready(function() {
    

    if ($(".candidate_pps_no").length > 0)
    {
      $('.candidate_pps_no').select2({
        minimumInputLength: 2,         
      }).on('select2:open', function (e) {
          document.querySelector('.select2-search__field').focus();
      });
    }
  
});



$('.bot_add_candidate').click(function(e) {
    e.preventDefault();
    
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
                },
            
            success: (data) => {
                if(data == "exist")
                {
                    notif.showNotification('top', 'right', 'Warning, This member is already on the list of candidates!', 'warning');
                    
                }
                else
                {
                    $( "#refreshDivBot" ).load(window.location.href + " #refreshDivBot" );
                    notif.showNotification('top', 'right', 'Success, New candidate added on the list!', 'success');
                }
        
            },
            error: function(data) { 
                Swal.fire({
                    title: "Warning!",
                    text: "Something error, please reload the page",
                    icon: "warning",
                    confirmButtonText: "Okay"
                })
            }
        });
    }

    
});


$('.chap_rep_add_candidate').click(function(e) {
    e.preventDefault();
    
    var candidate_pps_no = $( "#chap_rep_candidate_pps_no" ).val();
    
    if(candidate_pps_no == "")
    {
        notif.showNotification('top', 'right', 'Please choose candidate in the list!', 'warning');
        $('#chap_rep_candidate_pps_no').select2('open');
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
            data: { 'pps_no' : $( "#chap_rep_candidate_pps_no" ).val(),      
                },
            
            success: (data) => {

                if(data == "exist")
                {
                    notif.showNotification('top', 'right', 'Warning, This member is already on the list of candidates!', 'warning');
                    
                }
                else
                {
                    $( "#refreshDivChapRep" ).load(window.location.href + " #refreshDivChapRep" );
                    notif.showNotification('top', 'right', 'Success, New candidate added on the list!', 'success');
                }
        
            },
            error: function(data) { 
                Swal.fire({
                    title: "Warning!",
                    text: "Something error, please reload the page",
                    icon: "warning",
                    confirmButtonText: "Okay"
                })
            }
        });
    }

    
});





$('#add_candidate').click(function(e) {
    e.preventDefault();
    if($( "#candidate_pps_no" ).val() == "")
    {
        notif.showNotification('top', 'right', 'Please choose candidate in the list!', 'warning');
    }
    else
    {
        var token = $("#token").val();
        var url = $( "#urlCandidateAdd" ).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
        });

        
        $.ajax({
            type: 'get',
            url: url,
            data: { 'pps_no' : $( "#candidate_pps_no" ).val(),      
                },
            
            success: (data) => {
                if(data == "exist")
                {
                    notif.showNotification('top', 'right', 'Warning, This member is already on the list of candidates!', 'warning');
                    
                }
                else
                {
                    $( "#refreshDiv" ).load(window.location.href + " #refreshDiv" );
                    notif.showNotification('top', 'right', 'Success, New candidate added on the list!', 'success');
                }
        
            },
            error: function(data) { 
                Swal.fire({
                    title: "Warning!",
                    text: "Something error, please reload the page",
                    icon: "warning",
                    confirmButtonText: "Okay"
                })
            }
        });
    }
    

});



$(document).on('click', '.remove_candidate', function () {
    Swal.fire({

        customClass: {
            confirmButton: "btn bg-gradient-success",
            cancelButton: "btn bg-gradient-danger"
        },
        buttonsStyling: !1,
        
        title: "Are you sure?",
        text: "You want to remove this candidate in the list?",
        icon: "warning",
        showCancelButton: true,
        showCancelButton: !0,
        confirmButtonText: "Yes, proceed!",
    }).then((result) => {
        if (result.isConfirmed) {
            var token = $("#token").val();
            var url = $( "#urlCandidateRemove" ).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });
            $.ajax({
                type: 'get',
                url: url,
                data: { 'pps_no' : this.id,      
                    },
                
                success: (data) => {
                    $( "#refreshDiv" ).load(window.location.href + " #refreshDiv" );
                    Swal.fire({
                      title: "Removed!",
                      text: "Candidate successfully removed from the list!",
                      icon: "success",
                      confirmButtonText: "Okay"
                    })
                   
                },
                error: function(data) { 
                    Swal.fire({
                        title: "Warning!",
                        text: "Something error, please reload the page",
                        icon: "warning",
                        confirmButtonText: "Okay"
                    })
                }
            });
        }
    })
});


$(document).on('click', '.remove_candidateBot', function () {
    Swal.fire({

        customClass: {
            confirmButton: "btn bg-gradient-success",
            cancelButton: "btn bg-gradient-danger"
        },
        buttonsStyling: !1,
        
        title: "Are you sure?",
        text: "You want to remove this candidate in the list?",
        icon: "warning",
        showCancelButton: true,
        showCancelButton: !0,
        confirmButtonText: "Yes, proceed!",
    }).then((result) => {
        if (result.isConfirmed) {
            var token = $("#token").val();
            var url = $( "#urlCandidateRemoveBot" ).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });
            $.ajax({
                type: 'get',
                url: url,
                data: { 'pps_no' : this.id,      
                    },
                
                success: (data) => {
                    $( "#refreshDivBot" ).load(window.location.href + " #refreshDivBot" );
                    Swal.fire({
                      title: "Removed!",
                      text: "Candidate successfully removed from the list!",
                      icon: "success",
                      confirmButtonText: "Okay"
                    })
                   
                },
                error: function(data) { 
                    Swal.fire({
                        title: "Warning!",
                        text: "Something error, please reload the page",
                        icon: "warning",
                        confirmButtonText: "Okay"
                    })
                }
            });
        }
    })
});


$(document).on('click', '.remove_candidate_chap_rep', function () {

    Swal.fire({

        customClass: {
            confirmButton: "btn bg-gradient-success",
            cancelButton: "btn bg-gradient-danger"
        },
        buttonsStyling: !1,
        
        title: "Are you sure?",
        text: "You want to remove this candidate in the list?",
        icon: "warning",
        showCancelButton: true,
        showCancelButton: !0,
        confirmButtonText: "Yes, proceed!",
    }).then((result) => {
        if (result.isConfirmed) {
            var token = $("#token").val();
            var url = $( "#urlCandidateRemoveChapRep" ).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });
            $.ajax({
                type: 'get',
                url: url,
                data: { 'pps_no' : this.id,      
                    },
                
                success: (data) => {
                    $( "#refreshDivChapRep" ).load(window.location.href + " #refreshDivChapRep" );
                    Swal.fire({
                      title: "Removed!",
                      text: "Candidate successfully removed from the list!",
                      icon: "success",
                      confirmButtonText: "Okay"
                    })
                   
                },
                error: function(data) { 
                    Swal.fire({
                        title: "Warning!",
                        text: "Something error, please reload the page",
                        icon: "warning",
                        confirmButtonText: "Okay"
                    })
                }
            });
        }
    })
});



$(document).on('click', '.remove_candidate_chap_rep', function () {

    Swal.fire({

        customClass: {
            confirmButton: "btn bg-gradient-success",
            cancelButton: "btn bg-gradient-danger"
        },
        buttonsStyling: !1,
        
        title: "Are you sure?",
        text: "You want to remove this candidate in the list?",
        icon: "warning",
        showCancelButton: true,
        showCancelButton: !0,
        confirmButtonText: "Yes, proceed!",
    }).then((result) => {
        if (result.isConfirmed) {
            var token = $("#token").val();
            var url = $( "#urlCandidateRemoveChapRep" ).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });
            $.ajax({
                type: 'get',
                url: url,
                data: { 'pps_no' : this.id,      
                    },
                
                success: (data) => {
                    $( "#refreshDivChapRep" ).load(window.location.href + " #refreshDivChapRep" );
                    Swal.fire({
                      title: "Removed!",
                      text: "Candidate successfully removed from the list!",
                      icon: "success",
                      confirmButtonText: "Okay"
                    })
                   
                },
                error: function(data) { 
                    Swal.fire({
                        title: "Warning!",
                        text: "Something error, please reload the page",
                        icon: "warning",
                        confirmButtonText: "Okay"
                    })
                }
            });
        }
    })
});




