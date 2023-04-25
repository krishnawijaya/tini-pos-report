@extends("dodiukirreport::master")

@section("vue_icon", $modelIcon)

@section("vue_page_title")
{{ "Laporan " . $modelName }}
@endsection

@section("vue_content")
<report />
@endsection