@extends('kamruldashboard::layouts.app_master')

@section('stylesheet')
{{--    <link href="{{ url('vendor/kamruldashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">--}}
<link href="{{ url('vendor/kamruldashboard/vendor/summernote/summernote.css') }}" rel="stylesheet">

<link href="{{ url('vendor/kamruldashboard/vendor/bootstrap-multiselect/css/bootstrap-multiselect.css') }}" rel="stylesheet">


@endsection
@section('javascript')

    <!-- Summernote -->
    <script src="{{ url('vendor/kamruldashboard/vendor/summernote/js/summernote.min.js') }}"></script>
    <!-- Summernote init -->
    <script src="{{ url('vendor/kamruldashboard/js/plugins-init/summernote-init.js') }}"></script>

    <script src="{{ url('vendor/kamruldashboard/vendor/bootstrap-multiselect/js/bootstrap-multiselect.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#branch').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                maxHeight: 400,
                buttonWidth: '50%',
                dropUp: true
            });
        });
    </script>

@endsection
@section('title', __( 'kamruldashboard::lang.' . $title))
@section('content')

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">@lang( 'kamruldashboard::lang.' . $title)</h4>
        </div>
        <div class="card-body">
            <div class="basic-form">
                @if(isset($record))
                    @php
                        $button = 'update';
                        $language = getLanguageUrlPost($record->id , 'user');
                    @endphp
                    <form name="formPage" method="POST" action="{{ $language['url'] }}" novalidate=""  enctype="multipart/form-data">
                        <input type="hidden" name="model" value="{{ \Modules\Kamruldashboard\Http\Models\User::class }}">
                        <input type="hidden" name="language" value="{{ $language['code'] }}">
                        @else
                            @php
                                $button = 'save';
                            @endphp
                            <form method="POST" action="{{ route('user.createuser.store') }}"  enctype="multipart/form-data">
                @endif
                @csrf

                    <div class="form-row">

                        @isset($record){!! input_design_html('name',$record,6) !!} @else{!! input_design_html('name',null,6) !!} @endisset
                        @error('name')
                        {!! getValidationError($message)!!}
                        @enderror
                        @php echo  '</div>'; @endphp

                        @isset($record){!! input_design_html('username',$record,6) !!} @else{!! input_design_html('username',null,6) !!} @endisset
                        @error('username')
                        {!! getValidationError($message)!!}
                        @enderror
                        @php echo  '</div>'; @endphp

                        <div class="form-group col-md-6">
                            <label>@lang('kamruldashboard::lang.email')</label>
                            <input type="email" id="email" name="email" value="@isset($record){{$record->email}}@else{{ old('email') }}@endisset" class="form-control" placeholder="@lang('kamruldashboard::lang.email')">
                            @error('email')

                            {!! getValidationError($message)!!}
{{--                            {!! getValidationMessage()!!}--}}
{{--                            {{ $errors->email }}--}}
                            @enderror
                        </div>

                        @isset($record){!! select_design_html($record->role_id,$role,'role_id',6, __('kamruldashboard::lang.role')) !!} @else{!! select_design_html(1,$role,'role_id',6, __('kamruldashboard::lang.role')) !!} @endisset
                        @empty($record)
                            <div class="form-group col-md-6">
                                <label>@lang('kamruldashboard::lang.password')</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="@lang('kamruldashboard::lang.password')">
                                @error('password')
                                {!! getValidationError($message)!!}
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>@lang('kamruldashboard::lang.confirmation_password')</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="@lang('kamruldashboard::lang.confirmation_password')">
                            </div>
                        @endisset

                        @isset($record){!! input_design_html('photo',$record,6,'file', __('kamruldashboard::lang.photo')) !!} @else{!! input_design_html('photo',null,6,'file', __('kamruldashboard::lang.photo')) !!} @endisset


                        @isset($record){!! status_design_html($record->status,6, __('kamruldashboard::lang.status')) !!} @else{!! status_design_html(1,6, __('kamruldashboard::lang.status')) !!} @endisset

                            @php
                                $_module = Savefunction::request_module_defined('Branch');
                            @endphp
                            @if($_module)
                                @php
                                    $branch   = \Modules\Branch\Http\Models\Branch::where('status',1)->pluck('name', 'id')->all();
                                @endphp
                                @isset($record){!! array_select_field($record->branch->toarray(),$branch,'branch[]',6, __('branch::lang.branch'),'','multiple') !!} @else{!! array_select_field(0,$branch,'branch[]',6, __('branch::lang.branch'),'','multiple') !!} @endisset
                            @endif


                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('kamruldashboard::lang.'.$button) }}</button>
                    </form>
            </div>
        </div>
    </div>
@endsection
