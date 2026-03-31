$("#modalEventPay").on("show.bs.modal", function(e) {
    
    var id = $(e.relatedTarget).data('target-id');
    var event_title = $(e.relatedTarget).data('target-title');
    var event_category = $(e.relatedTarget).data('target-category');
    var event_joined_dt = $(e.relatedTarget).data('target-joined-dt');
    var event_description = $(e.relatedTarget).data('target-description');
    var first_name = $(e.relatedTarget).data('target-first_name');
    var middle_name = $(e.relatedTarget).data('target-middle_name');
    var last_name = $(e.relatedTarget).data('target-last_name');
    var suffix = $(e.relatedTarget).data('target-suffix');
    var pps_no = $(e.relatedTarget).data('target-pps_no');
    
    var email_address = $(e.relatedTarget).data('target-email_address');
    var mobile_number = $(e.relatedTarget).data('target-mobile_number');
    var country_code = $(e.relatedTarget).data('target-country_code');
    var type = $(e.relatedTarget).data('target-type');
    var price = $(e.relatedTarget).data('target-price');
   
    var price2 = '? ' + price + '.00';
    var mobile_number2 = country_code + ' ' + mobile_number;
    var member_name = first_name + ' ' + middle_name + ' ' + last_name + ' ' + suffix;
    var joined_dt = moment(event_joined_dt).format('DD MMM YYYY hh:mm A');
   
    
    
    $('#transaction_id').val(id);
    $('#event_title').text(event_title);
    $('#event_category').text(event_category);
    $('#event_joined_dt').text(joined_dt);
    $('#event_description').text(event_description);
    $('#member_name').text(member_name);
    $('#pps_no').val(pps_no);
    
    $('#email_address').text(email_address);
    $('#mobile_number').text(mobile_number2);
    $('#type').text(type);
    $('#price').text(price2);
    $('#total_price').val(price + '00');
    $('#price_validation').val(price);
    
    $('#total_amount').text(price2);
    

    $("#member_amount").keyup(function(){
        
        var member_amount = $("#member_amount").val();
        if(member_amount == "0")
        {
            $('#change').text('? 0.00');
        }
        else{
            var change =  member_amount - price
            var change2 = '? ' + change + '.00';
    
            $('#change').text(change2);
            $('#change_validation').val(change);
        }
        
    });

    
});



$('#cashier-event-pay').submit(function(e) {
    e.preventDefault();
    
        $("#loading2").fadeIn();
        var url = $( "#urlCashierEventPay" ).val();
        var token = $( "#token" ).val();
    
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
        });

        var formData = new FormData(this);
        formData.append('total_price',$( "#total_price" ).val());
        
        
        
        $.ajax({
            type: 'post',
            url: url,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                // console.log(data);
                
        
            },
            error: function(data) {
                // console.log(data);
            }
        });
        
    
  });

// function plus(){

//     countEl = document.getElementById("amount3");
//     count = countEl.value;
//     count++;
//     countEl.value = count;
    
// }
// function minus(){
    
//   countEl = document.getElementById("amount3");
//   total_price = document.getElementById("total_price").value;

//     count = countEl.value;
//     if (count > 1) {
//       count--;
//       countEl.value = count;
     
//    } 

  
// }


