<?php

namespace App\Http\Controllers\Adm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Site\SiteController;
use App\Http\Services\CacheService;
use App\Http\Services\ModuleBuildData;
use App\Http\Services\ModuleCleanUserfiles;
use App\Http\Services\ModuleValidation;
use App\Models\Adm\CacheModel;
use App\Models\Adm\CommonModel;
use GuzzleHttp\Psr7\MimeType;
use Illuminate\Support\Facades\Route as Route;
use Symfony\Component\DomCrawler\Crawler;
use Throwable;

class AdmController extends Controller
{

    protected array $data = [];
    protected $model;
    protected CommonModel $commonModel;
    protected string $mainTitle = 'Painel Site';
    protected string $title = '';
    protected string $titlePlural = '';
    protected array $fields = array();
    protected array $listFields = array();
    protected bool $allowOrder = false;
    protected bool $allowStatus = false;
    public bool $filter = false;
    public $exportFields;
    public $modalFields;
    protected bool $allowActions = true;
    protected bool $allowSearch = true;
    protected bool $allowSave = true;
    protected bool $justView = false;
    protected bool $export = false;
    protected bool $noInsert = false;
    protected $searchField = 'title';
    public $request;

    public function __construct()
    {
        $this->commonModel = new CommonModel();

        $this->checkUserPermissionToAccessPage();

        $modules = $this->commonModel->getModules();

        $this->data['gtm'] = $this->getGtm();
        $this->data['main_title'] = $this->mainTitle;
        $this->data['modules'] = $modules;
        $this->data['languages'] = config('app.languages');
    }

    public function index(Request $request)
    {
        $this->request = $request;

        if ($this->request->ajax()) {
            $this->ajax();
            return;
        }

        $route = Route::currentRouteName();

        $this->data['ajax'] = route($route);
        $this->data['insert'] = route(str_replace('index', 'insert', $route));
        $this->data['sort'] = route(str_replace('index', 'sort', $route));
        $this->data['status'] = route(str_replace('index', 'status', $route));
        $this->data['export'] = $this->export ?  route(str_replace('index', 'export', $route)) : false;
        $this->data['title'] = $this->titlePlural;
        $this->data['titlePlural'] = $this->titlePlural;
        $this->data['listFields'] = $this->listFields;
        $this->data['allowOrder'] = $this->allowOrder;
        $this->data['filter'] = $this->filter;
        $this->data['allowActions'] = $this->allowActions;
        $this->data['allowStatus'] = $this->allowStatus;
        $this->data['allowSearch'] = $this->allowSearch;
        $this->data['noInsert'] = $this->noInsert;
        $this->data['justView'] = $this->justView;

        return view('adm.pages.AppCommon.list', $this->data);
    }

    private function ajax()
    {
        $request = $this->request;
        $offset = $request->input('start') ? (int) $request->input('start') : 0;
        $limit = $request->input('length') ? (int) $request->input('length') : 10;
        $draw = $request->input('draw') ? (int) $request->input('draw') : 1;
        $columns = $request->input('columns');
        $order = $request->input('order.0');
        $search = $request->input('search.value') ? $request->input('search.value') : false;

        $route = Route::currentRouteName();

        if ($this->allowOrder) {
            array_unshift($this->listFields, ['name' => 'sort_order', 'order' => true]);
        }
        if ($this->allowStatus) {
            array_push($this->listFields, ['name' => 'status', 'order' => true]);
        }

        if (
            isset($order['column']) &&
            isset($columns[$order['column']]['name']) &&
            isset($this->listFields[$order['column']]['order']) &&
            $this->listFields[$order['column']]['order']
        ) {
            $dir = isset($order['dir']) ? $order['dir'] : 'asc';
            $sort_order = array($columns[$order['column']]['name'], $dir);
        } else {
            if ($this->allowOrder) {
                $sort_order = array('sort_order', 'asc');
            } else {
                $sort_order = false;
            }
        }

        $params = array(
            'offset' => $offset,
            'limit' => $limit,
            'search' => $search,
            'search_field' => $this->searchField,
            'sort_order' => $sort_order
        );

        $itens = $this->model->get($params);
        $total = $this->model->get(array_merge($params, array('total' => true)));

        $route = Route::currentRouteName();

        $updateRoute = str_replace('index', 'update', $route);
        $viewRoute = str_replace('index', 'view', $route);
        $deleteRoute = str_replace('index', 'delete', $route);

        $json = array('draw' => $draw, 'recordsTotal' => $total, 'recordsFiltered' => $total);

        if ($this->allowOrder) {
            array_shift($this->listFields);
        }
        if ($this->allowStatus) {
            array_pop($this->listFields);
        }

        $json['data'] = $this->buildListHtmlForAjax($itens, $updateRoute, $deleteRoute, $viewRoute);

        echo json_encode($json);
    }

