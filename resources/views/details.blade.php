@extends("dodiukirreport::master")

@section("vue_icon", $modelIcon)

@section("vue_page_title")
{{ "Nota " . $modelName }}
@endsection

@section("vue_header_action")
<a class="btn btn-success btn-primary"
   href="?print=true"
   onclick="printBill">

    <i class="voyager-print"></i>
    <span>Cetak Nota</span>
</a>
@endsection

@section("vue_content")
<item-details model-name="{{ $modelName }}" />
@endsection