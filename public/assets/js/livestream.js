function unpaid()
{
  Swal.fire({
    title: "Warning!",
    text: "You need to pay for this event before joining to this livestream.",
    icon: "warning",
    confirmButtonText: "Okay"
  })
}

function completed()
{
  Swal.fire({
    title: "Warning!",
    text: "Unable to join the livestream, the event has already ended.",
    icon: "warning",
    confirmButtonText: "Okay"
  })
}

function upcoming()
{
  Swal.fire({
    title: "Warning!",
    text: "Unable to join the livestream, the event has not started.",
    icon: "warning",
    confirmButtonText: "Okay"
  })
}

function notLiveStream()
{
  Swal.fire({
    title: "Warning!",
    text: "Only participants who choose the livestream option can proceed to this event.",
    icon: "warning",
    confirmButtonText: "Okay"
  })
}


$(document).ready(function () {
  function refreshSurveyLink() {
      $("#survey-container").load(window.location.href + " #survey-container > *");
  }

  // Refresh the div every 10 seconds
  setInterval(refreshSurveyLink, 10000);
});


