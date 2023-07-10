<?php

use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;
use Intervention\Image\ImageManager;
use App\Http\Controllers\Site\Page404Controller;
use App\Http\Services\ImageService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Request;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Str;
use App\Mail\Form;
use App\Models\Adm\CompaniesModel;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

if (!function_exists('explodeLines')) {
    function explodeLines(Collection|null $linesItens) {
        if (!$linesItens) return '';
        $lines = [];
        foreach ($linesItens as $key => $line) {
            $lineRoute = route('site.linesDetail', $line->slug);
            $lines[$line->id] = "<a href='$lineRoute'> $line->title </a>";
        }

        return implode(', ', $lines);
    }
}

if (!function_exists('returnInstaceOrNull')) {
    function returnInstaceOrNull($object, $attribute) {
        if (!$object || !isset($object->$attribute)) {
            return '';
        }

        return $object->$attribute;
    }
}

if (!function_exists('treatCommaSeparator')) {
    function treatCommaSeparator(null|string $string) {
        if (!$string) {
            return '';
        }
        $string = explode(',', $string);
        $string = implode(', ', $string);
        return $string;
    }
}

if (!function_exists('convertYoutubeLink')) {
    function convertYoutubeLink($link) {
        return preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i","https://www.youtube.com/embed/$1", $link);
    }
}

if (!function_exists('getIP')) {
    function getIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
    }
}

if (!function_exists('ignoreTags')) {

    function ignoreTags($str, $replace = ['</p><p>'], $tags=['<br>'], $let = '<br>, <strong>, <span>, <b>')
    {
        $str = strip_tags(str_replace($replace, $tags, $str), [$let]);
        return $str;
    }

}

if (!function_exists('capitalUnaccent')) {

    function capitalUnaccent($str)
    {
        $str = ucwords(strtolower(unaccent($str)));
        return $str;
    }

}

if (!function_exists('cleanString')) {

    function cleanString($string)
    {
        if (is_string($string)) {
            return addslashes(strip_tags($string));
        }

        return $string;
    }
}

if (!function_exists('show_404')) {
    function show_404()
    {
        http_response_code(404);
        $page404Controller = new Page404Controller();
        echo $page404Controller->index();
        exit;
    }
}

if (!function_exists('show_500')) {

    function show_500()
    {
        abort(500);
    }

}

if (!function_exists('insertMiddleOfPost')) {
    function insertMiddleOfPost($content, $insert)
    {
        $words = str_word_count($content) / 2;
        $content = explode(' ', $content);
        $content[$words] = $content[$words] . " " . $insert . " ";
        $content = implode(" ", $content);

        return $content;
    }
}

if (!function_exists('readTime')) {
    function readTime($content)
    {
        $wordsPerMinute = 238;
        $words = str_word_count(strip_tags($content));

        return floor(($words / $wordsPerMinute));
    }
}

if (!function_exists('formatDate')) {
    function formatDate(string $date)
    {
        setlocale(LC_TIME, 'ptb');
        date_default_timezone_set('America/Sao_Paulo');

        $dia = ucwords(strftime('%d', strtotime($date)));
        $mes = ucwords(strftime('%m', strtotime($date)));
        $ano = ucwords(strftime('%Y', strtotime($date)));
        $meses = meses();
        $mes = $meses[$mes];
        $data = $dia . " . " . $mes;
        return $data;
    }
}
if (!function_exists('meses')) {
    function meses()
    {
        $meses['01'] = 'Janeiro';
        $meses['02'] = 'Fevereiro';
        $meses['03'] = 'Março';
        $meses['04'] = 'Abril';
        $meses['05'] = 'Maio';
        $meses['06'] = 'Junho';
        $meses['07'] = 'Julho';
        $meses['08'] = 'Agosto';
        $meses['09'] = 'Setembro';
        $meses['10'] = 'Outubro';
        $meses['11'] = 'Novembro';
        $meses['12'] = 'Dezembro';
        return $meses;
    }
}
if (!function_exists('formatDateDiaMes')) {
    function formatDateDiaMes(string $date)
    {
        setlocale(LC_TIME, 'ptb');
        date_default_timezone_set('America/Sao_Paulo');
        $dia = ucwords(strftime('%d', strtotime($date)));
        $mes = ucwords(strftime('%m', strtotime($date)));
        $ano = ucwords(strftime('%Y', strtotime($date)));
        $data = "$dia/$mes/$ano";
        return $data;
    }
}

