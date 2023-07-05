<?php

namespace App\Models\Adm\BlogModule;

use App\Models\Adm\AdmModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuthorsModel extends AdmModel
{
    use HasFactory;

    protected $table = 'site_blog_authors';
    public $timestamps = false;
}
