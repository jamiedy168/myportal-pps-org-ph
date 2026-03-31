$(document).ready(function() {
    $('.member_chapter').select2({
        }).on('select2:open', function (e) {
        document.querySelector('.select2-search__field').focus();
    });
    $('.member_type').select2({
        }).on('select2:open', function (e) {
        document.querySelector('.select2-search__field').focus();
    });

    $('#export-specialty-board').submit(function(e) {
        e.preventDefault();
        if($("#member_type").val() == "" && $("#member_chapter").val() == "")
        {
            notif.showNotification('top', 'right', 'Warning, please fill-up member type or chapter!', 'warning');
        }
        alert("test");

    });
});
