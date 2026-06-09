<?php

use App\Domains\Settings\Models\Setting;

if (! function_exists('setting')) {
    function setting(string $key, mixed $default = null): mixed
    {
        return cache()->rememberForever(
            "setting.{$key}",
            fn () => Setting::query()
                ->where('key', $key)
                ->value('value') ?? $default
        );
    }
}