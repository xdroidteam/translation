<?php namespace XdroidTeam\Translation;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\NamespacedItemResolver;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\TranslatorInterface;

class Translator extends \Illuminate\Translation\Translator
{
public function get($key, array $replace = [], $locale = null, $fallback = true)
    {
        $translationModel =  config('xdroidteam-translation.translation_model', '\XdroidTeam\Translation\Translation');

        list($namespace, $group, $item) = $this->parseKey($key);
        // Here we will get the locale that should be used for the language line. If one
        // was not passed, we will use the default locales which was given to us when
        // the translator was instantiated. Then, we can load the lines and return.

        $app = app();
        $version = $app::VERSION;

        if($version >= '5.4'){
            $locales = $fallback ? $this->localeArray($locale) : [$locale ?: $this->locale];
        }else{
            $locales = $fallback ? $this->parseLocale($locale) : [$locale ?: $this->locale];
        }

        foreach ($locales as $locale) {
            $this->load($namespace, $group, $locale);
            $line = $this->getLine(
                $namespace, $group, $locale, $item, $replace
            );
            if (! is_null($line)) {
                break;
            }
        }
        // If the line doesn't exist, we will return back the key which was requested as
        // that will be quick to spot in the UI if language keys are wrong or missing
        // from the application's language files. Otherwise we can return the line.
        if (! isset($line)) {
            if ($item)
               $translationModel::firstOrCreate(['locale' => $locale, 'group' => $group, 'key' => $item]);
            return $key;
        }
        return $line;
    }
}
