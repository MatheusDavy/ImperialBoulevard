<?php

namespace App\Models\Adm\BlogModule;

use App\Models\Adm\AdmModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoriesModel extends AdmModel
{
    use HasFactory;

    protected $table = 'site_blog_categories';

    public $timestamps = false;
}
