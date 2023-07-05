<?php

namespace App\Models\Adm;

use App\Models\Adm\AdmModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class PagesModel extends AdmModel
{
    use HasFactory;

    protected $table = 'adm_pages';

    public $multilanguage;

    public $timestamps = false;

    public function getPages()
    {
        foreach ($this::all() as $key => $item) {
            $itens[$key] = $this->getPage($item->slug);
        }

        return $itens;
    }

    public function getPage($slug)
    {
        $page = $this::firstOrCreate([
            'slug' => $slug
        ]);

        $page = DB::table('adm_pages')
                    ->where('slug', $slug)
                    ->first();

        $page->hasGallery = false;

        $fields = PagesFieldsModel::where('id_page', $page->id)->get();

        foreach ($fields as $key => $field) {
            if ($field->type == 'gallery') {
                $page->hasGallery = true;
            }

            if ($this->multilanguage) {
                $field->language = array();
                foreach (config('app.languages') as $l => $lang) {
                    $field->language[$l] = (object) array();
                    $desc = DB::table('adm_pages_fields_description')
                                ->where('id_field', $field->id)
                                ->where('id_language', $l)
                                ->first();
                    $field->language[$l]->{$field->name} = $desc ? $desc->value : '';
                }
            }
        }

        $page->fields = $fields;

        if ($page->hasGallery) {
            $page->gallery = DB::table('adm_pages_gallery')
                                ->where('id_page', $page->id)
                                ->orderBy('sort_order', 'asc')
                                ->get()
                                ->all();
        }

        return $page;
    }

    public function addField($page, $data)
    {
        DB::table('adm_pages_fields')
            ->insert(array_merge($data, ['id_page' => $page]));
    }

    public function removeField($id)
    {
        DB::table('adm_pages_fields')
            ->where('id', $id)
            ->delete();
    }

    public function save($page = [], $data = [])
    {
        foreach ($data as $id => $field) {
            if ($field['type'] != 'gallery') {
                DB::table('adm_pages_fields')
                    ->where('id', $id)
                    ->update([
                        'value' => $field['value']
                    ]);
                if ($this->multilanguage) {
                    DB::table('adm_pages_fields_description')
                        ->where('id_field', $id)
                        ->delete();
                    foreach ($field['description'] as $key => $desc) {
                        DB::table('adm_pages_fields_description')
                            ->insert($desc);
                    }
                }
            } else {
                $gallery = $field['value'];

                DB::table('adm_pages_gallery')->where('id_page', $page)->delete();

                if (isset($gallery['image']) && is_array($gallery['image'])) {
                    $i = 1;
                    foreach ($gallery['image'] as $k => $img) {
                        DB::table('adm_pages_gallery')->insert(array(
                            'id_page' => $page,
                            'image' => $img,
                            'title' => (isset($gallery['title'][$k]) ? $gallery['title'][$k] : ''),
                            'highlighted' => (isset($gallery['highlighted'][$k]) ? $gallery['highlighted'][$k] : '0'),
                            'sort_order' => $i
                        ));
                        $i++;
                    }
                }
            }
        }
    }

    public function getSQL($id)
    {
        $item = DB::table('adm_pages')
                    ->where('id', $id)
                    ->first();
        $item = $this->getPage($item->slug);

        $sql = "DELETE FROM `adm_pages` WHERE slug = '$item->slug';\n";
        $sql .= "INSERT INTO `adm_pages` VALUES(null, '$item->slug');\n";
        $sql .= "SET @id = LAST_INSERT_ID();\n\n";

        foreach ($item->fields as $key => $field) {
            $sql .= "
                INSERT INTO `adm_pages_fields` VALUES(
                    null,
                    @id,
                    '$field->name',
                    '$field->type',
                    '$field->title',
                    $field->half,
                    '$field->value'
                );\n
            ";

            if ($this->multilanguage && in_array($field->type, ['input','text','ckEditor'])) {
                $sql .= "SET @idfield = LAST_INSERT_ID();\n";
                foreach ($field->language as $l => $lang) {
                    $sql .= "
                        INSERT INTO `adm_pages_fields_description` VALUES(
                            null,
                            @idfield,
                            $l,
                            '" . $lang->{$field->name} . "'
                        );\n
                    ";
                }
            }

            $sql .= "\n\n";
        }

        return $sql;
    }
}
