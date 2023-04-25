@extends("voyager::master")

@section("page_title")

@yield("vue_page_title")

@endsection

@hasSection("vue_icon")

@section("page_header")
<h1 class="page-title">
    <i class="@yield('vue_icon')"></i>

    @yield("vue_page_title")
</h1>
@endsection

@endif

@section("content")
<div id="vue-app">
    @yield("vue_content")
</div>
@endsection

@section("javascript")
<script src="/vendor/dodiukirreport/js/app.js"
        type="text/javascript"></script>
@endsection