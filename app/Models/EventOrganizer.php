<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class EventOrganizer extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $auditInclude  = [
        'created_at', 'created_by', 'updated_at', 'updated_by','is_active','status','pps_no','organizer_type_id','session'
    ];


    protected $connection = 'pgsql';
    protected $table = 'tbl_event_organizer_list'; 
}
