
$(document).ready(function() {
    setInterval(function() {
      $("#refreshDiv").load(window.location.href + " #refreshDiv", function() { 

       });
    }, 1000);
  });

  $('#formTempBtn').click(function() {


    $("#formTempBtn").removeClass("js-btn-next");


    var speaker1_relevance = $('input[type=radio][name=speaker1_relevance]:checked').val();
    var speaker1_usefulness = $('input[type=radio][name=speaker1_usefulness]:checked').val();
    var speaker1_quality = $('input[type=radio][name=speaker1_quality]:checked').val();
    var speaker1_expertise = $('input[type=radio][name=speaker1_expertise]:checked').val();
    var speaker1_delivery = $('input[type=radio][name=speaker1_delivery]:checked').val();
    var speaker1_time_management = $('input[type=radio][name=speaker1_time_management]:checked').val();
    var speaker1_environment = $('input[type=radio][name=speaker1_environment]:checked').val();
    


    var event_id = $('#event_id').val();
    var event_topic_id = $('#event_topic_id').val();
    

    var token = $("#token").val();
    var url = $( "#urlEventOnlineTopicSpeakerATemp" ).val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token
        }
    });

    $.ajax({
        type: 'get',
        url: url,
        data: {   
                'event_id' : event_id, 
                'event_topic_id' : event_topic_id,
                'speaker1_relevance' : speaker1_relevance,
                'speaker1_usefulness' : speaker1_usefulness,
                'speaker1_quality' : speaker1_quality,
                'speaker1_expertise' : speaker1_expertise,
                'speaker1_delivery' : speaker1_delivery,
                'speaker1_time_management' : speaker1_time_management,
                'speaker1_environment' : speaker1_environment,
                
        },
    
        success: (data) => {
            $("#refreshDiv").load(window.location.href + " #refreshDiv");
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

    
    $("#formTempBtn").addClass("js-btn-next");
    


});




$('#form1btn').click(function() {


    $("#form1btn").removeClass("js-btn-next");


    var speaker1_objectives = $('input[type=radio][name=speaker1_objectives]:checked').val();
    var speaker1_information_presented = $('input[type=radio][name=speaker1_information_presented]:checked').val();
    var speaker1_organization = $('input[type=radio][name=speaker1_organization]:checked').val();
    var speaker1_conclusions = $('input[type=radio][name=speaker1_conclusions]:checked').val();
    var speaker1_confidence = $('input[type=radio][name=speaker1_confidence]:checked').val();
    var speaker1_state_presence = $('input[type=radio][name=speaker1_state_presence]:checked').val();
    var speaker1_audience_interest = $('input[type=radio][name=speaker1_audience_interest]:checked').val();
    
    var speaker1_visual_aids = $('input[type=radio][name=speaker1_visual_aids]:checked').val();


    var event_id = $('#event_id').val();
    var event_topic_id = $('#event_topic_id').val();
    

    var token = $("#token").val();
    var url = $( "#urlEventOnlineTopicSpeakerA" ).val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token
        }
    });

    $.ajax({
        type: 'get',
        url: url,
        data: {   
                'event_id' : event_id, 
                'event_topic_id' : event_topic_id,
                'speaker1_objectives' : speaker1_objectives,
                'speaker1_information_presented' : speaker1_information_presented,
                'speaker1_organization' : speaker1_organization,
                'speaker1_conclusions' : speaker1_conclusions,
                'speaker1_confidence' : speaker1_confidence,
                'speaker1_state_presence' : speaker1_state_presence,
                'speaker1_audience_interest' : speaker1_audience_interest,
                'speaker1_visual_aids' : speaker1_visual_aids,
                
        },
    
        success: (data) => {
            $("#refreshDiv").load(window.location.href + " #refreshDiv");
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

    
    $("#form1btn").addClass("js-btn-next");
    


});

$('#form2btn').click(function() {


    $("#form2btn").removeClass("js-btn-next");


    var speaker2_objectives = $('input[type=radio][name=speaker2_objectives]:checked').val();
    var speaker2_information_presented = $('input[type=radio][name=speaker2_information_presented]:checked').val();
    var speaker2_organization = $('input[type=radio][name=speaker2_organization]:checked').val();
    var speaker2_conclusions = $('input[type=radio][name=speaker2_conclusions]:checked').val();
    var speaker2_confidence = $('input[type=radio][name=speaker2_confidence]:checked').val();
    var speaker2_state_presence = $('input[type=radio][name=speaker2_state_presence]:checked').val();
    var speaker2_audience_interest = $('input[type=radio][name=speaker2_audience_interest]:checked').val();
    var speaker2_visual_aids = $('input[type=radio][name=speaker2_visual_aids]:checked').val();


    var event_id = $('#event_id').val();
    var event_topic_id = $('#event_topic_id').val();
    

    var token = $("#token").val();
    var url = $( "#urlEventTopicSpeakerB" ).val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token
        }
    });

    $.ajax({
        type: 'get',
        url: url,
        data: {   
                'event_id' : event_id, 
                'event_topic_id' : event_topic_id,
                'speaker2_objectives' : speaker2_objectives,
                'speaker2_information_presented' : speaker2_information_presented,
                'speaker2_organization' : speaker2_organization,
                'speaker2_conclusions' : speaker2_conclusions,
                'speaker2_confidence' : speaker2_confidence,
                'speaker2_state_presence' : speaker2_state_presence,
                'speaker2_audience_interest' : speaker2_audience_interest,
                'speaker2_visual_aids' : speaker2_visual_aids,
                
        },
    
        success: (data) => {
            $("#refreshDiv").load(window.location.href + " #refreshDiv");
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
    
    $("#form2btn").addClass("js-btn-next");
    $(window).scrollTop(0);


});

$('#form3btn').click(function() {


    $("#form3btn").removeClass("js-btn-next");


    var speaker3_objectives = $('input[type=radio][name=speaker3_objectives]:checked').val();
    var speaker3_information_presented = $('input[type=radio][name=speaker3_information_presented]:checked').val();
    var speaker3_organization = $('input[type=radio][name=speaker3_organization]:checked').val();
    var speaker3_conclusions = $('input[type=radio][name=speaker3_conclusions]:checked').val();
    var speaker3_confidence = $('input[type=radio][name=speaker3_confidence]:checked').val();
    var speaker3_state_presence = $('input[type=radio][name=speaker3_state_presence]:checked').val();
    var speaker3_audience_interest = $('input[type=radio][name=speaker3_audience_interest]:checked').val();
    var speaker3_visual_aids = $('input[type=radio][name=speaker3_visual_aids]:checked').val();


    var event_id = $('#event_id').val();
    var event_topic_id = $('#event_topic_id').val();


    var token = $("#token").val();
    var url = $( "#urlEventTopicSpeakerC" ).val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token
        }
    });

    $.ajax({
        type: 'get',
        url: url,
        data: {   
                'event_id' : event_id, 
                'event_topic_id' : event_topic_id,
                'speaker3_objectives' : speaker3_objectives,
                'speaker3_information_presented' : speaker3_information_presented,
                'speaker3_organization' : speaker3_organization,
                'speaker3_conclusions' : speaker3_conclusions,
                'speaker3_confidence' : speaker3_confidence,
                'speaker3_state_presence' : speaker3_state_presence,
                'speaker3_audience_interest' : speaker3_audience_interest,
                'speaker3_visual_aids' : speaker3_visual_aids,
                
        },
    
        success: (data) => {
            $("#refreshDiv").load(window.location.href + " #refreshDiv");
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
    $( "#refreshDiv" ).load(window.location.href + " #refreshDiv" );
    $("#form3btn").addClass("js-btn-next");
    $(window).scrollTop(0);
  

    

});


$('#completebtn').click(function() {
    var event_id = $('#event_id').val();
    var event_topic_id = $('#event_topic_id').val();


    var token = $("#token").val();
    var url = $( "#urlEventOnlineTopicFinalizePlenary" ).val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token
        }
    });

    $.ajax({
        type: 'get',
        url: url,
        data: {   
                'event_id' : event_id, 
                'event_topic_id' : event_topic_id,

        },
    
        success: (data) => {
            Swal.fire({
                title: "Congratulations!",
                text: "You have successfully completed the evaluation form for the plenary session.",
                icon: "success",
                confirmButtonText: "Okay"
              }).then((result) => {
                window.location=data.url;
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



});

