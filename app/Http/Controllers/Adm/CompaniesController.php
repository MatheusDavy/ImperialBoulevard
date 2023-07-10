<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Adm\Traits\FieldsTraits;
use Illuminate\Http\Request;
use App\Models\Adm\CompaniesModel;
use Illuminate\Support\Facades\Route as Route;

class CompaniesController extends AdmController
{
    use FieldsTraits;

    public function __construct()
    {
        parent::__construct();
        $this->model = new CompaniesModel();
        $this->title = 'Empresa';
        $this->titlePlural = 'Empresas';
        $this->searchField = 'title';

        $this->fields['Geral'] = array(
            $this->makeFields('input', 'Fone', 'phone', false, null, true),
            $this->makeFields('input', 'E-mail', 'email', false, null, true),
            $this->makeFields(
                'input',
                'E-mails p/ envio<br><small>(separados por ,)</small>',
                'emails'
            ),
            $this->makeFields('input', 'Facebook', 'facebook', false, null, true),
            $this->makeFields('input', 'Instagram', 'instagram', false, null, true),
            $this->makeFields('input', 'Youtube', 'social', false, null, true),
            $this->makeFields('input', 'Google Maps', 'gmaps'),
        );

        $this->fields['Tags'] = array(
            $this->textField('input', 'GTM (id)', 'gtm', false, true),
            $this->textField('input', 'RD Station (src)', 'rd', false, true),
            $this->textField('input', 'Recaptcha (id)', 'recaptcha', false, false),
            $this->textField('input', 'Recaptcha (secret)', 'recaptcha_secret', false, false),
            // $this->textField('input', 'Analytics', 'analytics', false, true),
        );

        $this->fields['Endereço'] = array(
            $this->ckEditorSimpleField('Endereço', 'address'),
            $this->makeFields('position', 'Posição', 'position'),
        );

        $this->fields['E-mail'] = array(
            $this->makeFields('input', 'Host', 'mail_host'),
            $this->makeFields('input', 'Porta', 'mail_port'),
            $this->makeFields('input', 'Usuário', 'mail_user'),
            $this->makeFields('input', 'Senha', 'mail_pass'),
            $this->makeFields('input', 'De<br><small>(endereço de e-mail)</small>', 'mail_from'),
        );
    }

    public function index(Request $request)
    {
        $route = Route::currentRouteName();
        return redirect()->route(str_replace('index', 'update', $route), '1');
    }
}
