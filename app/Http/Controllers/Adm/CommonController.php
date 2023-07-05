<?php

namespace App\Http\Controllers\Adm;

use Illuminate\Http\Request;
use App\Models\Adm\LoginModel;
use Intervention\Image\ImageManager;

class CommonController
{
    public function upload(Request $request)
    {
        $json = array('status' => false);
        $type = $request->input('type') == 'image' ? 'image' : 'file';
        $folder = $request->input('folder');
        $widthImage = intval($request->input('image_width'));
        $heightImage = intval($request->input('image_height'));
        $maxSize = 1024 * 1024 * 4;
        $imageTypes = array('png', 'jpg', 'jpeg', 'webp', 'svg', 'gif');
        $path = getPublicPath() . config('app.userfiles_path');
        if ($type == 'image') {
            $maxSize = 1024 * 1024 * 4;
        }
        if ($type == 'file') {
            $maxSize = 1024 * 1024 * 50;
        }

        $user = $request->user();

        if (!$user) {
            $json['message'] = 'Login expirado';
        } else {
            if ($request->hasFile('file') && $request->file('file')->isValid()) {
                $file = $request->file('file');
                list($width, $height) = getimagesize($file);
                if ($file->getsize() < $maxSize) {
                    $ext = strtolower($file->getClientOriginalExtension());
                    if ($type != 'image' || in_array($ext, $imageTypes)) {
                        if (!is_dir($path . $folder)) {
                            mkdir($path . $folder, 0777, true);
                            $f = fopen($path . $folder . '/.gitignore', 'w');
                            fwrite($f, "*\n!.gitignore");
                            fclose($f);
                        }
                        if ($type == 'image') {
                            $finalExt = 'webp';
                            if ($ext == 'svg') {
                                $finalExt = 'svg';
                            }

                            $fileName = slug(substr($file->getClientOriginalName(), 0, strrpos($file->getClientOriginalName(), ".")));
                            $fileName = $fileName . "-" . $height . "px-" . $width . "px";
                            $fileName = $fileName . '.' . $finalExt;
                        } else {
                            $fileName = slug(substr($file->getClientOriginalName(), 0, strrpos($file->getClientOriginalName(), "."))) . '.' . $ext;
                        }

                        $file->move($path . $folder, $fileName);
                        $url = url($path . $folder . '/' . $fileName);

                        $fullFile = $path . $folder . '/' . $fileName;
                        $json['alert'] = false;
                        // dd($widthImage, $width);
                        if ($widthImage && $heightImage) {
                            if ($widthImage !== $width || $heightImage !== $heightImage) {
                                $json['alert'] = "Resolução incorreta! Enviada: $width px $height px | Necessária: $widthImage px $heightImage px";
                            }
                        }
                        if ($type == 'image') {
                            if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg') {
                                $fullFile = $path . $folder . '/' . $fileName;
                                $url = $this->convertPng($fullFile);
                            }
                        }

                        $json['status'] =  true;
                        $json['message'] = "Arquivo enviado! Dimensões: $width | $height";
                        $json['file_original_name'] = $file->getClientOriginalName();
                        $json['file_url'] = $url;
                        $json['file'] = $fileName;
                        if ($type == 'image') {
                            $json['resized'] = resize('userfiles/' . $folder . '/' . $fileName, 200, 200);
                            $json['croped'] = resize('userfiles/' . $folder . '/' . $fileName, 200, 200, 'crop');
                        }
                    } else {
                        $json['message'] = 'Extensão não permitida!';
                    }
                } else {
                    $json['message'] = 'Arquivo maior que o permitido (' . ((int)($maxSize / 1024 / 1024)) . ' mb).';
                }
            } else {
                $json['message'] = $request->file('file')->getErrorMessage();
            }
        }

        echo json_encode($json);
    }

    public function password(Request $request)
    {
        $model = new LoginModel();

        $pas = $request->input('password');
        $rep = $request->input('confirm');
        $json = array('status' => false);

        $user = $request->user();
        if ($user) {
            $error = $this->testPassword($pas);
            if ($error) {
                $json['message'] = $error;
                echo json_encode($json);
                exit;
            }
        }
        if (!$user) {
            $json['message'] = 'Login expirado';
        } elseif ($pas != $rep) {
            $json['message'] = 'As senhas não conferem';
        } elseif ($this->testPassword($pas)) {
            $json['message'] = 'A senha deve conter no mínimo 8 caracteres';
        } else {
            $model->changePassword($user->id, $pas);
            $json['status'] = true;
            $json['message'] = 'Senha Alterada';
            $json['timeout'] = 1500;
            $json['redirect'] = route('adm.dash');
        }

        echo json_encode($json);
    }

    private function testPassword($password)
    {
        // Validate password strength
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
        $error = false;
        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
            $error = "Atenção! Você precisa cadastrar uma senha forte, ela deve incluir: no mínimo 8 caracteres; pelo menos uma letra maiúscula; pelo menos um número (0-9); pelo menos um caractere especial (!@#$%^*)";
        }

        return $error;
    }

    public function convertPng($fullFile)
    {
        $manager = new ImageManager();

        $img = $manager->make($fullFile);
        $qualidade = 90;
        $img->save($fullFile, $qualidade, 'webp');
        $return = url($fullFile);

        return $return;
    }

    public function cropModal()
    {
        return view('adm.components.cropModal')->render();
    }

}
