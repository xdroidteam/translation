<?php namespace XdroidTeam\Translation;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Collection;
use Xdroid\Translation\Translation;
use Cache;

class Controller extends BaseController
{
    public function index($group = false){
        $groups = Translation::getGroups();
        if(!in_array($group, $groups) && count($groups) > 0)
            $group = $groups[0];

        $locals = [];
        foreach (explode(',', env('LANGUAGES')) as $key => $value)
            $locals[$value] = null;

        $translations = [];
        foreach (Translation::getTranslations($group) as $translationRow) {
            if(array_key_exists($translationRow->key, $translations))
                $translations[$translationRow->key][$translationRow->locale] = $translationRow->translation;
            else{
                $translations[$translationRow->key] = $locals;
                $translations[$translationRow->key][$translationRow->locale] = $translationRow->translation;
            }
        }

        return view('translation::index', compact('group', 'groups', 'translations', 'locals'));
    }

    public function updateOrCreate(Request $request){
        Cache::tags('translations_' . env('APP_KEY'))->forget('translations.' . $request->get('locale') . '.' . $request->get('group'));

        $translationRow = Translation::firstOrNew($request->only('locale', 'group', 'key'));
        $translationRow->translation = $request->get('translation');
        $translationRow->save();

        return ['status' => 'succes'];
    }
}
