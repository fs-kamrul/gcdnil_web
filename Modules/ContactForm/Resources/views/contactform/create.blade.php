@extends('kamruldashboard::layouts.app_master')

@section('stylesheet')


@endsection
@section('javascript')
@endsection
@section('title', __( 'contactform::lang.' . $title))
@section('content')

@if(isset($record))
    @php
        $button = 'update';
        $language = getLanguageUrlPost($record->id , 'contactform');
    @endphp
    <form name="formPage" method="POST" action="{{ $language['url'] }}" novalidate=""  enctype="multipart/form-data">
        <input type="hidden" name="model" value="{{ \Modules\ContactForm\Http\Models\ContactForm::class }}">
        <input type="hidden" name="language" value="{{ $language['code'] }}">
        @else
            @php
                $button = 'save';
            @endphp
    <form method="POST" action="{{ route('contactform.createcontactform.store') }}"  enctype="multipart/form-data">
@endif
@csrf
    <div class="row">
        <div class=" col-md-9">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ page_title()->getTitle() }}</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        {!! Form::information(
                                trans('contactform::contact.contact_information'),
                                isset($record) ? $record : null,
                                [
                                    'style' => 'margin-top: 0',
                                ],
                        ) !!}
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('contactform::contact.replies')</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        {!! Form::replies(
                                trans('contactform::contact.replies'),
                                isset($record) ? $record : null,
                        ) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class=" col-md-3">

            {!! Form::formActions(__('post::lang.publish'), '') !!}
            @if(isset($record) ? $language['code_edit'] : 1)

                {!! Form::customSelect2('status', \Modules\ContactForm\Enums\ContactStatus::labels(), isset($record) ? $record->status : null, ['class' => 'form-control option-type ui-select ui-select', 'id'=>'display_layout']) !!}
            @endif
                {{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    <h4 class="card-title">@lang('post::lang.templates')</h4>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <div class="basic-form">--}}

{{--                        <div class="form-row">--}}
{{--                            --}}{{--                            <div class="form-row">--}}
{{--                            @isset($record) @if($language['code_edit']) {!! select_design_html($record->status,\Modules\ContactForm\Enums\ContactStatus::labels(),'page_templates_id',12, __('post::lang.templates')) !!} @endif @else{!! select_design_html(0,$page_templates,'page_templates_id',12, __('post::lang.templates')) !!} @endisset--}}
{{--                            --}}{{--                            </div>--}}
{{--                            @error('page_templates_id')--}}
{{--                            {!! getValidationMessage()!!}--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>
    </form>
@endsection
