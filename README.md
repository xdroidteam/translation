## Laravel DB translation

Change standard Laravel file-based translation to DB.

## Installation

Require this package in your composer.json and run composer update:

    "xdroidteam/translation": "dev-master"

or run 

    composer require xdroidteam/translation

directly.

After updating composer, add the ServiceProvider to the providers array in config/app.php

    'Xdroidteam\Translation\TranslationServiceProvider',

You need to run the migrations for this package.

    $ php artisan vendor:publish --provider="Xdroid\Translation\TranslationServiceProvider" --tag=migrations
    $ php artisan migrate

Add following line to your .env file:

    LANGUAGES=en,hu,de

Deploy css and js files:

    php artisan vendor:publish --tag=xdroid-translation

Import existing language files to DB:

    php artisan translations:import

Or import with override existing records:

    php artisan translations:import --overwrite



Routes are added in the ServiceProvider, available at `http://yourdomain.com/translations`
