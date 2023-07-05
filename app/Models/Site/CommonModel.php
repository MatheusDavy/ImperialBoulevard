<?php

namespace App\Models\Site;

use App\Models\Adm\SeoModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class CommonModel
{
    use HasFactory;

    public function getSeo($slug)
    {
        return SeoModel::where('slug', $slug)->first();
    }

    public function getCompany($id)
    {
        $q = DB::table('adm_companies')
                ->where('id', $id);

        return $q->first();
    }

    public function getPage($slug)
    {
        $return = (object)array();

        $item = DB::table('adm_pages')->where('slug', $slug)->first();

        $fields = DB::table('adm_pages_fields')->where('id_page', $item->id)->get()->all();

        foreach ($fields as $key => $field) {
            if ($field->type == 'gallery') {
                $return->gallery = DB::table('adm_pages_gallery')->where('id_page', $item->id)->orderBy('sort_order', 'asc')->get()->all();
                $high = DB::table('adm_pages_gallery')->where('id_page', $item->id)->orderByRaw('highlighted desc, sort_order asc')->first();
                $return->galleryHighlighted = $high ? $high->image : '';
            } else {
                $return->{$field->name} = $field->value;
            }
        }

        return $return;
    }
}
