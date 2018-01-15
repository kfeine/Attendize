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

    'accepted'             => 'Ce champ doit être accepté.',
    'active_url'           => "Ce champ n'est pas une adresse valide.",
    'after'                => 'Ce champ doit être un date après :date.',
    'alpha'                => 'Ce champ doit contenir uniquement des lettres.',
    'alpha_dash'           => 'Ce champ doit contenir uniquement des lettres, chiffres et tirets.',
    'alpha_num'            => 'Ce champ doit contenir uniquement des lettres et chiffres.',
    'array'                => 'Ce champ doit être un tableau.',
    'before'               => 'Ce champ doit être un date avant :date.',
    'between'              => [
        'numeric' => 'Ce champt doit être entre :min et :max.',
        'file'    => 'Ce champt doit être entre :min et :max kilobytes.',
        'string'  => 'Ce champt doit être entre :min et :max characters.',
        'array'   => 'Ce champt doit avoir entre :min et :max lignes.',
    ],
    'boolean'              => 'Ce champ doit être activé ou désactivé.',
    'confirmed'            => "Ce champ n'est pas correct.",
    'date'                 => "Ce champ n'est pas une date valide.",
    'date_format'          => "Ce champ n'est pas une date correcte (:format).",
    'different'            => 'Ce champ et :other doivent être différents.',
    'digits'               => 'Ce champ doit contenir :digits chiffres.',
    'digits_between'       => 'Ce champ doit contenir entre :min et :max chiffres.',
    'email'                => 'Ce champ doit être une adresse email valide.',
    'filled'               => 'Le champ ce champ est requis.',
    'exists'               => 'La sélection sur ce champ est incorrecte.',
    'image'                => 'Ce champ doit être une image.',
    'in'                   => 'La sélection sur ce champ est incorrecte.',
    'integer'              => 'Ce champ doit être un nombre.',
    'ip'                   => 'Ce champ doit être une adresse IP valide.',
    'max'                  => [
        'numeric' => 'Ce champ doit être inférieur à :max.',
        'file'    => 'Ce champ doit être inférieur à :max ko.',
        'string'  => 'Ce champ doit être inférieur à :max caractères.',
        'array'   => 'Ce champ doit contenir moins de :max lignes.',
    ],
    'mimes'                => 'Ce champ doit être du type :values.',
    'min'                  => [
        'numeric' => "Ce champ doit être d'au moins :min.",
        'file'    => 'Ce champ doit être supérieur à :min ko.',
        'string'  => 'Ce champ doit être supérieur à :min caractères.',
        'array'   => 'Ce champ doit contenir au moins :min lignes.',
    ],
    'not_in'               => 'Ce champ est invalide.',
    'numeric'              => 'Ce champ doit être un nombre.',
    'regex'                => 'Le format de ce champ est invalide.',
    'required'             => 'Ce champ est requis.',
    'required_if'          => 'Ce champ est requis quand :other contient :value.',
    'required_with'        => 'Ce champ est requis quand :values est présent.',
    'required_with_all'    => 'Ce champ est requis quand :values est présent.',
    'required_without'     => "Ce champ est requis quand :values n'est pas présent.",
    'required_without_all' => "Ce champ est requis quand :values ne sont pas présent.",
    'same'                 => 'Ce champ et :other ne correspondent pas.',
    'size'                 => [
        'numeric' => 'Ce champ doit être à :size.',
        'file'    => 'Ce champ doit être à :size ko.',
        'string'  => 'Ce champ doit être à :size caractères.',
        'array'   => 'Ce champ doit contenir :size lignes.',
    ],
    'unique'               => 'Ce champ est déjà pris.',
    'url'                  => 'Ce champ a un format incorrect.',
    'timezone'             => 'Ce champ doit être un fuseau horaire valide.',

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
        'terms_agreed' => [
            'required' => 'Veuillez accepter les conditions de service.'
        ]
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
