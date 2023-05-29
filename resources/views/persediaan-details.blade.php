@extends("dodiukirreport::master")

@section("vue_icon", $modelIcon)

@section("vue_page_title")
{{ "Nota " . $modelName }}
@endsection

@section("vue_header_action")
<a class="btn btn-success btn-primary"
   href="?print=true"
   target="_blank">

    <i style="vertical-align: text-bottom"
       data-icon="f"
       class="icon"></i>
    <span>Cetak Nota</span>
</a>
@endsection

@section("vue_content")
<persediaan-details model-name="{{ $modelName }}" />
@endsection