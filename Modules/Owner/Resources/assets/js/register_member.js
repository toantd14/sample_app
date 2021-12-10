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

    $('.role').on('change', function () {
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

    $('#confirm-button').on('click', function () {
        $('.error').text('')
        $('#loader').removeClass('d-none');
        $('#box-form-register').addClass('d-none');
        let url = $('#form-register').attr('action');
        let data = new FormData($("#form-register")[0]);
        let type = "POST"
        callAjaxUpload(url, type, data)
            .done(function (response) {
                if (response.error) {
                    $('.alert-danger').text(data.error).addClass("d-block").removeClass("d-none");
                } else {
                    $('#loader').addClass('d-none');
                    $('#box-form-register').removeClass('d-none');
                    $('.url-certification').attr('href', response.urlCertification)
                    $('#successRegister').modal('show')
                }
            })
            .fail(function (response) {
                $('#loader').addClass('d-none');
                $('#box-form-register').removeClass('d-none');
                if (response.responseJSON.prefectures) {
                    $('.prefectures').text(response.responseJSON.prefectures)
                }
                if (response.responseJSON.Exception) {
                    $('.exception').text(response.responseJSON.Exception)
                }
                let errors = response.responseJSON.errors
                $.each(errors, function (index, value) {
                    $('.' + index).text(value)
                    $('input[name=' + index + ']').focus()
                });
            });
    });

    $(".exit-register-user").on('click', function(){
        postMessageToNative(messageExit);
    });

    $(".exit-register-owner").on('click', function(){
        window.location.replace(urlExit);
    });

    function isEmail(email) {
        let regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    $.extend($.validator.messages, {
        required: messageRequired,
    });

    jQuery.validator.addMethod("isEmail", function (value, element) {
        return isEmail(value);
    }, "メールアドレスを正しいメールアドレスにしてください。");

    $("#form-register").validate({
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
                isEmail: true,
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
                number: true,
                isTelNo: true
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

    $("input").on('keyup', function () {
        $('.' + $(this).attr('name')).text('');
    });
});
