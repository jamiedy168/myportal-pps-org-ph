<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AnnualDues extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
   
    protected $auditInclude  = [
        'created_at', 'created_by', 'updated_at', 'updated_by','is_active','status','description','amount','year_dues'
    ];


    protected $connection = 'pgsql';
    protected $table = 'tbl_annual_dues';
}
