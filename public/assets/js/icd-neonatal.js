




Dropzone.autoDiscover = false;

$(document).ready(function () {
    var myDropzone = new Dropzone("#my-awesome-dropzone", {
        url: $("#urlICDNeonatalUpload").val(),
        autoProcessQueue: false, // Prevent automatic processing
        addRemoveLinks: true,
        maxFiles: 1,
        dictDefaultMessage: `
        <div style="text-align: center;">
            <i class="fas fa-upload" style="font-size: 48px; margin-bottom: 10px;"></i>
            <div>Drag and drop files here or click to upload</div>
        </div>
    `,
        // Other Dropzone options as needed
    });

    // Listen for click on the upload button
    $('#uploadBtn').click(function() {
        if($("#month_year_icd").val() == "")
            {
                $("#month_year_icd").focus();
                notif.showNotification('top', 'right', 'Warning, please select month and year first!', 'warning');    
            }
        else if (myDropzone.files.length > 0) {
            Swal.fire({
                customClass: {
                    confirmButton: "btn bg-gradient-success",
                    cancelButton: "btn bg-gradient-danger"
                },
                buttonsStyling: false,
                title: "Are you sure?",
                text: "You want to upload this file?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, proceed!",
            }).then((result) => {
                if (result.isConfirmed) {
                    var urlCheckExist = $("#urlICDNeonatalUploadCheckExist").val();
                    var token =$("#token").val();
                    var month_year_icd =$("#month_year_icd").val();

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': token
                        }
                      });
                      $.ajax({
                        type: 'get',
                        url: urlCheckExist,
                        data: { 'token' : token,
                                'month_year_icd' : month_year_icd,
                     },
                        success: (data) => {
                            if(data >= 1)
                                {
                                    Swal.fire({
                                        customClass: {
                                          confirmButton: "btn bg-gradient-success",
                                          cancelButton: "btn bg-gradient-danger"
                                      },
                                      buttonsStyling: !1,
                                      
                                      title: "Warning!",
                                      text: "You have already uploaded a file for this month. Do you wish to upload another file?",
                                      icon: "warning",
                                      showCancelButton: true,
                                      showCancelButton: !0,
                                      confirmButtonText: "Yes, proceed!",
                                      }).then((result) => {
                                        if (result.isConfirmed) {
                                            myDropzone.processQueue();
                                            $("#loading2").fadeIn();
                                        }

                                      });
                                }
                                else
                                {

                                    myDropzone.processQueue();
                                    $("#loading2").fadeIn();
                                }
                           
                          },
                          
                      });
                   
                   
                }
            });
        } else {
            notif.showNotification('top', 'right', 'Warning, please add file first!', 'warning');    
        }
    });

    myDropzone.on("sending", function(file, xhr, formData) {
        formData.append("_token", $("#token").val());
        formData.append("month_year_icd", $("#month_year_icd").val());

    });

    myDropzone.on("success", function(file, response) {

        $("#loading2").fadeOut();
        Swal.fire({
            title: "Success!",
            text: "File successfully imported",
            icon: "success",
            confirmButtonText: "Okay"
        }).then((result) => {
            location.reload();
        });
    });

    myDropzone.on("error", function(file, response) {
        // Handle error action (e.g., displaying an error message)
        console.log(response);
    });
});





