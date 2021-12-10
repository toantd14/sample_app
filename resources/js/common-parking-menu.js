$(document).ready(function () {
    $(document).on('click', '.btn-delete-time', function () {
        $('#modalDeleteTime').modal('show');
        $('.input-modal-delete-time').val($(this).data('no'))
        $('.menu-time-id').val($(this).data('time-id'))
        removeMessage('.error_time')
    })

    $(document).on('click', '.confirm-delete-time', function (e) {
        e.preventDefault();
        let no = $('.input-modal-delete-time').val();
        $('.tr' + no).remove();
        $('#modalDeleteTime').modal('hide');
        showMessage('.success_time', messageSuccess);
    })

    $(document).on('click', '.btn-edit-time', function () {
        $('.set-menu-time-no').val($(this).data('no'))
        $('input[name=from_time]').val($(this).data('from_time'));
        $('input[name=to_time]').val($(this).data('to_time'));
        $('input[name=price]').val($(this).data('price'));
        $('input[value=' + $(this).data('day_type') + ']').prop('checked', true);
    })

    // //switch month
    if ($('input[name="month_flg_check"]').is(":checked")) {
        disableReadOnly('.input-check-month')
        enableSubmit('.submit-month')
    } else {
        enableReadOnly('.input-check-month')
        disableSubmit('.submit-month')
    }

    $('.round_month_flg').on('click', function (event) {
        if ($('input[name="month_flg_check"]').is(":checked")) {
            $('input[name="month_flg"]').val(1)
            enableReadOnly('.input-check-month')
            disableSubmit('.submit-month')

        } else {
            $('input[name="month_flg"]').val(0)
            disableReadOnly('.input-check-month')
            enableSubmit('.submit-month')
        }
    })

    // //switch day
    if ($('input[name="day_flg_check"]').is(":checked")) {
        disableReadOnly('.input-check-day')
        enableSubmit('.submit-day')
    } else {
        enableReadOnly('.input-check-day')
        disableSubmit('.submit-day')
    }

    $('.round_day_flg').on('click', function (event) {
        if ($('input[name="day_flg_check"]').is(":checked")) {
            $('input[name="day_flg"]').val(1)
            enableReadOnly('.input-check-day')
            disableSubmit('.submit-day')

        } else {
            $('input[name="day_flg"]').val(0)
            disableReadOnly('.input-check-day')
            enableSubmit('.submit-day')
        }
    })
    //switch period
    if ($('input[name="period_flg_check"]').is(":checked")) {
        enableIfOn('.input-check-period')
        enableSubmit('.submit-period')
    } else {
        disableIfOff('.input-check-period')
        disableSubmit('.submit-period')
    }

    $('.round_period_flg').on('click', function (event) {
        if ($('input[name="period_flg_check"]').is(":checked")) {
            $('input[name="period_flg"]').val(1)
            disableIfOff('.input-check-period')
            disableSubmit('.submit-period')
        } else {
            $('input[name="period_flg"]').val(0)
            enableIfOn('.input-check-period')
            enableSubmit('.submit-period')
        }
    })

    //switch time
    if ($('input[name="time_flg_check"]').is(":checked")) {
        enableSubmit('.submit-time')
        enableIfOn('.input-check-time')
        $('.btn-edit-time').removeClass("disable-time")
        $('.btn-delete-time').removeClass("disable-time")
        enableSubmit('.submit-lending')
    } else {
        disableSubmit('.submit-time')
        disableIfOff('.input-check-time')
        $('.btn-edit-time').addClass("disable-time")
        $('.btn-delete-time').addClass("disable-time")
        disableSubmit('.submit-lending')
    }

    $('.round_time_flg').on('click', function (event) {
        if ($('input[name="time_flg_check"]').is(":checked")) {
            $('input[name="time_flg"]').val(1)
            disableSubmit('.submit-time')
            disableIfOff('.input-check-time')
            disableSubmit('.submit-lending')
            $('.btn-edit-time').addClass("disable-time")
            $('.btn-delete-time').addClass("disable-time")
        } else {
            $('input[name="time_flg"]').val(0)
            enableSubmit('.submit-time')
            enableIfOn('.input-check-time')
            enableSubmit('.submit-lending')
            $('.btn-edit-time').removeClass("disable-time")
            $('.btn-delete-time').removeClass("disable-time")
        }
    })

    let isPeriodWeekChecked = $("input[name=period_week]").prop('checked');
    if (isPeriodWeekChecked) {
        disableDivWhenWeekChecked();
    }

    $("input[name=period_week]").on('change', function () {
        let isChecked = $(this).prop('checked');

        if (isChecked) {
            disableDivWhenWeekChecked();
        } else {
            $('input[name=period_timeflg]').val(0).attr('checked', false);
            $('.period_timeflg').addClass('disable-div');
            $('.checkbox-day-of-week').addClass('disable-div');
            $('.period_dayflg').removeClass('disable-div');
            $('.period_day').addClass('disable-div');
        }
    })

    let isPeriodDayChecked = $("input[name=period_dayflg]").prop('checked');
    if (isPeriodDayChecked) {
        disableDivWhenDayChecked();
    }

    $("input[name=period_dayflg]").on('change', function () {

        let isChecked = $(this).prop('checked');

        if (isChecked) {
            disableDivWhenDayChecked();
        } else {
            $('input[name=period_timeflg]').val(0).attr('checked', false);
            $('.period_day').addClass('disable-div');
            $('.period_timeflg').addClass('disable-div');
            $('.period_week').removeClass('disable-div');
            $('.checkbox-day-of-week').addClass('disable-div');
        }
    })

    function disableDivWhenDayChecked() {
        $('input[name=period_timeflg]').val(0).attr('checked', true).addClass("disable-div");
        $('.period_timeflg').removeClass('disable-div');
        $('.period_time').removeClass('disable-div');
        $('.period_day').removeClass('disable-div');
        $('.period_week').addClass('disable-div');
        $('input[name=period_week]').val(1).attr('checked', false);
    }

    function disableDivWhenWeekChecked() {
        $('input[name=period_timeflg]').val(0).attr('checked', true).addClass("disable-div");
        $('.period_timeflg').removeClass('disable-div');
        $('.checkbox-day-of-week').removeClass('disable-div');
        $('.period_dayflg').addClass('disable-div');
        $('input[name=period_dayflg]').val(1).attr('checked', false);
    }

    $(".period_timeflg").on('click', function () {
        if ($("input[name=period_timeflg]:checked").val()) {
            disableReadOnly('.period_time')
        } else {
            enableReadOnly('.period_time')
        }
    })

})

