
$(".remove").click(function() {
    var url = $( "#urlCashierAnnualDuesRemove" ).val();
    var token = $( "#token" ).val();

    Swal.fire({

        customClass: {
            confirmButton: "btn bg-gradient-success",
            cancelButton: "btn bg-gradient-danger"
        },
        buttonsStyling: !1,
        
        title: "Are you sure",
        text: "You want to remove this annual dues?",
        icon: "warning",
        showCancelButton: true,
        showCancelButton: !0,
        confirmButtonText: "Yes, proceed!",
        
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });

            $.ajax({
                type: 'get',
                url: url,
                data: { 'id' : this.id,      
                 },
               
                success: (data) => {
                    Swal.fire({
                        title: "Success!",
                        text: "Annual dues successfully removed!",
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
});


function emptycart()
{
    notif.showNotification('top', 'right', 'Warning, there is no item in the cart, please add item first !', 'warning');
}

$("#modalUpdateORNumber").on("show.bs.modal", function(e) {
    var id = $(e.relatedTarget).data('target-id');
    $('#or_master_id').val(id);

});

$("#modalUpdateOnlinePayment").on("show.bs.modal", function(e) {
    var id = $(e.relatedTarget).data('target-id');
    $('#or_master_id_2').val(id);

});

$('#update-annual-dues-or-number').submit(function(e) {
    e.preventDefault();
    $("#loading3").fadeIn();
  
    var url = $( "#urlCashierAnnualDuesOrNumberUpdate" ).val();
    var token = $( "#token" ).val();
    Swal.fire({

        customClass: {
            confirmButton: "btn bg-gradient-success",
            cancelButton: "btn bg-gradient-danger"
        },
        buttonsStyling: !1,
        
        title: "Are you sure",
        text: "You want to update the or number of this annual fee?",
        icon: "warning",
        showCancelButton: true,
        showCancelButton: !0,
        confirmButtonText: "Yes, proceed!",
        
    })
    .then((result) => {
        if (result.isConfirmed) {
  
          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
          });
          

          var formData = new FormData(this);
          formData.append('or_master_id',$( "#or_master_id" ).val());
          formData.append('or_no',$( "#or_no" ).val());
          
  
          $.ajax({
            type: 'post',
            url: url,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
              $("#loading3").fadeOut();
            
              Swal.fire({
                  title: "Success!",
                  text: "O.R number successfully updated.",
                  icon: "success",
                  confirmButtonText: "Okay"
              }).then((result) => {
                  if (result.isConfirmed) {
                    location.reload();
                      
                  }
                  else{
                    location.reload();
                  }
              });
        
            },
            error: function(data) {
              $("#loading").fadeOut();
              Swal.fire({
                  title: "Warning!",
                  text: "Something wrong!",
                  icon: "error",
                  confirmButtonText: "Okay"
              })
            }
        });
          
   
         
          }
      });
});



$(document).ready(function(){

    $('#modalChoosePaymentType').on('hidden.bs.modal', function(e) {
        $(".payment_type").val("").trigger("change");
        $("#gcashtransaction").hide();
        $("#cardtransaction").hide();
      });

    $('#payment_type').on('change', function () {
        if (this.value === 'gcash'){
            $("#gcashtransaction").show();
            $("#cardtransaction").hide();
        } else {
            $("#cardtransaction").show();
            $("#gcashtransaction").hide();
        }
    });


   $('.choosemember').select2({     
    dropdownParent: $("#modalAnnualDuesNewTransaction"),
    minimumInputLength: 2,  
        }).on('select2:open', function (e) {
        document.querySelector('.select2-search__field').focus();
    });

    $('.payment_type').select2({     
        dropdownParent: $("#modalChoosePaymentType")
            }).on('select2:open', function (e) {
            document.querySelector('.select2-search__field').focus();
    });



    if ($(".bank_name").length > 0)
    {
        $('.bank_name').select2({     
            tags: true,
            dropdownParent: $("#modalAnnualDuesPayCheque")  
            }).on('select2:open', function (e) {
            document.querySelector('.select2-search__field').focus();
        });
    }

    if ($(".bank_transfer_name").length > 0)
    {
        $('.bank_transfer_name').select2({     
            tags: true,
            dropdownParent: $("#modalAnnualDuesPayBankTransfer")  
            }).on('select2:open', function (e) {
            document.querySelector('.select2-search__field').focus();
        });
    }


    

    $(document).on('click', '.add_cart', function () {
   
        var url = $( "#urlCashierAnnualDuesAddCart" ).val();
        var token = $( "#token" ).val();
       

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
        });

        $.ajax({
            type: 'get',
            url: url,
            data : { 'pps_no' : $( "#pps_no" ).val(),
                     'or_id' : $(this).data("id")
                    
                   },
            success: (data) => {
                if(data == "exist")
                {
                    notif.showNotification('top', 'right', 'Warning, annual dues already in the cart !', 'warning');
                }
                else
                {
                    $("#cartListRow").load(" #cartListRow > *");
                    $("#cartListModal").load(" #cartListModal > *");

                    
                 
                }
        
            },
            error: function(data) {
               
            }
        });
     });



    $(document).on('click', '.removeCart', function () {

        var url = $( "#urlCashierAnnualDuesRemoveCart" ).val();
        var token = $( "#token" ).val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
        });

        $.ajax({
            type: 'get',
            url: url,
            data : { 
                     'cart_id' : $(this).data("id")
                    
                   },
            success: (data) => {
                
                $("#cartListRow").load(" #cartListRow > *");
            },
            error: function(data) {
               
            }
        });


  
     });
});

    $(document).on('keyup', '.amount3', function () {
        var amount = $('#amount3').val();
        
        var carttotal = $('#carttotal').val();
        var change = Number(amount) - Number(carttotal);
        var change_text = '₱ ' + change + '.00';
        $('#change').val(change);
        $('#changeText').text('₱ ' + parseFloat(change, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());

        // if(Number(amount) < Number(carttotal))
        // {
        //     $("#warningDiv").show();
        // }
        // else
        // {
        //     $("#warningDiv").hide();
        // }

        if(amount == "" || amount == null || amount == 0)
        {
            $("#warningDiv").show();
            $('#changeText').text('₱ ' + parseFloat(0, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
            $('#change').val(0);
        }

 

       
      });

      $('#plusBtn').click(function() {
        var carttotal = $('#carttotal').val();
        $('.amount3').val(function(i, val) { 

             var amount = val*1+1;
             
             var change =  Number(amount) - Number(carttotal);

             $('#changeText').text('₱ ' + parseFloat(change, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
             $('#change').val(change);
            return val*1+1 
         
 
        });
     });

     $('#minusBtn').click(function() {
        var carttotal = $('#carttotal').val();
            $('.amount3').val(function(i, val) {
                var amount = val*1-1;

                var change =  Number(amount) - Number(carttotal);
                $('#changeText').text('₱ ' + parseFloat(change, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
                $('#change').val(change);
                 return val*1-1   
            });
    }); 

     





$(document).on('submit', '#cashier-annual-dues-payment-form', function (e) {
    e.preventDefault();
    $("#loading2").fadeIn();


    var url = $( "#urlCashierAnnualDuesPay" ).val();
    var token4 = $( "#token4" ).val();
    var amount = $('#amount3').val();
    var pps_no = $('#pps_no4').val();
    var or_no = $('#or_no').val();
    var carttotal = $('#carttotal4').val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token4
        }
    });

    var formData = new FormData(this);

    formData.append('or_no',or_no);
    formData.append('amount',amount);
    formData.append('total_amount',carttotal);
    formData.append('pps_no',pps_no);
    
    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: (data) => {
            $("#loading2").fadeOut();
            if(data.type == "exist")
            {
                Swal.fire({
                    title: "Completed!",
                    text: "Payment Successful! please note that this member have remaining annual dues that need to pay.",
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
            }
            else
            {
                Swal.fire({
                    title: "Completed!",
                    text: "Payment Successful! Member has no remaining annual dues.",
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
            }
          
    
        },
        error: function(data) {
            $("#loading2").fadeOut();
            Swal.fire({
                title: "Warning!",
                text: "Something error",
                icon: "error",
                confirmButtonText: "Okay"
            })
        }
    });


});

$(document).on('submit', '#cashier-annual-dues-payment-bank-transfer-form', function (e) {
    e.preventDefault();
    var url = $( "#urlCashierAnnualDuesPayBankTransfer" ).val();
    var token = $( "#token" ).val();
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token
        }
    });


    var formData = new FormData(this);

    formData.append('pps_no',$( "#pps_no" ).val());
    formData.append('bank_name',$( "#bank_name" ).val());
    formData.append('bank_transfer_transaction_number',$( "#bank_transfer_transaction_number" ).val());
    formData.append('bank_transfer_dt',$( "#bank_transfer_dt" ).val());
    formData.append('amount_bank_transfer',$( "#amount_bank_transfer" ).val());
    formData.append('bank_transfer_remarks',$( "#bank_transfer_remarks" ).val());
    

    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: (data) => {
            if(data.type == "exist")
            {
                Swal.fire({
                    title: "Completed!",
                    text: "Payment Successful! please note that this member have remaining annual dues that need to pay.",
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
            }
            else
            {
                Swal.fire({
                    title: "Completed!",
                    text: "Payment Successful! Member has no remaining annual dues.",
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


});



$('#cashier-annual-dues-payment-cheque-form').submit(function(e) {
    e.preventDefault();
    $("#loading3").fadeIn();

    var url = $( "#urlCashierAnnualDuesPayCheque" ).val();
    var token = $( "#token" ).val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token
        }
    });

    var formData = new FormData(this);

    formData.append('pps_no',$( "#pps_no" ).val());
    formData.append('bank_name',$( "#bank_name" ).val());
    formData.append('cheque_number',$( "#cheque_number" ).val());
    formData.append('posting_dt',$( "#posting_dt" ).val());
    formData.append('amount_cheque',$( "#amount_cheque" ).val());
    

    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: (data) => {
            $("#loading3").fadeOut();
            if(data.type == "exist")
            {
                Swal.fire({
                    title: "Completed!",
                    text: "Payment Successful! please note that this member have remaining annual dues that need to pay.",
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
            }
            else
            {
                Swal.fire({
                    title: "Completed!",
                    text: "Payment Successful! Member has no remaining annual dues.",
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
            }
         
        },
        error: function(data) {
            $("#loading3").fadeOut();
            Swal.fire({
                title: "Warning!",
                text: "Something error",
                icon: "error",
                confirmButtonText: "Okay"
            })
        }
    });
  
});

$('.addannualdues').click(function() {

    var url = $( "#urlCashierAddAnnualDues" ).val();
        var token = $( "#token" ).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
        });

        $.ajax({
            type: 'get',
            url: url,
            data : { 'pps_no' : $( "#pps_no" ).val(),
                     'id' : $(this).data("id")
                    
                   },
            success: (data) => {
               if(data == "billed")
               {
                notif.showNotification('top', 'right', 'Warning, this annual dues already billed to the selected member!', 'warning');
               }
               else
               {
                notif.showNotification('top', 'right', 'Success, annual dues successfully billed to the selected member!', 'success');
                $("#chooseannualdues").load(window.location.href + " #chooseannualdues");
               }
        
            },
            error: function(data) {
               
            }
        });

});




$(function(){
    $(window).on('load',function(){
        $('#loading5').hide();

    });
});


