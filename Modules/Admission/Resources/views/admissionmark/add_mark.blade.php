@extends('kamruldashboard::layouts.app_master')

@section('stylesheet')
    <link href="{{ url('vendor/Modules/KamrulDashboard/vendor/summernote/summernote.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('vendor/Modules/KamrulDashboard/slug/slug.css') }}" type="text/css"/>

    <style>
        .box {
            color: #000;
            border: 1px solid #000;
            padding: 10px;

            /*margin-bottom: 10px;*/
        }

        .box_sub {
            padding: 0.75rem 0 0.75rem 0;
        }

        .box2 {
            color: #000;
            text-align: center;
            /*border: 1px solid #000;*/
            padding: 10px;
            margin-bottom: 10px;
        }
        .validation_error{
            border-color: #ff0000 !important;
        }
    </style>
@endsection
@section('javascript')

    <!-- Summernote -->
    <script src="{{ url('vendor/Modules/KamrulDashboard/vendor/summernote/js/summernote.min.js') }}"></script>
    <!-- Summernote init -->
    <script src="{{ url('vendor/Modules/KamrulDashboard/js/plugins-init/summernote-init.js') }}"></script>

    <script type="text/javascript">
        var csrf_token = "{{ csrf_token() }}";
    </script>
    <script src="{{ url('vendor/Modules/KamrulDashboard/slug/slug.js') }}"></script>
@endsection
@section('title', __( 'admission::lang.' . $title))
@section('content')

    @if(isset($record))
        @php
            $button = 'update';
//            $language = getLanguageUrlPost($record->id , 'admissionmark');
        @endphp
        {{--        <form name="formPage" method="POST" action="{{ $language['url'] }}" novalidate="" enctype="multipart/form-data">--}}
        {{--        <form name="formPage" method="POST" action="" novalidate="" enctype="multipart/form-data">--}}
        <form method="POST" action="{{ route('admissionmark.createadmissionmark.store') }}">
            <input type="hidden" name="model" value="{{ \Modules\Admission\Http\Models\AdmissionMark::class }}">
            @else
                @php
                    $button = 'save';
                @endphp
                {{--        <form method="POST" action="{{ route('admissionmark.createadmissionmark.store') }}"--}}
                {{--              enctype="multipart/form-data">--}}
            @endif
            @csrf
            @php do_action(BASE_ACTION_TOP_FORM_CONTENT_NOTIFICATION, request(), \Modules\Admission\Http\Models\AdmissionMark::class) @endphp

            <div class="row">
                <div class=" col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">@lang('admission::lang.admissionmark_create')</h4>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <div class="row box2">
                                    <div class="col-md-1">
                                        @lang('admission::lang.sl')
                                    </div>
                                    <div class=" col-md-4">
                                        @lang('admission::lang.name')
                                    </div>
                                    <div class=" col-md-1">
                                        @lang('admission::lang.roll')
                                    </div>
                                    <div class=" col-md-6">
                                        @lang('admission::lang.subject_mark')
                                    </div>
                                </div>
                                {{--                                <div class="form-row">--}}
                                <input type="hidden" name="class_id" value="{{ $class_id }}">
                                <input type="hidden" name="year_id" value="{{ $year_id }}">
                                @foreach($record as $key=>$value)
                                    <div class="row box">
                                        <div class="box_sub col-md-1">
                                            {{ $value->id }}
                                        </div>
                                        <div class="box_sub col-md-4">
                                            {{ $value->name }}
                                        </div>
                                        <div class="box_sub col-md-1">
                                            {{ $value->roll }}
                                        </div>
                                        <div class="col-md-6">
                                            @php
                                                $subject = \Modules\Option\Http\Models\OptionClass::find($class_id)->admissionSubjects;
                                                $count_subject = $subject->count();
                                                $row_subject = checkColumCount($count_subject);
    //                                            dd($subject->count());
                                            @endphp
                                            @if($count_subject > 0)
                                                <div class="row">
                                                    @foreach($subject as $key2=>$value2)
                                                        @php
                                                            $admission_mark = \Modules\Admission\Http\Models\AdmissionMark::where('admission_subjects_id',$value2->id)
                                                                                ->where('admissions_id',$value->id)->first();
//                                                            $field_name = "mark[{$value2->id}][{$value->id}]";
                                                            $field_name = "mark.{$value2->id}.{$value->id}";
                                                            $error_class = '';
                                                            $error_class = $errors->has($field_name) ? 'validation_error' : '';
//                                                            dd($errors->all(), old());
//                                                            dd($error_class);
                                                            if($admission_mark){
                                                                $admission_mark_value = $admission_mark->mark;
                                                            }else{
                                                                $admission_mark_value = old("mark.{$value2->id}.{$value->id}", 0);
                                                            }
                                                        @endphp
{{--                                                        @error('name')--}}
{{--                                                            @php--}}
{{--                                                                $error_class = 'validation_error';--}}
{{--                                                                dd($error_class);--}}
{{--                                                            @endphp--}}
{{--                                                        @enderror--}}
                                                        <div class="col-md-{{ $row_subject }}">
                                                            <span>{{ $value2->name }} @lang('admission::lang.mark'):</span>
                                                            <input type="hidden" name="admission_id[{{ $value2->id }}][{{ $value->id }}]" value="@isset($admission_mark){{ $admission_mark->id }}@endisset">
                                                            <input type="number" class="form-control {{ $error_class }}" value="{{ $admission_mark_value }}"
                                                                   name="mark[{{ $value2->id }}][{{ $value->id }}]"
                                                                   placeholder="{{ $value2->name }} @lang('admission::lang.mark')">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                                {{--                                            {!! Form::textField('name', isset($record) ? $record->name : null, 'admission', '12', ['placeholder'=> __('admission::lang.name')]) !!}--}}


                                {{--                                </div>--}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" col-md-3">
                    {!! Form::formActions(__('admission::lang.publish'), '') !!}

                </div>
            </div>
        </form>
        @endsection
