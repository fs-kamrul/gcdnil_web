@extends(DboardHelper::getAdminMasterLayoutTemplate())

@section('stylesheet')
{{--    <link href="{{ url('vendor/kamruldashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">--}}
<link href="{{ url('vendor/kamruldashboard/vendor/summernote/summernote.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ url('vendor/kamruldashboard/slug/slug.css') }}" type="text/css"/>


@endsection
@section('javascript')

    <!-- Summernote -->
    <script src="{{ url('vendor/kamruldashboard/vendor/summernote/js/summernote.min.js') }}"></script>
    <!-- Summernote init -->
    <script src="{{ url('vendor/kamruldashboard/js/plugins-init/summernote-init.js') }}"></script>

    <script type="text/javascript">
        var csrf_token = "{{ csrf_token() }}";
    </script>
    <script src="{{ url('vendor/kamruldashboard/slug/slug.js') }}"></script>

@endsection
@section('title', __( 'faq::lang.' . $title))
@section('content')

@if(isset($record))
    @php
        $button = 'update';
        $language = getLanguageUrlPost($record->id , 'faq');
    @endphp
    <form name="formPage" method="POST" action="{{ $language['url'] }}" novalidate=""  enctype="multipart/form-data">
        <input type="hidden" name="model" value="{{ \Modules\Faq\Http\Models\Faq::class }}">
        <input type="hidden" name="language" value="{{ $language['code'] }}">
@else
    @php
        $button = 'save';
    @endphp
    <form method="POST" action="{{ route('faq.createfaq.store') }}"  enctype="multipart/form-data">
@endif
@csrf
        @php do_action(BASE_ACTION_TOP_FORM_CONTENT_NOTIFICATION, request(), \Modules\Faq\Http\Models\Faq::class) @endphp
    <div class="row">
        <div class=" col-md-9">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('faq::lang.faq_create')</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <div class="form-row">

                            <div class="form-group col-md-12 col-xl-12">
                                <label for="category_id" class="control-label">{{ trans('faq::faq.category') }}</label>
                                {!! Form::customSelect('category_id',
                                    ['' => trans('faq::faq.select_category')] + app(\Modules\Faq\Repositories\Interfaces\FaqCategoryInterface::class)->pluck('name', 'id'),
                                    isset($record) ? $record->category_id : null,
                                    ['class' => 'form-control', 'id'=>'category_id'])
                                !!}
                            </div>


                            {!! Form::textField('question', isset($record) ? $record->question : null, 'faq', '12', ['placeholder'=> __('faq::faq.question')]) !!}

                            <div class="col-xl-12 col-xxl-12">
                                <label><strong>@lang('faq::lang.answer')</strong></label>
                                <textarea class="summernote" id="answer" name="answer">@isset($record){{$record->answer}}@else{{ old('answer') }}@endisset</textarea>
                                @error('description')
                                {!! getValidationMessage()!!}
                                @enderror
                            </div>
                            @isset($record) @if($language['code_edit']){!! status_design_html($record->status->getValue(),6, __('faq::lang.status')) !!} @endif @else{!! status_design_html(1,6, __('faq::lang.status')) !!} @endisset

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class=" col-md-3">
            {!! Form::formActions(__('faq::lang.publish'), '') !!}

            @isset($record)
                @php do_action(BASE_ACTION_META_BOXES, 'top', \Modules\Faq\Http\Models\Faq::where('id',$record->id)->first()) @endphp
            @endisset
        </div>
    </div>
    </form>
@endsection
