<?php

namespace App\Http\Services;

use App\Models\Adm\AdmModel;

class ModuleCleanUserfiles
{
    private array $fields;
    private AdmModel $model;
    private array $fieldNamesMultilang;
    private array $fieldNames;
    private string $folder;

    public static function cleanUserfiles(array $fields, AdmModel $model)
    {
        $cleanUserfilesInstance = new ModuleCleanUserfiles();
        $cleanUserfilesInstance->setUserfiles($fields, $model);
    }

    public function setUserfiles(array $fields, AdmModel $model)
    {
        $this->setFields($fields);
        $this->setModel($model);
        $this->setFolderAndFieldNamesData();
        $folderAndFolderPathExist = $this->folder && is_dir(config('app.userfiles_path') . $this->folder);
        if ($folderAndFolderPathExist == false) return;

        $files = $this->getFiles();
        $this->deleteImagesNotInModel($files);
    }

    private function setFolderAndFieldNamesData()
    {
        $folder = '';
        $fieldNames = [];
        $fieldNamesMultilang = [];

        foreach ($this->fields as $key => $tab) {
            foreach ($tab as $field) {
                if (in_array($field['type'], array('image', 'file', 'gallery'))) {
                    $folder = $field['folder'];
                    if ($field['type'] !== 'gallery') {
                        if (isset($field['multilanguage']) && $field['multilanguage']) {
                            $fieldNamesMultilang[] = $field['name'];
                        } else {
                            $fieldNames[] = $field['name'];
                        }
                    }
                }
            }
        }

        $this->setFolder($folder);
        $this->setFieldNames($fieldNames);
        $this->setFieldNamesMultilang($fieldNamesMultilang);
    }

    private function getFiles()
    {
        $modelItems = $this->model->query()->get();
        $files = [];

        foreach ($modelItems as $k => $item) {
            $files = $this->getFilesFromFieldName($files, $item);
            $files = $this->getFilesFromFieldNameMultilang($files, $item);
            $files = $this->getFilesFromGallery($item, $files);

            foreach ($files as $key => $value) {
                $files[$key] = $this->getImageSrc($value);
            }
        }

        $files = array_unique($files);

        return $files;
    }

    private function getFilesFromFieldName(array $files, $item)
    {
        foreach ($this->fieldNames as $k => $place) {
            if (isset($item->{$place}) && $item->{$place}) {
                $input = $item->{$place};
                $files[] = $input;
            }
        }

        return $files;
    }

    private function getFilesFromFieldNameMultilang(array $files, $item)
    {
        $currentLang = _session('language');
        foreach ($this->fieldNamesMultilang as $j => $place) {
            foreach (config('app.languages') as $l => $lang) {
                _session('language', $l);
                $inputLang = $item->{$place};
                if (isset($item->language[$l]->{$place}) && $item->language[$l]->{$place}) {
                    $files[] = $item->language[$l]->{$place};
                }

                if (isset($item->{$place}) && $item->{$place}) {
                    $files[] = $inputLang;
                }
            }
        }
        _session('language', $currentLang);

        return $files;
    }

    private function getFilesFromGallery($item, array $files): array
    {
        if (isset($item->gallery)) {
            foreach ($item->gallery as $key => $image) {
                $files[] = $image->image;
            }
        }

        if (isset($item->gallery_room)) {
            foreach ($item->gallery_room as $key => $image) {
                $files[] = $image->image;
            }
        }

        return $files;
    }

    private function getImageSrc($value)
    {
        if (is_string($value) && preg_match('/pt"/', $value) && preg_match('/{/', $value)) {
            $value = json_decode($value);
            if (!isset($value->pt)) {
                $value = json_encode($value);
            }
        }

        if (is_string($value) && preg_match('/src"/', $value)) {
            $value = json_decode($value);
            $value = $value->src;
        }
        
        if (is_object($value)) $value = $value->src;

        if (is_array($value)) $value = $value['src'];

        return $value;
    }

    private function deleteImagesNotInModel(array $files)
    {
        $folder = $this->folder;
        foreach (scandir(config('app.userfiles_path') . $folder) as $key => $file) {
            if (is_file(config('app.userfiles_path') . $folder . '/' . $file) && $file != '.gitignore') {
                if (!in_array($file, $files)) {
                    @unlink(config('app.userfiles_path') . $folder . '/' . $file);
                }
            }
        }
    }

    /**
     * Set the value of fields
     *
     * @return  self
     */ 
    private function setFields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * Set the value of model
     *
     * @return  self
     */ 
    private function setModel(AdmModel $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Set the value of fieldNamesMultilang
     *
     * @return  self
     */ 
    private function setFieldNamesMultilang(array $fieldNamesMultilang)
    {
        $this->fieldNamesMultilang = $fieldNamesMultilang;

        return $this;
    }

    /**
     * Set the value of fieldNames
     *
     * @return  self
     */ 
    private function setFieldNames(array $fieldNames)
    {
        $this->fieldNames = $fieldNames;

        return $this;
    }

    /**
     * Set the value of folder
     *
     * @return  self
     */ 
    private function setFolder(string $folder)
    {
        $this->folder = $folder;

        return $this;
    }
}