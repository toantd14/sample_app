$(document).ready(function () {
    let linkPrev = $('#slot-paginate .page-item:first-child a').attr('href');
    let linkNext = $('#slot-paginate .page-item:last-child a').attr('href');

    $('#prev-page').attr('href', linkPrev); $('#next-page').attr('href', linkNext);

    $('#modalSuccess').modal('show');
    $('#notifications-confirm').on('click', function () {
        $('#created_at').text($('input[name="created_at"]').val())
        $('#announce_period').text($('input[name="announce_period"]').val())
        $('#notics_title').text($('input[name="notics_title"]').val())
        $('#parking_cd').text($('select[name="parking_cd"] option:selected').text())
        $('#notics_details').text($('textarea[name="notics_details"]').val())
    });

    $('.button-delete').on('click', function () {
        $('#form-delete').attr('action', $(this).attr('link'));
        $('#modalDelete').modal('show');
    });

    $.extend($.validator.messages, {
        required: messageRequired,
    });

    $("#form-notifications").validate({
        rules: {
            "created_at": {
                required: true,
            },
            "announce_period": {
                required: true,
                number: true
            },
            "notics_title": {
                required: true,
            },
            "parking_cd": {
                required: true,
            },
            "notics_details": {
                required: true,
            }
        },
        messages: {
            parking_cd: {
                required: messageSelectRequired
            },
            announce_period: {
                number: messageNumber
            },
        },
        submitHandler: function (form) {
            if ($("#form-notifications").valid()) {
                $('#modalSubmit').modal('show');
                $('#notifications-submit').on('click', function () {
                    form.submit();
                })
            }
        }
    });


    $.validator.addMethod('required_search_notifications', function (value, element, param) {
        if ($(param[0]).val() || $(param[1]).val() || $(param[2]).val() || $(param[3]).val()) {
            return true;
        }
        $('p.error').text('')

        return false;
    }, mesSearchRequired);

    $("#search-notifications").validate({
        ignore: ".search-notifications-validate",
        rules: {
            "search-notifications-validate": {
                required_search_notifications: [
                    'input[name=date_public_from]',
                    'input[name=date_public_to]',
                    'input[name=title]',
                    'select[name=parking_cd]'
                ]
            },
        },
        submitHandler: function (form) {
            if ($("#search-notifications").valid()) {
                form.submit();
            }
        }
    });
})
