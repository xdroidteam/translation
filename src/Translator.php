<?php namespace XdroidTeam\Translation;

class Translator extends \Illuminate\Translation\Translator
{
public function get($key, array $replace = [], $locale = null, $fallback = true)
    {
        $app = app();
        $version = $app::VERSION;

        $translationModel =  config('xdroidteam-translation.translation_model', '\XdroidTeam\Translation\Translation');

        if($version >= '6.0') {
            if(preg_match('/^(?![a-z\/_]*?\.[A-Za-z0-9_\.\/%-]*$)/', $key)) {
                $originalKey = $key;
                $key = 'default.' . mb_substr(\Str::snake(preg_replace('/[^A-Za-z0-9\- ]/', '', $key)), 0, 255);
            }
        }

        list($namespace, $group, $item) = $this->parseKey($key);
        // Here we will get the locale that should be used for the language line. If one
        // was not passed, we will use the default locales which was given to us when
        // the translator was instantiated. Then, we can load the lines and return.


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
            if ($item) {
                $model = $translationModel::firstOrNew(['locale' => $locale, 'group' => $group, 'key' => $item]);

                if(!$model->exists) {
                    $model->translation = $originalKey ?? null;
                    $model->save();
                    \Cache::tags('translations_' . env('APP_KEY'))->forget('translations.' . $locale . '.' . $group);

                } else {
                    if($model->translation) {
                        \Cache::tags('translations_' . env('APP_KEY'))->forget('translations.' . $locale . '.' . $group);
                        return $model->translation;
                    }
                }
            }

            return $originalKey ?? $key;
        }
        return $line;
    }
}
