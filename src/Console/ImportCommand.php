<?php namespace XdroidTeam\Translation\Console;

use Barryvdh\TranslationManager\Manager;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Cache;
use File;

class ImportCommand extends Command {

    protected $signature =   'translations:import
                            {--overwrite : overwrite existing DB records}
                        ';

    protected $description = 'Import translations from the PHP sources';

    public function fire()
    {
        foreach (File::directories(base_path('resources/lang')) as $basePath) {
            $lang = array_last(explode('/', $basePath));

            foreach (File::allFiles($basePath)  as $langFile) {
                $group = explode('.', $langFile->getRelativePathname())[0];

                foreach (array_dot(File::getRequire($langFile->getRealPath())) as $key => $translation) {
                    $this->createOrUpdate($lang, $group, $key, $translation);
                }
                Cache::tags('translations_' . env('APP_KEY'))->forget('translations.' . $lang . '.' . $group);
            }
        }
        $this->info('Done importing!');
    }

    private function createOrUpdate($lang, $group, $key, $translation){
        $translationModel =  config('xdroidteam-translation.translation_model', '\XdroidTeam\Translation\Translation');

        $translationRow = $translationModel::firstOrNew([
            'locale' => $lang,
            'group' => $group,
            'key' => $key,
        ]);

        if($translationRow->exists && !$this->option('overwrite'))
            return;

        $translationRow->translation = $translation;
        $translationRow->save();
    }

}
