## Laravel DB translation


## Installation

Require this package in your composer.json and run composer update:

    "xdroidteam/translation": "dev-master"

or run 

    "composer require xdroidteam/translation"

directly.

After updating composer, add the ServiceProvider to the providers array in config/app.php

    'Xdroidteam\Translation\TranslationServiceProvider',

You need to run the migrations for this package.

    $ php artisan vendor:publish --provider="Xdroid\Translation\TranslationServiceProvider" --tag=migrations
    $ php artisan migrate


Routes are added in the ServiceProvider, available at `http://yourdomain.com/translations`
