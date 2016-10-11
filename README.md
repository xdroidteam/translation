# Laravel DB Translation
[![MIT licensed](https://img.shields.io/badge/license-MIT-blue.svg)](http://choosealicense.com/licenses/mit/)


### Change the standard Laravel file-based translation to DB based.
### Key features
1. Easy GUI for modifying translations
2. The new keys will be **automatically added** to the DB
3. It can easily import **lang** files to the DB
4. Translation is stored in the **cache**, and editing it automatically refreshes the cache from DB. We use cache tags, so regular file or database cache drivers doesn't work, please use **memcached** instead.

![Screenshot](https://raw.githubusercontent.com/xdroidteam/images/master/translationUI.png)

## Installation

Require this package in your **composer.json** and run composer update:

    "xdroidteam/translation": "1.1.4"

**or run**
```shell
composer require xdroidteam/translation
```
directly.


<br>
After updating composer, add the ServiceProvider to the providers array in **config/app.php**
```php
'XdroidTeam\Translation\TranslationServiceProvider',
```
<br>
Deploy config, migration, css and js files.
```shell
php artisan vendor:publish --tag=xdroidteam-translation
```
You need to run the migrations for this package.
```shell
php artisan migrate
```
<br>
Add following line to your **.env** file:
```
LANGUAGES=en,hu,de
```
<br>
Import existing language files to DB:
```shell
php artisan translations:import
```
or import with override existing records:
```shell
php artisan translations:import --overwrite
```
<br>
Routes are added in the ServiceProvider, available at `http://yourdomain.com/translations`

You can change the route prefix in the deployed config file `config/xdroidteam-translation.php`. Also you can modify the middleware or exclude translation groups (excluded groups will not appear on the GUI). See the example below. 
```php
<?php

return array(

    'route' => [
        'prefix' => 'custom-translations-route',
        'middleware' => [
            'web',
            'auth',
            'custom middleware',
        ],
    ],

	'exclude_groups' => ['auth', 'base'],
);

```
