<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Adm\Traits\FieldsTraits;
use App\Http\Controllers\Adm\Traits\ListFieldTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class LogController extends AdmController
{
    use ListFieldTraits;
    use FieldsTraits;

    public function __construct()
    {
        $routeName = Route::currentRouteName();
        if ($routeName !== 'adm.doLogDownload') {
            parent::__construct();
            $this->title = 'Log';
            $this->titlePlural = 'Log';
            $this->allowActions = false;
            $this->allowStatus = true;
            $this->allowSearch = false;
            $this->noInsert = true;
    
            $logFiles = array_filter(
                scandir(storage_path() . '/logs', SCANDIR_SORT_DESCENDING),
                fn($fn) => // filter everything that begins with dot
                    !str_starts_with($fn,'.') &&
                    $fn !== "query.log" &&
                    $fn !== "laravel.log"
                 
            );

            $this->fields['Arquivos de Log'] = array(
                $this->customField([
                    'type' => 'logs',
                    'files' => $logFiles,
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
        $this->data['title'] = $this->title;
        $this->data['titlePlural'] = $this->titlePlural;
        $this->data['allowSave'] = false;
        $this->data['fields'] = $this->fields;
        return view('adm.pages.AppCommon.form', $this->data);
    }

    public function doLogDownload(Request $request, $file)
    {
        if ($request->user()->id_group == 1) {
            Storage::deleteDirectory('logs/');
            $storagePath = '/logs/' . $file;
            $path = storage_path() . $storagePath;
            $content = File::get($path);
            Storage::put($storagePath, $content);
            return Storage::download('logs/' . $file);
        } else {
            abort(401);
        }
    }

}