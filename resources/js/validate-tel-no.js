$(document).ready(function () {
    $('input[name="tel_no"]').keyup(function () {
        let tel = $(this).val();
        let formattedTel = tel.replace('-', '');
        $(this).val(formattedTel);
    });

    jQuery.validator.addMethod("isTelNo", function(value, element) {
        let re = /^09|^08|^05/
        let lengthTel = value.length
        if (re.test(value)) {
            return lengthTel === 11;
        } else {
            return lengthTel === 10;
        }
    }, "電話番号は１０〜１１桁の数字とハイフンを入力してください。");
})
