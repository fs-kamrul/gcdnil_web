@extends('kamruldashboard::layouts.app_master')

@section('stylesheet')
{{--    <link href="{{ url('vendor/kamruldashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">--}}
<link href="{{ url('vendor/kamruldashboard/vendor/summernote/summernote.css') }}" rel="stylesheet">


@endsection
@section('javascript')

    <!-- Summernote -->
    <script src="{{ url('vendor/kamruldashboard/vendor/summernote/js/summernote.min.js') }}"></script>
    <!-- Summernote init -->
    <script src="{{ url('vendor/kamruldashboard/js/plugins-init/summernote-init.js') }}"></script>

    <script>
        $('.check_all').click(function() {
            if ($(this).is(':checked')) {
                $('div input').attr('checked', true);
            } else {
                $('div input').attr('checked', false);
            }
        });
    </script>
@endsection
@section('title', __( 'kamruldashboard::lang.' . $title))
@section('content')

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">@lang('kamruldashboard::lang.role_create')</h4>
        </div>
        <div class="card-body">
            <div class="basic-form">
                @if(isset($record))
                    @php
                        $button = 'update';
                        $language = getLanguageUrlPost($record->id , 'role');
                    @endphp
                    <form name="formPage" method="POST" action="{{ $language['url'] }}" novalidate=""  enctype="multipart/form-data">
                        <input type="hidden" name="model" value="{{ \Modules\Kamruldashboard\Http\Models\Role::class }}">
                        <input type="hidden" name="language" value="{{ $language['code'] }}">
                @else
                    @php
                        $button = 'save';
                    @endphp
                     <form method="POST" action="{{ route('role.createrole.store') }}"  enctype="multipart/form-data">
                @endif
                @csrf

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>@lang('kamruldashboard::lang.name')</label>
                            <input type="text" id="name" name="name" value="@isset($record){{$record->name}}@else{{ old('name') }}@endisset" class="form-control" placeholder="@lang('kamruldashboard::lang.name')">
                            @error('name')
                            {!! getValidationMessage()!!}
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="check_all input-icheck" > {{ __( 'kamruldashboard::lang.select_all' ) }}
                                </label>
                            </div>
                        </div>
                        @php
                            $start_one = '';
                            $start_two = 'kkknai';
                        @endphp
                        @foreach($permission as $key=>$value)
                            @php
                            //echo $key . '-->' . check_odd_even($key);
                            $module_name = explode("_",$value->name);
                            //$start_one = $module_name;
                            if(check_odd_even($key)=='Even'){
                                $start_one = $module_name[0];
                                //echo 'start_one-->' . $start_one;
                            }
                            if(check_odd_even($key)=='Odd'){
                                $start_two = $module_name[0];
                            }
                            if($start_one != $start_two){
                                echo '<div class="form-group col-md-12"><label style="text-transform: uppercase;">' . $module_name[0] . '</label> </div>';
                            }
                            @endphp
                        <div class="form-group col-md-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="permissions[{{$value->id}}]" class="input-icheck" @isset($permissions[$value->id])
                                    checked @endisset > {{ $value->name }}

                                </label>
                            </div>
                        </div>
                        @endforeach
                        @isset($record){!! status_design_html($record->status,12, __('kamruldashboard::lang.status')) !!} @else{!! status_design_html(1,12, __('kamruldashboard::lang.status')) !!} @endisset



                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('kamruldashboard::lang.'.$button) }}</button>
                    </form>
            </div>
        </div>
    </div>
@endsection
