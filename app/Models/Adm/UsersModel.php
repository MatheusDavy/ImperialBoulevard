<?php

namespace App\Models\Adm;

use App\Models\Adm\AdmModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;

class UsersModel extends AdmModel
{
    use HasFactory;

    protected $fillable = [
        'login',
        'email',
        'password',
    ];

    protected $table = 'adm_users';

    public function get($params = array())
    {
        $ret = parent::get($params);
        if (isset($params['id']) && $params['id']) {
            $ret->password = '';
        }
        return $ret;
    }

    public function insert($data)
    {
        $data['password'] = Hash::make($data['password']);
        return parent::insert($data);
    }

    public function update($id = [], $data = [])
    {
        if ($data['password']) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        parent::update($id, $data);
    }
}
