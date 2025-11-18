<?php

namespace Modules\KamrulDashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Modules\KamrulDashboard\Http\Requests\BackupRequest;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\KamrulDashboard\Packages\Supports\Backup;
use Modules\KamrulDashboard\Utils\Util;
use Storage;
use Log;
use Helper;


class BackUpController extends Controller
{

    /**
     * @var Backup
     */
    protected $backup;
    /**
     * All Utils instance.
     * @var Util
     *
     */
    protected $commonUtil;

    /**
     * Controller constructor.
     * @param Util $commonUtil
     * @param Backup $backup
     */
    public function __construct(Util $commonUtil, Backup $backup)
    {
        $this->commonUtil = $commonUtil;
        $this->backup = $backup;
    }

    public function getIndex()
    {
        page_title()->setTitle(trans('kamruldashboard::lang.backup'));
        $title = 'backup';
        if (!auth()->user()->can('backup_access')) {
            abort(403, 'Unauthorized action.');
        }
        $backupManager = $this->backup;

        $backups = $this->backup->getBackupList();

        return view('kamruldashboard::backup.index', compact('backups', 'backupManager', 'title'));
    }

    /**
     * @param BackupRequest $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @throws \Throwable
     */
    public function store(BackupRequest $request, DboardHttpResponse $response)
    {
        try {
            @ini_set('max_execution_time', -1);
            @ini_set('memory_limit', -1);

            $data = $this->backup->createBackupFolder($request->input('name'), $request->input('description'));
            $this->backup->backupDb();
            $this->backup->backupFolder(config('filesystems.disks.public.root'));

            do_action(BACKUP_ACTION_AFTER_BACKUP, BACKUP_MODULE_SCREEN_NAME, $request);

            $data['backupManager'] = $this->backup;

            return $response
                ->setData(view('kamruldashboard::backup.partials.backup-item', $data)->render())
                ->setMessage(trans('kamruldashboard::lang.create_backup_success'));
        } catch (\Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    /**
     * @param string $folder
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     */
    public function destroy($folder, DboardHttpResponse $response)
    {
        try {
            $this->backup->deleteFolderBackup($this->backup->getBackupPath($folder));

            return $response->setMessage(trans('kamruldashboard::lang.delete_backup_success'));
        } catch (\Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    /**
     * @param string $folder
     * @param Request $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     */
    public function getRestore($folder, Request $request, DboardHttpResponse $response)
    {
        try {
            $path = $this->backup->getBackupPath($folder);
            foreach (scan_folder($path) as $file) {
                if (Str::contains(basename($file), 'database')) {
                    $this->backup->restoreDatabase($path . DIRECTORY_SEPARATOR . $file, $path);
                }

//                if (Str::contains(basename($file), 'storage')) {
//                    $pathTo = config('filesystems.disks.public.root');
//                    $this->backup->cleanDirectory($pathTo);
//                    $this->backup->extractFileTo($path . DIRECTORY_SEPARATOR . $file, $pathTo);
//                }
            }

            setting()->set('media_random_hash', md5(time()))->save();

//            Helper::clearCache();

            do_action(BACKUP_ACTION_AFTER_RESTORE, BACKUP_MODULE_SCREEN_NAME, $request);

            return $response->setMessage(trans('kamruldashboard::lang.restore_backup_success'));
        } catch (\Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    /**
     * @param string $folder
     * @return DboardHttpResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function getDownloadDatabase($folder, DboardHttpResponse $response)
    {
        $path = $this->backup->getBackupPath($folder);

        foreach (scan_folder($path) as $file) {
            if (Str::contains(basename($file), 'database')) {
                return response()->download($path . DIRECTORY_SEPARATOR . $file);
            }
        }

        return $response
            ->setError()
            ->setMessage(trans('kamruldashboard::lang.database_backup_not_existed'));
    }

    /**
     * @param string $folder
     * @return bool|DboardHttpResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function getDownloadUploadFolder($folder, DboardHttpResponse $response)
    {
        $path = $this->backup->getBackupPath($folder);

        foreach (scan_folder($path) as $file) {
            if (Str::contains(basename($file), 'storage')) {
                return response()->download($path . DIRECTORY_SEPARATOR . $file);
            }
        }

        return $response
            ->setError()
            ->setMessage(trans('kamruldashboard::lang.uploads_folder_backup_not_existed'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'backup';
        if (!auth()->user()->can('backup')) {
            abort(403, 'Unauthorized action.');
        }

        $disk = Storage::disk(config('backup.backup.destination.disks')[0]);

        $files = $disk->files(config('backup.backup.name'));

        $backups = [];
        // make an array of backup files, with their filesize and creation date
        foreach ($files as $k => $f) {
            // only take the zip files into account
            if (substr($f, -4) == '.zip' && $disk->exists($f)) {
                $backups[] = [
                    'file_path' => $f,
                    'file_name' => str_replace(config('backup.backup.name') . '/', '', $f),
                    'file_size' => $disk->size($f),
                    'last_modified' => $disk->lastModified($f),
                ];
            }
        }
        // reverse the backups, so the newest one would be on top
        $backups = array_reverse($backups);

        $cron_job_command = $this->commonUtil->getCronJobCommand();
        $backup_clean_cron_job_command = $this->commonUtil->getBackupCleanCronJobCommand();

        return view("kamruldashboard::backup.index")
            ->with(compact('backups', 'cron_job_command', 'backup_clean_cron_job_command','title'));
    }

    /**
     * Create a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('backup')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            //Disable in demo
            $notAllowed = $this->commonUtil->notAllowedInDemo();
            if (!empty($notAllowed)) {
                return $notAllowed;
            }

            // start the backup process
//            Artisan::call('backup:run');
            Artisan::call('backup:run --only-db');
            $output = Artisan::output();

            // log the results
            Log::info("Backpack\BackupManager -- new backup started from admin interface \r\n" . $output);

//            $output = ['success' => 1,
//                        'msg' => __('lang_v1.success')
//                    ];
            $response_data['status'] = 1;
            $response_data['message'] =  __('kamruldashboard::lang.backup_create_successfully');
        } catch (Exception $e) {
//            $output = ['success' => 0,
//                        'msg' => $e->getMessage()
//                    ];
            $response_data['status'] = 0;
            $response_data['message'] =  __('kamruldashboard::lang.error');
        }

        return back()->with('status', $output)->with('response_data', $response_data);
    }

    /**
     * Downloads a backup zip file.
     *
     * TODO: make it work no matter the flysystem driver (S3 Bucket, etc).
     */
    public function download($file_name)
    {
        if (!auth()->user()->can('backup')) {
            abort(403, 'Unauthorized action.');
        }

        //Disable in demo
        if (config('app.env') == 'demo') {
//            $output = ['success' => 0,
//                            'msg' => 'Feature disabled in demo!!'
//                        ];

            $response_data['status'] = 0;
            $response_data['message'] =  __('kamruldashboard::lang.feature_disabled_in_demo');
            return back()->with('response_data', $response_data);
        }

        $file = config('backup.backup.name') . '/' . $file_name;
        $disk = Storage::disk(config('backup.backup.destination.disks')[0]);
        if ($disk->exists($file)) {
            $fs = Storage::disk(config('backup.backup.destination.disks')[0])->getDriver();
            $stream = $fs->readStream($file);
            return \Response::stream(function () use ($stream) {
                fpassthru($stream);
            }, 200, [
                "Content-Type" => $fs->getMimetype($file),
                "Content-Length" => $fs->getSize($file),
                "Content-disposition" => "attachment; filename=\"" . basename($file) . "\"",
            ]);
        } else {
            abort(404, "The backup file doesn't exist.");
        }
    }

    /**
     * Deletes a backup file.
     */
    public function delete($file_name)
    {
        if (!auth()->user()->can('backup')) {
            abort(403, 'Unauthorized action.');
        }

        //Disable in demo
        if (config('app.env') == 'demo') {
//            $output = ['success' => 0,
//                            'msg' => 'Feature disabled in demo!!'
//                        ];
            $response_data['status'] = 0;
            $response_data['message'] =  __('kamruldashboard::lang.feature_disabled_in_demo');
            return back()->with('response_data', $response_data);
        }

        $disk = Storage::disk(config('backup.backup.destination.disks')[0]);
        if ($disk->exists(config('backup.backup.name') . '/' . $file_name)) {
            $disk->delete(config('backup.backup.name') . '/' . $file_name);
            $response_data['status'] = 1;
            $response_data['message'] =  __('kamruldashboard::lang.delete_successfully');
            return redirect()->back()->with('response_data', $response_data);
        } else {
            abort(404, "The backup file doesn't exist.");
        }
    }
}
