<?php namespace XdroidTeam\Translation;


use Illuminate\Database\Eloquent\Model;
use DB;

class Translation extends Model {
    protected $guarded = [];
    protected $table = 'translations';

    public static function getGroups(){
        $languages = self::getLanguages();

        return self::select(
                        'group',
                        DB::raw("(COUNT(DISTINCT (`key`)) * " . count($languages) . " - SUM(IF(translation <> '',1,0))) AS missing_trans")
                    )
                    ->whereNotIn('group', config('xdroidteam-translation.exclude_groups', []))
                    ->whereIn('locale', $languages)
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
                    ->whereIn('locale', self::getLanguages())
                    ->orderBy('key')
                    ->get();
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
