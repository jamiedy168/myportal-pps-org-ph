function deleteRecords(id)
{

    Swal.fire({
        customClass: {
            confirmButton: "btn bg-gradient-success",
            cancelButton: "btn bg-gradient-danger"
        },
        buttonsStyling: !1,
        
        title: "Are you sure",
        text: "You want to delete this and all records included on this month?",
        icon: "warning",
        showCancelButton: true,
        showCancelButton: !0,
        confirmButtonText: "Yes, proceed!",
        
    }).then((result) => {
        if (result.isConfirmed) {

                var token = $("#token").val();
                var url = $( "#urlICDNeonatalDelete" ).val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                });
                
                $.ajax({
                    type: 'get',
                    url: url,
                    data: { 'id' : id,      
                     },
                   
                    success: (data) => {
                        
                            Swal.fire({
                                title: "Deleted!",
                                text: "Records successfully deleted",
                                icon: "success",
                                confirmButtonText: "Okay"
                            }).then((result) => {
                                location.reload();
                            });
                
                    },
                    error: function(data) { 
                        Swal.fire({
                            title: "Warning!",
                            text: "Something error",
                            icon: "error",
                            confirmButtonText: "Okay"
                        })
                    }
                });
              
              
        }
    });
}



function deleteNeonatalPatient(id)
{

    Swal.fire({
        customClass: {
            confirmButton: "btn bg-gradient-success",
            cancelButton: "btn bg-gradient-danger"
        },
        buttonsStyling: !1,
        
        title: "Are you sure",
        text: "You want to delete this patient record?",
        icon: "warning",
        showCancelButton: true,
        showCancelButton: !0,
        confirmButtonText: "Yes, proceed!",
        
    }).then((result) => {
        if (result.isConfirmed) {

                var token = $("#token").val();
                var url = $( "#urlICDNeonatalPatientDelete" ).val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                });
                
                $.ajax({
                    type: 'get',
                    url: url,
                    data: { 'id' : id,      
                     },
                   
                    success: (data) => {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Records successfully deleted",
                                icon: "success",
                                confirmButtonText: "Okay"
                            }).then((result) => {
                                $( "#refreshDiv" ).load(window.location.href + " #refreshDiv" );
                                $( "#refreshDiv2" ).load(window.location.href + " #refreshDiv2" );
                            });
                    },
                    error: function(data) { 
                        Swal.fire({
                            title: "Warning!",
                            text: "Something error",
                            icon: "error",
                            confirmButtonText: "Okay"
                        })
                    }
                });
              
              
        }
    });
}

