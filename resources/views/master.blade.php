@extends("voyager::master")

@section("page_title")

@yield("vue_page_title")

@endsection

@if (!Request::get('print'))
@hasSection("vue_icon")

@section("page_header")
<h1 class="page-title">
    <i class="@yield('vue_icon')"></i>

    @yield("vue_page_title")

    @yield("vue_header_action")
</h1>
@endsection

@endif
@endif

@section("content")
<div id="vue-app">
    @yield("vue_content")
</div>
@endsection

@section("css")
<link href="/vendor/tiniposreport/css/app.css"
      rel="stylesheet">

<link href="cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css"
      rel="stylesheet">
@endsection

@section("javascript")
<script src="/vendor/tiniposreport/js/app.js"
        type="text/javascript"></script>

<script src="cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.js"
        type="text/javascript"></script>
@endsection