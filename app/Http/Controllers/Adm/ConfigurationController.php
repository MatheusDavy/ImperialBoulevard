<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;

class ConfigurationController extends Controller
{
    public function index()
    {
        return view('adm.pages.AppConfig.index');
    }
}
