<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'O campo :attribute must be accepted.',
    'accepted_if' => 'O campo :attribute must be accepted when :other is :value.',
    'active_url' => 'O campo :attribute is not a valid URL.',
    'after' => 'O campo :attribute must be a date after :date.',
    'after_or_equal' => 'O campo :attribute must be a date after or equal to :date.',
    'alpha' => 'O campo :attribute must only contain letters.',
    'alpha_dash' => 'O campo :attribute must only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'O campo :attribute must only contain letters and numbers.',
    'array' => 'O campo :attribute must be an array.',
    'before' => 'O campo :attribute must be a date before :date.',
    'before_or_equal' => 'O campo :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => 'O campo :attribute must be between :min and :max.',
        'file' => 'O campo :attribute must be between :min and :max kilobytes.',
        'string' => 'O campo :attribute must be between :min and :max characters.',
        'array' => 'O campo :attribute must have between :min and :max items.',
    ],
    'boolean' => 'O campo :attribute must be true or false.',
    'confirmed' => 'O campo :attribute confirmation does not match.',
    'current_password' => 'O campo password is incorrect.',
    'date' => 'O campo :attribute is not a valid date.',
    'date_equals' => 'O campo :attribute must be a date equal to :date.',
    'date_têm formato' => 'O campo :attribute does not match the têm formato :têm formato.',
    'declined' => 'O campo :attribute must be declined.',
    'declined_if' => 'O campo :attribute must be declined when :other is :value.',
    'different' => 'O campo :attribute and :other must be different.',
    'digits' => 'O campo :attribute must be :digits digits.',
    'digits_between' => 'O campo :attribute must be between :min and :max digits.',
    'dimensions' => 'O campo :attribute has invalid image dimensions.',
    'distinct' => 'O campo :attribute has a duplicate value.',
    'email' => 'O campo :attribute must be a valid email address.',
    'ends_with' => 'O campo :attribute must end with one of the following: :values.',
    'enum' => 'O campo selected :attribute é inválido.',
    'exists' => 'O campo selected :attribute é inválido.',
    'file' => 'O campo :attribute must be a file.',
    'filled' => 'O campo :attribute must have a value.',
    'gt' => [
        'numeric' => 'O campo :attribute must be greater than :value.',
        'file' => 'O campo :attribute must be greater than :value kilobytes.',
        'string' => 'O campo :attribute must be greater than :value characters.',
        'array' => 'O campo :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'O campo :attribute must be greater than or equal to :value.',
        'file' => 'O campo :attribute must be greater than or equal to :value kilobytes.',
        'string' => 'O campo :attribute must be greater than or equal to :value characters.',
        'array' => 'O campo :attribute must have :value items or more.',
    ],
    'image' => 'O campo :attribute must be an image.',
    'in' => 'O campo selected :attribute é inválido.',
    'in_array' => 'O campo :attribute does not exist in :other.',
    'integer' => 'O campo :attribute must be an integer.',
    'ip' => 'O campo :attribute must be a valid IP address.',
    'ipv4' => 'O campo :attribute must be a valid IPv4 address.',
    'ipv6' => 'O campo :attribute must be a valid IPv6 address.',
    'json' => 'O campo :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'O campo :attribute must be less than :value.',
        'file' => 'O campo :attribute must be less than :value kilobytes.',
        'string' => 'O campo :attribute must be less than :value characters.',
        'array' => 'O campo :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'O campo :attribute must be less than or equal to :value.',
        'file' => 'O campo :attribute must be less than or equal to :value kilobytes.',
        'string' => 'O campo :attribute must be less than or equal to :value characters.',
        'array' => 'O campo :attribute must not have more than :value items.',
    ],
    'mac_address' => 'O campo :attribute must be a valid MAC address.',
    'max' => [
        'numeric' => 'O campo :attribute must not be greater than :max.',
        'file' => 'O campo :attribute must not be greater than :max kilobytes.',
        'string' => 'O campo :attribute must not be greater than :max characters.',
        'array' => 'O campo :attribute must not have more than :max items.',
    ],
    'mimes' => 'O campo :attribute must be a file of type: :values.',
    'mimetypes' => 'O campo :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'O campo :attribute precisa ter ao menos :min.',
        'file' => 'O campo :attribute precisa ter ao menos :min kilobytes.',
        'string' => 'O campo :attribute precisa ter ao menos :min caracteres.',
        'array' => 'O campo :attribute must have at least :min items.',
    ],
    'multiple_of' => 'O campo :attribute must be a multiple of :value.',
    'not_in' => 'O campo selected :attribute é inválido.',
    'not_regex' => 'O campo :attribute têm formato inválido.',
    'numeric' => 'O campo :attribute must be a number.',
    'password' => 'O campo password is incorrect.',
    'present' => 'O campo :attribute must be present.',
    'prohibited' => 'O campo :attribute is prohibited.',
    'prohibited_if' => 'O campo :attribute is prohibited when :other is :value.',
    'prohibited_unless' => 'O campo :attribute is prohibited unless :other is in :values.',
    'prohibits' => 'O campo :attribute prohibits :other from being present.',
    'regex' => 'O campo :attribute têm formato inválido.',
    'required' => 'O campo :attribute precisa ser preenchido.',
    'required_array_keys' => 'O campo :attribute must contain entries for: :values.',
    'required_if' => 'O campo :attribute precisa ser preenchido when :other is :value.',
    'required_unless' => 'O campo :attribute precisa ser preenchido unless :other is in :values.',
    'required_with' => 'O campo :attribute precisa ser preenchido when :values is present.',
    'required_with_all' => 'O campo :attribute precisa ser preenchido when :values are present.',
    'required_without' => 'O campo :attribute precisa ser preenchido when :values is not present.',
    'required_without_all' => 'O campo :attribute precisa ser preenchido when none of :values are present.',
    'same' => 'O campo :attribute and :other must match.',
    'size' => [
        'numeric' => 'O campo :attribute must be :size.',
        'file' => 'O campo :attribute must be :size kilobytes.',
        'string' => 'O campo :attribute must be :size characters.',
        'array' => 'O campo :attribute must contain :size items.',
    ],
    'starts_with' => 'O campo :attribute must start with one of the following: :values.',
    'string' => 'O campo :attribute must be a string.',
    'timezone' => 'O campo :attribute must be a valid timezone.',
    'unique' => 'O campo :attribute has already been taken.',
    'uploaded' => 'O campo :attribute failed to upload.',
    'url' => 'O campo :attribute must be a valid URL.',
    'uuid' => 'O campo :attribute must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
