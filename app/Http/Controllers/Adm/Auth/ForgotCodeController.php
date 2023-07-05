<?php

namespace App\Http\Controllers\Adm\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendTwoFactorCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use stdClass;

class ForgotCodeController extends Controller
{

    public function send(Request $request)
    {
        $email = $request->input('email');
        $json = new stdClass();
        $error = $this->testEmail($email);

        if ($error) {
            $json->message = 'Formato inválido de email';
            echo json_encode($json);
            http_response_code(422);
            exit;
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            $json->message = 'Usuário com email ' . $email . ' não encontrado';
            echo json_encode($json);
            http_response_code(422);
            exit;
        }

        try {
            Mail::to($user)->send(new SendTwoFactorCode($user->recoveryCodes()));
        } catch (\Throwable $th) {
            $json->message = 'Erro ao enviar email';
            echo json_encode($json);
            http_response_code(422);
            exit;
        }

        $json->message = 'Código enviado para email cadastrado.';
        echo json_encode($json);
        http_response_code(200);
        exit;
    }

    private function testEmail(string $email): bool
    {
        // Remove os caracteres ilegais, caso tenha
        $emailFilter = filter_var($email, FILTER_VALIDATE_EMAIL);
        $error = true;
        // Valida o e-mail
        if ($emailFilter) {
            $error = false;
        } 

        return $error;
    }

}