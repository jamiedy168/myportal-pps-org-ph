$(document).ready(function() {
    if($('.member_type_id').length > 0)
    {
        $('.member_type_id').select2({     
            dropdownParent: $("#modalApprove")  
            }).on('select2:open', function (e) {
            document.querySelector('.select2-search__field').focus();
        });
    }
    
});

$(document).on('submit', '#form_reclassification_submit', function(e) {
    e.preventDefault();
    Swal.fire({

        customClass: {
            confirmButton: "btn bg-gradient-success",
            cancelButton: "btn bg-gradient-danger"
        },
        buttonsStyling: !1,
        
        title: "Are you sure?",
        text: "You want to approve this application?",
        icon: "warning",
        showCancelButton: true,
        showCancelButton: !0,
        confirmButtonText: "Yes, proceed!",
    }).then((result) => {
        if (result.isConfirmed) {
            var token = $("#token").val();
            var urlMemberReclassificationSave = $( "#urlMemberReclassificationSave" ).val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });

            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: urlMemberReclassificationSave,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    Swal.fire({
                        title: "Success!",
                        text: "Application successfully approved.",
                        icon: "success",
                        confirmButtonText: "Okay"
                    }).then((result) => {
                        window.location.href = '/member-reclassification'
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
