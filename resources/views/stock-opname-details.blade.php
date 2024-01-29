@extends("tiniposreport::master")

@section("vue_icon", $modelIcon)

@section("vue_page_title")
{{ "Laporan " . ucwords(str_replace("-", " ", $modelName)) }}
@endsection

@section("vue_header_action")
<a class="btn btn-success btn-primary"
   href="?print=true"
   target="_blank">

    <i style="vertical-align: text-bottom"
       data-icon="f"
       class="icon"></i>
    <span>Cetak Laporan</span>
</a>
@endsection

@section("vue_content")
<stock-opname-item-details model-name="{{ $modelName }}" />
@endsection