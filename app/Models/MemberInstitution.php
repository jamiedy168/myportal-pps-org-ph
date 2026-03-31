<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use OwenIt\Auditing\Contracts\Auditable;

class MemberInstitution extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $auditInclude  = [
        'created_at', 'created_by', 'updated_at', 'updated_by','is_active','status','pps_no','institution',
        'department_chair','date_started','date_ended'
    ];


    protected $connection = 'pgsql';
    protected $table = 'tbl_member_institution';
}
