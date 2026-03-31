<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberTraining extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    protected $table = 'tbl_member_training';

    protected $dates = ['created_at',
    'date_started','date_ended',
    
   ];
    
}
