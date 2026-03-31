<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;



class EventAttend extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;


    protected $auditInclude  = [
        'id','created_at', 'created_by', 'updated_at', 'updated_by','is_active','status','date_attend','pps_no',
        'event_id','topic_id','examination','complete_fb_live_exam'
       
    ];


    protected $connection = 'pgsql';
    protected $table = 'tbl_event_attend'; 


}
