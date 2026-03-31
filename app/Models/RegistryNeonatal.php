<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RegistryNeonatal extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $auditInclude  = [
        'id','created_at', 'created_by', 'updated_at', 'updated_by','is_active','status','patient_initial',
        'date_of_admission','maturity','gestational_age','birth_weight','weight_gestational_age','presentation_upon_delivery',
        'manner_of_delivery','gender','apgar_score','einc','incomplete_einc_steps','diagnosis1','no_of_fetuses',
        'patient_birth_location','icd_no_1','diagnosis2','icd_no_2','highest_total_bilirubin','diagnosis3','icd_no_3',
        'respiratory_support','diagnosis4','icd_no_4','diagnosis5','icd_no_5','diagnosis6','icd_no_6','diagnosis7',
        'icd_no_7','baby_covid_status','mother_covid_status','kangaroo_mother_care','type_feeding_discharge','use_donor_human_milk',
        'discharge_outcome','date_discharged','month_year_icd','hospital_id','registry_header_id'

    ];

    protected $connection = 'pgsql';
    protected $table = 'tbl_registry_neonatal';


    protected $fillable = [
        'created_at',
        'created_by',
        'is_active',
        'patient_initial','date_of_admission',
        'maturity','gestational_age','birth_weight',
        'weight_gestational_age','presentation_upon_delivery','manner_of_delivery',
        'gender','apgar_score','einc','incomplete_einc_steps',
        'diagnosis1','no_of_fetuses','patient_birth_location','icd_no_1',
        'diagnosis2','icd_no_2','highest_total_bilirubin','diagnosis3','icd_no_3',
        'respiratory_support','diagnosis4','icd_no_4','diagnosis5','icd_no_5',
        'diagnosis6','icd_no_6','diagnosis7','icd_no_7','baby_covid_status',
        'mother_covid_status','kangaroo_mother_care','type_feeding_discharge','use_donor_human_milk',
        'discharge_outcome','date_discharged','month_year_icd','hospital_id','registry_header_id'

    ];



}
