$(document).ready(function() {
    if($('.gender').length > 0)
        {
            $('.gender').select2({     
                }).on('select2:open', function (e) {
                  document.querySelector('.select2-search__field').focus();
            });
        }

    if($('.nationality').length > 0)
        {
            $('.nationality').select2({     
                }).on('select2:open', function (e) {
                    document.querySelector('.select2-search__field').focus();
            });
        }    

    if($('.civil_status').length > 0)
        {
            $('.civil_status').select2({     
                }).on('select2:open', function (e) {
                    document.querySelector('.select2-search__field').focus();
            });
        }   

    if($('.area_code').length > 0)
        {
            $('.area_code').select2({     
                }).on('select2:open', function (e) {
                    document.querySelector('.select2-search__field').focus();
            });
        }  


    if($('.medical_school_year').length > 0)
        {
            $('.medical_school_year').select2({     
                }).on('select2:open', function (e) {
                    document.querySelector('.select2-search__field').focus();
            });
        }  

    if($('.research_authorship').length > 0)
        {
            $('.research_authorship').select2({     
                }).on('select2:open', function (e) {
                    document.querySelector('.select2-search__field').focus();
            });
        } 

    if($('.research_publication_status').length > 0)
        {
            $('.research_publication_status').select2({     
                }).on('select2:open', function (e) {
                    document.querySelector('.select2-search__field').focus();
            });
        } 

    if($('.research_publication_year').length > 0)
        {
            $('.research_publication_year').select2({     
                }).on('select2:open', function (e) {
                    document.querySelector('.select2-search__field').focus();
            });
        } 


    $('#birthdate').change(function()
    {
        console.log("change");
        var dob = new Date(document.getElementById('birthdate').value);
        var today = new Date();
        var age = Math.floor((today-dob)/(365.25*24*60*60*1000));
        document.getElementById('age').value = age;
    });
        

              


    $('.mobile_number').unbind('keyup change input paste').bind('keyup change input paste',function(e){
        var $this = $(this);
        var val = $this.val();
        var valLength = val.length;
        var maxCount = $this.attr('maxlength');
        if(valLength>maxCount){
            $this.val($this.val().substring(0,maxCount));
        }
    }); 


        
});

$('#update-profile').submit(function(e) {
    e.preventDefault();
    var url = $( "#urlSpecialtyBoardUpdate" ).val();
    var token = $( "#token" ).val();
    
    if($( "#cpdpointsum" ).val() < 25)
        {
            notif.showNotification('top', 'right', 'Warning, your total cpd points must be greater than 25!', 'warning');
        }

    else if($( "#first_name" ).val() == "")
        {
            notif.showNotification('top', 'right', 'Warning, please fill-up first name field!', 'warning');
            $("#first_name").focus();
        }
    else if($( "#last_name" ).val() == "")
        {
            notif.showNotification('top', 'right', 'Warning, please fill-up last name field!', 'warning');
            $("#last_name").focus();
        }    
    else if($( "#gender" ).val() == "")
        {
            notif.showNotification('top', 'right', 'Warning, please fill-up gender field!', 'warning');
            $("#gender").focus();
        }  

    else if($( "#birthdate" ).val() == "")
        {
            notif.showNotification('top', 'right', 'Warning, please fill-up date of birth field!', 'warning');
            $("#birthdate").focus();
        }  

    else if($( "#age" ).val() == "")
        {
            notif.showNotification('top', 'right', 'Warning, please fill-up age field!', 'warning');
            $("#age").focus();
        }      

    else if($( "#nationality" ).val() == "")
        {
            notif.showNotification('top', 'right', 'Warning, please fill-up nationality field!', 'warning');
            $("#nationality").focus();
        }    
    else if($( "#civil_status" ).val() == "")
        {
            notif.showNotification('top', 'right', 'Warning, please fill-up civil status field!', 'warning');
            $("#civil_status").focus();
        }
    else if($( "#prc_number" ).val() == "")
        {
            notif.showNotification('top', 'right', 'Warning, please fill-up prc number field!', 'warning');
            $("#prc_number").focus();
        }              
        
    else
        {
            Swal.fire({

                customClass: {
                    confirmButton: "btn bg-gradient-success",
                    cancelButton: "btn bg-gradient-danger"
                },
                buttonsStyling: !1,
                
                title: "Are you sure",
                text: "You want to update your profile information?",
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
                  
        
                  var formData = new FormData(this);
                  formData.append('first_name',$( "#first_name" ).val());
                  formData.append('middle_name',$( "#middle_name" ).val());
                  formData.append('last_name',$( "#last_name" ).val());
                  formData.append('suffix',$( "#suffix" ).val());
                  formData.append('gender',$( "#gender" ).val());
                  formData.append('birthdate',$( "#birthdate" ).val());
                  formData.append('nationality',$( "#nationality" ).val());
                  formData.append('civil_status',$( "#civil_status" ).val());
                  formData.append('prc_number',$( "#prc_number" ).val());
                  formData.append('address',$( "#address" ).val());
                  formData.append('country_code',$( "#country_code" ).val());
                  formData.append('mobile_number',$( "#mobile_number" ).val());
                  formData.append('email_address',$( "#email_address" ).val());
                  formData.append('medical_school',$( "#medical_school" ).val());
                  formData.append('medical_school_year',$( "#medical_school_year" ).val());
                  formData.append('institution',$( "#institution" ).val());
                  formData.append('date_started',$( "#date_started" ).val());
                  formData.append('ins_department_chair',$( "#ins_department_chair" ).val());
        
                  formData.append('subspecialty',$( "#subspecialty" ).val());
                  formData.append('sub_institution',$( "#sub_institution" ).val());
                  formData.append('sub_date_started',$( "#sub_date_started" ).val());
                  formData.append('sub_date_ended',$( "#sub_date_ended" ).val());
                  formData.append('sub_section_chief',$( "#sub_section_chief" ).val());
        
        
                  formData.append('academic_degree',$( "#academic_degree" ).val());
                  formData.append('academic_institution',$( "#academic_institution" ).val());
                  formData.append('academic_date_started',$( "#academic_date_started" ).val());
                  formData.append('academic_date_ended',$( "#academic_date_ended" ).val());
                  formData.append('academic_dean',$( "#academic_dean" ).val());
                  
        
                  formData.append('research_title',$( "#research_title" ).val());
                  formData.append('research_authorship',$( "#research_authorship" ).val());
                  formData.append('research_publication_status',$( "#research_publication_status" ).val());
                  formData.append('research_publication_year',$( "#research_publication_year" ).val());
        
                  
                  
                  
                  $.ajax({
                    type: 'post',
                    url: url,
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
        
                        if(data == "success")
                        {
                            Swal.fire({
                                title: "Success!",
                                text: "Profile information successfully updated.",
                                icon: "success",
                                confirmButtonText: "Okay"
                            }).then((result) => {
                                location.reload();
                            });
                        }
                        else
                        {
                            Swal.fire({
                                title: "Warning!",
                                text: "Something wrong!",
                                icon: "error",
                                confirmButtonText: "Okay"
                            })
                        }
                  
                
                    },
                    error: function(data) {
                      Swal.fire({
                          title: "Warning!",
                          text: "Something wrong!",
                          icon: "error",
                          confirmButtonText: "Okay"
                      })
                    }
                });
                  
           
                 
                  }
              });
        }

    
});