if (!function_exists('lang')) {
    require_once('Libraries/gettext/gettext.inc');
    function lang($data)
    {
        $data = __($data);
        return $data;
    }
}

if (!function_exists('checkMobile')) {
    function checkMobile() {
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
            return true;
        } else {
            return false;
        }
    }
}


if (!function_exists('checkIOS')) {
    function checkIOS() {
        $iPod = strpos($_SERVER['HTTP_USER_AGENT'], "iPod");
        $iPhone = strpos($_SERVER['HTTP_USER_AGENT'], "iPhone");
        $iPad = strpos($_SERVER['HTTP_USER_AGENT'], "iPad");
        return ($iPod !== false || $iPad !== false || $iPhone !== false);
    }
}

if (!function_exists('modelTranslate')) {
    function modelTranslate($data, $locale = null)
    {
        if (!is_string($data)) $data = json_encode($data);

        if (preg_match('/pt/', $data)) {
            $decode = json_decode($data);
            if (isset($decode->pt)) {
                if (!$locale) {
                    return $decode->pt;
                }
                return $decode->$locale;
            }
        }

        if ($data == 'null') {
            return '';
        }

        return $data;
    }
}

if (!function_exists('decodeImageJson')) {
    function decodeImageJson($data, $locale = null, $getSource = false)
    {
        return ImageService::decodeImageJson($data, $locale, $getSource);
    }
}

if (!function_exists('_session')) {
    function _session($key, $val = null)
    {
        if (!is_array($key)) {
            if (is_null($val)) {
                return isset($_SESSION[$key]) ? $_SESSION[$key] : false;
            } else {
                $_SESSION[$key] = $val;
            }
        } else {
            foreach ($key as $k => $v) {
                $_SESSION[$k] = $v;
            }
        }
    }
}

if (!function_exists('get_youtube_id')) {
    function get_youtube_id($link)
    {
        preg_match(
            "#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#",
            $link,
            $matches
        );

        return isset($matches[0]) ? $matches[0] : '';
    }
}

if (!function_exists('character_limiter')) {
    function character_limiter($str, $size, $end = '...')
    {
        if (mb_strlen($str) > $size) {
            $str = mb_substr($str, 0, ($size - 1)) . $end;
        }
        return $str;
    }
}

if (!function_exists('get_filesize')) {
    function get_filesize($path, $unit = 'mb')
    {
        if (file_exists($path)) {
            $s = filesize($path);
            $s = $s / 1024; //kb
            if ($s >= 1024) {
                $size = $s / 1024;
                $size = number_format($size, 2, ',', '');
                $unit = 'mb';
            } else {
                $size = floor($s);
                $unit = 'kb';
            }
            return $size . $unit;
        } else {
            return '0mb';
        }
    }
}

if (!function_exists('slug')) {
    function slug($str = '', $table = false, $column = 'slug', $where = array(), $sep = '-')
    {
        $str = mb_strtolower($str);
        $str = explode(' ', $str);
        foreach ($str as $key => $pt) {
            if (!trim($pt)) {
                unset($str[$key]);
            }
        }
        $str = implode($sep, $str);
        $foreign_characters = config('app.foreign_chars');
        $str = preg_replace(array_keys($foreign_characters), array_values($foreign_characters), $str);
        $str = mb_strtolower($str);
        $str = preg_replace('/[^a-zA-Z0-9-_]/', '', $str);
        if ($table) {
            $unique = false;
            $count = 1;
            $slug = $str;
            while (!$unique) {
                $w = array_merge($where, array($column => $str));
                $item = DB::table($table)->where($w)->first();
                if ($item) {
                    $str = $slug . $sep . $count;
                    $count++;
                } else {
                    $unique = true;
                }
            }
        }
        return $str;
    }
}

if (! function_exists('assetJson')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool|null  $secure
     * @return string
     */
    function assetJson($path, $secure = null)
    {
        return ImageService::assetJson($path, $secure);
    }
}

if (!function_exists('imgSrcJson')) {
    function imgSrcJson($path) {
        return ImageService::imgSrcJson($path);
    }
}

if (!function_exists('imgAltJson')) {
    function imgAltJson($file) {
        return ImageService::imgAltJson($file);
    }
}

if (!function_exists('imgTitleJson')) {
    function imgTitleJson($file) {
        return ImageService::imgTitleJson($file);
    }
}

