$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

window.callAjax = function (url, method, data) {
    return $.ajax({
        url: url,
        type: method,
        data: data,
    });
}

window.callAjaxUpload = function(url, method, data) {
    return $.ajax({
        url: url,
        type: method,
        data: data,
        dataType: 'json',
        processData: false,
        contentType: false,
    });
}
