
$(document).ready(function () {
    $.extend($.validator.messages, {
        required: messageRequired,
        number: messageNumberPrice,
    });
    // validate ajax create or update month, day, period menu
    $("#form-month").validate({
        rules: {
            "month_price": {
                required: true,
                menu_price: true,
                number: true
            },
            "minimum_use": {
                required: true,
            },
        },
        submitHandler: function (form) {
            if ($("#form-month").valid()) {
                $('input[name=month_price]').val(parseInt($('input[name=month_price]').val()));
                let type = "POST"
                let url = urlCreateOrUpdateMonth
                let data = $('#form-month').serialize()
                callAjax(url, type, data)
                    .done(function (response) {
                        $('#menuModalSucess').modal('show')
                        $('.success_title span').text(response.message);
                        $('#form-month p.text-danger').text('');
                        if (response.menuCd) {
                            $('#menu_cd').val(response.menuCd)
                            $('input[name=menu_cd]').val(response.menuCd)
                        }
                    })
                    .fail(function (response) {
                        let errors = response.responseJSON.errors;
                        $.each(errors, (key, value) => {
                            $('.err_' + key).text(value);
                        })
                    })
            }
        }
    });

    $("#form-day").validate({
        rules: {
            "day_price": {
                required: true,
                menu_price: true,
                number: true
            },
        },
        submitHandler: function (form) {
            if ($("#form-day").valid()) {
                $('input[name=day_price]').val(parseInt($('input[name=day_price]').val()));
                let type = "POST"
                let url = urlCreateOrUpdateDay
                let data = $('#form-day').serialize()
                callAjax(url, type, data)
                    .done(function (response) {
                        $('#menuModalSucess').modal('show')
                        $('.success_title span').text(response.message);
                        $('#form-day p.text-danger').text('');
                        if (response.menuCd) {
                            $('#menu_cd').val(response.menuCd)
                            $('input[name=menu_cd]').val(response.menuCd)
                        }
                    })
                    .fail(function (response) {
                        let errors = response.responseJSON.errors;
                        $.each(errors, (key, value) => {
                            $('.err_' + key).text(value);
                        })
                    })
            }
        }
    });

    $.validator.addMethod('compare_time', function (value, element, param) {
        if (value === '' && $(param).val() === '') {
            return true;
        }

        return (value > $(param).val());
    }, 'Invalid value');

    $.validator.addMethod('required_period_week_data', function (value, element, param) {
        if ($(param).length) {
            for (var i = 0; i <= 7; i++) {
                if ($('#period_week_data' + i + ':checked').length) {
                    return true;
                }
            }
        } else {
            return true;
        }
        return false;
    }, messageSelectRequired);

    $("#form-period").validate({
        ignore: ".period_week_data_validate",
        ignore: ".period_week_or_time",
        rules: {
            "period_price": {
                required: true,
                menu_price: true,
                number: true
            },
            "period_week_data_validate": {
                required_period_week_data: "input[name=period_week]:checked",
            },
            "period_fromtime": {
                required: function (element) {
                    if ($('input[name="period_week"]').is(":checked") || $('input[name="period_dayflg"]').is(":checked")) {
                        return true;
                    } else {
                        return false;
                    }
                },
            },
            "period_totime": {
                compare_time: 'input[name=period_fromtime]'
            },
            "period_fromday": {
                required: "input[name=period_dayflg]:checked",
            },
            "period_today": {
                required: "input[name=period_dayflg]:checked",
                compare_time: 'input[name=period_fromday]'
            },
            "period_week_or_time": {
                required: function (element) {
                    var flg = true;
                    if ($('input[name="period_week"]').is(":checked") || $('input[name="period_dayflg"]').is(":checked")) {
                        flg = false;
                    }
                    return flg;
                },
            }
        },
        "messages": {
            "period_totime": {
                compare_time: validatePeriodTime
            },
            "period_today": {
                compare_time: validatePeriodDay
            },
            "period_week_or_time": {
                required: validatePeriodWeekOrTime
            }
        },
        submitHandler: function (form) {
            if ($("#form-period").valid()) {
                $('input[name=period_price]').val(parseInt($('input[name=period_price]').val()));
                let type = "POST"
                let url = urlCreateOrUpdatePeriod
                let data = $('#form-period').serialize()
                callAjax(url, type, data)
                    .done(function (response) {
                        $('#menuModalSucess').modal('show')
                        $('.success_title span').text(response.message);
                        $('#form-period p.text-danger').text('');
                        if (response.menuCd) {
                            $('#menu_cd').val(response.menuCd)
                            $('input[name=menu_cd]').val(response.menuCd)
                        }
                    })
                    .fail(function (response) {
                        let errors = response.responseJSON.errors;
                        $.each(errors, (key, value) => {
                            $('.err_' + key).text(value);
                        })
                    })
            }
        }
    });

    $(document).on('click', '.submit-lending', function () {
        removeMessage('p.text-danger')
        removeMessage('.alert-success')
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: urlCreateOrUpdateMenuTime,
            data: $('#form-data-menu-time').serialize(),
            success: function (response) {
                reloadTable(response.menuTime)
                $('#menuModalSucess').modal('show')
                $('.success_title span').text(response.messageCreateTime);
            },
            error: handleAjaxErrorShowModal
        })
    })
});

