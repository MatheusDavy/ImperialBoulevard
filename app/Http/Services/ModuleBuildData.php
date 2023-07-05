<?php

namespace App\Http\Services;

use App\Models\Adm\AdmModel;
use App\Models\Adm\GalleryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class ModuleBuildData
{
    private $input;
    private AdmModel $model;
    private $title;

    public static function buildData(Request $request, $model, string $title, array $fields)
    {
        $setData = new ModuleBuildData();
        $setData->setModel($model);
        $setData->setModelTitle($title);

        $data = array('language' => array());

        foreach ($fields as $k => $tab) {
            foreach ($tab as $key => $input) {
                $setData->setInput($input);
                $multilang = isset($input['multilanguage']) && $input['multilanguage'];
                if ($multilang) {
                    $data = $setData->getMultilangData($request, $data);
                } 
                
                if (!$multilang) {
                    $data = $setData->getCommonData($request, $data);
                }
            }
        }

        return $data;
    }

    public function getMultilangData(Request $request, $data = [])
    {
        $input = $this->input;

        foreach (config('app.languages') as $l => $lang) {
            if ($input['type'] == 'checkbox') {
                $data = $this->getCheckboxData($request, $l, true, $data);
            } elseif ($input['type'] == 'slug') {
                $data = $this->getSlugData($request, $l, true, $data);
            } elseif ($input['type'] == 'image') {
                $data = $this->getImageData($request, $l, true, $data);
            } else {
                $data = $this->getOtherData($request, $l, true, $data);
            }
        }

        return $data;
    }

    public function getCommonData(Request $request, $data = [])
    {
        $input = $this->input;

        if ($input['type'] == 'checkbox') {
            $data = $this->getCheckboxData($request, 0, false, $data);
        } elseif ($input['type'] == 'date') {
            $data = $this->getDate($request, $data);
        } elseif ($input['type'] == 'slug') {
            $data = $this->getSlugData($request, 0, false, $data);
        } elseif ($input['type'] == 'image') {
            $data = $this->getImageData($request, 0, false, $data);
        } elseif ($input['type'] == 'gallery') {
            $data = $this->getGalleryData($request, $data);
        } else {
            $data = $this->getOtherData($request, 0, false, $data);
        }

        return $data;

    }

    private function getCheckboxData(Request $request, $l = 0, $multilang = false, $data = [])
    {
        $input = $this->input;

        if ($multilang) {
            $data['language'][$l][$input['name']] =
                $request->input('language.' . $input['name'] . '.' . $l) ? '1' : '0';
            return $data;
        }

        $data[$input['name']] = $request->input($input['name']) ? '1' : '0';

        return $data;
    }

    private function getSlugData(Request $request, $l = 0, $multilang = false, $data = [])
    {
        $input = $this->input;

        if ($multilang) {
            $data['language'][$l][$input['name']] =
            slug($request->input('language.' . $input['field'] . '.' . $l));

            return $data;
        }

        $data[$input['name']] = slug($request->input($input['field']));

        return $data;
    }

    private function getImageData(Request $request, $l = 0, $multilang = false, $data = [])
    {
        $isGallery = 0;
        $module = $this->title;
        $model = $this->model;
        $input = $this->input;

        if ($multilang) {
            $file = ModuleBuildData::getFileJsonMultilang($request, $input, $l);
            $data['language'][$l][$input['name']] = $file ? $file : '';

            return $data;
        }

        $file = ModuleBuildData::getFileJson($request, $input);
        $data[$input['name']] = $file ? mb_convert_encoding($file, 'utf-8', 'auto') : '';

        return $data;
    }

    private function getDate(Request $request, $data = [])
    {
        $input = $this->input;
        $date = $request->input($input['name']) ? $request->input($input['name']) : '';
        $date = explode('/', $date);
        $date =
        (isset($date[2]) ? $date[2] : date('Y'))
        . '-' .
        (isset($date[1]) ? $date[1] : date('m'))
        . '-' .
        (isset($date[0]) ? $date[0] : date('d'));

        $data[$input['name']] = $date;

        return $data;
    }

    private function getGalleryData(Request $request, $data)
    {
        $input = $this->input;
        $model = $this->model;
        $folder = $input['folder'];
        $isGallery = 1;
        $module = $this->title;
        $gallery = $request->input($input['name']);
        if ($gallery) {
            $parameters = Route::current()->parameters();
            $moduleId = null;
            if (isset($parameters['id']) && $parameters['id']) {
                $moduleId = intval($parameters['id']);
            }
            foreach ($gallery['image'] as $key => $value) {
                $file = ModuleBuildData::getFileJsonFromGallery($gallery, $key);
            }

        }

        $data[$input['name']] = $gallery ? $gallery : '';

        return $data;
    }
    
    private function getOtherData(Request $request, $l = 0, $multilang = false, $data = [])
    {
        $input = $this->input;

        if ($multilang) {
            $data['language'][$l][$input['name']] =
            $request->input('language.' . $input['name'] . '.' . $l) ?
            mb_convert_encoding($request->input('language.' . $input['name'] . '.' . $l), 'utf-8', 'auto') : '';

            return $data;
        }

        $data[$input['name']] = $request->input($input['name']) ? 
            mb_convert_encoding($request->input($input['name']), 'utf-8', 'auto') : '';

        return $data;
    }

    private static function getFileJson(Request $request, array $input): string
    {
        $file = [];
        $file["src"] = $request->input($input['name']);
        $file["alt"] = $request->input($input['name'] . "Alt");
        $file["title"] = $request->input($input['name'] . "Title");
        $file = json_encode($file);

        return $file;
    }

    private static function getFileJsonMultilang(Request $request, array $input, $l): string
    {
        $file = [];
        $file["src"] = $request->input('language.' . $input['name'] . '.' . $l);
        $file["alt"] = $request->input('language.' . $input['name'] . "Alt" . '.' . $l);
        $file["title"] = $request->input('language.' . $input['name'] . "Title" . '.' . $l);
        $file = json_encode($file);

        return $file;
    }

    private static function getFileJsonFromGallery(array $gallery, int $key): string
    {
        $file = [];
        $file["src"] = $gallery['image'][$key];
        $file["alt"] = $gallery['imageAlt'][$key];
        $file["title"] = $gallery['imageTitle'][$key];
        $file = json_encode($file);

        return $file;
    }

    public function setInput($input)
    {
        $this->input = $input;
        return $this;
    }

    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    public function setModelTitle($title)
    {
        $this->title = $title;
        return $this;
    }

}