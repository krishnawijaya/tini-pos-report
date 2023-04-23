@extends("voyager::master")

@section("content")
<div id="vue-app">
    @yield("vue-content")
</div>
@endsection

@section("javascript")
<script src="/vendor/dodiukirreport/js/app.js"
        type="text/javascript"></script>
@endsection