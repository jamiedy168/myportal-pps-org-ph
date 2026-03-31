

Dropzone.autoDiscover = false;

$(document).ready(function () {


    if ($('.patient_type').length > 0) {
        $('.patient_type').select2({}).on('select2:open', function (e) {
            document.querySelector('.select2-search__field').focus();
        });
    }

    var myDropzone = new Dropzone("#my-awesome-dropzone", {
        url: $("#urlICDAdmittedUpload").val(),
        autoProcessQueue: false, // Prevent automatic processing
        addRemoveLinks: true,
        maxFiles: 1,
        dictDefaultMessage: `
        <div style="text-align: center;">
            <i class="fas fa-upload" style="font-size: 48px; margin-bottom: 10px;"></i>
            <div>Drag and drop files here or click to upload</div>
        </div>
    `,
    });

    // Listen for click on the upload button
    $('#uploadBtn').click(function() {
        if($("#month_year_icd").val() == "") {
            $("#month_year_icd").focus();
            notif.showNotification('top', 'right', 'Warning, please select month and year first!', 'warning');
        } else if (myDropzone.files.length > 0) {
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
                    var urlCheckExist = $("#urlICDAdmittedUploadCheckExist").val();
                    var token = $("#token").val();
                    var month_year_icd = $("#month_year_icd").val();

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': token
                        }
                    });

                    $.ajax({
                        type: 'get',
                        url: urlCheckExist,
                        data: { token: token, month_year_icd: month_year_icd },
                        success: (data) => {
                            if (data >= 1) {
                                Swal.fire({
                                    customClass: {
                                        confirmButton: "btn bg-gradient-success",
                                        cancelButton: "btn bg-gradient-danger"
                                    },
                                    buttonsStyling: false,
                                    title: "Warning!",
                                    text: "You have already uploaded a file for this month. Do you wish to upload another file?",
                                    icon: "warning",
                                    showCancelButton: true,
                                    confirmButtonText: "Yes, proceed!",
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        myDropzone.processQueue();
                                        $("#loading2").fadeIn();
                                    }
                                });
                            } else {
                                myDropzone.processQueue();
                                $("#loading2").fadeIn();
                            }
                        },
                        error: (xhr, status, error) => {
                            if (xhr.responseJSON && xhr.responseJSON.error) {
                                Swal.fire({
                                    title: "Error!",
                                    text: xhr.responseJSON.error, // Display error message from server
                                    icon: "error",
                                    confirmButtonText: "Okay"
                                });
                            }
                        }
                    });
                    
                }
            });
        } else {
            notif.showNotification('top', 'right', 'Warning, please add file first!', 'warning');
        }
    });

    Dropzone.options.myDropzone = {
        timeout: 300000, 
    };
    

    myDropzone.on("sending", function(file, xhr, formData) {
        formData.append("_token", $("#token").val());
        formData.append("month_year_icd", $("#month_year_icd").val());
    });

    myDropzone.on("success", function(file, response) {
        $("#loading2").fadeOut();
    
        if (response.success === "uploaded") {
            Swal.fire({
                title: "Success!",
                text: "File successfully imported",
                icon: "success",
                confirmButtonText: "Okay"
            }).then((result) => {
                location.reload();
            });
        } else if (response.success === "empty") {
            Swal.fire({
                title: "Warning!",
                text: "There is an empty cell. Please check and fill it first.",
                icon: "warning",
                confirmButtonText: "Okay"
            });
        } else {
            Swal.fire({
                title: "Error!",
                text: "An unexpected error occurred.",
                icon: "error",
                confirmButtonText: "Okay"
            });
        }
    });
    

    myDropzone.on("error", function(file, response) {
        $("#loading2").fadeOut();
        console.log(response)

    });
});




