@extends("tiniposreport::master")

@section("vue_icon", $modelIcon)

@section("vue_page_title")
{{ "Laporan " . $modelName }}
@endsection

@if($createAbility)
@section("vue_header_action")

<a href="{{ route('tiniposreport.' . strtolower($modelName) . '.create') }}"
   class="btn btn-success btn-add-new">

    <i class="voyager-plus"></i>
    <span>{{ __('voyager::generic.add_new') }}</span>
</a>

@endsection
@endif

@section("vue_content")
<stock-opname-report model-name="{{ $modelName }}" :read-ability="{{ $readAbility ? 'true' : 'false' }}" />
@endsection