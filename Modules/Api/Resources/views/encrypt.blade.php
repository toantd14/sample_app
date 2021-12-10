<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
</body>
<script src="{{ mix('/js/app.js') }}"></script>
<script src="{{ mix('/js/common.js') }}"></script>
<script src="{{ mix('/js/upcTokenPaymentMini.js') }}"></script>
<script type="text/javascript">
    function getMemberToken() {
        var expire = {{ $params['expireMonth'] }} +'' + {{ $params['expireYear'] }};

        Multipayment.init("{{ $params['shopId'] }}");
        Multipayment.getMember(
            {
                cardno: "{{ $params['cardNo'] }}",
                securitycode: "{{ $params['securityCode'] }}",
                expire: expire,
                holderfirstname: "{{ $params['firstName'] }}",
                holderlastname: "{{ $params['lastName'] }}",
                memberid: "{{ $params['memberId'] }}",
                email: "{{ $params['email'] }}",
                phonenumber: "{{ $params['phoneNumber'] }}"
            },
            execMemberPurchase
        );
    }

    getMemberToken();

    function execMemberPurchase(response) {
        var result;
        if (response.resultCode !== "{{ config('payment.api_result_code') }}" && response.resultCode !== {{ config('payment.api_result_code_number') }}) {
            var lang = "{{ config('payment.lang') }}";
            result = {
                resultCode: response.resultCode,
                resultMessage:getResultCodeDetail(response.resultCode, lang)
            }
        } else {
            result = response
        }
        postObjectToNative(result)
    }
</script>
</html>
