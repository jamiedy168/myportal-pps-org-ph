<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Carbon\Carbon;

class RegistryAdmitted extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $auditInclude  = [
        'id','created_at', 'created_by', 'updated_at', 'updated_by','is_active','status',
        'patient_initial','type_of_patient','gender','weight','date_of_birth','date_admitted',
        'date_discharged','outcome','primary_diagnosis','icd_no','secondary_diagnosis','icd_no2',
        'tertiary_diagnosis','icd_no3','hospital_id','month_year_icd','registry_header_id'
       
    ];

    protected $connection = 'pgsql';
    protected $table = 'tbl_registry_admitted';


    protected $dates = ['date_of_birth'];

    public function age()
    {
    return Carbon::parse($this->attributes['date_of_birth'])->age;
    }
    

    protected $fillable = [
        'created_at',
        'created_by',
        'is_active',
        'patient_initial',
        'type_of_patient',
        'gender',
        'weight',
        'date_of_birth',
        'date_admitted',
        'date_discharged',
        'outcome',
        'primary_diagnosis',
        'icd_no',
        'secondary_diagnosis',
        'icd_no2',
        'tertiary_diagnosis',
        'icd_no3',
        'hospital_id',
        'month_year_icd',
        'registry_header_id'
    ];

}
