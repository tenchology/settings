<?php

namespace Tenchology\Setting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\Translatable\HasTranslations;

class Setting extends Model
{
    use HasTranslations;

    public array $translatable = ['value'];

    protected static string $cache_key = 'setting-';

    public static function getCacheKey(): string
    {
        if (session()->has('locale'))
        {
            return static::$cache_key . session('locale') . '-';
        }
        return static::$cache_key;
    }

    protected $table = 'app_settings';

    public $timestamps = false;
    protected $keyType = 'string';
    protected $primaryKey = 'key';

    protected $fillable = [
        'key',
        'value',
    ];
    protected $casts = [
        'key' => 'string',
        'value' => 'array',
    ];

    public static function set(string $key, $value, string $locale = null): bool
    {
        Cache::forget(static::getCacheKey() . $key);

        return static::firstOrNew([
            'key' => $key,
        ])->setTranslation('value', $locale ?? app()->getLocale(), $value ?: '')->save();
    }

    public function get(string $key, $default = null)
    {
        $result = cache()->rememberForever(static::getCacheKey().$key,function () use ($key, $default) {
            return static::select('value')->where('key', $key)->first();
        });

        return optional($result)->value == null ? $default : $result->value;

    }


}
