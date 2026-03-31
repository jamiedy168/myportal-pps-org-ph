<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Voting extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $auditInclude  = [
        'id','created_at', 'created_by', 'updated_at', 'updated_by','is_active','status','title','date_from',
        'date_to','time_from','time_to','description','picture','bot_max_vote','chaprep_max_vote'
       
    ];

    protected $connection = 'pgsql';
    protected $table = 'tbl_voting';
}
