@extends('kamruldashboard::layouts.app_master')

@section('stylesheet')
@endsection
@section('javascript')
@endsection
@section('title', __( 'simpleslider::lang.' . $title))
@section('content')

    @php
        Assets::addScripts(['fancybox'])
                    ->addStyles(['fancybox']);
    @endphp
@if(isset($record))
    @php
        $button = 'update';
        $language = getLanguageUrlSlider($record->id , 'simple-slider');
    @endphp
    <form name="formPage" method="POST" action="{{ $language['url'] }}" novalidate=""  enctype="multipart/form-data">
        <input type="hidden" name="model" value="{{ \Modules\SimpleSlider\Http\Models\SimpleSlider::class }}">
        <input type="hidden" name="language" value="{{ $language['code'] }}">
@else
    @php
        $button = 'save';
    @endphp
    <form method="POST" action="{{ route('simple-slider.create.store') }}"  enctype="multipart/form-data">
@endif
@csrf
        @php do_action(BASE_ACTION_TOP_FORM_CONTENT_NOTIFICATION, request(), \Modules\SimpleSlider\Http\Models\SimpleSlider::class) @endphp
    <div class="row">
        <div class=" col-md-9">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('simpleslider::lang.simpleslider_create')</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <div class="form-row">
                            {!! Form::textField('name', isset($record) ? $record->name : null, 'simpleslider', '12', ['placeholder'=> __('simpleslider::lang.name')]) !!}

                            {!! Form::textField('key', isset($record) ? $record->key : null, 'simpleslider', '12', ['placeholder'=> __('simpleslider::simple-slider.key')]) !!}

                            <div class="form-group col-md-12 col-xl-12">
                                <label><strong>@lang('simpleslider::lang.description')</strong></label>
                                <textarea id="description" class="form-control" rows="5" name="description">@isset($record){{$record->description}}@else{{ old('description') }}@endisset</textarea>
                                @error('description')
                                {!! getValidationMessage()!!}
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            @isset($content)
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('simpleslider::simple-slider.create_new_slide')</h4>
                </div>
                <div class="card-body">
                   {!! $content !!}
                </div>
            </div>
            @endisset
        </div>
        <div class=" col-md-3">
            {!! Form::formActions(__('simpleslider::lang.publish'), '') !!}
            @if(isset($record) ? $language['code_edit'] : 1)

                {!! Form::customSelect2('status', \Modules\KamrulDashboard\Packages\Supports\DboardStatus::labels(), isset($record) ? $record->status : null, ['class' => 'form-control option-type ui-select ui-select', 'id'=>'display_layout']) !!}
            @endif
            @isset($record)
                @php do_action(BASE_ACTION_META_BOXES, 'top', \Modules\SimpleSlider\Http\Models\SimpleSlider::where('id',$record->id)->first()) @endphp
            @endisset
        </div>
    </div>
    </form>
@endsection
