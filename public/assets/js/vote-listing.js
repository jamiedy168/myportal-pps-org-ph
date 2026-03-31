$(document).on('click', '.votenow', function () {
    Swal.fire({

      customClass: {
          confirmButton: "btn bg-gradient-success",
          cancelButton: "btn bg-gradient-danger"
      },
      buttonsStyling: !1,
      
      title: "Are you sure?",
      text: "You want to cast your vote now?",
      icon: "warning",
      showCancelButton: true,
      showCancelButton: !0,
      confirmButtonText: "Yes, proceed!",
  }).then((result) => {
    if (result.isConfirmed) {
        var token = $("#token2").val();
        var url = $( "#urlVotingCheckAllowed" ).val();
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': token
          }
      });
        $.ajax({
          type: 'get',
          url: url,
          data: { 'voting_id' : this.id,      
              },
          
          success: (data) => {
            if(data == "alreadyvoted")
            {
              Swal.fire({
                  title: "Warning!",
                  text: "You already vote on this election.",
                  icon: "warning",
                  confirmButtonText: "Okay"
              })
            }
            // else if(data == "notjoined")
            // {
            //   Swal.fire({
            //     title: "Warning!",
            //     text: "You need to join/pay the annual convention first.",
            //     icon: "warning",
            //     confirmButtonText: "Okay"
            //   })
            // }
            // else if(data == "paymenttimenotmeet")
            // {
            //   Swal.fire({
            //     title: "Unable to vote!",
            //     text: "Sorry, you did not meet the required date/time payment for annual convention.",
            //     icon: "warning",
            //     confirmButtonText: "Okay"
            //   })
            // }
            // else if(data == "existannualdues")
            // {
            //   Swal.fire({
            //       title: "Warning!",
            //       text: "You have remaining annual dues that need to pay before casting your vote!",
            //       icon: "warning",
            //       confirmButtonText: "Okay"
            //   })
            // }
            else
            {
              var firsturl = "/voting-elect/";
              var voting_id = data;
              window.location.href = firsturl + voting_id;
            
            }
           
              
            
            
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
  })
 
});


function notallowedvote()
{
    Swal.fire({
      title: "Warning,",
      text: "Only diplomate, fellow and emeritus fellow are allowed to vote.",
      icon: "warning",
      confirmButtonText: "Okay"
    })
}


function votingClose()
{
    Swal.fire({
      title: "Warning,",
      text: "Voting is not allowed at this time, please check the election date and time.",
      icon: "warning",
      confirmButtonText: "Okay"
    })
}
