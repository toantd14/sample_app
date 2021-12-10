$(document).ready(function () {
    $('#modalSuccess').modal('show');

    if (sessionStorage.getItem('dataCreateOwnerBank')) {
        let data = sessionStorage.getItem('dataCreateOwnerBank').split("&");
        var obj = {};
        for(var key in data) {
            obj[data[key].split("=")[0]] = decodeURIComponent(data[key].split("=")[1]);
        }
        $('input[name="account_kana"]').val(obj['account_kana'])
        $('input[name="account_name"]').val(obj['account_name'])
        $('input[name="bank_cd"]').val(obj['bank_cd'])
        $('input[name="bank_name"]').val(obj['bank_name'])
        $('input[name="branch_cd"]').val(obj['branch_cd'])
        $('input[name="branch_name"]').val(obj['branch_name'])
        if(obj['account_type'] === 1) {
            $('.account_type1').attr('checked', 'checked');
        } else {
            $('.account_type0').attr('checked', 'checked');
        }
    }

    $('#confirm-button').click(function () {
        $('.error').text('')
        $('#loader').removeClass('d-none');
        $('#box-form-register').addClass('d-none');
        let dataOwnerBankSession = sessionStorage.getItem("dataCreateOwnerBank");
        let dataOwnerSession = sessionStorage.getItem("dataCreateOwner");
        let dataOwnerPasswordSession = sessionStorage.getItem("dataCreateOwnerPassword");
        let url = $('#form-owner-bank').attr('action');
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

    $("#form-owner-bank").validate({
        rules: {
            "bank_name": {
                required: true,
            },
            "branch_name": {
                required: true,
            },
            "account_type": {
                required: true,
            },
            "account_name": {
                required: true,
            },
            "branch_cd": {
                required: true,
            },
            "bank_cd": {
                required: true,
            },
            "account_kana": {
                required: true,
            },
        },
        submitHandler: function (form) {
            if ($("#form-owner-bank").valid()) {
                let dataOwnerSession = sessionStorage.getItem("dataCreateOwner");
                let dataOwnerPassSession = sessionStorage.getItem("dataCreateOwnerPassword");
                let dataCreateOwnerBank = $("#form-owner-bank").serialize();

                sessionStorage.setItem("dataCreateOwnerBank", dataCreateOwnerBank);
                if (dataOwnerSession && dataOwnerPassSession) {
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
        if ($('#form-owner-bank').valid()){
            let dataCreateOwnerBank = $("#form-owner-bank").serialize();
            sessionStorage.setItem("dataCreateOwnerBank", dataCreateOwnerBank);
            window.location.href = url;
        }
    }

    function removeSessionStorage(){
        sessionStorage.removeItem("dataCreateOwnerPassword");
        sessionStorage.removeItem("dataCreateOwner");
        sessionStorage.removeItem("dataCreateOwnerBank");
    }
});
