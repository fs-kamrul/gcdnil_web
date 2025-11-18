@extends('kamruldashboard::layouts.app_master')

@section('stylesheet')

    <link rel="stylesheet" href="{{ url('vendor/kamruldashboard/vendor/toastr/css/toastr.min.css') }}">
@endsection
@section('javascript')
<script type="text/javascript">
        var csrf_token = "{{ csrf_token() }}";
    </script>
    <script src="{{ url('vendor/kamruldashboard/vendor/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ url('vendor/kamruldashboard/js/toastr_script.js') }}"></script>

    <script src="{{ url('vendor/kamruldashboard/js/backup.js') }}"></script>

@endsection
@section('title', __( 'kamruldashboard::lang.' . $title))
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('kamruldashboard::lang.backup')</h4>
                    @if (auth()->user()->can('backup_create'))
{{--                    <a id="create-new-backup-button" href="{{ url('kamruldashboard/backup/create') }}" class="btn btn-primary pull-right"--}}
{{--                       style="margin-bottom:2em;"><i class="icon-plus"></i> @lang('kamruldashboard::lang.create_new_backup')--}}
{{--                    </a>--}}
                    <button class="btn btn-primary pull-right" id="generate_backup">{{ trans('kamruldashboard::lang.generate_backup') }}</button>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="table-backups">
                                <thead>
                                <tr>
                                    <th>{{ trans('kamruldashboard::lang.name') }}</th>
                                    <th>{{ trans('kamruldashboard::lang.description') }}</th>
                                    <th>{{ trans('kamruldashboard::lang.size') }}</th>
                                    <th>{{ trans('kamruldashboard::lang.created_at') }}</th>
                                    <th>{{ trans('kamruldashboard::lang.operations') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if (count($backups) > 0)
                                    @foreach($backups as $key => $backup)
                                        @include('kamruldashboard::backup.partials.backup-item', ['data' => $backup, 'backupManager' => $backupManager, 'key' => $key, 'odd' => $loop->index % 2 == 0])
                                    @endforeach
                                @else
                                    <tr class="text-center no-backup-row">
                                        <td colspan="5">{{ trans('kamruldashboard::lang.no_backups') }}</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
{{--                            <br>--}}
{{--                            <strong>@lang('kamruldashboard::lang.auto_backup_instruction'):</strong><br>--}}
{{--                            <code>{{$cron_job_command}}</code> <br>--}}
{{--                            <strong>@lang('kamruldashboard::lang.backup_clean_command_instruction'):</strong><br>--}}
{{--                            <code>{{$backup_clean_cron_job_command}}</code>--}}

                            @if (auth()->user()->can('backup_create'))
                                {!! Form::modalAction('create-backup-modal', trans('kamruldashboard::lang.create_a_backup'), 'info', view('kamruldashboard::backup.partials.create')->render(), 'create-backup-button', trans('kamruldashboard::lang.create_btn')) !!}
                                <div data-route-create="{{ route('kamruldashboard.backups.create') }}"></div>
                            @endif

                            @if (auth()->user()->can('backup_restore'))
                                {!! Form::modalAction('restore-backup-modal', trans('kamruldashboard::lang.restore'), 'info', trans('kamruldashboard::lang.restore_confirm_msg'), 'restore-backup-button', trans('kamruldashboard::lang.restore_btn')) !!}
                            @endif
                            @if (auth()->user()->can('backup_destroy'))
                            @include('kamruldashboard::forms.partials.modal-item', [
                                    'type' => 'danger',
                                    'name' => 'modal-confirm-delete',
                                    'title' => trans('kamruldashboard::lang.confirm_delete'),
                                    'content' => trans('kamruldashboard::lang.confirm_delete_msg'),
                                    'action_name' => trans('kamruldashboard::lang.delete'),
                                    'action_button_attributes' => [
                                        'class' => 'delete-crud-entry',
                                ],
                            ])
{{--                                {!! Form::modalAction('restore-backup-modal', trans('kamruldashboard::lang.destroy'), 'danger', trans('kamruldashboard::lang.restore_confirm_msg'), 'restore-backup-button', trans('kamruldashboard::lang.restore_btn')) !!}--}}
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