    public function sort(Request $request)
    {
        $json = array('status' => false);

        $data = $request->input('data');
        CacheService::cleanCachesInArray($this->model->getCaches());
        if (is_array($data)) {
            $min = false;
            foreach ($data as $item) {
                if (!$min || $item['order'] < $min) {
                    $min = $item['order'];
                }
            }
            foreach ($data as $item) {
                $this->model::where('id', $item['id'])->update(array('sort_order' => $min));
                $min++;
            }
            $json['status'] = true;
            $json['message'] = 'Ordem editada.';
        }

        echo json_encode($json);
    }

    public function status(Request $request)
    {
        $json = array('status' => false);
        $status = $request->input('status') == 'true' ? '1' : '0';

        CacheService::cleanCachesInArray($this->model->getCaches());
        CacheModel::flushCache($status);

        $id = $request->input('id');
        $this->model::where('id', $id)->update(array('status' => $status));
        
        $json['status'] = true;
        $json['message'] = $this->title . ($status == '1' ? ' ativado(a).' : ' desativado(a).');

        echo json_encode($json);
    }

    public function excluir($id)
    {
        $json = array('status' => false);

        $item = $this->model->get(array('id' => $id));

        if ($item) {
            $this->model->delete($id);
            $this->cleanUserfiles();
            $json['status'] = true;
            $json['message'] = $this->title . ' excluído(a).';
        } else {
            $json['message'] = $this->title . ' não encontrado(a).';
        }

        echo json_encode($json);
    }

    public function exportar()
    {
        $route = Route::currentRouteName();

        if (!$this->export) {
            return redirect()->route(str_replace('export', 'index', $route));
        }

        $itens = $this->model->get();

        $headers = array();

        foreach ($this->exportFields as $key => $field) {
            $headers[] = mb_convert_encoding($field['title'], 'utf-8', 'auto');
        }

        $rows = array();

        foreach ($itens as $key => $item) {
            $rows[$key] = array();

            foreach ($this->exportFields as $field) {
                $rows[$key][] = mb_convert_encoding(str_replace("\n", '  ', $item->{$field['name']}), 'utf-8', 'auto');
            }
        }

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . slug($this->titlePlural) . '.csv');
        $output = fopen('php://output', 'w');

        fputcsv($output, $headers, ';', '"');

        foreach ($rows as $key => $row) {
            fputcsv($output, $row, ';', '"');
        }

