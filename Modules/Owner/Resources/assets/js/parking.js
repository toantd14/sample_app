$(document).ready(function () {
    $('.search-gps').on('click', function () {
        $('.errors span').text('');
        $('.errors').css('display', 'none');
        let code = $("input[name=code]").val().trim();
        let prefectures = $("input[name=prefectures]").val().trim();
        let municipality = $("input[name=municipality]").val().trim();
        let area_name = $("input[name=town_area]").val().trim();
        if (code == '' || prefectures == '' || municipality == '' || area_name == '') {
            $('.errors').css('display', 'block');
            $('.errors span').text('所在地の住所を入力して下さい');
        } else {
            window.open("http://apiapiapiworld.net/lonlat/byaddress.html");
        }
    })
})

function disableInputTimepicker() {
    if ($("input[name='sales_division']").is(":checked")) {
        $("input[name='sales_start_time']").prop("disabled", true)
        $("input[name='sales_end_time']").prop("disabled", true)
    } else {
        $("input[name='sales_start_time']").prop("disabled", false)
        $("input[name='sales_end_time']").prop("disabled", false)
    }

    if ($("input[name='lu_division']").is(":checked")) {
        $("input[name='lu_start_time']").prop("disabled", true)
        $("input[name='lu_end_time']").prop("disabled", true)
    } else {
        $("input[name='lu_start_time']").prop("disabled", false)
        $("input[name='lu_end_time']").prop("disabled", false)
    }
}

disableInputTimepicker();
$("input[name='sales_division']").on('click', function () {
    if ($("input[name='sales_division']").is(":checked")) {
        $("input[name='sales_start_time']").prop("disabled", true)
        $("input[name='sales_end_time']").prop("disabled", true)
    } else {
        $("input[name='sales_start_time']").prop("disabled", false)
        $("input[name='sales_end_time']").prop("disabled", false)
    }
})
$("input[name='lu_division']").on('click', function () {
    if ($("input[name='lu_division']").is(":checked")) {
        $("input[name='lu_start_time']").prop("disabled", true)
        $("input[name='lu_end_time']").prop("disabled", true)
    } else {
        $("input[name='lu_start_time']").prop("disabled", false)
        $("input[name='lu_end_time']").prop("disabled", false)
    }
})

$.extend($.validator.messages, {
    required: messageRequired
});

$.validator.addMethod('compare_menu_time', function (value, element, param) {
    if (value >= $(param[1]).val()) {
        return true;
    } else {
        return false;
    }
}, messageRequired);

$.validator.addMethod('validate_latitude', function (value, element, param) {
    let regex = /^(\-?([0-8]?[0-9](\.\d+)?|90(.[0]+)?))$/;
    return regex.test(value);
}, messageValidateLatitude);

$.validator.addMethod('validate_longitude', function (value, element, param) {
    let regex = /^(\-?([1]?[0-7]?[0-9](\.\d+)?|180((.[0]+)?)))$/;
    return regex.test(value);
}, messageValidateLongitude);

$("form.form-register").validate({
    rules: {
        "code": {
            required: true,
            checkZipCode: true
        },
        "name": {
            required: true,
        },
        "prefectures": {
            required: true,
        },
        "municipality": {
            required: true,
        },
        "town_area": {
            required: true,
        },
        "latitude": {
            required: true,
            validate_latitude: true,
        },
        "longitude": {
            required: true,
            validate_longitude: true,
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
        "sales_start_time": {
            required: true,
        },
        "sales_end_time": {
            required: true,
            compare_menu_time: [
                'input[name=sales_start_time]',
                'input[name=sales_end_time]'
            ]
        },
        "lu_start_time": {
            required: true,
        },
        "lu_end_time": {
            required: true,
            compare_menu_time: [
                'input[name=lu_start_time]',
                'input[name=lu_end_time]'
            ]
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
});

$('input[name="lu_division"]').on('click', function () {
    $('#lu_start_time-error').text('');
    $('#lu_end_time-error').text('');
});

$('input[name="sales_division"]').on('click', function () {
    $('#sales_start_time-error').text('');
    $('#sales_end_time-error').text('');
});

$('input[name="lu_end_time"]').on('click', function () {
    $('.ui-timepicker-viewport').on('click', function () {
        var name = $(this).attr('name') + '-error';
        $(name).css('display', 'none')
    });
});