$.validator.addMethod('menu_price', function (value, element, param) {
    return parseInt(value) > 0;
}, messageNumberPrice);

$.validator.addMethod('compare_menu_time', function (value, element, param) {
    if (value > $(param).val()) {
        return true;
    } else {
        return false;
    }
}, validateMenuTime);

$("#form-add-menu-time").validate({
    rules: {
        "from_time": {
            required: true,
        },
        "to_time": {
            required: true,
            compare_menu_time: 'input[name=from_time]'
        },
        "price": {
            required: true,
            menu_price: true,
            number: true
        }
    },
    "messages": {
        "to_time": {
            compare_menu_time: validateMenuTime
        }
    },
    submitHandler: function (form) {
        if ($("#form-add-menu-time").valid()) {
            let dayType = $('input[name=day_type]:checked').val();
            let contentType = dayTypeContent[dayType];
            let fromTime = $('input[name=from_time]').val();
            let toTime = $('input[name=to_time]').val();
            let price = parseInt($('input[name=price]').val());
            let numberTimeLending = $('input[name=number-time-lending]').val();
            let menuTimeNo = $('input[name=menu_time_no]').val();
            if (menuTimeNo) {
                $('.tr' + menuTimeNo + " .th-day-type").text("").append(
                    "<input hidden name=\"data[" + menuTimeNo + "][day_type]\" value=" + dayType + ">" +
                    "<span>" + contentType + "</span>"
                );
                $('.tr' + menuTimeNo + " .th-from-to-time").text("").append(
                    "<input hidden name=\"data[" + menuTimeNo + "][from_time]\" value=" + fromTime + ">" +
                    "<input hidden name=\"data[" + menuTimeNo + "][to_time]\" value=" + toTime + ">" +
                    "<span>" + fromTime + " ～　" + toTime + "</span>"
                );
                $('.tr' + menuTimeNo + " .td-price").text("").append(
                    "<input hidden name=\"data[" + menuTimeNo + "][price]\" value=" + price + ">" +
                    "<span>" + price + "</span>"
                );
                $('.tr' + menuTimeNo + ' .btn-edit-time').data('from_time', fromTime).data('to_time', toTime).data('price', price).data('day_type', dayType)
                $('#form-add-menu-time').trigger('reset');
                $('.set-menu-time-no').val("")
                showMessage('.success_time', messageSuccess);
            } else {
                showMessage('.success_time', messageSuccess);
                $('#table tbody').append("<tr class=tr" + numberTimeLending + ">\n" +
                    "    <th class=no" + numberTimeLending + ">" + numberTimeLending + "</th>" +
                    "    <input hidden name=\"day_type[]\" value=\"{{ $time->day_type }}\">" +
                    "    <th class=th-day-type>" +
                    "        <input hidden name=\"data[" + numberTimeLending + "][day_type]\" value=" + dayType + ">" +
                    "        <span>" + contentType + "</span>" +
                    "    </th>\n" +
                    "    <th class=th-from-to-time>" +
                    "        <input hidden name=\"data[" + numberTimeLending + "][from_time]\" value=" + fromTime + ">" +
                    "        <input hidden name=\"data[" + numberTimeLending + "][to_time]\" value=" + toTime + ">" +
                    "        <span>" + fromTime + " ～　" + toTime + "</span>" +
                    "    </th>\n" +
                    "    <td class=td-price>" +
                    "        <input hidden name=\"data[" + numberTimeLending + "][price]\" value=" + price + ">" +
                    "        <span>" + price + "</span>" +
                    "    </td>\n" +
                    "    <td class=\"border-0 text-left\">\n" +
                    "        <span data-no=" + numberTimeLending + " data-from_time=" + fromTime + " data-to_time=" + toTime + " data-price=" + price + " data-day_type=" + dayType + " class=\"btn btn-primary btn-edit-time\">\n" +
                    "        編集\n" +
                    "        </span>\n" +
                    "        <span data-no=" + numberTimeLending + " class=\"btn btn-danger btn-delete-time\">削除</span>\n" +
                    "    </td>\n" +
                    "</tr>"
                );
                $('.set-menu-time-no').val("");
                $('#form-add-menu-time').trigger('reset');
                $('#form-add-menu-time').validate().resetForm();
                $('input[name=number-time-lending]').val(parseInt(numberTimeLending) + 1);
            }
        }
    }
});

