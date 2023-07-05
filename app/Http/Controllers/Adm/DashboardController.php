<?php

namespace App\Http\Controllers\Adm;

use Illuminate\Http\Request;

class DashboardController extends AdmController
{
    public function index(Request $request)
    {
        return view('adm.pages.AppDashboard.index', $this->data);
    }
}
