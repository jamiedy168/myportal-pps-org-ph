<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class EventPlenary extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $auditInclude  = [
        'id','created_at', 'created_by', 'updated_at', 'updated_by','is_active','status','event_id','topic_id',
        'pps_no','criteria','score','speaker_no'
       
    ];


    protected $connection = 'pgsql';
    protected $table = 'tbl_event_plenary'; 
}