function disableSubmit(className) {
    $(className).attr("disabled", 'yes');
}

function enableSubmit(className) {
    $(className).removeAttr("disabled");
}

function enableReadOnly(className) {
    $(className + ' input').attr("readonly", 'yes');
}

function disableReadOnly(className) {
    $(className + ' input').removeAttr("readonly");
}

function disableIfOff(className) {
    $(className + ' input').attr("disabled", 'disabled');
}

function enableIfOn(className) {
    $(className + ' input').removeAttr("disabled");
}

$(".round_month_flg").on('click', function () {
    flgName = $('input[name=month_flg]').attr("name");
    flgData = $('input[name=month_flg]').val()
    updateCheckboxFlg(flgName, flgData)
})

$(".round_day_flg").on('click', function () {
    flgName = $('input[name=day_flg]').attr("name");
    flgData = $('input[name=day_flg]').val()
    updateCheckboxFlg(flgName, flgData)
})

$(".round_period_flg").on('click', function () {
    flgName = $('input[name=period_flg]').attr("name");
    flgData = $('input[name=period_flg]').val()
    updateCheckboxFlg(flgName, flgData)
})

$(".round_time_flg").on('click', function () {
    flgName = $('input[name=time_flg]').attr("name");
    flgData = $('input[name=time_flg]').val()
    updateCheckboxFlg(flgName, flgData)
})

function showMessage(className, message) {
    $(className).addClass('d-block');
    $(className + ' span').text(message);
}

function removeMessage(className) {
    $(className).removeClass('d-block');
    $(className + ' span').text('');
}

function showMessageErrors(className, message) {
    $(className).addClass('d-block');
    $(className + ' span').text(message);
}

function removeMessasgeErrors(className) {
    $(className).removeClass('d-block');
    $(className + ' span').text('');
}

function setValue(className, value) {
    $(className).text(value)
}

function removeErrorMessage(className) {
    $(className).addClass('d-none');
    $(className + ' span').text('');
}

function updateCheckboxFlg(flgName, flgData) {
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: urlUpdateFlg,
        data: {
            flg_name: flgName,
            flg_data: flgData,
            menu_cd: $('input[name=menu_cd]').val(),
        },
        success: function (data) {
            //
        },
        error: function (data) {
            //
        }
    })
}
