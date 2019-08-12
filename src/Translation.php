<?php namespace XdroidTeam\Translation;


use Illuminate\Database\Eloquent\Model;
use DB;

class Translation extends Model {
    protected $guarded = [];
    protected $table = 'translations';

    public static function getGroups(){
        $languages = static::getLanguages();

        $groups = self::select(
                        'group',
                        DB::raw("(COUNT(DISTINCT (`key`)) * " . count($languages) . " - SUM(IF(translation <> '',1,0))) AS missing_trans")
                    )
                    ->whereNotIn('group', config('xdroidteam-translation.exclude_groups', []))
                    ->whereIn('locale', $languages)
                    ->orderBy('group')
                    ->groupBy('group')
                    ->pluck('missing_trans', 'group')
                    ->all();
        
        return $groups;
    }

    public static function getTranslations($group){
        return self::where('group', '=', $group)
                    ->select(
                        'locale',
                        'key',
                        'translation'
                    )
                    ->whereIn('locale', static::getLanguages())
                    ->orderBy('key')
                    ->get();
    }

    public static function getAllTranslations(){
        return self::whereIn('locale', static::getLanguages())
                    ->select(
                        'locale',
                        'group',
                        'key',
                        'translation'
                    )
                    ->orderBy('group')
                    ->orderBy('key')
                    ->get();
    }

    private static function missingTranslationBuilder(){
        return self::whereNull('translation')
                    ->where('locale', '=', 'en')
                    ->select(
                        'locale',
                        'group',
                        'key',
                        'translation'
                    )
                    ->orderBy('key');
    }

    public static function getMissingTranslations(){
        return self::missingTranslationBuilder()
                    ->get();
    }

    public static function getMissingTranslationsCount(){
        return self::missingTranslationBuilder()
                    ->count();
    }

    public static function getLanguages(){
        return explode(',', env('LANGUAGES'));
    }

    public static function exportToCSV($pathToFile){
        $data = self::all()->toArray();
        $file = fopen($pathToFile, 'w');

        fputcsv($file, array_keys($data[1]));
        foreach($data as $line)
        {
            $line['translation'] = str_replace("\n", "", trim($line['translation']));
            fputcsv($file, $line);
        }

        fclose($file);
    }
}
