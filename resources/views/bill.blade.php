@extends("dodiukirreport::master")

@section("vue_icon", $modelIcon)

@section("vue_page_title")
{{ "Nota " . $modelName }}
@endsection

@section("vue_content")
<bill />
@endsection