
$(document).on('submit', '#form_reclassification', function(e) {
    e.preventDefault();
    Swal.fire({

        customClass: {
            confirmButton: "btn bg-gradient-success",
            cancelButton: "btn bg-gradient-danger"
        },
        buttonsStyling: !1,
        
        title: "Are you sure?",
        text: "You want to upload this certificate?",
        icon: "warning",
        showCancelButton: true,
        showCancelButton: !0,
        confirmButtonText: "Yes, proceed!",
    }).then((result) => {
        if (result.isConfirmed) {
            var token = $("#token").val();
            var urlReclassificationSave = $( "#urlReclassificationSave" ).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });

            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: urlReclassificationSave,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    if(data == 'exist')
                    {
                        Swal.fire({
                            title: "Warning!",
                            text: "You have a pending application that needs approval from the PPS Admin. Please contact the PPS Admin regarding your application.",
                            icon: "warning",
                            confirmButtonText: "Okay"
                        })
                    }
                    else
                    {
                        Swal.fire({
                            title: "Success!",
                            text: "Your certificate has been successfully uploaded. Please wait for the admin to approve your application.",
                            icon: "success",
                            confirmButtonText: "Okay"
                        }).then((result) => {
            
                                window.location.href = '/dashboard'
                        });
                    }
                    
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
    })
});

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
});

function previewResidencyCertificate(event) {
    const input = event.target;
    const preview = document.getElementById('preview-residency');

    if (input.files && input.files[0]) {
        const reader = new FileReader();    

        reader.onload = function (e) {
            preview.src = e.target.result; // Set the preview image source
            preview.classList.remove('d-none'); // Make the preview visible
        };

        reader.readAsDataURL(input.files[0]); // Read the file
    } else {
        preview.src = ''; // Reset preview if no file is selected
        preview.classList.add('d-none'); // Hide the preview
    }
}


function previewGovernmentCertificate(event) {
    const input = event.target;
    const preview = document.getElementById('preview-government');

    if (input.files && input.files[0]) {
        const reader = new FileReader();    

        reader.onload = function (e) {
            preview.src = e.target.result; // Set the preview image source
            preview.classList.remove('d-none'); // Make the preview visible
        };

        reader.readAsDataURL(input.files[0]); // Read the file
    } else {
        preview.src = ''; // Reset preview if no file is selected
        preview.classList.add('d-none'); // Hide the preview
    }
}


function previewFellowsTrainingCertificate(event) {
    const input = event.target;
    const preview = document.getElementById('preview-fellows-training');

    if (input.files && input.files[0]) {
        const reader = new FileReader();    

        reader.onload = function (e) {
            preview.src = e.target.result; // Set the preview image source
            preview.classList.remove('d-none'); // Make the preview visible
        };

        reader.readAsDataURL(input.files[0]); // Read the file
    } else {
        preview.src = ''; // Reset preview if no file is selected
        preview.classList.add('d-none'); // Hide the preview
    }
}





