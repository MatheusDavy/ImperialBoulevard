<?php

namespace App\Models\Adm;

use App\Models\Adm\AdmModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModulesModel extends AdmModel
{
    use HasFactory;

    protected $table = 'adm_modules';

    public $timestamps = false;

    public function get($params = array())
    {
        if (!isset($params['total']) && !isset($params['id'])) {
            $ret = parent::get(array_merge($params, ['sort_order' => ['sort_order','asc']]));
            foreach ($ret as $key => $item) {
                $item->id_parent = $item->parent;
                if ($item->parent) {
                    $parent = parent::get(array('id' => $item->parent));
                    $item->parent = $parent ? $parent->title : '';
                } else {
                    $item->parent = '--';
                }
            }
            foreach ($ret as $key => $item) {
                if (!$item->id_parent) {
                    foreach ($ret as $key => $oitem) {
                        if ($oitem->id_parent && $item->id == $oitem->id_parent) {
                            $ordered[] = $oitem;
                        }
                    }
                }
            }
            return $ret;
        } else {
            $ret = parent::get($params);
            return $ret;
        }
    }

    public function insert($data)
    {
        if (!$data['parent']) {
            $data['parent'] = null;
        }

        return parent::insert($data);
    }

    public function update($id = [], $data = [])
    {
        if (!$data['parent']) {
            $data['parent'] = null;
        }

        parent::update($id, $data);
    }
}
