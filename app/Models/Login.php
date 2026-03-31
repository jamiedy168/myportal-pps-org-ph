<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Login extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';
    protected $table = 'users';
}
