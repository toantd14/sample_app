$(document).ready(function () {
    $('#modalSuccess').modal('show');
    $.extend($.validator.messages, {
        required: messageRequired
    });

    $("#form-owner-edit").validate({
        rules: {
            "name_c": {
                required: true,
            },
            "person_man": {
                required: true,
            },
            "mail_add": {
                required: true,
                isEmail: true
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
                isTelNo: true,
                number: true
            },
            "fax_no": {
                minlength: 9,
                maxlength: 12,
                number: true
            },
        },
        messages: {
            confirm: {
                required: messageConfirmRequired,
            },
            tel_no: {
                number: '電話番号の書式が正しくありません。'
            },
            fax_no: {
                minlength: jQuery.validator.format("電話番号は{0}文字以上にしてください。"),
                maxlength: jQuery.validator.format("電話番号は{0}文字以下にしてください。"),
                number: '電話番号の書式が正しくありません。'
            }
        },
        submitHandler: function (form) {
            if ($("#form-owner-edit").valid()) {
                $('#modalConfirm').modal('show');
                $('#btn-confirm').on('click', function () {
                    form.submit();
                })
            }
        }
    });
});
