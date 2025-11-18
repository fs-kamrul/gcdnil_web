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
        <form method="POST" action="{{ route('admissionmigration.createadmissionmigration.store') }}">
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
                                <table border="1" class="table table-striped table-hover vertical-middle dataTable no-footer dtr-inline collapsed">
                                    <tr>
                                        <th>@lang('admission::lang.sl')</th>
                                        <th>@lang('admission::lang.name')</th>
                                        <th>@lang('admission::lang.roll')</th>
                                        <th>@lang('admission::lang.payment_amount')</th>
                                    </tr>
                                    @foreach($record as $key=>$value)
                                        <tr>
{{--                                            <td>{{ $value->id }}</td>--}}
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $value->name }}</td>
                                            <td> {{ $value->roll }}</td>
                                            <td> {{ $value->payment_amount }}</td>
                                        </tr>
                                    @endforeach
                                </table>

                                <input type="hidden" name="class_id" value="{{ $class_id }}">
                                <input type="hidden" name="year_id" value="{{ $year_id }}">
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
