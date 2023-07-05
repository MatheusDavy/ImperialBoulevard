<?php

namespace App\Http\Controllers\Adm\Traits;

trait ListFieldTraits
{
    public function makeListFields(
        ?string $type,
        string $title,
        string $name,
        string $size = 'small',
        ?string $folder = null,
        bool $search = false,
        bool $order = false,
        ?string $source = null
    ) {
        $field = [];

        $field = $this->normalListField($type, $title, $name, $size);

        if ($folder !== null || $search || $order || $source !== null) {
            $field = $this->customListField($field, $folder, $search, $order, $source);
        }

        return $field;
    }

    private function normalListField(?string $type = null, string $title, string $name, string $size): array
    {
        if ($type !== null) {
            return [
                'type' => $type,
                'title' => $title,
                'name' => $name,
                'size' => $size
            ];
        }

        return [
            'title' => $title,
            'name' => $name,
            'size' => $size
        ];
    }

    private function customListField(array $field, ?string $folder, bool $search, bool $order, ?string $source): array
    {
        if ($folder !== null) {
            $field['folder'] = $folder;
            $field['search'] = $search;
            $field['order'] = $order;

            return $field;
        }

        if ($source !== null) {
            $field['source'] = $source;
            $field['search'] = $search;
            $field['order'] = $order;

            return $field;
        }

        if ($folder !== null && $source !== null) {
            $field['folder'] = $folder;
            $field['source'] = $source;
            $field['search'] = $search;
            $field['order'] = $order;

            return $field;
        }

        $field['search'] = $search;
        $field['order'] = $order;

        return $field;
    }
}
