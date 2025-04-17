<?php

return [
    'required' => 'Das Feld :attribute ist erforderlich.',
    'image' => 'Das Feld :attribute muss ein Bild sein.',
    'mimes' => 'Das Feld :attribute muss eine Datei vom Typ :values sein.',
    'in' => 'Der ausgewählte Wert für :attribute ist ungültig.',
    'email' => ':attribute muss eine gültige E-Mail-Adresse sein.',
    'string' => ':attribute muss eine Zeichenkette sein.',
    'max' => [
        'string' => ':attribute darf nicht länger als :max Zeichen sein.',
    ],

    'testimonial' => [
        'name_required' => 'Der Name ist erforderlich.',
        'name_string' => 'Der Name muss eine Zeichenkette sein.',
        'name_max' => 'Der Name darf maximal 255 Zeichen lang sein.',

        'message_required' => 'Die Nachricht ist erforderlich.',
        'message_string' => 'Die Nachricht muss eine Zeichenkette sein.',

        'rating_required' => 'Die Bewertung ist erforderlich.',
        'rating_integer' => 'Die Bewertung muss eine ganze Zahl sein.',
        'rating_between' => 'Die Bewertung muss zwischen 1 und 5 liegen.',

        'status_required' => 'Der Status ist erforderlich.',
        'status_in' => 'Der ausgewählte Status ist ungültig.',

        'image_image' => 'Die Datei muss ein Bild sein.',
        'image_mimes' => 'Das Bild muss ein Dateityp sein: jpeg, png, jpg, webp.',
        'image_max' => 'Das Bild darf nicht größer als 2 MB sein.',
    ],
];
