@extends("dodiukirreport::master")

@section("vue_icon", $modelIcon)

@section("vue_page_title")
{{ "Tambah " . $modelName }}
@endsection

@section("vue_content")
<create />
@endsection