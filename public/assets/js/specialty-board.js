$('#profileNotCompeleteBtn').click(function() {
    Swal.fire({
        title: "Warning!",
        text: "Please update your profile first.",
        icon: "warning",
        confirmButtonText: "Okay"
    })
});