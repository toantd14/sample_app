$(document).ready(function () {
    $('input[name="month_flg"]').val() == 0 ? $('input[name="month_flg"]').attr('checked', 'checked') : "";
    $('input[name="month_flg"]').val() == 0 ? $('input.month_flg').prop('disabled', false) : "";
    $('input[name="period_flg"]').val() == 0 ? $('input[name="period_flg"]').attr('checked', 'checked') : "";
    $('input[name="time_flg"]').val() == 0 ? $('input[name="time_flg"]').attr('checked', 'checked') : "";

    $('.flag').on('click', function () {
        if ($(this).val() != 0) {
            $(this).val(0)
        } else {
            $(this).val(1);
        }
    })

    $('#month_flg').on('click', function () {
        if ($(this).val() == 0) {
            $('input.month_flg').prop('disabled', false)
        } else {
            $('input.month_flg').prop('disabled', true)
        }
    })

    $('#myModalSucess').modal('show');
});
