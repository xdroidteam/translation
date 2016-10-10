# Laravel DB Translation
[![MIT licensed](https://img.shields.io/badge/license-MIT-blue.svg)](http://choosealicense.com/licenses/mit/)


### Change the standard Laravel file-based translation to DB based.
### Key features
1. Easy GUI for modifying translations
2. The new keys will be **automatically added** to the DB
3. It can easily import **lang** files to the DB

![Screenshot](https://raw.githubusercontent.com/xdroidteam/images/master/translationUI.png)

## Installation

Require this package in your **composer.json** and run composer update:

    "xdroidteam/translation": "dev-master"

**or run**
```shell
composer require xdroidteam/translation
```
directly.


<br>
After updating composer, add the ServiceProvider to the providers array in **config/app.php**
```php
'Xdroidteam\Translation\TranslationServiceProvider',
```
<br>
You need to run the migrations for this package.
```shell
php artisan vendor:publish --provider="Xdroid\Translation\TranslationServiceProvider" --tag=migrations
php artisan migrate
```
<br>
Add following line to your **.env** file:
```
LANGUAGES=en,hu,de
```
<br>
Deploy css and js files:
```shell
php artisan vendor:publish --tag=xdroid-translation
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
