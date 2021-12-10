$(document).ready(function () {
    let checkboxCompany = $('#company');

    if (checkboxCompany.prop('checked')) {
        $('#user-name').addClass('d-none');
        $('#info-company').removeClass('d-none');
    } else {
        $('#user-name').removeClass('d-none');
        $('#info-company').addClass('d-none');
    }

    $('.role').change(function () {
        if (checkboxCompany.prop('checked')) {
            $('#user-name').addClass('d-none');
            $('#info-company').removeClass('d-none');
        } else {
            $('#user-name').removeClass('d-none');
            $('#info-company').addClass('d-none');
        }
    });

    $.extend($.validator.messages, {
        required: messageRequired
    });

    $("#form-user-edit").validate({
        rules: {
            "kubun": {
                required: true,
            },
            "name_c[0]": {
                required: true,
            },
            "name_c[1]": {
                required: true,
            },
            "name_c": {
                required: true,
            },
            "mail_add": {
                required: true,
            },
            "zip_cd": {
                required: true,
            },
            "prefectures": {
                required: true,
            },
            "municipality_name": {
                required: true,
            },
            "corporate_name": {
                required: true,
            },
            "townname_address": {
                required: true,
            },
            "department": {
                required: true,
            },
            "tel_no": {
                required: true,
                number: true,
                isTelNo: true
            },
            "fax_no": {
                minlength: 9,
                maxlength: 12,
                number: true
            },
        },
        messages: {
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
            if ($("#form-user-edit").valid()) {
                $('#modalConfirm').modal('show');
                $('#btn-confirm').on('click', function () {
                    $('.error').text('')
                    $('#modalConfirm').modal('hide')
                    $.ajax({
                        url: $('#form-user-edit').attr('action'),
                        data: $('#form-user-edit').serialize(),
                        type: "PUT",
                        beforeSend: function (xhr, settings) { xhr.setRequestHeader('Authorization', authorization); },
                        success: function (response) {
                            if (response.error || response.unauthorized) {
                                $('.alert-danger').text(data.error).addClass("d-block").removeClass("d-none");
                            } else {
                                $('#modalSuccess').modal('show')
                            }
                        },
                        error: function (response) {
                            let errors = response.responseJSON.errors;
                            $.each(errors, (key, value) => {
                                $('.' + key).text(value);
                            })
                        }
                    });
                })
            }
        }
    });

    $(".btn-ok, .btn-cancel").click('click', function () {
        window.location.href = urlUsersList;
    })
});
