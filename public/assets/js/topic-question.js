$('#form-add-question').submit(function(e) {
    e.preventDefault();
    Swal.fire({

        customClass: {
            confirmButton: "btn bg-gradient-success",
            cancelButton: "btn bg-gradient-danger"
        },
        buttonsStyling: !1,
        
        title: "Are you sure?",
        text: "You want to add this question in the list?",
        icon: "warning",
        showCancelButton: true,
        showCancelButton: !0,
        confirmButtonText: "Yes, proceed!",
    }).then((result) => {
        if (result.isConfirmed) {
            var token = $("#token").val();
            var url = $( "#urlEventTopicAddQuestion" ).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });

            var formData = new FormData(this);
            $('input[name="choices"]').each(function(){
                formData.append('choices', $(this).val());
            });
            $('input[name="letter"]').each(function(){
                formData.append('letter', $(this).val());
            });
            formData.append('question',$( "#question" ).val());
            formData.append('answer',$( "#answer" ).val());


            $.ajax({
                type: 'post',
                url: url,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
               
                success: (data) => { 
               
                        if(data == "exist")
                        {
                            Swal.fire({
                                title: "Warning!",
                                text: "This question already on the list!",
                                icon: "warning",
                                confirmButtonText: "Okay"
                            });
                        }
                        else
                        {
                            $('#modalAddQuestion').modal('hide');
                            $( "#refreshDiv" ).load(window.location.href + " #refreshDiv" );
                            $('#form-add-question').trigger("reset");
                            Swal.fire({
                                title: "Success!",
                                text: "Question successfully added on the list",
                                icon: "success",
                                confirmButtonText: "Okay"
                            }).then((result) => {
                               
                            });
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

$(document).on('click', '#addQuestionBtn', function () {
    Swal.fire({

        customClass: {
            confirmButton: "btn bg-gradient-success",
            cancelButton: "btn bg-gradient-danger"
        },
        buttonsStyling: !1,
        
        title: "Are you sure?",
        text: "You want to add this question in the list?",
        icon: "warning",
        showCancelButton: true,
        showCancelButton: !0,
        confirmButtonText: "Yes, proceed!",
    }).then((result) => {
        if (result.isConfirmed) {
            var token = $("#token").val();
            var url = $( "#urlEventTopicAddQuestion" ).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });
            $.ajax({
                type: 'get',
                url: url,
                data: { 'question' : $( "#question" ).val(),    
                        'answer' : $( "#answer" ).val(), 
                        'topic_id' : $( "#topic_id" ).val(), 
                        'choiceA' : $( "#choiceA" ).val(),
                        'choiceB' : $( "#choiceB" ).val(),
                        'choiceC' : $( "#choiceC" ).val(),
                        'choiceD' : $( "#choiceD" ).val(),
                        'choiceE' : $( "#choiceE" ).val(),
                        'choiceF' : $( "#choiceF" ).val(),
                        
                 },
               
                success: (data) => {
                        if(data == "exist")
                        {
                            Swal.fire({
                                title: "Warning!",
                                text: "This question already on the list!",
                                icon: "warning",
                                confirmButtonText: "Okay"
                            });
                        }
                        else
                        {
                            Swal.fire({
                                title: "Success!",
                                text: "Question successfully added on the list",
                                icon: "success",
                                confirmButtonText: "Okay"
                            }).then((result) => {
                                // location.reload();
                            });
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

$(document).on('click', '#fb_url_button', function () {
    if($("#fb_url").val() == '')
    {
      notif.showNotification('top', 'right', 'Warning, please fill-up facebook live url !', 'warning');
      $("#fb_url").focus();
    }
    else
    {
        var topic_id = $("#topic_id").val();
        var url = $( "#urlEventTopicAddFBLiveUrl" ).val();
        var token = $( "#token" ).val();
        var fb_url = $( "#fb_url" ).val();


        Swal.fire({
            customClass: {
              confirmButton: "btn bg-gradient-success",
              cancelButton: "btn bg-gradient-danger"
          },
          buttonsStyling: !1,
          
          title: "Are you sure?",
          text: "You want to add facebook live url?",
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
        
                $.ajax({
                  type: 'get',
                  url: url,
                  data: { 'topic_id' : topic_id,
                          'fb_live_url' : fb_url
               },
                 
                  success: (data) => {
                        $("#fb_live_url_row").load(window.location.href + " #fb_live_url_row");
                        Swal.fire({
                        title: "Success!",
                        text: "Facebook live URL successfully added.",
                        icon: "success",
                        confirmButtonText: "Okay"
                        })
                    },
                    error: function(data) {
                        Swal.fire({
                          title: "Warning!",
                          text: "Something went wrong",
                          icon: "warning",
                          confirmButtonText: "Okay"
                        })
                    }
                });
                
        
                }
            });
    }
    
  });

  $('#form-update-topic').submit(function(e) {
    e.preventDefault();
    Swal.fire({

        customClass: {
            confirmButton: "btn bg-gradient-success",
            cancelButton: "btn bg-gradient-danger"
        },
        buttonsStyling: !1,
        
        title: "Are you sure?",
        text: "You want to add this question in the list?",
        icon: "warning",
        showCancelButton: true,
        showCancelButton: !0,
        confirmButtonText: "Yes, proceed!",
    }).then((result) => {
        if (result.isConfirmed) {
            var token = $("#token").val();
            var url = $( "#urlEventTopicUpdate" ).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });

            var formData = new FormData(this);
           
            formData.append('topic_id',$( "#topic_id" ).val());
            formData.append('topic_name',$( "#topic_name" ).val());
            formData.append('points_on_site',$( "#points_on_site" ).val());
            formData.append('points_online',$( "#points_online" ).val());

            $.ajax({
                type: 'post',
                url: url,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
               
                success: (data) => { 
                    Swal.fire({
                        title: "Success!",
                        text: "Event Topic successfully updated.",
                        icon: "success",
                        confirmButtonText: "Okay"
                    })
                    .then((result) => {
                        location.reload();
                    });
            
                },
                error: function(data) { 
                    Swal.fire({
                        title: "Warning!",
                        text: "Something error",
                        icon: "warning",
                        confirmButtonText: "Okay"
                    })
                }
            });
        }
    });

  });