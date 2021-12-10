$(document).ready(function () {
    $('#modalSuccess').modal('show');
    $.extend($.validator.messages, {
        required: "入力して下さい",
    });

    $('#showConfirm').on('click', function () {
        $('.text-danger').remove();
    })

    $("#form-reset-password").validate({
        rules: {
            "password": {
                required: true,
            },
            "password_confirmation": {
                required: true,
            },
        },
        submitHandler: function (form) {
            if ($("#form-reset-password").valid()) {
                $('#modalConfirm').modal('show');
                $('#btn-confirm').on('click', function () {
                    form.submit();
                })
            }
        }
    });
});
