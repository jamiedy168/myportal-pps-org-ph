<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class EventTransaction extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $auditInclude  = [
        'id','created_at', 'created_by', 'updated_at', 'updated_by','is_active','status','event_id','pps_no',
        'paid','joined_dt','or_id','attended','attended_dt','selected_topic_id','is_livestream'
       
    ];
    
    protected $connection = 'pgsql';
    protected $table = 'tbl_event_transaction'; 

        protected $fillable = [
        'created_by',
        'updated_by',
        'is_active',
        'status',
        'pps_no',
        'event_id',
        'paid',
        'or_id',
        'paid',
        'joined_dt'
     
    ];

}
