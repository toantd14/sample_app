$(document).ready(function () {
    let linkPrev = $('#paginate-use-stituation .page-item:first-child a').attr('href');
    let linkNext = $('#paginate-use-stituation .page-item:last-child a').attr('href');

    $('#prev-page').attr('href', linkPrev);
    $('#next-page').attr('href', linkNext);

    $.validator.addMethod('required_search_use_situation', function (value, element, param) {
        for (var i = 0; i <= 7; i++) {
            if ($(param[i]).val()) {
                return true;
            }
        }
        $('p.error').text('')

        return false;
    }, mesSearchRequired);

    $("#search-use-situation").validate({
        ignore: ".search-use-situation-validate",
        rules: {
            "search-use-situation-validate": {
                required_search_use_situation: [
                    'input[name=year]',
                    'input[name=month]',
                    'input[name=use_day_from]',
                    'input[name=use_day_to]',
                    'input[name=reservation_day_from]',
                    'input[name=reservation_day_to]',
                    'input[name=payment_day_from]',
                    'input[name=payment_day_to]'
                ]
            },
        },
        submitHandler: function (form) {
            if ($("#search-use-situation").valid()) {
                form.submit();
            }
        }
    });
})
