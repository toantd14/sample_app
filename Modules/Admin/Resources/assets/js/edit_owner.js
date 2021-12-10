$(document).ready(function () {
    let checkboxCompany = $('#company');

    if (checkboxCompany.prop('checked')) {
        $('#info-company').removeClass('d-none');
        $('#text-guide').removeClass('d-none');
        $('#user-name').addClass('d-none');
        $('#user-company').removeClass('d-none');
    } else {
        $('#info-company').addClass('d-none');
        $('#text-guide').addClass('d-none');
        $('#user-name').removeClass('d-none');
        $('#user-company').addClass('d-none');
    }

    $('.role').change(function () {
        if (checkboxCompany.prop('checked')) {
            $('#info-company').removeClass('d-none');
            $('#text-guide').removeClass('d-none');
            $('#user-name').addClass('d-none');
            $('#user-company').removeClass('d-none');
        } else {
            $('#info-company').addClass('d-none');
            $('#text-guide').addClass('d-none');
            $('#user-name').removeClass('d-none');
            $('#user-company').addClass('d-none');
        }
        $('input[type=text], input[type=checkbox], button').removeAttr('disabled')
    });

    $('#confirm-button').click(function () {
        $('.error').text('')
        $('#loader').removeClass('d-none');
        $('#box-form-register').addClass('d-none');
        let url = $('#form-register').attr('action');
        let data = new FormData($('#form-register')[0]);
        let type = "POST"
        callAjaxUpload(url, type, data)
            .done(function (response) {
                if (response.error) {
                    $('.alert-danger').text(data.error).addClass("d-block").removeClass("d-none");
                } else {
                    $('#loader').addClass('d-none');
                    $('#box-form-register').removeClass('d-none');
                    $('#successRegisterContent').text(response.message);
                    $('#successRegister').modal('show');
                }
            })
            .fail(function (response) {
                if (response.status === 422) {
                    let errors = Object.entries(response.responseJSON.errors);
                    for (const [key, value] of errors) {
                        $('#' + key).text(value)
                    }
                    $('#loader').addClass('d-none');
                    $('#box-form-register').removeClass('d-none');
                } else {
                    $('#loader').addClass('d-none');
                    $('#box-form-register').removeClass('d-none');
                    $('#successRegisterContent').text(response.responseJSON.message);
                    $('.btn-success').css('background-color', 'red');
                    $('.btn-success').css('border', '1px solid red');
                    $('#successRegister').modal('show');
                }
            })
    })

    $.extend($.validator.messages, {
        required: messageRequired
    });

    $("#form-register").validate({
        rules: {
            "name_c": {
                required: true,
            },
            "person_man": {
                required: true,
            },
            "mail_add": {
                required: true,
                isEmail: true,
            },
            "zip_cd": {
                required: true,
                checkZipCode: true,
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
            }
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
            $('#confirmModal').modal('show');
        }
    });

    $("input[name=mail_add]").focus(function () {
        $('p.error').text('');
    })
});
