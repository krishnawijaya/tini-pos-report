@extends("tiniposreport::master")

@section("vue_icon", $modelIcon)

@section("vue_page_title")
{{ "Buat " . ucwords(str_replace("-", " ", $modelName)) }}
@endsection

@section("vue_content")
<stock-opname-create model-name="{{ $modelName }}" role-name="{{ $roleName }}" />
@endsection