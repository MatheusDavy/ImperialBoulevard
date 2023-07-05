<?php

namespace App\Http\Controllers\Adm\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserTokenController extends Controller
{

    public function createToken(Request $request)
    {
        $user = $request->user();

        try {
            $user->createToken('user-token', ['role:admin'])->plainTextToken;
            $json = ['token' => 'token enviado com sucesso'];
            echo json_encode($json);
            exit;
        } catch (\Throwable $th) {
            http_response_code(422);
            exit;
        }

    }

}