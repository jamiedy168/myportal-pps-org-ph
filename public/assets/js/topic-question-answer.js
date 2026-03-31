// $(".js-btn-next").click(function(event){
//     event.preventDefault();
//     alert("test");
//  });


//  $(".check_answer").click(function(e){
//    e.preventDefault();
  
//     var correct_answer = $(this).data('correct-answer');
//     var member_answer = $('input[name="member_answer"]:checked').val();
//     var row_member_answer = $('input[type=radio][name=member_answer]:checked').attr('id');


//     var question_id = $("#question_id").val();


//     if(member_answer == null)
//     {
//         notif.showNotification('top', 'right', 'Warning, please choose your answer first!', 'warning');
       
       
//     }
//     else if(member_answer !== correct_answer)
//     {
//         $(".bg-gray-200").removeClass("wrong-answer");
//         $("#row-"+row_member_answer).addClass("wrong-answer");
//         $("#row-"+correct_answer).addClass("correct-answer");

//         notif.showNotification('top', 'right', 'Warning, please choose the correct answer!', 'warning');
      

//     }
//     else
//     {
//         $(".next-btn"+question_id).click();
        
//     }




//  });


$('.check_answer').click(function() {

   $(".check_answer").removeClass("js-btn-next");

    var correct_answer = $(this).data('correct-answer');
    var member_answer = $('input[name="member_answer"]:checked').val();
    var row_member_answer = $('input[type=radio][name=member_answer]:checked').attr('id');


    var question_id = $("#question_id").val();


    if(member_answer == null)
    {
     
        notif.showNotification('top', 'right', 'Warning, please choose your answer first!', 'warning');
       
    }
    else if(member_answer !== correct_answer)
    {

        $(".bg-gray-200").removeClass("wrong-answer");
        $(".row-"+row_member_answer).addClass("wrong-answer");
        $(".rows-"+correct_answer).addClass("correct-answer");

        notif.showNotification('top', 'right', 'Warning, please choose the correct answer!', 'warning');
      
    }
    else
    {
        
      $(".check_answer").addClass("js-btn-next");
      $(".bg-gray-200").removeClass("wrong-answer");
      $(".bg-gray-200").removeClass("correct-answer");
        
    }



});





$("#complete_answer").click(function(e){
    e.preventDefault();
    var token = $("#token").val();
    var url = $( "#urlEventTopicProceedScore" ).val();

    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': token
      }
    });

    $.ajax({
      type: 'get',
      url: url,
      data: { 'event_topic_id' : $( "#event_topic_id" ).val(),  
               'event_id'  : $( "#event_id" ).val()
     
       },
     
      success: (data) => {


        if(data == "attended")
        {
          Swal.fire({
            title: "Warning!",
            text: "You have already attended to this topic.",
            icon: "warning",
            confirmButtonText: "Okay"
          })
        }
        else
        {
          Swal.fire({
            title: "Congratulations!",
            text: "You have successfully passed the examination and met the attendance requirements for this topic. Well done!",
            icon: "success",
            confirmButtonText: "Okay"
          }).then((result) => {
            window.location.href = '/sign-in'
          });
        }

          
      },
      error: function(data) { 
          Swal.fire({
              title: "Warning!",
              text: "You have already attended to this topic.",
              icon: "warning",
              confirmButtonText: "Okay"
          })
      }
  });



    
 });




