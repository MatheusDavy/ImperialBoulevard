<?php

namespace App\Http\Controllers\Adm;

use Illuminate\Http\Request;
use App\Models\Adm\PagesModel;

class PagesController extends AdmController
{
    public function __construct()
    {
        parent::__construct();
        $this->multilanguage = false;
        $this->model =  new PagesModel();
        $this->model->multilanguage = $this->multilanguage;
    }

    public function index(Request $request)
    {
        $this->request = $request;

        if ($this->request->ajax()) {
            $this->save();
            return;
        }

        $route = $this->request->route()->getName();

        $module = str_replace(['adm.module.','.index'], ['',''], $route);
        $module = $this->commonModel->getModule($module);

        $slug = $this->request->segments();
        unset($slug[0]);
        $slug = implode('-', $slug);

        $page = $this->model->getPage($slug);

        $fields = array('Geral' => array());
        $item = (object)array();

        foreach ($page->fields as $key => $field) {
            $field->remove = route('adm.module.' . $module->id . '.remove_field', $field->id);
            if ($this->multilanguage && in_array($field->type, ['input','text','ckEditor'])) {
                if (!isset($item->language)) {
                    $item->language = array();
                }
                foreach (config('app.languages') as $l => $lang) {
                    if (!isset($item->language[$l])) {
                        $item->language[$l] = (object)array();
                    }
                    $item->language[$l]->{$field->name} = $field->language[$l]->{$field->name};
                }
                $fields['Geral'][] = array(
                    'type' => $field->type,
                    'folder' => 'paginas',
                    'title' => $field->title,
                    'name' => $field->name,
                    'multilanguage' => true,
                    'half' => ($field->half == '1')
                );
            } elseif ($field->type == 'gallery') {
                $item->gallery = $page->gallery;
                $fields['Imagens'][] = array(
                    'type' => $field->type,
                    'folder' => 'paginas',
                    'title' => 'Imagens',
                    'name' => 'gallery'
                );
            } else {
                $item->{$field->name} = $field->value;
                $fields['Geral'][] = array(
                    'type' => $field->type,
                    'folder' => 'paginas',
                    'title' => $field->title,
                    'name' => $field->name,
                    'half' => ($field->half == '1')
                );
            }
        }

        $this->data['title'] = ($module->parent ? $module->parent->title . ' - ' : '') . $module->title;
        $this->data['action'] = route($route);
        $this->data['page'] = $page;
        $this->data['fields'] = $fields;
        $this->data['item'] = $item;
        $this->data['sql'] = route(str_replace('index', 'sql', $route), $page->id);
        $this->data['field'] = route(str_replace('index', 'field', $route));

        return view('adm.pages.AppCommon.form', $this->data);
    }

    private function save()
    {
        $slug = $this->request->segments();
        unset($slug[0]);
        $slug = implode('-', $slug);

        $page = $this->model->getPage($slug);
        $data = array();

        foreach ($page->fields as $key => $field) {
            $data[$field->id] = array(
                'value' => $this->request->input($field->name),
                'type' => $field->type,
                'description' =>  array()
            );

            if ($field->type == 'checkbox') {
                $data[$field->id]['value'] = $this->request->input($field->name) ? '1' : '0';
            }

            if ($this->multilanguage && in_array($field->type, ['input','text','ckEditor'])) {
                foreach (config('app.languages') as $l => $lang) {
                    $data[$field->id]['description'][] = array(
                        'id_language' => $l,
                        'id_field' => $field->id,
                        'value' => $this->request->input('language.' . $field->name . '.' . $l)
                    );
                }
            }
        }

        $this->model->save($page->id, $data);

        $this->cleanUserfiles();

        echo json_encode(['status' => true, 'message' => 'Dados editados.']);
    }

    public function field(Request $request)
    {
        $this->request = $request;
        $route = $this->request->route()->getName();
        $json = ['status' => false];

        $page = $this->request->input('page');
        $title = $this->request->input('title');
        $name = $this->request->input('name');
        $type = $this->request->input('type');
        $half = $this->request->input('half') ? '1' : '0';

        $page = $this->model->getPage($page);

        if ($type == 'gallery' && $page->hasGallery) {
            $json['message'] = 'Já existe galeria.';
        } else {
            $this->model->addField($page->id, [
                'title' => $title,
                'name' => $name,
                'type' => $type,
                'half' => $half
            ]);

            $json['status'] = true;
            $json['redirect'] = route(str_replace('field', 'index', $route));
        }

        echo json_encode($json);
    }

    public function remove_field(Request $request, $id)
    {
        $this->request = $request;
        $this->model->removeField($id);
        $route = $this->request->route()->getName();
        return redirect()->route(str_replace('remove_field', 'index', $route));
    }

    public function cleanUserfiles()
    {
        $pages = $this->model->getPages();
        $folder = 'paginas';
        $files = array();

        foreach ($pages as $key => $page) {
            foreach ($page->fields as $key => $field) {
                if (in_array($field->type, ['image', 'file']) && $field->value) {
                    $files[] = $field->value;
                }
            }
            if ($page->hasGallery) {
                foreach ($page->gallery as $key => $item) {
                    $files[] = $item->image;
                }
            }
        }

        foreach (scandir(config('app.userfiles_path') . $folder) as $key => $file) {
            if (is_file(config('app.userfiles_path') . $folder . '/' . $file) && $file != '.gitignore') {
                if (!in_array($file, $files)) {
                    @unlink(config('app.userfiles_path') . $folder . '/' . $file);
                }
            }
        }
    }

    public function sql($id)
    {
        $sql = $this->model->getSQL($id);
        echo '<pre>' . htmlentities($sql) . '</pre>';
    }
}
