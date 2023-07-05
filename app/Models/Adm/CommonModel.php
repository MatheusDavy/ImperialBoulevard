<?php

namespace App\Models\Adm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class CommonModel
{
    use HasFactory;

    public function getModules()
    {
        $q = DB::table('adm_modules')
            ->where('status', '1')
            ->whereNull('parent')
            ->orderBy('sort_order');

        $parents = $q->get()->all();

        foreach ($parents as $key => $item) {
            $children = DB::table('adm_modules')
                ->where('status', '1')
                ->where('parent', $item->id)
                ->orderBy('sort_order')
                ->get()
                ->all();

            $item->children = $children;
        }

        return $parents;
    }

    public function getModule($id)
    {
        $item = DB::table('adm_modules')->where('id', $id)->first();

        if ($item && $item->parent) {
            $item->parent = DB::table('adm_modules')->where('id', $item->parent)->first();
        }

        return $item;
    }

    public function getUsers($options)
    {

        $defaults = array(
            'id' => false,
            'where' => false,
            'login' => false
        );

        $params = (object) array_merge($defaults, $options);

        $q = DB::table('adm_users as u')->select('*');

        if ($params->id) {
            $q->where('u.id', $params->id);
        }

        if ($params->where) {
            $q->where($params->where);
        }

        if ($params->login) {
            $q->whereRaw('(u.login = \'' . $params->login . '\' or u.email = \'' . $params->login . '\')');
        }

        $itens = $q->get()->all();

        return $params->id || $params->login ? (isset($itens[0]) && $itens[0] ? $itens[0] : false) : $itens;
    }
}
