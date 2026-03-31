
$(document).ready(function() {

    $(function(){
        $(window).on('load',function(){
            $('#loading3').hide();
          
        });
    });

    $('.cpd_points_category_id').select2({     
        dropdownParent: $("#modalAddCPDPoints")  
        }).on('select2:open', function (e) {
          document.querySelector('.select2-search__field').focus();
    });

    $('.event_id').select2({     
        dropdownParent: $("#modalAddCPDPoints")  
        }).on('select2:open', function (e) {
          document.querySelector('.select2-search__field').focus();
    });


    $('#cpd_points_category_id').on('change', function() {
        var category = $("#cpd_points_category_id option:selected").text();
        if ( category == 'EVENT')
        {
          $("#event_title_row").show();
        }
        else
        {
          $("#event_title_row").hide();
          $("#event_id").val('').trigger('change')
          $("#cpd_points").val(0);
    
        }
    });



    $('#event_id').on('select2:select', function (e) {
        var data = e.params.data;
        $("#cpd_points").val(data['title']);
  
    });

    $("#btnSaveCpdPoints").click(function(){
        Swal.fire({
            customClass: {
              confirmButton: "btn bg-gradient-success",
              cancelButton: "btn bg-gradient-danger"
          },
          buttonsStyling: !1,
          
          title: "Are you sure?",
          text: "You want to save this CPD Points?",
          icon: "warning",
          showCancelButton: true,
          showCancelButton: !0,
          confirmButtonText: "Yes, proceed!",
        }).then((result) => {
            if (result.isConfirmed) {
                var url = $( "#urlSaveCpdPoints" ).val();

                var token = $( "#token" ).val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                });

                $.ajax({
                  type : 'get',
                  url: url,
                  data : { 'pps_no' : $("#pps_no").val(),
                           'category_name' : $("#cpd_points_category_id").val(),
                           'event_id' : $("#event_id").val(),
                           'points' : $("#cpd_points").val(),
                           
                          
                        },
                  success:function(res){
                    $( "#refreshDiv" ).load(window.location.href + " #refreshDiv" );
                    Swal.fire({
                        title: "Success!",
                        text: "CPD Points successfully saved!",
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


 


// Bar chart
// var ctx5 = document.getElementById("bar-chart").getContext("2d");

// new Chart(ctx5, {
//     type: "bar",
//     data: {
//         labels: ['16-20', '21-25', '26-30', '31-36', '36-42', '42+'],
//         datasets: [{
//             label: "Sales by age",
//             weight: 5,
//             borderWidth: 0,
//             borderRadius: 4,
//             backgroundColor: '#3A416F',
//             data: [15, 20, 12, 60, 20, 15],
//             fill: false,
//             maxBarThickness: 35
//         }],
//     },
//     options: {
//         responsive: true,
//         maintainAspectRatio: false,
//         plugins: {
//             legend: {
//                 display: false,
//             }
//         },
//         scales: {
//             y: {
//                 grid: {
//                     drawBorder: false,
//                     display: true,
//                     drawOnChartArea: true,
//                     drawTicks: false,
//                     borderDash: [5, 5],
//                     color: '#c1c4ce5c'
//                 },
//                 ticks: {
//                     display: true,
//                     padding: 10,
//                     color: '#9ca2b7',
//                     font: {
//                         size: 14,
//                         weight: 300,
//                         family: "Roboto",
//                         style: 'normal',
//                         lineHeight: 2
//                     },
//                 }
//             },
//             x: {
//                 grid: {
//                     drawBorder: false,
//                     display: false,
//                     drawOnChartArea: true,
//                     drawTicks: true,
//                     color: '#c1c4ce5c'
//                 },
//                 ticks: {
//                     display: true,
//                     color: '#9ca2b7',
//                     padding: 10,
//                     font: {
//                         size: 14,
//                         weight: 300,
//                         family: "Roboto",
//                         style: 'normal',
//                         lineHeight: 2
//                     },
//                 }
//             },
//         },
//     },
// });




});

function belowCPD()
{
    Swal.fire({
        title: "Warning!",
        text: "It seems that the number of CPD points you have earned is below the minimum requirement needed to print your certificate.",
        icon: "warning",
        confirmButtonText: "Okay"
    })
}



