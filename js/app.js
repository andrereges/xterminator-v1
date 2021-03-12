$('.hide').hide();
$('.doctrine').show();

$('#categoria').on('change', function () {
    $('.hide').hide();
    $('.'+$(this).val()).show();
});