if (!function_exists('supportWebp')) {
    function supportWebp(): bool
    {
        return ImageService::supportWebp();
    }
}

if (!function_exists('getPublicPath')) {
    function getPublicPath()
    {
        $publicPath = "public/";
        if (Str::contains(Request::getUri(), 'public')) {
            $publicPath = "";
        }

        if (env('APP_ENV') == 'local') {
            $publicPath = "";
        }

        return $publicPath;
    }
}

if (!function_exists('resize')) {
    function resize($src, $w = 100, $h = 100, $method = '', $quality = 85)
    {
        return ImageService::resize($src, $w, $h, $method, $quality);
    }
}

if (!function_exists('send_email')) {
    function send_email($params = array())
    {
        $default = array(
            'subject' => 'Novo e-mail',
            'from' => '',
            'to' => '',
            'reply' => array(),
            'body' => array(),
            'files' => array()
        );

        $params = (object) array_merge($default, $params);

        $config = DB::table('adm_companies')->where('id', '1')->first();

        $mail = new PHPMailer(true);

        $host = $config->mail_host;

        try {
            $mail->SMTPDebug = 0; /*2 to debug*/
            $mail->isSMTP();
            $mail->isHTML(true);
            $mail->Host = $config->mail_host;
            $mail->SMTPAuth = true;
            $mail->Username = $config->mail_user;
            $mail->Password = $config->mail_pass;
            $mail->Port = $config->mail_port;
            $mail->CharSet = "UTF-8";
            $mail->SMTPSecure = 'tls';

            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $mail->Subject = $params->subject;
            $mail->setFrom($config->mail_from, $params->from);

            if (is_array($params->to)) {
                foreach ($params->to as $to) {
                    $mail->addAddress($to);
                }
            } else {
                $mail->addAddress($params->to);
            }

            if ($params->reply) {
                $mail->addReplyTo($params->reply[0], $params->reply[1]);
            }

            if ($params->files) {
                foreach ($params->files as $key => $file) {
                    if (is_numeric($key)) {
                        $mail->addAttachment($file);
                    } else {
                        $mail->addAttachment($file, $key);
                    }
                }
            }

            // $mail->addAttachment('adm/img/logo-email.png', 'logo-email.png');

            $mail->Body = (string)view('adm.pages.AppCommon.email', ['body' => $params->body]);
            $mail->AltBody = (string)view('adm.pages.AppCommon.email', ['body' => $params->body,'textmode' => true]);

            $mail->send();

            return true;
        } catch (Exception $e) {
            return $mail->ErrorInfo;
        }
    }
}

if (! function_exists('newSendMail')) {
    function newSendMail($params = array())
    {
        $empresa = CompaniesModel::first();
        Config::set(['mail.mailers.smtp.transport' => 'smtp']);
        Config::set(['mail.mailers.smtp.host' => str_replace('tls://', '', $empresa->mail_host)]);
        Config::set(['mail.mailers.smtp.port' => $empresa->mail_port]);
        Config::set(['mail.mailers.smtp.username' => $empresa->mail_user]);
        Config::set(['mail.mailers.smtp.password' => $empresa->mail_pass]);
        Config::set(['mail.mailers.smtp.encryption' => 'tls']);
        Mail::to($params['to'])->send(
            new Form($params['body'], $params['subject'], $params['from']));
    }
}

if (! function_exists('checkFileExists')) {
    function checkFileExists($folder, $file)
    {
        return is_file(config('app.userfiles_path') . $folder . '/' . $file);
    }
}

