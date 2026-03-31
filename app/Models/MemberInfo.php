<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Yajra\Address\HasAddress; // ✅ correct import

class MemberInfo extends Model implements Auditable
{
    use HasFactory; 
    use \OwenIt\Auditing\Auditable;
    use HasAddress; 

    protected $auditInclude  = [
        'created_at', 'created_by', 'updated_at', 'updated_by','is_active','status','first_name','middle_name',
        'last_name','suffix','birthdate','address','telephone_number','mobile_number','email_address','prc_validity',
        'front_id_image','back_id_image','type','picture','country_code','gender','civil_status','citizenship','religion',
        'mailing_address','clinic_address','birthplace','pps_no','doctor_classification','graduated_overseas','medical_school',
        'pma_number','disapprove_dt','disapprove_by','disapprove_reason','applied_dt','member_approve_dt','residency_certificate',
        'government_physician_certificate','identification_card','applicant_type','annual_dues','prc_registration_dt',
        'member_status','member_type','nationality','member_chapter','annual_fee','prc_number','member_classification_id','is_foreign',
        'vip','vip_description','fellows_in_training_certificate','medical_school_year','completed_profile','is_fellows_in_training',
        'tin_number','house_number','street_name','barangay_name','city_name','province_name','postal_code','barangay_id','city_id',
        'province_id','region_id','country_name','country_text','second_completed_profile'
    ];

    protected $connection = 'pgsql';
    protected $table = 'tbl_member_info';

    protected $dates = ['created_at','birthdate','prc_validity'];

    public function age()
    {
        return Carbon::parse($this->attributes['birthdate'])->age;
    }
}
