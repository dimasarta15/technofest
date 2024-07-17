<?php

namespace Database\Seeders;

use App\Models\Fragment;
use DB;
use Illuminate\Database\Seeder;

class FragmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('truncate table fragments;');
        $f = file_get_contents(database_path('fragments.json'));
        $arr = json_decode($f, true);
        
        foreach ($arr as $lang => $value) {
            
            foreach ($value as $key => $v) {
                $fragment = new Fragment();
                $fragment->key = $key;
                $fragment->setLang('lang', $lang);
                $fragment->setTranslation('text', $lang, $v);
                $fragment->save();
            }
        }
    }
}
