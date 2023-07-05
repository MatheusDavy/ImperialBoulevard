<?php

namespace App\Models\Adm;

use App\Http\Services\CacheService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdmModel extends Model
{
    use HasFactory;

    // use ModelTypeTrait;

    protected $table;
    protected $caches = [];
    protected $description;
    protected $foreignKey;
    protected $galleryTable;
    protected $list;
    protected $customSelect = false;
    protected $defaults = [];
    protected $languages;
    protected bool $isMultilang = false;

    public function __construct()
    {
        $this->defaults = [
            'search' => false,
            'status' => false,
            'slug' => false,
            'search_field' => false,
            'select' => false,
            'id' => false,
            'total' => false,
            'sort_order' => false,
            'where' => false,
            'not' => false,
            'offset' => 0,
            'limit' => false,
            'language' => false,
            'debug' => false,
            'latest' => false,
            'destaque' => false,
            'secondary' => false,
            'paginate' => false,
            'like' => false,
            'first' => false,
        ];

        $this->languages = config('app.languages');
    }

    /**
     * get Data using DB Facade for performance
     *
     * @param array $params
     *
     */
    public function get($params = array())
    {
        if (isset($params['cms']) && $params['cms']) {
            foreach ($this->casts as $key => $value) {
                $this->casts[$key] = 'string';
            }
        }
        $params = (object)array_merge($this->defaults, $params);
        $q = $this::addSelect('*');
        //pega custom select do model se tiver
        if ($this->customSelect) {
            $q->addSelect(DB::raw($this->customSelect));
        }
        //pega select se tiver
        if ($params->select) {
            $q->addSelect(DB::raw($params->select));
        }

        $q = $this->addQueryToGet($q);

        if ($params->id) {
            $item = $q->find($params->id);

            if ($this->galleryTable) $item = $this->getGallery($item);

            if ($this->list) $item = $this->getList($item);

            return $item;
        }

        if (!$params->total && $params->limit) {
            $q->offset($params->offset)->limit($params->limit);
        }
        //faz o sort
        if ($params->search && $params->search_field) {
            if (is_array($params->search_field)) {
                foreach ($params->search_field as $key => $field) {
                    $q->orWhere($field, 'like', "%$params->search%");
                }
            } else {
                $q->where($params->search_field, 'like', '%' . $params->search . '%');
            }
        }

        if ($params->sort_order) {
            if (is_array($params->sort_order)) {
                $q->orderBy($params->sort_order[0], $params->sort_order[1]);
            } else {
                $q->orderBy(DB::raw($params->sort_order));
            }
        }

        if ($params->where) {
            if (is_array($params->where)) {
                foreach ($params->where as $key => $w) {
                    if (is_array($w)) {
                        $q->where([$w]);
                    } else {
                        if (is_numeric($key)) {
                            $q->where(DB::raw($w));
                        } else {
                            $q->where($key, $w);
                        }
                    }
                }
            } else {
                $q->where(DB::raw($params->where));
            }
        }

        if ($params->status) {
            $q->where('status', $params->status);
        }

        if ($params->not) {
            $q->where($params->not[0], '<>',[$params->not[1]]);
        }

        if ($params->slug) {
            $q->where('slug', $params->slug);
        }

        if ($params->destaque) {
            $q->where('highlight', 1);
        }

        if ($params->secondary) {
            $q->where('highlight', 0);
        }

        if ($params->like) {
            $q->where($params->like[0], 'like', "%" . $params->like[1] . "%");
        }

        if ($params->latest) {
            if ($params->latest === true) {
                $q->latest('id');
            } else {
                $q->latest("$params->latest");
            }
        }

        if ($params->first) {
            $item = $q->first();
            
            if ($this->galleryTable) $item = $this->getGallery($item);

            if ($this->list) $item = $this->getList($item);

            return $item;
        }

        if ($params->total) {
            $itens = new \stdClass();
            try {
                $itens->total = $q->count();
                return $itens->total;
            } catch (\Throwable $th) {
                $itens->total = 0;
                return $itens->total;
            }
        }

        if ($params->paginate) {
            $itens = $q->paginate($params->paginate);
            $lastPage = $itens->lastPage();
            $previousPage = $itens->previousPageUrl();
            $nextPage = $itens->nextPageUrl();
            $itens = $itens->all();
            if ($itens) {
                $itens[0]->lastPage = $lastPage;
                $itens[0]->previousPage = $previousPage;
                $itens[0]->nextPage = $nextPage;
            }
        } else {
            $itens = $q->get()->all();
        }

        //pega galeria se tiver
        if ($this->galleryTable) {
            foreach ($itens as $key => $item) {
                $item = $this->getGallery($item);
            }
        }

        if ($this->list) {
            foreach ($itens as $key => $item) {
                $item = $this->getList($item);
            }
        }

        $this->addLogicToGet($itens);

        return $itens;
    }

    public function insert(array $data)
    {
        $language = $this->returnLanguageIfExists($data);
        unset($data['language']);
        $gallery = $this->returnGalleryIfExists($data);
        unset($data['gallery']);
        $list = $this->returnListIfExists($data);
        unset($data['list']);

        if (isset($this->isMultilang) && !empty($language)) {
            try {
                $data = array_merge($this->saveLanguage($language), $data);
            } catch (\Throwable $th) {
                throw new \Exception("Erro ao salvar inputs multi-idiomas", 1000);
            }
        }

        if (Schema::hasColumn($this->table, 'created_at')) {
            $data['created_at'] = Carbon::now();
        }

        $id = DB::table($this->table)->insertGetId($data);

        if (isset($this->galleryTable)) {
            $this->saveGalleryImage($gallery, $id, $this->galleryTable);
        }

        if (isset($this->list) && !empty($list)) {
            $this->saveList($list, $id);
        }

        $this->addLogicToInsert($id, $data);

        CacheService::cleanCachesInArray($this->getCaches());

        return $id;
    }

    public function update($id = [], $data = [])
    {
        $language = $this->returnLanguageIfExists($data);
        unset($data['language']);
        $gallery = $this->returnGalleryIfExists($data);
        unset($data['gallery']);
        $list = $this->returnListIfExists($data);
        unset($data['list']);

        if (isset($this->isMultilang) && !empty($language)) {
            try {
                $data = array_merge($this->saveLanguage($language), $data);
            } catch (\Throwable $th) {
                throw new \Exception("Erro ao salvar inputs multi-idiomas", 1000);
            }
        }

        $update = $this->query()->where('id', $id)->update($data);

        if (isset($this->list) && !empty($list)) {
            DB::beginTransaction();
            try {
                DB::table($this->list)->where($this->foreignKey, $id)->delete();
                $this->saveList($list, $id);
            } catch (\Throwable $th) {
                DB::rollBack();
                logger($th);
                throw new \Exception("Erro ao salvar lista", 1001);
            }
            DB::commit();
        }

        if (isset($this->galleryTable) && !empty($gallery)) {
            DB::beginTransaction();
            try {
                DB::table($this->galleryTable)->where($this->foreignKey, $id)->delete();
                $this->saveGalleryImage($gallery, $id, $this->galleryTable);
            } catch (\Throwable $th) {
                DB::rollBack();
                logger($th);
                throw new \Exception("Erro ao salvar galeria", 1002);
            }
            DB::commit();
        }

        CacheService::cleanCachesInArray($this->getCaches());

        return is_int($update);
    }

    public function delete($id = [])
    {
        DB::table($this->table)->where('id', $id)->delete();
        CacheService::cleanCachesInArray($this->getCaches());
    }

    private function saveLanguage(array $language): array
    {
        $langCollection = collect();

        foreach (config('app.languages') as $l => $lang) {
            $langCollection = $langCollection->mergeRecursive($language[$l]);
        }

        foreach ($langCollection as $key => $value) {
            foreach (config('app.languages') as $l => $lang) {
                $json[$lang] = $value[$l - 1];
            }
            $langCollection[$key] = json_encode($json, JSON_UNESCAPED_UNICODE);
            $langCollection[$key] = mb_convert_encoding($langCollection[$key], 'UTF-8');
            $json = [];
        }

        return $langCollection->toArray();
    }

    protected function saveGalleryImage(array $gallery, $id, $table): void
    {
        if (isset($gallery['image']) && is_array($gallery['image'])) {
            $i = 1;
            foreach ($gallery['image'] as $k => $img) {
                $json = [];
                $json['src'] = $gallery['image'][$k];
                $json['alt'] = $gallery['imageAlt'][$k];
                $json['title'] = $gallery['imageTitle'][$k];
                $img = json_encode($json);
                DB::table($table)
                    ->insert(
                        array(
                            $this->foreignKey => $id,
                            'image' => $img,
                            'title' => (
                                isset($gallery['title'][$k]) ? $gallery['title'][$k] : ''
                            ),
                            'highlighted' => (
                                isset($gallery['highlighted'][$k]) ? $gallery['highlighted'][$k] : '0'
                            ),
                            'sort_order' => $i
                        )
                    );
                $i++;
            }
        }
    }

    private function saveList(array $list, $id): void
    {
        foreach ($list['title'] as $k => $value) {
            DB::table($this->list)
                ->insert(
                    array(
                        $this->foreignKey => $id,
                        'title' => (
                            isset($list['title'][$k]) ? $list['title'][$k] : ''
                        ),
                    )
                );
        }
    }

    private function returnLanguageIfExists(array $data): array
    {
        if (isset($data['language']) && $data['language']) {
            if (!is_array($data['language'])) {
                $data['language'] = [$data['language']];
            }
            return $data['language'];
        }

        return array();
    }

    private function returnGalleryIfExists(array $data): array
    {
        if (isset($data['gallery']) && $data['gallery']) {
            return $data['gallery'];
        }

        return array();
    }

    private function returnListIfExists(array $data): array
    {
        if (isset($data['list']) && $data['list']) {
            return $data['list'];
        }

        return array();
    }

    private function getGallery($item)
    {
        $item->gallery = DB::table($this->galleryTable)
                    ->where($this->foreignKey, $item->id)
                    ->orderBy('sort_order', 'asc')->get()->all();

        $item->galleryHighlighted = DB::table($this->galleryTable)
            ->where($this->foreignKey, $item->id)
            ->orderByRaw('highlighted desc, sort_order asc')->get()->first();

        $item->galleryImage = $item->galleryHighlighted ? $item->galleryHighlighted->image : false;

        return $item;
    }

    private function getList($item)
    {
        $item->list = DB::table($this->list)
                        ->where($this->foreignKey, $item->id)
                        ->orderBy('sort_order', 'asc')->get()->all();

        return $item;                        
    }

    /**
     * Caso precise adicionar lógica ao método get()
     */
    protected function addLogicToGet(array $itens): void
    {
    }

    /**
     * Caso precise adicionar query ao método get()
     */
    protected function addQueryToGet($q)
    {
        return $q;
    }

    /**
     * Caso precise adicionar lógica ao método insert()
     */
    protected function addLogicToInsert($id, array $data): void
    {
    }

    /**
     * Caso precise adicionar lógica ao método update()
     */
    protected function addLogicToUpdate($id, array $data): void
    {
    }

    public function changeTableNameForTests(string $table)
    {
        $this->table = $table;
        return $this;
    }

    public function changeGalleryNameForTests(string $gallery)
    {
        $this->galleryTable = $gallery;
        return $this;
    }

    public function changeForeignKeyForTests(string $foreignKey)
    {
        $this->foreignKey = $foreignKey;
        return $this;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function getDescriptionTable()
    {
        return $this->description;
    }

    public function getGalleryTable()
    {
        return $this->galleryTable;
    }

    public function getForeignKey()
    {
        return $this->foreignKey;
    }

    public function getCaches()
    {
        return $this->caches;
    }
}
