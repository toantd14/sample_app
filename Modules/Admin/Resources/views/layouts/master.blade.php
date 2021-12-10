<!DOCTYPE html>
<html lang="jp">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/admin/reset.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/admin/top.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/admin/header.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/admin/menu.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/admin/bootstrap-datepicker3.standalone.min.css') }}">
    @yield('css')
</head>

<body>
    @include('admin::layouts.header')
    <div class="box-container">
        <div class="container">
            @if (isset(Auth::guard('admin')->user()->serial_no))
            @include('admin::layouts.navbar')
            @endif
            @yield('content')
        </div>
    </div>
    @include('admin::layouts.footer')
</body>
<script src="{{ mix('/js/admin/app.js') }}"></script>
<script src="{{ mix('/js/admin/base_ajax.js') }}"></script>
<script src="{{ mix('/js/admin/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ mix('/js/admin/bootstrap-datepicker.ja.min.js') }}"></script>
<script src="{{ mix('/js/admin/common.js') }}"></script>
<script src="{{ mix('/js/admin/jquery.validate.min.js') }}"></script>
<script src="{{ mix('/js/common/common-validate-tel-no.js') }}"></script>
<script>
    $(document).ready(function() {
        function isEmail(email) {
            let regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        }

        jQuery.validator.addMethod("isEmail", function(value, element) {
            return isEmail(value);
        }, "メールアドレスを正しいメールアドレスにしてください。");

        @if(!request()->routeIs('owner-banks.create') && !request()->routeIs('owner-password.create') && !request()->routeIs('owners.create'))
            localStorage.clear();
        @endif
    })
</script>
@yield('js')

</html>
