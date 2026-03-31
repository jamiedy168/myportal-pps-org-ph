$(document).ready(function() {

    if($('.event_id').length > 0)
    {
        $('.event_id').select2({   
        }).on('select2:open', function (e) {
        document.querySelector('.select2-search__field').focus();
        });
    }

 
    $('.select2-container--default .select2-selection--multiple').css('min-height', '37px');

});

$('#form-generate-report').submit(function(e) {
    e.preventDefault();
    
    Swal.fire({
        customClass: {
            confirmButton: "btn bg-gradient-success",
            cancelButton: "btn bg-gradient-danger"
        },
        buttonsStyling: false,
        title: "Are you sure",
        text: "You want to generate report?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, proceed!",
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "Generating Report!",
                html: "Please wait while the report is being generated.",
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            var token = $("#token").val();
            var url = $("#urlGenerateEventAttendance").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });

            var formData = new FormData();
            formData.append('event_id', $("#event_id").val());

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                xhrFields: {
                    responseType: 'blob'
                },
                success: (blob, status, xhr) => {
                    
                    var filename = ""; 
                    var disposition = xhr.getResponseHeader('Content-Disposition');
                    if (disposition && disposition.indexOf('attachment') !== -1) {
                        var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                        var matches = filenameRegex.exec(disposition);
                        if (matches != null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                    }
    
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = filename || 'report.xlsx';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
    
                    // Close the loading alert
                    Swal.close();
                },
                error: function(data) {
                    // Handle error and close the loading alert
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!'
                    });
                }
            });
        }
    })

});
