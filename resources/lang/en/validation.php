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

    'accepted'             => 'El :attribute debe ser aceptado.',
    'active_url'           => 'El :attribute no es una direción URL valida.',
    'after'                => 'El valor de :attribute debe ser una fecha posterior a :date.',
    'alpha'                => 'El valor de :attribute debe contener unicamente letras.',
    'alpha_dash'           => 'El valor de :attribute sólo puede ser letras, números y guión bajo.',
    'alpha_num'            => 'El valor de :attribute sólo puede ser letras y números.',
    'array'                => 'El valor de :attribute debe ser un array.',
    'before'               => 'El valor de :attribute debe ser una fecha anterior a :date.',
    'between'              => [
        'numeric' => 'The :attribute debe estar entre  :min and :max.',
        'file'    => 'The :attribute debe estar entre :min and :max kilobytes.',
        'string'  => 'The :attribute debe estar entre :min and :max characters.',
        'array'   => 'The :attribute debe estar entre :min and :max items.',
    ],
    'boolean'              => 'El valor del campo :attribute debe ser verdadero o falso.',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'date'                 => 'El valor de :attribute no es una fecha valida.',
    'date_format'          => 'The :attribute no concuerda con el formato :format.',
    'different'            => 'El :attribute y :other deben ser diferentes.',
    'digits'               => 'El valor de :attribute debe contener :digits digitos.',
    'digits_between'       => 'El valor de :attribute debe estar entre :min and :max digits.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'El valor de :attribute debe ser una dirección de correo valida.',
    'exists'               => 'El valor seleccionado :attribute no es válido.',
    'filled'               => 'El campo :attribute es obligatorio.',
    'image'                => 'El campo :attribute debe ser una imagen.',
    'in'                   => 'The selected :attribute is invalid.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'El valor de :attribute debe ser un número entero.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'The :attribute may not be greater than :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'The :attribute must be at least :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'The :attribute must be at least :min characters.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => 'The :attribute must be a number.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => 'El campo :attribute es obligatorio.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'El valor de :attribute debe ser una cadena.',
    'timezone'             => 'El valor de :attribute debe ser una zona valida.',
    'unique'               => 'The :attribute has already been taken.',
    'url'                  => 'The :attribute format is invalid.',

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
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
