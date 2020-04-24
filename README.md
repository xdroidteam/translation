# Laravel DB Translation
[![MIT licensed](https://img.shields.io/badge/license-MIT-blue.svg)](http://choosealicense.com/licenses/mit/)


### Change the standard Laravel file-based translation to DB based.
### Key features
1. Easy GUI for modifying translations
2. The new keys will be **automatically added** to the DB
3. It can easily import **lang** files to the DB
4. Translation is stored in the **cache**, and editing it automatically refreshes the cache from DB. We use cache tags, so regular file or database cache drivers doesn't work, please use **memcached** instead.
5. It is now showing the **missing tranlations** fields for each language and group. Also you can toogle views between "Show only missing translations" and "Show all translations".
6. Now you can **export database** to .CSV.
![Screenshot](https://raw.githubusercontent.com/xdroidteam/images/master/translationUI.png)

## Installation
### **Below laravel 6.x use version 1.5.x, for Laravel/Lumen 6.x, 7.x use version 2.x**
Require this package in your **composer.json** and run composer update:

    "xdroidteam/translation": "1.5.*"

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
Deploy migration and config file.
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
    
    'translation_model' => '\App\Models\Translation',

);

```
You can use other Translation model, to overwrite methods. For example:

```php
<?php

namespace App\Models;

use XdroidTeam\Translation\Translation as XdroidTranslation;

class Translation extends XdroidTranslation
{
    public static function getLanguages(){
        // original:
        // return explode(',', env('LANGUAGES'));
		
        //custom:
        return ['en', 'hu'];
    }
}

```

## Export
You can export your db to a .CSV file, with call this function:
```php
XdroidTeam\Translation::exportToCSV('path/to/file');
```