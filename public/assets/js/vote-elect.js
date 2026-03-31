$(document).ready(function () {
    let maxBotVotes = $('#botMaxVote').val();
    $('.vote-bot-btn').on('click', function () {
        let target = $(this).data('target');
        let $checkbox = $(target);

        // If trying to check and already at max → block
        if (!$checkbox.prop('checked')) {
            let checkedCount = $('.bot-candidate-checkbox:checked').length;
            if (checkedCount >= maxBotVotes) {
                let messageBOT = "Warning, You can only select up to " + maxBotVotes + " candidates for this position.";
                notif.showNotification('top', 'right', messageBOT, 'warning');
                return;
            }
        }

        // Toggle checkbox state
        $checkbox.prop('checked', !$checkbox.prop('checked'));

        // Update button text + color
        if ($checkbox.prop('checked')) {
            $(this).removeClass('btn-danger').addClass('btn-success').text('UNSELECT');
        } else {
            $(this).removeClass('btn-success').addClass('btn-danger').text('SELECT');
        }
    });




    $('.vote-chap-rep-btn').on('click', function () {
    let maxChapRep = $('#chapRepMaxVote').val();
    let target = $(this).data('target');
    let $checkbox = $(target);

    // If trying to check and already at max → block
    if (!$checkbox.prop('checked')) {
        let checkedCount = $('.chap-rep-candidate-checkbox:checked').length;
        if (checkedCount >= maxChapRep) {
            let messageChapRep = "Warning, You can only select up to " + maxChapRep + " candidates for this position.";
            notif.showNotification('top', 'right', messageChapRep, 'warning');
            return;
        }
    }

    // Toggle checkbox state
    $checkbox.prop('checked', !$checkbox.prop('checked'));

    // Update button text + color
    if ($checkbox.prop('checked')) {
        $(this).removeClass('btn-danger').addClass('btn-success').text('UNSELECT');
    } else {
        $(this).removeClass('btn-success').addClass('btn-danger').text('SELECT');
    }
    });


});



$(document).on('click', '#maxVotedBOT', function () {
    alert("test");
});

$(document).on('click', '#maxVotedChapRep', function () {
    alert("test");
});




