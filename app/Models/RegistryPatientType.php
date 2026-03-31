<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RegistryPatientType extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $auditInclude  = [
        'id','created_at', 'created_by', 'updated_at', 'updated_by','is_active','status',
        'category'
       
    ];

    protected $connection = 'pgsql';
    protected $table = 'tbl_registry_patient_type';



}
