<?php

namespace App\Models\Adm;

use App\Models\Adm\AdmModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactsModel extends AdmModel
{
    use HasFactory;

    protected $table = 'site_contacts';

    public $timestamps = false;

    protected $casts = [
        'created' => 'datetime:d-m-Y H:i:s'
    ];
    protected $customSelect = '
        created as regular_date,
        date_format(created, "%d/%m/%Y") as
        date, date_format(created, "%d/%m/%y %H:%i") as datef
    ';

    public function get($params = array())
    {
        $ret = parent::get($params);

        if (is_array($ret)) {
            usort($ret, function ($ret1, $ret2) {
                return $ret1->regular_date < $ret2->regular_date;
            });
        }

        return $ret;
    }
}
