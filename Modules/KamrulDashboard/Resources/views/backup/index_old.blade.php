@extends('kamruldashboard::layouts.app_master')

@section('stylesheet')

@endsection
@section('javascript')


@endsection
@section('title', __( 'kamruldashboard::lang.' . $title))
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('kamruldashboard::lang.backup')</h4>
{{--                    <a href="{{ url('kamruldashboard/role/create') }}" type="button" class="btn btn-dark"><i class="icon-plus"></i> @lang('kamruldashboard::lang.role_create')</a>--}}
                    <a id="create-new-backup-button" href="{{ url('kamruldashboard/backup/create') }}" class="btn btn-primary pull-right"
                       style="margin-bottom:2em;"><i class="icon-plus"></i> @lang('kamruldashboard::lang.create_new_backup')
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-responsive-sm">
                            @if (count($backups))
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>@lang('kamruldashboard::lang.file')</th>
                                        <th>@lang('kamruldashboard::lang.size')</th>
                                        <th>@lang('kamruldashboard::lang.date')</th>
                                        <th>@lang('kamruldashboard::lang.age')</th>
                                        <th>@lang('kamruldashboard::lang.actions')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($backups as $backup)
                                        <tr>
                                            <td>{{ $backup['file_name'] }}</td>
                                            <td>{{ humanFilesize($backup['file_size']) }}</td>
                                            <td>
                                                {{ Carbon\Carbon::createFromTimestamp($backup['last_modified'])->toDateTimeString() }}
                                            </td>
                                            <td>
                                                {{ Carbon\Carbon::createFromTimestamp($backup['last_modified'])->diffForHumans(Carbon\Carbon::now()) }}
                                            </td>
                                            <td>
                                                <a class="btn btn-xs btn-success"
                                                   href="{{url('kamruldashboard/backup/download', [$backup['file_name']])}}"><i
                                                        class="fa fa-cloud-download"></i> @lang('kamruldashboard::lang.download')</a>
                                                <a class="btn btn-xs btn-danger link_confirmation" data-button-type="delete"
                                                   href="{{url('kamruldashboard/backup/delete', [$backup['file_name']])}}"><i class="fa fa-trash-o"></i>
                                                    @lang('kamruldashboard::lang.delete')</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="well">
                                    <h4>@lang('kamruldashboard::lang.there_are_no_backups')</h4>
                                </div>
                            @endif
                            <br>
                            <strong>@lang('kamruldashboard::lang.auto_backup_instruction'):</strong><br>
                            <code>{{$cron_job_command}}</code> <br>
                            <strong>@lang('kamruldashboard::lang.backup_clean_command_instruction'):</strong><br>
                            <code>{{$backup_clean_cron_job_command}}</code>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
