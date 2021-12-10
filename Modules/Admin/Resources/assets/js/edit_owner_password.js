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
                minlength: 6
            },
            "password_confirmation": {
                required: true,
                equalTo: "#password"
            },
        },
        messages: {
            "password": {
                minlength: jQuery.validator.format("パスワードは{0}文字以上にしてください。"),
            },
            "password_confirmation": {
                equalTo: "新しいパスワードと再入力パスワードが一致しません。",
            },
        },
        submitHandler: function (form) {
            if ($("#form-reset-password").valid()) {
                $('#modalConfirm').modal('show');
            }
        }
    });

    $('#btn-confirm').on('click', function () {
        let data = $("#form-reset-password").serialize();
        let url = $(this).attr('data-url');
        callAjax(url, 'POST', data)
            .done(function (response) {
                $('#successUpdateContent').text(response.message);
                $('#successUpdate').modal('show');
            })
            .fail(function (error) {
                $('#errorUpdateContent').text(error.responseJSON.message);

                $('#errorUpdate').modal('show');
            })
    })
});
