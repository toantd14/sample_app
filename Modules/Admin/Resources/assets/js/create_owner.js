$(document).ready(function () {
    let checkboxCompany = $('#company');

    function changeRole() {
        if (checkboxCompany.prop('checked')) {
            $('#info-company').removeClass('d-none');
            $('#text-guide').removeClass('d-none');
            $('#user-name').addClass('d-none');
            $('#user-company').removeClass('d-none');
        } else {
            $('#info-company').addClass('d-none');
            $('#text-guide').addClass('d-none');
            $('#user-name').removeClass('d-none');
            $('#user-company').addClass('d-none');
        }
    }

    changeRole();

    $('.role').change(function () {
        changeRole();
        $('input[type=text], input[type=checkbox], button').removeAttr('disabled')
    });

    $('#confirm-button').click(function () {
        $('.error').text('')
        $('#loader').removeClass('d-none');
        $('#box-form-register').addClass('d-none');
        let url = $('#form-register').attr('action');
        let data = new FormData($("#form-register")[0]);
        let type = "POST"
        callAjaxUpload(url, type, data)
            .done(function (response) {
                $('#loader').addClass('d-none');
                $('#box-form-register').removeClass('d-none');
                let newOwnerCD = response.newOwner.owner_cd;
                $('#btnOwnerBank').attr('href', routeCreateOwnerBank.replace('newOwnerCd', newOwnerCD));
                $('#btnCreatePassword').attr('href', routeCreateOwnerPassword.replace('newOwnerCd', newOwnerCD));
                saveLocalStorage(response.newOwner);
                $('#successRegister').modal('show')
            })
            .fail(function (response) {
                $('#loader').addClass('d-none');
                $('#box-form-register').removeClass('d-none');

                let errors = response.responseJSON.errors
                $.each(errors, function (index, value) {
                    $('#error-' + index).text(value);
                });
            })
    })

    function saveLocalStorage(newOwner) {
        localStorage.clear();
        localStorage.setItem('newOwner_newOwnerCD', newOwner.owner_cd);
        localStorage.setItem('newOwner_mgn_flg', newOwner.mgn_flg);
        localStorage.setItem('newOwner_kubun', newOwner.kubun ?? '');
        localStorage.setItem('newOwner_name_c', newOwner.name_c);
        localStorage.setItem('newOwner_person_man', newOwner.person_man);
        localStorage.setItem('newOwner_department', newOwner.department);
        localStorage.setItem('newOwner_hp_url', newOwner.hp_url);
        localStorage.setItem('newOwner_mail_add', newOwner.mail_add);
        localStorage.setItem('newOwner_zip_cd', newOwner.zip_cd);
        localStorage.setItem('newOwner_prefectures', $('input[name="prefectures"]').val());
        localStorage.setItem('newOwner_municipality_name', newOwner.municipality_name);
        localStorage.setItem('newOwner_townname_address', newOwner.townname_address);
        localStorage.setItem('newOwner_building_name', newOwner.building_name);
        localStorage.setItem('newOwner_tel_no', newOwner.tel_no);
        localStorage.setItem('newOwner_fax_no', newOwner.fax_no);
        localStorage.setItem('newOwner_confirm', newOwner.confirm);
    }

    if (localStorage.getItem('newOwner_newOwnerCD') !== null) {
        let newOwnerCD = localStorage.getItem('newOwner_newOwnerCD');
        //fill owner_cd of new owner to route create owner bank, create owner password
        $('#btnOwnerBank').attr('href', routeCreateOwnerBank.replace('newOwnerCd', newOwnerCD));
        $('#btnCreatePassword').attr('href', routeCreateOwnerPassword.replace('newOwnerCd', newOwnerCD));

        if (localStorage.getItem('newOwner_mgn_flg') == 1) {
            $('.mgn_flg1').prop('checked',true);
        } else {
            $('.mgn_flg0').prop('checked',true);
        }
        if (localStorage.getItem('newOwner_kubun') == 1) {
            $('#info-company').removeClass('d-none');
            $('#text-guide').removeClass('d-none');
            $('#user-name').addClass('d-none');
            $('#user-company').removeClass('d-none');

            $('.kubun1').prop('checked',true);
        } else {
            $('.kubun0').prop('checked',true);
        }
        $('input[name="name_c"]').val(localStorage.getItem('newOwner_name_c') === 'null' ? '' : localStorage.getItem('newOwner_name_c'));
        $('input[name="person_man"]').val(localStorage.getItem('newOwner_person_man') === 'null' ? '' : localStorage.getItem('newOwner_person_man'));
        $('input[name="department"]').val(localStorage.getItem('newOwner_department') === 'null' ? '' : localStorage.getItem('newOwner_department'));
        $('input[name="hp_url"]').val(localStorage.getItem('newOwner_hp_url') === 'null' ? '' : localStorage.getItem('newOwner_hp_url'));
        $('input[name="mail_add"]').val(localStorage.getItem('newOwner_mail_add') === 'null' ? '' : localStorage.getItem('newOwner_mail_add'));
        $('input[name="zip_cd"]').val(localStorage.getItem('newOwner_zip_cd') === 'null' ? '' : localStorage.getItem('newOwner_zip_cd'));
        $('input[name="prefectures"]').val(localStorage.getItem('newOwner_prefectures') === 'null' ? '' : localStorage.getItem('newOwner_prefectures'));
        $('input[name="municipality_name"]').val(localStorage.getItem('newOwner_municipality_name') === 'null' ? '' : localStorage.getItem('newOwner_municipality_name'));
        $('input[name="townname_address"]').val(localStorage.getItem('newOwner_townname_address') === 'null' ? '' : localStorage.getItem('newOwner_townname_address'));
        $('input[name="building_name"]').val(localStorage.getItem('newOwner_building_name') === 'null' ? '' : localStorage.getItem('newOwner_building_name'));
        $('input[name="tel_no"]').val(localStorage.getItem('newOwner_tel_no') === 'null' ? '' : localStorage.getItem('newOwner_tel_no'));
        $('input[name="fax_no"]').val(localStorage.getItem('newOwner_fax_no') === 'null' ? '' : localStorage.getItem('newOwner_fax_no'));
        if (localStorage.getItem('newOwner_confirm')) {
            $('input[name="confirm"]').prop('checked',true);
        }
    }

    $('input').on('change', function () {
        $('#error-' + $(this).attr('name')).text('');
    })

    $.extend($.validator.messages, {
        required: messageRequired
    });

    function isEmail(email) {
        let regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    jQuery.validator.addMethod("isEmail", function(value, element) {
        return isEmail(value);
    }, "メールアドレスを正しいメールアドレスにしてください。");

    $("#form-register").validate({
        rules: {
            "name_c": {
                required: true,
            },
            "person_man": {
                required: true,
            },
            "mail_add": {
                required: true,
                isEmail: true,
            },
            "zip_cd": {
                required: true,
                checkZipCode: true,
            },
            "prefectures": {
                required: true,
            },
            "municipality_name": {
                required: true,
            },
            "townname_address": {
                required: true,
            },
            "tel_no": {
                required: true,
                number: true,
                isTelNo: true,
            },
            "confirm": {
                required: true,
            },
        },
        messages: {
            confirm: {
                required: messageConfirmRequired,
            },
            tel_no: {
                number: '電話番号の書式が正しくありません。'
            }
        },
        submitHandler: function (form) {
            $('#confirmModal').modal('show');
        }
    });

    $('#btnOwnerBank').on('click', function (event) {
        event.preventDefault();
        if ($(this).attr('href') === '#') {
            $('#mustHasNewOwner').modal('show');
        }

        location.href = $(this).attr('href')
    });

    $('#btnCreatePassword').on('click', function (event) {
        event.preventDefault();
        if ($(this).attr('href') === '#') {
            $('#mustHasNewOwner').modal('show');
        }

        location.href = $(this).attr('href')
    });
});
