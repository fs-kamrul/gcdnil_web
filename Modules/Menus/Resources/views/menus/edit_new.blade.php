@extends(DboardHelper::getAdminMasterLayoutTemplate())

@section('stylesheet')
<style>
    .widget-menu {
         margin-top: -10px !important;
    }
</style>
@endsection
@section('javascript')

@endsection
@section('content')

@if(isset($record))
    @php
        $button = 'update';
        $language = getLanguageUrlPost($record->id , 'menus');
    @endphp
    <form name="formPage" method="POST" action="{{ route('menus.editmenus.update', $record->id) }}" novalidate="" class="form-save-menu"  enctype="multipart/form-data">
        <input type="hidden" name="model" value="{{ \Modules\Menus\Http\Models\Menus::class }}">
        <input type="hidden" name="language" value="{{ $language['code'] }}">

{{--        @php do_action(BASE_ACTION_TOP_FORM_CONTENT_NOTIFICATION, request(), $record) @endphp--}}
@else
    @php
        $button = 'save';
    @endphp
    <form method="POST" action="{{ route('menus.createmenus.store') }}" class="form-save-menu" enctype="multipart/form-data">
@endif
@csrf
    <div class="row">
        <div class=" col-md-9">
{{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    <h4 class="card-title">@lang('menus::lang.'.$title)</h4>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="card-body">--}}
                <div class="basic-form">
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                            <label>@lang('menus::lang.name')</label>
                            <input type="text" id="name" name="name" value="@isset($record){{$record->name}}@else{{ old('name') }}@endisset" class="form-control" placeholder="@lang('menus::lang.name')">
                            @error('name')
                            {!! getValidationMessage()!!}
                            @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            @include('menus::menu-structure')
                        </div>
                    </div>
                </div>
{{--            </div>--}}
        </div>
        <div class=" col-md-3">

            {!! Form::formActions(__('menus::lang.publish'), '') !!}

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('menus::lang.status')</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">

                        <div class="form-row">
                            @isset($record){!! status_design_html($record->status->getValue(),12, __('menus::lang.status')) !!} @else{!! status_design_html(1,12, __('menus::lang.status')) !!} @endisset

                        </div>
                    </div>
                </div>
            </div>
            @isset($record)
                @php do_action(BASE_ACTION_META_BOXES, 'top', $record) @endphp
            @endisset
        </div>
    </div>
    </form>
@endsection
