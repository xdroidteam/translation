<?php namespace XdroidTeam\Translation;


use Illuminate\Database\Eloquent\Model;
use DB;

class Translation extends Model {
    protected $guarded = [];

    public static function getGroups($localsNumber){
        return self::select(
                        'group',
                        DB::raw("(COUNT(DISTINCT (`key`)) * " . $localsNumber . " - SUM(IF(translation <> '',1,0))) AS missing_trans")
                    )
                    ->whereNotIn('group', config('xdroidteam-translation.exclude_groups', []))
                    ->whereIn('locale', explode(',', env('LANGUAGES')))
                    ->orderBy('group')
                    ->groupBy('group')
                    ->lists('missing_trans', 'group')
                    ->all();
    }

    public static function getTranslations($group){
        return self::where('group', '=', $group)
                    ->select(
                        'locale',
                        'key',
                        'translation'
                    )
                    ->whereIn('locale', explode(',', env('LANGUAGES')))
                    ->orderBy('key')
                    ->get();
    }
}
