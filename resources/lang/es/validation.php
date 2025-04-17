<?php

return [
    'required' => 'El campo :attribute es obligatorio.',
    'image' => 'El campo :attribute debe ser una imagen.',
    'mimes' => 'El campo :attribute debe ser un archivo de tipo: :values.',
    'in' => 'El valor seleccionado para :attribute no es válido.',
    'email' => ':attribute debe ser una dirección de correo válida.',
    'string' => ':attribute debe ser una cadena de texto.',
    'max' => [
        'string' => ':attribute no puede tener más de :max caracteres.',
    ],

    'testimonial' => [
        'name_required' => 'El nombre es obligatorio.',
        'name_string' => 'El nombre debe ser una cadena de texto.',
        'name_max' => 'El nombre no puede tener más de 255 caracteres.',

        'message_required' => 'El mensaje es obligatorio.',
        'message_string' => 'El mensaje debe ser una cadena de texto.',

        'rating_required' => 'La calificación es obligatoria.',
        'rating_integer' => 'La calificación debe ser un número entero.',
        'rating_between' => 'La calificación debe estar entre 1 y 5.',

        'status_required' => 'El estado es obligatorio.',
        'status_in' => 'El estado seleccionado no es válido.',

        'image_image' => 'El archivo debe ser una imagen.',
        'image_mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, webp.',
        'image_max' => 'La imagen no debe ser mayor a 2 MB.',
    ],
];
