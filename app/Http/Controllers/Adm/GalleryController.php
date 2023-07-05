<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Adm\Traits\FieldsTraits;
use App\Http\Controllers\Adm\Traits\ListFieldTraits;
use App\Models\Adm\BannersModel;
use App\Models\Adm\BlogModule\AuthorsModel;
use App\Models\Adm\GalleryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\Type\ObjectType;

class GalleryController extends AdmController
{
    use ListFieldTraits;
    use FieldsTraits;

    public function __construct()
    {
        parent::__construct();
        $this->model = new GalleryModel();
        $this->title = 'Galeria';
        $this->titlePlural = 'Galerias';
        $this->allowOrder = true;
        $this->allowStatus = true;
        $this->allowSave = false;
        $this->searchField = 'title';
    }

    public function index(Request $request)
    {
        $route = Route::currentRouteName();
        return redirect()->route(str_replace('index', 'update', $route), '1');
    }

    public function editar(Request $request, $id)
    {
        $galleryFirst = DB::table($this->model->getTable())->first();
        if ($galleryFirst) {
            $id = $galleryFirst->id;
        }

        $this->fillNullId();

        $data = $this->model->get();
        if (!$data) {
            return "<h1>O módulo está vazio.</h1><a href=" . url()->previous() . "><button>Voltar para a página anterior</button></a>";
        }

        usort($data, function ($data1, $data2) {
            if ($data1->module == $data2->module) {
                if ($data1->moduleId == $data2->moduleId) {
                    return $data1->isLang > $data2->isLang;
                }
                return $data1->moduleId > $data2->moduleId;
            }
            return $data1->module > $data2->module;
        });

        // $data = $this->getImageAndGallerySeparated();
        // dd($data);
        $this->data['itens'] = $data;
        $this->fields['Dados'] = array(
            $this->makeFields('galleryGeneral', null, ''),
        );
        return parent::editar($request, $id);
    }

    public function insert(bool $cleanUserfiles = false)
    {
        parent::insert($cleanUserfiles);
    }

    public function update($id, bool $cleanUserfiles = false)
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

        $validator = $this->setValidations($request);

        if (!$validator->fails()) {
            //diferente do método da classe pai
            $data = $this->request->all();

            $success = $this->model->update($id, $data);

            if (!$success) {
                $json['status'] = false;
                $json['message'] = "Algo deu errado ao salvar a imagem. Está excluindo? Talvez não seja permitido nesse caso.";
                echo json_encode($json);
                exit;
            }

            if ($cleanUserfiles) {
                $this->cleanUserfiles();
            }

            $json['status'] = true;
            $json['message'] = $this->title . ' editado(a).';
            $json['timeout'] = 3000;
            $json['redirect'] = route(str_replace('update', 'index', $route));
        } else {
            $json['message'] = implode("\n", $validator->errors()->all());
        }

        echo json_encode($json);
    }

    private function getImageAndGallerySeparated()
    {
        $dataImage = $this->model->get(['where' => ['isGallery' => 0]]);
        $dataGallery = $this->model->get(['where' => ['isGallery' => 1]]);

        if ($dataImage) {
            usort($dataImage, function ($dataImage1, $dataImage2) {
                if ($dataImage1->module == $dataImage2->module) {
                    return $dataImage1->moduleId > $dataImage2->moduleId;
                }
                return $dataImage1->module > $dataImage2->module;
            });
        }

        if ($dataGallery) {
            usort($dataGallery, function ($dataGallery1, $dataGallery2) {
                if ($dataGallery1->module == $dataGallery2->module) {
                    return $dataGallery1->moduleId > $dataGallery2->moduleId;
                }
                return $dataGallery1->module > $dataGallery2->module;
            });
        }


        return [...$dataImage, ...$dataGallery];
    }

    private function fillNullId()
    {
        $data = $this->model->get(['where' => ['moduleId' => null]]);
        foreach ($data as $key => $d) {
            if ($d->isGallery) {
                $findId = DB::table($d->table)->where(['image' => $d->title])->first();
                if (isset($findId->id)) {
                    $foreignKey = $d->foreignKey;
                    DB::table('site_general_gallery')->where(['title' => $d->title])->update([
                        'moduleId' => $findId->$foreignKey
                    ]);
                }
            } elseif ($d->isLang) {
                $findId = DB::table($d->table)->where([$d->column => $d->title])->first();
                if (isset($findId->id)) {
                    $foreignKey = $d->foreignKey;
                    DB::table('site_general_gallery')->where(['title' => $d->title, 'folder' => $d->folder])->update([
                        'moduleId' => $findId->$foreignKey
                    ]);
                }
            } else {
                $findId = DB::table($d->table)->where([$d->column => $d->title])->first();
                if (isset($findId->id)) {
                    DB::table('site_general_gallery')->where(['title' => $d->title, 'folder' => $d->folder])->update([
                        'moduleId' => $findId->id
                    ]);
                }
            }
        }
    }
}
