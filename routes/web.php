<?php

use App\Http\Controllers\Adm\Auth\UserTokenController;
use App\Http\Controllers\Adm\BackupController;
use App\Http\Controllers\Adm\CommonController;
use App\Http\Controllers\Adm\DashboardController;
use App\Http\Controllers\Adm\LogController;
use App\Http\Controllers\Adm\PagesController;
use App\Http\Controllers\Site\BlogController;
use App\Http\Controllers\Site\ContactController;
use App\Http\Controllers\Site\CronBackupController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\FormsController;
use App\Http\Controllers\Site\SiteController;
use App\Http\Services\ExcelScript;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
if (Schema::hasTable('adm_modules')) {
    // Rotas do ADM
    Route::redirect('/adm', 'dash');
    Route::prefix('adm')->middleware(['auth:sanctum'])->group(
        function () {
            // Rotas comuns
            Route::post('/user/createToken', [UserTokenController::class, 'createToken'])->name('user.create.token');
            Route::any('password', [CommonController::class, 'password'])->name('adm.password');
            Route::any('dash', [DashboardController::class, 'index'])->name('adm.dash');
            Route::any('common/upload', [CommonController::class, 'upload'])->name('adm.upload');
            
            //ckEditor
            Route::post('ckeditorImageUpload', [CommonController::class, 'upload'])->name('adm.ckImageUpload');
            
            //excelScript
            Route::get('/excelScript', [ExcelScript::class, 'excelScript']);

            //crop modal
            Route::post('/crop-modal', [CommonController::class, 'cropModal'])->name('adm.cropModal');
            //BACKUP
            Route::get('/doBackup/{table?}', [BackupController::class, 'doBackup'])->name('adm.doBackup');
            Route::get('/doBackupDownload/{file?}', [BackupController::class, 'doBackupDownload'])->name('adm.doBackupDownload');
            Route::get('/doLogDownload/{file?}', [LogController::class, 'doLogDownload'])->name('adm.doLogDownload');
            // Rotas do banco
            $modules = DB::table('adm_modules')->get()->all();

            foreach ($modules as $key => $item) {
                if ($item->url && $item->route) {
                    if (ucfirst($item->route) != 'Pages') {
                        $route = ucfirst($item->route) . 'Controller';
                        $path = "App\Http\Controllers\Adm";
                        $route = $path . '\\' . $route;
                        Route::any(
                            $item->url,
                            [$route, 'index']
                        )->name('adm.module.' . $item->id . '.index');

                        Route::any(
                            $item->url . 'adicionar',
                            [$route, 'adicionar']
                        )->name('adm.module.' . $item->id . '.insert');

                        Route::any(
                            $item->url . 'editar/{id}',
                            [$route, 'editar']
                        )->name('adm.module.' . $item->id . '.update');

                        Route::any(
                            $item->url . 'ver/{id}',
                            [$route, 'ver']
                        )->name('adm.module.' . $item->id . '.view');

                        Route::any(
                            $item->url . 'excluir/{id}',
                            [$route, 'excluir']
                        )->name('adm.module.' . $item->id . '.delete');

                        Route::any(
                            $item->url . 'sort',
                            [$route, 'sort']
                        )->name('adm.module.' . $item->id . '.sort');

                        Route::any(
                            $item->url . 'status',
                            [$route, 'status']
                        )->name('adm.module.' . $item->id . '.status');

                        Route::any(
                            $item->url . 'exportar',
                            [$route, 'exportar']
                        )->name('adm.module.' . $item->id . '.export');
                    } else {
                        Route::any(
                            $item->url,
                            [PagesController::class, 'index']
                        )->name('adm.module.' . $item->id . '.index');

                        Route::any(
                            $item->url . 'field',
                            [PagesController::class, 'field']
                        )->name('adm.module.' . $item->id . '.field');

                        Route::any(
                            $item->url . 'remove_field/{id}',
                            [PagesController::class, 'remove_field']
                        )->name('adm.module.' . $item->id . '.remove_field');

                        Route::any(
                            $item->url . 'sql/{id}',
                            [PagesController::class, 'sql']
                        )->name('adm.module.' . $item->id . '.sql');
                    }
                }
            }
        }
    );

    // Rotas do SITE
    $routes = DB::table('adm_seo')->orderBy('sort_order', 'asc')->get()->all();

    foreach ($routes as $key => $route) {
        if ($route->slug != 'general') {
            Route::any($route->uri, 'Site\\' . $route->route)->name('site.' . $route->slug);
        }
    }

    Route::get('cronBackup/{password}', [CronBackupController::class, 'doProductsBackup'])->name('site.cronBackup');

    Route::get('/', [HomeController::class, 'index'])->name('site.home');

    Route::post('/changeLang', [SiteController::class, 'changeLang'])->name('site.changeLang');
    Route::post('/newsletter', [FormsController::class, 'newsletterForm'])->name('site.newsletter');
} else {
    // echo "Precisa de migration";
}
