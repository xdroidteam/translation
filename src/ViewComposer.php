<?php namespace XdroidTeam\Translation;

use Illuminate\Contracts\View\View;
use Route;

class ViewComposer{
    public function __construct()
    {

    }

    public function compose(View $view)
    {
        $translationModel =  config('xdroidteam-translation.translation_model', '\XdroidTeam\Translation\Translation');
        $groups = $translationModel::getGroups();

        $selectedGroup = Route::current()->parameter('group');
        if(!array_key_exists($selectedGroup, $groups) && count($groups) > 0)
            $selectedGroup = array_keys($groups)[0];

        view()->share('groups', $groups);
        view()->share('selectedGroup', $selectedGroup);
        view()->share('missingCount', $translationModel::getMissingTranslationsCount());
    }
}
