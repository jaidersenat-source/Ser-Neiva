<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Versiones actuales de documentos de consentimiento
    |--------------------------------------------------------------------------
    | Al actualizar un documento, incrementar la versión correspondiente.
    | Esto forzará a los usuarios a aceptar los nuevos términos en el
    | próximo inicio de sesión.
    */

    'privacy_policy' => [
        'version' => '1.0',
        'title'   => 'Política de Tratamiento y Protección de Datos Personales',
    ],

    'terms_conditions' => [
        'version' => '1.0',
        'title'   => 'Términos y Condiciones del Sistema',
    ],

    /*
    | Versión del consentimiento en el formulario público de registro.
    */
    'registration' => [
        'version' => '1.0',
    ],
];
