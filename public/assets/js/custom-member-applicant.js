



$(document).ready(()=>{
    let template = "<div class='row mt-1 item'><div class='col-sm-3 col-3 offset-md-1' style='text-align: left !important'><label class='col-form-label mt-2 ms-0'>Institution</label><div class='input-group input-group-static'><input type='text' name='institution[]' id='institution' class='form-control'></div></div><div class='col-sm-3 col-3' style='text-align: left !important'><label class='col-form-label mt-2 ms-0'>Department Chair</label><div class='input-group input-group-static'><input type='text' name='department_chair[]' id='department_chair' class='form-control'></div></div><div class='col-sm-2 col-2' style='text-align: center !important'><label class='col-form-label mt-2 ms-0'>Date Started</label><div class='input-group input-group-static'><input type='date' name='date_started[]' id='date_started' class='datetimepicker text-center form-control multisteps-form__input'></div></div><div class='col-sm-2 col-2' style='text-align: center !important'><label class='col-form-label mt-2 ms-0 text-center'>Date Ended</label><div class='input-group input-group-static'><input type='date' name='date_ended[]' id='date_ended' class='datetimepicker text-center form-control multisteps-form__input'></div></div><div class='col-sm-1 col-1 mt-5'><a type='button' class='text-primary remove' data-bs-toggle='tooltip' data-bs-placement='bottom' title='' data-bs-original-title='Remove Record'><i class='fa fa-trash text-lg' aria-hidden='true'></i></a></div></div>"; 

    let template2 = "<div class='row mt-1 item2'><div class='col-sm-2 col-2 offset-md-1' style='text-align: left !important'><label class='col-form-label mt-2 ms-0'>Subspecialty</label><div class='input-group input-group-static'><input type='text' name='subspecialty[]' id='subspecialty' class='form-control'></div></div><div class='col-sm-2 col-2' style='text-align: left !important'><label class='col-form-label mt-2 ms-0'>Institution</label><div class='input-group input-group-static'><input type='text' name='sub_institution[]' id='sub_institution' class='form-control'></div></div><div class='col-sm-2 col-2' style='text-align: left !important'><label class='col-form-label mt-2 ms-0'>Section Chief</label><div class='input-group input-group-static'><input type='text' name='sub_section_chief[]' id='sub_section_chief' class='form-control'></div></div><div class='col-sm-2 col-2' style='text-align: center !important'><label class='col-form-label mt-2 ms-0'>Date Started</label><div class='input-group input-group-static'><input type='date' name='sub_date_started[]' id='sub_date_started' class='datetimepicker text-center form-control multisteps-form__input'></div></div><div class='col-sm-2 col-2' style='text-align: center !important'><label class='col-form-label mt-2 ms-0 text-center'>Date Ended</label><div class='input-group input-group-static'><input type='date' name='sub_date_ended[]' id='sub_date_ended' class='datetimepicker text-center form-control multisteps-form__input'></div></div><div class='col-sm-1 col-1 mt-5'><a type='button' class='text-primary remove2' data-bs-toggle='tooltip' data-bs-placement='bottom' title='' data-bs-original-title='Remove Record'><i class='fa fa-trash text-lg' aria-hidden='true'></i></a></div></div>";

    let template3 = "<div class='row mt-1 item3'><div class='col-sm-2 col-2 offset-md-1' style='text-align: left !important'><label class='col-form-label mt-2 ms-0'>Degree </label><div class='input-group input-group-static'><input type='text' name='academic_degree[]' id='academic_degree' class='form-control'></div></div><div class='col-sm-2 col-2' style='text-align: left !important'><label class='col-form-label mt-2 ms-0'>Institution</label><div class='input-group input-group-static'><input type='text' name='academic_institution[]' id='academic_institution' class='form-control'></div></div><div class='col-sm-2 col-2' style='text-align: left !important'><label class='col-form-label mt-2 ms-0'>Dean</label><div class='input-group input-group-static'><input type='text' name='academic_dean[]' id='academic_dean' class='form-control'></div></div><div class='col-sm-2 col-2' style='text-align: center !important'><label class='col-form-label mt-2 ms-0'>Date Started</label><div class='input-group input-group-static'><input type='date' name='academic_date_started[]' id='academic_date_started' class='datetimepicker text-center form-control multisteps-form__input'></div></div><div class='col-sm-2 col-2' style='text-align: center !important'><label class='col-form-label mt-2 ms-0 text-center'>Date Ended</label><div class='input-group input-group-static'><input type='date' name='academic_date_ended[]' id='academic_date_ended' class='datetimepicker text-center form-control multisteps-form__input'></div></div><div class='col-sm-1 col-1 mt-5'><a type='button' class='text-primary remove3' data-bs-toggle='tooltip' data-bs-placement='bottom' title='' data-bs-original-title='Remove Record'><i class='fa fa-trash text-lg' aria-hidden='true'></i></a></div></div>";

    let template4 = "<div class='row mt-1 item4'><div class='row mt-1'><div class='col-sm-3 col-3 offset-md-1' style='text-align: left !important'><label class='col-form-label mt-2 ms-0'>School </label><div class='input-group input-group-static'><input type='text' name='teaching_school[]' id='teaching_school' class='form-control'></div></div><div class='col-sm-3 col-3' style='text-align: left !important'><label class='col-form-label mt-2 ms-0'>Academic Rank </label><div class='input-group input-group-static'><input type='text' name='teaching_academic_rank[]' id='teaching_academic_rank' class='form-control'></div></div><div class='col-sm-2 col-2' style='text-align: left !important'><label class='col-form-label mt-2 ms-0'>Department </label><div class='input-group input-group-static'><input type='text' name='teaching_department[]' id='teaching_department' class='form-control'></div></div><div class='col-sm-3 col-3' style='text-align: left !important'><label class='col-form-label mt-2 ms-0'>Department Chair</label><div class='input-group input-group-static'><input type='text' name='teaching_department_chair[]' id='teaching_department_chair' class='form-control'></div></div></div><div class='row mt-1'><div class='col-sm-3 col-3 offset-md-1' style='text-align: left !important'><label class='col-form-label mt-2 ms-0'>Date Started</label><div class='input-group input-group-static'><input type='date' name='teaching_date_started[]' id='teaching_date_started' class='datetimepicker text-center form-control multisteps-form__input'></div></div><div class='col-sm-3 col-3' style='text-align: left !important'><label class='col-form-label mt-2 ms-0'>Date Ended</label><div class='input-group input-group-static'><input type='date' name='teaching_date_ended[]' id='teaching_date_ended' class='datetimepicker text-center form-control multisteps-form__input'></div></div><div class='col-sm-1 col-1 mt-5'><a type='button' class='text-primary remove4' data-bs-toggle='tooltip' data-bs-placement='bottom' title='' data-bs-original-title='Remove Record'><i class='fa fa-trash text-lg' aria-hidden='true'></i></a></div></div></div>";

    let template5 = "<div class='row mt-1 item5'><div class='col-sm-4 col-4 offset-md-1' style='text-align: left !important'><label class='col-form-label mt-2 ms-0'>Title </label><div class='input-group input-group-static'><input type='text' name='research_title[]' id='research_title' class='form-control'></div></div><div class='col-sm-2 col-2' style='text-align: left !important'><label class='col-form-label mt-2 ms-0'>Authorship </label><div class='input-group input-group-static'><input type='text' name='research_authorship[]' id='research_authorship' class='form-control'></div></div><div class='col-sm-2 col-2' style='text-align: left !important'><label class='col-form-label mt-2 ms-0'>Publication Status </label><div class='input-group input-group-static'><input type='text' name='research_publication_status[]' id='research_publication_status' class='form-control'></div></div><div class='col-sm-2 col-2' style='text-align: left !important'><label class='col-form-label mt-2 ms-0'>Date</label><div class='input-group input-group-static'><input type='date' name='research_year[]' id='research_year' class='datetimepicker text-center form-control multisteps-form__input'></div></div><div class='col-sm-1 col-1 mt-5'><a type='button' class='text-primary remove5' data-bs-toggle='tooltip' data-bs-placement='bottom' title='' data-bs-original-title='Remove Record'><i class='fa fa-trash text-lg' aria-hidden='true'></i></a></div></div>";

    $("#add").on("click", ()=>{
        
       
        var container = document.getElementById('card-body');
        container.style.height = (container.offsetHeight + 100) + "px";

        $("#items").append(template);
        flatpickr('.datetimepicker', {
            allowInput: true
        }); // flatpickr
    });
    $("body").on("click", ".remove", (e)=>{
        var container = document.getElementById('card-body');
        $(e.target).closest(".item").remove();
        var container = document.getElementById('card-body');
        container.style.height = (container.offsetHeight - 100) + "px";
    });

    $("#add2").on("click", ()=>{
        var container = document.getElementById('card-body');
        container.style.height = (container.offsetHeight + 100) + "px";

        $("#items2").append(template2);
        flatpickr('.datetimepicker', {
            allowInput: true
        }); // flatpickr
    });
    $("body").on("click", ".remove2", (e)=>{
        var container = document.getElementById('card-body');
        $(e.target).closest(".item2").remove();
        container.style.height = (container.offsetHeight - 100) + "px";
    });

    $("#add3").on("click", ()=>{
        var container = document.getElementById('card-body');
        container.style.height = (container.offsetHeight + 100) + "px";
        $("#items3").append(template3);
        flatpickr('.datetimepicker', {
            allowInput: true
        }); // flatpickr
    });
    $("body").on("click", ".remove3", (e)=>{
        var container = document.getElementById('card-body');
        $(e.target).closest(".item3").remove();
        container.style.height = (container.offsetHeight - 100) + "px";
    });

    $("#add4").on("click", ()=>{
        var container = document.getElementById('card-body');
        container.style.height = (container.offsetHeight + 100) + "px";
        $("#items4").append(template4);
        flatpickr('.datetimepicker', {
            allowInput: true
        }); // flatpickr
       
    });
    $("body").on("click", ".remove4", (e)=>{
        var container = document.getElementById('card-body');
        $(e.target).closest(".item4").remove();
        container.style.height = (container.offsetHeight - 100) + "px";
    });

    $("#add5").on("click", ()=>{
        var container = document.getElementById('card-body');
        container.style.height = (container.offsetHeight + 100) + "px";
        $("#items5").append(template5);
        flatpickr('.datetimepicker', {
            allowInput: true
        }); // flatpickr
    });

    $("body").on("click", ".remove5", (e)=>{
        var container = document.getElementById('card-body');
        $(e.target).closest(".item5").remove();
         container.style.height = (container.offsetHeight - 100) + "px";
    });

    
    if($('#applicant-type').val() == "NONMEMBER")
    {
        $('#prc-front-row').show(); 
        $('#prc-back-row').show(); 
    }
    else if($('#applicant-type').val() == "DIPLOMATE")
    {
        $('#prc-front-row').show(); 
        $('#prc-back-row').show(); 
    }
    else if($('#applicant-type').val() == "FELLOW")
    {
        $('#prc-front-row').show(); 
        $('#prc-back-row').show(); 
    }
    else if($('#applicant-type').val() == "EMERITUSFELLOW")
    {
        $('#prc-front-row').show(); 
        $('#prc-back-row').show(); 
    }
    else if($('#applicant-type').val() == "ALLIEDHEALTHPROFESSIONALS")
    {
        $('#identification-card-row').show(); 
    }
    else if($('#applicant-type').val() == "FOREIGNDELEGATE")
    {
        $('#identification-card-row').show(); 
    }
    else if($('#applicant-type').val() == "RESIDENTTRAINEES")
    {
        $('#certificate_residency-row').show(); 
        $('#prc-front-row').show(); 
        $('#prc-back-row').show(); 
    }
    else if($('#applicant-type').val() == "GOVERNMENTPHYSICIAN")
    {
        $('#government-physician-row').show(); 
        $('#prc-front-row').show(); 
        $('#prc-back-row').show(); 
    }
    else if($('#applicant-type').val() == "FELLOWSINTRAINING")
    {
        $('#fellows-in-training-row').show(); 
        $('#prc-front-row').show(); 
        $('#prc-back-row').show(); 
    }
    else
    {
        $('#prc-front-row').hide(); 
        $('#prc-back-row').hide(); 
        $('#government-physician-row').hide(); 
        $('#certificate_residency-row').hide(); 
        $('#identification-card-row').hide(); 
        $('#fellows-in-training-row').hide(); 
    }




    $('#js-btn-next').click(function() {
        $("#js-btn-next").removeClass("js-btn-next");


        if (document.getElementById("first_name").value == "") {
            notif.showNotification('top', 'right', 'Warning, please fill-up first name !', 'warning');
            document.getElementById("first_name").focus();
           
        } 

        else if (document.getElementById("last_name").value == "") {
            notif.showNotification('top', 'right', 'Warning, please fill-up last name !', 'warning');
            document.getElementById("last_name").focus();
        } 

        else if (document.getElementById("choices-month").value == "") {
            notif.showNotification('top', 'right', 'Warning, please fill-up birth month !', 'warning');
            document.getElementById("choices-month").focus();
        } 
    
        else if (document.getElementById("choices-day").value == "") {
            notif.showNotification('top', 'right', 'Warning, please fill-up birth date !', 'warning');
            document.getElementById("choices-day").focus();
        } 
    
        else if (document.getElementById("choices-year").value == "") {
            notif.showNotification('top', 'right', 'Warning, please fill-up birth year !', 'warning');
            document.getElementById("choices-year").focus();
        } 

        else if (document.getElementById("mobile_number").value == "") {
            notif.showNotification('top', 'right', 'Warning, please fill-up mobile number !', 'warning');
            document.getElementById("mobile_number").focus();
        } 
    
        else if (document.getElementById("email_address").value == "") {
            notif.showNotification('top', 'right', 'Warning, please fill-up email address !', 'warning');
            document.getElementById("email_address").focus();
        }

        else if (!$("input[type='radio']:checked").val()) {
            notif.showNotification('top', 'right', 'Warning, please choose nationality !', 'warning');

        }

        else if (document.getElementById("file-input-profile").files.length == 0) {
            notif.showNotification('top', 'right', 'Warning, please upload picture !', 'warning');
            document.getElementById("file-input-profile").focus();
        } 

        else
        {
            $("#js-btn-next").addClass("js-btn-next");
            $('#prc_tab').prop("disabled", false);
        }

        
    });





    $('#applicantSave').submit(function(e) {
        e.preventDefault();

        if (document.getElementById("applicant-type").value == "RESIDENTTRAINEES" && (document.getElementById("file-input-front").files.length == 0 || document.getElementById("file-input-back").files.length == 0 || document.getElementById("file-input-residency").files.length == 0)) {
            notif.showNotification('top', 'right', 'Warning, please upload all the documents !', 'warning');
        }

        else if (document.getElementById("applicant-type").value == "GOVERNMENTPHYSICIAN" && (document.getElementById("file-input-front").files.length == 0 || document.getElementById("file-input-back").files.length == 0 || document.getElementById("file-input-government").files.length == 0)) {
            notif.showNotification('top', 'right', 'Warning, please upload all the documents !', 'warning');
        }

        else if (document.getElementById("applicant-type").value == "FELLOWSINTRAINING" && (document.getElementById("file-input-front").files.length == 0 || document.getElementById("file-input-back").files.length == 0 || document.getElementById("file-input-fellows-in-training").files.length == 0)) {
            notif.showNotification('top', 'right', 'Warning, please upload all the documents !', 'warning');
        }

        else if (document.getElementById("applicant-type").value == "NONMEMBER" && (document.getElementById("file-input-front").files.length == 0  || document.getElementById("file-input-back").files.length == 0)) {
            notif.showNotification('top', 'right', 'Warning, please upload all the documents !', 'warning');
        }

        else if (document.getElementById("applicant-type").value == "DIPLOMATE" && (document.getElementById("file-input-front").files.length == 0  || document.getElementById("file-input-back").files.length == 0)) {
            notif.showNotification('top', 'right', 'Warning, please upload all the documents !', 'warning');
        }

        else if (document.getElementById("applicant-type").value == "FELLOW" && (document.getElementById("file-input-front").files.length == 0  || document.getElementById("file-input-back").files.length == 0)) {
            notif.showNotification('top', 'right', 'Warning, please upload all the documents !', 'warning');
        }

        else if (document.getElementById("applicant-type").value == "EMERITUSFELLOW" && (document.getElementById("file-input-front").files.length == 0  || document.getElementById("file-input-back").files.length == 0)) {
            notif.showNotification('top', 'right', 'Warning, please upload all the documents !', 'warning');
        }
        else if (document.getElementById("applicant-type").value == "ALLIEDHEALTHPROFESSIONALS" && document.getElementById("file-input-identification-card").files.length == 0 ) {
            notif.showNotification('top', 'right', 'Warning, please upload all the documents !', 'warning');
        }

        else if (document.getElementById("file-input-profile").files.length == 0) {
            notif.showNotification('top', 'right', 'Warning, please upload picture !', 'warning');
            document.getElementById("file-input-profile").focus();
        } 

        else if (document.getElementById("prc_number").value == "") {
            notif.showNotification('top', 'right', 'Warning, please input prc number!', 'warning');
        }
  
        else{
            Swal.fire({

                customClass: {
                    confirmButton: "btn bg-gradient-success",
                    cancelButton: "btn bg-gradient-danger"
                },
                buttonsStyling: !1,
                
                title: "Are you sure?",
                text: "You want to submit this record?",
                icon: "warning",
                showCancelButton: true,
                showCancelButton: !0,
                confirmButtonText: "Yes, submit it!",
             
                
            }).then((result) => {
                if (result.isConfirmed) {
    
                        $("#loading").fadeIn();
                        var token = $("#token").val();
                        var url = $( "#urlApplicantSave" ).val();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': token
                            }
                        });

                        var picture = $('#file-input-profile').prop('files')[0];
                        var front_id_image = $('#file-input-front').prop('files')[0];
                        var back_id_image = $('#file-input-back').prop('files')[0];
                        var residency_certificate = $('#file-input-residency').prop('files')[0];
                        var government_physician_certificate = $('#file-input-government').prop('files')[0];
                        var fellows_in_training_certificate = $('#file-input-fellows-in-training').prop('files')[0];
                        var identification_card = $('#file-input-identification-card').prop('files')[0];
                       
                   
                        var formData = new FormData(this);



                        formData.append('picture', picture);
                        formData.append('front_id_image', front_id_image);
                        formData.append('back_id_image', back_id_image);
                        formData.append('residency_certificate', residency_certificate);
                        formData.append('identification_card', identification_card);
                        formData.append('government_physician_certificate', government_physician_certificate);
                        formData.append('fellows_in_training_certificate', fellows_in_training_certificate);
                      
                        formData.append('first_name',$( "#first_name" ).val());
                        formData.append('middle_name',$( "#middle_name" ).val());
                        formData.append('last_name',$( "#last_name" ).val());
                        formData.append('suffix',$( "#suffix" ).val());
                        formData.append('birthmonth',$( "#choices-month" ).val());
                        formData.append('birthdate',$( "#choices-day" ).val());
                        formData.append('birthyear',$( "#choices-year" ).val());

                        formData.append('nationality',$( "#nationality" ).val());

                        formData.append('country_code',$( "#country_code" ).val());
                        formData.append('mobile_number',$( "#mobile_number" ).val());
                        formData.append('telephone_number',$( "#telephone_number" ).val());
                        formData.append('email_address',$( "#email_address" ).val());
                        formData.append('prc_number',$( "#prc_number" ).val());
                        formData.append('prc_registration_dt',$( "#prc_registration_dt" ).val());
                        formData.append('prc_validity',$( "#prc_validity" ).val());
                        formData.append('pma_number',$( "#pma_number" ).val());
                        formData.append('applicant_type',$( "#applicant-type" ).val());
                        formData.append('foreign_national',$(".foreign_national:checked").val());
                
                        $.ajax({
                            type: 'POST',
                            url: url,
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: (data) => {
                                $("#loading").fadeOut();
                        
                                if (data.success) {
                                    Swal.fire({
                                        title: "Saved!",
                                        text: "Your registration is now pending. Please check your email for further instructions.",
                                        icon: "success",
                                        confirmButtonText: "Okay"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = '/sign-in';
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        title: "Warning!",
                                        text: data.message,
                                        icon: "error",
                                        confirmButtonText: "Okay"
                                    });
                                }
                            },
                            error: function(xhr) {
                                $("#loading").fadeOut();
                        
                                let errorMessage = "Registration not successful!";
                                
                                if (xhr.status === 409) {
                                    errorMessage = "You have an existing application or you are already a member!";
                                } else if (xhr.status === 500) {
                                    // Use the detailed error message from Laravel
                                    const response = JSON.parse(xhr.responseText);
                                    errorMessage = response.message || "An unexpected error occurred. Please try again later.";
                                }
                        
                                Swal.fire({
                                    title: "Warning!",
                                    text: errorMessage,
                                    icon: "warning",
                                    confirmButtonText: "Okay"
                                });
                            }
                        });
                        
                }
            });
        }

     });


});


