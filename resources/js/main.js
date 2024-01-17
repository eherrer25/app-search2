$('.btn-delete').on('click', function (e) {

    $(this).prop("disabled", true);

    let spin = $(this).find('.s-spin');
    let trash = $(this).find('.bi-trash');
    trash.hide();
    spin.show();

    setTimeout(() => {
        $('#form-delete').submit();
    }, 1000);

});