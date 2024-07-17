<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Fragment extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $translatable = ['text'];
    protected $appends = ['raw_text'];

    public function setLang($key, $lang)
    {
        return $this->attributes[$key] = $lang;
    }

    public static function getTranslate($key)
    {
        $fragment = Fragment::where([
            'key' => $key,
            'lang' => App::getLocale()
        ])
        ->first();

        return $fragment->text ?? null;
    }

    public function getRawTextAttribute()
    {
        return array_values(json_decode($this->attributes['text'], true))[0] ?? null;
    }
    /* public static function getGroup(string $group, string $locale): array
    {
        $x = static::query()->where('key', 'LIKE', "{$group}.%")->get()
            ->map(function (Fragment $fragment) use ($locale, $group) {

                $key = preg_replace("/{$group}\\./", '', $fragment->key, 1);
                // $text = $fragment->translate('text', $locale);

                return compact('key', 'text');
            })
            ->pluck('text', 'key')
            ->toArray();
        dd($x);
    } */
}
