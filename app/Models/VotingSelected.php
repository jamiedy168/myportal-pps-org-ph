<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class VotingSelected extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $auditInclude  = [
        'id','created_at', 'created_by', 'updated_at', 'updated_by','is_active','status','voting_id','pps_no',
        'candidate_pps_no','transaction_id','position_id'
       
    ];

    protected $connection = 'pgsql';
    protected $table = 'tbl_voting_selected';
}
