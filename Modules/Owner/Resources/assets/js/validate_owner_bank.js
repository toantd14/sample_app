$(document).ready(function () {
    $('#modalSuccess').modal('show');
    $.extend($.validator.messages, {
        required: messageRequired,
    });

    $("#form-owner-bank").validate({
        rules: {
            "bank_name": {
                required: true,
            },
            "branch_name": {
                required: true,
            },
            "account_type": {
                required: true,
            },
            "account_name": {
                required: true,
            },
            "account_kana": {
                required: true,
            },
        },
        submitHandler: function (form) {
            if ($("#form-owner-bank").valid()) {
                $('#modalConfirm').modal('show');
                $('#btn-confirm').on('click', function () {
                    form.submit();
                })
            }
        }
    });
});
