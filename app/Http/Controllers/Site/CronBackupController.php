<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Adm\Traits\FieldsTraits;
use App\Http\Controllers\Adm\Traits\ListFieldTraits;
use App\Http\Services\BackupService;
use Illuminate\Support\Facades\DB;

class CronBackupController
{
    use ListFieldTraits;
    use FieldsTraits;

    public function doProductsBackup($password)
    {
        abort_unless($password == 'CkadaAXka@dnawdaISFM432@23aged', 401);

        $tables= '*';
        echo "Inicío Backup";
        echo "<br>";
        BackupService::backupDB($tables, true);
        echo "Fim Backup";
    }

}