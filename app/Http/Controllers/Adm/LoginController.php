<?php

namespace App\Http\Controllers\Adm;

use Illuminate\Http\Request;
use App\Models\Adm\LoginModel;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use stdClass;

class LoginController extends AdmController
{
    public $request;
    public $model;

    public function __construct()
    {
        parent::__construct();

        $this->model = new LoginModel();
    }

    public function index(Request $request)
    {
        $this->request = $request;

        if ($request->user()) {
            return redirect()->route('adm.dash');
        }

        if ($request->ajax()) {
            $this->login($request);
            return;
        }

        return view('auth.login');
    }

    public function loginUser(Request $request)
    {
        $this->request = $request;
        $json = new stdClass();
        $json->errors = [];

        $emailFilter = filter_var($request->email, FILTER_SANITIZE_EMAIL);
        $this->testEmail($emailFilter, $json);

        $user = User::where(['email' => $request->email, 'status' => 1])->first();
        if (!$user) {
            return false;
        }

        if ($user && Hash::check($request->password, $user->password)) {
            $user->permissions = LoginModel::getPermissions($user->id_group);

            return $user;
        }

    }

    public function logout(Request $request)
    {
        session(['login' => false]);
        return redirect()->route('login');
    }

    private function testEmail(string $email, $json): bool
    {
        // Remove os caracteres ilegais, caso tenha
        $emailFilter = filter_var($email, FILTER_VALIDATE_EMAIL);
        $error = false;
        // Valida o e-mail
        if ($emailFilter) {
            $error = false;
        } else {
            http_response_code(422);
            $json->errors[] = "Formato do email '$email' está incorreto";
            echo json_encode($json);
            exit;
        }

        return $error;
    }

}
