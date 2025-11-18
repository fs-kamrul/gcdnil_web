<tr class="@if (!empty($odd) && $odd == true) odd @else even @endif">
    <td>{{ $data['name'] }}</td>
    <td>@if ($data['description']) {{ $data['description'] }} @else &mdash; @endif</td>
    <td>{{ human_file_size(get_backup_size($key)) }}</td>
    <td style="width: 250px;">

{{--        {{ Carbon\Carbon::createFromTimestamp($data['date'])->diffForHumans(Carbon\Carbon::now()) }}--}}
        {{ $data['date'] }}
    </td>
    <td style="width: 150px;">
        @if ($backupManager->isDatabaseBackupAvailable($key))
            <a href="{{ route('kamruldashboard.backups.download.database', $key) }}" class="text-success" data-bs-toggle="tooltip" title="{{ trans('kamruldashboard::lang.download_database') }}"><i class="fa fa-database"></i></a>
        @endif

        <a href="{{ route('kamruldashboard.backups.download.uploads.folder', $key) }}" class="text-primary" data-bs-toggle="tooltip" title="{{ trans('kamruldashboard::lang.download_uploads_folder') }}"><i class="fa fa-cloud-download"></i></a>

        @if (auth()->user()->can('backup_destroy'))
            <a href="#" data-section="{{ route('kamruldashboard.backups.destroy', $key) }}" class="text-danger deleteDialog" data-bs-toggle="tooltip" title="{{ trans('kamruldashboard::lang.delete_entry') }}"><i class="fa fa-trash-o"></i></a>
        @endif

        @if (auth()->user()->can('backup_restore'))
            <a href="#" data-section="{{ route('kamruldashboard.backups.restore', $key) }}" class="text-info restoreBackup" data-bs-toggle="tooltip" title="{{ trans('kamruldashboard::lang.restore_tooltip') }}"><i class="fa fa-window-restore"></i></a>
        @endif
    </td>
</tr>
