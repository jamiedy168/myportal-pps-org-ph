<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ICD10Temp extends Model implements Auditable
{
    use HasFactory;

    use \OwenIt\Auditing\Auditable;

    protected $auditInclude  = [
        'id','created_at', 'created_by', 'updated_at', 'updated_by','isactive','description'
       
    ];
    protected $connection = 'pgsql';
    protected $table = 'tbl_icd10_temp'; 

    protected $fillable = ['description','created_by','isactive'];
}
