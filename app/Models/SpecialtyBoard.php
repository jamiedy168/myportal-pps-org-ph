<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SpecialtyBoard extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $auditInclude  = [
        'id','created_at', 'created_by', 'updated_at', 'updated_by','is_active','status',
        'pps_no','member_type_applied_id','apply_dt','is_paid','is_passed','remarks',
        'or_master_id','no_of_takes'
    ];

    protected $connection = 'pgsql';
    protected $table = 'tbl_specialty_board';
}
