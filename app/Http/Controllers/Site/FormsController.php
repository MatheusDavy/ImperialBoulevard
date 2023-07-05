<?php

namespace App\Http\Controllers\Site;

use App\Models\Adm\CompaniesModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormsController extends SiteController
{
    public function newsletterForm(Request $request)
    {
        $gRecaptchaResponse = $request->input('gRecaptchaResponse');
        $error = $this->testRecaptchaResponse($gRecaptchaResponse);
        if ($error) {
            $json['txt'] = $error;
            $json['status'] = false;
            echo json_encode($json);
            exit;
        }

        $email = $request->input('email');
        $name = $request->input('name');
        $checaSeExiste = DB::table('site_newsletters')->where('email', $email)->first();
        $dados = array();
        $dt = Carbon::now('UTC')->addHour(-3)->format('Y-m-d h:i:s');

        $dados['name'] = $name;
        $dados['email'] = $email;
        $dados['created'] = $dt;

        $json['status'] = false;
        $json['txt'] = "Email já existe";

        if ($checaSeExiste == null) {
            $json['status'] = true;
            $json['txt'] = "Sucesso!";
            try {
                DB::table('site_newsletters')->insert($dados);
            } catch (\Throwable $th) {
                logger($th);
                $json['status'] = false;
                $json['txt'] = "Algo deu errado";
            }
        }

        unset($dados['email']);

        echo json_encode($json);
        exit;
    }

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

        $email = $request->input('email');
        $name = $request->input('name');
        $phone = $request->input('phone');
        $subject = $request->input('subject');
        $message = $request->input('message');
        $checaSeExiste = DB::table('site_contacts')->where('email', $email)->first();
        $dados = array();
        $dt = Carbon::now('UTC')->addHour(-3)->format('Y-m-d h:i:s');

        $dados['name'] = $name;
        $dados['email'] = $email;
        $dados['phone'] = $phone;
        $dados['subject'] = $subject;
        $dados['message'] = $message;
        $dados['created'] = $dt;

        $json['status'] = false;
        $json['txt'] = "Email já existe";

        if ($checaSeExiste == null) {
            $json['status'] = true;
            $json['txt'] = "Sucesso!";
            try {
                DB::table('site_contacts')->insert($dados);
            } catch (\Throwable $th) {
                logger($th);
                $json['status'] = false;
                $json['txt'] = "Algo deu errado";
            }
        }

        unset($dados['email']);

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
