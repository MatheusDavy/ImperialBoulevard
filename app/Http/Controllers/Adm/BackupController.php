<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Adm\Traits\FieldsTraits;
use App\Http\Controllers\Adm\Traits\ListFieldTraits;
use App\Http\Services\BackupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class BackupController extends AdmController
{
    use ListFieldTraits;
    use FieldsTraits;

    public function __construct()
    {
        $routeName = Route::currentRouteName();
        if ($routeName !== 'adm.doBackup' && $routeName !== 'adm.doBackupDownload') {
            parent::__construct();
            $this->title = 'Backup';
            $this->titlePlural = 'Backup';
            $this->allowActions = false;
            $this->allowStatus = true;
            $this->allowSearch = false;
            $this->noInsert = true;
    
            $files = Storage::files('backups');
            $files = collect($files)->map(function($file) {
                return str_replace('backups/', '', $file);
            })->toArray();
            sort($files);

            $dbName = 'Tables_in_' . env('DB_DATABASE');
            $tables = DB::select(DB::raw("SHOW TABLES"));
            
            $tables = collect($tables)->map(function ($name) use ($dbName) {
                return $name->$dbName;
            })->toArray();
            sort($tables);
            array_unshift($tables, 'Todas');
    
            $this->fields['Backup'] = array(
                $this->customField([
                    'type' => 'backup',
                    'files' => $tables,
                    'doBackup' => true,
                ]),
            );

            $this->fields['Arquivos de Backup'] = array(
                $this->customField([
                    'type' => 'backup',
                    'files' => $files,
                ]),
            );
        }
    }

    public function index(Request $request)
    {
        $route = Route::currentRouteName();
        return redirect()->route(str_replace('index', 'update', $route), '1');
    }

    public function editar(Request $request, $id)
    {
        abort_unless($request->user()->id_group == 1, 401);
        $this->request = $request;
        $route = Route::currentRouteName();

        if ($this->justView) {
            return redirect()->route(str_replace('update', 'index', $route));
        }

        $this->data['item'] = [];
        $this->data['action'] = route($route, $id);
        $this->data['title'] = 'Fazer ' . $this->title;
        $this->data['titlePlural'] = $this->titlePlural;
        $this->data['allowSave'] = false;
        $this->data['fields'] = $this->fields;
        return view('adm.pages.AppCommon.form', $this->data);
    }

    public function doBackup(Request $request, $table)
    {
        if ($request->user()->id_group == 1) {
            if ($table == 'Todas') {
                $table = "*";
            }
            BackupService::backupDB($table);
        } else {
            abort(401);
        }

    }

    public function doBackupDownload(Request $request, $file)
    {
        if ($request->user()->id_group == 1) {
                return Storage::download('backups/' . $file);
        } else {
            abort(401);
        }
    }

}