<?php

namespace App\Http\Controllers\Adm\Traits;

trait FieldsTraits
{
    public function makeFields(
        ?string $type,
        ?string $title,
        string $name,
        bool $required = false,
        ?string $folder = null,
        bool $half = false,
        ?string $source = null,
        ?string $fieldString = null,
        bool $upload_images = false,
        ?string $customRules = null,
        bool $multilanguage = false,
        ?array $imageResolution = null
    ) {

        $args = [
            $type, $title, $name, $required, $folder, $half, $source, $fieldString, 
            $upload_images, $customRules, $multilanguage, $imageResolution
        ];

        $field = $this->commonField($args);

        return $field;
    }

    public function customFields(?string $type, ?string $title, string $name, array $custom = [])
    {
        if ($type) $field['type'] = $type;

        if ($title) $field['title'] = $title;
        
        $field['name'] = $name;

        foreach ($custom as $key => $value) {
            $field[$key] = $value;
        }

        return $field;
    }

    private function commonField(array $args): array
    {
        list(
            $type, $title, $name, $required, $folder, $half, $source, $fieldString, 
            $upload_images, $customRules, $multilanguage, $imageResolution
        ) = $args;

        $field = [
            'name' => $name,
            'required' => $required,
            'half' => $half
        ];

        if ($type) $field['type'] = $type;

        if ($title) $field['title'] = $title;

        if ($folder) $field['folder'] = $folder;

        if ($source) $field['source'] = $source;

        if ($fieldString) $field['field'] = $fieldString;

        if ($upload_images) $field['upload_images'] = $upload_images;

        if ($customRules) $field['customRules'] = $customRules;

        if ($multilanguage) $field['multilanguage'] = $multilanguage;

        if ($imageResolution) $field['imageResolution'] = $imageResolution;

        return $field;
    }

    public function textField(
        ?string $type,
        ?string $title,
        string $name,
        bool $required = false,
        bool $half = false,
        ?string $customRules = null, 
        array $custom = []
    ) {
        $field = [
            'name' => $name,
            'required' => $required,
            'half' => $half,
        ];

        if ($type !== null) {
            $field['type'] = $type;
        }

        if ($title !== null) {
            $field['title'] = $title;
        }

        if ($customRules) {
            $field['customRules'] = $customRules;
        }

        foreach ($custom as $key => $value) {
            $field[$key] = $value;
        }

        return $field;
    }

    public function ckEditorField(
        ?string $title,
        string $name,
        bool $required = false,
        bool $half = false,
        ?string $folder = null,
        ?string $customRules = null,
        array $custom = []
    ) {
        $field = [
            'name' => $name,
            'required' => $required,
            'type' => 'ckEditor',
            'half' => $half,
            'simpleCk' => false,
        ];

        if ($title) {
            $field['title'] = $title;
        }

        if ($folder) {
            $field['folder'] = $folder;
            $field['upload_images'] = true;
        }

        if ($customRules) {
            $field['customRules'] = $customRules;
        }

        foreach ($custom as $key => $value) {
            $field[$key] = $value;
        }

        return $field;
    }

    public function ckEditorSimpleField(
        ?string $title,
        string $name,
        bool $required = false,
        bool $half = false,
        ?string $folder = null,
        ?string $customRules = null,
        array $custom = []
    ) {
        $field = [
            'name' => $name,
            'required' => $required,
            'type' => 'ckEditor',
            'half' => $half,
            'simpleCk' => true,
        ];

        if ($title) {
            $field['title'] = $title;
        }

        if ($folder) {
            $field['folder'] = $folder;
            $field['upload_images'] = true;
        }

        if ($customRules) {
            $field['customRules'] = $customRules;
        }

        foreach ($custom as $key => $value) {
            $field[$key] = $value;
        }

        return $field;
    }

    public function textFieldMultilang(
        ?string $type,
        ?string $title,
        string $name,
        bool $required = false,
        bool $half = false,
        ?string $customRules = null, 
        array $custom = []
    ) {
        $field = [
            'name' => $name,
            'required' => $required,
            'multilanguage' => true,
            'half' => $half,
        ];

        if ($type !== null) {
            $field['type'] = $type;
        }

        if ($title !== null) {
            $field['title'] = $title;
        }

        if ($customRules) {
            $field['customRules'] = $customRules;
        }
        
        foreach ($custom as $key => $value) {
            $field[$key] = $value;
        }

        return $field;
    }

    public function ckEditorFieldMultilang(
        ?string $title,
        string $name,
        bool $required = false,
        bool $half = false,
        ?string $folder = null,
        ?string $customRules = null,
        array $custom = []
    ) {
        $field = [
            'name' => $name,
            'required' => $required,
            'type' => 'ckEditor',
            'multilanguage' => true,
            'half' => $half,
            'simpleCk' => false,
        ];

        if ($title) {
            $field['title'] = $title;
        }

        if ($folder) {
            $field['folder'] = $folder;
            $field['upload_images'] = true;
        }

        if ($customRules) {
            $field['customRules'] = $customRules;
        }

        foreach ($custom as $key => $value) {
            $field[$key] = $value;
        }

        return $field;
    }

    public function ckEditorSimpleFieldMultilang(
        ?string $title,
        string $name,
        bool $required = false,
        bool $half = false,
        ?string $folder = null,
        ?string $customRules = null,
        array $custom = []
    ) {
        $field = [
            'name' => $name,
            'required' => $required,
            'type' => 'ckEditor',
            'multilanguage' => true,
            'half' => $half,
            'simpleCk' => true,
        ];

        if ($title) {
            $field['title'] = $title;
        }

        if ($folder) {
            $field['folder'] = $folder;
            $field['upload_images'] = true;
        }

        if ($customRules) {
            $field['customRules'] = $customRules;
        }

        foreach ($custom as $key => $value) {
            $field[$key] = $value;
        }

        return $field;
    }

