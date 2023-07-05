<?php

namespace App\Http\Services;

use Intervention\Image\ImageManager;

class ImageService
{
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool|null  $secure
     * @return string
     */
    public static function assetJson($path, $secure = null)
    {
        $path = imgSrcJson($path);
        $imageArr = explode('/', $path);
        $hasImageInArr = false;
        foreach ($imageArr as $key => $image) {
            if (preg_match('/\./', $image)) {
                $hasImageInArr = true;
            }
        }

        if (!$hasImageInArr) {
            return asset('site/img/placeholder.webp');
        }
        return asset($path, $secure);
    }

    public static function resize($src, $w = 100, $h = 100, $method = '', $quality = 85)
    {
        if (is_array($src)) {
            $src = imgSrcJson($src);
        }
        ini_set('memory_limit', '512M');
        $publicPath = getPublicPath();

        $originalSrc = $src;
        $cache = $publicPath.'userfiles/imagens/';

        $method = in_array($method, array('resize', 'crop', 'canvas')) ? $method : 'resize';
        $w = (int)$w;
        $h = (int)$h;

        if (is_file('public/' . $src)) {
            $src = 'public/' . $src;
        }

        if (!is_file($src)) {
            return assetJson($src);
            $src = $cache . 'error.jpg';
        }

        $name = basename($src);
        $name = explode('.', $name);
        $ext = strtolower(array_pop($name));
        $name = implode('.', $name);

        if (strpos($src, 'http') !== false) {
            $output = $cache;
        } else {
            if ($src == $cache . 'error.jpg') {
                $folder = '';
            } else {
                $folder = explode('/', $src);
                $folder = $folder[(count($folder) - 2)];
                if (!is_dir($cache . $folder)) {
                    mkdir($cache . $folder);
                    $f = fopen($cache . $folder . '/.gitignore', 'w');
                    fwrite($f, "*\n!.gitignore");
                    fclose($f);
                }
            }

            $output = $cache . $folder . ($folder ? '/' : '');
        }

        if (!$method || $method == 'resize') {
            $name = $name . '-' . $w . 'x' . $h . '.' . $ext;
        } elseif ($method == 'crop') {
            $name = $name . '-' . $w . 'x' . $h . '-crop.' . $ext;
        } elseif ($method == 'canvas') {
            $ext = 'png';
            $name = $name . '-' . $w . 'x' . $h . '-canvas.' . $ext;
        }

        $convertExt = null;

        $convertExt = 'webp';
        $name = slug(substr($name, 0, strrpos($name, ".")))  . '.' . $convertExt;

        if (is_file($output . $name)) {
            $return = url($output . $name);
        }

        if (!isset($return)) {
            $manager = new ImageManager();
            try {
                $img = $manager->make($src);
            } catch (\Throwable $th) {
                return assetJson($originalSrc);
            }
            if (!$method || $method == 'resize') {
                if ($img->width() > $w || $img->height() > $h) {
                    $img->resize($w, $h, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                $img->save($output . $name, $quality, $convertExt);
                $return = url($output . $name);
            } elseif ($method == 'crop') {
                if ($img->width() > $img->height()) {
                    $ww = ceil($h * ($img->width() / $img->height()));
                    $ww = ($ww >= $w) ? $ww : $w;
                    $img->widen($ww);
                } else {
                    $hh = ceil($w * ($img->height() / $img->width()));
                    $hh = ($hh >= $h) ? $hh : $h;
                    $img->heighten($hh);
                }
                $img->crop($w, $h);
                $img->save($output . $name, $quality, $convertExt);
                $return = url($output . $name);
            } elseif ($method == 'canvas') {
                if ($img->width() > $w || $img->height() > $h) {
                    $img->resize($w, $h, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                $img->save($output . $name, $quality, $convertExt);

                $resized = imagecreatefrompng($output . $name);
                $tsizes = getimagesize($output . $name);
                $x = ($w / 2 - $tsizes[0] / 2);
                $y = ($h / 2 - $tsizes[1] / 2);

                $img = imagecreatetruecolor($w, $h);
                imagesavealpha($img, true);
                imagefill($img, 0, 0, imagecolorallocatealpha($img, 255, 255, 255, 127));
                imagecopy($img, $resized, $x, $y, 0, 0, $tsizes[0], $tsizes[1]);
                imagepng($img, $output . $name, 9);
                imagedestroy($img);

                $return = url($output . $name);
            }
        }

        return $return;
    }

    public static function imgSrcJson($path)
    {
        if (is_array($path)) {
            $path[1] = str_replace('\\', '', $path[1]);
            $image = json_decode($path[1]);
            if ($image) {
                $path[1] = $image->src;
            }
            $path = $path[0] . $path[1];
        }
        $path = str_replace('\\', '', $path);
        $path = mb_convert_encoding($path, 'utf-8', 'auto');
        $fileArr = explode('/', $path);
        $file = end($fileArr);
        $pathCut = str_replace($file, '', $path);
        if (preg_match('/src/', $pathCut . $file)) {
            $image = json_decode($file);
            if ($image) {
                $file = $image->src;
            } else {
                return asset('site/img/placeholder.webp');
            }
        }
        return $pathCut . $file;
    }

    public static function imgAltJson($file)
    {
        $testJson = $file;
        $file = '';
        if (preg_match('/src/', $testJson)) {
            $testJson = json_decode($testJson);
            $file = $testJson->alt;
        }
        return $file;
    }

    public static function imgTitleJson($file)
    {
        $testJson = $file;
        $file = '';
        if (preg_match('/src/', $testJson)) {
            $testJson = json_decode($testJson);
            $file = $testJson->title;
        }
        return $file;
    }

    public static function decodeImageJson($data, $locale = null, $getSource = false)
    {
        $data = modelTranslate($data, $locale);

        if (!is_string($data)) $data = json_encode($data);

        if (preg_match('/src/', $data) && preg_match('/alt/', $data)) {
            $data = json_decode($data);
        }

        if ($getSource && is_object($data)) {
            return $data->src;
        }

        return $data;
    }

    public static function supportWebp(): bool
    {
        if (env("APP_HOMOLOG")) {
            return true;
        }

        $webSupport = true;
        $gdSupport = false;

        $gdInfo = gd_info();

        if ($gdInfo['WebP Support']) {
            $gdSupport = true;
        }

        if (isset($_SERVER['HTTP_ACCEPT'])) {
            $webSupport = strpos($_SERVER['HTTP_ACCEPT'], 'image/webp') !== false;
        }

        if ($webSupport && $gdSupport) {
            return true;
        }

        return false;
    }

}