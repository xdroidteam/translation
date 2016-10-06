<?php namespace Xdroid\Translation;

use Cache;
use Illuminate\Translation\FileLoader;
use Xdroid\Translation\Translation;

class TranslationLoader extends FileLoader
{
    /**
     * Load the messages for the given locale.
     *
     * @param string $locale
     * @param string $group
     * @param string $namespace
     *
     * @return array
     */
    public function load($locale, $group, $namespace = null)
    {
        // Cache::tags('translations_' . env('APP_KEY'))->forget('translations.' . $locale . '.' . $group);
        $keys = Cache::tags('translations_' . env('APP_KEY'))->rememberForever('translations.' . $locale . '.' . $group, function() use($locale, $group){
            return Translation::where('locale', '=', $locale)->where('group', '=', $group)->lists('translation', 'key')->all();
        });
        return $keys;
    }
}
