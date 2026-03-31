<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGatewaySetting extends Model
{
    protected $fillable = [
        'gateway', 'mode',
        'live_key', 'test_key',
        'live_webhook_secret', 'test_webhook_secret',
        'updated_by',
    ];
}
