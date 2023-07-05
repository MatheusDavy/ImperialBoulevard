<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as ValidationValidator;

class ModuleValidation
{

    public static function moduleValidation(Request $request, array $fields): void
    {
        $rules = array();
        $messages = array();
        $attributes = array();

        foreach ($fields as $k => $tab) {
            foreach ($tab as $key => $input) {
                $required = isset($input['required']) && $input['required'];
                $multilang = isset($input['multilanguage']) && $input['multilanguage'];
                $customRules = isset($input['customRules']) && $input['customRules'];
                if ($required) {
                    if ($multilang) {
                        list($rules, $messages) = ModuleValidation::validateMultilangRequired($input);
                    } else {
                        list($rules, $messages) = ModuleValidation::validateRequired($input);
                    }
                } 
                
                if(!$required && $customRules) {
                    if ($multilang) {
                        list($rules, $attributes) = ModuleValidation::validateMultilang($input);
                    }
                    if(!$multilang) {
                        list($rules, $attributes) = ModuleValidation::validate($input);
                    }
                }
            }
        }

        
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        if ($validator->fails()) {
            $json['message'] = implode("\n", $validator->errors()->all());
            echo json_encode($json);
            exit;
        }
    }

    private static function validateMultilangRequired($input)
    {
        foreach (config('app.languages') as $l => $lang) {
            $name = 'language.' . $input['name'] . '.' . $l;
            if (isset($input['customRules']) && $input['customRules']) {
                $rules[$name] = 'required|' . $input['customRules'];
                $messages [
                    $name . '.required'
                ] = 'Preencha o campo "' . $input['title'] . ' (' . strtoupper($lang) . ')"';
            } else {
                $rules[$name] = 'required';
                $messages [
                    $name . '.required'
                ] = 'Preencha o campo "' . $input['title'] . ' (' . strtoupper($lang) . ')"';
            }
        }

        return [$rules, $messages];
    }

    private static function validateRequired($input)
    {
        if (isset($input['customRules']) && $input['customRules']) {
            $rules[$input['name']] = 'required|' . $input['customRules'];
            $messages[$input['name'] . '.required'] = 'Preencha o campo "' . $input['title'] . '"';
        } else {
            $rules[$input['name']] = 'required';
            $messages[$input['name'] . '.required'] = 'Preencha o campo "' . $input['title'] . '"';
        }

        return [$rules, $messages];
    }

    private static function validateMultilang($input)
    {
        foreach (config('app.languages') as $l => $lang) {
            $name = 'language.' . $input['name'] . '.' . $l;
            $attributes[$name] = $input['title'];
            $rules[$name] = $input['customRules'];
        }

        return [$rules, $attributes];
    }

    private static function validate($input)
    {
        $name = $input['name'];
        $attributes[$name] = $input['title'];
        $rules[$name] = $input['customRules'];

        return [$rules, $attributes];
    }

}