        return;
    }

    public function ver($id)
    {
        $route = Route::currentRouteName();

        if (!$this->justView) {
            return redirect()->route(str_replace('view', 'index', $route));
        }

        $json = array('status' => false);

        $item = $this->model->get(array('id' => $id));

        if ($item) {
            foreach ($this->modalFields as $key => $field) {
                $field['mime'] = '';
                if (isset($field['type']) && $field['type'] == 'image') {
                    $src = decodeImageJson($item->{$field['name']}, null, true);
                    $path = config('app.userfiles_path') . $field['folder'];
                    $fileSrc = asset($path . '/' . $src);
                    $mime = MimeType::fromFilename($fileSrc);
                    $this->modalFields[$key]['mime'] = $mime;
                    $this->modalFields[$key]['src'] = $fileSrc;
                    if (preg_match('/video/', $mime)) {
                        $this->modalFields[$key]['type'] = 'video';
                    }
                }
            }

            $html = (string) view(
                'adm.pages.AppCommon.modal',
                array('fields' => $this->modalFields,'item' => $item)
            );
            $json['status'] = true;
            $json['title'] = $this->title;
            $json['html'] = mb_convert_encoding(html_entity_decode($html), 'utf-8', 'auto');
        } else {
            $json['message'] = $this->title . ' não encontrado(a).';
        }

        echo json_encode($json);
    }

    public function adicionar(Request $request)
    {
        $this->request = $request;
        $route = Route::currentRouteName();

        if ($this->justView) {
            return redirect()->route(str_replace('insert', 'index', $route));
        }

        if ($this->request->ajax()) {
            $this->insert();
            return;
        }

        $this->data['item'] = false;
        $this->data['action'] = route($route);
        $this->data['back'] = route(str_replace('insert', 'index', $route));
        $this->data['title'] = 'Adicionar ' . $this->title;
        $this->data['titlePlural'] = $this->titlePlural;
        $this->data['allowSave'] = $this->allowSave;
        $this->data['fields'] = $this->fields;
        return view('adm.pages.AppCommon.form', $this->data);
    }

    public function insert(bool $cleanUserfiles = true)
    {
        $request = $this->request;
        $json = array('status' => false);
        $this->validateData($request);
        $route = Route::currentRouteName();
    
        $data = $this->buildData();

        if ($this->allowOrder) {
            $last = $this->model->get(array(
                'limit' => 1,
                'sort_order' => array('sort_order', 'desc')
            ));
            $data['sort_order'] = $last ? ((int)$last[0]->sort_order + 1) : 1;
        }

        $this->model->insert($data);

        if ($cleanUserfiles) {
            $this->cleanUserfiles();
        }

        $json['status'] = true;
        $json['message'] = $this->title . ' adicionado(a).';
        $json['timeout'] = 3000;
        $json['redirect'] = route(str_replace('insert', 'index', $route));

        echo json_encode($json);
    }

    public function editar(Request $request, $id)
    {
        $this->request = $request;
        $route = Route::currentRouteName();

        if ($this->justView) {
            return redirect()->route(str_replace('update', 'index', $route));
        }

        if ($this->request->ajax()) {
            $this->update($id);
            return;
        }
        $item = isset($this->data['item']) ? $this->data['item'] : null;

        if (!$item) {
            $item = $this->model->get(['id' => $id, 'cms' => true]);
        }

        if (!$item) {
            return redirect()->route(str_replace('update', 'index', $route));
        }

        $this->data['item'] = $item;
        $this->data['action'] = route($route, $id);
        $this->data['back'] = route(str_replace('update', 'index', $route));
        $this->data['title'] = 'Editar ' . $this->title;
        $this->data['titlePlural'] = $this->titlePlural;
        $this->data['allowSave'] = $this->allowSave;
        $this->data['fields'] = $this->fields;
        return view('adm.pages.AppCommon.form', $this->data);
    }

    public function update($id, bool $cleanUserfiles = true)
    {
        $request = $this->request;
        $json = array('status' => false);
        $route = Route::currentRouteName();

        $item = $this->model->get(array('id' => $id));

        if (!$item) {
            $json['message'] = 'Item não encontrado!';
            echo json_encode($json);
            return;
        }

        $this->validateData($request);

        $data = $this->buildData();

        try {
            $this->model->update($id, $data);
        } catch (\Throwable $th) {
            $json['message'] = $this->treatErrors($th);
            echo json_encode($json);
            exit;
        }

        if ($cleanUserfiles) {
            $this->cleanUserfiles();
        }

        $redirect = route(str_replace('update', 'index', $route));
        $json['status'] = true;
        $json['message'] = $this->title . ' editado(a).';
        $json['timeout'] = 3000;
        $json['redirect'] = $redirect;

        echo json_encode($json);
    }

    protected function validateData(Request $request)
    {
        return ModuleValidation::moduleValidation($request, $this->fields);
    }

    protected function buildData()
    {
        $request = $this->request;
        $model = $this->model;
        $title = $this->title;
        $fields = $this->fields;

        return ModuleBuildData::buildData($request, $model, $title, $fields);
    }

    protected function cleanUserfiles()
    {
        $model = $this->model;
        $fields = $this->fields;

        ModuleCleanUserfiles::cleanUserfiles($fields, $model);
    }

    protected function buildListHtmlForAjax($itens, string $updateRoute, string $deleteRoute, string $viewRoute): array
    {
        $data = array();

        foreach ($itens as $key => $item) {
            $line = array();
            $viewData['item'] = $item;
            $viewData['justView'] = $this->justView;
            $viewData['update'] = route($updateRoute, $item->id);
            $viewData['delete'] = route($deleteRoute, $item->id);
            $viewData['view'] = route($viewRoute, $item->id);

            if ($this->allowOrder) {
                $line['sort_order'] = view('adm.pages.AppCommon.ListElements.sort_order', $viewData)->render();
            }

            if ($this->allowStatus) {
                $line['status'] = view('adm.pages.AppCommon.ListElements.status', $viewData)->render();
            }

            $line['actions'] = view('adm.pages.AppCommon.ListElements.actions', $viewData)->render();

            foreach ($this->listFields as $key => $field) {
                $viewData['field'] = $field;
                if (isset($field['type']) && $field['type']) {
                    if ($field['type'] == 'image') {
                        $line[$field['name']] = view('adm.pages.AppCommon.ListElements.tableImage', $viewData)->render();
                    }
                } else {
                    $line[$field['name']] = mb_convert_encoding(
                        (isset($field['source']) ?
                        modelTranslate($item->{$field['source']}) : modelTranslate($item->{$field['name']})),
                        'utf-8',
                        'auto'
                    );
                }
            }

            $data[] = $line;
        }

        return $data;
    }

    protected function treatErrors(Throwable $th): string
    {
        $message = 'Aconteceu um erro durante o envio, tente mais tarde.';
        switch ($th->getCode()) {
            case '22001':
                $message = 'Um campo ultrapassou o limite de caracteres.';
                break;

            case '22007':
                $message = 'Formato inválido de data.';
                break;

            case '1000':
                $message = 'Erro ao salvar campos multi-idiomas.';
                break;

            case '1001':
                $message = 'Erro ao salvar campos dinâmicos.';
                break;

            case '1002':
                $message = 'Erro ao salvar galeria.';
                break;
            
            default:
                logger($th->getMessage());
                $message = 'Aconteceu um erro durante o envio, tente mais tarde.';
                break;
        }

        return $message;
    }

    private function checkUserPermissionToAccessPage()
    {
        $this->middleware(function ($request, $next) {
            $route = $request->route()->getName();
            $user = $request->user();
            $codes = [];
            $permissions = [];
            $token = '';

            if (!$user) {
                return redirect()->route('login');
            }

            $twoFactorActive = $user->hasEnabledTwoFactorAuthentication();
            if ($twoFactorActive) {
                $codes = $user->recoveryCodes();
            }

            if (isset($user->tokens) && $user->tokens->all()) {
                $token = $user->tokens->first()->abilities[0];

                if ($user->permissions && $token == 'role:admin') {
                    $permissions = explode('|', $user->permissions->permissions);
                }

                if ($token !== 'role:admin') {
                    $token = '';
                    $permissions = [];
                }
            }

            $user->permissions = $permissions;

            if (!in_array($route, ['login'])) {
                if (!in_array($route, ['adm.upload', 'adm.dash'])) {
                    $module = explode('.', $route);
                    $module = isset($module[2]) ? $module[2] : 99999;
                    if (!in_array($module, $user->permissions)) {
                        return redirect()->route('adm.dash');
                    }
                } else {
                    $module = 99999;
                }
                $this->data['current_module'] = $module;
                $this->data['user'] = $user;
                $this->data['twoFactorActive'] = $twoFactorActive;
                $this->data['hasToken'] = $token;
                $this->data['codes'] = $codes;
                
            }
            return $next($request);
        });
    }

    private function getGtm()
    {
        try {
            $siteController = new SiteController();
            
            $html = view('site.layout.app', $siteController->data)->render();
            $crawler = new Crawler($html);
            $scripts = $crawler->filter("script")->each(function (Crawler $node, $i) {
                return $node->text();
            });
            $gtm = false;
            foreach ($scripts as $key => $value) {
                if (!$value) {
                    unset($scripts[$key]);
                } else if (preg_match("/https:\/\/www.googletagmanager.com\/gtm/", $value)) {
                    $gtm = true;
                }
            }

            return $gtm;

        } catch (\Throwable $th) {
            logger($th);
            return 'error';
        }
    }
}
