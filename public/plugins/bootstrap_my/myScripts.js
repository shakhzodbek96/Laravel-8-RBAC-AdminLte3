/*
* My functions for admin panel
*/
$(function () {
    $("#dataTable").DataTable();
});

function preloader() {
    $(".loader-in").fadeOut();
    $(".loader").delay(150).fadeOut("fast");
    $(".wrapper").fadeIn("fast");
    $("#app").fadeIn("fast");
}

//Initialize Select2 Elements
$('.select2').select2({
    theme: 'bootstrap4'
});

//Initialize Select2 Elements
$('.select2bs4').select2({
    theme: 'bootstrap4'
});

//select all
$("#checkAll").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);

});

$('.duallistbox').bootstrapDualListbox({
    nonSelectedListLabel: 'Не разрешено',
    selectedListLabel: 'Разрешено',
});

$(".toggle-password").click(function() {

    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
});

function alertMessage(message = '',type = 'default') {

    let messageDiv =
        '<div class="alert alert-default-'+type+' alert-dismissible fade show" role="alert">\n' +
        message+'\n' +
        '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
        '    <span aria-hidden="true">&times;</span>\n' +
        '  </button>\n' +
        '</div>';

    return messageDiv;
}

$('form').submit(function() {
    let button = $(this).find("button[type=submit]:focus");
    button.prop('disabled',true);
    button.html('<i class="spinner-border spinner-border-sm text-light"></i> '+$(button).text() + '...');
});

$('.submitButton').click(function () {

    if(confirm('Confirm action'))
    {
        $(this).prop('disabled',true);
        $(this).html('<i class="spinner-border spinner-border-sm text-light"></i> '+$($(this)).text() + '...');
        $(this).parents('form:first').submit();
    }

});

function SpinnerGo(obj) {
    $(obj).prop('disabled',true);
    $(obj).html('<i class="spinner-border spinner-border-sm text-light"></i> '+$($(obj)).text());
}

function SpinnerStop(obj) {
    $(obj).prop('disabled',false);
    $(obj).html($($(obj)).text());
}