$(document).ready(function() {

 
    var token = $("#token").val();
    var url = $( "#urlCheckPRCExist").val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token
        }
    });


    $('#prc_number').keyup(function() {
        var prc_number = $("#prc_number").val();

        $.ajax({
            type: 'get',
            url: url,
            data : { 'pps_no' : $( "#pps_no" ).val(),
                     'prc_number' : prc_number
                    
                   },
            success: (data) => {
              if(data >= 1)
              {
                $('#prcexist').show();
                $("#prcexist").focus();
                $("#prcexist").addClass("is-focused");
                
                $( "#btnApplicantSavebtnApplicantSave" ).prop( "disabled", true );
                    

                var container = document.getElementById('card-body');
                container.style.height = (container.offsetHeight + 20) + "px";
              }

              else
              {
                $('#prcexist').hide();
                $("#prcexist").removeClass("is-focused");
                $( "#btnApplicantSavebtnApplicantSave" ).prop( "disabled", false );
              }
        
            },
            error: function(data) {
               
            }
        });
    });

   
});


// function insertApplicant() {

    // if (document.getElementById("first_name").value == "") {
    //     notif.showNotification('top', 'right', 'Warning, please fill-up first name !', 'warning');
    //     document.getElementById("first_name").focus();
       
    // } 

    // else if (document.getElementById("last_name").value == "") {
    //     notif.showNotification('top', 'right', 'Warning, please fill-up last name !', 'warning');
    //     document.getElementById("last_name").focus();
    // } 

    
    // else if (document.getElementById("choices-month").value == "") {
    //     notif.showNotification('top', 'right', 'Warning, please fill-up birth month !', 'warning');
    //     document.getElementById("choices-month").focus();
    // } 

    // else if (document.getElementById("choices-day").value == "") {
    //     notif.showNotification('top', 'right', 'Warning, please fill-up birth date !', 'warning');
    //     document.getElementById("choices-day").focus();
    // } 

    // else if (document.getElementById("choices-year").value == "") {
    //     notif.showNotification('top', 'right', 'Warning, please fill-up birth year !', 'warning');
    //     document.getElementById("choices-year").focus();
    // } 

    

    // else if (document.getElementById("gender").value == "") {
    //     notif.showNotification('top', 'right', 'Warning, please fill-up gender !', 'warning');
    //     document.getElementById("gender").focus();
    // } 

    // else if (document.getElementById("birthplace").value == "") {
    //     notif.showNotification('top', 'right', 'Warning, please fill-up birthplace !', 'warning');
    //     document.getElementById("birthplace").focus();
    // } 


    
    // else if (document.getElementById("civil_status").value == "") {
    //     notif.showNotification('top', 'right', 'Warning, please fill-up civil status !', 'warning');
    //     document.getElementById("civil_status").focus();
    // } 

    // else if (document.getElementById("citizenship").value == "") {
    //     notif.showNotification('top', 'right', 'Warning, please fill-up citizenship !', 'warning');
    //     document.getElementById("citizenship").focus();
        
    // } 

    // else if (document.getElementById("mobile_number").value == "") {
    //     notif.showNotification('top', 'right', 'Warning, please fill-up mobile number !', 'warning');
    //     document.getElementById("mobile_number").focus();
    // } 

    // else if (document.getElementById("email_address").value == "") {
    //     notif.showNotification('top', 'right', 'Warning, please fill-up email address !', 'warning');
    //     document.getElementById("email_address").focus();
    // } 


    // else if (document.getElementById("address").value == "") {
    //     notif.showNotification('top', 'right', 'Warning, please fill-up address !', 'warning');
    //     document.getElementById("address").focus();
    // } 

    // else if (document.getElementById("file-input-profile").files.length == 0) {
    //     notif.showNotification('top', 'right', 'Warning, please upload picture !', 'warning');
    //     document.getElementById("file-input-profile").focus();
    // } 

    // else if (document.getElementById("doctor_classification").value == "") {
    //     notif.showNotification('top', 'right', 'Warning, please fill-up doctor classification !', 'warning');
    //     document.getElementById("doctor_classification").focus();
    // } 


    

    

    // else if (document.getElementById("file-input-front").files.length == 0) {
    //     notif.showNotification('top', 'right', 'Warning, please upload front picture of your PRC License ID!', 'warning');
    //     document.getElementById("file-input-front").focus();
    // } 

    // else if (document.getElementById("file-input-back").files.length == 0) {
    //     notif.showNotification('top', 'right', 'Warning, please upload back picture of your PRC License ID!', 'warning');
    //     document.getElementById("file-input-back").focus();
    // } 

    // else if (document.getElementById("prc_number").value == "") {
    //     notif.showNotification('top', 'right', 'Warning, please fill-up PRC number !', 'warning');
    //     document.getElementById("prc_number").focus();
    // } 

    // else if (document.getElementById("prc_validity").value == "") {
    //     notif.showNotification('top', 'right', 'Warning, please fill-up PRC validity !', 'warning');
    //     document.getElementById("prc_validity").focus();
    // } 

    // else if (document.getElementById("pma_number").value == "") {
    //     notif.showNotification('top', 'right', 'Warning, please fill-up PMA number !', 'warning');
    //     document.getElementById("pma_number").focus();
    // } 



     
//     else {
       
//         notif.showSwal('warning-message-and-cancel2');
//     }

// }

$(function(){
    $(window).on('load',function(){
        $('#loading').hide();
    });
});


$(window).ready(function() { 
    $("#applicantSave").on("keypress", function (event) { 
       
        var keyPressed = event.keyCode || event.which; 
        if (keyPressed === 13) { 
          
            event.preventDefault(); 
            return false; 
        } 
    }); 
}); 






