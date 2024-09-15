<?php


use Tenchology\Setting\Setting;

if (!function_exists('setting')) {
    function setting(string $key, mixed $default = null): mixed
    {
        try {
            return (new Setting)->get($key, $default);
        } catch (\Illuminate\Database\QueryException $e) {
            \Log::error($e);
            return $default;
        }

    }

}