if (! function_exists('unaccent')) {
    function unaccent($str)
    {
        $transliteration = array(
        'Ĳ' => 'I', 'Ö' => 'O','Œ' => 'O','Ü' => 'U','ä' => 'a','æ' => 'a',
        'ĳ' => 'i','ö' => 'o','œ' => 'o','ü' => 'u','ß' => 's','ſ' => 's',
        'À' => 'A','Á' => 'A','Â' => 'A','Ã' => 'A','Ä' => 'A','Å' => 'A',
        'Æ' => 'A','Ā' => 'A','Ą' => 'A','Ă' => 'A','Ç' => 'C','Ć' => 'C',
        'Č' => 'C','Ĉ' => 'C','Ċ' => 'C','Ď' => 'D','Đ' => 'D','È' => 'E',
        'É' => 'E','Ê' => 'E','Ë' => 'E','Ē' => 'E','Ę' => 'E','Ě' => 'E',
        'Ĕ' => 'E','Ė' => 'E','Ĝ' => 'G','Ğ' => 'G','Ġ' => 'G','Ģ' => 'G',
        'Ĥ' => 'H','Ħ' => 'H','Ì' => 'I','Í' => 'I','Î' => 'I','Ï' => 'I',
        'Ī' => 'I','Ĩ' => 'I','Ĭ' => 'I','Į' => 'I','İ' => 'I','Ĵ' => 'J',
        'Ķ' => 'K','Ľ' => 'K','Ĺ' => 'K','Ļ' => 'K','Ŀ' => 'K','Ł' => 'L',
        'Ñ' => 'N','Ń' => 'N','Ň' => 'N','Ņ' => 'N','Ŋ' => 'N','Ò' => 'O',
        'Ó' => 'O','Ô' => 'O','Õ' => 'O','Ø' => 'O','Ō' => 'O','Ő' => 'O',
        'Ŏ' => 'O','Ŕ' => 'R','Ř' => 'R','Ŗ' => 'R','Ś' => 'S','Ş' => 'S',
        'Ŝ' => 'S','Ș' => 'S','Š' => 'S','Ť' => 'T','Ţ' => 'T','Ŧ' => 'T',
        'Ț' => 'T','Ù' => 'U','Ú' => 'U','Û' => 'U','Ū' => 'U','Ů' => 'U',
        'Ű' => 'U','Ŭ' => 'U','Ũ' => 'U','Ų' => 'U','Ŵ' => 'W','Ŷ' => 'Y',
        'Ÿ' => 'Y','Ý' => 'Y','Ź' => 'Z','Ż' => 'Z','Ž' => 'Z','à' => 'a',
        'á' => 'a','â' => 'a','ã' => 'a','ā' => 'a','ą' => 'a','ă' => 'a',
        'å' => 'a','ç' => 'c','ć' => 'c','č' => 'c','ĉ' => 'c','ċ' => 'c',
        'ď' => 'd','đ' => 'd','è' => 'e','é' => 'e','ê' => 'e','ë' => 'e',
        'ē' => 'e','ę' => 'e','ě' => 'e','ĕ' => 'e','ė' => 'e','ƒ' => 'f',
        'ĝ' => 'g','ğ' => 'g','ġ' => 'g','ģ' => 'g','ĥ' => 'h','ħ' => 'h',
        'ì' => 'i','í' => 'i','î' => 'i','ï' => 'i','ī' => 'i','ĩ' => 'i',
        'ĭ' => 'i','į' => 'i','ı' => 'i','ĵ' => 'j','ķ' => 'k','ĸ' => 'k',
        'ł' => 'l','ľ' => 'l','ĺ' => 'l','ļ' => 'l','ŀ' => 'l','ñ' => 'n',
        'ń' => 'n','ň' => 'n','ņ' => 'n','ŉ' => 'n','ŋ' => 'n','ò' => 'o',
        'ó' => 'o','ô' => 'o','õ' => 'o','ø' => 'o','ō' => 'o','ő' => 'o',
        'ŏ' => 'o','ŕ' => 'r','ř' => 'r','ŗ' => 'r','ś' => 's','š' => 's',
        'ť' => 't','ù' => 'u','ú' => 'u','û' => 'u','ū' => 'u','ů' => 'u',
        'ű' => 'u','ŭ' => 'u','ũ' => 'u','ų' => 'u','ŵ' => 'w','ÿ' => 'y',
        'ý' => 'y','ŷ' => 'y','ż' => 'z','ź' => 'z','ž' => 'z','Α' => 'A',
        'Ά' => 'A','Ἀ' => 'A','Ἁ' => 'A','Ἂ' => 'A','Ἃ' => 'A','Ἄ' => 'A',
        'Ἅ' => 'A','Ἆ' => 'A','Ἇ' => 'A','ᾈ' => 'A','ᾉ' => 'A','ᾊ' => 'A',
        'ᾋ' => 'A','ᾌ' => 'A','ᾍ' => 'A','ᾎ' => 'A','ᾏ' => 'A','Ᾰ' => 'A',
        'Ᾱ' => 'A','Ὰ' => 'A','ᾼ' => 'A','Β' => 'B','Γ' => 'G','Δ' => 'D',
        'Ε' => 'E','Έ' => 'E','Ἐ' => 'E','Ἑ' => 'E','Ἒ' => 'E','Ἓ' => 'E',
        'Ἔ' => 'E','Ἕ' => 'E','Ὲ' => 'E','Ζ' => 'Z','Η' => 'I','Ή' => 'I',
        'Ἠ' => 'I','Ἡ' => 'I','Ἢ' => 'I','Ἣ' => 'I','Ἤ' => 'I','Ἥ' => 'I',
        'Ἦ' => 'I','Ἧ' => 'I','ᾘ' => 'I','ᾙ' => 'I','ᾚ' => 'I','ᾛ' => 'I',
        'ᾜ' => 'I','ᾝ' => 'I','ᾞ' => 'I','ᾟ' => 'I','Ὴ' => 'I','ῌ' => 'I',
        'Θ' => 'T','Ι' => 'I','Ί' => 'I','Ϊ' => 'I','Ἰ' => 'I','Ἱ' => 'I',
        'Ἲ' => 'I','Ἳ' => 'I','Ἴ' => 'I','Ἵ' => 'I','Ἶ' => 'I','Ἷ' => 'I',
        'Ῐ' => 'I','Ῑ' => 'I','Ὶ' => 'I','Κ' => 'K','Λ' => 'L','Μ' => 'M',
        'Ν' => 'N','Ξ' => 'K','Ο' => 'O','Ό' => 'O','Ὀ' => 'O','Ὁ' => 'O',
        'Ὂ' => 'O','Ὃ' => 'O','Ὄ' => 'O','Ὅ' => 'O','Ὸ' => 'O','Π' => 'P',
        'Ρ' => 'R','Ῥ' => 'R','Σ' => 'S','Τ' => 'T','Υ' => 'Y','Ύ' => 'Y',
        'Ϋ' => 'Y','Ὑ' => 'Y','Ὓ' => 'Y','Ὕ' => 'Y','Ὗ' => 'Y','Ῠ' => 'Y',
        'Ῡ' => 'Y','Ὺ' => 'Y','Φ' => 'F','Χ' => 'X','Ψ' => 'P','Ω' => 'O',
        'Ώ' => 'O','Ὠ' => 'O','Ὡ' => 'O','Ὢ' => 'O','Ὣ' => 'O','Ὤ' => 'O',
        'Ὥ' => 'O','Ὦ' => 'O','Ὧ' => 'O','ᾨ' => 'O','ᾩ' => 'O','ᾪ' => 'O',
        'ᾫ' => 'O','ᾬ' => 'O','ᾭ' => 'O','ᾮ' => 'O','ᾯ' => 'O','Ὼ' => 'O',
        'ῼ' => 'O','α' => 'a','ά' => 'a','ἀ' => 'a','ἁ' => 'a','ἂ' => 'a',
        'ἃ' => 'a','ἄ' => 'a','ἅ' => 'a','ἆ' => 'a','ἇ' => 'a','ᾀ' => 'a',
        'ᾁ' => 'a','ᾂ' => 'a','ᾃ' => 'a','ᾄ' => 'a','ᾅ' => 'a','ᾆ' => 'a',
        'ᾇ' => 'a','ὰ' => 'a','ᾰ' => 'a','ᾱ' => 'a','ᾲ' => 'a','ᾳ' => 'a',
        'ᾴ' => 'a','ᾶ' => 'a','ᾷ' => 'a','β' => 'b','γ' => 'g','δ' => 'd',
        'ε' => 'e','έ' => 'e','ἐ' => 'e','ἑ' => 'e','ἒ' => 'e','ἓ' => 'e',
        'ἔ' => 'e','ἕ' => 'e','ὲ' => 'e','ζ' => 'z','η' => 'i','ή' => 'i',
        'ἠ' => 'i','ἡ' => 'i','ἢ' => 'i','ἣ' => 'i','ἤ' => 'i','ἥ' => 'i',
        'ἦ' => 'i','ἧ' => 'i','ᾐ' => 'i','ᾑ' => 'i','ᾒ' => 'i','ᾓ' => 'i',
        'ᾔ' => 'i','ᾕ' => 'i','ᾖ' => 'i','ᾗ' => 'i','ὴ' => 'i','ῂ' => 'i',
        'ῃ' => 'i','ῄ' => 'i','ῆ' => 'i','ῇ' => 'i','θ' => 't','ι' => 'i',
        'ί' => 'i','ϊ' => 'i','ΐ' => 'i','ἰ' => 'i','ἱ' => 'i','ἲ' => 'i',
        'ἳ' => 'i','ἴ' => 'i','ἵ' => 'i','ἶ' => 'i','ἷ' => 'i','ὶ' => 'i',
        'ῐ' => 'i','ῑ' => 'i','ῒ' => 'i','ῖ' => 'i','ῗ' => 'i','κ' => 'k',
        'λ' => 'l','μ' => 'm','ν' => 'n','ξ' => 'k','ο' => 'o','ό' => 'o',
        'ὀ' => 'o','ὁ' => 'o','ὂ' => 'o','ὃ' => 'o','ὄ' => 'o','ὅ' => 'o',
        'ὸ' => 'o','π' => 'p','ρ' => 'r','ῤ' => 'r','ῥ' => 'r','σ' => 's',
        'ς' => 's','τ' => 't','υ' => 'y','ύ' => 'y','ϋ' => 'y','ΰ' => 'y',
        'ὐ' => 'y','ὑ' => 'y','ὒ' => 'y','ὓ' => 'y','ὔ' => 'y','ὕ' => 'y',
        'ὖ' => 'y','ὗ' => 'y','ὺ' => 'y','ῠ' => 'y','ῡ' => 'y','ῢ' => 'y',
        'ῦ' => 'y','ῧ' => 'y','φ' => 'f','χ' => 'x','ψ' => 'p','ω' => 'o',
        'ώ' => 'o','ὠ' => 'o','ὡ' => 'o','ὢ' => 'o','ὣ' => 'o','ὤ' => 'o',
        'ὥ' => 'o','ὦ' => 'o','ὧ' => 'o','ᾠ' => 'o','ᾡ' => 'o','ᾢ' => 'o',
        'ᾣ' => 'o','ᾤ' => 'o','ᾥ' => 'o','ᾦ' => 'o','ᾧ' => 'o','ὼ' => 'o',
        'ῲ' => 'o','ῳ' => 'o','ῴ' => 'o','ῶ' => 'o','ῷ' => 'o','А' => 'A',
        'Б' => 'B','В' => 'V','Г' => 'G','Д' => 'D','Е' => 'E','Ё' => 'E',
        'Ж' => 'Z','З' => 'Z','И' => 'I','Й' => 'I','К' => 'K','Л' => 'L',
        'М' => 'M','Н' => 'N','О' => 'O','П' => 'P','Р' => 'R','С' => 'S',
        'Т' => 'T','У' => 'U','Ф' => 'F','Х' => 'K','Ц' => 'T','Ч' => 'C',
        'Ш' => 'S','Щ' => 'S','Ы' => 'Y','Э' => 'E','Ю' => 'Y','Я' => 'Y',
        'а' => 'A','б' => 'B','в' => 'V','г' => 'G','д' => 'D','е' => 'E',
        'ё' => 'E','ж' => 'Z','з' => 'Z','и' => 'I','й' => 'I','к' => 'K',
        'л' => 'L','м' => 'M','н' => 'N','о' => 'O','п' => 'P','р' => 'R',
        'с' => 'S','т' => 'T','у' => 'U','ф' => 'F','х' => 'K','ц' => 'T',
        'ч' => 'C','ш' => 'S','щ' => 'S','ы' => 'Y','э' => 'E','ю' => 'Y',
        'я' => 'Y','ð' => 'd','Ð' => 'D','þ' => 't','Þ' => 'T','ა' => 'a',
        'ბ' => 'b','გ' => 'g','დ' => 'd','ე' => 'e','ვ' => 'v','ზ' => 'z',
        'თ' => 't','ი' => 'i','კ' => 'k','ლ' => 'l','მ' => 'm','ნ' => 'n',
        'ო' => 'o','პ' => 'p','ჟ' => 'z','რ' => 'r','ს' => 's','ტ' => 't',
        'უ' => 'u','ფ' => 'p','ქ' => 'k','ღ' => 'g','ყ' => 'q','შ' => 's',
        'ჩ' => 'c','ც' => 't','ძ' => 'd','წ' => 't','ჭ' => 'c','ხ' => 'k',
        'ჯ' => 'j','ჰ' => 'h'
        );
        $str = str_replace(
            array_keys($transliteration),
            array_values($transliteration),
            $str
        );
        return $str;
    }
}
