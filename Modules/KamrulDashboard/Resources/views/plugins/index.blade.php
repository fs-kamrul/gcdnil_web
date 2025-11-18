@extends('kamruldashboard::layouts.app_master')

@section('stylesheet')
{{--    <link rel="stylesheet" href="{{ url('vendor/kamruldashboard/vendor/owl-carousel/css/owl.carousel.min.css') }}">--}}

@endsection
@section('javascript')

{{--    <script src="{{ url('vendor/kamruldashboard/vendor/raphael/raphael.min.js') }}"></script>--}}
@endsection

@section('title', __( 'kamruldashboard::all_lang.' . $title ))
@section('content')
<div class="row">
    <div class="col-xl-12 col-xxl-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">@lang('kamruldashboard::lang_v1.manage_plugins')</h4>
            </div>
            <div class="card-body">
                <div class="basic-form custom_file_input">
                    <form action="{{ url('upload-plugin') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">@lang('kamruldashboard::all_lang.upload')</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" name="plugin" required class="custom-file-input">
                                <label class="custom-file-label">@lang('kamruldashboard::lang.choose_file')</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary"> @lang('kamruldashboard::all_lang.upload')</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">@lang('kamruldashboard::lang_v1.plugins')</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-responsive-sm">
                        <thead>
                        <tr class="success">
                            <th class="col-md-1">#</th>
                            <th class="col-md-4">@lang('kamruldashboard::lang_v1.plugins')</th>
                            <th class="col-md-7">@lang('kamruldashboard::lang_v1.description')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($modules as $module)
                            <tr>
                                <th>{{$loop->iteration}}</th>
                                <td>
                                    <strong>{{$module['name']}}</strong> <br/>
                                    <?php //print_r($module['install_link']) ?>
                                    @if(!$module['is_installed'])
                                        <a class="btn btn-success btn-xs"
                                           @if($is_demo)
                                           href="#"
                                           title="@lang('kamruldashboard::lang_v1.disabled_in_demo')"
                                           disabled
                                           @else
                                           href="{{$module['install_link']}}"
                                            @endif
                                        > @lang('kamruldashboard::lang_v1.install')</a>
                                    @else
                                        <a class="btn btn-warning btn-xs"
                                           @if($is_demo)
                                           href="#"
                                           disabled
                                           title="@lang('kamruldashboard::lang_v1.disabled_in_demo')"
                                           @else
                                           href="{{$module['uninstall_link']}}"
                                           @endif
                                           onclick="return confirm('Do you really want to uninstall the plugin? Plugin will be uninstall but the data will not be deleted')"
                                        >@lang('kamruldashboard::lang_v1.uninstall')
                                        </a>
                                    @endif
                                    @if($module['install_link'] == '#')
                                        <a class="btn btn-warning btn-xs"
                                           @if($is_demo)
                                               href="#"
                                           title="@lang('kamruldashboard::lang_v1.disabled_in_demo')"
                                           disabled
                                           @else
                                               href="{{$module['active_link']}}"
                                            @endif
                                        > @lang('kamruldashboard::lang_v1.active')</a>
                                    @endif
                                    @if($module['is_delete'])
                                        <form
                                            action="{{url('plugins', ['module_name' => $module['name']])}}"
                                            style="display: inline;"
                                            method="post"
                                            onsubmit="return confirm('Do you really want to delete the plugin? Plugin code will be deleted but the data will not be deleted')"
                                        >
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-danger btn-xs"
                                                    @if($is_demo)
                                                    disabled="disabled"
                                                    title="@lang('kamruldashboard::lang_v1.disabled_in_demo')"
                                                @endif
                                            >
                                                @lang('kamruldashboard::lang_v1.delete') </button>
                                        </form>
                                    @endif
                                </td>
                                <td>
                                    {{$module['description']}} <br/>
                                    @isset($module['version'])
                                        <small class="label bg-gray">@lang('kamruldashboard::lang_v1.version') {{$module['version']['installed_version']}}</small>
                                    @endisset

                                    @if(!empty($module['version']) && $module['version']['is_update_available'])
                                        <div class="alert alert-warning mt-2">
                                            <i class="icon-refresh"></i> @lang('kamruldashboard::lang_v1.module_new_version', ['module' => $module['name'], 'link' => $module['update_link']])
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
