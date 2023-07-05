<?php

namespace App\Models\Adm\BlogModule;

use App\Models\Adm\AdmModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NewsModel extends AdmModel
{
    use HasFactory;

    protected $table = 'site_news';

    public $timestamps = false;

    protected $galleryTable = 'site_news_gallery';

    protected $foreignKey = 'id_new';

    protected $customSelect = 'date as regular_date, date_format(date, "%d/%m/%Y") as date';

    public static function getPostDetail($slug)
    {
        $today = NewsModel::getTodayDate();
        $post = NewsModel::where('slug', $slug)
                    ->where('status', 1)
                    ->where('date', '<=', $today)
                    ->first();

        if(!$post) abort(404);

        return $post;
    }

    public static function getPostDraft($hash)
    {
        $today = NewsModel::getTodayDate();
        $post = NewsModel::where('hash', $hash)
                    ->where('status', 1)
                    ->where('date', '<=', $today)
                    ->first();

        if(!$post) abort(404);

        return $post;
    }

    public static function getTodayDate()
    {
        return  Carbon::now()->toDateString();
    }
}
