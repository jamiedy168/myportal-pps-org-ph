<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberSchool extends Model
{
    
    use HasFactory;
    protected $connection = 'pgsql';
    protected $table = 'tbl_member_school';
    
}
