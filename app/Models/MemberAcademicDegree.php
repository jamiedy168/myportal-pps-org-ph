<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use OwenIt\Auditing\Contracts\Auditable;

class MemberAcademicDegree extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $auditInclude  = [
        'id','created_at', 'created_by', 'updated_at', 'updated_by','is_active','status','pps_no','academic_degree',
        'academic_institution','academic_dean','academic_date_started','academic_date_ended'
    ];

    protected $connection = 'pgsql';
    protected $table = 'tbl_member_academic_degree';

    protected $dates = ['created_at',
    'academic_date_started','academic_date_ended'
   ];
}
