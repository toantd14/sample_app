$(document).ready(function () {
    $.extend($.validator.messages, {
        required: messageRequired
    });

    $("#form-user-edit").validate({
        rules: {
            "name_c[0]": {
                required: true,
            },
            "name_c[1]": {
                required: true,
            },
            "name_c[2]": {
                required: true,
            },
            "name_c": {
                required: true,
            },
            "person_man": {
                required: true,
            },
            "mail_add": {
                required: true,
            },
            "zip_cd": {
                required: true,
                checkZipCode: true
            },
            "prefectures": {
                required: true,
            },
            "municipality_name": {
                required: true,
            },
            "townname_address": {
                required: true,
            },
            "tel_no": {
                required: true,
                minlength: 10,
                maxlength: 12,
                number: true
            },
            "fax_no": {
                minlength: 9,
                maxlength: 12,
                number: true
            },
            "confirm": {
                required: true,
            },
        },
        messages: {
            confirm: {
                required: messageConfirmRequired,
            },
            tel_no: {
                minlength: jQuery.validator.format("電話番号は{0}文字以上にしてください。"),
                maxlength: jQuery.validator.format("電話番号は{0}文字以下にしてください。"),
                number: '電話番号の書式が正しくありません。'
            },
            fax_no: {
                minlength: jQuery.validator.format("電話番号は{0}文字以上にしてください。"),
                maxlength: jQuery.validator.format("電話番号は{0}文字以下にしてください。"),
                number: '電話番号の書式が正しくありません。'
            }
        },
        submitHandler: function (form) {
            if ($("#form-user-edit").valid()) {
                $('#modalConfirm').modal('show');
            }
        }
    });

    $(".btn-cancle").on('click', function () {
        postMessageToNative(messageExit);
    });

    $('#btn-confirm').on('click', function () {
        $('.error').text('');
        $('#modalConfirm').modal('hide');
        $.ajaxSetup({
            headers: {
                'Authorization': authorization,
                'X-CSRF-TOKEN': csrfToken
            }
        });
        $.ajax({
            url: $('#form-user-edit').attr('action'),
            data: $('#form-user-edit').serialize(),
            type: "PUT",
            success: function (response) {
                if (response.error || response.unauthorized) {
                    $('.alert-danger').text(data.error).addClass("d-block").removeClass("d-none");
                    postMessageToNative(response.unauthorized);
                } else {
                    $('#modalSuccess').modal('show');
                    postMessageToNative(messageRegisterSuccess);
                }
            },
            error: function (response) {
                let errors = response.responseJSON.errors;
                $.each(errors, (key, value) => {
                    $('.' + key).text(value);
                    $('input[name=' + key + ']').focus();
                })
            }
        });
    });
})

$("input").on('keyup', function () {
    $('.' + $(this).attr('name')).text('');
});
