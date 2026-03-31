$(document).ready(function() {

    $(function(){
        $(window).on('load',function(){
            $('#loading3').hide();
          
        });
    });

    $(".deleteid").click(function(){
        var id = this.id;
       
        Swal.fire({

            customClass: {
                confirmButton: "btn bg-gradient-success",
                cancelButton: "btn bg-gradient-danger"
            },
            buttonsStyling: !1,
            
            title: "Are you sure?",
            text: "You want to delete this document?",
            icon: "warning",
            showCancelButton: true,
            showCancelButton: !0,
            confirmButtonText: "Yes, delete it!",
         
            
        }).then((result) => {
            if (result.isConfirmed) {
              
                var urlDeleteDocument = $( "#urlDeleteDocument" ).val();
                var token = $("#token2").val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                });
                $.ajax({
                    type : 'get',
                    url: urlDeleteDocument,
                    data : { 'id' : id
                           
                          },
                    success:function(res){
                        
                        Swal.fire({
                            title: "Success!",
                            text: "Document successfully remove!",
                            icon: "success",
                            confirmButtonText: "Okay"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload(true);
                            }
                            else
                            {
                                location.reload(true);
                            }
                        });
                        
                   
                    }
                  });

                
            }
           
        });
   });

    $('.document_id').select2({     
        dropdownParent: $("#modalUploadDocument")  
        }).on('select2:open', function (e) {
          document.querySelector('.select2-search__field').focus();
    });

    $('#modalUploadDocument').on('hidden.bs.modal', function () {
        $(this).find('form').trigger('reset');
        $("#image_preview").empty();
      });

    if (document.getElementById('image_count')) {
        const countUp = new CountUp('image_count', document.getElementById("image_count").getAttribute("countTo"));
        if (!countUp.error) {
            countUp.start();
        } else {
            console.error(countUp.error);
        }
    }
    if (document.getElementById('pdf_count')) {
        const countUp = new CountUp('pdf_count', document.getElementById("pdf_count").getAttribute("countTo"));
        if (!countUp.error) {
            countUp.start();
        } else {
            console.error(countUp.error);
        }
    }
    if (document.getElementById('others_count')) {
        const countUp = new CountUp('others_count', document.getElementById("others_count").getAttribute("countTo"));
        if (!countUp.error) {
            countUp.start();
        } else {
            console.error(countUp.error);
        }
    }

    

    

    $('#documents-upload').submit(function(e) {
        e.preventDefault();
        Swal.fire({

            customClass: {
                confirmButton: "btn bg-gradient-success",
                cancelButton: "btn bg-gradient-danger"
            },
            buttonsStyling: !1,
            
            title: "Are you sure?",
            text: "You want to upload this documents?",
            icon: "warning",
            showCancelButton: true,
            showCancelButton: !0,
            confirmButtonText: "Yes, upload it!",
         
            
        }).then((result) => {
            if (result.isConfirmed) {
                
                $("#loading5").fadeIn();
                var url = $( "#urlDocumentsUpload" ).val();
                var token2 = $( "#token2" ).val();

                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': token2
                    }
                });
                var formData = new FormData(this);
                let TotalFiles = $('#images')[0].files.length; //Total files
                let files = $('#images')[0];
                for (let i = 0; i < TotalFiles; i++) {
                    formData.append('images' + i, files.files[i]);
                }
                formData.append('TotalFiles', TotalFiles);
                formData.append('document_id', $("#document_id").val());
                formData.append('pps_no', $( "#pps_no" ).val());
                
                
                $.ajax({
                    type: 'post',
                    url: url,
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $("#loading5").fadeOut();
                        $('#modalUploadDocument').removeData();
                        $("#images").val(null);
                        $("#image_preview").empty();
                        $('#modalUploadDocument').modal('hide');
                       
                        Swal.fire({
                            title: "Success!",
                            text: "Document successfully uploaded!",
                            icon: "success",
                            confirmButtonText: "Okay"
                            
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload(true);
                            }
                            else{
                                location.reload(true);
                            }
                        });
                
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }
           
        });





     });


    var fileArr = [];
    $("#images").change(function(){
       // check if fileArr length is greater than 0
        if (fileArr.length > 0) fileArr = [];
      
         $('#image_preview').html("");
         var total_file = document.getElementById("images").files;
         if (!total_file.length) return;
         for (var i = 0; i < total_file.length; i++) {
           if (total_file[i].size > 1048576) {
             return false;
           } else {
             fileArr.push(total_file[i]);
            
             $('#image_preview').append("<div class='img-div' id='img-div"+i+"'><img src='"+URL.createObjectURL(event.target.files[i])+"' style='height: 40vh !important; width: 100%;' class='img-responsive image img-thumbnail' title='"+total_file[i].name+"'><div class='middle'><button id='action-icon' value='img-div"+i+"' class='btn btn-danger' role='"+total_file[i].name+"'><i class='fa fa-trash'></i></button></div></div>");
           }
         }
    });
   
   $('body').on('click', '#action-icon', function(evt){
       var divName = this.value;
       var fileName = $(this).attr('role');
       $(`#${divName}`).remove();
     
       for (var i = 0; i < fileArr.length; i++) {
         if (fileArr[i].name === fileName) {
           fileArr.splice(i, 1);
         }
       }
     document.getElementById('images').files = FileListItem(fileArr);
       evt.preventDefault();
   });
   
    function FileListItem(file) {
             file = [].slice.call(Array.isArray(file) ? file : arguments)
             for (var c, b = c = file.length, d = !0; b-- && d;) d = file[b] instanceof File
             if (!d) throw new TypeError("expected argument to FileList is File or array of File objects")
             for (b = (new ClipboardEvent("")).clipboardData || new DataTransfer; c--;) b.items.add(file[c])
             return b.files
         }
});