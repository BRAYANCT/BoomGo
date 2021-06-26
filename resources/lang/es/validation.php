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
	'not_exists'         => 'Seleccione el campo :attribute .',
	'not_selected'         => 'Seleccione el campo :attribute .',
	'alpha_spaces'         => 'El campo :attribute solo puede contener letras y espacio.',
    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'El campo :attribute debe ser una fecha posterior a :date.',
    'after_or_equal'       => 'El campo  :attribute debe ser una fecha igual o posterior a :date.',
    'alpha'                => 'El campo :attribute solo puede contener letras.',
    'alpha_dash'           => 'El campo :attribute solo puede contener letras, números y guiones.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'El campo :attribute debe tener múltiples valores.',
    'before'               => 'El campo :attribute debe ser una fecha anterior a :date.',
    'before_or_equal'      => 'El campo :attribute debe ser una fecha igual o anterior a :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'El campo :attribute debe ser verdadero o falso.',
    'confirmed'            => 'El campo :attribute y su confirmación no coinciden.',
    'date'                 => 'El campo :attribute no tiene un fecha válida.',
    'date_format'          => 'El campo :attribute no coincide con el formato :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'El campo :attribute debe tener entre :min a :max dígitos.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'El campo :attribute no tiene el formato correcto.',
    'exists'               => 'El valor del campo :attribute es inválido.',
    'file'                 => 'El campo :attribute debe ser un archivo.',
    'filled'               => 'El campo :attribute debe tener un valor.',
    'image'                => 'El campo :attribute debe ser una imagen.',
    'in'                   => 'El valor del campo :attribute es inválido.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'El campo :attribute debe ser un número entero.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'El campo :attribute no puede ser mayor a :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'El campo :attribute debe tener como máximo :max caractéres.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'El campo :attribute debe ser un archivo con extensión :values.',
    'mimetypes'            => 'El campo :attribute debe ser un archivo con extensión :values.',
    'min'                  => [
        'numeric' => 'El campo :attribute no puede ser menor a :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'El campo :attribute debe tener como mínimo :min caractéres.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => 'El campo :attribute debe ser un número.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'El campo :attribute tiene un formato incorrecto.',
    'required'             => 'El campo :attribute es necesario.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'El campo :attribute es necesario cuando el campo :values está presente.',
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
    'string'               => 'El campo :attribute debe ser texto.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'El campo :attribute ya se encuentra registrado en el sistema.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'El campo :attribute tiene un formato inválido.',

    'lt'                   => [
        'numeric' => 'El campo :attribute debe ser menor a :value.',
        'file'    => 'El campo :attribute debe ser menor a :value kilobytes.',
        'string'  => 'El campo :attribute debe ser menor a :value caracteres.',
        'array'   => 'El campo :attribute puede tener hasta :value elementos.',
    ],
    'lte'                   => [
        'numeric' => 'El campo :attribute debe ser menor o igual a :value.',
        'file'    => 'El campo :attribute debe ser menor o igual a :value kilobytes.',
        'string'  => 'El campo :attribute debe ser menor o igual a :value caracteres.',
        'array'   => 'El campo :attribute no puede tener más de :value elementos.',
    ],

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

    'attributes' => [

        'user_state_id' => 'estado usuario',
        'role_id' => 'rol',
        'user_id' => 'usuario',
        'category_type_id' => 'tipo de categoría',
        'category_id' => 'categoría',
        'parent_id' => 'padre',
        'provider_types_id' => 'tipo de proveedor',
        'business_id' => 'negocio',
        'categories_id' => 'categorías',
        'product_id' => 'producto',
        'price_range_id' => 'rango de precio',

        'password_confirmar'=> 'Confirme su nuevo password',

        'username' => 'usuario',
        'names' => 'nombres',
        'surnames' => 'apellidos',

        'name' => 'nombre',
        'address' => 'dirección',
        'latitude' => 'latitud',
        'longitude' => 'longitud',
        'description' => 'descripción',
        'phone' => 'teléfono',
        'catalog_link'=> 'link de catálogo',

        'score' => 'puntaje',
        'commentary' => 'comentario',

        'price'=> 'precio',
        'offer_price'=> 'precio de oferta',
        'offer_start_date'=> 'inicio de oferta',
        'offer_end_date'=> 'fin de oferta',
        'offer_date_range' => 'rango de fechas de oferta',
        'short_description' => 'descripción corta',

        'shipping_type' => 'envíos por',
        'department_id'=> 'departamento',
        'province_id'=> 'provincia',
        'district_id'=> 'distrito',
        'payment_method_id' => 'método de pago',

        'observation' => 'observación',
        'instructions' => 'instrucciones',

        'document_type_id' => 'doc. identidad',
        'identification_document'=> 'número de documento',
        'claim_type'=> 'tipo',
        'related_claim' => 'relacionado a',
        'detail_claims' => 'detalle del reclamo',
        'client_request' => 'pedido del cliente',

        'images' => 'imagenes',
        'logo_object'=>'logo',
        'picture_object'=>'imagen',
        'image_gallery' => 'galería de imágenes',
        'password' => 'contraseña',

    ],
    'values' => [
        'offer_start_date' => [
            // or tomorrow
            'today' => 'hoy',
            'tomorrow' => 'mañana'
        ]
    ]

];
