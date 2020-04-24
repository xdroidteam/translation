<?php namespace XdroidTeam\Translation;

use Cache;
use Illuminate\Translation\FileLoader;
use Illuminate\Support\Arr;

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
             $translationModel =  config('xdroidteam-translation.translation_model', '\XdroidTeam\Translation\Translation');
             $translations = $translationModel::where('locale', '=', $locale)->where('group', '=', $group)->get();

             $keys = [];
             foreach($translations as $translation){
                 Arr::set($keys, $translation->key, $translation->translation);
             }

             return $keys;
         });
         return $keys;
     }
}
