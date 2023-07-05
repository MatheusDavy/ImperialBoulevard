<?php

namespace App\Models\Adm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginModel extends Model
{
    use HasFactory;

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
            $q->where('email', $params->login);
        }

        $itens = $q->get()->all();

        return $params->id || $params->login ? (isset($itens[0]) && $itens[0] ? $itens[0] : false) : $itens;
    }

    public static function getPermissions($group)
    {
        $item = DB::table('adm_users_groups')->where('id', $group)->first();

        $permissions = explode('|', $item->permissions);

        return $permissions;
    }

    public function insertRecovery($data = array())
    {
        DB::table('adm_recoveries')->insert($data);
    }

    public function validKey($key)
    {
        $q = DB::table('adm_recoveries');
        $q->where('expiration', '>=', date('Y-m-d'))->where('key', $key)->where('used', '0');

        return $q->first();
    }

    public function changePassword($id_user, $password, $id_recover = false)
    {
        $password = Hash::make($password);
        DB::table('adm_users')->where('id', $id_user)->update(array('password' => $password));
        if ($id_recover) {
            DB::table('adm_recoveries')->where('id', $id_recover)->update(array('used' => '1'));
        }
    }
}
