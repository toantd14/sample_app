<!DOCTYPE html>
<html lang="jp">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/owner.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/reset.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/top.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/header.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/menu.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/bootstrap-datepicker3.standalone.min.css') }}">
    @yield('css')

</head>

<body>
    @include('owner::layouts.header')
    <div class="box-container">
        <div class="container">
            @if (isset(Auth::guard('owner')->user()->owner_cd))
                @include('owner::layouts.navbar')
            @endif
            @yield('content')
        </div>
    </div>
    @include('owner::layouts.footer')
</body>
<script src="{{ mix('/js/owner.js') }}"></script>
<script src="{{ mix('/js/base_ajax.js') }}"></script>
<script src="{{ mix('/js/sucess_modal.js') }}"></script>
<script src="{{ mix('/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ mix('/js/bootstrap-datepicker.ja.min.js') }}"></script>
<script src="{{ mix('/js/common.js') }}"></script>
<script src="{{ mix('/js/jquery.validate.min.js') }}"></script>
<script src="{{ mix('/js/common/common-validate-tel-no.js') }}"></script>
@yield('js')

</html>
