$(document).ready(function () {
    $('#modalSuccess').modal('show');

    if (sessionStorage.getItem('dataCreateOwnerPassword')) {
        let data = sessionStorage.getItem('dataCreateOwnerPassword').split("&");
        var obj = {};
        for(var key in data) {
            obj[data[key].split("=")[0]] = decodeURIComponent(data[key].split("=")[1]);
        }
        $('input[name="password"]').val(obj['password'])
        $('input[name="password_confirmation"]').val(obj['password_confirmation'])
    }

    $('#confirm-button').click(function () {
        $('.error').text('')
        $('#loader').removeClass('d-none');
        $('#box-form-register').addClass('d-none');
        let dataOwnerBankSession = sessionStorage.getItem("dataCreateOwnerBank");
        let dataOwnerSession = sessionStorage.getItem("dataCreateOwner");
        let dataOwnerPasswordSession = sessionStorage.getItem("dataCreateOwnerPassword");
        let url = $('#form-register').attr('action');
        let data = dataOwnerBankSession + '&' + dataOwnerSession + '&' + dataOwnerPasswordSession;
        let type = "POST"
        callAjax(url, type, data)
            .done(function (response) {
                if (response.error) {
                    $('.alert-danger').text(data.error).addClass("d-block").removeClass("d-none");
                } else {
                    $('#loader').addClass('d-none');
                    $('#box-form-register').removeClass('d-none');
                    $('.url-certification').attr('href', response.urlCertification)
                    $('#successRegister').modal('show')
                }
            })
            .fail(function (response) {
                $('#loader').addClass('d-none');
                $('#box-form-register').removeClass('d-none');
                if (response.responseJSON.prefectures) {
                    $('.prefectures').text(response.responseJSON.prefectures)
                }
                if (response.responseJSON.Exception) {
                    $('.exception').text(response.responseJSON.Exception)
                }
                let errors = response.responseJSON.errors
                $.each(errors, function (index, value) {
                    $('.' + index).text(value)
                });
            })
    })

    $.extend($.validator.messages, {
        required: messageRequired,
    });

    $("#form-register").validate({
        rules: {
            "password": {
                required: true,
            },
            "password_confirmation": {
                required: true,
            },
        },
        submitHandler: function (form) {
            if ($("#form-register").valid()) {

                let dataOwnerSession = sessionStorage.getItem("dataCreateOwner");
                let dataOwnerBankSession = sessionStorage.getItem("dataCreateOwnerBank");
                let dataCreateOwnerPassword = $("#form-register").serialize();

                sessionStorage.setItem("dataCreateOwnerPassword", dataCreateOwnerPassword);
                if (dataOwnerSession && dataOwnerBankSession) {
                    $('#confirmModal').modal('show');
                    $('#btn-confirm').on('click', function () {
                        form.submit();
                    })
                } else {
                    $('#requireFormModal').modal('show');
                }
            }
        }
    });

    $("#btnCreateOwner").click(function (e){
        e.preventDefault();
        let url = $('#btnCreateOwner').attr('href');
        setSessionStorage(url);
    })

    $("#btnCreatePassword").click(function (e){
        e.preventDefault();
        let url = $('#btnCreatePassword').attr('href');
        setSessionStorage(url);
    })

    $("#btn-cancel, .btn-success").click(function (e){
        e.preventDefault();
        let url = $('#btn-cancel').attr('href');
        removeSessionStorage();
        window.location.href = url;
    })

    function setSessionStorage(url){
        if ($('#form-register').valid()){
            let dataCreateOwnerPassword = $("#form-register").serialize();
            sessionStorage.setItem("dataCreateOwnerPassword", dataCreateOwnerPassword);
            window.location.href = url;
        }
    }

    function removeSessionStorage(){
        sessionStorage.removeItem("dataCreateOwnerPassword");
        sessionStorage.removeItem("dataCreateOwner");
        sessionStorage.removeItem("dataCreateOwnerBank");
    }
});
