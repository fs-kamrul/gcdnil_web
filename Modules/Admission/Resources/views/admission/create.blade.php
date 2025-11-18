@extends('kamruldashboard::layouts.app_master')

@section('stylesheet')
{{--    <link href="{{ url('vendor/Modules/KamrulDashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">--}}
<link href="{{ url('vendor/Modules/KamrulDashboard/vendor/summernote/summernote.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ url('vendor/Modules/KamrulDashboard/slug/slug.css') }}" type="text/css"/>


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
        $language = getLanguageUrlPost($record->id , 'admission');
    @endphp
    <form name="formPage" method="POST" action="{{ $language['url'] }}" novalidate=""  enctype="multipart/form-data">
        <input type="hidden" name="model" value="{{ \Modules\Admission\Http\Models\Admission::class }}">
        <input type="hidden" name="language" value="{{ $language['code'] }}">
@else
    @php
        $button = 'save';
    @endphp
    <form method="POST" action="{{ route('admission.createadmission.store') }}"  enctype="multipart/form-data">
@endif
@csrf
        @php do_action(BASE_ACTION_TOP_FORM_CONTENT_NOTIFICATION, request(), \Modules\Admission\Http\Models\Admission::class) @endphp
    <div class="row">
        <div class=" col-md-9">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('admission::lang.admission_create')</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <div class="form-row">
                            {!! Form::textField('name', isset($record) ? $record->name : null, 'admission', '12', ['placeholder'=> __('admission::lang.name')]) !!}
                            {!! Form::textField('student_id', isset($record) ? $record->student_id : null, 'admission', '6', ['placeholder'=> __('admission::lang.student_id')]) !!}
                            {!! Form::textField('phone', isset($record) ? $record->phone : null, 'table', '6', ['placeholder'=> __('table::lang.phone')]) !!}

                            @php
                                if(isset($record)){
                                    $slug = get_slug_table_data(null, \Modules\Admission\Http\Models\Admission::class,$record->id, \Modules\Admission\Http\Models\Admission::class);
                                }
                            @endphp
                            {!! Form::permalink('slug', isset($slug) ? $slug->key : null, isset($slug) ? $slug->reference_id : null, isset($slug) ? $slug->prefix : null) !!}

{{--                            @isset($record) @if($language['code_edit']){!! input_design_html('photo',$record,6,'file', __('admission::lang.photo')) !!} @endif @else{!! input_design_html('photo',null,6,'file', __('admission::lang.photo')) !!} @endisset--}}
                            {!! Form::textField('payment_amount', isset($record) ? $record->payment_amount : null, 'admission', '4', ['placeholder'=> __('admission::lang.payment_amount')]) !!}

                            @isset($record) @if($language['code_edit']){!! blood_group_design_html($record->blood_group,4, __('admission::lang.blood_group')) !!} @endif @else{!! blood_group_design_html(1,4, __('admission::lang.blood_group')) !!} @endisset

                            @isset($record) @if($language['code_edit']){!! status_design_html($record->status,4, __('admission::lang.status')) !!} @endif @else{!! status_design_html(1,4, __('admission::lang.status')) !!} @endisset

{{--                            <div class="col-xl-12 col-xxl-12">--}}
{{--                                <label><strong>@lang('admission::lang.description')</strong></label>--}}
{{--                                <textarea class="summernote" id="description" name="description">@isset($record){{$record->description}}@else{{ old('description') }}@endisset</textarea>--}}
{{--                                @error('description')--}}
{{--                                {!! getValidationMessage()!!}--}}
{{--                                @enderror--}}
{{--                            </div>--}}
                            @if(isset($record))
                                @php
//                                dd($record->set_subjects);
                                @endphp

                                @foreach($subject_list as $group)
                                    <div class="card mb-3 col-md-6">
                                        <div class="card-header">
                                            <h5 class="mb-0">
                                                {{ $group['set_name'] }}
                                                <span class="selection-counter" data-group="group-{{ $group['set_id'] }}">
                                            0/{{ $group['selected_subject_num'] }}
                                        </span>
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="selection-info">
                                                <strong>Required:</strong> Select exactly {{ $group['selected_subject_num'] }}
                                                subject{{ $group['selected_subject_num'] > 1 ? 's' : '' }} from this group
                                            </div>

                                            <div class="error-message" id="error-group-{{ $group['set_id'] }}">
                                                Please select exactly {{ $group['selected_subject_num'] }}
                                                subject{{ $group['selected_subject_num'] > 1 ? 's' : '' }} from {{ $group['set_name'] }}.
                                            </div>

                                            @foreach($group['subjects'] as $subjectId => $subjectName)
                                                @php
                                                    $isSelected = false;
                                                    if($record->set_subjects) {
                                                        // Handle different Laravel object types
                                                        if($record->set_subjects instanceof \Illuminate\Database\Eloquent\Collection) {
                                                            $isSelected = $record->set_subjects->pluck('id')->contains($subjectId) ||
                                                                         $record->set_subjects->pluck('subject_id')->contains($subjectId) ||
                                                                         $record->set_subjects->contains('id', $subjectId) ||
                                                                         $record->set_subjects->contains($subjectId);
                                                        } elseif($record->set_subjects instanceof \Illuminate\Support\Collection) {
                                                            $isSelected = $record->set_subjects->contains($subjectId);
                                                        } elseif(is_array($record->set_subjects)) {
                                                            $isSelected = in_array($subjectId, $record->set_subjects);
                                                        } elseif(method_exists($record->set_subjects, 'pluck')) {
                                                            $isSelected = $record->set_subjects->pluck('id')->contains($subjectId) ||
                                                                         $record->set_subjects->pluck('subject_id')->contains($subjectId);
                                                        } elseif(method_exists($record->set_subjects, 'contains')) {
                                                            $isSelected = $record->set_subjects->contains($subjectId);
                                                        }
                                                    }
                                                @endphp
                                                <div class="form-check {{ $isSelected ? 'checked' : '' }}">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
{{--                                                        value="{{ $subjectKey }}"--}}
                                                        value="{{ $subjectId }}"
                                                        id="subject_{{ $group['set_id'] }}_{{ $subjectId }}"
                                                        name="subjects_{{ $group['set_id'] }}[]"
                                                        data-group="group-{{ $group['set_id'] }}"
                                                        data-max="{{ $group['selected_subject_num'] }}"
                                                        data-subject-id="{{ $subjectId }}"
                                                        data-set-id="{{ $group['set_id'] }}"
                                                        {{ $isSelected ? 'checked' : '' }}
                                                    >
                                                    <label class="form-check-label" for="subject_{{ $group['set_id'] }}_{{ $subjectId }}">
                                                        {{ $subjectName }}
                                                    </label>
                                                </div>
                                            @endforeach

                                            @error('subjects.' . ($group['set_id'] - 1))
                                            <div class="text-danger mt-2">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach

                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class=" col-md-3">
            {!! Form::formActions(__('admission::lang.publish'), '') !!}

            @isset($record)
                @php do_action(BASE_ACTION_META_BOXES, 'top', \Modules\Admission\Http\Models\Admission::where('id',$record->id)->first()) @endphp
            @endisset
        </div>
    </div>
    </form>
@endsection
