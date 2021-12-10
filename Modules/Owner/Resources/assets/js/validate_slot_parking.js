$(document).ready(function () {
    $.extend($.validator.messages, {
        required: messageRequired,
        number: messageNumberRequired,
    });

    function validateCarType() {
        let conditions = !$("input[name='car_type[kbn_3no]']").is(':checked') &&
            !$("input[name='car_type[kbn_lightcar]']").is(':checked') &&
            !$("input[name='car_type[kbn_standard]']").is(':checked');
        if (conditions) {
            $("#car_type_error").show();
            $("#car_type_error").text(messageSelected);
        }

        return conditions;
    }

    $("#btn-submit").on('click', function (event) {
        event.preventDefault();
        $("#car_type_error").hide();
        $(".form-slot-parking").submit();
    });

    $(".form-slot-parking").validate({
        rules: {
            "parking_form": {
                required: true,
            },
            "car_width": {
                required: true,
                number: true,
            },
            "car_type[kbn_standard]": {
                required: function (element) {
                    return validateCarType();
                },
            },
            "car_type[kbn_3no]": {
                required: function (element) {
                    return validateCarType();
                },
            },
            "car_type[kbn_lightcar]": {
                required: function (element) {
                    return validateCarType();
                },
            },
            "car_length": {
                required: true,
                number: true,
            },
            "car_height": {
                required: true,
                number: true,
            },
            "car_weight": {
                required: true,
                number: true,
            },
            "space_symbol": {
                required: true,
            },
            "space_no_from": {
                required: true,
                number: true,
            },
            "space_no_to": {
                required: true,
                number: true,
            },
        },
        messages: {
            parking_form: messageSelected,
        },
        submitHandler: function (form) {
            if ($(".form-slot-parking").valid()) {
                $('#modalConfirm').modal('show');
                $('#btn-confirm').on('click', function () {
                    form.submit();
                })
            }
        }
    });
});