$('.submit-month').on('click', function () {
    removeMessage('#form-month p.text-danger')
    removeError('#form-month p.text-danger')
})
$('.submit-day').on('click', function () {
    removeMessage('#form-day p.text-danger')
    removeError('#form-day p.text-danger')
})
$('.submit-period').on('click', function () {
    removeMessage('#form-period p.text-danger')
    removeError('#form-period p.text-danger')
})
$('.submit-time').on('click', function (event) {
    removeMessage('#form-add-menu-time .success_time')
    removeMessage('#form-add-menu-time p.text-danger')
    removeError('#form-add-menu-time p.text-danger')
})

function showMessage(className, message) {
    $(className).addClass('d-block');
    $(className + ' span').text(message);
}

function removeMessage(className) {
    $(className).removeClass('d-block');
    $(className + ' span').text('');
}

function removeError(className) {
    $(className).text('');
}

function reloadTable(menuTime) {
    $('#table table tbody tr').remove()
    no = 0
    $.each(menuTime, function (key, value) {
        no += 1
        $('#table table tbody').append("<tr class=tr" + no + ">\n" +
            "    <th class=no" + no + ">" + no +
            "        <input hidden name=\"data[" + no + "][id]\" value=" + value.id + ">" +
            "    </th>\n" +

            "    <th class=th-day-type>" +
            "        <input hidden name=\"data[" + no + "][day_type]\" value=" + value.day_type + ">" +
            "        <span>" + dayTypeContent[value.day_type] + "</span>" +
            "    </th>\n" +
            "    <th class=th-from-to-time>" +
            "        <input hidden name=\"data[" + no + "][from_time]\" value=" + value.from_time + ">" +
            "        <input hidden name=\"data[" + no + "][to_time]\" value=" + value.to_time + ">" +
            "        <span>" + value.from_time + " ～　" + value.to_time + "</span>" +
            "    </th>\n" +
            "    <td class=td-price>" +
            "        <input hidden name=\"data[" + no + "][price]\" value=" + value.price + ">" +
            "        <span>" + value.price + "</span>" +
            "    </td>\n" +
            "    <td class=\"border-0 text-left\">\n" +
            "        <span data-no=" + no + " data-from_time=" + value.from_time + " data-to_time=" + value.to_time + " data-price=" + value.price + " data-day_type=" + value.day_type + " class=\"btn btn-primary btn-edit-time\">\n" +
            "        編集\n" +
            "        </span>\n" +
            "        <span data-no=" + no + " data-time-id=" + value.id + " class=\"btn btn-danger btn-delete-time\">削除</span>\n" +
            "    </td>\n" +
            "</tr>"
        );
    });
}

$('input[name=period_week]').on('click', function () {
    if ($(this).prop('checked')) {
        $('#period_week_or_time-error').text('');
    }
});

$('input[name=period_dayflg]').on('click', function () {
    if ($(this).prop('checked')) {
        $('#period_week_or_time-error').text('');
    }
});

$(document).on('click', function (e) {
    var target = e.target;
    if (!$(target).is('.success_time')) {
        $('.success_time').removeClass('d-block');
        $('.success_time span').text('')
    }
});

function handleAjaxErrorShowModal(response) {
    let errors = response.responseJSON.errors;
    if (errors) {
        $('#menuModalError').modal('show')
        $.each(errors, (key, value) => {
            showMessage('.error_message', value)
        })
    }
}
