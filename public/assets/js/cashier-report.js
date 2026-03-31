$(document).ready(function(){
    $('.transaction_type').select2({       
    }).on('select2:open', function (e) {
    document.querySelector('.select2-search__field').focus();
    });
});