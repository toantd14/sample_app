@extends('owner::layouts.master')
@section('css')
<style>
    body {
        display: none;
    }
</style>
@endsection
@section('js')
<script>
    var message = "{{ $responseMessageToNative['message'] }}";
    postMessageToNative(message);
</script>
@endsection
