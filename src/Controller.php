<?php namespace XdroidTeam\Translation;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Collection;
use XdroidTeam\Translation\Translation;
use Cache;
use DB;

class Controller extends BaseController
{
    public function index($selectedGroup = ''){
        $locals = [];
        foreach (explode(',', env('LANGUAGES')) as $key => $value)
            $locals[$value] = null;

        $groups = Translation::getGroups(count($locals));
        if(!array_key_exists($selectedGroup, $groups) && count($groups) > 0)
            $selectedGroup = array_keys($groups)[0];

        $translations = [];
        foreach (Translation::getTranslations($selectedGroup) as $translationRow) {
            if(array_key_exists($translationRow->key, $translations))
                $translations[$translationRow->key][$translationRow->locale] = $translationRow->translation;
            else{
                $translations[$translationRow->key] = $locals;
                $translations[$translationRow->key][$translationRow->locale] = $translationRow->translation;
            }
        }

        $missingByLocal = $locals;
        foreach ($translations as $key => $locals) {
            foreach ($locals as $locale => $value) {
                if (!$value)
                    $missingByLocal[$locale]++;
            }
        }

        return view('translation::index', compact('selectedGroup', 'groups', 'translations', 'locals', 'missingByLocal'));
    }

    public function updateOrCreate(Request $request){
        Cache::tags('translations_' . env('APP_KEY'))->forget('translations.' . $request->get('locale') . '.' . $request->get('group'));

        $translationRow = Translation::firstOrNew($request->only('locale', 'group', 'key'));
        $translationRow->translation = $request->get('translation');
        $translationRow->save();

        return ['status' => 'succes'];
    }
}