$(document).ready(function(){

    if ($(".member").length > 0)
    {
        $('.member').select2({       
        }).on('select2:open', function (e) {
        document.querySelector('.select2-search__field').focus();
        });
    }

    $('.updated-payment-member').select2({     
        dropdownParent: $("#modalEventUpdateOnlinePayment"),
        minimumInputLength: 2,  
            }).on('select2:open', function (e) {
            document.querySelector('.select2-search__field').focus();
    });

    $('.update-payment-event').select2({     
        dropdownParent: $("#modalEventUpdateOnlinePayment")
            }).on('select2:open', function (e) {
            document.querySelector('.select2-search__field').focus();
    });


    let searchUrl = $('#memberSearchUrl').val();

    $('.updated-payment-member').select2({
        dropdownParent: $("#modalEventUpdateOnlinePayment"),
        placeholder: '-- CHOOSE MEMBER --',
        ajax: {
            url: searchUrl, // dynamically loaded URL
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return { q: params.term };
            },
            processResults: function (data) {
                return { results: data.results };
            },
            cache: true
        },
        minimumInputLength: 1,
        width: '100%'
    });



   
    

    
    

    var price = $('#priceofevent').val();

    $('#plusBtn').click(function() {
       $('.amount3').val(function(i, val) { 
            var member_amount = val*1+1;
            var change =  Number(member_amount) - Number(price);
            var change2 = '? ' + change + '.00';

            $('#change3').text(change2);
            $('#final_change').val(change);
         
           return val*1+1 
        

       });
    });
    $('#minusBtn').click(function() {
        if($('.amount3').val() <= price)
        {
            notif.showNotification('top', 'right', 'Warning, amount should not be lower than event price !', 'danger');
        }
        else
        {
            $('.amount3').val(function(i, val) {
                if(val>1)
                {
                    var member_amount = val*1-1;
                    var change =  Number(member_amount) - Number(price);
                    var change2 = '? ' + change + '.00';

                    $('#change3').text(change2);
                    $('#final_change').val(change);
                 
                    return val*1-1 
                }
                
                
            });
        }
         
    }); 
 });

$("#amount3").keyup(function(){
        
    var member_amount = $("#amount3").val();
    var price =  $("#priceofevent").val();
    if(Number(member_amount) == "0" || Number(member_amount) == "")
    {
        $('#change3').text('? 0.00');
        $('#final_change').val(0);
    }

    else{
        var change =  member_amount - price
        var change2 = '? ' + change + '.00';

        $('#change3').text(change2);
        $('#final_change').val(change);
        

    }
    
});
 
$('#paycashierBtn').click(function(e) {
    e.preventDefault();
    var member_amount = $("#amount3").val();
    var price =  $("#priceofevent").val();
    
    if(Number(member_amount) == 0 || Number(member_amount) == "")
    {   
        notif.showNotification('top', 'right', 'Warning, please input amount !', 'danger');
        $("#amount3").focus();
    }
    else if(Number(member_amount) < Number(price))
    {
        notif.showNotification('top', 'right', 'Warning, amount should not be lower than event price !', 'danger');
        $("#amount3").focus();
    }
    else
    {
        Swal.fire({
            customClass: {
              confirmButton: "btn bg-gradient-success",
              cancelButton: "btn bg-gradient-danger"
          },
          buttonsStyling: !1,
          
          title: "Are you sure?",
          text: "You want to proceed this payment?",
          icon: "warning",
          showCancelButton: true,
          showCancelButton: !0,
          confirmButtonText: "Yes, proceed!",
        }).then((result) => {
            if (result.isConfirmed) {
                var url = $( "#urlCashierEventPayManual" ).val();
                var token2 = $( "#token2" ).val();
                var priceofevent = $( "#priceofevent" ).val();
                var transaction_ids = $( "#transaction_ids" ).val();
                var amount3 = $( "#amount3" ).val();
                var pps_no = $( "#pps_no" ).val();

                var final_change = $( "#final_change" ).val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': token2
                    }
                });

                $.ajax({
                    type: 'get',
                    url: url,
                    data : { 'priceofevent' : priceofevent,
                             'transaction_id' : transaction_ids,
                             'amount' : amount3,
                             'pps_no' : pps_no,
                             'change' : final_change
						   },
                    success: (data) => {
                        Swal.fire({
                            title: "Completed!",
                            text: "Payment Successful!",
                            icon: "success",
                            confirmButtonText: "Okay"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location=data.url;
                            }
                            else{
                                window.location=data.url;
                            }
                        });
                    },
                    error: function(data) {
                        Swal.fire({
                            title: "Cancelled!",
                            text: "Payment not completed!",
                            icon: "error",
                            confirmButtonText: "Okay"
                        })
                    }
                });
              
            }
        });
    }
    

});

