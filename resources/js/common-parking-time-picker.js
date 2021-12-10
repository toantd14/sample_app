$(document).ready(function () {
    $("body").append(
        $("<div id=time-container>", {}).append(
            $("<ul>", {}).append()
        )
    );
    for (let h = 0; h < 24; h++) {
        if (h <= 9) {
            h = '0' + h;
        }
        for (let m = 0; m <= 55; m++) {
            if (m == 0) {
                m = m + '0';
                time = h + ':' + m;
                addTimeOption(time);
            } else if (m == 5) {
                m = '0' + m;
                time = h + ':' + m;
                addTimeOption(time);
            }
            if (m % 5 == 0 && m != 0 && m != 5) {
                time = h + ':' + m;
                addTimeOption(time);
            }

        }
    };

    $("#time-container ul").append(
        "<li class=menu-time-pick>" +
        "<span class=time-pick>" + '24:00' +
        "</span>" +
        "</li>"
    );

    $('#time-container').hide();
});

function addTimeOption(time) {
    $("#time-container ul").append(
        "<li class=menu-time-pick>" +
        "<span class=time-pick>" + time +
        "</span>" +
        "</li>"
    );
}


$('.timepicker').on('click', function () {
    $('.success_time').removeClass('d-block');
    $('.success_time span').text('')
    var offset = $(this).offset();
    $('#time-container').css({
        'position': 'absolute',
        'width': $(this).width() + parseInt($(this).css('padding-left')) + parseInt($(this).css('padding-right')),
        'top': offset.top + $(this).height() + parseInt($(this).css('padding-top')) + parseInt($(this).css('padding-bottom')),
        'left': offset.left,
    })
    parent = $(this);
    $('#time-container').show();
    $('.time-pick').on('click', function () {
        parent.val($(this).text());
        $('#time-container').hide();
    });
});

$(document).on('click', function (e) {
    var target = e.target;
    if (!$(target).is('#time-container') && !$(target).parents().is('#time-container') && !$(target).is('.timepicker')) {
        $('#time-container').hide()
    }
});

$('.timepicker').on('change', function () {
    let time = setTime($(this).val());
    if (!time) {
        error = '<span id="' + $(this).attr('name') + '-time-error' + '">Error</span>'
        $(this).val('')
    } else {
        $(this).val(time)
    }
});

function setTime(str) {
    var patterns = [
        // 1, 12, 123, 1234, 12345, 123456
        [/^(\d+)$/, '$1'],
        // :1, :2, :3, :4 ... :9
        [/^:(\d)$/, '$10'],
        // :1, :12, :123, :1234 ...
        [/^:(\d+)/, '$1'],
        // 6:06, 5:59, 5:8
        [/^(\d):([7-9])$/, '0$10$2'],
        [/^(\d):(\d\d)$/, '$1$2'],
        [/^(\d):(\d{1,})$/, '0$1$20'],
        // 10:8, 10:10, 10:34
        [/^(\d\d):([7-9])$/, '$10$2'],
        [/^(\d\d):(\d)$/, '$1$20'],
        [/^(\d\d):(\d*)$/, '$1$2'],
        // 123:4, 1234:456
        [/^(\d{3,}):(\d)$/, '$10$2'],
        [/^(\d{3,}):(\d{2,})/, '$1$2'],
        //
        [/^(\d):(\d):(\d)$/, '0$10$20$3'],
        [/^(\d{1,2}):(\d):(\d\d)/, '$10$2$3']
    ],
        length = patterns.length;
    var h = false, m = false;
    if (typeof str === 'undefined' || !str.toLowerCase) { return null; }

    str = str.toLowerCase();
    str = str.replace(/[^0-9:]/g, '').replace(/:+/g, ':');

    for (var k = 0; k < length; k = k + 1) {
        if (patterns[k][0].test(str)) {
            str = str.replace(patterns[k][0], patterns[k][1]);
            break;
        }
    }
    str = str.replace(/:/g, '');

    if (str.length === 1) {
        h = '0' + str;
    } else if (str.length === 2) {
        h = str;
    } else if (str.length === 3 || str.length === 5) {
        h = str.substr(0, 1);
        m = str.substr(1, 2);
    } else if (str.length === 4 || str.length > 5) {
        h = str.substr(0, 2);
        m = str.substr(2, 2);
    }

    if (str.length > 0 && str.length < 5) {
        if (str.length < 3) {
            m = 0 + '0';
        }
    }

    if (h === false || m === false) {
        return false;
    }

    if (h > 24) {
        h = 24;
        m = 0 + '0';
    }
    if (m > 59) {
        m = 59;
    }

    time = h + ':' + m;
    return time;
}
