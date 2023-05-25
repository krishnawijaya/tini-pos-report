@extends("dodiukirreport::master")

@section("vue_icon", $modelIcon)

@section("vue_page_title")
{{ "Buat " . $modelName }}
@endsection

@section("vue_content")
<create model-name="{{ $modelName }}" />
@endsection