$(document).on('click', '#addMemberCustomerBtn', function () 
{
    if($("#member").val() == "")
    {
        notif.showNotification('top', 'right', 'Warning, please choose member first !', 'warning');
    }

    else
    {
        
        var member = $("#member").val();
        var url = $( "#urlAddCustomer" ).val();
        var token = $( "#token" ).val();
        var event_id = $( "#event_id" ).val();
  
    
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
        });
    
        $.ajax({
            type: 'get',
            url: url,
            data: { 'pps_no' : member,
                    'event_id' : event_id
                   
         },
           
            success: (data) => {
                if(data == "exist")
                {
                    notif.showNotification('top', 'right', 'Member already paid on this event!', 'warning');
                }
                else if(data == "selected")
                {
                    notif.showNotification('top', 'right', 'Member already selected on the list!', 'warning');
                }
                else
                {
                    $("#memberselected").load(window.location.href + " #memberselected");
                }
                
               
      
              },
              error: function(data) {
                notif.showNotification('top', 'right', 'Something error!', 'danger');
              }
          });
    }


});



// $('#cashier-event-pay').submit(function(e) {
//     e.preventDefault();
//     if($('#member_amount').val() < $('#price_validation').val())
//     {
//         notif.showNotification('top', 'right', 'Warning, amount should not be lower than event price !', 'danger');
//         $("#member_amount").focus();
//         $("#member_amount").addClass("is-invalid");
//     }
//     else{
//         $("#loading2").fadeIn();
//         var url = $( "#urlCashierEventPay" ).val();
//         var token = $( "#token" ).val();
    
//         $.ajaxSetup({
//             headers: {
//                 'X-CSRF-TOKEN': token
//             }
//         });
    
//         var formData = new FormData(this);
//         formData.append('transaction_id',$( "#transaction_id" ).val());
//         formData.append('member_amount',$( "#member_amount" ).val());
//         formData.append('change',$( "#change_validation" ).val());
//         formData.append('or_no',$( "#or_no" ).val());
//         formData.append('total_amount',$( "#price_validation" ).val());
//         formData.append('pps_no',$( "#pps_no" ).val());

//         formData.append('total_price',$( "#total_price" ).val());
        
        
        
//         $.ajax({
//             type: 'post',
//             url: url,
//             data: formData,
//             cache: false,
//             contentType: false,
//             processData: false,
//             success: (data) => {

//                 $("#loading2").fadeOut();
//                 $("#cashier-event-pay").trigger("reset");
//                 $("#change").html("");
//                 $('#modalEventPay').modal('hide');
              
                
//                 Swal.fire({
//                     title: "Completed!",
//                     text: "Payment Successful!",
//                     icon: "success",
//                     confirmButtonText: "Okay"
//                 }).then((result) => {
//                     if (result.isConfirmed) {
//                         location.reload(true);
//                     }
//                     else{
//                         location.reload(true);
//                     }
//                 });
                
        
//             },
//             error: function(data) {
//                 console.log(data);
//             }
//         });
//         }
    
//   });


  $('#modalEventPay').on('hidden.bs.modal', function () {
    $("#cashier-event-pay").trigger("reset");
    $("#change").html("");

  });


  $('#cashierupdateonlinepaymentform').submit(function(e) {
    e.preventDefault();

    var url = $( "#urlCashierEventUpdatePayment" ).val();
    var token = $( "#token2" ).val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token
        }
    });

        var formData = new FormData(this);
        formData.append('pps_no',$( "#pps_no_update" ).val());
        formData.append('event_id',$( "#event_id_update" ).val());
        formData.append('paymongo_transaction_number',$( "#paymongo_transaction_number_update" ).val());
      
        $.ajax({
            type: 'post',
            url: url,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                if(data == 'exist')
                {
                    Swal.fire({
                        title: "Warning!",
                        text: "Member already paid on this event!",
                        icon: "warning",
                        confirmButtonText: "Okay"
                    })
                }
                else if(data == 'completed')
                {
                    Swal.fire({
                        title: "Completed!",
                        text: "Payment Update Successful!",
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

                }
                else
                {
                    Swal.fire({
                        title: "Warning!",
                        text: "Payment update not completed!",
                        icon: "error",
                        confirmButtonText: "Okay"
                    })
                }
               

            },
            error: function(data) {
                Swal.fire({
                    title: "Warning!",
                    text: "Payment update not completed!",
                    icon: "error",
                    confirmButtonText: "Okay"
                })
            }
        });

    
  });
