<?php

namespace App\Models\Adm;

use App\Models\Adm\AdmModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class GalleryModel extends AdmModel
{
    use HasFactory;

    protected $table = 'site_general_gallery';

    public $timestamps = false;

    public function update($id = [], $data = [])
    {
        $table = decrypt($data['table']);
        $value = $data['value'];
        $oldValue = $data['oldValue'];
        $name = $data['name'];
        $folder = $data['folder'];
        $id = $data['moduleId'];
        $isGallery = $data['isGallery'];
        $foreignId = decrypt($data['foreignKey']);
        $isLang = $data['isLang'];
        $language = $data['language'];

        if ($value == 'undefined') {
            $value = null;
        }

        try {
            if ($isGallery && $foreignId) {
                if ($value) {
                    DB::table($table)->where($foreignId, $id)->where('image', $oldValue)->update([
                        'image' => $value
                    ]);
                    DB::table('site_general_gallery')->where('title', $oldValue)->update([
                        'title' => $value
                    ]);
                } else {
                    DB::table($table)->where($foreignId, $id)->where('image', $oldValue)->delete();
                    DB::table('site_general_gallery')->where('title', $oldValue)->delete();
                }

                return true;
            }

            if ($isLang && $foreignId) {
                if ($value) {
                    DB::table($table)->where($foreignId, $id)->where([$name => $oldValue, 'id_language' => $language])->update([
                        $name => $value
                    ]);
                    DB::table('site_general_gallery')->where('title', $oldValue)->update([
                        'title' => $value
                    ]);
                } else {
                    DB::table($table)->where($foreignId, $id)->where([$name => $oldValue, 'id_language' => $language])->update([
                        $name => $value
                    ]);
                    DB::table('site_general_gallery')->where('title', $oldValue)->delete();
                }

                return true;
            }


            DB::table($table)->where('id', $id)->update([
                $name => $value
            ]);
            DB::table('site_general_gallery')->where('title', $oldValue)->update([
                'title' => $value
            ]);

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public static function insertInGeneralGallery($data)
    {
        DB::table('site_general_gallery')->insert($data);
        return $data;
    }
}
