<?php namespace XdroidTeam\Translation;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Collection;
use Cache;
use DB;

class Controller extends BaseController
{
    public function index($selectedGroup = ''){
        $translationModel =  config('xdroidteam-translation.translation_model', '\XdroidTeam\Translation\Translation');
        $locals = [];

        foreach ($translationModel::getLanguages() as $key => $value)
            $locals[$value] = null;

        $translations = [];
        foreach ($translationModel::getTranslations($selectedGroup) as $translationRow) {
            if(array_key_exists($translationRow->key, $translations))
                $translations[$translationRow->key][$translationRow->locale] = $translationRow->translation;
            else{
                $translations[$translationRow->key] = $locals;
                $translations[$translationRow->key][$translationRow->locale] = $translationRow->translation;
            }
        }

        $missingByLocal = $locals;
        foreach ($translations as $key => $translation) {
            foreach ($translation as $locale => $value) {
                if (!$value && array_key_exists($locale, $missingByLocal))
                    $missingByLocal[$locale]++;
            }
        }
        return view('translation::group', compact('translations', 'locals', 'missingByLocal'));
    }

    public function updateOrCreate(Request $request){
        $translationModel =  config('xdroidteam-translation.translation_model', '\XdroidTeam\Translation\Translation');

        Cache::tags('translations_' . env('APP_KEY'))->forget('translations.' . $request->get('locale') . '.' . $request->get('group'));

        $translationRow = $translationModel::firstOrNew($request->only('locale', 'group', 'key'));
        $translationRow->translation = $request->get('translation');
        $translationRow->save();

        return ['status' => 'succes'];
    }

    public function missing(){
        $translationModel =  config('xdroidteam-translation.translation_model', '\XdroidTeam\Translation\Translation');

        $missingTranslations = $translationModel::getMissingTranslations();

        return view('translation::missing', compact('missingTranslations'));
    }

    public function all(){
        $translationModel =  config('xdroidteam-translation.translation_model', '\XdroidTeam\Translation\Translation');

        $allTranslations = $translationModel::getAllTranslations();

        return view('translation::all', compact('allTranslations'));
    }
}
