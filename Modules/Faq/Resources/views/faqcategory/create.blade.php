@extends(DboardHelper::getAdminMasterLayoutTemplate())

@section('stylesheet')

@endsection
@section('javascript')

@endsection
@section('title', __( 'faq::lang.' . $title))
@section('content')

@if(isset($record))
    @php
        $button = 'update';
        $language = getLanguageUrlPost($record->id , 'faqcategory');
    @endphp
    <form name="formPage" method="POST" action="{{ $language['url'] }}" novalidate=""  enctype="multipart/form-data">
        <input type="hidden" name="model" value="{{ \Modules\Faq\Http\Models\FaqCategory::class }}">
        <input type="hidden" name="language" value="{{ $language['code'] }}">
@else
    @php
        $button = 'save';
    @endphp
    <form method="POST" action="{{ route('faqcategory.createfaqcategory.store') }}"  enctype="multipart/form-data">
@endif
@csrf
        @php do_action(BASE_ACTION_TOP_FORM_CONTENT_NOTIFICATION, request(), \Modules\Faq\Http\Models\FaqCategory::class) @endphp

    <div class="row">
        <div class=" col-md-9">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('faq::lang.faqcategory_create')</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <div class="form-row">

                            {!! Form::textField('name', isset($record) ? $record->name : null, 'faq', '12', ['placeholder'=> __('faq::lang.name')]) !!}
                            {!! Form::numberField('order', isset($record) ? $record->order : 0, 'faq', '12', ['placeholder'=>__('Order Id')]) !!}


                            @isset($record) @if($language['code_edit']){!! status_design_html($record->status->getValue(),6, __('faq::lang.status')) !!} @endif @else{!! status_design_html(1,6, __('faq::lang.status')) !!} @endisset

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class=" col-md-3">
            {!! Form::formActions(__('faq::lang.publish'), '') !!}

{{--            @isset($record)--}}
                @php do_action(BASE_ACTION_META_BOXES, 'top', new \Modules\Faq\Http\Models\FaqCategory) @endphp
{{--            @php do_action(BASE_ACTION_META_BOXES, 'top', new \Modules\Menus\Http\Models\Menus) @endphp--}}
{{--            @endisset--}}
        </div>
    </div>
    </form>
@endsection
