<?php

function fileExample($request)
{
    if ($request->hasFile('file') && $request->file('file')->isValid()) {
        $file = $request->file('file');
        $path = config('app.userfiles_path');
        $maxSize = 1024 * 1024 * 4;
        $folder = 'resume';
        if ($file->getsize() < $maxSize) {
            $ext = strtolower($file->getClientOriginalExtension());
            if (!is_dir($path . $folder)) {
                mkdir($path . $folder, 0777);
                $f = fopen($path . $folder . '/.gitignore', 'w');
                fwrite($f, "*\n!.gitignore");
                fclose($f);
            }

                $fileName = uniqid(time()) . '.' . $ext;
            $dados['resume'] = $fileName;
            $file->move($path . $folder, $fileName);
        } else {
            $json['txt'] = 'Arquivo maior que o permitido (' . ((int)($maxSize / 1024 / 1024)) . ' mb).';
        }
    } else {
        $json['txt'] = $request->file('file')->getErrorMessage();
        $json['status'] = false;
    }
}