    public function imageField(
        ?string $title,
        string $name,
        string $folder,
        bool $required = false,
        bool $half = false,
        ?array $imageResolution = null,
        ?string $customRules = null, 
        array $custom = []
    ) {
        $field = [
            'type' => 'image',
            'name' => $name,
            'required' => $required,
            'half' => $half,
            'folder' => $folder
        ];

        if ($title !== null) {
            $field['title'] = $title;
        }

        if ($customRules) {
            $field['customRules'] = $customRules;
        }

        if ($imageResolution !== null) {
            $field['imageResolution'] = $imageResolution;
        }

        foreach ($custom as $key => $value) {
            $field[$key] = $value;
        }

        return $field;
    }

    public function imageFieldMultilang(
        ?string $title,
        string $name,
        string $folder,
        bool $required = false,
        bool $half = false,
        ?array $imageResolution = null,
        ?string $customRules = null, 
        array $custom = []
    ) {
        $field = [
            'type' => 'image',
            'name' => $name,
            'required' => $required,
            'multilanguage' => true,
            'half' => $half,
            'folder' => $folder
        ];

        if ($title !== null) {
            $field['title'] = $title;
        }

        if ($customRules) {
            $field['customRules'] = $customRules;
        }

        if ($imageResolution !== null) {
            $field['imageResolution'] = $imageResolution;
        }

        foreach ($custom as $key => $value) {
            $field[$key] = $value;
        }

        return $field;
    }

    public function selectField(
        string $type,
        ?string $title,
        string $name,
        string $source,
        bool $required = false,
        bool $half = false, 
        array $custom = []
    ) {
        $field = [
            'name' => $name,
            'required' => $required,
            'half' => $half,
            'source' => $source
        ];

        if ($type !== null) {
            $field['type'] = $type;
        }

        if ($title !== null) {
            $field['title'] = $title;
        }

        foreach ($custom as $key => $value) {
            $field[$key] = $value;
        }

        return $field;
    }

    public function multiInputField(
        ?string $title,
        string $name,
        ?string $source = null,
        bool $required = false,
        bool $half = false, 
        array $custom = []
    ) {
        $field = [
            'name' => $name,
            'required' => $required,
            'half' => $half,
            'type' => 'multi-input',
        ];
        
        if ($source !== null) {
            $field['source'] = $source;
        }

        if ($title !== null) {
            $field['title'] = $title;
        }

        foreach ($custom as $key => $value) {
            $field[$key] = $value;
        }

        return $field;
    }

    public function slugField(
        string $name,
        string $fieldString,
    ) {
        $field = [
            'name' => $name,
            'field' => $fieldString,
            'type' => 'slug'
        ];

        return $field;
    }

    public function slugFieldMultilang(
        string $name,
        string $fieldString,
    ) {
        $field = [
            'name' => $name,
            'field' => $fieldString,
            'multilanguage' => true,
            'type' => 'slug'
        ];

        return $field;
    }

    public function dateField(
        ?string $title,
        string $name,
        bool $required = false,
        bool $half = false,
    ) {
        $field = [
            'name' => $name,
            'type' => 'date',
            'required' => $required,
            'half' => $half,
        ];

        if ($title !== null) {
            $field['title'] = $title;
        }

        return $field;
    }

    public function checkField(
        ?string $title,
        string $name,
        bool $required = false,
        bool $half = false,
    ) {
        $field = [
            'name' => $name,
            'type' => 'checkbox',
            'required' => $required,
            'half' => $half,
        ];

        if ($title !== null) {
            $field['title'] = $title;
        }

        return $field;
    }

    public function linkField(
        ?string $title,
        string $name,
        bool $required = false,
        bool $half = false,
    ) {
        $field = [
            'name' => $name,
            'type' => 'link',
            'required' => $required,
            'half' => $half,
        ];

        if ($title !== null) {
            $field['title'] = $title;
        }

        return $field;
    }

    public function galleryField(
        ?string $title,
        string $name,
        string $folder,
        bool $required = false,
        ?array $imageResolution = null,
        ?string $customRules = null
    ) {
        $field = [
            'type' => 'gallery',
            'name' => $name,
            'required' => $required,
            'folder' => $folder
        ];

        if ($title !== null) {
            $field['title'] = $title;
        }

        if ($customRules) {
            $field['customRules'] = $customRules;
        }

        if ($imageResolution !== null) {
            $field['imageResolution'] = $imageResolution;
        }

        return $field;
    }

    public function fileField(
        ?string $title,
        string $name,
        string $folder,
        bool $required = false,
        bool $half = false,
    ) {
        $field = [
            'type' => 'file',
            'name' => $name,
            'required' => $required,
            'half' => $half,
            'folder' => $folder,
        ];

        if ($title !== null) $field['title'] = $title;

        return $field;
    }

    public function fileFieldMultiLang(
        ?string $title,
        string $name,
        string $folder,
        bool $required = false,
        bool $half = false,
    ) {
        $field = [
            'type' => 'file',
            'name' => $name,
            'required' => $required,
            'half' => $half,
            'folder' => $folder,
            'multilanguage' => true,
        ];

        if ($title !== null) $field['title'] = $title;

        return $field;
    }
    
    public function customField(array $custom = []) 
    {

        foreach ($custom as $key => $value) {
            $field[$key] = $value;
        }

        return $field;
    }
}
