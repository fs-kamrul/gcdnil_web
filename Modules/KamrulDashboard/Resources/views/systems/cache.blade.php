@extends('kamruldashboard::layouts.app_master')

@section('stylesheet')
@endsection
@section('javascript')
    <script type="text/javascript">
        var csrf_token = "{{ csrf_token() }}";
    </script>
    <script src="{{ url('vendor/Modules/KamrulDashboard/js/cache/cache.js') }}"></script>
@endsection
@section('title', __( 'kamruldashboard::lang.' . $title))
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
{{--                    <h4 class="card-title">@lang('kamruldashboard::lang.backup')</h4>--}}
                    <h4 class="card-title"><i class="fas fa-sync"></i> {{ trans('kamruldashboard::lang.cache_commands') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered vertical-middle table-hover">
                <colgroup>
                    <col width="70%">
                    <col width="30%">
                </colgroup>
                <tbody>
                    <tr>
                        <td>
                            {{ trans('kamruldashboard::lang.commands.clear_cms_cache.description') }}
                        </td>
                        <td>
                            <button class="btn btn-danger  btn-clear-cache" data-type="clear_cms_cache" data-url="{{ route('system.cache.clear') }}">
                                {{ trans('kamruldashboard::lang.commands.clear_cms_cache.title') }}
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ trans('kamruldashboard::lang.commands.refresh_compiled_views.description') }}
                        </td>
                        <td>
                            <button class="btn btn-warning btn-clear-cache" data-type="refresh_compiled_views" data-url="{{ route('system.cache.clear') }}">
                                {{ trans('kamruldashboard::lang.commands.refresh_compiled_views.title') }}
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ trans('kamruldashboard::lang.commands.clear_config_cache.description') }}
                        </td>
                        <td>
                            <button class="btn green-meadow btn-clear-cache" data-type="clear_config_cache" data-url="{{ route('system.cache.clear') }}">
                                {{ trans('kamruldashboard::lang.commands.clear_config_cache.title') }}
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ trans('kamruldashboard::lang.commands.clear_route_cache.description') }}
                        </td>
                        <td>
                            <button class="btn green-meadow btn-clear-cache" data-type="clear_route_cache" data-url="{{ route('system.cache.clear') }}">
                                {{ trans('kamruldashboard::lang.commands.clear_route_cache.title') }}
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ trans('kamruldashboard::lang.commands.clear_log.description') }}
                        </td>
                        <td>
                            <button class="btn green-meadow btn-clear-cache" data-type="clear_log" id="test-toastr" data-url="{{ route('system.cache.clear') }}">
                                {{ trans('kamruldashboard::lang.commands.clear_log.title') }}
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
