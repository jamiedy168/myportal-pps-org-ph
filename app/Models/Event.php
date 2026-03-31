<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Event extends Model implements Auditable
{

    use HasFactory;
    use \OwenIt\Auditing\Auditable;


    protected $auditInclude  = [
        'created_at', 'created_by', 'updated_at', 'updated_by','is_active','status','title','start_dt','fb_live_url',
        'end_dt','price','points','venue','participant_limit','description','examination_category','session',
        'category_id','start_time','end_time','selected_members','with_examination','certificate_image','max_cpd','identification_card_image',
        'youtube_live_url','questionnaire_link','survey_link','survey_link_date_time', 'payment_open','virtual_open_date'
       
    ];


    protected $connection = 'pgsql';
    protected $table = 'tbl_event'; 


    protected $dates = ['created_at',
                        'start_dt',
                        'end_dt',
                        'start_time',
                        'end_time'];
}
