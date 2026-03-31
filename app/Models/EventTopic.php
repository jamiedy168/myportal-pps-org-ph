<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class EventTopic extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $auditInclude  = [
        'id','created_at', 'created_by', 'updated_at', 'updated_by','is_active','status','event_id','topic_name',
        'points','max_attendee','day','with_examination','is_business_meeting','points_on_site','points_online','video_name',
        'qr_is_active','code','fb_live_url'
       
    ];


    protected $connection = 'pgsql';
    protected $table = 'tbl_event_topic'; 
}
