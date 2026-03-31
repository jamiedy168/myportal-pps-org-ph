$(document).ready(function() {
    if($('.member_type').length > 0)
    {
        $('.member_type').select2({   
            multiple: true,  
            placeholder: 'Select member type',
            closeOnSelect: false,
        }).on('select2:open', function (e) {
        document.querySelector('.select2-search__field').focus();
        });

        $('.member_type').val(null);
        $('.select2-selection__rendered').html(''); 
    }
    if($('.member_chapter').length > 0)
    {
        $('.member_chapter').select2({   
        }).on('select2:open', function (e) {
        document.querySelector('.select2-search__field').focus();
        });
    }
    if($('.classification').length > 0)
    {
        $('.classification').select2({   
        }).on('select2:open', function (e) {
        document.querySelector('.select2-search__field').focus();
        });
    }


    
 
    $('.select2-container--default .select2-selection--multiple').css('min-height', '37px');

});

$('#form-generate-report').submit(function(e) {
    e.preventDefault();

    var memberTypeFilled = $("#member_type").val() !== "";
    var memberChapterFilled = $("#member_chapter").val() !== "";

    if($("#member_type").val() == "" && $("#member_chapter").val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up member type or chapter!', 'warning');
    }
    else if (!memberTypeFilled && !memberChapterFilled) 
    {
        notif.showNotification('top', 'right', 'Warning, please fill-up member type or chapter!', 'warning');
    }
    else
    {
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
                // Show loading alert
                Swal.fire({
                    title: "Generating Report!",
                    html: "Please wait while the report is being generated.",
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
        
                var token = $("#token").val();
                var url = $("#urlGenerateMember").val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                });
        
                var formData = new FormData();
                var memberTypeValues = $("#member_type").val();
                var selectedData = $('#member_type').select2('data');
                var selectedTexts = selectedData.map(function(item) {
                    return item.text;
                });
                memberTypeValues.forEach(function(value) {
                    formData.append('member_type[]', value);
                });
        
                formData.append('member_chapter', $("#member_chapter").val());
                formData.append('classification', $("#classification").val());
                formData.append('member_type_texts', selectedTexts.join(', '));
        
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
                        $( "#refreshDiv" ).load(window.location.href + " #refreshDiv" );
                        
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
        });
          
                

        
    }
});


