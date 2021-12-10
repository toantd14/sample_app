$(document).ready(function () {
    $.extend($.validator.messages, {
        required: messageRequired,
    });

    $("#form-time").validate({
        rules: {
            "day_type[]": {
                required: true,
            },
            "from_time": {
                required: true,
            },
            "to_time": {
                required: true,
            },
            "price": {
                required: true,
            },
        },
        submitHandler: function (form) {
            if ($("#form-time").valid()) {
                form.submit();
            }
        }
    });
});
