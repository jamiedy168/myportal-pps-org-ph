<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestWebhook extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    protected $table = 'test_webhook';
}
