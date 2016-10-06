<?php namespace Xdroid\Translation;


use Illuminate\Database\Eloquent\Model;
use DB;

class Translation extends Model {
    protected $guarded = [];

    public static function getGroups(){
        return self::select('group')
                    ->orderBy('group')
                    ->groupBy('group')
                    ->lists('group')
                    ->all();
    }

    public static function getTranslations($group){
        return self::where('group', '=', $group)
                    ->select(
                        'locale',
                        'key',
                        'translation'
                    )
                    ->orderBy('key')
                    ->get();
    }
}
