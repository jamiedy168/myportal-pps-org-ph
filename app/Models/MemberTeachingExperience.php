<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberTeachingExperience extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';
    protected $table = 'tbl_member_teaching_experience';

    protected $dates = ['created_at',
    'teaching_date_started','teaching_date_ended'
   ];
}
