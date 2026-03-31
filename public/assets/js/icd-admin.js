
$(document).ready(function () {

    if($('.hospital').length > 0)
        {
            $('.hospital').select2({     
                }).on('select2:open', function (e) {
                  document.querySelector('.select2-search__field').focus();
            });
        }

});
    

$(document).on('click', '.add_list', function () {
    var id = $(this).attr('data-id');
    var description = $(this).attr('data-description');
    

    Swal.fire({
        customClass: {
            confirmButton: "btn bg-gradient-success",
            cancelButton: "btn bg-gradient-danger"
        },
        buttonsStyling: !1,
        
        title: "Are you sure",
        text: "You want to add this to ICD code list?",
        icon: "warning",
        showCancelButton: true,
        showCancelButton: !0,
        confirmButtonText: "Yes, proceed!",
        
    }).then((result) => {
        if (result.isConfirmed) {
            var url = $( "#urlICDAdminAddCode" ).val();
            var token = $( "#token" ).val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });

            $.ajax({
                type : 'get',
                url: url,
                data : { 'id' : id,
                         'description' : description

                      },
                success:function(res){
               
                    Swal.fire({
                        title: "Success!",
                        text: "New ICD code added.",
                        icon: "success",
                        confirmButtonText: "Okay"
                    }).then((result) => {
                        location.reload(true);
                    });

                }
              });
        }
    });

});