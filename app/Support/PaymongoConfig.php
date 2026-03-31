<?php

namespace App\Support;

use App\Models\PaymentGatewaySetting;
use Illuminate\Support\Facades\Cache;

class PaymongoConfig
{
    private const CACHE_KEY = 'paymongo.config';
    private const CACHE_TTL = 300; // 5 minutes

    public static function key(): string
    {
        $cfg = self::load();
        if (!$cfg) {
            return config('services.paymongo.key');
        }
        return $cfg['mode'] === 'live' ? ($cfg['live_key'] ?? '') : ($cfg['test_key'] ?? '');
    }

    public static function webhookSecret(): ?string
    {
        $cfg = self::load();
        if (!$cfg) {
            return config('services.paymongo.webhook_secret');
        }
        return $cfg['mode'] === 'live' ? ($cfg['live_webhook_secret'] ?? null) : ($cfg['test_webhook_secret'] ?? null);
    }

    private static function load(): ?array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            $setting = PaymentGatewaySetting::where('gateway', 'paymongo')->latest()->first();
            return $setting ? $setting->toArray() : null;
        });
    }

    public static function mode(): string
    {
        $cfg = self::load();
        if ($cfg && !empty($cfg['mode'])) {
            return $cfg['mode'];
        }

        // Fall back to env flag if present, otherwise derive from app environment.
        $envMode = env('PAYMONGO_MODE');
        if ($envMode) {
            return $envMode;
        }

        return app()->environment('production') ? 'live' : 'test';
    }

    public static function bustCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
