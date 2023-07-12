<?php

namespace App\Http\Controllers\Site;

use App\Models\Adm\CompaniesModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormsController extends SiteController
{
    public function contactForm(Request $request)
    {
        $gRecaptchaResponse = $request->input('gRecaptchaResponse');
        $error = $this->testRecaptchaResponse($gRecaptchaResponse);
        if ($error) {
            $json['txt'] = $error;
            $json['status'] = false;
            echo json_encode($json);
            exit;
        }

        $dados = array();
        $dt = Carbon::now('UTC')->addHour(-3)->format('Y-m-d h:i:s');

        $dados['name'] = $request->input('name');
        $dados['email'] = $request->input('email');
        $dados['phone'] = $request->input('phone');
        $dados['message'] = $request->input('message');
        $dados['created'] = $dt;

        $json['status'] = false;
        $json['txt'] = "Email já existe";

        $json['status'] = true;
        $json['txt'] = "Sucesso!";
        try {
            DB::table('site_contacts')->insert($dados);
            $body = [];
            $body[] = "Nome: " . $dados['name'];
            $body[] = "E-mail: " . $dados['email'];
            $body[] = "Telefone: " . $dados['phone'];
            $body[] = "Mensagem: " . $dados['message'];
            
            $to = $dados['email'];
            
            if (env('APP_ENV') == 'production') {
                $to = [$dados['email'], 'contato@boulevardconvention.com.br'];
            }
            newSendMail([
                'to' => $to,
                'body' => $body,
                'from' => $this->data['main_title'],
                'subject' => $this->data['main_title'] . ' - ' . 'Contato',
            ]);
        } catch (\Throwable $th) {
            logger($th);
            $json['status'] = false;
            $json['txt'] = "Algo deu errado";
        }

        echo json_encode($json);
        exit;
    }

    private function testRecaptchaResponse($gRecaptchaResponse)
    {
        $error = false;
        if (env("HOMOLOG") == true) {
            return false;
        }
        if (isset($gRecaptchaResponse) && !empty($gRecaptchaResponse)) {
            $secret = CompaniesModel::first()->recaptcha_secret;
            $verifyResponse = file_get_contents(
                'https://www.google.com/recaptcha/api/siteverify?secret=' .
                $secret . '&response=' . $gRecaptchaResponse . '&remoteip=' . getIp()
            );

            $responseData = json_decode($verifyResponse);
            if (!$responseData->success) {
                $error = 'Falha na verificação do robô, recarregue a página e tente novamente.1';
            }
            if (isset($responseData->score) && $responseData->score <= 0.4) {
                $error = 'Falha na verificação do robô, recarregue a página e tente novamente.2';
            }
        } else {
            $error = 'Falha na verificação do robô, recarregue a página e tente novamente.3';
        }

        return $error;
    }
}
