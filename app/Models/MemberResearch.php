<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use OwenIt\Auditing\Contracts\Auditable;

class MemberResearch extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $auditInclude  = [
        'id','created_at', 'created_by', 'updated_at', 'updated_by','is_active','status','pps_no','research_title',
        'research_authorship','research_publication_status','research_year'
    ];

    protected $connection = 'pgsql';
    protected $table = 'tbl_member_research_works';

    protected $dates = ['created_at'
   ];
}
