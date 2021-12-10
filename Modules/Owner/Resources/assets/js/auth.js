$(document).ready(function () {
    let member = $('input[name=member]').val()
    $('.submit-set-password').on('click', function () {
        $('.alert-danger').addClass("d-none").removeClass("d-block")
        $.ajax({
            method: 'post',
            url: $('.form-set-password').attr('action'),
            data: $('.form-set-password').serialize(),
            success: function (data) {
                if (data.error) {
                    $('.alert-danger').text(data.error).addClass("d-block").removeClass("d-none");
                    $('input[name=certification_cd]').focus()
                } else if (member == memberUser) {
                    postMessageToNative(messageRegisterSuccess)
                    $('#modalSuccess').modal('show')
                    $('.form-set-password')[0].reset()
                } else {
                    window.location.replace(urlExit)
                }
            },
            error: function (data) {
                $('.alert-danger').text(data.responseJSON.errors.password).addClass("d-block").removeClass("d-none");
                $('input[name=password]').focus()
            }
        })
    })

    $(".btn-modal-cancel").click('click', function () {
        if (member == memberUser) {
            postMessageToNative(messageExit)
        } else {
            window.location.replace(urlExit)
        }
    })
})
