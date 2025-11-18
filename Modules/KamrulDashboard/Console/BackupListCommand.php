<?php

namespace Modules\KamrulDashboard\Console;

use Exception;
use Illuminate\Console\Command;
use Modules\KamrulDashboard\Packages\Supports\Backup;

class BackupListCommand extends Command
{
    /**
     * @var Backup
     */
    public $backup;

    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'kamrul:backup:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all backups';

    /**
     * BackupCommand constructor.
     * @param Backup $backup
     */
    public function __construct(Backup $backup)
    {
        parent::__construct();
        $this->backup = $backup;
    }

    /**
     * Execute the console command.
     * @throws Exception
     */
    public function handle()
    {
        try {
            $backups = get_file_data($this->backup->getBackupPath('backup.json'));

            foreach ($backups as $key => &$backup) {
                $backup['key'] = $key;
            }

            $header = [
                'Name',
                'Description',
                'Date',
                'Folder',
            ];

            $this->table($header, $backups);

        } catch (Exception $exception) {
            $this->error($exception->getMessage());
        }

        return 0;
    }
}
