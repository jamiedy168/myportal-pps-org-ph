function emptycart()
{
    notif.showNotification('top', 'right', 'Warning, there is no item in the cart, please add item first !', 'warning');
}

function existAnnualDues()
{
    notif.showNotification('top', 'right', 'Warning, selected member has remaining annual dues that need to pay before joining the event!', 'warning');
}


$(document).ready(function(){

    $(document).on('select2:open', () => {
        let searchField = document.querySelector('.select2-search__field');
        if (searchField) {
            searchField.focus();
        }
    });


    let searchUrl = $('#memberSearchUrl').val();

    $('#choosemember').select2({
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
        
    $('.payment_type').select2({     
        dropdownParent: $("#modalChoosePaymentType")
            }).on('select2:open', function (e) {
            document.querySelector('.select2-search__field').focus();
    });   



    


    if ($("#bank_names").length > 0)
    {
        $('#bank_names').select2({     
            tags: true,
            dropdownParent: $("#modalTransactionPayBankTransfer")  
            }).on('select2:open', function (e) {
            document.querySelector('.select2-search__field').focus();
        });
    }

    if ($(".bankcheque").length > 0)
    {
        $('.bankcheque').select2({     
            tags: true,
            dropdownParent: $("#modalTransactionPayCheque")  
            }).on('select2:open', function (e) {
            document.querySelector('.select2-search__field').focus();
        });
    }
    
    
});

$(document).on('click', '.add_annualdues', function () {

    var url = $( "#urlCashierTransactionAddAnnualDues" ).val();
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
                     'pps_no' : $( "#pps_no" ).val(),
                     'id' : $(this).data("id"),
                     'amount' : $(this).data("amount"),
                     'or_master_id' : $(this).data("ormasterid")
                    
                   },
            success: (data) => {
                if(data == "exist")
                {
                    notif.showNotification('top', 'right', 'Warning, annual dues already in the cart !', 'warning');
                }
                else
                {
                    $("#cartListRow").load(" #cartListRow > *");
            
                }
            },
            error: function(data) {
                notif.showNotification('top', 'right', 'Warning, something error !', 'warning');
            }
        });
 });


 

 $(document).on('click', '.add_events', function () {


    var url = $( "#urlCashierTransactionAddEvents" ).val();
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
                 'pps_no' : $( "#pps_no" ).val(),
                 'id' : $(this).data("id"),
                 'amount' : $(this).data("amount"),
                 'topic_id' :$('input[name="topic_id"]:checked').val(),
                
               },
        success: (data) => {

            if(data == "membernotselected")
            {
                notif.showNotification('top', 'right', 'Warning, this event is for selected participants only, this member is not on the list!', 'warning');
            }
            else if(data == "exist")
            {
                notif.showNotification('top', 'right', 'Warning, event already in the cart !', 'warning');
            }
            else if(data == "paid")
            {
                notif.showNotification('top', 'right', 'Warning, member already paid on this event!', 'warning');
            }

            else
            {
                $("#cartListRow").load(" #cartListRow > *");
                $('#modalChooseTopic').modal('hide');
             
        
            }
        },
        error: function(data) {
            notif.showNotification('top', 'right', 'Warning, something error !', 'warning');
        }
    });
 });


 $(document).on('click', '#proceed_payment_btn', function () {

    if($('input[name="topic_id"]:checked').val() == null)
    {
        notif.showNotification('top', 'right', 'Warning, please choose one topic first!', 'warning');
    }
    else
    {
        var url = $( "#urlCountTopicAttendee" ).val();
        var token = $( "#token" ).val();
    
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': token
          }
        });
        
        $.ajax({
          type: 'get',
          url: url,
          data: { 'topic_id' : $('input[name="topic_id"]:checked').val(),
                   'event_id' : $('#event_id').val(),
       },
         
          success: (data) => {

            if(data == "maxlimit")
            {
                notif.showNotification('top', 'right', 'Warning, this topic already reach the maximum participant that allowed to join, please choose another topic!', 'warning');
            }
            else
            {
                $('.add_events').click();
            }
    
          },
          error: function(data) {
             Swal.fire({
                    title: "Warning!",
                    text: "Something went wrong!",
                    icon: "error",
                    confirmButtonText: "Okay"
                })
          }
        });
    }




});

$(document).on('click', '.removeCart', function () {

    var url = $( "#urlCashierTransactionRemoveCart" ).val();
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


 $(document).on('keyup', '.amount3', function () {
    var amount = $('#amount3').val();
    var carttotal = $('#carttotal4').val();
    var change = Number(amount) - Number(carttotal);

  
    var change_text = '? ' + change + '.00';
    $('#change').val(change);
    $('#changeText').text('? ' + parseFloat(change, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());


    if(amount == "" || amount == null || amount == 0)
    {
        $("#warningDiv").show();
        $('#changeText').text('? ' + parseFloat(0, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
        $('#change').val(0);
    }



   
  });


  $(document).on('click', '#plusBtn', function () {
    var carttotal = $('#carttotal4').val();


    $('.amount3').val(function(i, val) { 

         var amount = val*1+1;
         
         var change =  Number(amount) - Number(carttotal);

         $('#changeText').text('? ' + parseFloat(change, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
         $('#change').val(change);
        return val*1+1 
     

    });
 });


 $(document).on('click', '#minusBtn', function () {
    var carttotal = $('#carttotal4').val();
        $('.amount3').val(function(i, val) {
            var amount = val*1-1;

            var change =  Number(amount) - Number(carttotal);
            $('#changeText').text('? ' + parseFloat(change, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
            $('#change').val(change);
             return val*1-1   
        });
}); 

$(document).on('click', '.addannualdues', function () {
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


$(document).on('submit', '#cashier-transaction-payment-form', function (e) {
    e.preventDefault();

    var url = $( "#urlCashierTransactionPay" ).val();
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


    Swal.fire({
        customClass: {
            confirmButton: "btn bg-gradient-success",
            cancelButton: "btn bg-gradient-danger"
        },
        buttonsStyling: !1,
        
        title: "Are you sure",
        text: "You want to proceed?",
        icon: "warning",
        showCancelButton: true,
        showCancelButton: !0,
        confirmButtonText: "Yes, proceed!",
        
    }).then((result) => {
        if (result.isConfirmed) {
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
        
                    if(data.type == "exist")
                    {
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
                    }
                    else
                    {
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

    });
    


});


$(document).on('submit', '#cashier-transaction-payment-cheque-form', function (e) {
    e.preventDefault();

    var url = $( "#urlCashierTransactionPayCheque" ).val();
    var token = $( "#token" ).val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token
        }
    });


    Swal.fire({
        customClass: {
            confirmButton: "btn bg-gradient-success",
            cancelButton: "btn bg-gradient-danger"
        },
        buttonsStyling: !1,
        
        title: "Are you sure",
        text: "You want to proceed?",
        icon: "warning",
        showCancelButton: true,
        showCancelButton: !0,
        confirmButtonText: "Yes, proceed!",
        
    }).then((result) => {

        if (result.isConfirmed) {
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
                   
                    if(data.type == "exist")
                            {
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
                            }
                            else
                            {
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

    });


  
});

$(document).on('submit', '#cashier-transaction-payment-bank-transfer-form', function (e) {
    e.preventDefault();

    var url = $( "#urlCashierTransactionPayBankTransfer" ).val();
    var token = $( "#token" ).val();
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token
        }
    });


    var formData = new FormData(this);

    formData.append('pps_no',$( "#pps_no" ).val());
    formData.append('bank_name',$( "#bank_names" ).val());
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
                            }
                            else
                            {
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



