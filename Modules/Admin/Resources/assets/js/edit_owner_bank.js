$(document).ready(function () {
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
            "branch_cd": {
                required: true,
                maxlength: 5
            },
            "bank_cd": {
                required: true,
                maxlength: 4
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
        messages: {
            "branch_cd": {
                maxlength: jQuery.validator.format("施設IDは{0}文字以下にしてください"),
            },
            "bank_cd": {
                maxlength: jQuery.validator.format("銀行IDは{0}文字以下にしてください"),
            }
        },
        submitHandler: function (form) {
            if ($("#form-owner-bank").valid()) {
                $('#confirmModal').modal('show');
            }
        }
    });

    $('#confirm-button').on('click', function () {
        let data = $("#form-owner-bank").serialize();
        let url = $(this).attr('data-url');
        callAjax(url, 'POST', data)
            .done(function (response) {
                let now = new Date($.now());
                let month = now.getMonth() + 1;
                if (month < 10) {
                    month = '0' + month;
                }
                let stringDate = now.getUTCFullYear() + '/' + month + '/' + now.getDate();
                if (isUpdateCreatedAtField) {
                    $('#created_at').text(stringDate);
                }
                $('#update_at').text(stringDate);
                $('#successUpdateContent').text(response.message);
                $('#successUpdate').modal('show');
            })
            .fail(function (error) {
                $('#errorUpdateContent').text(error.responseJSON.message);

                $('#errorUpdate').modal('show');
            })
    })
});
