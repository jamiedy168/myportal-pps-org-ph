<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use OwenIt\Auditing\Contracts\Auditable;

class MemberSubspecialty extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $auditInclude  = [
        'id','created_at', 'created_by', 'updated_at', 'updated_by','is_active','status','pps_no','subspecialty',
        'sub_institution','sub_section_chief','sub_date_started','sub_date_ended'
    ];

    protected $connection = 'pgsql';
    protected $table = 'tbl_member_subspecialty_training';


    protected $dates = ['created_at',
    'sub_date_started','sub_date_ended'
   ];
}
