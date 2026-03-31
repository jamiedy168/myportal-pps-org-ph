$(document).ready(function() {
    $("input[name$='payment_type']").click(function() {
        var type = $(this).val();


        $("div.desc").hide();
        $(".payment" + type).show();
    });

});