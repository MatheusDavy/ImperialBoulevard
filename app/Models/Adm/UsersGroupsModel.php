<?php

namespace App\Models\Adm;

use App\Models\Adm\AdmModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UsersGroupsModel extends AdmModel
{
    use HasFactory;

    protected $table = 'adm_users_groups';

    public $timestamps = false;

    public function get($params = array())
    {
        $ret = parent::get($params);
        if (isset($params['id']) && $params['id']) {
            $ret->permissions = explode('|', $ret->permissions);
        }
        return $ret;
    }

    public function insert($data)
    {
        $data['permissions'] = $data['permissions'] && is_array($data['permissions'])
            ? implode('|', $data['permissions']) : '';
        return parent::insert($data);
    }

    public function update($id = [], $data = [])
    {
        $data['permissions'] = $data['permissions'] && is_array($data['permissions']) ? implode('|', $data['permissions']) : '';

        parent::update($id, $data);
        $userGroup = UsersGroupsModel::find($id);
        if ($userGroup) {
            $userGroup->permissions = $data['permissions'];
            $userGroup->save();
        }
    }
}