$(document).on('click', '.select_candidate', function () {
    
    Swal.fire({

        customClass: {
            confirmButton: "btn bg-gradient-success",
            cancelButton: "btn bg-gradient-danger"
        },
        buttonsStyling: !1,
        
        title: "Are you sure?",
        text: "You want to add this candidate in the selected list?",
        icon: "warning",
        showCancelButton: true,
        showCancelButton: !0,
        confirmButtonText: "Yes, proceed!",
    }).then((result) => {
        if (result.isConfirmed) {
           
            var token = $("#token").val();
            var url = $( "#urlVotingSelectCandidate" ).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });
            $.ajax({
                type: 'get',
                url: url,
                data: { 'pps_no' : this.id,      
                        'voting_id' : $( "#voting_id" ).val()
                    },
                
                success: (data) => {

                  
                    if(data == "existcandidate")
                    {
                        notif.showNotification('top', 'right', 'Warning, this candidate already in your list!', 'warning');
                    }
                    else if(data == "exceedBOT")
                    {
                        notif.showNotification('top', 'right', 'Warning, exceed the maximum allowed vote for the board of trustees!', 'warning');
                    }
                    else if(data == "exceedChapRep")
                    {
                        notif.showNotification('top', 'right', 'Warning, exceed the maximum allowed vote for the chapter representative!', 'warning');
                    }

                    else
                    {
                        $( "#botcount" ).load(window.location.href + " #botcount" );
                        $( "#chaprepcount" ).load(window.location.href + " #chaprepcount" );
                        $( "#refreshDiv" ).load(window.location.href + " #refreshDiv" );
                        notif.showNotification('top', 'right', 'Success, candidate successfully added in your list!', 'success');
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
});



$(document).on('click', '.select_candidate_bot', function () {

    Swal.fire({

        customClass: {
            confirmButton: "btn bg-gradient-success",
            cancelButton: "btn bg-gradient-danger"
        },
        buttonsStyling: !1,
        
        title: "Are you sure?",
        text: "You want to add this candidate in the selected list?",
        icon: "warning",
        showCancelButton: true,
        showCancelButton: !0,
        confirmButtonText: "Yes, proceed!",
    }).then((result) => {
        if (result.isConfirmed) {
           
            var token = $("#token").val();
            var url = $( "#urlVotingSelectCandidateBot" ).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });
            $.ajax({
                type: 'get',
                url: url,
                data: { 'pps_no' : this.id,      
                        'voting_id' : $( "#voting_id" ).val()
                    },
                
                success: (data) => {

                  
                    if(data == "existcandidate")
                    {
                        notif.showNotification('top', 'right', 'Warning, this candidate already in your list!', 'warning');
                    }
                    else if(data == "exceedBOT")
                    {
                        notif.showNotification('top', 'right', 'Warning, exceed the maximum allowed vote for this position!', 'warning');
                    }

                    else
                    {
                        $( "#botcount" ).load(window.location.href + " #botcount" );
                        $( "#refreshDiv" ).load(window.location.href + " #refreshDiv" );
                        notif.showNotification('top', 'right', 'Success, candidate successfully added in your list!', 'success');
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
});

$(document).on('click', '.select_candidate_chap_rep', function () {
    
    Swal.fire({

        customClass: {
            confirmButton: "btn bg-gradient-success",
            cancelButton: "btn bg-gradient-danger"
        },
        buttonsStyling: !1,
        
        title: "Are you sure?",
        text: "You want to add this candidate in the selected list?",
        icon: "warning",
        showCancelButton: true,
        showCancelButton: !0,
        confirmButtonText: "Yes, proceed!",
    }).then((result) => {
        if (result.isConfirmed) {
           
            var token = $("#token").val();
            var url = $( "#urlVotingSelectCandidateChapRep" ).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });
            $.ajax({
                type: 'get',
                url: url,
                data: { 'pps_no' : this.id,      
                        'voting_id' : $( "#voting_id" ).val()
                    },
                
                success: (data) => {

                  
                    if(data == "existcandidate")
                    {
                        notif.showNotification('top', 'right', 'Warning, this candidate already in your list!', 'warning');
                    }
                    else if(data == "exceedChapRep")
                    {
                        notif.showNotification('top', 'right', 'Warning, exceed the maximum allowed vote for the chapter representative!', 'warning');
                    }

                    else
                    {
                        $( "#chaprepcount" ).load(window.location.href + " #chaprepcount" );
                        $( "#refreshDiv" ).load(window.location.href + " #refreshDiv" );
                        notif.showNotification('top', 'right', 'Success, candidate successfully added in your list!', 'success');
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
});



$(document).on('click', '.remove_candidate2', function () {
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
            var url = $( "#urlVotingRemoveSelectCandidate" ).val();
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
            
                    $( "#botcount" ).load(window.location.href + " #botcount" );
                    $( "#chaprepcount" ).load(window.location.href + " #chaprepcount" );
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


$(document).on('click', '#finalize_btn', function () {
    
    Swal.fire({

        customClass: {
            confirmButton: "btn bg-gradient-success",
            cancelButton: "btn bg-gradient-danger"
        },
        buttonsStyling: !1,
        
        title: "Are you sure?",
        text: "You want to finalize your vote?",
        icon: "warning",
        showCancelButton: true,
        showCancelButton: !0,
        confirmButtonText: "Yes, proceed!",
    }).then((result) => {
        if (result.isConfirmed) {
            var token = $("#token").val();
            var url = $( "#urlVotingFinalize" ).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });
            $.ajax({
                type: 'get',
                url: url,
                data: { 'voting_id' : $( "#voting_id" ).val()      
                    },
                
                success: (data) => {

                    if(data == "emptycandidate")
                    {
                        notif.showNotification('top', 'right', 'Warning, please choose your candidate first!', 'warning');
                    }
                    else if(data == "alreadyvoted")
                    {
                          Swal.fire({
                            title: "Warning!",
                            text: "You've already done voting in this election!",
                            icon: "warning",
                            confirmButtonText: "Okay"
                        })
                    }
                    else if(data == "maxbot")
                    {
                        notif.showNotification('top', 'right', 'Warning, exceed the maximum allowed vote for bot position!', 'warning');
                    }
                    else if(data == "maxchaprep")
                    {
                        notif.showNotification('top', 'right', 'Warning, exceed the maximum allowed vote for chap rep position!', 'warning');
                    }
                    else if(data == "lesscandidate")
                    {
                        notif.showNotification('top', 'right', 'Warning, you need to vote the minimum allowed for chapter representative position!', 'warning');
                    }

                    
                    
                    else
                    {
                        Swal.fire({
                          title: "Completed!",
                          text: "Successfully completed your vote.",
                          icon: "success",
                          confirmButtonText: "Okay"
                        }).then((result) => {
                            window.location.href = '/voting-listing'
                        });
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
    })
});



