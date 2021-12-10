$(document).ready(function () {

    jQuery.validator.addMethod("checkZipCode", function() {
        return checkZipCode;
    }, "住所情報が取得できませんでした");

    $("input.zip_code, input.code").focusout(function () {
        return callZipCodeAPI();
    });

    function callZipCodeAPI() {
        $('.error-code').remove();
        $.ajax({
            type: 'get',
            url: 'https://maps.googleapis.com/maps/api/geocode/json',
            crossDomain: true,
            dataType: 'json',
            data: {
                address: $('input.zip_code').val(),
                language: 'ja',
                region: 'jp',
                sensor: false,
                key: key
            },
            success: function (resp) {
                if (resp.status === "OK") {
                    // APIのレスポンスから住所情報を取得
                    let prefectures;
                    var obj = resp.results[0].address_components;
                    if (obj.length < 5) {
                        checkZipCode = false;

                        return checkZipCode;
                    }
                    $.each(obj, (function (index, value) {
                        if (value.types[0] === "administrative_area_level_1" && value.types[1] === "political") {
                            prefectures = this['long_name']
                        }
                    }));
                    //$('#country').val(obj[4]['long_name']); // 国
                    $("input.municipality_name").val(obj[2]['long_name']);  // 市区町村
                    $("#municipality_name-error").text('');
                    $("input.prefectures").val(prefectures); // 都道府県
                    $("#prefectures-error").text('');
                    $("input.townname_address").val(obj[1]['long_name']); // 番地
                    $("#townname_address-error").text('');
                    $("#zip-error").text('');
                    $("#zip_cd-error").text('');

                    checkZipCode = true;
                } else {
                    checkZipCode = false;

                    return checkZipCode;
                }
            },
            error: function () {
                checkZipCode = false;

                return checkZipCode;
            }
        });

        return checkZipCode;
    }
})
