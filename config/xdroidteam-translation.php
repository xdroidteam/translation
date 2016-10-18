<?php

return array(

    'route' => [
        'prefix' => 'translations',
        'middleware' => [
            'web',
            'auth',
        ],
    ],

	'exclude_groups' => [],

    'translation_model' => '\XdroidTeam\Translation\Translation',

);
