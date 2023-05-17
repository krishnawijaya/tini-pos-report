@extends("dodiukirreport::master")

@section("vue_icon", $modelIcon)

@section("vue_page_title")
{{ "Laporan " . $modelName }}
@endsection

@section("vue_header_action")
<a href="{{ route('dodiukirreport.' . strtolower($modelName) . '.create') }}"
   class="btn btn-success btn-add-new">

    {{-- @can('add', $post) --}}
    <i class="voyager-plus"></i>
    <span>{{ __('voyager::generic.add_new') }}</span>
    {{-- @endcan --}}
</a>
@endsection

@section("vue_content")
<report model-name="{{ $modelName }}" />
@endsection