<?php namespace XdroidTeam\Translation;

use Illuminate\Support\Str;

class Translator extends \Illuminate\Translation\Translator
{
public function get($key, array $replace = [], $locale = null, $fallback = true)
    {
        $app = app();

        $translationModel =  config('xdroidteam-translation.translation_model', '\XdroidTeam\Translation\Translation');

        if(preg_match('/(?= )/', $key)) {
            $originalKey = $key;
            $key = 'default.' . mb_substr(Str::snake(preg_replace('/[^A-Za-z0-9\- ]/', '', $key)), 0, 255);
        }

        list($namespace, $group, $item) = $this->parseKey($key);
        // Here we will get the locale that should be used for the language line. If one
        // was not passed, we will use the default locales which was given to us when
        // the translator was instantiated. Then, we can load the lines and return.


        $locales = $fallback ? $this->localeArray($locale) : [$locale ?: $this->locale];

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

                    if($translationModel::where(['locale' => $locale, 'group' => $group])->where('key', 'like', $item . '.%')->count() > 0) {
                        \Log::warning('Wrong translation key given, children exist for locale ' . $locale . ' ' . $group . '.' . $item);
                        \DebugBar::warning('Wrong translation key given, children exist for locale ' . $locale . ' ' . $group . '.' . $item);

                        return "Wrong key for: " . $item;
                    }

                    $model->save();
                }
                
                $trans = $model->translation ?? $originalKey ?? $key;

                $transArray = array_merge(\Cache::tags('translations_' . env('APP_KEY'))->get('translations.' . $locale . '.' . $group, []), [$item => $trans]);
                \Cache::tags('translations_' . env('APP_KEY'))->put('translations.' . $locale . '.' . $group , $transArray);
            }

            if($translationModel::isTranslationDebugEnabled() && $translationModel::isTranslationDebugVerbose()) {
                return $group . '.' . $item . ': ' . ($trans ?? $originalKey ?? $key);
            } else {
                return $trans ?? $originalKey ?? $key;
            }
        }
        if($translationModel::isTranslationDebugEnabled() && $translationModel::isTranslationDebugVerbose()) {
            return $this->getWithKeys($group, $item, $line);
        } else {
            return $line;
        }
    }

    private function getWithKeys($group, $item, $line) {
        if(is_array($line)) {
            $lines = [];
            foreach ($line as $linekey => $lineItem) {
                $lines[$linekey] = $this->getWithKeys($group, $linekey, $lineItem);
            }
            return $lines;
        } else {
            return $group . '.' . $item . ': ' . $line;
        }
    }
}
